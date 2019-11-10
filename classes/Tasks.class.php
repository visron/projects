<?php
include_once ("DBConn.class.php");
class Tasks extends DBConn{

  function createtasks($name,$progress,$status,$pid)
  {
    $login = $this->lazyInsert('tasks',array("T_NAME","T_PROGRESS","T_STATUS","P_ID"),array($name,$progress,$status,$pid));
    return $login;
  }
  function getTasks(){
      $tasks = $this->simpleLazySelect("project", "Where P_STATUS =1");
      return @$tasks;
  }
}
 ?>
