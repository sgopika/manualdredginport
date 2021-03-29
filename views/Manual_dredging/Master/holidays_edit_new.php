<script>
$(document).ready(function(){
	$(function($) {
		// this script needs to be loaded on every page where an ajax POST may happen
		$.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
		 $('[data-toggle="popover"]').popover(); 
	});
   });

</script>
 <script src=<?php echo base_url("plugins/js/jquery.validate.min.js");?>></script>
<script>
/*$(document).ready(function(){
	//alert("sss");
	$('.removeholiday').click(function(){
		var valuebtn=$('.removeholiday').attr('id');
		holy_date=$('#holy_date'+valuebtn).val();
		day_type=5;
	
		period_name='<?php echo $period_name ?>';
		port_id='<?php echo $port_id ?>';
		$.post("<?php echo $site_url?>/Manual_dredging/Master/RemoveReserveDay_Ajax",{day_type:day_type,period_name:period_name,holy_date:holy_date,port_id:port_id},function(data)
		{
			
			var result	= data.split('#');
			
			$('#resulttype').val(result[0]);
			alert(result[1]);
			if(result[0]==1){}
		});
	
	});	
});*/
</script>

<style>

li li {
    /*width: 9em!important;*/
	width: 13%!important;
    background: url(images/day-bg.png) bottom right no-repeat;
	/*background: palegoldenrod!important;*/
	border-radius: 0px 0px 17px 0px;
	overflow: visible!important;
	height:3.95em!important;
	/*border: 3px solid #d2d6de!important;*/
	box-shadow: 0 3px 2px #a5968e;
}
.pop-my-class{
	margin: -19px 0 0 14px!important;	
}
li li ul li {
	border-radius: 0px 0px 17px 0px;
	border: 0px!important;	
	box-shadow: none;
}
li li ol li{
	border-radius:0px;
	border: 0px!important;
	box-shadow: none;
	width: auto!important;	
}
/* Calender Styles */
ol.calendar {
   /* width: 68em!important;*/
   width:85%!important;
    /*background: none!important;*/
	padding: 0px 0 0 20px!important;
}
.calender-bg {
    /*background: cadetblue!important;*/
	background: #dadee4!important;
}
li#lastmonth li, li#nextmonth li {
   /* background: darkcyan!important;*/
	background: #3c8dbc!important;
	/*padding: 35px 0px 0px 44px;*/
	padding: 22px 0px 0px 39px;
	text-shadow: 0 3px 3px #423d3d;
	/*background: darkgray;
	background: darkturquoise;*/
}
.custom-inner {
    padding-top: 0px; 
}
.content {
	padding-top: 0px; 
}


/* Pop Up styles */
.box-header {
    padding: 0px!important;
    /* padding-top: 25px; */
}
.ui-radio input {
	width:15px;
}
.ui-page-theme-a .ui-btn{
	/*background-color: #f6f6f6;
    border-color: #ddd;
    color: #333;
    text-shadow: 0 1px 0 #f3f3f3;
    margin-left: 34px;*/
	/*background-color: palegoldenrod!important;
    border-color: palegoldenrod!important;*/
	background-color: transparent!important;
    border-color: transparent!important;
    color: #333;
    text-shadow: 0 1px 0 #f3f3f3;
    margin-left: 15px;
	margin: 0;	
	
}
.ui-btn-inline {
/*    display: inline-block;
    vertical-align: middle;
*/    margin-right: 0px!important;
}
.ui-btn {
    font-size: 16px;
    /* margin: .5em 0; */
    padding: 0.9em 0em;
}
.ui-radio input{
	width:15px!important;
}
.ui-radio {
	float:left;	
}
.ui-popup.ui-content, .ui-popup .ui-content {
    min-width: 300px!important;
	background: #f7f5f5!important;
}
.ui-overlay-a,.ui-page-theme-a,.ui-page-theme-a .ui-panel-wrapper {
  /*background-color: #f9f9f9;
  border-color: #bbb;
  color: #333;*/
  text-shadow: none; 
}
.ui-popup.ui-body-inherit {
    border-width: 3px;
    border-style: solid;
    background: #fbfbf8;
    padding: 22px 15px 12px 23px;
    border-radius: 12px;
}
.reserv{
	color:green;
	font-weight:600;
	/*padding:14px 0px 0px 16px;*/
	padding:0px 0px 0px 16px;
	/*font-size:small;*/
	
}
.holy{
	color:red;
	font-weight:600;
	/*padding-top:14px;*/
	padding-top:3px;
	text-transform: capitalize;
}
.holy-title{
	color: #dd4b39!important;
    font-weight: 800;
    text-shadow: 2px 0px 4px #867b7b;
	text-align: center;
	font-size: x-large;
	width: 100%;
	margin-top:7px!important;
	/*color: #059!important;*/
	padding-bottom: 5px;
	font-size: 24px!important;
}
</style>

 <script>
