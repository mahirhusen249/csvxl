<?php
$servarname="localhost";    
$username="root";  
$password="";   
$dbname="scvxl";     

$con=mysqli_connect($servarname,$username,$password,$dbname);     
 
if($con){   
    // die("success:". mysqli_error($con));
}
?>   
