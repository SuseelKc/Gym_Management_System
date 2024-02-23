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
                        <li class="breadcrumb-item active">Payment Ledger</li>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="ml-2 mt-3 mb-3">
                                    <label>Members</label>
                                    <select name="members" id="members">
                                        <option href="{{route('ledger.index')}}" value="">Select Memeber</option>
                                        @foreach($members as $singleMember)
                                            <option value="{{ $singleMember['id'] }}">{{ $singleMember['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <a href="#" class="btn btn-primary" id="searchBtn" style="padding: 4px 10px;"><i class='fas fa-search'></i></a>

                                </div>
                            </div>
                           
                        </div>

                        <div class="card-body table-responsive p-2">
                            <table class="datatable table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Member S.No</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>Member Name</th>
                                      
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ledger as $ledger)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$ledger->date}}</td>
                                        <td>{{$ledger->member->serial_no}}</td>
                                        <td>{{$ledger->debit}}</td>
                                        <td>{{$ledger->credit}}</td>
                                        <td>{{$ledger->balance}}</td>
                                        <td>{{$ledger->member->name}}</td>
                                       
                                   
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
        });
    </script>
@endsection
