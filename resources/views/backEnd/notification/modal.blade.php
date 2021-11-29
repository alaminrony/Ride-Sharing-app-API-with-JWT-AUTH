<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<td>Title</td>
			<td>{{$notification->title}}</td>
		</tr>
		<tr>
			<td>Color</td>
			<td>{{$notification->bg_color}}</td>
		</tr>
		<tr>
			<td>Icon</td>
			<td>{{$notification->icon_name}}</td>
		</tr>
		<tr>
			<td>Details</td>
			<td>{{$notification->notification_details}}</td>
		</tr>
		<tr>
			<td>Created At</td>
			<td>{{datefunction($notification->created_at)}}</td>
		</tr>
		<tr>
			<td>Created by</td>
			<td>{{created_by($notification->created_by)}}</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>{{status($notification->status)}}</td>
		</tr>
	</table>
</div>