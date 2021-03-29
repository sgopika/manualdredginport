<?php  
$vessel_id 			=	$this->uri->segment(3);
$engineset 			=	$this->Survey_model->get_no_of_engineset_dynamic($vessel_id);
$data['engineset']	=	$engineset;

@$no_of_engineset=$engineset[0]['engine_count'];


$engine_details=$this->Survey_model->get_engine_details_dynamic($vessel_id);
$data['engine_details']	=	$engine_details;
//print_r($engine_details);
//$engine_sl= $key['engine_sl'];

 ?>

<style type="text/css">
	.ves_div2 {
		min-height: 60px;
		padding-top: 5px;
		background-color: #dee1e6;
		vertical-align: middle;
	}
	.ves_div1 {
		min-height: 60px;
		padding-top: 5px;
		background-color: #f4f4f4;
		vertical-align: middle;
	}
	.customtabs{
		min-height: 100%;
	}
</style>
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
<script language="javascript">
    
$(document).ready(function(){
  
	
	

	
	
	
//------------JQUERY END--------------------//	

});

function IsNumeric(e) 
{
	var unicode = e.charCode ? e.charCode : e.keyCode;
	if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
	{
	    return true;
	}
	else 
	{
	    window.alert("This field accepts only Numbers");
	    return false;
	}
}


function IsDecimal(e) 
{
	var unicode = e.charCode ? e.charCode : e.keyCode;
	if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58) || (unicode == 46 )) 
	{
	    return true;
	}
	else 
	{
	    window.alert("This field accepts only Numbers");
	    return false;
	}
} 
        
</script>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
<button type="button" class="btn bg-primary btn-flat margin"> Form 1 </button>
      <!-- Important; the following two ol class has to be kept, its not mistake -->
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?php echo $site_url."/Survey/SurveyHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
<li><a href="<?php echo $site_url."/Survey/InitialSurvey"?>"></i>  <span class="badge bg-blue"> Initial Survey DashBoard </span> </a></li>       
 <li><a href="#"></i>  <span class="badge bg-blue"> Form 1 </span> </a></li>
        <!--<li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li> -->
      </ol> </ol> 
      <!-- End of two ol -->
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Header Section ends here -->
    <!-- Main content -->
    <section class="content">
   <!-- Main Content starts here -->

     <div class="row custom-inner">
      <!-- start inner custom row -->

        <div class="col-md-12">
          <div class="box box-solid">
          <div class="box-header with-border">
              <h3 class="box-title" style="color: #00f">Form 3 </h3>
             
	<p> FORM No. 3  [ See Rule 6 (4) ]  Particulars to be furnished for Survey of  New Vessel or Vessels which are to be surveyed for the first time  <input type="hidden" name="stage_count" id="stage_count" value="<?php //echo $stage_count; ?>"> </p>
	</div> 

	<div class="box-body">
	<!-- Custom Tabs -->
	<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
	<li><a href="#tab_1" data-toggle="tab">Form 3 Details</a></li>
	</ul>
              
 
	<div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>
	<div class="tab-content customtabs">
                
              
               
  <!-- ____________________________ Form 3 Details ___________________________________________ -->




<div class="tab-pane active" id="tab_1">
<form name="form1" id="form1" method="post" class="form1"  action="<?php echo $site_url.'/Survey/Form3_details_entry/'.$vessel_id ?>" enctype="multipart/form-data" > 
<input type="hidden" name="no_of_engineset" id="no_of_engineset" value="<?php echo $no_of_engineset; ?>">
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<div class="col-md-12 col-lg-12" id="form3_details_div" style="padding-top: 1px;"> 



<?php 
$i=1;
if(!empty($label_control_details_head2))
{

foreach ($label_control_details_head2 as $key) {
	# code...
	$inarray 	=array(1,2,5,6,9,10,13,14,17,18,21,22,25,26,29,30);
	$style 		='ves_div2';

	if(in_array($i,$inarray,true))
	{
		$style='ves_div1';

	}


$value83='<div class="form-group">
		<input type="text" name="hull_year_of_built" value="" id="hull_year_of_built"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Year of Built of Hull"  data-validation="required number"/>
			</div>';
$value84='<div class="form-group">
			<input type="file" name="builder_certificate_document" id="builder_certificate_document">
			</div>';			

/*$value85='<div class="form-group">
			<input type="text" name="make_year" value="" id="make_year"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Year of Built of Engine"  data-validation="required number"/>
			</div>';			
$value86='<div class="form-group">
			<input type="file" name="test_certificate_upload" id="test_certificate_upload">
			</div>';
$value87='<div class="form-group">
			<input type="file" name="chainport_test_certificate" id="chainport_test_certificate">
			</div>';
$value88='<div class="form-group">
			<input type="file" name="chainstarboard_test_certificate" id="chainstarboard_test_certificate">
			</div>';*/

	 $label_id=$key['label_id'];
	$static_array=array(83,84,85,86,87,88);

	if(in_array($label_id,$static_array))
	{
		$g = "value".$label_id;
		$label_controls1= ${$g};

	}
	else
	{
		
		$label_controls1='';
	}
		
		if($i%2==1)
	{
		$label_name=$key['label_name'].$label_id;
		$label_control_type=$key['label_control_type'];

		if(in_array($label_id,$static_array))
	{
		$g = "value".$label_id;
		$label_controls2= ${$g};

	}
	else
	{
		
		$label_controls2='';
	}
		
		$j = 1;

	}

	else
	{
		$j = 0;
		if($label_control_type==2 || $key['label_control_type']==2)
		{
			$css_style = 'style="min-height: 80px; max-height: 80px;"';
		}	
		else
		{
			$css_style = 'style="min-height: 40px; max-height: 40px;"';
		}
?>


<!-- Copy the following based on database result -->

<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p><?php echo  $label_name; ?>   </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" <?php echo $css_style; ?> > 
	<?php echo $label_controls2; ?>
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>
<!-- Copy ends here based on database comparison -->
<!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p><?php echo  $key['label_name'].$key['label_id'];?>   </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 " <?php echo $css_style; ?>> 
	<?php  echo $label_controls1;  //echo $key['label_controls']; ?>
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>
<!-- Copy ends here based on database comparison -->
<?php
	}
?>
<?php 
$i++;
} // End of for each;

if($j == 1)
{
 ?>
 <!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p><?php echo  $label_name;?>   </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" <?php echo $css_style; ?> > 
	<?php echo $label_controls2; ?>
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>
<!-- Copy ends here based on database comparison -->
<!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p>  </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" <?php echo $css_style; ?> > 
	
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>


<?php
}
}
?>
			




	<?php 
	$i=1;
	if(!empty($label_control_details_head3))
	{

foreach ($label_control_details_head3 as $key) {
	# code...
	$inarray 	=array(1,2,5,6,9,10,13,14,17,18,21,22,25,26,29,30);
	$style 		='ves_div2';

	if(in_array($i,$inarray,true))
	{
		$style='ves_div1';

	}

			

$value85='<div class="form-group">
			<input type="text" name="make_year[]" value="" id="make_year"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Year of Built of Engine"  data-validation="required number"/>
			</div>';			
$value86='<div class="form-group">
			<input type="file" name="test_certificate_upload[]" id="test_certificate_upload">
			</div>';


	 $label_id=$key['label_id'];
	$static_array=array(83,84,85,86,87,88);

	if(in_array($label_id,$static_array))
	{
		$g = "value".$label_id;
		$label_controls1= ${$g};

	}
	else
	{
		
		$label_controls1='';
	}
		

 ?>


<!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	<?php //for($i=1;$i<=$no_of_engineset;$i++) { 
foreach($engine_details as $key1) {
		?><input type="hidden" name="hdn_engine_sl[]" value="<?php echo $key1['engine_sl']?>"> 
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 "> 
	<!--  Inside Label Div -->
	<p><?php echo  $key['label_name'].$key['label_id'];?>  </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 " <?php echo $css_style; ?>> 
	<?php  echo $label_controls1;  //echo $key['label_controls']; ?>
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	<?php
	}
?>
	<!-- End of one half of div -->
</div>
<!-- Copy ends here based on database comparison -->

<?php 
$i++;
} // End of for each;


}

