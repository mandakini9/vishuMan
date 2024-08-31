<?php
include '../function.php';

extract($_GET);

$db = dbConn();
$sql = "SELECT DISTINCT g.Name as gname ,s.Name as sname,m.Name as mname,r.StartTime as stime , "
        . "r.EndTime as etime, w.Name as wday,t.FirstName,t.LastName,d.Classfee FROM classroom_allocation r"
        . " INNER JOIN weekdays w ON w.Id=r.WeekdayId LEFT JOIN classdetails d ON d.Id=r.ClassdetailId "
        . "LEFT JOIN grades g ON g.Id=d.GradeId LEFT JOIN subjects s ON s.Id=d.SubjectId LEFT JOIN "
        . "medium m ON m.Id=d.MediumId LEFT JOIN teachers t ON t.TeacherId=d.TeacherId"
        . " WHERE g.Id=$gradeId AND s.Id=$subjectId AND m.Id=$mediumId";

$result = $db->query($sql);
?>

<?php if($subjectId != 0 && $mediumId != 0) { ?>
<div class="card text-center mb-3">
    <div class="card-body">
        <?php
        
        while ($row = $result->fetch_assoc()) {
            $stime=strtotime($row['stime']);
            $etime=strtotime($row['etime']);
//            echo "Created date is " . date("h:i", $stime);

            ?>
            <h6 class="card-text">
                <div class="ttgardient">
                    <span class="badge">
                        <span class="badge me-5 ttday "><?= $row['wday'] ?></span>
                        <span class="badge tttime"><?= date("h:ia", $stime) ?> - <?= date("h:ia", $etime) ?></span>
                    </span>
                    <span class="badge ttname"><?= $row['FirstName'] ?> <?= $row['LastName'] ?></span>
                    <span class="badge tttime">Rs. <?= $row['Classfee'] ?></span>
                    <span class="badge">
                        <a href="enrollpayment.php?gradeId=<?= $gradeId; ?>&subjectId=<?= $subjectId ?>&mediumId=<?= $mediumId ?>">
                            <span class="badge ms-5 ttday ">Enroll Now</span>
                        </a>
                    </span>

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

