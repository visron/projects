<?php
//include_once("../classes/signupdb.php");
include_once("../classes/Admins.class.php");

//include_once("OAuth.php");
//$signupdb = new signupdb();
$admin = new Admin();
if(isset($_GET['tag'])){
	$tag = $_GET['tag'];
}
elseif(isset($_POST['tag'])){
	$tag = $_POST['tag'];
}
else{
	header("location:".$_SERVER['HTTP_REFERER']);
}
switch($tag){
		case 'newuser':
	$firstname = $_POST['firstname'];
	$surname = $_POST['surname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	if(isset($_POST['phone'])){
		$phone = $_POST['phone'];

	}else{
		$phone = '';
	}
	$create = $admin->create_user($firstname, $surname, $username, $email, $phone);
	if($create){

	   $_SESSION['status']='pass';
	   $_SESSION['msg']='User has been created!';
	   header("location:../users.php");
	   exit;

	}
	else{
		 $_SESSION['status']='fail';
	    $_SESSION['msg']='An error occured!';
		header("location:".$_SERVER['HTTP_REFERER']); exit;
	}

	break;
        case 'newsignup':
	$firstname = $_POST['fname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
        	$password = $_POST['password'];

	if(isset($_POST['phone'])){
		$phone = $_POST['phone'];

	}else{
		$phone = '';
	}
	$create = $admin->signup($firstname, $username, $email, $phone,$password);
	if($create){

	   $_SESSION['status']='pass';
	   $_SESSION['msg']='User has been created!';
	   header("location:../login.php");
	   exit;

	}
	else{
		 $_SESSION['status']='fail';
	    $_SESSION['msg']='An error occured!';
		header("location:".$_SERVER['HTTP_REFERER']); exit;
	}

	break;
	case 'login':
           
	$username = $_REQUEST['username'];
	$userpassword = $_REQUEST['password'];
       // echo $username."<pass ".$userpassword;
       
	$create = $admin->login_admin($username,$userpassword);
	if($create){
	   $_SESSION['status']='pass';
	   $_SESSION['msg']='Login Successful';
	   header("location:../index.php");
	   exit;

	}
	else{
		 $_SESSION['status']='fail';
	    $_SESSION['msg']='Incorrect usernama or password, try again';
		header("location:".$_SERVER['HTTP_REFERER']); exit;
	}

		break;
}