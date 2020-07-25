<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SalesOrder extends Model
{
    protected $table = 'm_sales_order';
    public static function get_sales_order (){
        $salesO = DB::table('m_sales_order')->leftJoin('m_customer', 'm_sales_order.id_customer', '=', 'm_customer.id')->select('m_sales_order.id','m_sales_order.kode_order','m_customer.nama_customer')->get();
        $array = array();
        $no = 1;
        foreach($salesO as $data){
            $compiling = array();
            $compiling[] = $no++;
            $compiling[] = $data->kode_order;
            $compiling[] = $data->nama_customer;
            $compiling[]="<a href='get-sales-order/".$data->id."' class='btn btn-xs btn-primary editsalesorder' data-id='".$data->id."'>
            <i class='glyphicon glyphicon-edit'></i> Ubah</a>&nbsp;
            <a href='#' class='btn btn-xs btn-danger deletesalesorder' id='".$data->id."'>
            <i class='glyphicon glyphicon-remove'></i> Hapus</a>";
            $array[] = $compiling; 
        }
        return $array;
    }
}
