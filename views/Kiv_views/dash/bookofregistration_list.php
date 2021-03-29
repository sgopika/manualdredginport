<?php 
/*$sess_usr_id  =   $this->session->userdata('user_sl'); 
 $user_type_id  = $this->session->userdata('user_type_id');*/

$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');
$moduleid        = 2;
$modenc          = $this->encrypt->encode($moduleid); 
$modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
 
?>
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
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
  <div class="table-responsive">
<table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>

           <tr><th colspan="10"><font size="4">Registered vessel / Book of registration</font></th></tr>
            <tr>
                  <th>#</th>
                   <th>Reg. date</th>
                  <th>Vessel Name</th>
                   <th>Vessel Type</th>
                   <th>Owner Name</th>
                  <th>Port of registry</th>
                  <th>Ref. No</th>
                  <th>Survey number</th>
                              
                  <th>Registration number</th>
                  <th>Reg. certificate</th>
                  <th>Book of registration</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                 if(!empty($reg_vessel)) {
                foreach($reg_vessel as $res1)
                {
                  $vesselmain_reg_date= date('d-m-Y',strtotime($res1['vesselmain_reg_date']));
                 $vessel_sl2= $res1['vesselmain_vessel_id'];
                 $vesselmain_ref_number= $res1['vesselmain_ref_number'];
                    $vesselmain_reg_number= $res1['vesselmain_reg_number'];
                    $portofregistry_id= $res1['vesselmain_portofregistry_id'];


                  $vessel_details=$this->Bookofregistration_model->get_vessel_details_individual($vessel_sl2);
                      $data['vessel_details']  =   $vessel_details;

                     if(!empty($vessel_details)) {
                     
                 
                  $vessel_type_id              = $vessel_details[0]['vessel_type_id'];
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

$vessel_survey_number              = $vessel_details[0]['vessel_survey_number'];

}

$vessel_sl1 = $this->encrypt->encode($vessel_sl2); 
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

                ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $vesselmain_reg_date; ?></td> 
                <td><?php echo $vessel_details[0]['vessel_name']; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td><?php echo $customer_name1; ?></td>
                <td><?php echo $portofregistry_name; ?></td>
                <td><?php echo $vessel_details[0]['reference_number']; ?></td>
                <td><?php echo $vessel_survey_number; ?></td>
                <td><?php echo $vesselmain_reg_number; ?></td>
                <td>
                <a  href="<?php echo site_url(); ?>/Kiv_Ctrl/Bookofregistration/form14_certificate/<?php echo $vessel_sl2; ?>" target="_blank" width="30" height="30"> <i class="fas fa-file-download text-danger h4"></i> </a>                          
                 </td>
              <td>
                <a  href="<?php echo site_url(); ?>/Kiv_Ctrl/Bookofregistration/form15_certificate/<?php echo $vessel_sl2; ?>" target="_blank" width="30" height="30"><i class="fas fa-file-download text-success h4"></i></a>
                       
                
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
                 <th>Reg. date</th>
                  <th>Vessel Name</th>
                   <th>Vessel Type</th>
                   <th>Owner Name</th>
                  <th>Port of registry</th>
                  <th>Ref. No</th>
                  <th>Survey number</th>
                                  
                  <th>Registration number</th>
                   <th>Reg. certificate</th>
                  <th>Book of registration</th>
</tfoot>

       
    </table>
  </div>
</div>