<?php
include('../../docs/_includes/header.php');
$id = @$_REQUEST['id'];
// echo $id;
?>
<style>
  #importFrm{

    border: 2px blue dashed;
    padding: 4%;
    margin: 4% 0 4% 0%;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Carwash Type</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Carwash Type Management</a></li>
            <li class="breadcrumb-item active">Add Carwash Type</li>
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
            <div class="card-header">
              <a href="#" class="h1"><b>Add a type</b></a>
              <div class="float-right">
                <button href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="fas fa-plus"></i> Import</button>
              </div>
            </div>
            <div class="card-body">
              <!-- CSV file upload form -->
              <div class="col-md-12" id="importFrm" style="display: none;">
                <form action="../excels/import.php" method="post" enctype="multipart/form-data">
                  <input type="file" name="file" />
                  <input type="submit" class="btn btn-primary" name="import_carwash_type" value="IMPORT">
                </form>
              </div>
              <!-- end CSV file upload form -->
              <div id="alert" class="form-group"></div>
              <div class="errorTxt form-group alert-danger"></div>
              <form id="myForm" name="myForm" method="post">
                <div class="input-group mb-3">
                  <input type="text" id="title" name="title" class="form-control" placeholder="Enter title">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="description" name="description" class="form-control" placeholder="Enter carwash Description">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                      <label for="agreeTerms">
                        I agree to the <a href="#">terms</a>
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <input type="submit" id="save" class="btn btn-primary btn-block" value="Add carwash" />
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
<script src="../../ajax/carwashtypes_ajax.js"></script>
<script>
  $(document).ready(function() {
    var id = `<?php echo @$id; ?>`;
    if (id != '') {
      $.ajax({
        type: 'GET',
        url: '../../API/carwashtype.php',
        dataType: "json",
        data: {
          id: id,
          action: 'edit'
        },
        success: function(result) {
          if (result.success) {
            console.log(result);
            let carwashRec = result.data;
            $('#myForm').append('<input type="hidden" id="id" name="id" value="' + carwashRec.CarwashID + '">')
            $('#title').val(carwashRec.CarwashTitle);
            $('#description').val(carwashRec.CarwashDescription);
            $('#price').val(carwashRec.CarwashPrice);
            $('#save').val('Update User');
          }
        }
      });
    }
  });
</script>
<!-- Show/hide CSV upload form -->
<script>
    function formToggle(ID) {
      var element = document.getElementById(ID);
      if (element.style.display === "none") {
        element.style.display = "block";
      } else {
        element.style.display = "none";
      }
    }
  </script>

