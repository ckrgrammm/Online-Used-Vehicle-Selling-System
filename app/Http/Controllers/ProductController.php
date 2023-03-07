<?php

namespace App\Http\Controllers;

use App\Facades\ProductFacade;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;



class ProductController extends Controller
{
    public function index()
    {
        $products = ProductFacade::getAll();
        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
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
        /*Insert your data*/
        $product->product_image = implode("|",$images);
        $product->save();
        
        return redirect('/all-product')->with('success', 'Information has been added');

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
