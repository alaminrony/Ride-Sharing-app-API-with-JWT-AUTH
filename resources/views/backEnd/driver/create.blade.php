@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'createDriver'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CREATE')  @lang('lang.DRIVER' ) <i class="nc-icon nc-single-02"></i></h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open(['route' => 'driver.store','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                        @csrf
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('full_name',old('full_name'),['class' => 'form-control','placeholder' =>Lang::get('lang.NAME')]) !!}
                                @if ($errors->has('full_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('full_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                               {{--  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('last_name',old('last_name'),['class' => 'form-control','placeholder' =>Lang::get('lang.Last_Name')]) !!}
                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif --}}
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </div>
                                {!! Form::text('phone',old('phone'),['class' => 'form-control','placeholder' =>Lang::get('lang.PHONE')]) !!}
                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                                
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-email-85"></i>
                                    </span>
                                </div>
                                {!! Form::email('email',old('email'),['class' => 'form-control','placeholder' =>Lang::get('lang.EMAIL')]) !!}
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="fa fa-map-marker"></i>
                                    </span>
                                </div>
                                {!! Form::text('address',old('address'),['class' => 'form-control','placeholder' =>Lang::get('lang.ADDRESS')]) !!}
                                @if ($errors->has('address'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-table"></i>
                                    </span>
                                </div>
                                {!! Form::date('date_of_birth',old('date_of_birth'),['class' => 'form-control','title' =>Lang::get('lang.D_O_B')]) !!}
                                @if ($errors->has('date_of_birth'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('date_of_birth') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- driving licence --}}
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                       <i class="fa fa-table"></i>
                                    </span>
                                </div>
                                {!! Form::text('driving_licence_no',old('   driving_licence_no'),['class' => 'form-control','placeholder' =>Lang::get('lang.D_L_NUMBER')]) !!}
                                @if ($errors->has('driving_licence_no'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('driving_licence_no') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-table"></i>
                                    </span>
                                </div>
                                {!! Form::date('driving_licence_expire_date',old('driving_licence_expire_date'),['class' => 'form-control','title' =>Lang::get('lang.D_L_E_D')]) !!}
                                @if ($errors->has('driving_licence_expire_date'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('driving_licence_expire_date') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>
                        {{-- taxi --}}
                         <div class="row">
                           {{--  <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                       <i class="fa fa-table"></i>
                                    </span>
                                </div>
                                {!! Form::text('cab_driver_no',old('cab_driver_no'),['class' => 'form-control','placeholder' =>Lang::get('lang.TAXI_DRIVER_NO')]) !!}
                                @if ($errors->has('cab_driver_no'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('cab_driver_no') }}</strong>
                                </span>
                                @endif
                            </div> --}}
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-table"></i>
                                    </span>
                                </div>
                                {!! Form::text('australian_taxi_licence_no',old('australian_taxi_licence_no'),['class' => 'form-control','placeholder' =>Lang::get('lang.A_T_L_N')]) !!}
                                @if ($errors->has('australian_taxi_licence_no'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('australian_taxi_licence_no') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-table"></i>
                                    </span>
                                </div>
                                {!! Form::date('australian_taxi_licence_expire_date',old('australian_taxi_licence_expire_date'),['class' => 'form-control','title' =>Lang::get('lang.A_D_L_exp')]) !!}
                                @if ($errors->has('australian_taxi_licence_expire_date'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('australian_taxi_licence_expire_date') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('driver_type_id', $driverTypes ,null,['class'=>'form-control','placeholder'=> Lang::get('lang.DRIVER_TYPE')])!!}
                                @if ($errors->has('driver_type_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('driver_type_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-key-25"></i>
                                    </span>
                                </div>
                                {!! Form::password('password',['class' => 'form-control','placeholder' =>Lang::get('lang.PASSWORD')]) !!}
                                
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-key-25"></i>
                                    </span>
                                </div>
                                {!! Form::password('confirm_password',['class' => 'form-control','placeholder' =>Lang::get('lang.CON_PASSWORD')]) !!}
                                
                                @if ($errors->has('confirm_password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-venus-mars"></i>
                                    </span>
                                </div>
                                {!! Form::select('gender', ['1' => 'Male', '2' => 'Female'],null,['class'=>'form-control','placeholder'=> 'Select Gender'])!!}
                                @if ($errors->has('gender'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-question-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('status', ['0' => 'Inactive', '1' => 'Active'],null,['class'=>'form-control','placeholder'=> 'Status'])!!}
                                @if ($errors->has('status'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-image"></i>
                                    </span>
                                </div>
                                  {!! Form::file('avatar',['class' => 'form-control','placeholder' =>Lang::get('lang.PROFILE_PHOTO')]) !!}
                                @if ($errors->has('avatar'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-check text-left">
                            <label class="form-check-label">
                                {!! Form::checkbox('notify','1',false,['class'=>'form-check-input']) !!}
                                <span class="form-check-sign"></span>
                                @lang('lang.NOTIFY_USER')
                            </label>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Submit') }}</button>
                            <a href="{{route('driver.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection