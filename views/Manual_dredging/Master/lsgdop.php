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
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-list-ol "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/monthlypermit");?>">Monthly Permit</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-list-ol "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/spotsale_report"); ?>">Spot Sale Report</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-list-ol "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/reg_lorry"); ?>">Lorry Registration</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-list-ol "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Report/sale_report_zone"); ?>">Sale Report</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!-- ----------------------------------------------- START OF WIDGET 01 -------------------------------------------------- -->
 <div class="col-4 py-2">
    <!-- ---------------- start of card --- ------------------------ -->
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-list-ol "></i>
    </div>
    <div class="col-6 leftbordercard">
      <div class="card-body">
       <span class="info-box-number"><a href="<?php echo site_url("Manual_dredging/Master/workerregistration"); ?>">Worker Registration</a></span>
        
      </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->

      
  </div>
</div>








