
<!-- Page specific script starts here -->
<script type="text/javascript" language="javascript">

function toggle_status(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/status_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

function del_holidays(id,status)
{
	if(status==1){
		$.ajax({
				url : "<?php echo site_url('Master_model/del_holidays/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
	}else{
		alert('Sorry !! Holidays cant be deleted after the Approval of Permit for this Period');
		
	}
	
	
}

</script>
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
	 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Holiday Settings</span>
	</div>  <!-- end of col4 -->
	<?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Holiday Settings</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
	
	  <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "holidaysettings", "name" => "holidaysettings" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($holiday_period_name)){
       		echo form_open("Manual_dredging/Master/holidays_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/holidays_add", $attributes);
		}?>
	
	 <div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
            <a href="<?php echo $site_url.'/Manual_dredging/Master/holi_period_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add New <strong>Holiday</strong></button>
              </a>
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
	  <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl.No</th>
                  <th>Holiday</th>
				  <th>Zone</th>
                  <th>Status</th>
				  <th>View</th>
                  <th> Edit</th>
                 <!-- <th> Delete </th>-->
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=0; 
				 	 if(($period_holidays_list) != null){
				 foreach($period_holidays_list as $rowmodule)
				 {
					 $i++;
					 $id = $rowmodule['holiday_period_name'];
					$zone_id=$rowmodule['holiday_zone_id'];
					 $permit_status=1;
					 //$this->load->model('../Master_model');
					 $permit_det = $this->Master_model->get_montlyPermit_by_periodname($id,$port_id);
					//print_r($permit_det);
						if($permit_det!='')
						{
							$permit_status 	= $permit_det['monthly_permit_permit_status'];
						
						}
					?>
					<tr>
						<td> <?php echo $i ?></td>
						<td>
                        <div><?php echo strtoupper($rowmodule['holiday_period_name']);?></div>
                        </td>
						<td>
                        <div><?php echo strtoupper($rowmodule['zone_name']);?></div>
                        </td>
						
						<?php 
							if ($rowmodule['holiday_status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['holiday_status'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else { ?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['holiday_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
						<?php } ?>
							<td>  <a href="<?php echo $site_url.'/Manual_dredging/Master/holiday_view/'.encode_url($id).'/'.encode_url($zone_id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View  </button></a> </td>
						<td> 
                        <div>
                        
                        <?php if($permit_status==4){ ?>
                        
                        <a href="" onClick="alert('Holiday cant edit after the approval of Monthly Permit')"> <button name="edit_designation_btn" id="edit_designation_btn" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button></a> 			
						<?php /*?><?php }else{ ?>
                        
							<a href="<?php echo $site_url.'/Master/holidays_edit/'.encode_url($id);?>"> <button name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button></a> 		
						<?php } ?>		<?php */?>
                        <?php }else{ ?>
                        
							<a href="<?php echo $site_url.'/Manual_dredging/Master/holidays_edit_new/'.encode_url($id).'/'.encode_url($zone_id);?>"> <button name="" id="" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button></a> 		
						<?php } ?>		
                        </div>
                       
                        </td>
						<?php /*?><td> <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Holidays?')){ del_holidays(<?php echo $id;?>,<?php echo $permit_status ?>);}"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button> </td><?php */?>
					</tr>
					<?php
				}
			}
                echo form_close(); ?>
                </tbody>
               
              </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     