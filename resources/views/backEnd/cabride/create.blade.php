@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'createPassenger'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CREATE')  @lang('lang.PASSENGER' ) <i class="nc-icon nc-single-02"></i></h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open(['route' => 'passenger.store','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                        @csrf
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('first_name',old('first_name'),['class' => 'form-control','placeholder' =>Lang::get('lang.First_Name')]) !!}
                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('last_name',old('last_name'),['class' => 'form-control','placeholder' =>Lang::get('lang.Last_Name')]) !!}
                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                                
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
                       
                        <div class="form-check text-left">
                            <label class="form-check-label">
                                {!! Form::checkbox('notify','1',false,['class'=>'form-check-input']) !!}
                                <span class="form-check-sign"></span>
                                @lang('lang.NOTIFY_USER')
                            </label>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Submit') }}</button>
                            <a href="{{route('passenger.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection