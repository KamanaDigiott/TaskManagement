<?php
include('../../docs/_includes/header.php');
$id=@$_REQUEST['id'];
// echo $id;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Oil Type</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Oil Type Management</a></li>
              <li class="breadcrumb-item active">Add Oil Type</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">


      <div class="hold-transition register-page" style="height: 70vh;">

        <div class="register-box" style="width: 75%;">
          <div class="card card-outline card-primary">
            <div class="card-header text-center">
              <a href="#" class="h1"><b>Add a Oil Type</b></a>
            </div>
            <div class="card-body">
              <div class="errorTxt form-group alert-danger"></div>
              <form id="myForm" name="myForm" method="post">
                <div class="input-group mb-3">
                  <input type="text" id="title" name="title" class="form-control" placeholder="Enter Oil Type title">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="number" id="price" name="price" class="form-control" placeholder="Enter Oil Type Price">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="description" name="description" class="form-control" placeholder="Enter Oil Type Description">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="row">

                  <!-- /.col -->
                  <div class="col-4">
                    <input type="submit" id="save" class="btn btn-primary btn-block" value="Add Oil Type" />
                  </div>
                  <!-- /.col -->
                </div>
              </form>
            </div>
            <!-- /.form-box -->
          </div><!-- /.card -->
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include('../../docs/_includes/footer.php');
?>
<script src="../../ajax/oil_service_type_ajax.js"></script>
<script>
  $(document).ready(function() {
    var id=`<?php echo @$id; ?>`;
    if(id!=''){
    $.ajax({
      type: 'GET',
      url: '../../API/oil_service_type.php',
      dataType: "json",
      data: {
        id: id,
        action: 'edit'
      },
      success: function(result) {
        if (result.success) {
          console.log(result);
          let oilServiceType = result.data;
          $('#myForm').append('<input type="hidden" id="id" name="id" value="'+oilServiceType.OilTypeID+'">')
          $('#title').val(oilServiceType.OilTypeTitle);
          $('#description').val(oilServiceType.OilTypeDescription);
          $('#price').val(oilServiceType.OilTypePrice);
          $('#save').val('Update Oil Service Type');
        }
      }
    });
  }
  });
</script>
