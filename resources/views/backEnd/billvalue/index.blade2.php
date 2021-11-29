<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 6 Ajax CRUD tutorial using Datatable - ItSolutionStuff.com</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    </head>
    <body>
        
        <div class="container">
            <h1>Laravel 6 Ajax CRUD tutorial using Datatable - ItSolutionStuff.com</h1>
            <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Product</a>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sub option title</th>
                        <th>option title</th>
                        <th>Created at</th>
                        <th>Status</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="col-lg-6">
                                <form id="productForm" name="productForm" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="Bill charge options">Bill charge options</label><samp class="required-star">*</samp>
                                        
                                        <select name="bill_charge_option_id" class="form-control tip select2" style="width:100%;" id="bill_charge_option_id" required="required">
                                            <option value="" selected="selected">Select Option</option>
                                            <option value="0">Against Ride Chare</option>
                                            <option value="1">Ride Wise</option>
                                            <option value="2">Period Wise</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Option_value_title">Option value title</label><samp class="required-star">*</samp>
                                        <input type="text" name="option_value_name" value="" class="form-control tip" id="option_value_name" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label><samp class="required-star">*</samp>
                                        <select name="status" id="status" data-placeholder="Select Status" class="form-control input-tip select2" style="width:100%;">
                                            <option value="" selected="selected">Select status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="add_now" value="Add Now" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    
    <script type="text/javascript">
    $(function () {
    
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('bill-options-value.index') }}",
    columns: [
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'bill_charge_option_id', name: 'bill_charge_option_id'},
    {data: 'option_value_name', name: 'option_value_name'},
    {data: 'option_value_status', name: 'option_value_status'},
    {data: 'created_by', name: 'created_by'},
    {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
    });
    
    $('#createNewProduct').click(function () {
    $('#saveBtn').val("create-product");
    $('#product_id').val('');
    $('#productForm').trigger("reset");
    $('#modelHeading').html("Create New Product");
    $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editProduct', function () {
    var product_id = $(this).data('id');
    $.get("{{ route('bill-options-value.index') }}" +'/' + product_id +'/edit', function (data) {
    $('#modelHeading').html("Edit Product");
    $('#saveBtn').val("edit-user");
    $('#ajaxModel').modal('show');
    $('#bill_charge_option_id').val(data.bill_charge_option_id);
    $('#option_value_name').val(data.option_value_name);
    $('#status').val(data.status);
    })
    });
    
    $('#saveBtn').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    
    $.ajax({
    data: $('#productForm').serialize(),
    url: "{{ route('bill-options-value.store') }}",
    type: "POST",
    dataType: 'json',
    success: function (data) {
    
    $('#productForm').trigger("reset");
    $('#ajaxModel').modal('hide');
    table.draw();
    
    },
    error: function (data) {
    console.log('Error:', data);
    $('#saveBtn').html('Save Changes');
    }
    });
    });
    
    $('body').on('click', '.deleteProduct', function () {
    
    var product_id = $(this).data("id");
    confirm("Are You sure want to delete !");
    
    $.ajax({
    type: "DELETE",
    url: "{{ route('bill-options-value.store') }}"+'/'+product_id,
    success: function (data) {
    table.draw();
    },
    error: function (data) {
    console.log('Error:', data);
    }
    });
    });
    
    });
    </script>
</html>