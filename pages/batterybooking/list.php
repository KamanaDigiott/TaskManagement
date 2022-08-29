<?php
include('../../docs/_includes/header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">All Bookings</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Battery Serivce Booking</a></li>
            <li class="breadcrumb-item active">All Bookings</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div id="alert"></div>
      <div id="myTable" style="overflow:scroll;">
        <table id="example" cellspacing="0" width="100%"  class="table table-striped display nowrap">
          <thead>
            <tr>
              <th>S. No.</th>
              <th>AppoinmentID</th>
              <th>User</th>
              <th>BookingLocation</th>
              <th>Vehicle</th>
              <th>Service Type</th>
              <th>Booking Date</th>
              <th>Booking Time</th>
              <th>UsedDealCode</th>
              <th>TotalAmount</th>
              <th>PaymentStatus</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="list-list"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
include('../../docs/_includes/footer.php');
?>
<script src="../../ajax/battery_booking_ajax.js"></script>
