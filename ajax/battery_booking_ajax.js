
$(document).ready(function () {
    all_user();
    all_bookings();
    batteryType();
    batteryservice();


    $("#myForm").validate({
        rules: {
            user: {
                required: true
            }, booklocation: {
                required: true
            }, vehicle: {
                required: true,
            }, service: {
                required: true,
            }, bookdate: {
                required: true,
            }, booktime: {
                required: true,
            }, usedealcode: {
                required: true,
            }, totalamt: {
                required: true,
            }, paystatus: {
                required: true,
            },
        },
        messages: {
            user: 'Please Select User.',
            booklocation: 'Please Enter booking location.',
            vehicle: 'Please select vehicle.',
            service: 'Please select service.',
            bookdate: 'Please Enter booking date.',
            booktime: 'Please Enter booking time.',
            usedealcode: 'Please Enter dealcode.',
            totalamt: 'Please Enter total amount.',
            paystatus: 'Please Enter payment status.',
        },
        errorElement: 'div',
        errorLabelContainer: '.errorTxt',
        submitHandler: function (form, e) {
            e.preventDefault();
            var formData = {
                id: $("#id").val(),
                user: $("#user").val(),
                booklocation: $("#booklocation").val(),
                vehicle: $("#vehicle").val(),
                type: $("#type").val(),
                service: $("#service").val(),
                bookdate: $("#bookdate").val(),
                booktime: $("#booktime").val(),
                usedealcode: $("#usedealcode").val(),
                totalamt: $("#totalamt").val(),
                paystatus: $("#paystatus").val(),
                action: 'save',
            };
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '../../API/battery_booking.php',
                dataType: "json",
                data: formData,
                success: function (result) {
                    console.log(result);
                    if (result.success) {
                        $("#myForm").html(
                            '<div class="alert alert-success">' + result.message + "</div>"
                        );
                        setTimeout(function () {
                            window.location.href = '../../pages/batterybooking/list.php';
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
            url: '../../API/battery_booking.php',
            dataType: "json",
            data: {
                id: id,
                action: 'delete'
            },
            success: function (result) {
                console.log(result);
                $("#alert").append('<div class="alert-success">' + result.message + "</div>");
                all_bookings();
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
            url: '../../API/battery_booking.php',
            dataType: "json",
            data: {
                id: id,
                action: 'active'
            },
            success: function (result) {
                console.log(result);
                all_bookings();
            }
        });
    });
});

function all_user() {
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
                    //This is selector of my <tbody> in my table
                    $("#myForm #user").append(`<option value="` + data.UserID + `">` + data.FullName + `</option>`);
                });
            }
            else {
                // console.log(result.errors.error);
                $("#alert").append(
                    '<div class="alert-danger">' + result.errors + "</div>"
                );
            }
        }
    });
}

function myFunction(event) {
    var user_id = event.target.value;
    $.ajax({
        type: 'GET',
        url: '../../API/vehicle.php',
        dataType: "json",
        data: {
            id: user_id,
            action: 'vehicle_by_UserID'
        },
        success: function (result) {
            console.log(result);
            if (result.success) {
                let daftar = result.data;
                var html = '';
                $.each(daftar, function (i, data) {
                    //This is selector of my <tbody> in my table
                    $("#myForm #vehicle").append(`<option value="` + data.VehicleID + `" >` + data.VehicleName + `</option>`);
                });
            }
            else {
                $("#alert").append(
                    '<div class="alert-danger">' + result.errors.error + "</div>"
                );
                setTimeout(function () {
                    $("#alert").html('');
                }, 2000);
            }
        }
    });
}

function batteryType(event) {
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
                    //This is selector of my <tbody> in my table
                    $("#myForm #type").append(`<option value="` + data.BatterytypeID + `" >` + data.BatteryType + `</option>`);
                });
            }
            else {
                $("#alert").append(
                    '<div class="alert-danger">' + result.errors.error + "</div>"
                );
                setTimeout(function () {
                    $("#alert").html('');
                }, 2000);
            }
        }
    });
}


function batteryservice() {
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
                $.each(daftar, function (i, data) {
                    //This is selector of my <tbody> in my table
                    $("#myForm #service").append(`<option value="` + data.BatteryServiceID + `" >` + data.BatteryServiceTitle + `</option>`);
                });
            }
            else {
                $("#alert").append(
                    '<div class="alert-danger">' + result.errors + "</div>"
                );
            }
        }
    });
}

function all_bookings() {
    $("#myTable").ready(function () {
        $('#example').DataTable({
            select: true,
            "bDestroy": true
        });
        $.ajax({
            type: 'GET',
            url: '../../API/battery_booking.php',
            dataType: "json",
            data: {
              action: 'battery_booking'
            },
            success: function (result) {
              console.log(result);
              if (result.success) {
                let daftar = result.data;
                var html = '';
                var status = '';
                $.each(daftar, function (i, data) {
                    status = `<button data-id=` + data.BookingID + ` class=" btn btn-primary active" type="button">`+data.BookingStatus+`</button>`;
                  html += `<tr>
                                <td> ` + (i + 1) + `</td>
                                <td> ` + data.AppoinmentNo + `</td>
                                <td>` + data.FullName + `</td>
                                <td>` + data.BookingLocation + `</td>
                                <td>` + data.VehicleName + `</td>
                                <td>` + data.BatteryServiceTitle + `</td>
                                <td>` + data.BookingDate + `</td>
                                <td>` + data.BookingTime + `</td>
                                <td>` + data.UsedDeals + `</td>
                                <td>` + data.TotalAmount + `</td>
                                <td>` + data.PaymentStatus + `</td>
                                <td>` + status + `</td>
                                <td>
                                <a href="view.php?id=`+ data.BookingID + `" class="btn btn-primary edit">
                                 <span class="fas fa-eye"></span>
                                </a>
                                <a href="add.php?id=`+ data.BookingID + `" class="btn btn-primary edit">
                                 <span class="fas fa-pencil-alt"></span>
                                </a>
                                <button type="button" class="btn btn-danger delete" data-id="`+ data.BookingID + `" >
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
