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
                            <select name="members" id="members">
                                @foreach($members as $singleMember)
                                    <option value="{{ $singleMember['id'] }}">{{ $singleMember['name'] }}</option>
                                @endforeach
                            </select>
                            <a href="#" id="searchLink" class="btn btn-primary"><i class='fas fa-search'></i></a>  
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
                                        @foreach ($ledger as $ledger)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$ledger->date}}</td>                                          
                                            <td>{{$ledger->debit}}</td>
                                            <td>{{$ledger->credit}}</td>
                                            <td>{{$ledger->balance}}</td>
                                            <td>{{$ledger->member_id}}</td>
                                            <td>{{$ledger->gym_id}}</td>
                                            <td></td>
                                            

                                        </tr>
                                        @endforeach    
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

<script>
    document.getElementById('members').addEventListener('change', function() {
        var memberId = this.value; // Get the selected member ID
        var searchLink = document.getElementById('searchLink');
        searchLink.href = "http://127.0.0.1:8000/ledger#" + memberId;
    });
</script>