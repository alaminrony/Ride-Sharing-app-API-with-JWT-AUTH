<table class="table table-striped">
	<tr>
		<td>Driver Name :</td>
		<td>{{$cabRide->driver->full_name}}</td>
	</tr>
	<tr>
		<td>Riding Time</td>
		<td>{{time_subtract($cabRide->start_time,$cabRide->end_time )}}H</td>
	</tr>
	<tr>
		<td>Distance</td>
		<td>{{$cabRide->riding_distance}}</td>
	</tr>
	<tr>
		<td>Pickup time</td>
		<td>{{pickupDate($cabRide->start_time)}}</td>
	</tr>
	<tr>
		<td>Destination time</td>
		<td>{{pickupDate($cabRide->end_time)}}</td>
	</tr>
	<tr>
		<td>Pickup address</td>
		<td>{{$cabRide->pickup_address}}</td>
	</tr>
	<tr>
		<td>Destination address</td>
		<td>{{$cabRide->destination_address}}</td>
	</tr>
	<tr>
		<td>Discount</td>
		<td>{{$cabRide->discount_percent}}</td>
	</tr>
	<tr>
		<td>Comment</td>
		<td>{{$cabRide->comment}}</td>
	</tr>
	<tr>
		<td>Ratting	</td>
		<td></td>
	</tr>
	<tr>
		<td>Created at	</td>
		<td>{{pickupDate($cabRide->created_at)}}</td>
	</tr>
	<tr>
		<td>Passenger Name :</td>
		<td>{{$cabRide->passenger->full_name}}</td>
	</tr>
</table>