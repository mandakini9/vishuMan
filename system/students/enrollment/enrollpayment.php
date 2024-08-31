<?php
ob_start();
include_once '../../init.php';

extract($_GET);

$link = "Registered Students";
$breadcrumb_item = "student";
$breadcrumb_item_active = "Manage";
?> 
<style>
    #payButton {
        color: #ffffff;
        background: #17a2b8;
        border: 0;
        padding: 10px 30px;
        transition: 0.4s;
        border-radius: 50px;
    }
</style>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                extract($_POST);

                if (empty($message)) {
                    $db = dbConn();
                    $sql_student = "SELECT SRegNo, cd.Id As ClassNo FROM students s "
                            . "INNER JOIN classdetails cd ON s.GradeId = cd.GradeId "
                            . "WHERE s.Id='$studentId' AND cd.ClassName = '$ClassName'";
                    $result_student = $db->query($sql_student);
                    $row_student = $result_student->fetch_assoc();
                    $sregno = $row_student['SRegNo'];
                    $classid = $row_student['ClassNo'];
                    if ($addfeeid != 0) {
                        $sql5 = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate` ,`PaymentType`,`status`) "
                                . "VALUES ('$studentId','$ClassName','$addFee','Cash',CURRENT_DATE,'1','1')";
                        $db->query($sql5);

                        $sql4 = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate` ,`PaymentType`,`status`) "
                                . "VALUES ('$studentId','$ClassName','$classFees','Cash',CURRENT_DATE,'2','1')";
                        $db->query($sql4);
                    }else{
                        $sql2 = "INSERT INTO `approvalpayments`( `StudentId`, `ClassName`, `TotalFee`, `PayMethod`, `PaidDate` ,`PaymentType`,`status`) "
                                        . "VALUES ('$studentId','$ClassName','$classFees','Cash',CURRENT_DATE,'2','1')";
                                        $db->query($sql2);
                    }
                    $sql3 = "UPDATE `students` SET `status`='1' WHERE Id = '$studentId'";
                    $db->query($sql3);
                    
                    $sql = "INSERT INTO registerstudents (`StudentId`, `SRegNo`, `ClassId`) "
                            . "VALUES ('$studentId','$sregno','$classid')";
                    $db->query($sql);
                    

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

                    header("Location:enrollsuccess.php");
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

                        $sql = "SELECT Amount FROM addmissions WHERE Year = YEAR(CURDATE())";

                        $result = $db->query($sql);
                        ?>
                        <label for="admissionfee">Admission  Fee</label>
                    </div>
                    <div class="col-md-6">
                        <?php
                        while ($row = $result->fetch_assoc()) {

                            $sql2 = "SELECT * FROM registerstudents WHERE StudentId = $studentId";
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

                    <div class="col-md-6 mt-3">
                        <?php
                        $db = dbConn();

                        $sql = "SELECT Classfee FROM classdetails WHERE GradeId=$gradeId AND SubjectId=$subjectId AND MediumId=$mediumId";

                        $result = $db->query($sql);
                        ?>
                        <label for="classfee">Class Fee</label>
                    </div>
                    <div class="col-md-6 mt-3">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            Rs. <label for="classfee" id="classfee"><?= $row['Classfee'] ?></label>
                            <?php
                        }
                        ?>

                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="totalfee">Total Fee</label>
                    </div>
                    <div class="col-md-6 mt-2">
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
                                $sql3 = "SELECT * FROM registerstudents WHERE StudentId = $studentId";
                                $result3 = $db->query($sql3);
                                if ($result3->num_rows <= 0) {
                                    $addfeeid = $row['ID'];
                                    $addFee = $row['AMOUNT'];
                                    $tot = $classFees + $addFee;
                                    ?>
                                    <input type="text" name="totalfee" class="form-control fs-5" id="totalfee" value="<?= $tot ?>" readonly>
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
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="pay_method">Payment Method</label>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="pay_method" style="font-weight: 400 !important;">Cash</label>
                        <input type="hidden" name="studentId" class="form-control fs-5" id="studentId" value="<?= $studentId ?>">
                    </div>

                    <div class="col-md-12 text-center mt-4">
                        <input type="hidden" name="classFees" class="form-control fs-5" id="classFees" value="<?php echo $classFees; ?>" readonly>
                        <input type="hidden" name="addFee" class="form-control fs-5" id="addFee" value="<?php echo $addFee; ?>" readonly>
                        <input type="hidden" name="addfeeid" class="form-control fs-5" id="addfeeid" value="<?php echo $addfeeid; ?>" readonly>
                        <button type="submit" id="payButton">Pay</button>
                    </div>
                </div>
            </form>
        </div>

    </div><!-- End Contact Form -->
</div><!-- End Contact Form -->

</div>

<?php
$content = ob_get_clean();
include '../../layouts.php';
?>

