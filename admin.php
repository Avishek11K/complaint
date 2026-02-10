<?php
session_start();
require_once("db.php");
if(!isset($_SESSION['role']) && $_SESSION['role']!='admin'){
    header("Location:login.php");
    exit();
}

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
    <h2><b>Complaint!!</b></h2>
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
    <td>
        <a href="admin.php?edit=<?=$row['user_id'];?>">Edit status</a> |
        <a href="admin.php?delete=<?=$row['user_id'];?>"onclick="return confirm('Are you sure?');">Delete complaint</a>
    </tr>
    <?php
    }
}else{
    echo"<tr><td colspan='4'>No records found..</td></tr>";
}
?>
</table>
</html>


<?php
$edit_usid="";
$edit_compid="";
$edit_subject="";
$edit_desc="";
$edit_stat="";
$edit_creat="";
if(isset($_GET['edit'])){
    $edit_usid=(int)$_GET['edit'];
    // $edit_compid=(int)$_GET['compid'];

    $sql="SELECT *FROM complaints where user_id='$edit_usid'";
    $result=mysqli_query($connect,$sql);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $edit_compid=$row['complaint_id'];
        $edit_usid=$row['user_id'];
        $edit_stat=$row['status'];
        $edit_creat=$row['created_at'];
        $edit_subject=$row['subject'];
        $edit_desc=$row['description'];
    }else{
        echo"No record found!";
    }
}
?>

<h2>EDIT</h2><br>
<form method="GET">
    <!-- User Id:<input type="hidden" name="user_id" value="<?php echo $edit_usid;?>">
    <br>
     Complaint Id:<input type="hidden" name="compid" value="<?php echo $edit_compid;?>"> -->
     <br>
      Subject:<input type="text" name="sub" value="<?php echo $edit_subject;?>">
      <br><br>
       Description:<input type="text" name="desc" value="<?php echo $edit_desc;?>">
       <br><br>
        Status:<input type="text" name="stat" value="<?php echo $edit_stat;?>">
        <br><br>
         <!-- Created at:<input type="time" name="id" value="<?php echo $edit_creat;?>">
         <br> -->
         <input type="submit" value="Edit" name="edit"><br><br>
</form> 


<?php
if(isset($_POST['update'])){
$usid=(int)$_POST['user_id'];
$compid=(int)$_POST['compid'];
$sub=$_POST['sub'];
$desc=$_POST['desc'];
$stat=$_POST['stat'];

$sql="UPDATE complaints set complaint_id='$compid',subject='$sub',description='$desc',status='$stat' where user_id='$usid'";
    mysqli_query($connect,$sql);
    header("Location:admin.php");
    exit();
}
?>

<?php
if(isset($_GET['delete'])){
    $usid=(int)$_GET['delete'];
    $sql="DELETE FROM complaints where user_id='$usid'";
    mysqli_query($connect,$sql);

    header("Location:admin.php");
    exit();
}
?>


<h2>UPDATE & DELETE</h2><br><br>
<form method="POST">
    User Id:<input type="text" name="user_id" value="<?php echo $edit_usid;?>">
    <br><br>
     Complaint Id:<input type="text" name="compid" value="<?php echo $edit_compid;?>">
     <br><br>
      Subject:<input type="text" name="sub" value="<?php echo $edit_subject;?>">
      <br><br>
       Description:<input type="text" name="desc" value="<?php echo $edit_desc;?>">
       <br><br>
        Status:<input type="text" name="stat" value="<?php echo $edit_stat;?>">
        <br><br>
         <!-- Created at:<input type="time" name="id" value="<?php echo $edit_creat;?>">
         <br> -->
         <input type="submit" value="UPDATE" name="update"><br><br>
         <br>
</form>

<form method="GET">
    <!-- <input type="submit" value="DELETE" name="delete"> -->
</form>


