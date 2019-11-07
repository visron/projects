<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomStringFilter
 *
 * @author brian
 */
class CustomStringFilter {
    var $variableName;
    private function setVariableName($variableName){
        $this->variableName = $variableName;
    }
    private function getVariableName(){
        return $this->variableName;
    }
    //put your code here
    public function post($variableName){
        return trim(filter_input(INPUT_POST, $variableName, FILTER_SANITIZE_STRING));
    }
    public function get($variableName){
        return trim(filter_input(INPUT_GET, $variableName, FILTER_SANITIZE_STRING));
    }
    public function server($param) {
        return trim(filter_input(INPUT_SERVER, $param, FILTER_SANITIZE_STRING));
    }
    public function session($param) {
        return $param;
        //return trim(filter_input(INPUT_SESSION, $param, FILTER_SANITIZE_STRING));
    }
}
?>