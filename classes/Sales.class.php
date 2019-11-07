<?php
include_once('DBConn.class.php');
 
 class Sales extends DBConn{
	function createSale($uid, $cid, $date, $pr_id, $cc_id, $litres, $unit, $total){
		 $d = date('Y-m-d',strtotime($date));
		 if($this -> lazyInsert('dairy_sales', array('us_id', 'c_id', 'ds_date', 'pr_id', 'cc_id', 'ds_litres', 'ds_per_litre', 'ds_total', 'ds_ins_date'),array($uid, $cid, $d, $pr_id, $cc_id, $litres, $unit, $total, $this -> DBdate))){
			 return true;
		 }else{ 
			 return false;
		 }
	}
					
	function updateCustomerStatement($uid, $cid, $date, $unit, $litres, $total){
		$d = date('Y-m', strtotime($date));
		$val = $this -> simpleLazySelect('customer_statement', "where c_id = '$cid' and cs_date = '$d' and cs_status = 1");
		if($val){
			$new_l = $val[0]['CS_LITRES'] + $litres;
			$new_tc = $val[0]['CS_TOTAL_COST'] + $total;
			$new_bal = $val[0]['CS_BALANCE'] + $total;
			//$this -> lazyUpdate2('customer_statement', array('cs_litres', 'cs_total_cost', 'cs_balance'), array($new_l, $new_tc, $new_bal), 'c_id', 'cs_date', $cid, $d);
			$this -> lazyUpdate2('customer_statement', array('cs_total_cost', 'cs_balance'), array($new_tc, $new_bal), 'c_id', 'cs_date', $cid, $d);
			return true;
		}else{
			//$this -> lazyInsert('customer_statement', array('us_id', 'c_id', 'cs_date', 'cs_price', 'cs_litres', 'cs_total_cost', 'cs_total_paid', 'cs_balance', 'cs_ins_date'),array($uid, $cid, $d, $unit, $litres, $total, '0', $total, $this -> DBdate));
			$this -> lazyInsert('customer_statement', array('us_id', 'c_id', 'cs_date', 'cs_total_cost', 'cs_total_paid', 'cs_balance', 'cs_ins_date'),array($uid, $cid, $d, $total, '0', $total, $this -> DBdate));
			return true;
		}
	}
	
	function updateMilk_Inventory_Sale($us_id, $date, $litres){
		$val = $this -> simpleLazySelect('milk_inventory', "where US_ID = '$us_id' AND MI_DATE = '$date' AND MI_STATUS = 1");
		if($val){
			$mi_id = $val[0]['MI_ID'];
			$new_remaining = $val[0]['MI_REMAINING'] - $litres;
			$new_sold = $val[0]['MI_SOLD'] + $litres;
			if($this -> lazyUpdate('milk_inventory', array('MI_SOLD', 'MI_REMAINING', 'MI_INS_DATE'), array($new_sold, $new_remaining, 
				$this -> DBdate), 
				'mi_id', $mi_id)){
				return true;
			}else{
				return false;
			}
		}else{
			return $this -> lazyInsert('milk_inventory', array('us_id', 'f_id', 'mi_date', 'mi_sold', 'mi_remaining', 'mi_ins_date'), 
			array($us_id, "0", $date, $litres, '-'.$litres, $this -> DBdate));
		}
	}
	
	function getSales_by_user($id){
            //$val = $this -> complexSelect(array("dairy_sales", "products", "customers"),array("*"), "where dairy_sales.C_ID = customers.C_ID and dairy_sales.PR_ID = products.PR_ID and dairy_sales.US_ID = '$id' and dairy_sales.DS_STATUS = 1 order by dairy_sales.DS_DATE desc limit 100");
            $val = $this -> complexSelect(array("dairy_sales", "products", "customers"),
			array("DS_ID", "customers.C_ID", "dairy_sales.US_ID", "DS_DATE", "C_NAME", "PR_NAME", "DS_LITRES", "DS_PER_LITRE", "DS_TOTAL"), 
			"WHERE dairy_sales.C_ID = customers.C_ID AND dairy_sales.PR_ID = products.PR_ID AND dairy_sales.US_ID = '$id' AND dairy_sales.DS_STATUS = 1 
			ORDER BY dairy_sales.DS_DATE DESC LIMIT 100");
			return @$val;
	}
	
	function getCustomer_Sales_Records_by_user($us_id, $c_id, $cs_id, $cs_date){
            $val = $this -> complexSelect(array("customers", "products", "dairy_sales"),array("*"),"where customers.C_ID = '$c_id' AND dairy_sales.C_ID = customers.C_ID AND 
            dairy_sales.PR_ID = products.PR_ID AND YEAR(dairy_sales.DS_DATE) = YEAR(STR_TO_DATE('$cs_date', '%Y-%m-%d')) AND MONTH(dairy_sales.DS_DATE) = 
            MONTH(STR_TO_DATE('$cs_date', '%Y-%m-%d')) AND dairy_sales.DS_STATUS = 1");
            return @$val;
	}
 }
?>