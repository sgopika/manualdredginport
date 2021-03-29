<div class="main-content ui-innerpage">  
  <div class="row no-gutters ">
    <div class="col-2 text-primary kivheader">
        <button type="button" class="btn btn-primary btn-block kivbutton"><i class="fas fa-dolly-flatbed"></i> Manual Dredging </button>
      </div> <!-- end of col2 text-primary kiv-header -->
      <div class="col-10 d-flex justify-content-end">
           <ol class="breadcrumb justify-content-end mb-0">
           <li class="breadcrumb-item"></li> 
         </ol>
      </div> <!-- end of col10 -->
  </div> <!-- end of main row -->
  <!-- --------------------------- Start of Dash board for PC  --------------------------------------------- -->
  <!-- start of inside content -->
<div class="row px-3">
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-user-graduate "></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/customer_requestprocessing"); ?>"> <h5 class="card-title">Customer Registration</h5></a></span>
        <p class="card-text"><small class="text-muted"> <?php echo $tn1;?> PENDING</small></p>
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 02 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-book-reader"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/customer_bookingapproval"); ?>"><h5 class="card-title">Customer Booking</h5></a></span>
        <p class="card-text"><small class="text-muted"> <?php echo $tn2;?> PENDING</small></p>
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 02 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 03 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-list-ol"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/monthlypermitapproval"); ?>"><h5 class="card-title">Monthly Permit</h5></a></span>

        <p class="card-text"><small class="text-muted"> <?php echo $tot_per_pend;?> PENDING</small></p>
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 03 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 04 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-calendar-alt"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/holidaysettings"); ?>"> <h5 class="card-title">Holiday Settings </h5></a></span><?php echo $holy_prd;?>

        <p class="card-text"><small class="text-muted"> <?php echo $tot_workdays;?> WORKING DAYS/ <?php echo $tot_holydays;?></small></p>

      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 04 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 05 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fab fa-gg"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Port/all_customer_booking_pc");?>"> <h5 class="card-title">Sand Bookings </h5></a></span>

        <p class="card-text"><small class="text-muted"> </small></p>

      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 05 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 06 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-calendar-day"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Port/customer_booking_pc_paid");?>"><h5 class="card-title">Date Change </h5></a></span>

        <p class="card-text"><small class="text-muted"> </small></p>

      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 06 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 07 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-user-check"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/customer_login");?>"><h5 class="card-title">Registered Customers </h5></a></span>

        <p class="card-text"><small class="text-muted"> </small></p>

      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 07 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 08 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-print"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/sand_issue_reprintApprove"); ?>"> <h5 class="card-title">Vehicle Pass Reprint </h5></a></span>

        <p class="card-text"><small class="text-muted"> </small></p>

      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 08 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 09 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-layer-group"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Port/zoneStatus"); ?>"><h5 class="card-title">Zone Status </h5></a></span>

        <p class="card-text"><small class="text-muted"> </small></p>

      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 09 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 10 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-receipt"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"> <a href="<?php echo site_url("Manual_dredging/Report/report"); ?>"><h5 class="card-title">Reports </h5></a></span>

        <p class="card-text"><small class="text-muted"> </small></p>

      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 10 -------------------------------------------------- -->


</div> <!-- end of row -->
<div class="row p-3">
	<div class="col-12">
		<div class="card">
      <div class="card-header  bg-forestgreen">
        <i class="fas fa-cogs"></i>&nbsp; <em class="h6 ">  Master Settings </em>
      </div> <!-- end of card header -->
  	</div> <!-- end of card -->
	</div> <!-- end of col12 -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/Zone"?>" class="btn btn-block btn-flat bg-hotpink buttontext btn-point "> Zone </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/lsgd"?>" class="btn btn-block btn-flat bg-crimson buttontext btn-point "> LSGD </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/quantity_pc"?>" class="btn btn-block btn-flat bg-cadetblue buttontext btn-point "> Quantity </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/bank"?>" class="btn btn-block btn-flat bg-darkorchid buttontext btn-point "> Bank </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-palevioletred buttontext btn-point "> Rate </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/canoeregistration"?>" class="btn btn-block btn-flat bg-burlywood buttontext btn-point "> Canoe </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/assignzone"?>" class="btn btn-block btn-flat bg-sienna buttontext btn-point "> Assign Kadavu </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/assignzone_sec"?>" class="btn btn-block btn-flat bg-mediumorchid buttontext btn-point "> Assign Section </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/userman_home"?>" class="btn btn-block btn-flat bg-darkslateblue buttontext btn-point "> User Management </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Port/mech_rate_pc"?>" class="btn btn-block btn-flat bg-teal buttontext btn-point "> Mechanical Dredging </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<!-- <div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/lsgd"?>" class="btn btn-block btn-flat bg-darkolivegreen buttontext btn-point "> Change Zone </a> 
	</div> --> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/update_dailylog_qty"?>" class="btn btn-block btn-flat bg-indianred buttontext btn-point "> Update Daily Balance </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/user_notice"?>" class="btn btn-block btn-flat bg-firebrick buttontext btn-point "> Send Message  </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/send_flash"?>" class="btn btn-block btn-flat bg-limegreen buttontext btn-point "> Flash Message </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/pc_user_changephno"?>" class="btn btn-block btn-flat bg-coral buttontext btn-point "> Change Phone Number </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/spot"?>" class="btn btn-block btn-flat bg-darkseagreen buttontext btn-point "> Spot Booking </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/lorry"?>" class="btn btn-block btn-flat bg-mediumaquamarine buttontext btn-point "> Lorry  </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/Seccustomer_requestprocessing"?>" class="btn btn-block btn-flat bg-midnightblue buttontext btn-point "> 2nd Registration View </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/Seccustomer_requestrejectedlist"?>" class="btn btn-block btn-flat bg-plum buttontext btn-point "> 2nd Registration Rejected </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/secondrequest_booking_pc_paid"?>" class="btn btn-block btn-flat bg-deeppink buttontext btn-point "> Move to changed date </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Report/worker_report_zone"?>" class="btn btn-block btn-flat bg-darkslategray buttontext btn-point "> Zone wise worker details</a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-2 py-2">
		<a  href="<?php echo base_url()."index.php/Manual_dredging/Master/customer_bookingsearch"?>" class="btn btn-block btn-flat bg-goldenrod buttontext btn-point "> Search Booking Details </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	</div> <!-- end of row -->
 <!-- --------------------------- End of Dash board for PC  ----------------------------------------------- -->
</div> <!-- end of main-content container -->