<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "membershipdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . ".<br> Please create a database and import the SQL file");
}

// Start Session
session_start();
