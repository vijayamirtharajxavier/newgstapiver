var manageTBTable;



$(document).ready(function(){

var tburl = 'gettrialbal';
url = tburl.replace("undefined","");
manageTBTable = $('#tbTable').DataTable({
"destroy":true,
      "paging": false,
      "autoWidth": true,
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api();
        nb_cols = api.columns().nodes().length;
        var j = 2;
        while(j < nb_cols){
          var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal.toFixed(2));
          j++;
        } 
      },
"ajax": url,
      rowGroup: {
           dataSrc: 'group'
      },

"columns": [
            { "data": "group" },
            { "data": "name" },
            { "data": "debitamt", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
            { "data": "creditamt", render: $.fn.dataTable.render.number( ',', '.', 2 )  }
],

"columnDefs": [
  {
      "targets": 0, // your case first column
      "className": "text-left",
      "width": "5px",
      "visible": false
 },
  
  {
      "targets": 1, // your case first column
      "className": "text-left",
      "visible":true,
      "width": "30px"
 },
  {
      "targets": 2, // your case first column
      "className": "text-right",
      "width":"20px"

      
 },
  {
      "targets": 3, // your case first column
      "className": "text-right",
      "width":"20px"

      
 }

 ],
    
        "order": [[ 0, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="3">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
     /* "footerCallback": function (row, data, start, end, display) {                
                //Get data here 
                console.log(data);
                //Do whatever you want. Example:
                var totalAmount = 0;
                for (var i = 0; i < data.length; i++) {
                    totalAmount += parseFloat(data[i][2]);
                }
                console.log(totalAmount);
       }*/
      /*"footerCallback": function (row, data, start, end, display) {                
                //Get data here 
                console.log(data);
                //Do whatever you want. Example:
                var totalDebit = 0;
                var totalCredit=0;
                for (var i = 0; i < data.length; i++) {
                    totalDebit += parseFloat(data[i]['debitamt']);
                    totalCredit += parseFloat(data[i]['creditamt']);
                   // console.log(data[i]['debitamt']);
                }
                //$("#total_debit").innerHTML(totalDebit);
                console.log(totalCredit);
       }*/
});








   
   }); //Document.ready


