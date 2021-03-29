<?php 
$moduleid        = 2;
$modenc          = $this->encrypt->encode($moduleid); 
$modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
$user_sl                 =   $this->Survey_model->get_user_sl($sess_usr_id);
$data['user_sl']         =   $user_sl;
if(!empty($user_sl))
{
  $user_master_port_id=   $user_sl[0]['user_master_port_id'];
}
else
{
  $user_master_port_id= 0;
}
$survey_name              = $detTariffTable[0]['survey_name'];
$form_name                = $detTariffTable[0]['document_type_name'];
$vesseltype_name          = $detTariffTable[0]['vesseltype_name'];
$vessel_subtype_name      = $detTariffTable[0]['vessel_subtype_name'];
$start_date               = $detTariffTable[0]['start_date'];
$end_date                 = $detTariffTable[0]['end_date'];
$start_date = explode('-', $start_date);
$start_date = $start_date[2]."/".$start_date[1]."/".$start_date[0];
if(!empty($end_date))
{
  $end_date = explode('-', $end_date);
$end_date = $end_date[2]."/".$end_date[1]."/".$end_date[0];
}

?>
<?php 
/*if($this->session->flashdata('msg'))
{
echo $this->session->flashdata('msg');
}
     
          $attributes = array("class" => "form-horizontal", "id" => "tariff_view", "name" => "tariff_view" , "novalidate");
          
          if(isset($editres)){
                echo form_open("Master/dynamic_form", $attributes);
          } else {
            echo form_open("Master/viewTariff", $attributes);
       }*/

       ?>    
<!-- <form name="form1" method="post" id="form1" action="" > -->
    <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/detViewTariff", $attributes);
?>

<div class="container-fluid ui-innerpage">
    <div class="row pt-2">
    <div class="col-6">
      <span class="badge bg-darkmagenta innertitle ">Tariff Detailed View </span>
    </div> <!-- end of col6 -->
    <div class="col-6 d-flex justify-content-end">
     <nav aria-label="breadcrumb">
       <!--  <ol class="breadcrumb justify-content-end"> -->

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
   <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
 
           &nbsp; / &nbsp;
           <li><a href="<?php echo $site_url."/Kiv_Ctrl/Survey/tariff_list"?>">View Tariff List</a></li>
        </ol>
      </nav>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
  <div class="row mx-2  py-3 badge-label ">
    <div class="col-2 d-flex justify-content-center">
      <span class="badge badge-label"> Vessel Type : <?php echo $vesseltype_name; ?> </span>
    </div> <!-- end of col2 -->
    <div class="col-2 d-flex justify-content-center">
      <span class="badge badge-label"> Vessel subtype : <?php echo $vessel_subtype_name; if($vessel_subtype_name==''){echo "Nil";} ?> </span>
    </div> <!-- end of col2 -->
    <div class="col-2 d-flex justify-content-center">
      <span class="badge badge-label"> Activity : <?php echo $survey_name; ?> </span>
    </div> <!-- end of col2 -->
    <div class="col-2 d-flex justify-content-center">
      <span class="badge badge-label">  Form Name : <?php echo $form_name; ?></span>
    </div> <!-- end of col2 -->
    <div class="col-2 d-flex justify-content-center">
      <span class="badge badge-label"> Start Date : <?php echo $start_date; ?></span>
    </div> <!-- end of col2 -->
    <div class="col-2 d-flex justify-content-center">
      <span class="badge badge-label"> End Date : <?php echo $end_date; ?></span>
    </div> <!-- end of col2 -->
  </div> <!-- end of row -->
  <div class="row py-2">
    <div class="col-12 d-flex justify-content-center">
      <table id="example1" class="table table-bordered table-striped">
      <thead>
          <tr>
            <th>Sl.No</th>
            <th>Tonnage Type</th>
            <th>From Ton</th>
            <th>To Ton</th>
            <th>Day Type</th>
            <th>From Day</th>
            <th>To Day</th>
            <th>Amount</th>
            <th>Minimum Amount</th>
            <th>Fine Amount</th>
          </tr>
      </thead>
      <tbody>
         <?php  
                $i=1; foreach ($detTariffTable as $tariff) {
                $id                       = $tariff['tariff_sl'];
                $tariff_sl                = $tariff['tariff_sl'];
                $tariff_activity_id       = $tariff['tariff_activity_id'];
                $tariff_form_id           = $tariff['tariff_form_id'];
                $tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
                $tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
                $tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
                $tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
                $tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
                $tariff_day_type          = $tariff['tariff_day_type'];
                $tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
                $tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
                $tariff_amount            = $tariff['tariff_amount'];
                $tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
                $tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
                $tonnagetype_name         = $tariff['tonnagetype_name'];
                $tariffdaytype_name       = $tariff['tariffdaytype_name'];
         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $tonnagetype_name; ?></td>
            <td><?php echo $tariff_from_ton; ?></td>
            <td><?php echo $tariff_to_ton; ?></td>
            <td><?php echo $tariffdaytype_name; ?></td>
            <td><?php echo $tariff_from_day; ?></td>
            <td><?php echo $tariff_to_day; ?></td>
            <td><?php echo $tariff_amount; ?></td>
            <td><?php echo $tariff_min_amount; ?></td>
            <td><?php echo $tariff_fine_amount; ?></td> 
          </tr>
        <?php $i++;} ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Sl.No</th>
            <th>Tonnage Type</th>
            <th>From Ton</th>
            <th>To Ton</th>
            <th>Day Type</th>
            <th>From Day</th>
            <th>To Day</th>
            <th>Amount</th>
            <th>Minimum Amount</th>
            <th>Fine Amount</th>
          </tr>
      </tfoot>
</table>
    </div> <!-- end of col12 -->
  </div> <!-- end of table row -->
</div> <!-- end of container fluid -->
<!-- </form> --> <?php echo form_close(); ?>
<?php // echo form_close(); ?>