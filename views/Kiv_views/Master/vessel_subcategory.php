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
			
	 $('#vessel_subcategory_form').validate({
			rules:
			         { 
				  vessel_subcategory_category_id:{required:true,
				  },


				  vessel_subcategory_name:{required:true,
				  alphaonly:true,
				  maxlength:20, },

				  vessel_subcategory_code:{required:true,
				  nospecialmin:true,
				  maxlength:4, },
                     },
			messages:
			         {
				 vessel_subcategory_category_id:{required:"<font color='red'>Please enter Vessel Category Name</span>",
				 },


				 vessel_subcategory_name:{required:"<font color='red'>Please enter Vessel Sub Category Name</span>",
				 alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed in vessel category name.</font>",
				 maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
						 
				 vessel_subcategory_code:{required:"<font color='red'>Please enter Vessel Sub Category Code</span>",
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

function add_vessel_subcategory()
{
    $("#view_vessel_subcategory").hide();
	$("#add_vessel_subcategory").show();
}
	
function delete_vessel_subcategory()
{
	$("#add_vessel_subcategory").hide();
	$("#view_vessel_subcategory").show();
	$("#msgDiv").hide();
}
function ins_vessel_subcategory()
{
		var vessel_subcategory_ins		= $("#vessel_subcategory_ins").val(); 
                var vessel_subcategory_category_id	= $("#vessel_subcategory_category_id").val(); 
		var vessel_subcategory_name		= $("#vessel_subcategory_name").val(); 
		var vessel_subcategory_mal_name         = $("#vessel_subcategory_mal_name").val(); 
		var vessel_subcategory_code		= $("#vessel_subcategory_code").val();
			
			
	if(vessel_subcategory_category_id=="")
        {
            alert("Select Category Name");
           
            return false;
            
        }
        
        if(vessel_subcategory_name=="")
        {
            alert("Vessel Sub Category Name Required");
            $("#vessel_subcategory_name").focus();
            return false;
        }
        if(vessel_subcategory_code=="")
        {
            alert("Vessel Sub Category Code Required");
            $("#vessel_subcategory_code").focus();
            return false;
        }
        
        
        
				$.ajax({
					url : "<?php echo site_url('Kiv_Ctrl/Master/add_vessel_subcategory/')?>",
					type: "POST",
					data:{vessel_subcategory_ins:vessel_subcategory_ins, vessel_subcategory_name:vessel_subcategory_name,vessel_subcategory_mal_name:vessel_subcategory_mal_name,vessel_subcategory_code:vessel_subcategory_code,vessel_subcategory_category_id:vessel_subcategory_category_id},
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#vessel_subcategory_name").val('');
							$("#vessel_subcategory_mal_name").val('');
							$("#vessel_subcategory_code").val('');
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
				url : "<?php echo site_url('Kiv_Ctrl/Master/status_vessel_subcategory/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
	function del_vessel_subcategory(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Kiv_Ctrl/Master/delete_vessel_subcategory/')?>",
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


function edit_vessel_subcategory(id,i)
{
	$("#view_vessel_subcategory").hide();
        $("#first0_"+i).hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
        $("#hide0_"+i).show();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_vessel_subcategory_btn_"+i).hide();
	$("#save_vessel_subcategory_"+i).show();
	$("#cancel_vessel_subcategory_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_vessel_subcategory(id,i)
{
	$("#view_vessel_subcategory").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
        $("#first0_"+i).show();//new
	$("#hide0_"+i).hide();//new
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_vessel_subcategory_btn_"+i).show();
	$("#save_vessel_subcategory_"+i).hide();
	$("#cancel_vessel_subcategory_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
	$("#valid_err_msg_name_"+i).hide();
	$("#valid_err_msg_code_"+i).hide();
}
	
function save_vessel_subcategory(id,i)
{
    
    	var edit_vessel_subcategory_category_id= $("#edit_vessel_subcategory_category_id_"+i).val();
     	var edit_vessel_subcategory= $("#edit_vessel_subcategory_"+i).val();
	var edit_vessel_subcategory_code= $("#edit_vessel_subcategory_code_"+i).val();
	var edit_vessel_subcategory_mal= $("#edit_vessel_subcategory_mal_"+i).val();
	var re = /^[ A-Za-z0-9]*$/;


	if(edit_vessel_subcategory=="")
        {
            alert("Vessel sub category Name Required");
            $("#edit_vessel_subcategory_"+i).focus();
            return false;
            
        }
        	
        if(edit_vessel_subcategory_code=="")
        {
            alert("Vessel sub category Code Required");
            $("#edit_vessel_subcategory_code_"+i).focus();
            return false;
        }



	var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
	var regcd = new RegExp("^[a-zA-Z]+$");
  	if (regex.exec(edit_vessel_subcategory) == null) 
	{
    		alert("Only alphabets and characters like .-_ are allowed in vessel sub category name.");
		document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in vessel sub category Name.</font>";
    		document.getElementById("edit_vessel_subcategory").value = null;
    		return false;
  	} 
    	if (regcd.exec(edit_vessel_subcategory_code) == null) 
	{
    		alert("Only Alphabets Allowed in vessel sub category Code.");
		document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in vessel sub category Code.</font>";
    		document.getElementById("edit_vessel_subcategory_code").value = null;
    		return false;
  	} 



	if(edit_vessel_subcategory=="" ||  edit_vessel_subcategory_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter vessel sub category And Vessel sub category Code</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Kiv_Ctrl/Master/edit_vessel_subcategory/')?>",
					type: "POST",
					data:{ id:id,edit_vessel_subcategory_category_id:edit_vessel_subcategory_category_id,edit_vessel_subcategory:edit_vessel_subcategory,edit_vessel_subcategory_mal:edit_vessel_subcategory_mal,edit_vessel_subcategory_code:edit_vessel_subcategory_code},
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
<!----------------------------------------start of breadcrumb bar -------------------------------------- ------- -->
<div class="container-fluid ui-innerpage">
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Vessel Subcategory</span>
	</div>  <!-- end of col4 -->
	<div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<!---------------------------------------- start of main content area  ---------------------------------------- -->

    <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
     <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
     <?php 
        $attributes = array("class" => "form-horizontal", "id" => "vessel_subcategory_form", "name" => "vessel_subcategory_form" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Kiv_Ctrl/Master/add_vessel_subcategory", $attributes);
		} else {
			echo form_open("Kiv_Ctrl/Master/add_vessel_subcategory", $attributes);
		}?>
	<!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->	       
    <div class="row py-3" id="view_vessel_subcategory">  <!--- change the ID  --- -->
        <div class="col-12">
         <!-- ------------------------------------- Add Button  --------------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_vessel_subcategory()"> <i class="fa fa-plus-circle"></i> &nbsp; Add New Vessel Sub Category</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_vessel_subcategory" style="display:none;"> <!--- change the ID  --- -->
             <div class="col-3">
             <select name="vessel_subcategory_category_id" id="vessel_subcategory_category_id" class="form-control select2 div200">
                     <option value="">Select</option> 
                      <?php foreach($vessel_category as $category_id){ ?>
                <option value="<?php echo $category_id['vesselcategory_sl']; ?>" id="<?php echo $category_id['vesselcategory_sl']; ?>"><?php echo $category_id['vesselcategory_name']; ?></option>
                <?php }  ?>
                 </select> 
             </div> <!-- end of col3 -->
              <div class="col-3">
            <input type="text" name="vessel_subcategory_name" maxlength="20" id="vessel_subcategory_name" class="form-control"  placeholder=" Enter Vessel Sub Category Name" autocomplete="off"/> 
             </div>  <!-- end of col3 -->
              <div class="col-3">
             <input type="text" name="vessel_subcategory_mal_name" maxlength="50" id="vessel_subcategory_mal_name" class="form-control"   placeholder=" Enter Malayalam Name" autocomplete="off"/> 
             </div>  <!-- end of col3 -->
             <div class="col-3">
             <input type="text" name="vessel_subcategory_code" maxlength="4" id="vessel_subcategory_code" class="form-control"  placeholder=" Vessel Sub Category Code" autocomplete="off"/> 
             </div>  <!-- end of col3 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
              <input type="button" name="vessel_subcategory_ins" id="vessel_subcategory_ins" value="Save Vessel Sub Category" class="btn btn-info btn-flat" onClick="ins_vessel_subcategory()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="vessel_subcategory_del" id="vessel_subcategory_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_vessel_subcategory()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Vessel Category Name</th>
                   <th id="col_name">Vessel Sub Category Name</th>
                  <th id="col_name1">Vessel Sub Category Name(Malayalam)</th>
                  <th id="col_name2">Code</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                 <?php
                    $i=1;
                    foreach($vessel_subcategory as $rowmodule){
                    $subcategory_category_id = $rowmodule['vessel_subcategory_category_id'];
                    $id = $rowmodule['vessel_subcategory_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div0_<?php echo $i; ?>">
                  <div id="first0_<?php echo $i;?>" class="col-md-3">
                    <div class="form-group">
                  <?php echo $rowmodule['vesselcategory_name'];  ?>

                  </div>
                    </div>
                    
                    <div id="hide0_<?php echo $i;?>"  class="col-md-3" style="display:none">
                        
                 <select name="edit_vessel_subcategory_category_id_<?php echo $i;?>"  id="edit_vessel_subcategory_category_id_<?php  echo $i;?>"   class="form-control select2 div200">
                <?php foreach($vessel_category as $category_id){ ?>
                <option value="<?php echo $category_id['vesselcategory_sl']; ?>" id="<?php echo $category_id['vesselcategory_sl']; ?>" <?php if($category_id['vesselcategory_sl']==$subcategory_category_id) { echo "selected"; } ?>><?php echo $category_id['vesselcategory_name']; ?></option>
                
                <?php }  ?>
                 </select> 
                 </div>
                </td>              
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" class="col-md-3"><?php echo strtoupper($rowmodule['vessel_subcategory_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  class="col-md-3" style="display:none"><input maxlength="20" type="text" class="div300" name="edit_vessel_subcategory_<?php echo $i;?>"  id="edit_vessel_subcategory_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_subcategory_name'];?>" onchange="check_dup_vessel_subcategory_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><br><br><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['vessel_subcategory_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input type="text" maxlength="50" class="div300" name="edit_vessel_subcategory_mal_<?php echo $i;?>"  id="edit_vessel_subcategory_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_subcategory_mal_name'];?>" onchange="check_dup_vessel_subcategory_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['vessel_subcategory_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none" >
                     <input type="text" class="div80" maxlength="4"  name="edit_vessel_subcategory_code<?php echo $i;?>"  id="edit_vessel_subcategory_code_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_subcategory_code'];?>" onchange="check_dup_vessel_subcategory_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['vessel_subcategory_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vessel_subcategory_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>  </button> 
					<?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vessel_subcategory_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_vessel_subcategory_btn_<?php echo $i;?>" id="edit_vessel_subcategory_btn_<?php echo $i;?>" class="btn btn-sm bg-seagreen btn-flat" type="button" onclick="edit_vessel_subcategory(<?php echo $id;?>,<?php echo $i;?>);" >  <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button> 						
                        </div>
                   <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_vessel_subcategory_<?php echo $i;?>" id="save_vessel_subcategory_<?php echo $i;?>" onclick="save_vessel_subcategory(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="mt-2 btn btn-sm btn-danger btn-flat" type="button" name="cancel_vessel_subcategory_<?php echo $i;?>" id="cancel_vessel_subcategory_<?php echo $i;?>" onclick="cancel_vessel_subcategory(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Category?')){ del_vessel_subcategory(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
                  <?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Category?')){ del_vessel_subcategory(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
						<?php
					}
					?>
                </tr>
                <?php
					$i++;
				}
					?>
              
                </tbody>
                
                <?php
                 echo form_close(); ?>
              </table>
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->
</div> <!-- end of container-fluid -->
<!---------------------------------------- end of main content area  ---------------------------------------- -->