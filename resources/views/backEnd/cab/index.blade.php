@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'Cab'
])
@section('content')
<div class="content">
    <div class="card shadow">
        <div class="card-body">
            {!! Form::open(['route' => 'cab.dsearch','method' => 'get','enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class=" col-md-6">
                    <div class="row">
                        <div class="input-group col-md-12 pt-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user-circle"></i>
                                </span>
                            </div>
                            {!! Form::select('driver_id', $drivers ,isset($_GET['driver_id'])?$_GET['driver_id'] : null,['class'=>'form-control','placeholder'=> Lang::get('lang.DRIVER')])!!}
                            
                        </div>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    <button type="submit" class="btn btn-info btn-round">{{ __('Submit') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CAB')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('cab.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_CAB')</a>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">@lang('lang.BODY_TYPE')</th>
                                <th scope="col">@lang('lang.DRIVER')</th>
                                <th scope="col">@lang('lang.LICENSE')</th>
                                <th scope="col">@lang('lang.MODEL')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cabs as $cab)
                            <tr>
                                <td>{{ !empty($cab->cabType->type_name)?$cab->cabType->type_name : '' }}</td>
                                <td>{{ !empty($cab->driver->full_name)? $cab->driver->full_name : '' }}</td>
                                <td>{{$cab->number_plate}}</td>
                                <td>{{$cab->model_number}}</td>
                                <td>
                                    <form action="{{ route('cab.destroy',$cab->id) }}" method="POST">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-primary" href="{{ route('cab.edit',$cab->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-info" onclick="show({{$cab->id}})" href="#">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure')" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal start--}}
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cab details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- modal end--}}
<script>
function show(id) {
var id = id;
$.get("{{ route('cab.index') }}" +'/' + id , function (data) {
$('#detailsModal').modal('show');
$('.modal-body').html(data);
})
}
</script>
@endsection