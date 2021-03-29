<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PortInfo 2.0 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck/square/blue.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src=<?php echo base_url("assets/plugins/jQuery/jquery-2.2.3.min.js");?>></script>
  	<script src="<?php echo base_url('assets/dist/js/jquery.validate.js');?>"></script>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href=<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>>
  <!-- Font Awesome -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/css/font-awesome.min.css"); ?>>
  <!-- Ionicons -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/css/ionicons.min.css"); ?>>
  <!-- DataTables -->
  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css"); ?>>
  
  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/icheck/all.css"); ?>>
 
  <!-- Theme style -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/AdminLTE.css"); ?>>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/skins/_all-skins.css"); ?>>

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
    <a href="#"><b>PortInfo</b>2.0</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <?php if($this->session->flashdata('msg'))
		{ 
            echo $this->session->flashdata('msg');
        } 
echo form_open("Master/index");
?>
      <div class="form-group has-feedback">
        <input name="vch_un" type="username" class="form-control" placeholder="user name">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="vch_pw" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
         <div class="col-xs-12">
          <a href="#">I forgot my password</a><br>
        </div>
        
      </div>
    <?php 
echo form_close();
?>

    <div class="social-auth-links text-center">
     
      <a href="<?php echo site_url("Master/customerregistration_add"); ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-cog"></i> New Customer Registration</a>
    </div>
    <!-- /.social-auth-links -->

    


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>/assets/plugins/icheck/icheck.min.js"></script>
<script>
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
