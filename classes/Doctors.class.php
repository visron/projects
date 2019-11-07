<?php

include_once('DBConn.class.php');

class Doctors extends DBConn {

    function createProvider($doc_kmpdu,$doc_title, $doc_name,$doc_specialty,$doc_subspecialty,$doc_email, $doc_mobile,$doc_office, $doc_town, 
            $doc_phy_address) {
        //$pr_contact_name = $provider_firstname . " " . $provider_lastname;
        return $this->lazyInsert('doctors_table', 
                array( `KMPDU_NO`, `DOC_TITLE`, `DOC_NAME`, `DOC_SPECIALITY`, `DOC_SUB_SPECIALITY`, `DOC_EMAIL`, `DOC_MOBILE_NUMBER`,
                    `DOC_OFFICE_NUMBER`, `DOC_TOWN`,`DOC_PHYSICAL_ADDRESS`, `DOC_PASSWORD`, `DOC_STATUS`, `DOC_INS_DATE`), 
                array($doc_kmpdu,$doc_title, $doc_name,$doc_specialty,$doc_subspecialty,$doc_email, $doc_mobile,$doc_office, $doc_town, 
            $doc_phy_address, $this->DBdate));
    }

    function createProvider_Services( $us_id, $st_id) {
        return $this->lazyInsert('service_mapping', 
                array('US_ID','ST_ID', 'SM_INS_DATE'), 
                array($uid, $pr_id, $st_id, $this->DBdate));
    }

    function providerAdd_Sub_Test( $us_id, $st_id, $sm_price) {
        return $this->lazyInsert('service_mapping', 
                array('US_ID', 'ST_ID', 'SM_PRICE', 'SM_INS_DATE'), 
                array( $us_id, $st_id, $sm_price, $this->DBdate));
    }
    
