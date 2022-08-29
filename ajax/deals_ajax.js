
$(document).ready(function () {

  $("#myForm").validate({
    rules: {
      title: {
        required: true
      },
      description: {
        required: true
      },
      actualPrice: {
        required: true,
      },
      offerPrice: {
        required: true,
      },
      type: {
        required: true,
      }, file: {
        required: true,
      },
    },
    messages: {
      title: 'Please Select title.',
      description: 'Please Enter description.',
      actualPrice: {
        required: 'Please Enter Actual Price.',
      },
      offerPrice: {
        required: 'Please Enter Offer Price.',
      },
      type: {
        required: 'Please enter type.',
      }, file: {
        required: 'Please Select file.',
      },

    },
    errorElement: 'div',
    errorLabelContainer: '.errorTxt',
    submitHandler: function (form, e) {
      e.preventDefault();
      var formData = new FormData();
      var file_data = $('#file').prop('files')[0];
      if($("#id").val()!=undefined){
      formData.append('id', $("#id").val());
    }
    formData.append('title', $("#title").val());
    formData.append('description', $("#description").val());
    formData.append('actualPrice', $("#actualPrice").val());
    formData.append('offerPrice', $("#offerPrice").val());
    formData.append('type', $("#type").val());
    formData.append('action', 'save');
    formData.append('file', file_data);
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: '../../API/deals.php',
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
          console.log(result);
          if (result.success) {
            $("#myForm").html(
              '<div class="alert alert-success">' + result.message + "</div>"
            );
            setTimeout(function () {
              window.location.href = '../../pages/deals/list.php';
            }, 300);
          }
        },
        error: function (error) {

        }
      });
      return false;
    }
  });

  function all_deals() {
    $("#myTable").ready(function () {
      $('#example').DataTable({
        select: true,
        "bDestroy": true
      });
      $.ajax({
        type: 'GET',
        url: '../../API/deals.php',
        dataType: "json",
        data: {
          action: 'deals'
        },
        success: function (result) {
          console.log(result);
          if (result.success) {
            let daftar = result.data;
            var html = '';
            var status = '';
            $.each(daftar, function (i, data) {
              if (data.DealsStatus == '1') {
                status = `<button data-id=` + data.DealsID + ` class=" btn btn-success active" type="button">Active</button>`;
              }
              else {
                status = `<button data-id=` + data.DealsID + ` class="btn btn-danger active" type="button" >Inactive</button>`;
              }
              html += `<tr>
                            <td> ` + (i + 1) + `</td>
                            <td> ` + data.DealsTitle + `</td>
                            <td>` + data.DealsDescription + `</td>
                            <td>` + data.DealsActualPrice + `</td>
                            <td>` + data.DealsOfferPrice + `</td>
                            <td>` + data.DealsType + `</td>
                            <td>` + status + `</td>
                            <td>
                            <a href="add.php?id=`+ data.DealsID + `" class="btn btn-primary edit">
                             <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="button" class="btn btn-danger delete" data-id="`+ data.DealsID + `" >
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
  all_deals();
  $(document).on('click', '.delete', function () {
    var id = $(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '../../API/deals.php',
      dataType: "json",
      data: {
        id: id,
        action: 'delete'
      },
      success: function (result) {
        console.log(result);
        $("#alert").append('<div class="alert-success">' + result.message + "</div>");
        all_deals();
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
      url: '../../API/deals.php',
      dataType: "json",
      data: {
        id: id,
        action: 'active'
      },
      success: function (result) {
        console.log(result);
        all_deals();
      }
    });
  });
});

