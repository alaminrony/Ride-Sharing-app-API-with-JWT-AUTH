@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'driverbill'
])
@section('content')
<div class="content">
    <div class="card shadow">

        {!! Form::open(['url' => 'driver-bill/search','method' => 'get','enctype' => 'multipart/form-data']) !!}
        <div class="row p-3">
            <div class="col-md-3">
                <label>driver name</label>
                {!! Form::select('driver_id', $drivers ,isset($_GET['driver_id'])?$_GET['driver_id'] : null,['class'=>'form-control','placeholder'=> Lang::get('lang.DRIVER')])!!}
            </div>
            <div class="col-md-3 pt-3">
                <label> </label>
                <input type="submit" name="" value="submit" class="btn btn-primary">
            </div>
        </div>
        {!! Form::close() !!}
        <div class="row p-3">
            <div class="col-md-6">
                <table class="table border">
                    <tr>
                        <td>Total Amount</td>
                        <td>23</td>
                    </tr>
                    <tr>
                        <td>Total Paid Amount</td>
                        <td>23</td>
                    </tr>
                    <tr>
                        <td>Total Due Amount</td>
                        <td>23</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.DRIVER_BILL')</h3>
                        </div>
                        <div class="col-4 text-right">
                            {{-- 	<a href="{{route('driver.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_DRIVER')</a> --}}
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
                                <th scope="col">@lang('lang.FROM')</th>
                                <th scope="col">@lang('lang.TO')</th>
                                <th scope="col">@lang('lang.AMOUNT')</th>
                                <th scope="col">@lang('lang.PAYMENT_STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($driverBills as $driverBill)
                            <tr>
                                <td>{{$driverBill->full_name}}</td>
                                <td>{{$driverBill->start_date}}</td>
                                <td>{{$driverBill->end_date}}</td>
                                <td>{{$driverBill->amount}}</td>
                                @if($driverBill->payment_status==1)
                                <td>{{'Free'}}</td>
                                @elseif($driverBill->payment_status==2)
                                <td>{{'Paid'}}</td>
                                @elseif($driverBill->payment_status==3)
                                <td>{{'Pending'}}</td>
                                @endif
                                <td>
                                    <a class="btn btn-sm btn-info" onclick="show({{$driverBill->id}})" href="#">
                                        <i class="fa fa-info"></i>
                                    </a>
                                    <a class="btn btn-sm btn-info"  href="#">
                                        <i class="fa fa-car"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $driverBills->links() }}
            </div>
        </div>
    </div>
</div>

{{-- modal start--}}
<div class="modal fade" id="driverDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Driver-bill details</h5>
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
    $.get("{{ route('driver-bill.index') }}" + '/' + id, function (data) {

    $('#driverDetails').modal('show');
    $('.modal-body').html(data);
    })
    }
</script>
@endsection