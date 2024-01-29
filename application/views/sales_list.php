<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $page; ?></title>

  <!-- Custom fonts for this template -->
  <link href="<?php base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
              <button style="float: right;" class="pull-right btn btn-primary" href="<?php echo base_url(); ?>addSales" ><i class="fa fa-plus"></i> New Sales</button> </h6>
            </div>
            
<div id="delete-sales-message"></div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="salesTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST%</th>
                      <th>IGST</th>
                      <th>CGST</th>
                      <th>SGST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist">

                  </tbody>
                </table>
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
          <a class="btn btn-primary" href="<?php base_url();?>assets/login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>



        <!-- Form -->


<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-times"></i>
                </div>              
                <h4 class="modal-title">Are you sure?</h4>  
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this record? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <button type="button" id="delRec" class="btn btn-danger"  data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>  






  <!-- Bootstrap core JavaScript-->
  <script src="<?php base_url();?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php base_url();?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php base_url();?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php base_url();?>assets/js/demo/datatables-demo.js"></script>


<script>
  var manageProductTable;
$(document).ready(function(){

//var uniturl = 'products/getProductUnit';

//$("#productunit").load(uniturl);


getSales();






$("btn_search").on("click",function(){





    console.log('Search Clicked');
 urlstr = 'inventory/getallSales';
 url = urlstr.replace("undefined","");
//  date("d-m-Y", strtotime($originalDate));
//console.log('fmDate ' + fmDate + ' toDate ' + toDate);
//manageProductTable = $("#productTable").dataTable().fnDestroy();
 manageSalesTable =  $('#salesTable').DataTable( 
  {
    "destroy": true,
    "ajax"    : url, //+ 'fetchReceiptSearch',
   
"columns": [
            { "data": "action" },
            { "data": "name" },
            { "data": "desc" },
            { "data": "hsnsac" },
            { "data": "gstpc" },
            { "data": "unit" },
            { "data": "mrp" },
            { "data": "cost" },
            { "data": "rate" },
            { "data": "sku" },
            { "data": "batch" },
            { "data": "expiry" },
            { "data": "make" },
            { "data": "model" },
            { "data": "stock" }
            
        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-left",
      "width": "150px"
 },
 {
      "targets": [5, 6, 7,13],
      "className": "text-right"
 },

 ],

        dom: 'Bfrtip',
       
        buttons: [
            'copy', 'csv', 'excel',{
            extend: 'pdf',


title: function() {
      return $('#monthYear').val();
    },

 //title: system_name + '\n' + 'Receipts Report for the period from '+ $('#fmDate').val() + ' to '+ $('#toDate').val(),
  customize: function(doc) {
    doc.styles.title = {
      color: 'red',
      fontSize: '40',
      background: 'blue',
      alignment: 'center'

    }   


  },

               exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },   
          
            orientation: 'portrait', // 'landscape',


            customize: function (doc) {
                  var rowCount = doc.content[1].table.body.length;

      doc.pageMargins = [20,10,10,10];
        doc.defaultStyle.fontSize = 7;
        doc.styles.tableHeader.fontSize = 8;
        doc.styles.title.fontSize = 10; 
        // Remove spaces around page title
        doc.content[0].text = doc.content[0].text.trim();

      doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Receipts Report for the period from '+ $('#fmDate').val() + ' to '+ $('#toDate').val(),
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
                margin: [10, 0]
            }
        });

},
         }, {extend: 'print',

  

                                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },
      }

        ]




}); 
    
});   //Btn Clicked

//Edit Product Message

    $("#editSalesForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                if(response.success == true) {                      
                        $("#edit-product-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#edit-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


//$("#editProductForm").trigger("reset");
manageProductTable.ajax.reload(null, false);
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



//Add Product Message

    $("#addProductForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                if(response.success == true) {                      
                        $("#add-product-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


//$("#addProductForm").trigger("reset");
manageProductTable.ajax.reload(null, false);
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

function getSales()
{
  $.get("inventory/getallSales",function(data,status){
     console.log(data);
  });
}



function updateProductbyid(id)
{
  console.log('getProdfor Update ' + id);
 var url="products/getProductforUpdate";
        $.ajax({
            url: url+'?id='+id,
            
            success:function(response) {
              //console.log(response);
              $(".show-result-product").html(response);

}
});


}

function deleteUpdate(id)
{

$('#delRec').on('click',function() {
   // var id = $this.val();
console.log('delete '+ id);
$('#deleteModal').modal('hide');

    var urlstr =  'products/deleteProduct';
var url = urlstr.replace("undefined","");
//console.log(url);
    $.ajax({
        url: url+'?id='+id,
        dataType: 'JSON',
        success:function (response) 
        {

                            manageProductTable.ajax.reload(null, false);                  
                            //console.log(response);
                            if(response.success == true) {    
                     manageProductTable.ajax.reload(null, false);                  
                                $("#delete-product-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                  response.messages + 
                                '</div>');

    $('#deleteModal').modal('hide');
                                      
$("#delete-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});             
                                
                                $('.form-group').removeClass('has-error').removeClass('has-success');
                                $('.text-danger').remove(); 
                               // $("#addSalesInvoiceTable:not(:first)").remove();                                
                                //createTypeahead($td.find('input.edititemSearch'));
                                //manageExpeneseTable.ajax.reload(null, false);
                                
                                                                
                            }   
                            else {                                  
                            //  console.response;
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
                    }); // /.ajax
                    return false;
                }); // /.submit edit expenses form

}


</script>


<style type="text/css">
  
</style>


</body>

</html>
