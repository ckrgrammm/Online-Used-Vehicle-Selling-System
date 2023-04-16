<link rel="stylesheet" href="{{ asset('user/css/price_rangs.css') }}">
@extends('user/master')
@section('content')
<script src="{{ asset('user/js/price_rangs.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js"></script>
<style>
    .simple-pagination ul {
        margin: 0 0 20px;
        padding: 0;
        list-style: none;
        text-align: center;
    }

    .simple-pagination li {
        display: inline-block;
        margin-right: 5px;
    }

    .simple-pagination li a,
    .simple-pagination li span {
        color: #666;
        padding: 5px 10px;
        text-decoration: none;
        border: 1px solid #EEE;
        background-color: #FFF;
        box-shadow: 0px 0px 10px 0px #EEE;
    }

    .simple-pagination .current {
        color: #FFF;
        background-color: #FF7182;
        border-color: #FF7182;
    }

    .simple-pagination .prev.current,
    .simple-pagination .next.current {
        background: #e04e60;
    }
</style>
<!--================Home Banner Area =================-->
<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <h2>Shop Category</h2>
                        <p>Home <span>-</span> Shop Category</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<!--================Category Product Area =================-->
<section class="cat_product_area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="left_sidebar_area">
                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Product filters</h3>
                        </div>
                        <div class="widgets_inner">
                            <ul class="list">
                                @foreach($products->unique('make') as $product)
                                    <li><a href="" data-make="{{ $product->make }}" data-model="{{ $product->model }}" data-price="{{ $product->price }}">{{ $product->make }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>

                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Color Filter</h3>
                        </div>
                        <div class="widgets_inner">
                            <ul class="list">
                                @foreach($products->pluck('color')->unique() as $color)
                                    <li><a href="">{{ $color }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>

                    <aside class="left_widgets p_filter_widgets price_rangs_aside">
                        <div class="l_w_title">
                            <h3>Price Filter</h3>
                        </div>
                        <div class="widgets_inner">
                            <div class="range_item">
                                <!-- <div id="slider-range"></div> -->
                                <input type="text" class="js-range-slider" value="" />
                                <div class="d-flex">
                                    <div class="price_text">
                                        <p>Price :</p>
                                    </div>
                                    <div class="price_value d-flex justify-content-center">
                                        <input type="text" class="js-input-from" id="amount" readonly />
                                        <span>to</span>
                                        <input type="text" class="js-input-to" id="amount" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product_top_bar d-flex justify-content-between align-items-center">
                            <div class="single_product_menu">
                                <p><span>{{count($products)}} </span> Product Found</p>
                            </div>
                            <div class="single_product_menu d-flex">
                                <h5>short by : </h5>
                                <select>
                                    <option value="name">name</option>
                                    <option value="1">price</option>
                                    <option value="2">product</option>
                                </select>
                            </div>
                            <div class="single_product_menu d-flex">
                                <h5>show :</h5>
                                <div class="top_pageniation">
                                    <ul>
                                        <li>1</li>
                                        <li>2</li>
                                        <li>3</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="single_product_menu d-flex">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="search" aria-describedby="inputGroupPrepend">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center latest_product_inner list-wrapper">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-sm-6 list-item">
                            <div class="single_product_item">
                                @php
                                    $images = explode('|', $product->product_image);
                                @endphp
                                <img src="{{ asset('user/img/product/'.$images[0]) }}" alt="" width="270" height="275">
                                <div class="single_product_text">
                                    <h4>{{ $product->make .' '. $product->model }}</h4>
                                    <h3>RM {{ $product->price }}</h3>
                                    <a href="{{ route('products.details',$product->id) }}" class="add_cart">View More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-12">
                        <div id="pagination-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--================End Category Product Area =================-->

<!-- product_list part start-->
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
                    @foreach($products as $product)

                    <div class="single_product_item">
                        @php
                        $images = explode('|', $product->product_image);
                        @endphp
                        <img src="{{ asset('user/img/product/'.$images[0]) }}" width="300" height="175" class="d-block w-100" alt="">
                        <div class="single_product_text">
                            <h4>{{ $product->make }}</h4>
                            <span>{{ $product->model }}</span>
                            <h3>{{ $product->price }}</h3>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product_list part end-->

<script>
    // jQuery Plugin: http://flaviusmatis.github.io/simplePagination.js/

    var items = $(".list-wrapper .list-item");
    var numItems = items.length;
    var perPage = 9;

    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });
</script>
@endsection