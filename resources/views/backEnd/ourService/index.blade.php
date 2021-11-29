@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'ourService'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.OUR_SERVICES')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('our-services.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_SERVICES')</a>
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
                                <th scope="col">@lang('lang.IMAGE')</th>
                                <th scope="col">@lang('lang.TITLE')</th>
                                <th scope="col">@lang('lang.DESCRIPTION')</th>
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ouservices as $ouservice)
                            <tr>
                                <td><img src="{{ asset($ouservice->image) }}" width="70px"></td>
                                <td>{{$ouservice->title}}</td>
                                <td>{{$ouservice->description}}</td>
                                <td>{{ datefunction($ouservice->created_at) }}</td>
                                <td>{{ status($ouservice->status) }}</td>
                               
                                <td>
                                    <form action="{{ route('our-services.destroy',$ouservice->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary" href="{{ route('our-services.edit',$ouservice->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                      {{--   <a class="btn btn-sm btn-danger" title="Add to Trash" onclick="return confirm('Are you sure')" href="{{ route('driver.trash',$driver->id) }}">
                                            <i class="fa fa-trash"></i>
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
                {{ $ouservices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection