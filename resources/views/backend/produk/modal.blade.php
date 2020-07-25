<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="modal fade" id="myModal{{$title}}" role="dialog">
    <div class="modal-dialog">
<div class="modal-content">
  <form id="form{{$title}}" method="post" enctype="multipart/form-data">
  {{csrf_field()}} {{ method_field('POST') }}
        <div class="modal-header">  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Masukan Data {{$title}}</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" 
                placeholder="Nama Produk">
                <span class="help-block has-error nama_produk_error"></span>
            </div>
            <div class="form-group">
                <label>Kategori Produk</label>
                <input type="text" name="kategori_produk" id="kategori_produk" class="form-control" 
                placeholder="Kategori Produk">
                <span class="help-block has-error kategori_produk_error"></span>
            </div>
            <div class="form-group">
                <label>Harga Produk</label>
                <input type="number" name="harga" id="harga" class="form-control" 
                placeholder="Harga Produk">
                <span class="help-block has-error harga_error"></span>
            </div>
            <div class="form-group">
                <label>Kuantitas Produk</label>
                <input type="number" name="kuantitas" id="kuantitas" class="form-control" 
                placeholder="Kuantitas Produk">
                <span class="help-block has-error kuantitas_error"></span>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" name="submit" id="aksiProduk">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</body>
</html> 