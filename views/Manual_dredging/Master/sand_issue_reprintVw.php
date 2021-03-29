
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
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_zone_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Sand Pass Reprint</strong></a></li>
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
     
     
       <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
            
              <a href="<?php echo $site_url.'/Manual_dredging/Master/sand_issue_reprint';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Sand Issue Reprint Request</button>
              </a>
              
          </div></div>
      <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                 <th id="col_name">Customer Name</th>
                    <th id="col_name">Aadhar Number</th>
					  <th id="col_name">Permit Number</th>
					    <th id="col_name">Ton Needed</th>
                  <th>Status</th>
				  
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=1; 
				  if(($datareprintview) != null){
				 foreach($datareprintview as $rowmodule){
					 $id = $rowmodule['sandpass_reprint_id'];
					 $customer_regn_id	=	$rowmodule['customer_registration_id'];
		
		$datacustreg=$this->Master_model->get_cust_det($customer_regn_id);
		
		$customer_name=$datacustreg[0]['customer_name'];
		$customer_aadhar_number=$datacustreg[0]['customer_aadhar_number'];
		$customer_max_allotted_ton=$datacustreg[0]['customer_max_allotted_ton'];
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
						
							
							<td> <?php if($rowmodule['approved_user_id']==0)
							{ 
							echo "Not Approved";
							}
							else
							{ 
								if($rowmodule['reprint_status']==1)
							   		{?>
									<a href="<?php echo $site_url.'/Manual_dredging/Master/sand_issue_reprintVw/'.encode_url($id);?>">
									<button class="btn btn-sm bg-blue btn-flat" type="button" >  &nbsp; Reprint </button></a>
							 <?php   } else 
							 {
							 echo "Pass Issued";
							 }
							  } ?></td>
						
						
					</tr>
					<?php
					$i++; 
				} }
                echo form_close(); ?>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     