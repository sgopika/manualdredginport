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
   <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<form name="form1" id="form1" method="post" class="form1" > 
<div class="main-content ui-innerpage">
  <div class="row no-gutters p-1 justify-content-center">
    <div class="col-10 text-center">
      <div class="alert bg-darkslateblue" role="alert">
        Tariff List 
      </div> <!-- end of alert -->
      </div> <!-- end of col8 -->
      <div class="col-10 text-center">
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center ">
          <div class="col-2 py-2">
            Activity
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <select class="form-control btn-point js-example-basic-single select2" name="survey_sl[]" id="survey_sl" multiple="multiple" required="required"  data-placeholder="Select the list" >
              <option value="">Select</option>
              <option value="0">All</option>
                <?php foreach($survey_type as $res_survey_type) { ?>
                <option class="initial" value="<?php echo $res_survey_type['survey_sl']?>"><?php echo $res_survey_type['survey_name']; ?></option>
              <?php } ?></select> 
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2">
          &nbsp;
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            &nbsp;
            </select>
          </div> <!-- end of col-3 -->
        </div> <!-- end of inner row 2-->
       
        
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center bg-gray">
          <div class="col-12 text-center py-2"><input type="hidden" name="portofregistry_id" id="portofregistry_id" value="<?php echo $user_master_port_id ?>">
            <button type="submit" class="btn btn-point btn-flat bg-darkmagenta"> <i class="fas fa-money-check"></i> &nbsp; View Tariff</button>
          </div>  <!-- end of col12 -->
        </div> <!-- end of inner row 3 -->
      </div> <!-- end of col8 -->
   </div> <!-- end of row -->
<?php 
?>
   <div class="row no-gutters p-1 justify-content-center">
    <div class="col-12 p-1 text-center">
      <!-- <div class="alert bg-gray-active text-black" role="alert">
        Showing payment details for <span class="badge bg-gray py-2 px-3">  <?php echo $survey1_name; ?>  </span> activities at  <span class="badge  bg-gray py-2 px-3"> <?php echo $portofregistry_name1; ?></span> Port of Registry through  <span class="badge bg-gray py-2 px-3">  <?php echo $bankname1_name; ?> </span> Payment Gateway(s). <br> <br>
        From  <span class="badge bg-gray py-2 px-3"> <?php echo $from_date; ?></span>  to  <span class="badge  bg-gray py-2 px-3"> <?php echo  $to_date ; ?> </span>
      </div> --> <!-- end of alert -->
    </div>  <!-- end of col12 -->
    <div class="col-12 p-1 d-flex justify-content-end">
      <button type="button" class="btn btn-sm btn-flat btn-point bg-firebrick "><i class="fas fa-file-pdf"></i>&nbsp; Print </button> &nbsp;
      &nbsp; 
      <button type="button" class="btn btn-sm btn-flat btn-point bg-darkcyan "> <i class="fas fa-file-excel"></i>&nbsp;  Excel </button>
    </div> <!-- end of col12 -->
    <div class="col-12 p-1 text-center">
      <?php if(!empty($tariff_list)) {?>
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
          <thead class="thead-light">
         
          <tr>
            <th>Sl.No</th>
            <th>Activity</th>
            <th>Form Name</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Date</th>
            <th>View</th>
          </tr>
      
             </thead>
             <tbody>
         <?php $i=1; foreach ($tariff_list as $tariff_value) {
               $id=$tariff_value['tariff_sl'];
               $activity_id=$tariff_value['tariff_activity_id'];
               $form_id=$tariff_value['tariff_form_id'];
               $vessel_type_id=$tariff_value['tariff_vessel_type_id'];
               $vessel_subtype_id=$tariff_value['tariff_vessel_subtype_id'];
               $start_date=$tariff_value['start_date'];
               $end_date=$tariff_value['end_date'];
               $survey_name=$tariff_value['survey_name'];
               $form_name=$tariff_value['document_type_name'];
               $vesseltype_name=$tariff_value['vesseltype_name'];
               $vessel_subtype_name=$tariff_value['vessel_subtype_name'];
               $start_date_view  = explode('-', $start_date);
               @$start_date_view  = $start_date_view[2]."/".$start_date_view[1]."/".$start_date_view[0];

                if(!empty($end_date))
                {
                   $end_date_view  = explode('-', $end_date);
                               @$end_date_view  = $end_date_view[2]."/".$end_date_view[1]."/".$end_date_view[0];
                }
                else
                {
                  $end_date_view="";
                }
         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $survey_name; ?></td>
            <td><?php echo $form_name; ?></td>
            <td><?php echo $vesseltype_name; ?></td>
            <td><?php echo $vessel_subtype_name; ?></td>
            <?php if($tariff_value['end_date']=='0000-00-00'){$msg="dd/mm/yyyy";}else{$msg=$end_date_view;} ?>
            <td><?php echo "From ".$start_date_view." To ".$msg; ?><input type="hidden" name="hid_startDate" id="hid_startDate" value="<?php echo $start_date; ?>"><input type="hidden" name="hid_endDate" id="hid_endDate" value="<?php echo $end_date; ?>"></td>            
            <td>                
                <a href="<?php echo $site_url."/Kiv_Ctrl/Survey/detViewTariff/$activity_id/$form_id/$vessel_type_id/$vessel_subtype_id/$start_date/$end_date"?>">
                <button name="edit_dynamic_page_btn_<?php echo $i;?>" id="edit_bank_btn_<?php echo $i;?>" class="btn btn-sm bg-blue btn-flat" type="button" >   <i class="fa fa-fw fa-plus-circle"></i>  </button>
                </a>
            </td>           
          </tr>
        <?php $i++;} ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Sl.No</th>
            <th>Activity</th>
            <th>Form Name</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Date</th>
            <th>View</th>
          </tr>
        </table>
      </div> <!-- end of table responsive -->
       <?php 
}
 ?>
    </div> <!-- end of col10 -->
   </div> <!-- end of table display row -->
  
</div> <!-- end of main content -->
</form>
<script type="text/javascript">
$(document).ready(function() {


//End of jquery
});


</script>