<?php
ob_start();
include_once '../init.php';

$link = "Class Hall Management";
$breadcrumb_item = "class";
$breadcrumb_item_active = "Hall Manage";
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $hallname = dataClean($hallname);
    $capacity = dataClean($capacity);
    $db = dbConn();
    $sql = "INSERT INTO halls(`HallName`,`StudentCapacity`) VALUES ('$hallname','$capacity')";
    $db->query($sql);
    
    header("Location:classhall_manage.php");
    
    echo $hallname;
    echo $hallname;
}

?>




<div class="row">
       <div class="col-5">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Hall</h3>
            </div>              
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="hallname">Hall Name</label>
                            <input type="text" name="hallname" class="form-control" id="hallname" value="<?= @$hallname ?>" placeholder="Hall A" required>

                        </div>

                        <div class="col-md-6">
                            <label for="capacity">Student Capacity </label>
                            <input type="number" name="capacity" class="form-control" id="capacity" value="<?= @$capacity ?>" placeholder="100" required>

                        </div>

                       

                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="clear" class="btn btn-info">Clear</button>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </div>
    
    <div class="col-7">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Class Hall Details</h3>

<!--                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>-->
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn();
                $sql="SELECT * FROM halls h ";
                $result=$db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hall Name </th>
                            <th>Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows>0){
                            while ($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $row['Id'] ?></td>
                            <td><?= $row['HallName'] ?></td>
                            <td><?= $row['StudentCapacity'] ?></td>
                            
                            <td><a href="<?= SYS_URL ?>class/classhalledit.php?hallid=<?= $row['Id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></td>
                            <td><a href="<?= SYS_URL ?>class/delete.php?hallid=<?= $row['Id'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i> Delete</a></td>
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
