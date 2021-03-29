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
    
$(document).ready(function()
{
	
	$("#survey0").hide();
	$("#survey1").hide();
	$("#survey2").hide();
	$("#survey3").hide();
	$("#survey4").hide();

	$("#current_status_id").change(function()
	{
		var current_status_id=$("#current_status_id").val();
		//alert(current_status_id);
		//Reject and Revert
		if(current_status_id==3 || current_status_id==4)
		{
			$("#survey0").hide();
			$("#survey1").hide();
			$("#survey2").hide();
			$("#survey3").show();
			$("#survey4").show();
		}
		//Approve and Forward
		if(current_status_id==6)
		{
			$("#survey0").hide();
			$("#survey1").show();
			$("#survey2").show();
			$("#survey3").show();
			$("#survey4").show();
		}
		//Approve
		if(current_status_id==5)
		{
			$("#survey0").show();
			$("#survey1").show();
			$("#survey2").hide();
			$("#survey3").show();
			$("#survey4").show();
		}

	});

//-----Jquery End----//
});

</script>

<?php  
$vessel_id 			=  $this->uri->segment(3);
$processflow_sl 	=  $this->uri->segment(4);
$user_type_id 		=  $this->session->userdata('user_type_id');

$current_status1         =   $this->Survey_model->get_status_details($vessel_id);
  $data['current_status1'] =   $current_status1;
  $status_details_sl =$current_status1[0]['status_details_sl'];

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
<button type="button" class="btn bg-primary btn-flat margin"> Form 1 </button>
      <!-- Important; the following two ol class has to be kept, its not mistake -->
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?php echo $site_url."/Survey/csHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
      <!--  <li><a href="<?php //echo $site_url."/Survey/cs_InitialSurvey"?>"></i>  <span class="badge bg-blue"> New Applications </span> </a></li>  -->
        <li><a href="#"><span class="badge bg-blue"> Form 1  </span></a></li>
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

        <div class="col-md-10">
          <div class="box box-solid">
          <div class="box-header with-border">                                                                                                                                         
              <h3 class="box-title" style="color: #00f">Form 1 </h3>
              <p>See Rule 5 (1) - Form for expressing the intention to build a new vessel</p>

          </div>
 <?php
 //----------- Vessel Details -----------//
foreach($vessel_details_viewpage as $res_vessel)
{
	$vessel_name 			=	$res_vessel['vessel_name'];
	$vessel_length 			=	$res_vessel['vessel_length'];
	$vessel_breadth 		=	$res_vessel['vessel_breadth'];
	$vessel_depth 			=	$res_vessel['vessel_depth'];
	$vessel_expected_tonnage=	$res_vessel['vessel_expected_tonnage'];
	
	$vessel_category_id 	=	$res_vessel['vessel_category_id'];
	$vessel_subcategory_id 	=	$res_vessel['vessel_subcategory_id'];
	$vessel_type_id 		=	$res_vessel['vessel_type_id'];
	$vessel_subtype_id 		=	$res_vessel['vessel_subtype_id'];
    $sewage_treatment 		=	$res_vessel['sewage_treatment'];
     
    $solid_waste 			=	$res_vessel['solid_waste'];
    $sound_pollution 		=	$res_vessel['sound_pollution'];
    $water_consumption 		=	$res_vessel['water_consumption'];
    $source_of_water 		=	$res_vessel['source_of_water'];
    $vessel_id 				=	$res_vessel['vessel_sl'];
    $user_id 				=	$res_vessel['vessel_created_user_id'];

    $user_type_details				= 	$this->Survey_model->get_user_type_id($user_id);
	$data['user_type_details']		=	$user_type_details;
	$user_type_id					=	$user_type_details[0]['user_type_id'];


    $vessel_pref_inspection_date=date("d-m-Y", strtotime($res_vessel['vessel_pref_inspection_date']));

                
                
    if(($vessel_type_id==1) || ($vessel_type_id==7 && $vessel_subtype_id==3) )
    {
        $length_overall=$res_vessel['vessel_length_overall'];
    }
    else
    {
         $length_overall=0;
    }
                 
                
    if($sewage_treatment!=0)
    { $res_sewage_treatment='YES'; }
    else { $res_sewage_treatment='NO'; }
                    
    if($solid_waste!=0)
        { $res_solid_waste='YES'; }
    else { $res_solid_waste='NO'; }  
                    
    if($sound_pollution!=0)
    { $res_sound_pollution='YES'; }
    else { $res_sound_pollution='NO'; } 

    if( $source_of_water!=0)  
    {
     	$get_sourceof_water				= 	$this->Function_model->get_sourceof_water($source_of_water);
		$data['get_sourceof_water']		=	$get_sourceof_water;
		$source_of_water_name			=	$get_sourceof_water[0]['sourceofwater_name'];
    }
	if($vessel_category_id!=0)
	{
		$vessel_category_id				= 	$this->Survey_model->get_vessel_category_id($vessel_category_id);
		$data['vessel_category_id']		=	$vessel_category_id;
		$vessel_category_name			=	$vessel_category_id[0]['vesselcategory_name'];
	}
	else
	{
		$vessel_category_name='-';
	}
	if($vessel_category_id!=0)
	{
		$vessel_subcategory_id			= 	$this->Survey_model->get_vessel_subcategory_id($vessel_subcategory_id);
		$data['vessel_subcategory_id']	=	$vessel_subcategory_id;
		@$vessel_subcategory_name		=	$vessel_subcategory_id[0]['vessel_subcategory_name'];
	}
	/*else
	{
		$vessel_subcategory_name='-';
	}*/
	if($vessel_type_id!=0)
	{
		$vessel_type_id				= 	$this->Survey_model->get_vessel_type_id($vessel_type_id);
		$data['vessel_type_id']		=	$vessel_type_id;
		$vesseltype_name			=	$vessel_type_id[0]['vesseltype_name'];
	}
	else
	{
		$vesseltype_name='-';
	}
		
	if($vessel_subtype_id!=0)
	{
		$vessel_subtype_id			= 	$this->Survey_model->get_vessel_subtype_id($vessel_subtype_id);
		$data['vessel_subtype_id']	=	$vessel_subtype_id;
		$vessel_subtype_name		=	$vessel_subtype_id[0]['vessel_subtype_name'];
	}
	else
	{
		$vessel_subtype_name='-';
	}
}


