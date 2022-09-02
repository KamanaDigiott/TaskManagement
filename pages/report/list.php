<?php
include('../../docs/_includes/header.php');




// echo "Latitude:".$new_arr[0]['geoplugin_latitude']." and Longitude:".$new_arr[0]['geoplugin_longitude'];
if (!empty($_GET['status'])) {
  switch ($_GET['status']) {
    case 'succ':
      $statusType = 'alert-success';
      $statusMsg = 'Members data has been imported successfully.';
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
  #importFrm {

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
          <h1 class="m-0">Report </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">User Management</a></li>
            <li class="breadcrumb-item active">User's Reports</li>
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
      <!-- Display status message -->
      <?php if (!empty($statusMsg)) { ?>
        <div class="col-xs-12">
          <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
        </div>
      <?php } ?>
      <div class="row">
        <!-- Import & Export link -->
        <div class="col-md-12 head">
          <div class="float-left pb-4 ">
            <form method="post">
              <div class="input-group">
                <select class="form-control" name="search" id="search">
                  <option value=''>--Select User Status--</option>
                  <option value="loggedIn">Login User</option>
                  <option value="loggedOut">Logout User</option>
                </select>
              </div>
            </form>
          </div>
          <div class="float-right pb-4">
            <!-- <button href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="fas fa-plus"></i> Import</button>
            <a href="../excels/export.php?action=export_user" class="btn btn-primary"><i class="fas fa-download"></i> Export</a> -->
            <!-- <a href="add.php" class="btn btn-info"><i class="fas fa-plus"></i> Add New Task</a> -->
          </div>
        </div>
        <!-- CSV file upload form -->
        <div class="col-md-12" id="importFrm" style="display: none;">
          <form action="../excels/import.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" class="btn btn-primary" name="import_task" value="IMPORT">
          </form>
        </div>
        <!-- end CSV file upload form -->
      </div>

      <div id="myTable">
        <table id="example" cellspacing="0" width="100%" class="table table-striped display nowrap">
          <thead>
            <tr>
              <th>S. No.</th>
              <th>Task Title</th>
              <th>User Name</th>
              <th>Email</th>
              <th>Working Hours</th>
              <th>Salary</th>
              <th>Status</th>
              <th>Location</th>
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
<script>
  $(document).ready(function() {
    var token = "<?php echo $_SESSION['token']; ?>";

    function onload() {
      $.ajax({
        type: 'GET',
        url: 'http://127.0.0.1:8000/API/report.php',
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded",
        headers: {
          "Authorization": `Bearer ${token}`
        },
        data: {
          action: 'select'
        },
        success: function(result, xhr, ajaxOptions) {
          var status = '';
          console.log(result);
          if (result.success) {
            let daftar = result.data;
            var html = '';
            var taskRow = '';
            $.each(daftar, function(i, data) {
              let taskdata = data.tasks;

              if (data.TaskStatus == '1') {
                status = `<button data-id=` + data.id + ` class=" btn btn-success active" type="button">Active</button>`;
              } else {
                status = `<button data-id=` + data.id + ` class="btn btn-danger active" type="button" >Inactive</button>`;
              }

              $.each(data.tasks, function(i, task) {
                console.log(task);
                taskRow += `<p>` + (i + 1 + `. `) + task.TaskTitle + `</p>`
              });

              html += `<tr>
                        <td> ` + (i + 1) + `</td>
                        <td> ` + taskRow + `</td>
                        <td> ` + data.name + `</td>
                        <td>` + data.email + `</td>
                        <td>` + data.hours + ` hrs</td>
                        <td>₹ ` + (data.hours * data.taskRate) + `</td>
                        <td>` + status + `</td>
                        <td>
                        <iframe src="https://maps.google.com/maps?q=` + data.Latitude + `,` + data.Longitude + `&hl=es;z=14&amp;output=embed" width="80%" height="100px" frameborder="0" ></iframe>
                        </div>
                        </td>
                        <td>
                        <a href="add.php?id=` + data.TaskID + `" class="btn btn-primary edit-user">
                         <span class="fas fa-pencil-alt"></span>
                        </a>
                        <button type="button" class="btn btn-danger delete-user" data-id="` + data.TaskID + `" >
                        <span class="fas fa-trash"></span>
                        </button>
                        </td>
                    </tr>`;

              //This is selector of my <tbody> in my table
              $("#list-list").html(html);

            });
          } else {
            $("#alert").append(
              '<div class="alert-danger">' + result + "</div>"
            );
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          console.log(thrownError);
        }
      });
    }
    onload();
    $("#search").change(function() {
      var status = $("#search").val();
      if (status != '') {
        $.ajax({
          type: 'GET',
          url: 'http://127.0.0.1:8000/API/report.php',
          dataType: 'json',
          contentType: "application/x-www-form-urlencoded",
          headers: {
            "Authorization": `Bearer ${token}`
          },
          data: {
            action: 'activeInactiveUser',
            status: status
          },
          success: function(result) {
            var status = '';
            console.log(result);
            if (result.success) {
              let daftar = result.data;
              var html = '';
              var taskRow = 'No Record';
              $.each(daftar, function(i, data) {
                if (data.id != null) {
                  let taskdata = data.tasks;
                  if (data.TaskStatus == '1') {
                    status = `<button data-id=` + data.id + ` class=" btn btn-success active" type="button">Active</button>`;
                  } else {
                    status = `<button data-id=` + data.id + ` class="btn btn-danger active" type="button" >Inactive</button>`;
                  }
                  $.each(data.tasks, function(i, task) {
                    console.log(task);
                    taskRow += `<p>` + (i + 1 + `. `) + task.TaskTitle + `</p>`
                  });
                  html += `<tr>
                        <td> ` + (i + 1) + `</td>
                        <td> ` + taskRow + `</td>
                        <td> ` + data.name + `</td>
                        <td>` + data.email + `</td>
                        <td>` + data.hours + ` hrs</td>
                        <td>₹ ` + (data.hours * data.taskRate) + `</td>
                        <td>` + status + `</td>
                        <td><iframe src="https://maps.google.com/maps?q=` + data.Latitude + `,` + data.Longitude + `&hl=es;z=14&amp;output=embed" width="80%" height="100px" frameborder="0" ></iframe></td>
                        <td></td>
                        <td>
                        <a href="add.php?id=` + data.TaskID + `" class="btn btn-primary edit-user">
                         <span class="fas fa-pencil-alt"></span>
                        </a>
                        <button type="button" class="btn btn-danger delete-user" data-id="` + data.TaskID + `" >
                        <span class="fas fa-trash"></span>
                        </button>
                        </td>
                    </tr>`;

                  //This is selector of my <tbody> in my table
                  $("#list-list").html(html);
                } else {
                  $("#list-list").html(`<tr style="width:100%"><td colspan="8">No Record Found...</td></tr>`);
                }

              });
            } else {
              $("#alert").append(
                '<div class="alert-danger">' + result + "</div>"
              );
            }
          }
        });
      } else {
        onload();
      }
    });
  });
</script>
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
