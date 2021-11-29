@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'notification'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.EDIT')  @lang('lang.NOTIFICATION')<i class="fa fa-bell"></i></h3>
                        </div>
                    </div>
                    
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open( ['route' => ['notification.update', $notification->id],'enctype'=>'multipart/form-data']) !!}
                        {{ method_field('PATCH') }}
                        @csrf
                         <div class="row">
                             <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('title',$notification->title,['class' => 'form-control','placeholder' =>Lang::get('lang.TITLE')]) !!}
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
                                        {{-- <i class="nc-icon fa fa-tint"></i> --}}
                                        <i class="fa fa-paint-brush"></i>
                                    </span>
                                </div>
                                {!! Form::text('bg_color',$notification->bg_color,['class' => 'form-control jscolor','placeholder' =>Lang::get('lang.TITLE')]) !!}
                                @if ($errors->has('bg_color'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('bg_color') }}</strong>
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
                                {!! Form::text('icon_name',$notification->icon_name,['class' => 'form-control','placeholder' =>Lang::get('lang.ICON_NAME')]) !!}
                                @if ($errors->has('icon_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('icon_name') }}</strong>
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
                                {!! Form::textarea('notification_details',$notification->notification_details,['class' => 'form-control','placeholder' =>Lang::get('lang.NOTIFY_MESSAGE')]) !!}
                                @if ($errors->has('notification_details'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('notification_details') }}</strong>
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
                                {!! Form::select('type', ['0' => 'Driver', '1' => 'Passenger'],$notification->type,['class'=>'form-control','placeholder' =>Lang::get('lang.GROUP_BY')])!!}
                                @if ($errors->has('type'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Add Now') }}</button>
                            <a href="{{route('notification.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection