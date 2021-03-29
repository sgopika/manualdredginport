
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/dataentry_style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/icheck/green.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/select2.css">
<title>PortInfo 2.0 - Kerala Maritime Board</title>
</head>
<body>
<!------------ navbar section --------------------->
    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="login.php"><img src="<?php echo base_url(); ?>plugins/img/logo.png"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item ">
                <a class="nav-link main_link_b" href="mal.php"><img src="<?php echo base_url(); ?>plugins/img/india.png" style="width: 20%; height: 20%;"> Malayalam</a>
              </li>
              <li class="nav-item">
                <a class="nav-link main_link_b" href="<?php echo base_url()."index.php/Kiv_Ctrl/DataEntry/dataentry"?>">Data Entry</a>
              </li>
              <li class="nav-item">
                <a class="nav-link main_link_b" href="#">Notifications</a>
              </li>
              <li class="nav-item " id="lastnav">
                <a href="#about" class="btn btn-primary btn-flat btn-sm sub_link_w"><i class="fas fa-file-pdf h4"></i>&nbsp;KIV Forms</a>
              </li>
            </ul>
          </div>
        </nav>
    </section>
<!----------------------------------------------- end of navbar section -------------------------------------------------------->
<!-- ------------------------------------------------------------ Main Div ----------------------------------------------------- -->
<div class="container-fluid">

  
<!-- <div class="row">
<div class="col-5 d-flex justify-content-end pt-2">
     <p class="home_subtitle"> KIV Number </p>
</div>  
<div class="col-4 d-flex justify-content-left">
          <div class="input-group mb-3">
            <input type="text" class="form-control home_content" placeholder="E.g. : KIV/VZM/89/2019" aria-label="kiv number" aria-describedby="basic-addon2">
            <div class="input-group-append">
               <button class="btn btn-warning btn-flat btn-point home_content" type="button">Search Vessel</button>
            </div>
        </div>
</div> 
<div class="col-2"><a href="<?php echo base_url()."index.php/DataEntry/addform"?>" class="btn btn-success btn-flat btn-point"><i class="fas fa-plus"></i>&nbsp;Add New Vessel</a></div>
</div>  -->

<!-- end of row -->
  <!-- <div id="noresult">
    <div class="row">
      <div class="col-12">
        <div class="alert alert-success" role="alert">
          No result for the queried KIV Number.
        </div>
      </div>
    </div>
  </div> -->

   <!-- end of nosresult div -->
   <form name="form1" id="form1" method="post" action="">
  <div id="showcontent">
<div class="row">
<div class="col-12"> 
<div class="alert alert-success" role="alert home_title">
  Form 14 (Registration Certificate) Details 
  <i class="fas fa-pencil-alt float-right"></i>
</div> <!-- end of alert -->
</div> <!-- end of col12 -->
</div> <!-- end of row -->
<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Passenger Capacity
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point"  name="passenger_capacity"  id="passenger_capacity" aria-describedby="text" placeholder="Passenger Capacity" required maxlength="3">
  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-4">
    KIV Number
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="vessel_registration_number" id="vessel_registration_number" aria-describedby="text" placeholder="Vessel registration number" required maxlength="50">
  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-4">
    Year of registry
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control dob"  name="vesselmain_reg_date" id="vesselmain_reg_date" aria-describedby="text" placeholder="Vessel registration date" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

  <div class="row listrow">

   <div class="col-2 home_content pt-4">
    Place of Registry
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    <select class="form-control btn-point js-example-basic-single" name="registering_authority_sl" id="registering_authority_sl"  required>
    <option value="">Select</option>
      <?php foreach($registeringAuthority as $res_registeringAuthority) { ?>
      <option value="<?php echo $res_registeringAuthority['registering_authority_sl']?>"><?php echo $res_registeringAuthority['registering_authority_name']?></option>
    <?php } ?>

    </select>
  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-4">
    Registering Authority 
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">

   <!--  <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="" required maxlength="50"> -->

<select class="form-control btn-point js-example-basic-single" name="user_sl" id="user_sl"  required>
    <option value="">Select</option>
      <?php foreach($ra_list as $res_ra_list) { ?>
      <option value="<?php echo $res_ra_list['user_master_id']?>"><?php echo $res_ra_list['user_master_fullname']?></option>
    <?php } ?>
    </select>
 

  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-4" >
    Owner Name
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="user_name" id="user_name" aria-describedby="text" placeholder="Vessel owners name" required maxlength="50" onkeypress="return alpbabetspace(event);" >
  </div>
  </div> <!-- end of col2 -->
  </div> <!-- end of listrow -->

  <div class="row listrow">
    <div class="col-1 home_content pt-4" required>
    Address
  </div> <!-- end of col2 -->
   <div class="col-3 home_subtitle">
    <div class="form-group">
    <textarea class="form-control btn-point btn-block" id="textarea" rows="5" name="user_address" id="user_address" onkeypress="return IsAddress(event);" maxlength="100" placeholder="Address of owner"></textarea>
  </div>
  </div> <!-- end of col2 -->
<div class="col-2 home_content pt-4">
    Mobile Number
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="tel" class="form-control btn-point"name="user_mobile_number" id="user_mobile_number" aria-describedby="text" placeholder="Owner mobile number" minlength="10" maxlength="10" required onkeypress="return IsNumeric(event);">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Type of Vessel
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
   
      <select class="form-control btn-point js-example-basic-single" name="vessel_type_id" id="vessel_type_id" title="Select Vessel Type" data-validation="required">
         <option value="">Select</option>
    <?php foreach ($vesseltype as $res_vesseltype)
    {
    ?>
    <option value="<?php echo $res_vesseltype['vesseltype_sl']; ?>"> <?php echo $res_vesseltype['vesseltype_name'];?>  </option>
    <?php
    } 
    ?>
          </select> 
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
<div class="row listrow">
     <div class="col-2 home_content pt-4">
    Subtype of Vessel
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
   
<select class="form-control btn-point js-example-basic-single" name="vessel_subtype_id" id="vessel_subtype_id" title="Select Vessel Sub Type" > 
</select>
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-4">
    Vessel Name
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="vessel_name" value="" id="vessel_name" aria-describedby="text" placeholder="Enter Vessel Name" required maxlength="50" onkeypress="return alphaNumeric(event);" onchange="return checklength(this.id)">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-4">
    Built at
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="build_place" id="build_place" aria-describedby="text" placeholder="Built at" required maxlength="20">
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
  <div class="row listrow">
      <div class="col-2 home_content pt-4">
    Hull builder name
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="hull_name" id="hull_name" aria-describedby="text" placeholder="Hull name"  onkeypress="return alpbabetspace(event);" onchange="return checklength(this.id)" onpaste="return false;">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-4">
    Year of built
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="hull_year_of_built" id="hull_year_of_built" aria-describedby="text" placeholder="Year of built" required maxlength="4">
  </div>
  </div> <!-- end of col2 -->
    
       <div class="col-2 home_content pt-4">
    Port of Registry
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    
      <select class="form-control btn-point js-example-basic-single" name="portofregistry_sl" id="portofregistry_sl"  title="" data-validation="required">
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id']; ?>"><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select>
  </div>
  </div> <!-- end of col2 -->
   
  </div> <!-- end of listrow -->
  <div class="row listrow">
     <div class="col-2 home_content pt-4">
    Registration Date
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" id="text" aria-describedby="text" placeholder="" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
      <div class="col-2 home_content pt-4">
    Description of Engine
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    
      <select class="form-control btn-point js-example-basic-single" name="engine_placement_id" id="engine_placement_id" title="Select Engine inboard/outboard" data-validation="required">
                <option value="">Select</option>
              
                    <?php
                    foreach ($inboard_outboard as $res_inboard_outboard)
                   {
                        ?>
                     <option value="<?php echo $res_inboard_outboard['inboard_outboard_sl']; ?>"> <?php echo $res_inboard_outboard['inboard_outboard_name']; ?>  </option>
                    <?php
                   }
                    ?>

                  </select>



  </div>
  </div> <!-- end of col2 -->
     <div class="col-2 home_content pt-4">
    Name &amp; Address of Engine Maker
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="manufacturer_name" id="manufacturer_name" aria-describedby="text" placeholder="Manufacturer name" onkeypress="return alpbabetspace(event);" onchange="checklength()" onpaste="return false;">
  </div>
  </div> <!-- end of col2 -->
 
  </div> <!-- end of listrow -->
  <div class="row listrow">
       <div class="col-2 home_content pt-4">
    Engine make year
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="make_year" id="make_year" aria-describedby="text" placeholder="Engine make year" required maxlength="50">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-4">
    Number of engine set 
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="no_of_engineset" id="no_of_engineset" aria-describedby="text" placeholder="No. of engine set" required maxlength="1">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Number of shaft
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="propulsion_shaft_number" id="propulsion_shaft_number" aria-describedby="text" placeholder="number of shaft"  maxlength="1">
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
         <div class="col-2 home_content pt-1">
    Total BHP
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="bhp" id="bhp" aria-describedby="text" placeholder="BHP" required maxlength="3" min="1" max="999">
  </div>
  </div> <!-- end of col2 -->
        <div class="col-2 home_content pt-2">
    Speed of vessel
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" name="engine_speed" id="engine_speed" placeholder="Speed of vessel" aria-label="text" aria-describedby="basic-addon2" maxlength="3" required>
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">Kmph</span>
  </div>
</div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-2">
    Extreme Length
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point"  name="vessel_length_overall" id="vessel_length_overall" placeholder="Length over all" aria-label="text" aria-describedby="basic-addon2"  maxlength="2">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>
</div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
         <div class="col-2 home_content pt-2">
    Length
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point"  name="vessel_length" id="vessel_length" placeholder="Vessel length " aria-label="text" aria-describedby="basic-addon2" required maxlength="2"> 
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>
</div>
  </div> <!-- end of col2 -->
         <div class="col-2 home_content pt-2">
    Breadth
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point"   name="vessel_breadth" id="vessel_breadth" placeholder="Vessel breadth" aria-label="text" aria-describedby="basic-addon2" required maxlength="2"> 
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>
</div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-2">
    Depth
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point"  name="vessel_depth" id="vessel_depth" placeholder="Vessel depth" aria-label="text" aria-describedby="basic-addon2" required max="2">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>
</div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
         <div class="col-2 home_content pt-2">
    GRT
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point"  name="grt" id="grt" placeholder="Gross registered tonnage" aria-label="text" aria-describedby="basic-addon2" required maxlength="3">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">ton</span>
  </div>
