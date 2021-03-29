<div class="main-content ui-innerpage">
  <!-- ------------------------------------ First row starts here ------------------------------ -->
  <div class="row no-gutters">
      <div class="col-3 text-primary kivheader no-cursor">
        <button type="button" class="btn btn-primary btn-block kivbutton"><i class="fas fa-ship"></i> Kerala Inland Vessel</button>
      </div> <!-- end of col-2 text-primary kiv-header -->
      <div class="col-9"> </div>
    </div> <!-- end of first title row -->
<!-- ------------------------------------ First row ends here ------------------------------ -->

<!-- ------------------------------------ Second row starts here ------------------------------ -->
 <div class="row no-gutters">
  <?php //print_r($menu);
             $cnt=count($menu);
             for($i=0;$i<5;$i++)
             //foreach($menu as $details)
            { 
              if($i==0){
                $table = "vw_srinbox_cnt";
              }
              if($i==2){
                $table = "vw_srcsform4_cnt";
              }
              if($i==3){
                $table = "vw_srcsform56_cnt";
              }
              if($i==4){
                $table = "vw_srcsform7_cnt";
              }
              if($table!=""){ 
                $get_count  = $this->Survey_model->get_view_count($table);//print_r($get_count);
                if(!empty($get_count)){
                 foreach($get_count as $vw_res){
                    $uid       = $vw_res['uid'];
                    $sess_user  = $_SESSION['int_userid'];
                    if($uid==$sess_user){
                      @$vw_cnt   = $vw_res['cnt'];
                    }else { $vw_cnt=0;}
                    /* if($i!=2){
                      if($uid==$sess_user){
                      @$vw_cnt   = $vw_res['cnt'];
                      
                      }
                    } else { @$vw_cnt   = $vw_res['cnt'];}*/
                  }//exit;
                 } else {$vw_cnt=0;}
              } else {
                $vw_cnt=0;
              }?>
         <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
                <div class="col-4 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="<?php echo $menu[$i]['icon_name'];?>"></i> 
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                        <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path']; ?>">   <?php echo $menu[$i]['sub_modue_name']; ?>  </a>
                      </h5>
                      <p class="card-text"><small class="text-muted"> <?php if($i!=0){  echo @$vw_cnt;  } else { echo "0"; } ?> NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
<?php } ?>
  </div> <!-- end of row -->
  <!-- ------------------------------------ Second row ends here ------------------------------ -->
  <!-- ------------------------------------ Third row starts here ------------------------------ -->
 <div class="row no-gutters">
<div class="col-12"> 
<div class="card">
<div class="card-header text-primary">
<i class="fas fa-copy"></i> Survey Forms 
</div>
<div class="card-body layoutcolor">
<div class="row no-gutters layoutcolor">
<div class="col-3">
  <ul class="list-group">
    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'1' ?>"> 
    <li class="list-group-item text-primary"><i class="fab fa-fonticons"></i> Form 1
    <span class="badge badge-info badge-pill"><?php echo @$form1_count; ?></span></li>
    </a> 

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'2' ?>"> 
    <li class="list-group-item text-primary"><i class="fab fa-dyalog"></i> Keel Laying
    <span class="badge badge-info badge-pill"><?php echo @$keel_count; ?></span></li>
    </a>

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'3' ?>"> 
    <li class="list-group-item text-primary"><i class="fas fa-dolly-flatbed"></i> Hull Inspection 
    <span class="badge badge-info badge-pill"><?php echo @$hull_count; ?></span></li>
    </a>

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'4' ?>"> 
    <li class="list-group-item text-primary"><i class="fab fa-delicious"></i> Final Inspection
    <span class="badge badge-info badge-pill"><?php echo @$final_count; ?></span></li>
    </a>

  </ul>
</div> <!-- end of col-3 -->
<div class="col-3">
  <ul class="list-group">
    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'5' ?>">
    <li class="list-group-item text-primary"><i class="fas fa-file-upload"></i> Form 3
    <span class="badge badge-info badge-pill"> <?php echo @$form3_count; ?></span></li>
    </a>

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'6' ?>">
    <li class="list-group-item text-primary"><i class="fas fa-file-import"></i> Form 4
    <span class="badge badge-info badge-pill"><?php echo @$form4_count; ?></span></li>
    </a>

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'10' ?>">
    <li class="list-group-item text-primary"><i class="fas fa-file-signature"></i> Form 7
    <span class="badge badge-info badge-pill"><?php echo @$form7_count; ?></span></li>
    </a>

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'7' ?>">
    <li class="list-group-item text-primary"><i class="fas fa-file-prescription"></i> Defect Memo
    <span class="badge badge-info badge-pill"><?php echo @$defect_count; ?></span></li>
    </a>
  </ul>

</div> <!-- end of col-3 -->

<div class="col-3">
<ul class="list-group">

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'8' ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-alt"></i> Form 5
  <span class="badge badge-info badge-pill"><?php echo @$form5_count; ?></span></li> 
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'9' ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-alt"></i> Form 6
  <span class="badge badge-info badge-pill"><?php echo @$form6_count; ?></span></li>
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'12' ?>">
  <li class="list-group-item text-primary"> <i class="fas fa-file-download"></i> Form 9
  <span class="badge badge-info badge-pill"><?php echo @$form9_count; ?></span></li>
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'13' ?>">
  <li class="list-group-item text-primary"> <i class="fas fa-file-invoice"></i> Form 10
  <span class="badge badge-info badge-pill"><?php echo @$form10_count; ?></span></li>
  </a>
</ul>

</div> <!-- end of col-3 -->

<div class="col-3">
<ul class="list-group">
<a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'15' ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-medical-alt"></i> Form 2
  <span class="badge badge-info badge-pill"><?php echo @$form2_count; ?></span></li>
  </a>
  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'17' ?>">
  <li class="list-group-item text-primary"><i class="fas fa-anchor"></i> Annual Survey
  <span class="badge badge-info badge-pill"><?php echo @$annualsurvey_count; ?></span></li>
  </a>
  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.'26' ?>">
  <li class="list-group-item text-primary"><i class="fas fa-eraser"></i> Dry Dock Survey
  <span class="badge badge-info badge-pill"><?php echo @$drydocksurvey_count; ?></span></li>
  </a>
  <li class="list-group-item text-primary"><i class="far fa-compass"></i> Special Survey
  <span class="badge badge-info badge-pill">0-</span></li>

</ul>
</div> <!-- end of col-3 -->
</div> <!-- end of row 3rd-->
</div> <!-- end of card-body -->
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of another row -->
  <!-- ------------------------------------ Third row ends here ------------------------------ -->
  <!-- ------------------------------------ Fourth row starts here ------------------------------ -->
  <div class="row no-gutters">
  <div class="col-12">
    <div class="card">
      <div class="card-header text-primary">
       <i class="fas fa-dolly"></i> Survey Requests
      </div>
  <div class="card-body layoutcolor">
    <div class="row">
      <?php //print_r($menu);
             $cnt=count($menu);
             for($i=5;$i<8;$i++)
             //foreach($menu as $details)
            { 
              if($i==5){ $countt = @$initialsurvey_request_count;} elseif ($i==6) { $countt = @$annualsurvey_count;} elseif ($i==7) { $countt = @$drydocksurvey_count; }
              ?>
            <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
                <div class="col-4 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                        <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path']; ?>"> 
                          <?php echo $menu[$i]['sub_modue_name']; ?> </a>
                      </h5>
                      <p class="card-text"><small class="text-muted"> <?php if(isset($countt)){ echo @$countt; } else { echo "0";} ?> Requests </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
   
          <!-- end of one widget -->
        <?php } ?>
  </div> <!-- end of inner row -->
  </div> <!-- end of card-body -->
</div> <!-- end of card -->
  </div> <!-- end of col-12 -->
</div> <!-- end of 5th row -->
  <!-- ------------------------------------ Fourth row ends here ------------------------------ -->

  <!-- ------------------------------------ Fifth row starts here ------------------------------ -->
  <div class="row no-gutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
   <i class="fas fa-pallet"></i> Completed Surveys
  </div>
  <div class="card-body layoutcolor">
    <div class="row  ">
 <?php //print_r($menu);
             $cnt=count($menu);
             for($i=8;$i<11;$i++)
             //foreach($menu as $details)
            { 
              if($i==8){$classtyp="btn btnwidget1 btn-block btn-lg"; $cntt=$count_initial_survey;}
              elseif($i==9){$classtyp="btn btnwidget2 btn-block btn-lg";$cntt=$annualsurvey_count;}
              elseif($i==10){$classtyp="btn btnwidget3 btn-block btn-lg";$cntt=$drydocksurvey_count;}
              // elseif($i==11){$classtyp="btn btnwidget4 btn-block btn-lg";} ?>
      <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
                <div class="col-4 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                        <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path']; ?>">    
                          <?php echo $menu[$i]['sub_modue_name']; ?></a>
                      </h5>
                      <?php if($i<10) { ?>  <br> <?php } ?>
                      <p class="card-text"> <span class="badge badge-success badge-pill px-3 py-2">

                        <?php if(isset($cntt)){echo @$cntt;} else { echo "0";} ?></span> </p>
                    </div> <!-- end of card-body -->
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
<?php }?>
    </div> <!-- end of row 3rd-->
  </div> <!-- end of card-body -->
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 6th row -->
  <!-- ------------------------------------ Fifth row ends here ------------------------------ -->
    <!-- ------------------------------------ Sixth row starts here ------------------------------ -->
  <div class="row no-gutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
    <div class="row no-gutters">
    <div class="col-3">
   <i class="fas fa-project-diagram"></i> Utilities
 </div>
 <div class="col-9 d-flex justify-content-end">
<a href="<?php echo base_url();?>index.php/Kiv_Ctrl/Survey/track_vessel" class="no-link" > Track a vessel </a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/tariff_list';?>" class="no-link" > Tariff List </a>
&nbsp;&nbsp;|&nbsp;&nbsp; 
<a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/tariff_calc_vw';?>" class="no-link" > Tariff Calculator</a> 
&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/dcb_statement_cssrra';?>" class="no-link" >Payments </a>
&nbsp;&nbsp;|&nbsp;&nbsp;   
<a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/reg_certificate_list' ?>" class="no-link" >
Registered Vessels</a> 
&nbsp;&nbsp;|&nbsp;&nbsp;  
<a href="<?php echo base_url();?>index.php/Kiv_Ctrl/Survey/timeline"  class="no-link" > Timeline</a>
 </div>
</div>
  </div>
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 7th row -->
   <!-- ------------------------------------ Sixth row ends here ------------------------------ -->
</div> <!-- end of main-content div -->