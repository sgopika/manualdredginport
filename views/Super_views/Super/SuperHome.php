<!----------------------------------------start of breadcrumb bar -------------------------------------- ------- -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Library</li> -->
    <span class="badge bg-darkmagenta innertitle pt-2">Super Admin Settings</span>
  </ol>
</nav>
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<!---------------------------------------- start of search bar -------------------------------------- ------- -->
<div class="container-fluid ui-innerpage">
    <div class="row p-2">
    <div class="col-12 d-flex justify-content-end">
        <input type="text" id="search-criteria" /> 
        <input type="button" id="search" value="search" class="btn btn-success btn-sm btn-flat btn-point" /> 
         <button type="button" name="refreshBtn" id="refreshBtn" class="ml-5 btn btn-flat btn-point btn-default btn-sm"> <i class="fas fa-sync-alt"></i> Refresh  </button>
    </div> <!-- end of col12 -->
</div> <!-- end of row -->
<!---------------------------------------- end of search bar -------------------------------------- ------- -->
<!-- -------------------------------------- start of main content bar-------------------------------------- -->
   <!-- =================== Added for dynamic menu listing(start) on 02.11.2019=======--->

<?php $cnt=count($menu); if(($cnt%4)>=0){?><div class="row p-1"><?php }?>
  <?php 

//foreach($menu as $details)
for($i=0;$i<$cnt;$i++)
{
if($i==0){ $class= "card bg-darkorchid"; }
elseif ($i==1) { $class= "card bg-cadetblue"; }
elseif ($i==2) { $class= "card bg-crimson"; }
elseif ($i==3) { $class= "card bg-hotpink"; }
elseif ($i==4) { $class= "card bg-yellow"; }
elseif ($i==5) { $class= "card bg-aqua"; }
elseif ($i==6) { $class= "card bg-blue"; }
elseif ($i==7) { $class= "card bg-red"; }
elseif ($i==8) { $class= "card bg-green"; }
elseif ($i==9) { $class= "card bg-navy"; }
elseif ($i==10) { $class= "card bg-teal"; }
elseif ($i==11) { $class= "card bg-plum"; }
elseif ($i==12) { $class= "card bg-midnightblue"; }
elseif ($i==13) { $class= "card bg-mediumaquamarine"; }
elseif ($i==14) { $class= "card bg-darkslategray"; }
elseif ($i==15) { $class= "card bg-olive"; }
elseif ($i==16) { $class= "card bg-lime"; }
elseif ($i==17) { $class= "card bg-orange"; }
elseif ($i==18) { $class= "card bg-fuchsia"; }
elseif ($i==19) { $class= "card bg-purple"; }
elseif ($i==20) { $class= "card bg-maroon"; }
elseif ($i==21) { $class= "card bg-lightsalmon"; }
elseif ($i==22) { $class= "card bg-orange-red"; }
elseif ($i==23) { $class= "card bg-tomato"; }
elseif ($i==24) { $class= "card bg-darkkhaki"; }
elseif ($i==25) { $class= "card bg-forestgreen"; }
elseif ($i==26) { $class= "card bg-yellowgreen"; }
elseif ($i==27) { $class= "card bg-olivedrab"; }
elseif ($i==28) { $class= "card bg-darkcyan"; }
elseif ($i==29) { $class= "card bg-darkolivegreen"; }
elseif ($i==30) { $class= "card bg-seagreen"; }
elseif ($i==31) { $class= "card bg-lightseagreen"; }
elseif ($i==32) { $class= "card bg-royalblue"; }
elseif ($i==33) { $class= "card bg-deeppink"; }
elseif ($i==34) { $class= "card bg-darkmagenta"; }
elseif ($i==35) { $class= "card bg-peru"; }
elseif ($i==36) { $class= "card bg-saddlebrown"; }
elseif ($i==37) { $class= "card bg-rosybrown"; }
elseif ($i==38) { $class= "card bg-sandybrown"; }
elseif ($i==39) { $class= "card bg-tan"; }
elseif ($i==40) { $class= "card bg-deeppink"; }
elseif ($i==41) { $class= "card bg-goldenrod"; }
elseif ($i==42) { $class= "card bg-chocolate"; }
elseif ($i==43) { $class= "card bg-darkseagreen"; }
elseif ($i==44) { $class= "card bg-coral"; }
elseif ($i==45) { $class= "card bg-limegreen"; }
elseif ($i==46) { $class= "card bg-firebrick"; }
elseif ($i==47) { $class= "card bg-darkturquoise"; }
elseif ($i==48) { $class= "card bg-darkslateblue"; }
elseif ($i==49) { $class= "card bg-indianred"; }
elseif ($i==50) { $class= "card bg-darkolivegreen"; }
elseif ($i==51) { $class= "card bg-burlywood"; }
elseif ($i==52) { $class= "card bg-palevioletred"; }
elseif ($i==53) { $class= "card bg-mediumorchid"; }
elseif ($i==54) { $class= "card bg-sienna"; }
elseif ($i==55) { $class= "card bg-coral"; }
?>
<?php  
//if($menu[$i]['sub_modue_name']!= "Edit Profile" && $menu[$i]['sub_modue_name']!= "Logo"){
if($menu[$i]['sub_modue_name']!= "Edit Profile" ){ ?>
<div class="col-3 settingtab py-2">  
  <div class="<?php echo $class;?>">
    <div class="card-body">
      <h5 class="card-title  card-border card-border"> <a class="btn btn-flat card_white" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>"> <i class="<?php echo $menu[$i]['icon_name']; ?>"></i> <?php echo $menu[$i]['sub_modue_name']; ?></a></h5>
      <span class="progress-description d-flex justify-content-center"> <!-- Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');  echo $helper_table[0]['mastertable_records'];?> --></span>
    </div>
  </div>
</div>  
<?php } ?>
  <?php }?>
  <?php if(($cnt%4)==0){?></div><?php }?>

 <!-- =================== Added for dynamic menu listing(end) on 02.11.2019=======--->




