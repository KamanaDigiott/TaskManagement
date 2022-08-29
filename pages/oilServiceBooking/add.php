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
          <h1 class="m-0">Create Booking</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Oil Service Booking</a></li>
            <li class="breadcrumb-item active">Create Booking</li>
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
              <a href="#" class="h1"><b>Create Booking</b></a>
            </div>
            <div class="card-body">
              <div class="errorTxt form-group alert-danger"></div>
              <form id="myForm" name="myForm" method="post">
                <div class="row">
                  <div class="input-group mb-3 col-sm-6">
                    <select id="user" name="user" class="form-control" placeholder="Select User" onchange="myFunction(event)">
                      <option value="">Please select user</option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-6">
                    <select id="oiltype" name="oiltype" class="form-control" placeholder="Select Oil Type Services" >
                      <option value="">Please select Oil Type Services</option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-tools"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-6">
                    <input type="text" id="booklocation" name="booklocation" class="form-control" placeholder="Enter booking location">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-6">
                    <select id="vehicle" name="vehicle" class="form-control" placeholder="Select vehicle">
                      <option value="">Please select Vehicle</option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>

                  <div class="input-group mb-3 col-sm-6">
                    <input type="date" id="bookdate" name="bookdate" class="form-control" placeholder="Enter booking date">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-phone"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-6">
                    <input type="time" id="booktime" name="booktime" class="form-control" placeholder="Enter booking time">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="input-group mb-3 col-sm-6">
                    <input type="text" id="parktype" name="parktype" class="form-control" placeholder="Enter parking type">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div> -->



                  <!-- <div class="input-group mb-3 col-sm-6">
                    <input type="text" id="orderpickedupby" name="orderpickedupby" class="form-control" placeholder="Enter Order Picked Up By">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div> -->

                  <div class="input-group mb-3 col-sm-6">
                    <input type="text" id="usedealcode" name="usedealcode" class="form-control" placeholder="Enter deal code">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-6">
                    <input type="number" id="totalamt" name="totalamt" class="form-control" placeholder="Enter  total amount">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-sm-6">
                    <input type="text" id="paystatus" name="paystatus" class="form-control" placeholder="Enter payment status">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                   <div class="input-group mb-3 col-sm-6">
                    <input type="text" id="bookingstatus" name="bookingstatus" class="form-control" placeholder="Enter booking status">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                      <label for="agreeTerms">
                        I agree to the <a href="#">terms & condition</a>
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <input type="submit" id="save" class="btn btn-primary btn-block" value="Create Booking" />
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
<script src="../../ajax/oil_appointment_ajax.js"></script>
<script>
  $(document).ready(function() {
    // alert();
    $('#user').ready(function() {
      var id = `<?php echo @$id; ?>`;
      if (id != '') {
        $.ajax({
          type: 'GET',
          url: '../../API/oil_service_booking.php',
          dataType: "json",
          data: {
            id: id,
            action: 'edit'
          },
          success: function(result) {
            if (result.success) {
              console.log(result);
              let bookingRec = result.data;
              if (bookingRec.UserID) {
                $.ajax({
                  type: 'GET',
                  url: '../../API/vehicle.php',
                  dataType: "json",
                  data: {
                    id: bookingRec.UserID,
                    action: 'vehicle_by_UserID'
                  },
                  success: function(result) {
                    if (result.success) {
                      let daftar = result.data;
                      var html = '';
                      $.each(daftar, function(i, data) {
                        //This is selector of my <tbody> in my table
                        $("#myForm #vehicle").append(`<option value="` + data.VehicleID + `" >` + data.VehicleName + `</option>`);
                      });
                      $('#myForm').append('<input type="hidden" id="id" name="id" value="' + bookingRec.BookingID + '">')
                      $('#user').val(bookingRec.UserID).attr("selected", "selected");
                      $('#vehicle').val(bookingRec.VachileID).attr("selected", "selected");
                      $('#oiltype').val(bookingRec.OiltypeID).attr("selected", "selected");
                      $('#booklocation').val(bookingRec.BookingLocation);
                      $('#bookdate').val(bookingRec.BookingDate);
                      $('#booktime').val(bookingRec.BookingTime);
                      $('#usedealcode').val(bookingRec.UsedDeals);
                      $('#totalamt').val(bookingRec.TotalAmount);
                      $('#paystatus').val(bookingRec.PaymentStatus);
                      $('#bookingstatus').val(bookingRec.BookingStatus);
                      $('#save').val('Update User');
                    }
                  }

                });
              }

            }
          }
        });
      }
    });
  });
</script>
