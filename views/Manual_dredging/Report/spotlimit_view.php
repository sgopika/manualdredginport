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

function del_const(zone_id)

{

	var a=confirm("are you sure?");

	if(a==true)

	{

	$.ajax({

				url : "<?php echo site_url('Port/delconstr/')?>",

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
		<span class="badge bg-darkmagenta innertitle mt-2">Add Ton Limit</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/spot"); ?>"> Spot</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Add Ton Limit</strong></a></li>
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

		?>

            <div class="row py-3" id="view_vesselcategory">
		<div class="col-12">

               <a href="<?php echo $site_url.'/Manual_dredging/Report/add_spot_limit';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add Ton Limit</button>

              </a>

                </div></div>
 <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th id="sl">Sl.No</th>
					<th id="col_name">Kadavu</th>
                  <th id="col_name">Date</th>

				  <th id="col_name">Ton Limit</th>

				  <th id="col_name">Balance Ton Limit</th>
                </tr>

                </thead>

                <tbody>

                <?php

				//print_r($data);

				$allegation=array();

				 $i=1; foreach($cnst as $rowmodule){

					 $id = $rowmodule['construction_master_id'];

					 $limitdate=date("d-m-Y",strtotime(str_replace('/', '-',$rowmodule['spot_limit_date'])));

					 $limitqty=$rowmodule['spot_limit_quantity'];

					 $limitbalqty=$rowmodule['spot_limit_balance'];
					 $zonename=$rowmodule['zone_name'];;

					?>

					<tr id="<?php echo $i;?>">

						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">

                        <div id="first_<?php echo $i;?>"><?php echo $zonename;?></div>

						 

                        

                        </td>

						<td id="col_div_<?php echo $i; ?>">

                        <div id="first_<?php echo $i;?>"><?php echo $limitdate;?></div>

	
                        </td>

       								<td><div id="first_<?php echo $i;?>"><?php echo $limitqty;?></div>

						   </td>

								<td><div id="first_<?php echo $i;?>"><?php echo $limitbalqty;?></div>  </td>

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

<!-- /.content -->