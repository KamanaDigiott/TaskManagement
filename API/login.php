<?php
include_once './config/database.php';
require "../vendor/autoload.php";
session_start();

use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//Get IP Address of User in PHP
$ip = file_get_contents("https://www.geoplugin.com/ip.php");
// //call api
$url = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);
//decode json data
$getInfo = json_decode($url);
$lat = $getInfo->geoplugin_latitude;
$long = $getInfo->geoplugin_longitude;
// print_r($getInfo);

$email = '';
$password = '';
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();
$data = json_decode(file_get_contents("php://input"));
$email = $data->email;
$password = $data->password;
$table_name = 'users';
$query = "SELECT * FROM " . $table_name . " WHERE email = ? LIMIT 0,1";

$stmt = $conn->prepare($query);
$stmt->bindParam(1, $email);
$stmt->execute();
$num = $stmt->rowCount();
if ($num > 0) {
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $id = $row['id'];
  $name = $row['name'];
  $password2 = $row['password'];
  $role = $row['UserRole'];
  if (password_verify($password, $password2)) {
    if ($role == "USER") {
      $insert = "insert into login_details(UserID,IPAddress,Latitude,Longitude,LoginTime) values('$id','$ip','$lat','$long',now())";
      $prepare = $conn->prepare($insert);
      $prepare->execute();
    }
    // print_r($data);
    $secret_key = "YOUR_SECRET_KEY";
    $issuer_claim = "digiott.com"; // this can be the servername
    $audience_claim = "THE_AUDIENCE";
    $issuedat_claim = time(); // issued at
    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
    $expire_claim = $issuedat_claim + 6000; // expire time in seconds
    $token = array(
      "iss" => $issuer_claim,
      "aud" => $audience_claim,
      "iat" => $issuedat_claim,
      "nbf" => $notbefore_claim,
      "exp" => $expire_claim,
      "data" => array(
        "id" => $id,
        "name" => $name,
        "email" => $email
      )
    );

    http_response_code(200);
    $jwt = JWT::encode($token, $secret_key, 'HS256');
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $name;
    $_SESSION['token'] = $jwt;
    $_SESSION['email'] = $email;

    echo json_encode(
      array(
        "message" => "Successful login.",
        "token" => $jwt,
        "name" => $name,
        "email" => $email,
        "expireAt" => $expire_claim
      )
    );
  } else {

    http_response_code(401);
    echo json_encode(array("message" => "Login failed, Wrong Password.", "password" => $password));
  }
} else {
  echo json_encode(
    array(
      "message" => "Login Failed, User Not Exist.",
      "success" => false
    )
  );
}
