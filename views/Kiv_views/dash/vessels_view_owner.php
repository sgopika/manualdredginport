<?php /*$sess_usr_id  =   $this->session->userdata('user_sl'); 
 $user_type_id  = $this->session->userdata('user_type_id');*/
 $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
?>

<script language="javascript">
    
$(document).ready(function(){


}); 
</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<!-- <form name="form1" id="form1" method="post" action=""> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/vessels_view_owner", $attributes);
?>
<div class="main-content ui-innerpage">
  <div class="table-responsive">

 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>
          <tr><th colspan="8"><font size="4">Initiate special survey</font></th></tr>
            <tr>
                  <th>#</th>
                  <th>Port of registry</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Survey</th>
                  <th>Owner Name</th>
                  <th>Vessel Type</th>
                  <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                if(!empty($vessel_details)) {
                foreach($vessel_details as $res1)
                {
                  $vessel_sl2= $res1['vessel_sl'];
                  $category= $res1['category'];
                  if($category==1)
                  {
                    $form_number=9;
                  }
                  else
                  {
                    $form_number=10;
                  }
                  $vessel_type_id              = $res1['vessel_type_id'];
                  if($vessel_type_id!=0)
                  {
                      $vessel_type          =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
                      $data['vessel_type']  =   $vessel_type;
                      $vessel_type_name     =   $vessel_type[0]['vesseltype_name'];
                  }
                  else
                  {
                     $vessel_type_name="-";
                  } 

               $get_vessel_created_user         =   $this->Survey_model->get_vessel_created_user($vessel_sl2);
                  $data['get_vessel_created_user'] =   $get_vessel_created_user;

                  @$customer_name1=$get_vessel_created_user[0]['user_name'];
                  $portofregistry_id=$res1['vessel_registry_port_id'];

$portofregistry           =   $this->Survey_model->get_registry_port_id($portofregistry_id);
$data['portofregistry']   =   $portofregistry;
if(!empty($portofregistry))
{
  $portofregistry_name=$portofregistry[0]['vchr_portoffice_name'];
}
else
{
  
  $portofregistry_name="";
}

$survey_id=$res1['sid'];

if(!empty($survey_id))
{

$survey_type          = $this->Survey_model->get_survey_type($survey_id);
$data['survey_type']  =   $survey_type;
if(!empty($survey_type))
{
  $survey_name=$survey_type[0]['survey_name'];
}
}


else
{
  $survey_name="";
}


$vessel_sl1 = $this->encrypt->encode($vessel_sl2); 
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

//Processing status starting

$get_processing_status           =   $this->Survey_model->get_processing_status($vessel_sl2);
$data['get_processing_status']   =   $get_processing_status;
if(!empty($get_processing_status))
{
  $processing_status=$get_processing_status[0]['processing_status'];
}
else
{
  $processing_status=0;
}

  $status_details     =   $this->Survey_model->get_form_number($vessel_sl2);
    $data['status_details'] = $status_details;
    if(!empty($status_details))
    {
       $process_name     =   $status_details[0]['process_name'];

    }
    else
    {
       $process_name     ="another";
    }

$process="This vessel is in ". $process_name. " (".$survey_name.") processing...";
//Processing status ending 



                ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $portofregistry_name; ?></td>
                <td><?php echo $res1['vessel_name']; ?></td>
                <td><?php echo $res1['reference_number']; ?><!-- .'__'.$vessel_sl2 --></td>
                <td><?php echo $survey_name; ?></td>
                <td><?php echo $customer_name1; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                
                <td>
                
                <!-- <a  href="<?php echo site_url(); ?>/Survey/request_specialsurvey/<?php echo $vessel_sl; ?>" target="_blank" width="30" height="30"><button type="button" class="btn btn-primary btn-flat btn-sm"> <i class="far fa-newspaper"></i> <small>Request for special survey</small></button></a> -->
                <?php if($processing_status==0) { ?>

               <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/request_specialsurvey/'.$vessel_sl ?>">
                <button type="button" class="btn btn-primary btn-flat btn-sm">  
                <small> <i class="fas fa-plus-square"></i> Request for special survey</small> </button></a> 

              <?php } else { echo $process; }?>

                </td>
                </tr>
                <?php
                $i++;
              }
            }
                ?>
  </tbody>
<tfoot>
                <th>#</th>
                  <th>Port of registry</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Survey</th>
                  <th>Owner Name</th>
                  <th>Vessel Type</th>
                 
                  <th>View</th>
</tfoot>

       
    </table>

   
  </div>
</div>
<!-- </form> --> <?php echo form_close(); ?>