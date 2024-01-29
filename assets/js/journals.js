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
var managejournallistTable;
calcnetTotal();
$(document).ready(function(){
getjournallist();

aloader = document.querySelector(".aloader");
aloader.style.display = "none";
eloader = document.querySelector(".eloader");
eloader.style.display = "none";


//Add journal Message

    $("#addjournalForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
aloader.style.display = "block";
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
                if(response.success == true) {                      
                  aloader.style.display = "none";
                        $("#add-journal-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-journal-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addjournalForm").trigger("reset");
managejournallistTable.ajax.reload(null, false);
//$("#InvoiceItems tbody tr").remove(); 
//$("#cname").html("");
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-journal-message").fadeTo(2000, 500).slideUp(500, function(){
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







//Edit journal Messge


    $("#editjournalForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
eloader.style.display = "block";
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
                if(response.success == true) {                      
                  eloader.style.display = "none";
                        $("#edit-journal-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


managejournallistTable.ajax.reload(null, false);  
$("#edit-journal-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


                    }   
                    else {                                  

                        $("#error-journal-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-journal-message").fadeTo(2000, 500).slideUp(500, function(){
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


//Load journal persons dropdown

$("#salebyperson").load('getjournalPerson');


//Load Invoice Type dropdown

$("#invtype").load('getInvoiceType');



$("#salebyperson").on('change',function(){



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


$(document).on('click','.save_rbtn',function(){
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



function getjournallist()
{
  //journal list


 urlstr = 'getalljournallist';
 url = urlstr.replace("undefined","");
//managejournallistTable = $("#journallistTable").dataTable().fnDestroy();
 managejournallistTable =  $('#journallistTable').DataTable( 
  {
    "ajax"    : url, //+ 'fetchjournalSearch',
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


function getjournal()
{
  $.get("getalljournallist",function(data,status){
    console.log(data);
  });

 
  
}

function printTransid(id)
{
  //Pirint
console.log('invprint ' + id);
  //$.get("getInvoiceprintbyid?id="+id,function(data,status){
 //   console.log(data);
var w = window.open("getInvoiceprintbyid?id="+id);

// If the window opened successfully (e.g: not blocked)
if ( w ) {
    w.onload = function() {
        // Do stuff
        console.log('Loadeed successfully');
//        w.print();
//        w.close();
    };
}


//var data = JSON.parse(data);
     /*data.forEach(function(d) {
      $("show-edit-journal-result").appen();
});*/

//$(".show-edit-journal-result").html(data);
/*$("#modalEditjournal").modal({
  backdrop: 'static'
}); *
}); */


}


function deleteTransid(id)
{
console.log('record id for delete ' + id);  

$("#delete_btn").on('click',function(){
ttype='PYMT';
  $.get("deleteTransactionbyid?id="+id+"&trans_type="+ttype,function(data,status){

//console.log(datasuccess);
var d= JSON.parse(data);
//console.log(d);
console.log(d.success);

                if(d.success == true) {                      
                        $("#delete-journal-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          d.messages + 
                        '</div>');

managejournallistTable.ajax.reload(null, false);
  
$("#delete-journal-message").fadeTo(2000, 500).slideUp(500, function(){
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
  $.get("getjournalbyid?id="+id,function(data,status){

$(".show-edit-journal-result").html(data);

});

$("#modalEditjournal").modal({

  backdrop: 'static',
    keyboard: true
});




}



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


$(document).on('click','.remove',function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
});







 // Single Select


$(document).on('keydown','.dbaccount', function() { 
 
console.log('db name search');
$('.dbaccount').autocomplete({
    source: function (request, response) {
        $.getJSON("getcashledgerdatabyname?flag=pyt&itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
          //   console.log(value);
             var nm=value['account_name'];
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
 
console.log('cr name search');
$('.craccount').autocomplete({
    source: function (request, response) {
        $.getJSON("getcashledgerdatabyname?flag=pyt&itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
          //   console.log(value);
             var nm=value['account_name'];
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

