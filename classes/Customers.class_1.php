<?php

include_once('DBConn.class.php');

class Customers extends DBConn {

    function createCustomer($uid, $name, $number, $category, $days) {
        return $this->lazyInsert('customers', array('us_id', 'c_name', 'c_number', 'cc_id', 'c_frequency', 'c_ins_date'), array($uid, $name, $number, $category, $days, $this->DBdate));
    }

    function createCustomer_Category($uid, $name, $decription) {
        return $this->lazyInsert('customer_categories', array('us_id', 'cc_name', 'cc_description', 'cc_ins_date'), array($uid, $name, $decription, $this->DBdate));
    }

    function deleteCustomer($c_id) {
        if ($this->lazyUpdate('customers', array('C_STATUS'), array(0), 'C_ID', $c_id)) {
            return true;
        } else {
            return false;
        }
    }
	
	function getUserCount(){
		return $this -> countLazySelect("users", "");
	}

    function updateCustomer($id, $name, $number, $category, $days) {
        if ($this->lazyUpdate('customers', array('C_NAME', 'C_NUMBER', 'CC_ID', 'C_FREQUENCY'), array($name, $number, $category, $days), 'C_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }

    function updateCustomer_Category($id, $name, $description) {
        if ($this->lazyUpdate('customer_categories', array('CC_NAME', 'CC_DESCRIPTION'), array($name, $description), 'CC_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteCustomerCategory($cc_id) {
        if ($this->lazyUpdate('customer_categories', array('CC_STATUS'), array(0), 'CC_ID', $cc_id)) {
            return true;
        } else {
            return false;
        }
    }

    function getAllCustomers() {
        $val = $this->simpleLazySelect('customers', "where c_status = 1");
        return @$val;
    }

    function getCustomer($id) {
        $val = $this->simpleLazySelect('customers', "where c_id = '$id' and c_status = 1");
        return @$val[0];
    }

    function getCustomer_by_user($id) {
        $val = $this->complexSelect(array("customers", "customer_categories"), array("*"), "where customers.CC_ID = 
		customer_categories.CC_ID and customers.US_ID = '$id' and customers.C_STATUS = 1 ORDER BY customers.C_NAME ASC");
        return @$val;
    }

    function getUser_Customer_Category($uid) {
        $val = $this->simpleLazySelect('customer_categories', "where us_id = '$uid' and cc_status = 1");
        return @$val;
    }

    function getCustomer_Category($cc_id, $uid) {
        $val = $this->simpleLazySelect('customer_categories', "where us_id = '$uid' and cc_id = '$cc_id' and cc_status = 1");
        return @$val[0];
    }

    function getCustomerStatement_by_user($id, $c_id) {
        $val = $this->complexSelect(array("customers", "customer_statement"), array("*"), "where customer_statement.C_ID = '$c_id' and customer_statement.C_ID = customers.C_ID and customer_statement.US_ID = '$id' and customer_statement.CS_STATUS = 1");
        return @$val;
    }

    function getUser_Customer_Statement($uid) {
        //$val = $this->complexSelect(array("customers", "customer_statement"), array("*"), "where customer_statement.C_ID = customers.C_ID and customer_statement.US_ID = '$uid' and customer_statement.CS_STATUS = 1 ORDER BY customer_statement.CS_DATE DESC");
        $val = $this->complexSelect(array("customers", "customer_statement"), 
		array("CS_ID", "customer_statement.US_ID", "customers.C_ID", "CS_DATE", "CS_DATE", "C_NAME", "CS_TOTAL_COST", "CS_TOTAL_PAID", "CS_BALANCE", 
		"CS_INS_DATE"), 
		"WHERE customer_statement.C_ID = customers.C_ID AND customer_statement.US_ID = '$uid' AND customer_statement.CS_STATUS = 1 ORDER BY customer_statement.CS_DATE DESC");
		return @$val;
    }

}

?>