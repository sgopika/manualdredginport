<?php
//print_r($_REQUEST);
?>

  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
      <script src=<?php echo base_url("assets/datepicker-bootsrap/js/bootstrap-datepicker.js");?>></script>
      <script type="text/javascript">
	$(document).ready(function() {
		jQuery.validator.addMethod("no_special_check", function(value, element) {
        	return this.optional(element) || /^[a-zA-Z0-9\s.-]+$/.test(value);
		});
		jQuery.validator.addMethod("name_check", function(value, element) {
        	return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
		});
		jQuery.validator.addMethod("act_check",function (value,element)    {
			return this.optional(element)||/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s]+$/.test(value);
		});
		jQuery.validator.addMethod("address_check",function (value,element)    {
			return this.optional(element)||/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s\,]+$/.test(value);
		});
		jQuery.validator.addMethod("email_check", function(value, element)	 {
			  return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
		});
  		$("#addlsgd").validate({
		rules: {
				int_lsgd_port: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_lsgd_dist: {
					required: true,
					maxlength: 20,
				},
				int_lsgd_name: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_lsgd_name_mal: {
					required: true,
					maxlength: 20,
				},
				vch_lsgd_adrs: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				vch_lsgd_phone: {
					required: true,
					number:true,
					minlength: 10,
					maxlength: 10,
				},
		},
		messages: {
				int_lsgd_port: {
					required: "<font color='#FF0000'> Port required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsgd_dist: {
					required: "<font color='#FF0000'> Lsgd Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsgd_name: {
					required: "<font color='#FF0000'> Lsgd Name required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsgd_name_mal: {
					required: "<font color='#FF0000'> Lasgd Unicode Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_lsgd_adrs: {
					required: "<font color='#FF0000'> Address required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_lsgd_phone: {
					required: "<font color='#FF0000'> Phone Number Required!!</font>",
					number:"<font color='#FF0000'> Numbers Only!!</font>",
					minlength:  "<font color='#FF0000'> 10 characters needed!!</font>",
					maxlength:"<font color='#FF0000'> Only 10 characters Allowed!!</font>",
				},
		},
    	errorElement: "span",
        errorPlacement: function(error, element) {
                error.appendTo(element.parent());
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
<script type="text/javascript">
$(document).ready(function()
{
	$('#portdc').change(function()
	{
					//alert("hello");
		var port_id=$('#portdc').val();
					//var period =$('#periodb').val();
		$.post("<?php echo $site_url?>/Manual_dredging/Port/getzone/",{port_id:port_id},function(data)
	 	{
							//alert("hello");
				$('#zonedc').html(data);
		});
	});
	$('#btn_add').click(function()
	{
					//alert("hello");
		var port_id=$('#portdc').val();
		//var zone_id=$('#zonedc').val();
		//var m_p=$('#mn_pr').val();
		//var t_date=$('#to_date').val();
					//var period =$('#periodb').val();
		$.post("<?php echo $site_url?>/Manual_dredging/Port/get_cus_pd/",{port_id:port_id},function(data)
	 	{
							//alert("hello");
				$('#cus_buk_det').html(data);
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
<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Customer Registration Details</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_dir_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Customer Registration Details</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 


        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
     
            <?php 
			
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addlsgd", "name" => "userposting", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addlsgd", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		
		$i=0;
		foreach($port as $prt)
			{
				
				if($port_officer==1 && count($po_port_arr)>0){
					
					if(in_array($prt['int_portoffice_id'],$po_port_arr)){
						$pid=$prt['int_portoffice_id'];
						$arr[$i]['col0']=$prt['vchr_portoffice_name'];
						$arr[$i]['col1']=$bukk_data[$pid][0];
						$arr[$i]['col2']=$bukk_data[$pid][1];
						$arr[$i]['col3']=$bukk_data[$pid][2];
						$arr[$i]['col4']=$pid;
						$i++;
					}
				}else{
					$pid=$prt['int_portoffice_id'];
					$arr[$i]['col0']=$prt['vchr_portoffice_name'];
					$arr[$i]['col1']=$bukk_data[$pid][0];
					$arr[$i]['col2']=$bukk_data[$pid][1];
					$arr[$i]['col3']=$bukk_data[$pid][2];
					$arr[$i]['col4']=$pid;
					$i++;
				}
			}
			
		?>
		 <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
		 <table id="example" class="table table-bordered table-striped">
        <tr>
        	<th>Sl No</th>
            <th>Port Name</th>
            <th>Total Customer Registration</th>
            <th>Waiting for Approval</th>
            <th>Approved Customers</th>
            <th>View More</th>
        </tr>
        <?php 
		$j=1;
		foreach($arr as $ar)
		{
			?>
            <tr>
            	<td><?php echo $j; ?></td>
            	<td><?php echo $ar['col0'] ?></td>
                <td><?php echo $ar['col1'] ?></td>
                <td><?php echo $ar['col2'] ?></td>
                <td><?php echo $ar['col3'] ?></td>
                <td><a href="<?php echo $site_url.'/Manual_dredging/Port/get_cus_pd/'.encode_url($ar['col4']);?>">View More</a></td>
            </tr>
            <?php
			$j++;
		}
		?>
        </table>
		
          </div>
</div>		  
  		 
 		
		

    <div class="row">
        
           <div class="col-12" id="cus_buk_det"></div>
		   </div>
		   </div>