@extends('user/master')
@section('content')


<body>
  <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Shop Single</h2>
              <p>Home <span>-</span> Shop Single</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->
  <!--================End Home Banner Area =================-->

  <!--================Single Product Area =================-->
  <div class="product_image_area section_padding">
    <div class="container">
      <div class="row s_product_inner justify-content-between">
        <div class="col-lg-7 col-xl-7">
          <div class="product_slider_img">
            @php
            $images = explode('|', $product->product_image);
            @endphp
            <div id="vertical">
    @foreach ($images as $image)
      <div data-thumb="{{ asset('user/img/product/'.$image) }}">
        <img src="{{ asset('user/img/product/'.$image) }}" width="1000" height="500" />
      </div>
    @endforeach
  </div>
          </div>
        </div>
        <div class="col-lg-5 col-xl-4">
          <div class="s_product_text">
            <h5>previous <span>|</span> next</h5>
            <h3>{{ $product->make }} &nbsp;{{ $product->model }}</h3>
            <h2>RM {{ $product->price }}</h2>
            <ul class="list">
              <a href="#"> <span>Availibility</span> : In Stock</a>
              </li>
            </ul>
            <p>
              First replenish living. Creepeth image image. Creeping can't, won't called.
              Two fruitful let days signs sea together all land fly subdue
            </p>
            <div class="card_area d-flex justify-content-between align-items-center">
              <div class="product_count">
                <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                <input class="input-number" type="text" value="1" min="0" max="10">
                <span class="number-increment"> <i class="ti-plus"></i></span>
              </div>
              <a href="{{ route('products.cart',$product->id)}}" class="btn_3">add to cart</a>
              <a href="#" class="like_us"> <i class="ti-heart"></i> </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--================End Single Product Area =================-->

  <!--================Product Description Area =================-->
  <section class="product_description_area">
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Specification</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
          <p>
            {{ $product->product_description }}
          </p>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>
                    <h5>Year</h5>
                  </td>
                  <td>
                    <h5>{{ $product->product_description }}</h5>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h5>Mileage</h5>
                  </td>
                  <td>
                    <h5>{{ $product->mileage }}</h5>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h5>Color</h5>
                  </td>
                  <td>
                    <h5>{{ $product->color }}</h5>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h5>Transmission</h5>
                  </td>
                  <td>
                    <h5>{{ $product->transmission }}</h5>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!--================End Product Description Area =================-->

        <!-- product_list part start
  <section class="product_list best_seller">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="section_tittle text-center">
            <h2>Best Sellers <span>shop</span></h2>
          </div>
        </div>
      </div>
      <div class="row align-items-center justify-content-between">
        <div class="col-lg-12">
          <div class="best_product_slider owl-carousel">
            <div class="single_product_item">
              <img src="img/product/product_1.png" alt="">
              <div class="single_product_text">
                <h4>Quartz Belt Watch</h4>
                <h3>$150.00</h3>
              </div>
            </div>
            <div class="single_product_item">
              <img src="img/product/product_2.png" alt="">
              <div class="single_product_text">
                <h4>Quartz Belt Watch</h4>
                <h3>$150.00</h3>
              </div>
            </div>
            <div class="single_product_item">
              <img src="img/product/product_3.png" alt="">
              <div class="single_product_text">
                <h4>Quartz Belt Watch</h4>
                <h3>$150.00</h3>
              </div>
            </div>
            <div class="single_product_item">
              <img src="img/product/product_4.png" alt="">
              <div class="single_product_text">
                <h4>Quartz Belt Watch</h4>
                <h3>$150.00</h3>
              </div>
            </div>
            <div class="single_product_item">
              <img src="img/product/product_5.png" alt="">
              <div class="single_product_text">
                <h4>Quartz Belt Watch</h4>
                <h3>$150.00</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br><br><br><br><br><br>
  </section>
 product_list part end-->