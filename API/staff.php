<?php
include('DB.php');
session_start();
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
  // if ($_POST['action'] == 'admin_login') {
  //   if (empty($_POST['email'])) {
  //     $errors['email'] = 'Email is required.';
  //   }
  //   if (empty($_POST['password'])) {
  //     $errors['password'] = 'Password is required.';
  //   }
  //   if (!empty($errors)) {
  //     $data['success'] = false;
  //     $data['errors'] = $errors;
  //   } else {
  //     $query = "select * from admin where email='" . $_POST['email'] . "'";
  //     $res = mysqli_query($conn, $query);
  //     if (mysqli_num_rows($res) > 0) {
  //       $row = mysqli_fetch_assoc($res);
  //       if (md5($_POST['password'] == $row['Password'])) {
  //         $data['success'] = true;
  //         $_SESSION['user_id']=$row['ID'];
  //         $_SESSION['name']=$row['Name'];
  //         $_SESSION['email']=$row['Email'];
  //         $data['message'] = 'Login Successfully!';
  //       } else {
  //         $data['success'] = false;
  //         $errors['password'] = 'Incorrect Password';
  //         $data['errors'] = $errors;
  //       }
  //     } else {
  //       $data['success'] = false;
  //       $errors['email'] = 'User Not Exist.';
  //       $data['errors'] = $errors;
  //     }
  //   }
  //   echo json_encode($data);
  // }

  if ($_POST['action'] == 'save') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $Gender = $_POST['gender'];
    $DOB = $_POST['dob'];
    $MaritalStatus = $_POST['marital'];

    if (isset($_POST['id'])) {
      $update = "update admin set Name='$name', Email='$email', Phone='$mobile', Role='$role', Gender='$Gender',  DOB='$DOB', MaritalStatus='$MaritalStatus', LastEditedOn=now() where ID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'User Updated Successfully...!';
      }
    } else {
      $query = "select * from admin where Email='" . $_POST['email'] . "'";
      $res = mysqli_query($conn, $query);
      if (mysqli_num_rows($res) > 0) {
        $data['success'] = false;
        $errors['email'] = 'This Email Already Exist';
        $data['errors'] = $errors;
      } else {
        $query1 = "insert INTO admin(Name,Email,Phone,Role,Gender,DOB,MaritalStatus) values('$name','$email','$mobile','$role','$Gender','$DOB','$MaritalStatus')";
        // echo $query1; exit();
        if (mysqli_query($conn, $query1)) {
          $data['success'] = true;
          $data['message'] = '"'.$role.'" Added Successfully...!';
        }
      }
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'staff') {
    $query = "select * from admin order by ID desc";
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
    $query = "select * from admin where ID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update admin set DeletedOn=now() where ID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'User Deleted Successfully...!';
    }
    echo json_encode($data);
  }
}
