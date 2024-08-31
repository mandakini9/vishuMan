<?php
ob_start();
include_once '../init.php';

$link = "Exam Management";
$breadcrumb_item = "Exam";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>exams/examadd.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Exam Details</h3>

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
                $sql="SELECT e.Id as ID,c.ClassName as ClassName ,e.ExamName,e.ExamDate,e.Duration,"
                        . "e.StartTime,e.EndTime FROM exams e INNER JOIN  classdetails c ON e.ClassdetailId=c.Id";
                $result=$db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class Name</th>
                            <th>Exam Name</th>
                            <th>Exam Date</th>
                            <th>Duration(Minutes)</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows>0){
                            while ($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $row['ID'] ?></td>
                            <td><?= $row['ClassName'] ?></td>
                            <td><?= $row['ExamName'] ?></td>
                            <td><?= $row['ExamDate'] ?></td>
                            <td><?= $row['Duration'] ?></td>
                            <td><?= $row['StartTime'] ?></td>
                            <td><?= $row['EndTime'] ?></td>
                            <td><a href="<?= SYS_URL ?>users/edit.php?userid=<?= $row['UserId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></td>
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
include '../layouts_2.php';
?>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>
