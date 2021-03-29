<?php /*$sess_usr_id  =   $this->session->userdata('user_sl'); 
 $user_type_id  = $this->session->userdata('user_type_id');*/

  $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
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
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<!-- <form name="form1" id="form1" method="post" class="form1" >  -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/specialsurvey_done", $attributes);
?>




<div class="main-content ui-innerpage">
<div class="row no-gutters p-1 pb-2 justify-content-center">
  <div class="col-10 text-center">
      <div class="alert bg-darkslateblue" role="alert">
        Completed Special Survey Details
      </div> <!-- end of alert -->
  </div> <!-- end of col10 -->
  <div class="col-10 text-center py-1">
    <div class="row no-gutters px-1 pt-1 pb-1 justify-content-center bg-gray">
    <div class="col-2 pt-3 text-darkmagenta">
    From Date
    </div> <!-- end of col-3 -->
    <div class="col-3 py-2">
    <div class="input-group port-content-noborder">
    <input type="date" class="form-control dob" placeholder="" name="from_date" id="from_date" aria-label="Fromdate" aria-describedby="basic-addon2" required="required" value="<?php echo date('Y-m-d', strtotime('-30 days'));?>">
    <div class="input-group-append">
                  </div>
    </div> <!-- end of input group -->
    </div> <!-- end of col-3 -->
    <div class="col-2 pt-3 text-darkmagenta">
    To Date
    </div> <!-- end of col-3 -->
    <div class="col-3 py-2">
    <div class="input-group port-content-noborder">
    <input type="date" class="form-control dob" placeholder="" name="to_date" id="to_date" aria-label="Todate" aria-describedby="basic-addon2" required="required" value="<?php echo date('Y-m-d');?>">
    <div class="input-group-append">

    </div>
    </div> <!-- end of input group -->
    </div> <!-- end of col-3 -->
    <div class="col-2 text-center py-2"><input type="hidden" name="portofregistry_id" id="portofregistry_id" value="<?php //echo $user_master_port_id ?>">
    <button type="submit" class="btn btn-point btn-flat bg-darkmagenta"> <i class="fas fa-money-check"></i> &nbsp; View</button>
    </div>  <!-- end of col12 -->
    </div> <!-- end of inner row 1-->
  </div>
</div>
<?php if(!empty($special_survey_done)) { ?>
  <div class="table-responsive">
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>
           <tr><th colspan="8"><font size="4">Special survey completed</font></th></tr>
            <tr>
                  <th>#</th>
                  <th>Port of registry</th>
                  <th>Survey date</th>
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
                if(!empty($special_survey_done)) {
                foreach($special_survey_done as $res1)
                {
                  $survey_date= date('d-m-Y',strtotime($res1['actual_date']));
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

               $get_vessel_created_user      =   $this->Survey_model->get_vessel_created_user($vessel_sl2);
              $data['get_vessel_created_user'] =   $get_vessel_created_user;
              //print_r($get_vessel_created_user);


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
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);              ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $portofregistry_name; ?></td>
                <td><?php echo $survey_date; ?></td>
                <td><?php echo $res1['vessel_name']; ?></td>
                <td><?php echo $res1['reference_number']; ?></td>
                <td><?php echo $survey_name; ?></td>
                <td><?php echo $customer_name1; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td>
                  <?php if($survey_id==2 && $category==1) { ?>

                <a  href="<?php echo site_url(); ?>/Kiv_Ctrl/Survey/form9_certificate/<?php echo $vessel_sl; ?>" target="_blank" width="30" height="30"><i class="fas fa-file-pdf h4"></i> </a>
              <?php } ?>

              <?php if($survey_id==2 && $category==2) { ?>

                <a  href="<?php echo site_url(); ?>/Kiv_Ctrl/Survey/form10_certificate/<?php echo $vessel_sl; ?>" target="_blank" width="30" height="30"><i class="fas fa-file-pdf h4"></i> </a>
              <?php } ?>


                  <?php if($survey_id==3) { ?>

                <a  href="<?php echo site_url(); ?>/Kiv_Ctrl/Survey/drydocksurvey_certificate/<?php echo $vessel_sl; ?>" target="_blank" width="30" height="30"><i class="fas fa-file-pdf h4"></i> </a>
              <?php } ?>
              
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
                  <th>Survey date</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Survey</th>
                  <th>Owner Name</th>
                  <th>Vessel Type</th>
                  <th>View</th>
</tfoot>

       
    </table>
  </div> 
  <?php } ?>
</div>
<!-- </form> --> <?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function() {
$("#from_date").change(function()
{
    var newdate=$("#from_date").val();
    var CurrentDate = new Date();
    GivenDate = new Date(newdate);
    if(GivenDate > CurrentDate)
    {
      alert('Invalid date');
      $("#from_date").val('');
    }
});

$("#to_date").change(function()
{
    var newdate=$("#to_date").val();
    var CurrentDate = new Date();
    GivenDate = new Date(newdate);
    if(GivenDate > CurrentDate)
    {
      alert('Invalid date');
      $("#to_date").val('');
    }
});
//End of jquery
});
</script>