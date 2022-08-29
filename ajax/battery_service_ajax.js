$(document).ready(function () {
//code of add battery type by admin
   $("#batteryserviceForm").validate({
    rules: {
      title: {
        required: true
      },
      price: {
        required: true,
      },
      description: {
        required: true,
      },
    },
    messages: {
      title: 'Please enter Battery Service title.',
      price: {
        required: 'Please enter Battery Service price.',
      },
      description: {
        required: 'Please enter Battery Service description.',
      },

    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = {
        id: $("#id").val(),
        title: $("#title").val(),
        price: $("#price").val(),
        description: $("#description").val(),
        action: 'save_battery_service',
      };
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/battery_services.php',
        dataType: "json",
        data: formData,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#batteryserviceForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/batteryservices/battery_service_list.php';
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


  $("#myTable").ready(function () {
    // $('#example').DataTable({
    //   select: true,
    //   "bDestroy": true
    // });
    $.ajax({
      type: 'GET',
      url: '../../API/battery_services.php',
      dataType: "json",
      data: {
        action: 'all_battery_services'
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = '';
          var status = '';
          $.each(daftar, function (i, data) {
                if (data.BatteryServiceStatus == '1') {
                status = `<button data-id=` + data.BatteryServiceID + ` class=" btn btn-success active" type="button">Active</button>`;
              }
              else {
                status = `<button data-id=` + data.BatteryServiceID + ` class="btn btn-danger active" type="button" >Inactive</button>`;
              }
            html += `<tr>
                            <td> ` + (i + 1) + `</td>
                            <td> ` + data.BatteryServiceTitle + `</td>
                            <td>` + data.BatteryServicePrice + `</td>
                            <td>` + data.BatteryServiceDescription + `</td>
                            <td>
                            <a href="add_battery_services.php?id=`+ data.BatteryServiceID + `" class="btn btn-primary edit-user">
                             <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="button" class="btn btn-danger delete-battery-service" data-id="`+ data.BatteryServiceID + `" >
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

  $(document).on('click','.delete-battery-service',function () {
    var id=$(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/battery_services.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete_battery_service'
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
