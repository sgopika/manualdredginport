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
				url : "<?php echo site_url('Port/delzone/')?>",
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
				url : "<?php echo site_url('Master/add/')?>",
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
		<span class="badge bg-darkmagenta innertitle mt-2">Monthly Permit</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_dir_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Monthly Permit</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
  
           <?php if( $this->session->flashdata('msg')){ 
            echo $this->session->flashdata('msg');
            } ?>
            
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "allegation_form", "name" => "allegation_form" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Master/add_zone", $attributes);
		} else {
			echo form_open("Master/add_zone", $attributes);
		}?>
		
		
		<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
               <a href="<?php echo site_url("Manual_dredging/Port/mon_pt_ap_pd");?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-arrow-left"></i> &nbsp;&nbsp;Go Back </button>
              </a>
            </div>
            </div><?php
$i=1;
?>
<div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
		 <table id="example" class="table table-bordered table-striped">
<tr><th>SL.NO</th>
    <th>Localbody Name</th>
    <th>Zone Name</th>
    <th>Moth/Year</th>
    <th>Quantity (in ton)</th>
    <th>Permit Requested  Date</th>
    <th>Permit Approved Date</th>
    <th>Status</th>
</tr>
<?php
foreach($mp_det as $b_d)
{
?>
<tr>
	<td><?php echo $i; ?></td>
    <td><?php echo $b_d['lsgd_name_unicode'];?></td>
    <td><?php echo $b_d['zone_name'];?></td>
    <td><?php echo $b_d['monthly_permit_period_name'];?></td>
    <td><?php echo $b_d['monthly_permit_approved_ton'];?></td>
    <td><?php echo date("d/m/Y h:i:s", strtotime(str_replace('-', '/',$b_d['monthly_permit_request_timestamp'] )));?></td>
    <td><?php echo date("d/m/Y h:i:s", strtotime(str_replace('-', '/',$b_d['monthly_permit_approved_timestamp'] )));?></td>
    <?php 
							if ($b_d['monthly_permit_approved_user']==0) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp;&nbsp; Waiting For Approval &nbsp;&nbsp; </button> </td>
								<?php
							}
							else
							{
							?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp; Approved </button> </td>
							<?php
							} 
							?>
</tr>
<?php
$i++;
}
?>
</table>
</div>
           
</div>
          
</div>