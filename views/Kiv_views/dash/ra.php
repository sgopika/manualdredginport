<?php 
echo $sess_usr_id    = $this->session->userdata('int_userid');
echo $user_type_id   = $this->session->userdata('int_usertype');

?>

<!-- Container Class overridden for edge free design -->
<div class="main-content ui-innerpage">  
<!-- --------------------------------- -- First row starts here -- ------------------------------------------ -->
<div class="row no-gutters">
    <div class="col-3 text-primary kivheader">
        <button type="button" class="btn btn-primary btn-block kivbutton"><i class="fas fa-ship"></i> Kerala Inland Vessel</button>
      </div> <!-- end of col3 -->
      <div class="col-9"> </div>
</div> <!-- end of row -->
<!-- --------------------------------- -- First row starts here -- ------------------------------------------ -->
<!-- --------------------------------- -- Second row starts here -- ------------------------------------------ -->
<div class="row no-gutters">
  <?php 
             $cnt=count($menu);
             for($i=0;$i<2;$i++)
             //foreach($menu as $details)
            { 
                if($i==0){
                  $table = "vw_rainbox_cnt";
                }
                if($i==1){
                  $table = "vw_raregcert_cnt";
                }
                if($table!=""){ 
                $get_count  = $this->Survey_model->get_view_count($table);//print_r($get_count);
                if(!empty($get_count)){
                 foreach($get_count as $vw_res){
                    $uid       = $vw_res['uid'];
                    $sess_user  = $_SESSION['int_userid'];
                    if($i==0){
                      if($uid==$sess_user){
                        @$vw_cnt   = $vw_res['cnt'];
                      }
                    } 
                    if($i==1){
                      @$vw_cnt   = $vw_res['cnt'];
                    } 
                  }//exit;
                 } else {$vw_cnt=0;}
              } else {
                $vw_cnt=0;
              }
              ?>

       <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">     
                        <?php echo $menu[$i]['sub_modue_name']; ?> </a>
                      </h5> <br>
                      <span class="badge bg-chocolate px-3 py-2 badge-pill"><?php echo @$vw_cnt; ?></span>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
<?php }?>

<?php  for($i=6;$i<8;$i++)
             //foreach($menu as $details)
            {
              if($i==6){
                  $table = "vw_radataentry_cnt";
              }
              if($i==7){
                $table = "vw_raverdataentry_cnt";
              }
               if($table!=""){ 
                $get_count  = $this->Survey_model->get_view_count($table);//print_r($get_count);
                if(!empty($get_count)){
                 foreach($get_count as $vw_res){
                    @$vw_cnt   = $vw_res['cnt'];
                 }
                }else {$vw_cnt=0;}
                } else {$vw_cnt=0;}
              ?>
                <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">     
                       <?php echo $menu[$i]['sub_modue_name']; ?> </a>
                      </h5> <?php if($i==6) {?> <br> <?php } ?>
                     <span class="badge bg-chocolate px-3 py-2  badge-pill"><?php echo @$vw_cnt; ?></span>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->

            <?php }?>
</div> <!-- end of row -->
<!-- --------------------------------- -- Second row ends here -- ------------------------------------------ -->
<!-- --------------------------------- -- Third row starts here -- ------------------------------------------ -->
<div class="row no-gutters formsection">
  <div class="col-12">
    <div class="card">
      <div class="card-header text-primary">
        <i class="fas fa-stamp"></i> Form Requests
    </div> <!-- end of card header -->
  <div class="card-body layoutcolor">
    <div class="row no-gutters">
      <?php //print_r($menu);
             $cnt=count($menu);
             for($i=2;$i<5;$i++)
             //foreach($menu as $details)
            {

              if($i==2){
                $table1="vw_ranamchg_cnt";
              }
              if($i==3){
                $table1="vw_ratsfrvsl_cnt";
              }
              if($i==4){
                $table1="vw_raownerchg_cnt";
              }
              if($table1!=""){ 
                $get_count1  = $this->Survey_model->get_view_count($table1);//print_r($get_count);
                if(!empty($get_count1)){
                 foreach($get_count1 as $vw_res1){
                    $uid       = $vw_res1['uid'];
                    $sess_user  = $_SESSION['int_userid'];
                    
                      if($uid==$sess_user){
                        @$vw_cnt1   = $vw_res['cnt'];
                      }else { $vw_cnt1=0;}

                  }//exit;
                 } else {$vw_cnt1=0;}
              } else {
                $vw_cnt1=0;
              }

              ?>
       <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                      <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">  
                      <?php echo $menu[$i]['sub_modue_name']; ?>  </a>
                      </h5>  <?php if($i==2) {?> <br>  <?php  }?> 
                     <span class="badge badge-pill px-3 py-2 bg-darkcyan"><?php echo @$vw_cnt1;?></span>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
     

<?php }?>
<!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                      <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">  
                      Vessel Alteration  </a>
                      </h5> <br>
                     <span class="badge badge-pill px-3 py-2 bg-darkcyan"><?php echo @$vw_cnt1;?></span>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
    </div> <!-- end of row -->
  </div> <!-- end of card body -->
</div> <!-- end of card -->
</div> <!-- end of col12 -->
</div> <!-- end of row -->
<!-- --------------------------------- -- Third row ends here -- ------------------------------------------ -->

<!-- --------------------------------- -- Fifth row starts here -- ------------------------------------------ -->
<div class="row no-gutters">
  <div class="col-12">
     <div class="card">
      <div class="card-header text-primary">
       <i class="fas fa-registered "></i>  Vessel Registration
    </div> <!-- end of card header -->
  <div class="card-body layoutcolor">
    <div class="row no-gutters">
      <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="fas fa-angle-double-down"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                          <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/dcb_statement_cssrra';?>">
                      <!-- <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">  --> 
                      DCB  </a>
                      </h5> 
                   <p class="card-text"><small class="text-muted">  STATEMENT </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
        <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="fas fa-file-pdf"></i> 
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <a class="no-link" href="<?php //echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">  
                      Reports  </a>
                      </h5> 
                     <p class="card-text"><small class="text-muted">  ALL REPORTS </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
        <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="fab fa-searchengin"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <!-- <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">  --> 
                        <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/payment_search';?>">
                    Search  </a>
                      </h5> 
                     <p class="card-text"><small class="text-muted">  PAYMENTS </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
        <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
              <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="fas fa-rupee-sign"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <!-- <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">   -->
                         <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/transaction_search';?>">
                      Payments </a>
                      </h5> 
                     <p class="card-text"><small class="text-muted">  TRANSACTION ID </small></p>
                    </div> <!-- end of card-body -->
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
    </div> <!-- end of inner row -->
  </div> <!-- end of card-body -->
</div> <!-- end of card -->
  </div> <!-- end of col12 -->
</div> <!-- end of row -->
<!-- --------------------------------- -- Fifth row ends here -- ------------------------------------------ -->
  <!--  ------------------------------------ sixth row starts here ------------------------------------  -->
<div class="row no-gutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
    <div class="row no-gutters">
    <div class="col-3">
   <i class="fas fa-info-circle"></i> Information
 </div>
 <div class="col-9 d-flex justify-content-end"> 
<a href="<?php echo base_url();?>index.php/Kiv_Ctrl/Survey/track_vessel" class="no-link"> Track a vessel </a>&nbsp;&nbsp;|&nbsp;&nbsp;
 <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/tariff_list';?>" class="no-link"> Tariff List </a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/tariff_calc_vw';?>" class="no-link">Tariff Calculator</a> 
&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/dcb_statement_cssrra';?>" class="no-link">Payments </a>  
&nbsp;&nbsp;|&nbsp;&nbsp; 
<a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/reg_certificate_list' ?>"class="no-link">
Registered Vessels</a>  
&nbsp;&nbsp;|&nbsp;&nbsp;  
<a href="<?php echo base_url();?>index.php/Kiv_Ctrl/Survey/timeline"  class="no-link"> Timeline</a>
 </div>
</div>
  </div>
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 7th row -->
  <!--  ------------------------------------ sixth row ends here  ------------------------------------ -->
</div> <!-- end of main-content div -->