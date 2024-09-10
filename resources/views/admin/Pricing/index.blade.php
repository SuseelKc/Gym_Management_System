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
                                            <th>Package Name</th>                        
                                            <th>Price</th>
                                            <!-- <th>Duration Days</th> -->
                                            <th>Duration</th>
                                            <!-- <th>Start Date</th> 
                                            <th>End Date</th>  -->
                                            <th>Members Enrolled</th>                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pricing as $pricing)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$pricing->name}}</td>                  
                                            <td>{{$pricing->costs}}</td> 
                                            <!-- <td>{{$pricing->duration}}</td>                                          -->
                                            <td>{{$pricing->duration}} {{$pricing->costs_type}}</td>
                                            <!-- <td>{{$pricing->start_date}}</td>
                                            <td>{{$pricing->end_date}}</td>    -->
                                            <!-- <td>{{$pricing->members_count}} Members</td>                                   -->
                                            <td>hello</td>
                                            <td>
                                                <a href="{{route('pricing.edit', $pricing->id)}}" title="Edit Package">
                                                            <i class="fas fa-edit fa-lg"></i></a>
                                                <a type="button"  data-toggle="modal" data-target="#deleteModal"  data-pricing-id="{{$pricing->id}}"
                                                data-pricing-name="{{$pricing->name}}"
                                                href="#" title="Delete Package">
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
                <input type="hidden" id="pricingIdToDelete">
                 <p id="packageNameToDelete"></p>
                <!-- ... other modal content ... -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deletePricing()">Delete</button>
            </div>
    </div>
  </div>
</div>
<!--  -->
<script>
    $(document).ready(function () {
        // Update the modal input field when the anchor tag is clicked
        $('a[data-target="#deleteModal"]').on('click', function () {
            var pricingId = $(this).data('pricing-id');
            var pricingName = $(this).data('pricing-name');

            $('#pricingIdToDelete').val(pricingId);
            $('#packageNameToDelete').text('Are you sure you want to delete ' + pricingName + ' package ?');
        });

        // Function to handle the delete button click
        window.deletePricing = function () {
            // Get the ID from the input field
            var pricingId = $('#pricingIdToDelete').val();

            // Construct the delete route with the pricingId
            var deleteRoute = '{{ route("pricing.delete", ":id") }}';
            deleteRoute = deleteRoute.replace(':id', pricingId);

            // Perform the delete operation by navigating to the delete route
            window.location.href = deleteRoute;
        };
    });
</script>

<!--  -->
@endsection