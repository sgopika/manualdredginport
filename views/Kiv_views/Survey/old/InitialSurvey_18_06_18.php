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
       <!-- <li><a href="#"></i>  <span class="badge bg-blue"> Page1 </span> </a></li>
        <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li>-->
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
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                     <?php 
                      $i=1; 
                foreach($vessel_details as $result_vessel)
                {
                   $vessel_sl=$result_vessel['vessel_sl'];
                   
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
                   
                 if($stage_count==1)
                 {
                     $message='Basic Details Completed';
                 }
                 if($stage_count==2)
                 {
                     $message='Hull Completed';
                 }
                  if($stage_count==3)
                 {
                     $message='Engine Completed';
                 }
                  if($stage_count==4)
                 {
                     $message='Equipment Completed';
                 }
                  if($stage_count==5)
                 {
                     $message='Fire Appliance Completed';
                 }
                  if($stage_count==6)
                 {
                     $message='Other Equipments Completed';
                 }
                  if($stage_count==7)
                 {
                     $message='Documents Upload Completed';
                 }
                  if($stage_count==8)
                 {
                     $message='Payment Completed';
                 }
                 
                ?>
                <tbody>
                <tr>
                  <td><?php echo $i; ?> </td>
                  <td> <?php echo 'Reference Number';?> </td>
                  <td> <?php echo $result_vessel['vessel_name'];?> </td>
                  <td> <?php echo $vesselcategory_name;?> </td>
                  <td> Form&nbsp; <?php echo $result_vessel['form'];?>  </td>
                  <td> 
                      <span class="badge bg-red"><?php echo $message; ?></span> 
                  </td>
                  <td> <?php if($stage_count<8) { ?> <a href="<?php echo $site_url.'/Survey/edit_Vessel/'.$vessel_sl.'/'.$stage_count; ?>"><button type="button" class="btn btn-default"> <i class="fa fa-pencil"></i> Edit </button></a>
                  <?php
                  }
  else {
     ?>
             <a href="form1view.php"><button type="button" class="btn btn-default"> <i class="fa fa-newspaper-o"></i> View </button></a>          
                      <?php
 }
                  ?>
                  
                  </td>
                </tr>
                <!--<tr>
                  <tr>
                  <td> 2. </td>
                  <td> 1564/2018 </td>
                  <td> Kulathungal </td>
                  <td> Houseboat </td>
                  <td> Form 1 </td>
                  <td> <span class="badge bg-success">Payment Completed</span> </td>
                  <td>  <a href="form1view.php"><button type="button" class="btn btn-default"> <i class="fa fa-newspaper-o"></i> View </button></a></span></td>
                </tr> -->
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