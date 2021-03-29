<?php 
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');

?>

<script type="text/javascript">
$(document).ready(function() {
  $(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
 }); 

  function reprint_req(id){
   
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/reprint_request/')?>",
      type: "POST",
      dataType:"JSON",
      data:{  id:id},
      
      success: function(data)
      { //alert(data);exit;
       if(data['val_errors']!=""){
        //$("#msgDiv").show();
        var html ="";
        if(data['status']=="true")
        {
          var btn = "btn-success";
        }
        else
        {
          var btn = "btn-danger";
        }

        html ='<div id="msgDiv" class="alert '+btn+' alert-dismissible" >'+data['val_errors']+'</div>'
        //document.getElementById('msgDiv').innerHTML=""+data['val_errors']+"";
        $("#resp_msg").html(html);
      } 
    }

    });
  }
</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
 <div id="resp_msg">
   <!--  <div id="msgDiv" class="alert  alert-dismissible" ></div>  -->
  </div>
<div class="main-content ui-innerpage">
 
   <div class="row no-gutters p-1 justify-content-center">
    
    
    <div class="col-12 p-1 ">
     
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
          <thead class="thead-light">
         
          <tr>
            <th>Sl.No</th>
            <th>Vessel Name</th>
            <th>KIV Number</th>
            <th></th>
          </tr>
      
             </thead>
             <tbody>
         <?php $i=1; foreach ($vessel_reg_reprint_req as $req_value) {

               $id=$req_value['vesselmain_vessel_id'];
               $vesselmain_reg_number=$req_value['vesselmain_reg_number'];
               $vesselmain_vessel_name=$req_value['vesselmain_vessel_name'];
               $request_status=$req_value['reprint_request_status'];
               $approve_status=$req_value['reprint_approve_status'];
               $get_regn_plate_id = $this->Survey_model->get_reprint_id($id);
               

         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $vesselmain_vessel_name; ?></td>
            <td><?php echo $vesselmain_reg_number; ?></td>
            <td><?php if(($request_status==0)&&($approve_status==0)){?><button type="button" class="btn btn-flat btn-point bg-mediumorchid"  onclick="reprint_req(<?php echo $id;?>);" ><i class="fas fa-file-archive"></i>&nbsp; Reprint Request </button><?php } elseif((($request_status==1)&&($approve_status==0))||((($request_status==1)&&($approve_status==2)))){?><button type="button" class="btn btn-flat btn-point btn-info" style="cursor: none;" ><i class="fas fa-share"></i>&nbsp;  Reprint Request Sent to PC </button><?php } elseif(($request_status==1)&&($approve_status==1)){?> <button type="button" class="btn btn-flat btn-point btn-success" style="cursor: none;" ><i class="far fa-thumbs-up"></i>&nbsp; Reprint Request approved by PC </button><?php } elseif(($request_status==0)&&($approve_status==2)){?> <button type="button" class="btn btn-flat btn-point bg-crimson"  onclick="reprint_req(<?php echo $id;?>);" ><i class="fas fa-file-archive"></i>&nbsp; Request For Reprint </button> <br/><span class="badge badge-warning">Reprint Request Cancelled by PC </span><?php }?></td>
                     
          </tr>
        <?php $i++;} ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Sl.No</th>
            <th>Vessel Name</th>
            <th>KIV Number</th>
            <th></th>
          </tr>
        </table>
      </div> <!-- end of table responsive -->
     
    </div> <!-- end of col10 -->
   </div> <!-- end of table display row -->
  
</div> <!-- end of main content -->
