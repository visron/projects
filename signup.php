<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ITECH - Sign Up</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

	<link href="assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">


	<style>
		#signup-demo {
			position: fixed;
			right: 0;
			bottom: 0;
			z-index: 10000;
			background: rgba(0,0,0,.6);
			padding: 6px;
			border-radius: 3px;
		}
		#signup-demo img { cursor: pointer; height: 40px; }
		#signup-demo img:hover { opacity: .5; }
		#signup-demo div {
			color: #fff;
			font-size: 10px;
			font-weight: 600;
			padding-bottom: 6px;
		}
	</style>

</head>



<body class="theme-default page-signup">

<script>
	var init = [];
</script>
<script src="assets/demo/demo.js"></script>

	<!-- Page background -->
	<div id="page-signup-bg">
		<!-- Background overlay -->
		<div class="overlay"></div>
		<!-- Replace this with your bg image -->
		<img src="assets/images/bg2.jpeg" alt="">
	</div>
	<!-- / Page background -->

	<!-- Container -->
	<div class="signup-container" style="background-color:#00000000;">
		<!-- Header -->
		<div class="signup-header" style="background-color:#00000000;">
			<a href="index.php" class="logo">
				I TECH SIGNUP<span style="font-weight:100;"> </span>
			</a> <!-- / .logo -->
			<div class="slogan">
				For you by you.
			</div> <!-- / .slogan -->
		</div>
		<!-- / Header -->

		<!-- Form -->
		<div class="signup-form" style="background-color:#00000000;">
                    <form action="exec/register-exec.php" id="signup-form_id" method="post" >

				<div class="signup-text">
					<span>Create an account</span>
				</div>
                                <div class="form-group w-icon">
					<input type="text" name="username" id="us_name_id" class="form-control input-lg" placeholder="Username">
					<span class="fa fa-info signup-form-icon"></span>
				</div>

				<div class="form-group w-icon">
					<input type="text" name="fname" id="fname_id" class="form-control input-lg" placeholder="Firstname">
					<span class="fa fa-info signup-form-icon"></span>
				</div>
				
				<div class="form-group w-icon">
					<input type="text" name="email" id="email_id" class="form-control input-lg" placeholder="E-mail">
					<span class="fa fa-envelope signup-form-icon"></span>
				</div>
				<div class="form-group w-icon">
					<input type="text" name="phone" id="email_id" class="form-control input-lg" placeholder="+254...">
					<span class="fa fa-mobile-phone signup-form-icon"></span>
				</div>

				<!-- <div class="form-group w-icon">
					<input type="text" name="signup_username" id="username_id" class="form-control input-lg" placeholder="Username">
					<span class="fa fa-user signup-form-icon"></span>
				</div> -->

				<div class="form-group w-icon">
					<input type="password" name="password" id="password_id" class="form-control input-lg" placeholder="Password">
					<span class="fa fa-lock signup-form-icon"></span>
				</div>
				<div class="form-group w-icon">
					<input type="password" name="cpassword" id="password_id" class="form-control input-lg" placeholder="Confirm Password">
					<span class="fa fa-lock signup-form-icon"></span>
				</div>

				<div class="form-group" style="margin-top: 20px;margin-bottom: 20px;">
					<label class="checkbox-inline">
						<input type="checkbox" name="signup_confirm" class="px" id="confirm_id">
						<span class="lbl">I agree with the <a href="#" target="_blank">Terms and Conditions</a></span>
					</label>
				</div>

				<div class="form-actions">
					<input type="submit" value="SIGN UP" class="signup-btn bg-primary">
					<input type="hidden" name="tag" value="newsignup">
				</div>
			</form>
			<!-- / Form -->

			<!-- "Sign In with" block -->
	<!-- 		<div class="signup-with">
				<!-- Facebook -->
				<!-- <a href="index.html" class="signup-with-btn" style="background:#4f6faa;background:rgba(79, 111, 170, .8);">Sign Up with <span>Facebook</span></a>
			</div> -->
			<!-- / "Sign In with" block -->
		</div>
		<!-- Right side -->
	</div>

		<div class="have-account">
		Already have an account? <a href="login.php">Sign In</a>
	</div>


<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="assets/javascripts/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- LanderApp's javascripts -->
<script src="assets/javascripts/bootstrap.min.js"></script>
<script src="assets/javascripts/landerapp.min.js"></script>

<script type="text/javascript">
	// Resize BG
	init.push(function () {
		$("#signup-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

		// Validate name
		$("#name_id").rules("add", {
			required: true,
			minlength: 1
		});

		// Validate email
		$("#email_id").rules("add", {
			required: true,
			email: true
		});

		// Validate username
		$("#username_id").rules("add", {
			required: true,
			minlength: 3
		});

		// Validate password
		$("#password_id").rules("add", {
			required: true,
			minlength: 6
		});

		// Validate confirm checkbox
		$("#confirm_id").rules("add", {
			required: true
		});
	});

	window.LanderApp.start(init);
</script>

</body>
</html>
