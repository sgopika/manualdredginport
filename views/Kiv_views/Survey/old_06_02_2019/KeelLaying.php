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
<?php $user_type_id = $this->session->userdata('user_type_id'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
<button type="button" class="btn bg-primary btn-flat margin"> Initial Survey Timeline </button>
      <!-- Important; the following two ol class has to be kept, its not mistake -->
      <ol class="breadcrumb">
      <ol class="breadcrumb">
         <?php if($user_type_id==4) { ?>
        <li><a href="<?php echo base_url();?>index.php/Survey/csHome"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
        <?php } ?>
        <?php if($user_type_id==5) { ?>
        <li><a href="<?php echo base_url();?>index.php/Survey/SurveyorHome"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
        <?php } ?>

       <li><a href="#"></i>  <span class="badge bg-blue"> Keel Laying </span> </a></li>
        <!--  <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li> -->
      </ol> </ol> 
      <!-- End of two ol -->
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Header Section ends here -->
    <!-- Main content -->
    <section class="content">
   <!-- Main Content starts here -->

     <div class="row custom-inner">
      <!-- start inner custom row -->
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    Initial Survey / Keel Laying Applications
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->


            <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Keel Laying</a> </h3>
                <div class="timeline-body">
                  <div class="col-md-12">
                    <table id="vacbtable" class="table table-bordered table-striped">
                    <tr>
                      <td colspan="3"><!--  See Rule 5 (1) - Form for expressing the intention to build a new vessel --></td>
                    </tr>

                  <!--   <tr>
                      <td colspan="3"> Submitted Date : 12.05.2018 <br>
                  Preferred Inspection Date : 21.05.2018</td>
                    </tr> -->
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
                  <th>Application Date</th>
                  <th>Status</th>
                  <th>Forward</th>
                </tr>
                </thead>

                <?php
                $i=1;
                @$customer_name=$customer_details[0]['user_name'];
                foreach($initial_data as $res)
                {
                  $vessel_sl=$res['vessel_sl'];

                  $vessel_type_id=$res['vessel_type_id'];
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

                    $application_date=date("d-m-Y", strtotime($res['vessel_created_timestamp']));
                     $processflow_sl=$res['processflow_sl'];

                    $process_remarks          =   $this->Survey_model->get_process_remarks($processflow_sl);
                    $data['process_remarks']  =   $process_remarks;
                    @$remarks=$process_remarks[0]['remarks'];


                ?>
                <tbody>
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $res['vessel_name']; ?></td>
                <td>reference Number</td> 
                <td><?php echo $vessel_type_name; ?></td>
                <td><?php echo $customer_name; ?></td>
                <td><?php echo $application_date; ?></td>
                <td><?php echo $remarks; ?></td> 
                <td> <a href="<?php echo $site_url.'/Survey/Forward_SurveyProcess/'.$processflow_sl ?>"  class="btn btn-primary btn-xs">Forward</a> 

 
                </td>
                </tr>
                </tbody>
                <?php
                $i++;
                }
                ?>

                 <!-- <tfoot>
                 <tr>
                  <th>Sl.No</th>
                  <th>Vessel Name</th>
                  <th>Reference Number</th>
                  <th>Vessel Type</th>
                  <th>Owner Name</th>
                  <th>Application Date</th>
                 <th>Reason for Rejection</th>
                  <th>View</th>
                </tr>
                </tfoot> -->

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
            <!-- END timeline item -->
            <!-- timeline item -->


<!-- 
            <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Port of Registry Verification</a> </h3>

                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Approved</a> <br>
                  Verification Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Approve</a>
                  <a class="btn btn-danger btn-xs">Reject</a>
                </div>
              </div>
            </li> -->


            <!-- END timeline item -->
            <!-- timeline item -->

          <!--   <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Chief Surveyor Verification</a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Delegate to Surveyor Name</a> <br>
                  Verification Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Delegate</a>
                  <a class="btn btn-warning btn-xs">Accept</a>
                </div>
              </div>
            </li>
 -->
            <!-- END timeline item -->
            <!-- timeline item -->


           <!--  <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Surveyor Inspection | Keel</a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Approved</a> <br>
                  Inspection Date : 21.05.2018 <br>
                  Remarks: 
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Approve</a>
                  <a class="btn btn-warning btn-xs">Reject</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->
            <!-- timeline item -->

          <!--   <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Surveyor Inspection | Hull</a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Approved</a> <br>
                  Inspection Date : 21.05.2018 <br>
                  Remarks: 
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Approve</a>
                  <a class="btn btn-warning btn-xs">Reject</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->
            <!-- timeline item -->

<!-- 
            <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Surveyor Inspection | Final</a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Approved</a> <br>
                  Inspection Date : 21.05.2018 <br>
                  Remarks: 
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Approve</a>
                  <a class="btn btn-warning btn-xs">Reject</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->
            <!-- timeline item -->

            <!-- <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="form3link.php">Form No. 3</a> </h3>
                <div class="timeline-body">
                  Submitted Date : 21.05.2018 <br>
                </div>
              </div>
            </li>
 -->

            <!-- END timeline item -->
            <!-- timeline item -->

           <!--  <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Port of Registry Verification</a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Approved</a> <br>
                  Verification Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Approve</a>
                  <a class="btn btn-danger btn-xs">Reject</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->
            <!-- timeline item -->

            <!-- <li>
              <i class="fa fa-envelope bg-default"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="form4link.php">Form No. 4</a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Delegate to Surveyor Name</a> <br>
                  Verification Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Delegate</a>
                  <a class="btn btn-warning btn-xs">Accept</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->
            <!-- timeline item -->


           <!--  <li>
              <i class="fa fa-envelope bg-default"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="defectlink.php">Defect Notice</a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Approved</a> <br>
                  Inspection Date : 21.05.2018 <br>
                  Remarks: 
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Approve</a>
                  <a class="btn btn-warning btn-xs">Reject</a>
                </div>
              </div>
            </li> -->


            <!-- END timeline item -->
            <!-- END timeline item -->
            <!-- timeline item -->


           <!--  <li>
              <i class="fa fa-envelope bg-default"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="form5link.php">Form 5 or 6</a> </h3>
                <div class="timeline-body">
                   Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs" href="form6view.php">View</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->
            <!-- timeline item -->

            <!-- <li>
              <i class="fa fa-envelope bg-default"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="form7link.php">Form 7</a> </h3>
                <div class="timeline-body">
                  Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                  <a class="btn btn-success btn-xs">Approve</a>
                  <a class="btn btn-danger btn-xs">Reject</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->
            <!-- timeline item -->

            <!-- <li>
              <i class="fa fa-envelope bg-default"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="form8link.php">Form 8 </a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Issued</a> <br>
                  Issue Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">View</a>
                
                </div>
              </div>
            </li>



            <li>
              <i class="fa fa-envelope bg-default"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="form10link.php">Form 9 or 10 </a> </h3>
                <div class="timeline-body">
                  <a class="btn btn-primary btn-sm">Issued</a> <br>
                  Issue Date : 21.05.2018
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs" href="form10view.php">View</a>
                </div>
              </div>
            </li> -->

            <!-- END timeline item -->

            <!--  <li class="time-label">
                  <span class="bg-red">
                    Registration
                  </span>
            </li> -->

          </ul>
        </div>
        <!-- /.col -->
       </div>
     <!-- End of Row Custom-Inner -->
  <!-- Main Content Ends here -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->