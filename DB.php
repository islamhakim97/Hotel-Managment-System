<?php
$conn = new mysqli("localhost","root","" ,"hotel");
$sql = "CREATE TABLE Reserve (
    cc INT(14)  PRIMARY KEY, 
    cname VARCHAR(30) NOT NULL,
    roomnum int NOT NULL,
    out_date date,
    in_date date
    )";
    $sql2= "CREATE TABLE Guest (
        guestname varchar(50) , 
        roomnum int ,
        meals varchar(50),
        mprice int,
        drinks varchar(50) ,
        dprice int
        )";
     $sql3= "CREATE TABLE Orders (
            meals varchar(50),
            mprice int,
            drinks varchar(50),
            dprice int
            )";
    
    
    if ($conn->query($sql2) === TRUE) {
        echo "Table Guest created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    if ($conn->query($sql3) === TRUE) {
        echo "Table Orders created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    
?>