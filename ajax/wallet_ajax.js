
$(document).ready(function () {
  wallet();

});
function wallet() {
  $("#myTable").ready(function () {
    $('#example').DataTable({
      select: true,
      "bDestroy": true
    });
    $.ajax({
      type: 'GET',
      url: '../../API/wallet.php',
      dataType: "json",
      data: {
        action: 'wallet'
      },
      success: function (result) {
        console.log(result);
        if (result.success) {
          let daftar = result.data;
          var html = '';
          var status = '';
          $.each(daftar, function (i, data) {
            // if (data.BookingStatus == '1') {
              status = `<button data-id=` + data.BookingID + ` class=" btn btn-primary active" type="button">`+data.BookingStatus+`</button>`;
            // }
            // else {
            //   status = `<button data-id=` + data.BookingID + ` class="btn btn-danger active" type="button" >Inactive</button>`;
            // }
            html += `<tr>
                          <td> ` + (i + 1) + `</td>
                          <td>` + data.FullName + `</td>
                          <td>` + data.UserMobileno + `</td>
                          <td>` + data.UserEmail + `</td>
                          <td><a class="btn btn-success" href="view.php?id=`+data.UserID+`"><span class="fas fa-wallet"></span></td>
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
