@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'createCab'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CREATE')  @lang('lang.CAB' ) <i class="nc-icon nc-single-02"></i></h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open(['route' => 'cab.store','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                        @csrf
                        <div class="row">
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('driver_id', $drivers ,null,['class'=>'form-control','placeholder'=> Lang::get('lang.DRIVER')])!!}
                                @if ($errors->has('driver_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('driver_id') }}</strong>
                                </span>
                                @endif
                            </div>
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('cabtype_id', $cabtypes ,null,['class'=>'form-control','placeholder'=> Lang::get('lang.BODY_TYPE')])!!}
                                @if ($errors->has('cabtype_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('cabtype_id') }}</strong>
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
                                {!! Form::text('number_plate',old('number_plate'),['class' => 'form-control','placeholder' =>Lang::get('lang.NUMBER_PLATE')]) !!}
                                @if ($errors->has('number_plate'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('number_plate') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('model_number',old('model_number'),['class' => 'form-control','placeholder' =>Lang::get('lang.MODEL')]) !!}
                                @if ($errors->has('model_number'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('model_number') }}</strong>
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
                                {!! Form::text('color',old('color'),['class' => 'form-control','placeholder' =>Lang::get('lang.COLOR')]) !!}
                                @if ($errors->has('color'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                       <i class="fa fa-table"></i>
                                    </span>
                                </div>
                                {!! Form::textarea('description',old('description'),['class' => 'form-control','placeholder' =>Lang::get('lang.DESCRIPTION')]) !!}
                                @if ($errors->has('description'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
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
                                  {!! Form::file('photo',['class' => 'form-control','placeholder' =>Lang::get('lang.PROFILE_PHOTO')]) !!}
                                @if ($errors->has('photo'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('photo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Add Now') }}</button>
                            <a href="{{route('cab.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection