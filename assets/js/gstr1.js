var flag;
var managegstr1b2blistTable;
var managegstr1b2clistTable;
var managegstr1hsnsaclistTable;
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



function exp_json()
{
let output;
 let url ='gstr1b2bJson';
if(flag=='M')
{
let fmDate= $('#fromDate').val();
     
$.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

output=data;
//console.log(data);
//$("#monthcwmsTbl tbody").html(data);
  var textToWrite = output;
 // console.log(output);
  var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'});
  var fileNameToSaveAs = "json_output_gstr1.json";  //b document.getElementById("inputFileNameToSaveAs").value;

  var downloadLink = document.createElement("a");
  downloadLink.download = fileNameToSaveAs;
  downloadLink.innerHTML = "Download File";
  if (window.webkitURL != null)
  {
    // Chrome allows the link to be clicked
    // without actually adding it to the DOM.
    downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
  }
  else
  {
    // Firefox requires the link to be added to the DOM
    // before it can be clicked.
    downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
  }

  downloadLink.click();
});

}

 if(flag=='Q')
 {
  let fmDate= $('#gstr1_quater').val();  
   
        console.log('Ledger Account'+fmDate);

$.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){
output=data;
//console.log(data);
//$("#monthcwmsTbl tbody").html(data);
  var textToWrite = output;
  //console.log(output);
  var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'});
  var fileNameToSaveAs = "json_output_gstr1.json";  //b document.getElementById("inputFileNameToSaveAs").value;

  var downloadLink = document.createElement("a");
  downloadLink.download = fileNameToSaveAs;
  downloadLink.innerHTML = "Download File";
  if (window.webkitURL != null)
  {
    // Chrome allows the link to be clicked
    // without actually adding it to the DOM.
    downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
  }
  else
  {
    // Firefox requires the link to be added to the DOM
    // before it can be clicked.
    downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
  }

  downloadLink.click();

});




}





}







// 3.1
$('#search_btn').on('click',function(){
 let url ='fetch_gstr1b2b';
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
            { "data": "account_name" },
            { "data": "inv_no" },
            { "data": "trans_date" },
            { "data": "gstpc" },
            { "data": "txb_amt" },
            { "data": "igst" },
            { "data": "cgst" },
            { "data": "sgst" },
            { "data": "net_amt" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-center",
      "width": "100%"
 }, 
 {
      "targets": 3, // your case first column
      "className": "text-center",
      "width": "4%"
 },

 {
      "targets": [5,6,7,8,9],
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


url ='fetch_gstr1b2c';
 managegstr1b2clistTable =  $('#gstr1b2clistTable').DataTable( 
  {
    "ajax": url+'?fdate='+fmDate+'&flag='+flag,
    "destroy":true, 
    "order" : false,
"columns": [
            { "data": "gstin" },
            { "data": "account_name" },
            { "data": "inv_no" },
            { "data": "trans_date" },
            { "data": "gstpc" },
            { "data": "txb_amt" },
            { "data": "igst" },
            { "data": "cgst" },
            { "data": "sgst" },
            { "data": "net_amt" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-center",
      "width": "50%"
 }, 
 {
      "targets": 3, // your case first column
      "className": "text-center",
      "width": "4%"
 },

 {
      "targets": [5,6,7,8,9],
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



url ='fetch_gstr12hsnsac';
 managegstr1hsnsaclistTable =  $('#gstr1hsnsaclistTable').DataTable( 
  {
    "ajax": url+'?fdate='+fmDate+'&flag='+flag,
    "destroy":true, 
    "order" : false,
"columns": [
            { "data": "hsnsac" },
            { "data": "uqc" },
            { "data": "total_qty" },
            { "data": "taxable_value" },
            { "data": "gstpc" },
            { "data": "igst" },
            { "data": "cgst" },
            { "data": "sgst" },
            { "data": "cess" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-center",
      "width": "50%"
 }, 
 {
      "targets": 3, // your case first column
      "className": "text-right",
      "width": "4%"
 },
 {
      "targets": [5,6,7,8], // your case first column
      "className": "text-right",
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
            { "data": "account_name" },
            { "data": "inv_no" },
            { "data": "trans_date" },
            { "data": "gstpc" },
            { "data": "txb_amt" },
            { "data": "igst" },
            { "data": "cgst" },
            { "data": "sgst" },
            { "data": "net_amt" }

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
      "targets": [5,6,7,8,9],
      "className": "text-right"
 },

 ]


}); 


url ='fetch_gstr1b2c';
 managegstr1b2clistTable =  $('#gstr1b2clistTable').DataTable( 
  {
    "ajax": url+'?fdate='+fmDate+'&flag='+flag,
    "destroy":true, 
    "order" : false,
"columns": [
            { "data": "gstin" },
            { "data": "account_name" },
            { "data": "inv_no" },
            { "data": "trans_date" },
            { "data": "gstpc" },
            { "data": "txb_amt" },
            { "data": "igst" },
            { "data": "cgst" },
            { "data": "sgst" },
            { "data": "net_amt" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-center",
      "width": "80%"
 }, 
 {
      "targets": 3, // your case first column
      "className": "text-center",
      "width": "4%"
 },

 {
      "targets": [5,6,7,8,9],
      "className": "text-right"
 },

 ]


}); 




url ='fetch_gstr12hsnsac';
 managegstr1hsnsaclistTable =  $('#gstr1hsnsaclistTable').DataTable( 
  {
    "ajax": url+'?fdate='+fmDate+'&flag='+flag,
    "destroy":true, 
    "order" : false,
"columns": [
            { "data": "hsnsac" },
            { "data": "uqc" },
            { "data": "total_qty" },
            { "data": "taxable_value" },
            { "data": "gstpc" },
            { "data": "igst" },
            { "data": "cgst" },
            { "data": "sgst" },
            { "data": "cess" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-center",
      "width": "50%"
 }, 
 {
      "targets": 3, // your case first column
      "className": "text-right",
      "width": "4%"
 },
 {
      "targets": [5,6,7,8], // your case first column
      "className": "text-right",
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

