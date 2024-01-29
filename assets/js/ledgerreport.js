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
var manageledgerlistTable;

$(document).ready(function(){

$("#ldgacc").load('getledgerdata');

$("#ldgacc").select2();

//getledgerlist();

$("#search_btn").on('click',function() {
console.log("search btn clicked");
var actid=$("#ldgacc").val();
var fdate=$("#fromDate").val();
var tdate=$("#toDate").val();

var url='getledgerlist';

manageledgerlistTable =  $('#ledgerlistTable').DataTable( 
  {
    "ajax"    : url+'?acctid='+actid+'&fdate='+fdate+'&tdate='+tdate, //+ 'fetchledgerSearch',
    "destroy":true, 
    "sort":false,
       "language": {
       "infoEmpty": "No records available - Got it?",
                   "emptyPanes": 'There are no panes to display. :/'
    },

  /*      startRender: function(rows, group) {
                return $('<tr class="group group-start"><td class="' + (group == '1' ? 'bg-success' : (group == '0' ? 'bg-danger' : 'bg-dark')) + '" colspan="5">' + group + '</td></tr>');
            },
*/
      rowGroup: {
           dataSrc: 'op_balance'
      },

"columns": [
            { "data": "op_balance" },
            { "data": "trans_id" },
            { "data": "trans_date" },
            { "data": "trans_ref" },
            { "data": "trans_type" },
            { "data": "particulars" },
            { "data": "db_amount",  render: $.fn.dataTable.render.number(',', '.', 2, '')  },
            { "data": "cr_amount" ,  render: $.fn.dataTable.render.number(',', '.', 2, '')  },
            { "data": "cl_balance" ,  render: $.fn.dataTable.render.number(',', '.', 2, '')  }
            
            
//            { "data": "narration" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "10%"
 },
 {
      "targets": [6,7,8],
      "className": "text-right"
 },
  {
      "targets": 0, // your case first column
      "visible": false,
      "className": "bolded",
      "width": "300"
 },


 ]


}); 
 



});



//Add ledger Message

    $("#addledgerForm").unbind('submit').bind('submit', function() {
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
                        $("#add-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addledgerForm").trigger("reset");
manageledgerlistTable.ajax.reload(null, false);
//$("#InvoiceItems tbody tr").remove(); 
//$("#cname").html("");
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
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





//Edit ledger Messge


    $("#editledgerForm").unbind('submit').bind('submit', function() {
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
                        $("#edit-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


manageledgerlistTable.ajax.reload(null, false);  
$("#edit-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


                    }   
                    else {                                  

                        $("#error-ledger-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
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


//Load ledger persons dropdown




}); //Document Ready






function getledgerlist()
{
  //ledger list


 urlstr = 'getallledgerlist';
 url = urlstr.replace("undefined","");
//manageledgerlistTable = $("#ledgerlistTable").dataTable().fnDestroy();
 manageledgerlistTable =  $('#ledgerlistTable').DataTable( 
  {
    "ajax"    : url, //+ 'fetchledgerSearch',
    "destroy":true, 
"columns": [
            { "data": "action" },
            { "data": "trans_id" },
            { "data": "trans_date" },
            { "data": "db_name" },
            { "data": "cr_name" },
            { "data": "trans_amount" },
            { "data": "trans_ref" },
            { "data": "narration" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
 {
      "targets": 5,
      "className": "text-right"
 },

 ]


}); 
    
   



}


function getledger()
{
  $.get("getallledgerlist",function(data,status){
    console.log(data);
  });

 
  
}


function deleteTransid(id)
{
console.log('record id for delete ' + id);  

$("#delete_btn").on('click',function(){
ttype='CNTR';
  $.get("deleteTransactionbyid?id="+id+"&trans_type="+ttype,function(data,status){

//console.log(datasuccess);
var d= JSON.parse(data);
//console.log(d);
console.log(d.success);

                if(d.success == true) {                      
                        $("#delete-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          d.messages + 
                        '</div>');

manageledgerlistTable.ajax.reload(null, false);
  
$("#delete-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});

$("#deleteModal").modal('hide');

}

});

});



}



function updateTransid(id)
{
console.log('record id for update ' + id);
  $.get("getledgerbyid?id="+id,function(data,status){

$(".show-edit-ledger-result").html(data);

});

$("#modalEditledger").modal({

  backdrop: 'static',
    keyboard: true
});




}








 // Single Select


$(document).on('keydown','.dbaccount', function() { 
 
console.log('cust name search');
$('.dbaccount').autocomplete({
    source: function (request, response) {
        $.getJSON("getcashledgerdatabyname?itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
          //   console.log(value);
             var nm=value['name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    },

      /*select: function(e,ui) {

$.getJSON("getledgerdatabysearch?itemkeyword=" + ui.item.value, function (data, status) {
//console.log(data);
          $.map(data, function (value, key) {

$("#gstin").val(value['gstin']);

var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".itemname").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0)
{
document.getElementById("save_rbtn").disabled = false; 
$('#save_rbtn').removeClass('btn-default').addClass('btn-success');
}
else {
document.getElementById("save_rbtn").disabled = true; 
$('#save_rbtn').removeClass('btn-success').addClass('btn-default');
}


});

});              
//        console.log(data);
        //output selected dataItem
        },*/
//    minLength: 2,
    autoFocus: true,
    delay: 100
});



});



$(document).on('keydown','.craccount', function() { 
 
console.log('cust name search');
$('.craccount').autocomplete({
    source: function (request, response) {
        $.getJSON("getcashledgerdatabyname?itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
          //   console.log(value);
             var nm=value['name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    },

      /*select: function(e,ui) {

$.getJSON("getledgerdatabysearch?itemkeyword=" + ui.item.value, function (data, status) {
//console.log(data);
          $.map(data, function (value, key) {

$("#gstin").val(value['gstin']);

var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".itemname").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0)
{
document.getElementById("save_rbtn").disabled = false; 
$('#save_rbtn').removeClass('btn-default').addClass('btn-success');
}
else {
document.getElementById("save_rbtn").disabled = true; 
$('#save_rbtn').removeClass('btn-success').addClass('btn-default');
}


});

});              
//        console.log(data);
        //output selected dataItem
        },*/
//    minLength: 2,
    autoFocus: true,
    delay: 100
});



});



