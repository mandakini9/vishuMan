<?php
ob_start();
include_once '../init.php';

$link = "class Management";
$breadcrumb_item = "ClassDetail";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>class/classadd.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Class Details</h3>

<!--                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>-->
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn();
                $sql="SELECT a.Name, c.Id as Id ,c.ClassName ,t.FirstName,t.LastName,c.Classfee 
                    FROM classdetails c INNER JOIN  academicyears a ON a.Id=c.AcademicId LEFT JOIN teachers t ON t.TeacherId=c.TeacherId";
                $result=$db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Academic Year</th>
                            <th>Class Name</th>
                            <th>Teacher Name</th>
                            <th>Class fee</th>
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
                            <td><?= $row['Id'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['ClassName'] ?></td>
                            <td><?= $row['FirstName'] ?>  <?= $row['LastName'] ?></td>
                            <td><?= $row['Classfee'] ?></td>
                            <td><a href="<?= SYS_URL ?>class/classedit.php?classId=<?= $row['Id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></td>
                            <td><a href="<?= SYS_URL ?>class/classdelete.php?classId=<?= $row['Id'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i> Delete</a></td>
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