</div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-2">
    NRT
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point"  name="nrt" id="nrt" placeholder="Net registered tonnage" aria-label="text" aria-describedby="basic-addon2"  maxlength="3">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">ton</span>
  </div>
</div>
  </div> <!-- end of col2 -->
     <div class="col-2 home_content pt-2">
    Number of Deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point"  name="vessel_no_of_deck" id="vessel_no_of_deck" aria-describedby="text" placeholder="Number of deck" required maxlength="1">
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
    <div class="col-2 home_content">

    Number of bulkhead
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point"  name="bulk_heads" id="bulk_heads" aria-describedby="text" placeholder="Number of bulkhead"  maxlength="1">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Hull material
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">

<select class="form-control btn-point js-example-basic-single" name="hullmaterial_id" id="hullmaterial_id" title="Select Materil of Hull" data-validation="required">
<option value="">Select</option>

<?php
foreach ($hullmaterial as $res_hullmaterial)
{
  ?>
<option value="<?php echo $res_hullmaterial['hullmaterial_sl']; ?>"> <?php echo $res_hullmaterial['hullmaterial_name']; ?>  </option>
<?php
}
?>

</select>
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-4">
    Stern
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
   <select class="form-control btn-point js-example-basic-single" name="stern_material_sl" id="stern_material_sl" title="Select Materil of Hull" >
<option value="">Select</option>

<?php 
foreach ($stern_material as $res_stern_material) { ?>
<option value="<?php echo $res_stern_material['stern_material_sl']; ?>"><?php echo $res_stern_material['stern_material_name']; ?></option>
<?php 
}
?>

</select>
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of row -->
<div class="row listrow">
     <div class="col-2 home_content pt-4">
    Initial registration
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" id="text" aria-describedby="text" placeholder="" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Renewal date
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" name="next_reg_renewal_date" id="next_reg_renewal_date" aria-describedby="text" placeholder="Registration renewal date" maxlength="10">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-4">
    Registration validity
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" name="registration_validity_period" id="registration_validity_period" aria-describedby="text" placeholder="Regeration validity" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
  </div> <!-- end of listrow -->
  <div class="row listrow">
       <div class="col-2 home_content pt-4">
    Area of operation
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
 <input type="text" class="form-control btn-point" name="area_of_operation" id="area_of_operation" aria-describedby="text" placeholder="Area of operation" required maxlength="50">

   <!--  <select class="form-control btn-point js-example-basic-single" id="select12" required>
      <option>Alappuzha</option>
      <option>2</option>
    </select> -->
  </div>
  </div> <!-- end of col2 -->
     <div class="col-2 home_content pt-4">
    Email Id
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="user_email" id="user_email" aria-describedby="text" placeholder="Email Id" required maxlength="50">
  </div>
  </div> <!-- end of col2 -->
  </div> <!-- end of listrow -->
<!-- end of certificate of registration -->



<div class="row pt-3">
  <div class="col-12">
    <div class="alert alert-secondary" role="alert">
    Certificate of Survey Details 
    <i class="fas fa-pencil-alt float-right"></i>
</div>
  </div> <!-- end of col12 -->
</div> <!-- end of row -->

<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Details of Master
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">
    <!-- -------------------------------------------- Inside Master details -------------------------------------------------------------- -->

<span id="optionBox_mr">

<div class="row listrow" id="addrow_mr1">
<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point" name="name_of_type_mr[]" id="name_of_type_mr" aria-describedby="text" placeholder="Name of master" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_mr[]"  id="license_number_of_type_mr" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 
<!-- 
<div class="col-3">
<div class="form-group">
<textarea class="form-control btn-point btn-block" id="textarea" name="address_of_type_mr[]" rows="5" placeholder="Address"></textarea>
</div>
</div>  -->

 <div class="col-3 pt-5">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove('1')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div>  

</div> 

<input type="hidden" value="1" name="cnt" id="cnt">
<input type="hidden" value="1" name="master_cnt" id="master_cnt">
</span>

 <div class="col-3 pt-5">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add"><i class="fas fa-plus"></i>&nbsp; Add New </button>
</div>





    <!-- -------------------------------------------- End of Inside Master details -------------------------------------------------------- -->
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->
<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Details of Serang
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">
     <!-- -------------------------------------------- Inside Serang details -------------------------------------------------------------- -->

<span id="optionBox_sg">

<div class="row listrow" id="addrow_sg1">
<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point" name="name_of_type_sg[]" id="name_of_type_sg" aria-describedby="text" placeholder="Name of master" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_sg[]"  id="license_number_of_type_sg" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 

<!-- <div class="col-3">
<div class="form-group">
<textarea class="form-control btn-point btn-block" id="textarea" name="address_of_type_sg[]" rows="5" placeholder="Address"></textarea>
</div>
</div>  -->

 <div class="col-3 pt-5">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_sg('1')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div>  

</div> 

