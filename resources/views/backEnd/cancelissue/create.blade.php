@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'createcancelissue'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.ADD_ISSUE') 
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open(['route' => 'cancel-issue.store','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                        @csrf
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-question-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('app_id', ['1' => 'Driver', '2' => 'Passenger'],null,['class'=>'form-control','placeholder'=> Lang::get('lang.APP_TYPE')])!!}
                                @if ($errors->has('app_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('app_id') }}</strong>
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
                                {!! Form::select('scene_name', ['0' => 'sckin'],null,['class'=>'form-control','placeholder'=> Lang::get('lang.SCKIN_NAME')])!!}
                                @if ($errors->has('scene_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('scene_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('cancel_issue_type',old('cancel_issue_type'),['class' => 'form-control','placeholder' =>Lang::get('lang.CANCEL_ISSUE')]) !!}
                                @if ($errors->has('cancel_issue_type'))
                                <span class="invalid-feedback" style="display: block;" role="cancel_issue_type">
                                    <strong>{{ $errors->first('cancel_issue_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Submit') }}</button>
                            <a href="{{route('cancel-issue.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection