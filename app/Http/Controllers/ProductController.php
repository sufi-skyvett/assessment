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
        //
        $resource = Product::find($id);
        // $latestProject = $resource->projects()->orderBy('created_at', 'desc')->first();
        $latestProject = DB::table('projects')
            ->join('project_resource', 'projects.id', '=', 'project_resource.project_id')
            ->select('projects.*')
            ->where('project_resource.resource_id', $id)
            ->orderBy('project_resource.created_at', 'desc')
            ->first();

        $resourceProjects = DB::table('projects')
            ->join('project_resource', 'projects.id', '=', 'project_resource.project_id')
            ->where('project_resource.resource_id', $id)
            ->orderBy('project_resource.created_at', 'desc')
            ->select('projects.*', 'project_resource.created_at as pivot_created_at')
            ->get();

        //dd($resourceProjects);
        return view('show', compact('product'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return view('resources.edit', compact('resource', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $updateresource = Resource::find($id);
        $updateresource->name = $request->input('resourcename');
        $updateresource->description = $request->input('resourcedescription');

        $updateresource->update();
        $updateresource->projects()->attach($request->input('project_id'), ['created_at' => now(), 'updated_at' => now()]);
        //$updateresource->projects()->sync([$request->input('project_id') => ['created_at' => now(), 'updated_at' => now()]]);
        //dd($request);
        return redirect()->route('resources.index')->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $taskdata = Task::find($id);

        $taskdata->delete();
        return redirect()->route('tasks.index')
            ->with('success', 'Project deleted successfully');
    }
}
