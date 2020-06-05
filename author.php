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
                if(isset($_GET['p_id']))
                {
                    $p_id = Escape($_GET['p_id']);
                    $postauthor = Escape($_GET['author']);
                }
                $selectquery = "SELECT * FROM POST WHERE Post_Author = '$postauthor' ";
                $selectedposts = mysqli_query($sqlconnection,$selectquery);
                while($record = mysqli_fetch_assoc($selectedposts))
                {
                    $postid = $record['Id'];
                    $posttitle = $record['Post_Title'];
                    $postauthor = $record['Post_Author'];
                    $postdate = $record['Post_Date'];
                    $postimage = $record['Post_Image'];
                    $postcontent = $record['Post_Content'];
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>
                    <!-- Blog Post -->
                    <h2>
                    <a href="post.php?p_id=<?php echo $postid; ?>"><?php echo $posttitle ?></a>
                    </h2>
                    <p class="lead">
                        by <?php echo $postauthor ?>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $postdate ?></p>
                    <hr>
                    <img class="img-responsive" src="/cms/images/<?php echo $postimage;?>" alt="">
                    <hr>
                <p><?php echo $postcontent ?></p>   
                    <hr>
                    
                <?php 
                }
            
                ?>

            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/Sidebar.php"; ?>
        </div>
    </div>
        <!-- /.row -->

        <hr>
        <!-- Footer -->
<?php include "includes/Footer.php"; ?>