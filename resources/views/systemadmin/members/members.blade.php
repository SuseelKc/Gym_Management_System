@extends('admin.admin')
@section('title','Gym Memebers')
@section('content')
<div class="content">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Gym Members</li>
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
                            <label for="memberSelect">Select Member:</label>
                            <select name="member_id" id="memberSelect" class="form-control" required onchange="fetchMemberDetails()">
                                <option value="">-- Select a Member --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                             
                                
                       
                                <input type="text" class="form-control" id="name"
                                                placeholder="Name" name="name" value="" readonly>
                                <input type="text" class="form-control" id="dob"
                                                placeholder="dob" name="dob" value="" readonly>
                                <input type="text" class="form-control" id="address"
                                                placeholder="address" name="address" value="" readonly>
                                <input type="text" class="form-control" id="contact_no"
                                                placeholder="contact_no" name="contact_no" value="" readonly>  
                                                                            
                                                    
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                       
                                        <div class="card-body table-responsive p-2 table-container">
                                            <table class="table table-hover table-bordered display compact" id="ledgerTable">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>                                   
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                        <th>Balance</th>   
                                                        <th>Remarks</th>                                                                                           
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                          
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>   

<script>
function fetchMemberDetails(){
    var memberId= document.getElementById('memberSelect').value;
    
    if(memberId){
        $.ajax({
            url: '/getMemberDetails/'+memberId, //fetches the data 
            type: 'GET',
            success: function(response){
                if (response.success) {
                    document.getElementById('name').value = response.member.name;
                    document.getElementById('dob').value = response.member.dob;
                    document.getElementById('address').value = response.member.address;
                    document.getElementById('contact_no').value = response.member.contact_no;

             
                } else {
                    toastr.error('Member details not found.');
                }
            },
            error: function() {
                toastr.error('An error occurred while fetching member details.');
            }
        });   
    }
    else {
        document.getElementById('name').value = '';
        document.getElementById('dob').value = '';
        document.getElementById('address').value = '';
        document.getElementById('contact_no').value = '';

        
    }


// for ledger display of that particular member ledger 

//create ajax table here
var ledgerTableBody = document.getElementById('ledgerTable').getElementsByTagName('tbody')[0];

// Clear the table first
ledgerTableBody.innerHTML = '';

if(memberId){

    $.ajax({
            url: '/fetchledger/'+memberId, //fetches the data 
            type: 'GET',
            success: function(response){
                if (response.success) {
                    
                     // Populate ledger data
                    var ledgerTableBody = document.getElementById('ledgerTable').getElementsByTagName('tbody')[0];
                    ledgerTableBody.innerHTML = ''; // Clear the table first
                    response.ledger.forEach(function(entry, index) {
                        var row = ledgerTableBody.insertRow();
                        row.insertCell(0).textContent = index + 1;
                        row.insertCell(1).textContent = entry.debit;
                        row.insertCell(2).textContent = entry.credit;
                        row.insertCell(3).textContent = entry.balance;
                        row.insertCell(4).textContent = entry.remarks;
                    });
                } else {
                    toastr.error('Member details not found.');
                }
            },
            error: function() {
                toastr.error('An error occurred while fetching member details.');
            }
        }); 
}
else {

    var ledgerTableBody = document.getElementById('ledgerTable').getElementsByTagName('tbody')[0];
    ledgerTableBody.innerHTML = '';
}


}



</script>
@endsection