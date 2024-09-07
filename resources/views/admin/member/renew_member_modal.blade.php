<!-- resources/views/modals/renew_member_modal.blade.php -->

<div class="modal-header">
    <h5 class="modal-title" id="renewMemberModalLabel"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form  id="renewMemberForm"> 
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pricing_renew">Package</label><br>
                        <select id="pricing_renew" name="pricing_renew" class="form-control">
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
                        <label for="renew_start_date">Start Date</label>
                        <input type="date" class="form-control" id="renew_start_date"  name="renew_start_date" value="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="renew_end_date">End Date</label>
                        <input type="date" class="form-control" id="renew_end_date"  name="renew_end_date" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary px-3" id="renewsubmitForm">Submit</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () 
    {
        $('#pricing_renew').on('change', function() 
        {
            var packageId = $(this).val();
            var startDate = $('#renew_start_date').val();
            
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

                            $('#renew_end_date').val(endDate.toISOString().split('T')[0]);
                            $('#renew_end_date').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('An error occurred while retrieving package duration.');
                    }
                });
            } else {
                $('#renew_end_date').val('');
                $('#renew_end_date').prop('disabled', true);
            }
        });

        $('#renew_start_date').on('change', function() {
            $('#pricing_renew').trigger('change');
        });
    });
</script>