    function editProvider_Contact_Details( $id,$doc_title, $doc_name,$doc_email, $doc_mobile, $doc_office) {
        if ($this->lazyUpdate('doctors_table', 
                array(`DOC_TITLE`, 'DOC_NAME', `DOC_EMAIL`, `DOC_MOBILE_NUMBER`, 'PR_MAIN_EMAIL_ADDRESS', 
                    `DOC_OFFICE_NUMBER`), 
                array( $doc_title, $doc_name,$doc_email, $doc_mobile, $doc_office), 
                'US_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function editProvider_Location_Details( $id, $doc_town, $doc_physical_address){
        if ($this->lazyUpdate('doctors_table', 
                array( 'DOC_TOWN',  'DOC_PHYSICAL_ADDRESS'), 
                array($uid,  $doc_town, $doc_physical_address), 
                'US_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function deleteProvider($id) {
        if ($this->lazyUpdate('doctors_table', array('DOC_STATUS'), array(0), 'DOC_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function providerService_Action($sm_id, $sm_status) {
        if ($this->lazyUpdate('service_mapping', array('SM_STATUS'), array($sm_status), 'SM_ID', $sm_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function getProvider() {
        $val = $this->simpleLazySelect('doctors_table', "WHERE DOC_STATUS = 1");
        return @$val;
    }
    function getProviderById($docid) {
        $val = $this->simpleLazySelect('doctors_table', "WHERE DOC_ID = '$docid' AND DOC_STATUS= 1");
        return @$val[0];
    }

    function getProvider_Role($key_word){
        $val = $this->simpleLazySelect('auth_roles', "WHERE AR_NAME LIKE '$key_word%'");
        return @$val;
    }
    
   // function getAllProviders() {
        // $val = $this->complexSelect(array("doctors_table", "counties"), 
        //        array("providers.PR_ID", "providers.PR_NAME", "counties.C_NAME"), 
        //        "where providers.PR_COUNTY = counties.C_CODE AND "
       //         . "providers.PR_STATUS = 1");
      //  return @$val;
    //}
    
    //function getAllCounties() {
    //    $val = $this->simpleLazySelect('counties', "where C_STATUS = 1 ORDER BY C_NAME ASC");
     //   return @$val;
    //}

    //function getConstituency($id) {
    //    $val = $this->simpleLazySelect('constituencies', "where C_CODE = '$id' and CY_STATUS = 1");
    //    return @$val;
    //}
    
    //function getCounty_By_Id($id) {
    //    $val = $this->complexSelect(array("counties"), 
     //           array("C_NAME"), 
     //           "where counties.C_CODE = '$id' AND counties.C_STATUS = 1");
    //    return @$val[0];
    //}

  //  function getCounty_Constituency_ById($county, $constituency) {
     //   $val = $this->complexSelect(array("counties", "constituencies"), 
      //          array("*"), 
       //         "where counties.C_CODE = '$county' AND constituencies.CY_CODE = '$constituency' AND "
       //         . "counties.C_STATUS = 1 and constituencies.CY_STATUS = 1");
       // return @$val[0];
    //}

    //function getAll_Counties_and_Constituencies() {
    //    $val = $this->complexSelect(array("counties", "constituencies"), array("*"), "where constituencies.C_CODE = counties.C_CODE and counties.C_STATUS = 1 and constituencies.CY_STATUS = 1 order by counties.C_NAME ASC");
    //    return @$val;
    //}

    function getSpecific_Providers_Test($c_code) {
        $val = $this->complexSelect(array("doctors_table",  "service_mapping", "sub_tests"), 
                array("doctors_table.US_ID","doctors_table.DOC_TITLE", "doctors_table.DOC_NAME","doctors_table.DOC_SPECIALTY", "doctors_table.US_MOBILE_NUMBER", "doctors_table.DOC_TOWN",
            "doctors_table.DOC_PHYSICAL_ADDRESS", 
            "sub_tests.ST_ID", "sub_tests.ST_NAME", "sub_tests.ST_PRICE", "service_mapping.SM_PRICE"), 
                "WHERE doctors_table.US_ID = service_mapping.US_ID AND service_mapping.ST_ID = sub_tests.ST_ID AND "
                . "doctors_table.DOC_STATUS = 1");
                
        return @$val;
    }

    function getAll_Providers_Service_And_Price() {
        $val = $this->complexSelect(array("doctors_table",  "service_mapping", "sub_tests"), 
                array("doctors_table.US_ID", "doctors_table.DOC_TITLE", "doctors_table.DOC_NAME","doctors_table.DOC_SPECIALTY", "doctors_table.US_MOBILE_NUMBER", "doctors_table.DOC_TOWN",
            "doctors_table.DOC_PHYSICAL_ADDRESS", 
            "sub_tests.ST_ID", "sub_tests.ST_NAME", "sub_tests.ST_PRICE", "service_mapping.SM_PRICE"), 
                "WHERE doctors_table.US_ID = service_mapping.US_ID AND "
                . "service_mapping.ST_ID = sub_tests.ST_ID AND "
                . "doctors_table.DOC_STATUS = 1");
        return @$val;
    }
    
    function searchCustomer_Booking($uid, $pr_id, $cs_id){
        $val = $this->complexSelect(array("users", "customers", "requested_tests", "sub_tests"), 
                array("customers.CS_FIRST_NAME", "sub_tests.ST_ID", "sub_tests.ST_NAME", "requested_tests.RT_ID", 
                    "requested_tests.RT_STATUS", "requested_tests.RT_PAY_STATUS", 
                    "DATE_FORMAT(requested_tests.RT_INS_DATE, '%d-%M-%y') AS RT_INS_DATE"), 
                "WHERE users.USER_ID = '$uid' AND customers.CS_ID = '$cs_id' AND requested_tests.CS_ID =  customers. CS_ID "
                . "AND requested_tests.ST_ID = sub_tests.ST_ID AND requested_tests.RT_STATUS != 0 "
                . "AND requested_tests.US_ID = '$pr_id' AND requested_tests.RT_STATUS != 2 AND customers.CS_STATUS = 1");
        return @$val;
    }

    function getProvider_Service_Mapping($us_id){
        $val = $this->complexSelect(array("doctors_table", "service_mapping", "sub_tests"), 
                array("doctors_table.US_ID", "sub_tests.ST_ID", "sub_tests.ST_NAME", "sub_tests.ST_PRICE", 
                    "service_mapping.SM_ID"), 
                "WHERE doctors_table.US_ID = '$us_id' AND providers.PR_ID = service_mapping.PR_ID AND "
                . "service_mapping.ST_ID = sub_tests.ST_ID AND pdoctors_table.DOC_STATUS = 1");
        return @$val;
    }
    
    function getTest_Price($sm_id) {
        $val = $this->simpleLazySelect('service_mapping', "WHERE SM_ID = '$sm_id'");
        return @$val[0];
    }
    
    function getProvider_Service_Mapping_By_ID($sm_id){
        $val = $this->complexSelect(array("doctors_table", "service_mapping", "sub_tests"), 
                array("doctors_table.US_ID", "doctors_table.DOC_TITLE", "doctors_table.DOC_NAME", "sub_tests.ST_ID", "sub_tests.ST_NAME", "sub_tests.ST_PRICE", 
                    "service_mapping.SM_ID", "service_mapping.SM_PRICE"), 
                "WHERE service_mapping.SM_ID = '$sm_id' AND doctors_table.US_ID = service_mapping.US_ID AND "
                . "service_mapping.ST_ID = sub_tests.ST_ID AND service_mapping.SM_STATUS = 1");
        return @$val[0];
    }
}
?>