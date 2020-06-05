<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/cms/admin">CMS Blog Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <!--<li><a href="">Users Online :<?php// echo Users_Online();?></a></li> -->
        <li><a href="">Users Online :<span class="usersonline"></span></a></li>
        <li><a href='/cms'>Home</a></li>


        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
            <?php echo GetUserName(); ?>
                <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="./Profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/Logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="./index.php"><i class="fa fa-fw fa-dashboard"></i> My Dashboard</a>
            </li>
            <?php if(is_admin()): ?>
            <li>
                <a href="/cms/admin/Dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Overall Dashboard</a>
            </li>
            <?php endif; ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#post_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="post_dropdown" class="collapse">
                    <li>
                        <a href="./Posts.php">View All Posts</a>
                    </li>
                    <li>
                        <a href="Posts.php?source=add_post">Add Post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="./Categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>

            <li class="active">
                <a href="./Comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="users_dropdown" class="collapse">
                    <li>
                        <a href="./Users.php">View All Users</a>
                    </li>
                    <li>
                        <a href="./Users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="Profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>