foreach($customer_details as $res_owner)
{
	$owner_name 	=	$res_owner['user_name'];
	$owner_address	=	$res_owner['user_address'];
}
			   
 //----------- Hull Details -----------//
foreach($hull_details as $res_hull)
{
	$hull_name 			=	$res_hull['hull_name'];
	$hull_address 		=	$res_hull['hull_address'];
	$hullmaterial_id 	=	$res_hull['hullmaterial_id'];

	if($hullmaterial_id!=0)
	{
		$get_hullmaterial_id			= 	$this->Survey_model->get_hullmaterial_name($hullmaterial_id);
		$data['get_hullmaterial_id']	=	$get_hullmaterial_id;
		$hullmaterial_name				=	$get_hullmaterial_id[0]['hullmaterial_name'];
	}
	else
	{
		$hullmaterial_name='-';
	}

	$deck_status_id=$res_hull['deck_status_id'];

	if($deck_status_id=='1')
	{
		$deck_msg='YES';
	}
	else
	{
		$deck_msg='No';
	}

	$bulk_heads 			=	$res_hull['bulk_heads'];
	$bulk_head_placement 	=	$res_hull['bulk_head_placement'];

	if($bulk_head_placement!=0)
	{
		$bulk_head_placement_name			= 	$this->Survey_model->get_bulk_head_placement_name($bulk_head_placement);
		$data['bulk_head_placement_name']	=	$bulk_head_placement_name;
		$location_name						=	$bulk_head_placement_name[0]['location_name'];
	}
	else
	{
		$location_name='-';
	}
		$bulk_head_thickness 			=	$res_hull['bulk_head_thickness'];
		$hullplating_material_id 		=	$res_hull['hullplating_material_id'];

	if($hullplating_material_id!=0)
	{
		$hullplating_material_id		= 	$this->Survey_model->get_hullplating_material_name($hullplating_material_id);
		$data['hullplating_material_id']=	$hullplating_material_id;
		$hullplating_material_name		=	$hullplating_material_id[0]['hullplating_material_name'];
	}
	else
	{
		$hullplating_material_name='-';
	}

	$hull_plating_material_thickness=	$res_hull['hull_plating_material_thickness'];
	$hull_bulkhead_details			= 	$this->Function_model->get_hull_bulkhead_details($vessel_id);
	$data['hull_bulkhead_details']	=	$hull_bulkhead_details;
}	
			   
	//----------- Engine Details -----------//	
   
    //----------- Equipment Details -----------//	
foreach($equipment_details as $res_equipment)
{
   $equipment_id 	=	$res_equipment['equipment_id'];
   $vessel_id 		=	$res_equipment['vessel_id'];
}

//----anchor port-----//
$get_anchor_port			= 	$this->Function_model->get_anchor_port($vessel_id,1);
$data['get_anchor_port']	=	$get_anchor_port;
			 
foreach($get_anchor_port as $res_anchor_port) 
{
  	$weight_anchor_port 		=	$res_anchor_port['weight'];
   	$material_id_anchor_port 	=	$res_anchor_port['material_id'];

  	if($material_id_anchor_port!=0)
  	{
	  	$equipment_material			= 	$this->Function_model->get_equipment_material_name($material_id_anchor_port);
		$data['equipment_material']	=	$equipment_material;
	  	$equipment_material_name 	=	$equipment_material[0]['equipment_material_name'];
  	}
}
                          
//-------Anchor Startboard---------//
$anchor_startboard 			= 	$this->Function_model->get_anchor_startboard($vessel_id,2);
$data['anchor_startboard']	=	$anchor_startboard;

foreach($anchor_startboard as $res_star_board) 
{
	$weight_star_board 			=	$res_star_board['weight'];
	$material_id_star_board 	=	$res_star_board['material_id'];
	if($material_id_star_board!=0)
	{
		$equipment_material					= 	$this->Function_model->get_equipment_material_name($material_id_star_board);
		$data['equipment_material']			=	$equipment_material;
		$equipment_material_starboard_name	=	$equipment_material[0]['equipment_material_name'];
	}
} 
//-------Anchor Spare---------//
$get_anchor_spare 		= 	$this->Function_model->get_anchor_spare($vessel_id,3);
$data['anchor_spare']	=	$get_anchor_spare;

