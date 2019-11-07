<?php
include_once('DBConn.class.php');
class UserDetails extends DBConn{
  function getuserName($id) {
        return $this->simpleLazySelect("users", "where USER_ID =  $id");
    }
    
  }
