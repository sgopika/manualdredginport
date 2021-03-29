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
function del_canoe(id)
{
	var a=confirm("are you sure?");
	var tbl_name='canoe_registration';
	var uni_f='canoe_registration_id';
	var u_f='canoe_registration_status';
	if(a==true)
	{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Master/deldata')?>",
				type: "POST",
				data:{id:id,tbl_name:tbl_name,uni_f:uni_f,u_f:u_f},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
	}
	else
	{
	}
}

</script>

<!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Canoe Registration</span>
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
          <li class="breadcrumb-item"><a href="#"><strong>Canoe Registration</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->

 <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

  <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "canoe_registration", "name" => "canoe_registration" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/canoeRegistration_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/canoeRegistration_add", $attributes);
		}?>

<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
            <a href="<?php echo $site_url.'/Manual_dredging/Master/canoeregistration_add';?>">
             <button type="button" class="btn btn-sm btn-primary" > <i class="fa fa-plus-circle"></i>&nbsp; Add New Canoe </button>
              </a>
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->

<div class="row">
		<div class="col-12">
		<!-- ///////////////////////// start of table column //////////////////////---- -->
		<table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Canoe</th>
                  <th>Status</th>
				  <th>View</th>
                  <th id="th_div"> Edit</th>
                  <th> Delete </th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				  $i=1; foreach($reg_canoe_list as $rowmodule){
					 $id = $rowmodule['canoe_registration_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['canoe_name']);?></div>
                        </td>
						<?php 
							if ($rowmodule['canoe_registration_status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['canoe_registration_status'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['canoe_registration_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
							<td>  <a href="<?php echo $site_url.'/Manual_dredging/Master/canoeregistration_view/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View  </button></a> </td>
						<td id="td_div_<?php echo $i;?>"> 
                        <div id="edit_div_<?php echo $i;?>">
                        <a href="<?php echo $site_url.'/Manual_dredging/Master/canoeregistration_edit/'.encode_url($id);?>"> <button name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button> 	</a> 					
                        </div>
                       
                        </td>
						<td> <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="del_canoe(<?php echo $id;?>)"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button> </td>
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
               
              </table>
             <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col10 -->
               <!-- end of col2 -->
	</div>
  
  
   
   </div> <!-- ui innerpage closed-->
   
   
  