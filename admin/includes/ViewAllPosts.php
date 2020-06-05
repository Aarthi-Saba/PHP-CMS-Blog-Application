<?php
include "DeleteModal.php";
if(isset($_POST['checkBoxArray']))
{
    /*foreach($_POST['checkBoxArray'] as $checkBox){
        $bulkoptions = $_POST['bulk_options'];
    }
    */
    $bulkids = join(",",$_POST['checkBoxArray']);    
    $bulkoptions = Escape($_POST['bulk_options']);
    if($bulkoptions === 'clone')
    {
        $clonebulkquery = "INSERT INTO POST (Post_Category_Id,Post_Title,Post_Author,Post_Date,Post_Image,Post_Content,                        Post_Tags,Post_Comment_Count,Post_Status) SELECT Post_Category_Id, Post_Title, Post_Author,
                           Post_Date,Post_Image, Post_Content,Post_Tags,Post_Comment_Count,Post_Status FROM Post WHERE ID IN ($bulkids)";
        $clonedrows = mysqli_query($sqlconnection,$clonebulkquery);
        if(!$clonedrows)
        {
            die("INSERT INTO QUERY FAILED".mysqli_error($sqlconnection));
        }
        else
        { ?>
             <p class='bg-success col-xs-3'> <?php echo mysqli_affected_rows($sqlconnection) .' '?>Posts have been Cloned</p>
         <?php            
        }
        
    }
    elseif($bulkoptions !== 'delete')
    {
        $updatebulkquery = "UPDATE POST SET POST_STATUS = '{$bulkoptions}' WHERE ID IN ($bulkids) ";
        $updatedbulkrows = mysqli_query($sqlconnection,$updatebulkquery);
        if(!$updatedbulkrows){
            die("Query failed".mysqli_error($sqlconnection));
        }
        else
        { ?>
             <p class='bg-success col-xs-3'> <?php echo mysqli_affected_rows($sqlconnection) .' '?>Posts have been updated</p>
         <?php
        }
    }
    else
    {
        $deletebulkquery = "DELETE FROM POST WHERE Id IN ($bulkids)";
        $deletedbulkrows = mysqli_query($sqlconnection,$deletebulkquery);
        if(!$deletedbulkrows)
        {
            die("Delete query failed".mysqli_error($sqlconnection));
        }
        else
        { ?>
           <p class='bg-success col-xs-3'> <?php echo mysqli_affected_rows($sqlconnection) . ' ' ?> Posts have been deleted </p>
        <?php
        }
    }
}
?>
  <form action="" method="post">
   <table class="table table-bordered table-hover">
     <thead>
       <tr>
         <td colspan="13" style="border-color:white white light-grey white;">
               <div id="bulkOptionContainer" class="col-xs-2" style="padding:0px">
                   <select class="form-control" name="bulk_options" id="">
                       <option value="">Select Option</option>
                       <option value="published">Publish</option>
                       <option value="republished">Republish</option>
                       <option value="draft">Draft</option>
                       <option value="delete">Delete</option>
                       <option value="clone">Clone</option>
                   </select>
               </div>

                  <p>
                   <input class="btn btn-success" type="submit" name="submit" value="Apply"> 
                   <a class="btn btn-primary" href ="Posts.php?source=add_post">Add New Post</a>
                   </p>
         </td>
       </tr>
    
        <tr>
           <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Image</th>
            <th>Category</th>
            <th>Status</th>
            <th>Tags</th>
            <th rowspan="2" width='10%' >Total Comments</th>
            <th style="width : 10%">Date</th>
            <th style="width : 8%">View Count</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
       <?php 
        global $sqlconnection;
        //$postquery = "SELECT * FROM POST ORDER BY ID DESC";
        $postjoinquery = "SELECT POST.Id,POST.Post_Category_Id,POST.Post_Title,POST.Post_Author,POST.Post_Date,
                         POST.Post_Image,POST.Post_Content,POST.Post_Tags,POST.Post_Comment_Count,POST.Post_Status,
                         POST.Post_Views_Count,CATEGORY.CategoryId,CATEGORY.CategoryTitle FROM POST LEFT JOIN CATEGORY
                         ON POST.Post_Category_Id = CATEGORY.CategoryId ORDER BY POST.Id DESC";
        $allposts = mysqli_query($sqlconnection,$postjoinquery);
        while($row = mysqli_fetch_assoc($allposts))
        {
            $postid = $row['Id'];
            $postauthor = $row['Post_Author'];
            $posttitle = $row['Post_Title'];
            $postimage = $row['Post_Image'];
            $postcategory = $row['Post_Category_Id'];
            $poststatus = $row['Post_Status'];
            $posttags = $row['Post_Tags'];
            $postcomments = $row['Post_Comment_Count'];
            $postdate = $row['Post_Date'];
            $postviewcount = $row['Post_Views_Count'];
            $categoryid = $row['CategoryId'];
            $categorytitle = $row['CategoryTitle'];
            echo "<tr>";
            ?> <!-- Checkbox array is added with posts id that are chosen -->
            <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $postid ?>"></td>
            <?php 
            echo "<td>$postid</td>";
            echo "<td>$postauthor</td>";
            echo "<td> <a href='../post.php?p_id={$postid}'>$posttitle</a></td>";
            echo "<td><img width='100' src = '/cms/images/$postimage' alt='image'></td>";
            echo "<td>$categorytitle</td>";
            echo "<td>$poststatus</td>";
            echo "<td>$posttags</td>";
            echo "<td>$postcomments <a href='PostsComments.php?cp_id={$postid}'>Comments</a></td>";
            echo "<td>$postdate</td>";
            echo "<td>$postviewcount :<a href='Posts.php?reset={$postid}'>Reset</a></td>";
            echo "<td> <a class='btn btn-info' href='Posts.php?source=edit_post&p_id={$postid}'>Edit</a></td>"; ?>
            <form method="post">
                <input type="hidden" name="postid" value="<?php echo $postid ?>">
                <td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>
            </form>
            <?php
            //echo "<td> <a href='javascript:void(0)' rel='$postid' class='delete_link'>Delete</td>";
            //echo "<td> <a onClick=\"javascript: return confirm('Are you sure want to Delete this post?');\" href='Posts.php?delete={$postid}'>Delete</a></td>"; 
            echo "</tr>";
            }
            ?>
    </tbody>
   </table>
