@extends('admin.admin')
@section('title','Edit Staff')
@section('content')



<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('staffs.index') }}">Staff</a>
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
                            <h2 class="card-title font-weight-bold">Edit Staff</h2>
                        </div>
                        <form method="POST" action=" 
                        {{route('staffs.update',$staff->id)}}
                        " enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            
                            <div class="card-body">
                                <div class="row">
                                    <!-- name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Enter Name Here" name="name" value="{{ $staff->name }}" required >
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
                                            <label for="dob">Date Of Birth</label>
                                            <input type="date" class="form-control" id="dob"
                                             placeholder="Enter Date of Birth" name="dob" value="{{ $staff->dob }}"  required>
                                            @if ($errors->has('dob'))
                                                <x-validation-errors>
                                                    {{ $errors->first('dob') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>


                                    {{--  --}}

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address"
                                                placeholder="Enter Address Here" name="address" value="{{ $staff->address }}" required>
                                            @if ($errors->has('address'))
                                                <x-validation-errors>
                                                    {{ $errors->first('address') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                                                                                                                                                     
                                    {{--  --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" value="{{ $staff->email }}"
                                                placeholder="Enter Email Here" name="email" required>
                                            @if ($errors->has('email'))
                                                <x-validation-errors>
                                                    {{ $errors->first('email') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>


                                    {{--  --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_no">Contact No</label>
                                            <input type="contact_no" class="form-control" id="contact_no" value="{{ $staff->contact_no }}"
                                                placeholder="Enter Email Here" name="contact_no" required>
                                            @if ($errors->has('contact_no'))
                                                <x-validation-errors>
                                                    {{ $errors->first('contact_no') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>


                                    {{--  --}}

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="position">Position</label><br>
                                            <select id="position"  name="position" value="{{ $staff->position }}" required>
                                                <option value="Receptionist">Receptionist</option>
                                                <option value="Fitness Coach">Fitness Coach</option>
                                                <option value="Facility Supervisor">Facility Supervisor</option>
                                                <option value="Accountant">Accountant</option>
                                            </select>
                                            @if ($errors->has('position'))
                                                <x-validation-errors>
                                                    {{ $errors->first('position') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                    {{--  --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="photo">Upload Image</label>
                                            <input type="file" class="form-control" id="photo" name="photo" value="{{ $staff->photo }}">
                                            @if($staff->photo == null)
                                                <img src = "/images/defaultimage.jpg" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">

                                            @else
                                            <img src="/images/staff/{{$staff->photo}}"
                                            style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;"/>
                                            @endif
                                        
                                        </div>
                                    </div>
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
