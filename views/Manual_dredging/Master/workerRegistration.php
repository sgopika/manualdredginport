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
				url : "<?php// echo site_url('Master/status_workerregistration/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}*/
function del_workerregistration(id)
{
	var a=confirm("are you sure?");
	var tbl_name='worker_registration';
	var uni_f='worker_registration_id';
	var u_f='worker_registration_status';
	if(a==true)
	{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Master/del_worker')?>",
				type: "POST",
				data:{id:id,tbl_name:tbl_name,uni_f:uni_f,u_f:u_f},
				//dataType: "JSON",
				success: function(data)
				{
					//alert(data);
					alert("Worker successfully deleted");
					window.location.reload(true);
				}
			});
	}
	else
	{
	}
}
/*function del_workerregistration(id,status)
{
	
	$.ajax({
				url : "<?php// echo site_url('Master/deldata')?>",
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
     <div class="row py-3">
        <div class="col-md-4">
        
		</div>

    <div class="col-12 d-flex justify-content-end">
     <?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	 else if($sess_user_type==4)
	{ 
		$url=site_url("Manual_dredging/Port/port_lsgd_main");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        	 
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>>Worker Registration </strong></a></li>
      </ol>
    </div>
    <!-- Main content -->
    
        <div class="col-md-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      </div> <!-- end of co12 -->
		</div> <!-- end of row -->  



    <!-- Main content -->
     <div class="row">
		<div class="col-12">
          <!-- /.box -->
          <div class="box" >
            <?php
        $attributes = array("class" => "form-horizontal", "id" => "worker_registration", "name" => "worker_registration" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/workerregistration_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/workerregistration_add", $attributes);
		}?>
            <div class="box-header" id="view_designation">
              <a href="<?php echo $site_url.'/Manual_dredging/Master/workerregistration_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add New worker</button>
              </a>
            </div>
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Worker</th>
                  <th>Status</th>
				  <th>View</th>
                  <th id="th_div"> Edit</th>
                  <th> Delete </th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=1; foreach($reg_worker_list as $rowmodule){
					 $id = $rowmodule['worker_registration_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['worker_registration_name']);?></div>
                        </td>
						<?php 
							if ($rowmodule['worker_registration_status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['worker_registration_status'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['worker_registration_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
							<td>  <a href="<?php echo $site_url.'/Manual_dredging/Master/workerregistration_view/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View  </button></a> </td>
						<td id="td_div_<?php echo $i;?>"> 
                        <div id="edit_div_<?php echo $i;?>">
                        <a href="<?php echo $site_url.'/Manual_dredging/Master/workerregistration_edit/'.encode_url($id);?>"> <button name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button> 	</a> 					
                        </div>
                       
                        </td>
						<td> <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="del_workerregistration(<?php echo $id;?>)"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button> </td>
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
      </div>
    <!-- /.row -->
  </div>