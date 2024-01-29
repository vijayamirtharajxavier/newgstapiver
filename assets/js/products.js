  var manageProductTable;
$(document).ready(function(){

var uniturl = 'products/getProductUnit';

$("#productunit").load(uniturl);

    console.log('Search Clicked');
 urlstr = 'products/getProduct';
 url = urlstr.replace("undefined","");
 //  date("d-m-Y", strtotime($originalDate));
//console.log('fmDate ' + fmDate + ' toDate ' + toDate);
//manageProductTable = $("#productTable").dataTable().fnDestroy();
 manageProductTable =  $('#productTable').DataTable( 
  {
    "destroy": true,
    "ajax"    : url, //+ 'fetchReceiptSearch',
   
"columns": [
            { "data": "action" },
            { "data": "name" },
            { "data": "desc" },
            { "data": "hsnsac" },
            { "data": "gstpc" },
            { "data": "unit" },
            { "data": "mrp" },
            { "data": "cost" },
            { "data": "rate" },
            { "data": "sku" },
            { "data": "batch" },
            { "data": "expiry" },
            { "data": "make" },
            { "data": "model" },
            { "data": "stock" }
            
        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-left",
      "width": "150px"
 },
 {
      "targets": [5, 6, 7,13],
      "className": "text-right"
 },

 ],

        dom: 'Bfrtip',
       
        buttons: [
            'copy', 'csv', 'excel',{
            extend: 'pdf',


title: function() {
      return $('#monthYear').val();
    },

 //title: system_name + '\n' + 'Receipts Report for the period from '+ $('#fmDate').val() + ' to '+ $('#toDate').val(),
  customize: function(doc) {
    doc.styles.title = {
      color: 'red',
      fontSize: '40',
      background: 'blue',
      alignment: 'center'

    }   


  },

               exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },   
          
            orientation: 'portrait', // 'landscape',


            customize: function (doc) {
                  var rowCount = doc.content[1].table.body.length;

      doc.pageMargins = [20,10,10,10];
        doc.defaultStyle.fontSize = 7;
        doc.styles.tableHeader.fontSize = 8;
        doc.styles.title.fontSize = 10; 
        // Remove spaces around page title
        doc.content[0].text = doc.content[0].text.trim();

      doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Receipts Report for the period from '+ $('#fmDate').val() + ' to '+ $('#toDate').val(),
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
                margin: [10, 0]
            }
        });

},
         }, {extend: 'print',

  

                                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },
      }

        ]




}); 
    


//Add Product Message

    $("#addProductForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                if(response.success == true) {                      
                        $("#add-product-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addProductForm").trigger("reset");
manageProductTable.ajax.reload(null, false);
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#error-product-message").fadeTo(2000, 500).slideUp(500, function(){
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

   

//Edit Product Message

    $("#editProductForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                if(response.success == true) {                      
                        $("#edit-product-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#edit-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


//$("#editProductForm").trigger("reset");
manageProductTable.ajax.reload(null, false);
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#error-product-message").fadeTo(2000, 500).slideUp(500, function(){
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



//Add Product Message

    $("#addProductSerForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                if(response.success == true) {                      
                        $("#add-product-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


//$("#addProductForm").trigger("reset");
manageProductTable.ajax.reload(null, false);
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-product-message").fadeTo(2000, 500).slideUp(500, function(){
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









}); //Document Ready 

function updateProductbyid(id)
{
  console.log('getProdfor Update ' + id);
 var url="products/getProductforUpdate";
        $.ajax({
            url: url+'?id='+id,
            
            success:function(response) {
              //console.log(response);
              $(".show-result-product").html(response);

}
});


}

function deleteUpdate(id)
{

$('#delRec').on('click',function() {
   // var id = $this.val();
console.log('delete '+ id);
$('#deleteModal').modal('hide');

    var urlstr =  'products/deleteProduct';
var url = urlstr.replace("undefined","");
//console.log(url);
    $.ajax({
        url: url+'?id='+id,
        dataType: 'JSON',
        success:function (response) 
        {

                            manageProductTable.ajax.reload(null, false);                  
                            //console.log(response);
                            if(response.success == true) {    
                     manageProductTable.ajax.reload(null, false);                  
                                $("#delete-product-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                  response.messages + 
                                '</div>');

    $('#deleteModal').modal('hide');
                                      
$("#delete-product-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});             
                                
                                $('.form-group').removeClass('has-error').removeClass('has-success');
                                $('.text-danger').remove(); 
                               // $("#addSalesInvoiceTable:not(:first)").remove();                                
                                //createTypeahead($td.find('input.edititemSearch'));
                                //manageExpeneseTable.ajax.reload(null, false);
                                
                                                                
                            }   
                            else {                                  
                            //  console.response;
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
                    }); // /.ajax
                    return false;
                }); // /.submit edit expenses form

}






 // Single Select
$(document).on('keydown','.productname', function() { 
 

$('.productname').autocomplete({
    source: function (request, response) {
        $.getJSON("products/getproductdatabykeyword?itemkeyword=" + request.term, function (data) {
            response($.map(data, function (value, key) {
             var nm=value['prod_name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    }
   /* ,
      select: function(e,ui) {

$.getJSON("products/getproductdatabysearch?itemkeyword=" + ui.item.value, function (data, status) {
console.log(data);
          $.map(data, function (value, key) {


});

});              
//        console.log(data);
        //output selected dataItem
        },

//    minLength: 2,
    autoFocus: true,
    delay: 100 */
});



});
