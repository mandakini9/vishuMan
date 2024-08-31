<?php
ob_start();
include_once '../init.php';

$link = "Vishu Institute  Of Technoloy";
$breadcrumb_item = "Report";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cash payments Report</h3>

               
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn();
                $sql="SELECT ClassName, TotalFee ,PaidDate,PaymentType  FROM `approvalpayments`  WHERE PayMethod='cash'";
                $result=$db->query($sql);
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            
                            <th>Class Name</th>
                            <th>Class fee</th>
                            <th>Paid Date</th>
                            <th>Payment Type</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows>0){
                            while ($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $row['ClassName'] ?></td>
                            <td><?= $row['TotalFee'] ?></td>
                            <td><?= $row['PaidDate'] ?></td>
                            <td><?php if($row['PaymentType'] == '1'){ echo 'Admission Fee';} else { echo 'Class Fees';} ?></td>
                            
                           
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
     <a href="<?= SYS_URL ?>users/add.php" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> Print</a>
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
