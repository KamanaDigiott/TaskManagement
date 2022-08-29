
$(document).ready(function () {
  allUser();
});

function allUser(){
  $.ajax({
    type: 'GET',
    url: '../../API/users.php',
    dataType: "json",
    data: {
      action: 'all_users'
    },
    success: function (result) {
      console.log(result);
      if (result.success) {
        let daftar = result.data;
        $('#count_user').html(daftar.length+'+');
      }
      else {
        $("#alert").append(
          '<div class="alert-danger">' + result.errors + "</div>"
        );
      }
    }
  });
}


