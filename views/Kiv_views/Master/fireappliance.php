 
<script type="text/javascript" language="javascript">
$(document).ready(function() {
				
		 jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			});    	
			
		 jQuery.validator.addMethod("nospecialmin", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]+$/.test(value);
			}); 
		 jQuery.validator.addMethod("alphaonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]{1,}[a-zA-Z\s.-]+$/.test(value);
			});    	
			
	 $('#fireappliance').validate({
			rules:
			         { 
				  fireappliance_name:{required:true,
				  alphaonly:true,
				  maxlength:50, },

				  fireappliance_code:{required:true,
				  nospecialmin:true,
				  maxlength:4, },
                     },
			messages:
			         {
						 fireappliance_name:{required:"<font color='red'>Please enter Fire Appliance Name</span>",
						 alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed</font>",
						 maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
						 
						 fireappliance_code:{required:"<font color='red'>Please enter Fire Appliance Code</span>",
						 nospecialmin:"<font color='red'>Only Alphabets Allowed</font>",
						 maxlength:"<font color='red'>Maximum 4 Character allowed</font>"},
 
			         },
			errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
		});	
});

function add_fireappliance()
{
    	$("#view_fireappliance").hide();
	$("#add_fireappliance").show();
}
	
function delete_fireappliance()
{
	$("#add_fireappliance").hide();
	$("#view_fireappliance").show();
	$("#msgDiv").hide();
}
function ins_fireappliance()
{
		var fireappliance_ins		= $("#fireappliance_ins").val(); 
		var fireappliance_name		= $("#fireappliance_name").val(); 
		var fireappliance_mal_name	= $("#fireappliance_mal_name").val(); 
		var fireappliance_code		= $("#fireappliance_code").val();
		var csrf_token          	= '<?php echo $this->security->get_csrf_hash(); ?>';
			
	if(fireappliance_name=="")
        {
            alert("Fire Appliance Name Required");
            $("#fireappliance_name").focus();
            return false;
            
        }
        
        if(fireappliance_code=="")
        {
            alert("Fire Appliance Code Required");
            $("#fireappliance_code").focus();
            return false;
        }
        
				$.ajax({
					url : "<?php echo site_url('Master/add_fireappliance/')?>",
					type: "POST",
					data:{fireappliance_ins:fireappliance_ins, fireappliance_name:fireappliance_name,fireappliance_mal_name:fireappliance_mal_name,fireappliance_code:fireappliance_code,'csrf_test_name': csrf_token },
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#fireappliance_name").val('');
							$("#fireappliance_mal_name").val('');
							$("#fireappliance_code").val('');
						}
						else{
							window.location.reload(true);
						}
					}
				});
		
}
function toggle_status(id,status)
{
	
	var csrf_token          		= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Master/status_fireappliance/')?>",
				type: "POST",
				data:{ id:id,stat:status,'csrf_test_name': csrf_token },
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
	function del_fireappliance(id,status)
{
	var csrf_token          		= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Master/delete_fireappliance/')?>",
				type: "POST",
				data:{ id:id,stat:status,'csrf_test_name': csrf_token },
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


function edit_fireappliance(id,i)
{
	$("#view_fireappliance").hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_fireappliance_btn_"+i).hide();
	$("#save_fireappliance_"+i).show();
	$("#cancel_fireappliance_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_fireappliance(id,i)
{
	$("#view_fireappliance").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_fireappliance_btn_"+i).show();
	$("#save_fireappliance_"+i).hide();
	$("#cancel_fireappliance_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
	$("#valid_err_msg_name_"+i).hide();
	$("#valid_err_msg_code_"+i).hide();
}
	
function save_fireappliance(id,i)
{
	var edit_fireappliance= $("#edit_fireappliance_"+i).val();
	var edit_fireappliance_code= $("#edit_fireappliance_code_"+i).val();
	var edit_fireappliance_mal= $("#edit_fireappliance_mal_"+i).val();
	var csrf_token	= '<?php echo $this->security->get_csrf_hash(); ?>';
	var re = /^[ A-Za-z0-9]*$/;

	if(edit_fireappliance=="")
        {
            alert("Fire Appliance Name Required");
            $("#edit_fireappliance_"+i).focus();
            return false;
            
        }
        
        if(edit_fireappliance_code=="")
        {
            alert("Fire Appliance Code Required");
            $("#edit_fireappliance_code_"+i).focus();
            return false;
        }

	var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
	var regcd = new RegExp("^[a-zA-Z]+$");
  	if (regex.exec(edit_fireappliance) == null) 
	{
    		alert("Only alphabets and characters like .-_ are allowed in Fire Appliance name.");
		document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Fire Appliance name.</font>";
    		document.getElementById("edit_fireappliance").value = null;
    		return false;
  	} 
    	if (regcd.exec(edit_fireappliance_code) == null) 
	{
    		alert("Only Alphabets Allowed in Fire Appliance code.");
		document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Fire Appliance code.</font>";
    		document.getElementById("edit_fireappliance_code").value = null;
    		return false;
  	} 

	if(edit_fireappliance=="" ||  edit_fireappliance_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Fire Appliance Name And Fire Appliance Code</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Master/edit_fireappliance/')?>",
					type: "POST",
					data:{ id:id,edit_fireappliance:edit_fireappliance,edit_fireappliance_mal:edit_fireappliance_mal,edit_fireappliance_code:edit_fireappliance_code,'csrf_test_name': csrf_token },
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
						}else{
							window.location.reload(true);
						}
					}
				});
		}
}


	
	
	
</script>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
<button type="button" class="btn bg-primary btn-flat margin">Fire Appliance</button>
      </h1>
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
       <!-- <li><a href="#"></i>  <span class="badge bg-blue"> Page1 </span> </a></li>
        <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li>-->
      </ol></ol>
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
      <div class="col-md-12">
         
         
         <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
         
         <?php 
        $attributes = array("class" => "form-horizontal", "id" => "fireappliance", "name" => "fireappliance" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Master/add_fireappliance", $attributes);
		} else {
			echo form_open("Master/add_fireappliance", $attributes);
		}?>
         
         
          <div class="box">
            <div class="box-header">
            
            <div class="box-header" id="view_fireappliance">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_fireappliance()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Fire Appliance</button>
            </div>
             
             
             <div class="box-header col-md-12" id="add_fireappliance" style="display:none;">
            <div class="col-md-3">
             <input type="text" name="fireappliance_name" maxlength="50" id="fireappliance_name" class="form-control col-md-3"  placeholder=" Enter Fire Appliance Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="fireappliance_mal_name" maxlength="50" id="fireappliance_mal_name" class="form-control"   placeholder=" Enter Fire Appliance Malayalam Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="fireappliance_code" id="fireappliance_code" maxlength="4" class="form-control"  placeholder=" Enter Fire Appliance Code" autocomplete="off"/><br /> 
             </div>
             
             
             <div class="col-md-6">
             <input type="button" name="fireappliance_ins" id="fireappliance_ins" value="Save Fire Appliance" class="btn btn-info btn-flat" onClick="ins_fireappliance()"  />
             &nbsp;&nbsp;
             <input type="button" name="fireappliance_del" id="fireappliance_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_fireappliance()"  />
            </div>
            </div>
            
            
            
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Fire Appliance Name</th>
                  <th id="col_name1">Fire Appliance Name(Malayalam)</th>
                  <th id="col_name2">Code</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                 <?php
				//print_r($data);
				$i=1;
				foreach($fireappliance as $rowmodule){
				$id = $rowmodule['fireappliance_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['fireappliance_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="50" class="div300" type="text" name="edit_fireappliance_<?php echo $i;?>"  id="edit_fireappliance_<?php  echo $i;?>" value="<?php echo $rowmodule['fireappliance_name'];?>" onchange="check_dup_fireappliance_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['fireappliance_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_fireappliance_mal_<?php echo $i;?>"  id="edit_fireappliance_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['fireappliance_mal_name'];?>" onchange="check_dup_fireappliance_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['fireappliance_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_fireappliance_code<?php echo $i;?>"  id="edit_fireappliance_code_<?php  echo $i;?>" value="<?php echo $rowmodule['fireappliance_code'];?>" onchange="check_dup_fireappliance_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['fireappliance_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['fireappliance_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
					<?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['fireappliance_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_fireappliance_btn_<?php echo $i;?>" id="edit_fireappliance_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_fireappliance(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit </button> 						
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_fireappliance_<?php echo $i;?>" id="save_fireappliance_<?php echo $i;?>" onclick="save_fireappliance(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_fireappliance_<?php echo $i;?>" id="cancel_fireappliance_<?php echo $i;?>" onclick="cancel_fireappliance(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Fire Appliance?')){ del_fireappliance(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Fire Appliance?')){ del_fireappliance(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
						<?php
					}
					?>
                  </td>
                 
                </tr>
                <?php
					$i++;
				}
					?>
              
                </tbody>
                <tfoot>
                <tr>
                  <th>Sl.No</th>
                  <th>Fire Appliance Name</th>
                  <th>Fire Appliance Name(Malayalam)</th>
                  <th>Code</th>
                  <th>Status</th>
                  <th></th>
                  <th></th>
                  
                </tr>
                </tfoot>
                <?php
                 echo form_close(); ?>
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
  </div>
  <!-- /.content-wrapper -->
  
