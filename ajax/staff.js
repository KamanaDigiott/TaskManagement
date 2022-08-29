
$(document).ready(function () {
  staff();



  $("#registrationForm").validate({
    rules: {
      name: {
        required: true
      },
      email: {
        required: true,
        email: true
      },
      mobile: {
        required: true,
        rangelength: [10, 12],
        number: true
      },
      role: {
        required: true,
      },
      gender: {
        required: true,
      },
      dob: {
        required: true,
      },
      marital: {
        required: true,
      },
    },
    messages: {
      name: 'Please enter Name.',
      email: {
        required: 'Please enter Email Address.',
        email: 'Please enter a valid Email Address.',
      },
      mobile: {
        required: 'Please enter Mobile.',
        rangelength: 'Contact should be 10 digit number.'
      },
      role: {
        required: 'Please Select Role.',
      },
      gender: {
        required: 'Please Select Gender.',
      },
      dob: {
        required: 'Please Select Role.',
      },
      marital: {
        required: 'Please Select Marital Status.',
      },
    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = new FormData();
      if ($("#id").val() != undefined) {
        formData.append('id', $("#id").val());
      }
      formData.append('name', $("#name").val());
      formData.append('email', $("#email").val());
      formData.append('mobile', $("#mobile").val());
      formData.append('role', $("#role").val());
      formData.append('gender', $("#gender").val());
      formData.append('dob', $("#dob").val());
      formData.append('marital', $("#marital").val());
      formData.append('action', 'save');
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/staff.php',
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#registrationForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/staffperson/list.php';
            }, 300);
          }
          else {
            $("#alert").append(
              '<div class="alert-danger">' + result.errors.email + "</div>"
            );
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
      url: '../../API/staff.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete'
      },
      success: function (result) {
        console.log(result);
        staff();
        $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        setTimeout(function () {
          $("#alert").html('');
        }, 2000);
      }
    });
  });
});

function staff(){
  $("#myTable").ready(function () {
    $('#example').DataTable({
      select: true,
      "bDestroy": true
    });
    $.ajax({
      type: 'GET',
      url: '../../API/staff.php',
      dataType: "json",
      data: {
        action: 'staff'
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = '';
          $.each(daftar, function (i, data) {
            html += `<tr>
                            <td> ` + (i + 1) + `</td>
                            <td> ` + data.Name + `</td>
                            <td>` + data.Email + `</td>
                            <td>` + data.Phone + `</td>
                            <td>` + data.Role + `</td>
                            <td>` + data.Gender + `</td>
                            <td>` + data.DOB + `</td>
                            <td>` + data.MaritalStatus + `</td>
                            <td>
                            <a href="add.php?id=`+ data.ID + `" class="btn btn-primary edit-user">
                             <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="button" class="btn btn-danger delete" data-id="`+ data.ID + `" >
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


