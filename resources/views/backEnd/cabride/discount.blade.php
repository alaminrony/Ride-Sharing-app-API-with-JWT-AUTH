@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'cabridediscount'
])
@section('content')
<div class="content">
    <div class="card shadow">
       {!! Form::open(['url' => 'cab-ride/filter','method' => 'get','enctype' => 'multipart/form-data']) !!}
      
            <div class="row p-3">
                <div class="col-md-3">
                    <label>Status</label>
                   {!! Form::select('status_id', $ride_status ,isset($_GET['status_id'])?$_GET['status_id']:null,['class'=>'form-control','placeholder'=> Lang::get('lang.STATUS')])!!}
                </div>
                <div class="col-md-3">
                    <label>Driver</label>
                    {!! Form::select('driver_id', $drivers ,isset($_GET['driver_id'])?$_GET['driver_id']:null,['class'=>'form-control','placeholder'=> Lang::get('lang.DRIVER')])!!}
                </div>
                <div class="col-md-3">
                    <label>Passenger</label>
                   {!! Form::select('passenger_id', $passengers ,isset($_GET['passenger_id'])?$_GET['passenger_id']:null,['class'=>'form-control','placeholder'=> Lang::get('lang.PASSENGER')])!!}
                </div>
                <div class="col-md-3 pt-3">
                    <label> </label>
                    <input type="submit" name="" value="submit" class="btn btn-primary">
                </div>
            </div>
       {!! Form::close() !!}
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.RIDE')</h3>
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
                                <th scope="col">@lang('lang.PICK_UP_TIME')</th>
                                <th scope="col">@lang('lang.DESTINATION_TIME')</th>
                                <th scope="col">@lang('lang.DISTANCE_KM')</th>
                                <th scope="col">@lang('lang.DISCOUNT')</th>
                                <th scope="col">@lang('lang.BID_AMOUNT')</th>
                                <th scope="col">@lang('lang.STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cabrides as $cabride)
                            <tr>
                                <td>{{$cabride->driver->full_name}}</td>
                                <td>{{$cabride->passenger->full_name}}</td>
                                <td>{{pickupDate($cabride->start_time)}}</td>
                                <td>{{pickupDate($cabride->end_time)}}</td>
                                <td>{{$cabride->riding_distance}}</td>
                                <td>{{$cabride->discount_percent}}</td>
                                <td>{{$cabride->bid_amount}}</td>
                                <td>{{$cabride->ridestatus->name}}</td>
                            
                                <td>
                                    <form action="{{ route('cab-ride.destroy',$cabride->id) }}" method="POST">
                                       {{--  <a class="btn btn-sm btn-primary" href="{{ route('cab-ride.show',$cabride->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a> --}}
                                        <div class=" btn-group">
                                        <a class="btn btn-sm btn-info" title="details" onclick="show({{$cabride->id}})" href="#">
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

                            @if($cabrides->isEmpty())
                            <tr>
                                <td colspan="9">No data available.</td>
                            </tr>
                            @endif
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
        $.get("{{route('cab-ride.index')}}" +'/' + id, function(data){
            $('.modal-body').html(data);
            console.log(data);
    // alert("Data: " + data );
  });
    }
</script>
@endsection