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
                        <h3 class="page-header">Posts</h3>
                        <?php
                        
                        if(isset($_GET['source']))
                        {
                            $source = Escape($_GET['source']);
                        }
                        else
                        {
                            $source ='';
                        }
                            
                        switch($source)
                        {
                            case 'add_post':
                                include "includes/AddPost.php";
                                break;
                            case 'edit_post':
                                include "includes/EditPost.php";
                                break;
                            default :
                                include "includes/ViewAllPosts.php";
                                break;
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
</body>
<?php include "includes/AdminFooter.php" ?>
