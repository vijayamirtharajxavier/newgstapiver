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
var managecashbanklistTable;
let acname;
$(document).ready(function(){

$("#ldgacc").load('getcashbankledgerdata');

$("#ldgacc").on('change',function(){
 acname = $("#ldgacc option:selected").text();
});


$("#printCB").on('click',function() {
var actid=$("#ldgacc").val();
var fdate=$("#fromDate").val();
var tdate=$("#toDate").val();

let url = 'printCashBank';
// If the window opened successfully (e.g: not blocked)
var w = window.open(url+'?acctid='+actid+'&fdate='+fdate+'&tdate='+tdate+'&acname='+acname);
if ( w ) {
    w.onload = function() {
        // Do stuff
        console.log('Loadeed successfully');
//        w.print();
//        w.close();
    };
}



});


//getcashbanklist();

$("#search_btn").on('click',function() {
console.log("search btn clicked");
var actid=$("#ldgacc").val();
var fdate=$("#fromDate").val();
var tdate=$("#toDate").val();

var url='getcashbanklist';

managecashbanklistTable =  $('#cashbanklistTable').DataTable( 
  {
    "ajax"    : url+'?acctid='+actid+'&fdate='+fdate+'&tdate='+tdate, //+ 'fetchcashbankSearch',
    "destroy":true,
    "sort":false,
       rowGroup: {
           dataSrc: 'op_balance'
      },
   
"columns": [
            { "data": "op_balance" },
            { "data": "trans_id" },
            { "data": "trans_date" },
            { "data": "trans_ref" },
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
      "width": "20%"
 },
 {
      "targets": [5,6,7],
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



//Add cashbank Message

    $("#addcashbankForm").unbind('submit').bind('submit', function() {
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
                        $("#add-cashbank-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-cashbank-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addcashbankForm").trigger("reset");
managecashbanklistTable.ajax.reload(null, false);
//$("#InvoiceItems tbody tr").remove(); 
//$("#cname").html("");
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-cashbank-message").fadeTo(2000, 500).slideUp(500, function(){
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





//Edit cashbank Messge


    $("#editcashbankForm").unbind('submit').bind('submit', function() {
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
                        $("#edit-cashbank-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


managecashbanklistTable.ajax.reload(null, false);  
$("#edit-cashbank-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


                    }   
                    else {                                  

                        $("#error-cashbank-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-cashbank-message").fadeTo(2000, 500).slideUp(500, function(){
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


//Load cashbank persons dropdown




}); //Document Ready






function getcashbanklist()
{
  //cashbank list


 urlstr = 'getallcashbanklist';
 url = urlstr.replace("undefined","");
//managecashbanklistTable = $("#cashbanklistTable").dataTable().fnDestroy();
 managecashbanklistTable =  $('#cashbanklistTable').DataTable( 
  {
    "ajax"    : url, //+ 'fetchcashbankSearch',
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


function getcashbank()
{
  $.get("getallcashbanklist",function(data,status){
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
                        $("#delete-cashbank-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          d.messages + 
                        '</div>');

managecashbanklistTable.ajax.reload(null, false);
  
$("#delete-cashbank-message").fadeTo(2000, 500).slideUp(500, function(){
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
  $.get("getcashbankbyid?id="+id,function(data,status){

$(".show-edit-cashbank-result").html(data);

});

$("#modalEditcashbank").modal({

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



