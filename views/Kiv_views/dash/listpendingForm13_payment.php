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
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">        <thead>
            <tr>
                  <th>#</th>
                  <th>Port of registry</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Owner Name</th>
                  <th>Vessel Type</th>
                  <th>Form</th>
                  <th>Verify</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                //@$customer_name1=$customer_details1[0]['user_name'];
                //print_r($data_payment);
                foreach($data_payment as $res1)
                {
                  $vessel_sl= $res1['vessel_sl'];
                  //$form_number= $res1['form_number'];
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

               $get_vessel_created_user         =   $this->Survey_model->get_vessel_created_user($vessel_sl);
                  $data['get_vessel_created_user'] =   $get_vessel_created_user;

                  @$customer_name1=$get_vessel_created_user[0]['user_name'];
                  //$portofregistry_id=$res1['portofregistry_id'];
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



                ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $portofregistry_name; ?></td>
                <td><?php echo $res1['vessel_name']; ?></td>
                <td><?php echo $res1['reference_number']; ?></td>
                <td><?php echo $customer_name1; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td><?php echo 'Form 12';//. $form_number; ?></td>
                <td><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/Verify_payment_pc_form3/267/893/1" class="btn btn-primary btn-flat btn-sm">Verify payment form 12</a><?php //if($res1['payment_approved_status']==0) { echo "Pending payment"; } ; ?></td>
              
                </tr>
                <?php
                $i++;
              }
                ?>
  </tbody>
<tfoot>
                <th>#</th>
                  <th>Port of registry</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Owner Name</th>
                  <th>Vessel Type</th>
                  <th>Form</th>
                  <th>Verify</th>
</tfoot>

       
    </table>
  </div>