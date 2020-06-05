
<?php  include "includes/header.php"; ?>
<!-- Navigation -->
    
<?php  include "includes/navigation.php"; ?>

<?php
if(!isset($_GET['email']) && !isset($_GET['token']))
{
    Redirect('index');
}
if(isset($_POST['resetPassword']))
{
    
$inputemail =Escape($_GET['email']);
$inputtoken =Escape($_GET['token']);

if($getuserquery = mysqli_prepare($sqlconnection,"SELECT User_Name,User_Email FROM USER WHERE Token = ?"))
{
    mysqli_stmt_bind_param($getuserquery,"s",$inputtoken);
    mysqli_stmt_execute($getuserquery);
    mysqli_stmt_store_result($getuserquery);
    mysqli_stmt_bind_result($getuserquery,$username,$usermail);
    mysqli_stmt_fetch($getuserquery);
    if(mysqli_stmt_num_rows($getuserquery))
    {
        $pwd = Escape($_POST['password']);
        $confirmpwd = Escape($_POST['confirmPassword']);
        if(isset($pwd) && isset($confirmpwd)){
            if($pwd === $confirmpwd){
                $pwd = password_hash($pwd,PASSWORD_BCRYPT,array('cost' =>12));
                
                if($updatepwdquery = mysqli_prepare($sqlconnection,"UPDATE USER SET User_Password=?,Token='' WHERE User_Email=? AND Token = ?")){
                    mysqli_stmt_bind_param($updatepwdquery,"sss",$pwd,$inputemail,$inputtoken);
                    mysqli_stmt_execute($updatepwdquery);
                    mysqli_stmt_store_result($updatepwdquery);
                    if(mysqli_stmt_affected_rows($updatepwdquery))
                    {
                        echo "<h5>Password changed successfully <a href='/cms/Login'>Login Here</a></h5>";
                    }
                    else{
                        echo "Sorry, Unable to change to new password";
                    }
                }
            }
            else{
                echo "<p> Both passwords does not match";
            }
        }
        //echo $username.$usermail;
    }
    
}
}
?>
<!-- Page Content -->
<div class="container">



    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">


                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

