<?php
include 'header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/IMS/function.php';
?>
<main id="main">
    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact">
        <div class="container " data-aos="fade-up">

            <div class="section-title">
                <h2>Login</h2>

            </div>

            <div class="row justify-content-center">

                <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch " data-aos="fade-up" data-aos-delay="200">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        extract($_POST);
                        $db = dbConn();
                        $sql = "SELECT * FROM users WHERE UserName='$username'";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            if (password_verify($password, $row['Password'])) {
                                echo 'Password is valid!';
                            } else {
                                echo 'Invalid password.';
                            }
                        }
                    }
                    ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form bg-info" novalidate>

                        <div class="form-group mt-3">
                            <label for="name">User Name</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Subject" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Subject" required>
                        </div>

                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Login</button></div>
                    </form>
                </div>

            </div>

        </div>

    </section><!-- End Contact Us Section -->
</main>
<?php
include 'footer.php';
?>