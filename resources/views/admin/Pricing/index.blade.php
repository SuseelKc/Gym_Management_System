@extends('admin.admin')
@section('title','Pricing & Packages')
@section('content')

<div class="content">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Pricing & Packages</li>
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
                                {{route('pricing.create')}}
                                "
                                    class="btn btn-primary px-4 m-2 float-right">Create</a>  
                            </div>
                            <div class="card-body table-responsive p-2">
                                <table class="datatable table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>                         
                                            <th>Costs</th>
                                            <th>Costs Type</th>                                                                                  
                                            <th>Start Date</th>                                            
                                            <th>End Date</th>                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pricing as $pricing)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$pricing->name}}</td>                  
                                            <td>{{$pricing->costs}}</td>

                                            {{-- @if($pricing->weight)
                                                <td>{{$pricing->weight}} KG</td>
                                            
                                            @else
                                                <td></td>
                                            
                                            @endif --}}

                                            <td>{{$pricing->costs_type}}</td>
                                            <td>{{$pricing->start_date}}</td>
                                            <th>{{$pricing->end_date}}</th>                                     
                                            {{-- <td>
                                                <a href="{{route('equipments.edit', $equipment->id)}}" title="Edit Equipments">
                                                            <i class="fas fa-edit fa-lg"></i></a>
                                                <a type="button"  data-toggle="modal" data-target="#deleteModal"  data-equipment-id="{{$equipment->id}}"
                                                data-equipment-name="{{$equipment->name}}"
                                                href="#" title="Delete Equipment">
                                                <i class="fas fa-times-circle fa-lg" style="color: red;"></i>
                                                </a>                                        
                                            </td> --}}

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
                <input type="hidden" id="equipmentIdToDelete">
                 <p id="equipmentNameToDelete"></p>
                <!-- ... other modal content ... -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteEquipment()">Delete</button>
            </div>
    </div>
  </div>
</div>
<!--  -->
<script>
    $(document).ready(function () {
        // Update the modal input field when the anchor tag is clicked
        $('a[data-target="#deleteModal"]').on('click', function () {
            var equipmentId = $(this).data('equipment-id');
            var equipmentName = $(this).data('equipment-name');

            $('#equipmentIdToDelete').val(equipmentId);
            $('#equipmentNameToDelete').text('Are you sure you want to delete ' + equipmentName + '?');
        });

        // Function to handle the delete button click
        window.deleteEquipment = function () {
            // Get the ID from the input field
            var equipmentId = $('#equipmentIdToDelete').val();

            // Construct the delete route with the equipmentId
            var deleteRoute = '{{ route("equipments.delete", ":id") }}';
            deleteRoute = deleteRoute.replace(':id', equipmentId);

            // Perform the delete operation by navigating to the delete route
            window.location.href = deleteRoute;
        };
    });
</script>

<!--  -->
@endsection