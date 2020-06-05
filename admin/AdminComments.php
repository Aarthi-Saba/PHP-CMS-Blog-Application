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
                       
                        <h3 class="page-header">Comments by <?php echo GetUserFullName(); ?></h3>
                        
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
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php 
                            global $sqlconnection;
                            $useremail =isset($_SESSION['useremail']) ? $_SESSION['useremail'] : "";
                            $commentjoinquery =mysqli_prepare($sqlconnection,"SELECT COMMENT.Comment_Id,
                                                COMMENT.Comment_Author,COMMENT.Comment_Email,COMMENT.Comment_Content,
                                                COMMENT.Comment_Post_Id,COMMENT.Comment_Status,COMMENT.Comment_Date,
                                                POST.Id,POST.Post_Title FROM COMMENT LEFT JOIN POST ON COMMENT.Comment_Post_Id=POST.Id WHERE COMMENT.Comment_Email=? ORDER BY COMMENT.Comment_Date DESC");
                            mysqli_stmt_bind_param($commentjoinquery,"s",$useremail);
                            mysqli_stmt_execute($commentjoinquery);
                            mysqli_stmt_bind_result($commentjoinquery,$commentid,$commentauthor,$commentemail,$comment,
                                                   $commentresponseto,$commentstatus,$commentdate,$postid,$posttitle);
                            while(mysqli_stmt_fetch($commentjoinquery))
                            {
                           
                                echo "<tr>";
                                echo "<td>$commentid</td>";
                                echo "<td>$commentauthor</td>";
                                echo "<td>$comment</td>";
                                echo "<td>$commentemail</td>";
                                echo "<td>$commentstatus</td>";
                                echo "<td><a href='../post.php?p_id={$postid}'>$posttitle</a></td>";
                                echo "<td>$commentdate</td>";
                                echo "<td> <a href='AdminComments.php?delete={$commentid}'>DELETE</a></td>"; 
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
<?php
if(isset($_GET['delete']))
{
    if(IsLoggedIn())
    {
        $deletecommentid = Escape($_GET['delete']);
        $deletecommentquery = "DELETE FROM COMMENT WHERE Comment_Id=$deletecommentid";
        $deletedcomment = mysqli_query($sqlconnection,$deletecommentquery);
        $decreasecommentcountquery = "UPDATE POST SET Post_Comment_Count = Post_Comment_Count - 1 WHERE Id=$postid";
        $decreasedcommentcount = mysqli_query($sqlconnection,$decreasecommentcountquery);
        header("Location: AdminComments.php");    
        exit;
    }

}
?>    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/AdminFooter.php" ?>
