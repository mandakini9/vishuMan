<?php
ob_start();
include_once '../init.php';

$link = "Classroom Management";
$breadcrumb_item = "class";
$breadcrumb_item_active = "Classroom Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>class/classroomadd.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Class Room Details</h3>

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
                $sql="SELECT DISTINCT r.Id,d.ClassName ,w.Name ,h.HallName,r.StartTime ,r.EndTime FROM classroom_allocation r INNER JOIN classdetails d ON 
                        d.Id=r.ClassdetailId LEFT JOIN weekdays w ON w.Id=r.WeekdayId LEFT JOIN halls h ON h.Id=r.HallId";
                $result=$db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class Name </th>
                            <th>Weekday</th>
                            <th>ClassRoom Name</th>
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
                            <td><?= $row['Id'] ?></td>
                            <td><?= $row['ClassName'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['HallName'] ?></td>
                            <td><?= $row['StartTime'] ?></td>
                            <td><?= $row['EndTime'] ?></td>
                            <td><a href="<?= SYS_URL ?>class/classroomedit.php?roomid=<?= $row['Id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></td>
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
