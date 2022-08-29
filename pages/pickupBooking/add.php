<?php
include('../../docs/_includes/header.php');
$id = @$_REQUEST['id'];
// echo $id;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pickup Booking</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Pickup Booking Management</a></li>
            <li class="breadcrumb-item active">Add Pickup Booking </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">


      <div class="hold-transition register-page" style="height: 90vh;">

        <div class="register-box" style="width: 80%;">
          <div class="card card-outline card-primary">
            <div class="card-header text-center">
              <a href="#" class="h1"><b>Assign Service Person</b></a>
            </div>
            <div class="card-body">
              <div class="errorTxt form-group alert-danger"></div>
              <form id="myForm" name="myForm" method="post">
                <div class="row">
                  <div class="input-group mb-3 col-sm-4">
                    <select id="service" name="service" class="form-control" onchange="bookedOrder(event)">
                      <option value="">Select Service</option>
                      <option value="carwash">Carwash Booking</option>
                      <option value="battery">Battery Service Booking</option>
                      <option value="oil">Oil Service Booking</option>
                      <option value="tyre">Tyre Service Booking</option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-tools"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-4">
                    <select id="booking" name="booking" class="form-control" placeholder="Select booking">
                      <option value="">Select Booked Order</option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-4">
                    <select id="servicePerson" name="servicePerson" class="form-control" placeholder="Select Service Person">
                      <option value="">select Service Person</option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <!-- /.col -->
                  <div class="col-10">

                  </div>
                  <div class="col-2">
                    <input type="button" id="save" class="btn btn-primary btn-block" value="Submit" />
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
<script src="../../ajax/pickup_booking.js"></script>
