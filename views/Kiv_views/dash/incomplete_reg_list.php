<?php  
/*$sess_usr_id  =   $this->session->userdata('user_sl'); 
  $user_type_id1  =   $this->session->userdata('user_type_id');*/
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id1   = $this->session->userdata('int_usertype');


   ?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
<?php if($user_type_id1==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>

    <?php if($user_type_id1==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id1==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id1==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
  <div class="table-responsive">
  
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
  <thead>
     <tr><th colspan="9"><font size="4">Incomplete vessel registration list</font></th></tr>
  <tr>
  <th>#</th>
  <th>Vessel Name</th>
  <th>Vessel Type</th>
  <th>Vessel sub type</th>
  <th>Vessel category</th>
  <th>Engine Type</th>
  <th>Hull material</th>
  <th>Status</th>
  <th></th>
  </tr>
  </thead>
  <tbody>
  <?php
    $i=1;
  
    foreach($incomplete_form1 as $res1)
    {
      @$vessel_sl             = $res1['vessel_sl'];
      @$vessel_type_id        = $res1['vessel_type_id'];
      $vessel_subtype_id     = $res1['vessel_subtype_id'];
      $vessel_category_id     = $res1['vessel_category_id'];
      $vessel_subcategory_id     = $res1['vessel_subcategory_id'];
      $engine_placement_id     = $res1['engine_placement_id'];
      $hullmaterial_id     = $res1['hullmaterial_id'];
      $stage_count     = $res1['stage_count'];

     if($vessel_category_id!=0)
  {
    $vessel_category_id       =   $this->Survey_model->get_vessel_category_id($vessel_category_id);
    $data['vessel_category_id']   = $vessel_category_id;
    $vessel_category_name     = $vessel_category_id[0]['vesselcategory_name'];
  }
  else
  {
    $vessel_category_name='-';
  }
  if($vessel_subcategory_id!=0)
  {
    $vessel_subcategory_id      =   $this->Survey_model->get_vessel_subcategory_id($vessel_subcategory_id);
    $data['vessel_subcategory_id']  = $vessel_subcategory_id;
    @$vessel_subcategory_name   = $vessel_subcategory_id[0]['vessel_subcategory_name'];
  }
  else
  {
    $vessel_subcategory_name='-';
  }
  
  if($vessel_type_id!=0)
  {
    $vessel_type_id       =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
    $data['vessel_type_id']   = $vessel_type_id;
    $vesseltype_name      = $vessel_type_id[0]['vesseltype_name'];
  }
  else
  {
    $vesseltype_name='-';
  }
    
  if($vessel_subtype_id!=0)
  {
    $vessel_subtype_id      =   $this->Survey_model->get_vessel_subtype_id($vessel_subtype_id);
    $data['vessel_subtype_id']  = $vessel_subtype_id;
    $vessel_subtype_name    = $vessel_subtype_id[0]['vessel_subtype_name'];
  }
  else
  {
    $vessel_subtype_name='-';
  }

  if(($hullmaterial_id!='9999'))
    {
      $hullmaterial           =  $this->Survey_model->get_hullmaterial_name($hullmaterial_id);
      $data['hullmaterial']   =   $hullmaterial; 
      if(!empty($hullmaterial)){
        $hullmaterial_name      =   $hullmaterial[0]['hullmaterial_name'];
      }
      else
      {
        $hullmaterial_name      =  "nil";
      }
    }
    else
      {
        $hullmaterial_name      =  "ALL";
      }

 if(($engine_placement_id!='9999'))
    {
      $engine_placement           =  $this->Survey_model->get_inboard_outboard_name($engine_placement_id);
      $data['engine_placement']   =   $engine_placement; 
      if(!empty($engine_placement)){
        $engine_placement_name      =   $engine_placement[0]['inboard_outboard_name'];
      }
      else
      {
        $engine_placement_name      =  "nil";
      }
    }
    else
      {
        $engine_placement_name      =  "ALL";
      }
if($stage_count==1)
{
   $message='<span class="badge btn-primary btn-flat btn-point btn-block">Basic Details Completed</span>';
}
if($stage_count==2)
{
   $message='<span class="badge btn-primary btn-flat btn-point   btn-block">Hull Completed</span>';
}
if($stage_count==3)
{
   $message='<span class="badge btn-primary btn-flat btn-point btn-block">Engine Completed</span>';
}
if($stage_count==4)
{
   $message='<span class="badge btn-primary btn-flat btn-point btn-block">Equipment Completed</span>';
}
if($stage_count==5)
{
   $message='<span class="badge btn-primary btn-flat btn-point btn-block">Fire Appliance Completed</span>';
}
if($stage_count==6)
{
   $message='<span class="badge btn-primary btn-flat btn-point btn-block">Other Equipments Completed</span>';
}
if($stage_count==7)
{
   $message='<span class="badge btn-primary btn-flat btn-point btn-block">Documents Upload Completed</span>';
}
if($stage_count==8)
{
   $message='<span class="badge btn-primary btn-flat btn-point btn-block">Payment Completed</span>';
}

if($stage_count==9)
{
   $message='<span class="badge btn-warning btn-flat btn-point btn-block">Payment pending</span>';
}

if($stage_count==1)
{
   $button_message='Add Hull';
}

if($stage_count==2)
{
   $button_message='Add Engine';
}

if($stage_count==3)
{
   $button_message='Add Equipment';
}
if($stage_count==4)
{
   $button_message='Add Fire Appliance';
}
if($stage_count==5)
{
   $button_message='Add Other Equipments';
}
if($stage_count==6)
{
   $button_message='Add Documents';
}
if($stage_count==7)
{
   $button_message='Add Payment';
}
if($stage_count==9)
{
   $button_message='Payment pending';
}

$vessel_sl1 = $this->encrypt->encode($vessel_sl); 
$vessel_sl2=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

$stage_count1 = $this->encrypt->encode($stage_count); 
$stage_count2=str_replace(array('+', '/', '='), array('-', '_', '~'), $stage_count1);

    ?>

      <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $res1['vessel_name']; ?></td>
      <td><?php echo $vesseltype_name; ?></td>
      <td><?php echo $vessel_subtype_name; ?></td>
      <td><?php echo $vessel_category_name ; ?></td>
      <td><?php echo $engine_placement_name ; ?></td>
      <td><?php echo $hullmaterial_name ; ?></td>
      <td><?php echo $message ; ?></td>
      <td>
    <?php if($stage_count!=9) { ?> <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/add_form1/'.$vessel_sl2.'/'.$stage_count2 ?>" class="btn btn-sm tablebtn bg-indianred btn-flat btn-point btn-block"><?php echo $button_message; ?> </a> <?php } ?>

      <?php if($stage_count==9) { ?> <span class="btn btn-sm btn-noclick btn-block btn-flat btn-point bg-goldenrod"> <?php echo $button_message; ?> </span> <?php } ?>
    </td>
      </tr>
      <?php
      $i++;
    }
    ?>
  </tbody>
  <tfoot>
  <tr>
  <th>#</th>
  <th>Vessel Name</th>
  <th>Vessel Type</th>
  <th>Vessel sub type</th>
  <th>Vessel category</th>
  <th>Engine Type</th>
  <th>Hull material</th>
  <th>Status</th>
  <th></th>
  </tr>
  </tfoot>
</table>
</div>
</div>