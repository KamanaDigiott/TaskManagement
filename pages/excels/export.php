<?php
// Load the database configuration file
include_once '../../API/DB.php';
if ($_GET['action'] == 'export_user') {
  $filename = "users_" . date('Y-m-d') . "_" . time() . ".csv";
  $delimiter = ",";

  // Create a file pointer
  $f = fopen('php://memory', 'w');

  // Set column headers
  $fields = array('Name', 'Phone', 'Email', 'Address', 'Status');
  fputcsv($f, $fields, $delimiter);

  // Get records from the database
  $result = mysqli_query($conn, "SELECT * FROM user ORDER BY UserID DESC");
  if (mysqli_num_rows($result) > 0) {
    // Output each row of the data, format line as csv and write to file pointer
    while ($row = $result->fetch_assoc()) {
      if (is_null($row['DeletedOn'])) {
      $lineData = array($row['FullName'], $row['UserMobileno'], $row['UserEmail'], $row['UserAddress'], $row['UserStatus']);
      fputcsv($f, $lineData, $delimiter);
      }
    }
  }

  // Move back to beginning of file
  fseek($f, 0);

  // Set headers to download file rather than displayed
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '";');

  // Output all remaining data on a file pointer
  fpassthru($f);

  // Exit from file
  exit();
}

if ($_GET['action'] == 'export_battery_type') {
  $filename = "battery_type_" . date('Y-m-d') . "_" . time() . ".csv";
  $delimiter = ",";

  // Create a file pointer
  $f = fopen('php://memory', 'w');

  // Set column headers
  $fields = array('Battery Type', 'Car Model', 'Battery Weight', 'Status');
  fputcsv($f, $fields, $delimiter);

  // Get records from the database
  $result = mysqli_query($conn, "SELECT * FROM batterytype ORDER BY BatterytypeID DESC");
  if (mysqli_num_rows($result) > 0) {
    // Output each row of the data, format line as csv and write to file pointer
    while ($row = $result->fetch_assoc()) {
      if (is_null($row['DeletedOn'])) {
        $lineData = array($row['BatteryType'], $row['CarModel'], $row['BatteryWeight'], $row['BatterytypeStatus']);
        fputcsv($f, $lineData, $delimiter);
      }
    }
  }

  // Move back to beginning of file
  fseek($f, 0);

  // Set headers to download file rather than displayed
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '";');

  // Output all remaining data on a file pointer
  fpassthru($f);

  // Exit from file
  exit();
}

if ($_GET['action'] == 'export_battery_service') {
  $filename = "battery_service" . date('Y-m-d') . "_" . time() . ".csv";
  $delimiter = ",";

  // Create a file pointer
  $f = fopen('php://memory', 'w');

  // Set column headers
  $fields = array('BatteryServiceTitle', 'BatteryServicePrice', 'BatteryServiceDescription', 'BatteryServiceStatus');
  fputcsv($f, $fields, $delimiter);

  // Get records from the database
  $result = mysqli_query($conn, "SELECT * FROM batteryservices ORDER BY BatteryServiceID DESC");
  if (mysqli_num_rows($result) > 0) {
    // Output each row of the data, format line as csv and write to file pointer
    while ($row = $result->fetch_assoc()) {
      if (is_null($row['DeletedOn'])) {
      $lineData = array($row['BatteryServiceTitle'], $row['BatteryServicePrice'], $row['BatteryServiceDescription'], $row['BatteryServiceStatus']);
      fputcsv($f, $lineData, $delimiter);
      }
    }
  }

  // Move back to beginning of file
  fseek($f, 0);

  // Set headers to download file rather than displayed
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '";');

  // Output all remaining data on a file pointer
  fpassthru($f);

  // Exit from file
  exit();
}

if ($_GET['action'] == 'export_carwash_type') {
  $filename = "carwash_type" . date('Y-m-d') . "_" . time() . ".csv";
  $delimiter = ",";

  // Create a file pointer
  $f = fopen('php://memory', 'w');

  // Set column headers
  $fields = array('CarwashTitle', 'CarwashPrice', 'CarwashDescription', 'CarwashStatus');
  fputcsv($f, $fields, $delimiter);

  // Get records from the database
  $result = mysqli_query($conn, "SELECT * FROM carwashtypes ORDER BY CarwashID DESC");
  if (mysqli_num_rows($result) > 0) {
    // Output each row of the data, format line as csv and write to file pointer
    while ($row = $result->fetch_assoc()) {
      if (is_null($row['DeletedOn'])) {
      $lineData = array($row['CarwashTitle'], $row['CarwashPrice'], $row['CarwashDescription'], $row['CarwashStatus']);
      fputcsv($f, $lineData, $delimiter);
      }
    }
  }

  // Move back to beginning of file
  fseek($f, 0);

  // Set headers to download file rather than displayed
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '";');

  // Output all remaining data on a file pointer
  fpassthru($f);

  // Exit from file
  exit();
}
