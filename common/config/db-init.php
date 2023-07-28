<?php

namespace common\config;

use mysqli;

function getConnection()
{
    $host = "localhost";
    $username = "root";
    $password = "Fizica12";
    $dbname = "workout";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}