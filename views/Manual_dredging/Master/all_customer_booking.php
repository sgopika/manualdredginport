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
  <script>
$(document).ready(function()
{
	$('#btns').click(function()
				{
					//alert("hello");
					var zone_id=$('#zone_id').val();
					var mont =$('#mont').val();
					var yer  =$('#yer').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Port/sand_booking_history_ajax/",{zone_id:zone_id,yer:yer,mont:mont},function(data)
						{
							//$('#sandBookHis').css("display","none");
							$('#sandBookHis').html(data);
						});
				});
});
</script>
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->	
	<div class="container-fluid ui-innerpage">
     <div class="row py-3">
       

    <div class="col-12 d-flex justify-content-end">
     
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
        
		 <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/lsgd"); ?>"> Sand Booking History</a></li>
        
      </ol>
    </div>
    <!-- Main content -->
    <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
        <div class="col-md-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      </div> <!-- end of co12 -->
		</div> <!-- end of row -->  
	
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "allegation_form", "name" => "allegation_form" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/add_zone", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/add_materialrate", $attributes);
		}?>
                
            <div class="row p-3">
          <div class="col-md-12 d-flex justify-content-left px-2">     
                
            
               <a href="#"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Sand Booking History</button>
              </a>
            </div>
            </div>
                
                
            <!-- /.box-header -->
           
             <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">Select Month
         </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                    <select id="mont" name="mont" class="form-control">
                <option selected="selected" value="">select</option>
               <option  value='1'>Janaury</option>
    <option value='2'>February</option>
    <option value='3'>March</option>
    <option value='4'>April</option>
    <option value='5'>May</option>
    <option value='6'>June</option>
    <option value='7'>July</option>
    <option value='8'>August</option>
    <option value='9'>September</option>
    <option value='10'>October</option>
    <option value='11'>November</option>
    <option value='12'>December</option>
                
                </select>
                    </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
                    Select Year
               </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                    <select id="yer" name="yer" class="form-control">
                <option selected="selected" value="">select</option>
               <option value='2016'>2016</option>
    <option value='2017'>2017</option>
    <option value='2018'>2018</option>
    <option value='2019'>2019</option>
    <option value='2020'>2020</option>
    <option value='2021'>2021</option>
    <option value='2022'>2022</option>
    <option value='2023'>2023</option>
    <option value='2024'>2024</option>
    <option value='2025'>2025</option>
    <option value='2026'>2026</option>
    <option value='2027'>2027</option>
    
                </select>
                     </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
                    Select Zone
                </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                <select class="form-control" id="zone_id" name="zone_id">
                <option selected="selected" value="">select</option>
				<?php
			   foreach($zone as $row)
				{
				?>
                <option value="<?php echo $row['zone_id']; ?>"><?php echo $row['zone_name']; ?></option> 
				<?php 
				}
				?>
                </select>
                 </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2">
                       <button type="button" class="btn btn-success" id="btns">Show</button>
           </div>
           </div>
               <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2" id="sandBookHis">
              </div>
            </div>
        </div>