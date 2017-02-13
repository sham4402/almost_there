<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

echo "new value";
$invoice_id       = $_POST['invoice_id'];
$inv_iss       = $_POST['inv_iss'];   
$inv_date       = date("Y-m-d");
$inv_comm       = $_POST['inv_comm'];
$inv_ittl        = $_POST['inv_ittl'];
//print_r($_POST['id']);

$sqlvar ="INSERT INTO `invoice`(`invoice_id`, `inv_iss`, `inv_date`, `inv_ittl`,`inv_comm`) "
        . " VALUES ('$invoice_id', '$inv_iss', '$inv_date','$inv_ittl', '$inv_comm')";    
$fd = fopen("log","a+");
	$str = "[".date("Y/m/d h:i:s",mktime())."]"."\n"   ;	
	//$NEW = $NEW."\n";
	// write string
	fwrite($fd, $str);
        fwrite($fd, $sqlvar);  
	
	// close file
	fclose($fd); 


//$obj =  json_decode($_GET["x"], false);
//var_dump($_POST['dbParam']);
//var_dump($_POST['Tbody1']);
//var_dump($_POST);




//var_dump($obj);
//echo 'id value is'.$obj['id'];
//mysql_query("insert into invoice (inv-iss) VALUES ('$obj=>$Srno')")
mysql_query($sqlvar);
//;

//echo json_encode("obj");
//

?>