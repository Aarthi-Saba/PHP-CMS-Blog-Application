<?php
include "includes/Header.php";
include "./admin/includes/AdminFunctions.php";
//include "includes/Db.php";
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
                if(isset($_GET['category_id']) && isset($_SESSION['userrole'])){
                    $categoryid = Escape($_GET['category_id']);
                    if(is_admin())
                    {
                        $adminquery = mysqli_prepare($sqlconnection,"SELECT Id,Post_Title,Post_Author,Post_Date,Post_Image,
                                                Post_Content FROM POST WHERE Post_Category_Id=?");
                        //$selectquery = "SELECT * FROM POST WHERE Post_Category_Id = $categoryid ";
                        
                    }
                    else
                    {
                        $nonadminquery = mysqli_prepare($sqlconnection,"SELECT Id,Post_Title,Post_Author,Post_Date,
                                            Post_Image,Post_Content FROM POST WHERE Post_Category_Id=? AND LOWER(Post_Status) LIKE ?");
                        $publish = "%publish%";
                       // $selectquery = "SELECT * FROM POST WHERE Post_Category_Id = $categoryid AND LOWER(Post_Status) LIKE '%publish%'";
                    }
                    if(isset($adminquery)){
                        mysqli_stmt_bind_param($adminquery,"i",$categoryid);
                        mysqli_stmt_execute($adminquery);
                        
                        mysqli_stmt_bind_result($adminquery,$postid,$posttitle,$postauthor,$postdate,$postimage,
                                                $postcontent);
                        $selectedposts = $adminquery;                        
                    }
                    else{
                        mysqli_stmt_bind_param($nonadminquery,"is",$categoryid,$publish);
                        mysqli_stmt_execute($nonadminquery);
                        mysqli_stmt_bind_result($nonadminquery,$postid,$posttitle,$postauthor,$postdate,$postimage,
                                                $postcontent);
                        
                        $selectedposts = $nonadminquery;
                        
                    }
                    //$selectedposts = mysqli_query($sqlconnection,$selectquery);
                    mysqli_stmt_store_result($selectedposts); // always store result before accessing stmtm_numrows
                    if(mysqli_stmt_num_rows($selectedposts)>=1)
                    {
                        while(mysqli_stmt_fetch($selectedposts))
                        {
                            /*$postid = $record['Id'];
                            $posttitle = $record['Post_Title'];
                            $postauthor = $record['Post_Author'];
                            $postdate = $record['Post_Date'];
                            $postimage = $record['Post_Image'];
                            $postcontent = substr($record['Post_Content'],0,250);*/
                            ?>
                            <h1 class="page-header">
                                Page Heading
                                <small>Secondary Text</small>
                            </h1>  
                            <!-- Blog Post -->
                            <h2>
                            <a href="/cms/post.php?p_id=<?php echo $postid; ?>"><?php echo $posttitle ;?></a>
                            </h2>
                            <p class="lead">
                                by <a href="/cms/author.php?author=<?php echo $postauthor ?>&p_id=<?php echo $postid; ?>"><?php echo $postauthor ?></a>
                                
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $postdate ?></p>
                            <hr>
                            <img class="img-responsive" src="/cms/images/<?php echo $postimage;?>" alt="">
                            <hr>
                            <p><?php echo $postcontent ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>    
                            <hr>
                            <?php
                        }
                        mysqli_stmt_close($selectedposts);
                    }
                    else
                    {
                        echo "<h4 class='text-center'> No Posts to display</h4>";
                    }                    
                }
                else{
                    header("Location: /cms");
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




<!-- Second Blog Post -->
                <!--<h2>
                    <a href="#">Blog Post Title</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">Start Bootstrap</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 28, 2013 at 10:45 PM</p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, quasi, fugiat, asperiores harum voluptatum tenetur a possimus nesciunt quod accusamus saepe tempora ipsam distinctio minima dolorum perferendis labore impedit voluptates!</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <!-- Third Blog Post -->
                <!--<h2>
                    <a href="#">Blog Post Title</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">Start Bootstrap</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 28, 2013 at 10:45 PM</p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, voluptates, voluptas dolore ipsam cumque quam veniam accusantium laudantium adipisci architecto itaque dicta aperiam maiores provident id incidunt autem. Magni, ratione.</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <!-- Pager -->
                <!-- <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>
