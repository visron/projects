<?php
include_once("../signupdb.php");
//include_once("OAuth.php");
$signupdb = new signupdb();
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
	$username = $_POST['email'];
	if(isset($_POST['phone'])){
		$phone = $_POST['phone'];

	}else{
		$phone = '';
	}
	$create = $signupdb->createuser($username,$password,$fname,$lname,$email,$phone);
	if($create){

	   $_SESSION['status']='pass';
	   $_SESSION['msg']='Your Account has been created!';
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
       
	$create = $signupdb->login($username,$userpassword);
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