<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-darkorchid">
          <div class="card-body">
            <h5 class="card-title  card-border card-border"> <a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/dynamicform_byvessel"?>"> <i class="fas fa-tape"></i> &nbsp; Dynamic Form Design</a></h5>
             <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
         </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-cadetblue">
          <div class="card-body">
            <h5 class="card-title  card-border card-border"> <a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>"><i class="fas fa-copy"></i>&nbsp; Copy Dynamic Form </a></h5>
             <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-crimson">
          <div class="card-body">
           <h5 class="card-title  card-border card-border"> <a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/viewCopyDynamicform"?>"> <i class="far fa-newspaper"></i> &nbsp; View Copy Dynamic Form </a></h5>
             <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --> <!-- end of col3 -->
     <!-- <div class="col-3 settingtab">
        <div class="card bg-hotpink">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/mastertable"?>"> <i class="fa  fa-table"></i> &nbsp; Master Tables</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> -->  <!-- end of col3 -->
<!-- </div> --> <!-- end of 15th row -->
<!-- <div class="row p-1"> -->

    <!-- <div class="col-3 settingtab">
        <div class="card bg-yellow">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/addTariff"?>"> <i class="fa fa-credit-card"></i> &nbsp;Add Tariff </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card">
          <div class="card-body bg-aqua">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/viewTariff"?>" > <i class="fa fa-credit-card"></i></span> &nbsp; Tariff View</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card">
          <div class="card-body bg-blue">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/user_type"?>" > <i class="fa  fa-users"></i> &nbsp; User Type </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_user_type_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
       <!--  <div class="col-3 settingtab">
        <div class="card bg-red ">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/user"?>"> <i class="fa fa-user"></i>&nbsp; User</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_user_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div> --> <!-- end of 1st row -->

<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-light-blue">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/vesselType"?>"> <i class="fas fa-star-of-david"></i>&nbsp; Vessel Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_vesseltype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-green">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/vessel_subtype"?>"> <i class="fas fa-star-half-alt"></i>&nbsp; Vessel Subtype</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_vessel_subtype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-navy">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/vesselcategory"?>"> <i class="fas fa-swatchbook"></i> &nbsp; Vessel Category</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_vesselcategory_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-teal">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/vessel_subcategory"?>"> <i class="fas fa-ticket-alt"></i>&nbsp; Vessel Subcategory</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div> --> <!-- end of 2nd row -->
<!-- <div class="row p-1"> -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-plum">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/vessel_class"?>" > <i class="fa fa-cube"></i> &nbsp; Vessel Class</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_vessel_class_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-midnightblue">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/engine_class"?>"> <i class="fa  fa-leaf"></i> &nbsp; Engine Class </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_engine_class_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-mediumaquamarine" >
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/modelnumber"?>"> <i class="fas fa-charging-station"></i> &nbsp;Engine Model </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_modelnumber_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
        <!-- <div class="col-3 settingtab">
        <div class="card bg-darkslategray">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/metric"?>"> <i class="fa fa-trademark"></i> &nbsp; Metric</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_metric_master');echo $helper_table[0]['mastertable_records']; ?> </span>
           
          </div>
        </div>
    </div>  --><!-- end of col3 -->
