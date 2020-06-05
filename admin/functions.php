<?php
/**** function to escape special char to prevent SQL injection ****/
function Escape($inputstring)
{
    global $sqlconnection;
    return mysqli_real_escape_string($sqlconnection,$inputstring);
    
}

/**** Admin index page : Count for each table ******/
function TotalRecords($tablename){
    global $sqlconnection;
    $getrecordsquery = mysqli_prepare($sqlconnection,"SELECT * FROM $tablename") ;
    mysqli_stmt_execute($getrecordsquery);
    mysqli_stmt_store_result($getrecordsquery);
    //$result = mysqli_query($sqlconnection,$getrecordsquery);
    $recordcount = mysqli_stmt_num_rows($getrecordsquery);
    if($recordcount < 1){
        die("total record Query failed".mysqli_error($sqlconnection));
    }
    mysqli_stmt_close($getrecordsquery);
    return $recordcount;
}

/******** Calculate Chart values for different conditions ***********/
function ChartValues($tablename,$colname,$condition)
{
    global $sqlconnection;
    $specificrecordsquery = "SELECT * FROM $tablename WHERE LOWER($colname) = '$condition'";
    $specificrecords = mysqli_query($sqlconnection,$specificrecordsquery);
    $specificrecordscount = mysqli_num_rows($specificrecords);
    if(!$specificrecordscount){
        echo $tablename." ".$colname." ".$condition;
        die("Chart values Query failed".mysqli_error($sqlconnection));
    }
    return $specificrecordscount;
}
/****** Check if user already exists before registering ***/
function UserExists($inputusername)
{
    global $sqlconnection;
    $usernamequery = mysqli_prepare($sqlconnection,"SELECT * FROM USER WHERE USER_NAME = ?");
    mysqli_stmt_bind_param($usernamequery,"s",$inputusername);
    mysqli_stmt_execute($usernamequery);
    mysqli_stmt_store_result($usernamequery);
    $result = mysqli_stmt_num_rows($usernamequery);
    if($result)
    {
        return true;
    }
    else{
        return false;
    }
    mysqli_stmt_close($usernamequery);
    
}
function EmailExists($inputemail)
{
    global $sqlconnection;
    
    $useremailquery = mysqli_prepare($sqlconnection,"SELECT * FROM USER WHERE USER_EMAIL = ?");
    mysqli_stmt_bind_param($useremailquery,"s",$inputemail);
    mysqli_stmt_execute($useremailquery);
    mysqli_stmt_store_result($useremailquery);
    $records= mysqli_stmt_num_rows($useremailquery);
    if($records)
    {
        return true;
    }
    else{
        return false;
    }
    mysqli_stmt_close($useremailquery);
}
/******* -- check for errors -Registration form **************/
function CheckForErrors($inputname,$inputmail,$inputpwd,$error)
{
    global $error;
    if(empty($inputname))
    {
        $error['usernameerr'] = "User name cannot be empty";
    }
    if(empty($inputmail))
    {
        $error['emailerr'] = "User email cannot be empty";
    }
    if(empty($inputpwd))
    {
        $error['passworderr'] = "Password cannot be empty";
    }
    if(strlen($inputname) < 4){
         $error['usernameerr'] = "User name too short";

    }
    if(strlen($inputpwd) < 4){
         $error['passworderr'] = "Password is too short";

    }
    return $error;
}


/****** Check if given method is form method **********/
function IfMethod($method=null)
{
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method))
    {
        return true;
    }
    else
    {
        return false;
    }
}


/**** Redirect to given path **/
function Redirect($redirectloc = null){
    header("Location:" . $redirectloc);
    exit;
}


/***** Check if user is logged in  ***/
function IsLoggedIn(){
    if(isset($_SESSION['userrole'])){
        return true;
    }
    return false;
}

/****Check if user is logged in and redirect to given location *****/
function IsLoggedInAndRedirect($redirectlocation=null){
    if(IsLoggedIn()){
        Redirect($redirectlocation);
    }
}

