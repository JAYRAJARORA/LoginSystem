<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require __DIR__ . '/../vendor/autoload.php';
require 'dbConnection.php';

if ($_POST['email']) {

    $email = $_POST['email'];
    // check if email exists
    $sql = "SELECT email from users WHERE email= '$email'";
    $query = mysqli_query($db, $sql);
    $response = [];
    // if exists update a token no and send this no along with the email
    if ($query->num_rows > 0) {
        $rand_num = mt_rand();
        $sql = "Update users set forgot_pass_id='$rand_num' where email='$email'";

        $query = mysqli_query($db, $sql);


        if ($query) {
            $response['success'] = "Reset link sent successfully";
            $reset_link = 'http://dashboard.dev/views/resetPassword.view.php?token=' . $rand_num;
            $epoch = time();
            $date = date("Y-m-d h:i:s", $epoch);
            $time_update = "Update users set token_time='$date' where email='$email'";
            $time_update_query = mysqli_query($db, $sql);
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = false;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'jayraj.arora@gmail.com';                 // SMTP username
                $mail->Password = 'jayrajarora';                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('jayraj.arora@gmail.com', 'Mailer');
                $mail->addAddress('jayraja@mindfiresolutions.com', 'Jayraj');     // Add a recipient

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Reset password link ';
                $mail->Body = ' <html>
                    <head></head>
                    <body>
                        <div>Kindly click here to change password.The link will expire in 1 hour.
                            <a href= "' . $reset_link . '">Reset Password</a>
                        </div>
                    </body>
                    </html>';


                $mail->send();


            } catch (Exception $e) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        } else {
            $response['error'] = "Unable to process your request";
        }
    } else {
        $response['error'] = "Sorry,email doesn't exists";
    }
}
echo json_encode($response);

?>

