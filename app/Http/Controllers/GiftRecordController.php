<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Session;
use Illuminate\Http\Response;


class GiftRecordController extends Controller

{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index()
    {
        $giftRecords = $this->get();
        
         // return view('admin/all-gift', compact('giftRecords'));
         return view('admin/all-gift', [
            'giftRecords' => $giftRecords
        ]);
    }

    public function get()
    {

        // gift-records for testing
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/gift-records');
        $giftRecords = json_decode($response->getBody()->getContents(), true);

        
        return $giftRecords;
    }

    public function create(){
        return view('admin/add-gift-record');
    }

    public function show($id)
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/gift-records/' . $id);
        $giftRecord = json_decode($response->getBody()->getContents(), true);
        if (!$giftRecord) {
            return response()->json(['error' => 'Gift Record not found'], 404);
        }

        return response()->json($giftRecord);
    }
    public function store(Request $req){
        $validator = Validator::make($req->all(), [
            'paymentId' => ['required', 'string', 'regex:/^.{0,255}$/', 
                function ($attribute, $value, $fail) {
                    $response = Http::get('https://127.0.0.1:9000/api/gift-records/checkPaymentId/' . $value);
            
                    if (!($response->ok() && $response->json()['is_unique'])) {
                        $fail('The '.$attribute.' has already been used.');
                    }
                }],
            'giftId' => ['required','string','regex:/^[0-9,]{0,255}$/',
                function ($attribute, $value, $fail) {
                    $giftIds = explode(',', $value);
                    foreach ($giftIds as $giftId) {
                        $gift = Gift::where('id', $giftId)
                            ->where('quantity', '>', 0)
                            ->where('deleted', 0)
                            ->first();
                        if (!$gift) {
                            $fail('The '.$attribute.' is invalid.');
                            break;
                        }
                    }
                }
            ],
        ]);
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = [
            'paymentId' => $req->paymentId,
            'giftId' => $req->giftId,
            'deleted' => 0
        ];
        
            $response = $this->client->post('http://127.0.0.1:9000/api/gift-records', [
                'json' => $data
            ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return redirect('giftRecords')->with('success', 'Successfully added a gift');
        
    }

    public function update($id,Request $req)
    {
        $req->validate([
            'paymentId' => ['required', 'integer', 'regex:/^.{0,255}$/', 
                function ($attribute, $value, $fail) {
                    $response = $this->client->get('http://127.0.0.1:9000/api/gift-records/checkPaymentId/'.$value);
                    $giftRecords = json_decode($response->getBody()->getContents(), true);
                    
                    if ($response->getStatusCode() == 404 && $giftRecords['gift_record']['id']!=$value) {
                        $fail('The '.$attribute.' has already been used.');
                    }
                }
            ],
            'giftId' => ['string', 'regex:/^[0-9,]{0,255}$/'],
        ]);

        $freeGiftController = new FreeGiftController();
        $freeGifts = $freeGiftController->get();
        $input = $req->all();
        $giftIds = explode(',', $input['giftId']);//update inc and dec and
        $i = array();

        foreach ($giftIds as $giftId) {
            $gift = FreeGift::where('id', $giftId)
                ->where('quantity', '>', 0)
                ->where('deleted', 0)
                ->first();
            
            if ($gift) {
                $response = $freeGiftController->decrease($gift['id']);
                $i[] = $gift['id']; 
            }
        }
        $iString = implode(',', $i);
            $data = [
                'paymentId' => $req->paymentId,
                'giftId' => $iString
            ];
        $response = $this->client->put('http://127.0.0.1:9000/api/gift-records/'.$id, [
                    'json' => $data
                ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return redirect('giftRecords')->with('success', 'Successfully edit a gift');
    }


    public function destroyGift($id)
    {
        $response = $this->client->delete('http://127.0.0.1:9000/api/gift-records/'.$id);

        $giftRecords = json_decode($response->getBody()->getContents(), true);

        return redirect('giftRecords')->with('success', 'Successfully deleted a gift');
    }

    public function edit($id)
    {
        $response = $this->show($id);
        $giftRecord = json_decode($response->getContent(), true)['free_gift'];
        return view('admin/edit-gift', compact('giftRecord'));
    }

    public function storeFromPayment(Request $req){
        $data = [
            'paymentId' => $req->paymentId,
            'giftId' => $req->giftId
        ];
            $response = $this->client->post('http://127.0.0.1:9000/api/gift-records', [
                'json' => $data
            ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return response()->json(['message' => 'Gift Records stored successfully'], 200);
    }

    public function checkPaymentId($paymentId)
    {
        $response = $this->client->get('http://127.0.0.1:9000/api/gift-records/checkPaymentId/'.$paymentId);

        $giftRecords = json_decode($response->getBody()->getContents(), true);

        if ($giftRecords === null) {
            return response()->json(['message' => 'Gift Records is null'], 404);
        }
        
        return response()->json($giftRecords);
    }

    public function updateFromPayment($id,Request $req)
    {
        $req->validate([
            'paymentId' => ['required', 'integer', 'regex:/^.{0,255}$/', 
                function ($attribute, $value, $fail) {
                    $response = $this->client->get('http://127.0.0.1:9000/api/gift-records/checkPaymentId/'.$value);
                    $giftRecords = json_decode($response->getBody()->getContents(), true);
                    
                    if ($response->getStatusCode() == 404 && $giftRecords['gift_record']['id']!=$value) {
                        $fail('The '.$attribute.' has already been used.');
                    }
                }
            ],
            'giftId' => ['string', 'regex:/^[0-9,]{0,255}$/'],
        ]);
        
    
            $data = [
                'paymentId' => $req->paymentId,
                'giftId' => $req->giftId
            ];
        $response = $this->client->put('http://127.0.0.1:9000/api/gift-records/'.$id, [
                    'json' => $data
                ]);
            $giftRecords = json_decode($response->getBody()->getContents(), true);
            return redirect('giftRecords')->with('success', 'Successfully edit a gift');
    }
}