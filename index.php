<?php
include_once('header.php');

$uid = $_SESSION['UID'];
$now = date('Y-M-d');
include_once('classes/Dashboard.class.php');
$dash = new Dashboard();
//exit;
//	echo implode(",",$production);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <li><a href="#">Home</a></li>
        <li class="active"><a href="#">Dashboard</a></li>
    </ul>
  
 <div class="row">
        <div class="col-md-11">
            <div class="stat-panel">
                <div class="stat-row">
                    <div class="stat-cell bg-info darker">
                        <i class="fa fa-lightbulb-o bg-icon" style="font-size:60px;line-height:80px;height:80px;"></i>
                        <span class="text-bg">Overview</span><br>
                        <span class="text-sm">Account summary</span>
                    </div>
                </div>
                <div class="stat-row">
                    <div class="stat-counters bg-info no-border-b no-padding text-center">
                        <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                            <a class="clear" href="users.php">
                               <span class="text-bg"><strong><?php echo number_format($dash->getCount('users', 'WHERE U_STATUS = 1')); ?></strong></span><br>                                
                                <span class="text-xs">REGISTERED USERS</span>

                            </a>
                        </div>
                        <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                            <a class="clear" href="tasks.php">
                               <span class="text-bg"><strong><?php echo number_format($dash->getCount('tasks', 'WHERE T_STATUS = 1')); ?></strong></span><br>
                                
                                <span class="text-xs">TOTAL TRIPS</span>
                            </a>
                        </div>
                        
                    </div>
                </div>
                <div class="stat-row">
                    <div class="stat-counters bg-info no-border-b no-padding text-center">
                        <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                            <a class="clear" href="projects.php">
                                <span class="text-bg"><strong><?php echo number_format($dash->getCount('project', 'WHERE P_STATUS = 1')); ?></strong></span><br>
                                <span class="text-xs">NUMBER OF TRUCKS</span>
                            </a>
                        </div>
                         
                    </div>
                </div>
            </div>
        </div>
     </div> 
     
   </div>


<?php

include_once('footer.php');
?>