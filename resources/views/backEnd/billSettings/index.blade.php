@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'bill-setting'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.BILL_SETTINGS')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('bill-settings.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD')</a>
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
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill_settings as $bill_setting)
                            <tr>
                                <td>{{ $bill_setting->country->country_name }}</td>
                                <td>{{ isset($bill_setting->billchargeoption->bill_charge_title)?$bill_setting->billchargeoption->bill_charge_title : '' }}</td>
                               
                                <td>{{$bill_setting->billchargeoptionvalue->option_value_name}}</td>
                                <td>{{$bill_setting->charge_value}}</td>
                                <td>
                                    <form action="{{ route('bill-settings.destroy',$bill_setting->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary" href="{{ route('bill-settings.edit',$bill_setting->id) }}">
                                            <i class="fa fa-edit"></i>
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