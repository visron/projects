<?php
@require_once('DBConn.class.php');

class Notificationizer extends DBConn{

	function notify($from,$to,$body,$url){
		$notify = $this->lazyInsert("notificationizer",array("Nt_from","Nt_to","Nt_body","Nt_url","Nt_instime","Nt_viewed"),array($from,$to,$body,$url,$this->DBdate,"0"),"");
		if($notify){
			return $notify;
		}
		else{
			return false;
		}
	}
	
	function setAsRead($id){
		$setAsRead = $this->lazyUpdate("notificationizer",array("Nt_viewed"),array("1"),"Nt_id",$id);
		
		if($setAsRead){
			
			return $setAsRead;
		}
		else{
			return false;
		} 
	}

	function fetchNotifications($userId){
		return $this->simpleLazySelect("notificationizer","WHERE Nt_to='$userId' AND Nt_viewed = 0");
	}
}


?>