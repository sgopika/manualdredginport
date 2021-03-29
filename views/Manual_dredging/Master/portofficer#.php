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

function del_pc(zone_id)
{
	var a=confirm("are you sure?");
	//alert(uni_f);
	if(a==true)
	{
	$.ajax({
				url : "<?php echo site_url('Port/delpc/')?>",
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
    <section class="content-header">
      <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" >Port Officer</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
        <li><a href="#"><strong>Port Officer</strong></a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-9">
          <!-- /.box -->
          <div class="box" >
           <?php if( $this->session->flashdata('msg')){ 
            echo $this->session->flashdata('msg');
            } ?>
            <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "allegation_form", "name" => "allegation_form" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Master/add_zone", $attributes);
		} else {
			echo form_open("Master/add_zone", $attributes);
		}?>
            <div class="box-header" id="view_allegation">
               <a href="<?php echo $site_url.'/Port/po_user_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Create Port Officer </button>
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="vacbtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">PC UserName</th>
                  <th id="col_name">Port Name</th>
                  <th>Status</th>
                  <th> Delete </th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; foreach($portc as $rowmodule){
					 $id = $rowmodule['user_master_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['user_master_name']);?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['user_master_name'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['vchr_portoffice_name']);?></div>
                         <div id="hide_<?php echo $i;?>" style="display:none"><input type="text" name="edit_allegation_<?php echo $i;?>"  id="edit_allegation_<?php echo $i;?>" value="<?php echo $rowmodule['user_master_port_id'];?>" onchange="check_dup_allegation_edit(<?php echo $i;?>);"   maxlength="100" autocomplete="off"/>
                        </div>
                        </td>
						<?php 
							if ($rowmodule['user_master_status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['user_master_status'];?>);"  > <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['user_master_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
						
						<td> <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="del_pc(<?php echo $rowmodule['user_master_id']; ?>)"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button> </td>
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
  </section>
<!-- /.content -->