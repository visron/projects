<?php

include_once 'DBConn.class.php';
define("CUSTOMERS_TBL", "jab_customers");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transactions
 *
 * @author brian
 */
class Transactions extends DBConn {

    //put your code here
    function postTransaction($accountId, $narrative, $amount, $balance) {
        return $this->lazyInsert("jab_transactions", array("ACCOUNT_ID", "TX_NARRATIVE", "TX_AMOUNT", "TX_BALANCE", "USER_ID", "TX_POSTINGDATE"), array($accountId, $narrative, $amount, $balance, $_SESSION['UID'], $this->DBdate));
    }

    function postTransactionAtDisburse($accountId, $narrative, $amount, $balance) {
        
    }

    function openAccount($product, $customerNo, $accountNo, $accountName, $tenure, $appraisal_id) {

        $count = count($this->getAllUserAccounts($customerNo, $product));
        if ($count > 0) {
            $accountNo = $accountNo + $count;
        }

        $sql = $this->lazyInsert("jab_accounts", array("JA_PRODUCTCODE", "JA_CUSTOMERNO", "JA_ACCOUNTNO", "JA_ACCOUNT_NAME", "JA_LOAN_TENURE", "JA_APPRAISAL_ID","JA_INSDATE"), array($product, $customerNo, $accountNo, $accountName, $tenure, $appraisal_id,  $this->DBdate));
        return $sql;
    }

    function getAccounts() {
        return $this->simpleLazySelect("jab_accounts,jab_customers", "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID ORDER BY jab_accounts.JA_ID DESC ");
    }
    
    function getCustomerAccounts() {
        return $this->simpleLazySelect("jab_accounts,jab_customers,jab_appraisals", 
                "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID "
                . "and jab_appraisals.row_id = jab_accounts.JA_APPRAISAL_ID "
                . "and jab_customers.JC_TYPE = 1 "
                . "ORDER BY jab_accounts.JA_ID DESC ");
    }

    function getInternalAccounts() {
        return $this->simpleLazySelect("jab_accounts,jab_customers", "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID and jab_customers.JC_TYPE = 0");
    }

    function getAccountsWithoutMoney() {
        return $this->simpleLazySelect("jab_accounts,jab_customers", "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID and jab_accounts.JA_BOOKBALANCE = 0");
    }

    function getAccount($accountId) {
        $sql = $this->simpleLazySelect("jab_accounts,jab_customers,jab_appraisals", "where jab_appraisals.row_id = jab_accounts.JA_APPRAISAL_ID and jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID and jab_accounts.JA_ID = $accountId");
        return $sql[0];
    }

    function getAllUserAccounts($customerNo, $product) {
        $sql = $this->simpleLazySelect("jab_accounts,jab_customers,jab_appraisals", 
                "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID and jab_accounts.JA_CUSTOMERNO = $customerNo and JA_PRODUCTCODE = '$product' and jab_appraisals.row_id = jab_accounts.JA_APPRAISAL_ID");
        return $sql;
    }

    function getAccountByNo($accountId) {
        $sql = $this->simpleLazySelect("jab_accounts,jab_customers,jab_appraisals", 
                "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID and jab_accounts.JA_ACCOUNTNO = $accountId and jab_appraisals.row_id = jab_accounts.JA_APPRAISAL_ID");
        return @$sql[0];
    }

    function updateCredit($accountId, $amount) {
        return $this->lazyUpdate("jab_accounts", array("JA_CREDITBALANCE"), array($amount, $amount), "JA_ACCOUNTNO", $accountId);
    }

    function updateAccount($accountId, $amount) {
        return $this->lazyUpdate("jab_accounts", array("JA_BOOKBALANCE", "JA_CLEAREDBALANCE"), array($amount, $amount), "JA_ACCOUNTNO", $accountId);
    }

