<?php
@session_start();
?>
<!DOCTYPE html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Carsual - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">


        <style>
            #signin-demo {
                position: fixed;
                right: 0;
                bottom: 0;
                z-index: 10000;
                background: rgba(0,0,0,.6);
                padding: 6px;
                border-radius: 3px;
            }
            #signin-demo img { cursor: pointer; height: 40px; }
            #signin-demo img:hover { opacity: .5; }
            #signin-demo div {
                color: #fff;
                font-size: 10px;
                font-weight: 600;
                padding-bottom: 6px;
            }
        </style>
        <!-- / $DEMO -->

    </head>



    <body class="theme-default page-signin">

        <script>
            var init = [];
        </script>
    <script src="assets/demo/demo.js"></script>

        <div id="page-signin-bg">
            <div class="overlay"></div>
            <img src="assets/images/anulogoo.jpeg" width="500" height="1000"> alt=">
        </div>
        <div class="signin-container">

            <div class="signin-info" style="background-color:#00000000;">
                <a href="#" class="logo" >
                    <img src="assets/images/anulogo.jpg" width="100" height="100" alt="">
                   <!-- My<span style="font-weight:100;">Practice</span>-->
                </a>
                <div class="slogan">
                    Carsual Login
                </div>
            </div>
            <div class="signin-form" style="background-color:#00000000;">
                <form action="exec/register-exec.php" method="post" id="signin-form_id">
                    <div class="signin-text">
                        <span>Sign In</span>
                    </div> <!-- / .signin-text -->
                    <?php
                    if (isset($_SESSION['status']) && isset($_SESSION['msg'])) {

                        $invalid = "true";
                        if ($_SESSION['status'] == 'pass') {
                            $alert_msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $_SESSION['msg'] . '</div>';
                        } else if ($_SESSION['status'] == 'fail') {
                            $alert_msg = '<div class="alert alert-warning alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $_SESSION['msg'] . '</div>';
                        } else {
                            $alert_msg = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $_SESSION['msg'] . '</div>';
                        }

                        echo $alert_msg;

                        unset($_SESSION['status']);
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <div class="form-group w-icon">
                        <input type="text" name="username" id="username_id" class="form-control input-lg" placeholder="Username or email">
                        <span class="fa fa-user signin-form-icon"></span>
                    </div>
            <!-- / Username -->

                    <div class="form-group w-icon">
                        <input type="password" name="password" id="password_id" class="form-control input-lg" placeholder="Password">
                        <span class="fa fa-lock signin-form-icon"></span>
                    </div> <!-- / Password -->

                    <div class="form-actions">
                        <input name="tag" type="hidden" value="login" />
                        <input name="type" type="hidden" value="customer" />
                        <input type="submit" value="SIGN IN" class="signin-btn bg-primary" id="login">
                        <!-- <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a> -->

                    </div> <!-- / .form-actions -->
                </form>
                <!-- / Form -->

                <!-- Password reset form -->
                <div class="password-reset-form" id="password-reset-form">
                    <div class="header">
                        <div class="signin-text">
                            <span>Password reset</span>
                            <div class="close">&times;</div>
                        </div> <!-- / .signin-text -->
                    </div> <!-- / .header -->

                    <!-- Form -->
                    <form action="index.html" id="password-reset-form_id">
                        <div class="form-group w-icon">
                            <input type="text" name="password_reset_email" id="p_email_id" class="form-control input-lg" placeholder="Enter your email">
                            <span class="fa fa-envelope signin-form-icon"></span>
                        </div> <!-- / Email -->

                        <div class="form-actions">
                            <input type="submit" value="SEND PASSWORD RESET LINK" class="signin-btn bg-primary">
                        </div> <!-- / .form-actions -->
                    </form>
                    <!-- / Form -->
                </div>
                <!-- / Password reset form -->
            </div>
            <!-- Right side -->
        </div>
        <!-- / Container -->

        <div class="not-a-member">
            Not a member? <a href="signup.php">Sign up now</a>
        </div>


        <script type="text/javascript"> window.jQuery || document.write('<script src="assets/javascripts/jquery.min.js">' + "<" + "/script>");</script>

                <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>


        <script src="assets/javascripts/bootstrap.min.js"></script>
        <script src="assets/javascripts/landerapp.min.js"></script>
        <script src="assets/javascripts/jquery-ui.js"></script>
        <script type="text/javascript">
            init.push(function () {
                var $ph = $('#page-signin-bg'),
                        $img = $ph.find('> img');

                $(window).on('resize', function () {
                    $img.attr('style', '');
                    if ($img.height() < $ph.height()) {
                        $img.css({
                            height: '100%',
                            width: 'auto'
                        });
                    }
                });
            });

            init.push(function () {
                $('#forgot-password-link').click(function () {
                    $('#password-reset-form').fadeIn(400);
                    return false;
                });
                $('#password-reset-form .close').click(function () {
                    $('#password-reset-form').fadeOut(400);
                    return false;
                });
            });

            init.push(function () {
                $("#signin-form_id").validate({focusInvalid: true, errorPlacement: function () {
                    }});

                $("#username_id").rules("add", {
                    required: true,
                    minlength: 3
                });

                $("#password_id").rules("add", {
                    required: true,
                    minlength: 3
                });
            });

            init.push(function () {
                $("#password-reset-form_id").validate({focusInvalid: true, errorPlacement: function () {
                    }});

                $("#p_email_id").rules("add", {
                    required: true,
                    email: true
                });
            });

            window.LanderApp.start(init);
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                var shake = '<?php echo $invalid; ?>';
                if (shake == "true") {
                    $(".alert").slideDown("fast", function () {
                        $('#signin-form_id').effect("shake");
                    });

                }

            });
        </script>
    </body>
</html>
