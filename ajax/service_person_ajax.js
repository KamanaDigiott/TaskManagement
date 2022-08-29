
$(document).ready(function () {


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
      charge: {
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
      charge: {
        required: 'Please enter Charge of Service Person.',
      },

    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = {
        id: $("#id").val(),
        name: $("#name").val(),
        email: $("#email").val(),
        mobile: $("#mobile").val(),
        charge: $("#charge").val(),
        action: 'save_user',
      };
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/service_person.php',
        dataType: "json",
        data: formData,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#registrationForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/service_person/list.php';
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

  $("#myTable").ready(function () {
    $('#example').DataTable({
      select: true
    });
    $.ajax({
      type: 'GET',
      url: '../../API/service_person.php',
      dataType: "json",
      data: {
        action: 'all_users'
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = '';
          $.each(daftar, function (i, data) {
            html += `<tr>
                            <td> ` + (i + 1) + `</td>
                            <td> ` + data.ServicePersonName + `</td>
                            <td>` + data.ServicePersonEmail + `</td>
                            <td>` + data.ServicePersonMobile + `</td>
                            <td>` + data.ServiceCharge + `</td>
                            <td>
                            <a href="add.php?id=`+ data.ServicePersonID + `" class="btn btn-primary edit-user">
                             <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="button" class="btn btn-danger delete-user" data-id="`+ data.ServicePersonID + `" >
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

  $(document).on('click','.delete-user',function () {
    var id=$(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/service_person.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete_user'
      },
      success: function (result) {
        console.log(result);
        $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        setTimeout(function () {
          $("#alert").html('');
        }, 2000);
      }
      });
  });
});

