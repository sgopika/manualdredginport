 
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
			
	 $('#vesselcategory_form').validate({
			rules:
			         { 
				  vesselcategory_name:{required:true,
				  alphaonly:true,
				  maxlength:20, },

				  vesselcategory_code:{required:true,
				  alphaonly:true,
				  maxlength:4, },
                     },
			messages:
			         {
						 vesselcategory_name:{required:"<font color='red'>Please enter Category Name</span>",
						 alphaonly:"<font color='red'>Vessel Category Name can contain only alphabets and characters like .-_</font>",
						 maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
						 
						 vesselcategory_code:{required:"<font color='red'>Please enter Category Code</span>",
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

function add_vesselcategory()
{
    $("#view_vesselcategory").hide();
	$("#add_vesselcategory").show();
}
	
function delete_vesselcategory()
{
	$("#add_vesselcategory").hide();
	$("#view_vesselcategory").show();
	$("#msgDiv").hide();
}
function ins_vesselcategory()
{
		var vesselcategory_ins		= $("#vesselcategory_ins").val(); 
		var vesselcategory_name		= $("#vesselcategory_name").val(); 
		var vesselcategory_mal_name	= $("#vesselcategory_mal_name").val(); 
		var vesselcategory_code		= $("#vesselcategory_code").val();
			
	if(vesselcategory_name=="")
        {
            alert("Vessel Category Name Required");
            $("#vesselcategory_name").focus();
            return false;
            
        }
        
        if(vesselcategory_code=="")
        {
            alert("Vessel Category Code Required");
            $("#vesselcategory_code").focus();
            return false;
        }
        
				$.ajax({
					url : "<?php echo site_url('Master/add_vesselcategory/')?>",
					type: "POST",
					data:{vesselcategory_ins:vesselcategory_ins, vesselcategory_name:vesselcategory_name,vesselcategory_mal_name:vesselcategory_mal_name,vesselcategory_code:vesselcategory_code},
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#vesselcategory_name").val('');
							$("#vesselcategory_mal_name").val('');
							$("#vesselcategory_code").val('');
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
				url : "<?php echo site_url('Master/status_vesselcategory/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
	function del_vesselcategory(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/delete_vesselcategory/')?>",
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


function edit_vesselcategory(id,i)
{
	$("#view_vesselcategory").hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_vesselcategory_btn_"+i).hide();
	$("#save_vesselcategory_"+i).show();
	$("#cancel_vesselcategory_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_vesselcategory(id,i)
{
	$("#view_vesselcategory").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_vesselcategory_btn_"+i).show();
	$("#save_vesselcategory_"+i).hide();
	$("#cancel_vesselcategory_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
	$("#valid_err_msg_name_"+i).hide();
	$("#valid_err_msg_code_"+i).hide();
}
	
function save_vesselcategory(id,i)
{
	var edit_vesselcategory= $("#edit_vesselcategory_"+i).val();
	var edit_vesselcategory_code= $("#edit_vesselcategory_code_"+i).val();
	var edit_vesselcategory_mal= $("#edit_vesselcategory_mal_"+i).val();
	var re = /^[ A-Za-z0-9]*$/;


	if(edit_vesselcategory=="")
        {
            alert("Vessel Category Name Required");
            $("#edit_vesselcategory_"+i).focus();
            return false;
            
        }
        	
        if(edit_vesselcategory_code=="")
        {
            alert("Vessel Category Code Required");
            $("#edit_vesselcategory_code_"+i).focus();
            return false;
        }



	var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
	var regcd = new RegExp("^[a-zA-Z]+$");
  	if (regex.exec(edit_vesselcategory) == null) 
	{
    		alert("Vessel Category Name can contain only alphabets and characters like .-_");
		document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Vessel Category Name can contain only alphabets and characters like .-_</font>";
    		document.getElementById("edit_vesselcategory").value = null;
    		return false;
  	} 
    	if (regcd.exec(edit_vesselcategory_code) == null) 
	{
    		alert("Only Alphabets Allowed in Vessel Category Code.");
		document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Vessel Category Code.</font>";
    		document.getElementById("edit_vesselcategory_code").value = null;
    		return false;
  	} 



	if(edit_vesselcategory=="" ||  edit_vesselcategory_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Vessel category And Vessel category Code</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Master/edit_vesselcategory/')?>",
					type: "POST",
					data:{ id:id,edit_vesselcategory:edit_vesselcategory,edit_vesselcategory_mal:edit_vesselcategory_mal,edit_vesselcategory_code:edit_vesselcategory_code},
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
		<span class="badge bg-darkmagenta innertitle mt-2">Zone Details</span>
	</div>  <!-- end of col4 -->
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb justify-content-end mb-0">
           <li class="breadcrumb-item"><a href="<?php echo base_url()."index.php/Survey/pcHome"?>">Home</a></li> 
           <li class="breadcrumb-item"><a href="<?php echo base_url()."index.php/Survey/pcdredginghome"?>">Manual Dredging</a></li> 
         </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<!---------------------------------------- start of main content area  ---------------------------------------- -->
	<div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
                <?php 
		        $attributes = array("class" => "form-horizontal", "id" => "vesselcategory_form", "name" => "vesselcategory_form" , "novalidate");
				if(isset($editres)){
		       		echo form_open("Master/add_vesselcategory", $attributes);
				} else {
					echo form_open("Master/add_vesselcategory", $attributes);
				}?>
	<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_vesselcategory()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Vessel Category</button>
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
	<div class="row py-3" id="add_vesselcategory" style="display:none;">
		<div class="col-4">
             <input type="text" name="vesselcategory_name" maxlength="20" id="vesselcategory_name" class="form-control "  placeholder=" Enter Vessel Category Name" autocomplete="off"/><br /> 
             </div> <!-- end of col4 -->
              <div class="col-4">
             <input type="text" name="vesselcategory_mal_name" maxlength="50" id="vesselcategory_mal_name" class="form-control"   placeholder=" Enter Vessel Category Malayalam Name" autocomplete="off"/><br /> 
             </div>  <!-- end of col4 -->
              <div class="col-4">
             <input type="text" name="vesselcategory_code" maxlength="4" id="vesselcategory_code" class="form-control"  placeholder=" Enter Vessel Category Code" autocomplete="off"/><br /> 
             </div>  <!-- end of col4 -->
             <div class="col-6">
             <input type="button" name="vesselcategory_ins" id="vesselcategory_ins" value="Save Vessel Category" class="btn btn-info btn-flat" onClick="ins_vesselcategory()"  />
             &nbsp;&nbsp;
         	 </div>  <!-- end of col6 -->
         	 <div class="col-6">
             <input type="button" name="vesselcategory_del" id="vesselcategory_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_vesselcategory()"  />
            </div> <!-- end of col6 -->
	</div> <!-- end of add row -->
	<div class="row">
		<div class="col-9">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
		<table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Vessel Category Name</th>
                  <th id="col_name1">Vessel Category Name(Malayalam)</th>
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
				foreach($vesselcategory as $rowmodule){
				$id = $rowmodule['vesselcategory_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['vesselcategory_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_vesselcategory_<?php echo $i;?>"  id="edit_vesselcategory_<?php  echo $i;?>" value="<?php echo $rowmodule['vesselcategory_name'];?>" onchange="check_dup_vesselcategory_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['vesselcategory_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_vesselcategory_mal_<?php echo $i;?>"  id="edit_vesselcategory_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['vesselcategory_mal_name'];?>" onchange="check_dup_vesselcategory_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['vesselcategory_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_vesselcategory_code<?php echo $i;?>"  id="edit_vesselcategory_code_<?php  echo $i;?>" value="<?php echo $rowmodule['vesselcategory_code'];?>" onchange="check_dup_vesselcategory_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['vesselcategory_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vesselcategory_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
					<?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vesselcategory_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_vesselcategory_btn_<?php echo $i;?>" id="edit_vesselcategory_btn_<?php echo $i;?>" class="btn btn-sm bg-seagreen btn-flat" type="button" onclick="edit_vesselcategory(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button> 						
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_vesselcategory_<?php echo $i;?>" id="save_vesselcategory_<?php echo $i;?>" onclick="save_vesselcategory(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="mt-2 btn btn-sm btn-danger btn-flat" type="button" name="cancel_vesselcategory_<?php echo $i;?>" id="cancel_vesselcategory_<?php echo $i;?>" onclick="cancel_vesselcategory(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Category?')){ del_vesselcategory(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Category?')){ del_vesselcategory(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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
                
                <?php
                 echo form_close(); ?>
              </table>
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col10 -->
              <div class="col-3 pl-3 d-flex justify-content-center">
              	<div class="row">
              		<div class="col-12 d-flex justify-content-center bg-royalblue py-1">
              			Settings Panel
              		</div> <!-- end of col12 -->
              		<!--- ------------- inside settings div --------------------------- -->
              		<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="<?php echo base_url()."index.php/Survey/pcZone"?>" class="btn btn-block btn-flat bg-hotpink buttontext btn-point btn-wrap"> Zone </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-crimson buttontext btn-point btn-wrap"> LSGD </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-cadetblue buttontext btn-point btn-wrap"> Quantity </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-darkorchid buttontext btn-point btn-wrap"> Bank </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-palevioletred buttontext btn-point btn-wrap"> Rate </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-burlywood buttontext btn-point btn-wrap"> Canoe </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-sienna buttontext btn-point btn-wrap"> Assign Kadavu </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-mediumorchid buttontext btn-point btn-wrap"> Assign Section </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-darkslateblue buttontext btn-point btn-wrap"> User Management </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-darkturquoise buttontext btn-point btn-wrap"> Mechanical Dredging </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-darkolivegreen buttontext btn-point btn-wrap"> Change Zone </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-indianred buttontext btn-point btn-wrap"> Update Daily Balance </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-firebrick buttontext btn-point btn-wrap"> Send Message  </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-limegreen buttontext btn-point btn-wrap"> Flash Message </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-coral buttontext btn-point btn-wrap"> Change Phone Number </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-darkseagreen buttontext btn-point btn-wrap"> Spot Booking </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-mediumaquamarine buttontext btn-point btn-wrap"> Lorry  </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-midnightblue buttontext btn-point btn-wrap"> 2nd Registration View </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-plum buttontext btn-point btn-wrap"> 2nd Registration Rejected </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-deeppink buttontext btn-point btn-wrap"> Move to changed date </a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-darkslategray buttontext btn-point btn-wrap"> Zone wise worker details</a> 
	</div> <!-- end of col2 -->
	<!-- -------------------------------------------01 each button ends here ------------------------------------- -->
	<!-- -------------------------------------------01 each button starts here ------------------------------------- -->
	<div class="col-6 py-2">
		<a  href="#" class="btn btn-block btn-flat bg-goldenrod buttontext btn-point btn-wrap"> Search Booking Details </a> 
	</div> <!-- end of col2 -->
              		<!--- ----------------------- end of settings div ------------------ -->
              	</div> <!-- end of row -->
              </div> <!-- end of col2 -->
	</div> <!-- end of table row -->
</div> <!-- end of container-fluid -->
<!---------------------------------------- end of main content area  ---------------------------------------- -->