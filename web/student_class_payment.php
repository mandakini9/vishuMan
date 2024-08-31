<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';

extract($_GET);

$db = dbConn();
$stId = $_SESSION['STUDENTID'];
$sql = "SELECT r.StudentId AS StudentID, r.SRegNo, s.FirstName, s.LastName, d.ClassName AS ClassName, d.ClassFee AS Fee FROM registerstudents r "
        . "INNER JOIN classdetails d ON d.Id=r.ClassId  LEFT JOIN students s ON s.Id=r.StudentId WHERE r.StudentId='$stId'";

$result = $db->query($sql);
?>

<main class="main">
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Enroll The Class</h2>
        </div>

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="col-lg-12 mt-5 mt-lg-0 shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                extract($_POST);
//                               
//                                   // Retrieve the last payment date for the student
//                                    $sql = "SELECT MAX(PaidDate) as LastPaidDate FROM `approvalpayments` WHERE StudentId = $stId";
//                                    $resultLastPayment = $db->query($sql);
//                                    $row = $resultLastPayment->fetch_assoc();
//                                    $lastPaidDate = $row['LastPaidDate'];
//                                    $currentdate = date('Y-m-d');
//
//                                    // Check if the last payment date exists
//                                    if ($lastPaidDate) {
//                                        $lastPaidDateTime = new DateTime($lastPaidDate);
//                                        $currentDateTime = new DateTime($currentdate);
//                                        $interval = $lastPaidDateTime->diff($currentDateTime);
//
//                                        // Check if the difference is greater than or equal to 2 months
//                                        if ($interval->m >= 2 || $interval->y > 0) {
//                                            $message['date_error'] = "Error: Your last payment was more than 2 months ago. Please contact support.";
//                                        }
//                                    }
//                               
//                              //File Upload
                                $slipimg = $_FILES['uploadslip'];
                                if (!empty($slipimg)) {
                                    $filename = $slipimg['name'];
                                    $filetmp = $slipimg['tmp_name'];
                                    $filesize = $slipimg['size'];
                                    $fileerror = $slipimg['error'];

                                    $file_ext = explode('.', $filename);
                                    $file_ext = strtolower(end($file_ext));

                                    $allowd_ext = array('pdf', 'png', 'jpg', 'jpeg', 'gif');

                                    if (in_array($file_ext, $allowd_ext)) {
                                        if ($fileerror === 0) {
                                            if ($filesize <= 2097152) {
                                                $file_name = uniqid('', true) . '.' . $file_ext;

                                                $file_destination = '../system/students/payments/slips/' . $file_name;
                                                move_uploaded_file($filetmp, $file_destination);
                                            } else {
                                                $message['uploadslip'] = "File size is invalid";
                                            }
                                        } else {
                                            $message['uploadslip'] = "File has error";
                                        }
                                    } else {
                                        $message['uploadslip'] = "Invalid file type";
                                    }
                                }
                                //End File Upload
