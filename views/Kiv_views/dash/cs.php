<?php //print_r($data_payment); 

$id11 = 1; 
$id1 = $this->encrypt->encode($id11);
$id1=str_replace(array('+', '/', '='), array('-', '_', '~'), $id1);

$id12 = 2; 
$id2 = $this->encrypt->encode($id12);
$id2=str_replace(array('+', '/', '='), array('-', '_', '~'), $id2);

$id13 = 3; 
$id3 = $this->encrypt->encode($id13);
$id3=str_replace(array('+', '/', '='), array('-', '_', '~'), $id3);

$id14 = 4; 
$id4 = $this->encrypt->encode($id14);
$id4=str_replace(array('+', '/', '='), array('-', '_', '~'), $id4);

$id15 = 5; 
$id5 = $this->encrypt->encode($id15);
$id5=str_replace(array('+', '/', '='), array('-', '_', '~'), $id5);

$id16 = 6; 
$id6 = $this->encrypt->encode($id16);
$id6=str_replace(array('+', '/', '='), array('-', '_', '~'), $id6);

$id17 = 7; 
$id7 = $this->encrypt->encode($id17);
$id7=str_replace(array('+', '/', '='), array('-', '_', '~'), $id7);

$id18 = 8; 
$id8 = $this->encrypt->encode($id18);
$id8=str_replace(array('+', '/', '='), array('-', '_', '~'), $id8);

$id19 = 9; 
$id9 = $this->encrypt->encode($id19);
$id9=str_replace(array('+', '/', '='), array('-', '_', '~'), $id9);

$id20 = 10; 
$id10 = $this->encrypt->encode($id20);
$id10=str_replace(array('+', '/', '='), array('-', '_', '~'), $id10);

$id22 = 12; 
$id12 = $this->encrypt->encode($id22);
$id12=str_replace(array('+', '/', '='), array('-', '_', '~'), $id12);

$id23 = 13; 
$id13 = $this->encrypt->encode($id23);
$id13=str_replace(array('+', '/', '='), array('-', '_', '~'), $id13);

$id25 = 15; 
$id15 = $this->encrypt->encode($id25);
$id15=str_replace(array('+', '/', '='), array('-', '_', '~'), $id15);

$id27 = 17; 
$id17 = $this->encrypt->encode($id27);
$id17=str_replace(array('+', '/', '='), array('-', '_', '~'), $id17);


$id226 =26; 
$id26 = $this->encrypt->encode($id226);
$id26=str_replace(array('+', '/', '='), array('-', '_', '~'), $id26);


