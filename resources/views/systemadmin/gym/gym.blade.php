@extends('admin.admin')
@section('title','Gym Admins')
@section('content')
<div class="content">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Gym Admins</li>
                        </ol>
                    </div>
                </div>
            </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                            <div class="">                             
                                    <button class="btn btn-primary px-4 m-2 float-right" id="add-member-btn">Add</button>
                            </div>
                            <div class="card-body table-responsive p-2">
                                <table class="table table-hover table-bordered display compact" id="gymUsers"> 
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>ID No.</th>
                                            <th>Name</th>               
                                            <th>Email</th>
                                            <th>Members</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>ID No.</th>
                                            <th>Name</th> 
                                            <th>Email</th>
                                            <th>Members</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>   
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
       </div>
              <div class="modal-body">
                  <input type="hidden" id="gymIdToDelete">
                   <p id="gymNameToDelete"></p>
                  <!-- ... other modal content ... -->
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-danger" onclick="deleteGym()">Delete</button>
              </div>
      </div>
    </div>
</div>
  <!--  -->




  
<script>

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    var gymUsersData = $('#gymUsers').DataTable({
        dom: 'lrtip',
        destroy: true,
        processing: true,
        language: {
            processing: '<span style="color:black;">Processing...</span>'
        },
        serverSide: true,
        
        ajax: {
            url: "/allGym",
            type: "POST",
            data: function(postData) {
                postData._token = $('meta[name="csrf-token"]').attr('content');
            }
        },
        scrollY: "45vh",
        scrollX: true,
        // 	dom: '<<"pull-left"l>f>rt<"datatable_btns pull-left"B><"pull-right"ip>',
        // 	buttons: [{
        // 		extend: "excel",
        // 		className: "btn-sm",
        // 		text: '<i class="fa fa-file-excel-o"></i>&nbsp;Download',
        // 		filename: 'Classic House Owner',
        // 		title: 'House Owner',
        // 	}, ],
        // scrollCollapse: true,
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
        ],
        columns: 
        [
            {data: "sn"},
            {data: "id"},
            {data: "name"},
            {data: "email"},
            {data: "members"},
            {data: "created_at"},
            {data: "action"},
        ],
        // deferRender: true,
        // columnDefs: [{
        // 		"orderable": false,
        // 		"targets": [0,5]
        // 	}
        // ],
        initComplete: function() 
        {
            this.api().columns().every(function() 
            {
                var header          = $(this.header()).text();
                var negletColumns   = ['Action','S.N.'];

                if ($.inArray(header, negletColumns) < 0) 
                {
                    var column = this;
                    var select = $('<input style="width: 100%; padding: 5px 2px; margin: 4px 0; box-sizing: border-box;" class="input-sm" placeholder="' + header + '" title="Press Enter Key To Search" />').appendTo($(column.footer()).empty()).on('keyup', function(e) {
                        if (e.keyCode == 13 || (e.keyCode == 8 && "" == val)) {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val, true, true).draw();
                        }
                    });
                }
            });
        }
    }); 


    $(document).ready(function () {
        // Update the modal input field when the anchor tag is clicked
        $('a[data-target="#deleteModal"]').on('click', function () {
            var gymId = $(this).data('gym-id');
            var gymName = $(this).data('gym-name');

            $('#gymIdToDelete').val(gymId);
            $('#gymNameToDelete').text('Are you sure you want to delete ' + gymName + '?');
        });

        // Function to handle the delete button click
        window.deleteGym = function () {
            // Get the ID from the input field
            var gymId = $('#gymIdToDelete').val();

            // Construct the delete route with the gymId
            var deleteRoute = '{{ route("gym.delete", ":id") }}';
            deleteRoute = deleteRoute.replace(':id', gymId);

            // Perform the delete operation by navigating to the delete route
            window.location.href = deleteRoute;
        };
    });
</script>

@endsection