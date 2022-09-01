<?php
session_start();
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
      $userId = $_SESSION['id'];
      $table_name = 'login_details';
      $query = "SELECT users.UserRole,login_details.* FROM login_details left join users on users.id=login_details.UserID WHERE login_details.UserID ='$userId' order by login_details.LoginID desc LIMIT 1";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $LoginID = $row['LoginID'];
        if ($row['UserRole'] == 'USER') {
          $update = "update " . $table_name . " set LogoutTime=now() where LoginID='$LoginID'";
          $stmt = $conn->prepare($update);
          $stmt->execute();
        }
        session_unset();
        session_destroy();
        echo json_encode(array("message" => "Logout Successfully", "success" => true));
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
