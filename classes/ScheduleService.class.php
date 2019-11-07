<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * `BS_ID`, `US_ID`, `BS_TYPE`, `BS_DATE`, `BS_TIME`, `BS_NOTES`, `BS_TIMESTAMP`, `BS_STATUS`, `BS_ASS_MECH`, `BS_CAR`
 */
include_once('DBConn.class.php');

class ScheduleService extends DBConn {

    function getAllServices(){
        return $this->simpleLazySelect('bookservice', 'where BS_STATUS = 1 ORDER BY BS_ID DESC');
    }

    function deactivateServices($service_id){
      return $this->lazyUpdate('bookservice', array("BS_STATUS"), array("0"), "BS_ID", $service_id);
    }

    function getSliderImages(){
          return $this->simpleLazySelect("slider_images", 'where img_status = 1');
    }

    function setSliderImage($path){
        return $this->lazyInsert("slider_images", array("img_url"), array($path));
    }

    function deletePicture($img_id) {
        if($this->lazyUpdate('slider_images',array('img_status'),array(0),'img_id',$img_id)){
            return true;
        } else {
            return false;
        }
    }

    function getServiceById($bsid) {
       $val = $this->simpleLazySelect('bookservice', "WHERE AND BS_ID = '$bsid' AND BS_STATUS = 2");
       return @$val;
    }

    //accepted status = 1
    function acceptService($bsid){
        if ($this->lazyUpdate('bookservice',array('BS_REQUEST'),array(1),'BS_ID',$bsid)){
            return true;
        }else{
            return false;
        }
    }

    //denied status = 2
    function deniedService($bsid){
        if ($this->lazyUpdate('bookservice',array('BS_REQUEST'),array(2),'BS_ID',$bsid)){
            return true;
        }else{
            return false;
        }
    }

}
?>