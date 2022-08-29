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
          type: 'Please enter Battery Type.',
          car_model: {
            required: 'Please enter Car Model.',
          },
          weight: {
            required: 'Please enter Battery weight.',
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
            action: 'save_battery_type',
          };
          console.log(formData);
          $.ajax({
            type: 'POST',
            url: '../../API/battery_type.php',
            dataType: "json",
            data: formData,
            success: function (result) {
              console.log(result);
              if (result.success) {
                $("#batterytypeForm").html(
                  '<div class="alert alert-success">' + result.message + "</div>"
                );
                all_record();
                setTimeout(function () {
                  window.location.href = '../../pages/batterytypes/battery_type_list.php';
                }, 300);
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
          url: '../../API/battery_type.php',
          dataType: "json",
          data: {
            action: 'all_battery_type'
          },
          success: function (result) {
            console.log(result);
            if (result.success) {
              let daftar = result.data;
              var html = '';
              $.each(daftar, function (i, data) {
                html += `<tr>
                                <td> ` + (i + 1) + `</td>
                                <td> ` + data.BatteryType + `</td>
                                <td>` + data.CarModel + `</td>
                                <td>` + data.BatteryWeight + `</td>
                                <td>
                                <a href="add_battery_types.php?id=`+ data.BatterytypeID + `" class="btn btn-primary edit-user">
                                 <span class="fas fa-pencil-alt"></span>
                                </a>
                                <button type="button" class="btn btn-danger delete-battery-type" data-id="`+ data.BatterytypeID + `" >
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
          url: '../../API/battery_type.php',
          dataType: "json",
          data: {
            id: id,
            action: 'delete_battery_type'
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
