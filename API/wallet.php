<?php
include('DB.php');

if (isset($_GET['action'])) {
  if ($_GET['action'] == 'wallet') {
    $query = "select u.FullName,u.UserID,u.UserMobileno,u.UserEmail,w.* from wallethistory as w left join user as u on u.UserID=w.UserID order by w.ID  desc";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if (is_null($row['DeletedOn'])) {
        $data['data'][] = $row;
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'wallet_id') {
    $query = "select u.FullName,u.UserID,u.UserMobileno,w.* from wallethistory as w left join user as u on u.UserID=w.UserID where w.UserID='".$_GET['id']."' order by w.ID  desc";

    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if (is_null($row['DeletedOn'])) {
        $data['data'] = $row;
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }

  // if ($_GET['action'] == 'edit') {
  //   $query = "select * from wallethistory where BookingID='" . $_GET['id'] . "'";
  //   $res = mysqli_query($conn, $query);
  //   $row = mysqli_fetch_assoc($res);
  //   $data['data'] = $row;
  //   $data['success'] = true;
  //   echo json_encode($data);
  // }

  // if ($_GET['action'] == 'delete') {
  //   $update = "update wallethistory set DeletedOn=now() where BookingID='" . $_GET['id'] . "'";
  //   if (mysqli_query($conn, $update)) {
  //     $data['success'] = true;
  //     $data['message'] = 'wallethistory Deleted Successfully...!';
  //   }
  //   echo json_encode($data);
  // }

  // if ($_GET['action'] == 'active') {
  //   $status = "select * from wallethistory where BookingID='" . $_GET['id'] . "'";
  //   $res = mysqli_query($conn, $status);
  //   $row = mysqli_fetch_assoc($res);
  //   if ($row['BookingStatus'] == '1') {
  //     $update = "update wallethistory set BookingStatus='0' where BookingID='" . $_GET['id'] . "'";
  //     if (mysqli_query($conn, $update)) {
  //       $data['success'] = true;
  //       $data['message'] = 'wallethistory Status Updated Successfully...!';
  //     }
  //   } else {
  //     $update = "update wallethistory set BookingStatus='1' where BookingID='" . $_GET['id'] . "'";
  //     if (mysqli_query($conn, $update)) {
  //       $data['success'] = true;
  //       $data['message'] = 'wallethistory Status Updated Successfully...!';
  //     }
  //   }

  //   echo json_encode($data);
  // }
}
