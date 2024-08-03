<?php

include '../../function.php';

extract($_GET);

$db = dbConn();
$sql = "SELECT DISTINCT a.Name as aname ,g.Name as gname ,s.Name as sname,m.Name as mname ,t.Name as tname FROM classdetails d INNER JOIN academicyears a ON a.Id=d.AcademicId "
        . "LEFT JOIN grades g ON g.Id=d.GradeId  LEFT JOIN subjects s ON s.Id=d.SubjectId "
        . "LEFT JOIN medium m ON m.Id=d.MediumId LEFT JOIN classtypes t ON t.Id=d.ClasstypeId"
        . " WHERE d.AcademicId='$academicId' AND "
        . "d.GradeId='$gradeId' AND d.SubjectId='$subjectId' AND d.MediumId='$mediumId' AND d.ClasstypeId='$classtypeId' ";
$result = $db->query($sql);
?>

                                    
    <?php
    while ($row = $result->fetch_assoc()) {
        ?>
 <input type="text" name="classname" class="form-control" id="classname" value="<?= $row['aname'] ?>  <?= $row['gname'] ?>  <?= $row['sname'] ?>  <?= $row['mname'] ?>  <?= $row['tname'] ?> " placeholder="Class Name" readonly>

        
        <?php
    }
    ?>

