@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'rideapps'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.EDIT')  @lang('lang.RIDE_APP')<i class="nc-icon nc-single-02"></i></h3>
                        </div>
                    </div>
                    
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open( ['route' => ['ride-apps.update', $rideApps->id],'enctype'=>'multipart/form-data']) !!}
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('name',$rideApps->name,['class' => 'form-control','placeholder' =>Lang::get('lang.NAME')]) !!}
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('ride_charge',$rideApps->ride_charge,['class' => 'form-control','placeholder' =>Lang::get('lang.RIDE_CHARGE')]) !!}
                                @if ($errors->has('ride_charge'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('ride_charge') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('waiting_charge',$rideApps->waiting_charge,['class' => 'form-control','placeholder' =>Lang::get('lang.WAITING_CHARGE')]) !!}
                                @if ($errors->has('waiting_charge'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('waiting_charge') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('per_km',$rideApps->per_km,['class' => 'form-control','placeholder' =>Lang::get('lang.PER_KM')]) !!}
                                @if ($errors->has('per_km'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('per_km') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-question-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('status', ['0' => 'Inactive', '1' => 'Active'],$rideApps->status,['class'=>'form-control','placeholder'=> 'Status'])!!}
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
                                {!! Form::file('logo',['class' => 'form-control','placeholder' =>Lang::get('lang.PROFILE_PHOTO')]) !!}
                                <img src="{{asset($rideApps->logo)}}" width="70px">
                                @if ($errors->has('logo'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Submit') }}</button>
                            <a href="{{route('ride-apps.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection