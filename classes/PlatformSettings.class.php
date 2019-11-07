<?php
include_once 'DBConn.class.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlatformSettings
 *
 * @author ELITEBOOK 840
 */
class PlatformSettings extends DBConn {
    var $slider_table;
    public function __construct() {
        $this->slider_table = "slider_images";
    }
    function setSliderImage($path){
        return $this->lazyInsert("slider_images", array("img_url"), array($path));
    }
    
    function getSliderImages() {
        return $this->simpleLazySelect($this->slider_table, "where img_status = 1");

        // return $this->simpleLazySelect("slider_images", "");
    }
    function deleteImage($img_id) {
        if( $this->lazyUpdate("slider_images", array('img_status'),array(0),'img_status',$img_id)){
            return true;
        } else {
            return false;
        }
    }

}
