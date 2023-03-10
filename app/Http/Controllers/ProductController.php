<?php

namespace App\Http\Controllers;

use App\Facades\ProductFacade;
use Illuminate\Foundation\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;



class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin/all-product', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        /*
        $data = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'price' => 'required|string',
            'year' => 'required|string',
            'mileage' => 'required|string',
            'color' => 'required|string',
            'transmission' => 'required|string',
            'description' => 'required|string',
            'images' => 'required'

        ]);

make
model  
price   
year
mileage
color
transmission
description
images

        $product = new Product();
        $product->user_id = Session::get('user')['id'];
        $product->make = $request->post('make');
        $product->model = $request->post('model');
        $product->price = $request->post('price');
        $product->year = $request->post('year');
        $product->mileage = $request->post('mileage');
        $product->color = $request->post('color');
        $product->transmission = $request->post('transmission');
        $product->product_description = $request->post('description');
        $images=array();
        if($files=$request->file('images')){
            foreach($files as $file){
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $file->getClientOriginalName();
                $file->move('../public/user/img/product/',$imageName);
                $images[]=$imageName;
            }
        }

        //Insert your data
        $product->product_image = implode("|",$images);
        $product->save();
        
        return redirect('/all-product')->with('success', 'Information has been added');

        */



        //Observer Design Pattern


        $product = new Product([
            'user_id' => auth()->user()->id,
            'make' => $request->input('make'),
            'model' => $request->input('model'),
            'year' => $request->input('year'),
            'mileage' => $request->input('mileage'),
            'color' => $request->input('color'),
            'transmission' => $request->input('transmission'),
            'product_description' => $request->input('pDesc'),
            'price' => $request->input('price'),
            'deleted' => false,
        ]);

        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'mileage' => 'required|numeric',
            'color' => 'required',
            'transmission' => 'required',
            'pDesc' => 'required',
            'images' => 'required', // validate each image file in the array
            'price' => 'required|numeric',
        ]);

        $images = array();
        if ($files = $request->file('images')) {
        foreach ($files as $file) {
            $var = date_create();
            $time = date_format($var, 'YmdHis');
            $imageName = $time . '-' . $file->getClientOriginalName();
            $file->move('../public/user/img/product/', $imageName);
            $images[] = $imageName;
        }
    }


        $product->product_image = implode("|", $images);
        $product->save();

        return redirect()->route('products.index')->with('success', 'Information has been added');



        /*
        $product->user_id = auth()->user()->id;  // assuming you have an authenticated user
        $product->make = $request->input('make');
        $product->model = $request->input('model');
        $product->year = $request->input('year');
        $product->mileage = $request->input('mileage');
        $product->color = $request->input('color');
        $product->transmission = $request->input('transmission');
        $product->product_description = $request->input('pDesc');
        //$product->product_image = $request->input('pImg');
        $images = array();
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $file->getClientOriginalName();
                $file->move('../public/user/img/product/', $imageName);
                $images[] = $imageName;
            }
        }
        $product->price = $request->input('price');
        $product->deleted = false;

        $product->product_image = implode("|", $images);
        $product->save();

        
        return redirect()->route('products.index')->with('success', 'Information has been added');
        
        /*
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/all-product');
        } else {
            
        
            // Otherwise, redirect them to the user/all-product page
            return redirect('/user/all-product');
            */
        
    }

    public function show($id)
    {
        $product = ProductFacade::getById($id);
        return view('products.show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = ProductFacade::getById($id);
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity'
        ]);
    }
}
