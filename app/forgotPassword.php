<?php
/* Load composer's autoloader */
require __DIR__ . '/../vendor/autoload.php';
require 'dbConnection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST['email']) {

    $email = $_POST['email'];
    /* check if email exists */
    $sql = "SELECT email from users WHERE email= '$email'";
    $query = mysqli_query($db, $sql);
    $response = [];
    /* if exists update a token no and send this no along with the email */
    if ($query->num_rows > 0) {
        $rand_num = mt_rand();
        $epoch = time();
        $date = date("Y-m-d h:i:s", $epoch);
        $sql = "Update users set forgot_pass_id='$rand_num',".
            "token_time='$date' where email='$email'";

        $query = mysqli_query($db, $sql);

        if ($query) {
            $response['success'] = "Reset link sent successfully";
            $reset_link = 'http://dashboard.dev/views/resetPassword.view.php?token=' . $rand_num;
            $mail = new PHPMailer(true);
            /**Server settings:
             * Passing `true` enables exceptions,
             * Enable verbose debug output
             * Set mailer to use SMTP,
             * Set mailer to use SMTP
             * Specify main and backup SMTP servers,
             * Enable SMTP authentication,
             * SMTP username and password,
             * Enable TLS encryption,
             * `ssl` also accepted
             * TCP port to connect to
             **/
            try {
                $mail->SMTPDebug = false;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jayraj.arora@gmail.com';
                $mail->Password = 'jayrajarora';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                /*Recipients */
                $mail->setFrom('jayraj.arora@gmail.com', 'Mailer');
                /* add a recipient */
                $mail->addAddress($email, 'Jayraj');

                /*Content : set email format to HTML */
                $mail->isHTML(true);
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



