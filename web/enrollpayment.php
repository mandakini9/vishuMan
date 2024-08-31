<?php
ob_start();
session_start();
extract($_GET);
include 'header.php';
include '../function.php';
include '../mail.php';
?>

<main class="main">

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Student Class Enrollment Payment</h2>

        </div><!-- End Section Title -->

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="row justify-content-center">

                    <div class="col-lg-7">
                        <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                extract($_POST);

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
                                    if ($addfeeid != 0) {
                                        $sql = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate` ,`BankName`, `BranchName`, `UploadSlip`,`PaymentType`,`status`) "
                                        . "VALUES ('$stid','$ClassName','$addFee','Bank',CURRENT_DATE,'$bankname','$branchname','$file_name','1','2')";
                                        $db->query($sql);

                                        $sql = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate` ,`BankName`, `BranchName`, `UploadSlip`,`PaymentType`,`status`) "
                                        . "VALUES ('$stid','$ClassName','$classFees','Bank',CURRENT_DATE,'$bankname','$branchname','$file_name','2','2')";
                                        $db->query($sql);
                                    } else {
                                         $sql = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate` ,`BankName`, `BranchName`, `UploadSlip`,`PaymentType`,`status`) "
                                        . "VALUES ('$stid','$ClassName','$classFees','Bank',CURRENT_DATE,'$bankname','$branchname','$file_name','2','2')";
                                        $db->query($sql);
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



                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate enctype="multipart/form-data">
                                <div class="row gy-4">

                                    <div class="col-md-12 mt-4">
                                        <?php
                                        $db = dbConn();

                                        $sql = "SELECT ClassName FROM classdetails WHERE GradeId=$gradeId AND SubjectId=$subjectId AND MediumId=$mediumId";

                                        $result = $db->query($sql);
                                        ?>
                                        <label for="ClassName" class="fw-bold text-info fs-4">Class Name</label>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <!--<p class="fs-5"><i><label for="ClassName" id="ClassName" name="ClassName"><?= $row['ClassName'] ?></label></i></p>-->
                                            <input type="text" name="ClassName" class="form-control fs-5" id="ClassName" value="<?= $row['ClassName'] ?>" readonly>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();

                                        $sql = "SELECT Classfee FROM classdetails WHERE GradeId=$gradeId AND SubjectId=$subjectId AND MediumId=$mediumId";

                                        $result = $db->query($sql);
                                        ?>
                                        <label for="classfee">Class Fee</label>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            Rs. <label for="classfee" id="classfee"><?= $row['Classfee'] ?></label>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();

                                        $sql = "SELECT Amount FROM addmissions WHERE Year = YEAR(CURDATE())";

                                        $result = $db->query($sql);
                                        ?>
                                        <label for="admissionfee">Admission  Fee</label>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            $studentID = $_SESSION['STUDENTID'];
                                            $sql2 = "SELECT * FROM registerstudents WHERE StudentId = $studentID";
                                            $result2 = $db->query($sql2);
                                            if ($result2->num_rows <= 0) {
                                                ?>
                                                Rs. <label for="admissionfee" id="admissionfee"><?= $row['Amount'] ?></label>
                                            <?php } else {
                                                ?>
                                                Rs. <label for="admissionfee" id="admissionfee">0.00</label>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="totalfee">Total Fee</label>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT Classfee FROM classdetails WHERE GradeId=$gradeId AND SubjectId=$subjectId AND MediumId=$mediumId";
                                        $result = $db->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            $addfeeid = 0;
                                            $addFee = 0;
                                            $classFees = $row['Classfee'];
                                            $sql2 = "SELECT *,Amount AS AMOUNT, Id AS ID FROM addmissions WHERE Year = YEAR(CURDATE())";
                                            $result2 = $db->query($sql2);
                                            while ($row = $result2->fetch_assoc()) {
                                                $studentID = $_SESSION['STUDENTID'];
                                                $sql3 = "SELECT * FROM registerstudents WHERE StudentId = $studentID";
                                                $result3 = $db->query($sql3);
                                                if ($result3->num_rows <= 0) {
                                                   $addfeeid = $row['ID'];
                                                   $addFee = $row['AMOUNT'];
                                                    
                                                    $tot = $classFees + $addFee;
                                                    ?>
                                                    <input type="text" name="totalfee" class="form-control fs-5" id="totalfee" value="<?php echo $tot; ?>" readonly>
                                                    <input type="hidden" name="classFees" class="form-control fs-5" id="classFees" value="<?php echo $classFees; ?>" readonly>
                                                    <input type="hidden" name="addFee" class="form-control fs-5" id="addFee" value="<?php echo $addFee; ?>" readonly>

                                                    <?php
                                                } else {
                                                    $tot = $classFees + 0;
                                                    ?>

                                                    <input type="text" name="totalfee" class="form-control fs-5" id="totalfee" value="<?php echo $tot; ?>" readonly>
                                                    <input type="hidden" name="classFees" class="form-control fs-5" id="classFees" value="<?php echo $classFees; ?>" readonly>
                                                    <input type="hidden" name="addFee" class="form-control fs-5" id="addFee" value="<?php echo $addFee; ?>" readonly>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <!--<label for="totalfee" id="totalfee" name="totalfee">Total Fee</label>-->
<!--                                        <input type="text" name="totalfee" class="form-control fs-5" id="totalfee" value="" readonly>-->
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="button" id="payButton">Pay</button>
                                    </div>
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
                                            <input type="hidden" name="classFees" class="form-control fs-5" id="classFees" value="<?php echo $classFees; ?>" readonly>
                                            <input type="hidden" name="addFee" class="form-control fs-5" id="addFee" value="<?php echo $addFee; ?>" readonly>
                                             <input type="hidden" name="addfeeid" class="form-control fs-5" id="addfeeid" value="<?php echo $addfeeid; ?>" readonly>
                                            <button type="submit">Submit</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div><!-- End Contact Form -->

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

                </div>
            </div>

        </div>

    </section><!-- /Contact Section -->

</main>
<script>
//    // Get the label elements
//    var admissionFeeLabel = document.getElementById("admissionfee");
//    var classfeeLabel = document.getElementById("classfee");
//    var totalFeeLabel = document.getElementById('totalfee');
//
//    // Set the value of the admission fee label to the text of the total fee label
//    var total = parseInt(classfeeLabel.textContent) + parseInt(admissionFeeLabel.textContent);
////    total = total.toFixed(2);
////    totalFeeLabel.value = "Rs. " + total;

    // Add an event listener to the button to show the div when clicked
    document.getElementById("payButton").addEventListener("click", function () {
        var paymentTag = document.getElementById("paymenTag");
        paymentTag.classList.remove("d-none");
        paymentTag.classList.add("d-flex"); // or d-block, if flex is not suitable
    });
</script>
<?php
ob_end_flush();
include 'footer.php';
?>
