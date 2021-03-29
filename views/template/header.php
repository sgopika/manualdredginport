<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PortInfo | Version 2.0</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="<?php echo base_url("assets/plugins/jQuery/jquery-2.2.3.min.js");?>"></script>
  	<script src="<?php echo base_url('assets/dist/js/jquery.validate.js');?>"></script>
    <script>
    $(document).ready(function() {
		$("#btn_cancel").click(function(){
			
			window.location = "<?php echo site_url('Master/dashboard');?>";
						
			});
        
    });
    </script>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/css/font-awesome.min.css"); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/css/ionicons.min.css"); ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css"); ?>">
  
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/icheck/all.css"); ?>">
 
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/AdminLTE.css"); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/skins/_all-skins.css"); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<style>
.slow-spin {
  -webkit-animation: fa-spin 14s infinite linear;
  animation: fa-spin 14s infinite linear;
}
</style>


<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>" class="logo">PortInfo 2.0
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <?php if(isset($user_header)){   ?>  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="glyphicon glyphicon-user"></i>
              <span class="hidden-xs"><?php if(isset($user_header[0]['customer_name'])){ echo $user_header[0]['customer_name'];}else{ echo $user_header[0]['user_master_name']; }?></span>
            </a><?php } ?> 
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header"><?php if(isset($user_header)){   ?> 
                <img src=<?php echo base_url("assets/dist/img/logo1.png");?> class="img-circle" alt="User Image">

                <p>
                 <?php if(isset($user_header[0]['customer_name'])){ echo $user_header[0]['customer_name'];}else{ echo $user_header[0]['user_master_name']; } ?> - <?php echo  $user_header[0]['user_type_type_name']; ?>
                </p><?php } ?> 
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url("Port/user_change_pw"); ?>" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url("Master/logout"); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
    <script>
$(document).ready(function() {
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });

</script>
  </header>
   <div class="content-wrapper">