?>
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
             for($i=0;$i<7;$i++)
             //foreach($menu as $details)
            {
              if($i==0){
                $table = "vw_csinbox_cnt";
                $vw_cnt = @$count;
              } 
              if($i==1){
                $table = "vw_csactivity_cnt";
                $vw_cnt = @$count_task;
              }
              if($i==2){
                $table = "vw_cspendpay_cnt";
                $vw_cnt = @$count_payment;
              }
              if($i==3){
                $table = "vw_csform4int_cnt";
                $vw_cnt = @$count_form4;
              }
              if($i==4){
                $table = "vw_csform5or6_cnt";
                $vw_cnt = @$count_form56;
              }
              if($i==5){
                $table = "vw_csform7_cnt";
                $vw_cnt = @$count_form7;
              }
              if($i==6){
                //$table = "vw_csform7_cnt";
                $vw_cnt = @$count_special;
              }
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
                        <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">                
                           <?php echo $menu[$i]['sub_modue_name']; ?> </a>
                      </h5> <?php  if($i==0 || $i==1){ ?> <br> <?php } ?>
                      <p class="card-text"><small class="text-muted"> <?php if($i!=0){  echo @$vw_cnt;  } else { echo "0"; } ?> NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->

             <?php }?>
              <!-- -------------------------------- Create Widget for each menu item ------------------------------- -->
                <div class="col-4 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="fas fa-bookmark"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                      <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/dataentry_reports' ?>">     Data Entry list  </a>
                      </h5>
                      <p class="card-text"><small class="text-muted"> <?php //echo @$count_task; ?> NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->

         <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
                <div class="col-4 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                     <i class="fab fa-flipboard"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/verified_forms' ?>">                
                           Verified Data Entry List </a>
                      </h5>
                      <p class="card-text"><small class="text-muted"> <?php //echo @$count_task; ?> NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
 </div> <!-- end of second main row -->
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

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id1 ?>"> 
    <li class="list-group-item text-primary"><i class="fab fa-fonticons"></i> Form 1
    <span class="badge badge-info badge-pill"><?php echo @$form1_count; ?></span></li>
    </a> 

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id2 ?>"> 
    <li class="list-group-item text-primary"><i class="fab fa-dyalog"></i> Keel Laying
    <span class="badge badge-info badge-pill"><?php echo @$keel_count; ?></span></li>
    </a>

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id3 ?>"> 
    <li class="list-group-item text-primary"><i class="fas fa-dolly-flatbed"></i> Hull Inspection 
    <span class="badge badge-info badge-pill"><?php echo @$hull_count; ?></span></li>
    </a>

    <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id4 ?>"> 
    <li class="list-group-item text-primary"><i class="fab fa-delicious"></i> Final Inspection
    <span class="badge badge-info badge-pill"><?php echo @$final_count; ?></span></li>
    </a>
    </ul>
    </div> 

  <div class="col-3">
  <ul class="list-group">
  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id5 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-upload"></i> Form 3
  <span class="badge badge-info badge-pill"> <?php echo @$form3_count; ?></span></li>
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id6 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-import"></i> Form 4
  <span class="badge badge-info badge-pill"><?php echo @$form4_count; ?></span></li>
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id10 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-signature"></i> Form 7
  <span class="badge badge-info badge-pill"><?php echo @$form7_count; ?></span></li>
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id7 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-prescription"></i> Defect Memo
  <span class="badge badge-info badge-pill"><?php echo @$defect_count; ?></span></li>
  </a>

  </ul>
  </div> <!-- end of col-3 -->
  <div class="col-3">

  <ul class="list-group">
  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id8 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-alt"></i> Form 5
  <span class="badge badge-info badge-pill"><?php echo @$form5_count; ?></span></li> 
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id9 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-alt"></i> Form 6
  <span class="badge badge-info badge-pill"><?php echo @$form6_count; ?></span></li>
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id12 ?>">
  <li class="list-group-item text-primary"> <i class="fas fa-file-download"></i> Form 9
  <span class="badge badge-info badge-pill"><?php echo @$form9_count; ?></span></li>
  </a>

  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id13 ?>">
  <li class="list-group-item text-primary"> <i class="fas fa-file-invoice"></i> Form 10
  <span class="badge badge-info badge-pill"><?php echo @$form10_count; ?></span></li>
  </a>

  </ul>
  </div> <!-- end of col-3 -->
  <div class="col-3">
  <ul class="list-group">
  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id15 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-file-medical-alt"></i> Form 2
  <span class="badge badge-info badge-pill"><?php echo @$form2_count; ?></span></li>
  </a>
  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id17 ?>">
  <li class="list-group-item text-primary"><i class="fas fa-anchor"></i> Annual Survey
  <span class="badge badge-info badge-pill"><?php echo @$annualsurvey_count; ?></span></li>
  </a>
  <a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/survey_forms_view/'.$id26 ?>">
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
             for($i=7;$i<11;$i++)
             //foreach($menu as $details)
            {
              if($i==7){
                $table1 = "vw_csinitsurvy_cnt";
                $vw_cnt1= @$initialsurvey_request_count;
              }
              if($i==8){
                $table1 = "vw_csanulsurvy_cnt";
                 $vw_cnt1= @$annualsurvey_count;
              }
              if($i==9){
                $table1 = "vw_csdrysurvy_cnt";
                 $vw_cnt1= @$drydocksurvey_count;
              }
              if($i==10){
                $table1 = "vw_csspclsurvy_cnt";
                 $vw_cnt1= @$count_special;
              }
              /*if($table1!=""){ 
                $get_count1  = $this->Survey_model->get_view_count($table1);//print_r($get_count);
                  if(!empty($get_count1)){
                  foreach($get_count1 as $vw_res1){
                    $uid1       = $vw_res1['uid'];
                    $sess_user1  = $_SESSION['int_userid'];
                    //if($i!=2){
                      if($uid1==$sess_user1){
                      @$vw_cnt1   = $vw_res1['cnt'];
                      
                      }
                   // } else { @$vw_cnt1   = $vw_res1['cnt'];}
                  }//exit;
                 } else {$vw_cnt1=0;}
              } else {
                $vw_cnt1=0;
              }*/
              ?>
      <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
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
                        <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path']; ?>">                
                          <?php echo $menu[$i]['sub_modue_name']; ?> </a>
                      </h5>
                      <p class="card-text"><small class="text-muted"> <?php echo @$vw_cnt1;  ?> NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
<?php }?>


    
    <div> <!-- end of card-body -->
