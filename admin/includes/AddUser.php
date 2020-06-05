<!-- enctype attribute is required when file upload is included in form ; method should always be post -->
<form calss="form-group" method="post" enctype="multipart/form-data">
   <div class="col-xs-6">
    <div class="form-group">
        <label for="title">User Name</label>
        <input class="form-control" type="text" name="username">
    </div>
    <div class="form-group">
       <label for="category">Password</label>
       <input class="form-control" type="password" name="password">
    </div>
    <div class="form-group">
        <label for="author">First Name</label>
        <input class="form-control" type="text" name="firstname">
    </div>
    <div class="form-group">
        <label for="author">Last Name</label>
        <input class="form-control" type="text" name="lastname">
    </div>
    <div class="form-group">
        <label for="status">Email Id</label>
        <input class="form-control" type="text" name="email">
    </div>
    <div class="form-group">
        <label for="image">Profile Image</label>
        <input class="form-control" type="file" name="userimage"> <!-- input type is "file" as new file is uploaded here -->
    </div>
    <div class="form-group">
       <label for="userrole">Role</label>
        <select id="userrole" name="userrole">
            <option value="">Select Option</option>
            <option value='Subscriber'>Subscriber</option>
            <option value='Admin'>Admin</option>
        </select>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="new_user" value="Register User">
    </div>
 </div>
</form>
<?php
if(isset($_POST['new_user']))
{

    $username = Escape($_POST['username']);
    $password = Escape($_POST['password']);
    $firstname = Escape($_POST['firstname']);
    $lastname = Escape($_POST['lastname']);
    $email = Escape($_POST['email']);
    $userrole = Escape($_POST['userrole']);
    if(empty($userrole)){
        $userrole = 'Subscriber';
    }
    //Image file uploaded
    $userimage = $_FILES['userimage']['name'];
    $userimagetemp= $_FILES['userimage']['tmp_name']; // this is temporary path where image is stored in server
    $targetdir = "C:/xampp/htdocs/cms/images/";
    $targetfile = $targetdir . basename($userimage);
    $filetype = strtolower(pathinfo($targetfile,PATHINFO_EXTENSION));
    if(!empty($userimage) && $filetype == "jpeg" || $filetype == "jpg")
    {
        move_uploaded_file($userimagetemp,$targetfile);
        $password = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
        $insertuserquery = "INSERT INTO USER (User_Name,User_Password,User_FirstName,User_LastName,User_Email,
                            User_Image, User_Role) VALUES ('$username','$password','$firstname','$lastname',
                            '$email','$userimage','$userrole')";
        $insertedusers = mysqli_query($sqlconnection,$insertuserquery);
        if($insertedusers)
        {
            echo "User Created Successfully" . " " . "<a href = 'Users.php'>View All Users</a>";
        }
        else{
            echo "OOPS something went wrong !";
        }
    }
    else
    {
        echo "Incorrect File format.Upload only JPEG image!";
    }
}

?>