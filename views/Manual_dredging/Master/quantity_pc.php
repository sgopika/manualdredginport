<!-- Page specific script starts here -->
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
<script type="text/javascript" language="javascript">

function del_qty(zone_id)
{
	var a=confirm("are you sure?");
	if(a==true)
	{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Port/delqtypc/')?>",
				type: "POST",
				data:{id:zone_id},
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
function add_allegation(){
    $("#view_allegation").hide();
	$("#add_allegation").show();
}

function check_dup_allegation()
{
	var allegation= $("#allegation").val();
	$.ajax({
				url : "<?php echo site_url('Master/check_allegation/')?>",
				type: "POST",
				data:{ allegation:allegation},
				dataType: "JSON",
				success: function(data)
				{
					if(data['count']==4)
					{
					  $("#msgDiv").show();
						document.getElementById('msgDiv').innerHTML="<font color='red'>Allegation Already exists!!!</font>";
						$("#allegation").val('');
					}
					else if(data['count']==3)
					{
					  $("#msgDiv").show();
						document.getElementById('msgDiv').innerHTML="<font color='red'>Allegation Insertion failed!!!</font>";
						$("#allegation").val('');
					}
					else if(data['count']==1)
					{
					  window.location.reload(true);
					}
					else if(data['count']==2)
					{
					  window.location.reload(true);
					}
				}
			});
}

function check_dup_allegation_edit(i)
{
	var allegation= $("#edit_allegation_"+i).val();
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Master/check_allegation/')?>",
				type: "POST",
				data:{ allegation:allegation},
				dataType: "JSON",
				success: function(data)
				{
					if(data['count']==4)
					{
					  $("#msgDiv").show();
						document.getElementById('msgDiv').innerHTML="<font color='red'>Allegation Already exists</font>";
					}
				}
			});
}

function toggle_status(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Master/status_allegation/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

function del_allegation(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Master/delete_allegation/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{//alert(data['result']);
					if(data['result']==1)
					{
						window.location.reload(true);
					}
				}
			});
}

function edit_allegation(id,i)
{
	$("#first_"+i).hide();
	$("#hide_"+i).show();
	$("#edit_allegation_btn_"+i).hide();
	$("#save_allegation_"+i).show();
	$("#cancel_allegation_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
	
	$("#col_name").css('width',(400),'+px');
	$("#th_div").css('width',(200),'+px');
	$("#col_div_"+i).css('width',(400),'+px');
	$("#edit_allegation_"+i).css('width',(400),'+px');
	$("#td_div_"+i).css('width',(200),'+px');
}

function save_allegation(id,i)
{
	var edit_allegation= $("#edit_allegation_"+i).val();
	var re = /^[ A-Za-z0-9]*$/;
	if(edit_allegation==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='red'>Please Enter Allegation</font>";
	}
	else if(!isNaN(edit_allegation)) {
				$("#msgDiv").show();
				document.getElementById('msgDiv').innerHTML="<font color='red'>Please Enter Valid Enquiry</font>";
				return false;
	}
	else if(!re.test( edit_allegation ) ) {
		$("#msgDiv").show();	
        document.getElementById('msgDiv').innerHTML="<font color='red'>Special Characters not Allowed</font>";
        return false;
     }
	else{
		$.ajax({
					url : "<?php echo site_url('Manual_dredging/Master/edit_allegation/')?>",
					type: "POST",
					data:{ id:id,edit_allegation:edit_allegation},
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='red'>"+data['val_errors']+"</font>";
						}else{
							window.location.reload(true);
						}
					}
				});
		}
}

function cancel_allegation(id,i)
{
	$("#first_"+i).show();
	$("#hide_"+i).hide();
	$("#edit_allegation_btn_"+i).show();
	$("#save_allegation_"+i).hide();
	$("#cancel_allegation_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
}

function delete_allegation()
{
	$("#add_allegation").hide();
	$("#view_allegation").show();
}

function ins_allegation()
{
		var allegation= $("#allegation").val(); 
			var allegation_ins= $("#allegation_ins").val(); 
			var re = /^[ A-Za-z0-9]*$/;
			if(allegation==""){
				$("#msgDiv").show();
				document.getElementById('msgDiv').innerHTML="<font color='red'>Please Enter Allegation</font>";
			}
			else if(!isNaN(allegation)) {
				$("#msgDiv").show();
				document.getElementById('msgDiv').innerHTML="<font color='red'>Please Enter Valid Allegation</font>";
				return false;
			}
			else if(!re.test( allegation ) ) {
				$("#msgDiv").show();	
				document.getElementById('msgDiv').innerHTML="<font color='red'>Special Characters not Allowed</font>";
				return false;
			}
			else{
				$.ajax({
					url : "<?php echo site_url('Manual_dredging/Master/add_allegation/')?>",
					type: "POST",
					data:{ allegation:allegation,allegation_ins:allegation_ins},
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='red'>"+data['val_errors']+"</font>";
							$("#allegation").val('');
						}else{
							window.location.reload(true);
						}
					}
				});
			}
}

  </script>
  <!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Quantity</span>
	</div>  <!-- end of col4 -->
  <div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Quantity</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
   <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
<?php 
        $attributes = array("class" => "form-horizontal", "id" => "allegation_form", "name" => "allegation_form" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/add_materialrate", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/add_materialrate", $attributes);
		}?>
		
		<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
            <?php 
			$int_flag=0;
			foreach($quantity as $q)
			{
				if($q['quantity_status']==1)
				{
					$int_flag=1;
				}
			}
			if($int_flag==1)
			{?>
               <a href="#"> <button class="btn btn-primary btn-flat" type="button" disabled="disabled" title="Delete old Quantity to add New One" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add Quantity</button>
              </a>
              <?php
			}
			else
			{
				?>
                <a href="<?php echo $site_url.'/Manual_dredging/Master/quantity_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add Quantity</button>
              </a>
                <?php
			}
			?>
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    
   <!-- //------------------------------------------------------------------------------------------------------------------------->
     <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
		<table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Quantity</th>
                 
                  <th>Status</th>
                  <th id="th_div"> Edit</th>
                  <th> Delete </th>
                </tr>
                </thead>
                <tbody>
               <?php
				//print_r($data);
				$allegation=array();
				 $i=1; foreach($quantity as $rowmodule){
					 $id = $rowmodule['quantity_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        
                        <div id="first_<?php echo $i;?>"><?php
						$qrs=""; 
						foreach($quantitym as $qs){
							$qq=explode(',',$rowmodule['quantity_master_id']);
							if(in_array($qs['quantity_master_id'], $qq))
							{ 
								$qrs=$qrs.$qs['quantity_master_name'].",";
							}
						}
						echo "<b>".rtrim($qrs,',')."<b>"; 
						?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['quantity_master_id'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
						<?php 
							if ($rowmodule['quantity_status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['quantity_status'];?>);"  > <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['quantity_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
						<td id="td_div_<?php echo $i;?>"> 
                        <div id="edit_div_<?php echo $i;?>">
                        <a href="<?php echo $site_url.'/Manual_dredging/Master/quantity_pc_edit/'.encode_url($id);?>"><button name="edit_allegation_btn_<?php echo $i;?>" id="edit_allegation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button">   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button></a> 						
                        </div>
                        </td>
						<td><?php if($rowmodule['quantity_end_date']!='0000-00-00'){ ?> <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="del_qty(<?php echo $rowmodule['quantity_id'];?>)"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button><?php } else { echo "Update End Date to Delete data"; }?> </td>
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
 <!-- //--------------------------------------------------------------------------------------------------------------------------------------------->
    