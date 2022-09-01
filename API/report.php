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

      $location = "uploads/";
      if (isset($data->action)) {
        if ($data->action == 'insert') {
          $taskID = $data->taskID;
          $taskTitle = $data->taskTitle;
          $taskDesc = $data->taskDesc;
          $taskRate = $data->taskRate;
          if ($taskID != '') {
            $update = "update tasks set TaskID='$taskID',TaskTitle='$taskTitle',TaskDescription='$taskDesc',TaskRate='$taskRate' where TaskID='$taskID'";
            $stmt = $conn->prepare($update);
            if ($stmt->execute()) {
              echo json_encode(array("message" => "Task Rate Updated Successfully", "success" => true));
            }
          } else {
            $taskImage = $_FILES['file']['name'];
            $targetFilePath = $location . $taskImage;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
              $insert = "insert into tasks(TaskID,TaskTitle,TaskDescription,TaskImage,TaskRate) value('$taskID','$taskTitle','$taskDesc','$taskImage','$taskRate')";
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
          $select = "SELECT SUM(TIMESTAMPDIFF(SECOND, login_details.LoginTime, login_details.LogoutTime)/3600) as hours,users.*,login_details.* FROM login_details INNER JOIN users on users.id=login_details.UserID where login_details.LogoutTime IS NOT NULL and DATE(login_details.CreatedOn) = DATE(NOW()) ORDER BY users.id DESC";
          $stmt = $conn->prepare($select);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($row);
            foreach ($row as &$lst) {
              // print_r($lst['id']);
              $task = "select * from tasks where UserID='" . $lst['id'] . "'";
              // echo $task;
              $tasks = $conn->prepare($task);
              // print_r($tasks) ;exit();
              $tasks->execute();

              $rows = $tasks->fetchAll(PDO::FETCH_ASSOC);
              // print_r($rows) ;exit();s
              $lst['tasks'] = $rows;
            }
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

        // API for get lists of login users

        if ($_GET['action'] == 'activeInactiveUser') {
          if ($_GET['status'] == 'loggedIn') {
            $select = "SELECT SUM(TIMESTAMPDIFF(SECOND, login_details.LoginTime, login_details.LogoutTime)/3600) as hours,users.*,login_details.* FROM login_details INNER JOIN users on users.id=login_details.UserID where DATE(login_details.CreatedOn) = DATE(NOW()) and users.LoginStatus='LoggedOut' ORDER BY users.id DESC";
            //  echo $select;exit();
            $stmt = $conn->prepare($select);
            $stmt->execute();
            // echo $stmt->rowCount(); exit();
            if ($stmt->rowCount() > 0) {
              $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
              echo json_encode(array("data" => $row, "success" => true));
            }
          }
          if ($_GET['status'] == 'loggedOut') {
            $select = "SELECT SUM(TIMESTAMPDIFF(SECOND, login_details.LoginTime, login_details.LogoutTime)/3600) as hours,users.*,login_details.* FROM login_details INNER JOIN users on users.id=login_details.UserID where login_details.LogoutTime IS NOT NULL and DATE(login_details.CreatedOn) = DATE(NOW()) and users.LoginStatus='LoggedIN' ORDER BY users.id DESC";
            //  echo $select;exit();
            $stmt = $conn->prepare($select);
            $stmt->execute();
            // echo $stmt->rowCount(); exit();
            if ($stmt->rowCount() > 0) {
              $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
              echo json_encode(array("data" => $row, "success" => true));
            }
          }
        }
        // API for get lists of login users

        // if ($_GET['action'] == 'loggedOutUser') {
        //   $select = "SELECT SUM(TIMESTAMPDIFF(SECOND, login_details.LoginTime, login_details.LogoutTime)/3600) as hours,users.*,login_details.* FROM login_details INNER JOIN users on users.id=login_details.UserID where DATE(login_details.CreatedOn) = DATE(NOW()) and users.LoginStatus='LoggedOut' ORDER BY users.id DESC";
        //   //  echo $select;exit();
        //   $stmt = $conn->prepare($select);
        //   $stmt->execute();
        //   // echo $stmt->rowCount(); exit();
        //   if ($stmt->rowCount() > 0) {
        //     $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     echo json_encode(array("data" => $row, "success" => true));
        //   }
        // }
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
