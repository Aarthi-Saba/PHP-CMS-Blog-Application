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
                            Welcome to Admin Page 
                        
                        <?php echo GetUserFullName(); ?>
                        </h3>
                    </div>
                </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-text fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'><?php echo $postcount = TotalRecords('POST'); ?></div>
                                            <div>Posts</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="Posts.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Posts</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">

                                            <div class='huge'><?php echo $commentcount= TotalRecords('COMMENT'); ?></div>
                                          <div>Comments</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="Comments.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Comments</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'><?php echo $usercount = TotalRecords('USER'); ?></div>
                                            <div> Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="Users.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Users</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'><?php echo $categorycount= TotalRecords('CATEGORY'); ?></div>
                                             <div>Categories</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="Categories.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Categories</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                                    <!-- /.row -->
                    <?php
                        $publishedpostcount = ChartValues('POST','POST_STATUS','published');
                        $republishedpostcount = ChartValues('POST','POST_STATUS','republished');
                        $postdraftcount = ChartValues('POST','POST_STATUS','draft');
                        $unapprovedcount = ChartValues('COMMENT','COMMENT_STATUS','unapproved');
                        $subscribedusercount = ChartValues('USER','USER_ROLE','subscriber');
                    ?>
                    <div class="row">
                        <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                              ['Data', 'Count'],
                              <?php
                                $elementstext = ['Active Posts','Published Posts','Republished Posts','Draft Posts',
                                                 'Total Comments','UnApproved Comments','Users','Subscribed Users',
                                                 'Categories'];
                                $elementcounts= [$postcount,$publishedpostcount,$republishedpostcount,$postdraftcount,
                                                 $commentcount,$unapprovedcount,$usercount,$subscribedusercount,
                                                 $categorycount];
                                for($i=0; $i < count($elementstext) ; $i++){
                                    echo "['{$elementstext[$i]}'" . "," . "{$elementcounts[$i]}]," ;
                                }
                              ?>
                              //['2014', 1000, ],
                            ]);

                            var options = {
                              chart: {
                                title: '',
                                subtitle: '',
                              }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                          }
                        </script>
                        <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                    </div>

                
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/AdminFooter.php" ?>
