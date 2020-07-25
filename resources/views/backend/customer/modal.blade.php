<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="modal fade" id="myModalCustomer" role="dialog">
    <div class="modal-dialog">
<div class="modal-content">
  <form id="formCustomer" method="post" enctype="multipart/form-data">
  {{csrf_field()}} {{ method_field('POST') }}
        <div class="modal-header">  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Masukan Data Customer</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
                <label>Nama Customer</label>
                <input type="text" name="nama_customer" id="nama_customer" class="form-control" 
                placeholder="Nama Customer">
                <span class="help-block has-error nama_customer_error"></span>
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="number" name="no_telp" id="no_telp" class="form-control" 
                placeholder="No. Telepon">
                <span class="help-block has-error nomor_telepon_error"></span>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat"></textarea>
                <span class="help-block has-error alamat_error"></span>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" name="submit" id="aksiCustomer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</body>
</html> 