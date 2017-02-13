<?php
include('db.php');
$inv_id = $_REQUEST['inv_id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Quotation Number :<?php echo $inv_id ?></title>
</head>
<link rel="stylesheet" type="text/css" href="printstyle.css" />
<script type="text/javascript" src="tcal.js"></script> 
<link href="tabs.css" rel="stylesheet" type="text/css" />

<h1 > Quotation </h1>
<div class="name_address" id="todetails">
 

 <table >
      <tbody>
        <tr>
          <td style="width: 130px">Quotation Number : </td>
          <?php
            $da=date("Y-m-d");
            $retry=0;
            $sql=mysql_query("select * from invoice where invoice_id='$inv_id'");
            
            while (mysql_num_rows($sql) ==0){$retry++;
            usleep(99999);
            
            $sql=mysql_query("select * from invoice where invoice_id='$inv_id'");
            
            if ($retry==100){ echo 'row not found'; die();}
            }
            while($row = mysql_fetch_array($sql)){
    $To=$row['inv_iss'];
    $wdate=$row['inv_date'];
    $inv_ittl1= $row['inv_ittl'];
            
            }         ?>
          
          <td style="width: 480px"> <?php             echo $inv_id;         ?> </td>
          <td style="width: 50px"><b>&nbsp;Date
              :</b></td>
          <td style="width: 90px"> <?php             echo $wdate;         ?>         </td>
        </tr> <tr><td >To : </td>
            <td colspan="3" rowspan="1"><?php             echo $To;         ?> </td>
          
              
              
              
          </tr>
      </tbody>
     <br>
</div> 
<table class="center">
    <br>
      <thead>
        <tr class="head">
            <th width="12px"><b>Sr
              No</b></th>
            <th width="200px" ><b>Particulars</b></th>
          <th ><b>No
              of Items</b></th>
          <th ><b>Price
              Per Item</b></th>
          <th ><b>Total
              Price</b></th>
        </tr>
      </thead>
<tbody>
   <?php
$da=date("Y-m-d");
$qury="select * from invoice_detail where invoice_id='$inv_id'";
//echo $qury;
$sql=mysql_query($qury);
if ($sql===false){
    echo "queryfailed";    die();
}
$i=1; $price_total=(float)0.00;
while($row9=mysql_fetch_array($sql))
{
$srno=$row9['srno'];
$pert=$row9['pert'];
$qty=$row9['qty'];
$pqty=$row9['pqty'];
$pttl=$row9['pttl'];
$price_total = (float)$price_total+(float)$pttl;
//echo $price_total;
//$sales=$row['sales'];
?>
<tr id="<?php echo $srno; ?>" >
<td><span class="text"><?php echo $srno; ?></span> </td>
<td><span class="text"><?php echo $pert; ?></span> </td>
<td><span class="text"><?php echo $qty; ?></span> </td>
<td><span class="text"><?php echo $pqty; ?></span> </td>
<td><span class="text"><?php echo $pttl; ?></span> </td>
<?php
$i++;
}
?>
</tbody>
<tfoot>
        <tr>
          <td colspan="3" rowspan="1" style="text-align: center;"><br>
          </td>
          <td ><b>TOTAL</b></td>
          <td ><strong><?php             echo $inv_ittl1;         ?> 
            </strong> </td>
        </tr>
      </tfoot>
    </table>
<div style="float:left;">

</div><br /><br />
<input name="" type="button" value="Print" onclick="javascript:window.print()" style="cursor:pointer; float:left;" />

</body>
</html>
