<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';

extract($_GET);
?>

<main class="main">

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Exams</h2>

        </div><!-- End Section Title -->

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="row justify-content-center">

                    <div class="col-lg-7">
                        <div class="col-lg-12 mt-5 mt-lg-0 shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                                <div class="row gy-4">


                                    <div class="col-md-12">
                                        <?php
                                        $db = dbConn();
                                        $stId = $_SESSION['STUDENTID'];
                                        $sql = "SELECT d.Id AS ID, r.StudentId, r.SRegNo, s.FirstName, s.LastName, d.ClassName AS Class FROM registerstudents r "
                                                . "INNER JOIN classdetails d ON d.Id=r.ClassId  LEFT JOIN students s ON s.Id=r.StudentId WHERE s.Id='$stId'";
                                        $result = $db->query($sql);
                                        ?>
                                        <label for="classname">Class Name</label>
                                        <select name="classname" id="classname" onchange="loadTimeTable()" class="form-select" aria-label="Large select example">
                                            <option value="none" >--</option>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?= $row['ID'] ?>" <?= @$classname == $row['ID'] ? 'selected' : '' ?>><?= $row['Class'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <input type="hidden" id="gradeId" name="gradeId" value="<?= $gradeId; ?>">
                                    <div class="col-md-12" id="ttable" style="display: block;">
                                        <div id="tabledata">

                                        </div>
                                    </div>



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
<?php
ob_end_flush();
include 'footer.php';
?>
<script>
    function loadTimeTable(tabledata) {
        var classname = $('#classname').val();
        var tableDiv = document.getElementById('ttable');

        if (classname) {

            $.ajax({
                url: 'get_examtable.php?classname=' + classname + '&seltname=' + tabledata,
                type: 'GET',
                success: function (data) {
                    $("#tabledata").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }


    }

</script>
