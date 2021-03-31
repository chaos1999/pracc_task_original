<?php
$servername = "localhost";
$username = "root";
$password = "";

// Creating a connection
$con = new mysqli($servername, $username, $password);
//  Check connection
 if ($con->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 } 
//  Creating a database 
$sql = "CREATE DATABASE pracc";
 if ($con->query($sql) === TRUE) {
    echo "Database created successfully"; } 
else {
    echo "Error creating database: " . $con->error;
}

// closing connection
$con->close();
?>