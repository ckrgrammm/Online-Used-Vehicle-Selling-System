@extends('user/master')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="../images/logo.png"/>
<title>Check Out</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.1/examples/checkout/form-validation.css" rel="stylesheet">
</head>
<body>
<div class="container" style="margin-top:50px">
      <div class="py-5 text-center">
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your order</span>
          </h4>
          <ul class="list-group mb-3">
          @foreach ($productDetail as $detail)
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">{{ $detail->make }} {{ $detail->model }}</h6>
                <small class="text-muted">{{ $detail->product_description }}</small>
              </div>
              <span class="text-muted">RM{{ $detail->price }}</span>
            </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between lh-condensed" style="color:red !important">
              <div>
                <h6 class="my-0">Service Tax</h6>
                <small >10%</small>
              </div>
              <span >RM{{ $tax }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <div>
                <h6 class="my-0">Shipping <span id="updateDesc"></span></h6>
              </div>
              <span class="text-muted" id="showShippingPrice">RM??</span>
            </li>

            <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">Free Gift</h6>
                @php
                $name = explode(',', $gift);
                @endphp
                @foreach ($name as $giftName)
                <small>{{$giftName}}</small><br>
                @endforeach
              </div>
              
              <span class="text-success">{{ $count }} item</span>
            </li>
            
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (MYR)</span>
              <strong id="showTotalPrice"></strong>
            </li>
          </ul>
          @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
        </div>
        
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing & Shipping address</h4>
          <form class="needs-validation" novalidate method="post" action="payment">
          
            @csrf
            
            <div class="row"> 
              <div class="col-md-12 mb-3">
                <label for="name">Your name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="" value="a" required="">
                <div class="invalid-feedback">
                  Valid name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required="" value="123@1" >
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" value="1" required="" maxlength="150">
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>


            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" id="country" name="country" required="">
                  <option value="1">Choose...</option>
                  <option value="Malaysia">Malaysia</option>
                </select>
                <div class="invalid-feedback" id="showHideMsg">
                Please enter your country.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100" id="state" name="state" required="">
                  <option value="1">Choose...</option>
                  <option>California</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>


              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="" required="" value="11111">
                <div class="invalid-feedback">
                  Zip code required.
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <h4 class="mb-3">Shipping Method</h4>
            <div class="d-block my-3">
            @foreach ($shippingMethods as $method)
              <div class="custom-control custom-radio">
                <input id="{{ $method['id'] }}" name="shippingMethod" type="radio" class="custom-control-input" required="" value="{{ $method['id'] }}" onchange="updateShippingPrice('{{ $method['name'] }}','{{ $method['price'] }}')">
                <label class="custom-control-label" for="{{ $method['id'] }}">{{ $method['desc'] }} </label><span style="float:right;">RM{{ $method['price'] }}</span>
              </div>
              @endforeach
            </div>
            <hr class="mb-4">

            <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="" value="credit card">
                <label class="custom-control-label" for="credit">Credit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="" value="debit card">
                <label class="custom-control-label" for="debit">Debit card</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">Name on card</label>
                <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required="" value="test">
                <small class="text-muted">Full name as displayed on card</small>
                <div class="invalid-feedback">
                  Name on card is required
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cc-number">Credit card number</label>
                <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required="" value="1234123412341234" maxlength="16">
                <div class="invalid-feedback">
                  Credit card number is required
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="12/25" required="" value="12/23" maxlength="5">
                <div class="invalid-feedback">
                  Expiration date required
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="cc-cvv">CVV</label>
                <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required="" value="123" maxlength="3">
                <div class="invalid-feedback">
                  Security code required
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            
            <input type="hidden" name="grand_total_hidden" id="grand_total_hidden">
            <input type="hidden" name="order_id_hidden" id="order_id_hidden" value="{{$orderId}}">
          </form>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
      </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/holder.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>



</body>

<script>
  

    $(document).ready(function() {
    $('#country').niceSelect(); 
    $('#country').niceSelect('destroy');
    $('#state').niceSelect(); 
    $('#state').niceSelect('destroy');
});
    var voucherApply = false;
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();

var grandTotal = 0;

function updateShippingPrice(name,price){
  document.getElementById("updateDesc").innerHTML = " - "+ name;
  document.getElementById("showShippingPrice").innerHTML = "RM" + price;
  grandTotal = parseInt(price) + parseInt({{$tax}}) + parseInt({{$totalPrice}});
  document.getElementById("showTotalPrice").innerHTML ="RM "+grandTotal;
  document.getElementById("grand_total_hidden").value = grandTotal;
  document.getElementById("totalPrice").value = grandTotal;
}



</script>
</html>

