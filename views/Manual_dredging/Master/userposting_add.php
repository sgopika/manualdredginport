<?php
//print_r($_REQUEST);
?>

  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
	  <script type="text/javascript">
	 	$(document).ready(function()
			  {
				
			

		 jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			});    	
			
				
				
	 $('#userposting').validate(
		         {
			     rules:
			         { 
				  user:{required:true,
				//  nospecial:true,
							},
		 designation:{required:true,
				//  nospecial:true,
							},
							 usergroup:{required:true,
				//  nospecial:true,
							},
							 rangeoffice:{required:true,},
							 unitname:{required:true,},
							start_date:{required:true,},
							  end_date:{required:true,},
				
				     },
					 
			  messages:
			         {
						
						user:{required:"<font color='red'>Please select user</span>",
						},	
						designation:{required:"<font color='red'>Please select designation</span>",
						},
						usergroup:{required:"<font color='red'>Please select user group</span>",
						},	
						rangeoffice:{required:"<font color='red'>Please select range</span>",},
						start_date:{required:"<font color='red'>Please select start date</span>",},
						end_date:{required:"<font color='red'>Please select end date</span>",},
						unitname:{required:"<font color='red'>Please select unit</span>",},

									
			         }	,
					 
						errorPlacement: function(error, element)
                                              {
                                                   if ( element.is(":input") ) 
                                                       {
                                                             error.appendTo( element.parent() );
                                                       }
                                               else
                                                       { 
                                                             error.insertAfter( element );
                                                       }
                                             }
					 		
		   });	
				

	
});



</script>
<script>
function check_dates(){
	    var start_date = document.getElementById("start_date").value;
		var end_date = document.getElementById("end_date").value;
		//alert(start_date);
		//alert(end_date);
		if((start_date=="")&&(end_date==""))
		{
				document.getElementById('startdatediv').innerHTML="<font color='red'><b>Please Enter Start date and End date!!!</b></font>";
				document.getElementById('enddatediv').innerHTML="";
		}
		else if((start_date=="")&&(end_date!=""))
		{
				document.getElementById('startdatediv').innerHTML="<font color='red'><b>Please Enter Start date!!!</b></font>";
				document.getElementById('enddatediv').innerHTML="";
		}
		else if((start_date!="")&&(end_date==""))
		{
				document.getElementById('enddatediv').innerHTML="<font color='red'><b>Please Enter end date!!!</b></font>";
				document.getElementById('startdatediv').innerHTML="";
		}
		else
		{	
			 var startdate 	= start_date.split('/');
			 startdate 	= new Date(startdate[2], startdate[1], startdate[0]); 
			 var enddate 	= end_date.split('/'); 
			 enddate 	= new Date(enddate[2], enddate[1], enddate[0]); 
			 if (startdate > enddate ) { 
			 	document.getElementById("start_date").value='';
				document.getElementById("end_date").value='';
				document.getElementById('enddatediv').innerHTML="<font color='red'><b>Start Date Cannot be greater than end date!!!</b></font>";
				document.getElementById('startdatediv').innerHTML="";
				return false; 
			} else {
				document.getElementById('startdatediv').innerHTML="";
				document.getElementById('enddatediv').innerHTML="";
			}
		}
}
			

</script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#rangeoffice').change(function()
				{
					var rangeoffice=$('#rangeoffice').val();
					$.post("<?php echo $site_url?>/Master/getUnitAjax/",{range_office:rangeoffice},function(data)
						{
							$('#unit').html(data);
						});
				});
});
function validate_chk(){			
     	checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
			if(checked<1) {
				document.getElementById('scnDiv').innerHTML="<font color='red'><b>Atleast one Section to be selected!!!</b></font>";
				return false;
			}
}
function showSection(val){
		var x = document.getElementById("unitname").selectedIndex;
		var y = document.getElementById("unitname").options;
		unit_name = y[x].text;
		//alert(unit_name);
	if(unit_name=="DIRECTORATE"){
		document.getElementById('section_id').style.display='';
	}else{
		document.getElementById('section_id').style.display='none';
	}
}
 

