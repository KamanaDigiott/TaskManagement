<?php
// Load the database configuration file
include_once '../../API/DB.php';

if (isset($_POST['import_users'])) {

  // Allowed mime types
  $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

  // Validate whether selected file is a CSV file
  if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

    // If the file is uploaded
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {

      // Open uploaded CSV file with read-only mode
      $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

      // Skip the first line
      fgetcsv($csvFile);

      // Parse data from CSV file line by line
      while (($line = fgetcsv($csvFile)) !== FALSE) {
        // Get row data

        $name   = $line[0];
        $email  = $line[1];
        $phone  = $line[2];
        $address  = $line[3];
        $status = $line[4];

        // Check whether member already exists in the database with the same email
        $prevQuery = "SELECT UserID FROM user WHERE email = '" . $line[1] . "'";
        $prevResult = mysqli_query($conn, $prevQuery);
        if (mysqli_num_rows($prevResult) > 0) {
          // Update member data in the database
          mysqli_query($conn, "UPDATE user SET FullName = '" . $name . "', UserMobileno = '" . $phone . "', UserStatus = '" . $status . "', LastEditedOn = NOW() WHERE email = '" . $email . "'");
        } else {
          // Insert member data in the database
          mysqli_query($conn, "INSERT INTO user (FullName, UserEmail, UserMobileno,UserAddress, UserStatus) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "','" . $address . "', '" . $status . "')");
        }
      }

      // Close opened CSV file
      fclose($csvFile);

      $qstring = '?status=succ';
    } else {
      $qstring = '?status=err';
    }
  } else {
    $qstring = '?status=invalid_file';
  }

  // Redirect to the listing page
  header("Location: ../users/users_list.php" . $qstring);
}

if (isset($_POST['import_battery_types'])) {
  // Allowed mime types
  $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

  // Validate whether selected file is a CSV file
  if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

    // If the file is uploaded
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {

      // Open uploaded CSV file with read-only mode
      $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

      // Skip the first line
      fgetcsv($csvFile);

      // Parse data from CSV file line by line
      while (($line = fgetcsv($csvFile)) !== FALSE) {
        // Get row data

        $BatteryType   = $line[0];
        $CarModel  = $line[1];
        $BatteryWeight  = $line[2];
        $BatterytypeStatus  = $line[3];
        // Check whether member already exists in the database with the same email
        $prevQuery = "SELECT BatterytypeID FROM batterytype WHERE BatteryType = '" . $line[0] . "'";
        // echo "SELECT BatterytypeID FROM batterytype WHERE BatteryType = '" . $line[0] . "'"; exit();
        $prevResult = mysqli_query($conn, $prevQuery);
        if (mysqli_num_rows($prevResult) > 0) {
          // Update member data in the database
          mysqli_query($conn, "UPDATE batterytype SET BatteryType = '" . $BatteryType . "', CarModel = '" . $CarModel . "', BatteryWeight = '" . $BatteryWeight . "',  BatterytypeStatus = '" . $BatterytypeStatus . "', LastEditedOn = NOW() WHERE BatteryType = '" . $BatteryType . "'");
        } else {
          // Insert member data in the database
          mysqli_query($conn, "INSERT INTO batterytype(BatteryType, CarModel, BatteryWeight, BatterytypeStatus) VALUES ('" . $BatteryType . "', '" . $CarModel . "', '" . $BatteryWeight . "','" . $BatterytypeStatus . "')");
        }
      }
      // Close opened CSV file
      fclose($csvFile);

      $qstring = '?status=succ';
    } else {
      $qstring = '?status=err';
    }
  } else {
    $qstring = '?status=invalid_file';
  }

  // Redirect to the listing page
  header("Location: ../batterytypes/battery_type_list.php" . $qstring);
}

