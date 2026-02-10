<?php
session_start();
require_once("db.php");

// if(!isset($_SESSION['user_id'])){
//    header("Location:login.php");
//    exit();
// }

$usernameerr=$emailerr=$passworderr="";
$username=$email=$password="";

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['register'])){
     if(empty($_POST['username'])){
        $usernameerr="Username required!";
     }else{
        $username=trim(htmlspecialchars($_POST['username']));
     }


     if(empty($_POST['email'])){
        $emailerr="Email required";
     }elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $emailerr="Validate email required!";
     }else{
        $email=trim($_POST['email']);
     }


     if(empty($_POST['password'])){
        $passworderr="Password required!";
     }else{
        $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
     }

     if($usernameerr==""&&$emailerr==""&& $passworderr==""){
       $sql="SELECT *FROM user where username='$username'";
       $namecon=mysqli_query($connect,$sql);
       if(!$namecon){
         die("Failed!".mysqli_error($connect));
       }
       $nameres=mysqli_num_rows($namecon);
       if($nameres>0){
         $usernameerr="Username already exists!";
       }

        $sql="SELECT *FROM user where email='$email'";
        $check=mysqli_query($connect,$sql);
             $checkres=mysqli_num_rows($check);
         if(!$check){
            die("Error in connection!".mysqli_error($connect));
         }
        if($checkres>0){
            $emailerr="Already registered";
        }else{
            $sql="INSERT INTO user(username,email,password)
            values('$username','$email','$password')";
            $result=mysqli_query($connect,$sql);
         if($result){
                header("Location:login.php");
                exit();
            }else{
                echo"Error occured!".mysqli_error($connect);
            }
        }
    }
}
?>

<h2><b>Register!!!</b></h2><br>
<form method="POST">
    Username:
    <input type="text" name="username" placeholder="Enter username" value="<?php echo $username;?>">
    <span style='color:red'></style><?php echo $usernameerr;?></span>
    <br><br>
    Email:
    <input type="text" name="email" placeholder="Enter email" value="<?php echo $email;?>">
     <span style='color:red'></style><?php echo $emailerr;?></span>
    <br><br>
    Password:
    <input type="password" name="password" placeholder="Enter password" value="<?php echo $password;?>">
     <span style='color:red'></style><?php echo $passworderr;?></span>
    <br><br>
    <input type="submit" name="register" value="Register">
    <br><br>
    <p>Already have account?</p><br>
<a href="login.php">Login here</a>
</form>
