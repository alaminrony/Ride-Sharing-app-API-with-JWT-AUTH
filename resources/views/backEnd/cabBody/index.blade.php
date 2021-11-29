@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'cabBody'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.BODY_TYPE')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('cab-body-type.create')}}" class="btn btn-sm btn-primary">@lang('lang.ADD_BODY_TYPE')</a>
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
                                <th scope="col">@lang('lang.TYPE_NAME') </th>
                                <th scope="col">@lang('lang.DESCRIPTION')</th>
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cabtypes as $cabtype)
                            <tr>
                                <td>{{$cabtype->type_name}}</td>
                                <td>{{$cabtype->description}}</td>
                                <td>{{ date_format($cabtype->created_at,"d-M-Y ") }}</td>
                               
                                <td>
                                    <form action="{{ route('cab-body-type.destroy',$cabtype->id) }}" method="POST">
                                        <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('cab-body-type.edit',$cabtype->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a class="btn btn-sm btn-info" onclick="show({{$cabtype->id}})" href="#">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure')" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $cabtypes->links() }}
            </div>
        </div>
    </div>
</div>


{{-- modal start--}}
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cab Type details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- modal end--}}
<script>
function show(id) {
var id = id;
$.get("{{ route('cab-body-type.index') }}" +'/' + id , function (data) {

$('#detailsModal').modal('show');
$('.modal-body').html(data);

})
}
</script>
@endsection