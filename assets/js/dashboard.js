let url ='dashboard/getmsalespurhcase';
   
        console.log('Sales & Purchase Data');
  $.get(url,function(data,status){

$("#monthtransTbl tbody").html(data);

});



 url ='dashboard/getmgstsalespurhcase';
   
        console.log('Sales & Purchase GST Data');
  $.get(url,function(data,status){

$("#monthgstTbl tbody").html(data);

});


