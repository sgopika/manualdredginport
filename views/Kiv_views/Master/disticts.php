 
<script type="text/javascript" language="javascript">
 /*
$(document).ready(function()
{

 $('#vesselcategory_form').validate({
			     rules:
			         { 
				vesselcategory_name	:{required:true,},
				vesselcategory_code	:{required:true,}
                            },
			  messages:
			         {
				     vesselcategory_name	:{required:"<font color='red'>Required</font>",},
				     vesselcategory_code	:{required:"<font color='red'>Required</font>",},
					}			
		
                
					 	
		   });
});	
*/
 

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
}
	
function save_vesselcategory(id,i)
{
	var edit_vesselcategory= $("#edit_vesselcategory_"+i).val();
	var edit_vesselcategory_code= $("#edit_vesselcategory_code_"+i).val();
	var edit_vesselcategory_mal= $("#edit_vesselcategory_mal_"+i).val();
	var re = /^[ A-Za-z0-9]*$/;
	if(edit_vesselcategory=="" ||  edit_vesselcategory_code==""){
			$("#msgDiv").show();
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter vesselcategory And Vessel category Code</font>";
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
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
<button type="button" class="btn bg-primary btn-flat margin">Vessel Category</button>
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
        $attributes = array("class" => "form-horizontal", "id" => "vesselcategory_form", "name" => "vesselcategory_form" , "novalidate");
		
		if(isset($editres)){
       		echo form_open("Master/add_vesselcategory", $attributes);
		} else {
			echo form_open("Master/add_vesselcategory", $attributes);
		}?>
         
         
          <div class="box">
            <div class="box-header">
            
            <div class="box-header" id="view_vesselcategory">
             <button type="button" class="btn btn-sm btn-primary" onClick="add_vesselcategory()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Vessel Category</button>
            </div>
             
             
             <div class="box-header col-md-12" id="add_vesselcategory" style="display:none;">
            <div class="col-md-3">
             <input type="text" name="vesselcategory_name" id="vesselcategory_name" class="form-control col-md-3"  placeholder=" Enter Vessel Category Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="vesselcategory_mal_name" id="vesselcategory_mal_name" class="form-control"   placeholder=" Enter Vessel Category Malayalam Name" autocomplete="off"/><br /> 
             </div>
              <div class="col-md-3">
             <input type="text" name="vesselcategory_code" id="vesselcategory_code" class="form-control"  placeholder=" Enter Vessel Category Code" autocomplete="off"/><br /> 
             </div>
             
             
             <div class="col-md-6">
             <input type="button" name="vesselcategory_ins" id="vesselcategory_ins" value="Save Vessel Category" class="btn btn-info btn-flat" onClick="ins_vesselcategory()"  />
             &nbsp;&nbsp;
             <input type="button" name="vesselcategory_del" id="vesselcategory_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_vesselcategory()"  />
            </div>
            </div>
            
            
            
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
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
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input class="div300" type="text" name="edit_vesselcategory_<?php echo $i;?>"  id="edit_vesselcategory_<?php  echo $i;?>" value="<?php echo $rowmodule['vesselcategory_name'];?>" onchange="check_dup_vesselcategory_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['vesselcategory_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input class="div300"  type="text" name="edit_vesselcategory_mal_<?php echo $i;?>"  id="edit_vesselcategory_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['vesselcategory_mal_name'];?>" onchange="check_dup_vesselcategory_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['vesselcategory_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input class="div80" type="text" name="edit_vesselcategory_code<?php echo $i;?>"  id="edit_vesselcategory_code_<?php  echo $i;?>" value="<?php echo $rowmodule['vesselcategory_code'];?>" onchange="check_dup_vesselcategory_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
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
                        <button name="edit_vesselcategory_btn_<?php echo $i;?>" id="edit_vesselcategory_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_vesselcategory(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit </button> 						
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_vesselcategory_<?php echo $i;?>" id="save_vesselcategory_<?php echo $i;?>" onclick="save_vesselcategory(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_vesselcategory_<?php echo $i;?>" id="cancel_vesselcategory_<?php echo $i;?>" onclick="cancel_vesselcategory(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
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
                <tfoot>
                <tr>
                  <th>Sl.No</th>
                  <th>District Name</th>
                  <th>District Name(Malayalam)</th>
                  <th>District Code</th>
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
  
