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
          <h1 class="m-0">Garage Booking Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Garage Booking Appointment</a></li>
            <li class="breadcrumb-item active">Garage Booking Details</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">


      <div class="hold-transition register-page" style="height: auto; padding: 15px;">

        <div class="register-box" style="width: 95%;">
          <div class="card card-outline card-primary">
            <div class="card-header ">
              <div class="row">
                <div class="col-sm-8">
                  <a href="#" class="h1"><b>Garage booking Details</b></a>
                  <div class=" mb-3">
                    <h4><b>Appointment ID : <span id="appointment_id"></span></b></h4>
                  </div>
                </div>
                <div class="col-sm-4">
                  <form>
                    <input type="hidden" name="user_id" id="user_id">
                    <input type="hidden" name="appointment_id" id="appointment_no">
                    <label for="status">Vehicle Status : </label>
                    <select id="status" name="status" class="form-control" onchange="update_status(event)">
                      <option value="ingarage">in garage</option>
                      <option value="delivered">delivered</option>
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
                  <div class="col-sm-6"><b>Booking Timing :</b></div>
                  <div class="col-sm-6"><span id="booktime"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Insurance Details :</b></div>
                  <div class="col-sm-6"><span id="parktype"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Carregistration card :</b></div>
                  <div class="col-sm-6"><span id="addtnotes"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>EmiratesID :</b></div>
                  <div class="col-sm-6"><span id="manualadd"></span></div>
                </div>

                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>InsuranceClaim :</b></div>
                  <div class="col-sm-6"><span id="usedealcode"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>PoliceReport :</b></div>
                  <div class="col-sm-6"><span id="totalamt"></span></div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>customerConfirmation :</b></div>
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
<!-- <script src="../../ajax/garagebooking_ajax.js"></script> -->
<script>
  $(document).ready(function() {
    // alert();
    var id = `<?php echo @$id; ?>`;
    $.ajax({
      type: 'GET',
      url: '../../API/garageservicebooking.php',
      dataType: "json",
      data: {
        id: id,
        action: 'appointment_id'
      },
      success: function(result) {
        if (result.success) {
          let bookingRec = result.data;
          $('#user_name').text(bookingRec.FullName);
          $('#appointment_id').text(bookingRec.AppoinmentID);
          $('#status').val(bookingRec.VechileStatus).attr("selected", "selected");
          $('#booktime').html(bookingRec.BookingTiming);
          $('#parktype').html(bookingRec.InsuranceDetails);
          $('#addtnotes').html(bookingRec.Carregistrationcard);
          $('#manualadd').html(bookingRec.EmiratesID);
          $('#usedealcode').html(bookingRec.InsuranceClaim);
          $('#totalamt').html(bookingRec.PoliceReport);
          $('#paystatus').html(bookingRec.customerConfirmation);
 $('#appointment_no').val(bookingRec.AppoinmentID);
          $('#user_id').val(bookingRec.UserID);
          $('#save').html('Update Booking');
        }
      }
    });

    $('#status').change(function() {
      //alert($('#status').val());
      $.ajax({
        type: 'POST',
        url: '../../API/garageservicebooking.php',
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
