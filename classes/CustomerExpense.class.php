<?php

/**
 * Description of CustomerExpense
 * Class is used to get user expenses
 * @author ELITEBOOK 840
 */
include_once 'DBConn.class.php';
class CustomerExpense extends DBConn {
    
    function getAllExpenses() {
        return $this->simpleLazySelect('mobo_expence', 'where STATUS=1');
    }
    function deactivateExpense($expense_id){
        return $this->lazyUpdate('mobo_expence',array("0"),'EXP_ID',$expense_id );
    }
    
}
?>