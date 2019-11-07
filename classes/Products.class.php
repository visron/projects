<?php
include_once('DBConn.class.php');
 
 class Products extends DBConn{
	function createProduct($uid, $name){
	 return $this -> lazyInsert('products', array('us_id', 'pr_name', 'pr_ins_date'),array($uid, $name, $this -> DBdate));
	}
	
	function deleteProduct($p_id){
		if($this -> lazyUpdate('products', array('PR_STATUS'), array(0), 'PR_ID', $p_id)){
			return true;
		}else{
			return false;
		}
	}
	
	function updateProduct($id, $name){
		if($this -> lazyUpdate('products', array('pr_name'), array($name), 'pr_id', $id)){
			return true;
		}else{
			return false;
		}
	}
	
	function updateProduct_Pricing($prp_id, $price){
		if($this -> lazyUpdate('product_pricing', array('prp_price'), array($price), 'prp_id', $prp_id)){
			return true;
		}else{
			return false;
		}
	}
	
	function createProduct_Price($pr_id, $uid, $cc_id, $price){
		return $this -> lazyInsert('product_pricing', array('pr_id', 'cc_id', 'us_id', 'prp_price', 'prp_ins_date'),array($pr_id, $cc_id, $uid, $price, $this -> DBdate));
	}
	 
	function deleteProductPrice($prp_id){
		 if($this -> lazyUpdate('product_pricing', array('PRP_STATUS'), array(0), 'PRP_ID', $prp_id)){
			 return true;
		 }else{
			 return false;
		 }
	}
	
	function getProduct($id, $uid){
    	$val = $this -> simpleLazySelect('products', "where pr_id = '$id' and us_id = '$uid' and pr_status = 1");
		return @$val[0];
	}
	
	function get_Products_Only_User($uid){
		$val = $this -> simpleLazySelect('products', "where US_ID = '$uid' and pr_status = 1");
		return @$val;
	}
	
	function getUserProducts($id){
		/*$val = $this -> complexSelect(array("products", "product_pricing", "customer_categories"),array("*"),
		"where products.PR_ID = product_pricing.PR_ID and products.US_ID = '$id' AND 
		product_pricing.US_ID = '$id' AND product_pricing.CC_ID = customer_categories.CC_ID AND products.PR_STATUS = 1 AND 
		product_pricing.PRP_STATUS = 1 order by products.PR_INS_DATE");*/
    	//$val = $this -> simpleLazySelect('products', "where us_id = '$id' and pr_status = 1");
		$val = $this -> complexSelect(array("products", "product_pricing", "customer_categories"),
		array("products.US_ID", "products.PR_ID", "PR_NAME", "PRP_ID", "PRP_PRICE", "customer_categories.CC_ID", "CC_NAME", "CC_DESCRIPTION"),
		"where products.PR_ID = product_pricing.PR_ID and products.US_ID = '$id' AND 
		product_pricing.US_ID = '$id' AND product_pricing.CC_ID = customer_categories.CC_ID AND products.PR_STATUS = 1 AND 
		product_pricing.PRP_STATUS = 1 order by products.PR_INS_DATE");
		return @$val;
	}
	
	function getProductPricing($uid, $pr_id, $cc_id){
    	$val = $this -> simpleLazySelect('product_pricing', "where us_id = '$uid' and pr_id = '$pr_id' and cc_id = '$cc_id' and prp_status = 1");
		return @$val;
	}
 }
 
?>