function displayTextbox(texbxid){
	$(texbxid).css("display","block");
	
}
function displayCommentBox(idDate){
	
	$('#textbx'+idDate).css('display','block');
	$('#textbx'+idDate).prop('required', 'true');
	$('#textbx'+idDate).removeAttr('disabled');
}
function hideCommentBox(idDate){
	$('#textbx'+idDate).css('display','none');
	$('#textbx'+idDate).prop('disabled', 'true');
	$('#textbx'+idDate).removeAttr('required');
}
function closePopup(id){
	holy_date=$('#holy_date'+id).val();
	radbtval=$('input[name=date'+id+']:checked').val();
	//alert(radbtval);
	if(radbtval==0){
		$("#myPopupDiv"+id).popup( "close");
	}else{
		if(radbtval==1){
			$('#textbx'+id).prop('required', 'true');
			holyreason=$('#textbx'+id).val();
			if(holyreason==''){
				
				alert('Please Enter The Reason For Holiday');exit;	
			}
			/*else{
				//$('#li_content'+id).addClass("holy");
				//$('#li_content'+id).css({'color':'red'},{'font-weight': '600'});
				//$('#test_div').css();
				//$('#li_content'+id).html(holyreason);
			}*/
		}else if(radbtval==2){
			holyreason=null;
			//$('#li_content'+id).addClass("reserv");
			//$('#li_content'+id).css({'color':'green'},{'font-weight': '600'},{'padding': '14px 0px 0px 16px'},{'font-size': 'small'});
			//$('#test_div').css();
			//$('#li_content'+id).html("Reserved Day");
		}
		period_name='<?php echo $period_name ?>';
		port_id='<?php echo $port_id ?>';
		zone_id='<?php echo $zone_id ?>';
		$.post("<?php echo $site_url?>/Manual_dredging/Master/holidays_add_Ajax",{type_id:radbtval,period_name:period_name,holy_date:holy_date,holyreason:holyreason,port_id:port_id,zone_id:zone_id},function(data)
		{
			var result	= data.split('#');
			//alert(result[0]);
			$('#resulttype').val(result[0]);
			alert(result[1]);
			if(result[0]==1){
				if(radbtval==1){
					$('#li_content'+id).addClass("holy");
					$('#li_content'+id).html(holyreason);
				}else if(radbtval==2){
					$('#li_content'+id).addClass("reserv");
					$('#li_content'+id).html("Reserved Day");
				}
			}
		});
		$("#myPopupDiv"+id).popup( "close");
		//$("#popup"+id).css( "display","none");
	}
}
function RemoveReserveDay(id){
	holy_date=$('#holy_date'+id).val();
	day_type=4;
	//alert(holy_date);
	//type_id=$('#day_type'+id).val();
	period_name='<?php echo $period_name ?>';
		port_id='<?php echo $port_id ?>';
		$.post("<?php echo $site_url?>/Manual_dredging/Master/RemoveReserveDay_Ajax",{day_type:day_type,period_name:period_name,holy_date:holy_date,port_id:port_id},function(data)
		{
			
			var result	= data.split('#');
			//alert(result[0]);
			$('#resulttype').val(result[0]);
			alert(result[1]);
			if(result[0]==1){/*
				if(radbtval==1){
					$('#li_content'+id).addClass("holy");
					$('#li_content'+id).html(holyreason);
				}else if(radbtval==2){
					$('#li_content'+id).addClass("reserv");
					$('#li_content'+id).html("Reserved Day");
				}
			*/}
			window.location.reload();
		});
		//$("#myPopupDiv"+id).popup( "close");	
		
			
}


