@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'driverlog'
])
@section('content')
<div class="content">
    <div class="card shadow">
       {!! Form::open(['url' => 'driver-log/filter','method' => 'get','enctype' => 'multipart/form-data']) !!}
       @csrf
            <div class="row p-3">
                <div class="col-md-3">
                    <label>Driver name</label>
                   {!! Form::select('driver_id', $drivers ,null,['class'=>'form-control','placeholder'=> Lang::get('lang.DRIVER')])!!}
                </div>
                <div class="col-md-3">
                    <label>Start date</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>End date</label>
                    <input type="date" name="end_date" class="form-control">
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
                            <h3 class="mb-0">@lang('lang.DRIVER_LOG')</h3>
                        </div>
                        <div class="col-4 text-right">
                           {{--  <a href="{{route('driver.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_DRIVER')</a> --}}
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
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.ACTIVE')</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($driver_logs as $log)
                            <tr>
                                <td>{{$log->driver->full_name}}</td>
                                <td>{{datefunction($log->created_at)}}</td>
                                
                                <td>{{checkonline($log->driver->is_online)}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $driver_logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection