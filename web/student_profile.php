<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
?>

<main class="main">

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Student Profile</h2>

        </div><!-- End Section Title -->

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="row justify-content-center">

                    <div class="col-lg-7">
                        <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                extract($_POST);
                                $first_name = dataClean($first_name);
                                $last_name = dataClean($last_name);
                                $email = dataClean($email);

                                $message = array();
                                //Required validation-----------------------------------------------
                                if (empty($first_name)) {
                                    $message['first_name'] = "The first name should not be blank...!";
                                }
                                if (empty($last_name)) {
                                    $message['last_name'] = "The last name should not be blank...!";
                                }
                                if (!isset($gender)) {
                                    $message['gender'] = "Gender is required";
                                }
                                if (empty($user_name)) {
                                    $message['user_name'] = "User Name is required";
                                }
                                if (empty($password)) {
                                    $message['password'] = "Password is required";
                                }

                                //Advance validation------------------------------------------------
                                if (ctype_alpha(str_replace(' ', '', $first_name)) === false) {
                                    $message['first_name'] = "Only letters and white space allowed";
                                }
                                if (ctype_alpha(str_replace(' ', '', $last_name)) === false) {
                                    $message['last_name'] = "Only letters and white space allowed";
                                }
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $message['email'] = "Invalid Email Address...!";
                                } else {
                                    $db = dbConn();
                                    $sql = "SELECT * FROM teachers WHERE Email='$email'";
                                    $result = $db->query($sql);

                                    if ($result->num_rows > 0) {
                                        $message['email'] = "This Email address already exsist...!";
                                    }
                                }

                                if (!empty($user_name)) {
                                    $db = dbConn();
                                    $sql = "SELECT * FROM users WHERE UserName='$user_name'";
                                    $result = $db->query($sql);

                                    if ($result->num_rows > 0) {
                                        $message['user_name'] = "This User Name already exsist...!";
                                    }
                                }

                                if (!empty($password)) {
                                    if (strlen($password) < 8) {
                                        $message['password'] = "The password should be 8 characters more";
                                    }
                                }

                                if (empty($message)) {
                                    //Use bcrypt hasing algorithem
                                    $pw = password_hash($password, PASSWORD_DEFAULT);
                                    $db = dbConn();
                                    $sql = "INSERT INTO `users`(`UserName`, `Password`,`UserType`) VALUES ('$user_name','$pw','Students')";
                                    $db->query($sql);

                                    $user_id = $db->insert_id;

                                    $reg_number = date('Y') . date('m') . date('d') . $user_id;
                                    $_SESSION['RNO'] = $reg_number;
                                    $sql_guardians = "SELECT * FROM `guardians` WHERE NIC = '$NIC'";
                                    $result_guardians = $db->query($sql_guardians);
                                    if ($result_guardians->num_rows > 0) {
                                        $sql1 = "INSERT INTO `guardians`(`NIC`, `GTypeId`, `FirstName`, `LastName`, `TelNo`, `MobileNo`) "
                                                . "VALUES ('$NIC','$Gtype','$fname','$lname','$telno','$mno');";
                                        $db->query($sql1);
                                    }

                                    $sql = "INSERT INTO students (`FirstName`, `LastName`, `Email`, `Gender`, `GradeId`, `SchoolName`, `AddressLine1`, `AddressLine2`, `MobileNo`, `SRegNo`, `UserId`,`status`) "
                                            . "VALUES ('$first_name','$last_name','$email','$gender','$grade','$schoolname','$addressline1','$addressline2','$mobile_no','$reg_number','$user_id', '2')";
                                    $db->query($sql);

                                    $msg = "<h1>SUCCESS</h1>";
                                    $msg .= "<h2>Congratulations</h2>";
                                    $msg .= "<p>Your account has been successfully created</p>";
                                    $msg .= "<a href='http://localhost/IMS/verify.php'>Click here to verifiy your account</a>";
                                    sendEmail($email, $first_name, "Account Verification", $msg);

                                    header("Location:register_success.php");
                                }
                            }
                            ?>



                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                                <div class="row gy-4">

                                    <div class="col-md-12">
                                        <label for="" class="fw-bolder">Guardian Details</label>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="NIC">NIC</label>
                                        <input type="text" name="NIC" class="form-control" id="NIC" value="<?= @$NIC ?>" placeholder="965033602V/1996503303602" required>

                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM  guardiantypes";
                                        $result = $db->query($sql);
                                        ?>
                                        <label for="Gtype">Guardian Type</label>
                                        <select name="Gtype" id="Gtype" class="form-select" aria-label="Large select example">
                                            <option value="" >--</option>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                    </div>


                                    <div class="col-md-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="fname" class="form-control" id="fname" value="<?= @$fname ?>" placeholder="First Name" required>
                                        <span class="text-danger"><?= @$message['fname'] ?></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" required>
                                        <span class="text-danger"><?= @$message['lname'] ?></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="telno">Tel. No.(Home)</label>
                                        <input type="text" class="form-control" name="telno" id="telno" placeholder="Tel. No." required>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="telno">Mobile No.</label>
                                        <input type="text" class="form-control" name="mno" id="mno" placeholder="Mobile No" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="" class="fw-bolder">Student Details</label>

                                    </div>

                                    <div class="col-md-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" class="form-control" id="first_name" value="<?= @$first_name ?>" placeholder="First Name" required>
                                        <span class="text-danger"><?= @$message['first_name'] ?></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>
                                        <span class="text-danger"><?= @$message['last_name'] ?></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
                                        <span class="text-danger"><?= @$message['email'] ?></span>

                                    </div>

                                    <div class="col-md-6">
                                        <label>Select Gender</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="male"  value="male">
                                            <label class="form-check-label" for="male">
                                                Male
                                            </label>

                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" >
                                            <label class="form-check-label" for="female">
                                                Female
                                            </label>
                                        </div>
                                        <div class="text-danger mt-4"><?= @$message['gender'] ?></div>
                                    </div> 



                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM  grades";
                                        $result = $db->query($sql);
                                        ?>
                                        <label for="grade">Grade</label>
                                        <select name="grade" id="grade" class="form-select" aria-label="Large select example">
                                            <option value="" >--</option>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="schoolname">School Name</label>
                                        <input type="text" class="form-control" name="schoolname" id="schoolname" placeholder="school Name" required>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="addressline1">Address line 1</label>
                                        <input type="text" class="form-control" name="addressline1" id="addressline1" placeholder="No 248" required>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="addressline2">Address Line 2</label>
                                        <input type="text" class="form-control" name="addressline2" id="addressline2" placeholder="Namal Road" required>

                                    </div>
                                    <!--                                    <div class="col-md-6">
                                                                            <label for="addressline3">Address Line 3</label>
                                                                            <input type="text" class="form-control" name="addressline3" id="addressline3" placeholder="Colombo 10" required>
                                    
                                                                        </div>
                                    
                                                                        <div class="col-md-6">
                                                                            <label for="telno">Tel. No.(Home)</label>
                                                                            <input type="text" class="form-control" name="telno" id="telno" placeholder="Tel. No." required>
                                    
                                                                        </div>-->

                                    <div class="col-md-6">
                                        <label for="telno">Mobile No.</label>
                                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="user_name">User Name</label>
                                        <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Username" required>
                                        <span class="text-danger"><?= @$message['user_name'] ?></span>

                                    </div>

                                    <div class="col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                        <span class="text-danger"><?= @$message['password'] ?></span>

                                    </div>


                                    <div class="col-md-6">
                                        <label for="repassword">Retype Password</label>
                                        <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Retype Password" required>


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
                    </div><!-- End Contact Form -->

                </div>
            </div>
        </div>
    </section><!-- /Contact Section -->
</main>
<script>
    document.getElementById('NIC').addEventListener('blur', function () {
        let NIC = this.value;

        // Send an AJAX request to the backend
        fetch('get_guardian_details.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({NIC: NIC})
        })
                .then(response => response.json())
                .then(data => {
                    // Populate the fields if data is found
                    if (data.success) {
                        document.getElementById('fname').value = data.FirstName;
                        document.getElementById('lname').value = data.LastName;
                        document.getElementById('Gtype').value = data.GTypeId;
                        document.getElementById('telno').value = data.TelNo;
                        document.getElementById('mno').value = data.MobileNo;
                        // Populate other fields as needed
                    } else {
                        alert('No record found!');
                    }
                })
                .catch(error => console.error('Error:', error));
    });

</script>
<?php
ob_end_flush();
include 'footer.php';
?>
