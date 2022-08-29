<?php
include_once './config/database.php';
require "../vendor/autoload.php";

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
print_r($data);
      if (isset($data->action)) {
        if ($data->action == 'insert') {
          $name = $data->name;
          $email = $data->email;
          $password = $data->password;
          $query = "INSERT INTO " . $table_name . "
                SET name = :name,
                    email = :email,
                    password = :password";
          $stmt = $conn->prepare($query);

          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':email', $email);

          $password_hash = password_hash($password, PASSWORD_BCRYPT);

          $stmt->bindParam(':password', $password_hash);
          // print_r($stmt); exit();

          if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "User was successfully registered."));
          } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
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
      if(isset($_GET['action'])){
        if ($_GET['action'] == 'select') {
          $select = "select * from users where DeletedOn IS NULL order by id desc";
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

      }
      else {
        echo json_encode(array(
          "message" => "Action is Needed."
        ));
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
