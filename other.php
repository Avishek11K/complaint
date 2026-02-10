
<?php
require_once("db.php");
session_start();
try{
$sql="SELECT *FROM complaints ORDER BY user_id DESC";
$result=mysqli_query($connect,$sql);
}catch(Exception $e){
    $result=false;

    if(!isset($msg) || $msg==""){
        $msg="Error occurred!".$e->getMessage();
    }
}
?>
<html>
    <h2><b>Others complaint!!</b></h2>
    <table border="1" cellspacing="0">
        <tr>
            <th>User ID</th>
            <th>Complaint ID</th>
            <th>Subject</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created at</th>
      </tr>

<?php
if($result && mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_array($result)){
?>
    <tr>
    <td><?=$row['user_id'];?></td>
    <td><?=$row['complaint_id']?></td>
    <td><?=$row['subject']?></td>
    <td><?=$row['description']?></td>
    <td><?=$row['status']?></td>
    <td><?=$row['created_at']?></td>
    </tr>
    <?php
    }
}else{
    echo"<tr><td colspan='4'>No records found..</td></tr>";
}
?>
</table>
</html>
<br><br>
<a href="view.php">View complaint</a>