foreach($get_anchor_spare as $res_anchor_spare) 
{
	$weight_anchor_spare 		=	$res_anchor_spare['weight'];
	$material_id_anchor_spare 	=	$res_anchor_spare['material_id'];
	if($material_id_anchor_spare!=0)
	{
		$equipment_material				= 	$this->Function_model->get_equipment_material_name($material_id_anchor_spare);
		$data['equipment_material']		=	$equipment_material;
		$equipment_material_spare_name 	=	$equipment_material[0]['equipment_material_name'];
	}
}
                          
                          
//-------Chain Port---------//
$get_chain_port 		= 	$this->Function_model->get_chain_port($vessel_id,4);
$data['get_chain_port']	=	$get_chain_port;

foreach($get_chain_port as $res_chain_port) 
{
	$size_chain_port 	=	$res_chain_port['size'];
	$length_chain_port  =	$res_chain_port['length'];
	//$equipment_type_id_chain_port=$res_chain_port['equipment_type_id'];
	$equipment_type_id_chain_port=$res_chain_port['chainport_type_id'];


	if($equipment_type_id_chain_port!=0)
	{
		$equipment_type_chainport			= 	$this->Function_model->get_chainporttype_name($equipment_type_id_chain_port);
		$data['equipment_type_chain_port']	=	$equipment_type_chainport;
		$type_name_chain_port 				=	$equipment_type_chainport[0]['chainporttype_name'];
	}
	else
	{ 
		$type_name_chain_port='-';
	}
}  

//-------Chain startboard---------//
$get_chain_startboard 		= 	$this->Function_model->get_chain_startboard($vessel_id,5);
$data['chain_startboard']	=	$get_chain_startboard;

foreach($get_chain_startboard as $res_chain_startboard) 
{
	$size_chain_startboard 		=	$res_chain_startboard['size'];
	$length_chain_startboard 	=	$res_chain_startboard['length'];
	//$equipment_type_id_chain_startboard=$res_chain_startboard['equipment_type_id'];
	$equipment_type_id_chain_startboard=$res_chain_startboard['chainport_type_id'];


	if($equipment_type_id_chain_startboard!=0)
	{
		$equipment_type_chainstartboard			= 	$this->Function_model->get_chainporttype_name($equipment_type_id_chain_startboard);
		$data['equipment_type_chain_startboard']=	$equipment_type_chainstartboard;
		@$type_name_chain_startboard 			=	$equipment_type_chainstartboard[0]['chainporttype_name'];
	}
  	else
  	{ 
  		$type_name_chain_startboard ='-';
  	} 
}
                         
                          
//------- Rope---------//
$get_chain_Rope 	= 	$this->Function_model->get_chain_Rope($vessel_id,6);
$data['chain_Rope']	=	$get_chain_Rope;

foreach($get_chain_Rope as $res_chain_Rope) 
{
	$size_chain_Rope 	=	$res_chain_Rope['size'];
	$number_chain_Rope 	=	$res_chain_Rope['number'];
	$material_id_Rope 	=	$res_chain_Rope['material_id'];
	if($material_id_Rope!=0)
	{
		$equipment_material_rope			= 	$this->Function_model->get_rope_material_name($material_id_Rope);
		$data['equipment_material_rope']	=	$equipment_material_rope;
		$equipment_material_rope_name 		=	$equipment_material_rope[0]['ropematerial_name'];
	}
}  
//------- Search Light---------//
$get_searchlight 		= 	$this->Function_model->get_searchlight($vessel_id,7);
$data['searchlight']	=	$get_searchlight;

foreach($get_searchlight as $res_searchlight) 
{
	$size_searchlight 		=	$res_searchlight['size'];
	$power_searchlight 		=	$res_searchlight['power'];
	$number_searchlight 	=	$res_searchlight['number'];
	if($size_searchlight!=0)
	{
		$searchlight_size			= 	$this->Function_model->get_searchlight_size($size_searchlight);
		$data['searchlight_size']	=	$searchlight_size;
		$searchlight_size_name 		=	$searchlight_size[0]['searchlight_size_name'];
	}
	else
	{ 
		$searchlight_size_name='-';
	}
}

//------------- Life Buoys----------//
$get_lifebuoys 			= 	$this->Function_model->get_lifebuoys($vessel_id,8);
$data['get_lifebuoys']	=	$get_lifebuoys;
$number1 				=	$get_lifebuoys[0]['number'];

if($number1!=0)
{
  $number_lifebuoys =$number1;
}
else
 {
   $number_lifebuoys='-'; 
}           
      
                                
     

//---------- Buoyant apparatus ---------//
$get_buoyant_apparatus 			= 	$this->Function_model->get_buoyant_apparatus($vessel_id,9);
$data['get_buoyant_apparatus']	=	$get_buoyant_apparatus;
$number2 						=	$get_buoyant_apparatus[0]['number'];

if($number1!=0)
{
  $number_buoyant_apparatus=$number2;
}
else
 {
   $number_buoyant_apparatus='-'; 
}   
                          
//-----Navigation Light Particulars--------//
$navigation_light 			= 	$this->Function_model->get_navigation_light_view($vessel_id);
$data['navigation_light']	=	$navigation_light;


//-----Sound Signals--------//
$sound_signal 				= 	$this->Function_model->get_sound_signal_view($vessel_id);
$data['sound_signal']		=	$sound_signal;

//-----Fire Pumps---//  

$get_fire_pumps 			= 	$this->Function_model->get_fire_pumps($vessel_id,13);
$data['get_fire_pumps']		=	$get_fire_pumps;



