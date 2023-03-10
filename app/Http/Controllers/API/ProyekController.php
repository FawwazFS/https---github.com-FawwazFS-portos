<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Http\Resource\ProyekResource;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek = Proyek::all();
        return response(['proyeks' => ProyekResource::collection($proyeks),'message'=> 'Data berhasil ditampilkan'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request-all();

        $validator = Validator::make($data, [
            'portos'=> 'required|max:225', 
            'harga'=> 'required',
        ]);
    
    
        if ($validator->fails()){
            return response(['error'=> $validator->errors(), 'validasi data nama atau harga salah!'],);
        }

        $proyek = Proyek::create($data);
    
        return response(['proyek'=> new ProyekResource($proyek), 'message'=>'Data proyek berhasil di tambahkan'],200);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show(Proyek $proyek)
    {
        return response(['proyek'=> new ProyekResource($proyek), 'message'=>'Data proyek berhasil di ambil'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyek $proyek)
    {
        $proyek->update($request->all());

        return response(['proyek'=> new ProyekResource($proyek), 'message'=>'Data proyek berhasil di ubah'],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyek $proyek)
    {
        $proyek->delete();

        return response(['message'=>'Data terhapus']);
    }
}
