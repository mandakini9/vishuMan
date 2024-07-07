<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';

?>

<main class="main">

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Teacher Login</h2>

        </div><!-- End Section Title -->
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            extract($_POST);

            $username = dataClean($username);

            $message = array();

            if (empty($username)) {
                $message['username'] = "User Name should not be empty...!";
            }
            if (empty($password)) {
                $message['password'] = "Password should not be empty...!";
            }

            if (empty($message)) {
                $db = dbConn();
                $sql = "SELECT * FROM users u INNER JOIN teachers t ON t.UserId=u.UserId WHERE u.UserName='$username'&& u.status=1";
                $result = $db->query($sql);

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    if (password_verify($password, $row['Password'])) {
                        $_SESSION['USERID'] = $row['UserId'];
                        $_SESSION['FIRSTNAME'] = $row['FirstName'];
                        header("Location:dashboard.php");
                    } else {
                        $message['password'] = "Invalid User Name or Password...!";
                    }
                } else {
                    $message['password'] = "Your Account Not Approve Yet...!";
                }
            }
        }
        ?>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="row justify-content-center">

                    <div class="col-lg-7">
                        <div class="col-lg-12 mt-5 mt-lg-0 align-items-stretch shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                                <div class="row gy-4">


                                    <div class="col-md-12">
                                        <label for="user_name">User Name</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                        <span class="text-danger"><?= @$message['username'] ?></span>

                                    </div>

                                    <div class="col-md-12">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                        <span class="text-danger"><?= @$message['password'] ?></span>

                                    </div>




                                    <div class="col-md-12 text-center">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>

                                        <button type="submit">Login</button>
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
