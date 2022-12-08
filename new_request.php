<?php include_once('header.php'); 
$UID = $_SESSION['UID'];

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
                        <label for="name" class="col-sm-2 control-label">Phone no.</label>
                        <div class="col-sm-10">
                            <input placeholder="E.g +254722969246" type="text" class="form-control" id="number" name="number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="from" class="col-sm-2 control-label">From</label>
                        <div class="col-sm-10">
                        <select class="form-select" name="from" id="from">
  <option value="Karen">Karen</option>
  <option value="Rongai">Rongai</option>
  <option value="Dagoretti">Dagoretti</option>
  <option value="Langata">Langata</option>
  <option value="Runda">Runda</option>
  <option value="Umoja">Umoja</option>
  <option value="Ruiru">Ruiru</option>
  <option value="Juja">Juja</option>
  <option value="Uthiru">Uthiru</option>
  <option value="Westlands">Westlands</option>
  <option value="Kasarani">Kasarani</option>
  <option value="Embakasi">Embakasi</option>
</select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">To</label>
                        <div class="col-sm-10">
                        <select class="form-select" name="to" id="to">
                        <option value="Karen">Karen</option>
  <option value="Rongai">Rongai</option>
  <option value="Dagoretti">Dagoretti</option>
  <option value="Langata">Langata</option>
  <option value="Runda">Runda</option>
  <option value="Umoja">Umoja</option>
  <option value="Ruiru">Ruiru</option>
  <option value="Juja">Juja</option>
  <option value="Uthiru">Uthiru</option>
  <option value="Westlands">Westlands</option>
  <option value="Kasarani">Kasarani</option>
  <option value="Embakasi">Embakasi</option>
</select>
                        
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
                            <input name="userid" type="hidden" id="userid" value="<?php echo $UID ?>" />
                        </div>
                    </div> <!-- / .form-group -->
                </div>
            </form>
        </div>

    </div>
</div>
<?php include_once('footer.php'); ?>
				