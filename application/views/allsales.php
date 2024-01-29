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
                <div class="inline-group" style="float: right;">Account <select id="ldgacc" name="ldgacc" style="width: 15em;height: 2em"><option value="SALE">Sales Register</option><option value="PURC">Purchase Register</option></select> From <input  style="width:10em;height: 1.5em;" type="date" name="fromDate" id="fromDate" >&nbsp; To <input type="date" name="toDate" id="toDate" style="width:10em;height: 1.5em">
              &nbsp;&nbsp;<button style="float: right;" class="pull-right btn btn-primary" id="spsearch_btn" href="#" ><i class="fa fa-submit"></i> Search</button></div>
            <!--
              <button style="float: right;" class="pull-right btn btn-primary" href="#"  data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalAddSales" onclick="addSale()"><i class="fa fa-plus"></i> New Sales</button> -->
              </h6>
            </div>
            
<div id="delete-sales-message"></div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="saleslistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th></th>
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
<script src="<?php echo base_url();?>assets/js/spregister.js"></script>

   
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>


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