<input type="hidden" value="1" name="cnt_sg" id="cnt_sg">
<input type="hidden" value="1" name="serang_cnt" id="serang_cnt">
</span>

 <div class="col-3 pt-5">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add_sg"><i class="fas fa-plus"></i>&nbsp; Add New </button>
</div>




  
<!-- -------------------------------------------- End of Inside Serang details -------------------------------------------------------- -->
</div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Details of Lascar
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">
     <!-- -------------------------------------------- Inside Lascar details -------------------------------------------------------------- -->
 <span id="optionBox_lr">

<div class="row listrow" id="addrow_lr1">
<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point" name="name_of_type_lr[]" id="name_of_type_lr" aria-describedby="text" placeholder="Name of master" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_lr[]"  id="license_number_of_type_lr" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 

 <!-- <div class="col-3">
<div class="form-group">
<textarea class="form-control btn-point btn-block" id="textarea" name="address_of_type_lr[]" rows="5" placeholder="Address"></textarea>
</div>
</div>   -->

<div class="col-3 pt-5">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_lr('1')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div> 

</div> 

<input type="hidden" value="1" name="cnt_lr" id="cnt_lr">
<input type="hidden" value="1" name="lascar_cnt" id="lascar_cnt">
</span>

 <div class="col-3 pt-5">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add_lr"><i class="fas fa-plus"></i>&nbsp; Add New </button>
</div>
 
    <!-- -------------------------------------------- End of Inside Lascar details -------------------------------------------------------- -->
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->



<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Details of Driver
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">
     <!-- -------------------------------------------- Inside Driver details -------------------------------------------------------------- -->
 <span id="optionBox_dr">

<div class="row listrow" id="addrow_dr1">
<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point" name="name_of_type_dr[]" id="name_of_type_dr" aria-describedby="text" placeholder="Name of Driver" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_dr[]"  id="license_number_of_type_dr" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 

<!-- <div class="col-3">
<div class="form-group">
<textarea class="form-control btn-point btn-block" id="textarea" name="address_of_type_lr[]" rows="5" placeholder="Address"></textarea>
</div>
</div>  -->

<div class="col-3 pt-5">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_dr('1')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div> 

</div> 

<input type="hidden" value="1" name="cnt_dr" id="cnt_dr">
<input type="hidden" value="1" name="driver_cnt" id="driver_cnt">
</span>

 <div class="col-3 pt-5">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add_dr"><i class="fas fa-plus"></i>&nbsp; Add New </button>
</div>
 
    <!-- -------------------------------------------- End of Inside Driver details -------------------------------------------------------- -->
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->




<div class="row listrow">
  <div class="col-2 home_content pt-4" >
    Year of built
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="" required maxlength="4">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Nature of operation
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    <select class="form-control btn-point js-example-basic-single" id="cargo_nature" name="cargo_nature" required>
      <option value="">Select</option>
      <?php foreach($cargo_nature as $condtn) { ?>
      <option value="<?php echo $condtn['natureofoperation_sl']?>"><?php echo $condtn['natureofoperation_name']?></option>
    <?php } ?>
    </select>
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    <!-- Partial/U/D --> Upper deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <!-- <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder=""> -->
    Yes&nbsp;<input type="radio" value="Y" name="upperdeck">&nbsp;&nbsp;&nbsp;No&nbsp;<input type="radio" value="N" name="upperdeck" checked="">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Number of bedrooms
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Engine Number
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="engine_number" id="engine_number" aria-describedby="text" placeholder="Engine number" required maxlength="20">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Nature of fuel
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    <select class="form-control btn-point js-example-basic-single" name="fuel_sl" id="fuel_sl" required>
      <option value="">Select</option>
      <?php foreach($fuel as $res_fuel) { ?>
      <option value="<?php echo $res_fuel['fuel_sl']?>"><?php echo $res_fuel['fuel_name']?></option>
    <?php } ?>

    </select>
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Number of Master
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="" required maxlength="2">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Number of  Serang
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="" required maxlength="2">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Number of Lascar
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="" required maxlength="2">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-3 home_content pt-4">
    Is hull in good condition
  </div> <!-- end of col2 -->
   <div class="col-1 home_subtitle pt-3">
    <input tabindex="10" type="checkbox"  name="hull_condition_status_id" id="icheckbox_square-green" checked>
  </div> <!-- end of col2 -->
   <div class="col-3 home_content pt-4">
    Has vessel tested for stability
  </div> <!-- end of col2 -->
   <div class="col-1 home_subtitle pt-3">
    <input tabindex="10" type="checkbox" name="stability_test_status_id" id="icheckbox_square-green" checked>
  </div> <!-- end of col2 -->
   <div class="col-3 home_content pt-4">
    Are all equipments under rule
  </div> <!-- end of col2 -->
   <div class="col-1 home_subtitle pt-3">
    <input tabindex="10" type="checkbox" name="condition_of_equipment" id="icheckbox_square-green" checked>
  <!--   <div class="form-group">
    <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="">
  </div> -->
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-3 home_content pt-4">
    Life Saving equipment details 
  </div> <!-- end of col2 -->
   <div class="col-9 home_subtitle">
    <!-- ----------------------------- Inside life saving equipments --------------------------------------------------- -->
<?php
$i=1;
 foreach ($life_save_equipment as $key1) {
   ?>

    <div class="row listrow">
      <div class="col-4">
      <div class="form-group">
        <input type="hidden" name="equipment_sl<?php echo $i; ?>" id="equipment_sl<?php echo $i; ?>" value="<?php echo $key1['equipment_sl'];?>">
   <?php echo $key1['equipment_name'];?>
  </div>
</div> <!-- end of col6 -->
<div class="col-4">
  <div class="form-group">
    <input type="text" class="form-control btn-point" name="number_adult<?php echo $i; ?>" id="number_adult<?php echo $i; ?>" aria-describedby="text" placeholder="No. of  <?php echo $key1['equipment_name'];?> in adult" maxlength="3" >
  </div>
  </div> <!-- end of col6 -->

   <div class="col-4">
     <div class="form-group">
    <input type="text" class="form-control btn-point" name="number_child<?php echo $i; ?>" id="number_child<?php echo $i; ?>" aria-describedby="text" placeholder="No. of  <?php echo $key1['equipment_name'];?> in children" maxlength="3" >
  </div>
  </div> <!-- end of col4 -->
</div> <!-- end of row -->

<?php 
$i++; 
} ?>

<!-- -------------------------------------------------------- end of life saving equipments --------------------------------------- -->
  </div> <!-- end of col10 -->



</div> <!-- end of listrow -->
<div class="row listrow">
  <div class="col-3 home_content pt-4">
    Fire fighting equipment details 
  </div> <!-- end of col2 -->
   <div class="col-9 home_subtitle">
    <!-- ---------------  ------------------ Inside fire fighting equipments    ----------------------------------------------------->
    <?php 
    $j=1;
    foreach($portable_fire_ext as $key2) { ?>
    <div class="row listrow">
      <div class="col-4">
      <div class="form-group">
    <input type="hidden" name="fire_extinguisher_type_id[]" id="portable_fire_extinguisher_sl<?php echo $j; ?>" value="<?php echo $key2['portable_fire_extinguisher_sl'];?>">
   <?php echo $key2['portable_fire_extinguisher_name'];?>

  </div>
</div> <!-- end of col6 -->
<div class="col-4">
  <div class="form-group">
    <input type="text" class="form-control btn-point" name="firenumber[]" id="firenumber<?php echo $j; ?>" aria-describedby="text" placeholder="No. of  <?php echo $key2['portable_fire_extinguisher_name'];?>" required maxlength="3">
  </div>
  </div> <!-- end of col6 -->

  <div class="col-4">
  <div class="form-group">
    <input type="text" class="form-control btn-point" name="capacity[]" id="capacity<?php echo $j; ?>" aria-describedby="text" placeholder="Capacity of  <?php echo $key2['portable_fire_extinguisher_name'];?>" required maxlength="3">
  </div>
  </div> <!-- end of col6 -->


  <div class="col-4">
    
  </div> <!-- end of col4 -->
</div> <!-- end of row -->


<?php 
$j++;
} ?>
<input type="hidden" name="fireext_count" value="<?php echo ($j-1);?>">

<!-------------------------------------------- end of firefighting equipments ------------------------------------------- -->
  </div> <!-- end of col10 -->
</div> <!-- end of listrow -->
<div class="row listrow">
  <div class="col-3 home_content pt-4">
    Pollution control devices details 
  </div> <!-- end of col2 -->
   <div class="col-9 home_subtitle">
    <div class="form-group">
           <select class="js-example-basic-multiple" name="list3[]" multiple="multiple">
            <option value="">Select list</option>
            <?php foreach ($pollution_control as $key3) {
             ?>
              <option value="<?php echo $key3['equipment_sl']; ?>"><?php echo $key3['equipment_name']; ?></option>
           <?php } ?>
          </select>
          </div>
  </div> <!-- end of col10 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-12 home_content "> Number of passengers in </div>
  <div class="col-2 home_content pt-4">
    Lower Deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="lower_deck_passenger" id="lower_deck_passenger" aria-describedby="text" placeholder="No. of lower deck passenger" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Upper Deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="upper_deck_passenger" id="upper_deck_passenger" aria-describedby="text" placeholder="No. of upper deck passenger" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Four Day Cruise
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="four_cruise_passenger" id="four_cruise_passenger" aria-describedby="text" placeholder="No. of four day cruise" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-2 home_content pt-4">
    Number of life bouys
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <!-- <textarea class="form-control btn-point btn-block" id="textarea" name="repair_details_nature" rows="5"></textarea> -->

    <input type="text" class="form-control btn-point" name="number_of_lifebouys" id="number_of_lifebouys" aria-describedby="text" placeholder="No. of life bouys" maxlength="3">

  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Next drydock date
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" name="next_drydock_date" id="next_drydock_date" aria-describedby="text" placeholder="" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
    Validity of Certificate
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" name="validity_of_certificate" id="validity_of_certificate" aria-describedby="text" placeholder="Validity of certificate" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->



<div class="row listrow">
  <div class="col-1 home_content pt-4">
   <!--  Remarks of Surveyor -->Place of survey
  </div> <!-- end of col2 -->
   <div class="col-3 home_subtitle">
     <div class="form-group">
   <!--  <textarea class="form-control btn-point btn-block" id="remarks" name="remarks" rows="5"></textarea> -->
     <select class="form-control btn-point js-example-basic-single" name="placeofsurvey_sl" id="placeofsurvey_sl" required>
      <option value="">Select</option>
            <?php foreach ($placeof_survey as $res_placeofsurvey) {
             ?>
              <option value="<?php echo $res_placeofsurvey['placeofsurvey_sl']; ?>"><?php echo $res_placeofsurvey['placeofsurvey_name']; ?></option>
           <?php } ?> 
    </select>
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
     Date of survey
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
   <input type="date" class="form-control btn-point dob" name="date_of_survey" id="date_of_survey" aria-describedby="text" placeholder="Date of survey" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-4">
  Bilge pump
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
   <input type="hidden" name="equipment_type_id4" id="equipment_type_id4" value="4">
   <input type="text" class="form-control btn-point" name="number_of_bilgepump" id="number_of_bilgepump" aria-describedby="text" placeholder="No. of bilge pump" maxlength="3">
    <input type="hidden" name="equipment_id53" id="equipment_id53" value="53">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->



<div class="row listrow">
  <div class="col-1 home_content pt-4">
  Fire pump
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
    <input type="hidden" name="equipment_type_id4" id="equipment_type_id4" value="4">
   <input type="text" class="form-control btn-point" name="number_of_firepumps" id="number_of_firepumps" aria-describedby="text" placeholder="No. of fire pumps" maxlength="3">
    <input type="hidden" name="equipment_id13" id="equipment_id13" value="13">
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
  Fire bucket
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
 <input type="text" class="form-control btn-point" name="number_of_firebucket" id="number_of_firebucket" aria-describedby="text" placeholder="No. of fire bucket" maxlength="3">
    <input type="hidden" name="equipment_id11" id="equipment_id11" value="11">
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
  Sandbox
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="text" class="form-control btn-point" name="number_of_sandbox" id="number_of_sandbox" aria-describedby="text" placeholder="No. of sandbox" maxlength="3">
    <input type="hidden" name="equipment_id12" id="equipment_id12" value="12">
  </div>
  </div> 
</div> 



<div class="row listrow">
  <div class="col-1 home_content pt-4">
  First aid box
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
  Yes&nbsp;<input type="radio" value="Y" name="first_aid_box" checked="">&nbsp;&nbsp;&nbsp;No&nbsp;<input type="radio" value="N" name="first_aid_box" >
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
   Foam 

  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="hidden" name="equipment_type_id10" id="equipment_type_id10" value="10">
   <input type="text" class="form-control btn-point" name="number_of_foam" id="number_of_foam" aria-describedby="text" placeholder="No. of foam" maxlength="3">
    <input type="hidden" name="equipment_id20" id="equipment_id20" value="20"> 
   
  </div>
  </div> 

  <div class="col-2 home_content pt-4">
  Sandbox
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="text" class="form-control btn-point" name="number_of_fixed_sandbox" id="number_of_fixed_sandbox" aria-describedby="text" placeholder="No. of fixed sandbox" maxlength="3">
    <input type="hidden" name="equipment_id21" id="equipment_id21" value="21">
  </div>
  </div> 
</div> 


<div class="row listrow">
  <div class="col-1 home_content pt-4">
  Heaving line
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
  <input type="text" class="form-control btn-point" name="heaving_line_count" id="heaving_line_count" aria-describedby="text" placeholder="No. of heaving line" maxlength="3">
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
  Oars
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
 <input type="text" class="form-control btn-point" name="oars" id="oars" aria-describedby="text" placeholder="No. of oarsline" maxlength="3">
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
  Fire axe
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="text" class="form-control btn-point" name="fire_axe" id="fire_axe" aria-describedby="text" placeholder="No. of fire axe" maxlength="3">
  </div>
  </div> 
</div> 



<div class="row listrow">
  <div class="col-1 home_content pt-4">
 Insurance expiry date
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
<input type="date" class="form-control btn-point dob" name="insurance_expiry_date" id="insurance_expiry_date" aria-describedby="text" value="<?php echo date('Y-m-d'); ?>" maxlength="10">
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
  PCB certificate number
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  <input type="text" class="form-control btn-point" name="pcb_certificate_number" id="pcb_certificate_number" aria-describedby="text" placeholder=" PCB certificate number" maxlength="50">
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
  PCB expiry date
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
 <input type="date" class="form-control btn-point dob" name="pcb_expiry_date" id="pcb_expiry_date" aria-describedby="text" value="<?php echo date('Y-m-d'); ?>" maxlength="10">
  </div>
  </div> 
</div> 




<div class="row listrow">
  <div class="col-1 home_content pt-4">
 Number of bed rooms
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
 <input type="text" class="form-control btn-point" name="number_of_bedrooms" id="number_of_bedrooms" aria-describedby="text" placeholder="No. of bed" maxlength="3">
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
&nbsp;
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  &nbsp;
  </div>
  </div> 
  <div class="col-2 home_content pt-4">
  &nbsp;
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  &nbsp;
  </div>
  </div> 
</div> 


