@extends('admin.admin')
@section('title','Dashboard')
@section('content')


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
              <div>
                <select class="form-select">
                  <option value="1">March 2023</option>
                  <option value="2">April 2023</option>
                  <option value="3">May 2023</option>
                  <option value="4">June 2023</option>
                </select>
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
        <div class="row">
          <div class="col-lg-12">
            <!-- Yearly Breakup -->
            <div class="card w-100 shadow">
              <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Yearly Breakup</h5>
                <div class="row align-items-center">
                  <div class="col-8">
                    <h4 class="fw-semibold mb-3">$36,358</h4>
                    <div class="d-flex align-items-center mb-3">
                      <span
                        class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                      <p class="fs-3 mb-0">last year</p>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="me-4">
                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                        <span class="fs-2">2023</span>
                      </div>
                    
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="d-flex justify-content-center">
                      <div id="breakup"></div>
                    </div>
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
                                @endforeach                     
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  
  
    </div>
    <div class="row">
     
      
     
    </div>
    
  </div>

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
</script>
@endsection