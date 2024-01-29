    $('#fy').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, 1));
        }
    });

// 3.1
$('#search_btn').on('click',function(){
 let url ='cwms_report';
 
 var fyear= $('#fy').val();
 
   
    
  $.get(url+'?fy='+fyear,function(data,status){

$("#monthcwmsTbl tbody").html(data);

});


 
});