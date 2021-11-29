<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<td>Name</td>
			<td>{{$rideApps->name}}</td>
		</tr>
		<tr>
			<td>Logo</td>
			<td><img src="{{asset($rideApps->logo)}}" width="100px"></td>
		</tr>
		<tr>
			<td>Ride Charge</td>
			<td>{{$rideApps->ride_charge}}</td>
		</tr>
		<tr>
			<td>Waiting Charge</td>
			<td>{{$rideApps->waiting_charge}}</td>
		</tr>
		<tr>
			<td>Created At</td>
			<td>{{datefunction($rideApps->created_at)}}</td>
		</tr>
		<tr>
			<td>Created by</td>
			<td>{{created_by($rideApps->created_by)}}</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>{{status($rideApps->status)}}</td>
		</tr>
	</table>
</div>