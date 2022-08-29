
$(document).ready(function () {

  $("#myForm").validate({
    rules: {
      detail: {
        required: true
      },
      adminComments: {
        required: true
      },bookdate: {
        required: true,
      },booktime: {
        required: true,
      }
    },
    messages: {
      detail: 'Please Add detail.',
      adminComments: 'Please Enter Comments.',
      bookdate: 'Please Enter bookdate.',
      booktime: 'Please Enter booktime.',
    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = {
        id: $("#id").val(),
        detail: $("#detail").val(),
        adminComments: $("#adminComments").val(),
        bookdate: $("#bookdate").val(),
        booktime: $("#booktime").val(),
        action: 'save',
      };
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/reported_bug.php',
        dataType: "json",
        data: formData,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#myForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/reportedBug/list.php';
            }, 300);
          }
        },
        error: function (error) {

        }
      });
      return false;
    }
  });

  function all_record() {
var addedBy;
    $("#myTable").ready(function () {
      $('#example').DataTable({
        select: true,
        "bDestroy": true
      });
      $.ajax({
        type: 'GET',
        url: '../../API/reported_bug.php',
        dataType: "json",
        data: {
          action: 'all_bugs'
        },
        success: function (result) {
          console.log(result);
          if (result.success) {
            let daftar = result.data;
            var html = '';
            var status = '';
            $.each(daftar, function (i, data) {
if(data.UserId){
addedBy  = 'By Admin';
}else{
addedBy = 'By Others';
}
              html += `<tr>
                            <td> ` + (i + 1) + `</td>
                            <td> ` + addedBy + `</td>
                            <td>` + data.BugDetails + `</td>
                            <td>` + data.BugStatus + `</td>
                            <td>` + data.AdminComments + `</td>
                            <td>
                            <a href="add.php?id=`+ data.BugID + `" class="btn btn-primary edit">
                             <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="button" class="btn btn-danger delete" data-id="`+ data.BugID + `" >
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
  all_record();
  $(document).on('click', '.delete', function () {
    var id = $(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/reported_bug.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete'
      },
      success: function (result) {
        console.log(result);
        $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        all_record();
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
      url: '../../API/reported_bug.php',
      dataType: "json",
      data: {
        id: id,
        action: 'active'
      },
      success: function (result) {
        console.log(result);
        all_record();
      }
    });
  });
});

