<?php 
session_start();
include '../function.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VISHU INSTITUTE| Log in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
        
        <link href="assets/dist/css/mystyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>


<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">
            <!-- /.login-logo -->
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
                    $sql = "SELECT * FROM users u INNER JOIN teachers t ON t.UserId=u.UserId WHERE u.UserName='$username'";
                    $result = $db->query($sql);

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        
                        if (password_verify($password, $row['Password'])) {
                           $_SESSION['USERID'] = $row['UserId'];
                            $_SESSION['FIRSTNAME'] = $row['FirstName'];
                            $_SESSION['LASTNAME'] = $row['LastName'];
                            $_SESSION['TEACHERID'] = $row['TeacherId'];
                            header("Location:dashboard.php");
                        } else {
                            $message['password'] = "Invalid User Name or Password...!";
                        }
                    } else {
                        $message['password'] = "Invalid User Name or Password...!";
                    }
                }
            }
            ?>
            <div class="card o-hidden border-0 shadow-lg my-5 card-round">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center pt-lg-5">
                                    <h1 class="h3 heading-text mb-4">Welcome Back!</h1>
                                </div>
                                <div class="text-center pb-4">
                                    <span> Please enter Your username and password</span>
                                </div>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary btn-user btn-login px-5" type="submit">
                                            Login
                                        </button>
                                    </div>
                                </form>
                                <div class="text-danger"><?= @$message['username'] ?></div>
                                <div class="text-danger"><?= @$message['password'] ?></div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block image-background">
                            <div class="left-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>