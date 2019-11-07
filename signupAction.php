<?php
echo var_dump($_REQUEST);
$username = $_REQUEST['username'];
$userpassword = $_REQUEST['password'];
$conn = mysqli_connect("localhost", "rot", "", "student");
if ($conn->connect_error)
 {
    die("Connection failed: " . $conn->connect_error);
}else{
echo "Connected successfully";
}

$connection = mysqli_connect('localhost', 'rot', '','student') or
        die('Oops connection error -> ' . mysqli_connect_error());
$queryString = "INSERT INTO 'user' ('US_NAME','US_PASS') values ('$username','$userpassword')";
echo $queryString;
$sqlConnect = mysqli_query($this->conn, $queryString);
$id = mysqli_insert_id($this->conn);
if ($sqlConnect) {
    return $id;
} else {
    return FALSE;
}


?>
