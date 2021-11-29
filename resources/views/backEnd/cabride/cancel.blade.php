@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'ridecancel'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CANCEL') @lang('lang.RIDE')</h3>
                        </div>
                        <div class="col-4 text-right">
                            {{-- <a href="{{route('cab-ride.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_PASSENGER')</a> --}}
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
                                <th scope="col">@lang('lang.DRIVER_NAME')</th>
                                <th scope="col">@lang('lang.PASSENGER')</th>
                                <th scope="col">@lang('lang.DISCOUNT')</th>
                                <th scope="col">@lang('lang.BID_AMOUNT')</th>
                                <th scope="col">@lang('lang.STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rideCancels as $rideCancel)
                            <tr>
                                <td>{{$rideCancel->driver->full_name}}</td>
                                <td>{{$rideCancel->passenger->full_name}}</td>
                                <td>{{$rideCancel->cabride->discount_percent}}%</td>
                                <td>{{$rideCancel->cabride->bid_amount}}</td>
                                <td>{{$rideCancel->ridestatus->name}}</td>
                            
                               
                                <td>
                                    <form action="{{ route('ride-cancel.destroy',$rideCancel->id) }}" method="POST">
                                       {{--  <a class="btn btn-sm btn-primary" href="{{ route('cab-ride.show',$rideCancel->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a> --}}
                                        <div class=" btn-group">
                                        <a class="btn btn-sm btn-info" title="details" onclick="show({{$rideCancel->id}})" href="#">
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

{{-- modal start --}}
<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
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
{{-- modal end --}}

<script>
    function show(id) {
        var id = id;
        $('#details').modal('show');
        $.get("{{route('ride-cancel.index')}}" +'/' + id, function(data){
            $('.modal-body').html(data);
            console.log(data);
    // alert("Data: " + data );
  });
    }
</script>
@endsection