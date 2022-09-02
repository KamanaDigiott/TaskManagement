<?php
include_once './config/database.php';
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$secret_key = "YOUR_SECRET_KEY";
$jwt = null;
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();
$data = json_decode(file_get_contents("php://input"));

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);
/*echo json_encode(array(
    "message" => "sd" .$arr[1]
));*/
$record = [];
$error = [];

$jwt = $arr[1];

if ($jwt) {

  try {

    $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
    if ($decoded) {
      // echo json_encode(array(
      //   "message" => "Access granted:"
      // ));

      $location = "uploads/";
      if (isset($data->action)) {

        if ($data->action == 'insert') {
          $length = 6;
          $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          $taskID= date("y") . $randomString;
          $taskDesc = $data->taskDesc;
          if ($taskID != '') {
            $update = "update tasks set TaskID='$taskID',TaskDescription='$taskDesc' where TaskID='$taskID'";
            $stmt = $conn->prepare($update);
            if ($stmt->execute()) {
              echo json_encode(array("message" => "Task Rate Updated Successfully", "success" => true));
            }
          } else {
            $fileNames = array_filter($_FILES['files']['name']);
            $targetFilePath = $location . $taskImage;
            $UserID = $_SESSION['id'];
            if(!empty($fileNames)){
              foreach($_FILES['files']['name'] as $key=>$val){
                  // File upload path
                  $fileName = basename($_FILES['files']['name'][$key]);
                  $targetFilePath = $targetDir . $fileName;

                  // Check whether file type is valid
                  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                  if(in_array($fileType, $allowTypes)){
                      // Upload file to server
                      if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                          // Image db insert sql
                          $insertValuesSQL .= "('".$fileName."', NOW()),";
                      }else{
                          $errorUpload .= $_FILES['files']['name'][$key].' | ';
                      }
                  }else{
                      $errorUploadType .= $_FILES['files']['name'][$key].' | ';
                  }
              }
            }
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
              $insert = "insert into tasks(TaskID,UserID,TaskDescription,TaskImage) value('$taskID','$UserID','$taskTitle','$taskDesc','$taskImage')";
              $stmt = $conn->prepare($insert);
              if ($stmt->execute()) {
                echo json_encode(array("message" => "Task Created Successfully"));
              }
            }
          }
        }

        if ($data->action == 'update') {
          $taskTitle = $data->taskTitle;
          $taskDesc = $data->taskDesc;
          $select = "update tasks set TaskTitle='$taskTitle',TaskDescription='$taskDesc',UpdatedOn=now() where TaskID='" . $data->TaskID. "'";
          $stmt = $conn->prepare($select);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array("message" => "Task Updated Successfully", "success" => true));
          }
        }

        if ($data->action == 'delete') {
          $select = "update tasks set DeletedOn=now() where ID='" . $data->ID . "'";
          $stmt = $conn->prepare($select);
          if ($stmt->execute()) {
            echo json_encode(array("message" => "Task Deleted Successfully", "success" => true));
          }
        }
      }

      if (isset($_GET['action'])) {
        if ($_GET['action'] == 'select') {
          $select = "select * from tasks where DeletedOn IS NULL order by ID desc";
          $stmt = $conn->prepare($select);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array("data" => $row, "success" => true));
          }
        }
        // if ($_GET['action'] == 'active') {
          //   $status = "select * from carwashtypes where CarwashID='" . $_GET['id'] . "'";
          //   $res = mysqli_query($conn, $status);
          //   $row = mysqli_fetch_assoc($res);
          //   if ($row['CarwashStatus'] == '1') {
          //     $update = "update carwashtypes set CarwashStatus='0' where CarwashID='" . $_GET['id'] . "'";
          //     if (mysqli_query($conn, $update)) {
          //       $data['success'] = true;
          //       $data['message'] = 'carwashtypes Status Updated Successfully...!';
          //     }
          //   } else {
          //     $update = "update carwashtypes set CarwashStatus='1' where CarwashID='" . $_GET['id'] . "'";
          //     if (mysqli_query($conn, $update)) {
          //       $data['success'] = true;
          //       $data['message'] = 'carwashtypes Status Updated Successfully...!';
          //     }
          //   }

          //   echo json_encode($data);
        // }
        if ($_GET['action'] == 'select_id') {
          $select = "select * from tasks where TaskID='" . $_GET['taskID'] . "'";
          $stmt = $conn->prepare($select);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array("data" => $row, "success" => true));
          }
        }
      }
    }
  } catch (Exception $e) {
    http_response_code(401);
    echo json_encode(array(
      "message" => "Access denied, User Unauthenticated.",
      "error" => $e->getMessage()
    ));
  }
}
