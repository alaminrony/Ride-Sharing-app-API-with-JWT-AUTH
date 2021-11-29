@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'createBillsettings'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CREATE')  @lang('lang.BILL_SETTINGS' ) <i class="nc-icon nc-single-02"></i></h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open(['route' => 'bill-settings.store','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                        @csrf
                        <div class="row">
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('country_id', $countries ,null,['class'=>'form-control','placeholder'=> Lang::get('lang.COUNTRY')])!!}
                                @if ($errors->has('country_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                                @endif
                            </div>
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('billchargeoption_id', $billcharge_option ,null,['class'=>'form-control','id'=>'option_id','placeholder'=> Lang::get('lang.BILL_CHARGE_OPTION')])!!}
                                @if ($errors->has('billchargeoption_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('billchargeoption_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6 option_value" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                               {!! Form::select('billchargeoptionvalue_id',[''=>''] ,null,['class'=>'form-control','placeholder'=> Lang::get('lang.BILL_CHARGE_SUB_OPTION')])!!}
                                @if ($errors->has('billchargeoptionvalue_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('billchargeoptionvalue_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('charge_value',old('charge_value'),['class' => 'form-control','placeholder' =>Lang::get('lang.CHARGE_AMOUNT')]) !!}
                                @if ($errors->has('charge_value'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('charge_value') }}</strong>
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
                                {!! Form::text('bill_days',old('bill_days'),['class' => 'form-control','placeholder' =>Lang::get('lang.HOW_MANY_DAYS_BILL')]) !!}
                                @if ($errors->has('bill_days'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('bill_days') }}</strong>
                                </span>
                                @endif
                            </div>
                        
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                       <i class="fa fa-table"></i>
                                    </span>
                                </div>
                               {!! Form::text('trial_period',old('trial_period'),['class' => 'form-control','placeholder' =>Lang::get('lang.TRIAL_PERIOD')]) !!}
                                @if ($errors->has('trial_period'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('trial_period') }}</strong>
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
                                  {!! Form::text('ride_request_cancel_time',old('ride_request_cancel_time'),['class' => 'form-control','placeholder' =>Lang::get('lang.RIDE_REQUEST_CANCEL_TIME')]) !!}
                                @if ($errors->has('ride_request_cancel_time'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('ride_request_cancel_time') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-image"></i>
                                    </span>
                                </div>
                                  {!! Form::text('driver_fine_over_time',old('driver_fine_over_time'),['class' => 'form-control','placeholder' =>Lang::get('lang.DRIVER_FINE_OVER_TIME')]) !!}
                                @if ($errors->has('driver_fine_over_time'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('driver_fine_over_time') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <diiv class="row">
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-image"></i>
                                    </span>
                                </div>
                                  {!! Form::text('driver_fine_amount',old('driver_fine_amount'),['class' => 'form-control','placeholder' =>Lang::get('lang.DRIVER_FINE_AMOUNT')]) !!}
                                @if ($errors->has('driver_fine_amount'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('driver_fine_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-image"></i>
                                    </span>
                                </div>
                                  {!! Form::text('passenger_fine_over_time',old('passenger_fine_over_time'),['class' => 'form-control','placeholder' =>Lang::get('lang.PASSENGER_FINE_OVER_TIME')]) !!}
                                @if ($errors->has('passenger_fine_over_time'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('passenger_fine_over_time') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-image"></i>
                                    </span>
                                </div>
                                  {!! Form::text('passenger_fine_amount',old('passenger_fine_amount'),['class' => 'form-control','placeholder' =>Lang::get('lang.PASSENGER_FINE_AMOUNT')]) !!}
                                @if ($errors->has('passenger_fine_amount'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('passenger_fine_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Add Now') }}</button>
                            <a href="{{route('bill-settings.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#option_id').on('change',function() {
        var option_id = $('#option_id').val();
        var option =[];
        $.ajax({
            method: "get",
           
            url: "{{ route('bill-settings.option') }}",
            
            data:{option_id:option_id},
            dataType:'html',
            success:function(data){
              $('.option_value').html(data);
                // console.log(data);
                // alert(data);
            }
        });
    })
</script>
@endsection