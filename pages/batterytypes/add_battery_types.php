<?php
include('../../docs/_includes/header.php');
$id = @$_REQUEST['id'];
?>
<style>
  #importFrm {

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
          <h1 class="m-0">Battery Type Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Battery Type Management</a></li>
            <li class="breadcrumb-item active">Add Battery Type</li>
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
              <a href="#" class="h1"><b>Add a new battery type</b></a>
              <div class="float-right">
                <button href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="fas fa-plus"></i> Import</button>
              </div>
            </div>

            <div class="card-body">
              <!-- CSV file upload form -->
              <div class="col-md-12" id="importFrm" style="display: none;">
                <form action="../excels/import.php" method="post" enctype="multipart/form-data">
                  <input type="file" name="file" />
                  <input type="submit" class="btn btn-primary" name="import_battery_types" value="IMPORT">
                </form>
              </div>
              <!-- end CSV file upload form -->
              <!-- <div id="alert" class="form-group"></div> -->
              <!-- <div class="errorTxt form-group alert-danger"></div> -->
              <form id="batterytypeForm" name="batterytypeForm" method="post">
                <div class="input-group mb-3">
                  <input type="text" id="type" name="type" class="form-control" placeholder="Battery Type">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-heading"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="car_model" name="car_model" class="form-control" placeholder="Car Model">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="far fa-money-bill-alt"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="weight" name="weight" class="form-control" placeholder="Battery Weight">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-info"></span>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <!-- /.col -->
                  <div class="col-4">
                    <input type="submit" id="save-type" class="btn btn-primary btn-block" value="Add Battery Type" />
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

<script src="../../ajax/battery_type_ajax.js"></script>
<script>
  $(document).ready(function() {
    var id = <?php echo $id; ?>;
    if (id != '') {
      $.ajax({
        type: 'GET',
        url: '../../API/battery_type.php',
        dataType: "json",
        data: {
          id: id,
          action: 'edit_battery_type'
        },
        success: function(result) {
          if (result.success) {
            console.log(result);
            let batteryType = result.data;
            $('#batterytypeForm').append('<input type="hidden" id="id" name="id" value="' + batteryType.BatterytypeID + '">')
            $('#type').val(batteryType.BatteryType);
            $('#car_model').val(batteryType.CarModel);
            $('#weight').val(batteryType.BatteryWeight);
            $('#save-type').val('Update Battery type');
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