</form>
<?php
if(isset($_POST['delete']))
{
    if(is_admin())
    {
        $deleteid = Escape($_POST['postid']);
        $deletepostquery = "DELETE FROM POST WHERE Id=$deleteid";
        $deletedrows = mysqli_query($sqlconnection,$deletepostquery);

        if(!$deletedrows)
        {
            die("Delete query failed".mysqli_error($sqlconnection));
        }
        else{
            header("Location: Posts.php");
            exit;
        }
    }
    
    
}
if(isset($_GET['reset']) && is_admin())
{
    $resetid = Escape($_GET['reset']);
    $viewresetquery = "UPDATE POST SET Post_Views_Count =0 WHERE Id=".mysqli_real_escape_string($sqlconnection,$resetid);
    $resetrows = mysqli_query($sqlconnection,$viewresetquery);
    
    if(!$resetrows)
    {
        die("Reset query failed".mysqli_error($sqlconnection));
    }
    else{
        header("Location: Posts.php");
        exit;
    }
    
}
?>

<script>
$(document).ready(function(){
    $(".delete_link").on('click',function(){
        var id = $(this).attr('rel');
        var delete_url = "Posts.php?delete="+ id +" ";
        $(".modal_delete_link").attr("href",delete_url);
        $("#myModal").modal('show');
      //  return confirm('Are you sure want to Delete this post?');
    })
    
})
</script>