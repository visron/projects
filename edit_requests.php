<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("location: " . $_SERVER['HTTP_REFERER']);
}
?>
<?php
//session_start();
require_once('classes/requests.class.php');
$request = new Requests();
$info = $request->getRequest($id)[0];

?>
<?php include('header.php'); ?>
<section id="content">
    <section class="vbox">
        <section class="scrollable padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">Requests Management</a></li>
                <li><a href="index.php">Requests</a></li>
                <li class="active">Update Requests</li>
            </ul>
            <div class="m-b-md">
                <h3 class="m-b-none">Update Requests</h3>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading font-bold">Update Requests</div>
                    <div class="panel-body">
                        <form action="exec/requests-exec.php" method="post" name="user" class="form-horizontal" onSubmit="return MM_validateForm()">

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="name">Customer Name *</label>
                                    <div class="col-lg-10">
                                        <input name="name" type="text" class="form-control" id="fname" value="<?php echo $info["Name"] ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="name">Customer number *</label>
                                    <div class="col-lg-10">
                                        <input name="number" type="number" class="form-control" id="number" value="<?php echo $info["Number"] ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="email">PICKUP *</label>
                                    <div class="col-lg-10">
                                        <input name="pickup" type="status" class="form-control" id="pickup" value="<?php echo $info["Pickup"] ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="email">DESTINATION *</label>
                                    <div class="col-lg-10">
                                        <input name="destination" type="status" class="form-control" id="destination" value="<?php echo $info["Destination"] ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Trip Status</label>
                                                <div class="col-sm-10">

                        <select name="status" class="form-control" id="selectError" data-rel="chosen">
                             <option value="Pending">Pending</option>
                             <option value="Started">Started</option>
                             <option value="On-Going">On-Going</option>
                             <option value="Cancelled">Cancelled</option>
                             <option value="Finished">Finished</option>
                             
                            </select>
                            </div>
                            </div>s
                                
                            </fieldset>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <input name="tag" type="hidden" id="tag" value="edit">
                                <input name="request_id" type="hidden" id="request_id" value="<?php echo $id ?>">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

<?php include('footer.php'); ?>
