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

 <div class="main-content ui-innerpage"> 
 <div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Reports </span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
		<?php 
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if($sess_user_type==2){$url=site_url("Manual_dredging/Port/port_dir_main");}else if($sess_user_type==3){$url=site_url("Manual_dredging/Master/pcdredginghome");} else{$url=site_url('Manual_dredging/Port/port_clerk_main');} ?>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Reports</strong></a></li>
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
      <i class="fas fa-search"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Report/sale_report");?>">Sale Report</a></h5>
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
      <i class="fas fa-list"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Report/spotsale_report");?>">Spot Report</a></h5>
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
      <i class="fas fa-edit"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Master/genReport");?>">New Report</a></h5>
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
      <i class="fas fa-cog"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Report/workdone_approval");?>">Status</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
 </div>  <!---row px-3 close--->
 </div> <!--innerpage close-- >
  