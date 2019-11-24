<?php
include_once ("DBConn.class.php");
class Tasks extends DBConn{

  function createtasks($name,$progress,$status,$pid,$user)
  {
    $login = $this->lazyInsert('tasks',array("T_NAME","T_PROGRESS","T_STATUS","P_ID","US_ID"),array($name,$progress,$status,$pid,$user));
    return $login;
  }
   function createproject($name,$desc)
  {
    $newproj = $this->lazyInsert('project',array("P_NAME","P_DESC"),array($name,$desc));
    return $newproj;
  }
  function getTasks(){
      $tasks = $this->simpleLazySelect("project", "Where P_STATUS =1");
      return @$tasks;
  }
  function getTasksSum($id){
      $avg = $this->lazySum('tasks', "T_PROGRESS", "WHERE T_STATUS = 1 AND P_ID = '$id'");
      return $avg;
  }
  function getTasksCount($id){
   $count = $this->countLazySelect('tasks', "WHERE T_STATUS = 1 AND P_ID = '$id'");
   return $count;
  }
  function getTask($id){
      $tasks = $this->simpleLazySelect("tasks", "Where T_ID = '$id'");
      return @$tasks;
  }
  function editTask($id,$name,$progress,$status){
        return $this->lazyUpdate("tasks", array("T_NAME","T_PROGRESS","T_STATUS"), array($name,$progress,$status), "T_ID", $id);
  }
  function deleteTask($id){
        return $this->lazyUpdate("tasks", array("T_STATUS"), array('0'), "T_ID", $id);
  }
}
 ?>
