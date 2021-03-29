
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

function del_userposing(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/delete_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

</script>
<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand Pass Reprint</span>
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
        <li class="breadcrumb-item"><a href="#"><strong>Sand Pass Reprint Approve</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>

             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_login", "name" => "customer_login" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/customer_login_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/customer_login_add", $attributes);
		}?>
           
             <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                 <th id="col_name">Customer Name</th>
                    <th id="col_name">Aadhar Number</th>
					  <th id="col_name">Token Number</th>
					    <th id="col_name">Ton Needed</th>
                  <th>Approve</th>
				  
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=1; foreach($datareprintview as $rowmodule)
				 {
					 
					 
		$customer_regn_id	=	$rowmodule['transaction_customer_registration_id'];
		
		
		
		
		$datacustreg=$this->Master_model->get_cust_det($customer_regn_id);
		
		$customer_name=$datacustreg[0]['customer_name'];
		$customer_aadhar_number=$datacustreg[0]['customer_aadhar_number'];
		$customer_max_allotted_ton=$datacustreg[0]['customer_max_allotted_ton'];
		
					 $id = $rowmodule['sandpass_reprint_id'];
					 //$rowmodule['customer_name'];
					 //$rowmodule['customer_aadhar_number']
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($customer_name);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($customer_aadhar_number);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['token_no']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($customer_max_allotted_ton);?></div>
                        </td>
						
							
							<td>  <a href="<?php echo $site_url.'/Manual_dredging/Master/sand_issue_reprintApproval/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; Approve </button></a> </td>
						
						
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
     