<?php 
$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');

?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?><?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   
  </ol>
</nav> 
<!-- End of breadcrumb -->

 <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Bookofregistration/verified_forms", $attributes);
?>

<!-- <form name="form1" id="form1" method="post" class="form1" >  -->
<div class="main-content ui-innerpage">
  <div class="row no-gutters p-1 pb-2 justify-content-center">
  <div class="col-10 text-center">
      <div class="alert bg-darkslateblue" role="alert">
        Data Entry approved list
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
<?php if(!empty($dataentry_details)) { ?>

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
  <tr>
    <th colspan="9"><font size="4">Data entry approved list</font></th>
  </tr>
  <tr>
    <th>#</th>
    <th>Port of registry</th>
    <th>Vessel Name</th>
    <th>KIV Reg. number</th>
    <th>Date of entry</th>
    <th>Approved date</th>
    <th>Status</th>
  </tr>
</thead>
<tbody>
<?php
  $i=1;
  if(!empty($dataentry_details)) {
  foreach($dataentry_details as $key)
  {
    $dataentry_portoffice_id  = $key['dataentry_portoffice_id'];
    $vessel_id                = $key['vessel_id'];
    $date_of_entry            = date("d-m-Y", strtotime($key['dataentry_date']));
    $dataentry_approved_date            = date("d-m-Y", strtotime($key['dataentry_approved_datetime']));
    


    $portoffice             =  $this->DataEntry_model->get_portofregistry_name($dataentry_portoffice_id);
    $data['portoffice']     =  $portoffice;
    if(!empty($portoffice))
    {
     $portofregistry_name=$portoffice[0]['vchr_portoffice_name'];
    }
    else
    {
      $portofregistry_name="";
    }

    $vesselmain             =  $this->DataEntry_model->get_vesselmain($vessel_id);
    $data['vesselmain']     =  $vesselmain;
    if(!empty($vesselmain))
    {
      $vessel_name=$vesselmain[0]['vesselmain_vessel_name'];
      $vesselmain_reg_number=$vesselmain[0]['vesselmain_reg_number'];
    }


?>
<tr>
  <td><?php echo $i; ?></td>
  <td><?php echo $portofregistry_name; ?></td>
  <td><?php echo $vessel_name; ?></td>
  <td><?php echo $vesselmain_reg_number; ?></td>
  <td><?php echo $date_of_entry; ?></td>
  <td><?php echo $dataentry_approved_date; ?></td>
  <td><?php if($key['dataentry_approved_status']==0) { echo "Not approved";} else { echo "Approved";} ?></td>
 
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
  <th>KIV Reg. number</th>
  <th>Approved date</th>
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

});

</script>