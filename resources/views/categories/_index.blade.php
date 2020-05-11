@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">

@endpush

@push('head_js')


@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-category">Add New</a>
                {{-- <a class="btn btn-success mb-2" id="new_category" data-toggle="modal">New Category</a> --}}
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped" id="laravel_datatable">

        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="5%">Id</th>
                <th width="30%">Name</th>
                <th width="30%">Slug</th>
                <th width="20%">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- <tr>
                <th width="5%">No</th>
                <th width="5%">Id</th>
                <th width="30%">Name</th>
                <th width="30%">Slug</th>
                <th width="20%">Action</th>
            </tr> --}}
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajax-category-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="categoryCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="categoryForm" name="categoryForm" class="form-horizontal">
                <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div> 
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btnsave" value="create" disabled>Save changes
                        <a href="#" class="btn btn-danger">Cancel</a>
                    </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script defer src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    // error = false

    function validate() {
        if (document.categoryForm.name.value != '')
            document.categoryForm.btnsave.disabled = false
        else
            document.categoryForm.btnsave.disabled = true
    }
</script>


<script>
    var SITEURL = '{{URL::to('')}}';
    $(document).ready( function () {
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
             url: SITEURL + "category",
             type: 'GET',
            },
            columns: [
                     {data: 'id', name: 'id', 'visible': false},
                     {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                     { data: 'name', name: 'name' },
                     { data: 'slug', name: 'slug' },
                     { data: 'created_at', name: 'created_at' },
                     {data: 'action', name: 'action', orderable: false},
                  ],
           order: [[0, 'desc']]
         });
    
    /*  When user click add user button */
       $('#create-new-category').click(function () {
           $('#btnsave').val("create-category");
           $('#category_id').val('');
           $('#categoryForm').trigger("reset");
           $('#categoryCrudModal').html("Add New Category");
           $('#ajax-category-modal').modal('show');
       });
     
      /* When click edit user */
       $('body').on('click', '.edit-category', function () {
         var category_id = $(this).data('id');
         $.get('category/' + category_id +'/edit', function (data) {
            $('#title-error').hide();
            $('#category_code-error').hide();
            $('#categoryCrudModal').html("Edit Category");
             $('#btnsave').val("edit-category");
             $('#ajax-category-modal').modal('show');
             $('#category_id').val(data.id);
             $('#name').val(data.title);
         })
      });
    
       $('body').on('click', '#delete-category', function () {
     
           var category_id = $(this).data("id");
           
           if(confirm("Are You sure want to delete !")){
             $.ajax({
                 type: "get",
                 url: SITEURL + "category/delete/"+category_id,
                 success: function (data) {
                 var oTable = $('#laravel_datatable').dataTable(); 
                 oTable.fnDraw(false);
                 },
                 error: function (data) {
                     console.log('Error:', data);
                 }
             });
           }
       }); 
      
      });
     
   if ($("#categoryForm").length > 0) {
         $("#categoryForm").validate({
     
        submitHandler: function(form) {
     
         var actionType = $('#btnsave').val();
         $('#btnsave').html('Sending..');
          
         $.ajax({
             data: $('#categoryForm').serialize(),
             url: SITEURL + "category/store",
             type: "POST",
             dataType: 'json',
             success: function (data) {
     
                 $('#categoryForm').trigger("reset");
                 $('#ajax-category-modal').modal('hide');
                 $('#btnsave').html('Save Changes');
                 var oTable = $('#laravel_datatable').dataTable();
                 oTable.fnDraw(false);
                  
             },
             error: function (data) {
                 console.log('Error:', data);
                 $('#btnsave').html('Save Changes');
             }
         });
       }
     })
   }
   </script>

@endsection

