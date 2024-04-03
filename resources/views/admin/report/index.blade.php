@extends('admin.admin')
@section('title','Report')
@section('content')

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
            <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Total Members </h5>
                        <h6 class="mb-0" style="font-weight: bold;">{{$totalMembers}}</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <i class="fas fa-users mr-2 text-primary"></i>
                            @if($latestTotalMembers > $previousTotalMembers)
                                <i class="fas fa-arrow-up text-success mr-2"></i>
                            
                            @else
                                <i class="fas fa-arrow-down text-danger"></i>
                            
                            @endif
                            
                        </div>
                        <div>
                            <span class="text-primary">{{$percentageChange}} %</span>
                            @if($latestTotalMembers > $previousTotalMembers)
                            <span class="text-success ml-3">Increase</span>
                            @else
                            <span class="text-danger ml-3">Decrease</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  --}}
    </div>
    
     
</div>
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-MSXz5EmNhSC6/LW8ibFHNjNznbTIaQlNfWRqT2e2OrBFqm/2idZLc2sxi7/AtYs0++cDbzWwnjRMo7UCeLMtyw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
@endsection