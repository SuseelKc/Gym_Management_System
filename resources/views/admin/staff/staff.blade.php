@extends('admin.admin')
@section('title','Staff')
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
                            <li class="breadcrumb-item active">Staff</li>
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
                                <button class="btn btn-primary px-4 m-2 float-right" id="add-staff-btn">Add</button>
                            </div>
                            <div class="card-body table-responsive p-2">
                                <table class="table table-hover table-bordered display compact" id="staffTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>ID No.</th>
                                            <th>Image</th>
                                            <th>Name</th>            
                                            <th>D.O.B</th>
                                            <th>Address</th>  
                                            <th>Position</th>                                                                                  
                                            <th>Contact No.</th>                                            
                                            <th>Email</th>                                                                     
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<!--  -->

<!-- Modal for Adding Staff -->
<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog modal-xl" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="addStaffModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form  id="addStaffForm"> 
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="member_id" id="member_id" value="">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Enter Name Here" name="name"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gym_name">Gym Name</label>
                                        <input type="text" class="form-control" id="gym_name"
                                            placeholder="Enter Name Here" name="gym_name" value="{{ $gym->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth</label>
                                        <input type="date" class="form-control" id="dob"
                                            placeholder="Enter Date of Birth" name="dob"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address"
                                            placeholder="Enter Address Here" name="address" >
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_no">Contact No</label>
                                        <input type="number" class="form-control" id="contact_no"
                                            placeholder="Enter Contact Here" name="contact_no" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="Enter Email Here" name="email" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Position</label><br>
                                        <select id="position"  name="position">
                                            <option value="Receptionist">Receptionist</option>
                                            <option value="Fitness Coach">Fitness Coach</option>
                                            <option value="Facility Supervisor">Facility Supervisor</option>
                                            <option value="Accountant">Accountant</option>
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
                            <button type="submit" class="btn btn-primary px-3" id="submitStaffButton">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Staff -->
<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog modal-xl" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="editStaffModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form  id="editStaffForm"> 
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="staff_id" id="staff_id" value="">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Enter Name Here" name="name"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gym_name">Gym Name</label>
                                        <input type="text" class="form-control" id="gym_name"
                                            placeholder="Enter Name Here" name="gym_name" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth</label>
                                        <input type="date" class="form-control" id="dob"
                                            placeholder="Enter Date of Birth" name="dob"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address"
                                            placeholder="Enter Address Here" name="address" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_no">Contact No</label>
                                        <input type="number" class="form-control" id="contact_no"
                                            placeholder="Enter Contact Here" name="contact_no" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="Enter Email Here" name="email" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Position</label><br>
                                        <select id="position"  name="position">
                                            <option value="Receptionist">Receptionist</option>
                                            <option value="Fitness Coach">Fitness Coach</option>
                                            <option value="Facility Supervisor">Facility Supervisor</option>
                                            <option value="Accountant">Accountant</option>
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
                <input type="hidden" id="staffIdToDelete">
                 <p id="staffNameToDelete"></p>
                <!-- ... other modal content ... -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteStaff()">Delete</button>
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

    var staffTable = $('#staffTable').DataTable({
        destroy: true,
        processing: true,
        language: {
            processing: '<span style="color:black;">Processing...</span>'
        },
        serverSide: false,
        
        ajax: {
            url: "/allStaff",
            type: "POST",
            data: function(postData) {
                postData._token = $('meta[name="csrf-token"]').attr('content');
            }
        },
        scrollY: "55vh",
        scrollX: true,
    
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
        ],
        columns: 
        [
            {data: "sn"},
            {data: "serial_no"},
            {data: "photo"},
            {data: "name"},  //
            {data: "dob"},   //
            {data: "address"}, //
            {data: "position"},
            {data: "contact_no"}, //
            {data: "email"},  //
            {data: "action"},
        ],
    }); 

    $(document).on('click', '#add-staff-btn', function () 
    {
        $('#addStaffModal').find('#name, #dob, #address, #contact_no, #email').val('');
        $('#addStaffModal').find('input[type="file"]').val('');

        $('#addStaffModal').modal('show');
        
        $('#addStaffForm').on('submit', function(e) 
        {
            e.preventDefault();

            $('#submitStaffButton').prop('disabled', true);

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("staffs.save") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',  
                success: function (response) 
                {
                    if (response.success) 
                    {
                        toastr.success(response.success);
                        $('#addStaffModal').modal('hide').on('hidden.bs.modal', function () 
                        {
                            $('#submitStaffButton').prop('disabled', false);
                            window.location.reload(); 
                            staffTable.ajax.reload();  
                        });
                    }
                },
                error: function (xhr) 
                {
                    if (xhr.status === 422) 
                    {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                        $('#submitStaffButton').prop('disabled', false);
                    } 
                    else 
                    {
                        toastr.error('An error occurred while adding the staff.');
                        $('#submitStaffButton').prop('disabled', false);
                    }
                }
            });
        });
    });

    $(document).on('click', '.edit-staff-btn', function(e) 
    {
        e.preventDefault();

        var staffId = $(this).data('id'); 

        $.ajax({
            url: '/staff/' + staffId + '/edit',
            type: 'GET',
            success: function(response) 
            {
                if (response.success) 
                {
                    $('#editStaffForm #staff_id').val(response.staff.id);
                    $('#editStaffForm #name').val(response.staff.name);
                    $('#editStaffForm #gym_name').val(response.userName);
                    $('#editStaffForm #dob').val(response.staff.dob);
                    $('#editStaffForm #address').val(response.staff.address);
                    $('#editStaffForm #contact_no').val(response.staff.contact_no);
                    $('#editStaffForm #email').val(response.staff.email);
                    $('#editStaffForm #position').val(response.staff.position);
                    
                    $('#editStaffModal').modal('show');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to fetch staff details.');
            }
        });
    });

    $('#editStaffForm').on('submit', function(e) 
    {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '/staff/update', 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) 
            {
                if (response.success) 
                {
                    toastr.success(response.success);
                    $('#editStaffModal').modal('hide');
                    staffTable.ajax.reload();  
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
                    toastr.error('An error occurred while updating the staff.');
                }
            }
        });
    });

    $(document).on('click', '.delete-staff-btn', function (e) {
        e.preventDefault();

        var staffId = $(this).data('id');
        var staffName = $(this).data('name');
       
        $('#deleteModal').modal('show');
        $('#staffIdToDelete').val(staffId);
        $('#staffNameToDelete').text('Are you sure you want to delete ' + staffName + '?');
    });

    function deleteStaff() {
        var staffId = $('#staffIdToDelete').val();
      
        $.ajax({
            url: '/deletestaff/' + staffId, 
            type: 'GET', 
            success: function(response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    toastr.success(response.success);
                    staffTable.ajax.reload();
                }
            },
            error: function(xhr) {
                toastr.error('An error occurred while deleting the staff.');
            }
        });
    }; 
</script>

<!--  -->
@endsection