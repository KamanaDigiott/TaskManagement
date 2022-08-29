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
      $update = "update car_service_type set OilTypeTitle='$title', OilTypeDescription='$description', OilTypePrice='$price', LastEditedOn=now() where OilTypeID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'car_service_type Updated Successfully...!';
      }
    } else {
      $query1 = "insert INTO car_service_type(OilTypeTitle,OilTypeDescription,OilTypePrice) values('$title','$description','$price')";
      if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'car_service_type Added Successfully...!';
      }
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'car_service_type') {
    $query = "select * from car_service_type order by OilTypeID desc";
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
    $query = "select * from car_service_type where OilTypeID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update car_service_type set DeletedOn=now() where OilTypeID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'car_service_type Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from car_service_type where OilTypeID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['CarServiceTypeStatus'] == '1') {
      $update = "update car_service_type set  CarServiceTypeStatus='0' where OilTypeID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'car service type Status Updated Successfully...!';
      }
    } else {
      $update = "update car_service_type set CarServiceTypeStatus='1' where OilTypeID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'car service type Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
