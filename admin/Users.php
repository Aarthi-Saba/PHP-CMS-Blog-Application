Escape(<?php 
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
                        <h3 class="page-header">Users</h3>
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
                            case 'add_user':
                                include "includes/AddUser.php";
                                break;
                            case 'edit_user':
                                include "includes/EditUser.php";
                                break;
                            default :
                                include "includes/ViewAllUsers.php";
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

<?php include "includes/AdminFooter.php" ?>
