<?php
include '../function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $NIC = $input['NIC'];
    $db = dbConn();

//    // Connect to the database
//    $conn = new mysqli('localhost:3307', 'root', '', 'ims');
//
//    if ($conn->connect_error) {
//        die('Connection failed: ' . $conn->connect_error);
//    }
    

    // Query the database
    $sql = "SELECT FirstName, LastName, GTypeId, TelNo, MobileNo FROM guardians WHERE NIC = '$NIC'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'FirstName' => $row['FirstName'], 'LastName' => $row['LastName'], 'GTypeId' => $row['GTypeId'], 'TelNo' => $row['TelNo'], 'MobileNo' => $row['MobileNo']]);
    } else {
        echo json_encode(['success' => false]);
    }

}
?>