<!-- </div> --> <!-- end of 10th row -->
<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-olive">
          <div class="card-body">
             <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/firepumptype"?>"> <i class="fa  fa-fire-extinguisher"></i> &nbsp; Fire Pump Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_firepumptype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-lime">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/searchlight_size"?>"> <i class="fa  fa-crosshairs"></i> &nbsp; Searchlight Size</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_searchlight_size_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card">
          <div class="card-body bg-orange">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/towing"?>"> <i class="fa  fa-anchor"></i> &nbsp; Towing</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_towing_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-fuchsia">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white"  href="<?php echo $site_url."/Kiv_Ctrl/Master/plyingstate"?>"> <i class="fa fa-map-signs"></i> &nbsp; Plying State </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_plyingstate_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div> --> <!-- end of 3rd row -->

<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-purple">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/engineType"?>"> <i class="fa  fa-space-shuttle"></i>&nbsp; Engine Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_enginetype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-maroon">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/geartype"?>"> <i class="fa fa-share-alt"></i>&nbsp; Gear Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_geartype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-lightsalmon">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/chainporttype"?>"> <i class="fas fa-link"></i> &nbsp; Chain Port Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_chainporttype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-orange-red">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/nozzletype"?>"> <i class="far fa-paper-plane"></i> &nbsp; Nozzle Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_nozzletype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div> --> <!-- end of 4th row -->

<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-tomato">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/commnequipment"?>" > <i class="fa fa-mobile"></i>&nbsp; Communication Equipment </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_commnequipment_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-darkkhaki">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/navgnequipments"?>"> <i class="fa fa-globe"></i>&nbsp; Navigation equipment</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_navgnequipments_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-forestgreen">
          <div class="card-body">
             <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/navgn_light"?>"> <i class="fa fa-compass"></i> &nbsp; Navigation light</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_navgn_light_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-yellowgreen">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/sound_signal"?>"> <i class="fa fa-volume-down"></i> &nbsp; Sound Signal</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_sound_signal_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div> --> <!-- end of 5th row -->

<!-- <div class="row p-1">
 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-olivedrab">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/electricalgenerator"?>"> <i class="fa fa-industry"></i> &nbsp; Electrical Generator </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_electricalgenerator_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-darkcyan">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/locationof_electricalgenerator"?>"> <i class="fa fa-map-marker"></i>&nbsp; Generator Location</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_locationof_electricalgenerator_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-darkolivegreen">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/location"?>" > <i class="fa  fa-bullseye"></i> &nbsp; Location</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_location_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
       <!--  <div class="col-3 settingtab">
        <div class="card bg-seagreen">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white"  href="<?php echo $site_url."/Kiv_Ctrl/Master/formtype_location"?>"><i class="fa  fa-fire"></i>&nbsp; Foam Type Location</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_formtype_location_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div>  --><!-- end of 6th row -->
<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-lightseagreen">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/placeofsurvey"?>"> <i class="fa fa-crop"></i>&nbsp; Area of operation</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_placeofsurvey_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-royalblue">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/natureofoperation"?>"> <i class="fa fa-object-ungroup"></i> &nbsp; Nature of Operation </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_natureofoperation_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-deeppink">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/portofRegistry"?>"> <i class="fa fa-university"></i>&nbsp; Port of Registry</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_portofregistry_master');echo $helper_table[0]['mastertable_records']; ?> </span>
            
          </div>
        </div>
    </div>  --><!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-darkmagenta">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/stern"?>"><i class="fas fa-map-signs"></i> &nbsp; Stern</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_stern_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
<!-- </div> --> <!-- end of 7th row -->

<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-peru">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/occupation"?>"> <i class="fas fa-seedling"></i> &nbsp; Occupation </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_occupation_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-saddlebrown">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/surveyactivity"?>"><i class="fa  fa-flag-checkered"></i> &nbsp;Survey Activity </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_surveyactivity_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
       <!--  <div class="col-3 settingtab">
        <div class="card bg-rosybrown">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/document"?>"><i class="far fa-file-archive"></i> &nbsp; File Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_document_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-sandybrown">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/document_type"?>"><i class="fas fa-file-pdf"></i> &nbsp; Document Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_document_type_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div>  --><!-- end of 8th row -->

