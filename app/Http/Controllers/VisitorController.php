<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserSystemInfoHelper;
use GuzzleHttp\Client;


class VisitorController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = $this->client->get('https://api.ipify.org');
        $ipAddress = $response->getBody()->getContents();
        $output = geoip()->getLocation($ipAddress);
        $current_location = array(
            'iso_code'		=>	$output->iso_code,
            'country'	    =>	$output->country,
            'city'	        =>	$output->city,
            'state'	        =>	$output->state,
            'state_name'	=>	$output->state_name,
            'postal_code'	=>	$output->postal_code,
            'lat'		    =>	$output->lat,
            'lon'		    =>	$output->lon,
            'timezone'		=>	$output->timezone,
            'continent'		=>	$output->continent,
            'currency'		=>	$output->currency,
            'default'		=>	$output->default,
        );
        $current_location = json_encode($current_location);

        $data = [
            'getip' => $ipAddress,
            'getbrowser' => UserSystemInfoHelper::get_browsers(),
            'getdevice' => UserSystemInfoHelper::get_device(),
            'getos' => UserSystemInfoHelper::get_os(),
            'getcurrentLocation' => $current_location,
            'visit_time' => now()
        ];
        $result = $this->client->post('http://127.0.0.1:9000/api/visitor', [
            'json' => $data
        ]);
        $visitor = json_decode($result->getBody()->getContents(), true);
        return view('user/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
