<?php  include "includes/header.php"; ?>
<?php //include "includes/Db.php" ?>
<?php
                // Load Composer's autoloader
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer;
    if(isset($_POST['send']))
    {
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $othermail = "testuser@gmail.com";
        $sender = $_POST['email'];
        $name = $_POST['username'];
        
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
        );
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 25;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Username = 'sampleemail@gmail.com';
        $mail->Password = 'samplepwd';
        $mail->setFrom('setfromusermail@gmail.com','Admin');
        $mail->addAddress($othermail,'CMS Blog');
        $mail->addReplyTo($sender,$name);
        $mail->Subject = $subject;
        $mail->Body = $message;
        //send the message, check for errors
        if (!$mail->send()) {
            echo "ERROR: " . $mail->ErrorInfo;
        } else {
            echo "Mail sent !!!!";
        }
    }

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
<html>
    <head>
        <title>CMS Blog Contact</title>
        <style>.error {color: #FF0000;}</style>
    </head>
</html> 
<body>

    <!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                         <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input type="name" name="username" id="name" class="form-control" placeholder="Enter your Name">
                            <span class="error"><?php  global $emailerr; echo $emailerr?></span>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                            <span class="error"><?php  global $emailerr; echo $emailerr?></span>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                            <span class="error"><?php  global $emailerr; echo $emailerr?></span>
                        </div>
                         <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                             <textarea name="message" id="message" class="form-control" placeholder="Enter your message" rows="10" cols="25"></textarea>
                            <span class="error"><?php  global $passworderr; echo $passworderr?></span>
                        </div>
                
                        <input type="submit" name="send" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send Message">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>

    
</body>

<?php include "includes/footer.php";?>
