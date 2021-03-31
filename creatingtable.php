<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pracc";

// checking connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// sql code to create table
$sql = "CREATE TABLE emails(
        id int AUTO_INCREMENT PRIMARY KEY, 
        dateInserted datetime default CURRENT_TIMESTAMP, 
        email VARCHAR(60) NOT NULL,
        domain VARCHAR (50) NOT NULL
        )";
//current timestamp gives the time in computers local time zone but it works
if ($con->query($sql) === TRUE) {
    echo "Table emails created successfully";
} else {
    echo "Error creating table: " . $con->error;
}

$con->close();
?>