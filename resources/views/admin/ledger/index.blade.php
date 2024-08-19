@extends('admin.admin')
@section('title', 'Payment Ledger')
@section('content')

<link href="{{ asset('admin/Toastr/toastr.css') }}" rel="stylesheet">
<script src="{{ asset('admin/Toastr/toastr.js') }}"></script>

<link href="{{ asset('admin/DataTables/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/DataTables/datatables.min.js') }}"></script>

<link href="{{ asset('admin/Select2/select2.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/Select2/select2.min.js') }}"></script>

<style>
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    border-radius: 4px;
    height: 38px;
    line-height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 10px;
        color: #495057;
        font-size: 14px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
        right: 10px;
    }
</style>
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
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="ml-2 mt-3 mb-3">
                                        <label for="members">Members</label>
                                        <div class="form-group d-flex">
                                            <select name="members" id="members" class="form-control">
                                            </select>
                                            <a href="#" class="btn btn-primary ml-2" id="searchBtn">
                                                <i class='fas fa-search'></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body table-responsive p-2">
                            <table class="table table-hover table-bordered display compact" id="paymentLedgerTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Member S.No</th>
                                            <th>Member Name</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </section>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var paymentLedgerTable = $('#paymentLedgerTable').DataTable({
        destroy: true,
        processing: true,
        language: {
            processing: '<span style="color:black;">Processing...</span>'
        },
        serverSide: false,
        
        ajax: {
            url: "/filterLedger",
            type: "POST",
            data: function(postData) 
            {
                postData._token = $('meta[name="csrf-token"]').attr('content');
            }
        },
        scrollY: "55vh",
        scrollX: true,
    
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
        ],
        columns: 
        [
            {data: "sn"},
            {data: "date"},
            {data: "serial_no"},
            {data: "name"},
            {data: "debit"},
            {data: "credit"},
            {data: "remarks"},
        ],
    }); 

    $('#members').select2({
        placeholder: "Select Member",
        allowClear: true,
        width: '100%',
        ajax: {
            url: '/get-employees',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term, 
                    _token: $('meta[name="csrf-token"]').attr('content') 
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(employee) {
                        return {
                            id: employee.id,
                            text: `${employee.name} [${employee.serial_no}]`
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });

    $(document).on('click', '#searchBtn', function(e) {
        e.preventDefault();

        var employeeId = $('#members').val(); 

        if (employeeId) {
            $.ajax({
                url: '/filterLedger',
                type: 'POST',
                data: {
                    employeeId: employeeId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) 
                {
                    paymentLedgerTable.clear().rows.add(response.data).draw();
                },
                error: function(xhr) 
                {
                    toastr.error('Failed to filter ledger data.');
                }
            });
        } 
        else 
        {
            toastr.warning('Please select a member before searching.');
            paymentLedgerTable.ajax.reload();  
        }
    });
</script>
@endsection
