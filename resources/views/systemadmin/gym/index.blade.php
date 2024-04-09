@extends('admin.admin')
@section('title','Dashboard')
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
                            
                            <div class="card-body table-responsive p-2">
                                <table class="datatable table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>                                          
                                            <th>Name</th>                                            
                                            <th>Email</th>
                                            <th>Joined Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gyms as $gym)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$gym->name}}</td>                                            
                                            <td>{{$gym->email}}</td>
                                            <td>{{$gym->created_at}}</td>
                                         
                                            <td>
                                            {{-- <a href="{{route('member.edit', $member->id)}}" title="Edit Member">
                                                        <i class="fas fa-edit fa-lg"></i></a> --}}
                                            <a type="button"  data-toggle="modal" data-target="#deleteModal"  data-gym-id="{{$gym->id}}"
                                             data-gym-name="{{$gym->name}}"
                                             href="#" title="Delete Member">
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