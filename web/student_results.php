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
            <h2>Results</h2>

        </div><!-- End Section Title -->

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="row justify-content-center">

                    <div class="col-lg-7">
                        <div class="col-lg-12 mt-5 mt-lg-0 shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                                <div class="row gy-4">


                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();
                                        $stId = $_SESSION['STUDENTID'];
                                        $sql_1 = "SELECT * FROM students WHERE Id='$stId'";
                                        $result_1 = $db->query($sql_1);
                                        $row_1 = $result_1->fetch_assoc();
                                        
                                        
                                        $sregno=$row_1['SRegNo'];
                                        
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
                                    <div class="col-md-6">
                                        <label for="examname">Exam Name</label>
                                        <select name="examname" class="form-control" id="examname"  aria-label="Large select example">
                                            <option value="">---</option>
                                        </select>
                                    </div>

                                    <input type="hidden" id="gradeId" name="gradeId" value="<?= $gradeId; ?>">
                                    <input type="hidden" id="stId" name="stId" value="<?= $stId; ?>">
                                    <input type="hidden" id="sregno" name="sregno" value="<?= $sregno; ?>">
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
    $(document).ready(function () {
        // Trigger when class is selected
        $('#classname').change(function () {
            var classId = $(this).val();  // Get selected class ID

            if (classId !== "") {
                // Make an AJAX request to fetch exams based on selected class
                $.ajax({
                    url: 'fetch_exams.php', // PHP script to handle the request
                    method: 'GET',
                    data: {classId: classId},
                    success: function (response) {
                        $('#examname').html(response);  // Update exam dropdown
                    }
                });
            } else {
                $('#examname').html('<option value="">---</option>');  // Reset if no class selected
            }
        });
    });
</script>
<script>
   
    function loadTimeTable(tabledata) {
        var classname = $('#classname').val();
//        var examname = $('#examname').val();
//        var sregno = $('#sregno').val();
        var tableDiv = document.getElementById('ttable');

        if (classname) {

            $.ajax({
                url: 'get_examresults.php?classname=' + classname + '&examname=' + <?= @$examname ?> + '&sregno=' + <?= @$sregno ?>,
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
