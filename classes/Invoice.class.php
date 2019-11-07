<?php
include_once ('DBConn.class.php');

class InvoiceClass extends DBConn
{  
//     var $DBdate;
//     var $DBdate_Formatted;
//     var $refDate;
//     var $filedb;
//     var $patdb;
//     var $samplestart;
//     var $sampleend;
//     var $invdb;
//     var $invitemdb;
//     var $paydb;
//     var $procdb;
//     var $consdb;
//     var $ip_roundb;
//     var $ip_procdb;
//     var $implant_table;
//     var $doctor;
    
//     public function __construct() {
//         $this->filedb = "doctor_patient_link";
//         $this->patdb = "patients_table";
//         $this->invdb = "invoices_table";
//         $this->doctor = "doctors_table";
//         $this->ip_procdb = "ip_procedures_table";
//         $this->ip_roundb = "ward_round_table";
//         $this->invitemdb = "invoice_details_table";
//         $this->paydb = "patient_paying_institution";
//         $this->consdb = "consultations_table";
//         $this->procdb = "procedures_table";
//         $this->implant_table = "ip_procedures_implants";
//     }
    public function checkEmpty($data)
    {
        if ($data == "" || $data == "null") {
            return true;
        } else {
            return false;
        }
    }

    function setInvoice($inv_name, $doc_id, $pat_id)
    {
        $table = 'invoices_table';
        $column = array(
            'INV_GENERATED',
            'PAT_ID',
            'DOC_ID',
            'INV_INSDATE',
            'INV_REF_DATE'
        );
        $datenow = date('Y-m-d');
        $value = array(
            $inv_name,
            $pat_id,
            $doc_id,
            $this->DBdate,
            $datenow
        );
        $val = $this->lazyInsert('invoices_table', array(
            'INV_GENERATED',
            'PAT_ID',
            'DOC_ID',
            'INV_INSDATE',
            'INV_REF_DATE'
        ), array(
            $inv_name,
            $pat_id,
            $doc_id,
            $this->DBdate,
            $datenow
        ));
        return $val;
    }

    function updateallPaid($fileid)
    {
        if ($this->lazyUpdate($this->invdb, array(
            'INV_STATUS',
            'INV_PAY_DATE',
            'INV_PAY_TIMESTAMP'
        ), array(
            '2',
            $this->refDate,
            $this->DBdate
        ), 'LINK_ID', $fileid)) {
            return true;
            // $va = $this->lazyUpdate($this->paydb,array('PAYMENT_STATUS',array('1'),'LINK_ID',$file_id));
        } else {
            return false;
        }
    }

    function updatePaid($fileid)
    {
        if ($this->lazyUpdate($this->invdb, array(
            'INV_STATUS',
            'INV_PAY_DATE',
            'INV_PAY_TIMESTAMP'
        ), array(
            '2',
            $this->refDate,
            $this->DBdate
        ), 'LINK_ID', $fileid)) {
            return true;
            // $va = $this->lazyUpdate($this->paydb,array('PAYMENT_STATUS',array('1'),'LINK_ID',$file_id));
        } else {
            return false;
        }
    }

    function updateinvoceDetailsasPaid($fileid)
    {
        if ($this->lazyUpdate($this->invitemdb, array(
            'INV_DET_STATUS',
            'INV_DET_PAY_DATE',
            'INV_DET_PAY_TIMESTAMP'
        ), array(
            '2',
            $this->refDate,
            $this->DBdate
        ), 'LINK_ID', $fileid)) {
            return true;
            // $va = $this->lazyUpdate($this->paydb,array('PAYMENT_STATUS',array('1'),'LINK_ID',$file_id));
        } else {
            return false;
        }
    }

    function updatePaid2($fileid)
    {
        if ($this->lazyUpdate($this->paydb, array(
            'PAYMENT_STATUS',
            'PAYMENT_DATE'
        ), array(
            '1',
            $this->DBdate
        ), 'LINK_ID', $fileid)) {
            return true;
            // $va = $this->lazyUpdate($this->paydb,array('PAYMENT_STATUS',array('1'),'LINK_ID',$file_id));
        } else {
            return false;
        }
    }

    function doesInvoiceExist($doc_id, $pat_id)
    {
        $val = $this->simpleLazySelect('invoices_table', "where DOC_ID = '$doc_id' and PAT_ID = '$pat_id'");
        return @$val;
    }

    function doesInvoiceItemExist($link_id, $type)
    {
        $val = $this->simpleLazySelect($this->invitemdb, "where LINK_ID = '$link_id' and INV_ITEM_TYPE = '$type'");
        return @$val;
    }

    function getInvoiceId($linkid)
    {
        $val = $this->simpleLazySelect('invoices_table', "where LINK_ID = '$linkid' ");
        return @$val[0];
    }
    function getInvoiceDetails($invid)
    {
        $val = $this->simpleLazySelect('invoice_details_table', "where INV_ID = '$invid' ");
        return @$val;
    }

