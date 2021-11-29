@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'rideapps'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.RIDE_APP')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('ride-apps.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD')</a>
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
                                <th scope="col">@lang('lang.LOGO')</th>
                                <th scope="col">@lang('lang.NAME')</th>
                                <th scope="col">@lang('lang.RIDE_CHARGE')</th>
                                <th scope="col">@lang('lang.WAITING_CHARGE')</th>
                                <th scope="col">@lang('lang.PER_KM')</th>
                                <th scope="col">@lang('lang.STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rideAppss as $rideApps)
                            <tr>
                                <td><img src="{{ asset($rideApps->logo) }}" width="70px"></td>
                                <td>{{$rideApps->name}}</td>
                                <td>{{$rideApps->ride_charge}}</td>
                                <td>{{$rideApps->waiting_charge}}</td>
                                <td>{{$rideApps->per_km}}</td>
                                <td>{{ status($rideApps->status) }}</td>
                                
                                <td>
                                    <form action="{{ route('ride-apps.destroy',$rideApps->id) }}" method="POST">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-primary" href="{{ route('ride-apps.edit',$rideApps->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-info" onclick="show({{$rideApps->id}})" href="#">
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
                {{ $rideAppss->links() }}
            </div>
        </div>
    </div>
</div>
{{-- modal start--}}
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ride Apps details</h5>
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
$.get("{{ route('ride-apps.index') }}" +'/'+ id , function (data) {
$('#detailsModal').modal('show');
$('.modal-body').html(data);
})
}
</script>
@endsection