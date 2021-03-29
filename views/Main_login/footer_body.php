                

<div class="container-fluid ui-innerpage">

<?php if(isset($id)){ 
  foreach($footeritem as $footer_item_list_res){
      $footitem_sl          = $footer_item_list_res['bodycontent_sl']; 
      $footitem_title       = $footer_item_list_res['bodycontent_engtitle']; 
      $footitem_maltitle    = $footer_item_list_res['bodycontent_maltitle'];
      $footitem_engcontent  = $footer_item_list_res['bodycontent_engcontent']; 
      $footitem_malcontent  = $footer_item_list_res['bodycontent_malcontent'];
    }
 ?>
<div class="row " > 
   <nav aria-label="breadcrumb " class="mb-0">
     <ol class="breadcrumb justify-content-end mb-0">
        <li class="breadcrumb-item"><?php if($id==1){?> <a href="<?php echo base_url()."index.php/Main_login/index_mal"?>"> <i class="fas fa-home"></i> Home</a> <?php } else { ?><a href="<?php echo base_url()."index.php/Main_login/index"?>"><i class="fas fa-home"></i> Home </a> <?php }?></li>
       
      </ol>
  
</nav>
  <div class="port-content-head col-12 no-gutters">
              <button type="button" class="btn btn-point btn-flat btn-block btn-primary bcontentfont nocursor"><i class="fab fa-servicestack"></i>&nbsp;<?php if($id==1){ echo $footitem_maltitle; } else { echo $footitem_title;  }?></button>
  </div>
          <div class="port-content col-12 port-bg-lightgray text-justify">
                <p class="contentfont"><?php if($id==1){  echo $footitem_malcontent; } else { echo $footitem_engcontent; }?></p>
            </div>
</div> 

<?php }?>
</div>