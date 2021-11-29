@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'Driver'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.DRIVER')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('driver.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_DRIVER')</a>
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
                                <th scope="col">@lang('lang.NAME')</th>
                                <th scope="col">@lang('lang.RATINGS')</th>
                                <th scope="col">@lang('lang.EMAIL')</th>
                                <th scope="col">@lang('lang.PHONE')</th>
                                <th scope="col">@lang('lang.DRIVER_TYPE')</th>
                                <th scope="col">@lang('lang.ON_OF_LINE')</th>
                                <th scope="col">@lang('lang.ACTIVE')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $driver)
                            <tr>
                                <td>{{$driver->full_name}}</td>
                                <td>{{$driver->ratings}}</td>
                                <td>{{$driver->email}}</td>
                                <td>{{$driver->phone}}</td>
                                <td>{{$driver->driverType->option.' ( '.$driver->driverType->value.'$ )'}}</td>
                                {{-- <td>{{$driver->driver_type_id}}</td> --}}
                                <td>{{checkonline($driver->is_online)}}</td>
                                <td>{{status($driver->active)}}</td>
                                <td>
                                    <form action="{{ route('driver.destroy',$driver->id) }}" method="POST">
                                        <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('driver.edit',$driver->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-info" onclick="show({{$driver->id}})" href="#">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger" title="Add to Trash" onclick="return confirm('Are you sure')" href="{{ route('driver.trash',$driver->id) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a href="{{url('driver-bill/search?driver_id='.$driver->id)}}" class="btn btn-sm btn-primary" title="bill summery"><i class="  fa fa-certificate"></i></a>
                                        <a href="{{url('cab/driver/search?driver_id='.$driver->id)}}" class="btn btn-sm btn-info" title="cab list"><i class="  fa fa-certificate"></i></a>
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
                {{ $drivers->links() }}
            </div>
        </div>
    </div>
</div>
{{-- modal start--}}
<div class="modal fade" id="driverDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Driver details</h5>
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
$.get("{{ route('driver.index') }}" +'/' + id , function (data) {

$('#driverDetails').modal('show');
$('.modal-body').html(data);

})
}
</script>
@endsection