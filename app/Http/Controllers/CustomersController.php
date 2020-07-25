<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
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
        $title = "Customer";
        $menubar = "customer";

        return view('backend.customer.index',['title'=>$title , 'menubar'=>$menubar]);
    }
    public function json()
    {
        $index = Customer::select('id','nama_customer', 'no_telp','alamat')->get();
        $array = array();
        $no = 1;
        foreach($index as $data){
            $compiling = array();
            $compiling[] = $no++;
            $compiling[] = $data->nama_customer;
            $compiling[] = $data->no_telp;
            $compiling[] = $data->alamat;
            $compiling[]="<a href='#' class='btn btn-xs btn-primary editcustomer' data-id='".$data->id."'>
            <i class='glyphicon glyphicon-edit'></i> Ubah</a>&nbsp;
            <a href='#' class='btn btn-xs btn-danger deletecustomer' id='".$data->id."'>
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
            'nama_customer' => 'required',
            'no_telp'=>'required|numeric',
            'alamat'=>'required',
            
        ],[
            'nama_customer.required'=>':Attribute harus diisi',
            'no_telp.required'=>':Attribute harus diisi',
            'alamat.required'=>':Attribute harus diisi',
        ]);
        $customer = new Customer;
        $customer->nama_customer = $request->nama_customer;
        $customer->no_telp = $request->no_telp;
        $customer->alamat = $request->alamat;
        $customer->save(); 
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer,$id)
    {
        $get=Customer::find($id);
        return $get;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer ,$id)
    {
        $this->validate($request, [
            'nama_customer' => 'required',
            'no_telp'=>'required',
            'alamat'=>'required',
            
        ],[
            'nama_customer.required'=>':Attribute harus diisi',
            'no_telp.required'=>':Attribute harus diisi',
            'alamat.required'=>':Attribute harus diisi',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->nama_customer = $request->nama_customer;
        $customer->no_telp = $request->no_telp;
        $customer->alamat = $request->alamat;
        $customer->save();
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer,$id)
    {
        $del = Customer::find($id);
        if($del->delete())
        {
            echo 'Data Deleted';
        }
    }
}
