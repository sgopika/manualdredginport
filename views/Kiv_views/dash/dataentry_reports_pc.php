<?php 
$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');
$moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?><?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content ui-innerpage">
  <div class="table-responsive">
<table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
<thead>
  <tr>
    <th colspan="9"><font size="4">Data entry report</font></th>
  </tr>
  <tr>
    <th>#</th>
    <th>Port of registry</th>
    <th>Vessel Name</th>
    <th>KIV Reg. number</th>
    <th>Date of entry</th>
    <th>Status</th>
    <th>View</th>
  </tr>
</thead>
<tbody>
<?php
  $i=1;
  if(!empty($dataentry_details)) {
  foreach($dataentry_details as $key)
  {
    $data_id  = $key['id'];
    $dataentry_portoffice_id  = $key['dataentry_portoffice_id'];
    $vessel_id                = $key['vessel_id'];
    $date_of_entry            = date("d-m-Y", strtotime($key['dataentry_date']));


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
$vessel_sl1 = $this->encrypt->encode($vessel_id); 
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

$data_id1 = $this->encrypt->encode($data_id); 
$data_id_enc=str_replace(array('+', '/', '='), array('-', '_', '~'), $data_id1);


?>
<tr>
  <td><?php echo $i; ?></td>
  <td><?php echo $portofregistry_name; ?></td>
  <td><?php echo $vessel_name; ?></td>
  <td><?php echo $vesselmain_reg_number; ?></td>
  <td><?php echo $date_of_entry; ?></td>
  <td><?php if($key['dataentry_approved_status']==0) { echo "Not approved";} else { echo "Approved";} ?></td>
  <td> <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_dataentry_vessel/'.$vessel_sl.'/'.$data_id_enc ?>" class="btn btn-primary btn-flat btn-sm">Verify/Approve data entry forms</a></td>
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
  <th>Date of entry</th>
  <th>View</th>
</tfoot>
</table>
</div>
</div>