 
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
			
	 $('#portable_fire_extinguisher').validate({
			rules:
			         { 
				  portable_fire_extinguisher_name:{required:true,
				  alphaonly:true,
				  maxlength:20, },

				  portable_fire_extinguisher_code:{required:true,
				  nospecialmin:true,
				  maxlength:4, },
                     },
			messages:
			         {
						 portable_fire_extinguisher_name:{required:"<font color='red'>Please enter Portable Fire Extinguisher Name</span>",
						 alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
						 maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
						 
						 portable_fire_extinguisher_code:{required:"<font color='red'>Please enter Portable Fire Extinguisher Code</span>",
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

function add_portable_fire_extinguisher()
{
    	$("#view_portable_fire_extinguisher").hide();
	$("#add_portable_fire_extinguisher").show();
}
	
function delete_portable_fire_extinguisher()
{
	$("#add_portable_fire_extinguisher").hide();
	$("#view_portable_fire_extinguisher").show();
	$("#msgDiv").hide();
}
function ins_portable_fire_extinguisher()
{
		var portable_fire_extinguisher_ins		= $("#portable_fire_extinguisher_ins").val(); 
		var portable_fire_extinguisher_name		= $("#portable_fire_extinguisher_name").val(); 
		var portable_fire_extinguisher_mal_name	= $("#portable_fire_extinguisher_mal_name").val(); 
		var portable_fire_extinguisher_code		= $("#portable_fire_extinguisher_code").val();
		var csrf_token							= '<?php echo $this->security->get_csrf_hash(); ?>';
			
	if(portable_fire_extinguisher_name=="")
        {
            alert("Portable Fire Extinguisher Name Required");
            $("#portable_fire_extinguisher_name").focus();
            return false;
            
        }
        
        if(portable_fire_extinguisher_code=="")
        {
            alert("Portable Fire Extinguisher Code Required");
            $("#portable_fire_extinguisher_code").focus();
            return false;
        }
        
				$.ajax({
					url : "<?php echo site_url('Master/add_portable_fire_extinguisher/')?>",
					type: "POST",
					data:{portable_fire_extinguisher_ins:portable_fire_extinguisher_ins, portable_fire_extinguisher_name:portable_fire_extinguisher_name,portable_fire_extinguisher_mal_name:portable_fire_extinguisher_mal_name,portable_fire_extinguisher_code:portable_fire_extinguisher_code,'csrf_test_name': csrf_token},
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#portable_fire_extinguisher_name").val('');
							$("#portable_fire_extinguisher_mal_name").val('');
							$("#portable_fire_extinguisher_code").val('');
						}
						else{
							window.location.reload(true);
						}
					}
				});
		
}
function toggle_status(id,status)
{
	
	var csrf_token		= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Master/status_portable_fire_extinguisher/')?>",
				type: "POST",
				data:{ id:id,stat:status,'csrf_test_name': csrf_token},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
	function del_portable_fire_extinguisher(id,status)
{
	var csrf_token		= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Master/delete_portable_fire_extinguisher/')?>",
				type: "POST",
				data:{ id:id,stat:status,'csrf_test_name': csrf_token},
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


function edit_portable_fire_extinguisher(id,i)
{
	$("#view_portable_fire_extinguisher").hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_portable_fire_extinguisher_btn_"+i).hide();
	$("#save_portable_fire_extinguisher_"+i).show();
	$("#cancel_portable_fire_extinguisher_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_portable_fire_extinguisher(id,i)
{
	$("#view_portable_fire_extinguisher").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_portable_fire_extinguisher_btn_"+i).show();
	$("#save_portable_fire_extinguisher_"+i).hide();
	$("#cancel_portable_fire_extinguisher_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
	$("#valid_err_msg_name_"+i).hide();
	$("#valid_err_msg_code_"+i).hide();
}
	
function save_portable_fire_extinguisher(id,i)
{
	var edit_portable_fire_extinguisher= $("#edit_portable_fire_extinguisher_"+i).val();
	var edit_portable_fire_extinguisher_code= $("#edit_portable_fire_extinguisher_code_"+i).val();
	var edit_portable_fire_extinguisher_mal= $("#edit_portable_fire_extinguisher_mal_"+i).val();
	var csrf_token		= '<?php echo $this->security->get_csrf_hash(); ?>';
	var re = /^[ A-Za-z0-9]*$/;



	if(edit_portable_fire_extinguisher=="")
        {
            alert("Portable Fire Extinguisher Name Required");
            $("#edit_portable_fire_extinguisher_"+i).focus();
            return false;
            
        }
        
        if(edit_portable_fire_extinguisher_code=="")
        {
            alert("Portable Fire Extinguisher Code Required");
            $("#edit_portable_fire_extinguisher_code_"+i).focus();
            return false;
        }

	var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
	var regcd = new RegExp("^[a-zA-Z]+$");
  	if (regex.exec(edit_portable_fire_extinguisher) == null) 
	{
    		alert("Only alphabets and characters like .-_ are allowed in Portable Fire Extinguisher Name.");
		document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowedin Portable Fire Extinguisher Name.</font>";
    		document.getElementById("edit_portable_fire_extinguisher").value = null;
    		return false;
  	} 
    	if (regcd.exec(edit_portable_fire_extinguisher_code) == null) 
	{
    		alert("Only Alphabets Allowed in Portable Fire Extinguisher Code.");
		document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowedd in Portable Fire Extinguisher Code.</font>";
    		document.getElementById("edit_portable_fire_extinguisher_code").value = null;
    		return false;
  	} 


	if(edit_portable_fire_extinguisher=="" ||  edit_portable_fire_extinguisher_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Portable Fire Extinguisher Name And Portable Fire Extinguisher Code</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Master/edit_portable_fire_extinguisher/')?>",
					type: "POST",
					data:{ id:id,edit_portable_fire_extinguisher:edit_portable_fire_extinguisher,edit_portable_fire_extinguisher_mal:edit_portable_fire_extinguisher_mal,edit_portable_fire_extinguisher_code:edit_portable_fire_extinguisher_code,'csrf_test_name': csrf_token},
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
<button type="button" class="btn bg-primary btn-flat margin">Portable Fire Extinguisher</button>
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
        $attributes = array("class" => "form-horizontal", "id" => "portable_fire_extinguisher", "name" => "portable_fire_extinguisher" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Master/add_portable_fire_extinguisher", $attributes);
		} else {
			echo form_open("Master/add_portable_fire_extinguisher", $attributes);
		}?>
         
         
          <div class="box">
            <div class="box-header">
            
            <div class="box-header" id="view_portable_fire_extinguisher">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_portable_fire_extinguisher()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Portable Fire Extinguisher</button>
            </div>
             
             
             <div class="box-header col-md-12" id="add_portable_fire_extinguisher" style="display:none;">
            <div class="col-md-3">
             <input type="text" name="portable_fire_extinguisher_name" maxlength="20" id="portable_fire_extinguisher_name" class="form-control col-md-3"  placeholder=" Enter portable_fire_extinguisher Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="portable_fire_extinguisher_mal_name" maxlength="50" id="portable_fire_extinguisher_mal_name" class="form-control"   placeholder=" Enter portable_fire_extinguisher Malayalam Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="portable_fire_extinguisher_code" maxlength="4" id="portable_fire_extinguisher_code" class="form-control"  placeholder=" Enter portable_fire_extinguisher Code" autocomplete="off"/><br /> 
             </div>
             
             
             <div class="col-md-6">
             <input type="button" name="portable_fire_extinguisher_ins" id="portable_fire_extinguisher_ins" value="Save Portable Fire Extinguisher" class="btn btn-info btn-flat" onClick="ins_portable_fire_extinguisher()"  />
             &nbsp;&nbsp;
             <input type="button" name="portable_fire_extinguisher_del" id="portable_fire_extinguisher_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_portable_fire_extinguisher()"  />
            </div>
            </div>
            
            
            
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Portable Fire Extinguisher Name</th>
                  <th id="col_name1">Portable Fire Extinguisher Name(Malayalam)</th>
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
				foreach($portable_fire_extinguisher as $rowmodule){
				$id = $rowmodule['portable_fire_extinguisher_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['portable_fire_extinguisher_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_portable_fire_extinguisher_<?php echo $i;?>"  id="edit_portable_fire_extinguisher_<?php  echo $i;?>" value="<?php echo $rowmodule['portable_fire_extinguisher_name'];?>" onchange="check_dup_portable_fire_extinguisher_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['portable_fire_extinguisher_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_portable_fire_extinguisher_mal_<?php echo $i;?>"  id="edit_portable_fire_extinguisher_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['portable_fire_extinguisher_mal_name'];?>" onchange="check_dup_portable_fire_extinguisher_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['portable_fire_extinguisher_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_portable_fire_extinguisher_code<?php echo $i;?>"  id="edit_portable_fire_extinguisher_code_<?php  echo $i;?>" value="<?php echo $rowmodule['portable_fire_extinguisher_code'];?>" onchange="check_dup_portable_fire_extinguisher_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['portable_fire_extinguisher_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['portable_fire_extinguisher_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
					<?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['portable_fire_extinguisher_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_portable_fire_extinguisher_btn_<?php echo $i;?>" id="edit_portable_fire_extinguisher_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_portable_fire_extinguisher(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit </button> 						
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_portable_fire_extinguisher_<?php echo $i;?>" id="save_portable_fire_extinguisher_<?php echo $i;?>" onclick="save_portable_fire_extinguisher(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_portable_fire_extinguisher_<?php echo $i;?>" id="cancel_portable_fire_extinguisher_<?php echo $i;?>" onclick="cancel_portable_fire_extinguisher(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete portable_fire_extinguisher?')){ del_portable_fire_extinguisher(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete portable_fire_extinguisher?')){ del_portable_fire_extinguisher(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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
                  <th>Portable Fire Extinguisher Name</th>
                  <th>Portable Fire Extinguisher Name(Malayalam)</th>
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
  
