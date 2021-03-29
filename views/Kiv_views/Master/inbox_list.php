<!-- ------------------------------------ Main Container starts here ------------------------- -->
<div class="main-conten ui-innerpage p-1">
  <div class="row py-1 px-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innerservices "> Inbox </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<div id="resp_msg" class="p-1">
    <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div> 
</div>
<?php 
        $attributes = array("class" => "form-horizontal", "id" => "services_list", "name" => "services_list" , "novalidate");
      echo form_open("Kiv_Ctrl/Master/save_services", $attributes);
?>
<div class="row p-1">
        <div class="col-12 table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">From</th>
              <th id="col_name">Service</th>
              <th id="col_name">Subject</th>
              <th id="col_name">Received</th>
              <th id="col_name">View</th>
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($data);
          $i=1;
          foreach($mailbox_list as $rowmodule){
          $id           = $rowmodule['mailbox_sl'];
          $serv_id      = $rowmodule['mailbox_service'];
          $service_det  = $this->Master_model->get_service_det($serv_id);
          foreach($service_det as $serv_res){
              $serv_name =  $serv_res['services_engtitle'];
          }
          $fwdd_date      = $rowmodule['mailbox_forwarded'];
          $fwdd_date_exp  = explode(' ',$fwdd_date);
          $cnt1           = count($fwdd_date_exp);
          if($cnt1>0){
            @$fwdd_dt        = $fwdd_date_exp[0];
            @$fwdd_tme       = $fwdd_date_exp[1];
          }
          $fwdd_dt_exp    = explode('-', $fwdd_dt);
          $cnt2           = count($fwdd_dt_exp);
          if($cnt2>0){
          @$fwdd_dt_fnl    = $fwdd_dt_exp[2].'-'.$fwdd_dt_exp[1].'-'.$fwdd_dt_exp[0];
          $fwdd_dt_tm_fnl = $fwdd_dt_fnl.' '.$fwdd_tme;
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
              <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $fwdd_dt_tm_fnl;?></div>
                </td>
                <td><a target=""  class="pop" data-subject="<?php echo htmlentities($rowmodule['mailbox_subject']);?>" data-body="<?php echo htmlentities($rowmodule['mailbox_body']);?>" style="cursor: pointer;"><i class="fas fa-eye text-orange"></i></a></td>
                </tr>
                <?php
          $i++;
        }
          ?>
                </tbody>
              </table>
              </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->
<?php echo form_close(); ?>
</div> <!-- end of main content -->
<!-- ------------------------------------ Main Container ends here ------------------------- -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="form-group">
          <strong id="subject"></strong>
        </div> <!-- end of form group -->
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div> <!-- end of modal header -->
      <div class="modal-body">
        <div class="form-group" id="body">
        </div> <!-- end of form group -->
      </div> <!-- end of modal body -->
    </div> <!-- end of modal content -->
  </div> <!-- end of modal dialog -->
</div> <!-- end of modal -->

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