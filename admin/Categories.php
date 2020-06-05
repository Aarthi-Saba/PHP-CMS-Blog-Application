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
                        <h3 class="page-header">
                            Admin Page
                            <small>Subheading</small>
                        </h3>
                        <!-- Add New category Form -->
                        <div class="col-xs-6">
                        <?php AddCategory(); ?>
                        <form action="" method="post">
                            <div class="form-group">
                               <label for="category_title">Category Name</label>
                                <input class="form-control" type="text" name="category_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>
                        <?php 
                            if(isset($_GET['edit'])){
                                $editid = Escape($_GET['edit']);
                                include "includes/UpdateCategories.php";
                            }
                        ?>
                        </div>
                        <!--Add category -->
                        <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Category Id</th>
                                    <th>Category Title</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php ShowCategory(); ?>
                            <?php DeleteCategory() ?>
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
