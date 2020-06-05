<?php  include "includes/header.php"; ?>
<!-- Navigation -->
    
<?php  include "includes/navigation.php"; ?>

<?php
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $error = ['usernameerr'=>'','emailerr'=>'','passworderr'=>''];
        //$usernameerr = $emailerr = $passworderr ="";
        $error = CheckForErrors($username,$email,$password,$error);
        
        foreach($error as $key => $value){
            if(empty($value)){
                unset($error[$key]);
            }
        }
        if(empty($error))// && empty($emailerr) &&empty($passworderr))
        {
            global $sqlconnection;
            $username = mysqli_real_escape_string($sqlconnection,$username);
            $useremail = mysqli_real_escape_string($sqlconnection,$email);
            $password = mysqli_real_escape_string($sqlconnection,$password);
            if(UserExists($username)){
                die("User Already Exists !");
            }
            if(EmailExists($useremail)){
                die("Email already registered");
            }
            /*$randsaltquery = "SELECT RANDSALT FROM USER LIMIT 1";
            $randsalt = mysqli_query($sqlconnection,$randsaltquery);
            $row = mysqli_fetch_assoc($randsalt);
            $pwdsalt = $row['RANDSALT']; 
            $password = crypt('$password','$pwdsalt');*/
           $password = password_hash($password,PASSWORD_BCRYPT,array('cost' => 12));
            $insertnewuserquery = "INSERT INTO USER (User_Name,User_Password,User_Email) VALUES                                             ('$username','$password','$useremail')";
            $insertednewuser = mysqli_query($sqlconnection,$insertnewuserquery);
            if($insertednewuser){
                echo "<h3>Registered !!!</h3>";
            }
            else{
                echo "Registration failed";
            } 
        }
    }
?>


    
<html>
    <head>
        <title> CMS BLog Registration</title>
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
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username)?$username :''?>">
                            <span class="error"><?php  echo isset($error['usernameerr']) ? ($error['usernameerr']) :''?></span>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email)? $email :''?>">
                            <span class="error"><?php  echo isset($error['emailerr']) ? ($error['emailerr']) :'' ?></span>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <span class="error"><?php  echo isset($error['passworderr']) ? ($error['passworderr']) :''?></span>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>

    
</body>

<?php include "includes/footer.php";?>
