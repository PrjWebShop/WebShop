


<!DOCTYPE html>
<html>
<head>
<title>All fees of shipment.</title>
</head>
<body>
<?php

require_once 'src/lib.php';
function executeSql($sql){
    
    $flag = false;
    $feedback = array();
    if($sql == ""){
        echo "Error! Sql content is empty!";
    }else{
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
        $query_result=mysqli_query($conn,$sql);//query_result is a PHP array
        if($query_result){
            $flag = true;
            $feedback = $query_result;
            //$num_rows=mysqli_num_rows($query_result);
        }
        return array($flag,$feedback);
    }
}


$unitPrice  = 0.0;
if(isset($_POST["submit"])){
    $orignLocation = $_POST["orgn_location"];
    $targetLocation = $_POST["trgt_location"];
    $company = $_POST["company"];
    
    if($company == ""){$unitPrice = 0.0;setcookie("shipment_way",$company);}
    if($company == ""){$unitPrice = 0.0;setcookie("shipment_way",$company);}
    if($company == ""){$unitPrice = 0.0;setcookie("shipment_way",$company);}
    if($company == ""){$unitPrice = 9.8;setcookie("shipment_way",$company);}
    if($company == ""){$unitPrice = 7.6;setcookie("shipment_way",$company);}
    
    $totalItem = $_COOKIE['total_item'];
    $shipmentPrice = $unitPrice * $totalItem;
    
    $numbers = range (1,1000000);
    //shuffle Disrupt the order of the array immediately
    shuffle ($numbers);
    //array_slice Take a segment of this array
    $num=1;
    $result = array_slice($numbers,0,$num);
    $d_random = $result[0];
    
    $sql = "INSERT INTO delivery_info (d_company, d_init_add, d_trgt_add, d_price, d_random)
		VALUES ('".$company."', '".$orignLocation."', '".$targetLocation."',".$shipmentPrice.",".$d_random.");";
    
    $result = executeSql($sql);
    
    if($result[0]){
        setcookie('shipment_price',$shipmentPrice);
        $select_sql = "SELECT d_id FROM delivery_info WHERE d_random = ".$d_random.";";
        $select_result = executeSql($select_sql);
        if($select_result[0]){
            while ($row = mysqli_fetch_assoc($select_result[1])){
                //var_dump($row);
                $d_id=$row["d_id"];
                setcookie('d_id',$d_id);
                setcookie('shipment_status',true);
            }
        }
    }
}
header("location:payInfo.php");
?>
</body>
</html>