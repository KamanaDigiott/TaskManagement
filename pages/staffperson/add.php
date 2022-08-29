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
            <h1 class="m-0">Staff  Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Staff  Management</a></li>
              <li class="breadcrumb-item active">Add Staff </li>
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
              <a href="#" class="h1"><b>Add a new Staff </b></a>
            </div>
            <div class="card-body">

              <div class="errorTxt form-group alert-danger"></div>
              <form id="registrationForm" name="registrationForm" method="post">
                <div class="row">
                <div class="input-group mb-3 col-sm-6">
                    <select id="role" name="role" class="form-control">
                      <option value="">Select role</option>
                      <option value="Administration">Administration</option>
                      <option value="Marketing">Marketing</option>
                      <option value="Partners">Partners</option>
                      <option value="ServiceProviders">service providers </option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-tools"></span>
                      </div>
                    </div>
                  </div>
                <div class="input-group mb-3 col-sm-6">
                  <input type="text" id="name" name="name" class="form-control" placeholder="Full name">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3 col-sm-6" >
                  <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <input type="number" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <!-- <input type="number" id="mobile" name="gender" class="form-control" placeholder="Enter Mobile"> -->
                  <select id="gender" name="gender" class="form-control">
                      <option value="">Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <input type="date" id="dob" name="dob" class="form-control" placeholder="Enter dob">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3 col-sm-6">
                  <input type="text" id="marital" name="marital" class="form-control" placeholder="Enter marital">

                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
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
                    <input type="submit" id="save" class="btn btn-primary btn-block" value="Add Staff" />
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
<script src="../../ajax/staff.js"></script>
<script>
  $(document).ready(function() {
    var id=`<?php echo $id; ?>`;
    if(id!=''){
    $.ajax({
      type: 'GET',
      url: '../../API/staff.php',
      dataType: "json",
      data: {
        id: id,
        action: 'edit'
      },
      success: function(result) {
        if (result.success) {
          console.log(result);
          let userRec = result.data;
          $('#registrationForm').append('<input type="hidden" id="id" name="id" value="'+userRec.ID+'">')
          $('#name').val(userRec.Name);
          $('#email').val(userRec.Email);
          $('#mobile').val(userRec.Phone);
          $('#dob').val(userRec.DOB);
          $('#marital').val(userRec.MaritalStatus);
          $('#role').val(userRec.Role).attr('selected','selected');
          $('#gender').val(userRec.Gender).attr('selected','selected');
          $('#save').val('Update Staff');
        }
      }
    });
  }
  });
</script>
