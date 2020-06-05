<?php
if(isset($_GET['p_id']))
{
    $editid = $_GET['p_id'];
    global $sqlconnection;
    $postquery = "SELECT * FROM POST WHERE id={$editid}";
    $allposts = mysqli_query($sqlconnection,$postquery);
    while($row = mysqli_fetch_assoc($allposts))
    {
        $postid = $row['Id'];
        $postauthorusername = $row['Post_Author_User_Name'];
        $postauthor = $row['Post_Author'];
        $posttitle = $row['Post_Title'];
        $postimage = $row['Post_Image'];
        $postcontent = $row['Post_Content'];
        $postcategory = $row['Post_Category_Id'];
        $poststatus = $row['Post_Status'];
        $posttags = $row['Post_Tags'];
        $postcomments = $row['Post_Comment_Count'];
        $postdate = $row['Post_Date'];
    }
}
if(isset($_POST['update']))
{
    $title = Escape($_POST['title']);
    $authorusername = Escape($_POST['users']);
    $author = Escape($_POST['author']);
    $catid = Escape($_POST['category']);
    $date = date('Y-m-d');
    //Image file uploaded
    $image = $_FILES['image']['name'];
     // this is temporary path where image is stored in server
    $content = Escape($_POST['content']);
    $tags = Escape($_POST['tags']);
    $comment = Escape($_POST['comment']);
    $status = Escape($_POST['status']);
    if(empty($image)){
        $image = $postimage;
    }
    else{
        $imagetemp= $_FILES['image']['tmp_name'];
        move_uploaded_file($imagetemp,"/cms/images/$image");
    }
    
    $updatepostquery = "UPDATE POST SET Post_Category_Id=$catid,Post_Title='$title',Post_Author_User_Name='$authorusername',
                        Post_Author='$author',Post_Date='$date',Post_Image='$image',Post_Content='$content',
                        Post_Tags='$tags',Post_Comment_Count=$comment,Post_Status='$status' WHERE Id=$editid";
    $updatedrows = mysqli_query($sqlconnection,$updatepostquery);
    if(!$updatedrows){
        die("Update query failed".mysqli_error($sqlconnection));
    }
    else{
        echo "<p class='bg-success col-xs-7'>Post Updated ! &emsp;<a href='../post.php?p_id={$postid}'>View Post</a> | <a href ='Posts.php'>View All Posts</a></p>";
    }
}
?>
  <form calss="form-group" method="post" enctype="multipart/form-data">
   <div class="col-xs-7">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input class="form-control" type="text" name="title" value="<?php echo $posttitle; ?>">
    </div>
    <div class="form-group">
        <label for="category">Post Category</label>
        <select id="category" name="category">
            <?php
            $categoryquery = "SELECT * FROM CATEGORY";
            $categories = mysqli_query($sqlconnection,$categoryquery);
            while($row = mysqli_fetch_assoc($categories))
            {
                $categoryid = $row['CategoryId'];
                $categorytitle = $row['CategoryTitle'];
                if($categoryid == $postcategory)
                {
                    echo "<option selected value='$categoryid'>{$categorytitle}</option>";
                }
                else{
                    echo "<option value='$categoryid'>{$categorytitle}</option>";   
                }
                
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
                if($username == $postauthorusername)
                {
                    echo "<option selected value='$username'>{$username}</option>";
                }
                else{
                    echo "<option value='$username'>{$username}</options>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Post Author</label>
        <input class="form-control" type="text" name="author" value="<?php echo $postauthor; ?>">
    </div>
    <div class="form-group">
        <img width=100 src="/cms/images/<?php echo $postimage; ?>">
    </div>
    <div class="form-group">
        <label for="image">Post Image</label>
        <input class="form-control" type="file" name="image"> 
    </div>
    <div class="form-group">
        <label for="content">Post content</label>  <!--textarea for big text box ,adjust rows and columns-->
        <textarea class="form-control" name="content" id="body" cols="35" rows="10" ><?php echo $postcontent; ?>
        </textarea>
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input class="form-control" type="text" name="tags" value="<?php echo $posttags; ?>">
    </div>
    <div class="form-group">
        <label for="status">Post Status</label>
        <select id="status" class="browser-default custom-select" name="status">
            <?php
            if(empty($poststatus)){
                echo "<option value='draft'>Draft</option>";
                echo "<option value='published'>Published</option>";
            }
            else
            {
                echo "<option value='$poststatus'>{$poststatus}</option>";
                if(strtolower($poststatus) == 'published'){
                    echo "<option value='draft'>Draft</option>";
                    echo "<option value='republished'>Republish</option>";
                }
                else{
                    echo "<option value='published'>Published</option>";   
                }
                
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="comment">Post Comment Count</label>
        <input class="form-control" type="text" name="comment" value="<?php echo $postcomments; ?>">
    </div>
    <div>
        <div class="form-group">
        <label for="date">Post Date</label>
        <input class="form-control" type=text name="date" value="<?php echo $postdate; ?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update" value="Update Post">
    </div>
   </div>
</form>