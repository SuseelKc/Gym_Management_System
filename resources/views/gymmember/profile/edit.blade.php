@extends('admin.admin')
@section('title','My Profile')
@section('content')

<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('membersgym.index') }}">Edit Profile</a>
                        </li> 
                        <li class="breadcrumb-item active">{{$member->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('memberprofile.update', $member->id) }}" method="POST" enctype="multipart/form-data"> 
                    @csrf
                    @method('PATCH')
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="card-title font-weight-bold mb-2 mt-2" style="font-size: 1.5rem;">My Profile</h2>
                               
                                    <button type="submit" class="btn btn-success px-4" style="transition: background-color 0.3s;">Update</button>
                                
                            </div>
                        </div>
                        
    
                     
                            
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                      
                                            @if($member->photo == null)
                                            <img src = "/images/defaultimage.jpg" style="width:105px; height:115px; float:left; border-radius:10%; margin-right:10px;">

                                            @else
                                            <img src="{{asset('/images/members/'.$member->photo)}}"
                                            style="width:105px; height:115px; float:left; border-radius:10%; margin-right:10px;"/>
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
                                                placeholder="Enter Your Address" name="contact_no" value="{{$member->contact_no}}" readonly>
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
                                                placeholder="Enter Your Email" name="email" value="{{$member->email}}" readonly>
                                            @if ($errors->has('email'))
                                                <x-validation-errors>
                                                    {{ $errors->first('email') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>

                                    

                                </div>
                                
                
                    </div>
                
                </div>
            </form>
            </div>
        </div>
    </section>
</div>

@endsection