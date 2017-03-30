<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>SIA Pesantren</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php echo form_open("login/sign_in",array("id"=>"signin"));?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control filter-text" name="username" placeholder="Username atau email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div> 
       <div class="form-group has-feedback">
        <select class="form-control" name="sebagai" required>
          <option value="">Masuk Sebagai</option>
          <option value="santri">Santri</option>
          <option value="admin">Administrator Pesantren</option>
        </select>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close(); ?>

   
    <!-- /.social-auth-links -->
    <a href="register.html" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  
  $(document).ready(function(){
         
         $('.filter-text').keypress(function(e){
            var txt = String.fromCharCode(e.which);
            //console.log(txt + ' : ' + e.which);
            if(!txt.match(/[A-Za-z0-9+]/)&&e.which!=8) 
            {
                return false;
            }
         });
         $('.filter-text-permalink').keypress(function(e){
                          var txt = String.fromCharCode(e.which);
                          //console.log(txt + ' : ' + e.which);
                          if(!txt.match(/[a-z0-9-]/)&&e.which!=8) 
                          {
                              return false;
                          }
                       });
         $('.filter-number').keypress(function(e){
            var txt = String.fromCharCode(e.which);
            //console.log(txt + ' : ' + e.which);
            if(!txt.match(/[0-9+#.]/)&&e.which!=8) 
            {
                return false;
            }
         });
   });
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
