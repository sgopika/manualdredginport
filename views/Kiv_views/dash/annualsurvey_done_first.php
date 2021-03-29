<?php 
/*$sess_usr_id  =   $this->session->userdata('user_sl'); 
$user_type_id  = $this->session->userdata('user_type_id');*/
$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');
?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
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
<div class="ui-innerpage">
<table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>
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
                if(!empty($annual_survey_done)) {
                foreach($annual_survey_done as $res1)
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

$survey_id=$res1['subprocess_id'];

$survey_type          = $this->Survey_model->get_survey_type($survey_id);
$data['survey_type']  =   $survey_type;
if(!empty($survey_type))
{
  $survey_name=$survey_type[0]['survey_name'];
}

$vessel_sl1 = $this->encrypt->encode($vessel_sl2); 
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

                ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $portofregistry_name; ?></td>
                <td><?php echo $res1['vessel_name']; ?></td>
                <td><?php echo $res1['reference_number']; ?></td>
                <td><?php echo $survey_name; ?></td>
                <td><?php echo $customer_name1; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td>
                <a  href="<?php echo site_url(); ?>/Kiv_Ctrl/Survey/annualsurvey_certificate/<?php echo $vessel_sl; ?>" target="_blank" width="30" height="30"><i class="fas fa-file-pdf h4"></i>  </a>

              
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