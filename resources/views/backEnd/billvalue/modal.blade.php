 {!! Form::open(['route' =>[ 'bill-options-value.update',$chargeoptionvalue->id],'method' => 'put','id'=>'optionValueForm']) !!}
                @csrf
                <div class="">
                    <div class="form-group ">
                        <label>@lang('lang.OPTION_TITLE')</label>
                        {!! Form::select('billchargeoption_id',$options,$chargeoptionvalue->billchargeoption_id,['required'=>'required','class' => 'form-control','id'=>'bill_charge_option_id','placeholder' =>Lang::get('lang.OPTION_TITLE')]) !!}
                        <input type="hidden" name="id" value="{{$chargeoptionvalue->id}}">
                    </div>
                    <div class="form-group ">
                        <label>@lang('lang.OPTION_VALUE_TITLE')</label>
                        {!! Form::text('option_value_name',$chargeoptionvalue->option_value_name,['required'=>'required','class' => 'form-control','id'=>'option_value_name','placeholder' =>Lang::get('lang.OPTION_VALUE_TITLE')]) !!}
                    </div>
                    <div class="form-group ">
                        <label>@lang('lang.STATUS')</label>
                        {!! Form::select('status', ['0' => 'Inactive', '1' => 'Active'],$chargeoptionvalue->option_value_status,['required'=>'required','class'=>'form-control','id'=>'status','placeholder'=> 'Status'])!!}
                    </div>
                </div>
                
                <div class="modal-footer ">
                    <button type="submit" class="submit btn btn-info btn-round">{{ __('Submit') }}</button>
                    
                    <button type="button" class="btn btn-warning btn-round" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}