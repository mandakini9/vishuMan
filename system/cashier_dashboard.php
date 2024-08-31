<?php
ob_start();
include_once 'init.php';
$link = "Dashboard";
$breadcrumb_item = "Home";
$breadcrumb_item_active = "Dashboard";
?>     
<!-- Small boxes (Stat box) -->
<div class="row d-flex justify-content-around">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <?php
                $db = dbConn();
                $sql = "SELECT COUNT(*) AS STCOUNT FROM registerstudents";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                ?>
                <h3><?= $row['STCOUNT'] ?></h3>

                <p>Register Students</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="students/registerstudents.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <?php
                $db = dbConn();
                $sql = "SELECT COUNT(*) AS CDCOUNT FROM classdetails";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                ?>
                <h3><?= $row['CDCOUNT'] ?></h3>

                <p>Register Classes</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
           
            <a href="class/class_manage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <?php
                $db = dbConn();
                $sql = "SELECT COUNT(*) AS TCOUNT FROM teachers t INNER JOIN users u ON u.UserId =t.UserId WHERE u.Status=1 ";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                ?>
                <h3><?= $row['TCOUNT'] ?></h3>

                <p> Register Teachers</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            
            <a href="teachers/manage.php"" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
   
    <!-- ./col -->
</div>
<!-- /.row -->
<?php
$content = ob_get_clean();
include 'layouts.php';
?>
    

