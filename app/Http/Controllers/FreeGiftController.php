<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FreeGiftController extends Controller
{
    public function getData()
    {
        $client = new Client();

        // free-gifts for testing
        $response = $client->request('GET', 'http://127.0.0.1:9000/api/free-gifts');
        $freeGifts = json_decode($response->getBody()->getContents(), true);

        
        return $freeGifts;
    }
}
