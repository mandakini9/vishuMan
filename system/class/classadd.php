<?php
ob_start();
include_once '../init.php';

$link = "Class Management";
$breadcrumb_item = "class";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);

    
    $classfees = dataClean($classfees);
    
    $message = array();
    if (empty($ayear)) {
        $message['ayear'] = "The Academic Year should not be blank...!";
    }
    if (empty($grade)) {
        $message['grade'] = "The Grade should not be blank...!";
    }
    if (empty($subject)) {
        $message['subject'] = "The Subject should not be blank...!";
    }
    if (empty($classmedium)) {
        $message['classmedium'] = "The Class Medium should not be blank...!";
    }
    if (empty($classtype)) {
        $message['classtype'] = "The Class Type should not be blank...!";
    }
    if (empty($classname)) {
        $message['classname'] = "The Class Name should not be blank...!";
    }
    if (empty($teacher)) {
        $message['teacher'] = "The Teacher Name should not be blank...!";
    }
    if (empty($classfees)) {
        $message['classfees'] = "The Class Fee should not be blank...!";
    }
    
    if (empty($message)) {
    
        $db = dbConn();
        $sql = "INSERT INTO classdetails(AcademicId,GradeId,SubjectId,MediumId,ClasstypeId,ClassName,TeacherId,Classfee) VALUES ('$ayear','$grade','$subject','$classmedium','$classtype','$classname','$teacher','$classfees')";
        $db->query($sql);
        
        header("Location:class_manage.php");
    }


    
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Class</h3>
            </div>              
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                <div class="row">
                   
                        <div class="col-md-4">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  academicyears";
                            $result = $db->query($sql);
                            ?>
                         <label for="ayear">Academic Year</label>
                            <select name="ayear" id="ayear" onchange="loadcName()"  class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                                 <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" data-name="<?= $row['Name'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  grades";
                            $result = $db->query($sql);
                            ?>
                         <label for="grade">Grade</label>
                            <select name="grade" id="grade"  onchange="loadTName(); loadcName();" class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" data-name="<?= $row['Name'] ?>" <?= @$grade == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  subjects";
                            $result = $db->query($sql);
                            ?>
                         <label for="subject">Subject</label>
                            <select name="subject" id="subject" onchange="loadTName(); loadcName();" class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" data-name="<?= $row['Name'] ?>" <?= @$subject == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  medium";
                            $result = $db->query($sql);
                            ?>
                         <label for="classmedium">Class Medium</label>
                            <select name="classmedium" id="classmedium" onchange="loadTName(); loadcName();" class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                               <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" data-name="<?= $row['Name'] ?>" <?= @$classmedium == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?> 
                            </select>
                        </div>
                    
                     <div class="col-md-3">
                          <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  classtypes";
                            $result = $db->query($sql);
                            ?>
                                    <label for="classtype">Class Type</label>
                                    <select name="classtype" id="classtype"  onchange="loadcName()" class="form-control" aria-label="Large select example">
                                        <option value="" >--</option>
                                       <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" data-name="<?= $row['Name'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?> 

                                    </select>   
                                </div>
                    
                    <div class="col-md-6">
                                    <label for="classname">Class Name</label>
                                      <div id="cname">
                                    <input type="text" name="classname" class="form-control" id="classname" value="" placeholder="Class Name" readonly>
                                      </div>
                                </div>
                    <div class="col-md-6">
                        
                                    <label for="teacher">Teacher Name</label>
                                    <div id="tname">
                                        <select name="teacher" id="teacher"  class="form-control" aria-label="Large select example" disabled>
                                        <option value="" >---</option>
                                    </select>   
                                </div>
                    </div>
                    
                               
                    
                    
                    <div class="col-md-6">
                                    <label for="classfees">Class Fees</label>
                                    <input type="number" name="classfees" class="form-control" id="classfees" value="" placeholder="1000.00" required>
                                    
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
    $(document).ready(function () {
        loadTName('<?= @$teacher ?>');
    });


    function loadTName(tname) {
        var gradeId = $('#grade').val();
        var subjectId = $('#subject').val();
        var mediumId = $('#classmedium').val();

        if (gradeId && subjectId && mediumId) {

            $.ajax({
                url: 'get_teacher_name.php?gradeId=' + gradeId + '&subjectId='+ subjectId + '&mediumId=' + mediumId +'&seltname='+tname,
                type: 'GET',
                success: function (data) {
                    $("#tname").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }


    }

</script>

<script>
    function loadcName() {
      
        var academicId = document.getElementById('ayear');
        var gradeId = document.getElementById('grade');
        var subjectId = document.getElementById('subject');
        var mediumId = document.getElementById('classmedium');
        var classtypeId = document.getElementById('classtype');

        var academicYearName = academicId.options[academicId.selectedIndex].getAttribute('data-name');
        var gradeName = gradeId.options[gradeId.selectedIndex].getAttribute('data-name');
        var subjectName = subjectId.options[subjectId.selectedIndex].getAttribute('data-name');
        var mediumName = mediumId.options[mediumId.selectedIndex].getAttribute('data-name');
        var classtypeName = classtypeId.options[classtypeId.selectedIndex].getAttribute('data-name');

        var className = academicYearName + ' '+gradeName + ' ' + subjectName + ' ' + mediumName+ ' ' + classtypeName;
        
        document.getElementById('classname').value = className;
    

    }

</script>