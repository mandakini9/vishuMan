<?php
ob_start();
include_once '../init.php';

$link = "Students";
$breadcrumb_item = "student";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
       
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Student Details</h3>

                
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn();
                $sql="SELECT s.Id as Id,s.SRegNo as SRegNo,s.FirstName,s.LastName,s.MobileNo,g.Name as GradeId, g.Id as gId  FROM students s "
                        . "INNER JOIN grades g ON g.Id=s.GradeId WHERE status = 2";
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
<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>
