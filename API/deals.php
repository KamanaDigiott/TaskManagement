<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'save') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $actualPrice = $_POST['actualPrice'];
    $offerPrice = $_POST['offerPrice'];
    $type = $_POST['type'];
    if (isset($_POST['id'])) {
      $update = "update deals set DealsTitle='$title', DealsDescription='$description', DealsActualPrice='$actualPrice', DealsOfferPrice='$offerPrice', DealsType='$type', LastEditedOn=now() where DealsID='" . $_POST['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'Deals Updated Successfully...!';
      }
    } else {
      $uploadDir = 'uploads/';
        $fileName = $_FILES['file']['name'];
        //  echo $filseName;exit();
        $targetFilePath = $uploadDir . $fileName;
        move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
      $query1 = "insert INTO deals(DealsTitle,DealsDescription,DealsActualPrice,DealsOfferPrice,DealsType,DealsImage) values('$title','$description','$actualPrice','$offerPrice','$type','$fileName')";
      if (mysqli_query($conn, $query1)) {
        $data['success'] = true;
        $data['message'] = 'Deals Added Successfully...!';
      }
    }
    echo json_encode($data);
  }
}
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'deals') {
    $query = "select * from deals order by DealsID desc";
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
    $query = "select * from deals where DealsID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);
    $data['data'] = $row;
    $data['success'] = true;
    echo json_encode($data);
  }

  if ($_GET['action'] == 'delete') {
    $update = "update deals set DeletedOn=now() where DealsID='" . $_GET['id'] . "'";
    if (mysqli_query($conn, $update)) {
      $data['success'] = true;
      $data['message'] = 'Deals Deleted Successfully...!';
    }
    echo json_encode($data);
  }

  if ($_GET['action'] == 'active') {
    $status = "select * from deals where DealsID='" . $_GET['id'] . "'";
    $res = mysqli_query($conn, $status);
    $row = mysqli_fetch_assoc($res);
    if ($row['DealsStatus'] == '1') {
      $update = "update deals set DealsStatus='0' where DealsID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'Deals Status Updated Successfully...!';
      }
    } else {
      $update = "update deals set DealsStatus='1' where DealsID='" . $_GET['id'] . "'";
      if (mysqli_query($conn, $update)) {
        $data['success'] = true;
        $data['message'] = 'Deals Status Updated Successfully...!';
      }
    }

    echo json_encode($data);
  }
}
