@extends('user/master')
@section('content')

<!--================Home Banner Area =================-->
<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <h2>Cart Products</h2>
                        <p>Home <span>-</span>Cart Products</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<!--================Cart Area =================-->
<section class="cart_area padding_top">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">Vehicle</th>
                            <th scope="col">Details</th>

                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="media">
                                    @foreach($products as $product)
                                    <div class="media">
                                        <div class="d-flex">
                                            @php
                                            $images = explode('|', $product->product_image);
                                            @endphp
                                            <img src="{{ asset('user/img/product/'.$images[0]) }}" width="500" height="250" />
                                        </div>

                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="media-body">
                                    <p>{{ $product->make }} &nbsp;{{ $product->model }}</p>
                                </div>
                            </td>
                            <td>
                                <h5>RM {{ $product->price }}</h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <span class="input-number-decrement"> <i class="ti-angle-down"></i></span>
                                    <input class="input-number" type="text" value="1" min="0" max="10">
                                    <span class="input-number-increment"> <i class="ti-angle-up"></i></span>
                                </div>
                            </td>
                            <td>
                                <h5>RM {{ $product->price }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>


                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5>RM {{ $product->price }}</h5>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="checkout_btn_inner float-right">
                    <a class="btn_1 checkout_btn_1" href="#">Proceed to checkout</a>
                </div>
            </div>
        </div>
</section>
<!--================End Cart Area ============