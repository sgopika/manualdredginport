<?php
//print_r($_REQUEST);
?>
<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>
<script>
$(document).ready(function()
{
	port_id='<?php echo $port_id ?>';
	period_name='<?php echo $period_name ?>';
	
	$.post("<?php echo $site_url?>/Master/createDateRangeArrApprovedEdit",{port_id:port_id,period_name:period_name},function(data)
		{	
			$('#daterangearray').html(data);
		});
});
</script>
<script>
	function displayCommentBox(idDate){
		//alert($('#checkbx1:checkbox:checked').length);
		/*if($('#checkbx'+idDate).is(":checked")==true){
			$('#textbx'+idDate).css('display','block');
		}
		if($('#checkbx'+idDate).is(":checked")==false){
			$('#textbx'+idDate).css('display','none');
		}*/
		$('#textbx'+idDate).css('display','block');
		$('#textbx'+idDate).prop('required', 'true');
		$('#textbx'+idDate).removeAttr('disabled');
	}
	function hideCommentBox(idDate){
		$('#textbx'+idDate).css('display','none');
		$('#textbx'+idDate).prop('disabled', 'true');
		$('#textbx'+idDate).removeAttr('required');
	}

</script>
    
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($period_name)){?>Edit<?php } ?>
         <strong>Holiday Settings </strong> </button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><a href="<?php echo site_url("Master/holidays_approved_edit"); ?>"><strong>Holiday Settings </strong></a></li>
        <li><a href="#"><strong><?php if(isset($period_name)){?>Edit<?php }?></strong></a><a href="<?php echo site_url("Master/holidays_approved_edit"); ?>"><strong>Holidays </strong></a></li>
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
			
			   if(isset($period_name)){?>Edit<?php }?>
              <a href="<?php echo site_url("Master/holidays_approved_edit"); ?>"><strong>Holiday</strong></a></h3>
            </div>
            <!--<h5 style="margin-left:20px;color:red" class="box-title">Only Reserve Day Settings is avilable after Monthly Permit is Approved for the Curresponding Holidays</h5>-->
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($period_name)){
        $attributes = array("class" => "form-horizontal", "id" => "holidays_approved_edit", "name" => "holidays_approved_edit");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "holidays_approved_edit", "name" => "holidays_approved_edit");
			}
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($period_name)){
       		echo form_open("Master/holidays_approved_edit", $attributes);
		} else {
			echo form_open("Master/holidays_approved_edit", $attributes);
		}?>
		<input type="hidden" name="period_name" value="<?php if(isset($period_name)){ echo $period_name;} ?>" />
        <input type="hidden" name="port_id" value="<?php if(isset($port_id)){ echo $port_id;} ?>" />
		<table id="vacbtable" class="table table-bordered table-striped">
      
        <tr >
  
      		<td>Select Period<font color="#FF0000">*</font></td>
      		<td>From 
         		<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                <input readonly type="text" class="form-control"  value="<?php echo $start_date?>" name="start_date" id="start_date" >
              </div>
				<span id="startdatediv" ></span>
                To <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
				   
                  <input readonly type="text" class="form-control" name="end_date"  value="<?php echo $end_date?>" id="end_date">
                </div>
				<span id="enddatediv" ></span>
            
            </td>
      	</tr>
		<tr >
        
       <tr id="daterangearrayRow">
      		<td>Check halidays <font color="#FF0000">*</font></td>
            <td id="daterangearray"></td>
       </tr> 
	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($period_name)){echo $period_name;}?>" />
		<?php if(isset($period_name)){?>
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
  