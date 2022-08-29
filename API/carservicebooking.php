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
    $service = $_POST['service'];
    $bookdate = $_POST['bookdate'];
    $booktime = $_POST['booktime'];
    $parktype = $_POST['parktype'];
    $addtnotes = $_POST['addtnotes'];
    $manualadd = $_POST['manualadd'];
    $bookplace = $_POST['bookplace'];
    $usedealcode = $_POST['usedealcode'];
    $totalamt = $_POST['totalamt'];
    $paystatus = $_POST['paystatus'];
    if (isset($_POST['id'])) {
      $update = "update carservicebooking set UserID='$user_id', BookingLocation='$booklocation',VachileID='$vehicle_id',ServiceTypeID='$service',BookingDate='$bookdate',BookingTime='$booktime',ParkingType='$parktype',AdditionalNotes='$addtnotes',ManualAddress='$manualadd',BookingPlaceType='$bookplace',UsedDealCode='$usedealcode',TotalAmount='$totalamt',PaymentStatus='$paystatus', LastEditedOn=now() where BookingID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'carservicebooking Updated Successfully...!';
      }
    } else {
      $query1 = "insert INTO carservicebooking(AppoinmentID,UserID,BookingLocation,VachileID,ServiceTypeID,BookingDate,BookingTime,ParkingType,AdditionalNotes,ManualAddress,BookingPlaceType,UsedDealCode,TotalAmount,PaymentStatus,BookingStatus)
      values('$appoinmentID','$user_id','$booklocation','$vehicle_id','$service','$bookdate','$booktime','$parktype','$addtnotes','$manualadd','$bookplace','$usedealcode','$totalamt','paystatus','inprogress')";

if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'carservicebooking Added Successfully...!';
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
    $update = "update carservicebooking set BookingStatus='$status', LastEditedOn=now() where BookingID='" . $_POST['id'] . "'";

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

  if ($_POST['action'] == 'update_person_id') {
    $update = "update carservicebooking set OrderPickupedBy='".$_POST['person_id']."' where BookingID='" . $_POST['booking_id'] . "'";

    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'carservicebooking Updated Successfully...!';
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'carservice') {
    $query = "select u.FullName,u.UserID,v.VehicleName,v.VehicleID, b.* from carservicebooking as b left join user as u on u.UserID=b.UserID left join vehicles as v on v.UserID=u.UserID order by BookingID desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if (is_null($row['DeletedOn'])) {
        $data['data'][] = $row;
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'appointment_id') {
    $query = "select u.FullName,u.UserID,v.VehicleName,v.VehicleID, b.* from carservicebooking as b left join user as u on u.UserID=b.UserID left join vehicles as v on v.UserID=u.UserID where BookingID='".$_GET['id']."' order by BookingID desc";
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
    $query = "select * from carservicebooking where BookingID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update carservicebooking set DeletedOn=now() where BookingID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'carservicebooking Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from carservicebooking where BookingID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['BookingStatus'] == '1') {
      $update = "update carservicebooking set BookingStatus='0' where BookingID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'carservicebooking Status Updated Successfully...!';
      }
    } else {
      $update = "update carservicebooking set BookingStatus='1' where BookingID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'carservicebooking Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
