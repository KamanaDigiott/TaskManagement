<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {

  if ($_POST['action'] == 'save_user') {
    $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $charge = $_POST['charge'];
    if (isset($_POST['id'])) {
      $update="update servicepersons set ServicePersonName='$name', ServicePersonEmail='$email', ServicePersonMobile='$mobile', ServiceCharge='$charge', LastEditedOn=now() where ServicePersonID='".$_POST['id']."'";
     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'User Updated Successfully...!';
      }
    } else {
      $query = "select * from servicepersons where ServicePersonEmail='" . $_POST['email'] . "'";
      $res = mysqli_query($conn, $query);
      if (mysqli_num_rows($res) > 0) {
        $data['success'] = false;
        $errors['email'] = 'This Email Already Exist';
        $data['errors'] = $errors;
      } else {
        $userToken = md5($mobile . "MEECACREATE" . rand());
        $query1 = "insert INTO servicepersons(ServicePersonName,ServicePersonEmail,ServicePersonMobile,ServiceCharge) values('$name','$email','$mobile','$charge')";
        if (mysqli_query($conn, $query1)) {
          $data['success'] = true;
          $data['message'] = 'User Added Successfully...!';
        }
      }
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'all_users') {
    $query = "select * from servicepersons order by ServicePersonID  desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if(is_null($row['DeletedOn'])){
      $data['data'][] = $row;
      $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'edit_user') {
    $query = "select * from servicepersons where ServicePersonID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete_user') {
    $update="update servicepersons set DeletedOn=now() where ServicePersonID='".$_GET['id']."'";
     if(mysqli_query($conn, $update)){
        $data['success'] = true;
        $data['message'] = 'User Deleted Successfully...!';
      }
      echo json_encode($data);
  }
}
