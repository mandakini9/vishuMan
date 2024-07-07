<?php
ob_start();
include_once '../init.php';

$link = "Classhall Management";
$breadcrumb_item = "class";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $DesignationId = dataClean($DesignationId);
    $DepartmentId = dataClean($DepartmentId);
    $AppDate = dataClean($AppDate);
    $UserName = dataClean($UserName);
    
    $message = array();
    if (empty($FirstName)) {
        $message['FirstName'] = "The First Name should not be blank...!";
    }
    if (empty($LastName)) {
        $message['LastName'] = "The Last Name should not be blank...!";
    }
    if (empty($DesignationId)) {
        $message['DesignationId'] = "The Designation should not be blank...!";
    }
    if (empty($DepartmentId)) {
        $message['DepartmentId'] = "The Department should not be blank...!";
    }
    if (empty($AppDate)) {
        $message['AppDate'] = "The App. Date should not be blank...!";
    }
    if (empty($UserName)) {
        $message['UserName'] = "The UserName should not be blank...!";
    }
    if (empty($Password)) {
        $message['Password'] = "The Password should not be blank...!";
    }
    if (!empty($UserName)) {
        $db = dbConn();
        $sql = "SELECT * FROM users WHERE UserName='$UserName'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['UserName'] = "This User Name already exsist...!";
        }
    }
    if (!empty($Password)) {
        $uppercase = preg_match('@[A-Z]@', $Password);
        $lowercase = preg_match('@[a-z]@', $Password);
        $number = preg_match('@[0-9]@', $Password);
        $specialChars = preg_match('@[^\w]@', $Password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($Password) < 8) {
            $message['Password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
        }
    }
    if (empty($message)) {
        //Use bcrypt hasing algorithem
        $pw = password_hash($Password, PASSWORD_DEFAULT);
        $db = dbConn();
        $sql = "INSERT INTO users(FirstName,LastName,UserName,Password,UserType,Status) VALUES ('$FirstName','$LastName','$UserName','$pw','employee','1')";
        $db->query($sql);
        $UserId = $db->insert_id;

        $sql = "INSERT INTO employee(AppDate,DesignationId,DepartmentId,UserId) VALUES ('$AppDate','$DesignationId','$DepartmentId','$UserId')";
        $db->query($sql);

        header("Location:manage.php");
    }


    
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Hall</h3>
            </div>              
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="hallname">Hall Name</label>
                            <input type="text" name="hallname" class="form-control" id="hallname" value="" placeholder="hallname" required>

                        </div>

                        <div class="col-md-6">
                            <label for="capacity">Student Capacity </label>
                            <input type="number" name="capacity" class="form-control" id="capacity" value="" placeholder="capacity" required>

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
   
</div>


<?php
$content = ob_get_clean();
include '../layouts.php';
?>