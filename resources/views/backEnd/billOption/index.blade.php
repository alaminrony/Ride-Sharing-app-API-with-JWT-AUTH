@extends('backEnd.layouts.app', [
'class' => '',
'elementActive' => 'billoption'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@lang('lang.BILL_CHARGE_OPTION')</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" onclick="addbtn()" class="btn btn-sm btn-primary">@lang('lang.ADD_OPTION')</a>

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
                                <th scope="col">@lang('lang.OPTION_TITLE') </th>
                                <th scope="col">@lang('lang.CREATED_BY')</th>
                                <th scope="col">@lang('lang.CREATED_AT')</th>
                                <th scope="col">@lang('lang.ACTION')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($options as $option)
                            <tr>
                                <td>{{$option->bill_charge_title}}</td>
                                <td>{{created_by($option->created_by)}}</td>
                                <td>{{ datefunction($option->created_at) }}</td>
                               
                                <td>
                                    <form action="{{ route('bill-options.destroy',$option->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary"onclick="edit({{$option->id}})" href="#">
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
                {{ $options->links() }}
            </div>
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="optionsForm" method="POST">
        @csrf
      <div class="modal-body">
         <div class=" col-md-6">
            <label>Bill Charge Option</label>
            {!! Form::text('bill_charge_title', null, ['class'=>'form-control','id'=>'bill_title','placeholder' =>Lang::get('lang.OPTION_TITLE')]) !!}
                
               <p class="message">
                   
               </p>
               
                
        </div>
      </div>
      <div class="modal-footer text-left">
        <button type="button" onclick="save()" class="btn submit btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- modal end --}}


<script type="text/javascript">
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    function addbtn(){
        $('#optionModal').modal('show');
        $('.modal-title').html('Add Option');
        $('#optionsForm').trigger("reset");
        $('.message').html('');

        $('#optionsForm').attr('action','{{route('bill-options.store')}}');
    };
    function save() {
        // alert('hi');
        var title = $('#bill_title').val();
          $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        $.ajax({
            method: "post",
            url: "{{route('bill-options.store')}}",
            data:{bill_charge_title:title},
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
    function edit(id) {
        $('#optionModal').modal('show');
        $('.modal-title').html('Edit Option');
        $('.message').html('');

        var id = id;
         $.ajax({
            method: "get",
           
            url: "{{ route('bill-options.edit','edit') }}",
            
            data:{id:id},
            dataType:'json',
            success:function(data){
                if (data) {
                    $('#bill_title').val(data.bill_charge_title);
                    $('.submit').html('Update');
        $('.submit').attr('onclick','update('+data.id+')');
                   

                }
                console.log(data);
            }
        });
    }
    function update(id) {
        var id = id;
        var title = $('#bill_title').val();
          
        $.ajax({
            method: "PUT",
            url: "{{route('bill-options.update',"id")}}",
            data:{"_token": "{{ csrf_token() }}",bill_charge_title:title,id:id},
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