                

<div class="container-fluid ui-innerpage">

<?php if(isset($id)){ 
 
 ?>
<div class="row " > 
   <nav aria-label="breadcrumb " class="mb-0">
     <ol class="breadcrumb justify-content-end mb-0">
        <li class="breadcrumb-item"><?php if($id==1){?> <a href="<?php echo base_url()."index.php/Main_login/index_mal"?>"> <i class="fas fa-home"></i> Home</a> <?php } else { ?><a href="<?php echo base_url()."index.php/Main_login/index"?>"><i class="fas fa-home"></i> Home </a> <?php }?></li>
       
      </ol>
  
</nav>
<div class="port-content col-12  text-justify">
<?php
$i=1;
 foreach($marquee as $marquee_res){
      $webnotification_sl          = $marquee_res['webnotification_sl']; 
      $webnotification_engtitle    = $marquee_res['webnotification_engtitle']; 
      $webnotification_maltitle    = $marquee_res['webnotification_maltitle'];
      $webnotification_engcontent  = $marquee_res['webnotification_engcontent']; 
      $webnotification_malcontent  = $marquee_res['webnotification_malcontent'];
    
    ?>
   
          
                <p class="contentfont"><a target=""  class="pop" data-sl="<?php echo $webnotification_sl;?>" data-engtitle="<?php echo htmlentities($webnotification_engtitle);?>" data-maltitle="<?php echo htmlentities($webnotification_maltitle);?>" data-engcontent="<?php echo htmlentities($webnotification_engcontent);?>" data-malcontent="<?php echo htmlentities($webnotification_malcontent);?>" data-id="<?php echo $id;?>" style="cursor: pointer;"> <font color="#4b2df7"> <?php echo $i;?> . <?php if($id==1){  echo $webnotification_maltitle; } else { echo $webnotification_engtitle; }?></font></a></p>
           
  <?php $i++;}?> </div>          
</div> 
 

<?php }?>
</div>

<script type="text/javascript">
  $(document).ready(function(){
      $(".pop").click(function(){
        var id = $(this).data("id"); 
        var sl = $(this).data("sl");
        var engtitle =$(this).data("engtitle");
        var maltitle =$(this).data("maltitle");
        var engcontent =$(this).data("engcontent");
        var malcontent =$(this).data("malcontent");
        if(id==1){
          $("#title").html(maltitle);
          $("#content").html(malcontent);
        } else {
          $("#title").html(engtitle);
          $("#content").html(engcontent);
        }
        $("#myModal").modal("show");
      

      })    
  })

</script>


<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="form-group">
          <strong id="title"></strong>
        </div>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <!-- <h4 class="modal-title" id="myModalLabel">Image preview</h4> -->
      </div>
      <div class="modal-body">
          
        <div class="form-group" id="content">
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>Close</button>
      </div> -->
    </div>
  </div>
</div>