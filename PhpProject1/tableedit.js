
src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js";
        
src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js";

function update_total(a) {
    var b = parseFloat(document.getElementById('price_per_item').innerHTML).toFixed(2);
    document.getElementById('price_total').innerHTML = parseFloat(b * a).toFixed(2);
}

function change_qty() {
    var qty = parseInt(document.getElementById('ItemQty').value);

    if (!isNaN(qty)) {
        document.getElementById('ItemQty').value = qty;
        update_total(qty);
    } else {
        //alert('You can only enter numbers in quantity');
        document.ItemQty.focus();
    }


}


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
function update_table() {
    var table1 = document.getElementById("Tbody");
    for (var a = 0, rowa; rowa = table1.rows[a]; a++) {
        rowa.cells[0].innerHTML = parseFloat(a) + 1;
        
    }update_finalprice();
}
function addlist1() {
    var subm = document.getElementById("submit_data");
    subm.addEventListener('click', posthtml);
}
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


    //console.log("in console post");
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
    }
    window.open("printform_1.php?inv_id=" + abc);

}

function update_finalprice() {
    var table1 = document.getElementById("Tbody");
    var rowtotal = 0;
    for (var a = 0, rowa; rowa = table1.rows[a]; a++) {
        rowtotal = parseFloat(rowtotal) + parseFloat(rowa.cells[4].innerHTML);
    }
    document.getElementById("final_price").innerHTML = parseFloat(rowtotal).toFixed(2);
}
function addlist() {
    var table2 = document.getElementById("Tbody");
    table2.addEventListener('click', function (e) {
        var rowc = e.target.parentNode.parentNode;

        var j = rowc.rowIndex;
        var table1 = document.getElementById("Tbody");
        table1.deleteRow(parseInt(j) - 1);
        row_count = row_count - 1;
        //if (row_count !== 0) {
            update_table();
        //}
    }, false);
}
      function update_itemprice()
                        {

                            var textboxValue = document.getElementById('item_selected').value;
                            //console.log(textboxValue);
                            var price = textboxValue.substring(textboxValue.search("-") + 1,
                                    textboxValue.length - textboxValue.search("-") + 1);
                            //console.log(price);

                            document.getElementById('price_per_item').innerHTML = parseFloat(price).toFixed(2);

                            change_qty();

                        }
                        

                  