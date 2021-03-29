<?php
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id  = $this->session->userdata('int_usertype');
  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
?>
<div class="main-content ui-innerpage">
<!-- ------------------------------------ First row starts here ------------------------------ -->
  <div class="row no-gutters p-1">
      <div class="col-3 text-primary kivheader no-cursor">
        <button type="button" class="btn btn-primary btn-block kivbutton"><i class="fas fa-ship"></i> Kerala Inland Vessel</button>
      </div> <!-- end of col-2 text-primary kiv-header -->
      <div class="col-9"> 
        <!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
   <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Main_login/pc_dashboard"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
      </div>
    </div> <!-- end of first title row -->
<!-- ------------------------------------ First row ends here ------------------------------ -->
<!-- ------------------------------------ Second row starts here ------------------------------ -->
<div class="row no-gutters">
   <?php //print_r($menu); exit;
             $cnt = count($menu);
             for($i=0;$i<4;$i++)
             //foreach($menu as $details)
            { 
              if($i==0){
              $table = "vw_pcinbox_cnt";
             }
              if($i==1){
              $table = "vw_pcappvdpay_cnt";
             }
             if($i==2){
              $table = "";
             }
             if($i==3){
              $table = "";
             }
              if($table!=""){ $sess_user  = $_SESSION['int_userid'];
                $get_count  = $this->Survey_model->get_view_count($table);
                /*print_r($get_count);exit;*/
                  if(!empty($get_count)){
                  foreach($get_count as $vw_res){
                    $uid       = $vw_res['uid']; 
                    if($uid==$sess_user){ 
                      @$vw_cnt   = $vw_res['cnt'];
                    
                    } /*else { 
                      $vw_cnt=0;
                    }*/
                  }//exit;
                 } else {$vw_cnt=0;}
              } else {
                $vw_cnt=0;
              }
              ?>
           <!-- -------------------------------- Create Widget for each menu item -------------------------------- -->
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
                      </h5> <?php if ($i==0) { ?> <br> <?php } ?>
                      <p class="card-text"> <span class="badge bg-darkolivegreen badge-pill px-3 py-2"><?php if($i==2){ echo @$de_req_pc;} else{ echo @$vw_cnt;}?></span></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
            <?php }?>
</div> <!-- end of row -->
<!-- ------------------------------------ Second row ends here ------------------------------ -->
<!-- ------------------------------------ Third row starts here ---------------------------- -->
<div class="row no-gutters">
  <div class="col-12">
    <div class="card">
    <div class="card-header text-primary">
    <i class="fas fa-project-diagram"></i> Utilities
  </div> <!-- end of card header-->
</div> <!-- end of card -->
  </div> <!-- end of col12 -->
  <div class="col-12">
    <div class="row no-gutters">
       <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
        <?php for($i=4;$i<8;$i++)
             
            {?>
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
                     <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>" >              
                           <?php echo $menu[$i]['sub_modue_name']; ?> </a>
                      </h5>
                      <p class="card-text"><small class="text-muted">  <?php if($i==4){?>UPDATED<?php } elseif($i==5){?>CALCULATOR<?php } elseif($i==6){?>DATE WISE<?php } elseif($i==7){?>VESSEL OWNERS<?php }?> </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
      <?php }?>
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
        
       
        
         <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
          <?php for($i=8;$i<12;$i++)
             
            {?>
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
                        <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>"> <?php echo $menu[$i]['sub_modue_name']; ?> </a>
                      </h5>
                      <p class="card-text"><small class="text-muted">  <?php if($i==8){?>TRANSACTION ID <?php } elseif($i==9){?>KIV DETAILS WISE<?php } elseif($i==10){?>COMPREHENSIVE<?php } elseif($i==11){?>STATISTICS<?php }?></small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
         <?php }?>
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
        
		
        
    </div> <!-- end of inner row -->
  </div> <!-- end of col12 -->
</div> <!-- end of row -->
<!-- ------------------------------------ Third row ends here ------------------------------ -->

<!-- ------------------------------------ Fourth row starts here ---------------------------- -->
<div class="row no-gutters">
  <div class="col-12">
    <div class="card">
    <div class="card-header text-primary">
    <i class="fas fa-tachometer-alt"></i> Registration Number
  </div> <!-- end of card header-->
</div> <!-- end of card -->
  </div> <!-- end of col12 -->
  <div class="col-12">
    <div class="row no-gutters">
       <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
        <?php for($i=12;$i<16;$i++)
             
            {?>
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
                      </h5>
                      <p class="card-text"><small class="text-muted">  <?php if($i!=12){?> VESSELS<?php } ?></small></p>
                      <?php if ($i==12) { ?>
                      <p class="card-text"> <span class="badge bg-darkolivegreen badge-pill px-3 py-2"><?php echo @$cnt_req;?></span></p><?php } ?>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
         <?php }?>
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
        
        
        
         
    </div> <!-- end of inner row -->
  </div> <!-- end of col12 -->
</div> <!-- end of row -->
<!-- ------------------------------------ Fourth row ends here ------------------------------ -->
</div> <!-- end of main-content div -->