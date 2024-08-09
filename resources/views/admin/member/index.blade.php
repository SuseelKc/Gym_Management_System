@extends('admin.admin')
@section('title','Members')
@section('content')

<link href="{{ asset('admin/Toastr/toastr.css') }}" rel="stylesheet">
<script src="{{ asset('admin/Toastr/toastr.js') }}"></script>

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
                                    <button class="btn btn-primary px-4 m-2 float-right" id="add-member-btn">Add</button>
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

<!-- Modal for Creating Member -->
<div class="modal fade" id="createMemberModal" tabindex="-1" role="dialog modal-xl" aria-labelledby="createMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="createMemberModalContent">
            <!-- load the body -->
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Member -->
<div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog modal-xl" aria-labelledby="editMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="editMemberModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMemberModalLabel">Edit Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  id="editMemberForm"> 
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="member_id" id="member_id" value="">
                                <!-- name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter Name Here" name="name" >
                                    </div>
                                </div>
                                <!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gym_name">Gym Name</label>
                                        <input type="text" class="form-control" id="gym_name" placeholder="Enter Name Here" name="gym_name" value="" readonly>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth</label>
                                        <input type="date" class="form-control" id="dob"  name="dob" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter Your Address" name="address" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contactno">Contact No.</label>
                                        <input type="number" class="form-control" id="contact_no" placeholder="Enter Your Contact Number" name="contact_no" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Enter Your Email" name="email" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pricing">Package</label><br>
                                        <select id="pricing" name="pricing">
                                            <option value="">Not Selected</option>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="photo">Upload Image</label>
                                        <input type="file" class="form-control" id="photo" name="photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary px-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

    var membershipData = $('#membership').DataTable({
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

    $(document).on('click', '#add-member-btn', function () {

        $('#createMemberModal').modal('show');

        $('#createMemberModalContent').load('{{ route("member.displayCreateModal") }}', function() {
            
            $('#saveMemberForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
    
                $.ajax({
                    url: '{{ route("member.save") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',  
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.success);
                            $('#createMemberModal').modal('hide').on('hidden.bs.modal', function () {
                                membershipData.ajax.reload();  
                                $('.modal-backdrop').remove();
                            });
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred while saving the member.');
                        }
                    }
                });
            });
        });
    });

    $(document).on('click', '.edit-member-btn', function(e) 
    {
        e.preventDefault();

        var memberId = $(this).data('id'); 

        $.ajax({
            url: '/members/' + memberId + '/edit',
            type: 'GET',
            success: function(response) 
            {
                if (response.success) 
                {
                    $('#editMemberForm #member_id').val(response.member.id);
                    $('#editMemberForm #name').val(response.member.name);
                    $('#editMemberForm #gym_name').val(response.userName);
                    $('#editMemberForm #dob').val(response.member.dob);
                    $('#editMemberForm #address').val(response.member.address);
                    $('#editMemberForm #contact_no').val(response.member.contact_no);
                    $('#editMemberForm #email').val(response.member.email);
                    
                    $('#editMemberForm #pricing').empty();

                    // Add a default "Not Selected" option
                    $('#editMemberForm #pricing').append('<option value="">Not Selected</option>');

                    Object.values(response.pricing).forEach(function(packageItem) 
                    {
                        const selected = packageItem.id === response.member.pricing_id ? 'selected' : '';
                        $('#editMemberForm #pricing').append(
                            `<option value="${packageItem.id}" ${selected}>${packageItem.name}</option>`
                        );
                    });

                    $('#editMemberModal').modal('show');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to fetch member details.');
            }
        });
    });

    // Handle the form submission for editing member
    $('#editMemberForm').on('submit', function(e) 
    {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '/members/update', 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) 
            {
                if (response.success) 
                {
                    toastr.success(response.success);
                    $('#editMemberModal').modal('hide');
                    membershipData.ajax.reload();  
                }
            },
            error: function(xhr) 
            {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) 
                    {
                        toastr.error(value[0]);
                    });
                } else 
                {
                    toastr.error('An error occurred while updating the member.');
                }
            }
        });
    });

</script>

@endsection