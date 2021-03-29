


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/dataentry_style.css">
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
                <a class="nav-link main_link_b" href="<?php echo base_url(); ?>plugins/mal.php"><img src="<?php echo base_url(); ?>plugins/img/india.png" style="width: 20%; height: 20%;"> Malayalam</a>
              </li>
              <li class="nav-item">
                <a class="nav-link main_link_b" href="<?php echo base_url()."index.php/Kiv_Ctrl/DataEntry/dataentry"?>">Data Entry</a>
              </li>
              <li class="nav-item">
                <a class="nav-link main_link_b" href="#">Notifications</a>
              </li>
              <li class="nav-item " id="lastnav">
                <a href="#about" class="btn btn-primary btn-flat btn-sm sub_link_w"><i class="fas fa-file-pdf"></i>&nbsp;KIV Forms</a>
              </li>
            </ul>
          </div>
        </nav>
    </section>
<!----------------------------------------------- end of navbar section -------------------------------------------------------->
<!-- ------------------------------------------------------------ Main Div ----------------------------------------------------- -->
<div class="container-fluid">

  <form name="form1" id="form1" method="post" action="">
    <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/DataEntry/dataentry", $attributes);
?>

<div class="row">
<div class="col-5 d-flex justify-content-end pt-2">
     <p class="home_subtitle"> KIV Number </p>
</div>  
<div class="col-4 d-flex justify-content-left">
          <div class="input-group mb-3">
            <input type="text" class="form-control home_content" placeholder="E.g. : KIV/KLM/PV/75/2018" aria-label="kiv number" aria-describedby="basic-addon2" name="vessel_registration_number" id="vessel_registration_number">
            <div class="input-group-append">
               <button class="btn btn-warning btn-flat btn-point home_content" type="button">Search Vessel</button>
            </div>
        </div>
</div> <!-- end of col12 search -->
<div class="col-2"><a href="<?php echo base_url()."index.php/Kiv_Ctrl/DataEntry/addform"?>" class="btn btn-success btn-flat btn-point"><i class="fas fa-plus"></i>&nbsp;Add New Vessel</a></div>
</div> <!-- end of row -->

<!-- </form> --> <?php echo form_close(); ?>


 <!--  <div id="noresult">
    <div class="row">
      <div class="col-12">
        <div class="alert alert-success" role="alert">
          No result for the queried KIV Number.
        </div>
      </div>
    </div>
  </div>  -->

  <!-- end of nosresult div -->

<div id="show_vessel"></div>

 


<!-- end of showcontent div -->
<!-- end of listrow2 -- Survey row -->
</div> <!-- end of container fluid -->
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
<script src="<?php echo base_url(); ?>plugins/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fontawesome/js/all.min.js"></script>
</html>


<script language="javascript">
    
$(document).ready(function(){
$("#vessel_registration_number").change(function(){
  var regnum=$("#vessel_registration_number").val();
 
  var encregnum1=btoa(regnum);


 var encregnum = encregnum1.split("=").join("~");
  
      $.ajax({
      url : "<?php echo site_url('DataEntry/show_vessel/')?>"+encregnum,
      type: "POST",
      data:$('#form1').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
       // alert(data);
        if(data)
        {
          $("#show_vessel").html(data).find(".select2").select2(); 
        }
      }
    });
});

});

  </script>