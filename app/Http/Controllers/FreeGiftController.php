<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;


use Illuminate\Http\UploadedFile;

use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;


class FreeGiftController extends Controller

{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index()
    {
        $freeGifts = $this->get();
        
         // return view('admin/all-gift', compact('freeGifts'));
         return view('admin/all-gift', [
            'freeGifts' => $freeGifts
        ]);
    }

    public function get()
    {

        // free-gifts for testing
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/free-gifts');
        $freeGifts = json_decode($response->getBody()->getContents(), true);

        
        return $freeGifts;
    }

    public function create(){
        return view('admin/add-gift');
    }

    public function show($id)
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:9000/api/free-gifts/' . $id);
        $freeGift = json_decode($response->getBody()->getContents(), true);
        if (!$freeGift) {
            return response()->json(['error' => 'Free gift not found'], 404);
        }

        return response()->json($freeGift);
    }
    public function store(Request $req){
        $req->validate([
            'giftName' => 'required|string|regex:/^.{0,255}$/',
            'giftDesc' => 'required|string|regex:/^.{0,255}$/',
            'giftRequiredPrice' => 'required|string|regex:/^\d{0,255}$/',
            'qty' => 'required|int',
            'giftImages' => 'required'
        ]);
        
        $gift_img = NULL;
        if ($files = $req->input('giftImages')) {
            $json_data = json_decode($files, true);
                $data_column = $json_data['data']??null;
                $image = base64_decode($data_column);
                $image_name = uniqid(rand(), false) . '.png';
                if (file_put_contents('../public/user/img/gift/'.$image_name, $image)) {
                    $gift_img = $image_name;
                }
        }

        $data = [
            'giftName' => $req->giftName,
            'giftDesc' => $req->giftDesc,
            'giftRequiredPrice' => $req->giftRequiredPrice,
            'qty' => $req->qty,
            'giftImages' => $gift_img,
            'deleted' => 0
        ];
        
            $response = $this->client->post('http://127.0.0.1:9000/api/free-gifts', [
                'json' => $data
            ]);
            $freeGifts = json_decode($response->getBody()->getContents(), true);
            return redirect('freegifts')->with('success', 'Successfully added a gift');
        
    }

    public function update($id,Request $req)
    {
        $req->validate([
            'giftName' => 'required|string|regex:/^.{0,255}$/',
            'giftDesc' => 'required|string|regex:/^.{0,255}$/',
            'giftRequiredPrice' => 'required|string|regex:/^\d{0,255}$/',
            'qty' => 'required|int'
        ]);
        $gift_img = NULL;
        if ($files = $req->input('giftImages')) {
            $json_data = json_decode($files, true);
                $data_column = $json_data['data']??null;
                $image = base64_decode($data_column);
                $image_name = uniqid(rand(), false) . '.png';
                if (file_put_contents('../public/user/img/gift/'.$image_name, $image)) {
                    $gift_img = $image_name;
                }
        }
        if($gift_img != null){
            $data = [
            'giftName' => $req->giftName,
            'giftDesc' => $req->giftDesc,
            'giftRequiredPrice' => $req->giftRequiredPrice,
            'qty' => $req->qty,
            'giftImages' => $gift_img,
            'deleted' => 0
            ];
        }else{
            $data = [
            'giftName' => $req->giftName,
            'giftDesc' => $req->giftDesc,
            'giftRequiredPrice' => $req->giftRequiredPrice,
            'qty' => $req->qty,
            'deleted' => 0
            ];
        }
        $response = $this->client->put('http://127.0.0.1:9000/api/free-gifts/'.$id, [
                    'json' => $data
                ]);
            $freeGifts = json_decode($response->getBody()->getContents(), true);
            return redirect('freegifts')->with('success', 'Successfully edit a gift');
    }


    public function destroyGift($id)
    {
        $response = $this->client->delete('http://127.0.0.1:9000/api/free-gifts/'.$id);

        $freeGifts = json_decode($response->getBody()->getContents(), true);

        return redirect('freegifts')->with('success', 'Successfully deleted a gift');
    }
    

    public function edit($id)
    {
        $response = $this->show($id);
        $freegift = json_decode($response->getContent(), true)['free_gift'];
        return view('admin/edit-gift', compact('freegift'));
    }
}
