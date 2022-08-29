
$(document).ready(function () {
  all_notification();
  get3();

  $.ajax({
    type: 'GET',
    url: '../../API/users.php',
    dataType: "json",
    data: {
      action: 'all_users'
    },
    success: function (result) {
      // console.log(result);
      if (result.success) {
        let daftar = result.data;
        var html = '';
        $.each(daftar, function (i, data) {
          $("#myForm #user").append(`<option value="` + data.UserID + `">` + data.FullName + `</option>`);
        });
      }
      else {
        $("#alert").append(
          '<div class="alert-danger">' + result.errors + "</div>"
        );
      }
    }
  });

  $("#myForm").validate({
    rules: {
      user: {
        required: true
      },detail: {
        required: true,
      },description: {
        required: true,
      },
    },
    messages: {
      user: 'Please Select User.',
      detail: 'Please Enter Notification Title.',
      description: 'Please Enter payment Description.',
    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = {
        id: $("#id").val(),
        user: $("#user").val(),
        detail: $("#detail").val(),
        description: $("#description").val(),
        action: 'save',
      };
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/notification.php',
        dataType: "json",
        data: formData,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#myForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/notification/list.php';
            }, 300);
          }
        },
        error: function (error) {

        }
      });
      return false;
    }
  });

  $(document).on('click', '.delete', function () {
    var id = $(this).attr('data-id');

    $.ajax({
      type: 'GET',
      url: '../../API/notification.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete'
      },
      success: function (result) {
        console.log(result);
        $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        all_notification();
        setTimeout(function () {
          $("#alert").html('');
        }, 1500);
      }
    });
  });

  $(document).on('click', '.active', function () {
    var id = $(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/notification.php',
      dataType: "json",
      data: {
        id: id,
        action: 'active'
      },
      success: function (result) {
        console.log(result);
        all_notification();
      }
    });
  });
});

function all_notification() {
  $("#myTable").ready(function () {
    $('#example').DataTable({
      select: true,
      "bDestroy": true
    });
    $.ajax({
      type: 'GET',
      url: '../../API/notification.php',
      dataType: "json",
      data: {
        action: 'all_notification'
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = '';
          var status = '';
          $.each(daftar, function (i, data) {
             if (data.user_id == 'all') {
              user = 'For All Users';
            }
            else {
              user = ``+ data.FullName+ ``;
            }
            if (data.NotificationStatus == '1') {
              status = `<button data-id=` + data.NotificationID + ` class=" btn btn-success active" type="button">Active</button>`;            }
            else {
              status = `<button data-id=` + data.NotificationID + ` class="btn btn-danger active" type="button" >Inactive</button>`;
            }
            html += `<tr>
                          <td> ` + (i + 1) + `</td>
                          <td> ` + user + `</td>
                          <td>` + data.NotificationTitle + `</td>
                          <td>` + data.NotificationDescription + `</td>
                          <td>` + status + `</td>
                          <td>
                          <a href="view.php?id=`+ data.NotificationID + `" class="btn btn-primary edit">
                           <span class="fas fa-eye"></span>
                          </a>
                          <a href="add.php?id=`+ data.NotificationID + `" class="btn btn-primary edit">
                           <span class="fas fa-pencil-alt"></span>
                          </a>
                          <button type="button" class="btn btn-danger delete" data-id="`+ data.NotificationID + `" >
                          <span class="fas fa-trash"></span>
                          </button>
                          </td>
                      </tr>`;

            //This is selector of my <tbody> in my table
            $("#list-list").html(html);
          });
        }
        else {
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      }
    });
  });
}

function get3() {
    $.ajax({
      type: 'GET',
      url: '../../API/notification.php',
      dataType: "json",
      data: {
        action: 'notification_get3'
      },
      success: function (result) {
        if (result.success) {
        $.each(result.data, function (i, data) {
         console.log(data);
        $('#notification').append(`
        <a href="#" class="dropdown-item">
        <div class="media">
        <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
        <div class="media-body">
        <h3 class="dropdown-item-title">`+data.FullName+`<span class="float-right text-sm text-danger">
        <i class="fas fa-star"></i></span>
        </h3><p class="text-sm">`+data.NotificationDescription+`</p>
        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> `+data.CreatedOn+`</p>
        </div>
        </div>
        </a>
        <div class="dropdown-divider"></div>
        `);
        });
        $('#notification').append(`<a href="../../pages/notification/list.php" class="dropdown-item dropdown-footer">See All Messages</a>`);


        }
        else {
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      }
    });
  }
