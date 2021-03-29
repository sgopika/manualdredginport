<!-- Starting of navigation bar -->
<?php //print_r($_SESSION);exit;
 $sess_usr_id  =   $this->session->userdata('int_userid');
 $user_type_id = $this->session->userdata('int_usertype');

$user_type_id_details          =   $this->Survey_model->get_usertype_master_header($user_type_id);
$data['user_type_id_details']=$user_type_id_details; //print_r($user_type_id_details);exit;
if(!empty($user_type_id_details))
{
  $name=$user_type_id_details[0]['user_type_type_name'];
}
else
{
  $name="";
}

if($user_type_id==10)
{
  $user_master          =   $this->Survey_model->get_user_master_header($sess_usr_id);
}
else
{ //echo "hiii";
  $user_master          =   $this->Survey_model->get_user_master_header($sess_usr_id);
}
if(!empty($user_master))
{
$data['user_master']  =   $user_master;
@$official_name      =   $user_master[0]['user_master_fullname'];
@$portofregistry_id      =   $user_master[0]['user_master_port_id'];
}
if($portofregistry_id!=0)
{
   $registry_port_id          =   $this->Survey_model->get_registry_port_id($portofregistry_id);
   $data['registry_port_id']  =   $registry_port_id;
   @$portofregistry_name= $registry_port_id[0]['vchr_portoffice_name'];
}
else
{
  @$portofregistry_name="";
}
?>

<div class="row no-gutters">
<div class="col headercolor"> <p class="h3 pt-2 pl-5 text-white"> PortInfo </p> </div>
<div class="col-10">
<nav class="navbar navbar-expand-lg navbar-dark maincolor justify-content-end ">
 <!-- Links -->
  <ul class="navbar-nav navmargin">
    <!-- Dropdown -->
    <li class="nav-item dropdown  navmargin">
      <a class="nav-link text-white navmargin" href="#" id="navbardrop" data-toggle="dropdown">
        <i class="fas fa-desktop"></i>&nbsp;&nbsp; Welcome <?php //echo $official_name; ?><?php if($user_type_id!=11){?>&nbsp;|&nbsp;<?php echo $portofregistry_name; ?><?php }//if($user_type_id==11){?>&nbsp;|&nbsp;<?php echo $name; ?><?php //}?>
      </a>
      <div class="dropdown-menu border-0 rounded-0 mt-2  dropmenucolor navwidth navmargin" >
        <div class="col-12  dropmenucolor  ">
        <img src="<?php echo base_url(); ?>plugins/img/user-avatar.png" class="mt-0 mx-auto d-block rounded-circle img-thumbnail port-navuser" alt="Port User" >
        </div>
        <div class="col-12 text-white d-flex justify-content-center dropmenucolor "> <?php echo $name; ?> </div>
          <div class="dropdown-divider"></div>
          <div class="row">
          <div class="col-6 mt-3 mx-auto d-block">
          <button type="button" class="btn btn-sm btn-default text-primary ml-5">Profile</button>
          </div>
          <div class="col-6 mt-3 mx-auto d-block">

        <!-- <a class="btn btn-sm btn-light text-primary px-2" href="<?php echo base_url();?>index.php/Main_login/index">   Logout  </a>    -->

      <a class="btn btn-sm btn-light text-primary px-2" href="<?php echo base_url();?>index.php/Main_login/logout"><i class="icon-chevron-right"></i>Logout</a>
       

          </div>  <!-- end of col12 -->
        </div>
      </div><!-- end of dropdown menu -->
    </li>
  </ul>
</nav>
</div> <!-- div col10 -->
</div> <!-- end of row -->
<!-- End of Navigation Bar -->