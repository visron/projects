<?php
//session_start();
require_once('classes/Admins.class.php');
$user = new Admin();

?>
<?php include('header.php'); ?>
<script type="text/javascript">
    function validateForm() {
        var fn = document.forms["user"]["fname"].value;
        var sn = document.forms["user"]["sname"].value;
        var un = document.forms["user"]["username"].value;

        if (fn == "") {
            alert("Please input first name");
            return false;
        }

        if (sn == "") {
            alert("Please input surname");
            return false;
        }
        if (un == "") {
            alert("Please input username");
            return false;
        }
   
        
        if (sec == "0") {
            alert("Please Select Section");
            return false;
       
    //    alert(sec+" dpt : "+dpt+" id "+id_no);

    }
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="index.php">Home</a></li>   
        <li><a href="users.php">Users</a></li>
        <li class="active"><a href="#">Create User</a></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <form action="exec/register-exec.php" method="post" name="user" class="form-horizontal" onSubmit="return validateForm()">
                <div class="panel-heading">
                    <span class="panel-title">Create User</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="name">Firstname *</label>
                        <div class="col-lg-10">
                            <input name="firstname" type="text" class="form-control" id="fname" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="name">Surname *</label>
                        <div class="col-lg-10">
                            <input name="surname" type="text" class="form-control" id="sname" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="email">Email *</label>
                        <div class="col-lg-10">
                            <input name="email" type="email" class="form-control" id="email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="phone">Phone </label>
                        <div class="col-lg-10">
                            <input name="phone" type="text" class="form-control" id="phone" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="username">Username *</label>
                        <div class="col-lg-10">
                            <input name="username" type="text" class="form-control" id="username" 
                                   onclick="$('#fname').val()"/>
                        </div>
                        
                        
                    </div>
                   
                    
                 
                    

                    <div class="form-group" style="margin-bottom: 0;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input name="tag" type="hidden" id="tag" value="newuser">
                            <button type="submit" class="col-sm-2 btn btn-info">Create User</button>
                        </div>
                    </div> <!-- / .form-group -->
                </div>
            </form>
        </div>

    </div>
</div>


<?php include_once('footer.php'); ?>
<script type="text/javascript">
    $(function () {
        $("#group").change(function () {
            $("#role").load('choices.php?tag=user&id=' + $(this).val());
        });
        
    });
</script>			