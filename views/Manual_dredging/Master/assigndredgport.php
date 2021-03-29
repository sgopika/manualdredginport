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

function del_zone(zone_id)
{
	var a=confirm("are you sure?");
	if(a==true)
	{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Port/delport/')?>",
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

function edit_zone(id)
{
	$.ajax({
				url : "<?php echo site_url('Manual_dredging/Master/add/')?>",
				type: "POST",
				data:{ id:id},
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
  
  
  <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Dredge Port</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_dir_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Dredge Port</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
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
			echo form_open("Manual_dredging/Master/add_zone", $attributes);
		}?>
        <?php if($port_officer==0){ ?>
		
		<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
               <a href="<?php echo $site_url.'/Manual_dredging/Master/dredgeport_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Assign Dredging Port </button>
              </a>
            </div></div>
            <?php } ?>
            <!-- /.box-header -->
           <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
		 <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Port Name</th>
                  <th id="col_name">Port Code</th>
                  <th>Status</th>
                  <?php if($port_officer==0){ ?>
                  <th> Delete </th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; foreach($port as $rowmodule){
					 
					 $id = $rowmodule['int_portoffice_id'];
					 if($port_officer==1 && $po_port_arr){
						if(!in_array($id,$po_port_arr)){
							continue;
						} 
					 }
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['vchr_portoffice_name']);?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['vchr_portoffice_name'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['vchr_officecode']);?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['vchr_officecode'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
						<?php 
							if ($rowmodule['int_dredge_status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['int_dredge_status'];?>);"  > <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['int_dredge_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
						<?php if($port_officer==0){ ?>
						<td> <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="del_zone(<?php echo $rowmodule['int_portoffice_id']; ?>)"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button> </td>
                        <?php } ?>
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
               
              </table>
</div>
           
</div>
          
</div>