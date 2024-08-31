<?php
include '../function.php';

extract($_GET);

$db = dbConn();
$sql = "SELECT d.ClassName, e.ExamName ,e.ExamDate,e.Duration,e.StartTime,e.EndTime "
        . "FROM classdetails d INNER JOIN exams e ON e.ClassdetailId=d.Id WHERE d.Id = '$classname' AND e.ExamDate > CURRENT_DATE";

$result = $db->query($sql);
?>

<?php if($classname != 0) { ?>
<div class="card text-center mb-3">
    <div class="card-body">
        <?php
        
        if($result->num_rows <= 0) {
            echo 'No Sheduled Exams';
        }
        
        while ($row = $result->fetch_assoc()) {
            
            ?>
            <h6 class="card-text">
                <div class="ttgardient">
                    <?php 
                    $stime=strtotime($row['StartTime']);
                    $etime=strtotime($row['EndTime']);
                            ?>
                    <span class="badge">
                        <span class="badge me-5 ttday "><?= $row['ExamName'] ?></span>
                        <span class="badge tttime"><?= date("h:ia", $stime) ?> - <?= date("h:ia", $etime) ?></span>
                    </span>
                    <span class="badge ttname"><?= $row['ExamDate'] ?></span>
                    <span class="badge tttime"><?= $row['Duration'] ?> Min</span>
                    
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

