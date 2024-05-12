<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all();
        return view('index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'productname' => 'required|string|max:255',
            'productprice' => 'required|numeric',
            'productdescription' => 'nullable|string',
            'publish' => 'required|in:yes,no',
        ]);

        $product = new Product();
        $product->name = $request->input('productname');
        $product->price = $request->input('productprice');
        $product->details = $request->input('productdetails');
        $product->is_published = $request->input('publish') == 'yes' ? true : false;

        $product->save();

        // Redirect back with success message or do whatever you want
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::findOrFail($id);
        // dd($product);
        return view('show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::findOrFail($id);

        return view('edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'productname' => 'required|string|max:255',
            'productprice' => 'required|numeric',
            'productdescription' => 'nullable|string',
            'publish' => 'required|in:yes,no',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('productname');
        $product->price = $request->input('productprice');
        $product->details = $request->input('productdetails');
        $product->is_published = $request->input('publish') == 'yes' ? true : false;

        $product->save();

        // Redirect back with success message or do whatever you want
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $productdata = Product::findOrFail($id);

        $productdata->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Perform the search query
        $products = Product::where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('details', 'LIKE', "%$searchTerm%")
            ->get();
       
        // Pass the search results to the view
        return view('index', compact('products', 'searchTerm'));
    }
}