function RemoveHoliday(id){
	holy_date=$('#holy_date'+id).val();
	day_type=5;
	//alert(holy_date);
	//type_id=$('#day_type'+id).val();
	period_name='<?php echo $period_name ?>';
		port_id='<?php echo $port_id ?>';
		$.post("<?php echo $site_url?>/Manual_dredging/Master/RemoveReserveDay_Ajax",{day_type:day_type,period_name:period_name,holy_date:holy_date,port_id:port_id},function(data)
		{
			
			var result	= data.split('#');
			//alert(result[0]);
			$('#resulttype').val(result[0]);
			alert(result[1]);
			if(result[0]==1){/*
				if(radbtval==1){
					$('#li_content'+id).addClass("holy");
					$('#li_content'+id).html(holyreason);
				}else if(radbtval==2){
					$('#li_content'+id).addClass("reserv");
					$('#li_content'+id).html("Reserved Day");
				}
			*/}
			window.location.reload();
		});
		//$("#myPopupDiv"+id).popup( "close");	
		
			
}
</script>

<script>
function submitForm(){
	//window.location.reload();
  	//$("#btn_add").val("Save");
	document.getElementById("holidays_add").submit();
	//window.location = "http://localhost/portf/index.php/Master/holidaysettings";
	
}
function gotoHome(url){
	//document.getElementById("holidays_add").submit();
	//document.getElementsByClassName("fa fa-dashboard").click();
	base_url = url;
	window.location = base_url;
	//alert(base_url);
	
}
function popupClose(id){
	$("#myPopupDiv"+id).popup( "close");
	//window.location.reload();	
	
}
</script>
	<!--Pop-up-->
   <script src="<?php echo base_url() ?>/plugins/js/jquery-1.11.3.min.js"></script>
