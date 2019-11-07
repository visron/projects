<?php
include("DBConn.class.php");
class signupdb extends DBConn{
  function login($username,$password){
     $login = $this->simpleSelectStatement('registration',"WHERE Email = '$username' AND Password = '$password'");
    return @$login;
  }
  function createuser($username,$password,$fname,$lname,$email,$phone)
  {
//  $insert = $this->myInsertStatement("user",array("US_NAME","US_PASS","US_STATUS","US_FIRSTNAME","US_SURNAME","US_EMAIL","US_PHONE"),
//    array($username,$password,1,$fname,$lname,$email,$phone));
       $login = $this->myInsertStatement('registration',array("US_NAME","US_PASS"),array($username,$password));
    return $login;
  }
}
 ?>
