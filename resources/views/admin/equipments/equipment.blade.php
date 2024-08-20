@extends('admin.admin')
@section('title','Equipment')
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
                            <li class="breadcrumb-item active">Equipment</li>
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
                                <button class="btn btn-primary px-4 m-2 float-right" id="add-equipment-btn">Add</button>
                            </div>
                            <div class="card-body table-responsive p-2">
                                <table class="table table-hover table-bordered display compact" id="equipmentTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>ID No.</th>
                                            <th>Image</th>
                                            <th>Name</th>     
                                            <th>Weight</th>
                                            <th>Qty</th>
                                            <th>Maintainence Period</th>
                                            <th>Maintainence Type</th>
                                            <th>Upcoming Maintainence</th>  
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


<!-- Modal for Adding equipment -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" role="dialog modal-xl" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="addStaffModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffModalLabel">Add Equipment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form  id="addEquipmentForm"> 
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                {{-- <input type="hidden" name="member_id" id="member_id" value=""> --}}
                                
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
                                        <label for="weight">Weight(KG)</label>
                                        <input type="number" class="form-control" id="weight"
                                        placeholder="Enter Weight Here" name="weight"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="qty">Quantity</label>
                                        <input type="decimal" class="form-control" id="qty"
                                            placeholder="Enter Quantity Here" name="qty" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maintenance_period">Maintenance Period (Gap)</label>
                                        <div class="d-flex align-items-center">
                                            <input type="number" class="form-control mr-2" id="maintenance_period_input" style="width: 150px;"
                                                   name="maintenance_period" value="">
                                            <select id="maintenance_type" style="height: 30px;" name="maintenance_type">
                                                <option value="year">Year</option>
                                                <option value="month">Month</option>
                                                <option value="days">Days</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="photo">Upload Image</label>
                                        <input type="file" class="form-control" id="photo" name="photo" >
                                    </div>
                                </div>
                              
                                
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary px-3" id="submitEquipmentButton">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Equipment -->
<div class="modal fade" id="editEquipmentModal" tabindex="-1" role="dialog modal-xl" aria-labelledby="editEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="editEquipmentModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEquipmentModalLabel">Edit Equipment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form  id="editEquipmentForm"> 
                        @csrf
                        <div class="card-body">
                          <div class="row">
                            <input type="hidden" name="equipment_id" id="equipment_id" value="">

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
                                    <label for="weight">Weight(KG)</label>
                                    <input type="number" class="form-control" id="weight"
                                    placeholder="Enter Weight Here" name="weight"  >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="decimal" class="form-control" id="qty"
                                        placeholder="Enter Quantity Here" name="qty" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maintenance_period">Maintenance Period (Gap)</label>
                                    <div class="d-flex align-items-center">
                                        <input type="number" class="form-control mr-2" id="maintenance_period_input" style="width: 150px;"
                                               name="maintenance_period" value="">
                                        <select id="maintenance_type" style="height: 30px;" name="maintenance_type">
                                            <option value="year">Year</option>
                                            <option value="month">Month</option>
                                            <option value="days">Days</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">Upload Image</label>
                                    <input type="file" class="form-control" id="photo" name="photo" >
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var equipmentTable = $('#equipmentTable').DataTable({
            destroy: true,
            processing: true,
            language: {
                processing: '<span style="color:black;">Processing...</span>'
            },
            serverSide: false,
            
            ajax: {
                url: "/fetchEquipments",
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
            columns: [
                {data: "sn"},
                {data: "serial_no"},
                {data: "image"},
                {data: "name"},
                {data: "weight"},
                {data: "qty"},
                {data: "maintenance_period"},
                {data: "maintenance_type"},
                {data: "upcoming_date"},
                {data: "action"},
        ],
        }); 

        $(document).on('click', '#add-equipment-btn', function () 
        {
        $('#addEquipmentModal').find('#name, #weight, #qty, #maintenance_period').val('');  // resets the value of the model fields if there exits value before 
        $('#addEquipmentModal').find('input[type="file"]').val(''); // resets the file submitted if there is entered before

        $('#addEquipmentModal').modal('show'); // show model
        
        $('#addEquipmentForm').on('submit', function(e) 
        {
            e.preventDefault();

            $('#submitEquipmentButton').prop('disabled', true);

            var formData = new FormData(this);

            $.ajax({
                
                url: '{{ route("equipments.save") }}',
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
                        $('#addEquipmentModal').modal('hide').on('hidden.bs.modal', function () 
                        {
                            $('#submitEquipmentButton').prop('disabled', false);
                            window.location.reload(); 
                            equipmentTable.ajax.reload();  
                            
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
                        $('#submitEquipmentButton').prop('disabled', false);
                    } 
                    else 
                    {
                        toastr.error('An error occurred while adding the equipment.');
                        $('#submitEquipmentButton').prop('disabled', false);
                    }
                }
            });
        });
    });

    $(document).on('click', '.edit-equipment-btn', function(e) 
    {
        e.preventDefault();

        var equipmentId = $(this).data('id'); 

        $.ajax({
            url: '/equipment/' + equipmentId + '/edit',
            type: 'GET',
            success: function(response) 
            {
                if (response.success) 
                {
                    $('#editEquipmentForm #equipment_id').val(response.equipment.id);
                    $('#editEquipmentForm #name').val(response.equipment.name);
                    $('#editEquipmentForm #gym_name').val(response.gymName);
                    $('#editEquipmentForm #weight').val(response.equipment.weight);
                    $('#editEquipmentForm #qty').val(response.equipment.qty);
                    $('#editEquipmentForm #maintenance_period_input').val(response.equipment.maintenance_period);
                    $('#editEquipmentForm #maintenance_type').val(response.equipment.maintenance_type);

                    
                    $('#editEquipmentModal').modal('show');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to fetch equipment details.');
            }
        });
    });

  

</script>    
@endsection