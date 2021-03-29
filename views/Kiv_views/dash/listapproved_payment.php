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
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
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
echo form_open("Kiv_Ctrl/Survey/listapproved_payment", $attributes);
?>
<div class="main-content ui-innerpage">
<div class="row no-gutters p-1 pb-2 justify-content-center">
  <div class="col-10 text-center">
      <div class="alert bg-darkslateblue" role="alert">
       Approved payment Details
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
<?php if(!empty($data_payment)) { ?>

<?php if($day=='30') { ?>
<div class="alert text-black text-center" role="alert"><span class="badge bg-gray py-2 px-3"> Showing details for last 30 days</span></div>
<?php 
}
else
{
  ?>
  <?php
}
?>

  <div class="table-responsive">
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>
          <tr><th colspan="10"><font size="4">Approved payments</font></th></tr>
            <tr>
                  <th>#</th>
                  <th>Port of registry</th>
                  <th>Vessel Name</th>
                  <th>Activity Type</th>
                  <th>Amount</th>
                  <th>Ref. No</th>
                  <th>Owner Name</th>
                  <th>Vessel Type</th>
                   <th>Form</th>
                  <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                //@$customer_name1=$customer_details1[0]['user_name'];
                foreach($data_payment as $res1)
                {
                  $vessel_sl= $res1['vessel_sl'];
                  $form_number= $res1['form_number'];
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
                  $portofregistry_id=$res1['portofregistry_id'];

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
$survey_id=$res1['survey_id'];

$survey_type          = $this->Survey_model->get_survey_type($survey_id);
$data['survey_type']  =   $survey_type;
if(!empty($survey_type))
{
  $survey_name=$survey_type[0]['survey_name'];
}
else
{
  $survey_name="";
/*  if($form_number=='12')
  {
     $survey_name='Registration';
  }
  elseif($form_number=='11')
  {
    $survey_name='NameChange';
  }
   elseif($form_number=='18')
  {
    $survey_name='Ownership Change';
  }
  elseif($form_number=='19')
  {
    $survey_name='Transfer Vessel';
  }
  elseif($form_number=='20')
  {
    $survey_name='Duplicate Certificate';
  }
  else
  {
    $survey_name="";
  }*/
 /* $status_details_vessel_sl          = $this->Survey_model->get_status_details_vessel_sl($vessel_sl);
$data['status_details_vessel_sl']  =   $status_details_vessel_sl;
if(!empty($status_details_vessel_sl))
{
  $process_id=$status_details_vessel_sl[0]['process_id'];
  if($process_id==14)
  {
    $survey_name='Registration';
  }
  if($process_id==38)
  {
    $survey_name='Vessel change';
  }

}
else
{
  $survey_name="";
}
*/
}
$dd_amount=$res1['dd_amount'];
                ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $portofregistry_name; ?></td>
                <td><?php echo $res1['vessel_name']; ?></td>
                <td><?php echo $survey_name; ?></td>
                 <td><?php echo $dd_amount; ?></td>
                <td><?php echo $res1['reference_number']; ?></td>
                <td><?php echo $customer_name1; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                 <td><?php echo 'Form '. $form_number; ?></td>
                <td><?php if($res1['payment_approved_status']==1) { echo "Payment approved"; } ; ?></td>
           
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
                  <th>Activity Type</th>
                  <th>Amount</th>
                  <th>Ref. No</th>
                  <th>Owner Name</th>
                  <th>Vessel Type</th>
                   <th>Form</th>
                  <th>Status</th>
</tfoot>

       
    </table>

  </div>
  <?php
 }
else
{
  ?>
   <div class="alert text-red text-center" role="alert"><span class="badge bg-gray py-2 px-3">No data found</span></div>
  <?php 
} 
?>
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