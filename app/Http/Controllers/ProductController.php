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
        $data = Product::all();
        // $data=(json_encode($data));
        return view('product')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        //
        $request->validate([
            'ProductName' => 'required',
            'Price' => 'required',
            'Stock' => 'required',
        ]);

        $store = Product::create([
            'ProductName' => htmlspecialchars($request->input('ProductName')),
            'Stock' => htmlspecialchars($request->input('Stock')),
            'Price' => htmlspecialchars($request->input('Price')),
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    public function update2(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required',
            'ProductName' => 'required',
            'Stock' => 'min:1||required',
            'Price' => 'required',
        ]);

        $update = Product::findOrFail($request->id);

        if ($update) {
            $update->update([
                'ProductName' => htmlspecialchars($request->input('ProductName')),
                'Stock' => htmlspecialchars($request->input('Stock')),
                'Price' => htmlspecialchars($request->input('Price')),
            ]);
            $result = $update->save();

            if ($result == true) {
                session('success', 'berhasil');
            }
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(){

    }
    public function destroy2(Request $request)
    {
        // dd($request->all());
        Product::findOrFail($request->id)->deleteOrFail();
        return back();
    }
}
