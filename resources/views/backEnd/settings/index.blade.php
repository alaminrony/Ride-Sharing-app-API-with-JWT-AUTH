@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'settings'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.EDIT')  @lang('lang.SETTINGS')<i class="fa fa-cog"></i></h3>
                        </div>
                    </div>
                    
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open( ['route' => ['settings.update', $settings->id],'enctype'=>'multipart/form-data']) !!}
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('site_name',$settings->site_name,['class' => 'form-control','placeholder' =>Lang::get('lang.site_name')]) !!}
                                @if ($errors->has('site_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('site_name') }}</strong>
                                </span>
                                @endif
                            </div>

                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('dateformat',$settings->dateformat,['class' => 'form-control','placeholder' =>Lang::get('lang.DATE_FORMAT')]) !!}
                                @if ($errors->has('dateformat'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('dateformat') }}</strong>
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
                               {!! Form::text('dateformat',$settings->dateformat,['class' => 'form-control','placeholder' =>Lang::get('lang.TEL')]) !!}
                                @if ($errors->has('dateformat'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('dateformat') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                               {!! Form::text('timeformat',$settings->timeformat,['class' => 'form-control','placeholder' =>Lang::get('lang.TIME_FORMAT')]) !!}
                                @if ($errors->has('timeformat'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('timeformat') }}</strong>
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
                                {!! Form::select('rows_per_page', ['10' => '10', '25' => '25','50' => '50', '100' => '100'],$settings->rows_per_page,['class'=>'form-control','placeholder'=>Lang::get('lang.ROW_PER_PAGE')])!!}
                                @if ($errors->has('rows_per_page'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('rows_per_page') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-email-85"></i>
                                    </span>
                                </div>
                                {!! Form::email('default_email',$settings->default_email,['class' => 'form-control','placeholder' =>Lang::get('lang.DEFAULT_EMAIL')]) !!}
                                @if ($errors->has('default_email'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('default_email') }}</strong>
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
                                @if($settings->logo)
                                <img src="{{asset($settings->logo)}}" width="70px">@endif
                                @if ($errors->has('logo'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Update') }}</button>
                          
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection