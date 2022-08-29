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
            <h1 class="m-0">Vehicle Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Vehicle Management</a></li>
              <li class="breadcrumb-item active">Add Vehicle</li>
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
              <a href="#" class="h1"><b>Add a new Vehicle</b></a>
            </div>
            <div class="card-body">
              <div id="alert" class="form-group"></div>
              <div class="errorTxt form-group alert-danger"></div>
              <form id="myForm" name="myForm" method="post">
                <div class="input-group mb-3">
                  <select id="user" name="user" class="form-control" placeholder="Select User">
                    <option value="">Please select user</option>
                  </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="name" name="name" class="form-control" placeholder="Enter Vehicle Name">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="plateno" name="plateno" class="form-control" placeholder="Enter Vehicle Plate Number">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="color" name="color" class="form-control" placeholder="Enter Vehicle Colour"></textarea>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-map-marker"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="fuletype" name="fuletype" class="form-control" placeholder="Enter Vehicle Fule Type"></textarea>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-map-marker"></span>
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
                    <input type="submit" id="save" class="btn btn-primary btn-block" value="Add Vehicle" />
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
<script src="../../ajax/vehicle_ajax.js"></script>
<script>
  $(document).ready(function() {
    // alert();
    $.ajax({
      type: 'GET',
      url: '../../API/users.php',
      dataType: "json",
      data: {
        action: 'all_users'
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = '';
          $.each(daftar, function (i, data) {
            //This is selector of my <tbody> in my table
            $("#myForm #user").append(`<option value="` + data.UserID + `">` + data.FullName + `</option>`);
          });
        }
        else {
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      }
    });


  $('#user').ready(function () {
    var id=`<?php echo @$id; ?>`;
    if(id!=''){
    $.ajax({
      type: 'GET',
      url: '../../API/vehicle.php',
      dataType: "json",
      data: {
        id: id,
        action: 'edit'
      },
      success: function(result) {
        if (result.success) {
          console.log(result);
          let vehicleRec = result.data;
          $('#myForm').append('<input type="hidden" id="id" name="id" value="'+vehicleRec.VehicleID+'">')
          $('#user').val(vehicleRec.UserID).attr("selected","selected");
          // $('#user').val(vehicleRec.UserID);
          $('#name').val(vehicleRec.VehicleName);
          $('#plateno').val(vehicleRec.PlateNumber);
          $('#color').val(vehicleRec.VehicleColor);
          $('#fuletype').val(vehicleRec.Fuletype);
          $('#save').val('Update User');
        }
      }
    });
  }
  });
});
</script>
