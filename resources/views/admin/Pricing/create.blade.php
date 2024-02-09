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
                                                placeholder="Enter Name Here" name="name" >
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
                                            <label for="costs">Costs</label>
                                            <div class="d-flex align-items-center">
                                                <input type="decimal" class="form-control mr-2" id="costs" style="width: 150px;"
                                                       name="costs">
                                                <select id="costs_type" style="height: 30px;" name="costs_type">
                                                    <option value="Year">Yearly</option>
                                                    <option value="Month">Monthly</option>
                                                    <option value="Days">Daily</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('costs'))
                                                <x-validation-errors>
                                                    {{ $errors->first('costs') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>


                                    
                                    {{--  --}}
                                    <div class="col-md-6">
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
                                        

                                   </div>
                                    {{--  --}}

                                                                                                                                         
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary px-3">Submit</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
