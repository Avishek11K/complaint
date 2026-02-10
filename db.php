<?php
$host="localhost";
$user="root";
$password="mysql@11";
$db="usercomp";
$connect=mysqli_connect($host,$user,$password,$db);
if($connect){
   echo"Database connection successful!";
}else{
    echo"Error".mysqli_connect_error($connect);
}