//-----Fire Mains---//  
$get_fire_mains 			= 	$this->Function_model->get_fire_mains($vessel_id,14);
$data['get_fire_mains']		=	$get_fire_mains;

                          
foreach($get_fire_mains as $res_fire_mains) 
{
	$diameter_fire_mains 	=	$res_fire_mains['diameter'];
	$material_id_fire_mains =	$res_fire_mains['material_id'];

	if($material_id_fire_mains!=0)
	{
		$equipment_material_firemain			= 	$this->Function_model->get_equipment_material_name($material_id_fire_mains);
		$data['equipment_material_firemain']	=	$equipment_material_firemain;
		$equipment_material_firemains 			=	$equipment_material_firemain[0]['equipment_material_name'];
	}
}  
//-----Hydrants---//  
$get_hydrants 			= 	$this->Function_model->get_hydrants($vessel_id,15);
$data['get_hydrants']	=	$get_hydrants;  
@$hydrant_number 		=	$get_hydrants[0]['number'];

//-----Hose---//  
$get_hose 				= 	$this->Function_model->get_hose($vessel_id,16);
$data['get_hose']		=	$get_hose;  
@$hose_number 			=	$get_hose[0]['number'];


//-------------- portable fire extinguisher-----------------//tbl_kiv_fire_extinguisher_details
$get_portable_fire 			= 	$this->Function_model->get_fire_extinguisher_details($vessel_id);
$data['get_portable_fire']	=	$get_portable_fire;  

//----------------Communication Equipment---------------//
$get_communication_equipment 			= 	$this->Function_model->get_communication_equipment($vessel_id,5);
$data['get_communication_equipment']	=	$get_communication_equipment;

//----------------Navigation Equipment---------------//
$get_navigation_equipment 				= 	$this->Function_model->get_navigation_equipment($vessel_id,6);
$data['get_navigation_equipment']		=	$get_navigation_equipment;

//----------------Pollution Control Devices---------------//
$get_pollution_control 					= 	$this->Function_model->get_pollution_control($vessel_id,7);
$data['get_pollution_control']			=	$get_pollution_control;
//----------------Nozzle Type---------------//
$get_nozzle_type						= 	$this->Function_model->get_nozzle_type($vessel_id,8);
$data['get_nozzle_type']				=	$get_nozzle_type;




?>
  <div class="box-body">
  <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Survey/Verify_Vessel/'.$vessel_id ?>">
  <table id="example3" class="table table-bordered table-striped">

  <!-- ____________________________ Vessel Details ____________________________ -->

	<tr> <td colspan="4"><font color="#74c601"> <b> 1. Vessel Details </b> </font> </td> </tr>

    <tr> 
    <td> 1. Vessel Name </td> 
    <td> <font color="#7a29c6"> <?php echo @$vessel_name; ?> </font> </td>
    <td>Ref: Number </td>
    <td> <font color="#7a29c6"> 1234/2018 </font></td> 
    </tr>

    <tr> 
    <td> 2. Owner Name </td>
    <td> <font color="#7a29c6"> <?php echo @$owner_name; ?> </font></td>
    <td>Owner Address </td>
    <td><font color="#7a29c6"> <?php echo @$owner_address; ?>   </font> </td>
    </tr>

    <tr>
    <td> 3. Length:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"> <?php echo @$vessel_length; ?>&nbsp;m </font> </td>
    <td> Breadth:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$vessel_breadth; ?>&nbsp;m </font></td> 
    <td>Depth:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$vessel_depth; ?>&nbsp;m</font> </td>
    <td> Tonnage:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$vessel_expected_tonnage; ?>&nbsp;Ton</font></td>
    </tr>


    <tr> 
    <td> 4. Type</td> 
    <td><font color="#7a29c6"> <?php echo @$vesseltype_name; ?></font></td>
    <td>Sub type </td> 
    <td><font color="#7a29c6"> <?php echo @$vessel_subtype_name; ?></font></td>
    </tr>


    <tr> 
    <td> 5. Category</td> 
    <td><font color="#7a29c6"> <?php echo @$vessel_category_name; ?> </font></td> 
    <td> Sub category</td> <td><font color="#7a29c6"> <?php echo @$vessel_subcategory_name; ?></font></td> 
    </tr>
    <?php
   
   	if($length_overall>0)
    {
    ?>
    <tr>
    <td>6. Length Overall</td>
    <td><font color="#7a29c6"><?php echo @$length_overall; ?>&nbsp; m</font></td>
    <td></td>
    <td></td>
    </tr>
    <?php
   	}
    ?> 

	<!-- ____________________________ Hull Details ____________________________ -->

	<tr><td colspan="4"><font color="#74c601"> <b> 2. Particulars of Hull </b> </font> </td></tr>
	<tr> 
	<td> a. Builder Name</td>
	<td><font color="#7a29c6"> <?php echo @$hull_name; ?></font></td>
	<td> Builders Address</td>
	<td><font color="#7a29c6"> <?php echo @$hull_address; ?></font></td>
	</tr>

	<tr>
	<td> b. Material of Hull</td>
	<td colspan="3"><font color="#7a29c6"> <?php echo @$hullmaterial_name; ?></font></td>
	</tr>

	<tr> 
	<td> c. Whether with a deck above freeboard deck</td>
	<td colspan="3"><font color="#7a29c6"> <?php echo @$deck_msg; ?> </font></td>
	</tr>
	<tr> 
	<td colspan="4"> d. Number of bulk head:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$bulk_heads; ?></font> </td> 
	</tr>
	 <?php
	 $i=1;
	foreach($hull_bulkhead_details as $res_hull_bulkhead)
	{
	    $placement_id 						=	$res_hull_bulkhead['bulk_head_placement'];
	    $thickness_bulkhead_placement 		=	$res_hull_bulkhead['bulk_head_thickness'];
	    if($placement_id!=0)
	    {
	         $bulk_head_placement 			= 	$this->Function_model->get_bulk_head_placement_name($placement_id);
	         $data['bulk_head_placement']	=	$bulk_head_placement;
	         $bulk_head_placement_name 		=	$bulk_head_placement[0]['bulkhead_placement_name'];
		} 
	?>
	<tr>

    <td>Bulk head placement&nbsp;<?php echo $i; ?></td>
    <td><font color="#7a29c6"><?php echo @$bulk_head_placement_name; ?></font></td>
    <td>Bulk head Thickness&nbsp;<?php echo $i; ?></td>
    <td><font color="#7a29c6"><?php echo @$thickness_bulkhead_placement; ?>&nbsp;mm</font></td>
	</tr>
	<?php
	$i++;
	}
	?>

	<tr> 
	<td> e. Hull plating material</td>
	<td><font color="#7a29c6"> <?php echo @$hullplating_material_name; ?></font></td>
	<td> Thickness </td>
	<td><font color="#7a29c6"> <?php echo @$hull_plating_material_thickness; ?>&nbsp;mm</font></td>
	</tr>
            
