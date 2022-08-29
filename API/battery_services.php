<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
 

  if ($_POST['action'] == 'save_battery_service') {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
    if (isset($_POST['id'])) {
      $update="update batteryservices set BatteryServiceTitle='$title', BatteryServicePrice='$price', BatteryServiceDescription='$description', LastEditedOn=now() where BatteryServiceID ='".$_POST['id']."'";

     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'Battery Service Updated Successfully...!';
      }
    } else {
       $query1 = "insert INTO batteryservices(BatteryServiceTitle ,BatteryServicePrice,BatteryServiceDescription) values('$title','$price','$description')";
        if (mysqli_query($conn, $query1)) {
          $data['success'] = true;
          $data['message'] = 'Battery Service Added Successfully...!';
        }

    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'all_battery_services') {
    $query = "select * from batteryservices order by BatteryServiceID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if(is_null($row['DeletedOn'])){
      $data['data'][] = $row;
      $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'edit_battery_service') {
    $query = "select * from batteryservices where BatteryServiceID='" . $_GET['id'] . "'";

    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete_battery_service') {
    $update="update batteryservices set DeletedOn=now() where BatteryServiceID='".$_GET['id']."'";
   
     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'Battery Service Deleted Successfully...!';
      }
      echo json_encode($data);
  }
}
