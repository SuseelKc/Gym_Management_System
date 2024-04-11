@extends('admin.admin')
@section('title','My Account')
@section('content')

<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item active">Payment Ledger</li>
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
                            <div class="card-header">
                                <div class="d-flex justify-content-end">
                                    <a href="#" class="btn btn-primary px-4 m-2">Make Payment</a>  
                                </div>
                            </div>

                            <div class="card-body table-responsive p-2">
                                <table class="datatable table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Member S.No</th>
                                            <th>Member Name</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                            <th>Remarks</th>
                                            
                                            
                                        
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ledger as $ledger)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$ledger->date}}</td>
                                            <td>{{$ledger->member->serial_no}}</td>
                                            <td>{{$ledger->member->name}}</td>
                                            <td>{{$ledger->debit}}</td>
                                            <td>{{$ledger->credit}}</td>
                                            <td>{{$ledger->balance}}</td>
                                            <td>{{$ledger->remarks}}</td>
                                            
                                            
                                        
                                    
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
@endsection