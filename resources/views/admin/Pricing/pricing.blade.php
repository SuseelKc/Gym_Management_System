@extends('admin.admin')
@section('title','Equipment')
@section('content')

<link href="{{ asset('admin/Toastr/toastr.css') }}" rel="stylesheet">
<script src="{{ asset('admin/Toastr/toastr.js') }}"></script>

<link href="{{ asset('admin/DataTables/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/DataTables/datatables.min.js') }}"></script>

<div class="content">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">Equipment</li>
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
                            <div class="">                             
                                <button class="btn btn-primary px-4 m-2 float-right" id="add-equipment-btn">Add</button>
                            </div>
                            <div class="card-body table-responsive p-2">
                                <table class="table table-hover table-bordered display compact" id="equipmentTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Costs</th>
                                            <th>Costs Type</th>     
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Members Enrolled</th>
                                            <th>Status</th>                                       
                                            <th>Action</th>                                                               
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>