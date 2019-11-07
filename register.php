<?php
$username = $_POST['username'];
$userpassword = $_POST['password'];
$connection = mysqli_connect('localhost', 'rot', '','student') or
        die('Oops connection error -> ' . mysqli_connect_error());
$queryString = "INSERT INTO user('US_NAME','US_PASS') values ($username,$userpassword) ";
$sqlConnect = mysqli_query($this->connection, $queryString);
$id = mysqli_insert_id($this->connection);
if ($sqlConnect) {
    echo "string";
    return $id;
} else {
    echo "sake";
    return FALSE;
}


?>