/*********** Login User ************/
function LoginUser($loginusername,$loginpassword)
{
    global $sqlconnection;
    $selectquery = mysqli_prepare($sqlconnection,"SELECT User_Id,User_Name,User_Password,User_FirstName,User_LastName,
                                            User_Email,User_Image,User_Role FROM USER WHERE User_Name = ?");
    mysqli_stmt_bind_param($selectquery,"s",$loginusername);
    mysqli_stmt_execute($selectquery);
    mysqli_stmt_bind_result($selectquery,$userid,$username,$userpassword,$userfirstname,$userlastname,$useremail,
                            $userimage,$userrole);
    mysqli_stmt_store_result($selectquery);
    $selecteduser = mysqli_stmt_num_rows($selectquery);
    mysqli_stmt_fetch($selectquery);
    if($selecteduser == 0)
    { 
        die("No such user exists".mysqli_error($sqlconnection));
    }
    else
    {
        if(password_verify($loginpassword,$userpassword))
        {
            $_SESSION['userid'] = $userid;
            $_SESSION['username'] = $username;
            $_SESSION['firstname'] = $userfirstname;
            $_SESSION['lastname'] = $userlastname;
            $_SESSION['userrole'] = $userrole;  
            Redirect('/cms/admin');
        }
        else{
            
            return false;
        }
        return true;
    }
}

/****** Check If Logged user liked given post******/
function IsPostLikedByUser($currentpost=""){
    global $sqlconnection;
    $currentuser = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
    $postfetchquery = mysqli_prepare($sqlconnection,"SELECT USERID,POSTID FROM LIKES WHERE POSTID = ? AND USERID = ?");
    mysqli_stmt_bind_param($postfetchquery,"ii",$currentpost,$currentuser);
    mysqli_stmt_execute($postfetchquery);
    mysqli_stmt_store_result($postfetchquery);
    if(mysqli_stmt_affected_rows($postfetchquery)){
        return true;
    }
    else{
        return false;
    }
}
/***** Add new Category ***********/
function AddCategory()
{
    global $sqlconnection;
    if(isset($_POST['submit']))
    {
        $newtitle = Escape($_POST['category_title']);
        if($newtitle == "" || empty($newtitle)){
            echo "Category to be added cannot be empty";
        }
        else{
            
            $addquery = mysqli_prepare($sqlconnection,"INSERT INTO category (CategoryTitle) VALUES (?) ");
            mysqli_stmt_bind_param($addquery,"s",$newtitle);
            mysqli_stmt_execute($addquery);
            if($addquery){
                echo "$newtitle category added successfully !!";
            }
            else{
                die("Error in DB query".mysqli_error($sqlconnection));
            }
            mysqli_stmt_close($addquery);
        }

    }
}
/********** Display All categories *************/
function ShowCategory()
{
    global $sqlconnection;
    $selectquery = mysqli_prepare($sqlconnection,"SELECT CategoryId,CategoryTitle FROM CATEGORY");
    mysqli_stmt_execute($selectquery);
    mysqli_stmt_bind_result($selectquery,$id,$title);
    //$selectedrows = mysqli_query($sqlconnection,$selectquery);
    while(mysqli_stmt_fetch($selectquery))
    {
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$title}</td>";
        echo "<td> <a href='Categories.php?delete={$id}'>Delete</a> </td>";
        echo "<td> <a href='Categories.php?edit={$id}'>Edit</a> </td>";
        echo "</tr>";
    } 
    mysqli_stmt_close($selectquery);
}
/******** Delete the selected category *************/
function DeleteCategory()
{
    global $sqlconnection;
    if(isset($_GET['delete']))
    {
        $deleteid = Escape($_GET['delete']);
        $deletequery = mysqli_prepare($sqlconnection,"DELETE FROM CATEGORY WHERE CategoryId = ?");
        mysqli_stmt_bind_param($deletequery,"i",$deleteid);
        mysqli_stmt_execute($deletequery);
        if($deletequery){
            echo "Category deleted";
            header("Location: Categories.php");
            exit;
        }
        else{
            die("Delete query failed".mysqli_error($sqlconnection));
        }
        mysqli_stmt_close($deletequery);
    }
}
/***** Count no of users online ,using session detail and current time ***********/
function Users_Online()
{
    if(isset($_GET['onlineusers']))
    {
        global $sqlconnection;
        if(!$sqlconnection)
        {
            session_start();
            include("../includes/Db.php"); 
            $session =Escape(session_id());// Get current session's id
            $time = time();
            $timeoutsecs = 05;
            $timeout = $time - $timeoutsecs;
            $usersessionquery =mysqli_prepare($sqlconnection,"SELECT * FROM USERS_ONLINE WHERE SESSION = ?");
            mysqli_stmt_bind_param($usersessionquery,"s",$session);
            mysqli_stmt_execute($usersessionquery);
            mysqli_stmt_store_result($usersessionquery);
            $rowcount = mysqli_stmt_num_rows($usersessionquery);
            if($rowcount == NULL){
                $insertonlinequery = mysqli_prepare($sqlconnection,"INSERT INTO USERS_ONLINE (SESSION,TIME) VALUES (?,?) ");
                $bindparam= mysqli_stmt_bind_param($insertonlinequery,"si",$session,$time);
                $result =mysqli_stmt_execute($insertonlinequery);
            }
            else{
                $updateonlinequery = mysqli_prepare($sqlconnection,"UPDATE USERS_ONLINE SET TIME=? WHERE SESSION = ?");
                mysqli_stmt_bind_param($updateonlinequery,"is",$time,$session);
                mysqli_stmt_execute($updateonlinequery);
            }                                                                   
            $useronlinequery = mysqli_prepare($sqlconnection,"SELECT * FROM USERS_ONLINE WHERE TIME > ?");
            mysqli_stmt_bind_param($useronlinequery,"i",$timeout);
            mysqli_stmt_execute($useronlinequery);
            mysqli_stmt_store_result($useronlinequery);
            echo $usersonline = mysqli_stmt_num_rows($useronlinequery);
        }
    }
}
Users_Online();
?>