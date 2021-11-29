@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'cancelissue'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.EDIT')  @lang('lang.ISSUE')
                        </div>
                    </div>
                  
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                    {!! Form::open( ['route' => ['cancel-issue.update', $cancelIssue->id],'enctype'=>'multipart/form-data']) !!}
                     {{ method_field('PATCH') }}
                        @csrf
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-question-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('app_id', ['1' => 'Driver', '2' => 'Passenger'],$cancelIssue->app_id,['class'=>'form-control','placeholder'=> Lang::get('lang.APP_TYPE')])!!}
                                @if ($errors->has('app_id'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('app_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
{{-- 
                        <div class="row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-question-circle"></i>
                                    </span>
                                </div>
                                {!! Form::select('scene_name', ['0' => 'sckin'],$cancelIssue->scene_name,['class'=>'form-control','placeholder'=> Lang::get('lang.SCKIN_NAME')])!!}
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
                                {!! Form::text('cancel_issue_type',$cancelIssue->cancel_issue_type,['class' => 'form-control','placeholder' =>Lang::get('lang.CANCEL_ISSUE')]) !!}
                                @if ($errors->has('cancel_issue_type'))
                                <span class="invalid-feedback" style="display: block;" role="cancel_issue_type">
                                    <strong>{{ $errors->first('cancel_issue_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Update') }}</button>
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