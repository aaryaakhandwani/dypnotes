<?php

$host = "dypnotes-db.cviuomgcokjp.ap-south-1.rds.amazonaws.com";
$dbname = "dypnotes";   // ✅ FIXED
$username = "admin";    // ✅ FROM AWS
$password = "b69ZLZX4ZwPuyTV";

$mysqli = new mysqli(
    $host,
    $username,
    $password,
    $dbname
);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;