</script>
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Userposting</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><a href="<?php echo site_url("Master/userposting"); ?>"> Userposting</a></li>
        <li><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Userposting </strong></a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-9">
          <!-- /.box -->
        <div class="box" >
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		  
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title"><?php
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Userposting </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Master/userpost_edit", $attributes);
		} else {
		echo form_open("Master/userposting_add", $attributes);
			
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
              <table id="vacbtable" class="table table-bordered table-striped">

      
        <tr >
  
      		<td>User<font color="#FF0000">*</font></td>
      		<td>
           <select name="user" id="user"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php 
			
			
			
			foreach($user as $user_get){?>
               <option value="<?php  echo $user_get['int_user_sl'];?>"
			    <?php if(isset($get_userposting_details[0]['int_userpost_user_sl'])){
				
			 			if($get_userposting_details[0]['int_userpost_user_sl']==$user_get['int_user_sl']){
						?> selected="selected"<?php  } } else { if($user_get['int_user_sl']== set_value('user')){ echo "selected='selected' ";}  }?>
		>
			 <?php  echo $user_get['vch_user_fullname'];?></option>
             <?php } ?>
           </select> 
            
            
            
            
            </td>
      	</tr>
       
      	      <tr >
  
      		<td>Designation<font color="#FF0000">*</font></td>
      		<td>
           <select name="designation" id="designation"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($designation as $designation_get){?>
               <option value="<?php  echo $designation_get['int_designation_sl'];?>" <?php if(isset($get_userposting_details[0]['int_userpost_designation_sl'])){
			   if($get_userposting_details[0]['int_userpost_designation_sl']==$designation_get['int_designation_sl']){?> selected="selected"<?php  } }else { if($designation_get['int_designation_sl']== set_value('designation')){ echo "selected='selected' ";}  }?>><?php  echo $designation_get['vch_designation_name'];?></option>
             <?php } ?>
           </select> 
            
            </td>
      	</tr>
       
		  <tr >
  
      		<td>User group<font color="#FF0000">*</font></td>
      		<td>
           <select name="usergroup" id="usergroup"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($user_group as $usergroup_get){?>
               <option value="<?php  echo $usergroup_get['int_usergroup_sl'];?>" 
			   <?php if(isset($get_userposting_details[0]['int_userpost_usergroup_sl'])){
			   if($get_userposting_details[0]['int_userpost_usergroup_sl']==$usergroup_get['int_usergroup_sl']){?> selected="selected"<?php } }
			   else { 
			   if($usergroup_get['int_usergroup_sl']== set_value('usergroup')){ echo "selected='selected' ";}  }?>><?php  echo $usergroup_get['vch_usergroup_name'];?></option>
             <?php } ?>
           </select> 
            
            
            
            
            </td>
      	</tr>
       
		    <tr >
  
      		<td>Range office <font color="#FF0000">*</font></td>
      		<td>
            <select name="rangeoffice" id="rangeoffice"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($rangeoffice as $range){?>
               <option value="<?php  echo $range['int_rangeoffice_sl'];?>" <?php if(isset($get_userposting_details[0]['int_userpost_rangeoffice_sl'])){
			   if($get_userposting_details[0]['int_userpost_rangeoffice_sl']==$range['int_rangeoffice_sl']){?> selected="selected"<?php  } }else { if($range['int_rangeoffice_sl']== set_value('rangeoffice')){ echo "selected='selected' ";}  }?>><?php  echo $range['vch_rangeoffice_name'];?></option>
             <?php } ?>
           </select> 
            
            
            
            
            </td>
      	</tr>
		
		 <tr >
  
      		<td>Unit<font color="#FF0000">*</font></td>
      		<td>
            <select name="unitname" id="unitname"   class="form-control" <?php //if(!isset($int_userpost_sl)){?> onchange="showSection(this.value);" <?php//  } ?>>
           	 <option value="">SELECT</option>
           	<?php foreach($unit as $get_unit){?>
               <option value="<?php   echo $get_unit['int_unit_sl'];?>" <?php if(isset($get_userposting_details[0]['int_userpost_unit_sl'])){
			  if($get_userposting_details[0]['int_userpost_unit_sl']==$get_unit['int_unit_sl']){?> selected="selected"<?php  } }else { if($get_unit['int_unit_sl']== set_value('unitname')){ echo "selected='selected' ";}  }?>><?php  echo $get_unit['vch_unit_name'];?></option>
             <?php  } ?>
           </select>
            </td>
      	</tr>
		
		
		
		<?php 
	
		 if(@$unitname=="DIRECTORATE"){?>

      		<tr id="section_id"> <td width="30%" >Section<font color="#FF0000">*</font></td>
                    <td width="43%">
                    <?php 
					if(isset($get_userposting_details[0]['int_userpost_section_sl'])){
						$cas_section	=	$get_userposting_details[0]['int_userpost_section_sl'];
						$cas_section_list	=	explode(",",$cas_section);
					}
					$i=0;
					foreach($get_section as $section){?>
                    <input type="checkbox" id="chkbx" name="chkbx[<?php echo $i;?>]" value="<?php echo $section['int_section_sl'];?>" 	
						<?php if(isset($cas_section_list)){
						if (in_array($section['int_section_sl'], $cas_section_list)){?> 
						checked 
						<?php }}else { echo set_checkbox('chkbx[]', $section['int_section_sl']);  } ?> onclick="document.getElementById('scnDiv').innerHTML=''"/>&nbsp;<?php echo $section['vch_section_name'];?><br/>
                    <?php $i++;}  ?>
					<span id="scnDiv" ></span>
                    </td>
					</tr>
<?php }else{ ?>
<tr id="section_id"  style="display:none"> 
<td width="30%" >Section<font color="#FF0000">*</font></td>
                    <td width="43%">
                    <?php 
					
					$i=0;
					foreach($get_section as $section){?>
                    <input type="checkbox" id="chkbx" name="chkbx[<?php echo $i;?>]" value="<?php echo $section['int_section_sl'];?>" 	
						<?php if(isset($cas_section_list)){
						if (in_array($section['int_section_sl'], $cas_section_list)){?> 
						checked 
						<?php }}else { echo set_checkbox('chkbx[]', $section['int_section_sl']);  } ?> onclick="document.getElementById('scnDiv').innerHTML=''"/>&nbsp;<?php echo $section['vch_section_name'];?><br/>
                    <?php $i++;}  ?>
					<span id="scnDiv" ></span>
                    </td>
      	</tr>
		<?php
		}
		?>
		 <tr >
  
      		<td>Start date<font color="#FF0000">*</font></td>
      		<td>
         <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
				  <?php
				  if(isset( $get_userposting_details[0]['dte_userpost_startdate'])){
				$dte_userpost_startdate = $get_userposting_details[0]['dte_userpost_startdate'];
					$start_date = explode('-', $dte_userpost_startdate);
					$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];
				  }

					$start_date = set_value('start_date') == true ?  set_value('start_date'): @$start_date ; 
				  														
				  ?>
                <input type="text" class="form-control"  value="<?php echo @$start_date?>" name="start_date" id="start_date" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask>
              </div>
            
					<span id="startdatediv" ></span>
            
            </td>
      	</tr>
		<tr >
  
      		<td>End date<font color="#FF0000">*</font></td>
      		<td>
           <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
				   <?php
				    if(isset( $get_userposting_details[0]['dte_userpost_enddate'])){
				$dte_userpost_enddate = $get_userposting_details[0]['dte_userpost_enddate'];
					$end_date = explode('-', $dte_userpost_enddate);
					$end_date =$end_date[2]."-".$end_date[1]."-".$end_date[0];
				  }
				
					 $end_date = set_value('end_date') == true ?  set_value('end_date'): @$end_date ;
				  														
				  ?>
				 
                  <input type="text" class="form-control" name="end_date"  value="<?php echo @$end_date?>" id="end_date" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask 
				  onChange="check_dates();">
                </div>
            
					<span id="enddatediv" ></span>
            
            </td>
      	</tr>
		
	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
        </div>
        </div>
		

    
          
              
		   <?php echo form_close(); ?>
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  </section>
 <script>
  $(function () {
    //Initialize Select2 Elements
   // $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();


  });
</script>