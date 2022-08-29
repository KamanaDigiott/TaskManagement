$(document).ready(function () {
  $.ajax({
    type: "GET",
    url: "../../API/service_person.php",
    dataType: "json",
    data: {
      action: "all_users",
    },
    success: function (result) {
      console.log(result);
      if (result.success) {
        let daftar = result.data;
        $.each(daftar, function (i, data) {
          $("#servicePerson").append(
            '<option value="' +
              data.ServicePersonID +
              '">' +
              data.ServicePersonName +
              "</option>"
          );
        });
      } else {
        $("#alert").append(
          '<div class="alert-danger">' + result.errors + "</div>"
        );
      }
    },
  });
});
function bookedOrder(event) {
alert(event.target.value);
  if (event.target.value == "carwash") {
    $.ajax({
      type: "GET",
      url: "../../API/appointment.php",
      dataType: "json",
      data: {
        action: "appointments",
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = "";
          var status = "";
          $.each(daftar, function (i, data) {
            if (result.success) {
              $("#booking").html(
                `<option value="` +
                  data.BookingID +
                  `" >` +
                  data.AppoinmentID +
                  `</option>`
              );
            } else {
              $("#alert").append(
                '<div class="alert-danger">' + result.errors + "</div>"
              );
            }
          });
        }
      },
    });
  }
  if (event.target.value == "battery") {
    $.ajax({
      type: "GET",
      url: "../../API/battery_booking.php",
      dataType: "json",
      data: {
        action: "battery_booking",
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = "";
          var status = "";
          $.each(daftar, function (i, data) {
            $("#booking").html(
              `<option value="` +
                data.BookingID +
                `" >` +
                data.AppoinmentNo +
                `</option>`
            );
          });
        } else {
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      },
    });
  }
  if (event.target.value == "oil") {
    $.ajax({
      type: "GET",
      url: "../../API/oil_service_booking.php",
      dataType: "json",
      data: {
        action: "all_booking_service",
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = "";
          var status = "";
          $.each(daftar, function (i, data) {
            $("#booking").html(
              `<option value=` +
                data.BookingID +
                `>` +
                data.AppoinmentNo +
                `</option>`
            );
          });
        } else {
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      },
    });
  }
  if (event.target.value == "tyre") {
    $.ajax({
      type: "GET",
      url: "../../API/tyre.php",
      dataType: "json",
      data: {
        action: "tyre",
      },
      success: function (result) {
        alert(result.success);
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = "";
          var status = "";
          $.each(daftar, function (i, data) {
            alert(data.BookingID);
            $("#list-list").html(
              `<option value=` +
                data.BookingID +
                `>` +
                data.AppoinmentNo +
                `</option>`
            );
          });
        } else {
          $("#list-list").html(
            `<option value=``>No Data Found</option>`
          );
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      },
    });
  }
}
$("#save").click(function () {
     alert($("#service").val());
  if ($("#service").val() == "carwash") {
    $.ajax({
      type: "POST",
      url: "../../API/appointment.php",
      dataType: "json",
      data: {
        action: "update_person_id",
        person_id: $("#servicePerson").val(),
        booking_id: $("#booking").val(),
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
            setTimeout(function () {
                window.location.href = '../../pages/pickupBooking/add.php';
              }, 300);
        } else {
        }
      },
    });
  }
  if ($("#service").val() == "battery") {
    $.ajax({
      type: "POST",
      url: "../../API/battery_booking.php",
      dataType: "json",
      data: {
        action: "update_person_id",
        person_id: $("#servicePerson").val(),
        booking_id: $("#booking").val(),
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
        } else {
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      },
    });
  }
  if ($("#service").val() == "oil") {
    $.ajax({
      type: "POST",
      url: "../../API/oil_service_booking.php",
      dataType: "json",
      data: {
        action: "update_person_id",
        person_id: $("#servicePerson").val(),
        booking_id: $("#booking").val(),
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = "";
          var status = "";
          $.each(daftar, function (i, data) {
            $("#booking").html(
              `<option value=` +
                data.BookingID +
                `>` +
                data.AppoinmentNo +
                `</option>`
            );
          });
        } else {
          $("#alert").append(
            '<div class="alert-danger">' + result.errors + "</div>"
          );
        }
      },
    });
  }
  if ($("#service").val() == "tyre") {
    $.ajax({
      type: "POST",
      url: "../../API/tyre.php",
      dataType: "json",
      data: {
        action: "update_person_id",
        person_id: $("#servicePerson").val(),
        booking_id: $("#booking").val(),
      },
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

