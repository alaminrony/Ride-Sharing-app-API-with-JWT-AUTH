@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'bill-settinglog'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.BILL_SETTINGS_LOG')</h3>
                        </div>
                        <div class="col-4 text-right">
                    {{--<a href="{{route('bill-settings.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD')</a> --}}
                        </div>
                    </div>
                    @include('flash')
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">@lang('lang.COUNTRY')</th>
                                <th scope="col">@lang('lang.BILL_CHARGE_OPTION')</th>
                                <th scope="col">@lang('lang.BILL_CHARGE_SUB_OPTION')</th>
                                <th scope="col">@lang('lang.AMOUNT')</th>
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill_settings_log as $log)
                            <tr>
                                <td>{{ $log->country->country_name }}</td>
                                <td>{{ isset($log->billchargeoption->bill_charge_title)?$log->billchargeoption->bill_charge_title : '' }}</td>
                               
                                <td>{{$log->billchargeoptionvalue->option_value_name}}</td>
                                <td>{{$log->charge_value}}</td>
                                <td>{{datefunction($log->created_at)}}</td>
                                <td>
                                    <form action="{{ route('bill-settings-log.destroy',$log->id) }}" method="POST">
                                       {{--  <a class="btn btn-sm btn-primary" href="{{ route('bill-settings.edit',$log->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a> --}}
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