<!-- ____________________________ Engine Details ____________________________ -->
            
    <tr> <td colspan="4"><font color="#74c601"> <b> 3. Particulars of propulsion of engines </b> </font> </td> </tr>
	<?php 
	$i=1;
	foreach($engine_details as $res_engine)
	{
		$bhp 					=	$res_engine['bhp'];
		$manufacturer_name 	=	$res_engine['manufacturer_name'];
		$manufacturer_brand 	=	$res_engine['manufacturer_brand'];
		$propulsion_diameter 	= 	$res_engine['propulsion_diameter'];
		$gear_number 			=	$res_engine['gear_number'];
		$engine_model_id 		=	$res_engine['engine_model_id'];
		if($engine_model_id!=0)
		{
			$get_modelnumber_name			= 	$this->Function_model->get_modelnumber_name($engine_model_id);
		  	$data['get_modelnumber_name']	=	$get_modelnumber_name;
		  	$modelnumber_name				=	$get_modelnumber_name[0]['modelnumber_name'];
		}
		else
		{
		  $modelnumber_name='-';
		}
		$engine_type_id 	= 	$res_engine['engine_type_id'];

		if($engine_type_id!=0)
		{
			$get_enginetype_name			= 	$this->Function_model->get_enginetype_name($engine_type_id);
		  	$data['get_enginetype_name']	=	$get_enginetype_name;
		  	$enginetype_name				=	$get_enginetype_name[0]['enginetype_name'];
		}
		else
		{
		  	$enginetype_name='-';
		}
		$gear_type_id=$res_engine['gear_type_id'];
		if($gear_type_id!=0)
		{
		$get_geartype_name			= 	$this->Function_model->get_geartype_name($gear_type_id);
			$data['get_geartype_name']	=	$get_geartype_name;
			$geartype_name				=	$get_geartype_name[0]['geartype_name'];
		}
		else
		{
		  $geartype_name='-';
		}
		$propulsion_material_id=$res_engine['propulsion_material_id'];
		if($propulsion_material_id!=0)
		{
		          
			$get_propulsionshaft_material_name		= 	$this->Function_model->get_propulsionshaft_material_name($propulsion_material_id);
			$data['get_propulsionshaft_material_name']	=	$get_propulsionshaft_material_name;
			$propulsionshaft_material_name				=	$get_propulsionshaft_material_name[0]['propulsionshaft_material_name'];
		}
		else
		{
		  	$propulsionshaft_material_name='-';
		}





?>
	<tr><td colspan="4"><font color="#7a29c6"> <b> Set number <?php echo $i; ?> </b> </font> </td> </tr>
	<tr> 
	<td> a. BHP</td> 
	<td><font color="#7a29c6"> <?php echo @$bhp;  ?></font></td> 
	<td> </td> <td><font color="#7a29c6"> </font></td>
	</tr>

	<tr>
	<td> b. Manufacturers Name</td> 
	<td><font color="#7a29c6"> <?php echo @$manufacturer_name; ?></font></td> 
	<td> Brand</td> <td><font color="#7a29c6"><?php echo @$manufacturer_brand; ?> </font></td> 
	</tr>

	<tr>
	<td> c. Model number</td> <td><font color="#7a29c6"><?php echo $modelnumber_name; ?> </font></td> 
	<td> d. Type of engine</td> 
	<td><font color="#7a29c6"> <?php echo $enginetype_name; ?> </font></td> 
	</tr>

	<tr> 
	<td> e. Diameter of propulsion shaft</td> 
	<td><font color="#7a29c6"> <?php echo $propulsion_diameter; ?>&nbsp;mm</font></td>
	<td> Material of propulsion shaft</td>
	<td><font color="#7a29c6"> <?php echo $propulsionshaft_material_name; ?> </font> </td>
	</tr>

	<tr>
	<td> f. Type of gear</td>
	<td><font color="#7a29c6"><?php echo $geartype_name; ?> </font></td>
	<td> Number of gear </td>
	<td><font color="#7a29c6"><?php echo $gear_number; ?> </font></td> 
	</tr>

	<?php
	$i++;
	} 
	?>
           
            
	<!-- ____________________________ Equipment Details ____________________________ -->

	<tr> <td colspan="4"><font color="#74c601"> <b> 4. Particulars of Equipments </b> </font> </td> </tr>

	<tr> 
	<td colspan="4"><font color="">  a. Anchor  </font> </td> 
	</tr>

	<tr>
	<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Port weight</td> 
	<td><font color="#7a29c6"> <?php echo @$weight_anchor_port; ?>&nbsp;Kg</font></td> 
	<td> Port material</td> 
	<td><font color="#7a29c6"> <?php echo @$equipment_material_name;?></font></td>
	</tr>

	<tr> 
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Starboard weight</td> 
	<td><font color="#7a29c6"> <?php echo @$weight_star_board; ?>&nbsp;Kg</font></td>
	<td>Starboard Material </td>
	<td><font color="#7a29c6"> <?php echo @$equipment_material_starboard_name;?></font></td>
	</tr>

	<tr> 
	<td> b. Anchor spare weight</td>
	<td><font color="#7a29c6"> <?php echo @$weight_anchor_spare; ?>&nbsp;Kg</font></td> 
	<td> Anchor spare material</td> 
	<td><font color="#7a29c6"> <?php echo @$equipment_material_spare_name; ?></font></td>
	</tr>

	<tr> <td colspan="4"><font color=""> c. Chain Port  </font> </td> </tr>

            
	<tr> 
	<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Size:&nbsp;&nbsp;&nbsp;
	<font color="#7a29c6"><?php echo @$size_chain_port; ?>&nbsp;mm </font> </td> 
	<td> Type:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$type_name_chain_port;?> </font></td> 
	<td colspan="2">Length:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo $length_chain_port; ?>&nbsp;m</font> </td>
	</tr>

	<tr> 
	<td colspan="4"><font color="">  d. Chain Starboard  </font> </td>
	</tr>


	<tr>
	<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Size:&nbsp;&nbsp;&nbsp;
	<font color="#7a29c6"><?php echo $size_chain_startboard; ?>&nbsp;m</font> </td> 
	<td> Type:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$type_name_chain_startboard; ?> </font></td> 
	<td colspan="2">Length:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo $length_chain_startboard; ?>&nbsp;m</font> </td> 
	</tr>
            
            
	<tr> 
	<td> e. Rope Size:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo $size_chain_Rope; ?> &nbsp;mm</font> </td> 
	<td> Material:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"> <?php echo @$equipment_material_rope_name; ?> </font></td> 
	<td colspan="2">Number:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo $number_chain_Rope; ?></font> </td> 
	</tr>



	<tr> 
	<td> f. Search Light Size:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo $searchlight_size_name; ?> </font> </td> <td> Power:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$power_searchlight; ?>&nbsp;nm </font></td> 
	<td colspan="2">Number:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo $number_searchlight; ?></font> </td>
	</tr>


	<tr> 
	<td> g. Number of life buoys</td>
	<td><font color="#7a29c6"> <?php echo $number_lifebuoys; ?></font></td> 
	<td> Buoyant apparatus with self ignited light with buoyant</td>
	<td><font color="#7a29c6"> <?php echo @$number_buoyant_apparatus; ?> </font></td> 
	</tr>
	<tr> 
	<td> h.Navigation lights giving particulars </td>
	<td><font color="#7a29c6">
	<?php 
	foreach ($navigation_light as $result_nav)
	{
		$list1=$result_nav['equipment_id']; 
		if($list1>9)
		{
			$nav_light_euipment 		= 	$this->Function_model->get_nav_light_euipment($list1);
			$data['nav_light_euipment']	=	$nav_light_euipment;  
			echo  @$nav_equip_name 		= 	$nav_light_euipment[0]['equipment_name'].',';
		}
	} 
	?>
	</font></td> 

	<td> i. Sound signals : Mechanical or Electrical</td> <td><font color="#7a29c6"> 
	      <?php  foreach ($sound_signal as $result_sound)
	       {
	           $list2=$result_sound['equipment_id']; 
	           if($list2>9)
	           {
		            $get_sound_signal= 	$this->Function_model->get_nav_light_euipment($list2);
		       		$data['get_sound_signal']	=	$get_sound_signal;   
		       		echo @$sound_equip_name=$get_sound_signal[0]['equipment_name'].',';
	           }
	      } 
	       ?>
	</font>
	</td>
	</tr>


	<!-- ____________________________ Fire Appliance Details ____________________________ -->

	<tr> <td colspan="4"><font color="#74c601"> <b> 5. Particulars of Fire Appliances </b> </font> </td> </tr>
	<tr> <td colspan="4"><font color=""> a. Fire pumps  </font> </td> </tr>
	<tr>
	<td><b>Name</b></td>
	<td><b>Number</b></td>
	<td><b>Capacity</b></td>
	<td><b>Size</b></td>
	</tr>
	<?php
	foreach($get_fire_pumps as $res_fire_pumps) 
	{
		$firepumptype_id 		=	$res_fire_pumps['firepumptype_id'];
		$size_fire_pumps 		=	$res_fire_pumps['firepumpsize_id'];
		@$number_fire_pumps 	=	$res_fire_pumps['number'];
		@$capacity_fire_pumps 	=	$res_fire_pumps['capacity'];

		if($size_fire_pumps!=0)
		{
			$firepump_size			= 	$this->Function_model->get_firepump_size($size_fire_pumps);
			$data['firepump_size']	=	$firepump_size;
			@$sizename_fire_pumps 	= 	$firepump_size[0]['firepumpsize_name'];
		}
		else 
		{
			$sizename_fire_pumps='-'  ;
		}
		if($firepumptype_id!=0)
		{
			$firepump_type 			=	$this->Function_model->get_firepump_type_name($firepumptype_id);
			$data['firepump_type']	=	$firepump_type;
			@$firepump_type_name 	=	$firepump_type[0]['firepumptype_name'];
		}
	?>
               
	<tr> 
	<td><font color="#7a29c6"><?php echo $firepump_type_name; ?> </font> </td>
	<td><font color="#7a29c6"><?php echo $number_fire_pumps; ?> </font> </td>
	<td><font color="#7a29c6"><?php echo $capacity_fire_pumps; ?>&nbsp;&nbsp;m<sup>3</sup>/h</font> </td> 
	<td><font color="#7a29c6"><?php echo $sizename_fire_pumps;?> </font></td> 
	</tr>
               
<?php
	} 
