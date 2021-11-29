@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'news'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.NEWS')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('news.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD')</a>
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
                                <th scope="col">@lang('lang.TITLE')</th>
                                <th scope="col">@lang('lang.CATEGORY')</th>
                                <th scope="col">@lang('lang.CREATED_BY')</th>
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->newscategory->title }}</td>
                                <td>{{ created_by($item->created_by) }}</td>
                                <td>{{ datefunction($item->created_at) }}</td>
                                <td>{{ status($item->status) }}</td>
                                <td>
                                    <form action="{{ route('news.destroy',$item->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary" href="{{ route('news.edit',$item->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Are you sure')"  class="btn btn-sm btn-danger" href="{{ route('news.trash',$item->id) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                       {{--  @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure')" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button> --}}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $news->links() }}
            </div>
        </div>
    </div>
</div>
@endsection