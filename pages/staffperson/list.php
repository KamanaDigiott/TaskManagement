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
          <h1 class="m-0">Staff Record</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Serive Management</a></li>
            <li class="breadcrumb-item active">Staff Record</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <a href="add.php" class="btn btn-info" style="float: right;"><i class="fas fa-plus"></i>&nbsp; Add New Staff</a>
      <div id="myTable">
        <table id="example" cellspacing="0" width="100%" class="table table-striped display nowrap">
          <thead>
            <tr>
              <th>S. No.</th>
              <th> Name</th>
              <th> Email</th>
              <th> Mobile</th>
              <th>Role</th>
              <th>Gender</th>
              <th>Date Of Birth</th>
              <th>Marital Status</th>
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
<script src="../../ajax/staff.js"></script>
