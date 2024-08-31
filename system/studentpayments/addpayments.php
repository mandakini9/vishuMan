<?php
ob_start();
include_once '../init.php';

$link = "Students Payments";
$breadcrumb_item = "Payments";
$breadcrumb_item_active = "Add";

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    extract($_POST);
//
//    $message = array();
//    if (empty($classname)) {
//        $message['classname'] = "The Class Name should not be blank...!";
//    }
//    if (empty($examname)) {
//        $message['examname'] = "The Exam Name should not be blank...!";
//    }
//    if (empty($examdate)) {
//        $message['examdate'] = "The Exam Date should not be blank...!";
//    }
//    if (empty($duration)) {
//        $message['duration'] = "The Duration should not be blank...!";
//    }
//    if (empty($startTime)) {
//        $message['startTime'] = "The Stat time should not be blank...!";
//    }
//
//
//    if (empty($message)) {
//        $db = dbConn();
//        $sql = "INSERT INTO `exams`(`ClassdetailId`, `ExamName`, `ExamDate`, `Duration`, `StartTime`, `EndTime`) "
//                . "VALUES ('$classname','$examname','$examdate','$duration','$startTime','$endTime')";
//        $db->query($sql);
//
//        header("Location:manage.php");
//    }
//}
//
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Payment </h3>
            </div>              

            <div class="card-body">
                <div class="row">
                    <?php
                    $db = dbConn();
                    $sregno = null;
                    extract($_GET);
                    $sql = "SELECT d.Id AS ID, r.StudentId AS StudentID, r.SRegNo, s.FirstName, s.LastName, d.ClassName AS ClassName, d.ClassFee AS Fee FROM registerstudents r "
                            . "INNER JOIN classdetails d ON d.Id=r.ClassId  LEFT JOIN students s ON s.Id=r.StudentId WHERE r.SRegNo='$sregno'";
                    $result = $db->query($sql);
                    ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="sregno" class="form-control float-right" placeholder="Student RegNo">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card-body table-responsive p-0">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            extract($_POST);

                            $stid = $studentId;
                            $db = dbConn();

                            foreach ($_POST['ttFee'] as $feeClass) {
                                // Split the value to get TotalFee and ClassName
                                list($totalFee, $classNames) = explode('|', $feeClass);

                                $sql = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate`,`PaymentType`,`status`) "
                                        . "VALUES ('$stid','$classNames','$totalFee','Cash',CURRENT_DATE,'2','2')";
                                $db->query($sql);
                            }

                            header("Location:paymentsuccess.php");
                        }
                        ?>
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate >
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Class name</th>
                                        <th>Class Fee</th>
                                        <th>Last Paid Date</th>
                                        <th>Comment</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $className = $row['ClassName'];
                                            $totalFee = $row['Fee'];
                                            $StudentID = $row['StudentID'];

                                            $i = 1;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" id="ttFee<?= $i ?>" name="ttFee[]" value="<?= $row['Fee'] ?> | <?= $row['ClassName'] ?>" onclick="calculateTotal()"/></td>

                                                <td><?= $row['ClassName'] ?></td>
                                                <td><?= $row['Fee'] ?></td>
                                                <?php
                                                $db = dbConn();
                                                $sql_2 = "SELECT * FROM approvalpayments  WHERE StudentId='$StudentID' ORDER BY PaidDate DESC LIMIT 1";
                                                $result_2 = $db->query($sql_2);
                                                $row_2 = $result_2->fetch_assoc();
                                                $paidDate = $row_2['PaidDate'];
                                                $currentdate = date('Y-m-d');

                                                // Convert PaidDate to a DateTime object
                                                $paidDateObj = new DateTime($paidDate);

                                                // Get the current date
                                                $currentDateObj = new DateTime($currentdate);

                                                // Calculate the difference in months
                                                $interval = $paidDateObj->diff($currentDateObj);
                                                $monthsDifference = ($interval->y * 12) + $interval->m;
                                                ?>
                                                <td><?= $row_2['PaidDate'] ?></td>
                                                <?php
                                                if ($monthsDifference >= 2) {
                                                    ?>
                                                    <td><div class='text-danger'>Error: The <b><?= $className ?></b> payment is overdue by 2 or more months.</div></td>
                                                    <?php } elseif ($row_2['PaidDate'] == $currentdate) {
                                                    ?>
                                                    <td><div class='text-danger'><b><?= $className ?></b> payment is Already Done.</div></td>
                                                    <?php } else { ?>
                                                    <td>-</td>
                                                    <?php } ?>
                                                </tr>

                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12">
                                    <p>Total Fee: Rs. <span id="totalValue">0</span></p>
                                    <!--<input type="hidden" id="totalFee" name="totalFee" value="">-->
                                    <input type="hidden" id="hiddenTotalFee" name="totalFee" value="">
                                    <input type="hidden" id="hiddenClassNames" name="classNames" value="">
                                    <input type="hidden" id="hiddenClassNames" name="classNames" value="">
                                    <!--                        <label for="Paid">Paid Amount:</label>
                                                            <input type="text" id="Paid" name="Paid" value="" oninput="calculateBalance()">
                                    
                                                            <label for="balance">Balance Amount:</label>
                                                            <input type="text" id="balance" name="balance" value="" disabled>-->
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label for="pay_method">Payment Method : </label>
                                    <label for="pay_method" style="font-weight: 400 !important;">Cash</label>
                                    <input type="hidden" name="studentId" class="form-control fs-5" id="studentId" value="<?= $StudentID ?>">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">Pay</button>
                                </div>
                            </form>
                        </div>

                    </div>
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
    function calculateTotal() {
        let total = 0;
        // Select all checkboxes with name 'ttFee[]'
        const checkboxes = document.querySelectorAll('input[name="ttFee[]"]:checked');
        checkboxes.forEach(checkbox => {
            total += parseInt(checkbox.value);
        });
        // Update the total value in the DOM
        document.getElementById('totalValue').innerText = total;
//        document.getElementById('totalFee').value = total;
    }

//    function calculateBalance() {
//        // Get the total fee and paid amount
//        var totalFee = parseFloat(document.getElementById('totalFee').value);
//        var paidAmount = parseFloat(document.getElementById('Paid').value);
//
//        // Check if paidAmount is a valid number, if not set it to 0
//        if (isNaN(paidAmount)) {
//            paidAmount = 0;
//        }
//
//        // Calculate the balance
//        var balance =  paidAmount - totalFee;
//
//        // Set the balance value in the balance input field
//        document.getElementById('balance').value = balance.toFixed(2);
//    }
</script>