@extends('user/master')
@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

<style>
.scrollable {
    height: 12.5rem;
    overflow-y: scroll;
}
</style>

@if(Session::has('membership_upgrade_message'))
    <script>
        swal({
            title: "Success!",
            text: "{{ Session::get('membership_upgrade_message') }}",
            icon: "success",
            button: "OK",
        });
    </script>
@endif

  <br>

<div class="card mx-auto" style="width: 1200px;margin-top:100px;">
    <div class="card-header">
        <h2 class="card-header-text default">Payment History</h2>
    </div>
    <div class="card-body" id="deliveriesDataStorageBody" role="tabpanel">
        <h5 class="default">Invoices <span style="float:right">{{$count}}</span></h5><br>
<div class="table-responsive scrollable"  style="height:345px;">
            <table class="table table-sm table-hover text-nowrap grid-welcm" >
                <thead class="default">
                    <tr>
                        <th>NO.</th>
                        <th>Image</th>
                        <th>Car Name</th>
                        <th>Charge</th>
                        <th>Payment Method</th>
                        <th>Payment Date</th>
                        <th>Shipping Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php   
                    $previousPaymentId = '';
                    $i = 1;
                    @endphp
                @foreach ($productDetail as $index => $productDetails)
                    @php
                    $nextPaymentId = isset($payments[$index+1]) ? $payments[$index+1]->id : null;
                    @endphp
                    @if($payments[$index]->id == $previousPaymentId || $payments[$index]->id == $nextPaymentId)
                    <tr style="background-color: rgba(0,0,0,.05);">
                    @else
                    <tr>
                    @endif
                        <td>
                            @if($payments[$index]->id != $previousPaymentId)
                            {{ $i }} 
                            @php $i++ @endphp
                            @endif
                        </td>
                        @php
                            $images = explode('|', $productDetails->product_image);
                        @endphp
                        <td><img src="{{asset('user/img/product/'.$images[0])}}" style="width:50px;height:50px;"></td>
                        <td>{{ $productDetails->make }} {{ $productDetails->model }}</td>
                        @if($payments[$index]->id != $previousPaymentId)
                        <td>RM {{ $payments[$index]->total_charge }}</td>
                        <td>{{ $payments[$index]->payment_method }}</td>
                        <td>{{ date('Y-m-d', strtotime($payments[$index]->payment_date)) }}</td>
                        <td style="white-space: pre-wrap;">{{ $payments[$index]->billing_address }}</td>
                        <td>{{ $productDetails->status }}</td>
                        @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @endif
                        @php $previousPaymentId=$payments[$index]->id @endphp
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
  </div>
      </div>
      <br>
@endsection