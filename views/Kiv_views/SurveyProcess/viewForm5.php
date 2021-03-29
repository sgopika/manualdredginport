<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>
<?php 
$sess_usr_id  =   $this->session->userdata('user_sl'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
      <button type="button" class="btn bg-primary btn-flat margin">Initial Survey</button>
      </h1>
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?php echo $site_url."/Survey/SurveyHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
      <li><a href="#"></i>  <span class="badge bg-blue">Initial Survey DashBoard </span> </a></li>
       <!-- <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li>-->
      </ol></ol>
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-10">
          <div class="box">
            <div class="box-header">
              <a href="<?php echo $site_url."/Survey/add_newVessel"?>">
             <button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-plus-circle"></i> New Initial Survey</button> </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl.No</th>
                  <th>Reference Number</th>
                  <th>Vessel Name</th>
                  <th>Category</th>
                  <th>Form</th>
                  <th>Process</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                     <?php 
                      $i=1; 
                foreach($vessel_details as $result_vessel)
                {
                  $vessel_sl=$result_vessel['vessel_sl'];

                  //process flow

                  $process_flow         =   $this->Survey_model->get_process_flow_show($vessel_sl, $sess_usr_id);
                  $data['process_flow'] =   $process_flow;
                  @$current_status_id   =   $process_flow[0]['current_status_id'];
                  @$processflow_sl      =   $process_flow[0]['processflow_sl'];
                  @$process_id          =   $process_flow[0]['process_id'];
                  @$status              =   $process_flow[0]['status'];
                



                  $vessel_category_id=$result_vessel['vessel_category_id'];
                  if($vessel_category_id!=0)
                  {
                    $vessel_category			= 	$this->Survey_model->get_vessel_category($vessel_category_id);
                    $data['vessel_category']	=	$vessel_category;
                    $vesselcategory_name=$vessel_category[0]['vesselcategory_name'];
                  }
                  else{
                  $vesselcategory_name="-";
                  }

                  $stage_count=$result_vessel['stage_count'];
                   
                 /*if($stage_count==1)
                 {
                     $message='<span class="badge bg-red">Basic Details Completed</span>';
                 }
                 if($stage_count==2)
                 {
                     $message='<span class="badge bg-red">Hull Completed</span>';
                 }
                  if($stage_count==3)
                 {
                     $message='<span class="badge bg-red">Engine Completed</span>';
                 }
                  if($stage_count==4)
                 {
                     $message='<span class="badge bg-red">Equipment Completed</span>';
                 }
                  if($stage_count==5)
                 {
                     $message='<span class="badge bg-red">Fire Appliance Completed</span>';
                 }
                  if($stage_count==6)
                 {
                     $message='<span class="badge bg-red">Other Equipments Completed</span>';
                 }
                  if($stage_count==7)
                 {
                     $message='<span class="badge bg-red">Documents Upload Completed</span>';
                 }
                  if($stage_count==8)
                 {
                     $message='<span class="badge bg-success">Payment Completed</span>';
                 }*/
                 
              /*$process_flow_status         =   $this->Survey_model->get_process_flow_show_status($vessel_sl, $sess_usr_id);
                $data['process_flow_status'] =   $process_flow_status;
                @$current_status_show       =   $process_flow_status[0]['current_status'];*/


                 /*$survey_name       = $this->Survey_model->get_survey_name($survey_id);
                  $data['survey_name']  =   $survey_name;
                  $survey=$survey_name[0]['survey_name'];*/


               
                $vessel_rejection     =   $this->Survey_model->get_vessel_rejection($vessel_sl);
                $data['vessel_rejection']  = $vessel_rejection;
                @$reject_count= $vessel_rejection[0]['reject_count'];


                $current_status         =   $this->Survey_model->get_status_details($vessel_sl);
                $data['current_status'] =   $current_status;

                @$status_id=$current_status[0]['current_status_id'];
                @$sending_user_id=$current_status[0]['sending_user_id'];
                @$receiving_user_id=$current_status[0]['receiving_user_id'];
                @$process_id_status=$current_status[0]['process_id'];
                @$status_details_sl =$current_status[0]['status_details_sl'];

                $user_type_details           =   $this->Survey_model->get_user_master($receiving_user_id);
                $data['user_type_details']    =   $user_type_details;
                @$usertype_name =$user_type_details[0]['user_type_type_name'];

                $user_type_details1           =   $this->Survey_model->get_user_master($sending_user_id);
                $data['user_type_details1']    =   $user_type_details1;
                @$usertype_name_from =$user_type_details1[0]['user_type_type_name'];

                //Status Display
                if($status_id=='')
                {
                  $message='<span class="badge bg-success">Payment Completed</span>';
                }
                if($status_id==1)
                {
                  $message='<span class="badge bg-success">Payment Completed</span>';
                }
                 if($status_id==2)
                {
                  $message='<span class="badge bg-success">Forwarded to '.$usertype_name.'</span>';
                }
                 if($status_id==3)
                {
                  $message='<span class="badge bg-success">Application Rejected</span>';
                }

                if($status_id==4)
                {
                  $message='<span class="badge bg-success">Revert from '.$usertype_name_from.'</span>';
                }

                  if($status_id==5)
                {
                  $message='<span class="badge bg-success">Approved</span>';
                }

                 if($status_id==6)
                {
                  $message='<span class="badge bg-success">Approved & Forward</span>';
                }

                 if($status_id==2 && $process_id_status==2)
                {
                  $message='<span class="badge bg-success">Started</span>';
                }

                if($status_id==2 && $process_id_status==3)
                {
                  $message='<span class="badge bg-success">Started</span>';
                }
                 if(($status_id==2 && $process_id_status==4) || ($status_id==1 && $process_id_status==5))
                {
                  $message='<span class="badge bg-success">Started</span>';
                }

                


                //Process Display

                 if($process_id_status==0)
                {
                  $message1='<span class="badge bg-success">Initial</span>';
                }

                if($process_id_status==1)
                {
                  $message1='<span class="badge bg-success">Verification</span>';
                }
                if($process_id_status==2)
               
                {
                  $message1='<span class="badge bg-success">Keel Laying </span>';
                }

                if($process_id_status==3)
                {
                  $message1='<span class="badge bg-success">Hull Inspection</span>';
                }

                 if($process_id_status==4)
                {
                  $message1='<span class="badge bg-success">Final Inspection</span>';
                }

                 if($process_id_status==5)
                {
                  $message1='<span class="badge bg-success">Form 3</span>';
                }

                if($status_id==3)
                {
                  $message1='<span class="badge bg-success">-</span>';
                }


                 if($process_id_status==1 && $status_id==1)
                {
                  $message1='<span class="badge bg-success">-</span>';  
                }

                 if($process_id_status==5 && $status_id==2)
                {
                  $message1='<span class="badge bg-success">Form 3</span>';  
                }


               /* $form_number           =   $this->Survey_model->get_form_number($process_id);
                $data['form_number']    =   $form_number;
                @$form_no =$form_number[0]['form_no'];*/

                $form_number           =   $this->Survey_model->get_form_number($vessel_sl);
                $data['form_number']    =   $form_number;
                @$form_no =$form_number[0]['form_no'];



                  

                ?>
                <tbody>
                <tr>
                  <td><?php echo $i; ?><input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>"></td>
                  <td><?php echo 'Reference Number';?> </td>
                  <td><?php echo $result_vessel['vessel_name'];?> </td>
                  <td><?php echo $vesselcategory_name;?> </td>
                  <td>Form&nbsp; <?php echo $form_no; ?>  </td>
                  <td> <?php echo $message1.$process_id_status; ?>    </td>
                  <td> <?php echo $message.$status_id; ?>    </td>
                  <td> 
                  <?php if($process_id==1 || $process_id==2 || $process_id==3 || $process_id==4)
                 {
                ?>
                  <?php if($status==1) { ?>  <a href="<?php echo $site_url.'/Survey/Edit_Vessel/'.$vessel_sl.'/'.$stage_count; ?>"><button type="button" class="btn btn-default"> <i class="fa fa-pencil"></i> Edit </button></a> 
                  &nbsp; 
                   <a href="<?php echo $site_url.'/Survey/Forward_Vessel/'.$vessel_sl.'/'.$processflow_sl ?>">
                     <button type="button" class="btn btn-default"> <i class="fa fa-newspaper-o"></i> Forward </button></a> 
                  <?php
                  }
  
                  else {
                    if($reject_count==0)
                    {
                      ?>
                       <a href="<?php echo $site_url.'/Survey/View_Vessel/'.$vessel_sl ?>">
                     <button type="button" class="btn btn-default"> <i class="fa fa-newspaper-o"></i> View </button></a> 

                      <?php

                    }
                   
                     
                      
                    } 
                  }
                  if($process_id==5)
                  {
                    ?>
                    <a href="<?php echo $site_url.'/Survey/Add_Form3/'.$vessel_sl ?>">
                     <button type="button" class="btn btn-default"> <i class="fa fa-newspaper-o"></i> Add Form 3 Details </button></a> 
                    <?php
                  }
                  ?>
                  
                  </td>
                </tr>
                
              
                
                </tbody>
                <?php 
                $i++;
                }
                ?>
                <tfoot>
                <tr>
                  <th>Sl.No</th>
                  <th>Reference Number</th>
                  <th>Vessel Name</th>
                  <th>Category</th>
                  <th>Form</th>
                   <th>Process</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->