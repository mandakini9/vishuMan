<?php

include '../../function.php';

extract($_GET);

$db = dbConn();
$sql = "SELECT DISTINCT t.FirstName,t.LastName ,t.TeacherId as id FROM teachers_grades g INNER JOIN teachers t ON t.TeacherId=g.TeacherId LEFT JOIN users u ON u.UserId=t.UserId WHERE u.Status=1 AND "
        . "g.GradeId='$gradeId' AND g.SubjectId='$subjectId' AND g.MediumId='$mediumId' ";
$result = $db->query($sql);
?>
<select name="teacher" id="teacher"  class="form-control" aria-label="Large select example">
 <option value="" >---</option>
                                    
    <?php
    while ($row = $result->fetch_assoc()) {
        ?>
        <option value="<?= $row['id'] ?>" <?= @$seltname==$row['id']?'selected':'' ?>><?= $row['FirstName'] ?>    <?= $row['LastName'] ?></option>
        <?php
    }
    ?>
</select>

