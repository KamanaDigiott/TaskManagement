
$(document).ready(function () {




  $(document).on('click', '.delete-user', function () {
    var id = $(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/users.php',
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


