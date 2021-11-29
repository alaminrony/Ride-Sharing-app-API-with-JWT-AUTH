
	<div class="input-group-prepend">
		<span class="input-group-text">
			<i class="nc-icon nc-single-02"></i>
		</span>
	</div>
	{!! Form::select('billchargeoptionvalue_id',$billcharge_option_value ,null,['class'=>'form-control','placeholder'=> Lang::get('lang.BILL_CHARGE_SUB_OPTION')])!!}
	@if ($errors->has('billchargeoptionvalue_id'))
	<span class="invalid-feedback" style="display: block;" role="alert">
		<strong>{{ $errors->first('billchargeoptionvalue_id') }}</strong>
	</span>
	@endif
