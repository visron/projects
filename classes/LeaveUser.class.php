<?php
include_once('DBConn.class.php');

class LeaveUser extends DBConn {
    function createUser($fname,$lname,$mname,$dept,$sect,$ctrl,$permissions){
        
        $val  = $this->lazyInsert('tb_sec_leave_user',
                array('userpfnumber','fname','lname','mname','deptname','Sect_name','ctrl_officer_empid','userpermissions'),
                array('1',$fname,$lname,$mname,$dept,$sect,$ctrl,$permissions));
        return $val;
        
        }
     function getSections($id) {
        return $this->simpleLazySelect("tb_hur_sections", "where deptId_fk =  $id");
    }
    /*
    @emp_id
    @bal
     */
    function addLeaveBalancestouser($empid,$bal){
        
        $val = $this->lazyInsert("tb_leave_balance", array('empid_fk','dateupdated','lvbal'),
                array($empid,$this->DBdate,$bal));
        return $val;
    }
    function AddEmpDetails(){
        
    }
    function checkExistenceofEmoId(){
        
    }
    function ApplyLeave($empid,$start,$end,$days){
        $val = $this->lazyInsert("tb_leave_application", array('empid_fk','Appfrom','AppTo','appdays','status','AppDate'),
                array($empid,$start,$end,$days,'NEW',$this->DBdate));
        $action = "Leave Applied by user id : $empid -  days : $days application id : $val";
        $user_ID = $_SESSION['UID'];
        $this->Log($action, $user_ID);
        return $val;
    }
      function cancel($id) {
        return $this->lazyUpdate('tb_leave_application', array('status'), array("CANCELLED"), 'appid', $id);
    }

    function getLeave($uid){
        $val = $this->simpleLazySelect('tb_leave_application',"WHERE empid_fk = $uid ");
        return $val;
    }
    function getLeaveDetails($id){
        $val = $this->simpleLazySelect('tb_leave_application',"WHERE appid = $id ");
        return @$val[0];
    }

    function getOfficersLeaves($uid){
        $val = $this->simpleLazySelect('tb_leave_application',"WHERE empid_fk = $uid AND status LIKE %NEW%");
        return $val;
    }

    function approveLeave($id){
         return $this->lazyUpdate('tb_leave_application', array('status','ApprovalDate'), array("APPROVED",$this->DBdate), 'appid', $id);

    }
    function recallLeave($id){
         return $this->lazyUpdate('tb_leave_application', array('status','ApprovalDate'), array("RECALLED",$this->DBdate), 'appid', $id);

    }
    function subtractbalance($empid,$value){
               return $this->lazyUpdate('tb_leave_balance', array('lvbal','dateupdated'), array($value,$this->DBdate), 'empid_fk', $empid);
  
    }

    function denyLeave($id){
        $val = $this->lazyUpdate('tb_leave_application',array('status'),array("REJECTED"),'appid',$id);
        return $val;
    }
    function rejectleavenotes($id,$message){
        $val = $this->lazyInsert("tb_leave_reason", array('appid','Reason','R_DATE'),
                array($id,$message,$this->DBdate));
        return $val;
    }
    function getLeaveBalance($empid){
         $val = $this->simpleLazySelect('tb_leave_balance',"WHERE empid_fk = $empid ");
        return @$val[0];
    }
    function getLeaveTypes(){
         $val = $this->simpleLazySelect('tb_leave_type',"WHERE TYPE_STATUS = 1 ");
        return @$val;
    }
    
    
}
?>

