<?php
ob_start();
include_once '../init.php';

$link = "Attendance";
$breadcrumb_item = "students";
$breadcrumb_item_active = "Attendance";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>students/addattendance.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance Details</h3>

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
                $db = dbConn();
                $sql = "SELECT ClassDate, d.ClassName, COUNT(Status) AS HEADS FROM classattendance a "
                        . "INNER JOIN classdetails d ON d.Id = a.ClassdetailId WHERE Status=1";
                $result = $db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            
                            <th>Class Name </th>
                            <th>Class Date</th>
                            <th>Head Count</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    
                                    <td><?= $row['ClassName'] ?></td>
                                    <td><?= $row['ClassDate'] ?></td>
                                    <td><?= $row['HEADS'] ?></td>
                                    

                                </tr>

                                <?php
                            }
                        }
                        ?>
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
