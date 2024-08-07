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
                        <label for="name">Name</label>
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
                        <select id="pricing" name="pricing">
                            <option value="">Not Selected</option>
                            @foreach($pricing as $packageItem)
                                <option value="{{ $packageItem['id'] }}">{{ $packageItem['name'] }}</option>
                            @endforeach
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
            <button type="submit" class="btn btn-primary px-3" id="submitForm">Submit</button>
        </div>
    </form>
</div>