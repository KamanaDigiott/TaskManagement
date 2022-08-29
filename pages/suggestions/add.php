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
            <h1 class="m-0">Suggestion </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"> Suggestion Management</a></li>
              <li class="breadcrumb-item active">Suggestion Bug Type</li>
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
              <a href="#" class="h1"><b>Add a Suggestion</b></a>
            </div>
            <div class="card-body">
              <div class="errorTxt form-group alert-danger"></div>
              <form id="myForm" name="myForm" method="post">
                <div class="input-group mb-3">
                  <input type="text" id="detail" name="detail" class="form-control" placeholder="Enter  Suggestion Details">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <textarea type="text" id="adminComments" name="adminComments" class="form-control" placeholder="Enter Your Comments"></textarea>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="row">

                  <!-- /.col -->
                  <div class="col-4">
                    <input type="submit" id="save" class="btn btn-primary btn-block" value="Add Suggestion" />
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
<script src="../../ajax/suggestions_ajax.js"></script>
<script>
  $(document).ready(function() {
    var id=`<?php echo @$id; ?>`;
    if(id!=''){
    $.ajax({
      type: 'GET',
      url: '../../API/suggestions.php',
      dataType: "json",
      data: {
        id: id,
        action: 'edit'
      },
      success: function(result) {
        if (result.success) {
          console.log(result);
          let resp = result.data;
          $('#myForm').append('<input type="hidden" id="id" name="id" value="'+resp.SuggestionsID+'">')
          $('#detail').val(resp.Suggestions);
          $('#adminComments').val(resp.AdminComments);
          $('#save').val('Update Suggestion');
        }
      }
    });
  }
  });
</script>
