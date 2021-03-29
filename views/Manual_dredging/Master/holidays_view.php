<script>
$(document).ready(function(){
	$(function($) {
		// this script needs to be loaded on every page where an ajax POST may happen
		$.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
	});
    $('[data-toggle="popover"]').popover(); 
});
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
	/*padding: 0px 0 0 20px!important;*/
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


    <?php //if($_ci_view =='Master/holidays_view'){ //-----   commented on 17/12/2019
		?>
    	<!--Pop-up-->
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!--    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    -->	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/calendar.css"/>
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/pop-up.css"/>
    <?php //} ?>
	
	<!-- page header-->
	<div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">View Holidays</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> Home</a></li>
		 <li class="breadcrumb-item"><a href="#"> Holiday Setting</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>View Holidays</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
	
	
	        <div class="col-md-12" style="overflow-x: scroll;">
          <!-- /.box -->
        <div class="box" >
        
      <!--      </div> -->
		  
            
        <div  style="min-height: 615px;"> <!-- class="box box-primary box-blue-bottom calender-bg"-->
            <div class="box-header ">
              <h1 class="box-title holy-title" style=""><?php
			
			   if(isset($period_name)){ ?>Holidays <?php echo $period_name; ?> <?php } ?></h1>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
				<?php
                	//echo $start_date;//='2017-08-01';
					//$end_date='2017-08-30';
					
					//"2017-".."-01"
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
					
					//echo "wewew".$zone_id;
					//$list_holidays=$this->Master_model->get_holidaylist_by_periodname($port_id,$period_name);
					$list_holidays=$this->Master_model->get_holidaylist_by_periodnamenew($port_id,$zone_id,$period_name);
					//echo '<pre>qweqw';print_r($list_holidays);exit;
					if(count($list_holidays)>0){
						foreach($list_holidays as $holiday){
							$holiday_date=$holiday['holiday_date'];
							if($holiday_date!='' || $holiday_date!=0){
								array_push($holidayArr,$holiday_date);
							}
						}
					}
					$attributes = array("class" => "form-horizontal", "id" => "holidays_add", "name" => "holidays_add");?>
						
					<?php //echo '<pre>';print_r($holidayArr);exit;
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
													$dateArray.='<li style="font-weight: bold;">'.(($i+1)-$dayofweek).'<ol><li id="li_content'.(($i+1)-$dayofweek).'"></li></ol>';
												}else{
														$pos = array_search($dateValue,$holidayArr);
														$holiday_det=$list_holidays[$pos];
														$holiday_reason=$holiday_det['holiday_reason'];
														if($holiday_det['holiday_status']==1 && $holiday_det['holiday_reserve_status']==0){
															$dateArray.='<li style="color: #f4f4f4; background-color: crimson!important;background:none;"><strong>'.(($i+1)-$dayofweek).'</strong><ol><li class="holy" style="color: #f4f4f4;">'.$holiday_reason.'</li></ol></li>';
														}
														else if($holiday_det['holiday_reserve_status']==1 && $holiday_det['holiday_status']==0){
															$dateArray.='<li style="background-color: limegreen!important;color: #f4f4f4;background:none;"><strong>'.(($i+1)-$dayofweek).'</strong><ol><li class="reserv" style="color: #f4f4f4;">Reserved Day</li></ol></li>';
														}
													
													
													
												}
										}
										
									}
									$dateArray.='
											</ul>
										</li>
									</ol>';
							
								echo $dateArray;


								
                
                 ?>
            	<div class="col-md-12" style="text-align:center">
                 <input type="hidden" id="resulttype" name="resulttype" value="">
                 	<?php 	echo form_open("Manual_dredging/Master/holidaysettings",$attributes);
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
  
  