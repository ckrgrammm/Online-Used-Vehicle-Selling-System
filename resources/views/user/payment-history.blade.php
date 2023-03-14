@extends('user/master')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="../images/logo.png"/>
<title>Payment History</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<style>
.scrollable {
    height: 12.5rem;
    overflow-y: scroll;
}
</style>
  <br>
    <body>
<div class="card mx-auto" style="width: 1000px;margin-top:100px;">
    <div class="card-header">
        <h2 class="card-header-text default">Payment History</h2>
    </div>
    <div class="card-body" id="deliveriesDataStorageBody" role="tabpanel">
        <h5 class="default">Invoices <span style="float:right">{{$count}}</span></h5><br>
<div class="table-responsive scrollable"  style="height:345px;">
            <table class="table table-sm table-striped table-hover text-nowrap grid-welcm" >
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
                @foreach ($productDetail as $index => $productDetails)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><img src="{{asset('user/img/product/'.$productDetails->product_image)}}" style="width:50px;height:50px;"></td>
                        <td>{{ $productDetails->make }} {{ $productDetails->model }}</td>
                        <td>RM {{ $productDetails->total_charge }}</td>
                        <td>{{ $productDetails->payment_method }}</td>
                        <td>{{ date('Y-m-d', strtotime($productDetails->payment_date)) }}</td>
                        <td style="white-space: pre-wrap;">{{ $productDetails->billing_address }}</td>
                        <td>{{ $productDetails->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
  </div>
      </div>
      <br>
	</body>

    </html>