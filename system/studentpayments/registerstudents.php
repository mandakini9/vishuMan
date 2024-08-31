<?php
ob_start();
include_once '../init.php';

$link = "Registered Students";
$breadcrumb_item = "student";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
       
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Student Details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn();
                $sql="SELECT s.Id as Id,s.SRegNo as SRegNo,s.FirstName,s.LastName,s.MobileNo,"
                        . "g.Name as GradeId, g.Id as gId, "
                        . "GROUP_CONCAT(DISTINCT a.ClassName ORDER BY a.ClassName ASC SEPARATOR ', ') AS ClassName FROM students s "
                        . "INNER JOIN grades g ON g.Id=s.GradeId "
                        . "LEFT JOIN registerstudents r ON r.StudentId = s.Id "
                        . "LEFT JOIN approvalpayments a ON a.StudentId = s.Id WHERE s.status = 1 GROUP BY a.StudentId";
                $result=$db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SRegNo</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Grade</th>
                            <th>MobileNo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows>0){
                            while ($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $row['Id'] ?></td>
                            <td><?= $row['SRegNo'] ?></td>
                            <td><?= $row['FirstName'] ?></td>
                            <td><?= $row['LastName'] ?></td>
                            <td><?= $row['GradeId'] ?></td>
                            <td><?= $row['MobileNo'] ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="toggleContainer('<?= $row['Id'] ?>','<?= $row['SRegNo'] ?>','<?= $row['FirstName'] ?>','<?= $row['LastName'] ?>','<?= $row['GradeId'] ?>','<?= $row['ClassName'] ?>')" data-toggle="modal" data-target="#userModal">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                            <td><a href="<?= SYS_URL ?>students/enrollment/student_class.php?gradeId=<?= $row['gId'] ?>&studentId=<?= $row['Id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Enroll class</a></td>
                            <td><a href="<?= SYS_URL ?>users/delete.php?userid=<?= $row['UserId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i> Delete</a></td>
                        </tr>
                        
                        <?php 
                            }
                            } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Registered Student Details</h5>
            </div>
            <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-bordered text-nowrap">

                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td><label style="font-weight: 500 !important" id="reg_id"></label></td>
                            </tr>
                            <tr>
                                <td>SRegNo</td>
                                <td><label style="font-weight: 500 !important" id="sreg_no"></label></td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td><label style="font-weight: 500 !important" id="student_fname"></label></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td><label style="font-weight: 500 !important" id="student_lname"></label></td>
                            </tr>
                            <tr>
                                <td>Grade</td>
                                <td><label style="font-weight: 500 !important" id="student_grade"></label></td>
                            </tr>

                            <tr>
                                <td>Registered Classes</td>
                                <td><label style="font-weight: 500 !important" id="enrolled_classes"></label></td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
                

            </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
    
    function toggleContainer(para1,para2,para3,para4,para5,para6) {
            var container = document.getElementById('userModal');
                
//            alert(para1);
            var reg_id = document.getElementById('reg_id');
            var sreg_no = document.getElementById('sreg_no');
            var student_fname = document.getElementById('student_fname');
            var student_lname = document.getElementById('student_lname');
            var student_grade = document.getElementById('student_grade');
            var enrolled_classes = document.getElementById('enrolled_classes');

            reg_id.textContent = para1;
            sreg_no.textContent = para2;
            student_fname.textContent = para3;
            student_lname.textContent = para4;
            student_grade.textContent = para5;
            enrolled_classes.textContent = para6;

            container.style.display = 'block';
        }
</script>
