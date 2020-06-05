<?php 
include "includes/AdminHeader.php";
?>

<?php
if(isset($_SESSION['userid']))
{
    $loginuserid = $_SESSION['userid'];
    $selectuserquery = "SELECT * FROM USER WHERE User_Id={$loginuserid}";
    $user = mysqli_query($sqlconnection,$selectuserquery);
    while($row = mysqli_fetch_assoc($user))
    {
            $usereditid = $row['User_Id'];
            $username = $row['User_Name'];
            $userpassword = $row['User_Password'];
            $userfirstname= $row['User_FirstName'];
            $userlastname = $row['User_LastName'];
            $useremail = $row['User_Email'];
            $userimage = $row['User_Image'];
            $userrole = $row['User_Role'];
            //$pwdsalt = $row['RandSalt'];
    }
}
?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/AdminNavigation.php"; ?>
        
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">User Profile</h3>
                    </div>
                </div>
                <!-- /.row -->
                  <form calss="form-group" method="post" enctype="multipart/form-data">
                   <div class="col-xs-6">
                   <div class="form-group">
                        <label for="title">User Id</label>
                        <input class="form-control" type="text" name="userid" value="<?php echo $usereditid; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="title">User Name</label>
                        <input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group">
                       <label for="category">Password</label>
                       <input class="form-control" type="password" autocomplete="off" name="password" value="<?php echo $userpassword; ?>">
                    </div>
                    <div class="form-group">
                        <label for="author">First Name</label>
                        <input class="form-control" type="text" name="firstname" value="<?php echo $userfirstname; ?>">
                    </div>
                    <div class="form-group">
                        <label for="author">Last Name</label>
                        <input class="form-control" type="text" name="lastname" value="<?php echo $userlastname; ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Email Id</label>
                        <input class="form-control" type="text" name="email" value="<?php echo $useremail; ?>">
                    </div>
                    <div class="form-group">
                        <?php echo "<img width=100 src='/cms/images/$userimage' alt=image'>"?>
                    </div>
                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <input class="form-control" type="file" name="userimage"> <!-- input type is "file" as new file is uploaded here -->
                    </div>
                    <div class="form-group">
                        <label for="userrole">Role</label>
                        <input class="form-control" type="text" name="userrole" value="<?php echo $userrole; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="update_user" value="Update Profile">
                    </div>
                 </div>
                </form>
            </div>
            <!-- /.container-fluid -->
            <?php 
            //UpdateUser($userimage,$pwdsalt); 
            UpdateUser($userimage);?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/AdminFooter.php" ?>
