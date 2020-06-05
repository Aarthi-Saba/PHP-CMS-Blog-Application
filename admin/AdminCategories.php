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
                        <h4 class="page-header">
                            Categories of your posts
                        </h4>
                        <!-- Add New category Form -->
                        <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Category Id</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php ShowUserCategory(); ?>
                            </tbody>
                        </table>
                        </div>
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
