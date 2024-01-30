@extends('admin.admin')
@section('title','Equipments')
@section('content')

<div class="content">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Equipments</li>
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
                                {{-- {{route('member.create')}} --}}
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
                                            <th>Maintainence Period</th>
                                            <th>Upcoming Maintenance</th>                                   
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach () --}}
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                   
                                            </td>
                                            <td></td>
                                            <td></td>
                                            
                                            <td></td>
                                            <td></td>
                                            <td>
                                            {{-- <a href="{{route('member.edit', $member->id)}}" title="Edit Member">
                                                        <i class="fas fa-edit fa-lg"></i></a>
                                            <a type="button"  data-toggle="modal" data-target="#deleteModal"  data-member-id="{{$member->id}}"
                                             data-member-name="{{$member->name}}"
                                             href="#" title="Delete Member">
                                            <i class="fas fa-times-circle fa-lg" style="color: red;"></i>
                                            </a>                                         --}}
                                            </td>

                                        </tr>
                                        {{-- @endforeach     --}}
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
</script>

<!--  -->
@endsection