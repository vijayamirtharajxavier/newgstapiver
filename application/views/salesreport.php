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
  <!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
--

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> --
<link href="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.24/datatables.min.css"/>
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui.min.css"> 


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invstyle.css"> 


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

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $page; ?>
              <button style="float: right;" class="pull-right btn btn-primary" href="#"  data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalAddSales" onclick="addSale()"><i class="fa fa-plus"></i> New Sales</button> </h6>
            </div>
            
<div id="delete-sales-message"></div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="saleslistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>ITMES</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist"></tbody>
                </table>

                <!--<div id="sales_list"></div>-->
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



<!--Edit Sales Person Modal -->
<div id="modalSalesperson" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add / Edit Sales Person</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="edit-salesperson-message" class="pull-right"></div>
<div id="edit-error-salesperson-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="editSalesperson" method="POST" id="editSalespersonForm">

<div class="modal-body">
<div class="show-edit-salesperson-result"></div>
<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

  <button type="button" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
</div>
        



<!--Add Modal -->
<div id="modalAddSales" style="width: 1200px; margin-left: 50px;" class="modal fade"  role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Sales Invoice</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="add-sales-message" class="pull-right"></div>
<div id="add-error-sales-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="createSales" method="POST" id="addSalesForm">

<div class="modal-body">

<div id="loader" class="rloader"></div>
<table id="editInvoice" class="table table-bordered">
<tr><td>Inv.#<input type="text" class="form-control" autocomplete="off"  id="invoiceno" name="invoiceno" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="invdate" name="invdate" required></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="orderno" name="orderno"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="orderdate" name="orderdate"></td><td>Sales by<select class="form-control" autocomplete="off" id="salebyperson" name="salebyperson" required>'. $soption .'</select> </td></tr>
<tr><td>DC #<input type="text" class="form-control" autocomplete="off"  id="dcno" name="dcno"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="dcdate" name="dcdate"></td><td>Customer<input type="text" class="form-control customer_name" autocomplete="off"  id="customer_name" name="customer_name" required></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="gstin" name="gstin"  readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="invtype" name="invtype" >'. $invoption .'</select> </td></tr>
</table>


<div class="table-responsive"style="overflow:auto; height:200px;"><table id="InvoiceItems" border="1" ><tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>STOCK</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody></tbody></table></div>




<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  <button type="button" id="addNewRow" class="btn btn-primary">Add Row</button>
<!--  <button type="submit" disabled id="save_btn" class="btn btn-success">Save</button> -->
	<button type="submit" id="save_pbtn"  class="btn btn-success">Save</button>

                </div>
                </form>
            </div>
        </div>
</div>


<!--Edit Modal -->
<div id="modalEditSales" style="width: 1200px; margin-left: 50px;" class="modal fade"  role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sales Invoice</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="edit-sales-message" class="pull-right"></div>
<div id="edit-error-sales-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="editSales" method="POST" id="editSalesForm">

<div class="modal-body">
<div id="loader" class="eloader"></div>
<div class="show-edit-sales-result"></div>

<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  <button type="button" id="addRow" class="btn btn-info">Add Row</button>
  <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
</div>
        


<!--Sales Return Modal -->
<div id="modalEditRSales" style="width: 1000px; margin-left: 20px;" class="modal fade"  role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sales Return</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="edit-rsales-message" class="pull-right"></div>
<div id="edit-error-rsales-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="createRSales" method="POST" id="createRSalesForm">

<div class="modal-body">
<div id="loader" class="eloader"></div>
<div class="show-edit-rsales-result"></div>

<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  <button type="button" id="addRow" class="btn btn-info">Add Row</button>
  <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
</div>
        

  
<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/js/navbar.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url();?>assets/js/bootstrap3-typeahead.min.js"></script>
<script src="<?php base_url(); ?>../assets/js/jquery-ui.min.js"></script>
  
<script src="<?php base_url(); ?>../assets/js/select2.min.js"></script>
<!--<script src="<?php base_url();?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
--<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>-->

 
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.24/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/sales.js"></script>

  

  <!-- Page level custom scripts -->
<!--  <script src="<?php echo base_url();?>assets/js/demo/chart-area-demo.js"></script>
  <script src="<?php echo base_url();?>assets/js/demo/chart-pie-demo.js"></script>
<script src="<?php echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script> -->

<script>




</script>


<style type="text/css">

/*thead th {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 2;
}
*/
#editInvoiceItems thead th {
  background:grey;
  color: white;
  position: sticky;
  top: 0;
}

#InvoiceItems thead th {
  background:grey;
  width: auto;
  color: white;
  position: sticky;
  top: 0;
}


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


    .pagebreak { page-break-before: always;} 
    .bdr {border: none;}
.breakAfter {
    page-break-after: always
}

.ui-autocomplete { height: auto; overflow-y: scroll; overflow-x: hidden;
z-index: 215000000 !important;
}

/*
.ui-autocomplete {
  z-index: 215000000 !important;
}
*/

#loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  top: 50%;
  margin-left: 50%;
  margin-right: 50%;
  bottom: 50%;
  width: 50px;
  height: 50px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


#saleslistTable td{
font-size: 1em;
min-width: 30px;
}


#saleslistTable th{
font-size: 8px;
font-weight: bold;
min-width: 40px;
vertical-align: middle;

}

#saleslistTable td{
        vertical-align: middle;
    }
</style>

</body>

</html>
