<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('apps.products.index', compact('categories'));
    }

    public function api()
    {
        $products = Product::select('products.*', 'categories.name as category_name')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->filter(request())
            ->get();

        $datatables = datatables()->of($products)
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $method = "store";
        $url = route('apps.products.store');
        $categories = Category::all();
        return view('apps/products/_form', compact('method', 'url', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'         => 'required',
            'title'         => 'required|unique:products',
            'description'   => 'required',
            'category_id'   => 'required',
            'buy_price'     => 'required',
            'sell_price'    => 'required',
            'stock'         => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create category
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'category_id'   => $request->category_id,
            'buy_price'     => $request->buy_price,
            'sell_price'     => $request->sell_price,
            'stock'     => $request->stock,
        ]);

        //redirect
        return redirect()->route('apps.products.index')->with('success', 'Created product successfully');
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
        $method = "update";
        $url = route('apps.products.update', $id);
        $categories = Category::all();
        $product = Product::find($id);
        return view('apps/products/_form', compact('method', 'url', 'categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title'         => 'required|unique:products,title,' . $id,
            'description'   => 'required',
            'category_id'   => 'required',
            'buy_price'     => 'required',
            'sell_price'    => 'required',
            'stock'         => 'required',
        ]);
        $product = Product::find($id);
        //check image update
        if ($request->file('image')) {

            //remove old image
            Storage::disk('local')->delete('public/categories/' . basename($product->image));

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //update category with new image
            Product::whereId($id)->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'category_id'   => $request->category_id,
                'buy_price'     => $request->buy_price,
                'sell_price'    => $request->sell_price,
                'stock'         => $request->stock,
            ]);
        }

        //create category
        Product::whereId($id)->update([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'category_id'   => $request->category_id,
            'buy_price'     => $request->buy_price,
            'sell_price'    => $request->sell_price,
            'stock'         => $request->stock,
        ]);

        //redirect
        return redirect()->back()->with('success', 'Updated product successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
    }
}
