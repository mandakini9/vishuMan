<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="mb-3">
                <h2>Our Time Table</h2>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
                    <div style="display:block;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card text-center mb-3">
                                    <div class="card-header">Sinhala Medium</div>
                                    <div class="card-body">
                                        <?php
                                        extract($_GET);
                                        $db = dbConn();
                                        $sql = "SELECT DISTINCT g.Name as gname ,s.Name as sname,m.Name as mname,r.StartTime as stime , "
                                                . "r.EndTime as etime, w.Name as wday,t.FirstName,t.LastName FROM classroom_allocation r"
                                                . " INNER JOIN weekdays w ON w.Id=r.WeekdayId LEFT JOIN classdetails d ON d.Id=r.ClassdetailId "
                                                . "LEFT JOIN grades g ON g.Id=d.GradeId LEFT JOIN subjects s ON s.Id=d.SubjectId LEFT JOIN "
                                                . "medium m ON m.Id=d.MediumId LEFT JOIN teachers t ON t.TeacherId=d.TeacherId"
                                                . " WHERE g.Id=$gradeID AND s.Id=$subjectID AND m.Id=1";

                                        $result = $db->query($sql);

                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                        <h6 class="card-text">
                                            <div class="ttgardient">
                                                <span class="badge">
                                                    <span class="badge me-5 ttday "><?= $row['wday'] ?></span>
                                                    <span class="badge tttime"><?= $row['stime'] ?> - <?= $row['etime'] ?></span>
                                                </span>
                                                <span class="badge ttname"><?= $row['FirstName'] ?> <?= $row['LastName'] ?></span>
                                                <span class="badge">
                                                        <a href="enrollStudent.php">
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
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card text-center mb-3">
                                    <div class="card-header">English Medium</div>
                                    <div class="card-body">
                                        <?php
                                        extract($_GET);
                                        $db = dbConn();
                                        $sql2 = "SELECT DISTINCT g.Name as gname ,s.Name as sname,m.Name as mname,r.StartTime as stime , "
                                                . "r.EndTime as etime, w.Name as wday,t.FirstName,t.LastName FROM classroom_allocation r"
                                                . " INNER JOIN weekdays w ON w.Id=r.WeekdayId LEFT JOIN classdetails d ON d.Id=r.ClassdetailId "
                                                . "LEFT JOIN grades g ON g.Id=d.GradeId LEFT JOIN subjects s ON s.Id=d.SubjectId LEFT JOIN "
                                                . "medium m ON m.Id=d.MediumId LEFT JOIN teachers t ON t.TeacherId=d.TeacherId"
                                                . " WHERE g.Id=$gradeID AND s.Id=$subjectID AND m.Id=2";

                                        $result = $db->query($sql2);

                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                        <h6 class="card-text">
                                            <div class="ttgardient">
                                                <span class="badge">
                                                    <span class="badge me-5 ttday "><?= $row['wday'] ?></span>
                                                    <span class="badge tttime"><?= $row['stime'] ?> - <?= $row['etime'] ?></span>
                                                </span>
                                                <span class="badge ttname"><?= $row['FirstName'] ?> <?= $row['LastName'] ?></span>
                                                <span class="badge">
                                                        <a href="#">
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
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>


<?php
include 'footer.php';
?>