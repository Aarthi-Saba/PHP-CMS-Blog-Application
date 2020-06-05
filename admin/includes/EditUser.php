<!-- enctype attribute is required when file upload is included in form ; method should always be post -->
<?php
if(isset($_GET['u_id']))
{
    $usereditid = $_GET['u_id'];
    global $sqlconnection;
    $selectuserquery = "SELECT * FROM USER WHERE User_Id={$usereditid}";
    $user = mysqli_query($sqlconnection,$selectuserquery);
    while($row = mysqli_fetch_assoc($user))
    {
            $userid = $row['User_Id'];
            $username = $row['User_Name'];
            $userpassword = $row['User_Password'];
            $userfirstname= $row['User_FirstName'];
            $userlastname = $row['User_LastName'];
            $useremail = $row['User_Email'];
            $userimage = $row['User_Image'];
            $userrole = $row['User_Role'];
            //$pwdsalt=$row['RandSalt'];
    }
}
else
{
    header("Location: index");
    
}
?>
  <form calss="form-group" method="post" enctype="multipart/form-data">
   <div class="col-xs-6">
   <div class="form-group">
        <label for="title">User Id</label>
        <input class="form-control" type="text" name="userid" value="<?php echo $userid; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="title">User Name</label>
        <input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="form-group">
       <label for="category">Password</label>
       <input class="form-control" type="password" autocomplete="off" name="password" value="<?php echo $userpassword?>" readonly>
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
        <?php echo "<img width=100 src='/cms/images/$userimage' alt=image>"?>
    </div>
    <div class="form-group">
        <label for="image">Profile Image</label>
        <input class="form-control" type="file" name="userimage"> <!-- input type is "file" as new file is uploaded here -->
    </div>
    <div class="form-group">
       <label for="userrole">Role</label>
        <select id="userrole" name="userrole">
            <option value="subscriber"><?php echo $userrole; ?></option>
            <?php
            if(strtolower($userrole) == 'admin'){
                echo "<option value='Subscriber'>Subscriber</option>";
            }
            else{
                echo "<option value='Admin'>Admin</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User Profile">
    </div>
 </div>
</form>
<?php
//UpdateUser($userimage,$pwdsalt);
UpdateUser($userimage);
?>