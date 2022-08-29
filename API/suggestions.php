<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'save') {
    $detail = $_POST['detail'];
    $adminComments = $_POST['adminComments'];
    if (isset($_POST['id'])) {
      $update = "update suggestions set UserID='A1', Suggestions='$detail', SuggestionStatus='inprogress',AdminComments='$adminComments', LastEditedOn=now() where 	SuggestionsID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'suggestions Updated Successfully...!';
      }
    } else {
      $query1 = "insert INTO suggestions(UserID,Suggestions,SuggestionStatus,AdminComments) values('A1','$detail','inprogress','$adminComments')";
      if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'suggestions Added Successfully...!';
      }
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'all_bugs') {
    $query = "select * from suggestions order by 	SuggestionsID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if (is_null($row['DeletedOn'])) {
        $data['data'][] = $row;
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'edit') {
    $query = "select * from suggestions where 	SuggestionsID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update suggestions set DeletedOn=now() where 	SuggestionsID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'suggestions Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from suggestions where 	SuggestionsID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['SuggestionStatus'] == '1') {
      $update = "update suggestions set  SuggestionStatus='0' where 	SuggestionsID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'suggestions Status Updated Successfully...!';
      }
    } else {
      $update = "update suggestions set SuggestionStatus='1' where 	SuggestionsID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'suggestions Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
