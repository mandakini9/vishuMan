<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Result Management";
$breadcrumb_item = "Result";
$breadcrumb_item_active = "Add";

?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Result </h3>
            </div>  
            <div class="card-body">
                <div class="row">
                    
                    
            <form action="issue_results.php" method="post">
                <div class="card-body">
                    <div class="row">
                       
                        <div class="col-md-6">
                            <?php
                            $db = dbConn();
                            $tid = $_SESSION['TEACHERID'];
                            $sql = "SELECT * FROM  classdetails WHERE TeacherId='$tid'";
                            $result = $db->query($sql);
                            ?>
                            <label for="classname">Class Name</label>
                            <select name="classname"  class="form-control" id="classname" aria-label="Large select example" >
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
                        
                        <div class="col-md-6">
                            <label for="examname">Exam Name</label>
                            <select name="examname" class="form-control" id="examname" aria-label="Large select example">
                                <option value="">---</option>
                            </select>
                        </div>
                        <div class="card-body table-responsive p-0" id="stdata">
                
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
session_abort();
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
<script>
$(document).ready(function() {
    // Trigger when class is selected
    $('#classname').change(function() {
        var classId = $(this).val();  // Get selected class ID

        if (classId !== "") {
            // Make an AJAX request to fetch exams based on selected class
            $.ajax({
                url: 'fetch_exams.php',  // PHP script to handle the request
                method: 'GET',
                data: { classId: classId },
                success: function(response) {
                    $('#examname').html(response);  // Update exam dropdown
                }
            });
        } else {
            $('#examname').html('<option value="">---</option>');  // Reset if no class selected
        }
    });
});
</script>
<script>
$(document).ready(function() {
    // Trigger when class is selected
    $('#classname').change(function() {
        var classId = $(this).val();  // Get selected class ID

        if (classId !== "") {
            // Make an AJAX request to fetch exams based on selected class
            $.ajax({
                url: 'fetch_students.php',  // PHP script to handle the request
                method: 'GET',
                data: { classId: classId },
                success: function(response) {
                    $('#stdata').html(response);  // Update exam dropdown
                }
            });
        } else {
             // Reset if no class selected
        }
    });
});
</script>