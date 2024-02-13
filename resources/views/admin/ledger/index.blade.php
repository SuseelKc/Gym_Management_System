@extends('admin.admin')
@section('title','Payment Ledger')
@section('content')
{{--  --}}
<div class="content">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Gym Clients</li>
                        </ol>
                    </div>
                </div>
            </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="ml-2 mt-5 mb-3">
                            <label>Members </label>
                            <select name="cars" id="cars">
                                @foreach($member as $member)
                                    <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('ledger.search', $member['id']) }}" class="btn btn-primary">Search</a>  
                        </div>
                           
                            {{-- <div class="">                             
                                <a href="
                                {{route('member.create')}}
                                "
                                    class="btn btn-primary px-4 m-2 float-right">Find</a>  
                            </div> --}}
                            <div class="card-body table-responsive p-2">
                                <table class="datatable table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Debit</th>
                                            <th>Credit</th>                                         
                                            <th>Balance</th>
                                            <th>Package</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($member as $member)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$member->serial_no}}</td>
                                            <td>
                                                    @if ($member->photo == null)
                                                        <img src = "/images/defaultimage.jpg" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">
                                                    @else
                                                        <img src = "/images/members/{{$member->photo}}" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">
                                                    @endif
                                            </td>
                                            <td>{{$member->name}}</td>
                                            <td>{{$member->user->name}}</td>
                                            <td>{{$member->email}}</td>
                                            <td>{{$member->dob}}</td>
                                            <td>{{$member->contact_no}}</td>
                                            <td>
                                            
                                            </td>
                                           
                                            <td>
                                                                                  
                                            </td>

                                        </tr>
                                        @endforeach     --}}
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--  -->
@endsection