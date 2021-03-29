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
<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Monthly Permit</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_lsgd_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Monthly Permit</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
     
    
             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
		
     <div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
     
           
              <a href="<?php echo $site_url.'/Manual_dredging/Master/monthlypermit_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;Add Monthly Permit</button>
              </a>
                    <br/>
                    <h4 style="color:#00a65a;align:center;">Permit of <?php echo $zone_name ?> Zone in <?php echo $lsgd_name ?></h4>
                </div></div>
     
        <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th >Permit</th>
                  <th>Status</th>
				  <th>Download Permit</th>
 <!--			  <th id="th_div"> Edit</th>
                  <th> Delete </th>-->
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=1; foreach($monthly_permit_list as $rowmodule){
					 $id = $rowmodule['monthly_permit_id'];
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
					}					?>
					<tr>
						<td> <?php echo $i; ?> </td>
						<td>
                        	<div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['monthly_permit_period_name']);?></div>
                        </td>
                        <td class="<?php echo $butclass ?>" id="sl_div_<?php echo $i; ?>"> <?php echo $statusValue; ?> </td>
                        <?php if($status==2){ ?>
                            <td>
                               <a href="<?php echo $site_url.'/Manual_dredging/Master/monthlypermit_approval_pdf_dwnld/'.encode_url($id);?>"> <button name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i>Download Permit</button> 	</a> 
                            
                            </td>
						<?php }else{ ?>
							<td><?php echo $statusValue; ?></td>
                        <?php	} ?>
						
					</tr>
                    
				<?php	$i++; 
				} ?>
                </tbody>
             </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     