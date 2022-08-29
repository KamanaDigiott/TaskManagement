
$(document).ready(function () {

  $("#myForm").validate({
    rules: {
      user: {
        required: true
      },
      name: {
        required: true
      },
      plateno: {
        required: true,
      },
      color: {
        required: true,
      },
      fuletype: {
        required: true,
      },
    },
    messages: {
      user: 'Please Select User.',
      name: 'Please Enter Vehicle Name.',
      plateno: {
        required: 'Please Enter Plate No.',
      },
      color: {
        required: 'Please Enter Color Of Vehicle.',
      },
      fuletype: {
        required: 'Please enter fule type.',
      },

    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = {
        id: $("#id").val(),
        user_id: $("#user").val(),
        name: $("#name").val(),
        plateno: $("#plateno").val(),
        color: $("#color").val(),
        fuletype: $("#fuletype").val(),
        action: 'save',
      };
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/vehicle.php',
        dataType: "json",
        data: formData,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#myForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/vehicle/list.php';
            }, 300);
          }
        },
        error: function (error) {

        }
      });
      return false;
    }
  });
function all_vehicles(){
  $("#myTable").ready(function () {
    $('#example').DataTable({
      select: true,
      "bDestroy": true
    });
    $.ajax({
      type: 'GET',
      url: '../../API/vehicle.php',
      dataType: "json",
      data: {
        action: 'vehicle'
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = '';
          var status = '';
          $.each(daftar, function (i, data) {
            if (data.VehicleStatus == '1') {
              status = `<button data-id=`+data.VehicleID+` class=" btn btn-success active" type="button">Active</button>`;
            }
            else {
              status = `<button data-id=`+data.VehicleID+` class="btn btn-danger active" type="button" >Inactive</button>`;
            }
            html += `<tr>
                            <td> ` + (i + 1) + `</td>
                            <td> ` + data.FullName + `</td>
                            <td>` + data.VehicleName + `</td>
                            <td>` + data.PlateNumber + `</td>
                            <td>` + data.VehicleColor + `</td>
                            <td>` + data.Fuletype + `</td>
                            <td>` + status + `</td>
                            <td>
                            <a href="add.php?id=`+ data.VehicleID + `" class="btn btn-primary edit">
                             <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="button" class="btn btn-danger delete" data-id="`+ data.VehicleID + `" >
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

all_vehicles();
  $(document).on('click', '.delete', function () {
    var id = $(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/vehicle.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete'
      },
      success: function (result) {
        console.log(result);
        $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        all_vehicles();
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
      url: '../../API/vehicle.php',
      dataType: "json",
      data: {
        id: id,
        action: 'active'
      },
      success: function (result) {
        console.log(result);
        // $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        all_vehicles();
      }
    });
  });
});

