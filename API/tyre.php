<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'save') {
    $length = 6;
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $appoinmentID= date("y") . $randomString;
    $user_id = $_POST['user'];
    $booklocation = $_POST['booklocation'];
    $vehicle_id = $_POST['vehicle'];
    $tyresize = $_POST['tyresize'];
    $bookdate = $_POST['bookdate'];
    $booktime = $_POST['booktime'];
    $usedealcode = $_POST['usedealcode'];
    $totalamt = $_POST['totalamt'];
    $paystatus = $_POST['paystatus'];
    if (isset($_POST['id'])) {
      $update = "update tyreservicebooking set UserID='$user_id', BookingLocation='$booklocation',VachileID='$vehicle_id',TyreSize='$tyresize',BookingDate='$bookdate',BookingTime='$booktime',UsedDeals='$usedealcode',TotalAmount='$totalamt',PaymentStatus='$paystatus', LastEditedOn=now() where BookingID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'tyreservicebooking Updated Successfully...!';
      }
    } else {
      $query1 = "insert INTO tyreservicebooking(AppoinmentNo,UserID,BookingLocation,VachileID,TyreSize,BookingDate,BookingTime,UsedDeals,TotalAmount,PaymentStatus,BookingStatus)
      values('$appoinmentID','$user_id','$booklocation','$vehicle_id','$tyresize','$bookdate','$booktime','$usedealcode','$totalamt','$paystatus','inprogress')";
      if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'tyreservicebooking Added Successfully...!';
      }
    }
    echo json_encode($data);
  }

  if($_POST['action']=='update_status'){
    $status=$_POST['status'];
    $appointment_id=$_POST['appointment_id'];
    $user_id=$_POST['user_id'];
    $title='Booking Notifications';
    $desc='Your Order is $status';    $update = "update tyreservicebooking set BookingStatus='$status', LastEditedOn=now() where BookingID='" . $_POST['id'] . "'";

    if (mysqli_query($conn, $update)) {
      $query = "insert INTO notification(user_id,booking_id,NotificationTitle,NotificationDescription)
      values('$user_id','$appointment_id','$title','$desc')";
      $res = mysqli_query($conn, $query);
      if($res){
        $data['success'] = true;
      $data['message'] = 'notification added Successfully...!';
      }
      $data['success'] = true;
      $data['message'] = 'status Updated Successfully...!';
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'tyre') {
    $query = "select u.FullName,u.UserID,v.VehicleName,v.VehicleID, b.* from tyreservicebooking as b left join user as u on u.UserID=b.UserID left join vehicles as v on v.UserID=u.UserID order by BookingID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if (is_null($row['DeletedOn'])) {
        $data['data'][] = $row;
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'tyre_id') {
    $query = "select u.FullName,u.UserID,v.VehicleName,v.VehicleID, b.* from tyreservicebooking as b left join user as u on u.UserID=b.UserID left join vehicles as v on v.UserID=u.UserID where b.BookingID='".$_GET['id']."' order by b.BookingID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if (is_null($row['DeletedOn'])) {
        $data['data'] = $row;
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'edit') {
    $query = "select * from tyreservicebooking where BookingID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update tyreservicebooking set DeletedOn=now() where BookingID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'tyreservicebooking Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from tyreservicebooking where BookingID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['BookingStatus'] == '1') {
      $update = "update tyreservicebooking set BookingStatus='0' where BookingID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'tyreservicebooking Status Updated Successfully...!';
      }
    } else {
      $update = "update tyreservicebooking set BookingStatus='1' where BookingID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'tyreservicebooking Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
