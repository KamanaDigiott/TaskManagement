$(document).ready(function () {
  all_record();
  //code of add battery type by admin
     $("#batterytypeForm").validate({
      rules: {
        type: {
          required: true
        },
        car_model: {
          required: true,
        },
        weight: {
          required: true,
        },
      },
      messages: {
        type: 'Please enter Car Service Type.',
        car_model: {
          required: 'Please enter Price.',
        },
        weight: {
          required: 'Please enter Car Service.',
        },

      },
      errorElement: 'div',
      errorLabelContainer: '.errorTxt',
      submitHandler: function (form, e) {
        e.preventDefault();
        var formData = {
          id: $("#id").val(),
          type: $("#type").val(),
          car_model: $("#car_model").val(),
          weight: $("#weight").val(),
          action: 'save_car_service_type',
        };
        console.log(formData);
        $.ajax({
          type: 'POST',
          url: '../../API/car_service_type.php',
          dataType: "json",
          data: formData,
          success: function (result) {
            console.log(result);
            if (result.success) {
              $("#batterytypeForm").html(
                '<div class="alert alert-success">' + result.message + "</div>"
              );
              // all_record();
              // setTimeout(function () {
              //   window.location.href = '../../pages/carservicetype/list.php';
              // }, 300);
            }
            else {
              $("#batteryserviceForm").append(
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

    function all_record() {
    $("#myTable").ready(function () {
      // $('#example').DataTable({
      //   select: true,
      //   "bDestroy": true
      // });
      $.ajax({
        type: 'GET',
        url: '../../API/car_service_type.php',
        dataType: "json",
        data: {
          action: 'car_service_type'
        },
        success: function (result) {
          console.log(result);
          if (result.success) {
            let daftar = result.data;
            var html = '';
            $.each(daftar, function (i, data) {
              html += `<tr>
                              <td> ` + (i + 1) + `</td>
                              <td> ` + data.CarServiceType + `</td>
                              <td>` + data.CarServiceTypePrice + `</td>
                              <td>` + data.CarServiceTypeDescription + `</td>
                              <td>
                              <a href="add.php?id=`+ data.CarServiceTypeID + `" class="btn btn-primary edit-user">
                               <span class="fas fa-pencil-alt"></span>
                              </a>
                              <button type="button" class="btn btn-danger delete-battery-type" data-id="`+ data.CarServiceTypeID + `" >
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
    $(document).on('click','.delete-battery-type',function () {
      var id=$(this).attr('data-id');
      $.ajax({
        type: 'GET',
        url: '../../API/car_service_type.php',
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
          }, 2000);
        }
        });
    });
  });