?>
			

			<?php 
	$i=1;
	if(!empty($label_control_details_head4))
	{

foreach ($label_control_details_head4 as $key) {
	# code...
	$inarray 	=array(1,2,5,6,9,10,13,14,17,18,21,22,25,26,29,30);
	$style 		='ves_div2';

	if(in_array($i,$inarray,true))
	{
		$style='ves_div1';

	}



$value87='<div class="form-group">
			<input type="file" name="chainport_test_certificate" id="chainport_test_certificate">
			</div>';
$value88='<div class="form-group">
			<input type="file" name="chainstarboard_test_certificate" id="chainstarboard_test_certificate">
			</div>';

	 $label_id=$key['label_id'];
	$static_array=array(83,84,85,86,87,88);

	if(in_array($label_id,$static_array))
	{
		$g = "value".$label_id;
		$label_controls1= ${$g};

	}
	else
	{
		
		$label_controls1='';
	}
		
		if($i%2==1)
	{
		$label_name=$key['label_name'].$label_id;
		$label_control_type=$key['label_control_type'];

		if(in_array($label_id,$static_array))
	{
		$g = "value".$label_id;
		$label_controls2= ${$g};

	}
	else
	{
		
		$label_controls2='';
	}
		
		$j = 1;

	}

	else
	{
		$j = 0;
		if($label_control_type==2 || $key['label_control_type']==2)
		{
			$css_style = 'style="min-height: 80px; max-height: 80px;"';
		}	
		else
		{
			$css_style = 'style="min-height: 40px; max-height: 40px;"';
		}
?>


<!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p><?php echo  $label_name; ?>   </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" <?php echo $css_style; ?> > 
	<?php echo $label_controls2; ?>
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>
<!-- Copy ends here based on database comparison -->
<!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p><?php echo  $key['label_name'].$key['label_id'];?>   </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 " <?php echo $css_style; ?>> 
	<?php  echo $label_controls1;  //echo $key['label_controls']; ?>
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>
<!-- Copy ends here based on database comparison -->
<?php
	}
?>
<?php 
$i++;
} // End of for each;

if($j == 1)
{
 ?>
 <!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p><?php echo  $label_name;?>   </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" <?php echo $css_style; ?> > 
	<?php echo $label_controls2; ?>
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>
<!-- Copy ends here based on database comparison -->
<!-- Copy the following based on database result -->
<div class="col-lg-6 col-md-6 <?php echo $style; ?> " style="margin-left: -1%; margin-top: -1.55%">
	<!-- Inside of one half of div -->
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
	<!--  Inside Label Div -->
	<p>  </p>
	<!-- End of Label Div -->
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" <?php echo $css_style; ?> > 
	
	<!-- Inside Control Div -->
		</div>
	<!-- End of control div -->
	
	<!-- End of one half of div -->
</div>


<?php
}
}
?>
			
			

	
			   
			    
				<div class="col-md-12 ves_div2"> <div class="col-md-1 pull-right">
					<input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Save"> </div>
				</div><!-- end of button div -->
       </div> <!-- End of form3_details_div -->
	</form>  

</div>



 <!-- /. end of tab-pane 1-->




            
            </div>
                      <?php
                     
					//echo form_close();
					?>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     </div>
     <!-- End of Row Custom-Inner -->
  <!-- Main Content Ends here -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

