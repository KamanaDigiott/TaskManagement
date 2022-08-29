<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
 

  if ($_POST['action'] == 'save_battery_type') {
        $type = $_POST['type'];
        $car_model = $_POST['car_model'];
        $weight = $_POST['weight'];
    if (isset($_POST['id'])) {
      $update="update batterytype set BatteryType='$type', CarModel='$car_model', BatteryWeight='$weight', LastEditedOn=now() where BatterytypeID ='".$_POST['id']."'";
     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'Battery type Updated Successfully...!';
      }
    } else {
       $query1 = "insert INTO batterytype(BatteryType ,CarModel,BatteryWeight) values('$type','$car_model','$weight')";
        if (mysqli_query($conn, $query1)) {
          $data['success'] = true;
          $data['message'] = 'Battery type Added Successfully...!';
        }

    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'all_battery_type') {
    $query = "select * from batterytype order by BatterytypeID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if(is_null($row['DeletedOn'])){
      $data['data'][] = $row;
      $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'edit_battery_type') {
    $query = "select * from batterytype where BatterytypeID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete_battery_type') {
    $update="update batterytype set DeletedOn=now() where BatterytypeID='".$_GET['id']."'";
     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'Battery type Deleted Successfully...!';
      }
      echo json_encode($data);
  }
}
