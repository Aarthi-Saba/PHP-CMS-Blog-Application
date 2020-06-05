<?php  use PHPMailer\PHPMailer\PHPMailer; ?>
<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php require 'vendor/autoload.php'; ?>
<?php require './Classes/Config.php'; ?>

<?php

if(IfMethod('get') && !isset($_GET['forgot']) )
{
    Redirect('index');
}
if(IfMethod('post')){
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        
        if(EmailExists($email)){
            if($updatetokenquery = mysqli_prepare($sqlconnection,"UPDATE USER SET TOKEN = ? WHERE User_Email = ?"))
            {
                mysqli_stmt_bind_param($updatetokenquery,"ss",$token,$email);
                mysqli_stmt_execute($updatetokenquery);
                mysqli_stmt_close($updatetokenquery);
                /******* Configure  PHP MAILER *****/
                $mail = new PHPMailer(true);
                    //Server settings
                $mail->isSMTP();                                          // Send using SMTP
                $mail->Host       = Config::SMTP_HOST;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
                $mail->Username   = Config::SMTP_USERNAME;                // SMTP username
                $mail->Password   = Config::SMTP_PASSWORD;                // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = Config::SMTP_PORT;                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8'; //To support special char needed in other language
                $mail->setFrom('samplemailaddr@gmail.com','Admin');
                $mail->addAddress($email);
                
                $mail->Subject = 'Link to forgot password';
                $mail->Body = '<p>Please click the link to reset your password</p><a href = "http://localhost:81/cms/Reset.php?email='.$email.'&token='.$token.'">http://localhost:81/cms/Reset.php?email='.$email.'&token='.$token.'</a></p>';
                if($mail->send()){
                    $emailsent = true;
                }
                else{
                    $emailsent = false;
                }
            }
        }
        else{
            echo "no such email";
        }
    }
}
?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if(!isset($emailsent)): ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                   
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                            <?php else: ?>
                                <div>
                                    <h4>Reset link sent to the given email</h4>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

