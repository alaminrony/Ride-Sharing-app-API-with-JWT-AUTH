<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<td>Type name</td>
			<td>{{$cabtype->type_name}}</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>{{$cabtype->description}}</td>
		</tr>
		<tr>
			<td>Created At</td>
			<td>{{datefunction($cabtype->created_at)}}</td>
		</tr>
		<tr>
			<td>Created By</td>
			<td>{{created_by($cabtype->created_by)}}</td>
		</tr>
	</table>
</div>