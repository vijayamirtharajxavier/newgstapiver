<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $this->session->userdata('cname'); ?> | <?php echo $this->session->userdata('city'); ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/select2.min.css" rel="stylesheet">
</head>

<body id="page-top">

 <!-- Page Wrapper -->
  <div id="wrapper">
<?php  include 'layouts/sidebar.php';  ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
<?php  include 'layouts/navbar.php';  ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800"><?php echo $page; ?></h1>
<!--          <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="<?php base_url();?>assets/https://datatables.net">official DataTables documentation</a>.</p> -->

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $page; ?>
              <button style="float: right;" class="pull-right btn btn-primary" href="<?php echo base_url(); ?>addSales" ><i class="fa fa-plus"></i> Print</button> </h6>
            </div>
            
<div id="delete-sales-message"></div>
            <div class="card-body">
              <div class="table-responsive">
                <div id="sales_invoice"></div>
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


      <!-- Footer -->
<?php  include 'layouts/footer.php';  ?>      
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>










  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url();?>assets/js/bootstrap3-typeahead.min.js"></script>
  
<script src="<?php base_url(); ?>../assets/js/select2.min.js"></script>
  <!-- Page level custom scripts -->
<!--  <script src="<?php echo base_url();?>assets/js/demo/chart-area-demo.js"></script>
  <script src="<?php echo base_url();?>assets/js/demo/chart-pie-demo.js"></script>
<script src="<?php echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script> -->

<script>
var count;
var cnt;
count=1;
cnt=1;
var netvalue=0;
var net_value=0;
var netval=0;  
var gst_value=0.00;
var gstvalue=0;
var amtval=0;
var txbval=0;
var qty=0;
var gst_pc=0;
var dispc=0;
var rate=0;
var disval=0;
var gst_amt=0;
var gsttot=0;
calcnetTotal();
$(document).ready(function(){
getSales();
//$('#saleslistTable').DataTable();
var url="getSalesPerson";
$("#salesperson_name").load(url);
$("#salesperson_name").select2();


var url ="getInvLedgerAccount";
$("#customer_name").load(url);
$("#customerr_name").select2();

$("#customer_name").on('change',function(){
console.log('on chage');

var id = $(this).val();
console.log(id);
var furl ="getvendordata?id="+id;

       $.getJSON(furl, function(data) {
        console.log(data);
        $("#gstin").val(data.gstin);
        $("#vname").html(data.name);
        $("#statecode").val(data.statecode);
     //             console.log('AcName' + data.name );
      //            console.log('AcName' + data.statecode );


                  //$('#stage').append('<p>Age : ' + jd.age+ '</p>');
                 // $('#stage').append('<p> Sex: ' + jd.sex+ '</p>');
               });
});

/*
    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control" name="name' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="mail' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="phone' + counter + '"/></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });
*/



//Add Sales Message

    $("#addSalesForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
                if(response.success == true) {                      
                        $("#add-sales-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-sales-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addSalesForm").trigger("reset");
//manageProductTable.ajax.reload(null, false);
$("#salesTable tbody tr").remove(); 
$("#customer_name").val(0).change();
$("#cname").html("");
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});
                        
                        $.each(response.messages, function(index, value) {
                            var key = $("#" + index);

                            key.closest('.form-group')
                            .removeClass('has-error')
                            .removeClass('has-success')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.text-danger').remove();                         

                            key.after(value);
                        });
                                                
                    } // /else
            } // /.success
        }); // /.ajax funciton
        return false;
    });




//Item Name search typeahead

  $('.itemname').typeahead({
    source: function (typeahead, query) {
        return $.post(base_url + "invoice/getproductdatabysearch", {itemkeyword: query}, function (data) {
            return typeahead.process(data);
        });
    },
    onselect: function(obj) {
        var split = obj.split(' / ');
        //$('input[name=ecu]').val(split[1]);
        //$('input[name=ecu-id]').val(split[0].substr(1));
    }
});





}); //Document Ready


   $(document).on('click','#purTable tr', function() {
        //alert(this.rowIndex);
        // or
curr_row = $(".trrow").data("row");

        //alert($(this).index()); // jQuery way
    });


$(document).on('click','.trrow',function(){
curr_row = $(this).data("row");
console.log(curr_row);
});

