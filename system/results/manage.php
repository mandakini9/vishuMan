<?php
ob_start();
include_once '../init.php';

$link = "Result Management";
$breadcrumb_item = "Result";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>results/resultadd.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Result Details</h3>

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
//                $sql="SELECT * FROM users u "
//                        . "INNER JOIN employee e ON e.UserId=u.UserId "
//                        . "LEFT JOIN departments d ON d.Id=e.DepartmentId "
//                        . "LEFT JOIN designations p ON p.Id=e.DesignationId";
                $sql="SELECT sr.SRegNo AS StudentNo, FirstName, LastName, ExamMarks FROM studentresults sr "
                        . "INNER JOIN classdetails cd ON cd.Id=sr.ClassName LEFT JOIN exams e ON e.Id=sr.ExamName";
                $result=$db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class Name</th>
                            <th>Exam Name</th>
                            <th>Exam Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows>0){
                            while ($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $row['StudentNo'] ?></td>
                            <td><?= $row['FirstName'] ?></td>
                            <td><?= $row['LastName'] ?></td>
                            <td><?= $row['ExamMarks'] ?></td>
<!--                           <td><a href="<?= SYS_URL ?>users/edit.php?userid=<?= $row['UserId'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i> View Results</a></td>
                            <td><a href="<?= SYS_URL ?>users/edit.php?userid=<?= $row['UserId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></td>
                            <td><a href="<?= SYS_URL ?>users/delete.php?userid=<?= $row['UserId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i> Delete</a></td>-->
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
include '../layouts_2.php';
?>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>
