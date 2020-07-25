@extends('partials.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Default Form</span>
                </div>
            </div>
            <div class="row">
                
                <div class="portlet-body form">
                @foreach($sales_order as $data_m)
                    <form action="{{url('update-sales-order/'.$data_m->id.'')}}"  method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" value="{{$data_m->id}}" name="id_order">
                                <label>Nama Customer</label>
                                <select class="form-control" name="id_customer">
                                    <option disabled selected >-- Pilih Customer --</option>
                                    @foreach($customer as $data)
                                        {{$select = ''}}
                                        @if($data->id == $data_m->id_customer)
                                            {{$select ='selected'}}
                                        @endif
                                        <option value="{{$data->id}}" {{$select}}>
                                            {{$data->nama_customer}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label></label>
                                    <a class="btn btn-success" id="tambah">+</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" id="count" name="count">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl_create">
                                <thead>
                                    <tr>
                                        <th> Hapus </th>
                                        <th> Nama Produk </th>
                                        <th> Kuantitas </th>
                                        <th> Harga </th>
                                        <th> Stok </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales_order_p as $data)
                                    <tr>
                                        <td>
                                        <a href="#" class="btn btn-xs btn-danger deleteproduk" id="{{$data->id}}">X</a>
                                        </td>
                                        <td>
                                            <input type="hidden" value="{{$data->id_produk}}" name="id_produk[]">
                                            {{$data->nama_produk}}
                                        </td>
                                        <td>
                                        <input type="text" class="form-control" value="{{$data->kuantitas}}" name="kuantitas_produk[]">
                                        <input type="hidden" class="form-control" value="{{$data->kuantitas}}" name="old_kuantitas[]">
                                        </td>
                                        <td>
                                            {{$data->harga}}
                                        </td>
                                        <td>
                                        <input type="hidden" value="{{$data->kuantitas_produk}}" name="kuantitas[]">
                                            {{$data->kuantitas_produk}}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            @endforeach
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Ubah</button>
                            <a href="{{url('sales-order')}}" class="btn default">Kembali</a>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
        $(document).on('click','.delete',function(){
            var attr = $(this).attr('atribute');
            $('#row'+attr).remove();
        });
        function getnomor_gp(){
            let no = 0;
            $('#tbl_create tbody').find('tr').each(function(){
                no++;
            })
            return no;
        }
        var count = 0;
	    $('#tambah').click(function(e){
            e.preventDefault();
            count = getnomor_gp()+1;
            var html = "<tr id='row"+count+"'>";
            html +='<td><button type="button" id="delete-col" class="btn btn-danger delete" atribute="'+count+'">X</button></td>';
            html +='<td><select name="id_produk[]" class="form-control produkselect select-pilih" id="id_produk"><option>--Pilih Produk--</option>@foreach($produk as $data)<option value="{{$data->id}}">{{$data->nama_produk}}-{{$data->kuantitas}} </option>@endforeach</select></td><td><input type="number" min="1" name="kuantitas_produk[]" id="kuantitas_produk" class="form-control kuantitas_produk"/><input type="hidden" name="old_kuantitas[]" id="old_kuantitas" value="0" class="form-control old_kuantitas" value="0"/>';
            html +='<td><input type="number" name="harga[]" id="harga" class="form-control harga"  readonly="" /></td>';
            html +='<td><input type="text" name="kuantitas" id="kuantitas" class="form-control kuantitas" readonly/></td></tr>';
            
            $('#tbl_create').append(html);
            $('#count').val(count++);
            
        })

     $(document).on('change','.produkselect', function(){
        //  alert();
            var produk = $(this).val();
            var Eproduk = $(this).parent().parent(); 
            $.ajax({
                type: "get",
                url: '/findproduk/'+produk,
                data: {produk : produk},
                success:function(data){
                    console.log(Eproduk.find('.jumlah'));
                    Eproduk.find('.kuantitas').val(data[0].kuantitas_produk);
                    Eproduk.find('.harga').val(data[0].harga);
                    // $('.jumlah'+count).val(data[0].kuantitas);
                    // $('.harga'+count).val(data[0].harga);
                }
            })
        });
        $(document).on('click', '.deleteproduk', function(){
                var id = $(this).attr('id');
                  if (confirm("Yakin Dihapus ?")) {
                    $.ajax({
                      url: '/delete-produk-sales/'+id,
                      method: "get",
                      data:{id:id},
                      success: function(data){
                        location.reload();
                      }
                    })
                  }
                  else
                  {
                      $('#success').show();
                      var success = "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>"
                      success += "Data Tidak Dihapus!"
                      $('#success').addClass('alert alert-success alert-dismissible fade in').html(success);
                      //
                      $('#success').attr('hidden',false);
                      setTimeout(function(){
                        $('#success').fadeOut('slow');
                      }, 5000);
                    return false;
                  }
                });
        
</script>
@endsection