 
<script type="text/javascript" language="javascript">
$(document).ready(function() {
				
		 jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			});    	
			
		 jQuery.validator.addMethod("nospecialmin", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]+$/.test(value);
			}); 
		 jQuery.validator.addMethod("alphaonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]{1,}[a-zA-Z\s.-_]+$/.test(value);
			});    	
			
	jQuery.validator.addMethod("number", function(value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
			});

	 $('#mastertable').validate({
			rules:
			         { 
				  mastertable_name:{required:true, },
					
				  mastertable_mal_name:{required:true,
				  alphaonly:true,
				  maxlength:50, },

				  mastertable_records:{required:true,
				  number:true,
				  maxlength:10, },
                     },
			messages:
			         {
						mastertable_name:
						{
							required:"<font color='red'>Please Select Master Table</span>",
						},
						 
						 mastertable_mal_name:
						 {
						 	required:"<font color='red'>Please enter Master Table Name</span>",
						 	alphaonly:"<font color='red'>Only Alphabets Allowed</font>",
						 	maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"
						 },

						 mastertable_records:
						 {
						 	required:"<font color='red'>Please enter Number of Records</span>",
						 	number:"<font color='red'>Only Numbers Allowed</font>",
						 	maxlength:"<font color='red'>Maximum 10 Character allowed</font>"
						 },
 
			         },
			errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
		});	
});

function add_mastertable()
{
    $("#view_mastertable").hide();
	$("#add_mastertable").show();
}
	
