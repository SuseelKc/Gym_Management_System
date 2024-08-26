@extends('admin.admin')
@section('title','Dashboard')
@section('content')



<div class="container-fluid pt-2 pd-2">
        <!--  Row 1 -->
        <div class="row">
            <div class="col-lg-8 d-flex align-items-strech">
                <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Sales Overview</h5>
                    </div>
                    
                    </div>
                    <div id="chart">
                    <div>
                        {!! $chart->container() !!}
                    </div>
                
                    {!! $chart->script() !!}
                    </div>
                </div>
                </div>
            </div>

            <div class="col-lg-4">
            
                <div class="col-lg-12">
                    <div class="card w-100 shadow">
                        <div class="card-body p-2">
                            <div class="col mb-2">
                                <h5 class="card-title mb-1 mr-3 fw-semibold">Member Details</h5>
                                <br>
                                <div class="mb-2 mt-2" style="float: left;">
                                    <div style="display: flex; align-items: center; width: 100%;">
                                        <input list="membersList" id="membersInput" class="form-control" placeholder="Search or select a member..." style="width: calc(100% - 10px); max-width: 600px; margin-right: 10px;">
                                        <a href="#" class="btn btn-primary" id="searchBtn">
                                            <i class='fas fa-search'></i>
                                        </a>
                                    </div>
                                    <datalist id="membersList">
                                        @foreach($members as $member)
                                            <option data-id="{{ $member->id }}" value="{{ $member->name . ' - ' . $member->serial_no }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
                
                
                    
                {{--  --}}
                    <div class="col-lg-12">
                        <!-- Yearly Breakup -->
                        <div class="card w-100 shadow">
                            <div class="card-body p-4">
                                {{-- <h5 class="card-title mb-9 fw-semibold">Memebership Expired Members</h5> --}}
                                <div class="mb-4">    
                                    <h5 class="card-title mb-9 fw-semibold">Members Overall</h5>                             
                                </div>
                                            <div style="width: 80%; margin: auto;">
                                                <canvas id="pieChart"></canvas>
                                            </div>                              
                            </div>
                        </div>
                    </div>

                {{--  --}}

            
            </div>
    
        </div>

        <div class="row">
                <div class="col-lg-5 d-flex align-items-stretch">
                <div class="card w-100 shadow">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="card-title fw-bold mb-4">Recent Transactions</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topTransactions as $topTransaction)
                                    <tr>
                                        <td>
                                            {{ $topTransaction->created_at->format('M d, Y') }}  
                                            {{ $topTransaction->created_at->format('h:i A') }}</td>
                                        <td>{{ $topTransaction->member->name }}</td>
                                        <td>{{ $topTransaction->credit }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
        
            <div class="col-lg-7 d-flex align-items-stretch">
                <div class="card w-100 shadow">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Member Balance Reminder</h5>
                        <div class="table-responsive">
                        <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Member SNo.</th>
                                        <th>Name</th>
                                        <th>Priority</th>
                                        <th>Remaining Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestRecords->sortByDesc('balance') as $latestRecord)
                                    @if($latestRecord->balance>0)
                                    <tr>
                                        <td><h6 class="fw-bold mb-0">{{$latestRecord->member->serial_no}}</h6></td>
                                        <td>
                                            <h6 class="fw-bold mb-1">{{$latestRecord->member->name}}</h6>
                                        </td>              
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($latestRecord->balance >= 10000 )
                                                    <span class="badge bg-danger rounded-3 fw-bold">High</span>
                                                @elseif($latestRecord->balance >= 5000 && $latestRecord->balance < 10000 )
                                                    <span class="badge bg-warning rounded-3 fw-bold">Medium</span>
                                                @else
                                                    <span class="badge bg-info rounded-3 fw-bold">Low</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="fw-bold mb-0 fs-4">{{$latestRecord->balance}}</h6>
                                        </td>
                                    </tr> 
                                    @endif
                                    @endforeach                     
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    
    
</div>

{{-- modal for viewing memeber details --}}
<!-- Modal -->

<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">Member Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Member details will be loaded here -->
                <div id="memberDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

  



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('pieChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($data['labels']),
            datasets: [{
                data: @json($data['data']),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.9)',// Expired Member
                    'rgba(255, 99, 132, 0.9)' // Total Member
                        
                    // Add more colors if needed
                ],
                hoverOffset: 9, // Offset when hovering over slices
                borderWidth: 0 // Remove border around slices
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom', // Position of the legend
                    labels: {
                        boxWidth: 15, // Width of the colored boxes
                        usePointStyle: true, // Use point style for legend icons
                        font: {
                            size: 14 // Font size of legend labels
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)', // Background color of tooltips
                    titleColor: '#fff', // Font color of tooltip titles
                    bodyColor: '#fff', // Font color of tooltip body text
                    titleFont: {
                        size: 16, // Font size of tooltip titles
                        weight: 'bold' // Font weight of tooltip titles
                    },
                    bodyFont: {
                        size: 14 // Font size of tooltip body text
                    },
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.formattedValue; // Custom tooltip label
                        }
                    }
                }
            },
            animation: {
                animateRotate: true, // Enable rotation animation
                animateScale: true // Enable scaling animation
            },
            elements: {
                arc: {
                    borderColor: '#fff', // Border color of arcs
                    borderWidth: 2 // Border width of arcs
                }
            }
        }
    });

        // pop up the modal
        $(document).ready(function() {
        $('#searchBtn').on('click', function() {
            var input = $('#membersInput').val();
            var selectedOption = $('#membersList option[value="' + input + '"]');
            var memberId = selectedOption.data('id'); // Get the ID from the data-id attribute
            
            if (memberId) {
                $.ajax({
                    url: '/fetch/member-details',  // Change this to your actual route
                    type: 'GET',
                    data: { member_id: memberId }, // Send the member ID as the query parameter
                    success: function(data) {
                        // Populate the modal with member details
                        $('#memberDetails').html(data);

                        // Show the modal
                        $('#memberModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching member details:', error);
                    }
                });
            } else {
                console.error('No matching member found');
            }
        });
    });


</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@endsection