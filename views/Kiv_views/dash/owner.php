<!-- --------------------------- Container Class overridden for edge free design  ---------------------------- -->
<div class="main-content ui-innerpage">  
  <div class="row no-gutters">
    <div class="col-2 text-primary kivheader">
        <button type="button" class="btn btn-primary btn-block kivbutton no-cursor"><i class="fas fa-ship"></i> Kerala Inland Vessel</button>
      </div> <!-- end of col-2 text-primary kiv-header -->
      <div class="col-10"> </div> 
  </div> <!-- end of first row (logo) -->

  <!-- ------------------------------------second row starts here ------------------------------------ -->
  <div class="row no-gutters px-2">
    <!-- --------------------------------------- START OF WIDGET 01 ----------------------------------------- -->
<?php //print_r($menu);
$cnt=count($menu);
for($i=0;$i<10;$i++)
{
              $table="";
              if($i==1){
                $table = "vw_ownerincomp_cnt";
              }
              if($i==2){
                $table = "vw_ownerinbx_cnt";
              }
              if($i==3){
                $table = "vw_ownernamchgstat_cnt";
              }
              if($i==4){
                $table = "vw_ownerownchgstat_cnt";
              }
              if($i==5){
                $table = "vw_ownertfrvslstat_cnt";
              }
              if($i==6){
                $table = "vw_ownertfrvsloutstat_cnt";
              }
              if($i==7){
                $table = "vw_ownerdupcertstat_cnt";
              }
              if($i==8){
                $table = "vw_ownerspecsrvy_cnt";
              }
              if($i==9){
                $table = "vw_ownerbookregn_cnt";
              }
              if($table!=""){ 
                $get_count  = $this->Survey_model->get_view_count($table);//print_r($get_count);
                  if(!empty($get_count)){
                  foreach($get_count as $vw_res){
                    $uid       = $vw_res['uid'];
                    $sess_user  = $_SESSION['int_userid'];
                    if($uid==$sess_user){
                    @$vw_cnt   = $vw_res['cnt'];
                    }
                  }//exit;
                 } else {$vw_cnt=0;}
              } else {
                $vw_cnt=0;
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
                      </h5> 
                      <p class="card-text"><small class="text-muted"> <?php if($i!=0){  echo @$vw_cnt;  } else { echo "0"; } ?> NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
        <!-- -------------------------------- end of each Widget menu item ------------------------------------- -->

<?php }?>
 <?php if($i=26){?>
  <div class="col-4 p-2">
    <div class="card ">
      <div class="row no-gutters">
        <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
          <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
        </div>
        <div class="col-8 leftbordercard">
          <div class="card-body">
            <h5 class="card-title">
              <a class="no-link" href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">                
                           <?php echo $menu[$i]['sub_modue_name']; ?> </a> <br>
            </h5>
                      
          </div>
        </div> 
      </div> 
    </div>
  </div>

<?php }?> 

 <?php if($i=22){ //print_r($var);?>
  <div class="col-4 p-2">
    <div class="card ">
      <div class="row no-gutters">
        <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
          <i class="<?php echo $menu[$i]['icon_name'];?>"></i>
        </div>
        <div class="col-8 leftbordercard">
          <div class="card-body">
            <h5 class="card-title">
              <a class="no-link " href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>">                
                           <?php echo $menu[$i]['sub_modue_name']; ?> </a>
            </h5>
                <?php if($var>0){?><span class="badge  bg-tomato btn-point  text-light"> Renewal Required</span> <?php } ?>     
          </div>
        </div> <!-- end of col8 -->
      </div> <!-- end of row -->
    </div>
  </div>

<?php }?>
<!-- ------------------------------------------ END OF WIDGET 01 ---------------------------------------------- -->

  </div> <!-- end of row -->
  <!-------------------------------------- second row ends here  -------------------------------------->
  <!--  ------------------------------------ third row starts here ------------------------------------  -->
<div class="row no-gutters">
    <div class="col-12"> 
      <div class="card">
  <div class="card-header text-primary">
    <i class="fas fa-project-diagram"></i> Request Forms
  </div>
  <div class="card-body layoutcolor">
    <div class="row no-gutters layoutcolor">
      <!-- =================== Added for dynamic menu listing(start) on 02.11.2019=======--->
      <div class="col-3">
          <ul class="list-group">
           <?php //print_r($menu);
             if($j=10)
             //foreach($menu as $details)
            {?>
              
              <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" class="list-group-item list-group-item-action text-primary "><i class="<?php echo $menu[$j]['icon_name'];?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
              
             <?php }?>
             <?php //print_r($menu);
             if($j=12)
             //foreach($menu as $details)
            {?>
              
              <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" class="list-group-item list-group-item-action text-primary "><i class="<?php echo $menu[$j]['icon_name'];?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
              
             <?php }?>
             </ul>
          </div> <!-- end of col-3 -->
          <div class="col-3">
            <ul class="list-group">
           <?php //print_r($menu);
             if($j=11)
             //foreach($menu as $details)
            {?>
              
              <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" class="list-group-item list-group-item-action text-primary "><i class="<?php echo $menu[$j]['icon_name'];?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
              
             <?php }?>
             <?php //print_r($menu);
             if($j=13)
             //foreach($menu as $details)
            {?>
              
              <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" class="list-group-item list-group-item-action text-primary "><i class="<?php echo $menu[$j]['icon_name'];?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
              
             <?php }?>
             </ul>
          </div> <!-- end of col-3 -->
          <div class="col-3">
            <ul class="list-group">
              <a href="" class="list-group-item list-group-item-action text-primary "><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;Alteration of Vessel</a>
              
             <?php  if($j=14)
             //foreach($menu as $details)
            {?>
              
              <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" class="list-group-item list-group-item-action text-primary "><i class="<?php echo $menu[$j]['icon_name'];?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
              
             <?php }?>  
              
            </ul>
          </div> <!-- end of col-3 -->
          <div class="col-3">
            <ul class="list-group">
               <a href="" class="list-group-item list-group-item-action text-primary "><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;Appeal Form </a>
              
             <?php  if($j=15)
             //foreach($menu as $details)
            {?>
              
              <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" class="list-group-item list-group-item-action text-primary "><i class="<?php echo $menu[$j]['icon_name'];?>"></i> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
              
             <?php }?>  
              
            </ul>
          </div> <!-- end of col-3 -->

        </div> <!-- end of row 3rd-->
  </div> <!-- end of card-body -->
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of another row -->
  <!--  ------------------------------------ third row ends here  ------------------------------------ -->
  <!--  ------------------------------------ fourth row starts here ------------------------------------  -->
<div class="row no-gutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
   <i class="fas fa-pallet"></i> Completed Surveys
  </div>
  <div class="card-body layoutcolor">
    <div class="row no-gutters">

      <?php  //print_r($menu); 
      //if($j=16)
        for($j=16;$j<20;$j++)
          {   //foreach($menu as $details)
          if($j==16){ $countt = @$count_initial_survey;} elseif ($j==17) { $countt = @$count_annual_survey;} elseif ($j==18) { $countt = @$count_drydock_survey; } elseif ($j==19) { $countt = @$count_special_survey; }
          
      ?>
        <div class="col-3 px-2">      
        <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" <?php if($j==16){?>class="btn btnwidget1 btn-block btn-lg" <?php } elseif ($j==17) { ?>class="btn btnwidget2 btn-block btn-lg"<?php }elseif ($j==18) {?>class="btn btnwidget3 btn-block btn-lg"<?php }elseif ($j==19) {?>class="btn btnwidget4 btn-block btn-lg"<?php }?> id="inbox_link"><i class="<?php echo $menu[$j]['icon_name'];?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?>
        <span class="badge badge-success badge-pill"><?php if(isset($countt)){ echo @$countt; } else { echo "0";}?></span>
      </a>
         </div>     
      <?php }?> 
      </div> <!-- end of row 3rd-->
  </div> <!-- end of card-body -->
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 6th row -->
  <!--  ------------------------------------ fourth row ends here ------------------------------------  -->
  <!--  ------------------------------------ fifth row starts here ------------------------------------  -->
<div class="row no-gutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
   <i class="fas fa-search"></i> Features
  </div>
  <div class="card-body layoutcolor">
    <div class="row no-gutters">
        <?php if($j==20){?>
          <div class="col-3 px-2">
          <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" id="form12_link" class="no-link text-white"> <button type="button" class="btn bg-midnightblue btn-block btn-lg"> <i class="<?php echo $menu[$j]['icon_name'];?>"></i> &nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
        </div>
        <?php } ?>
        <?php for($j=23;$j<=25;$j++){
          if($j==23){$bacg="btn bg-darkorchid btn-block btn-lg";} elseif($j==24){$bacg="btn bg-mediumorchid btn-block btn-lg";} else{$bacg="btn bg-darkslateblue btn-block btn-lg";}?>
          <div class="col-3 px-2">
          <a href="<?php echo $site_url.'/'.$menu[$j]['sub_module_path'];?>" id="form12_link" class="no-link text-white"> <button type="button" class="<?php echo $bacg;?>"><i class="<?php echo $menu[$j]['icon_name'];?>"></i> &nbsp;&nbsp;<?php echo $menu[$j]['sub_modue_name']; ?></a>
        </div>
         <?php }?> 
          
    </div> <!-- end of row 3rd-->
  </div> <!-- end of card-body -->
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 6th row -->
  <!--  ------------------------------------ fifth row ends here ------------------------------------  -->
  <!--  ------------------------------------ sixth row starts here ------------------------------------  -->
<div class="row no-gutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
    <div class="row no-gutters">
    <div class="col-3">
   <i class="fas fa-info-circle"></i> Information
 </div>
 <div class="col-9 d-flex justify-content-end"><?php if($i=21){ ?> <a href="<?php echo $site_url.'/'.$menu[$i]['sub_module_path'];?>"   class="no-link" style="cursor: pointer;"> <?php echo $menu[$i]['sub_modue_name']; ?> </a>&nbsp;&nbsp;|&nbsp;&nbsp; <?php } ?><a target=""  class="pop" data-subject="<?php echo "Disclaimer";?>" style="cursor: pointer;"> Disclaimer </a>&nbsp;&nbsp;|&nbsp;&nbsp; <a target=""  class="pop" data-subject="<?php echo "Terms and Conditions";?>" style="cursor: pointer;">Terms &amp; Condition</a>
 </div>
</div>
  </div>
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 7th row -->
  <!--  ------------------------------------ sixth row ends here  ------------------------------------ -->
</div> <!--  ------------------------------------ end of main-content class  ------------------------------------ -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="form-group">
          <strong id="subject"></strong>
        </div>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <!-- <h4 class="modal-title" id="myModalLabel">Image preview</h4> -->
      </div>
      <div class="modal-body">
          
        <div class="form-group" id="body">
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>Close</button>
      </div> -->
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $(".pop").click(function(){
        var subject = $(this).data("subject"); 
       
          $("#subject").html(subject);
                 
        $("#myModal").modal("show");
      

      })    
  })

</script>