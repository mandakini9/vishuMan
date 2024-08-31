<?php
include '../init.php';
extract($_GET);
$db = dbConn();

$sql = "SELECT s.Id as Id, 
               s.SRegNo as SRegNo, 
               s.FirstName as FirstName, 
               s.LastName as LastName, 
               s.MobileNo, 
               r.ClassId, 
               g.Name as GradeId, 
               g.Id as gId, 
               GROUP_CONCAT(DISTINCT a.ClassName ORDER BY a.ClassName ASC SEPARATOR ', ') AS ClassName 
        FROM students s 
        INNER JOIN grades g ON g.Id = s.GradeId 
        LEFT JOIN registerstudents r ON r.StudentId = s.Id 
        LEFT JOIN approvalpayments a ON a.StudentId = s.Id 
        WHERE s.status = 1 AND r.ClassId = '$classId' 
        GROUP BY s.Id"; // Group by s.Id for a unique student

$result = $db->query($sql);

if (!$result) {
    die("Error executing query: " . $db->error); // Add this to catch SQL errors
}
?>
<table class="table table-hover text-nowrap">
    <thead>
        <tr>
            <th>ID</th>
            <th>SRegNo</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Marks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['Id']) ?></td>
                    <td><?= htmlspecialchars($row['SRegNo']) ?></td>
                    <td><?= htmlspecialchars($row['FirstName']) ?></td>
                    <td><?= htmlspecialchars($row['LastName']) ?></td>
                    <td>
                        <input type="hidden" name="sregno[]" value="<?= htmlspecialchars($row['SRegNo']) ?>"/>
                        <input type="hidden" name="fname[]" value="<?= htmlspecialchars($row['FirstName']) ?>"/>
                        <input type="hidden" name="lname[]" value="<?= htmlspecialchars($row['LastName']) ?>"/>
                        <input type="text" name="student_result[]" />
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
