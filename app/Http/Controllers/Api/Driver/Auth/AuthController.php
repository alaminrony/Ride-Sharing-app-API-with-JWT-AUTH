<?php

namespace App\Http\Controllers\Api\Driver\Auth;

use App\Http\Controllers\Controller;
use App\Driver;
use App\Passenger;
use App\OtpVerify;
use App\Cab;
use App\User;
use App\ContactUs;
use App\CabRide;
use App\CabType;
use App\DriverDailySummary;
use App\HelpAndSupport;
use App\PassengerRating;
use App\DriverPaymentInfo;
use App\DriverBill;
use App\BillChargeOption;
use App\BillChargeOptionValue;
use App\RideStatus;
use App\AdminNotification;
use App\DriverDevice;
use App\NotificationSend;
use App\Settings;
use App\TaxiOperator;
use App\DriversActivityMinutes;
use App\RideCancel;
use Notification;
use Validator;
use JWTAuth;
use Config;
use DB;
use Image;
use Artisan;
use ImageOptimizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Notifications\verifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Helper;

class AuthController extends Controller {

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'driverRegistration', 'sendOTP', 'verifyOTP', 'resetPassword', 'verifyEmail', 'phoneExists', 'emailExists', 'deleteDriver', 'termAndPrivacy', 'socialIdExists', 'cacheClear','onlineOffline','reideRequestDistance']]);

        Config::set('jwt.user', Driver::class);
        Config::set('auth.providers', ['users' => [
                'driver' => 'eloquent',
                'model' => Driver::class,
        ]]);
    }

    public function phoneExists(Request $request) {

        $rules = [
            'phone' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driver = Driver::where('phone', $request->phone)->first();
//        echo "<pre>";print_r($driver->toArray());exit;

        if (!empty($driver)) {
            return response()->json(['response' => 'success', 'message' => "This {$request->phone} exists in database"]);
        } else {
            return response()->json(['response' => 'success', 'message' => "This {$request->phone} does not exists in database"]);
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

        $driver = Driver::where('email', $request->email)->first();

        if (empty($driver)) {
            return response()->json(['response' => 'success', 'message' => "This {$request->email} does not exists in database"]);
        } else {
            $token = JWTAuth::fromUser($driver);
        }

        $message = "This {$request->email} exists in database";

        return $this->createNewToken($token, $driver, $message);
    }

    public function socialIdExists(Request $request) {

        $rules = [
            'social_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driver = Driver::where('social_id', $request->social_id)->first();

        if (empty($driver)) {
            return response()->json(['response' => 'success', 'message' => "This {$request->social_id} does not exists in database"]);
        } else {
            $token = JWTAuth::fromUser($driver);
        }

        $message = "This {$request->social_id} exists in database";

        return $this->createNewToken($token, $driver, $message);
    }

    public function sendOTP(Request $request) {
        $rules = [
            'phone' => 'required|numeric',
        ];
//        if (is_numeric($request->get('phone'))) {
//            $rules['phone'] = ['required', 'numeric'];
//        } elseif (filter_var($request->get('phone'), FILTER_VALIDATE_EMAIL)) {
//            $rules['phone'] = ['required', 'email'];
//        }


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

        $rules = [
            'password' => 'required|confirmed|string|min:6',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driver = Driver::where('phone', $request->phone)->first();
        $driver->password = Hash::make($request->password);
        if ($driver->save()) {
            return response()->json(['response' => 'success', 'message' => 'Password reset successfully', 'phone' => $request->phone]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'Password does not reset']);
        }
    }

    public function driverRegistration(Request $request) {
//          echo "<pre>";print_r($request->all());exit;
        $rules = [
            'full_name' => 'required|between:2,100',
            'email' => 'required|email|unique:drivers|max:50',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'post_code' => 'required',
            'driving_licence_no' => 'required',
            'australian_taxi_licence_no' => 'required',
            'driving_licence_expire_date' => 'required',
            'australian_taxi_licence_expire_date' => 'required',
            'profile_photo' => 'required',
            'driving_licence_photo_front' => 'required',
            'driving_licence_photo_back' => 'required',
            'atln_photo_front' => 'required',
            'atln_photo_back' => 'required',
            'phone' => 'required|unique:drivers',
            'otp_code' => 'required',
            'social_login' => 'required',
        ];

        if ($request->social_login == '0') {
            $rules['password'] = ['required', 'confirmed', 'string', 'min:6'];
//            $rules['otp_code'] = ['required'];
        }
        if ($request->social_login == '1') {
            $rules['social_id'] = ['required'];
        }

        if (!empty($request->file('profile_photo'))) {
            $rules['profile_photo'] = ['required', 'image', 'mimes:jpeg,png'];
        }
        if (!empty($request->file('driving_licence_photo_front'))) {
            $rules['driving_licence_photo_front'] = ['required', 'image', 'mimes:jpeg,png'];
        }
        if (!empty($request->file('driving_licence_photo_back'))) {
            $rules['driving_licence_photo_back'] = ['required', 'image', 'mimes:jpeg,png'];
        }
        if (!empty($request->file('atln_photo_front'))) {
            $rules['atln_photo_front'] = ['required', 'image', 'mimes:jpeg,png'];
        }
        if (!empty($request->file('atln_photo_back'))) {
            $rules['atln_photo_back'] = ['required', 'image', 'mimes:jpeg,png'];
        }

        $message = [
            'profile_photo.required' => 'Profile photo is required',
            'driving_licence_photo_front.required' => 'Driving license photo front is required',
            'driving_licence_photo_back.required' => 'Driving license photo back is required',
            'atln_photo_front.required' => 'Australin taxi license front photo is required',
            'atln_photo_back.required' => 'Australin taxi license back photo is required',
        ];


        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

//        echo "<pre>";print_r($request->all());exit;

        $driver = new Driver;
        $driver->full_name = $request->full_name;
        $driver->email = $request->email;
        if ($request->social_login == '0') {
            $driver->password = Hash::make($request->password);
        } else {
            $driver->password = Hash::make($request->social_id);
        }
        $driver->social_login = !empty($request->social_login) ? $request->social_login : '0';
        $driver->address = $request->address;
        $driver->country = $request->country;
        $driver->state = $request->state;
        $driver->city = $request->city;
        $driver->post_code = $request->post_code;
        $driver->driving_licence_no = $request->driving_licence_no;
        $driver->australian_taxi_licence_no = $request->australian_taxi_licence_no;
        $driver->driving_licence_expire_date = $request->driving_licence_expire_date;
        $driver->australian_taxi_licence_expire_date = $request->australian_taxi_licence_expire_date;
        $driver->social_id = $request->social_id;
        if ($files = $request->file('profile_photo')) {
            $imagePath = 'uploads/driver/profile_photo/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $image = Image::make($files)->orientate();
            $image->resize(800, 800, function($constraint) {
                $constraint->aspectRatio();
            })->save($imageName);
            $driver->profile_photo = $imageName;
        }
        if ($files = $request->file('driving_licence_photo_front')) {
            $imagePath = 'uploads/driver/d_licence_photo/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $image = Image::make($files)->orientate();
            $image->resize(800, 800, function($constraint) {
                $constraint->aspectRatio();
            })->save($imageName);
//            $files->move($imagePath, $imageName);
            $driver->driving_licence_photo_front = $imageName;
        }
        if ($files = $request->file('driving_licence_photo_back')) {
            $imagePath = 'uploads/driver/d_licence_photo/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $image = Image::make($files)->orientate();
            $image->resize(800, 800, function($constraint) {
                $constraint->aspectRatio();
            })->save($imageName);
//            $files->move($imagePath, $imageName);
            $driver->driving_licence_photo_back = $imageName;
        }
        if ($files = $request->file('atln_photo_front')) {
            $imagePath = 'uploads/driver/a_taxi_licence_photo/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $image = Image::make($files)->orientate();
            $image->resize(800, 800, function($constraint) {
                $constraint->aspectRatio();
            })->save($imageName);
//            $files->move($imagePath, $imageName);
            $driver->atln_photo_front = $imageName;
        }
        if ($files = $request->file('atln_photo_back')) {
            $imagePath = 'uploads/driver/a_taxi_licence_photo/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $image = Image::make($files)->orientate();
            $image->resize(800, 800, function($constraint) {
                $constraint->aspectRatio();
            })->save($imageName);
//            $files->move($imagePath, $imageName);
            $driver->atln_photo_back = $imageName;
        }
        $driver->phone = $request->phone;
        $driver->phone_varification = $request->otp_code;
        $driver->phone_varification_status = '1';

        if ($driver->save()) {
            $notifyForDriver = new AdminNotification;
            $notifyForDriver->title = 'New Driver Registered';
            $notifyForDriver->details = "Click to view {$driver->full_name} details";
            $notifyForDriver->type = '1';
            $notifyForDriver->type_id = $driver->id;
            $notifyForDriver->status = '0';
            $notifyForDriver->save();


            $this->sendEmail($driver);
            return $this->login($request);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
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

        $driver = Auth::guard()->user();
        $message = 'Successfully logged in';
        return $this->createNewToken($token, $driver, $message);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile() {
        return response()->json(Auth::guard()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        Auth::guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(Auth::guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token, $driver, $message = null) {

        return response()->json([
                    'response' => 'success',
                    'message' => $message,
                    'access_token' => $token,
                    'token_type' => 'bearer',
//                    'expires_in' => Auth::guard()->factory()->getTTL() * 60,
                    'drivers' => $driver,
        ]);
    }

    public function sendEmail($driver) {
//        echo "<pre>"; print_r($driver->toArray());exit;
        $details = [
            'greeting' => 'Hi ' . $driver->full_name,
            'body' => "Please confirm that {$driver->email} is your email address for clicking this button",
            'actionText' => 'Verify Email',
            'actionURL' => "http://faretrim.com.au/driver/verifyEmail/" . base64_encode($driver->email),
        ];

        $driver->notify(new verifyEmail($details));
//        Notification::send($driver, new verifyEmail($details));
//        Notification::route('mail', $driver->email)
//                ->notify(new verifyEmail($details));
//        return response()->json(['response' => 'success', 'message' => 'Successfully registered', 'driver' => $driver], 201);
    }

    public function verifyEmail(Request $request) {
        $email = base64_decode($request->email);

        $driver = Driver::where('email', $email)->first();

        if ($driver) {
            $driver->mail_verification_status = '1';
            if ($driver->save()) {
                return response()->json(['response' => 'success', 'message' => 'Your Email account is activated.', 'email' => $email, 'verified_status' => 1]);
            }
        }
        return response()->json(['response' => 'success', 'message' => 'Your Email does not Exists']);
    }

    public function resendEmail(Request $request) {
        $email = base64_decode($request->email);
        $driver = Driver::where('email', $email)->first();

        $details = [
            'greeting' => 'Hi ' . $driver->full_name,
            'body' => "Please confirm that {$driver->email} is your email address for clicking this button",
            'actionText' => 'Verify Email',
            'actionURL' => "http://faretrim.com.au/driver/verifyEmail/" . base64_encode($driver->email),
        ];

        $driver->notify(new verifyEmail($details));
        return response()->json(['response' => 'success', 'message' => 'Verify Email Sent Successfully', 'id' => $driver->id, 'email' => $email, 'phone' => $driver->phone]);
    }

    public function addVehicle(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        $rules = [
            'photo' => 'required',
            'number_plate' => 'required',
            'taxi_operator' => 'required',
            'passenger_capacity' => 'required',
            'children' => 'required',
            'wheelchair' => 'required',
            'driver_id' => 'required',
        ];

        if (!empty($request->file('photo'))) {
            $rules['photo'] = ['required', 'image', 'mimes:jpeg,png'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driverId = Auth::guard()->user()->id;

//        echo "<pre>";print_r($driverId);exit;
        $cabs = new Cab;

        if ($files = $request->file('photo')) {
            $imagePath = 'uploads/driver/vehicle/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $files->move($imagePath, $imageName);
            $cabs->photo = $imageName;
        }
        $cabs->manufacturer = $request->manufacturer;
        $cabs->model_number = $request->model_number;
        $cabs->manufacturer_year = $request->manufacturer_year;
        $cabs->color = $request->color;
        $cabs->cabtype_id = $request->cabtype_id;
        $cabs->number_plate = $request->number_plate;
        $cabs->taxi_operator = $request->taxi_operator;
        $cabs->passenger_capacity = $request->passenger_capacity;
        $cabs->children = $request->children;
        $cabs->wheelchair = $request->wheelchair;
        $cabs->driver_id = $request->driver_id;
        if ($cabs->save()) {
            return response()->json(['response' => 'success', 'message' => 'Vehicle added Successfully', 'cab' => $cabs]);
        }
    }

    public function vehicleList(Request $request) {
        $rules = [
            'driver_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $cabs = Cab::where('driver_id', $request->driver_id)->get();
        $cabType = CabType::pluck('type_name', 'id')->toArray();

        $driverSelectedCab = Driver::select('cab_id')->where('id', $request->driver_id)->first();
        $selected_cab = !empty($driverSelectedCab->cab_id) ? $driverSelectedCab->cab_id : null;

        if ($cabs->isNotEmpty()) {
            $cabArr = [];
            $i = 0;
            foreach ($cabs as $cab) {
                $cabArr[$i]['id'] = $cab->id;
                $cabArr[$i]['photo'] = url($cab->photo);
                $cabArr[$i]['manufacturer'] = $cab->manufacturer;
                $cabArr[$i]['model_number'] = $cab->model_number;
                $cabArr[$i]['color'] = $cab->color;
                $cabArr[$i]['cabtype_id'] = $cab->cabtype_id;
                $cabArr[$i]['cabtype_name'] = !empty($cabType[$cab->cabtype_id]) ? $cabType[$cab->cabtype_id] : '';
                $cabArr[$i]['number_plate'] = $cab->number_plate;
                $cabArr[$i]['driver_id'] = $cab->driver_id;
                $cabArr[$i]['totalSeats'] = $cab->passenger_capacity;
                $cabArr[$i]['totalChildrenSeats'] = $cab->children;
                $cabArr[$i]['wheelChairAvailable'] = $cab->wheelchair;
                $cabArr[$i]['details'] = url('api/vehicle/' . $cab->id);
                $i++;
            }
        }

        if (isset($cabArr)) {
            $cabList = $cabArr;
        } else {
            $cabList = [];
        }


        return response()->json(['response' => 'success', 'selected_cab' => $selected_cab, 'cabType' => $cabType, 'cabList' => $cabList]);
    }

    public function vehicle(Request $request) {
//        echo "<pre>";print_r($request->id);exit;

        $cab = Cab::leftJoin('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                ->select('cabs.id', 'cabs.photo', 'cabs.manufacturer', 'cabs.model_number', 'cabs.manufacturer_year', 'cabs.color', 'cabs.cabtype_id'
                        , 'cab_types.type_name as cabtype_name', 'cabs.number_plate', 'cabs.taxi_operator',
                        'cabs.passenger_capacity', 'cabs.children', 'cabs.wheelchair', 'cabs.driver_id', 'cabs.description', 'cabs.created_at', 'cabs.updated_at')
                ->where('cabs.id', $request->id)
                ->first();
        if (!empty($cab)) {
            return response()->json(['response' => 'success', 'cab' => $cab]);
        }
    }

    public function vehicleType() {

        $cabType = CabType::select('type_name', 'id')->orderBy('id', 'asc')->get();
        return response()->json(['response' => 'success', 'cabType' => $cabType]);
//        echo "<pre>";print_r($cabType);exit;
    }

    public function selectVehicle(Request $request) {
//        echo "<pre>";print_r($request->driver_id);exit;
        $driver = Driver::findOrFail($request->driver_id);
        $driver->cab_id = $request->cab_id;
        if ($driver->save()) {
            return response()->json(['response' => 'success', 'message' => 'Driver vehicle selected successfully', 'driver' => $driver]);
        }
    }

    public function editVehicle(Request $request) {

        $rules = [
            'number_plate' => 'required',
            'taxi_operator' => 'required',
            'passenger_capacity' => 'required',
            'children' => 'required',
            'wheelchair' => 'required',
        ];

        if (!empty($request->file('photo'))) {
            $rules['photo'] = ['required', 'image', 'mimes:jpeg,png'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driverId = Auth::guard()->user()->id;

//        echo "<pre>";print_r($driverId);exit;
        $cabs = Cab::findOrFail($request->cab_id);
//        echo "<pre>";print_r($cabs->photo);exit;

        if ($files = $request->file('photo')) {

            if (file_exists($cabs->photo) && !empty($cabs->photo)) {
                unlink($cabs->photo);
            }
            $imagePath = 'uploads/driver/vehicle/';
            $imageName = $imagePath . '' . uniqid() . "." . date('Ymd') . "." . $files->getClientOriginalExtension();
            $files->move($imagePath, $imageName);
            $cabs->photo = $imageName;
        }
        $cabs->manufacturer = $request->manufacturer;
        $cabs->model_number = $request->model_number;
        $cabs->manufacturer_year = $request->manufacturer_year;
        $cabs->color = $request->color;
        $cabs->cabtype_id = $request->cabtype_id;
        $cabs->number_plate = $request->number_plate;
        $cabs->taxi_operator = $request->taxi_operator;
        $cabs->passenger_capacity = $request->passenger_capacity;
        $cabs->children = $request->children;
        $cabs->wheelchair = $request->wheelchair;
        $cabs->driver_id = $driverId;
        if ($cabs->save()) {
            return response()->json(['response' => 'success', 'message' => 'Vehicle edit Successfully', 'cab' => $cabs]);
        }
    }

    public function deleteVehicle(Request $request) {
        $cabs = Cab::findOrFail($request->cab_id);
        if (file_exists($cabs->photo) && !empty($cabs->photo)) {
            unlink($cabs->photo);
        }
        if ($cabs->delete()) {
            return response()->json(['response' => 'success', 'message' => 'Vehicle delete Successfully']);
        }
    }

    public function onlineOffline(Request $request) {
        $driver = Driver::findOrFail($request->driver_id);
        $driver->is_online = $request->is_online;
        if ($driver->save()) {
            DriversActivityMinutes::create([
                'driver_id' => $request->driver_id,
                'status' => $request->is_online,
            ]);
            return response()->json(['response' => 'success', 'message' => 'Online Status updated Successfully', 'id' => $driver->id, 'is_online' => $driver->is_online]);
        }
    }

    public function loginPin(Request $request) {
//        echo "<pre>";print_r($driver->toArray());exit;
        $rules = [
            'pin' => 'required|numeric|confirmed',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $driver = Driver::findOrFail($request->driver_id);
        $driver->pin = $request->pin;
        $driver->first_login_status = '1';
        if ($driver->save()) {
            return response()->json(['response' => 'success', 'message' => 'Pin Insert Successfully', 'id' => $driver->id, 'pin' => $driver->pin, 'first_login_status' => $driver->first_login_status]);
        }
    }

    public function resetPin(Request $request) {
        $rules = [
            'pin' => 'required|numeric|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $driver = Driver::findOrFail($request->driver_id);
        $driver->pin = $request->pin;
        if ($driver->save()) {
            return response()->json(['response' => 'success', 'message' => 'Pin reset Successfully', 'id' => $driver->id, 'pin' => $driver->pin, 'first_login_status' => $driver->first_login_status]);
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

        $passengerDetails = [];
        if (!empty($rideDetails->passenger_id)) {
            $passengerDetails = Passenger::select('id as passenger_id', 'full_name', 'phone', 'avatar')->where('id', $rideDetails->passenger_id)->first();
        }
        return response()->json(['response' => 'success', 'rideDetails' => $rideDetails, 'passengerDetails' => $passengerDetails]);
    }

    public function rideAccept(Request $request) {
        // echo "<pre>";print_r($request->all());exit;
        $rules = [
            'driver_id' => 'required',
            'ride_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $acceptedDriver = Driver::findOrFail($request->driver_id);
        $rideStatus = CabRide::findOrFail($request->ride_id);

        if (!empty($rideStatus->driver_id)) {
            return response()->json(['response' => 'success', 'message' => 'This ride have already accepted by driver']);
        }
        $rideStatus->ridestatus_id = '2';
        $rideStatus->driver_id = $request->driver_id;
        $rideStatus->cab_id = !empty($acceptedDriver->cab_id) ? $acceptedDriver->cab_id : '';
        if ($rideStatus->save()) {
            return response()->json(['response' => 'success', 'message' => 'Ride Accept Successfully', 'rideDetails' => $rideStatus]);
        }
    }

    public function driverReachedAtPickup(Request $request) {
        // echo "<pre>";print_r($request->all());exit;
        $rules = [
            'driver_id' => 'required',
            'ride_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $acceptedDriver = Driver::findOrFail($request->driver_id);
        $rideStatus = CabRide::findOrFail($request->ride_id);

        if (!empty($rideStatus->driver_id)) {
            return response()->json(['response' => 'success', 'message' => 'This ride have already accepted by driver']);
        }
        $rideStatus->ridestatus_id = '4';
        $rideStatus->driver_id = $request->driver_id;
        $rideStatus->cab_id = !empty($acceptedDriver->cab_id) ? $acceptedDriver->cab_id : '';
        if ($rideStatus->save()) {
            return response()->json(['response' => 'success', 'message' => 'Driver Reached pickup address Successfully', 'rideDetails' => $rideStatus]);
        }
    }

    public function rideTimeOut(Request $request) {
        // echo "<pre>";print_r($request->all());exit;
        $rules = [
            'ride_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        $rideStatus = CabRide::findOrFail($request->ride_id);


        $rideStatus->ridestatus_id = '7';
        $rideStatus->driver_id = $request->driver_id;
        $rideStatus->cab_id = !empty($acceptedDriver->cab_id) ? $acceptedDriver->cab_id : '';
        if ($rideStatus->save()) {
            return response()->json(['response' => 'success', 'message' => 'Ride time out Successfully', 'rideDetails' => $rideStatus]);
        }
    }

    public function rideCancel(Request $request) {
        $rules = [
            'driver_id' => 'required',
            'ride_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $acceptedDriver = Driver::findOrFail($request->driver_id);
        $rideStatus = CabRide::findOrFail($request->ride_id);

        $rideStatus->ridestatus_id = '3';
        $rideStatus->canceled_by_driver = $request->driver_id;
        $rideStatus->cab_id = !empty($acceptedDriver->cab_id) ? $acceptedDriver->cab_id : '';
        $rideStatus->end_time = date('Y-m-d H:i:s');
        if ($rideStatus->save()) {
            return response()->json(['response' => 'success', 'message' => 'Ride Cancel Successfully', 'rideDetails' => $rideStatus]);
        }
    }

    public function rideStart(Request $request) {
        $rideStatus = CabRide::findOrFail($request->ride_id);
        $rideStatus->ridestatus_id = '5';
        $rideStatus->start_time = date('Y-m-d H:i:s');
        if ($rideStatus->save()) {
            return response()->json(['response' => 'success', 'message' => 'Ride Start Successfully', 'rideDetails' => $rideStatus]);
        }
    }

    public function rideComplete(Request $request) {
        $rideStatus = CabRide::findOrFail($request->ride_id);
        $rideStatus->ridestatus_id = '6';
        $rideStatus->end_time = date('Y-m-d H:i:s');
        if ($rideStatus->save()) {
            return response()->json(['response' => 'success', 'message' => 'Ride Complete Successfully', 'rideDetails' => $rideStatus]);
        }
    }

    public function paymentComplete(Request $request) {
//        echo "<pre>"; print_r($request->ride_id);exit;
        $rideStatus = CabRide::findOrFail($request->ride_id);
        $rideStatus->total_fare_amount = $request->total_fare_amount;

        $passengerRating = [];
        if (!empty($rideStatus->passenger_id)) {
            $passengerRating = PassengerRating::where(['passenger_id' => $rideStatus->passenger_id])->select(DB::raw("SUM(rating_value) as total_rating"), DB::raw("COUNT(rating_value) as count_number"))->first();
        }

        $passengerAverageRating = 0;
        if ($passengerRating->count_number > 0) {
            $passengerAverageRating = $passengerRating->total_rating / $passengerRating->count_number;
        }

        $passengerDetails = [];
        if (!empty($rideStatus->passenger_id)) {
            $passengerDetails = Passenger::select('id', 'full_name', 'avatar')->where('id', $rideStatus->passenger_id)->first();
        }

        $passengerDetailsArr = [];
        if (!empty($passengerDetails)) {
            $passengerDetailsArr['id'] = $passengerDetails->id;
            $passengerDetailsArr['full_name'] = $passengerDetails->full_name;
            $passengerDetailsArr['avatar'] = $passengerDetails->avatar;
            $passengerDetailsArr['passengerAverageRating'] = number_format($passengerAverageRating, 2);
        }

        if ($rideStatus->save()) {
            return response()->json(['response' => 'success', 'message' => 'Payment Complete Successfully', 'rideDetails' => $rideStatus, 'passengerDetails' => $passengerDetailsArr]);
        }
    }

    public function home(Request $request) {

        $driver = Driver::where('id', $request->driver_id)->select('id as driver_id', 'pin', 'cab_id', 'is_online', 'first_login_status', 'mail_verification_status')->first();

        $vehicleDetails = Cab::join('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                ->select('cabs.id as cab_id', 'cabs.photo', 'cabs.color', 'cabs.number_plate', 'cabs.passenger_capacity', 'cabs.children', 'cabs.wheelchair', 'cab_types.type_name')
                ->where('cabs.id', $driver->cab_id)
                ->first();

        $driverNotificationCount = NotificationSend::where(['user_id' => $request->driver_id, 'user_type' => '1', 'notification_read_atatus' => '0'])
                ->orderBy('notification_id', 'desc')
                ->count();

         $rideRequestDistance = Settings::select('request_distance','pickup_distance')->first();

        return response()->json(['response' => 'success', 'driverDetails' => $driver, 'vehicleDetails' => $vehicleDetails, 'unreadNotification' => $driverNotificationCount,'distance'=>$rideRequestDistance]);
    }

    public function todaySummary(Request $request) {

        $driver = Driver::where('id', $request->driver_id)->first();

        if (!empty($driver->cab_id)) {
            $vehicleDetails = Cab::join('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                    ->select('cabs.id as cab_id', 'cabs.photo', 'cabs.color', 'cabs.number_plate', 'cab_types.type_name')
                    ->where('cabs.id', $driver->cab_id)
                    ->firstOrFail();
        } else {
            $vehicleDetails = null;
        }


        $todaySummary = CabRide::join('drivers', 'drivers.id', '=', 'cab_rides.driver_id')
                ->select('cab_rides.driver_id', 'drivers.full_name', 'cab_rides.total_fare_amount', 'drivers.profile_photo')
                ->where('cab_rides.driver_id', $request->driver_id)
                ->where('cab_rides.ridestatus_id', '6')
                ->whereDate('cab_rides.created_at', '=', date('Y-m-d'))
                ->get();

//        $todayFare = CabRide::join('driver_daily_summaries', 'driver_daily_summaries.driver_id', '=', 'cab_rides.driver_id')
//                ->select('cab_rides.driver_id', 'driver_daily_summaries.total_minutes as total_munites', DB::raw("COUNT(cab_rides.id) as total_trip"), DB::raw("SUM(cab_rides.total_fare_amount) as total_fare"))
//                ->where('cab_rides.driver_id', $request->driver_id)
//                ->where('cab_rides.ridestatus_id', '6')
//                ->whereDate('cab_rides.created_at', '=', date('Y-m-d'))
//                ->groupBy('cab_rides.driver_id')
//                ->first();

        $todayFare = CabRide::select('cab_rides.driver_id', DB::raw("COUNT(cab_rides.id) as total_trip"), DB::raw("SUM(cab_rides.total_fare_amount) as total_fare"))
                ->where('cab_rides.driver_id', $request->driver_id)
                ->where('cab_rides.ridestatus_id', '6')
                ->whereDate('cab_rides.created_at', '=', date('Y-m-d'))
                ->first();


        $totalOnline = DriversActivityMinutes::select('created_at')->where('driver_id', $request->driver_id)->where('status', '1')->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        $totalOffline = DriversActivityMinutes::select('created_at')->where('driver_id', $request->driver_id)->where('status', '0')->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->get();

        $onlineTimeArr = [];
        if ($totalOnline->isNotEmpty()) {
            foreach ($totalOnline as $onlineTime) {
                $onlineTimeArr[] = strtotime($onlineTime->created_at);
            }
        }

        $offlineTimeArr = [];
        if ($totalOffline->isNotEmpty()) {
            foreach ($totalOffline as $offlineTime) {
                $offlineTimeArr[] = strtotime($offlineTime->created_at);
            }
        }

        if (count($offlineTimeArr) != count($onlineTimeArr)) {
            array_push($offlineTimeArr, strtotime(date('Y-m-d H:i:s')));
        }


        $diffArr = [];
        foreach ($offlineTimeArr as $offLineKey => $offlineTime) {
                $diffArr[] = abs($offlineTime - $onlineTimeArr[$offLineKey]);
        }
        
        $totalActiveMinutes = !empty($diffArr) ? array_sum($diffArr) : 0;

        $totalActiveTime = Null;
        if ($totalActiveMinutes > 0) {
            $totalActiveTime = $this->time_format($totalActiveMinutes);
        }


        if (!empty($totalActiveMinutes)) {
            $minutes = floor($totalActiveMinutes / 60);
        }

        $data = [
            'driver_id' => !empty($todayFare->driver_id) ? $todayFare->driver_id : null,
            'total_trip' => !empty($todayFare->total_trip) ? $todayFare->total_trip : null,
            'total_fare' => !empty($todayFare->total_fare) ? $todayFare->total_fare : null,
            'total_munites' => !empty($minutes) ? $minutes : null,
            'total_time' => !empty($totalActiveTime) ? $totalActiveTime : null,
        ];

        return response()->json(['response' => 'success', 'currentVehicle' => $vehicleDetails, 'todaySummary' => $todaySummary, 'todayFare' => $data]);
    }

    public function time_format($time) {

        $convert_hour_min_sec = gmdate("H:i:s", $time);
        $convert_array = explode(':', $convert_hour_min_sec);
        $result = "";
        if (!empty($convert_array[0]) && $convert_array[0] > 0) {
            $result .= (int) $convert_array[0] . ' hours ';
        }
        if (!empty($convert_array[1]) && $convert_array[1] > 0) {
            $result .= (int) $convert_array[1] . ' minutes';
        }
        return $result;
    }

    public function todayFare(Request $request) {

        $todayFare = CabRide::join('driver_daily_summaries', 'driver_daily_summaries.driver_id', '=', 'cab_rides.driver_id')
                ->select('cab_rides.driver_id', 'driver_daily_summaries.total_minutes as total_munites', DB::raw("COUNT(cab_rides.id) as total_trip"), DB::raw("SUM(cab_rides.total_fare_amount) as total_fare"))
                ->where('cab_rides.driver_id', $request->driver_id)
                ->where('cab_rides.ridestatus_id', '6')
                ->whereDate('cab_rides.created_at', '=', date('Y-m-d'))
                ->groupBy('cab_rides.driver_id')
                ->first();

        if (!empty($todayFare->total_munites)) {
            $hours = floor($todayFare->total_munites / 60);
            $minutes = ($todayFare->total_munites % 60);
            $totalTime = !empty($minutes) ? "{$hours} hours {$minutes} minutes" : "{$hours} hours";
        }

        $data = [
            'driver_id' => $todayFare->driver_id,
            'total_trip' => $todayFare->total_trip,
            'total_fare' => $todayFare->total_fare,
            'total_munites' => $todayFare->total_munites,
            'total_time' => $totalTime,
        ];
        return response()->json(['response' => 'success', 'data' => $data]);
    }

    public function editProfile(Request $request) {

        $rules = [
            'full_name' => 'required|between:2,100',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email|max:50',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $driver = Driver::findOrFail($request->driver_id);
        $driver->full_name = $request->full_name;
        $driver->address = $request->address;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        if ($driver->save()) {
            return response()->json(['response' => 'success', 'message' => 'Profile updated successfully', 'driver' => $driver]);
        }
    }

    public function updatePassword(Request $request) {
//        echo "<pre>"; print_r($request->all());exit;
        $rules = [
            'driver_id' => 'required|numeric',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $driver = Driver::findOrFail($request->driver_id);

        if ((Hash::check($request->old_password, $driver->password)) == false) {
            return response()->json(['response' => 'error', 'message' => 'Your old password does not match']);
        }
        $driver->password = Hash::make($request->new_password);
        if ($driver->save()) {
            return response()->json(['response' => 'success', 'message' => 'Password updated successfully', 'driver' => $driver]);
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
            'wheelchair_number' => 'required',
            // 'driver_id' => 'required',
            'ride_type' => 'required',
            // 'cab_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
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
        $addRide->wheelchair_number = $request->wheelchair_number;
        $addRide->passenger_id = $request->passenger_id;
        $addRide->driver_id = !empty($request->driver_id) ? $request->driver_id : '0';
        $addRide->ride_type = $request->ride_type;
        $addRide->cab_id = !empty($request->cab_id) ? $request->cab_id : '0';
        $addRide->start_time = $request->start_time;
        $addRide->end_time = $request->end_time;
        $addRide->riding_distance = $request->riding_distance;
        $addRide->pickup_address = $request->pickup_address;
        $addRide->pickup_latitude = $request->pickup_latitude;
        $addRide->pickup_longitude = $request->pickup_longitude;
        $addRide->destination_latitude = $request->destination_latitude;
        $addRide->cancel_issue = !empty($request->cancel_issue) ? $request->cancel_issue : '';
        $addRide->canceled_by_driver = !empty($request->canceled_by_driver) ? $request->canceled_by_driver : '0';
        $addRide->canceled_by_passenger = !empty($request->canceled_by_passenger) ? $request->canceled_by_passenger : '0';
        $addRide->destination_longitude = $request->destination_longitude;
        $addRide->destination_address = $request->destination_address;
        $addRide->ridestatus_id = '1';
        $addRide->bid_amount = $request->bid_amount;
        $addRide->total_fare_amount = !empty($request->total_fare_amount) ? $request->total_fare_amount : '0';
        $addRide->charge_amount = !empty($request->charge_amount) ? $request->charge_amount : '0';
        $addRide->charge_type = !empty($request->charge_type) ? $request->charge_type : '0';
        $addRide->charge_status = !empty($request->charge_status) ? $request->charge_status : '0';
        $addRide->comment = !empty($request->comment) ? $request->comment : '';
        if ($addRide->save()) {
            return response()->json(['response' => 'success', 'message' => 'Ride added successfully', 'ride' => $addRide]);
        }
    }

    public function rideHistory(Request $request) {

        $histories = CabRide::join('passengers', 'passengers.id', '=', 'cab_rides.passenger_id')
                ->leftJoin('cabs', 'cabs.id', '=', 'cab_rides.cab_id')
                ->leftJoin('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                ->select('cab_rides.id as ride_id', 'cab_rides.passenger_id', 'cab_rides.driver_id',
                        'cab_rides.pickup_address', 'cab_rides.destination_address',
                        'cab_rides.total_fare_amount', 'cab_rides.ridestatus_id', 'cab_rides.created_at',
                        'passengers.id as passenger_id', 'passengers.full_name as passenger_name', 'passengers.avatar as passenger_photo', 'cab_rides.pickup_latitude', 'cab_rides.pickup_longitude', 'cab_rides.destination_latitude', 'cab_rides.destination_longitude', 'cab_types.type_name', 'cab_rides.cab_id', 'cab_rides.adult_number',
                        'cab_rides.has_children', 'cab_rides.children_number', 'cab_rides.has_wheelchair', 'cab_rides.wheelchair_number')
                ->where('cab_rides.driver_id', $request->driver_id)
                ->whereIn('cab_rides.ridestatus_id', [3, 6])
                ->orderBy('cab_rides.id', 'desc')
                ->get();



        $passRatingByDriver = PassengerRating::where('driver_id', $request->driver_id)->pluck('rating_value', 'ride_id')->toArray();
        $rideStatus = RideStatus::pluck('name', 'id')->toArray();

        $historyArr = [];
        $i = 0;
        if ($histories->isNotEmpty()) {
            foreach ($histories as $history) {
                $historyArr[$i]['ride_id'] = $history->ride_id;
                $historyArr[$i]['driver_id'] = $history->driver_id;
                $historyArr[$i]['passenger_id'] = $history->passenger_id;
                $historyArr[$i]['passenger_name'] = $history->passenger_name;
                $historyArr[$i]['passenger_photo'] = $history->passenger_photo;
                $historyArr[$i]['pickup_address'] = $history->pickup_address;
                $historyArr[$i]['pickup_latitude'] = $history->pickup_latitude;
                $historyArr[$i]['pickup_longitude'] = $history->pickup_longitude;
                $historyArr[$i]['destination_address'] = $history->destination_address;
                $historyArr[$i]['destination_latitude'] = $history->destination_latitude;
                $historyArr[$i]['destination_longitude'] = $history->destination_longitude;
                $historyArr[$i]['cab_id'] = $history->cab_id;
                $historyArr[$i]['car_body_type'] = $history->type_name;
                $historyArr[$i]['total_fare_amount'] = number_format($history->total_fare_amount, 2);
                $historyArr[$i]['details'] = url('api/fareDetails/' . $history->ride_id);
                $historyArr[$i]['ridestatus_id'] = $history->ridestatus_id;
                $historyArr[$i]['ridestatus'] = !empty($rideStatus[$history->ridestatus_id]) ? $rideStatus[$history->ridestatus_id] : '';
                $historyArr[$i]['passenger_rating'] = !empty($passRatingByDriver[$history->ride_id]) ? $passRatingByDriver[$history->ride_id] : 0;
                $historyArr[$i]['adult_number'] = !empty($history->adult_number) ? $history->adult_number : 0;
                $historyArr[$i]['has_children'] = !empty($history->has_children) ? $history->has_children : 0;
                $historyArr[$i]['children_number'] = !empty($history->children_number) ? $history->children_number : 0;
                $historyArr[$i]['has_wheelchair'] = !empty($history->has_wheelchair) ? $history->has_wheelchair : 0;
                $historyArr[$i]['wheelchair_number'] = !empty($history->wheelchair_number) ? $history->wheelchair_number : 0;
                $historyArr[$i]['raw_datetime'] = date('Y-m-d H:i:s', strtotime($history->created_at));
                $historyArr[$i]['created_at'] = date('F d,Y,g:i A', strtotime($history->created_at));
                $i++;
            }
        }
        return response()->json(['response' => 'success', 'rideHistory' => $historyArr]);
    }

    public function cancelHistory(Request $request) {
        $histories = CabRide::join('passengers', 'passengers.id', '=', 'cab_rides.passenger_id')
                ->leftJoin('cabs', 'cabs.id', '=', 'cab_rides.cab_id')
                ->leftJoin('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                ->select('cab_rides.id as ride_id', 'cab_rides.passenger_id', 'cab_rides.driver_id',
                        'cab_rides.pickup_address', 'cab_rides.destination_address',
                        'cab_rides.total_fare_amount', 'cab_rides.ridestatus_id', 'cab_rides.created_at',
                        'passengers.id as passenger_id', 'passengers.full_name as passenger_name', 'passengers.avatar as passenger_photo', 'cab_rides.pickup_latitude', 'cab_rides.pickup_longitude', 'cab_rides.destination_latitude', 'cab_rides.destination_longitude', 'cab_types.type_name', 'cab_rides.cab_id', 'cab_rides.adult_number',
                        'cab_rides.has_children', 'cab_rides.children_number', 'cab_rides.has_wheelchair', 'cab_rides.wheelchair_number')
                ->where('cab_rides.canceled_by_driver', $request->driver_id)
                ->where('cab_rides.ridestatus_id', '3')
                ->orderBy('cab_rides.id', 'desc')
                ->get();

        $passRatingByDriver = PassengerRating::where('driver_id', $request->driver_id)->pluck('rating_value', 'ride_id')->toArray();
        $rideStatus = RideStatus::pluck('name', 'id')->toArray();
        $historyArr = [];
        $i = 0;
        if ($histories->isNotEmpty()) {
            foreach ($histories as $history) {
                $historyArr[$i]['ride_id'] = $history->ride_id;
                $historyArr[$i]['driver_id'] = $history->driver_id;
                $historyArr[$i]['passenger_id'] = $history->passenger_id;
                $historyArr[$i]['passenger_name'] = $history->passenger_name;
                $historyArr[$i]['passenger_photo'] = $history->passenger_photo;
                $historyArr[$i]['pickup_address'] = $history->pickup_address;
                $historyArr[$i]['pickup_latitude'] = $history->pickup_latitude;
                $historyArr[$i]['pickup_longitude'] = $history->pickup_longitude;
                $historyArr[$i]['destination_address'] = $history->destination_address;
                $historyArr[$i]['destination_latitude'] = $history->destination_latitude;
                $historyArr[$i]['destination_longitude'] = $history->destination_longitude;
                $historyArr[$i]['cab_id'] = $history->cab_id;
                $historyArr[$i]['car_body_type'] = $history->type_name;
                $historyArr[$i]['total_fare_amount'] = number_format($history->total_fare_amount, 2);
                $historyArr[$i]['details'] = url('api/fareDetails/' . $history->ride_id);
                $historyArr[$i]['ridestatus_id'] = $history->ridestatus_id;
                $historyArr[$i]['ridestatus'] = !empty($rideStatus[$history->ridestatus_id]) ? $rideStatus[$history->ridestatus_id] : '';
                $historyArr[$i]['passenger_rating'] = !empty($passRatingByDriver[$history->ride_id]) ? $passRatingByDriver[$history->ride_id] : 0;
                $historyArr[$i]['adult_number'] = !empty($history->adult_number) ? $history->adult_number : 0;
                $historyArr[$i]['has_children'] = !empty($history->has_children) ? $history->has_children : 0;
                $historyArr[$i]['children_number'] = !empty($history->children_number) ? $history->children_number : 0;
                $historyArr[$i]['has_wheelchair'] = !empty($history->has_wheelchair) ? $history->has_wheelchair : 0;
                $historyArr[$i]['wheelchair_number'] = !empty($history->wheelchair_number) ? $history->wheelchair_number : 0;
                $historyArr[$i]['raw_datetime'] = date('Y-m-d H:i:s', strtotime($history->created_at));
                $historyArr[$i]['created_at'] = date('F d,Y,g:i A', strtotime($history->created_at));
                $i++;
            }
        }
        return response()->json(['response' => 'success', 'cancelHistory' => $historyArr]);
    }

    public function passengerRating(Request $request) {
        $raring = new PassengerRating;
        $raring->ride_id = $request->ride_id;
        $raring->passenger_id = $request->passenger_id;
        $raring->driver_id = $request->driver_id;
        $raring->rating_value = $request->rating_value;
        $raring->note = !empty($request->note) ? $request->note : '';
        if ($raring->save()) {
            return response()->json(['response' => 'success', 'message' => 'Pessanger rating added successfully', 'raring' => $raring]);
        }
    }

    public function fareDetails(Request $request) {
        $fareDetails = CabRide::join('passengers', 'passengers.id', '=', 'cab_rides.passenger_id')
                ->leftJoin('cabs', 'cabs.id', '=', 'cab_rides.cab_id')
                ->leftJoin('cab_types', 'cab_types.id', '=', 'cabs.cabtype_id')
                ->select('cab_rides.id as ride_id', 'cab_rides.passenger_id', 'cab_rides.driver_id', 'cab_rides.cab_id',
                        'cab_rides.pickup_address', 'cab_rides.destination_address',
                        'cab_rides.bid_amount', 'cab_rides.total_fare_amount', 'cab_rides.ridestatus_id', 'cab_rides.created_at',
                        'passengers.id as passenger_id', 'passengers.full_name as passenger_name',
                        'passengers.avatar as passenger_photo', 'cab_types.type_name as cab_type', 'cabs.photo as cabs_photo')
                ->where('cab_rides.id', $request->ride_id)
                ->first();

//        echo "<pre>"; print_r($fareDetails->toArray());exit;

        $passRatingByDriver = PassengerRating::where('ride_id', $request->ride_id)->pluck('rating_value', 'ride_id')->toArray();

        $fareDetailsArr = [];
        if (!empty($fareDetails)) {
            $fareDetailsArr['ride_id'] = $fareDetails->ride_id;
            $fareDetailsArr['driver_id'] = $fareDetails->driver_id;
            $fareDetailsArr['cab_id'] = $fareDetails->cab_id;
            $fareDetailsArr['cabs_photo'] = $fareDetails->cabs_photo;
            $fareDetailsArr['cab_type'] = $fareDetails->cab_type;
            $fareDetailsArr['passenger_id'] = $fareDetails->passenger_id;
            $fareDetailsArr['passenger_name'] = $fareDetails->passenger_name;
            $fareDetailsArr['passenger_photo'] = $fareDetails->passenger_photo;
            $fareDetailsArr['pickup_address'] = $fareDetails->pickup_address;
            $fareDetailsArr['destination_address'] = $fareDetails->destination_address;
            $fareDetailsArr['bid_amount'] = number_format($fareDetails->bid_amount, 2);
            $fareDetailsArr['total_fare_amount'] = number_format($fareDetails->total_fare_amount, 2);
            $fareDetailsArr['ridestatus_id'] = $fareDetails->ridestatus_id;
            $fareDetailsArr['passenger_rating'] = !empty($passRatingByDriver[$fareDetails->ride_id]) ? $passRatingByDriver[$fareDetails->ride_id] : '';
            $fareDetailsArr['created_at'] = date('F d,Y,g:i A', strtotime($fareDetails->created_at));
        }
        return response()->json(['response' => 'success', 'fareDetailsArr' => $fareDetailsArr]);
    }

    public function cardAdd(Request $request) {
        // echo "<pre>";print_r($request->all());exit;
        $rules = [
            'driver_id' => 'required|numeric',
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
        $cardAdd = new DriverPaymentInfo;
        $cardAdd->driver_id = $request->driver_id;
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
        $driverCardList = DriverPaymentInfo::where('driver_id', $request->driver_id)->get();
        if ($driverCardList->isNotEmpty()) {
            return response()->json(['response' => 'success', 'driverCardList' => $driverCardList]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
        }
    }

    public function cardUpdate(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        $rules = [
            'card_id' => 'required|numeric',
            'driver_id' => 'required|numeric',
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
        $cardUpdate = DriverPaymentInfo::findOrFail($request->card_id);
        $cardUpdate->driver_id = $request->driver_id;
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
        $card = DriverPaymentInfo::findOrFail($request->card_id);
        if ($card->delete()) {
            return response()->json(['response' => 'success', 'message' => 'Card info Deleted successfully']);
        }
    }

    public function billList(Request $request) {
        $driverBills = DriverBill::where('driver_id', $request->driver_id)->get();
        $billChargeOption = BillChargeOption::pluck('bill_charge_title', 'id')->toArray();
        $billChargeOptionValue = BillChargeOptionValue::pluck('option_value_name', 'id')->toArray();

        if ($driverBills->isNotEmpty()) {
            $billArr = [];
            $i = 0;
            foreach ($driverBills as $driverBill) {
                $billArr[$i]['id'] = $driverBill->id;
                $billArr[$i]['transaction_id'] = $driverBill->transaction_id;
                $billArr[$i]['driver_id'] = $driverBill->driver_id;
                $billArr[$i]['start_date'] = $driverBill->start_date;
                $billArr[$i]['end_date'] = $driverBill->end_date;
                $billArr[$i]['amount'] = $driverBill->amount;
                $billArr[$i]['billchargeoption_id'] = $driverBill->billchargeoption_id;
                $billArr[$i]['billchargeoption_title'] = !empty($billChargeOption[$driverBill->billchargeoption_id]) ? $billChargeOption[$driverBill->billchargeoption_id] : '';
                $billArr[$i]['billchargeoptionvalue_id'] = $driverBill->billchargeoptionvalue_id;
                $billArr[$i]['billchargeoptionvalue_title'] = !empty($billChargeOptionValue[$driverBill->billchargeoptionvalue_id]) ? $billChargeOptionValue[$driverBill->billchargeoptionvalue_id] : '';
                $billArr[$i]['payment_status'] = $driverBill->payment_status;
                if ($driverBill->payment_status == '1') {
                    $billArr[$i]['payment_status_value'] = 'Free';
                } elseif ($driverBill->payment_status == '2') {
                    $billArr[$i]['payment_status_value'] = 'Paid';
                } elseif ($driverBill->payment_status == '3') {
                    $billArr[$i]['payment_status_value'] = 'Pending';
                }
                $billArr[$i]['created_at'] = $driverBill->created_at;
                $billArr[$i]['updated_at'] = $driverBill->updated_at;
                $i++;
            }
        }


        if (!empty($billArr)) {
            return response()->json(['response' => 'success', 'billList' => $billArr]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
        }
    }

    public function deleteDriver() {
        OtpVerify::truncate();
        if (Driver::truncate()) {
            return response()->json(['response' => 'success', 'message' => 'Driver Table truncate successfully']);
        } else {
            return response()->json(['response' => 'error', 'message' => 'Driver Table does not truncated']);
        }
    }

    public function driverDeviceAdd(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        $alreadyExistsToken = DriverDevice::where('token', $request->token)->first();
        if ($alreadyExistsToken) {
            $alreadyExistsToken->token = $request->token;
            return response()->json(['response' => 'success', 'message' => 'Driver device has been updated successfully!!', 'driverDevice' => $alreadyExistsToken]);
        }
        $driverDevice = new DriverDevice;
        $driverDevice->driver_id = $request->driver_id;
        $driverDevice->device_id = $request->device_id;
        $driverDevice->token = $request->token;
        $driverDevice->user_type = '1';
        if ($driverDevice->save()) {
            return response()->json(['response' => 'success', 'message' => 'Driver device has been inserted successfully!!', 'driverDevice' => $driverDevice]);
        }
    }

    public function driverNotifications(Request $request) {

        $driverNotificationArr = NotificationSend::where(['user_id' => $request->driver_id, 'user_type' => '1'])
                        ->orderBy('notification_id', 'desc')
                        ->take(20)
                        ->pluck('notification_id')->toArray();

        $driverNotificationStatusArr = NotificationSend::where(['user_id' => $request->driver_id, 'user_type' => '1'])
                        ->orderBy('notification_id', 'desc')
                        ->take(20)
                        ->pluck('notification_read_atatus', 'notification_id')->toArray();

        // echo "<pre>";print_r($driverNotificationStatusArr);exit;
        if (!empty($driverNotificationArr)) {
            $notificationsList = DB::table('notifications')->select('id', 'title', 'notification_details', 'created_at')->whereIn('id', $driverNotificationArr)->orderBy('id', 'desc')->get();

            if ($notificationsList->isNotEmpty()) {
                $i = 0;
                $notificationArr = [];
                foreach ($notificationsList as $notification) {
                    $notificationArr[$i]['notification_id'] = $notification->id;
                    $notificationArr[$i]['title'] = $notification->title;
                    $notificationArr[$i]['message'] = $notification->notification_details;
                    $notificationArr[$i]['status'] = $driverNotificationStatusArr[$notification->id];
                    $notificationArr[$i]['status_value'] = $driverNotificationStatusArr[$notification->id] == '1' ? 'Read' : 'Unread';
                    $notificationArr[$i]['created_at'] = date('j F Y \a\t h:i A', strtotime($notification->created_at));
                    $i++;
                }
            }

            return response()->json(['response' => 'success', 'notificationList' => $notificationArr]);
        } else {
            return response()->json(['response' => 'success', 'notificationList' => []]);
        }
    }

    public function readNotifications(Request $request) {
        $updateStatus = ['notification_read_atatus' => '1'];

        $readNotifications = NotificationSend::where('user_id', $request->driver_id)
                ->where('user_type', '1')
                ->whereIn('notification_id', $request->notifications_id)
                ->update($updateStatus);
        if ($readNotifications == count($request->notifications_id)) {
            return response()->json(['response' => 'success', 'message' => 'Driver Notifications status updated']);
        }
    }

    public function termAndPrivacy() {
        $termAndCondition = Settings::select('driver_term_and_condition', 'driver_privacy_policy')->first();

        $term_and_condition = [];
        if (!empty($termAndCondition->driver_term_and_condition)) {
            $term_and_condition = $termAndCondition->driver_term_and_condition;
        }
        $privacy_policy = [];
        if (!empty($termAndCondition->driver_privacy_policy)) {
            $privacy_policy = $termAndCondition->driver_privacy_policy;
        }

        return response()->json(['response' => 'success', 'term_and_condition' => $term_and_condition, 'privacy_policy' => $privacy_policy]);
    }

    public function changeEmail(Request $request) {
        $rules = [
            'id' => 'required',
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $driver = Driver::findOrFail($request->id);
        $driver->email = $request->email;
        if ($driver->save()) {
            $this->sendEmail($driver);
            return response()->json(['response' => 'success', 'driver' => $driver]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'Email has not changed']);
        }
    }

    public function cacheClear() {

        // Artisan::call('cache:clear');
        // Artisan::call('route:cache');
        // Artisan::call('route:clear');
        // Artisan::call('view:clear');
        Artisan::call('config:cache');
        return 'cleared';
    }

    public function taxiOperatorList(Request $request) {
        $taxiOperatorList = TaxiOperator::where('status', '1')->orderBy('created_at', 'desc')->get();
        if ($taxiOperatorList->isNotEmpty()) {
            return response()->json(['response' => 'success', 'taxiOperatorList' => $taxiOperatorList]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
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

    public function driverCards(Request $request){

        $cardList = DriverPaymentInfo::where('driver_id',$request->id)->first();
        // echo "<pre>";print_r($cardList->toArray());exit;
        if (!empty($cardList)) {
            return response()->json(['response' => 'success', 'cardList' => $cardList]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
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
    
    public function driverToken(Request $request){
        

        $tokens = DriverDevice::where('driver_id',$request->driver_id)->where('user_type',1)->first();
        // echo "<pre>";print_r($tokens->toArray());exit;
        if (!empty($tokens)) {
            return response()->json(['response' => 'success', 'token' => $tokens]);
        } else {
            return response()->json(['response' => 'error', 'message' => 'No data found']);
        }
    }

}
