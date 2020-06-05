<?php
include "includes/Header.php";
?>

<body>
    <!-- Navigation -->
    <?php 
    include "includes/Navigation.php"; 
    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
               
                <?php
                if(isset($_GET['p_id'])  && isset($_SESSION['userrole']))
                {
                    $postid = Escape($_GET['p_id']);
                    $postviewscountquery = "UPDATE POST SET Post_Views_Count = Post_Views_Count+1 WHERE Id=$postid";
                    $viewcounts = mysqli_query($sqlconnection,$postviewscountquery);
                    if(!$viewcounts){
                        die("Query failed".mysqli_error($sqlconnection));
                    }
                                
                    $selectquery = "SELECT * FROM POST WHERE Id = $postid ";
                    $selectedposts = mysqli_query($sqlconnection,$selectquery);
                    //echo "<h3 class='page-header'>Current Post</h3>";
                    while($record = mysqli_fetch_assoc($selectedposts))
                    {
                        $posttitle = $record['Post_Title'];
                        $postauthor = $record['Post_Author'];
                        $postdate = $record['Post_Date'];
                        $postimage = $record['Post_Image'];
                        $postcontent = $record['Post_Content'];
                        ?>

                        <!-- Blog Post -->
                        <h2>
                        <a href="#"><?php echo $posttitle ?></a>
                        </h2>
                        <p class="lead">
                            by <?php echo $postauthor ?>
                        </p>
                         <p><a href="author.php?author=<?php echo $postauthor;?>&p_id=<?php echo $postid; ?>">View All Posts by  <?php echo $postauthor ?></a></p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $postdate ?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/images/<?php echo $postimage;?>" alt="">
                        <hr>
                        <p><?php echo $postcontent ?></p>   
                        <hr>
                    
                <?php 
                    }

                ?>
                <!-- Blog Comments -->
                <?php
                if(isset($_POST['new_comment']))
                {
                    $postid = Escape($_GET['p_id']);
                    $author = Escape($_POST['comment_author']);
                    $email = Escape($_POST['comment_email']);
                    $content = Escape($_POST['comment_content']);
                    $currdate = date('Y-m-d');
                    if(empty($author) || empty($email) || empty($content))
                    {
                        echo "<script>alert('Fields cannot be empty')</script>";
                    }
                    else
                    {
                        $insertcommentquery = "INSERT INTO COMMENT (Comment_Post_Id,Comment_Author,Comment_Email,
                                               Comment_Content,Comment_Date) VALUES ($postid,'$author','$email',
                                               '$content','$currdate')";
                        $insertedrows = mysqli_query($sqlconnection,$insertcommentquery);
                        if(!$insertedrows)
                        {
                            die("Comment not added".mysqli_error($sqlconnection));
                        }
                        else
                        {
                            $incrementcommentcountquery = "UPDATE POST SET Post_Comment_Count = Post_Comment_Count +1 
                                                      WHERE Id=$postid";
                            $incrementedcommentcount = mysqli_query($sqlconnection,$incrementcommentcountquery);
                        }
                    }
                }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
           
                    <form role="form" action="" method="post">
                       <div class="form-group">
                           <label for="comment_author">Name</label>
                           <input class="form-control" type="text" name="comment_author">
                       </div>
                       <div class="form-group">
                           <label for="comment_email">Email</label>
                           <input class="form-control" type="text" name="comment_email">
                       </div>

                        <div class="form-group">
                            <textarea class="form-control" name="comment_content" cols="25" rows="8"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="new_comment">Submit</button>
                    </form>
     
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                    $commentquery = "SELECT * FROM COMMENT WHERE Comment_Post_Id=$postid AND
                                     Comment_Status='Approved' ORDER BY Comment_Id DESC";
                    $allcomments = mysqli_query($sqlconnection,$commentquery);
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

                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $commentauthor; ?>
                                    <small><?php echo $commentdate; ?></small>
                                </h4>
                                <?php echo $comment; ?>
                            </div>
                        </div>
                    <?php       
                        }   
                   }
                   else
                   {
                       header("Location: index")  ;
                       exit;
                   }
                    ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/Sidebar.php"; ?>
        <!-- /.row -->

        <hr>
        <!-- Footer -->
<?php include "includes/Footer.php"; ?>