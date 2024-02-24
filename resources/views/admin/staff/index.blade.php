@extends('admin.admin')
@section('title','Staff')
@section('content')



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
                                <a href="
                                {{route('staffs.create')}}
                                "
                                    class="btn btn-primary px-4 m-2 float-right">Add</a>  
                            </div>
                            <div class="card-body table-responsive p-2">
                                <table class="datatable table">
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
                                    <tbody>
                                        @foreach ($staff as $staff)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$staff->serial_no}}</td>
                                            <td>                                                                
                                                @if ($staff->photo == null)
                                                    <img src = "/images/defaultimage.jpg" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">
                                                 
                                                @else
                                                    <img src = "/images/staff/{{$staff->photo}}" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">
                                                @endif
                                            </td>
                                            <td>{{$staff->name}}</td>                             
                                            <td>{{$staff->dob}}</td>
                                            <td>{{$staff->address}}</td>
                                            <td>{{$staff->position}}</td>
                                            <td>{{$staff->contact_no}}</td>
                                            <td>{{$staff->email}}</td>
                                            <td>
                                            <a href="{{route('staffs.edit', $staff->id)}}" title="Edit Staff">
                                                        <i class="fas fa-edit fa-lg"></i></a>
                                            <a type="button"  data-toggle="modal" data-target="#deleteModal"  data-staff-id="{{$staff->id}}"
                                             data-equipment-name="{{$staff->name}}"
                                             href="#" title="Delete staff">
                                            <i class="fas fa-times-circle fa-lg" style="color: red;"></i>
                                            </a>                                        
                                            </td>

                                        </tr>
                                        @endforeach    
                                    </tbody>
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
    $(document).ready(function () {
        // Update the modal input field when the anchor tag is clicked
        $('a[data-target="#deleteModal"]').on('click', function () {
            var staffId = $(this).data('staff-id');
            var staffName = $(this).data('equipment-name');

            $('#staffIdToDelete').val(staffId);
            $('#staffNameToDelete').text('Are you sure you want to delete ' + staffName + '?');
        });

        // Function to handle the delete button click
        window.deleteStaff = function () {
            // Get the ID from the input field
            var staffId = $('#staffIdToDelete').val();

            // Construct the delete route with the staffId
            var deleteRoute = '{{ route("staffs.delete", ":id") }}';
            deleteRoute = deleteRoute.replace(':id', staffId);

            // Perform the delete operation by navigating to the delete route
            window.location.href = deleteRoute;
        };
    });
</script>

<!--  -->
@endsection