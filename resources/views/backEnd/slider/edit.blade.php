@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'slider'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.EDIT')  @lang('lang.SLIDER')<i class="nc-icon nc-single-02"></i></h3>
                        </div>
                    </div>
                  
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                    {!! Form::open( ['route' => ['slider.update',$slider->id],'enctype'=>'multipart/form-data']) !!}
                     {{ method_field('PATCH') }}
                        @csrf
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('title',$slider->title,['class' => 'form-control','placeholder' =>Lang::get('lang.TITLE')]) !!}
                                @if ($errors->has('title'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
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
                                {!! Form::textarea('description',$slider->description,['class' => 'form-control','placeholder' =>Lang::get('lang.DESCRIPTION')]) !!}
                                @if ($errors->has('description'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                       {{--  <div class="row">
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-question-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('status', ['0' => 'Inactive', '1' => 'Active'],$mainSlider->status,['class'=>'form-control','placeholder'=> 'Status'])!!}
                                @if ($errors->has('status'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                                @endif
                            </div>
                       
                        </div> --}}
                       
                        <div class="row">
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-image"></i>
                                    </span>
                                </div>
                                  {!! Form::file('image',['class' => 'form-control','placeholder' =>Lang::get('lang.PROFILE_PHOTO')]) !!}
                                  <img src="{{asset($slider->image)}}" width="70px">
                                @if ($errors->has('image'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Update') }}</button>
                            <a href="{{route('slider.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection