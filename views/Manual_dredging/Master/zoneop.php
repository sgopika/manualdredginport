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
    
     <div class="row no-gutters ">
    <div class="col-2 text-primary kivheader">
        <button type="button" class="btn btn-primary btn-block kivbutton"><i class="fas fa-dolly-flatbed"></i> Manual Dredging </button>
      </div> <!-- end of col2 text-primary kiv-header -->
      
  </div> <!-- end of main row -->
  
  <div class="row px-3">
     
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-list-ol "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Port/get_zone_pass_stat");?>">Sand Pass (<small><?php echo date('d-m-Y'); ?></small>)</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
    <i class="far fa-check-square"></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/sand_issue");?>">Sand Issue<br><small>(Verification)</small></a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->

<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
    <i class="fas fa-ticket-alt"></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/sand_issueotp");?>">Sand Issue(OTP)</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
      <!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-print  "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php  echo site_url("Manual_dredging/Master/sand_issue_reprintVw");?>">Sand Issue Reprint</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->

<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
    <i class="fas fa-ticket-alt"></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/sand_issue");?>">Sand Issue Spot Booking</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->

<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
     <i class="fas fa-ticket-alt"></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/sand_issueotpspot");?>">Spot Sand Issue(OTP)</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-truck "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/lorry_today");?>">Lorry Details</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
     <i class="far fa-list-alt"></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/get_sand_issue_det");?>">Vehicle Pass Details</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
     <i class="far fa-list-alt"></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/gen_salereportzone");?>">Daily Sale Report</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-3 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
     <i class="far fa-list-alt"></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/spotgen_salereport_zone");?>">Daily Sale Report Spot</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->




  </div>
</div>












