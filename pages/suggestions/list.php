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
          <h1 class="m-0">Suggestions Record</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Suggestions   Management</a></li>
            <li class="breadcrumb-item active">Suggestions Record</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div id="myTable">
        <table id="example" cellspacing="0" width="100%" class="table table-striped display nowrap">
          <thead>
            <tr>
              <th>S. No.</th>
              <th> Added By</th>
              <th> Suggestion Details</th>
              <th> Suggestion Status</th>
              <th> Admin Comments</th>
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
<script src="../../ajax/suggestions_ajax.js"></script>
