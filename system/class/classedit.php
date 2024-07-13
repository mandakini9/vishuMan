<?php
ob_start();
include_once '../init.php';

$link = "Class Management";
$breadcrumb_item = "class";
$breadcrumb_item_active = "Update";


//get class details from db
        extract($_POST);
        extract($_GET);
    
    $db = dbConn();
    $sql = "SELECT * FROM classdetails WHERE Id=$classId ";

    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    
    
    $ayear = $row['AcademicId'];
    $grade = $row['grade'];
    $subject = $row['subject'];
    $classmedium = $row['classmedium'];
    $classtype = $row['classtype'];
    $classname = $row['classname'];
    $teacher = $row['teacher'];
    $classfees = $row['classfees'];
    
 




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $ayear = dataClean($ayear);
    $grade = dataClean($grade);
    $subject = dataClean($subject);
    $classmedium = dataClean($classmedium);
    $classtype = dataClean($classtype);
    $classname = dataClean($classname);
    $teacher = dataClean($teacher);
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
        $sql = "UPDATE  classdetails SET AcademicId='$ayear',GradeId='$grade',SubjectId='$subject',MediumId='$classmedium',ClasstypeId='$classtype',ClassName='$classname',TeacherId='$teacher',Classfee='$classfees'";
        $db->query($sql);
        
        header("Location:class_manage.php");
    }


    
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">UPdate  Class</h3>
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
                            <select name="ayear" id="ayear" onchange=""  class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                                 <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"<?= @$$ayear == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
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
                            <select name="grade" id="grade"  onchange="loadTName()" class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" <?= @$grade == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
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
                            <select name="subject" id="subject" onchange="loadTName()" class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" <?= @$subject == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
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
                            <select name="classmedium" id="classmedium" onchange="loadTName()" class="form-control" aria-label="Large select example">
                                <option value="" >--</option>
                               <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" <?= @$classmedium == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
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
                                    <select name="classtype" id="classtype"  onchange="" class="form-control" aria-label="Large select example">
                                        <option value="" >--</option>
                                       <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?> 

                                    </select>   
                                </div>
                    
                    <div class="col-md-6">
                                    <label for="classname">Class Name</label>
                                    <input type="text" name="classname" class="form-control" id="classname" value="" placeholder="Class Name" required>
                                    
                                </div>
                    <div class="col-md-6">
                        
                                    <label for="teacher">Teacher Name</label>
                                    <div id="tname">
                                    <select name="teacher" id="teacher"  class="form-control" aria-label="Large select example">
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
                     <input type="hidden" name="classId" value="<?= $classId ?>">
                    <button type="submit" class="btn btn-success">Update</button>
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

<!--<script>
    $(document).ready(function () {
        loadcName('<?= @$classname ?>');
    });


    function loadcName(cname) {
        var academicId = $('#ayear').val();
        var gradeId = $('#grade').val();
        var subjectId = $('#subject').val();
        var mediumId = $('#classmedium').val();
        var classtypeId = $('#classtype').val();

        if (academicId && gradeId && subjectId && mediumId && classtypeId ) {

            $.ajax({
                url: 'get_class_name.php?academicId=' + academicId + '&gradeId=' + gradeId + '&subjectId='+ subjectId + '&mediumId=' + mediumId + '&classtypeId='+ classtypeId + '&selcname='+cname,
                type: 'GET',
                success: function (data) {
                    $("#cname").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }


    }

</script>-->