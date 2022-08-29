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
          <h1 class="m-0">Tyre Booking</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Tyre Booking</a></li>
            <li class="breadcrumb-item active">Tyre Booking Details</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">


      <div class="hold-transition register-page" style="height: 80vh;">
        <div class="register-box" style="width: 95%;">
          <div class="card card-outline card-primary">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-8">
                  <a href="#" class="h1"><b>Booking Details</b></a>
                  <div class=" mb-3">
                    <h4><b>Appointment ID : <span id="appointment_id"></span></b></h4>
                  </div>
                </div>
                <div class="col-sm-4">
                  <form>
 <input type="hidden" name="user_id" id="user_id">
                    <input type="hidden" name="appointment_id" id="appointment_no">
                    <label for="status">Booking Status : </label>
                    <select id="status" name="status" class="form-control" onchange="update_status(event)">
                      <option value="inprogress">inprogress</option>
                      <option value="pickedup">pickedup</option>
                      <option value="processing">processing</option>
                      <option value="completed">completed</option>
                      <option value="cancelled">cancelled</option>
                    </select>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div id="alert" class="form-group"></div>
              <div class="errorTxt form-group alert-danger"></div>
              <div class="row">
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>User Name :</b></div>
                  <div class="col-sm-6"><span id="user_name"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Vehicle Name :</b></div>
                  <div class="col-sm-6"><span id="vehicle"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Tyre Size :</b></div>
                  <div class="col-sm-6"><span id="tyresize"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Booking Location :</b></div>
                  <div class="col-sm-6"><span id="booklocation"></span></div>
                </div><div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Booking Date :</b></div>
                  <div class="col-sm-6"><span id="bookdate"></span></div>
                </div><div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Booking Time :</b></div>
                  <div class="col-sm-6"><span id="booktime"></span></div>
                </div>

                <!--
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Additional Notes :</b></div>
                  <div class="col-sm-6"><span id="addtnotes"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Manual Address :</b></div>
                  <div class="col-sm-6"><span id="manualadd"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Booking Place :</b></div>
                  <div class="col-sm-6"><span id="bookplace"></span></div>
                </div> -->
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>used deal code :</b></div>
                  <div class="col-sm-6"><span id="usedealcode"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Total Amount :</b></div>
                  <div class="col-sm-6"><span id="totalamt"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Payment Status :</b></div>
                  <div class="col-sm-6"><span id="paystatus"></span></div>
                </div>
              </div>
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
<!-- <script src="../../ajax/appointment_ajax.js"></script> -->
<script>
  $(document).ready(function() {
    // alert();
      var id = `<?php echo @$id; ?>`;
      $.ajax({
        type: 'GET',
        url: '../../API/tyre.php',
        dataType: "json",
        data: {
          id: id,
          action: 'tyre_id'
        },
        success: function(result) {
          if (result.success) {
            let bookingRec = result.data;
          $('#status').val(bookingRec.BookingStatus).attr("selected", "selected");
            $('#user_name').text(bookingRec.FullName);
            $('#appointment_id').text(bookingRec.AppoinmentNo);
            $('#vehicle').text(bookingRec.VehicleName);
            $('#tyresize').html(bookingRec.TyreSize);
            $('#booklocation').html(bookingRec.BookingLocation);
            $('#bookdate').html(bookingRec.BookingDate);
            $('#booktime').html(bookingRec.BookingTime);
            $('#usedealcode').html(bookingRec.UsedDeals);
            $('#totalamt').html(bookingRec.TotalAmount);
            $('#paystatus').html(bookingRec.PaymentStatus);
$('#appointment_no').val(bookingRec.AppoinmentNo);
          $('#user_id').val(bookingRec.UserID);
            $('#save').html('Update Details');
          }
        }
      });
      $('#status').change(function() {
      $.ajax({
        type: 'POST',
        url: '../../API/tyre.php',
        dataType: "json",
        data: {
          id: `<?php echo @$id; ?>`,
          status: $('#status').val(),
appointment_id: $('#appointment_no').val(),
          user_id: $('#user_id').val(),
          action: 'update_status'
        },
        success: function(result) {
          console.log(result);
          if (result.success) {
            alert(result.message);
          } else {
            $("#alert").append(
              '<div class="alert-danger">' + result.errors + "</div>"
            );
          }
        }
      });
    });
  });
</script>
