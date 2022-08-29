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
          <h1 class="m-0">Notification Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Notification </a></li>
            <li class="breadcrumb-item active">Notification Details</li>
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
            <div class="card-header text-center">
              <b class="h1">Notification Details</b>
              <div class=" mb-3">
                  <h4 ><b>Notification ID : <span id="not_id"></span></b></h4>
              </div>
            </div>
            <div class="card-body">
              <div id="alert" class="form-group"></div>
              <div class="errorTxt form-group alert-danger"></div>
              <div class="row">
                <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>For :</b></div>
                  <div class="col-sm-6"><span id="user_name"></span></div>
                </div>
               <div class="input-group mb-3 col-sm-6">
                  <div class="col-sm-6"><b>Notification Title :</b></div>
                  <div class="col-sm-6"><span id="title"></span></div>
                  
                  </div>
                 
                </div>
                <div class="row">
                  <div class="col-sm-4"><b>Notification Description :</b></div>
                  <div class="col-sm-8"><span id="desc"></span></div>

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
    var user_name;
      var id = `<?php echo @$id; ?>`;
      $.ajax({
        type: 'GET',
        url: '../../API/notification.php',
        dataType: "json",
        data: {
          id: id,
          action: 'notification_id'
        },
        success: function(result) {
          if (result.success) {
            let resp = result.data;
            console.log(result.data);
            if(resp.user_id=='all'){
              user_name='For All Users';
            }else{
              user_name=resp.FullName;
            }
            $('#not_id').html(resp.NotificationID);
            $('#user_name').text(user_name);
            $('#title').html(resp.NotificationTitle);
            $('#desc').html(resp.NotificationDescription);
            $('#save').html('Update Notification');
          }
        }
      });
  });
</script>