</div> <!-- end of card -->
  </div> <!-- end of col-12 -->
</div> <!-- end of 5th row -->

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
             for($i=11;$i<15;$i++)
             //foreach($menu as $details)
            {
              if($i==11){$classsty="btn btnwidget1 btn-block btn-lg"; $table2 = "vw_csinitsurvycomp_cnt"; $vw_cnt2 = @$count_initial_survey;}
              elseif($i==12){$classsty="btn btnwidget2 btn-block btn-lg";$table2 = "vw_csannlsurvycomp_cnt"; $vw_cnt2 = @$count_annual_survey;}
              elseif($i==13){$classsty="btn btnwidget3 btn-block btn-lg";$table2 = "vw_csdrydksurvycomp_cnt"; $vw_cnt2 = @$count_drydock_survey;}
              elseif($i==14){$classsty="btn btnwidget4 btn-block btn-lg";$table2 = "vw_csspclsurvycomp_cnt"; $vw_cnt2 = @$count_special_survey;}

            

              ?>
      
      <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
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
                        <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path']; ?>">                
                           <?php echo $menu[$i]['sub_modue_name'];  ?> </a>
                      </h5>
                      <p class="card-text">  <span class="badge badge-success badge-pill h4 p-2"><?php echo @$vw_cnt2; ?></span> </p>
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


<div class="row no-gutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
    <div class="row no-gutters">
    <div class="col-3">
   <i class="fas fa-project-diagram"></i> Utilities
 </div>
<div class="col-9 d-flex justify-content-end">

<a class="no-link" href="<?php echo base_url();?>index.php/Kiv_Ctrl/Survey/track_vessel" > Track a vessel </a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/tariff_list';?>" > Tariff List </a>
&nbsp;&nbsp;|&nbsp;&nbsp; 
<a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/tariff_calc_vw';?>" > Tariff Calculator</a>
&nbsp;&nbsp;|&nbsp;&nbsp;  
<a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Survey/dcb_statement_cssrra';?>"> Payments</a>
&nbsp;&nbsp;|&nbsp;&nbsp;
Reports 
&nbsp;&nbsp;|&nbsp;&nbsp; 
<a class="no-link" href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/reg_certificate_list' ?>" >
Registered Vessels</a>
&nbsp;&nbsp;|&nbsp;&nbsp; 
<a class="no-link" href="<?php echo base_url();?>index.php/Kiv_Ctrl/Survey/timeline"  > Timeline</a>

</div>

</div>
  </div>
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 7th row -->
</div> <!-- end of container div -->