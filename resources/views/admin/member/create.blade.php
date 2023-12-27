@extends('admin.admin')
@section('title','Create Members')
@section('content')
    {{-- @include('validation-error-message') --}}
    {{--Pop up error msg  --}}
<!-- <div class="content">
    @if(session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif
</div> -->
{{--  --}}
    <div class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.index') }}">Member</a>
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
                                <h2 class="card-title font-weight-bold">Add Members</h2>
                            </div>
                            <form method="POST" action=" 
                            {{route('member.store')}}
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
                                                <label for="dob">Date Of Birth</label>
                                                <input type="date" class="form-control" id="dob"
                                                     name="dob" value="">
                                                @if ($errors->has('dob'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('dob') }}
                                                    </x-validation-errors>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address"
                                                    placeholder="Enter Your Address" name="address" value="">
                                                @if ($errors->has('address'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('address') }}
                                                    </x-validation-errors>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contactno">Contact No.</label>
                                                <input type="text" class="form-control" id="contactno"
                                                    placeholder="Enter Your Address" name="contactno" value="">
                                                @if ($errors->has('contactno'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('contactno') }}
                                                    </x-validation-errors>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email"
                                                    placeholder="Enter Your Email" name="email" value="">
                                                @if ($errors->has('contactno'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('contactno') }}
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
