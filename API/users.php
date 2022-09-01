<?php
include_once './config/database.php';
require "../vendor/autoload.php";
session_start();

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
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
$table_name = 'users';
$jwt = $arr[1];
// echo $jwt;exit();
// print_r($data); exit();
if ($jwt) {

  try {

    $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
    if ($decoded) {
      if (isset($data->action)) {
        if ($data->action == 'insert') {
          $name = $data->name;
          $email = $data->email;
          $password = $data->password;
          $taskRate = $data->taskRate;
          $query = "INSERT INTO " . $table_name . "
                SET name = :name,
                    email = :email,
                    password = :password,
                    taskRate = :taskRate,
                    UserRole = 'USER'";
          $stmt = $conn->prepare($query);

          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':email', $email);

          $password_hash = password_hash($password, PASSWORD_BCRYPT);

          $stmt->bindParam(':password', $password_hash);
          $stmt->bindParam(':taskRate', $taskRate);
          // print_r($stmt); exit();

          if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "User was successfully registered.", "success" => true));
          } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
          }
        }

        if ($data->action == 'login_status') {
          $userID = $_SESSION['id'];
          $select = "select id,name,email,UserRole,UserStatus,taskRate,LoginStatus from users where id='$userID' and DeletedOn IS NULL order by id desc";
          $stmt = $conn->prepare($select);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['LoginStatus'] == 'LoggedOut') {
              $update = "update users set LoginStatus='LoggedIN',UpdatedOn=now() where id='$userID'";
              $stmt = $conn->prepare($update);
              $stmt->execute();
              if ($stmt->rowCount() > 0) {
                echo json_encode(array("message" => "User Logged In", "success" => true));
              }
            } else if ($row['LoginStatus'] == 'LoggedIN') {
              $select = "update users set LoginStatus='LoggedOut',UpdatedOn=now() where id='$userID'";
              $stmt = $conn->prepare($select);
              $stmt->execute();
              if ($stmt->rowCount() > 0) {
                echo json_encode(array("message" => "User Logged Out", "success" => true));
              }
            }
          }
        }

        if ($data->action == 'delete') {
          $select = "update users set DeletedOn=now() where ID='" . $data->ID . "'";
          $stmt = $conn->prepare($select);
          if ($stmt->execute()) {
            echo json_encode(array("message" => "Task Deleted Successfully", "success" => true));
          }
        }
      }

      if (isset($_GET['action'])) {
        // echo $jwt;exit();
        if ($_GET['action'] == 'select') {
          $select = "select id,name,email,UserRole,UserStatus,taskRate from users where DeletedOn IS NULL order by id desc";
          //  echo $select;exit();
          $stmt = $conn->prepare($select);
          $stmt->execute();
          // echo $stmt->rowCount(); exit();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array("data" => $row, "success" => true));
          }
        }



        if ($_GET['action'] == 'select_id') {
          $select = "select * from users where TaskID='" . $data->taskID . "'";
          $stmt = $conn->prepare($select);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
