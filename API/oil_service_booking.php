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
    // $orderpickedupby = $_POST['orderpickedupby'];
    $bookdate = $_POST['bookdate'];
    $booktime = $_POST['booktime'];
    $oiltype = $_POST['oiltype'];
    $bookingstatus = $_POST['bookingstatus'];
    $usedealcode = $_POST['usedealcode'];
    $totalamt = $_POST['totalamt'];
    $paystatus = $_POST['paystatus'];
    if (isset($_POST['id'])) {
      $update = "update oilservicebooking set UserID='$user_id', BookingLocation='$booklocation',VachileID='$vehicle_id',OiltypeID='$oiltype',BookingDate='$bookdate',BookingTime='$booktime',UsedDeals='$usedealcode',TotalAmount='$totalamt',PaymentStatus='$paystatus',BookingStatus='$bookingstatus', LastEditedOn=now() where BookingID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = ' oilservicebooking Updated Successfully...!';
      }
    } else {
      $query1 = "insert INTO oilservicebooking(AppoinmentNo,UserID,BookingLocation,VachileID,OiltypeID,BookingDate,BookingTime,UsedDeals,TotalAmount,PaymentStatus,BookingStatus)
      values('$appoinmentID','$user_id','$booklocation','$vehicle_id','$oiltype','$bookdate','$booktime','$usedealcode','$totalamt','$paystatus','inprogress')";

      if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'oilservicebooking Added Successfully...!';
      }
    }
    echo json_encode($data);
  }

  if($_POST['action']=='update_status'){
    $status=$_POST['status'];
    $appointment_id=$_POST['appointment_id'];
    $user_id=$_POST['user_id'];
    $title='Booking Notifications';
    $desc="Your Order is $status";
    $update = "update carwashbookings set BookingStatus='$status', LastEditedOn=now() where BookingID='" . $_POST['id'] . "'";
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
  if ($_GET['action'] == 'all_booking_service') {
    $query = "select u.FullName,u.UserID,v.VehicleName,v.VehicleID,t.OilTypeID,t.OilTypeTitle, b.* from oilservicebooking as b left join oiltypes as t on t.OilTypeID=b.OiltypeID left JOIN vehicles as v on v.VehicleID=b.VachileID LEFT JOIN user as u on u.UserID=b.UserID Order BY b.BookingID DESC";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if (is_null($row['DeletedOn'])) {
        $data['data'][] = $row;
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'all_booking_service_id') {
    $query = "select u.FullName,u.UserID,v.VehicleName,v.VehicleID,o.OilTypeID,o.OilTypeTitle, b.* from oilservicebooking as b left join oiltypes as o on b.OiltypeID=o.OilTypeID left join user as u on u.UserID=b.UserID left join vehicles as v on v.UserID=u.UserID where b.BookingID='".$_GET['id']."' order by b.BookingID desc";
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
    $query = "select * from oilservicebooking where BookingID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update oilservicebooking set DeletedOn=now() where BookingID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'oilservicebooking Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from oilservicebooking where BookingID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['BookingStatus'] == '1') {
      $update = "update oilservicebooking set BookingStatus='0' where BookingID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'oilservicebooking Status Updated Successfully...!';
      }
    } else {
      $update = "update oilservicebooking set BookingStatus='1' where BookingID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'oilservicebooking Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
