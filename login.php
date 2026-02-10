<?php
session_start();
$emerror=$passerror="";
require_once("db.php");
if(isset($_POST['login'])){
    $username=trim($_POST['name']);
    $email=trim($_POST['email']);
    $password=$_POST['password'];
    

    // $admin=[
    //     "username"=>"admin",
    //     "password"=>"admin123",
    //     "email"=>"admin123@gmail.com"
    // ];
    
    $sql="SELECT *FROM user where email='$email' and username='$username'";
    $result=mysqli_query($connect,$sql);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
              if(password_verify($password,$row['password'])){
                  $_SESSION['user_id']=$row['user_id'];
                  $_SESSION['username']=$row['username'];
                  $_SESSION['role']=$row['role'];
                  if($row['role']=='admin'){
                     header("Location:admin.php");
                     echo"<span style='color:green;'</style><br>Login successful!</br></span>";
                  }else{
                     header("Location:dash.php");
                      exit();
                  }
                //    $_SESSION['Email']=$row['email'];
                //              // $_SESSION['role']="user";
    }else{
        $passerror="Incorrect password!";
    }
}else{
    $emerror="Incorrect email or username!";
}
}

?>

<h2><b>Login!!!</b></h2><br>
<form method="POST">
    Username:
    <input type="text" name="name" placeholder="Enter username" required>
    <br><br>
    Email:
    <input type="text" name="email" placeholder="Enter email" required>
    <span style='color:red;'></style><?php echo $emerror;?></span>
    <br><br>
    Password:
    <input type="password" name="password" placeholder="Enter password" required>
    <span style='color:red;'></style><?php echo $passerror;?></span>
    <br><br>
    <input type="submit" name="login" value="Login">
    <br><br>
    <p>No account yet?</p>
    <a href="register.php">Register</a>
</form>

