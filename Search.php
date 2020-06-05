
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
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>               
                <?php
                    if(isset($_POST['submit']))
                    {
                        $searchword = Escape($_POST['search']);
                        $searchquery = " SELECT * FROM Post WHERE Post_Tags LIKE '%$searchword%' ";
                        $searchresult = mysqli_query($sqlconnection,$searchquery);
                        if(!$searchresult){
                            die("Query failed".mysqli_error($sqlconnection));
                        }
                        $resultcount = mysqli_num_rows($searchresult);
                        if($resultcount == 0){
                            echo "OOPS! No matching results found";
                        }
                        else
                        {
                           while($record = mysqli_fetch_assoc($searchresult))
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
                                    by <a href="index"><?php echo $postauthor ?></a>
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
                            }

                        }
                        ?>
                
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/Sidebar.php"; ?>
        <!-- /.row -->

        <hr>
        <!-- Footer -->
<?php include "includes/Footer.php"; ?>