<!-- end of listrow2 -- Survey row -->
<div class="row listrow">
  <div class="col-12 d-flex justify-content-end">
    <input type="submit" class="btn btn-success btn-point btn-flat" name="btnsubmit" id="btnsubmit" value="Save Vessel Details">
  </div> <!-- end of col12 -->
<!-- end of listrow2 -- Survey row -->
</div> <!-- end of container fluid -->


</div> <!-- end of showcontent div -->

</form>

<!-- --------------------------------------------------End of Main Div ----------------------------------------------------- -->
<!-- ---------------------------------------------- Footer TAB  ------------------------------------------------------------->
<div class="row ">
<div class="port-content-footer col-4 footer_heading">
    <div class="footer-col">
<p class="home_title_w footer_link"> Contact </p>
<p class="home_content_w footer_link" >
Kerala Maritime Board
</p>
<p class="home_content_w footer_link">
Vallakadavu, 
</p>
<p class="home_content_w footer_link">
Valiyathura 
</p>
<p class="home_content_w footer_link" >
Thiruvananthapuram 
</p>
<p class="home_content_w footer_link">
Kerala 
</p>
<p class="home_content_w footer_link">
Pin: 695001
</p>
<p class="home_content_w footer_link">
Phone : 0471-2380910
</p>
<p class="home_content_w footer_link">
Email Id: cdit@cdit.org
</p>
 </div> <!-- footer col div -->
</div> <!-- end of col 4 footer -->
<div class="port-content-footer col-4 footer_heading">
     <div class="footer-col">
<p class="home_title_w footer_link">Disclaimer 
  </p>
<p class="home_content_w footer_link">
About the Portal
</p>
<p class="home_content_w footer_link">
Terms of Use
</p>
<p class="home_content_w footer_link">
Accessibility Statement
</p>
<p class="home_content_w footer_link">
Disclaimer
</p>
<p class="home_content_w footer_link">
Copyright
</p>
 </div> <!-- footer col div -->
</div> <!-- end of col 4 footer -->
<div class="port-content-footer col-4 footer_heading">
     <div class="footer-col">
<p class="home_title_w footer_link"> Terms &amp; Conditions </p>
                <p class="home_content_w footer_link"> Guidelines for booking sand pass </p>
                <p class="home_content_w footer_link"> Guidelines for registering as new vessel owner </p>
                <p class="home_content_w footer_link"> Guidelines on internet banking </p>
 </div> <!-- footer col div -->
</div> <!-- end of col 4 footer -->
<div class="col-12 port-content-footer footer-col text-center copyright">
<p class="home_content_w">Copyright @ Kerala Martime Board &nbsp; &nbsp; &nbsp; Designed and Developed by C-DIT </p>
</div>
</div> <!-- end of footer row -->
<!-- ---------------------------------------------- End of Footer TAB  -------------------------------------------------->
</div> <!-- -----------------------end of container fluid ------------------ -->  
</body>

<script src="<?php echo base_url(); ?>plugins/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/icheck.min.js"></script>

<script src="<?php echo base_url(); ?>plugins/js/inputmask.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fontawesome/js/all.min.js"></script>

<script>

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2({ width: '100%' });
    $('.js-example-basic-single').select2({ width: '100%' });
});


   $(document).ready(function() {
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
    increaseArea: '20%' // optional
  });


} ); // end of ready function 

  (function($){ 
  $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
})(jQuery);
</script>

<script type="text/javascript">
$(document).ready(function() 
{
  $("#vessel_type_id").change(function()
  {
    var vessel_type_id=$("#vessel_type_id").val();
    if(vessel_type_id != '')
    { 
      $.ajax
      ({
      type: "POST",
      url:"<?php echo site_url('Kiv_Ctrl/DataEntry/vessel_subtype/')?>"+vessel_type_id,
      success: function(data)
      {         
      $("#vessel_subtype_id").html(data);
      }
      });
    }
  });

$("#user_name").change(function(){

var user_name=$("#user_name").val();
//alert(user_name.length);

if(user_name.length<4)
{
   alert("Name should contain atleast 4 characters");
        $("#user_name").val('');
        $("#user_name").focus();
}

});

$("#user_address").change(function(){

var user_address=$("#user_address").val();

if(user_address.length<10)
{
   alert("Address should contain atleast 10 characters");
        $("#user_address").val('');
        $("#user_address").focus();
}

});


$("#user_mobile_number").change(function(){
    var mob=$("#user_mobile_number").val();

    var mob_length = mob.length; 
    if(mob_length<10)
    {
      alert('Please enter 10 digit mobile number');
      $("#user_mobile_number").val('');
     // $("#user_mobile_number").focus();
      return false;
    }

 if(mob!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('/Kiv_Ctrl/Registration/mobileverify')?>",
            data: { mob: mob,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("This mobile number already exists");
                $("#user_mobile_number").val('');
                $("#user_mobile_number").focus();
              }
             }
       });  
     }

  });

$("#user_email").change(function(){
    var email_id=$("#user_email").val();
   if(email_id!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('/Kiv_Ctrl/Registration/email_id_verify')?>",
            data: { email_id: email_id,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("This Email Id  already exists");
                $("#user_email").val('');
                $("#user_email").focus();
                 
              }
             }
       });  
     }
       
 });  

