@extends('admin.admin')
@section('title','Create Package')
@section('content')

<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pricing.index') }}">Pricing & Packages</a>
                        </li> 
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h2 class="card-title font-weight-bold">Create Package/Pricing</h2>
                        </div>
                        <form method="POST" action=" 
                        {{route('pricing.store')}}
                        " enctype="multipart/form-data">
                            @csrf
                            
                            <div class="card-body">
                                <div class="row">
                                    <!-- name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Enter Name Here" name="name" required>
                                            @if ($errors->has('name'))
                                                <x-validation-errors>
                                                    {{ $errors->first('name') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gym_name">Gym Name</label>
                                            <input type="text" class="form-control" id="gym_name"
                                                placeholder="Enter Name Here" name="gym_name" value="{{ $gym->name }}" readonly>
                                            @if ($errors->has('gym_name'))
                                                <x-validation-errors>
                                                    {{ $errors->first('gym_name') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                    <!--  -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duration">Duration</label>
                                            <div class="d-flex align-items-center">
                                                <input type="decimal" class="form-control mr-2" id="duration" style="width: 150px;"
                                                    name="duration">
                                                <select id="duration_type" style="height: 30px;" name="duration_type">
                                                    <option value="Year">Year</option>
                                                    <option value="Month" selected>Month</option>
                                                    <option value="Days">Day</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('duration'))
                                                <x-validation-errors>
                                                    {{ $errors->first('duration') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="costs">Price</label>
                                            <input type="decimal" class="form-control" id="costs" placeholder="Enter Package Price" name="costs" required>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duration">Duration (In Days)</label>
                                            <input type="number" class="form-control" id="duration" placeholder="Enter Duration days for this Package" name="duration" required>
                                        </div>
                                    </div> -->

                                    
                                    {{--  --}}
                                    <!-- <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group" style="margin-right: 10px;">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" class="form-control" id="start_date" required name="start_date" value="{{ date('Y-m-d') }}">
                                                @if ($errors->has('start_date'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('start_date') }}
                                                    </x-validation-errors>
                                                @endif
                                            </div>
                                        

                                            <div class="form-group" style="margin-left: 20px;">
                                                <label for="end_date">End Date</label>
                                                <input type="date" class="form-control" id="end_date"  name="end_date" value="">
                                                @if ($errors->has('end_date'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('end_date') }}
                                                    </x-validation-errors>
                                                @endif
                                            </div>
                                        </div>
                                        

                                   </div> -->
                                    {{--  --}}

                                                                                                                                         
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary px-3">Submit</button>
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
