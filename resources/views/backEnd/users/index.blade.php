@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'User'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.USER')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('user.create')}}" class="btn btn-sm btn-primary">Add user</a>
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
                                <th scope="col">@lang('lang.First_Name')</th>
                                <th scope="col">@lang('lang.Last_Name')</th>
                                <th scope="col">@lang('lang.EMAIL')</th>
                                <th scope="col">@lang('lang.GROUP')</th>
                                <th scope="col">@lang('lang.STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->group->name}}</td>
                                <td>{{status($user->status)}}</td>
                                <td>
                                    <form action="{{ route('user.destroy',$user->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary" href="{{ route('user.edit',$user->id) }}">
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
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection