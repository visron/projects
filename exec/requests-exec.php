<?php
include_once("../classes/requests.class.php");

$request = new Requests();
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
		case 'new_request':
	$name = $_POST['name'];
	$number = $_POST['number'];
	$from = $_POST['from'];
	$to = $_POST['to'];
	$uid = $_POST['userid'];
	
	$create = $request->createRequest($name, $number, $from, $to,$uid);
	if($create){

	   $_SESSION['status']='pass';
	   $_SESSION['msg']='Request has been created!';
	   header("location:../view_requests.php");
	   exit;

	}
	else{
		 $_SESSION['status']='fail';
	    $_SESSION['msg']='An error occured!';
		header("location:".$_SERVER['HTTP_REFERER']);
		 exit;
	}

	break;
	case 'delete':
		$id = $_REQUEST['id'];
		$editRequest = $request->deleteRequest($id);

		if($editRequest){

			$_SESSION['status']='pass';
			$_SESSION['msg']='Request has been cancelled!';
			header("location:../view_requests.php");
			exit;
	 
		 }
		 else{
			  $_SESSION['status']='fail';
			 $_SESSION['msg']='An error occured!';
			 header("location:".$_SERVER['HTTP_REFERER']);
			  exit;
		 }
		break;
		case 'edit':
			$id = $_REQUEST['request_id'];
			$name = $_REQUEST['name'];
			$number = $_REQUEST['number'];
			$from = $_REQUEST['pickup'];
			$to = $_REQUEST['destination'];
			$status = $_REQUEST['status'];
			$editRequest = $request->editRequest($id,$name,$number,$from,$to,$status);
	
			if($editRequest){
	
				$_SESSION['status']='pass';
				$_SESSION['msg']='Request has been cancelled!';
				header("location:../view_requests.php");
				exit;
		 
			 }
			 else{
				  $_SESSION['status']='fail';
				 $_SESSION['msg']='An error occured!';
				 header("location:".$_SERVER['HTTP_REFERER']);
				  exit;
			 }
			break;
		
	}
	

