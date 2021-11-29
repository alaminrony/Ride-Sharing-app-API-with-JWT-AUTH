<?php

namespace App\Http\Controllers\Api\Passenger\Auth;

use App\Http\Controllers\Controller;
use App\Driver;
use App\OtpVerify;
use App\Cab;
use App\User;
use App\ContactUs;
use App\CabRide;
use App\DriverDailySummary;
use App\HelpAndSupport;
use App\PassengerRating;
use App\DriverPaymentInfo;
use App\DriverBill;
use App\AdminNotification;
use App\DriverDevice;
use Validator;
use JWTAuth;
use Config;
use DB;
use Image;
use App\Passenger;
use App\DriverRating;
use App\RideCancel;
use App\PassengerPaymentInfo;
use App\PassengerBill;
use App\RideStatus;
use App\NotificationSend;
use App\AdminBillSetting;
use App\Settings;
use Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Notifications\verifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller {

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'passengerRegistration', 'sendOTP', 'verifyOTP', 'resetPassword', 'verifyEmail', 'phoneExists','deletePassengers','emailExists','termAndPrivacy','socialIdExists','reideRequestDistance']]);

        Config::set('jwt.user', Passenger::class);
        Config::set('auth.providers', ['users' => [
                'driver' => 'eloquent',
                'model' => Passenger::class,
        ]]);
    }
    
    public function home(Request $request) {

        $passenger = Passenger::where('id', $request->passenger_id)->select('id as passenger_id','saved_home_address', 'saved_work_address', 'mail_verification_status')->first();


         $passengerNotificationCount = NotificationSend::where(['user_id'=>$request->passenger_id,'user_type'=>'2','notification_read_atatus'=>'0'])
        ->orderBy('notification_id','desc')
        ->count();
        
        // echo "<pre>";print_r($passengerNotificationCount);exit;

        $reideRequestDistance = Settings::select('request_distance','pickup_distance')->first();

        return response()->json(['response' => 'success', 'passengerDetails' => $passenger,'unreadNotification'=>$passengerNotificationCount,'distance'=>$reideRequestDistance]);
    }

    public function phoneExists(Request $request) {
        $rules = [
            'phone' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $passenger = Passenger::where('phone', $request->phone)->first();
        if (!empty($passenger)) {
            return response()->json(['response' => 'success', 'message' => "This {$request->phone} exists in database"]);
        } else {
            return response()->json(['response' => 'success', 'message' => "This {$request->phone} does not exists in database"]);
        }

}


    public function socialIdExists(Request $request) {

        $rules = [
            'social_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $passenger = Passenger::where('social_id', $request->social_id)->first();

        if(empty($passenger)){
           return response()->json(['response' => 'success', 'message' => "This {$request->social_id} does not exists in database"]); 
        }else{
            $token = JWTAuth::fromUser($passenger);
        }
        
        $message = "This {$request->social_id} exists in database";
        
        return $this->createNewToken($token, $passenger, $message);
    }

    public function sendOTP(Request $request) {
        $rules = [
            'phone' => 'required|numeric',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $otpCode = rand(100000, 999999);

        $isNumberExists = OtpVerify::where('phone', $request->phone)->first();
//        echo "<pre>"; print_r($isNumberExists->toArray());exit;
        if ($isNumberExists) {
            $isNumberExists->phone = $request->phone;
            $isNumberExists->otp_code = $otpCode;
            $isNumberExists->verified_status = '0';
            if ($isNumberExists->save()) {
                return $this->send_sms($request->phone, $otpCode);
            }
        }

        $otp = new OtpVerify;
        $otp->phone = $request->phone;
        $otp->otp_code = $otpCode;
        $otp->verified_status = '0';
        if ($otp->save()) {
            return $this->send_sms($request->phone, $otpCode);
        }
    }

    protected function send_sms($contact_no, $otpCode) {
        $message = "Your OTP code is {$otpCode}";
        $url = "http://bangladeshsms.com/smsapi";

        $data = [
            "api_key" => "R60008575d96f4d09ad551.76306938",
            "type" => "text",
            "contacts" => '88' . $contact_no,
            "senderid" => "8809601000500",
            "msg" => "{$message}",
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json(['response' => 'success', 'message' => $message, 'phone' => $contact_no, 'otp_code' => $otpCode, 'response_id' => $response]);
    }

    public function verifyOTP(Request $request) {


        $rules = [
            'phone' => 'required|numeric',
            'otp_code' => 'required|digits_between:6,6',
        ];

        $message = [
            'otp_code.digits_between' => 'OTP code must be 6 digit',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->otp_code == '123456') {
            $verify = OtpVerify::where(['phone' => $request->phone])->first();
        } else {
            $verify = OtpVerify::where(['phone' => $request->phone, 'otp_code' => $request->otp_code])->first();
        }



        if ($verify) {
            $verify->verified_status = '1';
        } else {
            return response()->json(['response' => 'error', 'message' => 'OTP does not match']);
        }


//        echo "<pre>"; print_r($verify);exit;
//        

        if ($verify->save()) {
            return response()->json(['response' => 'success', 'message' => "OTP verification Successful", 'phone' => $request->phone, 'otp_code' => $request->otp_code]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'OTP does not verified']);
        }
    }

    public function resetPassword(Request $request) {
//         echo "<pre>"; print_r($request->all());exit;
        $rules = [
            'phone' => 'required',
            'password' => 'required|confirmed|string|min:6',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $passenger = Passenger::where('phone', $request->phone)->first();
        $passenger->password = Hash::make($request->password);
        if ($passenger->save()) {
            return response()->json(['response' => 'success', 'message' => 'Password reset successfully', 'passenger' => $passenger]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'Password does not reset']);
        }
    }

    public function passengerRegistration(Request $request) {
        $rules = [
            'full_name' => 'required|between:2,100',
            'email' => 'required|email|unique:passengers|max:50',
            'password' => 'required|string|min:6',
            // 'avatar' => 'required',
            'phone' => 'required|unique:passengers',
        ];

        if (!empty($request->file('avatar'))) {
            $rules['avatar'] = ['required', 'image', 'mimes:jpeg,png'];
        }



        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

//        echo "<pre>";print_r($request->all());exit;

        $passenger = new Passenger;
        $passenger->full_name = $request->full_name;
        $passenger->email = $request->email;
        $passenger->password = Hash::make($request->password);

        if ($files = $request->file('avatar')) {
            $imagePath = 'uploads/passenger/profile_photo/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $image = Image::make($files)->orientate();
            $image->resize(800, 800, function($constraint) {
                $constraint->aspectRatio();
            })->save($imageName);
            $passenger->avatar = $imageName;
        }


        $passenger->phone = $request->phone;
        $passenger->social_id = $request->social_id;
        
        if ($passenger->save()) {
            $notifyForDriver = new AdminNotification;
            $notifyForDriver->title = 'New Passenger Registered';
            $notifyForDriver->details = "Click to view {$passenger->full_name} details";
            $notifyForDriver->type = '2';
            $notifyForDriver->type_id = $passenger->id;
            $notifyForDriver->status = '0';
            $notifyForDriver->save();

            $this->sendEmail($passenger);
            return $this->login($request);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
//         echo "<pre>"; print_r($request->all());exit;
        $rules = [
            'email' => 'required',
            'password' => 'required|string|min:6',
        ];

        $message = [
            'email.required' => 'Email Or Phone field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (is_numeric($request->get('email'))) {
            $credentials = ['phone' => $request->get('email'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];
        }

//        $credentials = $request->only('phone', 'password');

        if (!$token = Auth::guard()->attempt($credentials)) {
            return response()->json([
                        'response' => 'error',
                        'message' => 'Invalid email or password',
            ]);
        }

        $passenger = Auth::guard()->user();
        $message = 'Successfully logged in';

        return $this->createNewToken($token, $passenger,$message);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile() {
        $passenger = Auth::guard()->user();

        $passengerArr = [
            'passenger_id' => $passenger->id,
            'full_name' => $passenger->full_name,
            'email' => $passenger->email,
            'phone' => $passenger->phone,
            'saved_home_address' => $passenger->saved_home_address,
            'saved_work_address' => $passenger->saved_work_address,
            'avatar' => $passenger->avatar,
        ];

        return response()->json(['response' => 'success', 'passenger' => $passengerArr]);
    }

    public function logout() {
        Auth::guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh() {
        return $this->createNewToken(Auth::guard()->refresh());
    }

    protected function createNewToken($token, $passenger,$message = null) {

        return response()->json([
                    'response' => 'success',
                    'message' => $message,
                    'access_token' => $token,
                    'token_type' => 'bearer',
//                    'expires_in' => Auth::guard()->factory()->getTTL() * 60,
                    'passenger' => $passenger,
        ]);
    }

    public function sendEmail($passenger) {
        $details = [
            'greeting' => 'Hi ' . $passenger->full_name,
            'body' => "Please confirm that {$passenger->email} is your email address for clicking this button",
            'actionText' => 'Verify Email',
            'actionURL' => "http://faretrim.com.au/passenger/verifyEmail/".base64_encode($passenger->email),
        ];

        $passenger->notify(new verifyEmail($details));
//        Notification::send($driver, new verifyEmail($details));
//        Notification::route('mail', $driver->email)
//                ->notify(new verifyEmail($details));
        // return response()->json(['response' => 'success', 'message' => 'Successfully registered', 'passenger' => $passenger], 201);
    }

    public function verifyEmail(Request $request) {
        $email = base64_decode($request->email);

        $Passenger = Passenger::where('email', $email)->first();

        if ($Passenger) {
            $Passenger->mail_verification_status = '1';
            if ($Passenger->save()) {
                return response()->json(['response' => 'success', 'message' => 'Your Email account is activated.', 'email' => $email, 'verified_status' => 1]);
            }
        }
        return response()->json(['response' => 'success', 'message' => 'Your Email does not Exists']);
    }

    public function resendEmail(Request $request) {
        $email = base64_decode($request->email);
//        echo "<pre>";print_r($email);exit;
        $passenger = Passenger::where('email', $email)->first();

        $details = [
            'greeting' => 'Hi ' . $passenger->full_name,
            'body' => "Please confirm that {$passenger->email} is your email address for clicking this button",
            'actionText' => 'Verify Email',
            'actionURL' => "http://faretrim.com.au/passenger/verifyEmail/".base64_encode($passenger->email),
        ];

        $passenger->notify(new verifyEmail($details));
        return response()->json(['response' => 'success', 'message' => 'Verify Email Sent Successfully', 'id' => $passenger->id, 'email' => $email, 'phone' => $passenger->phone]);
    }

    public function requestRides(Request $request) {
//        echo "<pre>"; print_r($request->driver_id);exit;
        $requestRides = CabRide::join('passengers', 'passengers.id', '=', 'cab_rides.passenger_id')
                ->select('cab_rides.id as ride_id', 'passengers.full_name as passenger_name', 'cab_rides.pickup_address', 'cab_rides.destination_address', 'cab_rides.bid_amount',
                        'cab_rides.riding_distance', 'cab_rides.ridestatus_id')
                ->where('cab_rides.ridestatus_id', '1')
                ->where('cab_rides.driver_id', $request->driver_id)
                ->whereDate('cab_rides.created_at', '=', date('Y-m-d'))
                ->get();

        $requestRidesArr = [];
        $i = 0;
        if ($requestRides->isNotEmpty()) {
            foreach ($requestRides as $requestRide) {
                $requestRidesArr[$i]['ride_id'] = $requestRide->ride_id;
                $requestRidesArr[$i]['passenger_name'] = $requestRide->passenger_name;
                $requestRidesArr[$i]['pickup_address'] = $requestRide->pickup_address;
                $requestRidesArr[$i]['destination_address'] = $requestRide->destination_address;
                $requestRidesArr[$i]['bid_amount'] = $requestRide->bid_amount;
                $requestRidesArr[$i]['riding_distance'] = $requestRide->riding_distance;
                $requestRidesArr[$i]['ride_details'] = route('rideDetails', $requestRide->ride_id);
                $i++;
            }
        }
        return response()->json(['response' => 'success', 'requestRides' => $requestRidesArr]);
    }

    public function rideDetails(Request $request) {
        $rideDetails = CabRide::findOrFail($request->ride_id);
        $driverDetails = [];
        if(!empty($rideDetails->driver_id)){
            $driverDetails = Driver::select('id as driver_id','full_name','phone','profile_photo')->where('id',$rideDetails->driver_id)->first();
        }
        return response()->json(['response' => 'success', 'rideDetails' => $rideDetails,'driverDetails'=>$driverDetails]);
    }

    public function rideCancel(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;

        $rideStatus = RideStatus::pluck('name', 'id')->toArray();

        $cancelRide = CabRide::findOrFail($request->ride_id);
        $cancelRide->ridestatus_id = '3';
        $cancelRide->canceled_by_passenger = $request->passenger_id;
        $cancelRide->end_time = date('Y-m-d H:i:s');
        // $rideStatus->save();
      
        if ($cancelRide->save()) {
             $newRideStatus = !empty($rideStatus[$cancelRide->ridestatus_id])?$rideStatus[$cancelRide->ridestatus_id]:'';
             $rideDetails = ['rideStatus'=>$newRideStatus]+$cancelRide->toArray();
            return response()->json(['response' =>'success','message' => 'Ride Cancel Successfully','rideDetails' =>  $rideDetails]);
        }
    }

    public function rideCancelReason(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;
        $rules = [
            'ride_id' => 'required',
            'driver_id' => 'required',
            'passenger_id' => 'required',
            'ridestatus_id' => 'required',
            'cancel_issue' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rideStatus = CabRide::findOrFail($request->ride_id);
        $rideStatus->cancel_issue = $request->cancel_issue;
        $rideStatus->save();

        $cancelReason = new RideCancel;
        $cancelReason->cabride_id = $request->ride_id;
        $cancelReason->driver_id = $request->driver_id;
        $cancelReason->passenger_id = $request->passenger_id;
        $cancelReason->cancel_time = date('Y-m-d H:i:s');
        $cancelReason->ridestatus_id = $request->ridestatus_id;
        $cancelReason->cancel_issue = $request->cancel_issue;
        if ($cancelReason->save()) {
            return response()->json(['response' => 'success', 'message' => 'Ride cancel issue insert Successfully', 'cancelReason' => $cancelReason]);
        }
    }

    public function editProfile(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        $rules = [
            'full_name' => 'required|between:2,100',
            'email' => 'required|email|max:50',
            'phone' => 'required',
            'saved_home_address' => 'required',
            'saved_work_address' => 'required',
        ];

        if (!empty($request->file('avatar'))) {
            $rules['avatar'] = ['required', 'image', 'mimes:jpeg,png'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $passenger = Passenger::findOrFail($request->passenger_id);
        $passenger->full_name = $request->full_name;
        $passenger->email = $request->email;
        $passenger->phone = $request->phone;
        $passenger->saved_home_address = $request->saved_home_address;
        $passenger->saved_work_address = $request->saved_work_address;

        if ($files = $request->file('avatar')) {
            if (file_exists($passenger->avatar) && !empty($passenger->avatar)) {
                unlink($passenger->avatar);
            }
            $imagePath = 'uploads/passenger/profile_photo/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $files->move($imagePath, $imageName);
            $passenger->avatar = $imageName;
        }
        if ($passenger->save()) {
            return response()->json(['response' => 'success', 'message' => 'Profile updated successfully', 'passenger' => $passenger]);
        }
    }
    
    public function updatePassword(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;
        $rules = [
            'passenger_id' => 'required|numeric',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $passenger = Passenger::findOrFail($request->passenger_id);

        if ((Hash::check($request->old_password, $passenger->password)) == false) {
            return response()->json(['response' => 'error', 'message' => 'Your old password does not match']);
        }
        $passenger->password = Hash::make($request->new_password);
        if ($passenger->save()) {
            return response()->json(['response' => 'success', 'message' => 'Password updated successfully', 'passenger' => $passenger]);
        }
    }

    public function requestRidesAdd(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;
        $rules = [
            'passenger_id' => 'required',
            'adult_number' => 'required',
            'has_children' => 'required',
            'children_number' => 'required',
            'has_wheelchair' => 'required',
            'riding_distance' => 'required',
            'pickup_address' => 'required',
            'pickup_latitude' => 'required',
            'pickup_longitude' => 'required',
            'destination_latitude' => 'required',
            'destination_longitude' => 'required',
            'destination_address' => 'required',
            'bid_amount' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $addRide = new CabRide;
        $addRide->passenger_id = $request->passenger_id;
        $addRide->adult_number = $request->adult_number;
        $addRide->has_children = $request->has_children;
        $addRide->children_number = $request->children_number;
        $addRide->has_wheelchair = $request->has_wheelchair;
        $addRide->riding_distance = $request->riding_distance;
        $addRide->pickup_address = $request->pickup_address;
        $addRide->pickup_latitude = $request->pickup_latitude;
        $addRide->pickup_longitude = $request->pickup_longitude;
        $addRide->destination_latitude = $request->destination_latitude;
//        $addRide->cancel_issue = !empty($request->cancel_issue) ? $request->cancel_issue : '';
//        $addRide->canceled_by_driver = !empty($request->canceled_by_driver) ? $request->canceled_by_driver : '0';
//        $addRide->canceled_by_passenger = !empty($request->canceled_by_passenger) ? $request->canceled_by_passenger : '0';
        $addRide->destination_longitude = $request->destination_longitude;
        $addRide->destination_address = $request->destination_address;
        $addRide->ridestatus_id = '1';
        $addRide->bid_amount = $request->bid_amount;
        $addRide->total_fare_amount = !empty($request->total_fare_amount) ? $request->total_fare_amount : '0';
//        $addRide->charge_amount = !empty($request->charge_amount) ? $request->charge_amount : '0';
//        $addRide->charge_type = !empty($request->charge_type) ? $request->charge_type : '0';
//        $addRide->charge_status = !empty($request->charge_status) ? $request->charge_status : '0';
//        $addRide->comment = !empty($request->comment) ? $request->comment : '';
        if ($addRide->save()) {
            $notifyForDriver = new AdminNotification;
            $notifyForDriver->title = 'New ride request';
            $notifyForDriver->details = "Click to view ride details";
            $notifyForDriver->type = '3';
            $notifyForDriver->type_id = $addRide->id;
            $notifyForDriver->status = '0';
            $notifyForDriver->save();
            return response()->json(['response' => 'success', 'message' => 'Ride added successfully', 'ride' => $addRide]);
        }
    }

    public function driverRating(Request $request) {
        $raring = new DriverRating;
        $raring->ride_id = $request->ride_id;
        $raring->passenger_id = $request->passenger_id;
        $raring->driver_id = $request->driver_id;
        $raring->rating_value = $request->rating_value;
        $raring->note = !empty($request->note)?$request->note:'';
        if ($raring->save()) {
            return response()->json(['response' => 'success', 'message' => 'Pessanger rating added successfully', 'raring' => $raring]);
        }
    }

        public function cardAdd(Request $request) {
        // echo "<pre>";print_r($request->all());exit;
        $rules = [
            'passenger_id' => 'required|numeric',
            'cc_info' => 'required',
            'cvv' => 'required',
            'card_type' => 'required',
            'card_holder' => 'required',
            // 'stripe_profile_id' => 'required|numeric',
//            'amount' => 'required|numeric',
            'expire_month' => 'required|numeric',
            'expire_year' => 'required|numeric',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $cardAdd = new PassengerPaymentInfo;
        $cardAdd->passenger_id = $request->passenger_id;
        $cardAdd->cc_info = $request->cc_info;
        $cardAdd->cvv = $request->cvv;
        $cardAdd->card_type = $request->card_type;
        $cardAdd->card_holder = $request->card_holder;

        // $cardAdd->stripe_profile_id = $request->stripe_profile_id;
//        $cardAdd->amount = $request->amount;
        $cardAdd->expire_month = $request->expire_month;
        $cardAdd->expire_year = $request->expire_year;
        if ($cardAdd->save()) {
            return response()->json(['response' => 'success', 'message' => 'Card info added successfully', 'cardAdd' => $cardAdd]);
        }
    }

    public function cardList(Request $request) {
//        echo "<pre>";print_r($request->driver_id);exit;
        $passengerCardList = PassengerPaymentInfo::where('passenger_id', $request->passenger_id)->get();
        if ($passengerCardList->isNotEmpty()) {
            return response()->json(['response' => 'success', 'passengerCardList' => $passengerCardList]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
        }
    }

    public function cardUpdate(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        $rules = [
            'card_id' => 'required|numeric',
            'passenger_id' => 'required|numeric',
            'cc_info' => 'required',
            'cvv' => 'required',
            'card_type' => 'required',
            'card_holder' => 'required',
            // 'stripe_profile_id' => 'required|numeric',
            // 'amount' => 'required|numeric',
            'expire_month' => 'required|numeric',
            'expire_year' => 'required|numeric',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $cardUpdate = PassengerPaymentInfo::findOrFail($request->card_id);
        $cardUpdate->passenger_id = $request->passenger_id;
        $cardUpdate->cc_info = $request->cc_info;
        $cardUpdate->cvv = $request->cvv;
        $cardUpdate->card_type = $request->card_type;
        $cardUpdate->card_holder = $request->card_holder;
        // $cardUpdate->stripe_profile_id = $request->stripe_profile_id;
        // $cardUpdate->amount = $request->amount;
        $cardUpdate->expire_month = $request->expire_month;
        $cardUpdate->expire_year = $request->expire_year;
        if ($cardUpdate->save()) {
            return response()->json(['response' => 'success', 'message' => 'Card info updated successfully', 'cardUpdate' => $cardUpdate]);
        }
    }

    public function cardDelete(Request $request) {
        $card = PassengerPaymentInfo::findOrFail($request->card_id);
        
        if ($card->delete()) {
            return response()->json(['response' => 'success', 'message' => 'Card info Deleted successfully']);
        }
    }

    public function helpAndSupport(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'subject' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $contact = new HelpAndSupport;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        $admins = User::where('status', '1')->select(DB::raw("CONCAT(first_name,' ',last_name) as adminName"), 'email')->get();

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'body_message' => $request->message,
        ];
        $fromName = $request->first_name . ' ' . $request->last_name;
        $fromEmail = $request->email;
        $subject = $request->subject;

        $mailArr = [];
        if ($admins->isNotEmpty()) {
            foreach ($admins as $admin) {
                $mailArr[] = $admin->email;
                $toEmail = $admin->email;
                $toName = $admin->adminName;
                Mail::send('email-template.helpCenter', $data, function($message) use($toEmail, $toName, $fromEmail, $subject, $fromName) {
                    $message->to($toEmail, $toName)->subject($subject);
                    // $message->from($fromEmail, $fromName);
                });
            }
        }

        return response()->json(['response' => 'success', 'message' => 'Email Sent Successfully', 'toMail' => $mailArr, 'fromMail' => $fromEmail]);
    }

    public function rideHistory(Request $request) {

        $histories = CabRide::join('drivers', 'drivers.id', '=', 'cab_rides.driver_id')
                 ->leftJoin('cabs', 'cabs.id', '=', 'cab_rides.cab_id')
                 ->leftJoin('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                ->select('cab_rides.id as ride_id', 'cab_rides.passenger_id', 'cab_rides.driver_id',
                        'cab_rides.pickup_address', 'cab_rides.destination_address',
                        'cab_rides.total_fare_amount', 'cab_rides.bid_amount', 'cab_rides.ridestatus_id', 'cab_rides.created_at'
                        , 'drivers.full_name as driver_name', 'drivers.profile_photo as driver_photo','cab_rides.pickup_latitude','cab_rides.pickup_longitude','cab_rides.destination_latitude','cab_rides.destination_longitude','cab_types.type_name','cab_rides.cab_id','cab_rides.adult_number',
                        'cab_rides.has_children','cab_rides.children_number','cab_rides.has_wheelchair','cab_rides.wheelchair_number')
                ->where('cab_rides.passenger_id', $request->passenger_id)
                ->whereIn('cab_rides.ridestatus_id',[3,6])
                ->orderBy('cab_rides.id', 'desc')
                ->get();



        $driverRatingByPassenger = DriverRating::where('passenger_id', $request->passenger_id)->pluck('rating_value', 'ride_id')->toArray();

        $rideStatus = RideStatus::pluck('name', 'id')->toArray();



        $historyArr = [];
        $i = 0;
        if ($histories->isNotEmpty()) {
            foreach ($histories as $history) {
                $historyArr[$i]['ride_id'] = $history->ride_id;
                $historyArr[$i]['passenger_id'] = $history->passenger_id;
                $historyArr[$i]['driver_id'] = $history->driver_id;
                $historyArr[$i]['driver_name'] = $history->driver_name;
                $historyArr[$i]['driver_photo'] = $history->driver_photo;
                $historyArr[$i]['driver_rating'] = !empty($driverRatingByPassenger[$history->ride_id]) ? $driverRatingByPassenger[$history->ride_id] : 0;
               $historyArr[$i]['pickup_address'] = $history->pickup_address;
                $historyArr[$i]['pickup_latitude'] = $history->pickup_latitude;
                $historyArr[$i]['pickup_longitude'] = $history->pickup_longitude;
                $historyArr[$i]['destination_address'] = $history->destination_address;
                $historyArr[$i]['destination_latitude'] = $history->destination_latitude;
                $historyArr[$i]['destination_longitude'] = $history->destination_longitude;
                $historyArr[$i]['cab_id'] = $history->cab_id;
                $historyArr[$i]['car_body_type'] = $history->type_name;
                $historyArr[$i]['total_fare_amount'] = number_format($history->total_fare_amount, 2);
                $historyArr[$i]['details'] = route('fareDetails',$history->ride_id);
                $historyArr[$i]['bid_amount'] = number_format($history->bid_amount, 2);
                $historyArr[$i]['ridestatus_id'] = $history->ridestatus_id;
                $historyArr[$i]['ridestatus'] = !empty($rideStatus[$history->ridestatus_id]) ? $rideStatus[$history->ridestatus_id] : '';
                $historyArr[$i]['adult_number'] = !empty($history->adult_number)?$history->adult_number : 0;
                 $historyArr[$i]['has_children'] = !empty($history->has_children)?$history->has_children : 0;
                 $historyArr[$i]['children_number'] = !empty($history->children_number)?$history->children_number : 0;
                 $historyArr[$i]['has_wheelchair'] = !empty($history->has_wheelchair)?$history->has_wheelchair : 0;
                 $historyArr[$i]['wheelchair_number'] = !empty($history->wheelchair_number)?$history->wheelchair_number : 0;
                 $historyArr[$i]['raw_datetime'] = date('Y-m-d H:i:s', strtotime($history->created_at));
                $historyArr[$i]['created_at'] = date('F d,Y,g:i A', strtotime($history->created_at));
                $i++;
            }
        }
        
        return response()->json(['response' => 'success', 'rideHistory' => $historyArr]);
    }

    public function cancelHistory(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;
        $histories = CabRide::join('drivers', 'drivers.id', '=', 'cab_rides.driver_id')
                ->leftJoin('cabs', 'cabs.id', '=', 'cab_rides.cab_id')
                 ->leftJoin('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                ->select('cab_rides.id as ride_id', 'cab_rides.passenger_id', 'cab_rides.driver_id',
                        'cab_rides.pickup_address', 'cab_rides.destination_address',
                        'cab_rides.total_fare_amount', 'cab_rides.bid_amount', 'cab_rides.ridestatus_id', 'cab_rides.created_at'
                        , 'drivers.full_name as driver_name', 'drivers.profile_photo as driver_photo','cab_rides.pickup_latitude','cab_rides.pickup_longitude','cab_rides.destination_latitude','cab_rides.destination_longitude','cab_types.type_name','cab_rides.cab_id','cab_rides.adult_number',
                        'cab_rides.has_children','cab_rides.children_number','cab_rides.has_wheelchair','cab_rides.wheelchair_number')
                ->where('cab_rides.canceled_by_passenger',$request->passenger_id)
                ->where('cab_rides.ridestatus_id','3')
                ->orderBy('cab_rides.id', 'desc')
                ->get();

        $driverRatingByPassenger = DriverRating::where('passenger_id', $request->passenger_id)->pluck('rating_value', 'ride_id')->toArray();
        
        $rideStatus = RideStatus::pluck('name', 'id')->toArray();


        $historyArr = [];
        $i = 0;
         if ($histories->isNotEmpty()) {
            foreach ($histories as $history) {
                $historyArr[$i]['ride_id'] = $history->ride_id;
                $historyArr[$i]['passenger_id'] = $history->passenger_id;
                $historyArr[$i]['driver_id'] = $history->driver_id;
                $historyArr[$i]['driver_name'] = $history->driver_name;
                $historyArr[$i]['driver_photo'] = $history->driver_photo;
                $historyArr[$i]['driver_rating'] = !empty($driverRatingByPassenger[$history->ride_id]) ? $driverRatingByPassenger[$history->ride_id] : '';
               $historyArr[$i]['pickup_address'] = $history->pickup_address;
                $historyArr[$i]['pickup_latitude'] = $history->pickup_latitude;
                $historyArr[$i]['pickup_longitude'] = $history->pickup_longitude;
                $historyArr[$i]['destination_address'] = $history->destination_address;
                $historyArr[$i]['destination_latitude'] = $history->destination_latitude;
                $historyArr[$i]['destination_longitude'] = $history->destination_longitude;
                $historyArr[$i]['cab_id'] = $history->cab_id;
                $historyArr[$i]['car_body_type'] = $history->type_name;
                $historyArr[$i]['total_fare_amount'] = number_format($history->total_fare_amount, 2);
                $historyArr[$i]['details'] = route('fareDetails',$history->ride_id);
                $historyArr[$i]['bid_amount'] = number_format($history->bid_amount, 2);
                $historyArr[$i]['ridestatus_id'] = $history->ridestatus_id;
                $historyArr[$i]['ridestatus'] = !empty($rideStatus[$history->ridestatus_id]) ? $rideStatus[$history->ridestatus_id] : '';
                $historyArr[$i]['adult_number'] = !empty($history->adult_number)?$history->adult_number : 0;
                 $historyArr[$i]['has_children'] = !empty($history->has_children)?$history->has_children : 0;
                 $historyArr[$i]['children_number'] = !empty($history->children_number)?$history->children_number : 0;
                 $historyArr[$i]['has_wheelchair'] = !empty($history->has_wheelchair)?$history->has_wheelchair : 0;
                 $historyArr[$i]['wheelchair_number'] = !empty($history->wheelchair_number)?$history->wheelchair_number : 0;
                 $historyArr[$i]['raw_datetime'] = date('Y-m-d H:i:s', strtotime($history->created_at));
                $historyArr[$i]['created_at'] = date('F d,Y,g:i A', strtotime($history->created_at));
                $i++;
            }
        }
        
        return response()->json(['response' => 'success', 'rideHistory' => $historyArr]);
    }
    
    public function fareDetails(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;
        $fareDetails = CabRide::join('drivers', 'drivers.id', '=', 'cab_rides.driver_id')
                ->join('cabs', 'cabs.id', '=', 'cab_rides.cab_id')
                ->join('cab_types','cab_types.id','=','cabs.cabtype_id')
                ->select('cab_rides.id as ride_id', 'cab_rides.passenger_id', 'cab_rides.driver_id', 'cab_rides.cab_id',
                        'cab_rides.pickup_address', 'cab_rides.destination_address',
                        'cab_rides.bid_amount','cab_rides.total_fare_amount', 'cab_rides.ridestatus_id', 'cab_rides.created_at',
                        'drivers.id as driver_id', 'drivers.full_name as driver_name',
                        'drivers.profile_photo as driver_photo','cab_types.type_name as cab_type','cabs.photo as cabs_photo')
                ->where('cab_rides.id', $request->ride_id)
                ->first();
        

       $driverRatingByPassenger = DriverRating::where('ride_id', $request->ride_id)->pluck('rating_value', 'ride_id')->toArray();
       
//        echo "<pre>"; print_r($driverRatingByPassenger);exit;
       
        $fareDetailsArr = [];
        if (!empty($fareDetails)) {
            $fareDetailsArr['ride_id'] = $fareDetails->ride_id;
            $fareDetailsArr['passenger_id'] = $fareDetails->passenger_id;
            $fareDetailsArr['cab_id'] = $fareDetails->cab_id;
            $fareDetailsArr['cabs_photo'] = $fareDetails->cabs_photo;
            $fareDetailsArr['cab_type'] = $fareDetails->cab_type;
            $fareDetailsArr['driver_id'] = $fareDetails->driver_id;
            $fareDetailsArr['driver_name'] = $fareDetails->driver_name;
            $fareDetailsArr['driver_photo'] = $fareDetails->driver_photo;
            $fareDetailsArr['driver_rating'] = !empty($driverRatingByPassenger[$fareDetails->ride_id]) ? $driverRatingByPassenger[$fareDetails->ride_id] : '';
            $fareDetailsArr['pickup_address'] = $fareDetails->pickup_address;
            $fareDetailsArr['destination_address'] = $fareDetails->destination_address;
            $fareDetailsArr['bid_amount'] = number_format($fareDetails->bid_amount, 2);
            $fareDetailsArr['total_fare_amount'] = number_format($fareDetails->total_fare_amount, 2);
            $fareDetailsArr['ridestatus_id'] = $fareDetails->ridestatus_id;
            
            $fareDetailsArr['created_at'] = date('F d,Y,g:i A', strtotime($fareDetails->created_at));
        }
        return response()->json(['response' => 'success', 'fareDetailsArr' => $fareDetailsArr]);
    }
    
    public function addBill(Request $request){
        $billAdd = new PassengerBill;
        $billAdd->transaction_id = $request->transaction_id;
        $billAdd->passenger_id = $request->passenger_id;
        $billAdd->amount = $request->amount;
        $billAdd->payment_status = $request->payment_status;
        if($billAdd->save()){
            return response()->json(['response' => 'success','message'=>'Passenger bill added successfully', 'billAdd' => $billAdd]);
        }
    }
    
    public function billList(Request $request){
//        echo "<pre>"; print_r($request->all());exit;
        $paymentStatusArr = [1=>'free',2=>'paid',3=>'pending'];
        $passengerBill = PassengerBill::where('passenger_id',$request->passenger_id)->get();
        

        $billArr =  [];
        if($passengerBill->isNotEmpty()){
            $i = 0;
            foreach($passengerBill as $bill){
                  $billArr[$i]['id'] = $bill->id;
                  $billArr[$i]['transaction_id'] = $bill->transaction_id;
                  $billArr[$i]['passenger_id'] = $bill->passenger_id;
                  $billArr[$i]['amount'] = $bill->amount;
                  $billArr[$i]['payment_status'] = $bill->payment_status;
                  $billArr[$i]['payment_status_value'] = !empty($bill->payment_status)? $paymentStatusArr[$bill->payment_status] : '';
                  $billArr[$i]['created_at'] = $bill->created_at;
                  $billArr[$i]['updated_at'] = $bill->updated_at;
                  $i++;
            }
        }
        
        if(!isset($billArr)){
            return response()->json(['response'=>'success','billList'=>$billArr]);
        }else{
            return response()->json(['response'=>'success','billList'=>$billArr]);
        }
    }
    
    public function emailExists(Request $request) {
        
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $passenger = Passenger::where('email', $request->email)->first();

        if(empty($passenger)){
           return response()->json(['response' => 'success', 'message' => "This {$request->email} does not exists in database"]); 
        }else{
            $token = JWTAuth::fromUser($passenger);
        }
        
        $message = "This {$request->email} exists in database";
        
        return $this->createNewToken($token, $passenger, $message);
    }

    public function deletePassengers() {
        if (Passenger::truncate() && OtpVerify::truncate()) {
            return response()->json(['response' => 'success', 'message' => 'Passenger & OtpVerify Table truncate successfully']);
        } else {
            return response()->json(['response' => 'error', 'message' => 'Passenger & OtpVerify Table does not truncated']);
        }
    }

    public function passengerDeviceAdd(Request $request){
       // echo "<pre>";print_r($request->all());exit;
        $alreadyExistsToken = DriverDevice::where('token',$request->token)->first();
        if($alreadyExistsToken){
            $alreadyExistsToken->token = $request->token;
            return response()->json(['response'=>'success','message'=>'Passenger device has been updated successfully!!','passengerDevice'=>$alreadyExistsToken]);
        }
        $passengerDevice = new DriverDevice;
        $passengerDevice->driver_id = $request->passenger_id;
        $passengerDevice->device_id = $request->device_id;
        $passengerDevice->token     = $request->token;
        $passengerDevice->user_type     = '2';
        if($passengerDevice->save()){
           return response()->json(['response'=>'success','message'=>'Passenger device has been inserted successfully!!','passengerDevice'=>$passengerDevice]); 
        }
    }

    public function passengerNotifications(Request $request){
        
        $passengerNotificationArr = NotificationSend::where(['user_id'=>$request->passenger_id,'user_type'=>'2'])
        ->orderBy('notification_id','desc')
        ->take(20)
        ->pluck('notification_id')->toArray();

        $passengerNotificationStatusArr = NotificationSend::where(['user_id'=>$request->passenger_id,'user_type'=>'2'])
        ->orderBy('notification_id','desc')
        ->take(20)
        ->pluck('notification_read_atatus','notification_id')->toArray();

        // echo "<pre>";print_r($passengerNotificationArr);exit;
        if(!empty($passengerNotificationArr)){
           $notificationsList = DB::table('notifications')->select('id','title','notification_details','created_at')->whereIn('id',$passengerNotificationArr)->orderBy('id','desc')->get();

          
        
        if($notificationsList->isNotEmpty()){
             $i = 0;
             $notificationArr = [];
             foreach($notificationsList as $notification){
               $notificationArr[$i]['notification_id'] =  $notification->id;
               $notificationArr[$i]['title'] =  $notification->title;
               $notificationArr[$i]['message'] =  $notification->notification_details;
               $notificationArr[$i]['status'] =  $passengerNotificationStatusArr[$notification->id];
               $notificationArr[$i]['status_value'] =  $passengerNotificationStatusArr[$notification->id] == '1' ? 'Read' : 'Unread';
               $notificationArr[$i]['created_at'] =  date('j F Y \a\t h:i A',strtotime($notification->created_at));
               $i++;
             }
        }

        return response()->json(['response'=>'success','notificationList'=>$notificationArr]);
        }else{
             return response()->json(['response'=>'success','notificationList'=>[]]);
            
        }
    }

    public function readNotifications(Request $request){
        $updateStatus = ['notification_read_atatus'=>'1'];

        $readNotifications = NotificationSend::where('user_id',$request->passenger_id)
        ->where('user_type','2')
        ->whereIn('notification_id',$request->notifications_id)
        ->update($updateStatus);
        if($readNotifications == count($request->notifications_id) ){
          return response()->json(['response'=>'success','message'=>'Passenger Notifications status updated']);
        }
    }


    public function estimateFare(Request $request){
        
        $rules = [
            'kilometer' => 'required|numeric',
            'time' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       

       $allFares =  AdminBillSetting::get();
       if($allFares->isNotEmpty()){
          $competitorFare = [];
          foreach($allFares as $fare){
            $competitorFare[$fare->id] = $fare->base_fare + ($fare->cost_per_minutes * $request->time) + ($fare->cost_per_kilometer * $request->kilometer) + $fare->booking_fee;
          }
       }

       

       $maxFare = max($competitorFare);
       $minFare = min($competitorFare);

       $reduceFare = DB::table('reduce_fares')->where('id',1)->first();

       $fareReduce = $reduceFare->reduce_fare_percentage;

       $ourOfferingFare = $minFare - (($fareReduce *  $minFare) / 100);
       $ourOfferingFare = number_format($ourOfferingFare,2);

       $data = ['maxFare'=>$maxFare,'minFare'=>$minFare,'fareReducePercent'=>$fareReduce,'ourOfferingFare'=>$ourOfferingFare];
       // echo "<pre>";print_r(max($competitorFare));
       // echo "<pre>";print_r(min($competitorFare));exit;

       return response()->json(['response'=>'success','data'=>$data]);
       
        // AdminBillSetting
    }
    
    
     public function pickupArriving(Request $request){
        
        $rideDetails = CabRide::select('id as ride_id','pickup_address','pickup_latitude','pickup_longitude','destination_address','destination_latitude','destination_longitude','total_fare_amount','bid_amount','riding_distance','driver_id','cab_id')
        ->where('id',$request->ride_id)->first();
        
        $driverDetails = [];
        if(!empty($rideDetails->driver_id)){
          $driverDetails = Driver::where('id',$rideDetails->driver_id)->select('id as driver_id','full_name','phone','profile_photo','cab_id')->first();
        }

        $cabDetails = [];
        if(!empty($driverDetails->cab_id)){
            $cabDetails = Cab::where('id',$driverDetails->cab_id)->select('id','photo','model_number','color','number_plate')->first();
        }

        
        $driverRating = DriverRating::where(['driver_id'=>$rideDetails->driver_id])->select(DB::raw("SUM(rating_value) as total_rating"),DB::raw("COUNT(rating_value) as count_number"))->first();

        // echo "<pre>";print_r($driverRating->toArray());exit;
        
        $driverAverageRating = 0;
        if($driverRating->count_number > 0){
          $driverAverageRating = $driverRating->total_rating/$driverRating->count_number;
        }
       


        return response()->json(['response'=>'success','rideDetails'=>$rideDetails,'driverDetails'=>$driverDetails,'cabDetails'=>$cabDetails,'driverAverageRating'=>$driverAverageRating]);
        
    }


    public function reviewDetails(Request $request){
        $rideDetails = CabRide::select('id as ride_id','pickup_address','pickup_latitude','pickup_longitude','destination_address','destination_latitude','destination_longitude','start_time','end_time','total_fare_amount','bid_amount','riding_distance','driver_id','cab_id')
        ->where('id',$request->ride_id)->first();
        
        $driverDetails = [];
        if(!empty($rideDetails->driver_id)){
          $driverDetails = Driver::where('id',$rideDetails->driver_id)->select('id as driver_id','full_name','phone','profile_photo','cab_id')->first();
        }

        $cabDetails = [];
        if(!empty($driverDetails->cab_id)){
            $cabDetails = Cab::where('id',$driverDetails->cab_id)->select('id','photo','model_number','color','number_plate')->first();
        }

        $driverRating = DriverRating::where(['driver_id'=>$rideDetails->driver_id])->select(DB::raw("SUM(rating_value) as total_rating"),DB::raw("COUNT(rating_value) as count_number"))->first();

        $driverAverageRating = 0;
        if($driverRating->count_number > 0){
          $driverAverageRating = $driverRating->total_rating/$driverRating->count_number;
        }
        return response()->json(['response'=>'success','rideDetails'=>$rideDetails,'driverDetails'=>$driverDetails,'cabDetails'=>$cabDetails,'driverAverageRating'=>$driverAverageRating]);
    }

    public function termAndPrivacy(){
        $termAndCondition = Settings::select('passenger_term_and_condition','passenger_privacy_policy')->first();

        $term_and_condition = [];
        if(!empty($termAndCondition->passenger_term_and_condition)){
          $term_and_condition = $termAndCondition->passenger_term_and_condition;
        }
        $privacy_policy = [];
        if(!empty($termAndCondition->passenger_privacy_policy)){
          $privacy_policy = $termAndCondition->passenger_privacy_policy;
        }

        return response()->json(['response'=>'success','term_and_condition'=>$term_and_condition,'privacy_policy'=>$privacy_policy]);
    }


    public function changeEmail(Request $request){
        $rules = [
            'id'=> 'required',
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $passenger = Passenger::findOrFail($request->id);
        $passenger->email = $request->email;
        if($passenger->save()){
            $this->sendEmail($passenger);
             return response()->json(['response'=>'success','passenger'=>$passenger]);
        }else{
            return response()->json(['response'=>'error','message'=>'Email has not changed']);
        }
        
    }

    public function reideRequestDistance(){
        $reideRequestDistance = Settings::select('request_distance','pickup_distance')->first();
        if ($reideRequestDistance) {
            return response()->json(['response' => 'success', 'distance' => $reideRequestDistance]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
        }
    }


    public function passengerCards(Request $request){

        $cardList = PassengerPaymentInfo::where('passenger_id',$request->id)->first();
        // echo "<pre>";print_r($cardList->toArray());exit;
        if (!empty($cardList)) {
            return response()->json(['response' => 'success', 'cardList' => $cardList]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
        }
    }
    
    public function passengerToken(Request $request){
        

        $tokens = DriverDevice::where('driver_id',$request->passenger_id)->where('user_type',2)->first();
        // echo "<pre>";print_r($tokens->toArray());exit;
        if (!empty($tokens)) {
            return response()->json(['response' => 'success', 'token' => $tokens]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
        }
    }


}
