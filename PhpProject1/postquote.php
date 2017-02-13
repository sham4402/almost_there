<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

echo "new value";
$pttl       = $_POST['pttl'];
$srno       = $_POST['Srno'];   
$pert       = $_POST['Pert'];
$pqty       = $_POST['pqty'];
$qty        = $_POST['qty'];
$invoice_id       = $_POST['invoice_id'];
//print_r($_POST['id']);

$sqlvar ="INSERT INTO `invoice_detail` (`invoice_id`, `srno`, `pert`, `qty`, `pqty`, `pttl`) "
        . "VALUES ('$invoice_id', '$srno', '$pert', '$qty', '$pqty', '$pttl') ";    
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