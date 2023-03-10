<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function displayPayment(){

        $user_id = Session::get('user')['id'];
        $productDetailQuery = DB::table('users')
                    ->where('users.id' , $user_id)
                    ->join('orders','orders.user_id','=','users.id')
                    ->join('products','products.id','=','orders.product_id')
                    ->where('orders.status','Available')
                    ->select('products.*');
    
        $countItem = $productDetailQuery -> count();
        $productDetail = $productDetailQuery->get();
        $totalPrice = $productDetailQuery->sum('price');
        $tax = $totalPrice * 0.1;
                    $shippingMethods = [
                        [
                            'id' => 'gls',
                            'name' => 'GLS',
                            'desc' => 'GLS - Package delivered directly to the door',
                            'price' => '200',
                            'type' => 'private'
                        ],
                        [
                            'id' => 'fedex',
                            'name' => 'FedEx',
                            'desc' => 'FedEx - Package delivered directly to the door',
                            'price' => '250',
                            'type' => 'private'
                        ],
                        [
                            'id' => 'dhl',
                            'name' => 'DHL',
                            'desc' => 'DHL - Package delivered directly to the door',
                            'price' => '400',
                            'type' => 'company'
                        ]
                    ];
                    return view('payment', [
                        'countItem' => $countItem,
                        'shippingMethods' => $shippingMethods,
                        'productDetail' => $productDetail,
                        'totalPrice' => $totalPrice,
                        'tax' => $tax
                    ]);
       }
}
