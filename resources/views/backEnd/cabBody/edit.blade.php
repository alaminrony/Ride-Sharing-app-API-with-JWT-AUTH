@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'cabBody'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.EDIT_BODY_TYPE')  <i class="nc-icon nc-single-02"></i></h3>
                        </div>
                    </div>
                    
                </div>
                <div class="table-responsive">
                    <div class="card-body ">
                        {!! Form::open( ['route' => ['cab-body-type.update', $cabtype->id],'methood'=>'POST']) !!}
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                {!! Form::text('type_name',$cabtype->type_name,['class' => 'form-control','placeholder' =>Lang::get('lang.TYPE_NAME')]) !!}
                                @if ($errors->has('type_name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('type_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{-- <i class="nc-icon nc-single-02"></i> --}}
                                        <i class="fa fa-paragraph"></i>
                                    </span>
                                </div>
                                {!! Form::textarea('description', $cabtype->description, ['class'=>'form-control','placeholder' =>Lang::get('lang.DESCRIPTION')]) !!}
                                @if ($errors->has('description'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                                
                            </div>
                        </div>
                           
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-info btn-round">{{ __('Update') }}</button>
                            <a href="{{route('cab-body-type.index')}}" class="btn btn-warning btn-round">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection