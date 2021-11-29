@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'contact'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.CONTACT_REQUEST')</h3>
                        </div>
                        <div class="col-4 text-right">
                            {{-- <a href="#" onclick="addbtn()" class="btn btn-sm btn-primary">@lang('lang.ADD_OPTION')</a> --}}

                            {{-- <a href="{{route('bill-options.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_OPTION')</a> --}}
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
                                <th scope="col">@lang('lang.NAME') </th>
                                <th scope="col">@lang('lang.EMAIL') </th>
                                <th scope="col">@lang('lang.SUBJECT') </th>
                                <th scope="col">@lang('lang.MESSAGE')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contactUs as $contact)
                            <tr>
                                <td>{{$contact->name}}</td>
                                <td>{{$contact->email}}</td>
                                <td>{{$contact->subject}}</td>
                                <td>{{$contact->message}}</td>
                                {{-- <td>{{ datefunction($subscriber->created_at) }}</td> --}}
                               
                                <td>
                                    <form action="{{ route('contact.destroy',$contact->id) }}" method="POST">
                                       {{--  <a class="btn btn-sm btn-primary"onclick="edit({{$option->id}})" href="#">
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
                {{ $contactUs->links() }}
            </div>
        </div>
    </div>
</div>


@endsection