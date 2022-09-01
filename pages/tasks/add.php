<?php
include('../../docs/_includes/header.php');
$id = @$_REQUEST['id'];

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">User Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">User Management</a></li>
            <li class="breadcrumb-item active">Add User</li>
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
              <b class="h1" id="form_title">Add New Task</b>
            </div>
            <div class="card-body">
              <div id="alert" class="form-group"></div>
              <div class="errorTxt form-group alert-danger"></div>
              <form id="registrationForm" name="registrationForm" method="post" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <input type="text" id="taskID" name="taskID" class="form-control" placeholder="Enter taskID">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="taskTitle" name="taskTitle" class="form-control" placeholder="taskTitle">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" id="taskDesc" name="taskDesc" class="form-control" placeholder="Enter taskDesc">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3" id="file_upload">
                  <input type="file" id="file" name="file" class="form-control" placeholder="Enter file">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
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
                  <div class="col-2">
                    <a href="list.php" class="btn btn-dark btn-block">Cancel</a>
                  </div>
                  <div class="col-2">
                    <input type="submit" id="save-user" class="btn btn-primary btn-block" value="Add Task" />
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
<script>
  var token = "<?php echo $_SESSION['token']; ?>";
  var id = '<?php echo $id; ?>';
  $(document).ready(function() {


    if (id != '') {
      $.ajax({
        type: 'GET',
        url: 'http://127.0.0.1:8000/API/task.php',
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded",
        headers: {
          "Authorization": `Bearer ${token}`
        },
        data: {
          action: 'select_id',
          taskID: id
        },
        success: function(result) {
          if (result.success) {
            console.log(result);
            let taskRec = result.data;
            // $('#registrationForm').append('<input type="hidden" id="id" name="id" value="' + taskRec.TaskID + '">')
            $('#taskID').val(taskRec.TaskID).attr('disabled', true);
            $('#taskTitle').val(taskRec.TaskTitle);
            $('#taskDesc').val(taskRec.TaskDescription);
            $('#form_title').html('Update Task');
            $('#file_upload').css('display', 'none');
            $('#save-user').val('Save');
          }
        }
      });
    }

    $("#registrationForm").validate({
      rules: {
        taskID: {
          required: true
        },
        taskTitle: {
          required: true
        },
        taskDesc: {
          required: true,
        },
        file: {
          required: true
        }
      },
      messages: {
        taskID: 'Please enter taskTitle.',
        taskTitle: {
          required: 'Please enter taskTitle.',
        },
        taskDesc: {
          required: 'Please enter taskDesc.',
        },
        file: {
          required: 'Please choose file.',
        }
      },
      errorElement: 'div',
      errorLabelContainer: '.errorTxt',
      submitHandler: function(form, e) {
        e.preventDefault();
        var formData = {
          taskID: $("#taskID").val(),
          taskTitle: $("#taskTitle").val(),
          taskDesc: $("#taskDesc").val(),
          taskRate: $("#taskRate").val(),
          action: 'insert',
        };
        // console.log(formData);
        $.ajax({
          type: 'POST',
          url: 'http://127.0.0.1:8000/API/task.php',
          dataType: "json",
          headers: {
            "Authorization": `Bearer ${token}`
          },
          data: JSON.stringify(formData),
          processData: false,
          contentType: false,
          success: function(result) {
            console.log(result);
            if (result.token) {
              $("#registrationForm").html(
                '<div class="alert alert-success">' + result.message + "</div>"
              );
              setTimeout(function() {
                window.location.href = '../../pages/task/list.php';
              }, 300);
            } else {
              $("#alert").append(
                '<div class="alert-danger">' + result.errors.email + "</div>"
              );
            }

          },
          error: function(error) {

          }
        });
        return false;
      }
    });
  });
</script>
