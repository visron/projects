<?php
include('header.php');
include('classes/Admins.class.php');

if (isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    $user = $_SESSION['UID'];
}
$admin = new Admin();
$userinfo = $admin->getAdminInfo($user);
$userpic = $admin->getAdminPic($user);
?>

<div id="content-wrapper">
    <div class="profile-full-name">
        <span class="text-semibold"><?php echo $_SESSION['FIRSTNAME'] . ' ' . $_SESSION['LASTNAME'] ?></span>'s profile
    </div>
    <div class="profile-row">
        <div class="left-col">
            <div class="profile-block">
                <div class="panel profile-photo">
                    <img src="assets/demo/avatars/5.jpg" alt="">
                </div>
            </div>

            <div class="panel panel-transparent">
                <div class="panel-heading">
                    <span class="panel-title">About Me</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item"><strong>Name:</strong> <?php echo $userinfo['FIRSTNAME'] . "  " . $userinfo['SURNAME'] ?></a>
                    <a class="list-group-item"><strong>Email:</strong> <?php echo $userinfo['USER_EMAIL'] ?></a>
                   <a class="list-group-item"><strong>Phone:</strong> <?php echo $userinfo['USER_PHONE'] ?></a>
<!-- 						<a href="#" class="list-group-item"><strong>Farms:</strong> 1</a>
                    <a href="#" class="list-group-item"><strong>Livestock:</strong> 9</a>
                    <a href="#" class="list-group-item"><strong>Sales:</strong> KES 2,300,456.80</a>
                    <a href="#" class="list-group-item"><strong>Expenses:</strong> KES 1,700,345.20</a> -->
                </div>
            </div>

        </div>
        <div class="right-col">
            <hr class="profile-content-hr no-grid-gutter-h">
            <div class="profile-content">
                <ul id="profile-tabs" class="nav nav-tabs">
                    <li class="active">
                        <a href="#profile-details" data-toggle="tab">Edit Info</a>
                    </li>
                    <li>
                        <a href="#profile-password" data-toggle="tab">Change Password</a>
                    </li>
                </ul>
                <!-- User Details Edit-->
                <div class="tab-content tab-content-bordered panel-padding">
                    <div class="tab-pane fade in active" id="profile-details">
                            <form action="exec/auth-exec.php" method="post" name="user" class="form-horizontal" onSubmit="return MM_validateForm()">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="name">Firstname </label>
                                    <div class="col-lg-10">
                                        <input name="fname" type="text" class="form-control" id="fname" value="<?php echo $userinfo["FIRSTNAME"] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="name">Surname </label>
                                    <div class="col-lg-10">
                                        <input name="sname" type="text" class="form-control" id="sname" value="<?php echo $userinfo["SURNAME"] ?>" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="email">Email </label>
                                    <div class="col-lg-10">
                                        <input name="email" type="email" class="form-control" id="email" value="<?php echo $userinfo["USER_EMAIL"] ?>" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="email">Phone Number</label>
                                    <div class="col-lg-10">
                                        <input name="phone" type="text" class="form-control" id="phone" value="<?php echo $userinfo["USER_PHONE"] ?>" required/>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <input name="tag" type="hidden" id="tag" value="editadmin">
                                    <input name="user_id" type="hidden" id="user_id" value="<?php echo $userinfo["USER_ID"] ?>">
                                </div>
                            </form>
                    </div> <!-- !User Details Edit-->

                    <!-- / .tab-pane -->
                    <!-- Password Edit-->

                    <div class="tab-pane fade" id="profile-password">
                        <form action="exec/auth-exec.php" method="post" name="user" class="form-horizontal" onSubmit="return MM_validateForm()">
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="name">Current Password</label>
                                <div class="col-lg-10">
                                    <input name="curr_password" type="password" class="form-control" id="curr_password" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="name">New Password </label>
                                <div class="col-lg-10">
                                    <input name="password" type="password" class="form-control" id="password" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="email">Confrim Password</label>
                                <div class="col-lg-10">
                                    <input name="conf" type="password" class="form-control" id="conf" required/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                                <input name="tag" type="hidden" id="tag" value="editadmin">
                                <input name="user_id" type="hidden" id="user_id" value="<?php echo $userinfo["USER_ID"] ?>">
                            </div>

                        </form>
                    </div> <!-- / .tab-pane -->
                </div> <!-- / .tab-content -->
            </div>
        </div>
    </div>
</div> <!-- / #content-wrapper -->

<?php include_once('footer.php'); ?>
<script type="text/javascript">
    $(function () {
        $("body").addClass("page-profile");
    });
</script>
<script type="text/javascript">
    init.push(function () {
        $('#profile-tabs').tabdrop();
    })
    window.LanderApp.start(init);
</script>