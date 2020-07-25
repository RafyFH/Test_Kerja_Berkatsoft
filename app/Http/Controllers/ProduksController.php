<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;

class ProduksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Produk";
        $menubar = "produk";

        return view('backend.produk.index',['title'=>$title , 'menubar'=>$menubar]);
    }
    public function json()
    {
        $index = Produk::all();
        $array = array();
        $no = 1;
        foreach($index as $data){
            $compiling = array();
            $compiling[] = $no++;
            $compiling[] = $data->nama_produk;
            $compiling[] = $data->kategori_produk;
            $compiling[] = $data->harga;
            $compiling[] = $data->kuantitas;
            $compiling[]="<a href='#' class='btn btn-xs btn-primary editproduk' data-id='".$data->id."'>
            <i class='glyphicon glyphicon-edit'></i> Ubah</a>&nbsp;
            <a href='#' class='btn btn-xs btn-danger deleteproduk' id='".$data->id."'>
            <i class='glyphicon glyphicon-remove'></i> Hapus</a>";
            $array[] = $compiling; 
        }
        echo json_encode(array("data"=>$array));
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
            'nama_produk' => 'required',
            'kategori_produk'=>'required',
            'harga'=>'required|numeric',
            'kuantitas'=>'required|numeric',
            
        ],[
            'nama_produk.required'=>':Attribute harus diisi',
            'kategori_produk.required'=>':Attribute harus diisi',
            'harga.required'=>':Attribute harus diisi',
            'kuantitas.required'=>':Attribute harus diisi',
            'harga.numeric'=>':Attribute harus berupa angka',
            'kuantitas.numeric'=>':Attribute harus berupa angka',
        ]);
        $produk = new Produk;
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_produk = $request->kategori_produk;
        $produk->harga = $request->harga;
        $produk->kuantitas = $request->kuantitas;
        $produk->save(); 
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk , $id)
    {
        $get=Produk::find($id);
        return $get;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk, $id)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'kategori_produk'=>'required',
            'harga'=>'required|numeric',
            'kuantitas'=>'required|numeric',
            
        ],[
            'nama_produk.required'=>':Attribute harus diisi',
            'kategori_produk.required'=>':Attribute harus diisi',
            'harga.required'=>':Attribute harus diisi',
            'kuantitas.required'=>':Attribute harus diisi',
            'harga.numeric'=>':Attribute harus berupa angka',
            'kuantitas.numeric'=>':Attribute harus berupa angka',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_produk = $request->kategori_produk;
        $produk->harga = $request->harga;
        $produk->kuantitas = $request->kuantitas;
        $produk->save(); 
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk , $id)
    {
        $del = Produk::find($id);
        if($del->delete())
        {
            echo 'Data Deleted';
        }
    }
}
