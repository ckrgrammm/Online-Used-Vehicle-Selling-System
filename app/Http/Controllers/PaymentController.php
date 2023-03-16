<?php

namespace App\Http\Controllers;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;
use Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FreeGiftController;
use App\Builders\PaymentBuilder;
use App\Builders\PaymentQueryBuilder;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends Controller
{
    protected $paymentBuilder;

    public function __construct(PaymentBuilder $paymentBuilder)
    {
        $this->paymentBuilder = $paymentBuilder;
    }

    public function index()
    {
        $payments = $this->paymentBuilder->readAll();

        return view('admin/all-payment', compact('payments'));
    }

    public function edit($id)
    {
        $payment = $this->paymentBuilder->readById($id);

        $date = new DateTime();
        $payment->payment_date = $date->format('Y-m-d');

        return view('admin/edit-payment', compact('payment'));
    }
    
    public function create(){
        return view('admin/add-payment');
    }
    public function store(Request $req){
        $req->validate([
            'order_id' => [
                'required',
                'string',
                'regex:/^[0-9]{1,4}$/',
                Rule::exists('orders', 'id')->where(function ($query) {
                    $query->where('status', 'Available');
                })
            ],
            'total_charge' => 'required|int|regex:/^[0-9]{0,10}$/',
            'date' => 'required|date',
            'method' => 'required',
            'address' => 'required|string'
        ]);
        $date_string = $req->input('date');
        $payment_date = DateTime::createFromFormat('Y-m-d', $date_string);
        $data = [
            'order_id' => $req->order_id,
            'total_charge' => $req->total_charge,
            'payment_date' => $payment_date,
            'payment_method' => $req->method,
            'billing_address' => $req->address,
            'deleted' => 0
        ];
        $this->paymentBuilder->create($data);

        //update order status to Paid
        $order = Order::find($req->order_id);
        if ($order && $order->status === 'Available') {
            $order->status = 'Paid';
            $order->save();
        }
        $product_id = $order->product_id;

        $orders = Order::where('product_id', $product_id)->get();

        //update order status same product id to Sold
        foreach ($orders as $order) {
            if ($order->status === 'Available') {
                $order->status = 'Sold';
                $order->save();
            }
        }

        return redirect('payments')->with('success', 'Successfully added a payment');

    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'order_id' => [
                'required',
                'string',
                'regex:/^[0-9]{1,4}$/',
                Rule::exists('orders', 'id')->where(function ($query) {
                    $query->where('status', 'Available');
                })
            ],
            'total_charge' => 'required|int|regex:/^[0-9]{0,10}$/',
            'date' => 'required|date',
            'method' => 'required',
            'address' => 'required|string'
        ]);


        $date_string = $req->input('date');
        $payment_date = DateTime::createFromFormat('Y-m-d', $date_string);
        $data = [
            'order_id' => $req->order_id,
            'total_charge' => $req->total_charge,
            'payment_date' => $payment_date,
            'payment_method' => $req->method,
            'billing_address' => $req->address,
            'deleted' => 0
        ];

        $this->paymentBuilder->update($id,$data);

        //update order status to Paid
        $order = Order::find($req->order_id);
        if ($order && $order->status === 'Available') {
            $order->status = 'Paid';
            $order->save();
        }
        $product_id = $order->product_id;

        $orders = Order::where('product_id', $product_id)->get();

        //update order status same product id to Sold
        foreach ($orders as $order) {
            if ($order->status === 'Available') {
                $order->status = 'Sold';
                $order->save();
            }
        }

        return redirect('payments')->with('success', 'Payment information has been updated');

    }

    public function destroyPayment(string $id)
    {
        $this->paymentBuilder->delete($id);

        return redirect('payments')->with('success', 'Payment information has been deleted');
    }

    public function displayPayment(){

        $user_id = Session::get('user')['id'];

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->get();
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

        //update order status to Paid
        $order = Order::find($req->input('order_id_hidden'));
        if ($order && $order->status === 'Available') {
            $order->status = 'Paid';
            $order->save();
        }
        $product_id = $order->product_id;

        $orders = Order::where('product_id', $product_id)->get();

        //update order status same product id to Sold
        foreach ($orders as $order) {
            if ($order->status === 'Available') {
                $order->status = 'Sold';
                $order->save();
            }
        }

        return redirect('/payment-history')->with('success', 'Payment successful! Thank you for your purchase.');
    }

    public function displayPaymentHistory(){

        $user_id = Session::get('user')['id'];

        $productDetailQuery = DB::table('users')
                    ->where('users.id' , $user_id)
                    ->join('orders','orders.user_id','=','users.id')
                    ->join('products','products.id','=','orders.product_id')
                    ->join('payments','payments.order_id','=','orders.id')
                    ->where('orders.status','Paid')//need to change to paid
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
