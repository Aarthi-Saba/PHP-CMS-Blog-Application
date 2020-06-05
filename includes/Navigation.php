<?php include "Db.php"; 
session_start();?>
          <!-- navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                <?php
                 $selectquery = "SELECT * FROM CATEGORY";
                 $selectedrows = mysqli_query($sqlconnection,$selectquery);
                 while($row = mysqli_fetch_assoc($selectedrows))
                 {
                     $categoryid = $row['CategoryId'];
                     $title = $row['CategoryTitle'];
                     $category_class = "";
                     $reg_static_class = "";
                     $admin_static_class = "";
                     $contact_static_class = "";
                     $login_static_class="";
                     $currentpage = basename($_SERVER['PHP_SELF']);
                     if(isset($_GET['category_id']) && $_GET['category_id'] == $categoryid){
                         $category_class = "active";
                     }
                     switch($currentpage){
                         case 'registration.php':
                             $reg_static_class = "active";
                             break;
                         case 'contact.php':
                             $contact_static_class = "active";
                             break;
                         case 'admin.php':
                             $admin_static_class = "active";
                             break;
                         case 'Login.php':
                             $login_static_class ="active";
                             break;
                         default:
                             break;
                     }
                     echo "<li class='$category_class'><a href='/cms/Category/{$categoryid}'>{$title}</a></li>";
                 }
                 if(IsLoggedIn())
                 {
                     echo "<li class=$admin_static_class> <a href='/cms/admin'>Admin</a></li>";
                     echo "<li> <a href='/cms/includes/Logout.php'>Logout</a></li>";
                     
                     if(isset($_GET['p_id']))
                     {
                         $postid=Escape($_GET['p_id']);
                         echo "<li> <a href='admin/Posts.php?source=edit_post&p_id={$postid}'>Edit Post</a></li>";
                     }
                 }
                 else
                 {
                     echo "<li class=$login_static_class><a href='/cms/Login'> Login </a></li>";
                 }
                ?>
                   
                   <li class="<?php echo $reg_static_class; ?>"> <a href='/cms/registration'>Registration</a></li>
                   <li class="<?php echo $contact_static_class; ?>"> <a href='/cms/contact'>Contact</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>