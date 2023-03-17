<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;

use App\Facades\ProductFacade;
use Illuminate\Foundation\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;




class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        //return view('admin/all-product', compact('products'));
        return view('user/all-product', compact('products'));
    }

    public function admin()
    {

        $products = Product::all();

        return view('admin/all-product', compact('products'));
    }

    public function details($id)
    {
        $product = Product::find($id);

        return view('user/product-details', compact('product'));
    }

    public function cart($id)
    {
        $product = Product::find($id);
        $products = [$product]; // create an array of products with a single product

        return view('user/cart', compact('products'));
    }


    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        /*
make
model  
price   
year
mileage
color
transmission
description
images

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
            'filepond' => 'required', // validate each image file in the array
            'price' => 'required|numeric',
        ]);

        $images = array();
        if ($files = $request->input('filepond')) {
            foreach ($files as $file) {
                $json_string = json_decode($file, true);
                $data_column = $json_string['data'];

                $image = base64_decode($data_column);
                $image_name = uniqid(rand(), false) . '.png';
                file_put_contents('../public/user/img/product/'.$image_name, $image);
                $images[] = $image_name;
            }
        }
        $product->product_image = implode("|", $images);
        $product->save();

        if ($this->middleware('isAdmin')) {
            return redirect()->route('products.admin')->with('success', 'Information has been added');
        } else {
            return redirect()->route('products.index')->with('success', 'Information has been added');
        }
    }




    public function edit(Request $request, $id)
    {
        $product = Product::find($id);

        // Check if user is authorized to edit the product
        if ($this->middleware('isAdmin') && $product->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to edit this product.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0|max:999999',
            'color' => 'required|string',
            'transmission' => 'required|string',
            'pDesc' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        // Update the product with the validated data
        $product->make = $validatedData['make'];
        $product->model = $validatedData['model'];
        $product->year = $validatedData['year'];
        $product->mileage = $validatedData['mileage'];
        $product->color = $validatedData['color'];
        $product->transmission = $validatedData['transmission'];
        $product->product_description = $validatedData['pDesc'];
        $product->price = $validatedData['price'];
        $product->save();

        return redirect()->route('products.store', ['id' => $id])->with('success', 'Product updated successfully.');
    }





    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // authorize user to delete product
        //$this->middleware('isAdmin');

        // check if product has any orders
        if ($product->orders()->exists()) {
            return redirect()->back()->withErrors(['Product has existing orders and cannot be deleted']);
        }

        // delete product image from disk
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // delete product variations and images from disk
        if ($product->variations) {
            foreach ($product->variations as $variation) {
                if ($variation->image) {
                    Storage::disk('public')->delete($variation->image);
                }
                $variation->delete();
            }
        }

        // delete product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function setDeleted($id)
    {
        $product = Product::find($id);

        $product->deleted = 1;
        $product->save();

        return response()->json(['message' => 'Product set deleted to 1 successfully'], 200);
    }

}
