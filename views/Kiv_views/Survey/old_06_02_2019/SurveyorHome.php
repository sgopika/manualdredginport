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

<?php $sess_usr_id  =   $this->session->userdata('user_sl'); ?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
<button type="button" class="btn bg-primary btn-flat margin"> Page Description</button>
      </h1>
      <!-- Important; the following two ol class has to be kept, its not mistake -->
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>index.php/Survey/SurveyorHome"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
       <!-- <li><a href="#"></i>  <span class="badge bg-blue"> Page1 </span> </a></li>
        <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li>-->
      </ol> </ol> 
      <!-- End of two ol -->
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Header Section ends here -->
    <!-- Main content -->


<!-- __________________ Requests / Applications Start _______________________ -->
 <section class="content">

     <div class="row custom-inner">
        <div class="col-md-12">
          <ul class="timeline">
            <li class="time-label">
                  <span class="bg-red">
                   Requests / Applications
                  </span>
            </li>
  			 <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#"> Requests / Applications</a> </h3>
                <div class="timeline-body">
                  <div class="col-md-12">
                    <table id="vacbtable" class="table table-bordered table-striped">
                    <tr>
                      <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr>
                    <td>
                <div class="box-body">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl.No</th>
                  <th>Vessel Name</th>
                  <th>Reference Number</th>
                  <th>Vessel Type</th>
                  <th>Owner Name</th>
                  <th>Form</th>
                  <th>Survey</th>
                  
                  <th>Forward Date</th>
                  <th>Process</th>
                  <th>Status</th> 
                  <th>Verify</th>
                </tr>
                </thead>

                <?php
                $i=1;
                @$customer_name=$customer_details[0]['user_name'];
                foreach($initial_data as $res)
                {
                  $vessel_sl        = $res['vessel_sl'];
                  $vessel_type_id   = $res['vessel_type_id'];


                  $process_flow         =   $this->Survey_model->get_process_flow_show($vessel_sl, $sess_usr_id);
                  $data['process_flow'] =   $process_flow;
                  $current_status_id    =   $process_flow[0]['current_status_id'];
                  $processflow_sl       =   $process_flow[0]['processflow_sl'];
                  
                  $status               =   $process_flow[0]['status'];

                  @$process_id          =   $process_flow[0]['process_id'];
                  @$survey_id           =   $process_flow[0]['survey_id'];




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

                  $application_date=date("d-m-Y", strtotime($res['status_change_date']));
                  $processflow_sl=$res['processflow_sl'];

 					$process_name 			=	$this->Survey_model->get_process_name($process_id);
                  $data['process_name'] 	=   $process_name;
                  $process=$process_name[0]['process_name'];

                  $survey_name 			=	$this->Survey_model->get_survey_name($survey_id);
                  $data['survey_name'] 	=   $survey_name;
                  $survey=$survey_name[0]['survey_name'];


                  //Status display

				        $current_status         =   $this->Survey_model->get_status_details($vessel_sl);
                $data['current_status'] =   $current_status;
                 $status_details_sl =$current_status[0]['status_details_sl'];

                @$status_id=$current_status[0]['current_status_id'];
                @$sending_user_id=$current_status[0]['sending_user_id'];
                @$receiving_user_id=$current_status[0]['receiving_user_id'];
                @$process_id_status=$current_status[0]['process_id'];


                $user_type_details           =   $this->Survey_model->get_user_master($receiving_user_id);
                $data['user_type_details']    =   $user_type_details;
                @$usertype_name =$user_type_details[0]['user_type_name'];


             

                if($process_id_status==1)
                {
                  $message1='<span class="badge bg-success">Form 1 Verification</span>';
                }
                if($process_id_status==2)
                {
                  $message1='<span class="badge bg-success">Keel Laying</span>';
                }

            if($process_id_status==3)
                {
                  $message1='<span class="badge bg-success">Hull Inspection</span>';
                }

                 if($process_id==1 || $process_id==2 || $process_id==3 || $process_id==4 ||  $process_id=='')
                  {
                    $form_no=1;
                  }
                  else
                  {
                    $form_no=$process_id;
                  }



                ?>
                <tbody>
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $res['vessel_name']; ?></td>
                <td></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td><?php echo $customer_name; ?></td>
                 <td>Form&nbsp; <?php echo $form_no;?></td>
                <td><?php echo $survey; ?></td>
                <td><?php echo $application_date; ?> </td>
                <td><?php echo $message1; ?></td>
                <td></td>
                <td>
                <?php if($status==1) { ?>
                <a href="<?php echo $site_url.'/Survey/Verify_Vessel_surveyor/'.$vessel_sl.'/'.$processflow_sl ?>" class="btn btn-danger btn-xs">Verify</a>
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
                  <th>Vessel Name</th>
                  <th>Reference Number</th>
                  <th>Vessel Type</th>
                  <th>Owner Name</th>
                  <th>Form</th>
                  <th>Survey</th>
                  
                  <th>Forward Date</th>
                  <th>Process</th>
                  <th>Status</th> 
                  <th>Verify</th>
                </tr>
                </tfoot>

              </table>
              </div>


                    </td>
                    </tr>




                  </table>
                  </div>
                </div>
                <div class="timeline-footer">
                  <a href="form1view.php" class="btn btn btn-xs"> </a>
                  <a href="form.php" class="btn btn btn-xs"></a>
                </div>
              </div>
            </li>
            
</ul>
</div>
</div></section>

<!-- __________________ Requests / Applications End _______________________ -->




<!-- __________________ Tasks Start _______________________ -->
 <section class="content">

     <div class="row custom-inner">
        <div class="col-md-12">
          <ul class="timeline">
            <li class="time-label">
                  <span class="bg-red">
                   Tasks
                  </span>
            </li>
  			 <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#"> Tasks</a> </h3>
                <div class="timeline-body">
                  <div class="col-md-12">
                    <table id="vacbtable" class="table table-bordered table-striped">
                    <tr>
                      <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr>
                    <td>
                <div class="box-body">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl.No</th>
                  <th>Vessel Name</th>
                  <th>Reference Number</th>
                  <th>Vessel Type</th>
                  <th>Owner Name</th>
                  <th>Form</th>
                  <th>Survey</th>
                  
                  <th>Forward Date</th>
                  <th>Process</th>
                  <th>Inspection Date</th> 
                  <th>Verify</th>
                </tr>
                </thead>

                <?php
                $i=1;
                @$customer_name1=$customer_details1[0]['user_name'];
                foreach($data_task as $res1)
                {
                  $vessel_sl              = $res1['vessel_sl'];
                  @$vessel_type_id        = $res1['vessel_type_id'];
                  @$processflow_sl        = $res1['processflow_sl'];
                  @$current_status_id     = $res1['current_status_id'];
                  @$status                = $res1['status'];
                   
                  @$process_id            = $res1['process_id'];
                  @$survey_id             = $res1['survey_id'];

         



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

                  $application_date=date("d-m-Y", strtotime($res1['status_change_date']));
                   $inspection_date=date("d-m-Y", strtotime($res1['assign_date']));
                  

 					$process_name 			=	$this->Survey_model->get_process_name($process_id);
                  $data['process_name'] 	=   $process_name;
                  $process=$process_name[0]['process_name'];

                  $survey_name 			=	$this->Survey_model->get_survey_name($survey_id);
                  $data['survey_name'] 	=   $survey_name;
                  $survey=$survey_name[0]['survey_name'];


                  

				  $current_status         =   $this->Survey_model->get_status_details($vessel_sl);
                $data['current_status'] =   $current_status;
                 $status_details_sl =$current_status[0]['status_details_sl'];

                @$status_id=$current_status[0]['current_status_id'];
                @$sending_user_id=$current_status[0]['sending_user_id'];
                @$receiving_user_id=$current_status[0]['receiving_user_id'];
                @$process_id_status=$current_status[0]['process_id'];


                $user_type_details           =   $this->Survey_model->get_user_master($receiving_user_id);
                $data['user_type_details']    =   $user_type_details;
                @$usertype_name =$user_type_details[0]['user_type_name'];


             

                if($process_id_status==1)
                {
                  $message1='<span class="badge bg-success">Form 1 Verification</span>';
                }
                if($process_id_status==2)
                {
                  $message1='<span class="badge bg-success">Keel Laying</span>';
                }
                 if($process_id_status==3)
                {
                  $message1='<span class="badge bg-success">Hull Inspection</span>';
                }

                if($process_id_status==4)
                {
                  $message1='<span class="badge bg-success">Final Inspection</span>';
                }

                
                $form_number           =   $this->Survey_model->get_form_number($process_id);
                $data['form_number']    =   $form_number;
                @$form_no =$form_number[0]['form_no'];
              
                ?>
                <tbody>
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $res1['vessel_name']; ?></td>
                <td></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td><?php echo $customer_name1; ?></td>
                <td>Form&nbsp; <?php echo $form_no;?></td>
                <td><?php echo $survey; ?></td>
                <td><?php echo $application_date; ?> </td>
                <td><?php echo $message1; ?></td>
                <td><?php echo $inspection_date; ?></td>
                <td>
                <?php if($status==1) { ?>
                <a href="<?php echo $site_url.'/Survey/srTask/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id  ?>" class="btn btn-danger btn-xs">Verify</a>
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
                  <th>Vessel Name</th>
                  <th>Reference Number</th>
                  <th>Vessel Type</th>
                  <th>Owner Name</th>
                  <th>Form</th>
                  <th>Survey</th>
                  
                  <th>Forward Date</th>
                  <th>Process</th>
                  <th>Inspection Date</th>
                  <th>Verify</th>
                </tr>
                </tfoot>

              </table>
              </div>


                    </td>
                    </tr>




                  </table>
                  </div>
                </div>
                <div class="timeline-footer">
                  <a href="form1view.php" class="btn btn btn-xs"> </a>
                  <a href="form.php" class="btn btn btn-xs"></a>
                </div>
              </div>
            </li>
            
</ul>
</div>
</div></section>

<!-- __________________ Tasks End _______________________ -->





    <section class="content">
   <!-- Main Content starts here -->
    <!-- PANEL ROW START -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border bg-info">
              <h3 class="box-title"><i class="fa fa-fw  fa-history"></i> <font color="0000ff"> Initial Survey </font> </font></h3>
            </div>

	<!-- /.box-header -->
	<div class="box-body bg-info">
	<div class="row">
	<div class="col-md-12">

	<!-- Inside Div -->

		<!-- BOX 1-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<a href="<?php echo base_url();?>index.php/Survey/cs_InitialSurvey">
		<div class="info-box">
		<span class="info-box-icon bg-orange"><i class="fa fa-fw fa-sort-amount-desc"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h5> <font color="#0000ff">New Applications(Form 1)</font> </h5>  <br><br></span>
		</div>
		</div>
		</a>
		</div>
		<!-- /.col -->
		<!-- BOX 1 END -->

		<!-- BOX 2-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<a href="<?php echo base_url();?>index.php/Survey/ApprovedApplication">
		<div class="info-box">
		<span class="info-box-icon bg-lime"><i class="fa fa-fw fa-graduation-cap"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h5> <font color="#0000ff"> Approved Applications  </font> </h5>  <br><br></span>
		</div>
		</div>
		</a>
		</div> 
		<!-- /.col -->
		<!-- BOX 2 END -->



		<!-- BOX 3-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<a href="<?php echo base_url();?>index.php/Survey/KeelLaying">
		<div class="info-box">
		<span class="info-box-icon bg-lime"><i class="fa fa-fw fa-graduation-cap"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> Keel Laying  </font> </h4>  <br><br></span>
		</div>
		</div>
		</a>
		</div> 
		<!-- /.col -->
		<!-- BOX 3 END -->


		<!-- BOX 4-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<a href="<?php echo base_url();?>index.php/Survey/HullInspection">
		<div class="info-box">
		<span class="info-box-icon bg-purple"><i class="fa fa-fw fa-line-chart"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> Hull Inspection  </font> </h4>  <br><br></span>
		</div>
		</div>
		</a>
		</div>
		<!-- /.col -->
		<!-- BOX 4 END -->

		<!-- BOX 5-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<a href="<?php echo base_url();?>index.php/Survey/FinalInspection">
		<div class="info-box">
		<span class="info-box-icon bg-primary"><i class="fa fa-fw fa-crop"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> Final Inspection </font> </h4>  <br><br></span>
		</div>
		</div>
		</a>
		</div>
		<!-- /.col -->
		<!-- BOX 5 END -->



		<!-- BOX 6-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<a href="<?php echo base_url();?>index.php/Survey/rejectedApplication">
		<div class="info-box">
		<span class="info-box-icon bg-primary"><i class="fa fa-fw fa-crop"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h5> <font color="#0000ff"> Rejected Applications </font> </h5>  <br><br></span>
		</div>
		</div>
		</a>
		</div>
		<!-- /.col -->
		<!-- BOX 6 END -->




	<!-- End of inside Div -->

	</div>
	<!-- /.col -->
	</div>
	<!-- /.row -->
	</div>
	<!-- ./box-body -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- PANEL ROW END -->
      
      <!-- PANEL ROW START -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border bg-info">
              <h3 class="box-title"><i class="fa fa-fw  fa-cloud-upload"></i> <font color="0000ff"> <!-- Utilties --> </font> </font></h3>
            </div>
	<!-- /.box-header -->
	<div class="box-body bg-info">
	<div class="row">
	<div class="col-md-12">

	<!-- Inside Div -->

		<!-- BOX 1-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-lime"><i class="fa fa-fw fa-files-o"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> <!-- Registration -->  </font> </h4>  <br><br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 1 END -->

		<!-- BOX 2-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-purple"><i class="fa fa-fw  fa-file-code-o"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> <!-- Name Change --> </font> </h4>  <br><br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 2 END -->

		<!-- BOX 3-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-primary"><i class="fa fa-fw fa-crosshairs"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"><!--  Renewal of <br> Registration  --> </font> </h4>  <br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 3 END -->

		<!-- BOX 4-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-blue"><i class="fa fa-fw fa-briefcase"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> <!-- Ownership<br> change -->  </font> </h4>  <br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 4 END -->

		<!-- BOX 5-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-green"><i class="fa fa-fw fa-object-ungroup"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> <!-- Duplicate<br>Certificate -->  </font> </h4>  <br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 5 END -->

		<!-- BOX 6-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-red"><i class="fa fa-fw fa-paper-plane"></i></span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> <!-- Alteration of<br>Vessel -->  </font> </h4>  <br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 6 END -->

		<!-- BOX 7-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-maroon"><i class="fa fa-fw  fa-quote-right"></i> </span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"> <!-- Tab 7 -->  </font> </h4>  <br><br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 7 END -->

		<!-- BOX 8-->
		<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
		<span class="info-box-icon bg-maroon"><i class="fa fa-fw  fa-quote-right"></i> </span>
		<div class="info-box-content bg-default">
		<span class="info-box-text"> <h4> <font color="#0000ff"><!--  Tab 8  --> </font> </h4>  <br><br></span>
		</div>
		</div>
		</div>
		<!-- /.col -->
		<!-- BOX 8 END -->

	<!-- End of inside Div -->

	</div>
	<!-- /.col -->
	</div>
	<!-- /.row -->
	</div>
	<!-- ./box-body -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- PANEL ROW END -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->sss