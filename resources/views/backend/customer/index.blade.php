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
                    <button type="button" class="btn btn-primary" id="TambahCustomer"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                    
                    </div>
                </div>
            </div>
            @include('backend.customer.modal')
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                    <thead>
                        <tr>
                            <th>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" />
                                    <span></span>
                                </label>
                            </th>
                            <th> Nama </th>
                            <th> No. Telepon </th>
                            <th> Alamat </th>
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
            ajax: '/jsoncustomer',
        });
        //crud(modal)
        $('#TambahCustomer').click(function(){
        $('#myModalCustomer').modal('show');
        $('.modal-title').text('Masukan Data Customer');
        // $('.select-pilih').select2();
        $('#aksiCustomer').val('Tambah Customer');
            state = "insert";
        });

        $('#myModalCustomer').on('hidden.bs.modal',function(e){
            $(this).find('#formCustomer')[0].reset();
            $('span.has-error').text('');
            $('.form-group.has-error').removeClass('has-error');
        });
        //function
        function create_data(){
            $("#formCustomer").submit(function(e){
                $.ajaxSetup({
                  header: {
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                  }
                });
                e.preventDefault();
                    if (state == 'insert') {
                    $.ajax({
                        url:'store-customer',
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
                        $('#myModalCustomer').modal('hide');
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
                            $("#formCustomer")[0].reset();
                        }
                                    
                });
                }
                else{
                    $.ajax({
                        url:'update-customer/' + $('#id').val(),
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
                        $('#myModalCustomer').modal('hide');
                        $('#datatable').DataTable().ajax.reload();
                        },
                        complete: function() {
                            $("#formCustomer")[0].reset();
                        }
                    });

                }
            });
        }
        $(document).on('click', '.editcustomer', function(){
            var id = $(this).data('id');
            $('#formCustomer').submit('');
            $.ajax({
              url:'get-customer' + '/' + id,
              method:'get',
              data:{id:id},
              dataType:'json',
              success:function(data){
                console.log(data);
                state = "update";
                $('#id').val(data.id);
                $('#nama_customer').val(data.nama_customer);
                $('#no_telp').val(data.no_telp);
                $('#alamat').val(data.alamat);
                $('#myModalCustomer').modal('show');
                $('#aksiCustomer').val('Simpan');
                $('.modal-title').text('Ubah Data Customer');
                }
              });
          });
          $(document).on('click', '.deletecustomer', function(){
                var id = $(this).attr('id');
                  if (confirm("Yakin Dihapus ?")) {
                    $.ajax({
                      url: 'delete-customer/'+id,
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