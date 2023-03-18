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
use App\Http\Controllers\GiftRecordController;
use App\Http\Controllers\ProductController;
use App\Builders\PaymentBuilder;
use App\Builders\PaymentQueryBuilder;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;

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
        $payment = $this->paymentBuilder->create($data);
        $paymentId = $payment->id;

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->get();
        $giftIds = array();
        foreach ($freeGifts['freeGifts'] as $item) {
            if (intval($item['giftRequiredPrice']) <= $req->total_charge && $item['qty'] > 0 && $item['deleted'] == 0) {
                //decrease free gift quantity
                $freeGiftController->decrease($item['id']);
                $giftIds[] = $item['id']; 
            }
        }
        $giftIdsString = implode(',', $giftIds);
        if($giftIdsString){
            //update giftRecord
            $giftRecordController = new GiftRecordController();
            $recordData = new Request([
                'paymentId' => $paymentId,
                'giftId' => $giftIdsString,
            ]);
            $giftRecordController->storeFromPayment($recordData);
        }
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
        //set product deleted to 1
        $productController = new ProductController();
        $products = $productController->setDeleted($product_id);

        return redirect('payments')->with('success', 'Successfully added a payment');

    }

    public function update(Request $req, $id)
    {
        if($req->old_order_id==$req->order_id){
            $req->validate([
                'order_id' => [
                'required',
                'string',
                'regex:/^[0-9]{1,4}$/',
                Rule::exists('orders', 'id')->where(function ($query) {
                    $query->where('status', 'Paid');
                })
            ]]);
        }else{
            $req->validate([
                'order_id' => [
                'required',
                'string',
                'regex:/^[0-9]{1,4}$/',
                Rule::exists('orders', 'id')->where(function ($query) {
                    $query->where('status', 'Available');
                })
            ]]);
        }
        $req->validate([
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

        $payment = $this->paymentBuilder->update($id,$data);
        $paymentId = $payment->id;

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->get();
        $giftIds = array();
        foreach ($freeGifts['freeGifts'] as $item) {
            if (intval($item['giftRequiredPrice']) <= $req->total_charge && $item['qty'] > 0 && $item['deleted'] == 0) {
                //decrease free gift quantity
                $freeGiftController->decrease($item['id']);
                $giftIds[] = $item['id']; 
            }
        }
        $giftIdsString = implode(',', $giftIds);
        //update giftRecord
        $giftRecordController = new GiftRecordController();
        $giftRecordResponse = $giftRecordController->checkPaymentId($paymentId);
        $recordData = new Request([
            'paymentId' => $paymentId,
            'giftId' => $giftIdsString,
        ]);
        
        //increase the gift that have in gift record
        if($giftRecordResponse){
            $giftRecord = json_decode($giftRecordResponse->getContent())->gift_record;
            $giftRecordId = $giftRecord->id;
            $ids = $giftRecord->giftId;
            $idsStrings = explode(',', $ids);
            foreach ($idsStrings as $idsString) {
                $freeGiftController->increase($idsString);
              }

            $giftRecordController->updateFromPayment($giftRecordId,$recordData);
        }else{
            $giftRecordController->storeFromPayment($recordData);
        }

        //update order status to Paid
        $order = Order::find($req->order_id);
        if ($order && $order->status === 'Available') {
            $order->status = 'Paid';
            $order->save();
        }
        //update old order status
        $old_order = Order::find($req->old_order_id);
        if ($order && ($order->status === 'Paid'||$order->status === 'Sold')) {
            $order->status = 'Available';
            $order->save();
        }
        $old_product_id = $old_order->product_id;
        $product_id = $order->product_id;

        $old_order = Order::where('product_id', $old_product_id)->get();
        $orders = Order::where('product_id', $product_id)->get();

        //update order status same product id to Sold
        foreach ($orders as $order) {
            if ($order->status === 'Available') {
                $order->status = 'Sold';
                $order->save();
            }
        }

        //set product deleted to 1
        $productController = new ProductController();
        $products = $productController->setDeleted($product_id);
        $old_products = $productController->setNoDeleted($old_product_id);


        return redirect('payments')->with('success', 'Payment information has been updated');

    }

    public function destroyPayment(string $id)
    {
        $this->paymentBuilder->delete($id);

        return redirect('payments')->with('success', 'Payment information has been deleted');
    }

    public function displayPayment()
    {

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
    
        $productDetail = $productDetailQuery->first();
        $productPrice = $productDetail->price;
        

        $count=0;
        $freeGiftName="";
        foreach ($freeGifts['freeGifts'] as $item) {
            if (intval($item['giftRequiredPrice']) <= $productPrice && $item['qty'] > 0 && $item['deleted'] == 0) {
                $count++;
                $freeGiftName .= $item['giftName'];
                $freeGiftName .= ',';
            }
        }
        $gift = rtrim($freeGiftName, ",");
        

        $tax = $productPrice * 0.1;
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
                        'productPrice' => $productPrice,
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
            $paymentId = $payment->id;

            $freeGiftController = new FreeGiftController();
            $freeGifts = $freeGiftController->get();
            $giftIds = array();
            foreach ($freeGifts['freeGifts'] as $item) {
                if (intval($item['giftRequiredPrice']) <= $req->product_price && $item['qty'] > 0 && $item['deleted'] == 0) {
                    
                    $freeGiftController->decrease($item['id']);
                    $giftIds[] = $item['id']; 
                }
            }
            $giftIdsString = implode(',', $giftIds);
            if($giftIdsString){
                //update giftRecord
                $giftRecordController = new GiftRecordController();
                $recordData = new Request([
                    'paymentId' => $paymentId,
                    'giftId' => $giftIdsString,
                ]);
                $giftRecordController->storeFromPayment($recordData);
            }
            //update order status to Paid
            $order = Order::find($req->order_id_hidden);
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
            //set product deleted to 1
        $productController = new ProductController();
        $products = $productController->setDeleted($product_id);

        return redirect('/payment-history')->with('success', 'Payment successful! Thank you for your purchase.');
    }

    public function displayPaymentHistory()
    {

        $user_id = Session::get('user')['id'];

        $productDetailQuery = DB::table('users')
                    ->where('users.id' , $user_id)
                    ->join('orders','orders.user_id','=','users.id')
                    ->join('products','products.id','=','orders.product_id')
                    ->join('payments','payments.order_id','=','orders.id')
                    ->where('orders.status','Paid')
                    ->where('orders.deleted',0)
                    ->where('products.deleted',1)
                    ->select('*');
    
        $productDetail = $productDetailQuery->get();
        $count = $productDetailQuery->count();
        

                    return view('user/payment-history', [
                        'productDetail' => $productDetail,
                        'count'=>$count,
                    ]);
       }
}
