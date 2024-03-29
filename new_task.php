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
        <li><a href="tasks.php">Tasks</a></li>
        <li class="active"><a href="#">Add Task</a></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <form action="exec/task-exec.php" method="post" class="panel form-horizontal">
                <div class="panel-heading">
                    <span class="panel-title">New Task</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Task Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div> <!-- / .form-group -->
<!--                    <div class="form-group">
                        <label for="progress" class="col-sm-2 control-label">Task Progress</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="location" name="progress">
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Task Status</label>
                                                <div class="col-sm-10">

                        <select name="status" class="form-control" id="selectError" data-rel="chosen">
                             <option value="1">Start</option>
                             <option value="2">Approved</option>
                             <option value="3">On Going</option>
                             <option value="4">Completed</option>                             
                             
                            </select>
                    </div>
                    </div>
                      <div class="form-group">
                        <label for="project" class="col-sm-2 control-label">Project</label>
                        <div class="col-sm-10">
                          <select name="project" class="form-control" id="selectError" data-rel="chosen">
                          <option value="0">--- Select Project ---</option>

                          <?php
                                foreach ($taas as $dep) {
                                    echo '<option value="' . $dep['P_ID'] . '">' . $dep['P_NAME'] . '</option>';
                                }
                                ?>
                          </select>
                        </div>
                    </div> 
                   
                        <div class="form-group">
                        <label for="project" class="col-sm-2 control-label">Users</label>
                        <div class="col-sm-10">
                          <select name="user" class="form-control" id="selectError" data-rel="chosen">
                          <option value="0">--- Assign User ---</option>

                          <?php
                                foreach ($users as $user) {
                                    echo '<option value="' . $user['U_ID'] . '">' . $user['U_NAME'] . '</option>';
                                }
                                ?>
                          </select>
                        </div>
                    </div>  
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="col-sm-2 btn btn-info">Submit</button>
                            <input name="tag" type="hidden" id="tag" value="new_task" />
                        </div>
                    </div> <!-- / .form-group -->
                </div>
            </form>
        </div>

    </div>
</div>
<?php include_once('footer.php'); ?>
				