@extends('partials.master')
@section('content')
<div class="row">
    <div class="col-md-12">
    @if (session('notif'))
    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert" href="#">×</a>
                {{ session('notif') }}<br>
    </div>
    @endif
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Managed Table</span>
                </div>
                <div class="actions">
                    <a href ="{{url('sales-order-tambah')}}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
                    
                    </div>
                </div>
            
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th> Kode Order </th>
                            <th> Nama Customer </th>
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
        //datatable
        $('#datatable').DataTable({
            processing: true,
            // serverSide: true,
            paging: true,
            ajax: '/jsonsales',
        });
        $(document).on('click', '.deletesalesorder', function(){
                var id = $(this).attr('id');
                  if (confirm("Yakin Dihapus ?")) {
                    $.ajax({
                      url: 'delete-sales-order/'+id,
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