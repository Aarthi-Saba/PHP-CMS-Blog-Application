<?php
include "includes/Header.php";
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
                <h1 class='page-header'>
                    Welcome to CMS Tech Blog
                </h1>
                
                              
                <?php
                if(isset($_SESSION['userrole']))
                {
                    $postperpage = 6;
                    if(isset($_GET['page']))
                    {
                        $pagenum = Escape($_GET['page']);
                    }
                    else
                    {
                        $pagenum = "";
                    }
                    if($pagenum=="" || $pagenum == 1)
                    {
                        $pagestart = 0;
                    }
                    else
                    {
                        $pagestart = ($pagenum*$postperpage)-$postperpage;

                    }
                    if(strtolower($_SESSION['userrole']) == 'admin')
                    {
                        $postcountquery = "SELECT * FROM POST";
                    }
                    else{
                        $postcountquery = "SELECT * FROM POST WHERE LOWER(Post_Status) LIKE '%publish%' ";
                    }                    
                    $postcount = mysqli_query($sqlconnection,$postcountquery);
                    $count = mysqli_num_rows($postcount);
                    $totalpages = ceil($count/$postperpage);
                    $selectquery = "SELECT * FROM POST WHERE LOWER(Post_Status) LIKE '%publish%' ORDER BY Post_Date DESC LIMIT $pagestart,$postperpage ";
                    $selectedposts = mysqli_query($sqlconnection,$selectquery);
                    if(mysqli_num_rows($selectedposts) > 0)
                    {


                        while($record = mysqli_fetch_assoc($selectedposts))
                        {
                            $postid = $record['Id'];
                            $posttitle = $record['Post_Title'];
                            $postauthor = $record['Post_Author'];
                            $postdate = $record['Post_Date'];
                            $postimage = $record['Post_Image'];
                            $postcontent =substr($record['Post_Content'],0,250);
                            $poststatus=$record['Post_Status'];
                        ?>    

                                    <!-- Blog Post -->
                                <h2>Latest Articles</h2>
                                <h2>
                                <a href="post/<?php echo $postid; ?>"><?php echo $posttitle ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="author.php?author=<?php echo $postauthor ?>&p_id=<?php echo $postid; ?>"><?php echo $postauthor ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $postdate ?></p>
                                <hr>
                                <a href="post.php?p_id=<?php echo $postid; ?>">
                                <img class="img-responsive" src="/cms/images/<?php echo $postimage;?>" alt="">
                                </a>
                                <hr>
                                <p><?php echo $postcontent ?></p>
                                <a class="btn btn-primary" href="post.php?p_id=<?php echo $postid; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>    
                                <hr>
                        <?php
                        }
                    }
                    else
                    { ?>
                           <h3> No Posts to Display !!</h3>

                    <?php
                    }
                }
                else
                {
                    echo "<img src='https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=780&q=60' alt='Technical Blog'>" ;
                    
                }
                    ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/Sidebar.php"; ?>
        <!-- /.row -->

        <hr>
        <ul class="pager">
           <?php
            
            for($i=1 ; $i <= $totalpages;$i++)
            {
                if($i == $pagenum){
                    echo "<li><a class='active_link' href='index?page={$i}'>$i</a></li>";
                    
                }
                else{
                    echo "<li><a href='index?page={$i}'>$i</a></li>";
                }
            }
           ?>
        </ul>
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
