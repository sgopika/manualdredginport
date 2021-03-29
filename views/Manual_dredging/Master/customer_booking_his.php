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
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand Booking History</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/customer_home"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Sand Booking History</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>


             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>


          

			

      <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
            
               <a href="#"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Sand Booking History</button>

              </a>
              
          </div></div>
      <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">
           

            <tr><td>Allotted Quantity</td><td><?php echo $cus_bal[0]['customer_allotted_ton'];?></td></tr>

            <tr><td>Used Quantity</td><td><?php echo $cus_bal[0]['customer_used_ton'];?></td></tr>

            <tr><td>Balance Quantity</td><td><?php echo $cus_bal[0]['customer_unused_ton'];?></td></tr>

            </table>

            <p>&nbsp;</p>

              <table id="example" class="table table-bordered table-striped" width="100%">

                <thead>

                <tr>

                  <th id="sl">Sl.No</th>
                  <th>Port & Zone</th>
                  <th>Sand Quantity</th>
                  <th>Priority No</th>
                  <th>Token No</th>
                  <th>Cancel Booking</th>
                  <th>Status</th>
                  <th>Alotted Date</th>
                  <th>Download</th>
                  <th>Pay Online</th>
                
                </tr>
                </thead>
                <tbody>
                <?php
		
				$allegation=array();

				 $i=1; 
				 	 // if(($datareprintview) != null){
				 foreach($cust_book_his as $rowmodule){

					 $sat=0;

					 $id = $rowmodule['customer_booking_id'];
					 $customer_booking_port_id=$rowmodule['customer_booking_port_id'];
					?>

					<tr id="<?php echo $i;?>">

						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['vchr_portoffice_name']).'<br> '.$rowmodule['zone_name'];?>
                        </div> </td>
			            <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo $rowmodule['customer_booking_request_ton'];?></div>
						</td>

                        <td id="col_div_<?php echo $i; ?>">

                        <div id="first_<?php echo $i;?>"><?php echo $rowmodule['customer_booking_priority_number'];?></div>
                        </td>

                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo $rowmodule['customer_booking_token_number'];?></div>

                        </td>

                        <td id="col_div_<?php echo $i; ?>"><?php if(($rowmodule['customer_booking_decission_status']==0)&&$rowmodule['payment_status']==0) { ?> <a href="<?php echo $site_url.'/Manual_dredging/Report/cancelbooking/'.encode_url($id); ?>">Cancel Booking</a> <?php } else { echo "N/A";}?>

                        </td>
                        <td id="col_div_<?php echo $i; ?>">

						<?php 

							if ($rowmodule['customer_booking_decission_status']==0) 

							{

								?>

								 <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_decission_status'];?>);"  > <i class="fa fa-fw  fa-minus"></i> &nbsp;&nbsp; Waiting For Approval &nbsp;&nbsp; </button> 

								<?php

							}

							else if($rowmodule['customer_booking_decission_status']==2)

							{

								$curd=date('Y-m-d');

								if(($rowmodule['customer_booking_allotted_date']<$curd)&&($rowmodule['customer_booking_pass_issue_user']==''))

								{

									$sat=1;

									?>

                                  <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_decission_status'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Sand Not Taken </button>

                                    <?php

								}

								else if($rowmodule['customer_booking_pass_issue_user']!=0)

								{

									$sat=1;

									?>

								 <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_decission_status'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp; Sand Issued </button> 

								<?php

								}

								else

								{

								?>

								<button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_decission_status'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp; Approved </button>

								<?php

								}

							} 

							else if($rowmodule['customer_booking_decission_status']==4)

							{

								$sat=1;

								?>

								 <span class="badge bg-purple">Canceled Due to nonpayment </span> 

							<?php

                            }

							else if($rowmodule['customer_booking_decission_status']==5)

							{

								$sat=1;

								?>
                              
							 <span class="badge bg-purple" >  Canceled By User </span> 

								<?php

                            }

							

                            else

                            {

								?>

                                <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Rejected By Port Conservator </button> 

                                <?php

                            }?>
						</td>
                        <td id="col_div_<?php echo $i; ?>">

                        <div id="first_<?php echo $i;?>"><?php if($rowmodule['customer_booking_allotted_date']=="0000-00-00"){ echo "----------";}else{ echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$rowmodule['customer_booking_allotted_date']))));} ?></div>

                       

                        </td>

						<td id="td_div_<?php echo $i;?>"> 

                        <div id="edit_div_<?php echo $i;?>">

						<?php if($rowmodule['payment_status']==1){ $sat=1;}?>

                        <a target="_new" href="<?php if($sat==1){}else{ echo $site_url.'/Manual_dredging/Master/getChellanDetails/'.encode_url($id);}?>"> 

                        <button name="edit_allegation_btn_<?php echo $i;?>" id="edit_allegation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" <?php if($sat==1){ ?> disabled="disabled" <?php }?> >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Chellan  </button> 

                        </a>					

                        </div>

                        </td>
 
						<td id="td_div_<?php echo $i;?>"> 
                       <?php 
					// if($customer_booking_port_id==10)
				//	echo "zczxczcxzxc".$sess_usr_id;
				/*	if($sess_usr_id==62369 || $sess_usr_id==62371 || $sess_usr_id==62368 || $sess_usr_id==62370|| $sess_usr_id==62372|| $sess_usr_id==62373|| $sess_usr_id==62374 || $sess_usr_id==61550 || $sess_usr_id==1857) 
{ */
							?>
                        <div id="edit_div_<?php echo $i;?>">
                        <a  href="<?php  if($sat==1 ){}else{ echo $site_url.'/Manual_dredging/Master/Onlinepayment/'.encode_url($id);
							} ?>"> 
                        
                        <button name="edit_allegation_btn_<?php echo $i;?>" id="edit_allegation_btn_<?php echo $i;?>" class="btn btn-sm bg-darkmagenta btn-flat" type="button" <?php if($sat==1){ ?> disabled="disabled" <?php }?>  >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; <?php if($sat==1){ ?> Paid <?php } else { ?>Pay Now <?php } ?> </button> 
                        </a>					
                        </div>
                        
                        <?php //} ?>
                        </td>

					</tr>

					<?php

					$i++; 

				} //}

                echo form_close(); ?>

                </tbody>

               

              </table>

           </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->