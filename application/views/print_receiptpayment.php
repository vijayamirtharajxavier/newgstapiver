<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
	<?php if($trans_type=="RCPT") { ?>
    <title>Receipt</title>
	<?php } ?>
	<?php if($trans_type=="PYMT") { ?>
    <title>Payment</title>
	<?php } ?>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

	<title><?php echo $this->session->userdata('cname'); ?> | <?php echo $this->session->userdata('city'); ?></title>

<!-- Custom fonts for this template-->
<link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
-->

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> 

<!-- Custom styles for this template-->
<link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui.min.css"> 


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invstyle.css"> 



</head>
<body>
<div class="page_wrap" style="padding:20px;">
<div style="margin-left:10px;margin-right:10px;">

<!--<div style="float:center;"><h1 style="text-align:center;font-size:18px;font-weight:bold;margin-bottom:10px;">ATK ENTERPRISES</h1><p  style="text-align:center;font-size:11px;margin-top:-10px;">1/54 GAJAPATHY STREET | SHENOY NAGAR | CHENNAI 600 030</p><p style="text-align:center;font-size:10px;margin-top:-10px;">Phone :+91-9841010067 | E-mail :atkenterprises2019@gmail.com</p><p style="text-align:center;font-size:18px;font-weight:bold;margin-top:-10px;">GSTIN : 33ABQFA4136J1ZD</p></div> -->
<div style="text-align:center"><strong><h1><?php echo $comp_name; ?></h1></strong></div>
<div style="text-align:center"><strong><h5><?php echo $comp_address; ?></h5></strong></div>
<div style="text-align:center"><strong><h5><?php echo $comp_contact; ?>&nbsp; | &nbsp;<?php echo $comp_email; ?> </h5></strong></div>
<div style="text-align:center"><strong><h3><?php echo $comp_gstin; ?></h3></strong></div>

<div style="margin-bottom:50px;">
<?php if($trans_type=="RCPT") { ?>
<div style="float:left;"><strong>RECEIPT VOUCHER</strong></div>
<?php } ?>
<?php if($trans_type=="PYMT") { ?>
<div style="float:left;"><strong>PAYMENT VOUCHER</strong></div>
<?php } ?>


<?php if($cb_code=="1") { ?>
<div style="float:right;padding:5px;margin-top:-10px;"><input checked type="checkbox" id="cash" name="cash">Cash&nbsp;&nbsp;<input type="checkbox" id="bank" name="bank">Bank </div>
<?php } ?>
<?php if($cb_code=="2") { ?>
<div style="float:right;padding:5px;margin-top:-10px;"><input type="checkbox" id="cash" name="cash">Cash&nbsp;&nbsp;<input  checked type="checkbox" id="bank" name="bank">Bank </div>
<?php } ?>
</div>
</div>
	<table class="table" width="100%" style="border-collapse:none;">
		<tr>
		<td style="border:none;" colspan="6">Voucher# : &nbsp;<?php echo $receiptno;?></td>
		<td colspan="6" style="border:none;text-align:right;">Voucher Date : &nbsp;<?php echo date("d-m-Y", strtotime($trans_date));?></td>
		</tr>
		<tr>
		<?php if($trans_type=="RCPT") { ?>
		<td style="border:none;float:left;"  colspan="12"><div>Received from Mr./M/s. :&nbsp;<span width="600px;" style="border:solid 2px;border-top:none;border-left:none;border-right:none;"><?php echo $acct_name;?></span></div></td>
		<?php } ?>
		<?php if($trans_type=="PYMT") { ?>
		<td style="border:none;float:left;"  colspan="12"><div>Paid to Mr./M/s. :&nbsp;<span width="600px;" style="border:solid 2px;border-top:none;border-left:none;border-right:none;"><?php echo $acct_name;?></span></div></td>
		<?php } ?>

	</tr>
		<tr>
		<td style="border:none;"  colspan="12">Rupees (in words) : &nbsp;<?php echo $rswords;?></td>
		</tr>
		<tr>
		<td style="border:none;"  colspan="12">Referece : &nbsp;<?php echo $trans_ref;?></td>
		</tr>
		<tr>
		<td style="border:none;"  colspan="12">Towards : &nbsp;<?php echo $trans_narration;?></td>
		</tr>
	<tr></tr>
	<tr><td colspan="12" style="border:none;"></td></tr>

	<tr>

		<td colspan="2" style="text-align:right;border:solid 1px;">Rs.<?php echo $trans_amt;?>/-</td>
		</tr>
<tr>
<td colspan="8" style="text-align:right;border-left:none;border-bottom:none;border-right:none;">Prepared by</td>
		<td colspan="4" style="text-align:right;border-bottom:none;border-right:none;border-left:none;">Received by</td>

</tr>
	</table>
</div>
</div>
</div>
</div>
</div>


<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url();?>assets/js/bootstrap3-typeahead.min.js"></script>
<script src="<?php base_url(); ?>../assets/js/jquery-ui.min.js"></script>
  
<script src="<?php base_url(); ?>../assets/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url();?>assets/js/receipts.js"></script>
<script src="<?php echo base_url();?>assets/js/navbar.js"></script>

</body>
</html>
