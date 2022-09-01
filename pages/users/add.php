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
              <b class="h1">Add a new member</b>
            </div>
            <div class="card-body">
              <div id="alert" class="form-group"></div>
              <div class="errorTxt form-group alert-danger"></div>
              <form id="registrationForm" name="registrationForm" method="post" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <input type="text" id="name" name="name" class="form-control" placeholder="Full name">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <!-- <div class="input-group mb-3">
                  <input type="number" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div> -->

                <div class="input-group mb-3">
                  <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
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
                  <div class="col-2">
                    <a href="list.php" class="btn btn-dark btn-block">Cancel</a>
                  </div>
                  <div class="col-2">
                    <input type="submit" id="save-user" class="btn btn-primary btn-block" value="Add User" />
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
  $(document).ready(function() {

    $("#registrationForm").validate({
      rules: {
        name: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        password: {
          required: true,
          rangelength: [8, 16]
        },
      },
      messages: {
        name: 'Please enter Name.',
        email: {
          required: 'Please enter Email Address.',
          email: 'Please enter a valid Email Address.',
        },
        password: {
          required: 'Please enter Mobile.',
          rangelength: 'Contact should be 10 digit number.'
        }
      },
      errorElement: 'div',
      errorLabelContainer: '.errorTxt',
      submitHandler: function(form, e) {
        e.preventDefault();
        var formData = {
          id: $("#id").val(),
          name: $("#name").val(),
          email: $("#email").val(),
          password: $("#password").val(),
          action: 'insert',
        };
        console.log(formData);
        $.ajax({
          type: 'POST',
          url: 'http://127.0.0.1:8000/API/users.php',
          dataType: "json",
          headers: {
            "Authorization": `Bearer ${token}`
          },
          data: JSON.stringify(formData),
          processData: false,
          contentType: false,
          success: function(result) {
            console.log(result);
            if (result.success) {
              $("#registrationForm").html(
                '<div class="alert alert-success">' + result.message + "</div>"
              );
              setTimeout(function() {
                window.location.href = '../../pages/users/list.php';
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

    // var id = '<?php echo $id; ?>';
    // if (id != '') {
    //   $.ajax({
    //     type: 'GET',
    //     url: '../../API/users.php',
    //     dataType: "json",
    //     data: {
    //       id: id,
    //       action: 'edit_user'
    //     },
    //     success: function(result) {
    //       if (result.success) {
    //         console.log(result);
    //         let userRec = result.data;
    //         $('#registrationForm').append('<input type="hidden" id="id" name="id" value="' + userRec.UserID + '">')
    //         $('#name').val(userRec.FullName);
    //         $('#email').val(userRec.UserEmail);
    //         $('#mobile').val(userRec.UserMobileno);
    //         $('#address').val(userRec.UserAddress);
    //         $('#file_upload').css('display', 'none');
    //         $('#save-user').val('Update User');
    //       }
    //     }
    //   });
    // }
  });
</script>
