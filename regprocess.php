<?php

$username = $_POST['username'];
$password = $_POST['password'];
//echo "username is $username and password is $password";

//connect to db
$conn = mysqli_connect("localhost","rot","","csc316");
if($conn){
  $query = "INSERT student(username,password) values('$username','$password')";
  $process = mysqli_query($conn, $query);
  if($process){
      echo "User Created Successfully";
  }
  else{
      echo "Insertion fail";
  }
}
else{
    echo "Db Connection Fail";
}

?>
