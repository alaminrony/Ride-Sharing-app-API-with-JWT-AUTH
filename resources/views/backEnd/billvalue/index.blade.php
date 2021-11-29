@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'optionValue'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.BILL_CHARGE_SUB_OPTION')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" onclick="add()" class="btn btn-sm btn-primary">@lang('lang.ADD')</a>
                        </div>
                    </div>
                    @include('flash')
                   {{--  @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif --}}
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">@lang('lang.SUB_OPTION_TITLE')</th>
                                <th scope="col">@lang('lang.OPTION_TITLE')</th>
                                <th scope="col">@lang('lang.CREATED_BY')</th>
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.STATUS')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                          <tbody>
                            @foreach($options_value as $option_value)
                            <tr>
                                {{-- <td>{{ $option_value->bill_charge_title  }}</td> --}}
                                <td>{{ (isset($option_value->billchargeoption->bill_charge_title)? $option_value->billchargeoption->bill_charge_title : '')  }}</td>
                                <td>{{ $option_value->option_value_name }}</td>
                                {{-- <td>{{ $option_value->first_name .' '.$option_value->last_name }}</td> --}}
                                <td>{{ created_by($option_value->created_by) }}</td>
                                <td>{{ datefunction($option_value->created_at) }}</td>
                                <td>{{ status($option_value->option_value_status) }}</td>
                               
                                
                                <td>
                                    <form action="{{ route('bill-options-value.destroy',$option_value->id) }}" method="POST">
                                        <a onclick="edit({{$option_value->id}})" class="btn btn-sm btn-primary" href="#">
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
                 {{ $options_value->links() }}
            </div>
        </div>
    </div>
</div>
{{-- modal --}}
<!-- Modal -->
<div class="modal fade" id="optionValue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'bill-options-value.store','method' => 'POST','id'=>'optionValueForm']) !!}
                {{-- @csrf --}}
                <div class="">
                    <div class="form-group ">
                        <label>@lang('lang.OPTION_TITLE')</label>
                        {!! Form::select('billchargeoption_id',$options,old('billchargeoption_id'),['required'=>'required','class' => 'form-control','id'=>'billchargeoption_id','placeholder' =>Lang::get('lang.OPTION_TITLE')]) !!}
                    </div>
                    <div class="form-group ">
                        <label>@lang('lang.OPTION_VALUE_TITLE')</label>
                        {!! Form::text('option_value_name',old('option_value_name'),['required'=>'required','class' => 'form-control','id'=>'option_value_name','placeholder' =>Lang::get('lang.OPTION_VALUE_TITLE')]) !!}
                    </div>
                    <div class="form-group ">
                        <label>@lang('lang.STATUS')</label>
                        {!! Form::select('status', ['0' => 'Inactive', '1' => 'Active'],null,['required'=>'required','class'=>'form-control','id'=>'status','placeholder'=> 'Status'])!!}
                    </div>
                </div>
                
                <div class="modal-footer ">
                    <button type="submit" class="submit btn btn-info btn-round">{{ __('Submit') }}</button>
                    
                    <button type="button" class="btn btn-warning btn-round" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
                
            </div>
            
        </div>
    </div>
</div>
{{-- modal end --}}
<script type="text/javascript">
function add() {
$('.modal-title').html('Add Bill Charge Sub Option');
$('#optionValue').modal('show');
$('#optionValueForm').trigger("reset");
}
function edit(id){
    var id = id;
       $.get("{{ route('bill-options-value.index') }}" +'/' + id +'/edit', function (data) {
    $('#modelHeading').html("Edit Product");
    $('#saveBtn').val("edit-user");
    $('#optionValue').modal('show');
    $('.modal-body').html(data);
    $('.modal-title').html('Edit Bill Charge Sub Option');
    
    })
}

function update(id) {
        var id = id;
        var title = $('#bill_title').val();
        var carge_option = $('#bill_charge_option_id').val();
        var option_name = $('#option_value_name').val();
        var status = $('#status').val();
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            method: "PUT",
            url: "{{route('bill-options-value.update',"id")}}",
            data:{bill_charge_title:title,id:id},
            dataType:'json',
            success:function(data){
                if (data.res) {
                    $('.message').html(data.res);
                    $('.message').addClass('text-success');
                    $('#optionsForm').trigger("reset");
                    setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 5000);
                }else{
                    $('.message').html(data.bill_charge_title);
                    $('.message').addClass('text-danger');

                }
                console.log(data);
            }
        });
    }
</script>
@endsection