    function getallUnpaidInvoices()
    {
        $val = $this->simpleLazySelect('invoices_table', "where INV_STATUS = '1' ");
        return @$val;
    }

    function getDoctorsUnpaidInvoices($doc_id)
    {
        $val = $this->simpleLazySelect("$this->filedb,$this->doctor,$this->invdb", "where DOC_ID = '$doc_id' and US_ID = DOC_ID and $this->filedb.LINK_ID = $this->invdb.LINK_ID and INV_STATUS = '1' ");
        return @$val;
    }

    function getInvoiceTotals($file_id)
    {
        $val = $this->lazySum($this->invitemdb, "INV_AMOUNT", "WHERE LINK_ID = '$file_id' AND INV_DET_STATUS = 1");
        return $val;
    }
//     function getInvoiceDetails($file_id)
//     {
//         $condition  = "WHERE invoices_table.INV_ID = invoice_details_table.INV_ID and invoices_table.INV_ID = '$file_id'";
//         $val = $this->simpleLazySelect("invoice_details_table,invoices_table", $condition);
//         return $val;
//     }

    function getPatientsCount($docid, $type)
    {
        $val = $this->countLazySelect($this->filedb, "WHERE DOC_ID = $docid AND LINK_TYPE = $type");
        return $val;
    }

    function updateInvoiceAmount($amount, $fileid)
    {
        if ($this->lazyUpdate($this->invdb, array(
            'INV_AMOUNT',
            'LAST_EDIT'
        ), array(
            $amount,
            $this->DBdate
        ), 'LINK_ID', $fileid)) {
            return true;
        } else {
            return false;
        }
    }

    function createInvoice($inv_name, $link_id, $amount)
    {
        $val = $this->lazyInsert('invoices_table', array(
            'INV_GENERATED',
            'LINK_ID',
            'INV_INSDATE',
            'INV_AMOUNT',
            'INV_REF_DATE'
        ), array(
            $inv_name,
            $link_id,
            $this->DBdate,
            $amount,
            $this->refDate
        ));
        return $val;
    }

    function createInvoiceDetails($inv_id, $file_id, $item, $desc, $amount, $date)
    {
        $val = $this->lazyInsert('invoice_details_table', array(
            'INV_ID',
            'LINK_ID',
            'INV_ITEM_TYPE',
            'INV_ITEM_DESC',
            'INV_ITEM_AMOUNT',
            'INV_DATE',
            'INV_TIMESTAMP',
            'INV_REF_DATE'
        ), array(
            $inv_id,
            $file_id,
            $item,
            $desc,
            $amount,
            $this->refDate,
            $this->DBdate,
            $date
        ));
        return $val;
    }

    function createAutobillDetail($inv_id, $file_id, $item, $desc, $amount, $date)
    {
        $val = $this->lazyInsert('invoice_details_table', array(
            'INV_ID',
            'LINK_ID',
            'INV_ITEM_TYPE',
            'INV_ITEM_DESC',
            'INV_AMOUNT',
            'INV_DATE',
            'INV_TIMESTAMP',
            'INV_REF_DATE',
            'INV_IS_AUTOBILL'
        ), array(
            $inv_id,
            $file_id,
            $item,
            $desc,
            $amount,
            $this->refDate,
            $this->DBdate,
            $date,
            1
        ));
        return $val;
    }

    function activateItem($item_id)
    {
        if ($this->customUpdate($this->invitemdb, array(
            'INV_DET_STATUS',
            'INV_EDIT_DATE',
            'INV_IS_AUTOBILL',
            'INV_IS_EDITED'
        ), array(
            '1',
            $this->DBdate,
            0,
            1
        ), 'INV_DET_ID', $item_id)) {
            return true;
        } else {
            return false;
        }
    }

    function deactivateItem($item_id)
    {}

    function editInvoiceDetail($det_id, $ref_date, $amount)
    {
        if ($this->lazyUpdate($this->invitemdb, array(
            'INV_REF_DATE',
            'INV_AMOUNT',
            'INV_EDIT_DATE',
            'INV_IS_EDITED'
        ), array(
            $ref_date,
            $amount,
            $this->DBdate,
            1
        ), 'INV_DET_ID', $det_id)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteInvoiceDetail($det_id)
    {
        if ($this->lazyUpdate($this->invitemdb, array(
            'INV_DET_STATUS',
            'IS_DELETED',
            'DELETE_DATE'
        ), array(
            '0',
            '1',
            $this->DBdate
        ), 'INV_DET_ID', $det_id)) {
            return true;
        } else {
            return false;
        }
    }
    function getservicerepairs($service){
        $table = "repairs";
        $condition ="WHERE R_S_ID = '$service'";
        $val = $this->simpleLazySelect($table, $condition);
        return @$val;
    }
}
?>
