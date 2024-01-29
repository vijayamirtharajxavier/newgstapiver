var flag;
var managegstr1b2blistTable;
var managegstr1b2clistTable;
    $('#fromDate').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm-yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });




    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 5 ?
                        data.replace( /[$,]/g, '' ) :
                        data;
                }
            }
        }
    };


$(document).on('click','#mn', function() { 

console.log('Month ' + $(this).val());
console.log('Quarter ' + $("qr").val());
document.getElementById("gstr1_quater").disabled = true;
   document.getElementById("fromDate").disabled = false;
flag='M';
});


$(document).on('click','#qr', function() { 

console.log('Quarter ' + $(this).val());
console.log('Month ' + $("mn").val());
document.getElementById("fromDate").disabled = true;
document.getElementById("gstr1_quater").disabled = false;
flag='Q';
});


 

// 3.1
$('#search_btn').on('click',function(){
 let url ='fetch_gstr2b';
 if(flag=='M')
 {
 let fmDate= $('#fromDate').val();
   
        console.log('Ledger Account'+fmDate);

 managegstr1b2blistTable =  $('#gstr1b2blistTable').DataTable( 
  {
    "ajax": url+'?fdate='+fmDate+'&flag='+flag,
    "destroy":true, 
    "order" : false,
"columns": [
            { "data": "gstin" },
            { "data":"account_name"},
            { "data": "trans_id" },
            { "data": "inv_type" },
            { "data": "trans_date" },
            { "data": "invval" },
            { "data": "statecode" },
            { "data": "rcm" },
            { "data": "gstpc" },
            { "data": "txblval" },

            { "data": "igstval" },
            { "data": "cgstval" },
            { "data": "sgstval" },
            { "data": "cessval" }

        ],

'columnDefs': [
  {
      "targets": [0,1,2], // your case first column
      "className": "text-left",
      "width": "4%"
 },
  {
      "targets": [6,7,8], // your case first column
      "className": "text-center",
      "width": "100%"
 }, 
 {
      "targets": 3, // your case first column
      "className": "text-center",
      "width": "4%"
 },

 {
      "targets": [4,5,9,10,11,12,13],
      "className": "text-right"
 },

 ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]

}); 



 }
 if(flag=='Q')
 {
  let fmDate= $('#gstr1_quater').val();  
   
        console.log('Ledger Account'+fmDate);

 managegstr1b2blistTable =  $('#gstr1b2blistTable').DataTable( 
  {
    "ajax": url+'?fdate='+fmDate+'&flag='+flag,
    "destroy":true, 
    "order" : false,
"columns": [
            { "data": "gstin" },
            { "data":"account_name"},
            { "data": "trans_id" },
            { "data": "inv_type" },
            { "data": "trans_date" },
            { "data": "invval" },
            { "data": "statecode" },
            { "data": "rcm" },
            { "data": "txblval" },
            { "data": "gstpc" },
            { "data": "igstval" },
            { "data": "cgstval" },
            { "data": "sgstval" },
            { "data": "cessval" }

        ],
        "dom": 'Rlfrtip',
'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-left",
      "width": "250px"
 }, 
 {
      "targets": 3, // your case first column
      "className": "text-center",
      "width": "4%"
 },

 {
      "targets": [4,5,6,7,8],
      "className": "text-right"
 },

 ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]



}); 




 } 
 
});