//                                header("Location:register_success.php");
//                                $message['error'] = "Upload";
                                if (empty($message)) {
                                    $stid = $_SESSION['STUDENTID'];
                                    $db = dbConn();

                                    foreach ($_POST['ttFee'] as $feeClass) {
                                        // Split the value to get TotalFee and ClassName
                                        list($totalFee, $classNames) = explode('|', $feeClass);

                                        $sql = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate` ,`BankName`,"
                                                . " `BranchName`, `UploadSlip`,`PaymentType`,`status`) VALUES ('$stid','$classNames','$totalFee',"
                                                . "'Bank',CURRENT_DATE,'$bankname','$branchname','$file_name','2','2')";
                                        $db->query($sql);
                                        // Now you have these variables:
                                    }

//                                    $user_id = $db->insert_id;
//
//                                    $reg_number = date('Y') . date('m') . date('d') . $user_id;
//                                    $_SESSION['RNO'] = $reg_number;
//                                    $sql = "INSERT INTO students (`FirstName`, `LastName`, `Email`, `Gender`, `GradeId`, `SchoolName`, `AddressLine1`, `AddressLine2`, `AddressLine3`, `TelNo`, `MobileNo`, `SRegNo`, `UserId`,`status`) "
//                                            . "VALUES ('$first_name','$last_name','$email','$gender','$grade','$schoolname','$addressline1','$addressline2','$addressline3','$telno','$mobile_no','$reg_number','$user_id', '2')";
//                                    $db->query($sql);
//                                    $msg = "<h1>SUCCESS</h1>";
//                                    $msg .= "<h2>Congratulations</h2>";
//                                    $msg .= "<p>Your account has been successfully created</p>";
//                                    $msg .= "<a href='http://localhost/IMS/verify.php'>Click here to verifiy your account</a>";
//                                    sendEmail($email, $first_name, "Account Verification", $msg);
                                    header("Location:approvesucess.php");
                                }
                            }
                            ?>
                            <!-- Display the error message if the payment is too late -->
                            <?php if (!empty($message['date_error'])): ?>
                                <div class="alert alert-danger">
                                    <?= $message['date_error'] ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate enctype="multipart/form-data">
                                <div class="row gy-4">

                                    <div class="col-md-12" id="ttable" style="display: block;">

                                        <div id="tabledata">
                                            <div class="card text-center mb-3">
                                                <div class="card-body">

                                                    <?php
                                                    while ($row = $result->fetch_assoc()) {
                                                        
                                                        $className = $row['ClassName'];
                                                        $totalFee = $row['Fee'];
                                                        $sql_2 = "SELECT * FROM approvalpayments  WHERE StudentId='$stId' ORDER BY PaidDate DESC LIMIT 1";
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

                                                        // Check if the payment date is 2 months or more behind the current month

                                                        if ($monthsDifference >= 2) {
                                                            ?>
                                                            <div class='error'>Error: The <b><?= $className ?></b> payment is overdue by 2 or more months.</div>
                                                            <?php
                                                        } elseif ($row_2['PaidDate'] == $currentdate) {
                                                            echo "<div class='error'>Your <b>" . $className . "</b> payment is Already Done.</div>";
                                                        } else {
                                                            $i = 1;
                                                            ?>
                                                            <h6 class="card-text">
                                                                <div class="ttgardient">
                                                                    <div class="badge">
                                                                        <input type="checkbox" id="ttFee<?= $i ?>" name="ttFee[]" value="<?= $row['Fee'] ?> | <?= $row['ClassName'] ?>" onclick="calculateTotal()"/>
                                                                    </div>
                                                                    <span class="badge">
                                                                        <span class="badge ttname"><?= $row['ClassName'] ?></span>
                                                                    </span>
                                                                    <span class="badge tttime">Rs. <?= $row['Fee'] ?></span>
                                                                    <span class="badge tttime ttdate" id="paimonth"><?= $row_2['PaidDate'] ?></span>
                                                                </div>
                                                            </h6>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <p>Total Fee: Rs. <span id="totalValue">0</span></p>
                                        <input type="hidden" id="hiddenTotalFee" name="totalFee" value="">
                                        <input type="hidden" id="hiddenClassNames" name="classNames" value="">
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="button" id="payButton" onclick="showUpload()">Pay</button>
                                    </div>
                                    <!--                                    <div class="alert alert-danger">
                                                                             Error message will be shown here 
                                                                        </div>-->
                                    <div id="paymenTag" class="row mt-4 d-none">
                                        <div class="col-md-6 mb-4">
                                            <label for="bankname">Bank Name</label>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <input type="text" name="bankname" class="form-control" id="bankname" required>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label for="branchname">Branch Name</label>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <input type="text" name="branchname" class="form-control" id="branchname" required>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label for="uploadslip">Upload Slip</label>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <input type="file" name="uploadslip" class="form-control" id="uploadslip" accept="image/*" required>
                                            <span class="text-danger"><?= @$message['uploadslip'] ?></span>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <div class="loading">Loading</div>
                                            <div class="error-message"></div>
                                            <div class="sent-message">Your message has been sent. Thank you!</div>

                                            <button type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                                <div class="row gy-4">
                                    <div class="col-md-12">
                                        <div class="container" data-aos="fade-up">
                                            <h4 class="fw-bolder text-primary">Bank Details</h4>
                                        </div><!-- End Section Title --><br>
                                        <p class="text-muted"><label class="fw-bold">Bank Name : </label><label for="first_name" style="text-align: center"> &nbsp;Peoples Bank</label></p>
                                        <p class="text-muted"><label class="fw-bold">Branch Name : </label><label for="first_name" style="text-align: center"> &nbsp;Kolonnawa</label></p>
                                        <p class="text-muted"><label class="fw-bold">Account Name : </label><label for="first_name" style="text-align: center"> &nbsp;D.M. Anuththara</label></p>
                                        <p class="text-muted"><label class="fw-bold">Account No : </label><label for="first_name" style="text-align: center"> &nbsp;119020172850</label></p>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div><!-- End Contact Form -->
                </div><!-- End Contact Form -->
            </div>
        </div>
    </section>
</main>
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
    }
</script>
<script>
    function showUpload() {
        var paymentTag = document.getElementById("paymenTag");
        paymentTag.classList.remove("d-none");
        paymentTag.classList.add("d-flex");
    }
</script>
<?php
ob_end_flush();
include 'footer.php';
?>



