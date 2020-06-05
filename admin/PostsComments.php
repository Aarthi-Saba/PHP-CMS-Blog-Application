<?php 
include "includes/AdminHeader.php";
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/AdminNavigation.php"; ?>
        
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Comments</h3>
                    <?php
                    if(isset($_GET['cp_id']))
                    {
                        $commentpostid = Escape($_GET['cp_id']);
                        global $sqlconnection;
                        $selectpostquery = "SELECT * FROM POST WHERE Id=$commentpostid"; // get relative post id to which comment is added
                        $posts = mysqli_query($sqlconnection,$selectpostquery);
                        $totalpost = mysqli_num_rows($posts);
                        if($totalpost == 1)
                        {
                            $row = mysqli_fetch_assoc($posts);
                            $postid = $row['Id'];
                            $posttitle = $row['Post_Title'];
                        }
                        else{
                            die("Something went wrong !".mysqli_error($sqlconnection));
                        }
                    }
                    else{
                        echo "failed";
                    }
                    ?>
                    <h4> All Comments of <a href="../post.php?p_id=<?php echo $postid; ?>"><?php echo $posttitle ?></a></h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Approve</th>
                                <th>UnApprove</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                $commentpostquery = "SELECT * FROM COMMENT WHERE COMMENT_POST_ID = $commentpostid ";
                                $allcommentsofpost = mysqli_query($sqlconnection,$commentpostquery);
                                while($row = mysqli_fetch_assoc($allcommentsofpost))
                                {
                                    $commentid = $row['Comment_Id'];
                                    $commentauthor = $row['Comment_Author'];
                                    $commentemail = $row['Comment_Email'];
                                    $comment = $row['Comment_Content'];
                                    $commentresponseto = $row['Comment_Post_Id'];
                                    $commentstatus = $row['Comment_Status'];
                                    $commentdate = $row['Comment_Date'];

                                    echo "<tr>";
                                    echo "<td>$commentid</td>";
                                    echo "<td>$commentauthor</td>";
                                    echo "<td>$comment</td>";
                                    echo "<td>$commentemail</td>";
                                    echo "<td>$commentstatus</td>";
                                    echo "<td>$commentdate</td>";
                                    echo "<td> <a href='PostsComments.php?approve={$commentid}&cp_id=". $_GET['cp_id'] ."'>Approve</a></td>";
                                    echo "<td> <a href='PostsComments.php?unapprove={$commentid}&cp_id=". $_GET['cp_id'] ."'>UnApprove</a></td>"; 
                                    echo "<td> <a href='PostsComments.php?delete={$commentid}&cp_id=". $_GET['cp_id'] ."'>DELETE</a></td>"; 
                                    echo "</tr>";
                                 }
                           ?>  
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include "includes/AdminFooter.php" ?>

<?php
if(isset($_GET['approve']))
{
    $commentid = $_GET['approve'];
    $approvecommentquery = "UPDATE COMMENT SET Comment_Status='Approved' WHERE Comment_id=$commentid ";
    $approvedcomment = mysqli_query($sqlconnection,$approvecommentquery);
    header("Location: PostsComments.php?cp_id=". $postid ."");
    

}
if(isset($_GET['unapprove']))
{
    $commentid = $_GET['unapprove'];
    $unapprovecommentquery = "UPDATE COMMENT SET Comment_Status='Unapproved' WHERE Comment_id=$commentid ";
    $unapprovedcomment = mysqli_query($sqlconnection,$unapprovecommentquery);
    header("Location: PostsComments.php?cp_id=". $postid ."");

}
if(isset($_GET['delete']))
{
    $deletecommentid = $_GET['delete'];
    $postid = $_GET['cp_id'];
    $deletecommentquery = "DELETE FROM COMMENT WHERE Comment_Id=$deletecommentid";
    $deletedcomment = mysqli_query($sqlconnection,$deletecommentquery);
    $decreasecommentcountquery = "UPDATE POST SET Post_Comment_Count = Post_Comment_Count - 1 WHERE Id=$postid";
    $decreasedcommentcount = mysqli_query($sqlconnection,$decreasecommentcountquery);
    header("Location: PostsComments.php?cp_id=". $postid ."");    
}
?>    