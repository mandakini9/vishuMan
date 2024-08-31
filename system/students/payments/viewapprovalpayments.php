<?php
ob_start();
include_once '../../init.php';

$link = "Student Management";
$breadcrumb_item = "Payments";
$breadcrumb_item_active = "Approval Payments";
?> 
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">View Approval Payment Details</h3>

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
                $sql = "SELECT a.Id as PayId, StudentId, `FirstName`,`LastName`,`ClassName`, `TotalFee`,`PaymentType`, `PaidDate`, `BankName`, "
                        . "`BranchName`, `UploadSlip`, s.status as StStatus, a.status as PayStatus FROM approvalpayments a "
                        . "LEFT JOIN students s ON a.StudentId = s.Id WHERE a.PayMethod = 'Bank'";
                $result = $db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>PayID</th>
                            <th>Student Name</th>
                            <th>Class Name</th>
                            <th>Total Fee</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if($row['PaymentType'] == 1) {
                                    $paytype = 'Admission Fee';
                                } else {
                                    $paytype = 'Class Fee';
                                }
                                ?>
                                <tr>
                                    <td><?= $row['PayId'] ?></td>
                                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                                    <td><?= $row['ClassName'] ?></td>
                                    <td>Rs. <?= $row['TotalFee'] ?></td>
                                    <td><?= $row['PaidDate'] ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="toggleContainer('<?= $row['PayId'] ?>','<?= $row['FirstName'] ?> <?= $row['LastName'] ?>','<?= $row['ClassName'] ?>','<?= $row['TotalFee'] ?>', '<?= $paytype ?>','<?= $row['PaidDate'] ?>','<?= $row['BankName'] ?>','<?= $row['BranchName'] ?>','<?= $row['UploadSlip'] ?>')" data-toggle="modal" data-target="#userModal">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                    <?php if ($row['StStatus'] == '2') {
                                        if($row['PayStatus'] == '2'){?>
                                        <td>
                                            <a href="<?= SYS_URL ?>students/approve.php?studentId=<?= $row['StudentId'] ?>&totalFee=<?= $row['TotalFee'] ?>&className=<?= $row['ClassName'] ?>" class="btn btn-success">
                                                <i class="fas fa-thumbs-up"></i> Confirm Payment
                                            </a>
                                        </td>
                                        <?php } else { ?>
                                        <td>
                                            <button class="btn btn-success" disabled>
                                                <i class="fas fa-thumbs-up"></i> Approved
                                            </button>
                                        </td>
                                    <?php }} elseif($row['StStatus'] == '1') {
                                        if($row['PayStatus'] == '2'){?>
                                        <td>
                                            <a href="<?= SYS_URL ?>students/approve.php?studentId=<?= $row['StudentId'] ?>&totalFee=<?= $row['TotalFee'] ?>&className=<?= $row['ClassName'] ?>" class="btn btn-success">
                                                <i class="fas fa-thumbs-up"></i> Confirm Payment
                                            </a>
                                        </td>
                                        <?php } else { ?>
                                        <td>
                                            <button class="btn btn-success" disabled>
                                                <i class="fas fa-thumbs-up"></i> Approved
                                            </button>
                                        </td>
                                    <?php }} elseif($row['StStatus'] == '3') { ?>
                                        <td>
                                            <button class="btn btn-success" disabled>
                                                <i class="fas fa-thumbs-up"></i> Confirm Payment
                                            </button>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <button class="btn btn-success" disabled>
                                                <i class="fas fa-thumbs-up"></i> Approved
                                            </button>
                                        </td>
                                    <?php } ?>
                                        
                                    <?php if ($row['StStatus'] <= '2') { ?>
                                        <td><a href="<?= SYS_URL ?>teachers/delete.php?userid=<?= $row['UserId'] ?>" class="btn btn-danger"  id="delete-button"><i class="fas fa-times"></i>  Reject</a></td>
                                    <?php } else { ?>
                                        <td>
                                            <button class="btn btn-danger" disabled>
                                                <i class="fas fa-times"></i> Rejected
                                            </button>
                                        </td>
                                    <?php } ?>
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
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Teacher Details</h5>
            </div>
            <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-bordered text-nowrap">

                        <tbody>
                            <tr>
                                <td>PayID</td>
                                <td><label style="font-weight: 500 !important" id="payment_id"></label></td>
                            </tr>
                            <tr>
                                <td>Student Name</td>
                                <td><label style="font-weight: 500 !important" id="student_name"></label></td>
                            </tr>
                            <tr>
                                <td>Class Name</td>
                                <td><label style="font-weight: 500 !important" id="class_name"></label></td>
                            </tr>
                            <tr>
                                <td>Payment Type</td>
                                <td><label style="font-weight: 500 !important" id="pay_type"></label></td>
                            </tr>
                            <tr>
                                <td>Fee</td>
                                <td><label style="font-weight: 500 !important" id="total_fee"></label></td>
                            </tr>
                            <tr>
                                <td>Payment Date</td>
                                <td><label style="font-weight: 500 !important" id="payment_date"></label></td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td><label style="font-weight: 500 !important" id="bank_name"></label></td>
                            </tr>

                            <tr>
                                <td>Branch Name</td>
                                <td><label style="font-weight: 500 !important" id="branch_name"></label></td>
                            </tr> 

                            <tr>
                                <td>Payment Slip</td>
                                <td>
                                    <!--<label style="font-weight: 500 !important" id="payment_slip"></label>-->
                                    <img src="" alt="alt" id="payment_slip"/>
                                </td>
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
include '../../layouts.php';
?>
<script>
//    function confirmDelete() {
//        return confirm("Are you sure you want to delete this record?");
//    }
    
    function toggleContainer(para1,para2,para3,para4,para5,para6,para7,para8, para9) {
            var container = document.getElementById('userModal');
                
            var payment_id = document.getElementById('payment_id');
            var student_name = document.getElementById('student_name');
            var class_name = document.getElementById('class_name');
            var total_fee = document.getElementById('total_fee');
            var pay_type = document.getElementById('pay_type');
            var payment_date = document.getElementById('payment_date');
            var bank_name = document.getElementById('bank_name');
            var branch_name = document.getElementById('branch_name');
            var payment_slip = document.getElementById('payment_slip');

            payment_id.textContent = para1;
            student_name.textContent = para2;
            class_name.textContent = para3;
            total_fee.textContent = "Rs. "+para4;
            pay_type.textContent = para5;
            payment_date.textContent = para6;
            bank_name.textContent = para7;
            branch_name.textContent = para8;
            payment_slip.src = "slips/"+para9;

            container.style.display = 'block';
        }
</script>
