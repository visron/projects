<?php

include_once("DBConn.class.php");

class Services extends DBConn {

    function setNewservice_providers($US_ID, $SP_NAME, $SP_LICENSE, $SP_COUNTY, $SP_TOWN, $SP_PHYSICAL_ADDRESS, $SP_LONG, $SP_LAT, $SP_AVATAR) {
        $sql = this->lazyInsert("service_providers", array("US_ID", "SP_NAME", "SP_LICENSE", "SP_COUNTY", "SP_TOWN", "SP_PHYSICAL_ADDRESS", "SP_LONG", "SP_LAT", "SP_AVATAR"), array($US_ID, $SP_NAME, $SP_LICENSE, $SP_COUNTY, $SP_TOWN, $SP_PHYSICAL_ADDRESS, $SP_LONG, $SP_LAT, $SP_AVATAR), "");
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    function updateservice_providers($SP_ID, $US_ID, $SP_NAME, $SP_LICENSE, $SP_COUNTY, $SP_TOWN, $SP_PHYSICAL_ADDRESS, $SP_LONG, $SP_LAT, $SP_AVATAR) {
        $sql = $this->lazyUpdate("service_providers", array("US_ID", "SP_NAME", "SP_LICENSE", "SP_COUNTY", "SP_TOWN", "SP_PHYSICAL_ADDRESS", "SP_LONG", "SP_LAT", "SP_AVATAR"), array($US_ID, $SP_NAME, $SP_LICENSE, $SP_COUNTY, $SP_TOWN, $SP_PHYSICAL_ADDRESS, $SP_LONG, $SP_LAT, $SP_AVATAR), "SP_ID", "$SP_ID");
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }

}

?>