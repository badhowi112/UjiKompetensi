<?php

namespace App\Http\Controllers;

use App\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TamuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tamus = Tamu::with('pegawai')->get();

        return response()->json($tamus, 200);
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
        // $this->validate($request, [
        //     'title' => 'required|max:255|unique:tamus,title',
        //     'price' => 'required|integer',
        //     'image' => 'required|image|max:2048',
        //     'description' => 'required'
        // ]);
        $this->validate($request, [
            'id_pegawai' => 'required',
            'nik' => 'required|unique:tamus,nik',
            'nama' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
            'keperluan' => 'required',
            'image' => 'required|image|max:2048'
            
        ]);

        $tamus = Tamu::create([
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
            $request->image->move(public_path('storage/tamu'), $imageName);
            $tamus->image = '/storage/tamu/' . $imageName;
            $tamus->save();
        }

        return response()->json($tamus, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tamu  $tamu
     * @return \Illuminate\Http\Response
     */
    public function show(Tamu $tamu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tamu  $tamu
     * @return \Illuminate\Http\Response
     */
    public function edit(Tamu $tamu)
    {
        return response()->json($tamu, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tamu  $tamu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Tamu $tamu)
    {   
        // $this->validate($request, [
        //     'title' => "required|max:255|unique:tamus,title, $tamu->id",
        //     'price' => 'required|integer',
        //     'image' => 'sometimes|nullable|image|max:2048',
        //     'description' => 'required'
        // ]);

        $this->validate($request, [
            'id_pegawai' => "required ,$tamu->id",
            'nik' => 'required|unique:tamus,nik',
            'nama' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
            'keperluan' => 'required',
            'image' => 'required|image|max:2048'
            
        ]);
        $tamu->update([
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
            $request->image->move(public_path('storage/tamu'), $imageName);
            $tamu->image = '/storage/tamu/' . $imageName;
            $tamu->save();
        }

        return response()->json($tamu, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tamu  $tamu
     * @return \Illuminate\Http\Response
     */
    public function destroy(tamu $tamu)
    {
        if($tamu){
            $tamuImage = $tamu->image;
            $imagePath = public_path($tamuImage);
            
            if($tamuImage && file_exists($imagePath)){
                unlink($imagePath);
            }

            $tamu->delete();
        }else {
            return response()->json('tamu not found.', 404);
        }
    }
}
