<?php

namespace App\Http\Controllers;

use App\Facades\ProductFacade;
use App\Models\Product;
use Illuminate\Http\Request;


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
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|string',


        ]);
        
        $product = ProductFacade::create($data);

        return redirect()->route('products.show', ['product' => $product->id]);
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