?>

	<tr> 
	<td colspan="4"><font color=""> b. Fire Mains  </font> </td> 
	</tr>

	<tr>
	<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diameter:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$diameter_fire_mains; ?>&nbsp;mm</font> </td> 
	<td> Material:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo @$equipment_material_firemains;?> </font></td> 
	<td colspan="2">Number of hydrants:&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><?php echo $hydrant_number; ?></font> </td> 
	</tr>

	<tr>
	<td> f. Number of hose</td> 
	<td><font color="#7a29c6"><?php echo @$hose_number; ?></font></td> 
	<td> Nozzles </td>
	<td><font color="#7a29c6">
          
	<?php
	foreach($get_nozzle_type as $res_nozzle_type)
	{
		$list8= $res_nozzle_type['equipment_id'];
		if($list8>9)
		{
			$get_nozzle_equipment			= 	$this->Function_model->get_nav_light_euipment($list8);
			$data['get_nozzle_equipment']	=	$get_nozzle_equipment;   
			echo @$nozzle_equip_name 		= 	$get_nozzle_equipment[0]['equipment_name'].',';
		}
	}
	?>
	</font>
	</td>
	</tr>
    
     <!-- ____________________________ Portable Fire Extinguishers Details ____________________________ -->

	<tr> <td colspan="4"><font color="#74c601"> <b> 6. Particulars of Portable Fire Extinguishers </b> </font> </td> </tr>
	<tr>
	<td></td>
	<td><b>Name</b></td>
	<td><b>Number</b></td>
	<td><b>Capacity</b></td>
	</tr>

	<?php 
	$i=1;
	foreach ($get_portable_fire as $result_portable) 
	{
		$ext_id 							= 	$result_portable['fire_extinguisher_type_id'];
		$get_ext_type						= 	$this->Function_model->get_portable_fire_extinguisher_name($ext_id);
		$data['get_ext_type']				=	$get_ext_type;
		@$portable_fire_extinguisher_name	=	$get_ext_type[0]['portable_fire_extinguisher_name'];
	?>
            
	<tr> <td> </td> 
	<td><font color="#7a29c6"><?php echo $i; ?>&nbsp; <?php echo $portable_fire_extinguisher_name;  ?></font></td> 
	<td ><font color="#7a29c6"><?php echo $result_portable['fire_extinguisher_number']; ?> </font></td>
	<td ><font color="#7a29c6"><?php echo $result_portable['fire_extinguisher_capacity']; ?> </font></td>
	<?php $i++; } ?>
	</tr>
            
	<tr>
	<td colspan="4"><font color="#74c601"> <b>  </b> </font> </td> 
	</tr>

	<tr> 
	<td>  11. Particulars of communication equipments </td> 
	<td colspan="3"><font color="#7a29c6"> 
	<?php
	foreach($get_communication_equipment as $res_commn_equipment)
	{
		$list3= $res_commn_equipment['equipment_id'];
		if($list3>9)
		{
			$get_commn_equipment 			= 	$this->Function_model->get_nav_light_euipment($list3);
			$data['get_commn_equipment']	=	$get_commn_equipment;   
			echo @$commn_equip_name 		= 	$get_commn_equipment[0]['equipment_name'].',';
		}
	}
	?>

	</font>
	</td>
	</tr>


	<tr> <td>  12. Particulars of navigation equipments </td>
	<td colspan="3"> <font color="#7a29c6"> 
	<?php
	foreach($get_navigation_equipment as $res_navigation_equipment)
	{
		$list4 	= $res_navigation_equipment['equipment_id'];
		if($list4>9)
		{
			$get_nav_equipment 			= 	$this->Function_model->get_nav_light_euipment($list4);
			$data['get_nav_equipment']	=	$get_nav_equipment;   
			echo @$nav_equip_name 		=	$get_nav_equipment[0]['equipment_name'].',';
			}
	}
	?>
	</font>
	</td>
	</tr>


	<tr> <td>  13. Particulars of pollution control devices </td> 
	<td colspan="3"> <font color="#7a29c6">
	<?php
	foreach($get_pollution_control as $res_pollution_control)
	{
		$list5= $res_pollution_control['equipment_id'];

		if($list5>9)
		{
			$get_pollncntrl_equipment 			= 	$this->Function_model->get_nav_light_euipment($list5);
			$data['get_pollncntrl_equipment']	=	$get_pollncntrl_equipment;   
			echo @$polln_equip_name 			=	$get_pollncntrl_equipment[0]['equipment_name'].',';
		}
	}
	?>

	</font>
	</td> 
	</tr>

	<tr> 
	<td class="div300">14. Sewage treatment and disposal :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><b> <?php echo $res_sewage_treatment;?> </b></font></td>
	<td class="div300">15. Solid waste processing and disposal :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#7a29c6"> <b> <?php echo $res_solid_waste; ?> </b> </font></td>
	<td class="div300" colspan="2">16. Sound pollution control :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#7a29c6"><b> <?php echo $res_sound_pollution; ?> </b></font></td>
	</tr>

	<tr>
	<td> 17. Water consumption per day</td>
	<td><font color="#7a29c6"> <?php echo @$water_consumption; ?>&nbsp;L </font></td>
	<td>18. Source of Water </td> <td><font color="#7a29c6"><?php echo @$source_of_water_name; ?></font></td>
	</tr>

	<!-- ____________________________ Documents Details ____________________________ -->
	
	<tr> <td colspan="4"><font color="#74c601"> <b> 7. Documents </b> </font> </td> </tr>

	<?php
	$i=1; 
	foreach($list_document_vessel as $res_list_document)
	{
		$document_sl 	=	$res_list_document['document_sl'];
		$doc_file 		= 	$this->Function_model->get_doc_file($vessel_id, $document_sl);
		$document_id 	= 	@$doc_file->document_id;
		$filename 		= 	@$doc_file->document_name;
		/*  
		$document_id=$doc_file[0]['document_id'];
		$filename=$doc_file[0]['document_name'];
		*/ 
		if($filename==NULL)
		{
			$msg_disp='<font color="#7a29c6">  <b> No </b>  </font>';
		}
		else 
		{
			$msg_disp='<font color="#7a29c6"> <a href="'.base_url().'uploads/survey/'.$document_id.'/'.$filename.'" download> <b> Yes </b> </a> </font>';
		}


	?>
	<tr> <td colspan="3"><font color="#7a29c6"><?php  echo $res_list_document['document_name']; ?></font></td> 
	<td>
	<?php
		echo $msg_disp; 
	?>
	</td>
	</tr>
	<?php
	$i++;
	}
	?>

	<tr> <td colspan="4"><font color="#74c601"> <b> &nbsp; </b> </font> </td> </tr>
	<tr>
	<td>Preferred Inspection Date</td>
	<td><?php echo $vessel_pref_inspection_date; ?></td>
	<td>
		<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
		<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
		<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
		<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
		<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $user_type_id; ?>">
		<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">

		</td>
	<td></td>
	</tr>
