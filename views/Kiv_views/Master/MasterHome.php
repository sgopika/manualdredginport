<!-- -------------------------------- breadcrumb starts here ----------------------------------- -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
    <!-- <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Library</li> -->
    <span class="badge bg-darkmagenta innertitle pt-2">Master Settings</span>
  </ol>
</nav>
<!-- -------------------------------- breadcrumb ends  here ----------------------------------- -->
<!-- -------------------------------- container starts here ----------------------------------- -->
<div class="main-content ui-innerpage">
  <div class="row py-2 ">
    <div class="col-12 d-flex justify-content-end">
      <input type="text" id="search-criteria" /> 
        <input type="button" id="search" value="search" class="btn btn-success btn-sm btn-flat btn-point" /> 
         <button type="button" name="refreshBtn" id="refreshBtn" class="ml-5 btn btn-flat btn-point btn-default btn-sm"> <i class="fas fa-sync-alt"></i> Refresh  </button>
    </div> <!-- end of col12 -->
  </div> <!-- end of row -->
  <!-- -------------------------------- Dyanmic row starts here ------------------------------ -->
  <?php $cnt=count($menu); 
    //if(($cnt%4)==0){?>
  <div class="row p-1"> <?php //}?>
   <?php 

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
    elseif ($i==56) { $class= "card bg-hotpink"; }
    elseif ($i==57) { $class= "card bg-darkslategray"; }
    elseif ($i==58) { $class= "card bg-maroon"; }
    elseif ($i==59) { $class= "card bg-midnightblue"; }
    ?>

    <div class="col-3 settingtab py-2">  
      <div class="<?php echo $class;?>">
        <div class="card-body">
          <h5 class="card-title  card-border card-border"> <a class="btn btn-flat card_white" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>"> <i class="<?php echo $menu[$i]['icon_name']; ?>"></i> <?php echo $menu[$i]['sub_modue_name']; ?></a></h5>
          <span class="progress-description d-flex justify-content-center"> Total records : <?php $helper_table=$this->Master_model->count_table_raws('kiv_dynamic_field_master');  echo $helper_table[0]['mastertable_records'];?></span>
        </div>
      </div>
    </div>  
    <?php }?>
  <?php //if(($cnt%4)==0){?> 
    </div> <?php //}?>

  <!-- -------------------------------- Dyanmic row ends  here ------------------------------ -->
</div> <!-- end of container -->
<!-- -------------------------------- container ends here ----------------------------------- -->
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