<?php include_once('header.php'); 
include_once('classes/Tasks.class.php');
include_once('classes/Admins.class.php'); 

$task = new Tasks();
$taas= $task->getTasks();
$admin = new Admin();
$users = $admin->getAllUsers();

?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <li><a href="index.php">Home</a></li>
        <li><a href="tasks.php">Requests</a></li>
        <li class="active"><a href="#">Make Request</a></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <form action="exec/requests-exec.php" method="post" class="panel form-horizontal">
                <div class="panel-heading">
                    <span class="panel-title">New Request</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="number" name="number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="from" class="col-sm-2 control-label">From</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="from" name="from" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">To</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="to" name="to" required>
                        </div>
                    </div>
                    <!-- / .form-group -->
<!--                    <div class="form-group">
                        <label for="progress" class="col-sm-2 control-label">Task Progress</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="location" name="progress">
                        </div>
                    </div>-->
                
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="col-sm-2 btn btn-info">Submit</button>
                            <input name="tag" type="hidden" id="tag" value="new_request" />
                        </div>
                    </div> <!-- / .form-group -->
                </div>
            </form>
        </div>

    </div>
</div>
<?php include_once('footer.php'); ?>
				