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


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->

<?php  include 'layouts/navbar.php';  ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <form class="text-center" style="color: #757575;" action="addSales" method="POST" id="addSalesForm">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?php echo $page; ?></h1>

                  <button type="submit" class="btn btn-success btn-sm" id="save_btn"><i class="fa fa-save text-white-900"></i> Save </button>

          </div>
<div class="pull-right" id="add-sales-message"></div>
<div class="pull-right" id="error-sales-message"></div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Invoice #<input autocomplete="off" class="form-control" type="text" name="invoice_no" id="invoice_no" required></div>
                      
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Invoice Date<input autocomplete="off"  class="form-control" type="date" name="invoice_date" id="invoice_date" required></div>
                    </div>                      
                   
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Order #<input class="form-control" autocomplete="off"  type="text" name="order_no" id="order_no"></div>
                      
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Order Date<input class="form-control" type="date" autocomplete="off"  name="order_date" id="order_date"></div>
                    </div>                      
                   
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Delivery Challan #<input class="form-control" type="text" autocomplete="off"  name="dc_no" id="dc_no"></div>
                      
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">DC Date<input class="form-control" type="date" autocomplete="off"  name="dc_date" id="dc_date"></div>
                    </div>                      
                   
                  </div>
                </div>
              </div>
            </div>


            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Customer Name<select class="form-control" name="customer_name" autocomplete="off"  id="customer_name" required></select></div>
                      
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">GSTIN#<input class="form-control" type="text" name="gstin" id="gstin" readonly><input class="form-control" type="text" name="statecode" id="statecode" hidden></div>
                    </div>                      
                   
                  </div>
                </div>
              </div>
            </div>            
</div>
            <!-- Earnings (Monthly) Card Example -->
            <!-- Earnings (Monthly) Card Example -->



  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sales Person<select class="form-control" name="salesperson_name" autocomplete="off"  id="salesperson_name" required></select></div>
                    

          <!-- Content Row -->
          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Items Details</h6>
                  <div style="font-size: 30px;color: blue; font-weight: bold;" class="text-center" name="vname" id="vname"></div>
                  <button class="btn btn-secondary btn-sm">Item(s)&nbsp;&nbsp;<span id="ticount"></span></button>

                  <button href="<?php base_url(); ?>" class="btn btn-primary btn-sm" id="addProduct"  data-toggle="modal" data-target="#modalAddProduct"><i class="fa fa-plus"></i> New Product </button>

                  

                  <button class="btn btn-info btn-sm" id="addRow">Add Row</button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                <!--  <div class="chart-area">-->
                

                <!--    <canvas id="myAreaChart"></canvas> -->
              <div class="table-responsive" style="overflow: auto; height: 250px; ">
                <table class="sturdy" id="purTable">
                  <thead>
                    <tr>
                    <th>?</th>
                    <th>ITEM</th>
                    <th>DESCRIPTION</th>
                    <th>HSNSAC</th>
                    <th>GST</th>
                    <th>UOM</th>
                    <th>QTY</th>
                    <th>RATE</th>
                    <th>DISPC</th>
                    <th>DISAMT</th>
                    <th>TAXABLE</th>
                    <th>NETT</th>
                    </tr>
                    
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
             <!-- </div>-->
                  </div>
                

              <div class="row">
                <div class="col-lg-4 mb-4">
                  <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                      <div class="text-white-900 pull-left">Taxable Value<span>
                      <h5 class="text-white-900 pull-right" id="taxval" style="text-align: right;"></h5></div></span>
                      
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 mb-2">
                  <div class="card bg-info text-white shadow">
                    <div class="card-body">
                      <h5 class="text-white-900" id="gstvaltot" style="text-align: right;"></h5>
                      <div class="text-white-900 large">GST Value</div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 mb-2">
                  <div class="card bg-success text-white shadow">
                    <div class="card-body">
                      <div class="text-white-900 large">Nett Value</div>
                      <h5 class="text-white-900" id="netvaltot" name="netvaltot" style="text-align: right;"></h5>
                      
                    </div>
                  </div>
                </div>
              </div>

</div>
              </div>
            </div>
          </div>

      

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" id="csrf_id" value="<?php echo $this->security->get_csrf_hash();?>">

</form>

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

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a>
        </div>
      </div>
    </div>
  </div>






<!--Add Modal -->
    <div id="modalAddProduct" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Product</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="add-product-message" class="pull-right"></div>
<div id="error-product-message" class="pull-right"></div>


        <!-- Form -->
        <form class="text-center" style="color: #757575;" action="products/addProduct" method="POST" id="addProductForm">

                <div class="modal-body">

                    <!--<p>Add the <code>.modal-xl</code> class on <code>.modal-dialog</code> to create this extra large modal.</p> -->
