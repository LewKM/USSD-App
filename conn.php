<?php

// Connection to the db
$conn = new mysqli("localhost", "root", "", "ussdapp");

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn -> connect_error);
}