<?php
ob_start();
include_once '../init.php';

$link = "Classroom Management";
$breadcrumb_item = "classroom";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
//
//    $message = array();
//    if (empty($classname)) {
//        $message['classname'] = "The Class Name should not be blank...!";
//    }
//    if (empty($classroomname)) {
//        $message['classroomname'] = "The Last Name should not be blank...!";
//    }
//    if (empty($weekday)) {
//        $message['weekday'] = "The Week Day should not be blank...!";
//    }
//    if (empty($duration)) {
//        $message['duration'] = "The Duration should not be blank...!";
//    }
//    if (empty($startTime)) {
//        $message['startTime'] = "The Stat time should not be blank...!";
//    }
//
//    if (empty($allocationtype)) {
//        $message['allocationtype'] = "The Allocation Type should not be blank...!";
//    }
//
//
//    if (empty($message)) {
    $db = dbConn();

    foreach ($attendance as $key => $att) {
        $attendance = $att;
        $studentid = $stid[$key];
        $regno = $sregno[$key];
        $class = $classname[$key];

        $sql = "INSERT INTO `classattendance`(`ClassdetailId`, `ClassDate`, `StudentId`, `SRegNo`, `Status`) "
                . "VALUES ('$class',CURRENT_DATE,'$studentid','$regno','$attendance')";
        $db->query($sql);
    }

    header("Location:manage.php");
//
//        header("Location:classroom_manage.php");
//    }
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Attendance Details</h3>
            </div>              

            <div class="card-body">
                <div class="row">
                    <?php
                    $db = dbConn();
                    $classname = null;
                    extract($_GET);
                    $sql = "SELECT d.Id AS ID, r.StudentId, r.SRegNo, s.FirstName, s.LastName FROM registerstudents r "
                            . "INNER JOIN classdetails d ON d.Id=r.ClassId  LEFT JOIN students s ON s.Id=r.StudentId WHERE d.Id='$classname'";
                    $result = $db->query($sql);
                    ?>

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                        <div class="row col-md-12">
                            <div class="col-md-10">

                                <?php
                                $db = dbConn();
                                $sql_1 = "SELECT d.ClassName AS ClassName ,d.Id AS ID FROM  classdetails d "
                                        . "INNER JOIN classroom_allocation r ON r.ClassdetailId=d.Id "
                                        . "LEFT JOIN weekdays w ON w.Id=r.WeekdayId "
                                        . "WHERE w.Name=DAYNAME(CURDATE())";
                                $result_1 = $db->query($sql_1);
                                ?>
                                <label for="classname">Class Name</label>
                                <select Name="classname"  class="form-control" id="classname" aria-label="Large select example" >
                                    <option value="" >---</option> 
                                    <?php
                                    while ($row_1 = $result_1->fetch_assoc()) {
                                        $classname = $row_1['ID'];
                                        $class = $row_1['ClassName'];
                                        ?>
                                        <option value="<?= $row_1['ID'] ?>"><?= $row_1['ClassName'] ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>

                        </div>

                    </form>



                    <div class="card-body table-responsive p-0">
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>

                                        <th>SRegNo</th>
                                        <th>Name</th>
                                        <th>Last Paid Month</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $StudentID = $row['StudentId'];
                                            ?>
                                            <tr>
                                                <td><?= $row['SRegNo'] ?></td>
                                                <td><?= $row['FirstName'] . ' ' . $row['LastName'] ?></td>
                                                <?php
                                                $db = dbConn();
                                                $sql_2 = "SELECT * FROM approvalpayments  WHERE StudentId='$StudentID' ORDER BY PaidDate DESC LIMIT 1";
                                                $result_2 = $db->query($sql_2);
                                                $row_2 = $result_2->fetch_assoc();
                                                
                                                $sql_3 = "SELECT * FROM registerstudents  WHERE StudentId='$StudentID'";
                                                $result_3 = $db->query($sql_3);
                                                $row_3 = $result_3->fetch_assoc();
                                                ?>

                                                <td><?= $row_2['PaidDate'] ?></td>
                                                <td>
                                                    <input type="hidden" name="stid[]" value="<?= htmlspecialchars($row['StudentId']) ?>"/>
                                                    <input type="hidden" name="sregno[]" value="<?= htmlspecialchars($row['SRegNo']) ?>"/>
                                                    <input type="hidden" name="classname[]" value="<?= htmlspecialchars($row_3['ClassId']) ?>"/>
                                                </td>
                                                <td>
                                                    <select name="attendance[]"  class="form-control" id="attendance" aria-label="Large select example" >
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </td>
                                                
                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
            <!-- /.card-body -->



        </div>
        <!-- /.card -->
    </div>

</div>


<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<script>
    $(document).ready(function () {
        function calculateEndTime() {
            var duration = parseFloat($('#duration').val());
            var startTime = $('#startTime').val();
            if (!isNaN(duration) && startTime) {
                var startTimeParts = startTime.split(':');
                var startHours = parseInt(startTimeParts[0]);
                var startMinutes = parseInt(startTimeParts[1]);
                var startDate = new Date();
                startDate.setHours(startHours);
                startDate.setMinutes(startMinutes);
                var endDate = new Date(startDate.getTime() + (duration / 60) * 60 * 60 * 1000);

                var endHours = String(endDate.getHours()).padStart(2, '0');
                var endMinutes = String(endDate.getMinutes()).padStart(2, '0');
                $('#endTime').val(endHours + ':' + endMinutes);
            }
        }
        $('#duration').on('input', calculateEndTime);
        $('#startTime').on('input', calculateEndTime);
    });
</script>