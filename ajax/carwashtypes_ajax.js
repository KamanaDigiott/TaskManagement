
$(document).ready(function () {

  $("#myForm").validate({
    rules: {
      title: {
        required: true
      },
      description: {
        required: true
      },
      price: {
        required: true,
      },
    },
    messages: {
      title: 'Please Select title.',
      description: 'Please Enter description.',
      price: {
        required: 'Please Enter Actual Price.',
      },

    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = {
        id: $("#id").val(),
        title: $("#title").val(),
        description: $("#description").val(),
        price: $("#price").val(),
        action: 'save',
      };
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/carwashtype.php',
        dataType: "json",
        data: formData,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#myForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/carwashtype/list.php';
            }, 300);
          }
        },
        error: function (error) {

        }
      });
      return false;
    }
  });

  function all_carwash() {
    $("#myTable").ready(function () {
      // $('#example').DataTable({
      //   select: true,
      //   "bDestroy": true
      // });
      $.ajax({
        type: 'GET',
        url: '../../API/carwashtype.php',
        dataType: "json",
        data: {
          action: 'carwashtypes'
        },
        success: function (result) {
          console.log(result);
          if (result.success) {
            let daftar = result.data;
            var html = '';
            var status = '';
            $.each(daftar, function (i, data) {
              if (data.CarwashStatus == '1') {
                status = `<button data-id=` + data.CarwashID + ` class=" btn btn-success active" type="button">Active</button>`;
              }
              else {
                status = `<button data-id=` + data.CarwashID + ` class="btn btn-danger active" type="button" >Inactive</button>`;
              }
              html += `<tr>
                            <td> ` + (i + 1) + `</td>
                            <td> ` + data.CarwashTitle + `</td>
                            <td>` + data.CarwashDescription + `</td>
                            <td>` + data.CarwashPrice + `</td>
                            <td>` + status + `</td>
                            <td>
                            <a href="add.php?id=`+ data.CarwashID + `" class="btn btn-primary edit">
                             <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="button" class="btn btn-danger delete" data-id="`+ data.CarwashID + `" >
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
  all_carwash();
  $(document).on('click', '.delete', function () {
    var id = $(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/carwashtype.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete'
      },
      success: function (result) {
        console.log(result);
        $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        all_carwash();
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
      url: '../../API/carwashtype.php',
      dataType: "json",
      data: {
        id: id,
        action: 'active'
      },
      success: function (result) {
        console.log(result);
        all_carwash();
      }
    });
  });
});

