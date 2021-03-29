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
<script language="javascript">
    
$(document).ready(function()
{
   
   $("#lb1").hide();  
   $("#lb2").hide(); 

    $("#current_status_id").change(function()
    {
      var current_status_id   = $("#current_status_id").val();
      var session_usertype_id = $("#session_usertype_id").val();
      //alert(current_status_id);
      if(current_status_id==5)
      {
        $("#lb1").show();
        $("#lb2").show(); 
      }
      else
      {
        $('#surveyactivity_id').val('');
        $("#lb1").hide();
        $("#lb2").hide();  
      }

    });

//Jquery End  
});
</script>

<?php 
$processflow_sl =   $this->uri->segment(3);
$user_type_id   =   $this->session->userdata('user_type_id');

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
      <?php if($user_type_id==4) { ?>
        <li><a href="<?php echo $site_url."/Survey/csHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
        <?php } ?>

         <?php if($user_type_id==5) { ?>
        <li><a href="<?php echo $site_url."/Survey/SurveyorHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
        <?php } ?>

      <li><a href="<?php //echo $site_url."/Survey/InitialSurvey"?>"></i>  <span class="badge bg-blue"> Forward Survey Process </span> </a></li>
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

            $user_type_id       =   $this->session->userdata('user_type_id');
            $sess_usr_id        =   $this->session->userdata('user_sl');
            $process_id         =   $vessel_details[0]['process_id']; 
            $vessel_id          =   $vessel_details[0]['vessel_id']; 
            $current_status_id  =   $vessel_details[0]['current_status_id'];
            $vessel_user_id     =   $vessel_details[0]['vessel_user_id'];

            
            $vessel_usertype          =   $this->Survey_model->get_customer_details($vessel_user_id);
            $data['vessel_usertype']  =   $vessel_usertype;
            $vessel_user_type_id      =   $vessel_usertype[0]['user_type_id'];


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
            

            

           

            ?>
             
             <button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-plus-circle"></i><?php echo $msg; ?> -- <?php echo $vessel_details[0]['vessel_name']; ?></button>

               </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form id="form1" name='form1' method="post" action="<?php echo $site_url.'/Survey/Forward_SurveyProcess/'?>">

             <table id="example" class="table table-bordered table-striped">
             <tr>
              <td colspan="4">
              <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
              <input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
              <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
              <input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
              <input type="hidden" name="user_id" id="user_id" value="<?php echo $vessel_user_id; ?>">
              <input type="hidden" name="current_position" id="current_position" value="<?php echo  $vessel_user_type_id; ?>">
              <input type="text" name="session_usertype_id" value="<?php echo $user_type_id; ?>">
              </td>
            </tr>

            <tr id="survey3">
           <td>Survey Activity Date</td>
            <td><div class="div250">
              <div class="form-group">
              <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div><input type="text" class="form-control" id="datepicker3" name="inspection_date" title="Enter Inspection Date" data-validation="required">
              </div>
              </div>
              </div>
            </td>
            <td>Remarks</td>
            <td><textarea name="remarks" data-validation="required" id="remarks"></textarea></td>
            </tr>
            <tr>
            <td>Survey Process</td>
            <td>
            <?php if(($user_type_id==4) || ($user_type_id==5 && $process_id!=4)) { ?>

          <select name="current_status_id" id="current_status_id" class="form-control select2" data-validation="required">
          <option value="">Select</option>
          <option value="4">Revert</option>
          <option value="5">Approve</option>
          </select>
          <?php } ?>

          </td>

          <td><span id="lb1">Survey Activity</span></td>
          <td>
              <span id="lb2"><select name="surveyactivity_id" id="surveyactivity_id"  data-validation="required">
              <option value="">Select</option>
              <option value="3">Hull Inspection</option>
              <option value="4">Final Inspection</option>
              </select></span>
          </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Submit"></td>
            <td></td>
            <td></td>
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