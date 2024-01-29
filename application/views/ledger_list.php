<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $page; ?></title>

  <link href="<?php base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui.min.css"> 

  <!-- Custom styles for this page -->
  <link href="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php base_url();?>assets/css/select2.min.css" rel="stylesheet" type="text/css" />



  <!-- Custom fonts for this template --

  <link href="<?php base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

  <!-- Custom styles for this template --
  <link href="<?php base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page --
  <link href="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php base_url();?>assets/css/select2.min.css" rel="stylesheet" type="text/css" />
-->
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
              <button style="float: right;" class="pull-right btn btn-primary"  data-toggle="modal" data-target="#modalAddLedger"><i class="fa fa-plus"></i> New Ledger</button> </h6>
            </div>
            
<div id="delete-ledger-message"></div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="ledgerTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>LEDGER ACCOUNT</th>
                      <th>GSTIN</th>
                      <th>CONTACT</th>
                      <th>EMAIL</th>
                      <th>STATECODE</th>
                      <th>BUSTYPE</th>
                      <th>GROUP</th>
                      <th>ADDRESS</th>

                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ACTION</th>
                      <th>LEDGER ACCOUNT</th>
                      <th>GSTIN</th>
                      <th>CONTACT</th>
                      <th>EMAIL</th>
                      <th>STATECODE</th>
                      <th>BUSTYPE</th>
                      <th>GROUP</th>
                      <th>ADDRESS</th>
                      
                    </tr>
                  </tfoot>
                  <tbody>

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




<!--Edit Modal -->
    <div id="modalEditLedger" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ledger Account</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="edit-ledger-message" class="pull-right"></div>
<div id="edit-error-ledger-message" class="pull-right"></div>


        <!-- Form -->
<form class="text-center" style="color: #757575;" action="ledgers/editLedger" method="POST" id="editLedgerForm">

 <div class="modal-body">

                    <!--<p>Add the <code>.modal-xl</code> class on <code>.modal-dialog</code> to create this extra large modal.</p> -->
<div class="show-result-ledger"></div>
<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
        

<!--Add Modal -->
    <div id="modalAddLedger" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Ledger Account</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="add-ledger-message" class="pull-right"></div>
<div id="error-ledger-message" class="pull-right"></div>


        <!-- Form -->
        <form class="text-center" style="color: #757575;" action="ledgers/addLedger" method="POST" id="addLedgerForm">

                <div class="modal-body">

<!-- Material form register -->
<div class="card">


    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">


            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <label for="ledgername">LEDGER ACCOUNT NAME</label>
                         <input oninput="this.value = this.value.toUpperCase()" type="text" id="ledgername" name="ledgername" class="form-control ledgername" autocomplete="off" required>

                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgergstin">GSTIN NUMBER</label>
                        <input type="text" oninput="this.value = this.value.toUpperCase()"  id="ledgergstin" name="ledgergstin" class="form-control" autocomplete="off">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgeraddress">ADDRESS</label>
                        <input type="text" autocapitalize="word"  id="ledgeraddress" autocomplete="off" name="ledgeraddress" class="form-control">
                        
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgergroup">GROUP</label><br>
                        <select id="ledgergroup" class="form-control" name="ledgergroup">
                          
                        </select>
                        
                    </div>
                </div>


            </div>


            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <label for="ledgercity">CITY</label>
                        <input type="text" id="ledgercity" oninput="this.value = this.value.toUpperCase()"   style="text-align: right;" autocomplete="off" name="ledgercity" class="form-control">
                        
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgerstate">STATE</label><br>
                        <select id="ledgerstate" oninput="this.value = this.value.toUpperCase()"  style="width: 250px; height: 20px;" name="ledgerstate">
                          
                        </select>
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgercontact">CONTACT#</label>
                        <input type="text"  style="text-align: right;"  id="ledgercontact" autocomplete="off"   name="ledgercontact" oninput="this.value = this.value.toUpperCase()"  class="form-control">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgeremail">EMAIL</label>
                        <input type="email" id="ledgeremail" name="ledgeremail"  style="text-align: right;"  autocomplete="off" class="form-control">
                        
                    </div>
                </div>

            </div>

            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <label for="ledgerbustype">BUSINESS TYPE</label>
                        <select class="form-control" id="bus_type" name="bus_type">
                          <option value="0">Regular</option>
                          <option value="1">Store</option>
                         </select>
                        
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgerpan">PAN#</label>
                        <input type="text" id="ledgerpan" oninput="this.value = this.value.toUpperCase()"  autocomplete="off" name="ledgerpan" class="form-control">
                        
                    </div>
                </div>

                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <label for="ledgeropenbal">OPENING BALANCE</label>
                        <input style="text-align: right;" type="text" id="ledgeropenbal" name="ledgeropenbal" autocomplete="off" value="0.00" class="form-control">
                        
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
<script src="<?php echo base_url();?>assets/js/navbar.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php base_url();?>assets/js/sb-admin-2.min.js"></script>
<script src="<?php base_url(); ?>assets/js/jquery-ui.min.js"></script>
  
<script src="<?php base_url(); ?>assets/js/select2.min.js"></script>


  <!-- Page level plugins -->
  <script src="<?php base_url();?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php base_url();?>assets/js/demo/datatables-demo.js"></script>

<script src="<?php echo base_url();?>assets/js/ledger.js"></script>








<script>



</script>


<style type="text/css">

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



.ui-autocomplete { height: auto; overflow-y: scroll; overflow-x: hidden;
z-index: 215000000 !important;
}

/*
.ui-autocomplete {
  z-index: 215000000 !important;
}
*/



</style>


<style>
body {
  font-family: 'Varela Round', sans-serif;
}
.modal-confirm {    
  color: #636363;
  width: 400px;
}
.modal-confirm .modal-content {
  padding: 20px;
  border-radius: 5px;
  border: none;
  text-align: center;
  font-size: 14px;
}
.modal-confirm .modal-header {
  border-bottom: none;   
  position: relative;
}
.modal-confirm h4 {
  text-align: center;
  font-size: 26px;
  margin: 30px 0 -10px;
}
.modal-confirm .close {
  position: absolute;
  top: -5px;
  right: -2px;
}
.modal-confirm .modal-body {
  color: #999;
}
.modal-confirm .modal-footer {
  border: none;
  text-align: center;   
  border-radius: 5px;
  font-size: 13px;
  padding: 10px 15px 25px;
}
.modal-confirm .modal-footer a {
  color: #999;
}   
.modal-confirm .icon-box {
  width: 80px;
  height: 80px;
  margin: 0 auto;
  border-radius: 50%;
  z-index: 9;
  text-align: center;
  border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
  color: #f15e5e;
  font-size: 46px;
  display: inline-block;
  margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
  color: #fff;
  border-radius: 4px;
  background: #60c7c1;
  text-decoration: none;
  transition: all 0.4s;
  line-height: normal;
  min-width: 120px;
  border: none;
  min-height: 40px;
  border-radius: 3px;
  margin: 0 5px;
}
.modal-confirm .btn-secondary {
  background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
  background: #a8a8a8;
}
.modal-confirm .btn-danger {
  background: #f15e5e;
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
  background: #ee3535;
}
.trigger-btn {
  display: inline-block;
  margin: 100px auto;
}
</style>



</body>

</html>