<?php //echo $vessel_details[0][''];?>

	<tr>
	<td>Survey Process</td>
	<td><select name="current_status_id" id="current_status_id" class="form-control select2" data-validation="required">
		<option value="">Select</option>
		<?php foreach($current_status as $res_current_status)
	{
	?>
	<option value="<?php echo $res_current_status['status_id']; ?>"> <?php echo $res_current_status['status_name']; ?> </option>
	<?php
	}
	?>
	
	</select>

	</td>
	<td></td>
	<td></td>
	</tr>

	<tr id="survey1">
	<td>Survey Activity</td>
	<td><select name="surveyactivity_id" id="surveyactivity_id" class="form-control select2" data-validation="required">
	<option value="">Select</option>	
	<?php foreach($survey_activity as $res_survey_activity)
	{
	?>
	<option value="<?php echo $res_survey_activity['surveyactivity_sl']; ?>"> <?php echo $res_survey_activity['surveyactivity_name']; ?> </option>
	<?php
	}
	?>
	</select></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr id="survey0">
	<td>Survey Activity Date</td>
	<td><div class="div250">
		<div class="form-group">
		<div class="input-group date">
		<div class="input-group-addon">
		<i class="fa fa-calendar"></i>
		</div>
		 <input type="text" class="form-control" id="datepicker1" name="inspection_date" title="Enter Inspection Date" data-validation="required">
		</div>
		</div>
		</div>
	</td>
	<td></td>
	<td></td>
	</tr>

	<tr id="survey2">
	<td>Forward To Surveyor</td>
	<td><select name="forward_to" id="forward_to" class="form-control select2" data-validation="required">
	<option value="">Select</option>
	<?php foreach($surveyor_details as $res_surveyor_details) 
	{
	?>
	<option value="<?php echo $res_surveyor_details['user_sl']; ?>"> <?php echo $res_surveyor_details['official_name']; ?> </option>
	<?php 
	}
	?>
	</select></td>
	<td></td>
	<td></td>
	</tr>

	<tr id="survey3">
	<td>Remarks</td>
	<td><textarea name="remarks" data-validation="required" id="remarks"></textarea></td>
	<td></td>
	<td></td>
	</tr>

	<tr id="survey4">
	<td></td>
	<td><input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Submit"></td>
	<td></td>
	<td></td>
	</tr>
	
            
          </table>
          </form>
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