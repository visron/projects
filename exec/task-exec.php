<?php
include_once("../classes/Tasks.class.php");
//include_once("OAuth.php");
$task = new Tasks();
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
		case 'new_task':
	$name = $_POST['name'];
	$pid = $_POST['project'];
	$status = $_POST['status'];
        $user = $_POST['user'];
        if($status == '1'){
            $progress='25';
        }
         if($status == '2'){
            $progress='50';
        }
         if($status == '3'){
            $progress='75';
        }
         else{
            $progress='100';
        }

	$create = $task->createtasks($name,$progress,$pid,$status,$user);
	if($create){

	   $_SESSION['status']='pass';
	   $_SESSION['msg']='Your Task has been created!';
	   
	}
	else{
		 $_SESSION['status']='fail';
	    $_SESSION['msg']='An error occured!';
		
	}
        header("location:".$_SERVER['HTTP_REFERER']); 
	break;
		case 'new_project':
	$name = $_POST['name'];
	$desc = $_POST['desc'];
	

	$create = $task->createproject($name,$desc);
	if($create){

	   $_SESSION['status']='pass';
	   $_SESSION['msg']='Your Project has been created!';
	   
	}
	else{
		 $_SESSION['status']='fail';
	    $_SESSION['msg']='An error occured!';
		
	}
        header("location:".$_SERVER['HTTP_REFERER']); 
	break;
                case 'edit':
                    $id= $_POST['task_id'];
                    $name = $_POST['name'];
                    $progress = $_POST['progress'];
                    $status = $_POST['status'];
                    $edit= $task->editTask($id, $name, $progress, $status);
                    if($edit){
                                          $_SESSION['status']='pass';
                    $_SESSION['msg']='Your Task has been edited!';}
                    else{
                       $_SESSION['status']='fail'; 
                      $_SESSION['msg']='An error occured!';

                    }
                         header("location:".$_SERVER['HTTP_REFERER']); 
   
                    break;
                case 'delete':
                     $id= $_GET['id'];
                    
                    $edit= $task->deleteTask($id);
                    if($edit){
                     $_SESSION['status']='pass';
                    $_SESSION['msg']='Your Task has been Deleted!';}
                    else{
                       $_SESSION['status']='fail'; 
                      $_SESSION['msg']='An error occured!';

                    }
                         header("location:".$_SERVER['HTTP_REFERER']); 
   
                    break;
	

}