$(document).on('keyup','.itemqty',function(){
var itnm =Number($('#'+curr_row).find('.itemname').val());
console.log(itnm);
txbval=0;
disval=0;
gst_amt=0;
netval=0;
console.log(curr_row);
gst_pc = Number($('#'+curr_row).find('.itemgstpc').val());
dispc = Number($('#'+curr_row).find('.itemdispc').val());


qty= Number($(this).val());
console.log('qty '+ qty);
//
rate=Number($('#'+curr_row).find('.itemrate').val());
console.log('rate '+ rate);

//var disval = Number(parseInt((qty)*rate)*dispc/100);

 amtval = Number(parseInt(qty)*rate);
//var txbval = Number(parseInt(qty)*rate);
disval = (amtval*dispc/100);
 txbval = amtval-disval;
console.log('amt'+amtval);
var gst_amt = Number(txbval*gst_pc/100);

netval = Number(txbval+gst_amt);

console.log(gst_amt);
$('#'+curr_row).find('.itemgstamt').val(gst_amt);
$('#'+curr_row).find('.itemdis').val(disval);
$('#'+curr_row).find('.itemamt').val(txbval);
$('#'+curr_row).find('.itemnet').val(netval);

calcnetTotal();
});


$(document).on('keyup','.itemrate',function(){
console.log(curr_row);
gst_pc = $('#'+curr_row).find('.itemgstpc').val();
dispc = $('#'+curr_row).find('.itemdispc').val();


rate= $(this).val();
//console.log('qty '+ qty);
//
qty=Number($('#'+curr_row).find('.itemqty').val());
//console.log('rate '+ rate);

//var disval = Number(parseInt((qty)*rate)*dispc/100);
 amtval = Number(parseInt(qty)*rate);
//var txbval = Number(parseInt(qty)*rate);
 disval = (amtval*dispc/100);
 txbval = amtval-disval;
console.log('amt'+amtval);
 gst_amt = Number(txbval*gst_pc/100);

 netval = Number(txbval+gst_amt);

console.log(netval);
$('#'+curr_row).find('.itemgstamt').val(gst_amt);
$('#'+curr_row).find('.itemdis').val(disval);
$('#'+curr_row).find('.itemamt').val(txbval);
$('#'+curr_row).find('.itemnet').val(netval);
calcnetTotal();
});

$(document).on('keyup','.itemdispc',function(){
console.log(curr_row);
console.log($("#itemname").text());

 dispc= $(this).val();
//console.log('qty '+ qty);
//
 qty=Number($('#'+curr_row).find('.itemqty').val());
//console.log('rate '+ rate);
 gst_pc = $('#'+curr_row).find('.itemgstpc').val();
 rate = $('#'+curr_row).find('.itemrate').val();

//var disval = Number(parseInt((qty)*rate)*dispc/100);
 amtval = Number(parseInt(qty)*rate);
//var txbval = Number(parseInt(qty)*rate);
 disval = (amtval*dispc/100);
 txbval = amtval-disval;
console.log('amt'+amtval);
 gst_amt = Number(txbval*gst_pc/100);

 netval = Number(txbval+gst_amt);

console.log(netval);
$('#'+curr_row).find('.itemgstamt').val(gst_amt);
$('#'+curr_row).find('.itemdis').val(disval);
$('#'+curr_row).find('.itemamt').val(txbval);
$('#'+curr_row).find('.itemnet').val(netval);

calcnetTotal();
});


$(document).on('focus', '.itemname', function (e) {
  
  var isOriginalEvent = e.originalEvent // don't re-open on closing focus event
  var isSingleSelect = $(this).find(".itemname").length > 0 // multi-select will pass focus to input

  if (isOriginalEvent && isSingleSelect) {
    $(this).siblings('select:enabled').select2('open');
  } 

});


$(document).on('click','.save_btn',function(){
        var table = document.getElementById("purTable").tBodies[0];
 
        for (var i = 0 ; i < table.rows.length; i++) {
 
            var row = "";
 
            for (var j = 0; j < table.rows[i].cells.length; j++) {
 
                row += table.rows[i].cells[j].innerHTML;
                row += " | ";
            }
 
            alert(row);
        }
  });



