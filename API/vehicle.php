<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'save') {
    $name = $_POST['name'];
    $userId = $_POST['user_id'];
        $plateno = $_POST['plateno'];
        $color = $_POST['color'];
        $fuletype = $_POST['fuletype'];
    if (isset($_POST['id'])) {
      $update="update vehicles set UserID=$userId, VehicleName='$name', PlateNumber='$plateno', VehicleColor='$color', Fuletype='$fuletype', LastEditedOn=now() where VehicleID='".$_POST['id']."'";
     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'User Updated Successfully...!';
      }
    } else {
        // $userToken = md5($mobile . "MEECACREATE" . rand());
        $query1 = "insert INTO vehicles(UserID,VehicleName,PlateNumber,VehicleColor,Fuletype) values('$userId','$name','$plateno','$color','$fuletype')";
        if (mysqli_query($conn, $query1)) {
          $data['success'] = true;
          $data['message'] = 'Vehicle Added Successfully...!';
        }
      }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'vehicle') {
    $query = "select u.FullName,u.UserID,v.* from vehicles as v left join user as u on u.UserID=v.UserID order by v.VehicleID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if(is_null($row['DeletedOn'])){
      $data['data'][] = $row;
      $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'vehicle_by_UserID') {
    $query = "select * from vehicles where UserID='".$_GET['id']."' order by VehicleID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if(isset($row['VehicleID'])){
        if(is_null($row['DeletedOn'])){
          $data['data'][] = $row;
          $data['success'] = true;
        }
        else{
          $data['success'] = false;
          $errors['error']='Please Add Atleast One Vehicle';
          $data['errors'] = $errors;
        }
      }
      else{
        $data['success'] = false;
        $errors['error']='Please Add Atleast One Vehicle';
        $data['errors'] = $errors;
      }

  }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'edit') {
    $query = "select * from vehicles where VehicleID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update="update vehicles set DeletedOn=now() where VehicleID='".$_GET['id']."'";
     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'Vehicle Deleted Successfully...!';
      }
      echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status="select * from vehicles where VehicleID='".$_GET['id']."'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if($row['VehicleStatus']=='1'){
      $update="update vehicles set VehicleStatus='0' where VehicleID='".$_GET['id']."'";
      if(mysqli_query($conn, $update)){
         $data['success'] = true;
         $data['message'] = 'Vehicle Status Updated Successfully...!';
       }
    }
    else{
      $update="update vehicles set VehicleStatus='1' where VehicleID='".$_GET['id']."'";
      if(mysqli_query($conn, $update)){
         $data['success'] = true;
         $data['message'] = 'Vehicle Status Updated Successfully...!';
       }
    }

      echo json_encode($data);
  }
}
