<div class="main-content ui-innerpage">
  <div class="row no-gutters p-1">
    <div class="col-12 p-1">
      <div class="card">
      <div class="card-header  bg-blue">
        <i class="fas fa-tachometer-alt "></i>&nbsp; <em class="h6 ">  Port Conservator Dashboard</em>
      </div> <!-- end of card header -->
      <div class="card-body ">
        <div class="row no-gutters p-1">
          <?php //print_r($module); 
         //exit;
         foreach($module as $details1) {
            $mod_id     = $details1['main_module_id'];
          }
          $mod_qry      = $this->Main_login_model->get_module($mod_id); //print_r($mod_qry);exit;
          foreach($mod_qry as $details){ 
            $module_id  = $details['main_module_id'];
            $path       = $details['module_path'];
            
            $mod_id_enc = $this->encrypt->encode($module_id); 
            $md_id_enc  = str_replace(array('+', '/', '='), array('-', '_', '~'), $mod_id_enc);

           // user_master_id_user_type','user_master_port_id','main_module_id 
            //Kiv_Ctrl/Survey/pcHome
            //Manual_dredging/Master/pcdredginghome
            //

            if(!empty($port))
            {
              $user_master_id_user_type  = $port[0]['user_master_id_user_type'];
              $main_module_id  = $port[0]['main_module_id'];
            }
          
         ?> 
           <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="<?php echo $details['icon_name'];?> "></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">

                       <!--  <a class="no-link" href="<?php //echo base_url(); ?>index.php/<?php //echo $path.'/'.$md_id_enc;?>"> <?php //echo $details['main_module_name'];?> </a> -->

                       <?php if($user_master_id_user_type==3 && $main_module_id==2)
                       {
                        ?>
                         <a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome"> KERALA INLAND VESSEL </a>
                        <?php 
                       }
                       else
                       {
                        ?>
                        <a class="no-link" href="<?php echo base_url(); ?>index.php/Manual_dredging/Master/pcdredginghome"> MANUAL DREDGING </a>
                        <?php
                       }

                       ?>
                      </h5>
                      <p class="card-text"><small class="text-muted">  NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->

        <?php } ?>
        <!-- -------------------------------- Create Widget for each menu item --------------------------------- -->
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="fas fa-unlock-alt"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                        <a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/ch_pw">  CHANGE PASSWORD </a>
                      </h5>
                      <p class="card-text"><small class="text-muted">  NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->
        </div> <!-- end of inner row -->
      </div> <!-- end of card body -->
    </div> <!-- end of card -->
    </div> <!-- end of col-12 -->
  </div> <!-- end of row -->
<!-- ------------------------- ----------------- Accordion Menu starts here ------------------------- ------- --->
<div class="row no-gutters p-1">
  <div class="col-12 my-2 pl-5">
    <p class="h5 text-primary">  <i class="fas fa-exclamation-circle "></i>     Notifications </p>
  </div> <!-- end of col12 -->
  <div class="col-12">
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Manual Dredging
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="alert alert-primary" role="alert">
          A simple primary alert—check it out!
        </div>
        <div class="alert alert-secondary" role="alert">
          A simple secondary alert—check it out!
        </div>
        <div class="alert alert-success" role="alert">
          A simple success alert—check it out!
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Kerala Inland Vessel
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
              <div class="alert alert-danger" role="alert">
        <strong>Payment Pending - </strong> <span class="badge bg-darkolivegreen badge-pill px-3 py-2"><?php echo @$req_pc_cnt;?></span> Requests
      </div>
      <div class="alert alert-warning" role="alert">
        <strong>Data Entry - </strong> <span class="badge bg-darkolivegreen badge-pill px-3 py-2"><?php echo @$de_req_pc_cnt;?></span> Requests
      </div>
      <div class="alert alert-info" role="alert">
        <strong>Reprint Number Plate - </strong> <span class="badge bg-darkolivegreen badge-pill px-3 py-2"><?php echo @$cnt_req;?></span> Requests
      </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Landing &amp; Shipping
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
          <!--- -->
          <div class="alert alert-primary" role="alert">
          A simple danger alert—check it out!
        </div>
        <div class="alert alert-warning" role="alert">
          A simple warning alert—check it out!
        </div>
        <div class="alert alert-dark" role="alert">
          A simple info alert—check it out!
        </div>
      </div>
    </div>
  </div>
</div>
</div> <!-- end of col12 -->
</div> <!-- end of row -->
<!-- ------------------------- ----------------- Accordion Menu ends here ------------------------- ------- --->
</div> <!-- end of main-content container -->