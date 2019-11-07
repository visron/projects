<?php
include_once 'DBConn.class.php';
class reports extends DBConn {

    function getCustomers($start, $end) {
        return $this->simpleLazySelect("customers", 
                "where CS_STATUS = 1 and DATE(CS_INS_DATE) BETWEEN '$start' AND '$end'  order by CS_ID DESC");
    }
    function getapplications($start, $end) {
        return $this->simpleLazySelect("tb_leave_application", 
                "where Leave_Type = 'ANNUAL'");
    }
     function getAuditTrial() {
        return $this->simpleLazySelect("audit_trail", 
                "where AT_VISIBLE = '1'");
    }
     function getSMSReports() {
        return $this->simpleLazySelect("smsrecords", 
                "where SMS_VISIBLE = '1'");
    }


    function getSecurityDocs($start, $end) {
        return $this->simpleLazySelect("jab_appraisals ja,jab_customers jc", "where ja.security !='' and jc.JC_ID=ja.customer_id and DATE(jc.JC_INSDATE) BETWEEN '$start' AND '$end'");
    }

    function loanRepayments($start, $end) {
        return $this->simpleLazySelect("jab_repayments jp", " where DATE(jp.JRP_INSDATE) BETWEEN '$start' AND '$end'");
    }

    function customeraccounts($start, $end) {
        return $this->simpleLazySelect("jab_customers jc", "where DATE(jc.JC_INSDATE) BETWEEN '$start' AND '$end'");
    }

    function customeraccounts1($start, $end) {
        return $this->simpleLazySelect("jab_customers jc,jab_appraisals ja", "where DATE(jc.JC_INSDATE) BETWEEN '$start' AND '$end'and jc.JC_ID=ja.customer_id");
    }

    function getRefundsList($start, $end) {
        return $this->simpleLazySelect("jab_accounts,jab_customers,jab_repayments, jab_transactions", "where jab_accounts.JA_CUSTOMERNO = jab_customers.JC_ID "
                        . "and jab_repayments.JA_ACCOUNTNO = jab_accounts.JA_ACCOUNTNO "
                        . "and jab_transactions.ID = jab_repayments.TX_ID "
                        . "where DATE(jc.JC_INSDATE) BETWEEN '$start' AND '$end'"
                        . "ORDER BY jab_repayments.JRP_ID DESC ");
    }

    function getAllTransactions($start, $end) {
        return $this->simpleLazySelect("jab_transactions", "where DATE(jc.JC_INSDATE) BETWEEN '$start' AND '$end" . "order by ID DESC");
    }

    function getAppraisals($start, $end) {
        $sql = $this->simpleLazySelect("jab_customers,jab_appraisals", "where jab_customers.JC_ID = jab_appraisals.customer_id and jab_appraisals.status = 5");
        //return $sql;
    }

    function getExternalCustomers($start, $end) {
        return $this->simpleLazySelect("jab_customers", "where JC_TYPE = 1 and DATE(JC_INSDATE) BETWEEN '$start' AND '$end'  order by JC_ID DESC");
    }

    function getInternalCustomers($start, $end) {
        return $this->simpleLazySelect("jab_customers ", "where JC_TYPE = 0 and DATE(JC_INSDATE) BETWEEN '$start' AND '$end'  order by JC_ID DESC");
    }
}