function delete_mastertable()
{
	$("#add_mastertable").hide();
	$("#view_mastertable").show();
	$("#msgDiv").hide();
}
function ins_mastertable()
{
		var mastertable_ins			= $("#mastertable_ins").val(); 
		var mastertable_name		= $("#mastertable_name").val(); 
		var mastertable_mal_name	= $("#mastertable_mal_name").val(); 
		var mastertable_records		= $("#mastertable_records").val();
		var csrf_token				= '<?php echo $this->security->get_csrf_hash(); ?>';
			
	if(mastertable_name=="")
        {
            alert("Please Select Master Table");
            $("#mastertable_name").focus();
            return false;
            
        }
	
	if(mastertable_mal_name=="")
        {
            alert("Master Table Name Required");
            $("#mastertable_mal_name").focus();
            return false;
        }
        
        if(mastertable_records=="")
        {
            alert("Number of Records Required");
            $("#mastertable_records").focus();
            return false;
        }
        
				$.ajax({
					url : "<?php echo site_url('Kiv_Ctrl/Master/add_mastertable/')?>",
					type: "POST",
					data:{mastertable_ins:mastertable_ins, mastertable_name:mastertable_name,mastertable_mal_name:mastertable_mal_name,mastertable_records:mastertable_records,'csrf_test_name': csrf_token },
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#mastertable_name").val('');
							$("#mastertable_mal_name").val('');
							$("#mastertable_records").val('');
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
				url : "<?php echo site_url('Kiv_Ctrl/Master/status_mastertable/')?>",
				type: "POST",
				data:{ id:id,stat:status,'csrf_test_name': csrf_token },
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
function del_mastertable(id,status)
{
	var csrf_token		= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Kiv_Ctrl/Master/delete_mastertable/')?>",
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


function edit_mastertable(id,i)
{
	$("#view_mastertable").hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_mastertable_btn_"+i).hide();
	$("#save_mastertable_"+i).show();
	$("#cancel_mastertable_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_mastertable(id,i)
{
	$("#view_mastertable").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_mastertable_btn_"+i).show();
	$("#save_mastertable_"+i).hide();
	$("#cancel_mastertable_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
	$("#valid_err_msg_name_"+i).hide();
	$("#valid_err_msg_code_"+i).hide();
	$("#valid_err_msg_rec_"+i).hide();
}
	
function save_mastertable(id,i)
{
	var edit_mastertable= $("#edit_mastertable_"+i).val();
	var edit_mastertable_records= $("#edit_mastertable_records_"+i).val();
	var edit_mastertable_mal= $("#edit_mastertable_mal_"+i).val();
	var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
	//var re = /^[ A-Za-z0-9]*$/;
	
	if(edit_mastertable=="")
        {
            alert("Select Master Table ");
            $("#edit_mastertable").focus();
            return false;
            
        }
        

	if(edit_mastertable_mal=="")
        {
            alert("Master table Name Required");
            $("#edit_mastertable_mal_"+i).focus();
            return false;
            
        }
        
        if(edit_mastertable_records=="")
        {
            alert("Number of records Required");
            $("#edit_mastertable_records_"+i).focus();
            return false;
        }



	var regex  = new RegExp("^[a-zA-Z0-9\ \.\_\-]+$");
	var regnum = new RegExp("^[0-9]+$");
  	if (regex.exec(edit_mastertable) == null) 
	{
    		alert("Only alphabets and characters like .-_ are allowed in in Master Table.");
		document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Master Table.</font>";
    		document.getElementById("edit_mastertable").value = null;
    		return false;
  	} 
    	if (regex.exec(edit_mastertable_mal) == null) 
	{
    		alert("Only alphabets and characters like .-_ are allowed Master Table Name.");
		document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Master Table Name.</font>";
    		document.getElementById("edit_mastertable_mal").value = null;
    		return false;
  	} 
	if (regnum.exec(edit_mastertable_records) == null) 
	{
    		alert("Only numbers are allowed in Number of Records.");
		document.getElementById("valid_err_msg_rec_"+i).innerHTML ="<font color='red'>Only numbers are allowed in Number of Records.</font>";
    		document.getElementById("edit_mastertable_records").value = null;
    		return false;
  	} 




	if(edit_mastertable=="" ||  edit_mastertable_records=="" || edit_mastertable_mal==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Master Table, Master Table Name And Number of Records</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Kiv_Ctrl/Master/edit_mastertable/')?>",
					type: "POST",
					data:{ id:id,edit_mastertable:edit_mastertable,edit_mastertable_mal:edit_mastertable_mal,edit_mastertable_records:edit_mastertable_records,'csrf_test_name': csrf_token },
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
  <!-- <div class="content-wrapper"> -->
  	<div class="container-fluid ui-innerpage">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
     <h1>
<button type="button" class="btn bg-primary btn-flat margin">Dynamic Form</button>
      </h1>
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
       
     </ol></ol>
    </section> -->
    <div class="row pt-2">
    <div class="col-6">
      <span class="badge bg-darkmagenta innertitle ">Dynamic Form</span>
    </div> <!-- end of col6 -->
    <div class="col-6 d-flex justify-content-end">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
           <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
        </ol>
      </nav>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
      <div class="col-md-12">
         
         
         <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
         
         <?php 
        $attributes = array("class" => "form-horizontal", "id" => "mastertable", "name" => "mastertable" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Kiv_Ctrl/Master/add_mastertable", $attributes);
		} else {
			echo form_open("Kiv_Ctrl/Master/add_mastertable", $attributes);
		}?>
         
         
     <div class="box">
       <div class="box-header">
            
			<div class="box-header" id="view_mastertable">
            <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/mastertable_print"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue">  Print</span> </a>
            </div>

            <div class="box-header" id="view_mastertable">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_mastertable()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Master Table</button>
            </div>
             
		
			<div class="box-header col-md-12 row" id="add_mastertable" style="display:none;">
                 
            <div class="col-md-3">
              <div class="form-group">
                <select name="mastertable_name" id="mastertable_name" class="form-control select2 div300">
                <option value="">Select</option> 
                <?php foreach($show_table as $show_table_list){ ?>
                <option value="<?php echo $show_table_list['myTables']; ?>" id="<?php echo $show_table_list['myTables']; ?>"><?php echo $show_table_list['myTables'];?></option>
                <?php }  ?>
                </select> 
               </div>
             </div>
            
          
            <div class="col-md-3">
             <input type="text" name="mastertable_mal_name" maxlength="50" id="mastertable_mal_name" class="form-control"   placeholder=" Enter Master Table Name" autocomplete="off"/><br /> 
            </div>
            <div class="col-md-3">
             <input type="text" name="mastertable_records"  maxlength="10" id="mastertable_records" class="form-control"  placeholder=" Enter Number of Records" autocomplete="off"/><br /> 
            </div>
             
             
            <div class="col-md-3">
            <input type="button" name="mastertable_ins" id="mastertable_ins" value="Save Master Table" class="btn btn-info btn-flat" onClick="ins_mastertable()"  />
             &nbsp;&nbsp;
            <input type="button" name="mastertable_del" id="mastertable_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_mastertable()"  />
            </div>
            </div>        
            
            
            
            <!--</div>-->
            <!-- /.box-header -->
            
    <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Master table</th>
                  <th id="col_name1">Master table Name</th>
                  <th id="col_name2">Number of Records</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                 <?php
				//print_r($data);
				$i=1;
				foreach($mastertable as $rowmodule){
				$id = $rowmodule['mastertable_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['mastertable_name'];?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input class="div300" type="text" name="edit_mastertable_<?php echo $i;?>"  id="edit_mastertable_<?php  echo $i;?>" value="<?php echo $rowmodule['mastertable_name'];?>" onchange="check_dup_mastertable_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>               
		
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['mastertable_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_mastertable_mal_<?php echo $i;?>"  id="edit_mastertable_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['mastertable_mal_name'];?>" onchange="check_dup_mastertable_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['mastertable_records'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="10" class="div80" type="text" name="edit_mastertable_records<?php echo $i;?>"  id="edit_mastertable_records_<?php  echo $i;?>" value="<?php echo $rowmodule['mastertable_records'];?>" onchange="check_dup_mastertable_records_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_rec_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['mastertable_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['mastertable_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
					<?php
					}
					else
					{
					?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['mastertable_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                 <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_mastertable_btn_<?php echo $i;?>" id="edit_mastertable_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_mastertable(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit </button> 						
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_mastertable_<?php echo $i;?>" id="save_mastertable_<?php echo $i;?>" onclick="save_mastertable(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_mastertable_<?php echo $i;?>" id="cancel_mastertable_<?php echo $i;?>" onclick="cancel_mastertable(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Master Table?')){ del_mastertable(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
					}
					else
					{
					?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Master Table?')){ del_mastertable(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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
                  <th>Master Table</th>
                  <th>Master Table Name</th>
                  <th>Number of Records</th>
                  <th>Status</th>
                  <th></th>
                  <th></th>
                  
                </tr>
                </tfoot>
              </table>

</div>
        <!-- end of  /.box-body -->
        
          <?php  echo form_close(); ?>
        
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
