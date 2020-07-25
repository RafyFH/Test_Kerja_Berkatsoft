<?php

namespace App\Http\Controllers;

use App\SalesOrderPivot;
use App\SalesOrder;
use App\Produk; 
use Illuminate\Http\Request;
use DB;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Sales Order";
        $menubar = "sales_order";
        
        return view('backend.sales_order.index',['title'=>$title , 'menubar'=>$menubar]);
    }
    public function json()
    {
        $salesO = SalesOrder::get_sales_order();
        echo json_encode(array("data"=>$salesO));
    }
    public function findproduk($id){
        $produk = Produk::where('id',$id)->get();
        return response()->json($produk);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Sales Order";
        $menubar = "sales_order";
        $customer = DB::table('m_customer')->get();
        $produk = DB::table('m_produk')->get();
        
        return view('backend.sales_order.create',['title'=>$title , 'menubar'=>$menubar,'customer'=>$customer,'produk'=>$produk]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $m_sales_order = new SalesOrder;
        $m_sales_order->id_customer = $request->id_customer;
        $m_sales_order->kode_order =  $randomString;
        $m_sales_order->save();
        // dd($request->count);
        $insert=[];
        for($i=0; $i < $request->count; $i++){
            $insert[$i]=[
                'id_order'=>$m_sales_order->id,
                'id_produk'=>$request->id_produk[$i],
                'kuantitas'=>$request->kuantitas_produk[$i]
            ];
            $produk = Produk::where('id',$request->id_produk[$i])->first();
            $total = $produk->kuantitas - $request->kuantitas_produk[$i];
            
            $error = array();
            if($request->kuantitas_produk[$i] > $produk->kuantitas){
                $error[] = "Stok barang melebihi";
            }
            if (count($error) > 0 ){
                $data = '';
                for($b=0;$b<count($error);$b++){
                    $data.=  $error[$b].',';
                }
                return redirect('/sales-order-tambah')->with('error',$data);
            }
            else{
                Produk::where('id',$request->id_produk[$i])->update([
                    'kuantitas'=>$total,
                ]);
            }
        }
        $sales = SalesOrderPivot::insert($insert);
        if($sales){
            $notif = "Data Berhasil Ditambah";
            return redirect()->route('sales-order')->with('notif',$notif);
        }
    }
        // dd($sales);

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesOrder $salesOrder,$id)
    {
        $title = "Sales Order";
        $menubar = "sales_order";
        $customer = DB::table('m_customer')->get();
        $produk = DB::table('m_produk')->get();

        $sales_order = SalesOrder::where('id',$id)->get();
        $sales_order_p = SalesOrderPivot::leftJoin('m_produk', 't_sales_order.id_produk', '=', 'm_produk.id')->select('m_produk.nama_produk','t_sales_order.id','t_sales_order.kuantitas','m_produk.harga','m_produk.kuantitas as kuantitas_produk','m_produk.id as id_produk')->where('t_sales_order.id_order',$id)->get();
        // dd($sales_order);
        return view('backend.sales_order.edit',['title'=>$title , 'menubar'=>$menubar,'customer'=>$customer,'sales_order'=>$sales_order,'sales_order_p'=>$sales_order_p,'produk'=>$produk]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesOrder $salesOrder,$id)
    {
        SalesOrder::where('id',$id)->update([
            'id_customer'=>$request->id_customer
        ]);
        SalesOrderPivot::where('id_order', '=', $id)->delete();
        // dd($request->count);
        $insert=[];
        // dd($request->all());
        for($i=0; $i < count($request->id_produk); $i++){
            $insert[$i]=[
                'id_order'=>$id,
                'id_produk'=>$request->id_produk[$i],
                'kuantitas'=>$request->kuantitas_produk[$i]
            ];
            $produk = Produk::where('id',$request->id_produk[$i])->first();
            $total = $produk->kuantitas + $request->old_kuantitas[$i] - $request->kuantitas_produk[$i];
            // dd($total);
            Produk::where('id',$request->id_produk[$i])->update(['kuantitas'=>$total]);
        }
        SalesOrderPivot::insert($insert);
        // dd($sales);
        return redirect()->route('sales-order');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesOrder  $salesOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesOrder $salesOrder,$id)
    {
        $del = SalesOrder::find($id);
        if($del->delete())
        {
            echo 'Data Deleted';
        }
    }
    public function delete_produk(SalesOrder $salesOrder,$id)
    {
        $del = SalesOrderPivot::find($id);
        if($del->delete())
        {
            echo 'Data Deleted';
        }
    }
}
