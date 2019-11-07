<?php

include_once('DBConn.class.php');

class Expenses extends DBConn {

    function createExpense($uid, $ec_id, $date, $purchaser, $supplier, $item, $quantity, $unitcost, $transportcost) {
        if ($transportcost == "") {
            $transportcost = 0;
        }
        $d = date('Y-m-d', strtotime($date));
        $total_cost = ($unitcost * $quantity) + $transportcost;
        return $this->lazyInsert('expenses', array('US_ID', 'EC_ID', 'EX_DATE', 'EX_PURCHASER', 'EX_SUPPLIER', 'EX_ITEM', 'EX_QUANTITY', 'EX_UNIT_COST', 
		'EX_TRANSPORT_COST', 'EX_TOTAL', 'EX_INS_DATE'),
		array($uid, $ec_id, $d, $purchaser, $supplier, $item, $quantity, $unitcost, $transportcost, $total_cost, $this->DBdate));
    }

    function getExpenses_by_user($id) {
        $val = $this->simpleLazySelect('expenses', "where us_id = '$id' and ex_status = 1 order by ex_date desc limit 100");
        return @$val;
    }
	
	function getExpense_Categories(){
		$val = $this->simpleLazySelect('expense_categories', "WHERE EC_STATUS = 1 ORDER BY EC_NAME ASC");
        return @$val;
	}

    function updateExpense($ex_id, $date, $purchaser, $supplier, $item, $quantity, $unitcost, $transportcost) {
        if ($transportcost == "") {
            $transportcost = 0;
        }
        $total_cost = ($unitcost * $quantity) + $transportcost;
        if ($this->lazyUpdate('expenses', array('EX_DATE', 'EX_PURCHASER', 'EX_SUPPLIER', 'EX_ITEM', 'EX_QUANTITY', 'EX_UNIT_COST', 'EX_TRANSPORT_COST', 'EX_TOTAL', 'EX_INS_DATE'), array($date, $purchaser, $supplier, $item, $quantity, $unitcost, $transportcost, $total_cost, $this->DBdate), 'EX_ID', $ex_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function deleteExpense($ex_id) {
        if ($this->lazyUpdate('expenses', array('EX_STATUS'), array(0), 'EX_ID', $ex_id)) {
            return true;
        } else {
            return false;
        }
    }

}

?>