if (isset($_POST['import_battery_services'])) {
  // Allowed mime types
  $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

  // Validate whether selected file is a CSV file
  if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

    // If the file is uploaded
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {

      // Open uploaded CSV file with read-only mode
      $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

      // Skip the first line
      fgetcsv($csvFile);

      // Parse data from CSV file line by line
      while (($line = fgetcsv($csvFile)) !== FALSE) {
        // Get row data

        $BatteryServiceTitle   = $line[0];
        $BatteryServicePrice  = $line[1];
        $BatteryServiceDescription  = $line[2];
        $BatteryServiceStatus  = $line[3];
        // Check whether member already exists in the database with the same email
        $prevResult = mysqli_query($conn,"SELECT BatteryServiceID FROM batteryservices WHERE BatteryServiceTitle = '" . $line[0] . "'");
        if (mysqli_num_rows($prevResult) > 0) {
          // Update member data in the database
          mysqli_query($conn, "UPDATE batteryservices SET BatteryServiceTitle = '" . $BatteryServiceTitle . "', BatteryServicePrice = '" . $BatteryServicePrice . "', BatteryServiceDescription = '" . $BatteryServiceDescription . "',  BatteryServiceStatus = '" . $BatteryServiceStatus . "', LastEditedOn = NOW() WHERE BatteryServiceTitle = '" . $BatteryServiceTitle . "'");
        } else {
          mysqli_query($conn, "INSERT INTO batteryservices(BatteryServiceTitle, BatteryServicePrice, BatteryServiceDescription, BatteryServiceStatus) VALUES ('" . $BatteryServiceTitle . "', '" . $BatteryServicePrice . "', '" . $BatteryServiceDescription . "','" . $BatteryServiceStatus . "')");
          //  echo "INSERT INTO batterytype(BatteryServiceTitle, BatteryServicePrice, BatteryServiceDescription, BatteryServiceStatus) VALUES ('" . $BatteryServiceTitle . "', '" . $BatteryServicePrice . "', '" . $BatteryServiceDescription . "','" . $BatteryServiceStatus . "')"; exit();
        }
      }
      // Close opened CSV file
      fclose($csvFile);

      $qstring = '?status=succ';
    } else {
      $qstring = '?status=err';
    }
  } else {
    $qstring = '?status=invalid_file';
  }

  // Redirect to the listing page
  header("Location: ../batteryservices/battery_service_list.php" . $qstring);
}

if (isset($_POST['import_carwash_type'])) {
  // Allowed mime types
  $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

  // Validate whether selected file is a CSV file
  if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

    // If the file is uploaded
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {

      // Open uploaded CSV file with read-only mode
      $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

      // Skip the first line
      fgetcsv($csvFile);

      // Parse data from CSV file line by line
      while (($line = fgetcsv($csvFile)) !== FALSE) {
        // Get row data

        $CarwashTitle   = $line[0];
        $CarwashPrice  = $line[1];
        $CarwashDescription  = $line[2];
        $CarwashStatus  = $line[3];
        // Check whether member already exists in the database with the same email
        $prevResult = mysqli_query($conn,"SELECT CarwashID FROM carwashtypes WHERE CarwashTitle = '" . $line[0] . "'");
        if (mysqli_num_rows($prevResult) > 0) {
          // Update member data in the database
          mysqli_query($conn, "UPDATE carwashtypes SET CarwashTitle = '" . $CarwashTitle . "', CarwashPrice = '" . $CarwashPrice . "', CarwashDescription = '" . $CarwashDescription . "',  CarwashStatus = '" . $CarwashStatus . "', LastEditedOn = NOW() WHERE CarwashTitle = '" . $CarwashTitle . "'");
        } else {
          mysqli_query($conn, "INSERT INTO carwashtypes(CarwashTitle, CarwashPrice, CarwashDescription, CarwashStatus) VALUES ('" . $CarwashTitle . "', '" . $CarwashPrice . "', '" . $CarwashDescription . "','" . $CarwashStatus . "')");
          //  echo "INSERT INTO batterytype(BatteryServiceTitle, BatteryServicePrice, BatteryServiceDescription, BatteryServiceStatus) VALUES ('" . $BatteryServiceTitle . "', '" . $BatteryServicePrice . "', '" . $BatteryServiceDescription . "','" . $BatteryServiceStatus . "')"; exit();
        }
      }
      // Close opened CSV file
      fclose($csvFile);

      $qstring = '?status=succ';
    } else {
      $qstring = '?status=err';
    }
  } else {
    $qstring = '?status=invalid_file';
  }

  // Redirect to the listing page
  header("Location: ../carwashtype/list.php" . $qstring);
}
