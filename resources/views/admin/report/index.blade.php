@extends('admin.admin')
@section('title','Report')
@section('content')

<style>
    .card {
        transition: all 0.2s ease-in-out; /* Add smooth transition effect */
    }
    
    .card:hover {
        background-color: #f0f0f0; /* Change to your desired hover background color */
        box-shadow: 0 4px 8px rgba(43, 42, 42, 0.1); /* Add a shadow effect on hover */
        transform: translateY(-4px); /* Lift the card slightly on hover */
    }
    .title-head {
        color: #000000; /* Black color */
        font-weight: bold;
    }

    @media print {
        #pdfButton,#timePeriod  {
                display: none; /* Hide all elements by default */
            }
            
        }
        
</style>
<div class="container-fluid pt-2 pd-2">
    
    <div class="row indicators">
        {{-- Net Income --}}
        <div class="col-lg-3 d-flex align-items-stretch">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 title-head">Net Income</h6>
                        <h5 class="mb-0 title-head">RS {{$NetIncome}}</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <i class="fas fa-money-bill mr-2 text-primary"></i>
                            @if($NetIncome>$NetIncomeUptoPreviousMth)
                            <i class="fas fa-arrow-up text-success mr-2"></i>
                            @elseif($NetIncome == $NetIncomeUptoPreviousMth)
                            @else
                            <i class="fas fa-arrow-down text-danger"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-primary">{{$NetIncomeChange}}</span>
                            @if($NetIncome>$NetIncomeUptoPreviousMth)
                            <span class="text-success ml-3">Increase</span>
                            @elseif($NetIncome == $NetIncomeUptoPreviousMth)
                            No Changes
                            @else
                            <span class="text-danger ml-3">Decrease</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  --}}
        {{-- Top Selling Package --}}
        <div class="col-lg-3 d-flex align-items-stretch">
            <a href="{{ route('member.index') }}" class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 title-head">Total Members</h6>
                        <h5 class="mb-0 title-head" >{{$totalMembers}}</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <i class="fas fa-users mr-2 text-primary"></i>
                            @if($latestTotalMembers > $previousTotalMembers)
                                <i class="fas fa-arrow-up text-success mr-2"></i>
                            @elseif($latestTotalMembers == $previousTotalMembers)

                            @else
                                <i class="fas fa-arrow-down text-danger"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-primary">{{$latestTotalMembers - $previousTotalMembers}} Members</span>
                            @if($latestTotalMembers > $previousTotalMembers)
                                <span class="text-success ml-3">Increase</span>
                            @elseif($latestTotalMembers == $previousTotalMembers)
                                <span class="text-secondary ml-3">No Changes</span>
                            @else
                                <span class="text-danger ml-3">Decrease</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        {{--  --}}

        {{-- equipments --}}
        <div class="col-lg-3 d-flex align-items-stretch">
            <a href="{{ route('equipments.index') }}" class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 title-head">Total Equipments</h6>
                        <h5 class="mb-0 title-head" >{{$totalEquipments}}</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <i class="fas fa-dumbbell mr-2 text-primary"></i>
                            @if($latestTotalEquipments > $previousTotalEquipments)
                                <i class="fas fa-arrow-up text-success mr-2"></i>
                            @elseif($latestTotalEquipments == $previousTotalEquipments)   

                            @else
                                <i class="fas fa-arrow-down text-danger"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-primary">{{$latestTotalEquipments-$previousTotalEquipments}} Equipments</span>
                            @if($latestTotalEquipments > $previousTotalEquipments)
                                <span class="text-success ml-3">Added</span>
                            @elseif($latestTotalEquipments == $previousTotalEquipments)       
                                <span class="text-secondary ml-3">No Changes</span>
                            @else
                                <span class="text-danger ml-3">Decrease</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{--  --}}
         {{-- Account recivables --}}
         <div class="col-lg-3 d-flex align-items-stretch">
            <a href="{{ route('ledger.index') }}" class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 title-head">Accounts Receivable</h6>
                        @if($totalDebit>$totalCredit)
                            <h5 class="mb-0 title-head" >RS {{$totalDebit-$totalCredit}}</h5>
                        @else
                            <h5 class="mb-0 title-head" >RS 0</h5>
                        @endif    
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <i class="fas fa-hand-holding-usd mr-2 text-primary"></i>
                            @if($AcReceivableChange>0)
                                <i class="fas fa-arrow-up text-danger mr-2"></i>
                            @else
                                <i class="fas fa-arrow-down-success text-danger"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-primary">{{$AcReceivableChange}} %</span>
                            @if($AcReceivableChange>0)
                                <span class="text-danger ml-3">Increase</span>
                            @elseif($AcReceivableChange==0)
                                <span class="text-secondary ml-3">No Changes</span>
                            @else
                                <span class="text-success ml-3">Decrease</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{--  --}}

    </div>
    
     
</div>

