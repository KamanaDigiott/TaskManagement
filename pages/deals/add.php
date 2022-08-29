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
            <h1 class="m-0">Deals Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Deals Management</a></li>
              <li class="breadcrumb-item active">Add Deals</li>
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
              <b class="h1">Add a new deal</b>
            </div>
            <div class="card-body">
              <div id="alert" class="form-group"></div>
              <div class="errorTxt form-group alert-danger"></div>
              <form id="myForm" name="myForm" method="post" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <input type="text" id="title" name="title" class="form-control" placeholder="Enter title">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="description" name="description" class="form-control" placeholder="Enter Deals Description">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="number" id="actualPrice" name="actualPrice" class="form-control" placeholder="Enter Actual Price">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="number" id="offerPrice" name="offerPrice" class="form-control" placeholder="Enter Offer Price"></textarea>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-map-marker"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="type" name="type" class="form-control" placeholder="Enter Deals Type"></textarea>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-map-marker"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3" id="file_upload">
                  <input type="file" accept="image/*" id="file" name="file" class="form-control" placeholder="Upload Image">
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
                    <input type="submit" id="save" class="btn btn-primary btn-block" value="Add deals" />
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
<script src="../../ajax/deals_ajax.js"></script>
<script>
  $(document).ready(function() {
    var id=`<?php echo @$id; ?>`;
    if(id!=''){
    $.ajax({
      type: 'GET',
      url: '../../API/deals.php',
      dataType: "json",
      data: {
        id: id,
        action: 'edit'
      },
      success: function(result) {
        if (result.success) {
          console.log(result);
          let dealsRec = result.data;
          $('#myForm').append('<input type="hidden" id="id" name="id" value="'+dealsRec.DealsID+'">')
          $('#title').val(dealsRec.DealsTitle);
          $('#description').val(dealsRec.DealsDescription);
          $('#actualPrice').val(dealsRec.DealsActualPrice);
          $('#offerPrice').val(dealsRec.DealsOfferPrice);
          $('#type').val(dealsRec.DealsType);
          $('#file_upload').css('display','none');
          $('#save').val('Update Deals');
        }
      }
    });
  }
  });
</script>
