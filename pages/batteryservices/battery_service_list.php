<?php
include('../../docs/_includes/header.php');
if (!empty($_GET['status'])) {
  switch ($_GET['status']) {
    case 'succ':
      $statusType = 'alert-success';
      $statusMsg = 'Battery Services has been imported successfully.';
      break;
    case 'err':
      $statusType = 'alert-danger';
      $statusMsg = 'Some problem occurred, please try again.';
      break;
    case 'invalid_file':
      $statusType = 'alert-danger';
      $statusMsg = 'Please upload a valid CSV file.';
      break;
    default:
      $statusType = '';
      $statusMsg = '';
  }
}
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
          <h1 class="m-0">Battery Services Record</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Battery Services Management</a></li>
            <li class="breadcrumb-item active">Battery Services Record</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
       <!-- Display status message -->
       <?php if (!empty($statusMsg)) { ?>
        <div class="col-xs-12">
          <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
        </div>
      <?php } ?>
      <div class="row">
        <!-- Import & Export link -->
        <div class="col-md-12 head" >
          <div class="float-right pb-2">
            <button href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="fas fa-plus"></i> Import</button>
            <a href="../excels/export.php?action=export_battery_service" class="btn btn-primary"><i class="fas fa-download"></i> Export</a>
          </div>
        </div>
        <!-- CSV file upload form -->
        <div class="col-md-12" id="importFrm" style="display: none;">
          <form action="../excels/import.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" class="btn btn-primary" name="import_battery_services" value="IMPORT">
          </form>
        </div>
        <!-- end CSV file upload form -->
      </div>

      <div id="myTable">
        <table id="example" cellspacing="0" width="100%" class="table table-striped display nowrap">
          <thead>
            <tr>
              <th>S. No.</th>
              <th>Battery Service Tittle</th>
              <th>Batter Service Price</th>
              <th>Battery Service Description</th>
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
<script src="../../ajax/battery_service_ajax.js"></script>
<!-- <script src="../../ajax/user_ajax.js"></script> -->
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
