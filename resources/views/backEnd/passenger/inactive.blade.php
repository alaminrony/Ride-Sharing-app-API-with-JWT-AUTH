@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'InPassenger'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.PASSENGER')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('passenger.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_PASSENGER')</a>
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
                                <th scope="col">@lang('lang.FULL_NAME')</th>
                                {{-- <th scope="col">@lang('lang.Last_Name')</th> --}}
                                <th scope="col">@lang('lang.EMAIL')</th>
                                <th scope="col">@lang('lang.PHONE')</th>
                                <th scope="col">@lang('lang.ACTIVE')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($passengers as $passenger)
                            <tr>
                                <td>{{$passenger->full_name}}</td>
                                {{-- <td>{{$passenger->p_last_name}}</td> --}}
                                <td>{{$passenger->email}}</td>
                                <td>{{$passenger->phone}}</td>
                                <td>{{status($passenger->active)}}</td>
                                <td>
                                    <form action="{{ route('passenger.destroy',$passenger->id) }}" method="POST">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-primary" href="{{ route('passenger.edit',$passenger->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-info" onclick="show({{$passenger->id}})" href="#">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger" title="Add to Trash" onclick="return confirm('Are you sure')" href="{{ route('passenger.trash',$passenger->id) }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            {{--  @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure')" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                            </button> --}}
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$passengers->links()}}
            </div>
        </div>
    </div>
</div>
{{-- modal start--}}
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Passenger details</h5>
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
$.get("{{ route('passenger.index') }}" +'/'+ id , function (data) {
$('#detailsModal').modal('show');
$('.modal-body').html(data);
})
}
</script>
@endsection