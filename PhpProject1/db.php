<?php
$mysql_hostname = "localhost:3307";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "liveedit";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) 
        
or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

?>