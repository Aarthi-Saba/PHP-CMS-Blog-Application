<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th width='20%'>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response To</th>
            <th width='9%'>Date</th>
            <th>Approve</th>
            <th>UnApprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
       <?php 
        global $sqlconnection;
        $commentjoinquery = "SELECT COMMENT.Comment_Id,COMMENT.Comment_Author,COMMENT.Comment_Email,COMMENT.Comment_Content,
                        COMMENT.Comment_Post_Id,COMMENT.Comment_Status,COMMENT.Comment_Date,POST.Id,POST.Post_Title 
                        FROM COMMENT LEFT JOIN POST ON COMMENT.Comment_Post_Id=POST.Id ORDER BY COMMENT.Comment_Date DESC";
        $allcomments = mysqli_query($sqlconnection,$commentjoinquery);
        while($row = mysqli_fetch_assoc($allcomments))
        {
            $commentid = $row['Comment_Id'];
            $commentauthor = $row['Comment_Author'];
            $commentemail = $row['Comment_Email'];
            $comment = $row['Comment_Content'];
            $commentresponseto = $row['Comment_Post_Id'];
            $commentstatus = $row['Comment_Status'];
            $commentdate = $row['Comment_Date'];
       ?>
       
           <?php
            echo "<tr>";
            echo "<td>$commentid</td>";
            echo "<td>$commentauthor</td>";
            echo "<td>$comment</td>";
            echo "<td>$commentemail</td>";
            echo "<td>$commentstatus</td>";
            $selectpostquery = "SELECT * FROM POST WHERE Id=$commentresponseto"; // get relative post id to which comment is added
           // $posts = mysqli_query($sqlconnection,$selectpostquery);
        //    while($row = mysqli_fetch_assoc($posts)){
                $postid = $row['Id'];
                $posttitle = $row['Post_Title'];
                // hyperlink to post is created using get request url to post page
                echo "<td><a href='../post.php?p_id={$postid}'>$posttitle</a></td>";
          //  }
            echo "<td>$commentdate</td>";
            echo "<td> <a href='Comments.php?approve={$commentid}'>Approve</a></td>";
            echo "<td> <a href='Comments.php?unapprove={$commentid}'>UnApprove</a></td>"; 
            echo "<td> <a href='Comments.php?delete={$commentid}'>DELETE</a></td>"; 
            echo "</tr>";
            }
            ?>
    </tbody>
</table>
<?php
if(isset($_GET['approve']))
{
    $commentid = Escape($_GET['approve']);
    $approvecommentquery = "UPDATE COMMENT SET Comment_Status='Approved' WHERE Comment_id=$commentid ";
    $approvedcomment = mysqli_query($sqlconnection,$approvecommentquery);
    header("Location: Comments.php");
    exit;

}
if(isset($_GET['unapprove']))
{
    $commentid = Escape($_GET['unapprove']);
    $unapprovecommentquery = "UPDATE COMMENT SET Comment_Status='Unapproved' WHERE Comment_id=$commentid ";
    $unapprovedcomment = mysqli_query($sqlconnection,$unapprovecommentquery);
    header("Location: Comments.php");
    exit;

}
if(isset($_GET['delete']) && isset($_SESSION['userrole']))
{
    if(strtolower($_SESSION['userrole']) == 'admin')
    {
        $deletecommentid = Escape($_GET['delete']);
        $deletecommentquery = "DELETE FROM COMMENT WHERE Comment_Id=$deletecommentid";
        $deletedcomment = mysqli_query($sqlconnection,$deletecommentquery);
        $decreasecommentcountquery = "UPDATE POST SET Post_Comment_Count = Post_Comment_Count - 1 WHERE Id=$postid";
        $decreasedcommentcount = mysqli_query($sqlconnection,$decreasecommentcountquery);
        header("Location: Comments.php");    
        exit;
    }

}
?>    