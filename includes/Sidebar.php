<?php
if(IfMethod('post') && isset($_POST['login']))
{
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        global $sqlconnection;
        $loginusername = mysqli_real_escape_string($sqlconnection,$_POST['username']);
        $loginpassword = mysqli_real_escape_string($sqlconnection,$_POST['password']);
        if(!LoginUser($loginusername,$loginpassword)){
            echo "<h4 class='alert alert-danger'>Login unsuccessful, Incorrect values</h4>";
        }
    }
    else{
        Redirect('/cms/');
    }
}
?>
                

                    <!-- Blog Sidebar Widgets Column -->
               
                <div class="col-md-4">

                
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="Search.php" method="post">
                    <div class="input-group">
                       <input name="search" type="text" class="form-control">
                       <span class="input-group-btn">
                           <button name="submit" class="btn btn-default" type="submit">
                               <span class="glyphicon glyphicon-search"></span>
                       </button>
                       </span>
                    </div>                        
                    </form>
                    
                    <!-- /.input-group -->
                </div>
                
                                <!-- Login -->

                <div class="well">
                   <?php if(isset($_SESSION['userrole'])): ?>
                       <h5> Logged in as <?php echo $_SESSION['username']; ?></h5>
                       <a href="includes/Logout.php" class="btn btn-primary"> Logout</a>
                   <?php else: ?>
                        <h4>Login</h4>
                        <form method="post">
                        <div class="form-group">
                           <input name="username" type="text" class="form-control" placeholder="User Name">
                        </div>
                        <div class="form-group">
                           <input name="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div>
                           <span class="input-group-btn">
                               <button name="login" class="btn btn-primary" type="submit" >Submit</button>
                           </span>
                        </div>          
                        <div class="form-group">
                            <a href='Forgot.php?forgot=<?php echo uniqid(true); ?>'>Forgot Password?</a>
                        </div>
                        </form>
                    <?php endif; ?>
                </div>
                <?php
                    $selectquery = "SELECT * FROM CATEGORY";
                    $selectedrows = mysqli_query($sqlconnection,$selectquery);
                ?>
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                   <?php                                
                                    while($row = mysqli_fetch_assoc($selectedrows))
                                    {
                                        $categoryid = $row['CategoryId'];
                                        $categorytitle = $row['CategoryTitle'];
                                        echo "<li> <a href='Category.php?category_id=$categoryid'>{$categorytitle}</a></li>";
                                    }
                                    ?>
                            </ul>
                        </div>
                        
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "Widget.php"; ?>

            </div>

        </div>