    function disburse($accountId, $narrative, $amount, $creditamount) {
        $account = $this->getAccountByNo($accountId);
        $balance = @$account["JA_BOOKBALANCE"] + $amount;


        $post = $this->postTransaction($accountId, $narrative, $amount, $balance);
        if ($post) {

            if ($this->updateAccount($accountId, $balance)) {
                $this->updateCredit($accountId, $creditamount);
                $this->lazyUpdate("jab_accounts", array("JA_LOAN_APPROVED", "JA_INSDATE"), array(1, $this->DBdate), "JA_ACCOUNTNO", $accountId);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function setLimit($accountId, $amount, $expiry) {
        return $this->lazyUpdate("jab_accounts", array("JA_DEBITLIMIT", "JA_DEBITLIMITEXPIRY"), array($amount, $expiry), "JA_ACCOUNTNO", $accountId);
    }

    function setCustomer($name,$kra,$nat="N/A") {
        return $this->lazyInsert("jab_customers", 
                array('JC_NAME', 'JC_KRAPIN', 'JC_IDPASS','JC_INSDATE'), 
                array($name, $kra, $nat, $this->DBdate));
    }
    //`JO_FNAME`, `JO_SNAME`, `JO_ONAME`, `JO_IDPASS`, `JO_IMAGEPATH`, `JO_NATION`, `JO_SHARES`, `JC_ID`
    function setCustomerOwnership($jc_id, $fname, $sname, $oname,$cust_id,$nation,$shares,$JO_IMAGEPATH){
        return $this->lazyInsert("jab_ownership", array("JO_FNAME", "JO_SNAME", "JO_ONAME", "JO_IDPASS", "JO_NATION", "JO_SHARES", "JC_ID","JO_IMAGEPATH"),
                array($fname, $sname, $oname,$cust_id,$nation,$shares,$jc_id,$JO_IMAGEPATH));
    }
    function getCustomerOwners($jc_id){
        return $this->simpleLazySelect("jab_ownership", "where JC_ID = $jc_id ORDER BY JO_SHARES DESC");
    }

    function getCustomers() {
        return $this->simpleLazySelect("jab_customers", "where JC_TYPE = 1 order by JC_ID DESC");
    }
    //     function getCustomers() {
    //     return $this->simpleLazySelect("jab_customers", "where JC_IDPASS !='' and JC_KRAPIN !='' ORDER BY JC_INSDATE DESC");
    // }

    function getAllTransactions() {
        return $this->simpleLazySelect("jab_transactions", "order by ID DESC");
    }

    function getTransactions($accountId) {
        return $this->simpleLazySelect("jab_transactions,jab_accounts", "where jab_transactions.ACCOUNT_ID=jab_accounts.JA_ACCOUNTNO and jab_transactions.ACCOUNT_ID=$accountId order By TX_DATE DESC");
    }

    function getProducts() {
        return $this->simpleLazySelect("jab_products", "");
    }

    function setReqLoan($customerId, $product, $amount) {
        return $this->lazyUpdate("jab_customers", array("JC_LOAN", "JC_PRODUCT"), array($amount, $product), "JC_ID", $customerId);
    }

    function getProductByCode($code) {
        $sql = $this->simpleLazySelect("jab_products", " where JP_CODE = $code");
        return @$sql[0];
    }

    function getPendingLoans() {
        return $this->simpleLazySelect("jab_accounts ja,jab_customers jc", "where ja.JA_LOAN_APPROVED = 0 and ja.JA_CUSTOMERNO = jc.JC_ID and jc.JC_TYPE = 1");
    }

    function getIssuedLoans() {
        return $this->simpleLazySelect("jab_accounts ja,jab_customers jc", "where ja.JA_LOAN_APPROVED = 1 and ja.JA_CUSTOMERNO = jc.JC_ID");
    }

    function setAppraisal($customer_id) {
        return $this->lazyInsert("jab_appraisals", array("customer_id"), array($customer_id), "");
    }

    function appraiseCustomer($appraisal_id,
            $purpose,
            $notes, 
            $instrument_amount, 
            $disbursable_amount, 
            $loan_tenure, 
            $interest, 
            $security_notes, 
            $security_doc,
            $expirationdate,
            $customer_background,
            $recommendation, 
            $account_analysis, 
            $processing_fee, 
            $customer_id, 
            $product_code, 
            $security_doc_no, 
            $fmi_recovery, 
            $Industry, 
            $Market_and_Competition, 
            $Site_Visit_Report,
            $Justification, 
            $Strengths,
            $Weakness, 
            $schemes) {

        $new_appraise = $this->lazyUpdate("jab_appraisals", array("purpose", 
            "notes", 
            "instrument_amount",
            "disbursable_amount",
            "loan_tenure", 
            "interest", 
            "security_notes",            
            "security",
            "expirationdate",
            "customer_background", 
            "recommendation", 
            "account_analysis", 
            "processing_fee", 
            "customer_id", 
            "product_code", 
            "security_doc_no",
            "fmi_recovery", 
            "schemes",
            "industry", 
            "market",
            "site_visit", 
            "justification", 
            "strengths", 
            "weakness",
            "ro",
            "status",
            "ro_insdate"
            ), array($purpose,
                $notes, 
                $instrument_amount, 
                $disbursable_amount, 
                $loan_tenure, 
                $interest, 
                $security_notes,
                $security_doc,
                $expirationdate,
                $customer_background, 
                $recommendation, 
                $account_analysis, 
                $processing_fee, 
                $customer_id, 
                $product_code, 
                $security_doc_no, 
                $fmi_recovery, 
                $schemes,
                $Industry, 
                $Market_and_Competition, 
                $Site_Visit_Report, 
                $Justification, 
                $Strengths, 
                $Weakness,
                $_SESSION["UID"],
                1,
                $this->DBdate
                ), "row_id", $appraisal_id);

        if ($new_appraise) {
            $this->Log("Created new Appraisal");
            return $new_appraise;
        } else {
            return false;
        }
    }



    function updateAppraisal($security_doc_no,$security_doc_type,$instrument_amount,$expirationdate,$appraisal_id) {
        return $this->lazyUpdate("jab_appraisals", array("security_doc_no","security","instrument_amount","expirationdate"), array($security_doc_no,$security_doc_type,$instrument_amount,$expirationdate),"row_id",$appraisal_id);
    }

    function getAppraisal($appraisal_id) {
        $sql = $this->simpleLazySelect("jab_customers,jab_appraisals", "where jab_customers.JC_ID = jab_appraisals.customer_id and jab_appraisals.row_id = $appraisal_id");
        return $sql[0];
    }

    function getAppraisals() {
        $sql = $this->simpleLazySelect("jab_customers,jab_appraisals", "where jab_customers.JC_ID = jab_appraisals.customer_id and jab_appraisals.status = 5");
        return $sql;
    }
    
    function updateApproval($appraisal_id,$status,$notesCol,$notes,$stageCol,$approvedLimit){
        return $this->lazyUpdate("jab_appraisals", array("instrument_amount","status",$notesCol,$stageCol,$stageCol."_insdate"), array($approvedLimit,$status,$notes,$_SESSION['UID'],  $this->DBdate), "row_id", $appraisal_id);
    }

    function setTurnover($appraisal_id, $month, $credit, $debit) {
        return $this->lazyInsert("jab_turnover", array("appraisal_id", "jt_month", "jt_credit", "jt_debit"), array($appraisal_id, $month, $credit, $debit), "");
    }

    function getAppraisalsForApproval() {
        return $this->simpleLazySelect("jab_appraisals,jab_customers", 
                "WHERE jab_appraisals.customer_id = jab_customers.JC_ID and jab_appraisals.status > 0 and jab_appraisals.status < 10 ORDER BY jab_appraisals.ro_insdate DESC");
    }

    function getAppraisalsForApprovalOne($appraisal_id) {
        $sql = $this->simpleLazySelect("jab_appraisals,jab_customers", "WHERE jab_appraisals.customer_id = jab_customers.JC_ID and jab_appraisals.row_id=$appraisal_id ");

        return $sql[0];
    }
    function getDeclinedAppraisals(){
      return $this->simpleLazySelect("jab_appraisals,jab_customers", "WHERE jab_appraisals.customer_id = jab_customers.JC_ID and jab_appraisals.status > 5 and jab_appraisals.status < 7 ");
    }
      function getDefferedAppraisals(){
      return $this->simpleLazySelect("jab_appraisals,jab_customers", "WHERE jab_appraisals.customer_id = jab_customers.JC_ID and jab_appraisals.status > 7");
    }

    function getTurnovers($appraisal_id) {
        return $this->simpleLazySelect("jab_turnover", "where appraisal_id = $appraisal_id");
    }
    function setRefund($accountNo, $transactionId, $paymentFrom,$dateOfPayment){
      //`TX_ID``JA_ACCOUNTNO``JRP_FROM``JRP_PAYDATE``JRP_INSDATE`
      return $this->lazyInsert("jab_repayments", 
              array("TX_ID","JA_ACCOUNTNO","JRP_FROM","JRP_PAYDATE"), 
              array($transactionId,$accountNo,$paymentFrom,$dateOfPayment));
  }
  function updateRefund($repayID,$col,$status,$notes){
      $colDate = $col;
      $notesCol = "JRP_NOTES";
      if($col == 'CHECK'){
          $col = "CHECKE";
          //$colDate = "CHECK"
      }
      if ($col != "MAKE") {
            $notesCol = "JRP_COMMENTS";
        }
      
      return $this->lazyUpdate("jab_repayments", 
              array("JRP_".$col."R","JRP_".$colDate."DATE","JRP_STATUS",$notesCol),
              array($_SESSION['UID'],  $this->DBdate,$status,$notes), "JRP_ID", $repayID);
  }
  function getRefundsList(){
      return $this->simpleLazySelect("jab_accounts,jab_customers,jab_repayments, jab_transactions", 
                "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID "
                . "and jab_repayments.JA_ACCOUNTNO = jab_accounts.JA_ACCOUNTNO "
                . "and jab_transactions.ID = jab_repayments.TX_ID "
                . "ORDER BY jab_repayments.JRP_ID DESC ");
  }
  //   function getRefundsList(){
  //     return $this->simpleLazySelect("jab_accounts,jab_customers,jab_repayments, jab_transactions","jab_appraisals", 
  //               "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID "
  //               . "and jab_repayments.JA_ACCOUNTNO = jab_accounts.JA_ACCOUNTNO "
  //               . "and jab_transactions.ID = jab_repayments.TX_ID "
  //               . "and jab_appraisals.customer_id = jab_customers.JC_ID"
  //               . "ORDER BY jab_repayments.JRP_ID DESC ");
  // }
  function getRefundDetails($jrp_id){
      $sql = $this->simpleLazySelect("jab_accounts,jab_customers,jab_repayments, jab_transactions, jab_appraisals", 
                "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID "
                . "and jab_repayments.JA_ACCOUNTNO = jab_accounts.JA_ACCOUNTNO "
                . "and jab_transactions.ID = jab_repayments.TX_ID "
                . "and jab_appraisals.row_id = jab_accounts.JA_APPRAISAL_ID "
                . "and jab_repayments.JRP_ID=$jrp_id ");
      return $sql[0];
  }
  function getDeclinedRefunds(){
      return $this->simpleLazySelect("jab_accounts,jab_customers,jab_repayments, jab_transactions", 
                "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID "
                . "and jab_repayments.JA_ACCOUNTNO = jab_accounts.JA_ACCOUNTNO "
                . "and jab_transactions.ID = jab_repayments.TX_ID "
                . "ORDER BY jab_repayments.JRP_ID DESC ");
  }
  
    function getCustomersInTheDB(){
        return $this->simpleLazySelect("jab_customers", "");
    }
    function getCustomersWithoutAccounts(){
        return $this->lazyBlank("select * from jab_customers where JC_ID NOT IN (SELECT JA_CUSTOMERNO FROM jab_accounts)");
        //return $this->simpleLazySelect("jab_customers, jab_accounts", "where jab_customers.JC_ID != jab_accounts.JA_CUSTOMERNO");
    }
    function getInternalCustomers(){
        return $this->simpleLazySelect("jab_customers", "where JC_TYPE = 0");
    }
    function setCustomerDoc($customer_id,$document_path,$document_type){
        //`JC_ID`,`JD_TYPE`,`JD_PATH`
        if($document_type == 'AVATAR'){
            $column = 'JC_ID';
        }else{
            $column = 'APPRAISAL_ID';
        }
        return $this->lazyInsert("jab_documentpaths",array($column,'JD_TYPE','JD_PATH'), array($customer_id,$document_type,$document_path));
           
    }

}

?>