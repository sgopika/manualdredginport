<?php 
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id = $this->session->userdata('int_usertype');
if($user_type_id==3)
{
  $name="Port Conservator";
}
if($user_type_id==10)
{
  $name="Administrator";
}
if($user_type_id==11)
{
  $name='Vessel Owner';
}
if($user_type_id==12)
{
  $name='Chief Surveyor';
}
if($user_type_id==13)
{
  $name='Surveyor';
}
if($user_type_id==16)
{
  $name='Super Admin';
}

if($user_type_id==17)
{
  $name='Print User';
}
//echo base_url();

//$sess_usr_id          =   $this->session->userdata('user_sl');
if($user_type_id==10)
{
  $user_master          =   $this->Master_model->get_user_master($sess_usr_id);
}
else
{
  $user_master          =   $this->Survey_model->get_user_master($sess_usr_id);
}

$data['user_master']  =   $user_master;
@$user_type_name      =   $user_master[0]['user_type_type_name'];
@$official_name       =   $user_master[0]['user_master_fullname'];
?>

<div class="row no-gutters">
<div class="col headercolor"> <p class="h3 m-2 ml-5 text-white"> PortInfo </p> </div>
<div class="col-10">
<nav class="navbar navbar-expand-lg navbar-dark maincolor justify-content-end ">
 <!-- Links -->
  <ul class="navbar-nav navmargin">
    <!-- Dropdown -->
    <li class="nav-item dropdown  navmargin">
      <a class="nav-link text-white navmargin" href="#" id="navbardrop" data-toggle="dropdown">
        <i class="fas fa-desktop"></i>&nbsp;&nbsp; Welcome   <?php echo $name; ?> <?php echo @$official_name; ?>
      </a>
      <div class="dropdown-menu border-0 rounded-0 mt-2  dropmenucolor navwidth navmargin" >
        <div class="col-12  dropmenucolor  ">
        <img src="<?php echo base_url(); ?>plugins/img/user-avatar.png" class="mt-0 mx-auto d-block rounded-circle img-thumbnail port-navuser" alt="Port User" >
        </div>
        <div class="col-12 text-white d-flex justify-content-center dropmenucolor "> <?php echo $name; ?>  <?php echo @$official_name; ?>  </div>
          <div class="dropdown-divider"></div>
          <div class="row">
          <div class="col-6 mt-3 mx-auto d-block">
          <button type="button" class="btn btn-sm btn-default text-primary ml-5">Profile</button>
          </div>
          <div class="col-6 mt-3 mx-auto d-block">

          <!-- <button type="button" class="btn btn-sm btn-default text-primary mr-5">Logout</button> -->

          <a class="btn btn-sm btn-light text-primary mr-5" href="<?php echo base_url();?>index.php/Main_login/logout">   Logout  </a>

          </div>  <!-- end of col12 -->
        </div>
      </div><!-- end of dropdown menu -->
    </li>
  </ul>
</nav>
</div> <!-- div col10 -->
</div> <!-- end of row -->
<!-- End of Navigation Bar -->