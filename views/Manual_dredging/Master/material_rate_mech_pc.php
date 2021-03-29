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
function del_matrate(zone_id)
{
	var a=confirm("are you sure?");
	if(a==true)
	{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Port/delmatrate_mech/')?>",
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
				url : "<?php echo site_url('Master/check_allegation/')?>",
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
				url : "<?php echo site_url('Master/status_allegation/')?>",
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
				url : "<?php echo site_url('Master/delete_allegation/')?>",
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
					url : "<?php echo site_url('Master/edit_allegation/')?>",
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
					url : "<?php echo site_url('Master/add_allegation/')?>",
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
		<span class="badge bg-darkmagenta innertitle mt-2">Material Rate </span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Material Rate</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
  
  <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
  
   <?php if( $this->session->flashdata('msg')){ 
            echo $this->session->flashdata('msg');
            } ?>
            <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "allegation_form", "name" => "allegation_form" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/add_zone", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/add_materialrate", $attributes);
		}?>
  
  <div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
          		
			  <a href="<?php echo $site_url.'/Manual_dredging/Port/add_mech_matrate_pc';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add Material Rate</button>
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
                  <th id="col_name">Material Name</th>
                  <th id="col_name">Amount</th>
                  <th id="col_name">Zone ID</th>
                  <th>Status</th>
                  <th>Edit</th>
                  <th> Delete </th>
                </tr>
                </thead>
                <tbody>
                 <?php
				//print_r($data);
				$allegation=array();
				 $i=1; foreach($material_rate as $rowmodule){
					 $id = $rowmodule['mdrate_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php foreach($material as $mat){if($mat['material_master_id']==$rowmodule['material_id']) { $matname= $mat['material_master_name'];}} echo strtoupper($matname);?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['mdrate_status'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['mat_amount']);?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['mat_amount'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php $zi=$rowmodule['materialrate_zone']; $z_a=explode(',',$zi);foreach($zone as $z){ if(in_array($z['zone_id'],$z_a)){ echo strtoupper($z['zone_name'])." ";} }?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['materialrate_zone'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
						<?php 
							if ($rowmodule['mdrate_status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['mdrate_status'];?>);"  > <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['mdrate_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
					 	<td id="td_div_<?php echo $i;?>"> 
                        <?php if($rowmodule['mat_domain']==1){}else { ?>
                        <div id="edit_div_<?php echo $i;?>">
                       <a href="<?php echo $site_url.'/Manual_dredging/Port/edit_mechmaterialrate_pc/'.encode_url($id);?>"> <button <?php if ($rowmodule['mdrate_status']==2) { ?> disabled="disabled" <?php }?> name="edit_allegation_btn_<?php echo $i;?>" id="edit_allegation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button"  ><i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button> 	</a>					
                        </div>
                        <?php } ?>
                        </td>
						<td>
						<?php if($rowmodule['mat_domain']==1){ } else{?>
						<?php if($rowmodule['materialrate_port_end_date']!='0000-00-00'){ ?> <button <?php if ($rowmodule['mdrate_status']==2) { ?> disabled="disabled" <?php }?> class="btn btn-sm btn-danger btn-flat" type="button" onclick="del_matrate(<?php echo $rowmodule['materialrate_port_id']; ?>)"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button><?php  } else { echo "Update End Date to Delete data"; }?>
                        <?php
						}
						?>
                        </td>
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
   
   