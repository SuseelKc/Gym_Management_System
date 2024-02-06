@extends('admin.admin')
@section('title','Edit Members')
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
                            <li class="breadcrumb-item active">Edit {{$member->name}}</li>
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
                                <h2 class="card-title font-weight-bold">Edit Members</h2>
                            </div>
                            <form method="POST" action=" 
                            {{route('member.update',$member->id)}}
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
                                                    placeholder="Enter Name Here" name="name" value="{{$member->name}}" required>
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
                                                    placeholder="Enter Name Here" name="gym_name" value="{{ $member->user->name }}" readonly>
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
                                                <input type="date" class="form-control" id="dob" required
                                                     name="dob" value="{{$member->dob}}">
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
                                                    placeholder="Enter Your Address" name="address" value="{{$member->address}}" required>
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
                                                <input type="text" class="form-control" id="contact_no"
                                                    placeholder="Enter Your Address" name="contact_no" value="{{$member->contact_no}}" required>
                                                @if ($errors->has('contact_no'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('contact_no') }}
                                                    </x-validation-errors>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email"
                                                    placeholder="Enter Your Email" name="email" value="{{$member->email}}" required>
                                                @if ($errors->has('email'))
                                                    <x-validation-errors>
                                                        {{ $errors->first('email') }}
                                                    </x-validation-errors>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="photo">Upload Image</label>
                                                <input type="file" class="form-control" id="photo" name="photo">
                                                @if($member->photo == null)
                                                <img src = "/images/defaultimage.jpg" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">

                                                @else
                                                <img src="{{asset('/images/members/'.$member->photo)}}"
                                                style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;"/>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary px-3">Save</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
