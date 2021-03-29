<?php 
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');

$modid=2;
$modidenc     = $this->encrypt->encode($modid); 
$modidenc    = str_replace(array('+', '/', '='), array('-', '_', '~'), $modidenc);

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
      data:{  id:id},
      dataType:"JSON",
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
    <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div> 
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
            <!-- <th>Print Request Date</th> -->
            <th>Total Print</th>
            
          </tr>
      
             </thead>
             <tbody>
         <?php $i=1; foreach ($single_print as $req_value) {
               $id=$req_value['vesselmain_vessel_id'];
               $idenc     = $this->encrypt->encode($id); 
               $idencd    = str_replace(array('+', '/', '='), array('-', '_', '~'), $idenc);
               $vesselmain_reg_number=$req_value['vesselmain_reg_number'];
               $vesselmain_vessel_name=$req_value['vesselmain_vessel_name'];
               //$reprint_reqtimestamp=$req_value['reprint_reqtimestamp'];
              $print_count=$req_value['print_count'];

         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $vesselmain_vessel_name; ?></td>
            <td><?php echo $vesselmain_reg_number; ?></td>
            <!-- <td><?php echo $reprint_reqtimestamp; ?></td> -->
            <td><?php echo $print_count; ?></td>
            
                     
          </tr>
        <?php $i++;} ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Sl.No</th>
            <th>Vessel Name</th>
            <th>KIV Number</th>
            <!-- <th>Print Request Date</th> -->
            <th>Total Print</th>
            
          </tr>
        </table>
      </div> <!-- end of table responsive -->
     
    </div> <!-- end of col10 -->
   </div> <!-- end of table display row -->
  
</div> <!-- end of main content -->
