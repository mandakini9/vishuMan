<?php

//Create Database Conection-------------------
function dbConn() {
    $server = "localhost:3307";
    $username = "root";
    $password = "";
    $db = "ims";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error : " . $conn->connect_error);
    } else {
        return $conn;
    }
}

//End Database Conection-----------------------
//Data Clean------------------------------------------
function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//End Data Clean

function validateNIC($NIC) {
    // Determine the length of the NIC
    $length = strlen($NIC);

    // Check for old NIC format
    if ($length == 10) {
        $firstPart = substr($NIC, 0, 9);
        $lastChar = substr($NIC, -1);

        // Check if the first part is numeric and the last character is 'V' or 'X'
        if (ctype_digit($firstPart) && ($lastChar == 'V' || $lastChar == 'X')) {
            return null;
        } elseif (empty($NIC)) {
            return "NIC is required";
        } else {
            return "Invalid NIC format.";
        }
    }
    // Check for new NIC format
    elseif ($length == 12) {
        // Check if all characters are numeric
        if (ctype_digit($NIC)) {
            return null;
        } else {
            return "Invalid NIC format.";
        }
    } else {
        return "Invalid NIC format.";
    }
}
