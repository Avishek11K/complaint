

<?php
session_start();
require_once("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit();
}


if(isset($_POST['submit'])){
    $user_id=$_SESSION['user_id'];
    $subject=$_POST['sub'];
    $description=$_POST['desc'];
    $sql="INSERT into complaints(subject,description,status,user_id)
    values('$subject','$description','pending',$user_id)";
    $result=mysqli_query($connect,$sql);
    if($result){
        header("Location:viewcomp.php");
        exit();
    }else{
        die("Failed!".mysqli_error($connect));
    }
}
?>

<h2><b>Complaints submission!!!</b></h2><br>
   
<form method="post">
   Subject:<br><br>
    <input type="text" name="sub" placeholder="Enter the subject of complaints" required>
    <br><br>
   Description:<br><br>
   <textarea name="desc" rows="10" cols="15" placeholder="Write your complaints here" required></textarea>
   <br><br>
   <input type="submit" name="submit" value="Submit">
   
</form>











