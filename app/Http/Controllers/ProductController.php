<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('pegawai')->get();

        return response()->json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_pegawai' => 'required',
            'nik' => 'required|unique:products,nik',
            'nama' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
            'keperluan' => 'required',
            'image' => 'required|image|max:2048'
            
        ]);

        $product = Product::create([
            'id_pegawai' => $request->id_pegawai,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'keperluan' => $request->keperluan            
        ]);

        if($request->image){
            $imageName = time().'_'. uniqid() .'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('storage/product'), $imageName);
            $product->image = '/storage/product/' . $imageName;
            $product->save();
        }

        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {   
        $this->validate($request, [
            'id_pegawai' => 'required',
            'nik' => "required|unique:products,nik,$product->id",
            'nama' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
            'keperluan' => 'required',
            'image' => 'required|image|max:2048'
            
        ]);

        $product->update([
            'id_pegawai' => $request->id_pegawai,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'keperluan' => $request->keperluan, 
        ]);

        if($request->image){
            $imageName = time().'_'. uniqid() .'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('storage/product'), $imageName);
            $product->image = '/storage/product/' . $imageName;
            $product->save();
        }

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product){
            $productImage = $product->image;
            $imagePath = public_path($productImage);
            
            if($productImage && file_exists($imagePath)){
                unlink($imagePath);
            }

            $product->delete();
        }else {
            return response()->json('Product not found.', 404);
        }
    }
}