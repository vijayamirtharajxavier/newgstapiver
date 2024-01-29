var manageLedgerTable;
var manageLedgerOpBal;
let table, names;


$(document).ready(function(){

	var opbalurl = 'getopenbal';
	url = opbalurl.replace("undefined","");
	
	
	manageledgeropTable = $('#ledgeropTable').DataTable({
	"destroy":true,
	"paging":   false,
	"ajax": url,
	"order":false,
	"columns": [
				{ "data": "account_name" },
		//        {"data": "id"},
				{ "data": "open_bal" },
				{"data":"action"}
	],
	
	"columnDefs": [
	  {
		  "targets": 0, // your case first column
		  "className": "text-left",
		  "width": "100px"
	 },
	  
	  {
		  "targets": 1, // your case first column
		  "className": "text-right",
		  "visible":true,
		  "width": "15px"
	 },
	  {
		  "targets": 2, // your case first column
		  "className": "text-center",
		  "width":"20px"
	
		  
	 }
	 ]
	});
	

	$("#opadd_btn").on('click',function(){
		console.log('add btn clicked');
		var acct_name = $("#account_name").val();
		var acct_id= $("#acct_id").val();
		var opbal_amt= $("#openbal_amt").val();
		console.log('Record ' + acct_name + acct_id + ' amt : ' + opbal_amt);
		var tbl="";
		//array("ldger_id"=>$ldg_id,"open_bal"=>$opbal_amt,"finyear"=>$finyear,"company_id"=>$compId);
		
		$.ajax({
			url: 'post_OpBal',
			data: {'acct_id':acct_id, 'opbal_amt':opbal_amt}, 
			success: function(result) {
			//	  alert('SUCCESS');
		
		
		
		
			}
			});
		manageledgeropTable.ajax.reload(null, false);
		
		$("#account_name").val("");
		$("#openbal_amt").val("");
		$("#account_name").focus();
		
		});
		
		
		
		
		$('.account_name').autocomplete({
				source: function (request, response) {
						$.getJSON("getledgerdatabyname?flag=ldg&itemkeyword=" + request.term, function (data) {
		//console.log(data);
								response($.map(data, function (value, key) {
								 
								 var nm=value['account_name'];
										return {
												 label:nm
												 //value:key
												//value: key
										};
								}));
						});
				},
					select: function(e,ui) {
		
		$.getJSON("getledgerdatabysearch?itemkeyword=" + ui.item.value, function (data, status) {
		//console.log(data);
							$.map(data, function (value, key) {
		//$("#gstin").val(data.gstin);
		$("#acct_id").val(data[0].id);
		$("#openbal_amt").focus();
		
		// console.log(data[0].id);
		});
		
		});              
						},
		//    minLength: 2,
				autoFocus: true,
				delay: 100
		});
		
		
		

		$("#updateOpBalForm").unbind('submit').bind('submit', function() {
			var form = $(this);
			var url = form.attr('action');
			var type = form.attr('method');
		rloader = document.querySelector(".rloader");        
		rloader.style.display = "block";
			$.ajax({
					url: url,
					type: type,
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						console.log(response);
							if(response.success == true) { 
							rloader.style.display = "none";                     
											$("#add-sales-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
												'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
												response.messages + 
											'</div>');
		
		
		
		$("#add-sales-message").fadeTo(2000, 500).slideUp(500, function(){
		$("#success-alert").slideUp(500);
		
		});
		
		
		$("#updateOpBalForm").trigger("reset");
		manageledgeropTable.ajax.reload(null, false);
		//$("#InvoiceItems tbody tr").remove(); 
		$("#cname").html("");
									}   
									else {                                  
		
											$("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
												'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
												response.messages + 
											'</div>');
		
		
		$("#error-sales-message").fadeTo(2000, 500).slideUp(500, function(){
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
		
		






   
   }); //Document.ready


//Functions

function deleteOpbal(id)
{
	console.log('delete by id ' + id);
	$.ajax({
		url: 'deleteOpBalbyid?id=' +id,
//		data: {'acct_id':id}, 
		success: function(result) {
console.log(result);

		//	  alert('Record Deleted Successfully....!!!');
	
			  manageledgeropTable.ajax.reload(null, false);

	
	
		}
	  });
	
}