function getSales()
{
  $.get("getallSales",function(data,status){
    //console.log(JSON.parse(data));
/*var data = JSON.parse(data);
     data.forEach(function(d) {
var taxable_tot = Number(d.taxable_amount);
var net_tot = Number(d.net_amount);
var gst_tot = Number(net_tot-taxable_tot);
*/
      $("#sales_list").html(data);
     
     //});

//$("#saleslist").dataTable();
  });

 
  
}

function updateTransid(id)
{
console.log('record id for update ' + id);
  $.get("getSalesbyid?id="+id,function(data,status){
 //   console.log(data);
//var data = JSON.parse(data);
     /*data.forEach(function(d) {
      $("show-edit-sales-result").appen();
});*/

$(".show-edit-sales-result").html(data);
$("#modalEditSales").modal({
  backdrop: 'static'
});
});




}


function calcnetTotal()
{
  console.log("netTotal");
gsttot=0;
taxablevalue=0;
net_value=0;
taxablevalue=0;
netvalue=0;
$('.itemnet').each(function(i)
  {
    console.log(i);
    //gst_value = Number($(this).val());
    netvalue = Number($(this).val());
    
    net_value+=netvalue;
    console.log('nt ' + net_value);
  });


 taxable_value = 0.00;
 taxablevalue = 0.00;
 $('.itemamt').each(function(i){
    taxable_value = Number($(this).val());
    taxablevalue+=taxable_value;

  });
//console.log(taxablevalue);
$("#taxval").html(taxablevalue.toFixed(2));


console.log(gst_value);
console.log(gstvalue);
$("#netvaltot").html(net_value.toFixed(2)); 

 gsttot = Number(net_value-taxablevalue);
console.log('gsttot=' + gsttot);
$("#gstvaltot").html(gsttot.toFixed(2));

}

/*

$(document).on('keydown','.itemname',function(){
var id = $(this).val();
console.log('onchange item ' + id);

//var furl ="getproductdatabysearch?id="+id;
$(".itemname").typeahead({
    source: function (typeahead, query) {
        return $.post("invoice/getproductdatabysearch", {itemkeyword: query}, function (data) {
            return typeahead.process(data);
        });
    },
    onselect: function(obj) {
        var split = obj.split(' / ');
        //$('input[name=ecu]').val(split[1]);
        //$('input[name=ecu-id]').val(split[0].substr(1));
    }

});
*/
  /*     $.getJSON(furl, function(data) {
        console.log(data);
curr_row = $(".trrow").data("row");
//var gst_pc = $('#'+curr_row).find('.item_gstpc').val();

$('#'+curr_row).find('.itemrate').val(data.rate);
$('#'+curr_row).find('.itemdesc').val(data.desc);
$('#'+curr_row).find('.itemhsn').val(data.hsnsac);
$('#'+curr_row).find('.itemgstpc').val(data.gstpc);
$('#'+curr_row).find('.itemmrp').val(data.mrp);
$('#'+curr_row).find('.itemuom').val(data.unit).change();

$('#'+curr_row).find(".itemqty").focus();



});

}); */

$(document).on('click','.remove',function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 //x = document.getElementById("").rows.length-1;
//console.log('X' +x);
//$('#ticount').html(x);
//calcnetTotal();
//update_total();
//update_gsttotal();/
//update_nettotal();
});






