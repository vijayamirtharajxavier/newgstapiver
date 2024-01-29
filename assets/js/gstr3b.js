    $('#fromDate').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm-yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });



$(document).on('click','#mn', function() { 

console.log('Month ' + $(this).val());
console.log('Quarter ' + $("qr").val());
document.getElementById("gstr3b_quater").disabled = true;
document.getElementById("fromDate").disabled = false;
document.getElementById("search_btn").disabled = false;

flag='M';
});


$(document).on('click','#qr', function() { 

console.log('Quarter ' + $(this).val());
console.log('Month ' + $("mn").val());
document.getElementById("fromDate").disabled = true;
document.getElementById("gstr3b_quater").disabled = false;
document.getElementById("search_btn").disabled = false;

flag='Q';
});









// 3.1
$('#search_btn').on('click',function(){
 
 if(flag=='M')
 {
   let url ='fetch_gstr3b';

 let fmDate= $('#fromDate').val();
   
        console.log('Ledger Account'+fmDate);

// var fmDate= $('#fromDate').val();
 
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr3bdata").html(data);

});

// 3.2
 url ='fetch_gstr32b';
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr32bdata").html(data);
console.log("gstr32bdata" + data);
});

//ITC
 url ='fetch_gstr34b';
   
        console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr34bdata").html(data);
//console.log("gstr34bdata " + data);

});

//Zero Rated Purchases
 url ='fetch_gstr3b5';
   
       // console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){
console.log("zero rated " + data);
$("#gstr3b5data").html(data);

});

} // Monthly


 if(flag=='Q')
 {
 let url ='fetch_gstr3b';

 let fmDate= $('#gstr3b_quater').val();
   
        console.log('Ledger Account'+fmDate);

// var fmDate= $('#fromDate').val();
 
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr3bdata").html(data);

});

// 3.2
 url ='fetch_gstr32b';
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr32bdata").html(data);
console.log("gstr32bdata" + data);
});

//ITC
 url ='fetch_gstr34b';
   
        console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr34bdata").html(data);
//console.log("gstr34bdata " + data);

});

//Zero Rated Purchases
 url ='fetch_gstr3b5';
   
       // console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){
console.log("zero rated " + data);
$("#gstr3b5data").html(data);

});

} // Quarterly





 
});

