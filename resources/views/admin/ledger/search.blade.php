@extends('admin.admin')
@section('title', 'Payment Ledger')
@section('content')
{{--  --}}
<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item active">Gym Clients</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card" id="memberPaymentSection" style="display: none;">
                <div class="card-primary">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h6 class="card-title font-weight-bold mb-0">Member Payment Details</h6>
                        </div>
                    </div>
                    <form method="POST" action=" 
                        {{-- {{route('pricing.store')}} --}}
                        " enctype="multipart/form-data">
                            @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="member_name">Member Name</label>
                                        <input type="text" class="form-control" id="member_name"
                                            placeholder="Enter Name Here" name="member_name" value="{{ $selectedMember->name }}" readonly>
                                        @if ($errors->has('member_name'))
                                            <x-validation-errors>
                                                {{ $errors->first('member_name') }}
                                            </x-validation-errors>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amt_paid">Amount Paid</label>
                                        <input type="number" class="form-control" id="amt_paid"
                                            placeholder="Enter Amount Paid" name="amt_paid" value="" > 
                                        @if ($errors->has('amt_paid'))
                                            <x-validation-errors>
                                                {{ $errors->first('amt_paid') }}
                                            </x-validation-errors>
                                        @endif                                 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="receipt_no">Receipt No</label>
                                        <input type="number" class="form-control" id="receipt_no"
                                            placeholder="Enter Record number" name="receipt_no" value="" > 
                                        @if ($errors->has('receipt_no'))
                                            <x-validation-errors>
                                                {{ $errors->first('receipt_no') }}
                                            </x-validation-errors>
                                        @endif                                   
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <input type="text" class="form-control" id="remarks"
                                            placeholder="Enter Remarks if any" name="remarks" value="" > 
                                        @if ($errors->has('remarks'))
                                            <x-validation-errors>
                                                {{ $errors->first('remarks') }}
                                            </x-validation-errors>
                                        @endif                                   
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary px-3">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </section>
    
    
              

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="ml-2 mt-3 mb-3">
                                    <label>Members</label>
                                    <select name="members" id="members">
                                        <option href="" value="">Select Memeber</option>
                                        @foreach($members as $singleMember)
                                            <option value="{{ $singleMember['id'] }}" {{ old('members') == $singleMember['id'] ? 'selected' : '' }}>{{ $singleMember['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <a href="#" class="btn btn-primary" id="searchBtn" style="padding: 4px 10px;"><i class='fas fa-search'></i></a>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="ml-3 mt-4 mb-0 text-center">
                                    <h5>
                                        <label style="font-weight: bold; color: #007bff;">Member :</label>
                                        <span >{{ $selectedMember->name }}</span> <span >({{ $selectedMember->serial_no }})</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="ml-3 mt-1 mb-3 text-center">
                                    <a href="#"
                                    class="btn btn-primary px-4 m-2 float-right" id="addPaymentBtn">Add Payment</a>  
                                </div>
                            </div>

                        </div>
                        
                       
                        <div class="card-body table-responsive p-2">
                            <table class="datatable table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                                                          
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ledger as $ledger)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$ledger->date}}</td>
                                        <td>{{$ledger->debit}}</td>
                                        <td>{{$ledger->credit}}</td>
                                        <td>{{$ledger->balance}}</td>
                                        
                                        <td></td>
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
    <script>
        $(document).ready(function() {
            $('#members').on('change', function(){
                var memberId = $(this).val();
                console.log("Selected member ID:", memberId); // Debugging line
                
                // Construct the URL dynamically with the selected member's ID
                var url = "{{ route('ledger.search', ':id') }}";
                url = url.replace(':id', memberId);
                console.log("Dynamic URL:", url); // Debugging line
                
                // Update the href attribute of the search button with the constructed URL
                $('#searchBtn').attr('href', url);
                console.log("Href updated:", $('#searchBtn').attr('href')); // Debugging line
            });

            // Handle click event for Add Payment button
            $('#addPaymentBtn').on('click', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Show the section with the member name input field
                $('#memberPaymentSection').show();
            });
        });
    </script>
@endsection
