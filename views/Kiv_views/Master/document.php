
<script type="text/javascript" language="javascript">
$(document).ready(function() {
				
		 jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			});    	
			
		 jQuery.validator.addMethod("nospecialmin", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]+$/.test(value);
			});
		 
		 jQuery.validator.addMethod("numalpha", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
			});
 
		 jQuery.validator.addMethod("alphaonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]{1,}[a-zA-Z\s.-]+$/.test(value);
			});    	
			
	 $('#document_form').validate({
			rules:
			         { 
				  document_type_id:{required:true, },

				  document_name:{required:true,
				  alphaonly:true,
				  maxlength:200, },

				  document_code:{required:true,
				  nospecialmin:true,
				  maxlength:4, },
                     },
			messages:
			         {
				  document_type_id:{required:"<font color='red'>Document Type</span>"},
					 
				  
				  document_name:{required:"<font color='red'>Document Name</span>",
				  alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed in Document Name.</font>",
				  maxlength:"<font color='red'>Maximum 200 Characters allowed</font>"},
					 
				  document_code:{required:"<font color='red'>Document Code</span>",
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
function add_document()
{
    $("#view_document").hide();
	$("#add_document").show();
}
	
function delete_document()
{
	$("#add_document").hide();
	$("#view_document").show();
	$("#msgDiv").hide();
}
function ins_document()
{
		var document_ins	= $("#document_ins").val(); 
        var document_type_id	= $("#document_type_id").val(); 
		var document_name	= $("#document_name").val(); 
		var document_mal_name   = $("#document_mal_name").val(); 
		var document_code	= $("#document_code").val();
		var csrf_token      = '<?php echo $this->security->get_csrf_hash(); ?>';
			
			
	if(document_type_id=="")
        {
            alert("Select document type Name");
            $("#document_type_id").focus();           
            return false;
            
        }
        
        if(document_name=="")
        {
            alert("Document Name Required");
            $("#document_name").focus();
            return false;
        }
        if(document_code=="")
        {
            alert("Document Code Required");
            $("#document_code").focus();
            return false;
        }
        
        
        
				$.ajax({
					url : "<?php echo site_url('Kiv_Ctrl/Master/add_document/')?>",
					type: "POST",
					data:{document_ins:document_ins, document_name:document_name,document_mal_name:document_mal_name,document_code:document_code,document_type_id:document_type_id,'csrf_test_name': csrf_token},
					dataType: "JSON",
					success: function(data)
					{
						if(data['val_errors']!=""){
							$("#msgDiv").show();
							document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
							$("#document_name").val('');
							$("#document_mal_name").val('');
							$("#document_code").val('');
						}
						else{
							window.location.reload(true);
						}
					}
				});
		
}
function toggle_status(id,status)
{
	
	var csrf_token          	= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Kiv_Ctrl/Master/status_document/')?>",
				type: "POST",
				data:{ id:id,stat:status,'csrf_test_name': csrf_token},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}
	function del_document(id,status)
{
	var csrf_token          	= '<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
				url : "<?php echo site_url('Kiv_Ctrl/Master/delete_document/')?>",
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


function edit_document(id,i)
{
	$("#view_document").hide();
        $("#first0_"+i).hide();
	$("#first_"+i).hide();
	$("#first1_"+i).hide();
	$("#first2_"+i).hide();
        $("#hide0_"+i).show();
	$("#hide_"+i).show();
	$("#hide1_"+i).show();
	$("#hide2_"+i).show();
	$("#edit_document_btn_"+i).hide();
	$("#save_document_"+i).show();
	$("#cancel_document_"+i).show();
	$("#edit_div_"+i).hide();
	$("#save_div_"+i).show();
}	
	
function cancel_document(id,i)
{
	$("#view_document").show();
	$("#first_"+i).show();
	$("#first1_"+i).show();
	$("#first2_"+i).show();
        $("#first0_"+i).show();//new
	$("#hide0_"+i).hide();//new
	$("#hide_"+i).hide();
	$("#hide1_"+i).hide();
	$("#hide2_"+i).hide();
	$("#edit_document_btn_"+i).show();
	$("#save_document_"+i).hide();
	$("#cancel_document_"+i).hide();
	$("#edit_div_"+i).show();
	$("#save_div_"+i).hide();
	$("#valid_err_msg_name_"+i).hide();
	$("#valid_err_msg_code_"+i).hide();
}
	
function save_document(id,i)
{
    
    var edit_document_type_id  = $("#edit_document_type_id_"+i).val();
    var edit_document          = $("#edit_document_"+i).val();
	var edit_document_code     = $("#edit_document_code_"+i).val();
	var edit_document_mal      = $("#edit_document_mal_"+i).val();
	var csrf_token             = '<?php echo $this->security->get_csrf_hash(); ?>';
	var re = /^[ A-Za-z0-9]*$/;

	if(edit_document_type_id=="")
        {
            alert("Document Type Name Required");
            $("#edit_document_type_id_"+i).focus();
            return false;
            
        }

	if(edit_document=="")
        {
            alert("Document Name Required");
            $("#edit_document_"+i).focus();
            return false;
            
        }
        	
        if(edit_document_code=="")
        {
            alert("Document Code Required");
            $("#edit_document_code_"+i).focus();
            return false;
        }
	var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
	var regcd = new RegExp("^[a-zA-Z]+$");
	
  	if (regex.exec(edit_document) == null) 
		{
    		alert("Only alphabets and characters like .-_ are allowed in Document Name.");
			document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Document Name.</font>";
    		document.getElementById("edit_document").value = null;
    		return false;
  		} 
    if (regcd.exec(edit_document_code) == null) 
		{
    		alert("Only Alphabets Allowed in Document Code.");
		document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets And Numbers Allowed in Document Code.</font>";
    		document.getElementById("edit_document_code").value = null;
    		return false;
  		} 



	
	if(edit_document=="" ||  edit_document_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Document Name And Document Code</font>";
	}

	else{
		$.ajax({
					url : "<?php echo site_url('Kiv_Ctrl/Master/edit_document/')?>",
					type: "POST",
					data:{ id:id,edit_document_type_id:edit_document_type_id,edit_document:edit_document,edit_document_mal:edit_document_mal,edit_document_code:edit_document_code,'csrf_test_name': csrf_token},
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
<button type="button" class="btn bg-primary btn-flat margin">Document</button>
      </h1>
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
      </ol></ol>
    </section> -->
    <div class="row py-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innertitle ">Document </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
      <div class="col-md-12">
         
         
         <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
         
         <?php 
        $attributes = array("class" => "form-horizontal", "id" => "document_form", "name" => "document_form" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Kiv_Ctrl/Master/add_document", $attributes);
		} else {
			echo form_open("Kiv_Ctrl/Master/add_document", $attributes);
		}?>
         
         
          <div class="box">
            <div class="box-header">
            
            <div class="box-header" id="view_document">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_document()"> <i class="fa fa-plus-circle"></i> &nbsp; Add New Document</button>
            </div>
             
             
             <div class="box-header col-md-12 row" id="add_document" style="display:none;">
                 
             <div class="col-md-3">
                  <div class="form-group">
                 <select name="document_type_id" id="document_type_id" class="form-control select2 div200">
                     <option value="">Select Document Type</option> 
                      <?php foreach($document_type as $type_id){ ?>
                <option value="<?php echo $type_id['document_type_sl']; ?>" id="<?php echo $type_id['document_type_sl']; ?>"><?php echo $type_id['document_type_name']; ?></option>
                <?php }  ?>
                 </select> 
                  </div>
             </div>
                 
            <div class="col-md-3">
                
             <input type="text" name="document_name" id="document_name" maxlength="200" class="form-control"  placeholder=" Enter Document Name" autocomplete="off"/><br /> 
             </div>
                 
              <div class="col-md-3">
             <input type="text" name="document_mal_name" maxlength="50" id="document_mal_name" class="form-control"   placeholder=" Enter Malayalam Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="document_code" maxlength="4" id="document_code" class="form-control"  placeholder=" Document Code" autocomplete="off"/><br /> 
             </div>
             
             
             <div class="col-md-6 d-flex justify-content-end">
             <input type="button" name="document_ins" id="document_ins" value="Save Document" class="btn btn-info btn-flat" onClick="ins_document()"  />
             &nbsp;&nbsp;
             <input type="button" name="document_del" id="document_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_document()"  />
            </div>
            </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Document Type Name</th>
                   <th id="col_name">Document Name</th>
                  <th id="col_name1">Document Name(Malayalam)</th>
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
                    foreach($document as $rowmodule){
                    $subtype_type_id = $rowmodule['document_type_id'];
                    $id = $rowmodule['document_sl'];
					?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div0_<?php echo $i; ?>">
                  <div id="first0_<?php echo $i;?>" class="col-md-12">
                    <div class="form-group">
                  <?php echo $rowmodule['document_type_name'];  ?>

                  </div>
                    </div>
                    
                    <div id="hide0_<?php echo $i;?>"  class="col-md-12" style="display:none">
                        
                 <select name="edit_document_type_id_<?php echo $i;?>"  id="edit_document_type_id_<?php  echo $i;?>"   class="form-control select2 div200">
                <?php foreach($document_type as $type_id){ ?>
                <option value="<?php echo $type_id['document_type_sl']; ?>" id="<?php echo $type_id['document_type_sl']; ?>" <?php if($type_id['document_type_sl']==$subtype_type_id) { echo "selected"; } ?>><?php echo $type_id['document_type_name']; ?></option>
                
                <?php }  ?>
                 </select> 
                        
                   
                 </div><div id="valid_err_msg_typename_<?php echo $i; ?>"></div>
                </td>
                
                
               <!-- <td><?php //echo $rowmodule['document_type_name'];  ?></td> -->
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" class="col-md-12"><?php echo strtoupper($rowmodule['document_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  class="col-md-12" style="display:none"><input maxlength="200" type="text" class="div300" name="edit_document_<?php echo $i;?>"  id="edit_document_<?php  echo $i;?>" value="<?php echo $rowmodule['document_name'];?>" onchange="check_dup_document_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
               
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['document_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" type="text" class="div300" name="edit_document_mal_<?php echo $i;?>"  id="edit_document_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['document_mal_name'];?>" onchange="check_dup_document_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['document_code'];?></div>
                
                 <div id="hide2_<?php echo $i;?>" style="display:none" >
                     
                     <input type="text" maxlength="4" class="div80" name="edit_document_code<?php echo $i;?>"  id="edit_document_code_<?php  echo $i;?>" value="<?php echo $rowmodule['document_code'];?>" onchange="check_dup_document_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
              
                </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                	<?php  if($rowmodule['document_status']=='1')
					{
					?>
					<button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['document_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>  </button> 
					<?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['document_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
						<?php
					}
					?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_document_btn_<?php echo $i;?>" id="edit_document_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_document(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit </button> 						
                        </div>
                   <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_document_<?php echo $i;?>" id="save_document_<?php echo $i;?>" onclick="save_document(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-danger btn-flat" type="button" name="cancel_document_<?php echo $i;?>" id="cancel_document_<?php echo $i;?>" onclick="cancel_document(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                 <!-- <span class="glyphicon glyphicon-pencil">Edit</span>-->
                  </td>
                  <td>
                  <?php
					if($rowmodule['delete_status']==1)
					{
					?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Document Type?')){ del_document(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
                  <?php
					}
					else{
						?>
						 <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Document Type?')){ del_document(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
						<?php
					}
					?>
                  <!--<span class="badge bg-blue">Delete</span>--></td>
                 
                </tr>
                <?php
					$i++;
				}
					?>
              
                </tbody>
                <tfoot>
                <tr>
                  <th>Sl.No</th>
                  <th>Document Type Name</th>
                 <th id="col_name">Document Name</th>
                  <th id="col_name1">Document Name(Malayalam)</th>
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
  
