<?php
session_start();
// session_unset();
// session_destroy();
//header("location:../index.php");
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
        // echo $jwt;exit();
        if ($data->action == 'user_logout') {
          $userId = $_SESSION['id'];
          $table_name = 'login_details';
          $query = "SELECT * FROM " . $table_name . " WHERE UserID ='$userId' order by LoginID desc LIMIT 1";
          $stmt = $conn->prepare($query);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $LoginID = $row['LoginID'];
            if ($userId != '') {
              $update = "update " . $table_name . " set LogoutTime='now()' where LoginID='$LoginID'";
              // echo $update;
              // exit();
              $stmt = $conn->prepare($update);
              if ($stmt->execute()) {
                session_unset();
                session_destroy();
                echo json_encode(array("message" => "User Logout Successfully", "success" => true));
              }
            } else {
              echo "hi";
              // $taskImage = $_FILES['file']['name'];
              // $targetFilePath = $location . $taskImage;
              // if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
              //   $insert = "insert into tasks(TaskID,TaskTitle,TaskDescription,TaskImage,TaskRate) value('$taskID','$taskTitle','$taskDesc','$taskImage','$taskRate')";
              //   $stmt = $conn->prepare($insert);
              //   if ($stmt->execute()) {
              //     echo json_encode(array("message" => "Task Created Successfully"));
              //   }
              // }
            }
          }
        }

        if ($data->action == 'admin_logout') {
          session_unset();
          session_destroy();
          echo json_encode(array("message" => "Admin Logout Successfully", "success" => true));
        }
        if ($data->action == 'update') {
          $taskTitle = $data->taskTitle;
          $taskDesc = $data->taskDesc;
          $select = "update tasks set TaskTitle='$taskTitle',TaskDescription='$taskDesc',UpdatedOn=now() where ID='" . $_POST['ID'] . "'";
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
