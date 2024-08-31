<?php
include '../function.php';
extract($_GET);
$db = dbConn();

$sql = "SELECT *,Id AS ID FROM exams WHERE ClassdetailId = '$classId'";
$result = $db->query($sql);
?>

<select name="examname" id="examname">
    <option value="">-Exam-</option>
    <?php
while ($row = $result->fetch_assoc()) {
?>
        <option value="<?= $row['ID'] ?>"<?= @$examname == $row['ID'] ? 'selected' : '' ?>><?= $row['ExamName'] ?></option>
        <?php
    }
?>
</select>


