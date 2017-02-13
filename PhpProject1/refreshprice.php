<?php
require("db.php");
$item1=$_POST['textboxValue'];
$row1 = mysql_query("SELECT price from inventory where item = $item1");
echo $row['price'];
?>