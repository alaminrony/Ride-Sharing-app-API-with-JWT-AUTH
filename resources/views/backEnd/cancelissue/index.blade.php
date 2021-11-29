@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'cancelissue'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CANCEL_ISSUE')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('cancel-issue.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_CANCEL_ISSUE')</a>
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
                                <th scope="col">@lang('lang.USER_TYPE')</th>
                                {{-- <th scope="col">@lang('lang.PAGE')</th> --}}
                                <th scope="col">@lang('lang.CANCEL_ISSUE')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cancelissues as $cancelissue)
                            <tr>
                                
                                <td>{{($cancelissue->app_id ==1)? 'Driver' :'Passenger'}}</td>
                                {{-- <td>{{$cancelissue->scene_name}}</td> --}}
                                <td>{{$cancelissue->cancel_issue_type}}</td>
                                
                               
                                <td>
                                    <form action="{{ route('cancel-issue.destroy',$cancelissue->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary" href="{{ route('cancel-issue.edit',$cancelissue->id) }}">
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
                {{ $cancelissues->links() }}
            </div>
        </div>
    </div>
</div>
@endsection