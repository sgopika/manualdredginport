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
$vessel_id=$this->uri->segment(3);
$processflow_sl=$this->uri->segment(4);
$current_status         =   $this->Survey_model->get_status_details($vessel_id);
  $data['current_status'] =   $current_status;
  @$status_details_sl =$current_status[0]['status_details_sl'];

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
<button type="button" class="btn bg-primary btn-flat margin"> Initial Survey</button>
      </h1>
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?php echo $site_url."/Survey/SurveyHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
      <li><a href="<?php echo $site_url."/Survey/InitialSurvey"?>"></i>  <span class="badge bg-blue"> Initial Survey DashBoard </span> </a></li>
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
            <?php 
            $process_id=$vessel_details[0]['process_id']; 
            $current_status_id=$vessel_details[0]['current_status_id'];

            if($process_id==1)
            {
              $msg='Form 1 Verification';
            }
            if($process_id==2)
            {
              $msg='Keel Laying';
            }
            if($process_id==3)
            {
              $msg='Hull Inspection';
            }
            if($process_id==4)
            {
              $msg='Final Inspection';
            }
            $previous_module_id=$vessel_details[0]['previous_module_id'];

            $user_type_user_id         =   $this->Survey_model->get_user_type_user_id($previous_module_id);
            $data['user_type_user_id']   = $user_type_user_id;
            @$user_type_id1=$user_type_user_id[0]['current_position'];
            @$user_id1=$user_type_user_id[0]['user_id'];

            if(@$user_type_id1=='')
            {
              $user_type_id=4;
            }
            else
            {
              $user_type_id=$user_type_id1;
            }

             if(@$user_id1=='')
            {
              $user_id=4;
            }
            else
            {
              $user_id=$user_id1;
            }


            ?>
             
             <button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-plus-circle"></i><?php echo $msg; ?> -- <?php echo $vessel_details[0]['vessel_name']; ?></button>

               </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form id="form1" name='form1' method="post" action="<?php echo $site_url.'/Survey/Forward_Vessel/'?>">

             <table id="example" class="table table-bordered table-striped">
             <tr>
                 <td colspan="3">
                 <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
                 <input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
                <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
                <input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">

                <input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">

                </td>
               </tr>
               <tr>
                 <td>Forward To  <input type="hidden" name="current_status_id" id="current_status_id" value="2"></td>
                 <td>
                 <select name="current_position" id="current_position" class="form-control select2" data-validation="required">
                  <option value="">Select</option>
                  <option value="<?php echo $user_type_id; ?>"><?php if($user_type_id==4 || $user_type_id=='') { echo 'Chief Surveyor'; } if($user_type_id==5) { echo 'Surveyor'; }?></option>
                 </select></td>
                 <td><input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Submit"></td>
               </tr>
               
              </table>
              
            </form>
             

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