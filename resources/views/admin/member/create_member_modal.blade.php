<!-- resources/views/modals/create_member_modal.blade.php -->

<div class="modal-header">
    <h5 class="modal-title" id="createMemberModalLabel">Add Member</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form  id="saveMemberForm"> 
        @csrf
        <div class="card-body">
            <div class="row">
                <!-- name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name Here" name="name" >
                    </div>
                </div>
                <!--  -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gym_name">Gym Name</label>
                        <input type="text" class="form-control" id="gym_name" placeholder="Enter Name Here" name="gym_name" value="{{ $gym->name }}" readonly>
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
                        <select id="pricing" name="pricing" class="form-control">
                            <option value="">-- Select Package --</option>
                            @foreach($pricing as $packageItem)
                                <option value="{{ $packageItem['id'] }}">{{ $packageItem['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="shift">Shift</label><br>
                        <select id="shift" name="shift" class="form-control">
                            <option value="Morning">Morning</option>
                            <option value="Day">Day</option>
                            <option value="Evening">Evening</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date"  name="start_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date"  name="end_date" value="" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="admission_charge">Admission Charge</label><br>
                        <input type="radio" id="admission_charge_yes" name="admission_charge_toggle" value="yes" checked>
                        <label for="admission_charge_yes">Yes</label>

                        <input type="radio" id="admission_charge_no" name="admission_charge_toggle" value="no">
                        <label for="admission_charge_no">No</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="photo">Upload Image</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                </div>
                <div class="col-md-6" id="admissionChargeField">
                    <div class="form-group">
                        <label for="admission_charge_amount">Admission Charge Amount</label>
                        <input type="number" class="form-control" id="admission_charge_amount" name="admission_charge" value="1000">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary px-3" id="submitForm">Submit</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('input[name="admission_charge_toggle"]').on('change', function () {
            if ($('#admission_charge_yes').is(':checked')) {
                $('#admissionChargeField').show();
            } else {
                $('#admissionChargeField').hide();
            }
        });

        $('input[name="admission_charge_toggle"]').trigger('change');

        $('#pricing').on('change', function() 
        {
            var packageId = $(this).val();
            var startDate = $('#start_date').val();

            if (packageId) {
                $.ajax({
                    url: '/get-package-duration', 
                    type: 'POST',
                    data: {
                        package_id: packageId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.duration) {
                            var durationDays = parseInt(response.duration);
                            var endDate = new Date(startDate);
                            endDate.setDate(endDate.getDate() + durationDays);

                            $('#end_date').val(endDate.toISOString().split('T')[0]);
                            $('#end_date').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('An error occurred while retrieving package duration.');
                    }
                });
            } else {
                $('#end_date').val('');
                $('#end_date').prop('disabled', true);
            }
        });

        $('#start_date').on('change', function() {
            $('#pricing').trigger('change');
        });
    });
</script>