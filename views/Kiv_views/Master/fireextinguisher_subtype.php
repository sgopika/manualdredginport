 
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
			
	 $('#fireextinguisher_subtype').validate({
			rules:
			         { 
				  fireextinguisher_subtype_name:{required:true,
				  alphaonly:true,
				  maxlength:20, },

				  fireextinguisher_subtype_code:{required:true,
				  nospecialmin:true,
				  maxlength:4, },
                     },
			messages:
			         {
						 fireextinguisher_subtype_name:{required:"<font color='red'>Please enter Fire extinguisher sub type Name</span>",
						 alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed</font>",
						 maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
						 
						 fireextinguisher_subtype_code:{required:"<font color='red'>Please enter Fire extinguisher sub type Code</span>",
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

function add_fireextinguisher_subtype()
{
    $("#view_fireextinguisher_subtype").hide();
	$("#add_fireextinguisher_subtype").show();
}
	
function delete_fireextinguisher_subtype()
{
	$("#add_fireextinguisher_subtype").hide();
	$("#view_fireextinguisher_subtype").show();
	$("#msgDiv").hide();
}
function ins_fireextinguisher_subtype()
{
		var fireextinguisher_subtype_ins		= $("#fireextinguisher_subtype_ins").val(); 
		var fireextinguisher_subtype_name		= $("#fireextinguisher_subtype_name").val(); 
		var fireextinguisher_subtype_mal_name	= $("#fireextinguisher_subtype_mal_name").val(); 
		var fireextinguisher_subtype_code		= $("#fireextinguisher_subtype_code").val();
		var csrf_token          				= '<?php echo $this->security->get_csrf_hash(); ?>';
			
	if(fireextinguisher_subtype_name=="")
        {
            alert("Fire extinguisher sub type Name Required");
            $("#fireextinguisher_subtype_name").focus();
            return false;
            
        }
        
        if(fireextinguisher_subtype_code=="")
        {
            alert("Fire extinguisher sub type Code Required");
            $("#fireextinguisher_subtype_code").focus();
            return false;
        }
        
				$.ajax({
					url : "<?php echo site_url('Master/add_fireextinguisher_subtype/')?>",
					type: "POST",
					data:{fireextinguisher_subtype_ins:fireextinguisher_subtype_ins, fireextinguisher_subtype_name:fireextinguisher_subtype_name,fireextinguisher_subtype_mal_name:fireextinguisher_subtype_mal_name,fireextinguisher_subtype_code:fireextinguisher_subtype_code,'csrf_test_name': csrf_token },
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#fireextinguisher_subtype_name").val('');
							$("#fireextinguisher_subtype_mal_name").val('');
							$("#fireextinguisher_subtype_code").val('');
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
				url : "<?php echo site_url('Master/status_fireextinguisher_subtype/')?>",
				type: "POST",
				data:{ id:id,stat:status,'csrf_test_name': csrf_token },
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
	function del_fireextinguisher_subtype(id,status)
{
	var csrf_token          		= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Master/delete_fireextinguisher_subtype/')?>",
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


function edit_fireextinguisher_subtype(id,i)
{
	$("#view_fireextinguisher_subtype").hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_fireextinguisher_subtype_btn_"+i).hide();
	$("#save_fireextinguisher_subtype_"+i).show();
	$("#cancel_fireextinguisher_subtype_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_fireextinguisher_subtype(id,i)
{
	$("#view_fireextinguisher_subtype").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_fireextinguisher_subtype_btn_"+i).show();
	$("#save_fireextinguisher_subtype_"+i).hide();
	$("#cancel_fireextinguisher_subtype_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
}
	
function save_fireextinguisher_subtype(id,i)
{
	var edit_fireextinguisher_subtype= $("#edit_fireextinguisher_subtype_"+i).val();
	var edit_fireextinguisher_subtype_code= $("#edit_fireextinguisher_subtype_code_"+i).val();
	var edit_fireextinguisher_subtype_mal= $("#edit_fireextinguisher_subtype_mal_"+i).val();
	var re = /^[ A-Za-z0-9]*$/;

	if(edit_fireextinguisher_subtype=="")
        {
            alert("Fire extinguisher sub type Name Required");
            $("#edit_fireextinguisher_subtype_"+i).focus();
            return false;
            
        }
        
        if(edit_fireextinguisher_subtype_code=="")
        {
            alert("Fire extinguisher sub type Code Required");
            $("#edit_fireextinguisher_subtype_code_"+i).focus();
            return false;
        }


	var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
	var regcd = new RegExp("^[a-zA-Z]+$");
  	if (regex.exec(edit_fireextinguisher_subtype) == null) 
	{
    		alert("Only alphabets and characters like .-_ are allowed in Fire extinguisher sub type name.");
			document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in  Fire extinguisher sub type name.</font>";
    		document.getElementById("edit_fireextinguisher_subtype").value = null;
    		return false;
  	} 
    	if (regcd.exec(edit_fireextinguisher_subtype_code) == null) 
	{
    		alert("Only Alphabets Allowed in Fire extinguisher sub type code.");
			document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in  Fire extinguisher sub type code.</font>";
    		document.getElementById("edit_fireextinguisher_subtype_code").value = null;
    		return false;
  	} 



	if(edit_fireextinguisher_subtype=="" ||  edit_fireextinguisher_subtype_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Fire extinguisher sub type And Fire extinguisher sub type Code</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Master/edit_fireextinguisher_subtype/')?>",
					type: "POST",
					data:{ id:id,edit_fireextinguisher_subtype:edit_fireextinguisher_subtype,edit_fireextinguisher_subtype_mal:edit_fireextinguisher_subtype_mal,edit_fireextinguisher_subtype_code:edit_fireextinguisher_subtype_code,'csrf_test_name': csrf_token },
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
<button type="button" class="btn bg-primary btn-flat margin">Fire Extinguisher Sub Type</button>
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
        $attributes = array("class" => "form-horizontal", "id" => "fireextinguisher_subtype", "name" => "fireextinguisher_subtype" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Master/add_fireextinguisher_subtype", $attributes);
		} else {
			echo form_open("Master/add_fireextinguisher_subtype", $attributes);
		}?>
         
         
          <div class="box">
            <div class="box-header">
            
            <div class="box-header" id="view_fireextinguisher_subtype">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_fireextinguisher_subtype()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Fire Extinguisher Sub Type</button>
            </div>
             
             
             <div class="box-header col-md-12" id="add_fireextinguisher_subtype" style="display:none;">
            <div class="col-md-3">
             <input type="text" name="fireextinguisher_subtype_name" maxlength="20" id="fireextinguisher_subtype_name" class="form-control col-md-3"  placeholder=" Enter Fire Extinguisher Sub Type Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="fireextinguisher_subtype_mal_name" maxlength="50" id="fireextinguisher_subtype_mal_name" class="form-control"   placeholder=" Enter Fire Extinguisher Sub Type Malayalam Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="fireextinguisher_subtype_code" maxlength="4" id="fireextinguisher_subtype_code" class="form-control"  placeholder=" Enter Fire Extinguisher Sub Type Code" autocomplete="off"/><br /> 
             </div>
             
             
             <div class="col-md-6">
             <input type="button" name="fireextinguisher_subtype_ins" id="fireextinguisher_subtype_ins" value="Save Fire Extinguisher Sub Type" class="btn btn-info btn-flat" onClick="ins_fireextinguisher_subtype()"  />
             &nbsp;&nbsp;
             <input type="button" name="fireextinguisher_subtype_del" id="fireextinguisher_subtype_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_fireextinguisher_subtype()"  />
            </div>
            </div>
            
            
            
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Fire extinguisher sub type Name</th>
                  <th id="col_name1">Fire extinguisher sub type Name(Malayalam)</th>
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
				foreach($fireextinguisher_subtype as $rowmodule){
				$id = $rowmodule['fireextinguisher_subtype_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['fireextinguisher_subtype_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_fireextinguisher_subtype_<?php echo $i;?>"  id="edit_fireextinguisher_subtype_<?php  echo $i;?>" value="<?php echo $rowmodule['fireextinguisher_subtype_name'];?>" onchange="check_dup_fireextinguisher_subtype_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['fireextinguisher_subtype_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_fireextinguisher_subtype_mal_<?php echo $i;?>"  id="edit_fireextinguisher_subtype_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['fireextinguisher_subtype_mal_name'];?>" onchange="check_dup_fireextinguisher_subtype_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['fireextinguisher_subtype_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_fireextinguisher_subtype_code<?php echo $i;?>"  id="edit_fireextinguisher_subtype_code_<?php  echo $i;?>" value="<?php echo $rowmodule['fireextinguisher_subtype_code'];?>" onchange="check_dup_fireextinguisher_subtype_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['fireextinguisher_subtype_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['fireextinguisher_subtype_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
					<?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['fireextinguisher_subtype_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_fireextinguisher_subtype_btn_<?php echo $i;?>" id="edit_fireextinguisher_subtype_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_fireextinguisher_subtype(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit </button> 						
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_fireextinguisher_subtype_<?php echo $i;?>" id="save_fireextinguisher_subtype_<?php echo $i;?>" onclick="save_fireextinguisher_subtype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_fireextinguisher_subtype_<?php echo $i;?>" id="cancel_fireextinguisher_subtype_<?php echo $i;?>" onclick="cancel_fireextinguisher_subtype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Fire extinguisher sub type?')){ del_fireextinguisher_subtype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Fire extinguisher sub type?')){ del_fireextinguisher_subtype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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
                  <th>Fire extinguisher sub type Name</th>
                  <th>Fire extinguisher sub type Name(Malayalam)</th>
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
  
