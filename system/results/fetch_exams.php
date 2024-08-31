<?php
include '../init.php';
extract($_GET);
$db = dbConn();

$sql = "SELECT * FROM exams WHERE ClassdetailId = '$classId' AND ExamDate < CURRENT_DATE";
$result = $db->query($sql);
while ($row = $result->fetch_assoc()) {
?>
        <option value="1"><?= $row['ExamName'] ?></option>
        <?php
    }
?>


