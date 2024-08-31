<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Exam Management";
$breadcrumb_item = "exam";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    
    $message = array();
    if (empty($classname)) {
        $message['classname'] = "The Class Name should not be blank...!";
    }
    if (empty($examname)) {
        $message['examname'] = "The Exam Name should not be blank...!";
    }
    if (empty($examdate)) {
        $message['examdate'] = "The Exam Date should not be blank...!";
    }
    if (empty($duration)) {
        $message['duration'] = "The Duration should not be blank...!";
    }
    if (empty($startTime)) {
        $message['startTime'] = "The Stat time should not be blank...!";
    }
  
  
    if (empty($message)) {
        $db = dbConn();
        $sql = "INSERT INTO `exams`(`ClassdetailId`, `ExamName`, `ExamDate`, `Duration`, `StartTime`, `EndTime`) "
                ."VALUES ('$classname','$examname','$examdate','$duration','$startTime','$endTime')";
        $db->query($sql);
        
        header("Location:manage.php");
    }


    
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Exam</h3>
            </div>              
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="row">
                       
                        <div class="col-md-4">
                            <?php
                            $db = dbConn();
                            $tid = $_SESSION['TEACHERID'];
                            $sql = "SELECT * FROM classdetails WHERE TeacherID = '$tid'";
                            $result = $db->query($sql);
                            ?>
                            <label for="classname">Class Name</label>
                            <select Name="classname"  class="form-control" id="classname"aria-label="Large select example" >
                                <option value="" >---</option> 
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['ClassName'] ?></option>
                                    <?php
                                }
                                ?> 
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="classroomname">Exam Name</label>
                            <input type="text" name="examname" class="form-control" id="examname" value="<?= @$examname ?>" placeholder="Mid Exam" required>   
                            <span class="text-danger"><?= @$message['examname'] ?></span>
                        </div>

                        <div class="col-md-4">
                            <label for="weekday">Exam Date</label>
                            <input type="date" name="examdate" class="form-control" id="examdate" value="" required>
                        </div>

                        <div class="col-md-4">
                            <label for="duration">Duration (Minutes)</label>
                            <input type="number" name="duration" class="form-control" id="duration" value="<?= @$duration ?>" placeholder="3" required>
                            <span class="text-danger"><?= @$message['duration'] ?></span>
                        </div>

                        <div class="col-md-4">
                            <label for="start-time">Start Time</label>
                            <input type="time" name="startTime" class="form-control" id="startTime" value="" placeholder="04.00" required>

                        </div>

                        <div class="col-md-4">
                            <label for="end-time">End Time</label>
                            <input type="time" name="endTime" class="form-control" id="endTime" value="" placeholder="06.00" readonly>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="clear" class="btn btn-info">Clear</button>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </div>
   
</div>


<?php
session_abort();
$content = ob_get_clean();
include '../layouts_2.php';
?>
<script>
        $(document).ready(function() {
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
                    var endDate = new Date(startDate.getTime() + (duration/60) * 60 * 60 * 1000);
                    
                    var endHours = String(endDate.getHours()).padStart(2, '0');
                    var endMinutes = String(endDate.getMinutes()).padStart(2, '0');
                    $('#endTime').val(endHours + ':' + endMinutes);
                }
            }
            $('#duration').on('input', calculateEndTime);
            $('#startTime').on('input', calculateEndTime);
        });
    </script>