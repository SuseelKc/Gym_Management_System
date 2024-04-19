@extends('admin.admin')
@section('title','My Account')
@section('content')
{{--  --}}
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
{{--  --}}
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
                                    {{-- <button id="payment-button">Pay with Khalti</button> --}}
                                    <a href="#" class="btn btn-primary px-4 m-2"  id="payment-button">Make Payment</a>  
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
{{--  --}}
<script>
    var config = {
        "publicKey": "test_public_key_850bbcc5a5074adb8c92a79e5bf21dc8",
        "productIdentity": "1234567890",
        "productName": "Dragon",
        "productUrl": "http://127.0.0.1:8000/user/ledger/1/details",
        "paymentPreference": [
            "KHALTI",
            "EBANKING",
            "MOBILE_BANKING",
            "CONNECT_IPS",
            "SCT",
        ],
        "eventHandler": {
            onSuccess (payload) {
                console.log("inside success function");
                console.log(payload);

                // Send payload data to PaymentController using AJAX
                $.ajax({
                    type: 'POST',
                    url: '/khalti/verify',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'payload': payload,
                        'member_id': {{ $ledger->member_id }},
                        'ledger_id' : {{ $ledger->id }}
                    },
                    success: function(response) {
                        console.log('Payment data sent to PaymentController.');
                       
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending payment data:', error);
                    }
                });
            },
            onError (error) {
                console.log(error);
            },
            onClose () {
                console.log('widget is closing');
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById("payment-button");
    btn.onclick = function () {
        checkout.show({amount: 20000});
    }
</script>

{{-- <script>
    var config = {
        // replace the publicKey with yours
        "publicKey": "test_public_key_850bbcc5a5074adb8c92a79e5bf21dc8",
        "productIdentity": "1234567890",
        "productName": "Dragon",
        "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
        "paymentPreference": [
            "KHALTI",
            // "EBANKING",
            // "MOBILE_BANKING",
            // "CONNECT_IPS",
            // "SCT",
            ],
        "eventHandler": {
            onSuccess (payload) {
                // hit merchant api for initiating verfication


                $.ajax({
                    type:'POST',
                    url: "{{ route('ajax.khalti.verify_order')}}",
                    data:{
                        token : payload.token,
                        amount :payload.amount,
                        "_token": "{{ csrf_token()}}'"
                    },
                    success :function(res){
                        $.ajax({
                            type:'POST',
                            url:"{{route('khalti.storePayment')}}"
                            data:{
                                response :res,
                                "_token": "{{ csrf_token()}}'"
                            }
                        });
                        console.log(res);
                    }
                });

                console.log(payload);
                // if(payload.idx){
                //     $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': '{{csrf_token()}}'
                //     }
                // });

                // $.ajax({
                //     method: 'post',
                //     url: "{{route('ajax.khalti.verify_order')}}",
                //     data: payload,
                //     success: function(response){
                //         if(response.success ==1){
                //             window.location = response.redirecto;
                //         }
                //         else{
                //             checkout.hide();
                //         }
                //     },
                //         error:function(data){
                //             console.log('Error:',data);
                //         }
                    
                // });

                // }
            },
            onError (error) {
                console.log(error);
            },
            onClose () {
                console.log('widget is closing');
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById("payment-button");
    btn.onclick = function () {
        // minimum transaction amount must be 10, i.e 1000 in paisa.
        checkout.show({amount: 1000});
    }
</script> --}}
{{--  --}}
@endsection