<!--    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
-->	
<script src="<?php echo base_url() ?>/plugins/js/jquery.mobile-1.4.5.min.js"></script>
	<?php if($_ci_view=='Manual_dredging/Master/holidays_edit_new'){ ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/css/calendar.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pop-up.css"/>
    <?php } ?>
    <div class="container-fluid ui-innerpage">
 
    <div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Holiday Settings</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Holiday Edit</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
      	 <div class="col-md-12" style="text-align:center">
                 <input type="hidden" id="resulttype" name="resulttype" value="">
                 	<?php 	
					$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	} ?>
                     <input style="width: 120px;margin: 15px 0px 8px 0px;" id="btn_add" name="btn_add" type="button" onClick="submitForm()" class="btn btn-primary" value="Back"/>
                     <input style="width: 120px;margin: 15px 0px 8px 0px;" id="btn_add" name="btn_add" type="button" onClick="gotoHome(<?php echo $url; ?>)" class="btn btn-primary" value="Home"/>
                     <?php echo form_close(); ?>
                 </div>
        <!--<div class="col-md-9">-->
        <div class="col-md-12" style="overflow-x: scroll;">
          <!-- /.box -->
        <div class="box" >
        
      <!--      </div> -->
		  
            
        <div class="box box-primary box-blue-bottom calender-bg" style="min-height: 630px;">
            <div class="box-header ">
              <h1 class="box-title holy-title" style=""><?php
			
			   if(isset($period_name)){ ?>Holidays <?php echo $period_name; ?> <?php } ?></h1>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
				<?php
                	//$start_date='2017-08-01';
					//$end_date='2017-08-30';
					
					
					$format = 'Y-m-d';
					$start_date = explode('/', $start_date);
					$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];
					$end_date = explode('/', $end_date);
					$end_date =$end_date[2]."-".$end_date[1]."-".$end_date[0];
					$start  = new DateTime($start_date);
					$end    = new DateTime($end_date);
					$invert = $start > $end;
					
					
					$dayofweek = date('w', strtotime($start_date))+1;
					$last_day=date('t', strtotime($end_date));
					$momth_name= date("F", strtotime($start_date));
					//echo $momth_name;break;
					//$start  = new DateTime($start_date);
					//$end    = new DateTime($end_date);
				
					$dates = array();
					$holidayArr=array();
					$dates[] = $start->format($format);
					while ($start != $end) {
						$start->modify(($invert ? '-' : '+') . '1 day');
						$dates[] = $start->format($format);
					}
					
					$list_holidays=$this->Master_model->get_holidaylist_by_periodnamenew($port_id,$zone_id,$period_name);
					//echo '<pre>';print_r($list_holidays);exit;
					if(count($list_holidays)>0){
						foreach($list_holidays as $holiday){
							$holiday_date=$holiday['holiday_date'];
							if($holiday_date!='' || $holiday_date!=0){
								array_push($holidayArr,$holiday_date);
							}
						}
					}
			$attributes = array("class" => "form-horizontal", "id" => "holidays_add", "name" => "holidays_add");
		
			?>
						
					<?php //echo '<pre>';print_r($dayofweek);exit;
					$dateArray='
					
							<ol class="calendar" start="6">
								<li id="lastmonth">
									<ul start="29">
										<li style="color: red;">SUN</li>
										<li style="color: white;">MON</li>
										<li style="color: white;">TUE</li>
										<li style="color: white;">WED</li>
										<li style="color: white;">THU</li>
										<li style="color: white;">FRI</li>
										<li style="color: white;">SAT</li>
									</ul>
								</li>
								<li id="thismonth">
									<ul>';
									for($i=1;$i<count($dates)+$dayofweek;$i++){
										
										@$dateValue=$dates[$i-$dayofweek];
										
										if($i<($dayofweek))
											$dateArray.='<li></li>';
										else{
												if(in_array($dateValue,$holidayArr)!=1){
													$dateArray.='<li>'.(($i+1)-$dayofweek).'<ol><li id="li_content'.(($i+1)-$dayofweek).'"><input type="hidden" id="holy_date'.(($i+1)-$dayofweek).'" value="'.$dateValue.'">
													<a id="popup'.(($i+1)-$dayofweek).'" href="#myPopupDiv'.(($i+1)-$dayofweek).'" data-rel="popup" class="ui-btn ui-btn-inline ui-corner-all ui-icon-check ui-btn-icon-left pop-my-class">Add</a>
													<div data-role="popup" id="myPopupDiv'.(($i+1)-$dayofweek).'" class="ui-content" style="min-width:250px;">
														<input type="radio" id="radiobx'.(($i+1)-$dayofweek).'" name="date'.(($i+1)-$dayofweek).'"  onClick="displayCommentBox('.(($i+1)-$dayofweek).')" value="1" autocomplete="off" /><span style="    margin-left: 35px;color: red;font-weight: 800;">Holiday</span>
														<input type="radio" id="radiobx'.(($i+1)-$dayofweek).'" name="date'.(($i+1)-$dayofweek).'"  onClick="hideCommentBox('.(($i+1)-$dayofweek).')" value="2" autocomplete="off" /><span style=" margin-left: 35px;color: lightgreen;font-weight: 800;">Reserve day</span>
														<input onClick="popupClose('.(($i+1)-$dayofweek).')" type="radio" id="radiobx'.(($i+1)-$dayofweek).'" name="date'.(($i+1)-$dayofweek).'" onClick="hideCommentBox('.(($i+1)-$dayofweek).')"  value="0" /><span style="    margin-left: 35px;color: darkgrey;font-weight: 800;">Cancel</span></p>
														<input class="form-control" style="display:none;margin-bottom: 10px;" type="textbox" id="textbx'.(($i+1)-$dayofweek).'" name="reason'.(($i+1)-$dayofweek).'" disabled value="" placeholder="Reason for the holiday on '.$dateValue.'" >
														<input onClick="closePopup('.(($i+1)-$dayofweek).')" style="background-color: #f6f6f6;border-color: #ddd;color:#777;text-shadow: 0 1px 0 #f3f3f3;border-radius: .3125em;padding: 2px 10px 2px 10px!important;box-shadow: 0 2px 3px #a09595;font-weight: 700;" type="button" data-inline="true" value="Save"></div>
													
													</li></ol>';
												}else{
														$pos = array_search($dateValue,$holidayArr);
														$holiday_det=$list_holidays[$pos];
														$holiday_reason=$holiday_det['holiday_reason'];
														if($holiday_det['holiday_status']==1 && $holiday_det['holiday_reserve_status']==0){
															//$dateArray.='<li style="color: red;"><strong>'.(($i+1)-$dayofweek).'</strong><ol><li class="holy">'.$holiday_reason.'</li></ol></li>';
															
															$dateArray.='<li style="color: red;">'.(($i+1)-$dayofweek).'<ol><li style="margin: -24px 0px 0px 24px;" class="holy">'.$holiday_reason.'</li><li id="li_content'.(($i+1)-$dayofweek).'" style="margin: -8px 0px 0px 8px;"><input type="hidden" id="holy_date'.(($i+1)-$dayofweek).'" value="'.$dateValue.'">
													<a style="    margin-left: -10px!important;" id="popup'.(($i+1)-$dayofweek).'" href="#myPopupDiv'.(($i+1)-$dayofweek).'" data-rel="popup" class="ui-btn ui-btn-inline ui-corner-all ui-icon-check ui-btn-icon-left pop-my-class">Remove</a>
													<div data-role="popup" id="myPopupDiv'.(($i+1)-$dayofweek).'" class="ui-content" style="min-width:250px;">
														<input type="radio" id="radiobx'.(($i+1)-$dayofweek).'" name="date'.(($i+1)-$dayofweek).'"  onClick="displayCommentBox('.(($i+1)-$dayofweek).')" value="1" autocomplete="off" /><span style="    margin-left: 35px;color: red;font-weight: 800;">Remove Holiday</span>
														<input onClick="popupClose('.(($i+1)-$dayofweek).')" type="radio" id="radiobx'.(($i+1)-$dayofweek).'" name="date'.(($i+1)-$dayofweek).'" onClick="hideCommentBox('.(($i+1)-$dayofweek).')"  value="0" /><span style="    margin-left: 35px;color: darkgrey;font-weight: 800;">Cancel</span></p>
														<input  onClick="RemoveHoliday('.(($i+1)-$dayofweek).')" style="background-color: #f6f6f6;border-color: #ddd;color:#777;text-shadow: 0 1px 0 #f3f3f3;border-radius: .3125em;padding: 2px 10px 2px 10px!important;box-shadow: 0 2px 3px #a09595;font-weight: 700;" type="button" data-inline="true" value="Save"></div>
													
													</li></ol></li>';
															
															
														}
														else if($holiday_det['holiday_reserve_status']==1 && $holiday_det['holiday_status']==0){
															//$dateArray.='<li style="color: green;"><strong>'.(($i+1)-$dayofweek).'</strong><ol><li class="reserv">Reserved Day</li></ol></li>';
															$dateArray.='<li style="color: green;">'.(($i+1)-$dayofweek).'<ol><li style="margin: -24px 0px 0px 12px;" class="reserv">Reserved Day</li><li id="li_content'.(($i+1)-$dayofweek).'" style="margin: -8px 0px 0px 8px"><input type="hidden" id="holy_date'.(($i+1)-$dayofweek).'" value="'.$dateValue.'">
													<a style="    margin-left: -10px!important;" id="popup'.(($i+1)-$dayofweek).'" href="#myPopupDiv'.(($i+1)-$dayofweek).'" data-rel="popup" class="ui-btn ui-btn-inline ui-corner-all ui-icon-check ui-btn-icon-left pop-my-class">Remove</a>
													<div data-role="popup" id="myPopupDiv'.(($i+1)-$dayofweek).'" class="ui-content" style="min-width:250px;">
														<input type="radio" id="radiobx'.(($i+1)-$dayofweek).'" name="date'.(($i+1)-$dayofweek).'"  onClick="displayCommentBox('.(($i+1)-$dayofweek).')" value="1" autocomplete="off" /><span style="    margin-left: 35px;color: green;font-weight: 800;">Remove Reserve Day</span>
														<input onClick="popupClose('.(($i+1)-$dayofweek).')" type="radio" id="radiobx'.(($i+1)-$dayofweek).'" name="date'.(($i+1)-$dayofweek).'" onClick="hideCommentBox('.(($i+1)-$dayofweek).')"  value="0" /><span style="    margin-left: 35px;color: darkgrey;font-weight: 800;">Cancel</span></p>
														<input onClick="RemoveReserveDay('.(($i+1)-$dayofweek).')" style="background-color: #f6f6f6;border-color: #ddd;color:#777;text-shadow: 0 1px 0 #f3f3f3;border-radius: .3125em;padding: 2px 10px 2px 10px!important;box-shadow: 0 2px 3px #a09595;font-weight: 700;" type="button" data-inline="true" value="Save"></div>
													
													</li></ol></li>';
														}
													
													
													
												}
										}
										
									}
									$dateArray.='
											</ul>
										</li>
									</ol>';
							
								echo $dateArray;
                	echo form_open("Manual_dredging/Master/holidaysettings",$attributes);
                 ?>
                
            	
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
</div>
  