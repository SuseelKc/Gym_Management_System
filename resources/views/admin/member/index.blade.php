@extends('admin.admin')
@section('title','Members')
@section('content')

<link href="{{ asset('admin/DataTables/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/DataTables/datatables.min.js') }}"></script>

<div class="content">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Gym Membership</li>
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
                                <a href="{{route('member.create')}}"
                                    class="btn btn-primary px-4 m-2 float-right">Add</a>  
                            </div>
                            <div class="card-body table-responsive p-2">
                                <table class="table table-hover table-bordered display compact" id="membership"> 
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>ID No.</th>
                                            <th>Name</th>  
                                            <th>Image</th>  
                                            <th>Email</th>
                                            <th>DOB</th>
                                            <th>Contact</th>
                                            <th>Shifts</th>
                                            <th>Package</th>
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
                                            <th>Image</th>  
                                            <th>Email</th>
                                            <th>DOB</th>
                                            <th>Contact</th>
                                            <th>Shifts</th>
                                            <th>Package</th>
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
<!--  -->
<!-- Modal -->
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
                <input type="hidden" id="memberIdToDelete">
                 <p id="memberNameToDelete"></p>
                <!-- ... other modal content ... -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteMember()">Delete</button>
            </div>
    </div>
  </div>
</div>
<!--  -->
<script>
    $(document).ready(function () {
        // Update the modal input field when the anchor tag is clicked
        $('a[data-target="#deleteModal"]').on('click', function () {
            var memberId = $(this).data('member-id');
            var memberName = $(this).data('member-name');

            $('#memberIdToDelete').val(memberId);
            $('#memberNameToDelete').text('Are you sure you want to delete ' + memberName + '?');
        });

        // Function to handle the delete button click
        window.deleteMember = function () {
            // Get the ID from the input field
            var memberId = $('#memberIdToDelete').val();

            // Construct the delete route with the memberId
            var deleteRoute = '{{ route("member.delete", ":id") }}';
            deleteRoute = deleteRoute.replace(':id', memberId);

            // Perform the delete operation by navigating to the delete route
            window.location.href = deleteRoute;
        };
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#membership').dataTable({
			dom: 'lrtip',
			destroy: true,
			processing: true,
			language: {
				processing: '<span style="color:black;">Processing...</span>'
			},
			serverSide: true,
			ajax: {
				url: "/allmembers",
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
				{data: "serial_no"},
				{data: "name"},
                {data: "photo"},
				{data: "email"},
				{data: "dob"},
                {data: "contact_no"},
				{data: "shifts"},
                {data: "package_name"},
                {data: "status"},
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
                    var negletColumns   = ['Action','S.N.','Image'];

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

</script>

<!--  -->
@endsection