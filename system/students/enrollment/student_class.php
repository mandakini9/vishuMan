<?php
ob_start();
include_once '../../init.php';

extract($_GET);

$link = "Registered Students";
$breadcrumb_item = "student";
$breadcrumb_item_active = "Manage";
?> 
<div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="col-lg-12 mt-5 mt-lg-0 shadow p-3 mb-5 bg-body rounded" data-aos="fade-up" data-aos-delay="200">

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                                <div class="row gy-4">


                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM  subjects";
                                        $result = $db->query($sql);
                                        ?>
                                        <label for="subject">Subject</label>
                                        <select name="subject" id="subject" onchange="loadTimeTable()" class="form-control form-select" aria-label="Large select example">
                                            <option value="none" >--</option>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?= $row['Id'] ?>" <?= @$subject == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM  medium";
                                        $result = $db->query($sql);
                                        ?>
                                        <label for="classmedium">Class Medium</label>
                                        <select name="classmedium" id="classmedium" onchange="loadTimeTable()" class=" form-control form-select" aria-label="Large select example">
                                            <option value="none" >--</option>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?= $row['Id'] ?>" data-name="<?= $row['Name'] ?>" <?= @$classmedium == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                                <?php
                                            }
                                            ?> 
                                        </select>
                                    </div>
                                    <input type="hidden" id="gradeId" name="gradeId" value="<?= $gradeId; ?>">
                                    <input type="hidden" id="studentId" name="studentId" value="<?= $studentId; ?>">
                                    <div class="col-md-12 mt-3" id="ttable" style="display: block;">
                                        <div id="tabledata">
                                            
                                        </div>
                                    </div>



                                </div>
                        </div>
                    </div>
                    </form>
                </div><!-- End Contact Form -->

</div>

<?php
$content = ob_get_clean();
include '../../layouts.php';
?>
<script>
    function loadTimeTable(tabledata) {
        var subjectId = $('#subject').val();
        var mediumId = $('#classmedium').val();
        var gradeId = $('#gradeId').val();
        var studentId = $('#studentId').val();
        var tableDiv = document.getElementById('ttable');

        if (subjectId && mediumId) {

            $.ajax({
                url: 'get_timetable.php?gradeId=' + gradeId + '&subjectId='+ subjectId + '&mediumId=' + mediumId +'&studentId='+studentId+'&seltname='+tabledata,
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
