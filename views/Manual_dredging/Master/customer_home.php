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
    <span class="badge bg-darkmagenta innertitle mt-2">Customer </span>
  </div>  <!-- end of col4 -->
  
  <div class="col-8 d-flex justify-content-end">
    <ol class="breadcrumb">
   
       
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
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Report/zone_stat");?>">Kadavu Booking Status</a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->
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
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Master/customer_booking_history"); ?>">Sand booking History</a></h5>
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
        <h5 class="card-title"><a href="<?php echo site_url("Manual_dredging/Report/customer_booking_request"); ?>" style="font-size: 13px;"> അനുവദിച്ച  തീയതിയിൽ മണൽ എടുക്കാൻ സാധിക്കാത്തവർ ഈ ലിങ്കിൽ ക്ലിക്ക് ചെയ്യുക </a></h5>
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
        <h5 class="card-title"><a href="<?php if(($status=="limit")&&($req_stat<2)){ 

        echo site_url("Manual_dredging/Report/customerregistration_view/".encode_url($purpose)); } else {?>#<?php }  ?>"><?php if($req_stat>=2) { echo "Registered"; }else{?>Apply for <?php if($purpose==1){ echo "Repair"; }else { echo "Construction"; } ?><?php } ?></a></h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
<!--<div class="col-3 py-2">
    
    <div class="card ">
  <div class="row no-gutters">
    <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
      <i class="fas fa-cog"></i>
    </div>
    <div class="col-8 leftbordercard">
      <div class="card-body">
        <h5 class="card-title"><a href="<?php if($upload=="yes"){ 

        echo site_url("Manual_dredging/Report/update_myfile"); } else {?>#<?php }  ?>" ><?php if($upload=="yes") { echo "Upload Permit/Tax Receipt"; }else{?><?php } ?></a></h5>
       </div> 
    </div> 
  </div> 
</div> 

</div> --><!-- end of col3/4 -->

<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->



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
        <h5 class="card-title">



         <?php 

        if($status=="buk_allow")

        { ?>
         <a href="<?php echo site_url("Manual_dredging/Master/customer_booking_add"); ?>">Customer booking</a>
       <?php  }

        else if($status=="limit")

        {  ?>

           <li style="color:#FF0000">You Have reached your booking Limit</li>

                   <?php

        }

        else if($status=="buk_blockw")

        {

          ?>

          <li style="color:#FF0000">You Have one booking under process</li>

          <?php

              }

        else

        { 
          ?> 
           <span class="info-box-number">Next Booking after >> <?php $nb_d=explode(" ",$nbd); echo date("d/m/Y",strtotime(str_replace('-', '/',$nb_d[0])));?></span>
          <?php 
        }

        ?>

        </h5>
       </div> <!-- end of card-body -->
    </div> <!-- end of col8 -->
  </div> <!-- end of row -->
</div>  <!-- end of card -->
<!-- ---------------- start of card --- ------------------------ -->
</div> <!-- end of col3/4 -->

<!-- ----------------------------------------------- END OF WIDGET 01 -------------------------------------------------- -->
 </div>  <!---row px-3 close--->
 </div> <!--innerpage close-- >
  




































