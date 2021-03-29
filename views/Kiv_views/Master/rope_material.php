 
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
			
	 $('#rope_material').validate({
			rules:
			         { 
				  ropematerial_name:{required:true,
				  alphaonly:true,
				  maxlength:20, },

				  ropematerial_code:{required:true,
				  nospecialmin:true,
				  maxlength:4, },
                     },
			messages:
			         {
						 ropematerial_name:{required:"<font color='red'>Please Enter Rope Material Name</span>",
						 alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
						 maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
						 
						 ropematerial_code:{required:"<font color='red'>Please Enter Rope Material Code</span>",
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

function add_ropematerial()
{
   	$("#view_ropematerial").hide();
	$("#add_ropematerial").show();
}
	
function delete_ropematerial()
{
	$("#add_ropematerial").hide();
	$("#view_ropematerial").show();
	$("#msgDiv").hide();
}
function ins_ropematerial()
{
		var ropematerial_ins		= $("#ropematerial_ins").val(); 
		var ropematerial_name		= $("#ropematerial_name").val(); 
		var ropematerial_mal_name	= $("#ropematerial_mal_name").val(); 
		var ropematerial_code		= $("#ropematerial_code").val();
		var csrf_token				= '<?php echo $this->security->get_csrf_hash(); ?>';

	if(ropematerial_name=="")
        {
            alert("Rope Material Name Required");
            $("#ropematerial_name").focus();
            return false;
            
        }
        
        if(ropematerial_code=="")
        {
            alert("Rope Material Code Required");
            $("#ropematerial_code").focus();
            return false;
        }
        
				$.ajax({
					url : "<?php echo site_url('Master/add_ropematerial/')?>",
					type: "POST",
					data:{ropematerial_ins:ropematerial_ins, ropematerial_name:ropematerial_name,ropematerial_mal_name:ropematerial_mal_name,ropematerial_code:ropematerial_code},
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#ropematerial_name").val('');
							$("#ropematerial_mal_name").val('');
							$("#ropematerial_code").val('');
						}
						else{
							window.location.reload(true);
						}
					}
				});
		
}
function toggle_status(id,status)
{
	
	$.ajax({
				url : "<?php echo site_url('Master/status_ropematerial/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
	function del_ropematerial(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/delete_ropematerial/')?>",
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


function edit_ropematerial(id,i)
{
	$("#view_ropematerial").hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_ropematerial_btn_"+i).hide();
	$("#save_ropematerial_"+i).show();
	$("#cancel_ropematerial_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_ropematerial(id,i)
{
	$("#view_ropematerial").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_ropematerial_btn_"+i).show();
	$("#save_ropematerial_"+i).hide();
	$("#cancel_ropematerial_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
	$("#valid_err_msg_name_"+i).hide();
	$("#valid_err_msg_code_"+i).hide();
}
	
function save_ropematerial(id,i)
{
	var edit_ropematerial= $("#edit_ropematerial_"+i).val();
	var edit_ropematerial_code= $("#edit_ropematerial_code_"+i).val();
	var edit_ropematerial_mal= $("#edit_ropematerial_mal_"+i).val();
	var re = /^[ A-Za-z0-9]*$/;

	

	if(edit_ropematerial=="")
        {
            alert("Rope Material Name Required");
            $("#edit_ropematerial_"+i).focus();
            return false;
            
        }
        
        if(edit_ropematerial_code=="")
        {
            alert("Rope Material Code Required");
            $("#edit_ropematerial_code_"+i).focus();
            return false;
        }

	var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
	var regcd = new RegExp("^[a-zA-Z]+$");
  	if (regex.exec(edit_ropematerial) == null) 
	{
    		alert("Only alphabets and characters like .-_ are allowed in Rope Material Name.");
		document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Rope Material Name.</font>";
    		document.getElementById("edit_ropematerial").value = null;
    		return false;
  	} 
    	if (regcd.exec(edit_ropematerial_code) == null) 
	{
    		alert("Only Alphabets Allowed in Rope Material Code.");
		document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Rope Material Code.</font>";
    		document.getElementById("edit_ropematerial_code").value = null;
    		return false;
  	} 


	if(edit_ropematerial=="" ||  edit_ropematerial_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Rope Material Name And Rope Material Code</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Master/edit_ropematerial/')?>",
					type: "POST",
					data:{ id:id,edit_ropematerial:edit_ropematerial,edit_ropematerial_mal:edit_ropematerial_mal,edit_ropematerial_code:edit_ropematerial_code},
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
<button type="button" class="btn bg-primary btn-flat margin">Rope Material</button>
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
        $attributes = array("class" => "form-horizontal", "id" => "rope_material", "name" => "rope_material" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Master/add_ropematerial", $attributes);
		} else {
			echo form_open("Master/add_ropematerial", $attributes);
		}?>
         
         
          <div class="box">
            <div class="box-header">
            
            <div class="box-header" id="view_ropematerial">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_ropematerial()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Rope Material</button>
            </div>
             
             
             <div class="box-header col-md-12" id="add_ropematerial" style="display:none;">
            <div class="col-md-3">
             <input type="text" name="ropematerial_name"maxlength="20" id="ropematerial_name" class="form-control col-md-3"  placeholder=" Enter Rope Material Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" maxlength="50" name="ropematerial_mal_name" id="ropematerial_mal_name" class="form-control"   placeholder=" Enter Rope Material Malayalam Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="ropematerial_code"maxlength="4" id="ropematerial_code" class="form-control"  placeholder=" Enter Rope Material Code" autocomplete="off"/><br /> 
             </div>
             
             
             <div class="col-md-6">
             <input type="button" name="ropematerial_ins" id="ropematerial_ins" value="Save Rope Material" class="btn btn-info btn-flat" onClick="ins_ropematerial()"  />
             &nbsp;&nbsp;
             <input type="button" name="ropematerial_del" id="ropematerial_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_ropematerial()"  />
            </div>
            </div>
            
            
            
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Rope Material Name</th>
                  <th id="col_name1">Rope Material Name(Malayalam)</th>
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
				foreach($ropematerial as $rowmodule){
				$id = $rowmodule['ropematerial_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['ropematerial_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_ropematerial_<?php echo $i;?>"  id="edit_ropematerial_<?php  echo $i;?>" value="<?php echo $rowmodule['ropematerial_name'];?>" onchange="check_dup_ropematerial_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['ropematerial_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_ropematerial_mal_<?php echo $i;?>"  id="edit_ropematerial_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['ropematerial_mal_name'];?>" onchange="check_dup_ropematerial_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['ropematerial_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_ropematerial_code<?php echo $i;?>"  id="edit_ropematerial_code_<?php  echo $i;?>" value="<?php echo $rowmodule['ropematerial_code'];?>" onchange="check_dup_ropematerial_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['ropematerial_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['ropematerial_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
					<?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['ropematerial_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_ropematerial_btn_<?php echo $i;?>" id="edit_ropematerial_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_ropematerial(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit </button> 						
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_ropematerial_<?php echo $i;?>" id="save_ropematerial_<?php echo $i;?>" onclick="save_ropematerial(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_ropematerial_<?php echo $i;?>" id="cancel_ropematerial_<?php echo $i;?>" onclick="cancel_ropematerial(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Rope Material?')){ del_ropematerial(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Rope Material?')){ del_ropematerial(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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
                  <th>Rope Material Name</th>
                  <th>Rope Material Name(Malayalam)</th>
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
  
