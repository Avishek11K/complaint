
<?php
session_start();
require_once("db.php");

// must be logged in
if(!isset($_SESSION['user_id'])){
    echo "Please login first";
    exit();
}

$user_id = $_SESSION['user_id'];

// ONLY this user's complaints
$sql = "SELECT subject, description, status, created_at,complaint_id
        FROM complaints
        WHERE user_id = $user_id
        ORDER BY created_at DESC";

$result = mysqli_query($connect, $sql);
?>

<h2>My Complaints</h2>

<?php if(mysqli_num_rows($result) > 0){ ?>
<table border="1" cellpadding="8">
    <tr>
        <th>Complaint ID</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= htmlspecialchars($row['complaint_id']); ?></td>
        <td><?= htmlspecialchars($row['subject']); ?></td>
        <td><?= htmlspecialchars($row['description']); ?></td>
        <td><?= htmlspecialchars($row['status']); ?></td>
        <td><?= $row['created_at']; ?></td>
        <td>
            <a href="view.php?edit=<?=$row['complaint_id'];?>">Edit</a> |
            <a href="view.php?delete=<?=$row['complaint_id'];?>"onclick="return confirm('Are you sure?');">Delete</a>
    </td>
    </tr>
    <?php } ?>

</table>
<?php } else { ?>
    <p>You have not submitted any complaints yet.</p>
<?php } ?>

<?php
$edit_compid="";
$edit_sub="";
$edit_desc="";
if(isset($_GET['edit'])){
  $edit_compid=(int)$_GET['edit'];

  $sql="SELECT *from complaints where complaint_id='$edit_compid'";
  $res=mysqli_query($connect,$sql);
  if(mysqli_num_rows($res)==1){
    $row=mysqli_fetch_array($res);
  $edit_desc=$row['description'];
  $edit_sub=$row['subject'];
  }else{
    echo"No records found";
  }
}
?>

<h2>EDIT</h2>
<br><br>
<form method="GET">
   Complaint ID: <input type="hidden" name="comp_id" value="<?php echo $edit_compid;?>">
    <br><br>
      Subject:<input type="text" name="sub" value="<?php echo $edit_sub;?>">
    <br><br>
    Description:<input type="text" name="desc" value="<?php echo $edit_desc;?>">
    <br><br>
    <input type="submit" value="EDIT" name="edit">
</form>


<?php

if(isset($_POST['update'])){
    $compid=(int)$_POST['compid'];
    $sub=$_POST['sub'];
    $desc=$_POST['desc'];

    $sql="UPDATE complaints set subject='$sub',description='$desc' where complaint_id='$compid' ";
    mysqli_query($connect,$sql);

    header("Location:view.php");
    exit();

}
?>

<h2>UPDATE</h2>
<br><br>
<form method="POST">
    Complaint ID:<input type="hidden" name="compid" value="<?php echo $edit_compid;?>">
    <br><br>
    Subject:<input type="text" name="sub" value="<?php echo $edit_sub;?>">
    <br><br>
   Description:<br><br>
     <input type="text" name="desc" value="<?php echo $edit_desc;?>">
    <br><br>
    <input type="submit" value="UPDATE"name="update">
</form>
<br><br>
<a href="other.php">Other complaint</a>

<?php

if(isset($_GET['delete'])){
     $compid=(int)$_GET['delete'];
     $sql="DELETE from complaints where complaint_id='$compid'";
     mysqli_query($connect,$sql);
     header("Location:view.php");
     exit();
}
?>


<form method="GET">
    <!-- Complaint ID:<input type="hidden" name="compid">
    <br><br>
    <input type="text" name="sub">
    <br><br>
    <input type="text" name="desc"> -->
    <br><br>
    <!-- <input type="submit" value="DELETE"name="delete"> -->
</form>
 
