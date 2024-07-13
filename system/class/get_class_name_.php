<?php

include '../../function.php';

extract($_GET);

$db = dbConn();
$sql = "SELECT DISTINCT a.Name ,g.Name ,s.Name,m.Name,t.Name FROM classdetails d INNER JOIN academicyears a ON a.Id=d.AcademicId "
        . "LEFT JOIN grades g ON g.Id=d.GradeId  LEFT JOIN subjects s ON s.Id=d.SubjectId "
        . "LEFT JOIN medium m ON m.Id=d.MediumId LEFT JOIN classtypes t ON t.Id=d.ClasstypeId"
        . "WHERE d.AcademicId='$academicId' AND "
        . "d.GradeId='$gradeId' AND d.SubjectId='$subjectId' AND d.MediumId='$mediumId' AND d.ClasstypeId='$classtypeId' ";

//$sql = "SELECT DISTINCT t.FirstName,t.LastName ,t.TeacherId as id FROM teachers_grades g "
//        . "INNER JOIN teachers t ON t.TeacherId=g.TeacherId LEFT JOIN users u ON u.UserId=t.UserId "
//        . "WHERE u.Status=1 AND "
//        . "g.GradeId='$gradeId' AND g.SubjectId='$subjectId' AND g.MediumId='$mediumId' ";


$result = $db->query($sql);
?>

                                    
    <?php
    while ($row = $result->fetch_assoc()) {
        ?>
 <input type="text" name="classname" class="form-control" id="classname" value="<?= $row['AcademicId'] ?> " placeholder="Class Name" required>

        
        <?php
    }
    ?>

