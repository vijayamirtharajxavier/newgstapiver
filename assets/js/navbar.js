var base_url = window.location.origin + '/';
console.log(base_url);
var finurl ="dashboard/fetchFinyear";
//getProfile();

//getCompany();



function getSettings()
{
//var base_url = "<?php echo base_url();?>";
var url = "get_settings";


            $.ajax({
                url:base_url + url,
                dataType:   "jsonp", // <== JSON-P request
                success:    function(data){
                   // alert(weblink); // this statement doesn't show up
                    $.each(data.result, function(entryIndex, entry){ // <=== Note, `data.results`, not just `data`
                     //   userList.push(entry['from_user']); // <=== Or `entry.from_user` would also work (although `entry['from_user']` is just fine)
            $("#invoice_number").val(entry.inv_no);
        $("#invoice_prefix").val(entry.inv_prefix);
        $("#invoice_suffix").val(entry.inv_suffix);

        $("#receipt_number").val(entry.receipt_no);
        $("#receipt_prefix").val(entry.receipt_prefix);
        $("#receipt_suffix").val(entry.receipt_suffix);

        $("#payment_number").val(entry.payment_no);
        $("#payment_prefix").val(entry.payment_prefix);
        $("#payment_suffix").val(entry.payment_suffix);

        $("#contra_number").val(entry.contra_no);
        $("#contra_prefix").val(entry.contra_prefix);
        $("#contra_suffix").val(entry.contra_suffix);

        $("#leadzero").val(entry.leading_zero);        

                    });
//                    alert(userList); // <== Note I've moved this (see #2 above)
                }
            });






  /*     $.getJSON(base_url + url, function(data) {
//        console.log(data);
//        console.log(data.inv_no);
        $("#invoice_number").val(data.inv_no);
        $("#invoice_prefix").val(data.inv_prefix);
        $("#invoice_suffix").val(data.inv_suffix);

        $("#receipt_number").val(data.receipt_no);
        $("#receipt_prefix").val(data.receipt_prefix);
        $("#receipt_suffix").val(data.receipt_suffix);

        $("#payment_number").val(data.payment_no);
        $("#payment_prefix").val(data.payment_prefix);
        $("#payment_suffix").val(data.payment_suffix);

        $("#contra_number").val(data.contra_no);
        $("#contra_prefix").val(data.contra_prefix);
        $("#contra_suffix").val(data.contra_suffix);

        $("#leadzero").val(data.leading_zero);        

        });
*/

}


function getCompany()
{

  var url ="accounts/get_company";

$.ajax({url:base_url + url,
 dataType:   "jsonp", // <== JSON-P request
 success:function(data){
                   // alert(weblink); // this statement doesn't show up
 $.each(data.result, function(entryIndex, entry){ // <=== Note, `data.results`, not just `data`
                     //   userList.push(entry['from_user']); // <=== Or `entry.from_user` would also work (although `entry['from_user']` is just fine)
        $("#companyname").val(entry.companyname);
        $("#companygstin").val(entry.companygstin);
        $("#companyaddress").val(entry.companyaddress);
$("#companycontact").val(entry.companycontact);
        $("#companycity").val(entry.companycity);
        $("#companypincode").val(entry.companypincode);
        $("#companyemail").val(entry.companyemail);

        $("#companystatecode").val(entry.companystatecode);
        $("#companybank").val(entry.companybank);

});
}
})
}
/*
       $.getJSON(base_url + url, function(data) {
//        console.log(data);
        //console.log(data.inv_no);
        $("#companyname").val(data.companyname);
        $("#companygstin").val(data.companygstin);
        $("#companyaddress").val(data.companyaddress);
$("#companycontact").val(data.companycontact);
        $("#companycity").val(data.companycity);
        $("#companypincode").val(data.companypincode);
        $("#companyemail").val(data.companyemail);

        $("#companystatecode").val(data.companystatecode);
        $("#companybank").val(data.companybank);
        });

       */

function getProfile()
{
var user_url = "accounts/fetchUserProfile";
/*
$.getJSON(base_url + user_url, function(data) {
  //      console.log(data);
$("#firstname").val(data.firstname);
$("#lastname").val(data.lastname);
$("#email").val(data.email);


});

*/


$.ajax({
 url:base_url + user_url,
 dataType:   "jsonp", // <== JSON-P request
 success:    function(data){
                   // alert(weblink); // this statement doesn't show up
 $.each(data.result, function(entryIndex, entry){ // <=== Note, `data.results`, not just `data`
                     //   userList.push(entry['from_user']); // <=== Or `entry.from_user` would also work (although `entry['from_user']` is just fine)
$("#firstname").val(entry.firstname);
$("#lastname").val(entry.lastname);
$("#email").val(entry.email);

});
//                    alert(userList); // <== Note I've moved this (see #2 above)
}
});

}


$("#finyear").load(base_url + finurl);



$(document).on('change','#finyear', function(){
var newfinyear = $("#finyear").val();

console.log(newfinyear);
$.ajax({ url: base_url +"dashboard/changeFinyear?newfinyear=" + newfinyear ,
  //  headers: {'X-Requested-With': 'XMLHttpRequest'}
});

});


$(document).on('keyup','#confirmpass',function(){
let cnpass = $(this).val();
let nwpass = $("#newpass").val();
if(nwpass==cnpass)
{
          //border-color: #ff80ff;
 $("#confirmpass").css("border-color","green");  
}
else
{
 $("#confirmpass").css("border-color","red");  
  //$("#confirmpass").focus();
}

});


var surl = "inventory/getStates";

$("#companystatecode").load(base_url + surl);
