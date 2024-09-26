<?php
include 'conn.php';


if (isset($_POST['submit'])) {

    $file_name = 'sdata.csv';

    $sql = "SELECT * FROM `stbl`";


    $result = mysqli_query($con, $sql);
    if (!$result) {
        die("query failed:" . mysqli_error($con));
    }  
   
    $data_arr = [];
     
    while ($row = mysqli_fetch_assoc($result)) {
        $sql2 = "SELECT mobileno,gender,address FROM `sdetails` WHERE sid=" . $row['id'];
        // print_r($sql2);exit;
        $result2 = mysqli_query($con, $sql2);
        if (!$result2) {
            die("query failed:" . mysqli_error($con));
        } 
        $data=['mobileno' => '', 'gender' => '','address'=>''];
        if (mysqli_num_rows($result2) > 0) {
            $data = mysqli_fetch_assoc($result2);
        }   
     
        
       $sql3="SELECT product_name,price,quantity from product where pid=".$row['id'];   
       $result3=mysqli_query($con,$sql3);   

       if(!$result3){ 
        die("query failed:".mysqli_error($con));
       }  
       $product=['product_name'=>'','price'=>'','quantity'=>''];  

       if(mysqli_num_rows($result3)>0){  
        $product=mysqli_fetch_assoc($result3);
       }      
      
     
        $data_arr[] = array_merge($row, $data,$product);
    }


    if (!empty($data_arr)) {
        header('content-type text/csv');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        $output = fopen('php://output', 'w');  
        fputcsv($output, array('id', 'name', 'email', 'password', 'mobileno', 'gender', 'address','product_name','price','quantity'));

        foreach ($data_arr as $data) {
            fputcsv($output, $data);
        }
        fclose($output);
        exit();
    } else {
        echo "no record found";
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>csvfille</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <form action="" method="post">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <button type="submit" name="submit" class="btn btn-primary">export data</button>
                </div>
            </div>
        </div>

    </form>
</body>

</html>