<div class="container-fluid pt-2 pd-2">
    <div class="row">
        <div id="incomeStatement" class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="title-head mb-0">Income Statement</h6>
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <button id="pdfButton" class="btn btn-primary mr-3">PDF</button>

                            <select class="form-control" id="timePeriod">
                                <option value="All">All</option>
                                <option value="Year">This Year</option>
                                <option value="Month">This Month</option>                        
                            </select>
                            &nbsp;
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="title-head mb-0">Total Revenue</h6>
                        <h6 style="font-size: 16px;" id="totalRevenue">{{ $totalRevenue }}</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="section-title mb-0">Expenses</h6>
                    </div>
                    <div id="expenses">
                        @foreach($expenses as $expense)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="section-title mb-0">{{ $expense->name }}</h6>
                            <h6 style="font-size: 16px;">{{ $expense->costs }}</h6>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="title-head mb-0">Total Expenses</h6>
                        <h6 style="font-size: 16px;" id="totalExpenses">{{ $totalExpenses }}</h6>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="title-head mb-0">Net Income</h6>
                        <h6 style="font-size: 16px;" id="NetIncome">{{ $NetIncome }}</h6>
                    </div>
                </div>
            </div>
        </div>

        {{--  --}}
         <div class="col-lg-6 d-flex align-items-stretch">

            <div class="col" >

                <div class="card w-100 shadow">
                    <div class="card-body">
                        <h6 class="title-head mb-3">Cash Outflows Per Month</h6>
                      
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>For</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach($cashOutflows as $cashInflow)
                                    <tr>
                                        <td>{{$cashInflow->start_date}}</td>
                                        <td>{{$cashInflow->name}}</td>
                                        <td>{{$cashInflow->costs}}</td>
                                    </tr>
                                    @endforeach
                                    
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <div class="card w-100 shadow">
                    <div class="card-body">
                        <h6 class="title-head mb-3">Cash Inflows Per Month</h6>
                      
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>For</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cashInflows as $cashInflow)
                                    <tr>
                                        <td>{{$cashInflow->date}}</td>
                                        <td>{{$cashInflow->remarks}}</td>
                                        <td>{{$cashInflow->credit}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 

            </div>

        </div>  
        
        {{--  --}}


    </div>
</div>




<script>
    document.getElementById('timePeriod').addEventListener('change', function() {
        var selectedPeriod = this.value;
        if (selectedPeriod === 'Month') {
            // Display monthly revenue
            document.getElementById('totalRevenue').innerText = '{{ $totalRevenueMth }}';
            document.getElementById('totalExpenses').innerText = '{{ $totalExpensesMth }}';
            document.getElementById('NetIncome').innerText = '{{ $NetIncomeMth }}';

            // Replace expenses HTML with new data of monthly
            document.getElementById('expenses').innerHTML = '';
            @foreach($expensesMth as $expense)
                var expenseDiv = document.createElement('div');
                expenseDiv.className = 'd-flex justify-content-between align-items-center mb-3';
                expenseDiv.innerHTML = `
                    <h6 class="section-title mb-0">{{ $expense->name }}</h6>
                    <h6 style="font-size: 16px;">{{ $expense->costs }}</h6>
                `;
                document.getElementById('expenses').appendChild(expenseDiv);
            @endforeach
        } 
        else if(selectedPeriod === 'Year'){
            document.getElementById('totalRevenue').innerText = '{{ $totalRevenueYear }}';
            document.getElementById('totalExpenses').innerText = '{{ $totalExpensesYear }}';
            document.getElementById('NetIncome').innerText = '{{ $NetIncomeYear }}';

            // if year is selected
            document.getElementById('expenses').innerHTML = '';
            @foreach($expensesYear as $expense)
                var expenseDiv = document.createElement('div');
                expenseDiv.className = 'd-flex justify-content-between align-items-center mb-3';
                expenseDiv.innerHTML = `
                    <h6 class="section-title mb-0">{{ $expense->name }}</h6>
                    <h6 style="font-size: 16px;">{{ $expense->costs }}</h6>
                `;
                document.getElementById('expenses').appendChild(expenseDiv);
            @endforeach
            
        }
        
        else {
             // Display monthly revenue
            document.getElementById('totalRevenue').innerText = '{{ $totalRevenue }}';
            document.getElementById('totalExpenses').innerText = '{{ $totalExpenses }}';
            document.getElementById('NetIncome').innerText = '{{ $NetIncome }}';


            // If not 'Month', reset expenses to default
            document.getElementById('expenses').innerHTML = '';
            @foreach($expenses as $expense)
                var expenseDiv = document.createElement('div');
                expenseDiv.className = 'd-flex justify-content-between align-items-center mb-3';
                expenseDiv.innerHTML = `
                    <h6 class="section-title mb-0">{{ $expense->name }}</h6>
                    <h6 style="font-size: 16px;">{{ $expense->costs }}</h6>
                `;
                document.getElementById('expenses').appendChild(expenseDiv);
            @endforeach
        }
    });
</script>

{{-- pdf --}}
<script>
  // Function to print the income statement
  function printIncomeStatement() {
        window.print(); // Open the print dialog
    }

    // Attach click event listener to the print button
    document.getElementById('pdfButton').addEventListener('click', function() {
        printIncomeStatement(); // Call the print function when the button is clicked
    });
</script>




@endsection