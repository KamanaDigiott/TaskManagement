<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'save') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    if (isset($_POST['id'])) {
      $update = "update carwashtypes set CarwashTitle='$title', CarwashDescription='$description', CarwashPrice='$price', LastEditedOn=now() where CarwashID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'carwashtypes Updated Successfully...!';
      }
    } else {
      $query1 = "insert INTO carwashtypes(CarwashTitle,CarwashDescription,CarwashPrice) values('$title','$description','$price')";
      if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'carwashtypes Added Successfully...!';
      }
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'carwashtypes') {
    $query = "select * from carwashtypes order by CarwashID desc";
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
    $query = "select * from carwashtypes where CarwashID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update carwashtypes set DeletedOn=now() where CarwashID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'carwashtypes Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from carwashtypes where CarwashID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['CarwashStatus'] == '1') {
      $update = "update carwashtypes set CarwashStatus='0' where CarwashID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'carwashtypes Status Updated Successfully...!';
      }
    } else {
      $update = "update carwashtypes set CarwashStatus='1' where CarwashID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'carwashtypes Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
