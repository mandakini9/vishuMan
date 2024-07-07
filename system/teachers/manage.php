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

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn();
                $sql="SELECT * FROM teachers";
                $result=$db->query($sql);
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
                        if($result->num_rows>0){
                            while ($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $row['TeacherId'] ?></td>
                            <td><?= $row['FirstName'] ?></td>
                            <td><?= $row['LastName'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['Gender'] ?></td>
                            <td><?= $row['MobileNo'] ?></td>
                            <td><a href="<?= SYS_URL ?>users/view.php?userid=<?= $row['UserId'] ?>" class="btn btn-primary" onclick=""><i class="fas fa-eye"></i> View</a></td>
                            <td><a href="<?= SYS_URL ?>teachers/approve.php?userid=<?= $row['UserId'] ?>" class="btn btn-success"><i class="fas fa-thumbs-up"></i> Approve</a></td>
                            <td><a href="<?= SYS_URL ?>users/delete.php?userid=<?= $row['UserId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-times"></i>  Reject</a></td>
                            
                        </tr>
                        </tr>
                        
                        <?php 
                            }
                            } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>
