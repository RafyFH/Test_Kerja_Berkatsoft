@extends('partials.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('error'))
        <div class="alert alert-block alert-success">
            <a class="close" data-dismiss="alert" href="#">×</a>
                    {{ session('error') }}<br>
        </div>
        @endif
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Default Form</span>
                </div>
            </div>
            <div class="row">
                
                <div class="portlet-body form">
                    <form action="{{route('sales-store')}}"  method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control" name="id_customer">
                                    <option disabled selected >-- Pilih Customer --</option>
                                @foreach($customer as $data)
                                    <option value="{{$data->id}}">
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
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Tambah</button>
                            <a href="{{url('sales-order')}}" type="button" class="btn default">Batal</a>
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
            html +='<td><select name="id_produk[]" class="form-control produkselect select-pilih" id="id_produk"><option>--Pilih Produk--</option>@foreach($produk as $data)<option value="{{$data->id}}">{{$data->nama_produk}}-{{$data->kuantitas}} </option>@endforeach</select></td><td><input type="number" min="1" name="kuantitas_produk[]" id="kuantitas_produk" class="form-control kuantitas_produk"/>';
            html +='<td><input type="number" name="harga[]" id="harga" class="form-control harga"  readonly="" /></td>';
            html +='<td><input type="text" name="jumlah" id="jumlah" class="form-control jumlah" readonly/></td></tr>';
            
            $('#tbl_create').append(html);
            $('#count').val(count++);
            
        })

     $(document).on('change','.produkselect', function(){
        //  alert();
            var produk = $(this).val();
            var Eproduk = $(this).parent().parent(); 
            $.ajax({
                type: "get",
                url: 'findproduk/'+produk,
                data: {produk : produk},
                success:function(data){
                    console.log(Eproduk.find('.jumlah'));
                    Eproduk.find('.jumlah').val(data[0].kuantitas);
                    Eproduk.find('.harga').val(data[0].harga);
                    // $('.jumlah'+count).val(data[0].kuantitas);
                    // $('.harga'+count).val(data[0].harga);
                }
            })
        });
</script>
@endsection