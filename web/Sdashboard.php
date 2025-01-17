<?php
session_start();
if (!isset($_SESSION['USERID'])) {
    header("Location:student_login.php");
}

$studnetid = $_SESSION['STUDENTID'];

extract($_GET);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Vishu Institute</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Main CSS File -->
        <link href="assets/css/main.css" rel="stylesheet">
        <link href="assets/css/mystyle.css" rel="stylesheet">
        <script src="assets/js/sweetalert2@11.js" type="text/javascript"></script>

    </head>
    <body class="index-page">

        <header id="header" class="header d-flex align-items-center sticky-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">

                <a href="index.html" class="logo d-flex align-items-center me-auto">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="assets/img/logo.png" alt=""> -->
                    <h1 class="sitename">Vishu</h1>
                </a>

                <nav id="navmenu" class="navmenu">

                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                <a class="btn-getstarted scrollto register-btn" href="register.php">Welcome, <?= $_SESSION['FIRSTNAME'] ?></a>
                <a class="btn-getstarted scrollto login-btn" href="logout.php">Logout</a>



            </div>
        </header>

        <main class="main">



            <section id="services" class="services section" >

                <div class="container section-title" data-aos="fade-up">
                    <h2>Dashboard</h2>

                </div> 

                <div class="container">

                    <div class="row justify-content-center gy-4">

<!--                        <div class="col-xl-4 col-md-6 d-flex rounded-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-md-12 service-item position-relative text-center" style="background-image: url('assets/img/subjects/.jpg');
                                 object-fit: cover;
                                 background-repeat: no-repeat;">
                                <h4><a href="student_profile.php" class="stretched-link">Profile</a></h4>
                            </div>
                        </div> End Service Item -->
                        
                        <div class="col-xl-4 col-md-6 d-flex rounded-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-md-12 service-item position-relative text-center" style="background-image: url('assets/img/team/class.jpg');
                                 object-fit: cover;">
                                <h4><a href="student_class.php?gradeId=<?= $gradeId; ?>" class="stretched-link">Class</a></h4>
                            </div>
                        </div><!-- End Service Item -->
                        
                        <div class="col-xl-4 col-md-6 d-flex rounded-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-md-12 service-item position-relative text-center" style="background-image: url('assets/img/team/payment.jpg');
                                 object-fit: cover;
                                 background-repeat: no-repeat;">
                                <h4><a href="student_class_payment.php?gradeId=<?= $gradeId; ?>" class="stretched-link">Payment</a></h4>
                            </div>
                        </div><!-- End Service Item -->
                        
                        <div class="col-xl-4 col-md-6 d-flex rounded-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-md-12 service-item position-relative text-center" style="background-image: url('assets/img/team/exam.jpg');
                                 object-fit: cover;
                                 background-repeat: no-repeat;">
                                <h4><a href="student_exam.php?gradeId=<?= $gradeId ?>" class="stretched-link">Exam</a></h4>
                            </div>
                        </div><!-- End Service Item -->
                        
<!--                        <div class="col-xl-4 col-md-6 d-flex rounded-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-md-12 service-item position-relative text-center" style="background-image: url('assets/img/team/result.jpg');
                                 object-fit: cover;
                                 background-repeat: no-repeat;">
                                <h4><a href="student_results.php?gradeId=<?= $gradeId ?>" class="stretched-link">Result</a></h4>
                            </div>
                        </div> End Service Item 
                        
                        <div class="col-xl-4 col-md-6 d-flex rounded-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-md-12 service-item position-relative text-center" style="background-image: url('assets/img/team/attendance.jpg');
                                 object-fit: cover;
                                 background-repeat: no-repeat;">
                                <h4><a href="student_attendance.php?gradeId=<?= $gradeId ?>" class="stretched-link">Attendance</a></h4>
                            </div>
                        </div> End Service Item -->

                    </div>


                </div>
            </section> 


<!--            <section class="team section">

                Section Title 
                <div class="container section-title" data-aos="fade-up">
                    <h2>Dashboard</h2>
                </div> 
                End Section Title 

                <div class="container">

                    <div class="row gy-4">

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="assets/img/team/class.jpg" class="img-fluid" alt="">

                                </div>
                                <div class="member-info">
                                    <h4><a href="student_class.php?gradeId=<?= $gradeId; ?>" class="stretched-link">Class</a></h4>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="assets/img/team/payment.jpg" class="img-fluid" alt="">

                                </div>
                                <div class="member-info">
                                    <h4><a href="student_class_payment.php?gradeId=<?= $gradeId; ?>" class="stretched-link">Payment</a></h4>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">

                                </div>
                                <div class="member-info">
                                    <h4><a href="" class="stretched-link">Attendance</a></h4>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">

                                </div>
                                <div class="member-info">
                                    <h4><a href="" class="stretched-link">Exam</a></h4>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">

                                </div>
                                <div class="member-info">
                                    <h4><a href="" class="stretched-link">Results</a></h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">

                                </div>
                                <div class="member-info">
                                    <h4><a href="" class="stretched-link">Profile</a></h4>
                                </div>
                            </div>
                        </div>

                    </div></div>
            </section>-->





        </main>

        <?php
        include 'footer.php';
        ?>