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
                            <h3 class="mb-0">@lang('lang.TRASH')</h3>
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
                                <td>{{$driver->d_first_name.' '.$driver->d_last_name}}</td>
                                <td>{{$driver->ratings}}</td>
                                <td>{{$driver->d_email}}</td>
                                <td>{{$driver->d_phone}}</td>
                                <td>{{$driver->driver_type_id}}</td>
                                <td>{{$driver->is_online}}</td>
                                <td>{{$driver->active}}</td>
                                <td>
                                    <form action="{{ route('driver.destroy',$driver->id) }}" method="POST">
                                      
                                        <a class="btn btn-sm btn-primary" title="Restore" href="{{ route('driver.trash',$driver->id) }}">
                                           <i class="fa fa-undo"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure')" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
@endsection