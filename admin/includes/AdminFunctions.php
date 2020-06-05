<?php
/******* Check if current user is Admin ***********/
function is_admin()
{
    global $sqlconnection;
    $currentuserid ='';
    if(IsLoggedIn())
    {
        $currentuserid = $_SESSION['userid'];
    }
    $userrolequery = "SELECT User_Role FROM USER WHERE User_Id = $currentuserid ";
    $userroleresult = mysqli_query($sqlconnection,$userrolequery);
    if($userroleresult){
        $row = mysqli_fetch_assoc($userroleresult);
        if(strtolower($row['User_Role']) ==='admin'){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
    
}
/**** Get logged in user name ************/
function GetUserName()
{
    if(isset($_SESSION['username'])){
        $user = Escape($_SESSION['username']);
        return $user;
    }
    return "";
}
/***** Get Full name of logged in User ******/
function GetUserFullName()
{
    if(isset($_SESSION['firstname']) || isset($_SESSION['lastname'])){
        $userfullname = Escape($_SESSION['firstname'])." ".Escape($_SESSION ['lastname']);
        return $userfullname;
    }
    return "LoggedIn User";
}
/**** Get current user id ****/
function GetUserId()
{
    if(IsLoggedIn()){
        return isset(($_SESSION['userid'])) ? Escape($_SESSION['userid']) : "";
    }
}
/******** Update new details to user *********/
function UpdateUser($userimage)
{
    $oldimage = $userimage;
    //$salt = $pwdsalt;
    if(isset($_POST['update_user']))
    {
        global $sqlconnection;
        $userid = Escape($_POST['userid']);
        $username = Escape($_POST['username']);
        $password = Escape($_POST['password']);
        $firstname = Escape($_POST['firstname']);
        $lastname = Escape($_POST['lastname']);
        $email = Escape($_POST['email']);
        $userrole = Escape($_POST['userrole']);
        //Image file uploaded
        $usernewimage = $_FILES['userimage']['name'];
        $userimagetemp= $_FILES['userimage']['tmp_name']; // this is temporary path where image is stored in server
        $targetdir = "C:/xampp/htdocs/cms/images/";
        $targetfile = $targetdir . basename($usernewimage);
       
        $filetype = strtolower(pathinfo($targetfile,PATHINFO_EXTENSION));
        if(empty($usernewimage)){
            $usernewimage = $oldimage;
            $filetype = strtolower(pathinfo($oldimage,PATHINFO_EXTENSION));
        }
        else{
            //$imagetemp= $_FILES['$userimage']['tmp_name'];
            move_uploaded_file($userimagetemp,"/cms/images/$usernewimage");
        }
        if(empty($password))
        {
            echo "Password cannot be empty !";
        }
        elseif($filetype !== "jpeg" && $filetype !== "jpg")
        {
            echo $filetype.' '."is incorrect image format.Upload only JPEG/JPG image!";
        }
        else
        {
            $pwdquery = "SELECT User_Password FROM USER WHERE USER_ID = $userid";
            $queryresult = mysqli_query($sqlconnection,$pwdquery);
            $row = mysqli_fetch_assoc($queryresult);
            $dbpwd= $row['User_Password'];
            if($dbpwd != $password)
            {
                $password = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
            }
            $updateuserquery = "UPDATE USER SET User_Name='$username',User_Password='$password',User_FirstName='$firstname',
            User_LastName='$lastname',User_Email='$email',User_Image='$usernewimage',User_Role='$userrole' WHERE User_Id =
            $userid";
            $updatedusers = mysqli_query($sqlconnection,$updateuserquery);
            if($updatedusers)
            {
                header("Location: Users.php");
            }
            else{
                echo "OOPS something went wrong !";
            } 
        }
    }
}

?>
