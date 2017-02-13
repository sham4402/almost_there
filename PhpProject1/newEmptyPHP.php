<?php
require_once('auth.php');
?>
<?php
include('db.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Inventory System</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/
        ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script type="text/javascript">
            var row_count = 0;
            var start = 0;
            var i = 0;
            $(document).ready(function ()
            {
                $(".edit_tr").click(function ()
                {
                    var ID = $(this).attr('id');
                    $("#first_" + ID).show();

                    $("#last_" + ID).hide();
                    $("#last_input_" + ID).show();
                }).change(function ()
                {
                    var ID = $(this).attr('id');
                    var first = $("#first_input_" + ID).val();
                    var last = $("#last_input_" + ID).val();
                    var dataString = 'id=' + ID + '&price=' + first + '&qty_sold=' + last;
                    $("#first_" + ID).html('<img src="image/load.gif" />');


                    if (first.length && last.length > 0)
                    {
                        $.ajax({
                            type: "POST",
                            url: "table_edit_ajax.php",
                            data: dataString,
                            cache: false,
                            success: function (html)
                            {

                                $("#first_" + ID).html(first);
                                $("#last_" + ID).html(last);
                            }
                        });
                    } else
                    {
                        alert('Enter something.');
                    }

                });

                $(".editbox").mouseup(function ()
                {
                    return false
                });

                $(document).mouseup(function ()
                {
                    $(".editbox").hide();
                    $(".text").show();
                });

            });
        </script>
        <link rel="stylesheet" href="tableedit.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="tab.css" type="text/css" media="screen" />
        <link rel="stylesheet" type="text/css" href="tcal.css" />
        <script type="text/javascript" src="tcal.js"></script> 
        <link href="tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">

            var popupWindow = null;

            function child_open()
            {

                popupWindow = window.open('printform.php', "_blank", "directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=950, height=400,top=200,left=200");

            }
        </script>

    </head>

    <body bgcolor="#dedede">

        <h1>Inventory System </h1>
        <ol id="toc">
            <li><a href="#geninvoice"><span>New Quotation</span></a></li>
            <li><a href="#quotef"><span>Quotation history</span></a></li>
            <li><a href="#inventory"><span>Inventory</span></a></li>
            <li><a href="#sales"><span>Sales</span></a></li>
            <li><a href="#alert"><span>To be order</span></a></li>
            <li><a href="#addproitem"><span>Add Item</span></a></li>
            <li><a href="#addpro"><span>Add Product</span></a></li>
            <li><a href="#editprice"><span>Edit Price</span></a></li>
            <li><a href="index.php"><span>Logout</span></a></li>
        </ol>

        <div class="content" id="inventory">
            Click the table rows to enter the quantity sold<br><br>
                    <table width="100%">
                        <tr class="head">
                            <th>Date</th>
                            <th>Item</th>
                            <th>Quantity Left</th>
                            <th>Qty Sold </th>
                            <th>Price</th>
                            <th>Sales</th>
                        </tr>
                        <?php
                        $da = date("Y-m-d");

                        $sql = mysql_query("select * from inventory");
                        $i = 1;
                        while ($row = mysql_fetch_array($sql)) {
                            $id = $row['id'];
//$date=$row['date'];
                            $item = $row['item'];
                            $qtyleft = $row['qtyleft'];
                            $qty_sold = $row['qty_sold'];
                            $price = $row['price'];
                            $sales = $row['sales'];

                            if ($i % 2) {
                                ?>
                                <tr id="<?php echo $id; ?>" class="edit_tr">
                            <?php
                            } else {
                                ?>
                                    <tr id="<?php echo $id; ?>" bgcolor="#f2f2f2" class="edit_tr">
                                <?php } ?>
                                    <td class="edit_td">
                                        <span class="text"><?php echo $da; ?></span> 
                                    </td>
                                    <td>
                                        <span class="text"><?php echo $item; ?></span> 
                                    </td>
                                    <td>
                                        <span class="text"><?php echo $qtyleft; ?></span>
                                    </td>
                                    <td>
                                        <span id="last_<?php echo $id; ?>" class="text"> 
    <?php
    $sqls = mysql_query("select * from sales where date='$da' and product_id='$id'");
    while ($rows = mysql_fetch_array($sqls)) {
        if ($rows['qty'] == 0) {
            $row1 = '0';
        } else {
            $row1 = $rows['qty'];
        }
        echo ($row1);
    }
    ?>
                                        </span> 
                                        <input type="text" value="<?php echo $row1; ?>"  class="editbox" id="last_input_<?php echo $id; ?>"/>
                                    </td>
                                    <td>
                                        <span id="first_<?php echo $id; ?>" class="text"><?php echo $price; ?></span>
                                        <input type="text" value="<?php echo $price; ?>" class="editbox" id="first_input_<?php echo $id; ?>" />
                                    </td>
                                    <td>

                                        <span class="text"> 
    <?php //echo $dailysales;  ?>
                                            <?php
                                            $sqls = mysql_query("select * from sales where date='$da' and product_id='$id'");
                                            while ($rows = mysql_fetch_array($sqls)) {
                                                $rtyrty = $rows['qty'];
                                                $rrrrr = $rtyrty * $price;
                                                echo $rrrrr;
                                            }
                                            ?>
                                        </span> 
                                    </td>
                                </tr>

    <?php
    $i++;
}
?>

                    </table>
                    <br />
                    Total Sales as of today:
                    <b>INR <?php

function formatMoney($number, $fractional = false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}

$result1 = mysql_query("SELECT sum(sales) FROM sales where date='$da'");
while ($row = mysql_fetch_array($result1)) {
    $rrr = $row['sum(sales)'];
    echo formatMoney($rrr, true);
}
?></b><br /><br />
                    <input name="" type="button" value="Print" onclick="javascript:child_open()" style="cursor:pointer;" />
                    </div>
                    <div class="content" id="alert">
                        <ul>
<?php
$CRITICAL = 10;
$sql2 = mysql_query("select * from inventory where qtyleft<='$CRITICAL'");
while ($row2 = mysql_fetch_array($sql2)) {
    echo '<li>' . $row2['item'] . '</li>';
}
?>
                        </ul>
                    </div>
                    <div class="content" id="sales">
                        <form action="tableedit.php#sales" method="post">
                            From: <input name="from" type="text" class="tcal" value="<?php echo date("Y-m-d"); ?>"/>
                            To: <input name="to" type="text" class="tcal" value="<?php echo date("Y-m-d"); ?>"/>
                            <input name="" type="submit" value="Search" />
                        </form><br />
                        Total Sales:  
<?php
if (!empty($_POST['from']) && !empty($_POST['to'])) {


    $a = $_POST['from'];
    $b = $_POST['to'];
    $result1 = mysql_query("SELECT sum(sales) FROM sales where date BETWEEN '$a' AND '$b'");
    while ($row = mysql_fetch_array($result1)) {
        $rrr = $row['sum(sales)'];
        echo formatMoney($rrr, true);
    }
}
?>
                    </div>
                    <div class="content" id="addproitem">
                        <form action="updateproduct.php" method="post">
                            <div style="margin-left: 48px;">
                                Product name:<?php
                        $name = mysql_query("select * from inventory");

                        echo '<select style="width: 200px" name="ITEM" id="user" class="textfield1">';
                        while ($res = mysql_fetch_assoc($name)) {
                            echo '<option value="' . $res['id'] . '">';
                            echo $res['item'];
                            echo'</option>';
                        }
                        echo'</select>';
                        ?>
                            </div>
                            <br />
                            Number of Item To Add:<input name="itemnumber" type="text" /><br />
                            <div class="center"><input name="" type="submit" value="Add" /></div>
                        </form>
                    </div>


                    <div class="content" id="addpro">
                        <form action="saveproduct.php" method="post">
                            <div style="margin-left: 48px;">
                                Product name:<input name="proname" type="text" />
                            </div>
                            <br />
                            <div style="margin-left: 97px;">
                                Price:<input name="price" type="text" />
                            </div>
                            <br />
                            <div style="margin-left: 80px;">
                                Quantity:<input name="qty" type="text" />
                            </div>
                            <div style="margin-left: 127px; margin-top: 14px;"><input name="" type="submit" value="Add" /></div>
                        </form>
                    </div>



                    <div class="content" id="editprice">
                        <form action="updateprice.php" method="post">
                            <div style="margin-left: 48px;">
                                Product name:<?php
                                $name = mysql_query("select * from inventory");

                                echo '<select style="width: 200px" name="ITEM" id="user" class="textfield1">';
                                while ($res = mysql_fetch_assoc($name)) {
                                    echo '<option value="' . $res['id'] . '">';
                                    echo $res['item'];
                                    echo'</option>';
                                }
                                echo'</select>';
                        ?>
                            </div>
                            <br />
                            <div style="margin-left: 97px;">Price:<input name="itemprice" type="text" /></div>
                            <div style="margin-left: 127px; margin-top: 14px;"><input name="" type="submit" value="Update" /></div>
                        </form>
                    </div>

                    <script type="text/javascript">


                        function update_itemprice()
                        {

                            var textboxValue = document.getElementById('item_selected').value;
                            console.log(textboxValue);
                            var price = textboxValue.substring(textboxValue.search("-") + 1,
                                    textboxValue.length - textboxValue.search("-") + 1);
                            console.log(price);

                            document.getElementById('price_per_item').innerHTML = parseFloat(price).toFixed(2);

                            change_qty();

                        }
                    </script>

                    <script type="text/javascript">

                        function update_total(a) {
                            var b = parseFloat(document.getElementById('price_per_item').innerHTML).toFixed(2);
                            document.getElementById('price_total').innerHTML = parseFloat(b * a).toFixed(2);
                        }
                    </script>
                    <script type="text/javascript">
                        function change_qty() {
                            var qty = parseInt(document.getElementById('ItemQty').value);

                            if (!isNaN(qty)) {
                                document.getElementById('ItemQty').value = qty;
                                update_total(qty);
                            } else {
                                alert('You can only enter numbers in quantity');
                                document.ItemQty.focus();
                            }


                        }
                    </script>

                    </script>
                    <script type="text/javascript">

                        function add_row() {
                            if (start === 0) {
                                addlist();
                                addlist1();
                                start = 1;
                            }
                            var table = document.getElementById("Tbody");
                            var row1 = table.insertRow();
                            var cell1 = row1.insertCell(0);
                            var cell2 = row1.insertCell(1);
                            var cell3 = row1.insertCell(2);
                            var cell4 = row1.insertCell(3);
                            var cell5 = row1.insertCell(4);
                            var cell6 = row1.insertCell(5);
                            cell1.innerHTML = row_count + 1;
                            var c1 = document.getElementById('item_selected');
                            var c2 = c1.options[c1.selectedIndex].text;

                            //cell2.
                            cell2.innerHTML = c2;
                            cell3.innerHTML = document.getElementById('ItemQty').value;
                            cell4.innerHTML = parseFloat(document.getElementById('price_per_item').innerHTML).toFixed(2);
                            cell5.innerHTML = parseFloat(document.getElementById('price_total').innerHTML).toFixed(2);
                            ;
                            var buttonnode = document.createElement('input');
                            buttonnode.setAttribute('type', 'button');
                            buttonnode.setAttribute('value', 'Remove');
                            cell6.appendChild(buttonnode);
                            update_finalprice();
                            row_count++;
                        }
                    </script>
                    <script type="text/javascript">
                        function update_table() {
                            var table1 = document.getElementById("Tbody");
                            for (var a = 0, rowa; rowa = table1.rows[a]; a++) {
                                rowa.cells[0].innerHTML = parseFloat(a) + 1;
                                update_finalprice();
                            }
                        }
                    </script>
                    <script type="text/javascript">
                        function addlist1() {
                            var subm = document.getElementById("submit_data");
                            subm.addEventListener('click', posthtml);
                        }

                    </script>
                    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

                    <script type="text/javascript">
                        function posthtml() {

                            var abc = document.getElementById("invoice_id").innerHTML;
                            var inviss = document.getElementById("inv_iss").value;
                            var invdate = document.getElementById("inv_date").innerHTML;
                            var invcomm = document.getElementById("inv_comm").value;
                            document.getElementById("invoice_id").innerHTML = parseInt(abc) + 1;

                            var dbParam1 = 'invoice_id=' + abc +
                                    '&inv_iss=' + inviss +
                                    '&inv_date=' + invdate +
                                    '&inv_comm=' + invcomm +
                                    '&inv_ittl=' + document.getElementById("final_price").innerHTML;

                            $.ajax({
                                type: "POST",
                                url: "postinvoice.php",
                                data: dbParam1,
                                // contentType: "application/json; charset=utf-8",
                                // dataType: "json",
                                cache: false,
                                success: function (data) {
                                    console.log("success");
                                }
                            }
                            );
                            console.log("in console post");
                            var table1 = document.getElementById("Tbody");
                            for (var a = 0, rowa; rowa = table1.rows[a]; a++) {

                                // var dbParam=obj;
                                var dbParam = 'Srno=' + parseFloat(rowa.cells[0].innerHTML) +
                                        '&Pert=' + (rowa.cells[1].innerHTML) +
                                        '&qty=' + parseInt(rowa.cells[2].innerHTML) +
                                        '&pqty=' + (rowa.cells[3].innerHTML) +
                                        '&pttl=' + (rowa.cells[4].innerHTML) +
                                        '&invoice_id=' + abc;
                                $.ajax({
                                    type: "POST",
                                    url: "postquote.php",
                                    data: dbParam,
                                    // contentType: "application/json; charset=utf-8",
                                    // dataType: "json",
                                    cache: false,
                                    success: function (data) {
                                        console.log("success");
                                    }
                                }
                                );
                            }
                            window.open("printform_1.php?inv_id=" + abc);

                        }

                    </script>
                    <script type="text/javascript">
                        function update_finalprice() {
                            var table1 = document.getElementById("Tbody");
                            var rowtotal = 0;
                            for (var a = 0, rowa; rowa = table1.rows[a]; a++) {
                                rowtotal = parseFloat(rowtotal) + parseFloat(rowa.cells[4].innerHTML);
                            }
                            document.getElementById("final_price").innerHTML = parseFloat(rowtotal).toFixed(2);
                        }
                    </script>

                    <script type="text/javascript">

                        function addlist() {
                            var table2 = document.getElementById("Tbody");
                            table2.addEventListener('click', function (e) {
                                var rowc = e.target.parentNode.parentNode;

                                var j = rowc.rowIndex;
                                var table1 = document.getElementById("Tbody");
                                table1.deleteRow(parseInt(j) - 1);
                                row_count = row_count - 1;
                                if (row_count !== 0) {
                                    update_table();
                                }
                            }, false);
                        }
                    </script>


                    </script>
                    <div class="content" id="geninvoice">


                        <h2 class="head2">GENERATE NEW QUOTATION </h2>

                        <div class="inv_number_and_date"> <span class="float-left"  >
                                Quotation Number: </span><span class="float-left" id="invoice_id" ><?php
                                $name = mysql_query("SELECT max(invoice_id) as num FROM invoice ");

                                $res = mysql_fetch_assoc($name);
                                $inv_num = (int) $res['num'];
                                $inv_num++;
                                //$res['num']=$res+1;
                                echo $inv_num;
                                ?></span>

                            <span id="inv_date" class="float-right" > Date : <?php echo date("Y-m-d"); ?></span>
                        </div> <br>
                            <div class="name_address"> <span class="float-left">
                                    To : <input type="text" id="inv_iss" value="" size="77"/></span>
                                <span class="float-left">Invoice note (optional) : <input type="text" id="inv_comm" value="" size="61"/></span>        <br>
                            </div>
                            <br> <br>
                                    <br>
                                        <div class="center">
                                            <table  id="item_table" >
                                                <thead>
                                                    <tr class="head">
                                                        <th style="width: 150px;" >Select Item to add</th>
                                                        <th>Quantity</th>
                                                        <th>Price Per Item</th>
                                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;         </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="Tbody1">
                                                    <tr ><td  >  <select style="width: 150px;" name="ITEM" id="item_selected" class="textfield1"
                                                                         onchange="javascript:update_itemprice()">
                                                                             <?php
                                                                             $name = mysql_query("select * from inventory");
                                                                             while ($res = mysql_fetch_assoc($name)) {
                                                                                 echo '<option value="' . $res['id'] . '-' . $res['price'] . '">';
                                                                                 echo $res['item'];
                                                                                 echo'</option>';
                                                                             }
                                                                             echo'</select>';
                                                                             ?>                     
                                                        </td>  <td class="edit_td"> <input type="text" id="ItemQty" value="1" size="11"
                                                                                           oninput="javascript:change_qty()"
                                                                                           /> </td>
                                                        <td> <p type="text" id="price_per_item" size="10">  </p> </td>
                                                        <script> update_itemprice();</script>
                                                        <td> <p type="text" id="price_total" size="10"> </p> 
                                                            <script> update_total(1);</script>
                                                        </td>           
                                                        <td>    
                                                            <input type="submit" value="Add to Quote" name="new_item_button" onclick="javascript:add_row()"
                                                                   />   </td>
                                                    </tr>
                                            </table>
                                        </div><br>
                                            <table  class="center" id="quoate_table">
                                                <thead>
                                                    <tr class="head">
                                                        <th width="10"> Sr No</th>
                                                        <th width="150"> Particulars (Items)</th>
                                                        <th width="50"> Quantity</th>
                                                        <th width="80"> Price per Qty</th>
                                                        <th width="100"> Total Price</th>
                                                        <th width="30"> Remove </th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" rowspan="1" style="text-align: center;"> </td>
                                                        <td>TOTAL PRICE</td>
                                                        <td id="final_price" class="finalprice"> </td>
                                                        <td class="finalprice"></td>
                                                    </tr>
                                                </tfoot>
                                                <tbody id="Tbody" ></tbody>

                                            </table>




                                            <form >

                                                <div class="center"><input  type="button" value="Submit Quoatation" 
                                                                            id="submit_data"   /></div>

                                            </form>
                                            </div>

                                            <div class="content" id="quotef">

                                                <form action="tableedit.php#quotef" method="post">
                                                    From: <input name="from" type="text" class="tcal" value="<?php echo date("Y-m-d"); ?>"/>
                                                    To: <input name="to" type="text" class="tcal" value="<?php echo date("Y-m-d"); ?>"/>
                                                    <input name="" type="submit" value="Search" />
                                                </form><br />

                                                <?php
                                                if (!empty($_POST['from']) && !empty($_POST['to'])) {


                                                    $a = $_POST['from'];
                                                    $b = $_POST['to'];
                                                    $result1 = mysql_query("SELECT * FROM invoice where inv_date BETWEEN '$a' AND '$b'");
                                                    //echo $result1;
                                                    $rec = 0;
                                                    while ($row = mysql_fetch_array($result1)) {
                                                        $rec = (int) $rec + 1;
                                                        if ($rec == '1') {
                                                            echo '<table  class="center" id="quoate_table">
            <thead>
                <tr class="head">
                    <th width="50"> Quotation number</th>
                    <th width="75"> Date</th>
                    <th width="150"> To</th>
                    <th width="80"> Total Price</th>
                    <th width="200"> Comments</th></tr>
            </thead>';
                                                            echo '         <tbody id="Tbody" >';
                                                        } echo ' <tr> 
                     <td> <a href="printform_1.php?inv_id=';
                                                        echo $row['invoice_id'];
                                                        echo '" target="_blanks">';
                                                        echo $row['invoice_id'];
                                                        echo '</a>';
                                                        echo '</td>
         <td>';
                                                        echo $row['inv_date'];
                                                        echo '</td>
         <td>';
                                                        echo $row['inv_iss'];
                                                        echo ' </td>
         <td>';
                                                        echo $row['inv_ittl'];
                                                        echo ' </td>
         <td>';
                                                        echo $row['inv_comm'];
                                                        echo ' </td>
         
             </tr> ';
                                                    } echo '       
         </tbody></table>';
                                                }
                                                ?>
                                            </div>


                                            <script src="activatables.js" type="text/javascript"></script>
                                            <script type="text/javascript">
                                                                activatables('page', ['geninvoice', 'quotef', 'inventory', 'alert', 'sales', 'addproitem', 'addpro', 'editprice']);
                                            </script>
                                            </body>







                                            </html>



