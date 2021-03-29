<?php 
$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');

?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==15) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/DataEntry/dataentryhome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="ui-innerpage">
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