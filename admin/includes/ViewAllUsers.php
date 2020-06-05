<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>User Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Profile Image</th>
            <th>Role</th>
            <th style="text-align:center" colspan=2>Roles</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
       <?php 
        global $sqlconnection;
        $alluserquery = mysqli_prepare($sqlconnection,"SELECT User_Id,User_Name,User_FirstName,User_LastName,User_Email,
                            User_Image,User_Role FROM USER");
        mysqli_stmt_execute($alluserquery);
        mysqli_stmt_bind_result($alluserquery,$userid,$username,$userfirstname,$userlastname,$useremail,
                                            $userimage,$userrole);
        mysqli_stmt_store_result($alluserquery);
        if(mysqli_stmt_num_rows($alluserquery)>=1)
        {
            while(mysqli_stmt_fetch($alluserquery))
            {
           ?>

               <?php
                echo "<tr>";
                echo "<td>$userid</td>";
                echo "<td>$username</td>";
                echo "<td>$userfirstname</td>";
                echo "<td>$userlastname</td>";
                echo "<td>$useremail</td>";
                echo "<td><img width=100 src = '/cms/images/$userimage' alt='image'></td>";
                echo "<td>$userrole</td>";
                echo "<td> <a href='Users.php?change_to_admin={$userid}'>Admin</a></td>";
                echo "<td> <a href='Users.php?change_to_subscriber={$userid}'>Subscribe</a></td>"; 
                echo "<td> <a href='Users.php?source=edit_user&u_id={$userid}'>EDIT</a></td>";
                echo "<td> <a href='Users.php?delete={$userid}'>DELETE</a></td>"; 
                echo "</tr>";
                }
         }
        else{
            echo "No users to display";
        }
            ?>
    </tbody>
</table>
<?php
if(isset($_GET['change_to_admin']))
{
    $userid = Escape($_GET['change_to_admin']);
    $adminquery = "UPDATE USER SET User_Role='Admin' WHERE User_id=$userid ";
    $approvedadmin= mysqli_query($sqlconnection,$adminquery);
    header("Location: Users.php");
    exit;

}
if(isset($_GET['change_to_subscriber']))
{
    $userid = Escape($_GET['change_to_subscriber']);
    $subscriberquery = "UPDATE USER SET User_Role='Subscriber' WHERE User_id=$userid  ";
    $approvedsubscriber = mysqli_query($sqlconnection,$subscriberquery);
    header("Location: Users.php");
    exit;
}
if(isset($_GET['delete']))
{
    if(is_admin())
    {            
        $deleteuserid = mysqli_real_escape_string($sqlconnection,$_GET['delete']);
        $deleteuserquery = "DELETE FROM USER WHERE User_Id=$deleteuserid";
        $deleteduser = mysqli_query($sqlconnection,$deleteuserquery);
        header("Location: Users.php"); 
        exit;
    }
   
}
?>    