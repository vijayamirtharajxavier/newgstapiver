<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form method="POST" class="user" action="<?php echo base_url();?>login/validate_user" id="validate_userForm">
                    <div id="login-message"></div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="InputEmail"  name="InputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="InputPassword"  name="InputPassword" placeholder="Password" required>
                    </div>
                   <div class="form-group">
                      <select id="finyear" name="finyear" class="form-control" required> </select>
                    </div>                  
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                     <!--   <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>-->
                      </div>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                    <!--<a href="<?php echo base_url();?>login/validate_user" class="btn btn-primary btn-user btn-block"> -->
                      
                    </a>
                    <hr>
<!--                    <a href="<?php echo base_url();?>dashboard" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="<?php echo base_url();?>dashboard" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> -->
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />


                  </form>
                  <hr>
                  <!--<div class="text-center">
                    <a class="small" href="<?php echo base_url();?>assets/forgot-password.html">Forgot Password?</a>
                  </div> -->
                  <!--<div class="text-center">
                    <a class="small" href="<?php echo base_url();?>assets/register.html">Create an Account!</a>
                  </div>-->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>


<script>
$(document).ready(function(){

var url ="login/fetchFinyear";

$("#finyear").load(url);

console.log('Submited Form');

{
  /*SUBMIT FORM*/
                
                $("#validate_userForm").unbind('submit').bind('submit', function() { 
                  console.log('submited validate_user');
                    var form = $(this);
                    //var data = {'id' : id};
                //  console.log(data);
                    var data = form.serialize()+'&'+ $.param(data);
                    var url = form.attr('action');
                    var type = form.attr('method');
                //  console.log('url-'+ url+"/"+id);
                    //var invNo= "&id=" + id ;
                    $.ajax({
                        url: url,
                        type: type,
                        data: data,
                        dataType: 'json',
                        success:function(response) {
                           // console.log(response);
                            if(response.success == true) {    
                              console.log('success');

                              var id=response.company_id;
                              var email=response.email;
                              var finyear=response.finyear;
                              var userid = response.userid;
                              var authkey=response.authkey;
                             // console.log(id);
//                              var furl = 'login/log?id='+id+'&email='+email+'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
                              var furl = 'login/log?id='+id+'&email='+email+'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;

                             // console.log(furl);
                              //window.location.href = furl;                  
                                window.location.replace(furl);
                                $('.form-group').removeClass('has-error').removeClass('has-success');
                                $('.text-danger').remove(); 
                                                                
                            }   
                            else {                                  
                            //  console.response;
                                $("#login-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                                  response.message + 
                                '</div>');      
$("#login-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#danger-alert").slideUp(500);
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
                    }); // /.ajax
                    return false;
                }); // /.submit edit expenses form
}  
});
</script>



</body>

</html>
