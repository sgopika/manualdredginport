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

<body class="hold-transition " style="background:url(<?php echo base_url("assets/images/login_bg_vallarpadom.jpg");?>) no-repeat center center fixed; 

        -webkit-background-size: cover;

        -moz-background-size: cover;

        -o-background-size: cover;

        background-size: cover;">



<!--<marquee><h1>This pages is under design modifications (16-Sep-17)</h1></marquee>-->

<div class="hidden-xs"  style="min-height: 100px !important;"> &nbsp; </div>

<div class="">

<div class="col-md-8" style="color:#FFF">

  <img src="<?php echo base_url("assets/images/gokportlogo.png");?>"  class="img-responsive"  />

  <div class="row">

   <div class="col-md-1"></div>

   <div class="col-md-10 hidden-xs" >

   

    <p style="text-align: justify">Kerala State Port Department is an independent department under Government of Kerala. Director is the Head of the Port Department and is also the Marine Advisor to the Government of Kerala. Port department offers tremendous potential for development and growth of a wide spectrum of maritime activities such as international shipping, coastal shipping, ship repairs, fishing, captive ports for specific industries, all weather ports, tourism and sports etc. There are three major/ intermediate port offices and ten minor port offices under the Ports Department.</p>

    

   

  </div>



</div>

</div>

<div class="col-md-3">



 

  <div class="login-box-body" style="background:#fef6af;">

    <img src="<?php echo base_url("assets/images/portinfo-logo.png");?>" class="img-responsive" />

<hr>

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

        <input name="vch_pw" type="password" class="form-control" placeholder="Password" style="border:solid #red >

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

          <a href="<?php echo site_url("Port/forget_pw"); ?>">I forgot my password</a><br>

        </div>

        

      </div>

    <?php 

echo form_close();

?>



    <div class="social-auth-links text-center">

     

      <a href="<?php echo site_url("Master/customerregistration_add"); ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-cog"></i> New Customer Registration</a>

	   <a href="<?php echo site_url("Report/spot_online"); ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-cog"></i> Spot / Door Booking</a>

    </div>

    <!-- /.social-auth-links -->



    





  </div>

  <!-- /.login-box-body -->

</div>

</div>



<!-- /.login-box -->

<div class="row" style="position: absolute; bottom: 0px; right: 50px; ">

<footer><div align="right"><p style="text-align:left;font-size:15px; color: white;">Designed and Developed by Centre for Development of Imaging Technology-1<a href="http://cdit.org" target="_blank"><img src="<?php echo base_url('assets/images/cdit_logo.png'); ?>" /></a></p></div></footer></div>

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

