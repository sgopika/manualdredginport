 <div class="main-content ui-innerpage"> 
 <div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">User management </span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>User management</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <div class="row px-3">
 <!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-user"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Report/spot_bookingsearch");?>">Search Booking</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-phone"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Report/spot_registration");?>">List of Online Spot</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-ban"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Report/spot_reg_details");?>">Spot Registration Assign Kadavu</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-user"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Port/addmodule_clerk");?>">Assign Module</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-user"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Report/settings_interval");?>">Settings</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-user"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
          
          <?php  $bookingtime_data= $this->Master_model->customerspotbooking_timecheck();
			$starttime=$bookingtime_data[0]['spotbooking_master_start'];
			$endtime=$bookingtime_data[0]['spotbooking_master_end'];
			$start_time=strtotime($starttime);
			$end_time=strtotime($endtime);
			//echo date_default_timezone_get();
			//echo date('Y-M-d h:i:s');
			//exit;
			$current_time=strtotime("now");
		if($current_time <= $start_time)
		{ $url=site_url("Report/spotlimit_view"); }else{$url='#';}?>
        <h5 class="card-title"><a href="<?php echo $url?>">Add Ton Limit</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
 </div>  <!---row px-3 close--->
 </div> <!--innerpage close-- >