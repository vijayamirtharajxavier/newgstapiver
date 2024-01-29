  var manageLedgerTable;
$(document).ready(function(){

var grpurl = 'ledgers/getLedgerGroup';

$("#ledgergroup").load(grpurl);
$("#ledgergroup").select2();



var stateurl = 'ledgers/getStates';

$("#ledgerstate").load(stateurl);
$("#ledgerstate").select2();


    console.log('Search Clicked');
 urlstr = 'ledgers/getLedger';
 url = urlstr.replace("undefined","");
 //  date("d-m-Y", strtotime($originalDate));
//console.log('fmDate ' + fmDate + ' toDate ' + toDate);
//manageProductTable = $("#productTable").dataTable().fnDestroy();
 manageLedgerTable =  $('#ledgerTable').DataTable( 
  {
    "destroy": true,
    "ajax"    : url, //+ 'fetchReceiptSearch',

"columns": [
            { "data": "action" },
            { "data": "name" },
            { "data": "gstin" },
            { "data": "contact" },
            { "data": "email" },
            { "data": "statecode" },
            { "data": "bustype" },
            { "data": "groupname" },
            { "data": "address" }
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
      "targets": [5, 6, 7],
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
/*for (i = 1; i < rowCount; i++) {
//doc.content[1].table.body[i][5].alignment = 'right';
//doc.content[1].table.body[i][6].alignment = 'right';
doc.content[1].table.body[i][5].alignment = 'right';
doc.content[1].table.body[i][6].alignment = 'right';
doc.content[1].table.body[i][7].alignment = 'right';
doc.content[1].table.body[i][8].alignment = 'right';
doc.content[1].table.body[i][9].alignment = 'right';
};
*/

      doc.pageMargins = [20,10,10,10];
        doc.defaultStyle.fontSize = 7;
        doc.styles.tableHeader.fontSize = 8;
        doc.styles.title.fontSize = 10; 
        // Remove spaces around page title
        doc.content[0].text = doc.content[0].text.trim();

      doc['footer']=(function(page, pages) {
            return {
                columns: [
                    //'Receipts Report for the period from '+ $('#fmDate').val() + ' to '+ $('#toDate').val(),
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
    
   

//Edit Product Message

    $("#editLedgerForm").unbind('submit').bind('submit', function() {
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
                        $("#edit-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#edit-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


//$("#editLedgerForm").trigger("reset");
manageLedgerTable.ajax.reload(null, false);
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



//Add Product Message

    $("#addLedgerForm").unbind('submit').bind('submit', function() {
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
                        $("#add-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addLedgerForm").trigger("reset");
manageLedgerTable.ajax.reload(null, false);
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



$(document).on('keyup','#ledgergstin',function(){
var pan = $(this).val();
$("#ledgerpan").val(pan.substring(2,12));

});





}); //Document Ready 

function updateLedgerbyid(id)
{
  console.log('getLedger for Update ' + id);
 var url="ledgers/getLedgerforUpdate";
        $.ajax({
            url: url+'?id='+id,
            
            success:function(response) {
              //console.log(response);
              $(".show-result-ledger").html(response);

}
});


}

function deleteUpdate(id)
{

$('#delRec').on('click',function() {
   // var id = $this.val();
console.log('delete '+ id);
$('#deleteModal').modal('hide');

    var urlstr =  'ledgers/deleteLedger';
var url = urlstr.replace("undefined","");
//console.log(url);
    $.ajax({
        url: url+'?id='+id,
        dataType: 'JSON',
        success:function (response) 
        {

                            manageLedgerTable.ajax.reload(null, false);                  
                            //console.log(response);
                            if(response.success == true) {    
                     manageLedgerTable.ajax.reload(null, false);                  
                                $("#delete-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                  response.messages + 
                                '</div>');

    $('#deleteModal').modal('hide');
                                      
$("#delete-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
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



$(document).on('keydown','.ledgername', function() { 
 
console.log('ldg name search');
$('.ledgername').autocomplete({
    source: function (request, response) {
        $.getJSON("accounts/getledgerdatabyname?flag=rct&itemkeyword=" + request.term, function (data) {

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

    autoFocus: true,
    delay: 100
});



});


