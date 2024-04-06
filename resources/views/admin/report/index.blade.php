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
</style>
<div class="container-fluid pt-2 pd-2">
    
    <div class="row">
        {{-- Net Income --}}
        <div class="col-lg-3 d-flex align-items-stretch">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Net Income</h5>
                        <h6 class="mb-0">RS. 1234</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <i class="fas fa-money-bill mr-2 text-primary"></i>
                            <i class="fas fa-arrow-up text-success mr-2"></i>
                            <i class="fas fa-arrow-down text-danger"></i>
                        </div>
                        <div>
                            <span class="text-primary">Income</span>
                            <span class="text-success ml-3">Increase</span>
                            <span class="text-danger ml-3">Decrease</span>
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

<div class="container-fluid pt-3 pd-2">
    <div class="row">
        <div class="col-lg-6 d-flex align-items-stretch">
             <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="title-head mb-0">Income Statement</h5>
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <button class="btn btn-primary mr-3">PDF</button>
                            <select class="form-control">
                                <option value="All">All</option>
                                <option value="Year">This Year</option>
                                <option value="Month">This Month</option>                        
                            </select>
                            &nbsp;
                            <a href="#" class="btn btn-primary" id="searchBtn" style="padding: 4px 10px;"><i class='fas fa-search'></i></a>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="title-head mb-0">Total Revenue</h6>
                        <h6 style="font-size: 16px;">{{ $totalRevenue}}</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="section-title mb-0">Expenses</h6>
                    </div>
                    @foreach($expenses as $expense)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="section-title mb-0"> {{$expense->name}}</h6>
                        <h6 style="font-size: 16px;">{{$expense->costs}}</h6>
                    </div>
                    @endforeach
                 
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="title-head mb-0">Total Expenses</h6>
                        <h6 style="font-size: 16px;">{{$totalExpenses}}</h6>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="title-head mb-0">Net Income</h6>
                        <h6 style="font-size: 16px;">{{ $NetIncome}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection