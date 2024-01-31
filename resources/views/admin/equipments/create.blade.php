@extends('admin.admin')
@section('title','Create Equipments')
@section('content')

@if(session('message'))
<div class="alert alert-danger">
    {{ session('message') }}
</div>
@endif

<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('equipments.index') }}">Equipments</a>
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
                            <h2 class="card-title font-weight-bold">Add Equipments</h2>
                        </div>
                        <form method="POST" action=" 
                        {{route('equipments.store')}}
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
                                                placeholder="Enter Name Here" name="gym_name" value="{{ $gym->name }}">
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
                                            <label for="weight">Weight</label>
                                            <input type="number" class="form-control" id="weight"
                                                placeholder="Enter Weight Here" name="weight" value="{{ $gym->name }}">
                                            @if ($errors->has('weight'))
                                                <x-validation-errors>
                                                    {{ $errors->first('weight') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="maintenance_period">Maintenance Period (Gap)</label>
                                            <div class="d-flex align-items-center">
                                                <input type="number" class="form-control mr-2" id="maintenance_period_input" style="width: 150px;"
                                                       name="maintenance_period" value="">
                                                <select id="maintenance_period" style="height: 30px;">
                                                    <option value="year">Year</option>
                                                    <option value="month">Month</option>
                                                    <option value="days">Days</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('maintenance_period'))
                                                <x-validation-errors>
                                                    {{ $errors->first('maintenance_period') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                                                                                       

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="photo">Upload Image</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>

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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    // Attach an event listener to the select element
    $('#maintenance_period').on('change', function () {
        var selectedOption = $(this).val();
        var inputField = $('#maintenance_period_input');

        // If the selected option is 'days', add a validation for digits above 0
        if (selectedOption === 'days') {
            inputField.attr('min', 1); // Set minimum value to 1
            inputField.attr('required', true); // Make the input field required
        } else {
            // If the selected option is not 'days', remove the validation
            inputField.removeAttr('min');
            inputField.removeAttr('required');
        }
    });
</script>