<!-- Material form register -->
<div class="card">


    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">


            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <label for="productname">PRODUCT NAME</label>
                         <input type="text" id="productname" name="productname" class="form-control" autocomplete="off" required>

                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="productdesc">DESCRIPTION</label>
                        <input type="text" id="productdesc" name="productdesc" class="form-control" autocomplete="off">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="productdesc">HSNSAC</label>
                        <input type="text" id="producthsnsac" autocomplete="off" name="producthsnsac" class="form-control">
                        
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="productdesc">UNIT</label><br>
                        <select id="productunit" name="productunit">
                          
                        </select>
                        
                    </div>
                </div>


            </div>


            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <label for="productmrp">MRP</label>
                        <input type="text" id="productmrp"  style="text-align: right;" value="0.00" autocomplete="off" name="productmrp" class="form-control">
                        
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="materialRegisterFormLastName">Cost</label>
                        <input type="text" id="productcost"  style="text-align: right;"  name="productcost" value="0.00" autocomplete="off" class="form-control">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="materialRegisterFormLastName">Rate</label>
                        <input type="text"  style="text-align: right;"  id="productrate" autocomplete="off" value="0.00"  name="productrate" class="form-control">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="productstock">Stock</label>
                        <input type="text" id="productstock" name="productstock" style="text-align: right;" value="0.00" autocomplete="off" class="form-control">
                        
                    </div>
                </div>

            </div>

            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <label for="productsku">SKU</label>
                        <input type="text"  id="productsku" autocomplete="off"  name="productsku" class="form-control">
                        
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="productbatch">Batch</label>
                        <input type="text" id="productbatch" autocomplete="off" name="productbatch" class="form-control">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="productexpiry">Expiry</label>
                        <input type="text" id="productexpiry" name="productexpiry" autocomplete="off" class="form-control">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <label for="productmake">Make</label>
                        <input type="text" autocomplete="off" name="productmake" id="productmake" class="form-control">
                        
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="productmodel">Model</label>
                        <input type="text" id="productmodel" autocomplete="off" name="productmodel" class="form-control">
                        
                    </div>
                </div>


            </div>


<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">


    </div>

</div>
<!-- Material form register -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
        </form>
        <!-- Form -->





  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php base_url(); ?>../assets/js/select2.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="<?php echo base_url();?>assets/js/demo/chart-area-demo.js"></script>
  <script src="<?php echo base_url();?>assets/js/demo/chart-pie-demo.js"></script>


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



$(document).on('change','.itemname',function(){
var id = $(this).val();
console.log('onchange item ' + id);

var furl ="getproductdata?id="+id;

       $.getJSON(furl, function(data) {
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

});

$(document).on('click','.remove',function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 x = document.getElementById("purTable").rows.length;
//console.log('X' +x);
$('#ticount').html(x);
calcnetTotal();
//update_total();
//update_gsttotal();/
//update_nettotal();
});


$(document).on('click','#addRow', function(){
console.log('AddRow Clicked');
 x = document.getElementById("purTable").rows.length;   
$('#ticount').html(x);
console.log(x);
count=Number(count)+1;
cnt=cnt+1;

var tbl="";




tbl +='<tr data-row="row'+count+'" class="trrow" id="row' + count +'"><td><button class="btn btn-danger remove" data-row="row'+count+'"><i class="fa fa-times"></i></button></td><td style="width:350px;text-align:left;"><input id="itemname' + count +'" name="itemname[' + count +']" class="itemname form-control" required></td><td><input style="width:150px;text-align:left;" text="text" class="form-control itemdesc"  autocomplete="off" id="itemdesc' + count +'" name="itemdesc[' + count +']"></td><td><input style="width:85px;text-align:left;" text="text" class="form-control itemhsn" id="itemhsn' + count +'" name="itemhsn[' + count +']" readonly></td><td><input text="text" class="form-control itemgstpc" id="itemgstpc' + count +'" name="itemgstpc[' + count +']" style="width:50px;" readonly></td><td><select class="form-control itemuom" id="itemuom' + count +'" name="itemuom[' + count +']" style="width:80px;"></select></td><td><input text="text" class="form-control itemqty"  autocomplete="off" id="itemqty' + count +'" name="itemqty[' + count +']" style="width:60px;"></td><td><input style="width:80px;text-align:right;" text="text" class="form-control itemrate" id="itemrate' + count +'" autocomplete="off"  name="itemrate[' + count +']"></td><td><input style="width:50px;text-align:right;" text="text" autocomplete="off"  class="form-control itemdispc" value="0.00" id="itemdispc' + count +'" name="itemdispc[' + count +']"></td><td><input style="width:80px;text-align:right;" text="text" class="form-control itemdis" id="itemdis' + count +'" name="itemdis['+ count +']" value="0.00" readonly></td><td><input style="width:90px;text-align:right;" text="text" class="form-control itemamt" id="itemamt' + count +'" name="itemamt[' + count +']" readonly></td><td><input style="width:90px;text-align:right;" text="text" class="form-control itemnet" id="itemnet' + count +'" name="itemnet[' + count +']" readonly></td><input style="width:150px;text-align:right;" text="text" class="form-control itemgstamt" id="itemgstamt' + count +'" name="itemgstamt[' + count +']" hidden><input  text="hidden" class="form-control itemmrp" id="itemmrp" name="itemmrp[]"></tr>';


$("#purTable tbody").prepend(tbl);
//$(".itemname").focus();
curr_row = $(".trrow").data("row");

var uniturl = 'getProductUnit';

$('#'+curr_row).find(".itemuom").load(uniturl);


var url ="getInvItems";
$('#'+curr_row).find(".itemname").load(url);
$('#'+curr_row).find(".itemname").select2();

$('#'+curr_row).find(".itemname").select2('open');
//$('#id').select2('open').select2('close');

  });
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



</style>

</body>

</html>
