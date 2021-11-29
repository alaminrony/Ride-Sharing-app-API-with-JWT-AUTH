<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<td>Body type</td>
			<td>{{$cab->cabType->type_name}}</td>
		</tr>
		<tr>
			<td>Driver</td>
			<td>{{$cab->driver->full_name}}</td>
		</tr>
		<tr>
			<td>Model</td>
			<td>{{$cab->model_number}}</td>
		</tr>
		<tr>
			<td>Color</td>
			<td>{{$cab->color}}</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>{{$cab->description}}</td>
		</tr>
	</table>
</div>