<?php
ob_start();
include_once '../init.php';

$link = "Student Class Payments";
$breadcrumb_item = "payment";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>studentpayments/addpayments.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> New Payment</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Details</h3>

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
                $sql = "SELECT s.Id AS StudentID, s.SRegNo as SRegNo,s.FirstName,s.LastName, d.Classfee AS Fee, d.ClassName AS ClassName "
                        . "FROM students s INNER JOIN registerstudents r ON r.StudentId=s.Id LEFT JOIN classdetails d ON d.Id = r.ClassId;";
                $result = $db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>SRegNo</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Class Name</th>
                            <th>Class Fee</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $StudentID = $row['StudentID'];
                                ?>
                                <tr>
                                    <td><?= $row['SRegNo'] ?></td>
                                    <td><?= $row['FirstName'] ?></td>
                                    <td><?= $row['LastName'] ?></td>
                                    <td><?= $row['ClassName'] ?></td>
                                    <td><?= $row['Fee'] ?></td>
                                    <?php
                                    $db = dbConn();
                                    $sql_2 = "SELECT * FROM approvalpayments  WHERE StudentId='$StudentID' ORDER BY PaidDate DESC LIMIT 1";
                                    $result_2 = $db->query($sql_2);
                                    $row_2 = $result_2->fetch_assoc();
                                    ?>
                                    <td><?= $row_2['PaidDate'] ?></td>
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
