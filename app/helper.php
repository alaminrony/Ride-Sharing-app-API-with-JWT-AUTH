<?php
function status($status){
	$result = '';
if ($status == 0) {
	$result = 'Inactive';
}
elseif($status ==1){
	$result = 'Active';
}
echo $result;
}
function created_by($id){
	$user = DB::table('users')
			->where('id',$id)
	->first();
	$fullName = $user->first_name.' '.$user->last_name;
	echo $fullName;
}
function datefunction($date){
	echo date_format($date,"d-M-Y ");
}
function pickupDate($date){
	echo date_format(new DateTime($date),"d-M-Y h:i:s A");
}
function checkonline($value)
{
	$result= '';
	if ($value == 0) {
		$result = "<i class='fa fa-circle text-danger'></i>";
	}elseif($value == 1) {
		$result = "<i class='fa fa-circle text-success'></i>";
	}
	echo $result;
}
function time_subtract($datetime1,$datetime2)
{
	$datetime1 = strtotime($datetime1);
	$datetime2 = strtotime($datetime2);

	$secs = ($datetime2+109) - $datetime1;// == <seconds between the two times>
	$days = $secs / 3600;
	echo round($days,2);
}