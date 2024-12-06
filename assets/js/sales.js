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
var managesaleslistTable;
let managersaleslistTable;
calcnetTotal();
$(document).ready(function(){
getSaleslist();
getRSaleslist();
//$('#saleslistTable').DataTable();
var url="getSalesPerson";
//$('#salebyperson').load(url);
//$("#show-edit-sales-result").find("#salesperson_name").load(url);
//$("#show-edit-sales-result").find("#salesperson_name").select2();

rloader = document.querySelector(".rloader");
rloader.style.display = "none";
eloader = document.querySelector(".eloader");
eloader.style.display = "none";
var url ="getInvLedgerAccount";
//$("#customer_name").load(url);
//$("#customerr_name").select2();

/*$("#customer_name").on('change',function(){
console.log('on chage');

var id = $(this).val();
console.log(id);
var furl ="getvendordata?id="+id;

       $.getJSON(furl, function(data) {
        console.log(data);
        $("#gstin").val(data.gstin);
        $("#vname").html(data.name);
        $("#statecode").val(data.statecode);
     //             console.log('AcName' + data.name );
      //            console.log('AcName' + data.statecode );


                  //$('#stage').append('<p>Age : ' + jd.age+ '</p>');
                 // $('#stage').append('<p> Sex: ' + jd.sex+ '</p>');
               });
});

*/

//Add Sales Message

    $("#addSalesForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
//rloader = document.querySelector(".rloader");        
//rloader.style.display = "block";
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
                if(response.success == true) { 
									alert('record saved successfully ....!')
//                rloader.style.display = "none";                     
                        $("#add-sales-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-sales-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addSalesForm").trigger("reset");
managesaleslistTable.ajax.reload(null, false);
$("#InvoiceItems tbody tr").remove(); 
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




//Add Sales Return Message

    $("#createRSalesForm").unbind('submit').bind('submit', function() {
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
                        $("#add-rsales-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-rsales-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#createRSalesForm").trigger("reset");
managersaleslistTable.ajax.reload(null, false);
//$("#InvoiceItems tbody tr").remove(); 
//$("#cname").html("");
                    }   
                    else {                                  

                        $("#error-rsales-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-rsales-message").fadeTo(2000, 500).slideUp(500, function(){
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


/*
$("#save_btn").on('click',function(){
   document.getElementById("save_btn").disabled = true; 
   $('#save_btn').removeClass('btn-success').addClass('btn-default');

});
*/



//Edit Sales Messge


    $("#editSalesForm").unbind('submit').bind('submit', function() {
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
                        $("#edit-sales-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


managesaleslistTable.ajax.reload(null, false);  
$("#edit-sales-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


                    }   
                    else {                                  

                        $("#error-sales-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
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









//Load Sales persons dropdown

$("#salebyperson").load('getSalesPerson');


//Load Invoice Type dropdown

$("#invtype").load('getInvoiceType');



$("#salebyperson").on('change',function(){


var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".customer_name").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0){

 document.getElementById("save_btn").disabled = false; 
$('#save_btn').removeClass('btn-default').addClass('btn-success');
}
else {
   document.getElementById("save_btn").disabled = true; 
   $('#save_btn').removeClass('btn-success').addClass('btn-default');
}


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

//netval = Math.round(Number(txbval+gst_amt));

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

// netval = Math.round(Number(txbval+gst_amt));
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
 //netval = Math.round(Number(txbval+gst_amt));

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


$(document).on('click','.save_btn',function(){
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



function getSaleslist()
{
  //Sales list
 urlstr = 'getallSaleslist';
 url = urlstr.replace("undefined","");
//managesaleslistTable = $("#saleslistTable").dataTable().fnDestroy();
 managesaleslistTable =  $('#saleslistTable').DataTable( 
  {
    "ajax"    : url, //+ 'fetchReceiptSearch',
    "destroy":true,
    "sort":false,
    "createdRow": function( row, data, dataIndex ) {
      if ( data[3] == "SALES ACCOUNT" ) {        
  $(row).addClass('red');

}


},
            "columns": [
            { "data": "action" },
            { "data": "trans_id" },
            { "data": "trans_date" },
            { "data": "custname" },
            { "data": "gstin" },
            { "data": "noi" },
            { "data": "taxable_amount",  render: $.fn.dataTable.render.number(',', '.', 2, '') },
            { "data": "gst_tot",  render: $.fn.dataTable.render.number(',', '.', 2, '') },
            { "data": "net_amount",  render: $.fn.dataTable.render.number(',', '.', 2, '') }
        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
 {
      "targets": 5,
      "className": "text-center"
 },
 {
      "targets": [6,7,8],
      "className": "text-right"
 },

 ]


}); 
    
}



function getRSaleslist()
{
  //Sales list


 urlstr = 'getallRSaleslist';
 url = urlstr.replace("undefined","");
//managesaleslistTable = $("#saleslistTable").dataTable().fnDestroy();
 managersaleslistTable =  $('#rsaleslistTable').DataTable( 
  {
    "ajax"    : url, //+ 'fetchReceiptSearch',
    "destroy":true, 
"columns": [
            { "data": "action" },
            { "data": "cn_id"},
            { "data": "cn_date"},
            { "data": "trans_id" },
            { "data": "trans_date" },
            { "data": "custname" },
            { "data": "gstin" },
            { "data": "noi" },
            { "data": "taxable_amount",  render: $.fn.dataTable.render.number(',', '.', 2, '') },
            { "data": "gst_tot",  render: $.fn.dataTable.render.number(',', '.', 2, '') },
            { "data": "net_amount",  render: $.fn.dataTable.render.number(',', '.', 2, '') }
        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
 {
      "targets": 7,
      "className": "text-center"
 },
 {
      "targets": [8,9,10],
      "className": "text-right"
 },

 ]


}); 
    
   



}



function getSales()
{
  $.get("getallSaleslist",function(data,status){
    console.log(data);
    //console.log(JSON.parse(data));
/*var data = JSON.parse(data);
     data.forEach(function(d) {
var taxable_tot = Number(d.taxable_amount);
var net_tot = Number(d.net_amount);
var gst_tot = Number(net_tot-taxable_tot);
*/
      //$("#sales_list").html(data);
     
     //});

//$("#saleslist").dataTable();
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
      $("show-edit-sales-result").appen();
});*/

//$(".show-edit-sales-result").html(data);
/*$("#modalEditSales").modal({
  backdrop: 'static'
}); *
}); */


}


function updateTransid(id)
{
eloader.style.display = "block";

var flg="sl";
console.log('record id for update ' + id);
  $.get("getSalesbyid?id="+id+"&flag="+flg,function(data,status){
 //   console.log(data);
//var data = JSON.parse(data);
     /*data.forEach(function(d) {
      $("show-edit-sales-result").appen();
});*/
eloader.style.display = "none";
$(".show-edit-sales-result").html(data);


});



$("#modalEditSales").modal({

  backdrop: 'static',
    keyboard: true
});



}



function sreturnTransid(id)
{
//eloader.style.display = "block";

var flg = "sr";
console.log('record id for update ' + id);
  $.get("getSalesbyid?id="+id+"&flag="+flg,function(data,status){
 //   console.log(data);
//var data = JSON.parse(data);
     /*data.forEach(function(d) {
      $("show-edit-sales-result").appen();
});*/
//eloader.style.display = "none";
$(".show-edit-rsales-result").html(data);


});



$("#modalEditRSales").modal({

  backdrop: 'static',
    keyboard: true
});



}


function addSale()
{

  $.get("getSettings",function(data,status){
    console.log(data);
 $("#invoiceno").val(data);
});

var url="getSalesPerson";
$('#salebyperson').load(url);


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
    //netvalue = Math.round(Number($(this).val()));
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



// Add New Row for New Sales 

$(document).on('click','#addNewRow', function(){
console.log('AddNewRow Clicked');

var tbl="";
x = document.getElementById("InvoiceItems").rows.length-1;
console.log("X " +x);   
count=Number(x);
cnt=cnt+1;

$('#ticount').html(x);
//console.log(x);

tbl ='<tr data-row="row'+count+'" class="trrow" id="row' + count + '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname' + count + '" name="itemname[]" required></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc' + count + '" name="itemdesc[]" ></td><td><input type="text" class="form-control itemhsnsac" autocomplete="off" id="hsnsac' + count + '" name="hsnsac[]" ></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc' + count + '" name="itemgstpc[]"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit' + count +'" name="itemunit[]">';

  

tbl +='</select></td><td><input type="text"  style="text-align:right;"  class="form-control stock" autocomplete="off" id="stock' + count + '" name="stock[]" readonly ></td><td><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty' + count + '" name="itemqty[]" required ></td><td><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate' + count + '" name="itemrate[]" ></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc' + count + '" value="0.00" name="itemdispc[]" ></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt' + count + '" name="itemamt[]" ></td><td><input type="text"  class="form-control itemnet"  style="text-align:right" autocomplete="off" id="itemnet' + count + '" name="itemnet[]"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'+count+'" ><i class="fa fa-times"></i></button></td></tr>';

  var $td = $(tbl);
    //$("#addProdTable tbody tr:last").after($td);
    //createCustTypeahead($('input.customerSearch'));

$("#InvoiceItems").prepend($td);
//$(".itemname").focus();

curr_row = $(".trrow").data("row");
$('#'+curr_row).find(".itemname").focus();
console.log(curr_row);

var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".customer_name").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0){

 document.getElementById("save_btn").disabled = false; 
$('#save_btn').removeClass('btn-default').addClass('btn-success');
}
else {
   document.getElementById("save_btn").disabled = true; 
   $('#save_btn').removeClass('btn-success').addClass('btn-default');
}




  });





//Add New Row for Edit Sales
$(document).on('click','#addRow', function(){
console.log('AddRow Clicked');

var tbl="";
x = document.getElementById("editInvoiceItems").rows.length-1;
console.log("X " +x);   
count=Number(x);
cnt=cnt+1;

$('#ticount').html(x);
//console.log(x);

tbl ='<tr data-row="row'+count+'" class="trrow" id="row' + count + '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname' + count + '" name="itemname[]"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc' + count + '" name="itemdesc[]" ></td><td><input type="text" class="form-control itemhsnsac" autocomplete="off" id="hsnsac' + count + '" name="hsnsac[]" ></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc' + count + '" name="itemgstpc[]"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit' + count +'" name="itemunit[]">';

  

tbl +='</select></td><td><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty' + count + '" name="itemqty[]" ></td><td><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate' + count + '" name="itemrate[]" ></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc' + count + '" value="0.00" name="itemdispc[]" ></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt' + count + '" name="itemamt[]" ></td><td><input type="text"  class="form-control itemnet"  style="text-align:right" autocomplete="off" id="itemnet' + count + '" name="itemnet[]"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'+count+'" ><i class="fa fa-times"></i></button></td></tr>';

  var $td = $(tbl);
    //$("#addProdTable tbody tr:last").after($td);
    //createCustTypeahead($('input.customerSearch'));

$("#editInvoiceItems").prepend($td);
//$(".itemname").focus();

curr_row = $(".trrow").data("row");
$('#'+curr_row).find(".itemname").focus();
console.log(curr_row);

  });

 // Single Select
$(document).on('keydown','.itemname', function() { 
 

$('.itemname').autocomplete({
    source: function (request, response) {
        $.getJSON("getproductdatabysearch?itemkeyword=" + request.term, function (data) {
            response($.map(data, function (value, key) {
             var nm=value['prod_name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    },
      select: function(e,ui) {

$.getJSON("getproductdatabysearch?itemkeyword=" + ui.item.value, function (data, status) {
console.log(data);
          $.map(data, function (value, key) {


//curr_row = $(".trrow").data("row");
//var gst_pc = $('#'+curr_row).find('.item_gstpc').val();
console.log(curr_row);
//$('#'+curr_row).find('.itemrate').val(data.rate);
var url ="getProductUnit";
$('#'+curr_row).find(".itemunit").load(url);
$('#'+curr_row).find(".itemrate").val(value['prod_rate']);
$('#'+curr_row).find(".itemdesc").val(value['prod_desc']);
$('#'+curr_row).find(".itemhsnsac").val(value['prod_hsnsac']);
$('#'+curr_row).find(".itemgstpc").val(value['prod_gstpc']);

$('#'+curr_row).find(".stock").val(value['prod_stock']);
$('#'+curr_row).find(".itemqty").focus();
//console.log(value);
if(value['stock']>0)
{
$('#'+curr_row).find(".stock").css("border-color","green"); 
}
else
{
$('#'+curr_row).find(".stock").css("border-color","red");   
}
var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".itemname").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0){

 document.getElementById("save_btn").disabled = false; 
$('#save_btn').removeClass('btn-default').addClass('btn-success');
}
else {
   document.getElementById("save_btn").disabled = true; 
   $('#save_btn').removeClass('btn-success').addClass('btn-default');
}


});

});              
//        console.log(data);
        //output selected dataItem
        },
//    minLength: 2,
    autoFocus: true,
    delay: 100
});



});


/*
$("#customer_name").on('change',function(){
console.log('on chage');

var id = $(this).val();
console.log(id);
var furl ="getvendordata?id="+id;

       $.getJSON(furl, function(data) {
        console.log(data);
        $("#gstin").val(data.gstin);
        $("#vname").html(data.name);
        $("#statecode").val(data.statecode);
     //             console.log('AcName' + data.name );
      //            console.log('AcName' + data.statecode );


                  //$('#stage').append('<p>Age : ' + jd.age+ '</p>');
                 // $('#stage').append('<p> Sex: ' + jd.sex+ '</p>');
               });
});
*/

 // Single Select


$(document).on('keydown','.custname',function(){
console.log('cust name search');
$('.custname').autocomplete({
    source: function (request, response) {
        $.getJSON("getledgerdatabyname?flag=inv&itemkeyword=" + request.term, function (data) {
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
//console.log(data);
 $("#gstin").val(value['account_gstin']);
 $("#editgstin").val(value['account_gstin']);
 
});

});              
        },
//    minLength: 2,
    autoFocus: true,
    delay: 100
});



});


$(document).on('keydown','#customer_name', function() { 
 
console.log('ldg name search');
$('#customer_name').autocomplete({
    source: function (request, response) {
        $.getJSON("getledgerdatabyname?flag=inv&itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
           //  console.log(value);
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

$("#gstin").val(value['account_gstin']);
$("#editgstin").val(value['account_gstin']);

var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".customer_name").val().length;


 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0)
{
document.getElementById("save_btn").disabled = false; 
$('#save_btn').removeClass('btn-default').addClass('btn-success');
}
else {
document.getElementById("save_btn").disabled = true; 
$('#save_btn').removeClass('btn-success').addClass('btn-default');
}


});

});              
//        console.log(data);
        //output selected dataItem
        },
//    minLength: 2,
    autoFocus: true,
    delay: 100
});



});



