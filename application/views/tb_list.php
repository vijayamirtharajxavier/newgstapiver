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
            <!--data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalAddSales"-->
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $page; ?>
  <button style="float: right;" class="pull-right btn btn-primary" href="#"   onclick="printTb();"><i class="fa fa-print"></i> </button>  </h6>
            </div>
            
<div id="delete-sales-message"></div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered dt-responsive nowrap" id="tbTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Group</th>
                      <th style="width: 20px;">Account Name</th>
                      <th style="width: 20px;">Debit</th>
                      <th style="width: 20px;">Credit</th>

                    </tr>
                  </thead>
                  <tbody></tbody>
     <tfoot>
      <tr>
       <th colspan="2">Total</th>
       <th id="total_debit"></th>
       <th id="total_credit"></th>
      </tr>
     </tfoot>                  
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

  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

</div>
</div>



<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
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
<script src="<?php echo base_url();?>assets/js/tb.js"></script>
<script src="<?php echo base_url();?>assets/js/datatablesum.js"></script>

  

<style type="text/css">
.group{
  background-color: #1d2c57;
  color: white;
  font-weight: bold;
}

table thead th {
  background-color: #3da6e3;
  color: #fff;
}

table tfoot th {
  background-color: #969799;
  color: #ffffff;
  font-weight: bold;
}

</style>

</body>

</html>
