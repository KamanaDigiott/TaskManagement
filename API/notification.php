<?php
include('DB.php');
$errors = [];
$data = [];
$records = [];
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save') {
        $user_id = $_POST['user'];
        $detail = $_POST['detail'];
        $description = $_POST['description'];

        if (isset($_POST['id'])) {
            $update = "update notification set user_id='$user_id', NotificationTitle='$detail', NotificationDescription='$description', LastEditedOn=now() where NotificationID ='" . $_POST['id'] . "'";
            if (mysqli_query($conn, $update)) {
                $data['success'] = true;
                $data['message'] = 'notification Updated Successfully...!';
            }
        } else {
            $query1 = "insert INTO notification(user_id ,NotificationTitle,NotificationDescription) values('$user_id','$detail','$description')";
            if (mysqli_query($conn, $query1)) {
                $data['success'] = true;
                $data['message'] = 'notification Added Successfully...!';
            }
        }
        // if (isset($data['success'])) {
        //     if ($user_id == 'all') {
        //         $select_query = "SELECT * FROM `user`";
        //         $resp = mysqli_query($conn, $select_query);
        //         $email = 'kamana.4699@gmail.com';
        //         $from = 'nilanjana3798@gmail.com';
        //         $subject = "Email Verification";
        //         $body = "Hi, kamana Click here too activate your account ";
        //         $headers  = "MIME-Version: 1.0" . "\r\n";
        //         $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        //         $headers .= "From: " . $from . "\r\n";
        //         $headers .= "Reply-To: " . $from . "\r\n";
        //         $headers .= "X-Mailer: PHP/" . phpversion();
        //         $headers .= "X-Priority: 1" . "\r\n";
        //         // $mail =  mail($email, $subject, $body, $headers);
        //         // if (!mail($email, $subject, $body, $headers)) {
        //         //     print_r(error_get_last());
        //         //   }
        //         //   else {
        //         //    echo '<h3 style="color:#d96922; font-weight:bold; height:0px; margin-top:1px;">Thank You For Contacting us!!</h3>';

        //         //   }
        //         // mail($to, $subject, $message, $headers);
        //         //     if (mail($email, $subject, $body, $headers)) {
        //         //          $data["message"] = "Email Successfully Sent To $email Please Verify Your Email";
        //         //     } else {
        //         //           $data["message"] = "Email gg sending failed...";
        //         //     }
        //         //   while($row=mysqli_fetch_assoc($resp)){

        //         //   }
        //     } else {
        //         $select_query2 = "SELECT * FROM `user`  WHERE  UserID ='" . $_POST['user'] . "' ";
        //         $resp2 = mysqli_query($conn, $select_query2);
        //         $email = 'kamana.4699@gmail.com';
        //         $from = 'nilanjana3798@gmail.com';
        //         $subject = "Email Verification";
        //         $body = "Hi, kamana Click here too activate your account ";
        //         $headers  = "MIME-Version: 1.0" . "\r\n";
        //         $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        //         $headers .= "From: " . $from . "\r\n";
        //         $headers .= "Reply-To: " . $from . "\r\n";
        //         $headers .= "X-Mailer: PHP/" . phpversion();
        //         $headers .= "X-Priority: 1" . "\r\n";
        //         if (!mail($email, $subject, $body, $headers)) {
        //             print_r(error_get_last());
        //           }
        //           else {
        //            echo '<h3 style="color:#d96922; font-weight:bold; height:0px; margin-top:1px;">Thank You For Contacting us!!</h3>';

        //           }
        //         //     if (mail($email, $subject, $body, $headers)) {
        //         //          $data["message"] = "Email Successfully Sent To $email Please Verify Your Email";
        //         //     } else {
        //         //            $data["message"] = "Email fg sending failed...";
        //         //     }
        //         //   while($row=mysqli_fetch_assoc($resp2)){

        //         //   }
        //     }
        // }
        echo json_encode($data);
    }
}
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'all_notification') {
        $query = "select u.FullName,u.UserID,n.* from notification as n left join user as u on u.UserID=n.user_id order by NotificationID desc";

        $res = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($res)) {
            if (is_null($row['DeletedOn'])) {
                $data['data'][] = $row;
                $data['success'] = true;
            }
        }
        echo json_encode($data);
    }

    if ($_GET['action'] == 'notification_id') {
        $query = "select u.FullName,u.UserID, n.* from notification as n left join user as u on u.UserID=n.user_id  where n.NotificationID='" . $_GET['id'] . "' order by n.NotificationID desc";
        $res = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($res)) {
            if (is_null($row['DeletedOn'])) {
                $data['data'] = $row;
                $data['success'] = true;
            }
        }
        echo json_encode($data);
    }

    if ($_GET['action'] == 'notification_get3') {
        $query = "select u.FullName,u.UserID, n.* from notification as n left join user as u on u.UserID=n.user_id order by n.NotificationID desc limit 3";
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
        $query = "select * from notification where NotificationID='" . $_GET['id'] . "'";
        $res = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($res);
        $data['data'] = $row;
        $data['success'] = true;
        echo json_encode($data);
    }

    if ($_GET['action'] == 'delete') {
        $update = "update notification set DeletedOn=now() where NotificationID='" . $_GET['id'] . "'";
        if (mysqli_query($conn, $update)) {
            $data['success'] = true;
            $data['message'] = 'notification Deleted Successfully...!';
        }
        echo json_encode($data);
    }

    if ($_GET['action'] == 'active') {
        $status = "select * from notification where NotificationID='" . $_GET['id'] . "'";
        $res = mysqli_query($conn, $status);
        $row = mysqli_fetch_assoc($res);
        if ($row['NotificationStatus'] == '1') {
            $update = "update notification set NotificationStatus='0' where NotificationID='" . $_GET['id'] . "'";
            if (mysqli_query($conn, $update)) {
                $data['success'] = true;
                $data['message'] = 'notification Status Updated Successfully...!';
            }
        } else {
            $update = "update notification set NotificationStatus='1' where NotificationID='" . $_GET['id'] . "'";
            if (mysqli_query($conn, $update)) {
                $data['success'] = true;
                $data['message'] = 'notification Status Updated Successfully...!';
            }
        }

        echo json_encode($data);
    }
}
