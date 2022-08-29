<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'save') {
    $detail = $_POST['detail'];
    $adminComments = $_POST['adminComments'];
    $bookdate = $_POST['bookdate'];
    $booktime = $_POST['booktime'];
    if (isset($_POST['id'])) {
      $update = "update bugreports set UserID='A1', BugDetails='$detail', BugStatus='inprogress',AdminComments='$adminComments',deadline_date='$bookdate',deadline_time='$booktime', LastEditedOn=now() where BugID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'bug reports Updated Successfully...!';
      }
    } else {
      $query1 = "insert INTO bugreports(UserID,BugDetails,BugStatus,AdminComments,deadline_date,deadline_time) values('A1','$detail','inprogress','$adminComments','$bookdate','$booktime')";
      if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'bug reports Added Successfully...!';
      }
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'all_bugs') {
    $query = "select * from bugreports order by BugID desc";
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
    $query = "select * from bugreports where BugID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update bugreports set DeletedOn=now() where BugID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'bugreports Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from bugreports where BugID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['OilTypeStatus'] == '1') {
      $update = "update bugreports set  OilTypeStatus='0' where BugID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'bugreports Status Updated Successfully...!';
      }
    } else {
      $update = "update bugreports set OilTypeStatus='1' where BugID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'bugreports Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
