<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FreeGiftController;
use App\Builders\PaymentBuilder;
use App\Builders\PaymentQueryBuilder;

class PaymentController extends Controller
{
    public function displayPayment(){

        $user_id = Session::get('user')['id'];

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->getData();
        $request = app('request');
        $orderId = $request->query('orderId');

        $productDetailQuery = DB::table('users')
                    ->where('users.id' , $user_id)
                    ->join('orders','orders.user_id','=','users.id')
                    ->join('products','products.id','=','orders.product_id')
                    ->where('orders.id',$orderId)
                    ->where('orders.status','Available')
                    ->where('orders.deleted',0)
                    ->where('products.deleted',0)
                    ->select('*', 'orders.id AS order_id');
    
        $productDetail = $productDetailQuery->get();
        $totalPrice = $productDetailQuery->sum('price');
        

        $count=0;
        $freeGiftName="";
        foreach ($freeGifts['freeGifts'] as $item) {
            if (intval($item['giftRequiredPrice']) <= $totalPrice) {
                $count++;
                $freeGiftName .= $item['giftName'];
                $freeGiftName .= ',';
            }
        }
        $gift = rtrim($freeGiftName, ",");
        

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
                    return view('user/payment', [
                        'shippingMethods' => $shippingMethods,
                        'productDetail' => $productDetail,
                        'totalPrice' => $totalPrice,
                        'tax' => $tax,
                        'gift' => $gift,
                        'count'=>$count,
                        'orderId'=>$orderId
                    ]);
       }
//need to update the order status to Paid
//need to modify the product to deleted = 1
       public function createPayment(Request $req)
    {
        $req->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = auth()->user();
                    if (!$user || $user->email !== $value) {
                        $fail('The email address does not belong to the currently authenticated user.');
                    }
                },
            ],
            'address' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'zip' => 'required|string|regex:/^[0-9]{5}$/',
            'shippingMethod' => 'required',
            'paymentMethod' => 'required',
            'cc-name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'cc-number' => 'required|string|regex:/^[0-9]{16}$/',
            'cc-expiration' => [
                'required',
                'string', 
                'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/',
            ],
            'cc-cvv' => 'required|string|regex:/^[0-9]{3}$/'
            
        ]);

        $queryBuilder = new PaymentQueryBuilder();
        $builder = new PaymentBuilder($queryBuilder);

        $payment = $builder
            ->create([
                'order_id' => $req->input('order_id_hidden'),
                'total_charge' => $req->input('grand_total_hidden'),
                'payment_date' => now()->format('Y-m-d H:i:s'),
                'payment_method' => $req->paymentMethod,
                'billing_address' => $req->address . ', ' . $req->zip . ' ' . $req->state . ', ' . $req->country,
                'deleted' => 0
            ]);

        return redirect('/payment-history')->with('success', 'Payment successful! Thank you for your purchase.');
    }

    public function displayPaymentHistory(){

        $user_id = Session::get('user')['id'];

        $productDetailQuery = DB::table('users')
                    ->where('users.id' , $user_id)
                    ->join('orders','orders.user_id','=','users.id')
                    ->join('products','products.id','=','orders.product_id')
                    ->join('payments','payments.order_id','=','orders.id')
                    ->where('orders.status','Available')//need to change to paid
                    ->where('orders.deleted',0)
                    ->where('products.deleted',0)//need to change to 1
                    ->select('*');
    
        $productDetail = $productDetailQuery->get();
        $count = $productDetailQuery->count();
        

                    return view('user/payment-history', [
                        'productDetail' => $productDetail,
                        'count'=>$count,
                    ]);
       }
}
