<?php
if(isset($_POST['submit_new_post']))
{

    $posttitle = Escape($_POST['title']);
    $postcategory = Escape($_POST['category']);
    $postauthorusername = Escape($_POST['users']);
    /*$selectquery = "SELECT * FROM CATEGORY WHERE CategoryTitle=$category LIMIT 1";
    $selectedcategory = mysqli_query($sqlconnection,$selectquery);  */
    $postauthor = Escape($_POST['author']);
    $postdate = date('Y-m-d');
    //Image file uploaded
    $postimage = $_FILES['image']['name'];
    $postimagetemp= $_FILES['image']['tmp_name']; // this is temporary path where image is stored in server
    $postcontent = Escape($_POST['content']);
    $posttags = Escape($_POST['tags']);
    $poststatus = Escape($_POST['status']);
    $targetdir = "C:/xampp/htdocs/cms/images/";
    $targetfile = $targetdir . basename($postimage);
    $filetype = strtolower(pathinfo($targetfile,PATHINFO_EXTENSION));
    if($filetype == "jpeg" || $filetype == "jpg")
    {
        move_uploaded_file($postimagetemp,$targetfile);
        $insertquery = "INSERT INTO POST (Post_Category_Id,Post_Title,Post_Author_User_Name,Post_Author,Post_Date,
                        Post_Image,Post_Content,Post_Tags,Post_Status) VALUES($postcategory,'$posttitle',
                        '$postauthorusername','$postauthor','$postdate','$postimage','$postcontent','$posttags',
                        '$poststatus')";
        $insertedrows = mysqli_query($sqlconnection,$insertquery);
        if($insertedrows)
        {
            $postid = mysqli_insert_id($sqlconnection);
            echo "<p class='bg-success col-xs-7'>Post Added ! &emsp;<a href='../post.php?p_id={$postid}'>View Post</a> | <a href ='Posts.php'>View All Posts</a></p>";
        }
        else{
            echo $postcontent;
            echo "OOPS something went wrong !";
        }
    }
    else
    {
        echo "Incorrect File format.Upload only JPEG image!";
    }

}

?>
 <!-- enctype attribute is required when file upload is included in form ; method should always be post -->
  <form calss="form-group" method="post" enctype="multipart/form-data">
   <div class="col-xs-7">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input class="form-control" type="text" name="title">
    </div>
    <div class="form-group">
       <label for="category">Post Category</label>
       <select id="category" name="category">
           <?php
            $getcategoryquery = "SELECT * FROM CATEGORY";
            $category = mysqli_query($sqlconnection,$getcategoryquery);
            while($row = mysqli_fetch_assoc($category))
            {
                $categoryid = $row['CategoryId'];
                $categorytitle = $row['CategoryTitle'];
                echo "<option value='$categoryid'>{$categorytitle}</option>";
            }
            ?>
        </select>
    </div>
        <div class="form-group">
       <label for="users">Users</label>
       <select id="users" name="users">
           <?php
            $getusersquery = "SELECT * FROM USER";
            $users = mysqli_query($sqlconnection,$getusersquery);
            while($row = mysqli_fetch_assoc($users))
            {
                $userid = $row['User_Id'];
                $username = $row['User_Name'];
                echo "<option value='$username'>{$username}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Post Author</label>
        <input class="form-control" type="text" name="author">
    </div>
    <div class="form-group">
        <label for="image">Post Image</label>
        <input class="form-control" type="file" name="image"> <!-- input type is "file" as new file is uploaded here -->
    </div>
    <div class="form-group">
        <label for="content">Post content</label>  <!--textarea for big text box ,adjust rows and columns-->
        <textarea class="form-control" name="content" id="body" cols="45" rows="20"></textarea>
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input class="form-control" type="text" name="tags">
    </div>
        <div class="form-group">
        <label for="status">Post Status</label>
        <select id="" name="status">
            <option value="draft"> Select Option </option>
            <option value="draft"> Draft </option>
            <option value="published"> Publish </option>
        </select>
    </div>
        <div class="form-group">
        <label for="comment">Post Comment Count</label>
        <input class="form-control" type="text" name="comment">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="submit_new_post" value="Publish Post">
    </div>
   </div>
</form>

