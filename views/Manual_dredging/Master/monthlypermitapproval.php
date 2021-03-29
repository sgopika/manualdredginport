<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>
<!-- Page specific script starts here -->
<script type="text/javascript" language="javascript">

/*function toggle_status(id,status)
{
	$.ajax({
				url : "<?php// echo site_url('Master/status_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

function del_userposing(id,status)
{
	$.ajax({
				url : "<?php// echo site_url('Master/delete_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}*/

</script>

 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Monthly Permit</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Monthly Permit</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

  <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>

 <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">

                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Permit</th>
                  <th>Zone</th>
                  <th>Local Body</th>
                  <th>Status</th>
				  <th>View</th>
                  <th>Download Permit</th>
                  <!--<th id="th_div"> Edit</th>
                  <th> Delete </th>-->
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=1; foreach($monthly_permit_list as $rowmodule){
					 $id = $rowmodule['monthly_permit_id'];
					 $zone_name	=	$this->Master_model->get_zone_name_by_id($rowmodule['zone_id']);
					 $lsgd_name	=	$this->Master_model->get_lsgdname_by_id($rowmodule['lsg_id']);
					 $zone_name=$zone_name['zone_name'];
					 $lsgd_name_name=$lsgd_name['lsgd_name'];
					 $statusValue='';
					 $status = $rowmodule['monthly_permit_permit_status'];
					 if($status==1){
						 $statusValue='Approval Pending';
						 $butclass='btn btn-sm bg-blue';
					}else if($status==2){
						$statusValue='Approved';
						$butclass='btn btn-sm bg-green';
					}else if($status==3){
						$statusValue='Rejected';
						$butclass='btn btn-sm bg-red';
					}
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['monthly_permit_period_name']);?></div>
                        </td>
                        <td><?php echo $zone_name; ?></td>
                        <td><?php echo $lsgd_name_name; ?></td>
						
						<td> <button class="<?php echo $butclass ?>"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; <?php echo $statusValue ?> &nbsp;&nbsp; </button> </td>
							
                        <td>  <a href="<?php echo $site_url.'/Manual_dredging/Master/monthlypermitapprovalview/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View  </button></a> </td>
                    
                    
                    <?php if($status==2){ ?>
                        <td>
                               <a href="<?php echo $site_url.'/Manual_dredging/Master/monthlypermit_approval_pdf_dwnld/'.encode_url($id);?>"> <button name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i>Download Permit</button> 	</a> 
                            
                        </td>
                    <?php }else{ ?>
                        <td><?php echo $statusValue; ?></td>
                    <?php	} ?>
                        
                        </tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
               
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     