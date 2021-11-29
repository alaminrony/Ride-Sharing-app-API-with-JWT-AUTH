<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<td>First Name</td>
			<td>{{$passenger->full_name}}</td>
		</tr>
		{{-- <tr>
			<td>Last Name</td>
			<td>{{$passenger->p_last_name}}</td>
		</tr> --}}
		<tr>
			<td>Gender</td>
			<td>{{($passenger->gender ==1)?'Male' : 'Female'}}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>{{$passenger->email}}</td>
		</tr>
		<tr>
			<td>Phone</td>
			<td>{{$passenger->phone}}</td>
		</tr>
		<tr>
			<td>Register ip address</td>
			<td>{{$passenger->ip_address}}</td>
		</tr>
		{{-- <tr>
			<td>Last ip address</td>
			<td>{{$passenger->ip_address}}</td>
		</tr> --}}
		<tr>
			<td>Created At</td>
			<td>{{datefunction($passenger->created_at)}}</td>
		</tr>
		<tr>
			<td>Created by</td>
			<td>{{created_by($passenger->created_by)}}</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>{{status($passenger->active)}}</td>
		</tr>
	</table>
</div>