$(document).on('click','#addRow', function(){
console.log('AddRow Clicked');
count=Number(count)+1;
cnt=cnt+1;

var tbl="";
 x = document.getElementById("editInvoiceItems").rows.length;   
$('#ticount').html(x);
console.log(x);
tbl ='<tr data-row="row'+count+'" class="trrow" id="row' + count + '" ><td style="width:30%;"><input style="width:100%;" type="text"  class="form-control itemname typeahead" autocomplete="off" id="edititemname" name="editsalebyperson[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="edititemdesc" name="edititemdesc[]" ></td><td><input type="text"  class="form-control" autocomplete="off" id="edithsnsac" name="edithsnsac[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="editgstpc" name="editgstpc[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="editunit" name="editunit[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="editqty" name="editqty[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="editrate" name="editrate[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="editdispc" name="editdispc[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="editdisamount" name="editdisamount[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="edittaxableamount" name="edittaxableamount[]"></td><td><input type="text"  class="form-control" autocomplete="off" id="editnetamount" name="editnetamount[]"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'+count+'" ><i class="fa fa-times"></i></button></td></tr>';



  var $td = $(tbl);
    //$("#addProdTable tbody tr:last").after($td);
    //createCustTypeahead($('input.customerSearch'));


$("#editInvoiceItems").prepend($td);
//$(".itemname").focus();

curr_row = $(".trrow").data("row");
//createTypeahead($('input.itemname'));
createTypeahead($('#edititemname'));
//var uniturl = 'getProductUnit';

//$('#'+curr_row).find(".itemuom").load(uniturl);

//var url ="getInvItems";
//$('#'+curr_row).find(".itemname").load(url);
//$('#'+curr_row).find(".itemname").select2();

//$('#'+curr_row).find(".itemname").select2('open');
//$('#id').select2('open').select2('close');

  });


function createTypeahead($els) {
console.log('you are in right track'+ $els);

var productNames = new Array();
var productIds = new Object();
/*
    $('.itemname').typeahead({
        source: function (query, process) {

            return $.get('getproductdatabysearch?itemkeyword=' + query, function (data) {
//console.log(data);
var obj = JSON.parse(data);
console.log(obj['name']);
                return process(obj['name']);
            });
        }
    });
*/
/*
$.get("getproductdatabysearch", function(data){
  $(".itemname").typeahead({ source:data });
},'json');

*/

$els.typeahead({

    source: function (query, process) {
        return $.get('getproductdatabysearch', { itemkeyword: query }, function (data) {
          console.log(data);

            productNames=new Array();;
 $.each( JSON.parse(data), function ( index, product )
            {
              console.log(product);

              //var accnamelist = product.id + ' - ' + product.name;
                productNames.push(product);

//                productNames.push( product.account_name );
            //    $('#debitaccountNumber').val(product.id);

              //  productIds[product.account_name] = product.id;
            } );
            return process(productNames);
        });
    },afterSelect: function(item) {
        //value = the selected object
        //e.g.: {State: "South Dakota", Capital: "Pierre"}
  //      console.log(item);
/*    var urlstr = base_url + 'fetchAccountlistbyname';
    var url = urlstr.replace("undefined","");
        return $.get(base_url + 'fetchAccountlistbyname', { itemkeyword: item }, function (response) {
           // console.log(items);

$.map(JSON.parse(response),function(items){
//console.log(items['id']);
    $('#editaccountNumber').val(items['acclink_id']);
//    $('#debitmemberNumber').val(items['acclink_id']);
    return items['id'];
   }); 

}); */

    }
   // autoSelect: true,
    
}); 

}



function oocreateTypeahead($els) {
console.log('you are in right track'+ $els);

  $els.typeahead({
    source: function (typeahead, query) {
        return $.post("invoice/getproductdatabysearch", {itemkeyword: query}, function (data) {
console.log(data);
            return typeahead.process(data);
        });
    },
    onselect: function(obj) {
        var split = obj.split(' / ');
        //$('input[name=ecu]').val(split[1]);
        //$('input[name=ecu-id]').val(split[0].substr(1));
    }
});

}


</script>


<style type="text/css">

input{
  font-size: 16px;
}


.sturdy th:nth-child(2)
 {
  width: 35%;
}

.sturdy td:nth-child(2),
.sturdy td:nth-child(2) {
  width: 35%;
}
/*.sturdy td:nth-child(2) {
  width: 50%;
} */

.nobreak {
  white-space: nowrap;
}

.wider td {
  width: 300px;
}


.ignoreyou td:nth-child(1) {
  width: 10px;
}
.ignoreyou td:nth-child(2) {
  width: 28px;
}

.cut-off th:nth-child(1) {
  width: 75%;
}
.cut-off td:nth-child(1) {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.cut-off th:nth-child(2) {
  width: 25%;
}
.cut-off td:nth-child(2) span {
  display: block;
  
}


.hide td {
  overflow: hidden;
}

.scroll-code td {
  overflow: auto;
}



.typeahead input{
  position: absolute;
  bottom: : 70px;
}

</style>

</body>

</html>
