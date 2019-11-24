<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("location: " . $_SERVER['HTTP_REFERER']);
}
?>
<?php
//session_start();
require_once('classes/Tasks.class.php');
$task = new Tasks();
$info = $task->getTask($id)[0];

?>
<?php include('header.php'); ?>
<section id="content">
    <section class="vbox">
        <section class="scrollable padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">Project Management</a></li>
                <li><a href="admins.php">Tasks</a></li>
                <li class="active">Update Task</li>
            </ul>
            <div class="m-b-md">
                <h3 class="m-b-none">Update Task</h3>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading font-bold">Update Task</div>
                    <div class="panel-body">
                        <form action="exec/task-exec.php" method="post" name="user" class="form-horizontal" onSubmit="return MM_validateForm()">

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="name">Task Name *</label>
                                    <div class="col-lg-10">
                                        <input name="name" type="text" class="form-control" id="fname" value="<?php echo $info["T_NAME"] ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="name">Task Progress *</label>
                                    <div class="col-lg-10">
                                        <input name="progress" type="number" class="form-control" id="sname" value="<?php echo $info["T_PROGRESS"] ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="email">Task Status *</label>
                                    <div class="col-lg-10">
                                        <input name="status" type="status" class="form-control" id="email" value="<?php echo $info["T_STATUS"] ?>" />
                                    </div>
                                </div>
                                
                            </fieldset>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <input name="tag" type="hidden" id="tag" value="edit">
                                <input name="task_id" type="hidden" id="user_id" value="<?php echo $id ?>">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

<?php include('footer.php'); ?>
