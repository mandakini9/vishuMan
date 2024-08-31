<?php
ob_start();

include_once '../init.php';

$link = "Classroom Management";
$breadcrumb_item = "classroom";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    
    $message = array();
    if (empty($classname)) {
        $message['classname'] = "The Class Name should not be blank...!";
    }
    if (empty($classroomname)) {
        $message['classroomname'] = "The Last Name should not be blank...!";
    }
    if (empty($weekday)) {
        $message['weekday'] = "The Week Day should not be blank...!";
    }
    if (empty($duration)) {
        $message['duration'] = "The Duration should not be blank...!";
    }
    if (empty($startTime)) {
        $message['startTime'] = "The Stat time should not be blank...!";
    }
    
    if (empty($allocationtype)) {
        $message['allocationtype'] = "The Allocation Type should not be blank...!";
    }
    
//    if (empty($classname && $classroomname && $weekday)) {
//        $db = dbConn();
//        $sql = "SELECT * FROM classroom_allocation "
//                . " WHERE ClassdetailId=$classname AND HallId=$classroomname AND WeekdayId=$weekday'";
//        $result = $db->query($sql);
//
//        if ($result->num_rows > 0) {
//            $message['allocation'] = "Already allocate";
//        }
//    }
    if (empty($message)) {
        $db = dbConn();
        echo $sql2 = "SELECT * FROM classroom_allocation "
                . " WHERE ClassdetailId=$classname AND HallId=$classroomname AND WeekdayId=$weekday";
        $result2 = $db->query($sql2);

        if ($result2->num_rows > 0) {
            echo 'thiyenwa';
            $message['allocation'] = "Already allocate";
        }
    }


//    if (empty($message)) {
//        $db = dbConn();
//        $sql = "INSERT INTO classroom_allocation(ClassdetailId,HallId,WeekdayId,Duration,StartTime,EndTime,AllocationId) VALUES ('$classname','$classroomname','$weekday','$duration','$startTime','$endTime','$allocationtype')";
//        $db->query($sql);
//        
////        header("Location:classroom_manage.php");
//    }

  
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Classroom</h3>
            </div>              
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        

                        <div class="col-md-6">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  classdetails";
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
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  halls";
                            $result = $db->query($sql);
                            ?>
                            <label for="classroomname">Classroom Name</label>
                            <select name="classroomname" id="classroomname"  class="form-control" aria-label="Large select example">
                                <option value="" >---</option> 
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['HallName'] ?></option>
                                    <?php
                                }
                                ?> 
                            </select>   
                        </div>

                        <div class="col-md-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  weekdays";
                            $result = $db->query($sql);
                            ?>
                            <label for="weekday">Week day</label>
                            <select name="weekday" id="weekday"  class="form-control" aria-label="Large select example">
                                <option value="" >---</option> 
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?> 
                            </select>
                            <span class="text-danger"><?= @$message['allocation'] ?></span>
                        </div>


                        <div class="col-md-4">
                            <label for="duration">Duration (Minutes)</label>
                            <input type="number" name="duration" class="form-control" id="duration" value="" placeholder="3" required>

                        </div>

                        <div class="col-md-4">
                            <label for="start-time">Start Time</label>
                            <input type="time" name="startTime" class="form-control" id="startTime" value="" placeholder="04.00" required>

                        </div>

                        <div class="col-md-4">
                            <label for="end-time">End Time</label>
                            <input type="time" name="endTime" class="form-control" id="endTime" value="" placeholder="06.00" readonly>

                        </div>

                        

                        <div class="col-md-4">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  allocationtypes";
                            $result = $db->query($sql);
                            ?>
                            <label for="allocationtype">Allocation Type</label>
                            <select name="allocationtype" id="allocationtype"  class="form-control" aria-label="Large select example">
                                <option value="" >---</option> 
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?> 

                            </select>   
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
$content = ob_get_clean();
include '../layouts.php';
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