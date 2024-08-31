<?php
include '../function.php';

extract($_GET);
extract($_POST);

$db = dbConn();
echo $sql = "SELECT DISTINCT r.FirstName AS FNAME, r.LastName AS LNAME, r.ExamMarks AS MARKS,r.ExamName FROM studentresults r "
        . "INNER JOIN classdetails d ON d.Id=r.ClassName LEFT JOIN exams e ON e.Id=r.ExamName "
        . "LEFT JOIN students s ON s.SRegNo=r.SRegNo "
        . " WHERE r.ExamName = '$examname' AND r.ClassName = '$classname' AND r.SRegNo = '$sregno'";


$result = $db->query($sql);
?>

<?php if($classname != 0) { ?>
<div class="card text-center mb-3">
    <div class="card-body">
        <?php
        
       
        
        while ($row = $result->fetch_assoc()) {
            
            ?>
            <h6 class="card-text">
                <div class="ttgardient">
                    <?php 
                    
                            ?>
                    
                    <span class="badge ttname"><?= $row['FNAME'] ?> <?= $row['LNAME'] ?></span>
                    <span class="badge tttime"><?= $row['MARKS'] ?> %</span>
                    
                    
                </div>
            </h6>
            <?php
        }
        ?>
    </div>
</div>
<?php
        }
        ?>

