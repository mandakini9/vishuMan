<?php
ob_start();
include_once '../init.php';

$link = "Vishu Institute  Of Technoloy";
$breadcrumb_item = "Report";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Register Students Report</h3>
            </div>
            <div class="card-header">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="row">
                    <div class="col-md-4">
                    <label for="classroomname">From Date</label>
                    <input type="date" name="fromdate" class="form-control" id="fromdate">
                   
                    </div>
                        <div class="col-md-4">
                    <label for="classroomname">From Date</label>
                    <input type="date" name="todate" class="form-control" id="todate">
                        </div>
                        
                        <div class="col-md-4">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  classdetails";
                            $result = $db->query($sql);
                            ?>
                            <label for="classname">Class Name</label>
                            <select Name="classname"  class="form-control" id="classname"aria-label="Large select example" >
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
                        
                            
                            
                   
                    
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Search</button>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    
                    $where = "WHERE r.RegisterDate BETWEEN '$fromdate' AND '$todate' ";
                }
                $db = dbConn();
                $sql = "SELECT r.RegisterDate, s.FirstName,s.LastName,d.ClassName "
                        . "FROM registerstudents r INNER JOIN students s ON s.Id=r.StudentId "
                        . "LEFT JOIN classdetails d ON d.Id=r.ClassId $where";
                $result = $db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>

                            <th>Class Name</th>
                            <th>Student name</th>
                            <th>Register Date</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['ClassName'] ?></td>
                                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                                    <td><?= $row['RegisterDate'] ?></td>



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
    <a href="<?= SYS_URL ?>users/add.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> Print</a>
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
