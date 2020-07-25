@extends('partials.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="success"></div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Managed Table</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <button type="button" class="btn btn-primary" id="TambahProduk"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                    
                    </div>
                </div>
            </div>
            @include('backend.produk.modal')
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th> Nama Produk </th>
                            <th> Kategori Produk </th>
                            <th> Harga </th>
                            <th> Kuantitas </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        create_data();
        //datatable
        $('#datatable').DataTable({
            processing: true,
            // serverSide: true,
            paging: true,
            ajax: '/jsonproduk',
        });
        //crud(modal)
        $('#TambahProduk').click(function(){
        $('#myModalProduk').modal('show');
        $('.modal-title').text('Masukan Data Produk');
        // $('.select-pilih').select2();
        $('#aksiProduk').val('Tambah Produk');
            state = "insert";
        });

        $('#myModalProduk').on('hidden.bs.modal',function(e){
            $(this).find('#formProduk')[0].reset();
            $('span.has-error').text('');
            $('.form-group.has-error').removeClass('has-error');
        });
        //function
        function create_data(){
            $("#formProduk").submit(function(e){
                $.ajaxSetup({
                  header: {
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                  }
                });
                e.preventDefault();
                    if (state == 'insert') {
                    $.ajax({
                        url:'store-produk',
                        type:'post',
                        data: new FormData(this),
                        cache: true,
                        contentType: false,
                        processData: false,
                        async:false,
                        dataType: 'json',
                        success: function (data){
                        console.log(data);
                        $('#success').show();
                        var success = "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>"
                        success += "Data Berhasil disimpan!"
                        $('#success').addClass('alert alert-success alert-dismissible fade in').html(success);
                        //
                        $('#success').attr('hidden',false);
                        setTimeout(function(){
                            $('#success').fadeOut('slow');
                        }, 5000);
                        $('#myModalProduk').modal('hide');
                        $('#datatable').DataTable().ajax.reload();
                        },
                        error: function (data){
                            $('input').on('keydown keypress keyup click change', function(){
                            $(this).parent().removeClass('has-error');
                            $(this).next('.help-block').hide()
                            });
                            var coba = new Array();
                            console.log(data.responseJSON.errors);
                            $.each(data.responseJSON.errors,function(name, value){
                                console.log(name);
                                coba.push(name);
                                $('input[name='+name+']').parent().addClass('has-error');
                                $('input[name='+name+']').next('.help-block').show().text(value);
                            });
                            $('input[name='+coba[0]+']').focus();
                        },
                        complete: function() {
                            $("#formProduk")[0].reset();
                        }
                                    
                });
                }
                else{
                    $.ajax({
                        url:'update-produk/' + $('#id').val(),
                        type:'post',
                        data: new FormData(this),
                        cache: true,
                        contentType: false,
                        processData: false,
                        async:false,
                        dataType: 'json',
                        success: function (data){
                        console.log(data);
                        $('#success').show();
                        
                        var success = "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>"
                        success += "Data Berhasil disimpan!"
                        $('#success').addClass('alert alert-success alert-dismissible fade in').html(success);
                        //
                        $('#success').attr('hidden',false);
                        setTimeout(function(){
                            $('#success').fadeOut('slow');
                        }, 5000);
                        $('#myModalProduk').modal('hide');
                        $('#datatable').DataTable().ajax.reload();
                        },
                        complete: function() {
                            $("#formProduk")[0].reset();
                        }
                    });

                }
            });
        }
        $(document).on('click', '.editproduk', function(){
            var id = $(this).data('id');
            $('#formProduk').submit('');
            $.ajax({
              url:'get-produk' + '/' + id,
              method:'get',
              data:{id:id},
              dataType:'json',
              success:function(data){
                console.log(data);
                state = "update";
                $('#id').val(data.id);
                $('#nama_produk').val(data.nama_produk);
                $('#kategori_produk').val(data.kategori_produk);
                $('#harga').val(data.harga);
                $('#kuantitas').val(data.kuantitas);
                $('#myModalProduk').modal('show');
                $('#aksiProduk').val('Simpan');
                $('.modal-title').text('Ubah Data Produk');
                }
              });
          });
          $(document).on('click', '.deleteproduk', function(){
                var id = $(this).attr('id');
                  if (confirm("Yakin Dihapus ?")) {
                    $.ajax({
                      url: 'delete-produk/'+id,
                      method: "get",
                      data:{id:id},
                      success: function(data){
                        $('#success').show();
                      var success = "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>"
                      success += "Data Berhasil Dihapus!"
                      $('#success').addClass('alert alert-success alert-dismissible fade in').html(success);
                      //
                      $('#success').attr('hidden',false);
                      setTimeout(function(){
                        $('#success').fadeOut('slow');
                      }, 5000);
                        $('#datatable').DataTable().ajax.reload();
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
        

    });
</script>
@endsection