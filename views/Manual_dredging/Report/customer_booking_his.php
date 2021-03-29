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
function del_bank(zone_id)
{
	var a=confirm("are you sure?");
	var tbl_name='bank';
	var uni_f='bank_id';
	var u_f='bank_status';
	if(a==true)
	{
	$.ajax({
				url : "<?php echo site_url('Master/deldata/')?>",
				type: "POST",
				data:{id:zone_id,tbl_name:tbl_name,uni_f:uni_f,u_f:u_f},
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
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" >Sand Booking History</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
        <li><a href="#"><strong>Sand Booking History</strong></a></li>
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
			echo form_open("Master/add_materialrate", $attributes);
		}?>
            <div class="box-header" id="view_allegation">
               <a href="#"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Sand Booking History</button>
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <table class="table table-bordered table-striped">
            <tr><td>Allotted Quantity</td><td><?php echo $cus_bal[0]['customer_max_allotted_ton'];?></td></tr>
            <tr><td>Used Quantity</td><td><?php echo $cus_bal[0]['customer_used_ton'];?></td></tr>
            <tr><td>Balance Quantity</td><td><?php echo $cus_bal[0]['customer_unused_ton'];?></td></tr>
            </table>
            <p>&nbsp;</p>
              <table id="vacbtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th>Port Name</th>
                  <th id="col_name">Zone Name</th>
                  <th>Sand Quantity</th>
                  <th>Priority No</th>
                  <th>Token No</th>
                  <th>Status</th>
                  <th>Alotted Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; 
				 foreach($cust_book_his as $rowmodule){
					 $sat=0;
					 $id = $rowmodule['customer_booking_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['vchr_portoffice_name']);?></div>
                         
                        </div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['zone_name']);?></div>
                         
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_booking_request_ton']);?></div>
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_booking_priority_number']);?></div>
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_booking_token_number']);?></div>
                        </div>
                        </td>
						<?php 
							if ($rowmodule['customer_booking_decission_status']==0) 
							{
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_decission_status'];?>);"  > <i class="fa fa-fw  fa-minus"></i> &nbsp;&nbsp; Waiting For Approval &nbsp;&nbsp; </button> </td>
								<?php
							}
							else if($rowmodule['customer_booking_decission_status']==2)
							{
								$curd=date('Y-m-d');
								if(($rowmodule['customer_booking_allotted_date']<$curd)&&($rowmodule['customer_booking_pass_issue_user']==''))
								{
									$sat=1;
									?>
                                    <td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_decission_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Sand Not Taken </button> </td>
                                    <?php
								}
								else if($rowmodule['customer_booking_pass_issue_user']!=0)
								{
									$sat=1;
									?>
								<td> <button title="Sand Issue Details" data-toggle="popover" data-html="true" data-container="body"  data-trigger="focus" data-content="<table class=table table-bordered table-striped><tr><th>Driver Name</th><td><?php echo $rowmodule['customer_booking_driver_name'];  ?></td></tr><tr><th>Vehicle Reg No&nbsp;</th><td><?php echo $rowmodule['customer_booking_vehicle_registration_number'];  ?></td></tr><tr><th>Time</th><td><?php echo strtoupper(date("h:i:s A",strtotime(str_replace('-', '/',$rowmodule['customer_booking_pass_issue_timestamp']))));  ?></td></tr></table>" class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp; Sand Issued </button> </td>
								<?php
								}
								else
								{
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_decission_status'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp; Approved </button> </td>
								<?php
								}
							} 
							else if($rowmodule['customer_booking_decission_status']==4)
							{
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Canceled Due to nonpayment </button> </td>
							<?php
                            }
							else if($rowmodule['customer_booking_decission_status']==5)
							{
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Canceled By User </button> </td>
								<?php
                            }
							
                            else
                            {
								?>
                                <td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Rejected By Port Conservator </button> </td>
                                <?php
                            }?>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php if($rowmodule['customer_booking_allotted_date']=="0000-00-00"){ echo "----------";}else{ echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$rowmodule['customer_booking_allotted_date']))));} ?></div>
                        </div>
                        </td>
					</tr>
                    
                   
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
               
              </table>
               <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
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