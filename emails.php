<!DOCTYPE html>
<html>
    <head>
        <title>The database</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<h1>The table</h1>

<?php
$con = mysqli_connect('localhost', 'root', '', 'pracc');


class db {
    private $con="";
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname="pracc";

    public function __construct() {
        $this->con=new mysqli($this->servername, $this->username,$this->password,$this->dbname);
    }
    public function insertData($email) {
        $_email = mysqli_real_escape_string($this->con, $email);

        if ($_email==""){
            $emptyErr = "E-mail address is required";
            echo "<script type='text/javascript'>alert('$emptyErr');</script>";
        }
        else if (!filter_var($_email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Please provide a valid e-mail address";
            echo "<script type='text/javascript'>alert('$emailErr');</script>";
        }
        else if (preg_match("/\S+@\S+\.co$/",$_email)){
            $coErr = "We are not accepting subscriptions from Colombia e-mails";
            echo "<script type='text/javascript'>alert('$coErr');</script>";
        }
        // else if (!isset($_POST['checkmark'])){
        //     $checkErr = "You must accept the terms and conditions";              this thing always returns true, without even checking, cant find why
        //     echo "<script type='text/javascript'>alert('$checkErr');</script>";
        // }

        else {
            $_domain = mysqli_real_escape_string($this->con, substr(strrchr($email, "@"), 1));
            $sql = "INSERT INTO emails (email, domain) VALUES ('$_email', '$_domain')";  //for some reason this happens twice, the problem is here or it is called twice, probably a simple thing messed up
            $this->con->query($sql);
            if(mysqli_query($this->con, $sql)){
                echo "Records added successfully.";
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($this->con);
            }//ERROR CHECKING
        } 
    }
    public function printAllRecords() {
        $sql="SELECT email, dateInserted FROM emails ORDER BY email;"; //the ordering by email
        $results = $this->con->query($sql);
        //print_r($results);
        if ($results->num_rows>0) {
            while($row=$results->fetch_assoc()){//fetches row by row
                echo "<br><br>";?>
                <tr>
                    <td><?php echo $row['email']; ?></td> 
                    <td><?php echo $row['dateInserted']; ?></td> 
                </tr>
                <?php // to make the table, showing the email and date
            }
        }
        echo "<br><br>";
    }
    // public function deleteRecord($id) {               really no idea how to implement this
    //     $sql = "DELETE FROM emails WHERE id=$id;";
    //     $this->con->query($sql);
    // }
    public function searchRecord(){ //the search bar
        ?><form action="" method="post"> 
            <input type="text" placeholder="Search" name="search" id="search">
            <button type="submit" name="submit">Search</button>
        </form><?php

        $sql="SELECT `domain` FROM `emails`";
        $query=$this->con->query($sql);
        $array = Array();
        while($result = $query->fetch_assoc()){
            $array[] = $result['domain'];
        }
        $realarray=(array_unique($array));//the buttons, they save only the last value, not correct.
        echo"<br><br>";
        foreach ($realarray as $value) {?>
            <form method="post"><button type='submit' name="button" value="<?php echo $value?>"><?php echo $value?></button></form>
            <?php echo "<br>";
        }
        //no point of executing the "if both pressed" situation because the buttons dont work
        if (isset($_POST['submit'])) { //the search
            $searchValue = $_POST['search'];
            $sql = "SELECT * FROM emails WHERE email LIKE '%$searchValue%'";
            $outcome = $this->con->query($sql);
            if ($outcome->num_rows<1){echo "<br><br>No results";}
            while ($record= $outcome->fetch_assoc()) {
                echo "<br><br>"?>
                <tr>
                    <td><?php echo $record['email']; ?></td> 
                    <td><?php echo $record['dateInserted']; ?></td> 
                </tr>
                <?php 
            }echo "<br><br>";
        }
        else if (isset($_POST['button'])){  // when button pressed  
            $sql="SELECT * FROM emails WHERE domain LIKE '$value'";
            $filter = $this->con->query($sql);
            if ($filter->num_rows<1){echo "<br><br>No results";}
                while ($record= $filter->fetch_assoc()) {
                    echo "<br><br>"?>
                    <tr>
                        <td><?php echo $record['email']; ?></td> 
                        <td><?php echo $record['dateInserted']; ?></td> 
                    </tr>
                 <?php 
                }echo "<br><br>";
        }
    }
}
$somedb = new db(); 
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['email'])){  //if theres a value
    $email=$_POST['email'];
    $somedb->insertData($email);
    }
}
// if(isset($_POST["checkmark"])){
//     $checkmark = $_POST["checkmark"];
//     echo $checkmark;}
//     else {echo "no";}
//     echo "<br><br>";
$somedb -> searchRecord(); //the search bar and buttons
$somedb -> printAllRecords(); ///puts out all


?>

</body>
</html>