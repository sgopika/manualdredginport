<script>
  function toggle_status(id,status)
{
 
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/status_inbox/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}

 function fwd_mail(id,serv)
{ 
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/fwd_mail/')?>",
        type: "POST",
        data:{ id:id,serv:serv},
        dataType: "JSON",
        success: function(data)
        {//alert(data);exit;
          window.location.reload(true);
        }
      });
}
</script>
<!----------------------------------------start of breadcrumb bar -------------------------------------- ------- -->
<div class="container-fluid ui-innerpage">
<div class="row py-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innertitle "> Inbox </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a href="<?php echo $site_url."/Super_Ctrl/Super/SuperHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<!---------------------------------------- start of main content area  ---------------------------------------- -->
  <div id="resp_msg" >
    <!-- <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div>  -->
  </div>
    
  
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">From</th>
              <th id="col_name">Service</th>
              <th id="col_name">Subject</th>
              <th>View</th>
              <th>Status</th>
              <th id="th_div">Forward</th>
              
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($data);
          $i=1;
          foreach($mail_list as $rowmodule){
          $id           = $rowmodule['mailbox_sl'];
          $serv_id      = $rowmodule['mailbox_service'];
          $service_det  = $this->Super_model->get_service_det($serv_id);
          foreach($service_det as $serv_res){
              $serv_name =  $serv_res['services_engtitle'];
          }
          
          ?>
            <tr id="<?php echo $i;?>">
              <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
              <td id="col_div_<?php echo $i; ?>">
                <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['mailbox_from'];?></div>
              
              </td>
              <td id="col_div1_<?php echo $i; ?>">
                <div id="first1_<?php echo $i;?>" ><?php echo $serv_name;?></div>
                
              </td>
              <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['mailbox_subject'];?></div>
                 
                </td>
                <td class=""><a target=""  class="pop" data-subject="<?php echo htmlentities($rowmodule['mailbox_subject']);?>" data-body="<?php echo htmlentities($rowmodule['mailbox_body']);?>" style="cursor: pointer;"><i class="fas fa-eye text-orange"></i></a></td>
               
                <td>
                  <?php  if($rowmodule['mailbox_status']=='1')
                  {
                  ?>
                  <button class="btn btn-sm btn-flat btn-point btn-primary " type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['mailbox_status'];?>);"  > <i class="far fa-bell"></i>   </button> 
                  <?php
                  }
                  else{
                    ?>
                     <button class="btn btn-sm btn-flat btn-point btn-warning"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['mailbox_status'];?>);"> <i class=" fas fa-bell-slash
"></i>  </button> 
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <div id="edit_div_<?php echo $i;?>">
                    <?php  if($rowmodule['mailbox_to']=='')
                    {
                    ?>
                    <button name="fwd" id="fwd" class="btn btn-sm btn-flat btn-point btn-info" type="button" onclick="fwd_mail(<?php echo $id;?>,<?php echo $serv_id;?>);"><i class="fas fa-share"></i> &nbsp; Forward </button> 
                    <?php } else {?>
                      <button name="fwd" id="fwd" class="btn btn-sm btn-flat btn-point btn-success" type="button" > &nbsp; Forwarded </button>
                     <?php } ?> 
                    <!-- <button name="edit_title_btn_<?php echo $i;?>" id="edit_title_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_title(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>  -->  
                    <!-- <button name="edit_footer_btn_<?php echo $i;?>" id="edit_footer_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_footer(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>   -->        
                  </div>
                  <!-- <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_footer_<?php echo $i;?>" id="save_footer_<?php echo $i;?>" onclick="save_footer(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_footer_<?php echo $i;?>" id="cancel_footer_<?php echo $i;?>" onclick="cancel_footer(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div> -->
                  </td>
                  <!-- <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete Footer Menu?')){ del_footer(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
                  <?php
          }
          ?>
                  </td> -->
                 
                </tr>
                <?php
          $i++;
        }
          ?>
              
                </tbody>
                <?php
                 echo form_close(); ?>
              </table>
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col12 -->

               
    </div> <!-- end of table row -->
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
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $(".pop").click(function(){
        var subject = $(this).data("subject"); 
        var body = $(this).data("body");
        
        
          $("#subject").html(subject);
          $("#body").html(body);
        
        $("#myModal").modal("show");
      

      })    
  })

</script>

<!---------------------------------------- end of main content area  ---------------------------------------- -->