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
            <h2>Register class</h2>

        </div><!-- End Section Title -->

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="row justify-content-center">

                    <div class="col-lg-7">
                        <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                extract($_POST);
                               
                                if (empty($message)) {
                                    
                                    $db = dbConn();
                                    $sql = "INSERT INTO `users`(`UserName`, `Password`,`UserType`) VALUES ('$user_name','$pw','Students')";
                                    $db->query($sql);

                                        }
                                    }
                                    ?>



                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                                <div class="row gy-4">

                                    <div class="col-md-12">
                                        <label for="first_name">Class Name</label>
                                        <input type="text" name="classname" class="form-control" id="classname" value="<?= @$first_name ?>" placeholder="classname" readonly>
                                        
                                    </div>

                                    <div class="col-md-6">
                                        <label for="classfee">Class Fee</label>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="classfee" id="classfee" placeholder="1000.00" required>
                                        
                                    </div>

                                    <div class="col-md-6">
                                        <label for="addmission">Admission Fee</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="addmission" id="addmission" placeholder="1000.00" required>
                                        

                                    </div>
                                    <div class="col-md-6">
                                        <label for="total">Total Amount</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="total" id="total" placeholder="1000.00" required>
                                        
                                    </div>
                                 
                                    <div class="col-md-12 text-center">
                                   
                                        <button type="submit">Pay</button>
                                    </div>
                                </div>
                      
                        </form>
                    </div><!-- End Contact Form -->

                </div>
            </div>

        </div>

    </section><!-- /Contact Section -->

</main>
<?php
ob_end_flush();
include 'footer.php';
?>