<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-tan">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/equipment_material"?>"><i class="fas fa-shekel-sign"></i>&nbsp; Equipment Material</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_equipment_material_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
       <!--  <div class="col-3 settingtab">
        <div class="card bg-deeppink">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/equipment"?>"> <i class="fas fa-cogs"></i> &nbsp; Equipment </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_equipment_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-goldenrod">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/equipment_type"?>"> <i class="fas fa-sliders-h"></i>&nbsp; Equipment Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_equipment_type_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->

       <!--  <div class="col-3 settingtab">
        <div class="card bg-chocolate">
          <div class="card-body">
                        <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/bulkhead_placement"?>"><i class="fa fa-columns"></i> &nbsp; Bulk Head Placement</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_bulkhead_placement_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div>  --><!-- end of 9th row -->



<!-- <div class="row p-1"> -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-darkseagreen">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/rule"?>"> <i class="fab fa-gg-circle"></i> &nbsp; Rules</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_rule_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-coral">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/inspection"?>"> <i class="fas fa-chart-bar"></i> &nbsp; Inspection</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_inspection_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-limegreen">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/fuel"?>"> <i class="fas fa-battery-three-quarters"></i> &nbsp; Fuel</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_fuel_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-firebrick">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/sourceofwater"?>"> <i class="fa fa-flask"></i> &nbsp; Source of water</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_sourceofwater_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div> --> <!-- end of 11throw -->

<!-- <div class="row p-1"> -->
  <!-- <div class="col-3 settingtab">
        <div class="card bg-darkturquoise">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/hullplating_material"?>"> <i class="fa fa-database"></i> Hull Plating Material&nbsp; </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_hullplating_material_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-darkslateblue">
          <div class="card-body">
             <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/hullmaterial"?>" > <i class="fa  fa-ship"></i>&nbsp; Hull Material</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_hullmaterial_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-indianred">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/insurance_type"?>"> <i class="fa  fa-credit-card"></i> &nbsp;Insurance Type </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_insurance_type_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-darkolivegreen">
          <div class="card-body">

            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/bank"?>"> <i class="fas fa-rupee-sign"></i>&nbsp;Bank </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_bank_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
<!-- </div> --> <!-- end of 12th row -->

<!-- <div class="row p-1"> -->
  <!-- <div class="col-3 settingtab">
        <div class="card bg-burlywood">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/propulsionshaft_material"?>"> <i class="fa  fa-expand"></i>&nbsp; Propulsion Shaft Material</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_propulsionshaft_material_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-palevioletred">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/meansofpropulsion"?>" > <i class="fa fa-i-cursor"></i> &nbsp; Means of Propulsion</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_meansofpropulsion_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-mediumorchid">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/pollution_controldevice"?>"> <i class="fa fa-recycle"></i> &nbsp; Pollution control</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_pollution_controldevice_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-sienna">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/garbage"?>"> <i class="fas fa-trash"></i>&nbsp; Garbage Collection</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_garbage_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
    
<!-- </div> --> <!-- end of 13th row -->
<!-- <div class="row p-1"> -->
    <!-- <div class="col-3 settingtab">
        <div class="card bg-darkorchid">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/searchlight_size"?>"> <i class="fa  fa-crosshairs"></i> &nbsp; Searchlight Size</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_searchlight_size_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-cadetblue">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" href="<?php echo $site_url."/Kiv_Ctrl/Master/firepumptype"?>"> <i class="fa  fa-fire-extinguisher"></i> &nbsp; Fire Pump Type</a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_firepumptype_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-crimson">
          <div class="card-body">
           <h5 class="card-title  card-border"><a class="btn btn-flat card_white" > &nbsp; </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div> --> <!-- end of col3 -->
   <!--  <div class="col-3 settingtab">
        <div class="card bg-hotpink">
          <div class="card-body">
            <h5 class="card-title  card-border"><a class="btn btn-flat card_white" > &nbsp; </a> </h5>
            <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');echo $helper_table[0]['mastertable_records']; ?> </span>
          </div>
        </div>
    </div>  --><!-- end of col3 -->
<!-- </div> --> <!-- end of 14th row -->
<!--- -------------------------------------- end of main content bar -------------------------------------- -->
</div> <!-- end of container -->
</div>
<script type="text/javascript">
$('#search').click(function(){
    $('.settingtab').hide();
    var txt = $('#search-criteria').val();
    $('.settingtab').each(function(){
       if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
           $(this).show();
       }
    });
});
$('#refreshBtn').click(function () {
  location.reload();
  })
</script>