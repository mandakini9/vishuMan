<?php
ob_start();
include_once '../init.php';

$link = "Teacher Management";
$breadcrumb_item = "Teacher";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Teacher Details</h3>

                
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db = dbConn();
//                $sql="SELECT * FROM teachers";
                $sql = "SELECT t.TeacherId, t.FirstName AS FName, t.LastName AS LastName, Email,Gender, "
                        . "MobileNo, Status, u.UserId,t.Experience,q.Name AS QNAME,"
                        . "GROUP_CONCAT(DISTINCT g.Name ORDER BY g.Name ASC SEPARATOR ', ') AS Grades,"
                        . "m.Name as medium, s.Name AS Subject FROM "
                        . "teachers t INNER JOIN users u ON t.UserId = u.UserId "
                        . "LEFT JOIN teachers_grades f ON f.TeacherId=t.TeacherId "
                        . "LEFT JOIN subjects s ON s.Id=f.SubjectId "
                        . "LEFT JOIN grades g ON g.Id=f.GradeId "
                        . "LEFT JOIN qualification q ON q.Id=t.Qualification "
                        . "LEFT JOIN medium m ON m.Id=f.MediumId GROUP BY t.TeacherId";
                $result = $db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Mobile No</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['TeacherId'] ?></td>
                                    <td><?= $row['FName'] ?></td>
                                    <td><?= $row['LastName'] ?></td>
                                    <td><?= $row['Email'] ?></td>
                                    <td><?= $row['Gender'] ?></td>
                                    <td><?= $row['MobileNo'] ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="toggleContainer('<?= $row['TeacherId'] ?>', '<?= $row['FName'] ?>', '<?= $row['LastName'] ?>', '<?= $row['Email'] ?>', '<?= $row['Gender'] ?>', '<?= $row['MobileNo'] ?>', '<?= $row['Subject'] ?>', '<?= $row['medium'] ?>', '<?= $row['Grades'] ?>','<?= $row['QNAME'] ?>','<?= $row['Experience'] ?> Years')" data-toggle="modal" data-target="#userModal">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                    <?php if ($row['Status'] == '2') { ?>
                                        <td>
                                            <a href="<?= SYS_URL ?>teachers/approve.php?userid=<?= $row['UserId'] ?>" class="btn btn-success">
                                                <i class="fas fa-thumbs-up"></i> Approve
                                            </a>
                                        </td>
                                    <?php } elseif ($row['Status'] == '3') { ?>
                                        <td>
                                            <button class="btn btn-success" disabled>
                                                <i class="fas fa-thumbs-up"></i> Approve
                                            </button>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <button class="btn btn-success" disabled>
                                                <i class="fas fa-thumbs-up"></i> Approved
                                            </button>
                                        </td>
                                    <?php } ?>

                                    <?php if ($row['Status'] <= '2') { ?>
                                        <td>
                                            <a href="<?= SYS_URL ?>teachers/reject.php?userid=<?= $row['UserId'] ?>" class="btn btn-danger"  id="reject-button">
                                                <i class="fas fa-times"></i>  Reject
                                            </a>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <button class="btn btn-danger" disabled>
                                                <i class="fas fa-times"></i> Rejected
                                            </button>
                                        </td>
                                    <?php } ?>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Teacher Details</h5>
            </div>
            <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-bordered text-nowrap">

                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td><label style="font-weight: 500 !important" id="teacher_id"></label></td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td><label style="font-weight: 500 !important" id="teacher_fname"></label></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td><label style="font-weight: 500 !important" id="teacher_lname"></label></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><label style="font-weight: 500 !important" id="teacher_email"></label></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td><label style="font-weight: 500 !important" id="teacher_gender"></label></td>
                            </tr>

                            <tr>
                                <td>Mobile No</td>
                                <td><label style="font-weight: 500 !important" id="teacher_mb"></label></td>
                            </tr> 

                            <tr>
                                <td>Subject</td>
                                <td><label style="font-weight: 500 !important" id="teacher_sub"></label></td>
                            </tr> 
                            <tr>
                                <td>Medium</td>
                                <td><label style="font-weight: 500 !important" id="teacher_med"></label></td>
                            </tr> 
                            <tr>
                                <td>Grades</td>
                                <td><label style="font-weight: 500 !important" id="teacher_gd"></label></td>
                            </tr> 
                            <tr>
                                <td>Qualifications</td>
                                <td><label style="font-weight: 500 !important" id="teacher_qf"></label></td>
                            </tr> 
                            <tr>
                                <td>Experience</td>
                                <td><label style="font-weight: 500 !important" id="teacher_ex"></label></td>
                            </tr> 
                        </tbody>
                    </table>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<script>
//    function confirmDelete() {
//        return confirm("Are you sure you want to delete this record?");
//    }

    function toggleContainer(para1, para2, para3, para4, para5, para6, para7, para8, para9,para10,para11) {
        var container = document.getElementById('userModal');

//            alert(para1);
        var teacher_id = document.getElementById('teacher_id');
        var teacher_fname = document.getElementById('teacher_fname');
        var teacher_lname = document.getElementById('teacher_lname');
        var teacher_email = document.getElementById('teacher_email');
        var teacher_gender = document.getElementById('teacher_gender');
        var teacher_mb = document.getElementById('teacher_mb');
        var teacher_sub = document.getElementById('teacher_sub');
        var teacher_med = document.getElementById('teacher_med');
        var teacher_gd = document.getElementById('teacher_gd');
        var teacher_qf = document.getElementById('teacher_qf');
        var teacher_ex = document.getElementById('teacher_ex');

        teacher_id.textContent = para1;
        teacher_fname.textContent = para2;
        teacher_lname.textContent = para3;
        teacher_email.textContent = para4;
        teacher_gender.textContent = para5;
        teacher_mb.textContent = para6;
        teacher_sub.textContent = para7;
        teacher_med.textContent = para8;
        teacher_gd.textContent = para9;
        teacher_qf.textContent = para10;
        teacher_ex.textContent = para11;

        container.style.display = 'block';
    }
</script>
