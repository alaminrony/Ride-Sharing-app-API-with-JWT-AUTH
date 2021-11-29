@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'newsCategory'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.NEWS_CATEGORY')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" onclick="add()" class="btn btn-sm btn-primary">@lang('lang.ADD_NEWS_CATEGORY')</a>
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
                                <th scope="col">@lang('lang.DESCRIPTION')</th>
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newsCategories as $newsCategory)
                            <tr>
                                <td>{{ $newsCategory->title }}</td>
                                <td>{{ $newsCategory->description }}</td>
                                <td>{{ datefunction($newsCategory->created_at) }}</td>
                                
                                <td>
                                    <form action="{{ route('news-category.destroy',$newsCategory->id) }}" method="POST">
                                        <a onclick="edit({{$newsCategory->id}})" class="btn btn-sm btn-primary" href="#">
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
                {{$newsCategories->links()}}
            </div>
        </div>
    </div>
</div>
{{-- modal --}}
<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'news-category.store','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                @csrf
                <div class="">
                    <div class="form-group">
                        <label>Title</label>
                        {!! Form::text('title',old('title'),['class' => 'form-control','placeholder' =>Lang::get('lang.TITLE'),'required'=>'required']) !!}
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        {!! Form::textarea('description',old('description'),['class' => 'form-control','placeholder' =>Lang::get('lang.NOTIFY_MESSAGE'),'required'=>'required']) !!}
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-round">{{ __('Add Now') }}</button>
                    <button type="button" class="btn btn-warning btn-round" data-dismiss="modal">Cancel</button>
                </div>
                {!! Form::close() !!}
                
            </div>
            
        </div>
    </div>
</div>
<script>
function add(){
$('#category').modal('show');
}
function edit(id){
var id = id;
       $.get("{{ route('news-category.index') }}" +'/' + id +'/edit', function (data) {
    $('.modal-title').html("Edit Category");
    $('#category').modal('show');
    $('.modal-body').html(data);
    })
}
</script>
@endsection