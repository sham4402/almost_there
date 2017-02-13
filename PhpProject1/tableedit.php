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
        <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
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
                    $("#first_" + ID).html('<img src="load.gif" />');


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
        <script type="text/javascript" src="tableedit.js"></script> 
        <link rel="stylesheet" href="reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="tab.css" type="text/css" media="screen" />
        <link rel="stylesheet" type="text/css" href="tcal.css" />
        <script type="text/javascript" src="tcal.js"></script> 
        <link href="tabs.css" rel="stylesheet" type="text/css" />
        
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


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    

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
                <form id="theForm">
                To : <input name="search" type="text" id="inv_iss" value="" size="77" autocomplete="off"/></span>
                <div id="results" ></div>
                </form>
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

                                    <td> <p type="text" id="price_total" size="10"> </p> 

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
                                    <td id="final_price" class="finalprice" > </td>
                                    <td class="finalprice"></td>
                                    <script> update_itemprice(); update_total(1);</script>
                                </tr>
                            </tfoot>
                            <tbody id="Tbody" ></tbody>

                        </table>




                        <form >

                            <div class="center"><input  type="button" value="Submit Quoatation" 
                                                        id="submit_data"   /></div>

                        </form>
<div id="results"></div>
<script type="text/javascript">

  
var lookFor=[" "];
      
          <?php
include('db.php');
$sql=mysql_query("select distinct inv_iss from invoice where inv_iss <> ' ' ");
$index=1;
while($row = mysql_fetch_array($sql)){
    ?>
     lookFor.push(<?php echo json_encode($row['inv_iss']);?>);
     <?php $index++;?>
<?php }; ?>
      var form = document.getElementById("theForm");
      var resultsDiv = document.getElementById("results");
      console.log(form);
      console.log(form.search);
      var searchField = form.search;

      // first, position the results:
      var node = searchField;
      var x = 0;
      var y = 0;
      console.log(lookFor);
      console.log(node);
      while ( node !== null )
      {
          x += node.offsetLeft;
          y += node.offsetTop;
          node = node.offsetParent;
      }
      resultsDiv.style.left = x + "px";
      resultsDiv.style.top  = (y + 20) + "px";
      
      // now, attach the keyup handler to the search field:
      searchField.onkeyup = function()
      {
          var txt = this.value.toLowerCase();
          if ( txt.length === 0 ) return;

          var txtRE = new RegExp( "(" + txt + ")", "ig" );
          // now...do we have any matches?
          var top = 0;
          for ( var s = 0; s < lookFor.length; ++s )
          {
              var srch = lookFor[s];
              if ( srch.toLowerCase().indexOf(txt) >= 0 )
              {
                  srch = srch.replace( txtRE, "<span>$1</span>" );
                  var div = document.createElement("div");
                  div.innerHTML = srch;
                  div.onclick = function() {
                      searchField.value = this.innerHTML.replace(/\<\/?span\>/ig,"");
                      resultsDiv.style.display = "none";
                  };
                  div.style.top = top + "px";
                  top += 20;
                  resultsDiv.appendChild(div);
                  resultsDiv.style.display = "block";
              }
          }
      }
      // and the keydown handler:
      searchField.onkeydown = function() 
      {
          while ( resultsDiv.firstChild !== null )
          {
              resultsDiv.removeChild( resultsDiv.firstChild );          
          }
          resultsDiv.style.display = "none";
      };
     
  

</script>  
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
                    <th class="Date" width="100"> Date</th>
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