$('#add').click(function() {
  var cou=parseInt(document.getElementById('cnt').value);
  var incr=cou+1;
  var d="addrow_mr"+incr;
  document.getElementById('cnt').value=incr;

  var master_cnt=parseInt(document.getElementById('master_cnt').value);
  document.getElementById('master_cnt').value=master_cnt+1;

   $('#optionBox_mr').append('<div class="row listrow" id="addrow'+incr+'"><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="name_of_type_mr[]" id="name_of_type_mr" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="license_number_of_type_mr[]"  id="license_number_of_type_mr" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 pt-5"><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove('+incr+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
});

$('#add_sg').click(function() {
  var cou=parseInt(document.getElementById('cnt_sg').value);
  var incr_sg=cou+1;
  var d="addrow_sg"+incr_sg;
  document.getElementById('cnt_sg').value=incr_sg;

  var serang_cnt=parseInt(document.getElementById('serang_cnt').value);
  document.getElementById('serang_cnt').value=serang_cnt+1;

  
    $('#optionBox_sg').append('<div class="row listrow" id="addrow_sg'+incr_sg+'"><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="name_of_type_sg[]" id="name_of_type_sg" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="license_number_of_type_sg[]"  id="license_number_of_type_sg" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 pt-5"><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_sg('+incr_sg+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
});

$('#add_lr').click(function() {
  var cou=parseInt(document.getElementById('cnt_lr').value);
  var incr_lr=cou+1;
  var d="addrow_lr"+incr_lr;
  document.getElementById('cnt_lr').value=incr_lr;

   var lascar_cnt=parseInt(document.getElementById('lascar_cnt').value);
  document.getElementById('lascar_cnt').value=lascar_cnt+1;


    $('#optionBox_lr').append('<div class="row listrow" id="addrow_lr'+incr_lr+'"><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="name_of_type_lr[]" id="name_of_type_lr" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="license_number_of_type_lr[]"  id="license_number_of_type_lr" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 pt-5"><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_lr('+incr_lr+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
});

$('#add_dr').click(function() {
  var cou=parseInt(document.getElementById('cnt_dr').value);
  var incr_dr=cou+1;
  var d="addrow_dr"+incr_dr;
  document.getElementById('cnt_dr').value=incr_dr;

   var driver_cnt=parseInt(document.getElementById('driver_cnt').value);
  document.getElementById('driver_cnt').value=driver_cnt+1;


    $('#optionBox_dr').append('<div class="row listrow" id="addrow_dr'+incr_dr+'"><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="name_of_type_dr[]" id="name_of_type_dr" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point" name="license_number_of_type_dr[]"  id="license_number_of_type_dr" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 pt-5"><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_dr('+incr_dr+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
});
$('.txtcapital').keyup(function() {
        this.value = this.value.toUpperCase();
    });

//_______________Jquery ending_______________________//  
});


function remove(txt)
{
  $('#addrow_mr'+txt).remove();
  var  master_cnt=document.getElementById('master_cnt').value;
  document.getElementById('master_cnt').value=master_cnt-1;
}

function remove_sg(txt)
{
  $('#addrow_sg'+txt).remove();
  var  serang_cnt=document.getElementById('serang_cnt').value;
  document.getElementById('serang_cnt').value=serang_cnt-1;
}

function remove_lr(txt)
{
  $('#addrow_lr'+txt).remove();
  var  lascar_cnt=document.getElementById('lascar_cnt').value;
  document.getElementById('lascar_cnt').value=lascar_cnt-1;
}

function remove_dr(txt)
{
  $('#addrow_dr'+txt).remove();
  var  driver_cnt=document.getElementById('driver_cnt').value;
  document.getElementById('driver_cnt').value=driver_cnt-1;
}

function IsNumeric(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
  {
    return true;
  }
  else 
  {
    window.alert("This field accepts only numbers");
    return false;
  }
}

function alpbabetspace(e) {
     var k;
     document.all ? k = e.keyCode : k = e.which;
     return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==32);
}

function validateEmail(email) {
 
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( email ) ) {
      alert("Invalid Email");
      document.getElementById('user_email').value='';
        return false;
    } else {
        return true;
    }
}

function IsAddress(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ((unicode == 32) || (unicode == 44) || (unicode == 47) || (unicode == 40) || (unicode == 41) || (unicode == 45) || (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode > 96 && unicode < 123) || (unicode==8) || (unicode==46) ) 
        {
                return true;
        }
        else 
        {
              window.alert("Not Allowed");
                return false;  
        }
        }    
 function IsAlphanumeric(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
       if ( (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode==47) || (unicode == 45) || (unicode == 8))  
        {
                return true;
        }
        else 
        {
                window.alert("This field accepts Capital letters(A-Z), numbers with hyphen(-) and slash (/) ");
                return false;
        }
        }


function alphaNumeric(e) 
{
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || (k > 47 && k < 58) || k == 45 || k==32);
} 

    function checklength(id)
{
  var strvalue=document.getElementById(id).value;  
  //alert(strvalue);
    var len=strvalue.length;
  if(len<4)
  {
    alert("Minimum 4 character");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}
</script>



</html>


