<?php
/********************************************************************/
 $code=rand(1000,9999);
  $_SESSION["cap_code"]=$code;
 /*******************************************************************/
 /********************************************************************/
 $contactcode=rand(1000,9999);
  $_SESSION["contactcap_code"]=$contactcode;
 /*******************************************************************/


?>

<div class="container-fluid">
  <?php $attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1" , "novalidate"); 
              echo form_open("Main_login/index", $attributes);  
  ?>
  <div class="row " >

      <div class="port-content-noborder  col-lg-8 col-md-8 port-bg-lightgray ">
        <?php if(isset($reg)){  foreach($reg as $reg_res){ $reg_title = $reg_res['bodycontent_engtitle']; $reg_maltitle= $reg_res['bodycontent_maltitle']; $reg_content = $reg_res['bodycontent_engcontent']; $reg_malcontent = $reg_res['bodycontent_malcontent'];}}?>
              <p class="bcontentfont"><?php if(isset($val)){ echo $reg_maltitle; } else {echo $reg_title;}?></p>
              <p class="contentfont"><?php if(isset($val)){ echo $reg_malcontent;} else {echo $reg_content;}?>
              <!-- Sand pass, spot booking, New vessel owner registration --></p>
              <ul class="list-group">
                <?php if(isset($reg_items)){  foreach($reg_items as $regitems_res){ $reg_title = $regitems_res['bodycontent_engtitle']; $reg_maltitle= $regitems_res['bodycontent_maltitle']; $reg_icon = $regitems_res['bodycontent_icon']; $reg_link = $regitems_res['bodycontent_link']; $reg_order = $regitems_res['bodycontent_order'];?>
                <li class="list-group-item "> <a href="<?php echo base_url()."index.php/$reg_link"?>" class="btn btn-flat btn-block btn-point btn-default contentfont"><i class="<?php echo $reg_icon;?>"></i> &nbsp;<?php if(isset($val)){ echo $reg_maltitle; } else {echo $reg_title;}?> </a> </li>
              <?php }}?>

              <!-- <li class="list-group-item "> <a href="#" class="btn btn-flat btn-block btn-point btn-default contentfont"><i class="fas fa-house-damage"></i> &nbsp; New customer registration for sand pass </a> </li>
              <li class="list-group-item"> <a href="#" class="btn btn-flat btn-block btn-point btn-default contentfont"><i class="fas fa-door-open"></i> &nbsp; Spot booking / Door bookingvvv </a> </li>
              <li class="list-group-item"><a href="<?php echo base_url()."index.php/Kiv_Ctrl/Registration/NewUser_Registration"?>" class="btn btn-flat btn-block btn-point btn-default contentfont"> <i class="fas fa-ship"></i> &nbsp;New vessel owner registrationvv</a> </li> -->
            </ul>
      </div> <!-- end of col 8 ----- -->
      <div class="port-content-noborder  col-lg-4 col-md-4 port-bg-blue ">

              <p class="bcontentfont"> <?php if(isset($val)){ ?> നിലവിലുള്ള ഉപയോക്തൃ ലോഗിൻ <?php } else {?> Existing User Login <?php }?></p>
                  <div class="col-md-12 col-lg-12">

                     <?php if( $this->session->flashdata('msg')){ 
        echo $this->session->flashdata('msg');
       }?>
                    <fieldset class="form-group">
                        <label for="name" class="contentfont"><?php if(isset($val)){ ?> ഉപയോക്തൃനാമം <?php } else {?> Username <?php }?></label>
                        <input type="text" class="form-control" id="vch_un" name="vch_un" placeholder="<?php if(isset($val)){ ?> ഉപയോക്തൃനാമം <?php } else {?> Username <?php }?>">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="email" class="contentfont"><?php if(isset($val)){ ?> പാസ്സ്‌വേർഡ്  <?php } else {?> Password <?php }?></label>
                        <input type="password" autocomplete="new-password"  class="form-control" name="vch_pw" id="vch_pw" placeholder="<?php if(isset($val)){ ?> പാസ്സ്‌വേർഡ്  <?php } else {?> Password <?php }?>">
                    </fieldset>
                     <fieldset class="form-group">
      <label class="contentfont">Please enter the code<font color="#FF0000">*</font></label><br>
      <input name="captcha" type="text" class="validate[required,custom[onlyLetterNumber]]"  id="captcha" autocomplete="off"  placeholder="Enter Captcha" size="10" maxlength="4" style="text-align:center" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" required="true" title="Please Enter the Captcha !!!!">
          <?php $rr=base64_encode($_SESSION['cap_code']);?>
           <img src="<?php echo base_url()?>captcha.php?id=<?php echo $code; ?>" id="capchaimg"/> &nbsp;
             <input name="pass2" type="hidden" class="tb4" id="pass2" size="24"  value=<?php echo $rr;?>>
             
          <img src="<?php echo base_url()?>plugins/img/Refresh.png"  style="cursor:pointer" id="captchareload"  >
      </fieldset>
                    <button type="submit" class="btn btn-danger opaqueclass btn-flat btn-point btn-block home_linkhead_w" name="login"  id="login" onclick="return validate()" ><i class="fas fa-sign-in-alt"></i>&nbsp; <?php if(isset($val)){ ?> ലോഗിൻ <?php } else {?> Login <?php }?> </button>

                    <a align="right" class="badge bg-warning text-white" href="<?php echo base_url()."index.php/Main_login/forget_pw"?>">Forgot password ?</a>
                </div>   <!-- end of inner col12 --->
      </div> <!-- end of col 4 ------->
  </div> <!-- end of row ------------ >
 <?php echo form_close(); ?>
<!-- -----------------------------------End of LOGIN AND REGISTRATION TAB ------------------->
<!-- ---------------------------------------------Services TAB --------------------------->
<div class="row ">
            <div class="port-content-head col-12 no-gutters">
              <button type="button" class="btn btn-point btn-flat btn-block btn-primary bcontentfont nocursor"><i class="fab fa-servicestack"></i>&nbsp;<?php if(isset($val)){ ?> സേവനങ്ങൾ <?php } else {?> Services <?php }?></button>
          </div> <!-- end of heading col12 -->

          <?php if(isset($services)){  foreach($services as $services_res){ $ser_sl = $services_res['services_sl']; $ser_title = $services_res['services_engtitle']; $ser_maltitle= $services_res['services_maltitle']; 
           if($ser_sl==1){ $bg = "port-bg-red"; $icon = "fas fa-truck"; $desc="Apply for sand pass using building permit, aadhar details for construction and repair."; $desc_mal ="തദ്ദേശസ്വയംഭരണ സ്ഥാപനങ്ങൾ, പോർട്ട് ഓഫീസ് എന്നിവയുടെ കീഴിലെ കടവുകളിൽ നിന്ന് മണലിനായ് പൊതുജനങ്ങൾക്ക് അപേക്ഷിക്കാം.";} 
           else if($ser_sl==2){ $bg = "port-bg-blue"; $icon = "fas fa-ship"; $desc="Vessels owners can apply for survey, registration, duplicate certificate, registration book."; $desc_mal ="ബോട്ടുകൾ, വള്ളങ്ങൾ എന്നിവയുടെ നിർമ്മാണാനുമതി, സർവ്വേ, രജിസ്ട്രേഷൻ  സേവനങ്ങൾക്കായി ഉടമകൾക്ക് അപേക്ഷിക്കാം.";} 
           else if($ser_sl==3){ $bg = "port-bg-green"; $icon = "fas fa-certificate"; $desc="Apply for competency certificates for Drivers, Lascar and other crew members of vessel."; $desc_mal ="ബോട്ടുകൾ വള്ളങ്ങൾ എന്നിവയിലെ ഡ്രൈവർമാർ, ലസ്‌കർ, സ്രാങ്ക് കാര്യക്ഷമത സർട്ടിഫിക്കറ്റിനായി അപേക്ഷിക്കാം.";} 
           else if($ser_sl==4){ $bg = "port-bg-yellow"; $icon = "fas fa-anchor"; $desc="Apply for Berthing os ships, Cargo loading and unloading, Clearance, Storage facilities at ports."; $desc_mal ="ബർത്തിങ്ങ്, കാർഗോ കയറ്റിറക്കുമതി, കാർഗോ ക്ളിയറൻസ്, സ്റ്റോറേജ് സൗകര്യങ്ങൾ എന്നിവയ്ക്ക് അപേക്ഷിക്കാം.";}?>

            <div class="port-content col-lg-3 col-md-6 <?php echo $bg;?>">
                <p class="bcontentfont"><i class="<?php echo $icon;?>"></i>&nbsp;<?php if(isset($val)){ echo $ser_maltitle; } else { echo $ser_title; }?></p>
                <p class="contentfont"> <?php if(isset($val)){ echo $desc_mal; } else { echo $desc; }?></p>
            </div>
           <?php }}?> 
              <!-- <div class="port-content col-lg-3 col-md-6 port-bg-red">
                <p class="bcontentfont"><i class="fas fa-truck"></i>&nbsp;Sand Pass</p>
                <p class="contentfont"> Apply for sand pass using building permit, aadhar details for construction and repair.</p>
            </div>
            <div class="port-content col-lg-3 col-md-6 port-bg-blue">
                <p class="bcontentfont"><i class="fas fa-ship"></i>&nbsp;Kerala Inland Vessel</p>
                <p class="contentfont"> Vessels owners can apply for survey, registration, duplicate certificate, registration book. </p>
            </div>
            <div class="port-content col-lg-3 col-md-6 port-bg-green">
                <p class="bcontentfont"><i class="fas fa-certificate"></i>&nbsp;Competency Certificate</p>
                <p class="contentfont"> Apply for competency certificates for Drivers, Lascar and other crew members of vessel. </p>
            </div>
            <div class="port-content col-lg-3 col-md-6 port-bg-yellow">
                <p class="bcontentfont"><i class="fas fa-anchor"></i>&nbsp;Landing &amp; Shipping </p>
                <p class="contentfont"> Apply for Berthing os ships, Cargo loading and unloading, Clearance, Storage facilities at ports. </p>
            </div>  -->
 </div>
<!-- ---------------------------------------------End of Services TAB -------------------------->
<!-- --------------------------- Statistics TAB  ----------------------------------------------->
<div class="row ">
            <div class="port-content-head col-12 no-gutters">
              <button type="button" class="btn btn-point btn-flat btn-block btn-default bcontentfont nocursor"><i class="fas fa-chart-pie"></i>&nbsp;<?php if(isset($val)){ ?> നിലവിലെ സ്ഥതിവിവരകണക്കുകൾ  <?php } else {?> Statistics <?php }?></button>
          </div> <!-- end of heading col12 -->
                        <div class="port-content col-lg-2 col-md-2 port-bg-lightgray text-center">
                <i class="fas fa-ticket-alt"></i>           
                <h2>54321</h2>
                <p class="contentfont"><?php if(isset($val)){ ?> മണൽ പാസ്സുകൾ  <?php } else {?> Sand Passes issued <?php }?></p>
            </div>

            <div class="port-content col-lg-2 col-md-2 port-bg-lightgray text-center">
                <i class="fas fa-weight"></i>
                <h2>54321</h2>
                <p class="contentfont"><?php if(isset($val)){ ?> ടൺ മണൽ  <?php } else {?> Quantity of sand issued <?php }?></p>
            </div>

            <div class="port-content col-lg-2 col-md-2 port-bg-lightgray text-center">
                <i class="far fa-building"></i>
                <h2><?php if(isset($cnt_port)){ echo $cnt_port;}?></h2>
                <p class="contentfont"><?php if(isset($val)){ ?> തുറമുഖ ഓഫീസുകൾ <?php } else {?> Port Offices <?php }?></p>
            </div>

            <div class="port-content col-lg-2 col-md-2 port-bg-lightgray text-center">
                <i class="fas fa-ship"></i>
                <h2>10231</h2>
                <p class="contentfont"><?php if(isset($val)){ ?> രജിസ്റെർഡ്  വള്ളങ്ങൾ <?php } else {?> Registered Vessels <?php }?></p>
            </div>

            <div class="port-content col-lg-2 col-md-2 port-bg-lightgray text-center">
                <i class="fas fa-door-open"></i>
                <h2>7536</h2>
                <p class="contentfont"><?php if(isset($val)){ ?> തൽസമയ ബുക്കിങ്ങ് <?php } else {?> Spot booking done <?php }?></p>
            </div>

            <div class="port-content col-lg-2 col-md-2 port-bg-lightgray text-center">
                <i class="fas fa-chalkboard-teacher"></i>
                <h2>1563218</h2>
                <p class="contentfont"><?php if(isset($val)){ ?> ഉപഭോക്താക്കൾ <?php } else {?> Customers <?php }?></p>
            </div>
 </div>
<!-- ------------------------------- End of Statistics TAB  ---------------------------------------->
<!-- --------------------------------- TRACK TAB  -------------------------------------------------->
<div class="row ">
 <div class="port-content col-4 port-bg-gray">
          <p class="bcontentfont darkfont"> <?php if(isset($val)){ ?> നിങ്ങളുടെ രസീത്/അന്വേഷണങ്ങൾ ട്രാക്ക് ചെയ്യാം <?php } else {?> Track your receipt / activity <?php }?> </p>
          <div class="input-group mb-3">
            <input type="text" name="reference_number" id="reference_number" class="form-control home_content" placeholder="E.g. : #1235089" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
               <button name="track_ref_number" id="track_ref_number" class="btn btn-warning btn-flat btn-point contentfont" type="button"><?php if(isset($val)){ ?> വിവരം ലഭ്യമാക്കുക <?php } else {?> View Details <?php }?></button>
            </div>
        </div>
      </div> <!-- end of col 4 div -->

      <div class="port-content col-4 port-bg-gray">
          <p class="darkfont bcontentfont "> <?php if(isset($val)){ ?> ബോട്ടുകൾ വള്ളങ്ങളുടെ വിവരങ്ങൾ അന്വേഷിക്കാം <?php } else {?> Track a vessel <?php }?> </p>
          <div class="input-group mb-3">
            <input type="text" name="vessel_registration_number" id="vessel_registration_number" class="form-control home_content" placeholder="E.g. : KIV/BYP/PV/1/2019" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
            <button name="track_vessel" id="track_vessel" class="btn btn-warning btn-flat btn-point contentfont" type="button"><?php if(isset($val)){ ?> വിവരം ലഭ്യമാക്കുക <?php } else {?> View Details <?php }?></button>
            </div>
        </div>
      </div> 

      <!-- end of col 4 div -->

        <div class="port-content col-4 port-bg-gray">
          <p class="darkfont bcontentfont"> <?php if(isset($val)){ ?> മണൽ പാസിന്റെ വിവരങ്ങൾ അന്വേഷിക്കാം <?php } else {?> Track sand pass receipts <?php }?></p> 
          <div class="input-group mb-3">
            <input type="text" class="form-control home_content" placeholder="E.g. : 13467/09" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
               <button class="btn btn-warning btn-flat btn-point contentfont" type="button"><?php if(isset($val)){ ?> വിവരം ലഭ്യമാക്കുക <?php } else {?> View Details <?php }?></button>
            </div>
        </div>
      </div> <!-- end of col 4 div -->
 </div>
<!-- ---------------------------------------------- End of Track TAB  ------------------------------------>
<div class="row">
  <?php $attributes = array("class" => "form-horizontal", "id" => "form_tariff", "name" => "form_tariff" , "novalidate"); 
              echo form_open("Main_login/index", $attributes);  
  ?>
  <div class="col-lg-6 col-md-6 port-content tariffdiv">
     <div class="alert alert-dark" role="alert">
  <p class="bcontentfont text-primary"><?php if(isset($val)){ ?> താരിഫ് കാൽക്കുലേറ്റർ  <?php } else {?> Tariff Calculator <?php }?></p>
</div>
    <div class="row">
      <div class="col-lg-6 col-md-6 port-content-noborder">
         <label for="budget " class="contentfont"><?php if(isset($val)){ ?> വെസ്സൽ ടൈപ്പ്  <?php } else {?> Vessel Type <?php }?></label>
          <select class="form-control contentfont" name="vesselType_name" id="vesselType_name">
            <?php foreach($vesselType as $vesl_typ_res){
                $mal_name = $vesl_typ_res['vesseltype_mal_name']; 
                $name     = $vesl_typ_res['vesseltype_name']; 
              ?>
              <option value="<?php echo $vesl_typ_res['vesseltype_sl'];?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?> </option>
            <?php }?>  
              
          </select> 
      </div> <!-- end of inner col1 -->
      <div class="col-lg-6 col-md-6 port-content-noborder">
           <label for="budget" class="contentfont"><?php if(isset($val)){ ?> വെസ്സൽ സബ്‌ടൈപ്പ് <?php } else {?> Vessel Subtype<?php }?></label>
           <input type="hidden" name="val" id="val" value="<?php if(isset($val)){ echo $val; } else { echo "2";}?>">
                <select name="vessel_subtype_name" id="vessel_subtype_name" class="form-control " style="width: 100%;" >
                  <option value="">Select Vessel SubType</option>                  
                </select>
      </div> <!-- end of inner col2 -->
    </div> <!-- end of inner row -->

    <div class="row">
      <div class="col-lg-6 col-md-6 port-content-noborder">
        <label for="budget" class="contentfont"><?php if(isset($val)){ ?> ആക്‌റ്റിവിറ്റി <?php } else { ?> Activity<?php } ?> </label>
        <input type="hidden" name="val" id="val" value="<?php if(isset($val)){ echo $val; } else { echo "2";}?>">
                        <select class="form-control " style="width: 100%;" id="surveyName" name="surveyName" >
                  <option value="">Select Survey Type</option> 
                  <?php foreach($surveyType as $survey){ 
                    $mal_name = $survey['survey_mal_name']; 
                    $name     = $survey['survey_name']; 

                    ?>
                  <option value="<?php echo $survey['survey_sl']; ?>" id="<?php echo $survey['survey_sl']; ?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?></option>
                  <?php }  ?>
                </select>
      </div> <!-- end of inner col1 -->
      <div class="col-lg-6 col-md-6 port-content-noborder">
         <label for="budget" class="contentfont"><?php if(isset($val)){ ?> ഫോം  <?php } else {?> Form<?php }?> </label>
                        <select class="form-control " style="width: 100%;" id="formtypeName" name="formtypeName">
                  <option value="">Select Form</option> 
                  <?php foreach($formName as $form){ 
                    $mal_name = $form['document_type_mal_name']; 
                    $name     = $form['document_type_name'];
                    ?>
                  <option value="<?php echo $form['document_type_sl']; ?>" id="<?php echo $form['document_type_sl']; ?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?></option>
                  <?php }  ?>
                </select>
      </div> <!-- end of inner col2 -->
    </div> <!-- end of inner row -->
    <div class="row">
        <div class="input-group col-lg-6 col-md-6 port-content-noborder">
        <input type="text" class="form-control" placeholder="Specify tonnage" name="tonnage" id="tonnage" aria-label="Tonnage" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon2">Ton</span>
        </div>
      </div>
    </div>
     <div class="row">
      <!-- <div class="col-lg-6 col-md-6 port-content-noborder">
        <label for="budget" class="contentfont"><?php if(isset($val)){ ?> എഞ്ചിൻ ടൈപ്പ് <?php } else {?> Tonnage<?php }?> </label>
                        <input type="text" name="tonnage" id="tonnage" placeholder="Specify Tonnage">
      </div> -->  <!-- end of inner col1 -->
      <!-- <div class="col-lg-6 col-md-6 port-content-noborder">
         <label for="budget" class="contentfont"><?php if(isset($val)){ ?> ഹൾ സാമഗ്രി <?php } else {?> Hull Material<?php }?> </label>
                        <select class="form-control contentfont" id="budget">
                            <option>Aluminium</option>
                            <option>Wood</option>
                        </select>
      </div> -->
    </div>  <!-- end of inner row -->

    <!-- <div class="row"> -->
      <!-- <div class="col-lg-6 col-md-6 port-content-noborder">
                <label for="email" class="contentfont"><?php if(isset($val)){ ?> ഡെക്കിന്റെ നീളം <?php } else {?> Length of deck<?php }?></label>
                        <input type="email" class="form-control" id="email" placeholder="e.g. 10">
      </div> --> <!-- end of inner col1 -->
      <!-- <div class="col-lg-6 col-md-6 port-content-noborder">
         <label for="budget" class="contentfont"><?php if(isset($val)){ ?> ഉദ്ദേശ്യം <?php } else {?> Purpose<?php }?></label>
                        <select class="form-control contentfont" id="budget">
                            <option>Initial Survey - Form 01</option>
                            <option>Registration renewal</option>
                        </select>
      </div> --> <!-- end of inner col2 -->
    <!-- </div> --> <!-- end of inner row -->

    <div class="row">
      <div class="col-lg-12 col-md-12 port-content-noborder">
        <button type="button" name="tariff_calc" id="tariff_calc" class="btn btn-point  btn-dark text-white contentfont"><?php if(isset($val)){ ?> താരീഫ് കാൽക്കുലേറ്റ് ചെയ്യാം <?php } else {?> Calculate Tariff<?php }?></button>
      </div> <!-- end of inner col1 -->
    </div> <!-- end of inner row -->
    <div class="row">
      <div class="col-lg-12 col-md-12 port-content-noborder text-maroon" id="tariff_amt_div" >
      </div> <!-- end of inner col1 -->
    </div>
  </div> <!-- end of first main div6 -->
  <?php  echo form_close(); ?>  
  <div class="col-lg-6 col-md-6 port-content tariffdiv2 home_content">
    <div class="alert alert-dark" role="alert">
  <p class="bcontentfont text-primary"><?php if(isset($val)){ ?> സ്‌പോട്ട്‌ബുക്കിംഗിനായി പോർട്ട്‌വൈസ് അനുവദിച്ച ടൺ <?php } else {?> Portwise allotted ton for spotbooking<?php }?></p>
</div>
  <div class="table-responsive">
  <table class="table table-lg table-hover contentfont">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Port/Kadavu</th>
      <th scope="col">Allowed Ton</th>
      <th scope="col">Balance Ton</th>
    </tr>
  </thead>
  <tbody>
    <?php for($i=1;$i<=9;$i++) { ?> 
        <tr>
      <td> <?php echo $i; ?> </td>
      <td> <?php echo "Kappakadavu"; ?> </td>
      <td> 250 </td>
      <td> 120 </td>
    </tr>
  <?php } ?>
  </tbody>
  </table>
  <nav aria-label="...">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active" aria-current="page">
      <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
</div>
  </div> <!-- end of second main div -->
</div> <!-- end of row -->
<!-- ------------- ------- Service & Holiday TAB  -------------------------------------------------->
<div class="row">

     <div class="port-content-noborder col-lg-6 col-md-6 bg-mediumaquamarine">
      <div class="alert alert-light" role="alert">
  <p class="bcontentfont text-primary"><?php if(isset($val)){ ?> പോർട്ട് ഓഫീസുകളിൽ ലഭ്യമായ സേവനങ്ങൾ <?php } else {?> Services available at port offices<?php }?></p>
</div>
    
        <fieldset class="form-group">
            <label for="budget"  class="contentfont text-dark"><?php if(isset($val)){ ?> തുറമുഖ ഓഫീസ് <?php } else {?> Port Office<?php }?></label>
            <input type="hidden" name="val" id="val" value="<?php if(isset($val)){ echo $val; } else { echo "2";}?>">
                <select class="form-control contentfont" id="port" name="port">
                  <option value=""> SELECT PORT</option>
                  <?php foreach($ports as $port_res){ 
                    $mal_name = $port_res['portofregistry_mal_name']; 
                    $name     = $port_res['vchr_portoffice_name'];?>
                  <option value="<?php echo $port_res['int_portoffice_id']; ?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?></option>
                <?php } ?>
                  
                </select>
        </fieldset>
        <hr> 
        <!-- <a href="<?php echo base_url()."index.php/Main_login/get_port_services"?>" class="btn btn-point btn-dark contentfont"><?php if(isset($val)){ ?> വിവരങ്ങൾ ലഭ്യമാക്കുക <?php } else {?> View Details<?php }?></a> --> <br> 

         <ul class="list-group " id="port_services">
          </ul>
</div> <!-- end of col-6 -->

<div class="port-content-noborder col-lg-6 col-md-6 servicebg2">
  <div class="alert alert-light" role="alert">
  <p class="bcontentfont text-primary"><?php if(isset($val)){ ?> കടവുകളിലെ അവധി ദിവസങ്ങൾ <?php } else {?> Holidays at Zone/Kadav<?php }?></p>
</div>

        <fieldset class="form-group">
          <label for="budget"  class="contentfont"><?php if(isset($val)){ ?> തുറമുഖ ഓഫീസ് <?php } else {?> Port Office<?php }?></label>
                <select class="form-control contentfont" id="budget">
                  <option>Azhikkal</option>
                  <option>Beypur</option>
                </select>
        </fieldset>
        <fieldset class="form-group">
            <label for="budget" class="contentfont"><?php if(isset($val)){ ?> സോൺ/കടവ് <?php } else {?> Zone/Kadavu<?php }?></label>
              <select class="form-control contentfont" id="budget">
                  <option>Pappinissery</option>
                  <option>Kambil</option>
               </select>
        </fieldset> <hr>
        <a href="#contact" class="btn btn-point btn-dark contentfont"><?php if(isset($val)){ ?> കലണ്ടർ ലഭ്യമാക്കുക <?php } else {?> View Calendar<?php }?></a>  
        <ul class="list-group"><br>
          <li class="list-group-item contentfont"><?php if(isset($val)){ ?> കൂടുതൽ വിവരങ്ങൾക്ക് തുറമുഖ ഓഫീസുമായി ബന്ധപ്പെടുക. <?php } else {?> For more details contact respective port offices.<?php }?></li>
        </ul>
</div>
</div>
<!-- ---------------------------------------------- End of Service & Holiday TAB  -------------------------------------------------->
<!-- ---------------------------------------------- Zone TAB  -------------------------------------------------->
<div class="row">
<div class="port-content col-lg-4 col-md-4 bg-darkseagreen">
    <div class="alert alert-dark" role="alert">
  <p class="bcontentfont text-primary"><?php if(isset($val)){ ?> കടവ് കണ്ടെത്താം (തുറമുഖ ഓഫീസിനനുസൃതമായി) <?php } else {?> Locate zone/Kadavu by port office<?php }?></p>
</div>
        <fieldset class="form-group"> <br>
            <label for="budget"  class="contentfont text-dark"><?php if(isset($val)){ ?> തുറമുഖ ഓഫീസ് <?php } else {?> Port Office<?php }?></label>
                <select class="form-control contentfont" id="budget">
                  <option>Azhikkal</option>
                  <option>Beypur</option>
                </select>
        </fieldset>
        <a href="#contact" class="btn btn-dark btn-point btn-flat contentfont"><?php if(isset($val)){ ?> കടവുകളുടെ ലിസ്റ്റ് <?php } else {?>View Zone details<?php }?></a> 
 </div>
<div class="port-content col-lg-4 col-md-4 bg-tan ">
  <div class="alert alert-dark" role="alert">
  <p class="bcontentfont text-primary"><?php if(isset($val)){ ?> കടവ് കണ്ടെത്താം (തദ്ദേശ സ്വയംഭരണ സ്ഥാപനം ) <?php } else {?>Locate zone/Kadavu by LSG Department wise<?php }?></p>
</div>
        <fieldset class="form-group">
            <label for="budget" class="contentfont text-dark"><?php if(isset($val)){ ?> തദ്ദേശ സ്വയംഭരണ സ്ഥാപനം <?php } else {?>LSG Department<?php }?></label>
              <select class="form-control contentfont" id="budget">
                <option>Kolacherry Panchayath</option>
                <option>Beypur</option>
              </select>
        </fieldset>
        <a href="#contact" class="btn btn-dark btn-point btn-flat contentfont"><?php if(isset($val)){ ?> കടവുകളുടെ ലിസ്റ്റ് <?php } else {?>View Zone details<?php }?></a> 
</div>
<div class="port-content col-lg-4 col-md-4 bg-darkseagreen ">
  <div class="alert alert-dark" role="alert">
  <p class="bcontentfont text-primary"><?php if(isset($val)){ ?> തൽസമയ ബുക്കിങ്ങ് അനുവദനീയമായ കടവുകൾ <?php } else {?>List of Spot / Door booking available zones<?php }?></p>
</div>
      <fieldset class="form-group">
          <label for="budget"  class="contentfont text-dark"><?php if(isset($val)){ ?> തുറമുഖ ഓഫീസ് <?php } else {?> Port Office<?php }?></label>
                <select class="form-control contentfont" id="budget">
                  <option>Azhikkal</option>
                  <option>Beypur</option>
                </select>
      </fieldset>
      <a href="#contact" class="btn btn-dark btn-point btn-flat contentfont"><?php if(isset($val)){ ?> കടവുകളുടെ ലിസ്റ്റ് <?php } else {?> View Zone details<?php }?></a> 
</div> 
</div>
<!-- ---------------------------------------------- End of Zone TAB  -------------------------------------------------->
<!-- ---------------------------------------------- Contact TAB  -------------------------------------------------->
<div class="row">
   
<div class="port-content col-4 port-bg-lightgray" id="send_mail_div">
  <?php $attributes = array("class" => "form-horizontal", "id" => "mail", "name" => "mail" , "novalidate"); 
              echo form_open("Main_login/send_mail", $attributes);  
  ?> 
  <!-- <form action="#contact" method="post" id="contact-form"> -->
    <p class="bcontentfont text-primary"> <?php if(isset($val)){ ?> ബന്ധപ്പെടുക <?php } else {?>Contact Us<?php }?> </p>
    <fieldset class="form-group">
        <label for="subject" class="contentfont"><?php if(isset($val)){ ?> നിങ്ങളുടെ ഈമെയിൽ വിലാസം <?php } else {?>Your email id<?php }?></label>
          <input type="text" class="form-control loginfont" id="from_mail_id" name="from_mail_id" placeholder="<?php if(isset($val)){ ?>ഈമെയിൽ വിലാസം <?php } else {?> Email id <?php }?>">
          <input type="hidden" name="val" id="val" value="<?php if(isset($val)){ echo $val; } else { echo "2";}?>">
      </fieldset>
      <fieldset class="form-group">
        <label for="subject" class="contentfont"><?php if(isset($val)){ ?> സേവനങ്ങൾ <?php } else {?>Services<?php }?></label>
          <select class="form-control contentfont" id="services_mail" name="services_mail">
                  <option value=""> Select Service</option>
                  <?php foreach($services as $services_res){ 
                    $mal_name = $services_res['services_maltitle']; 
                    $name     = $services_res['services_engtitle'];?>
                  <option value="<?php echo $services_res['services_sl']; ?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?></option>
                <?php } ?>
                  
                </select>
      </fieldset>
      <fieldset class="form-group">
        <label for="subject" class="contentfont"><?php if(isset($val)){ ?> വിഷയം <?php } else {?>Subject<?php }?></label>
          <input type="text" class="form-control loginfont" id="subject" name="subject" placeholder="<?php if(isset($val)){ ?> വിഷയം <?php } else {?>Subject topic<?php }?>">
      </fieldset>
      <fieldset class="form-group">
        <label for="message" class="contentfont"><?php if(isset($val)){ ?> നിങ്ങളുടെ സന്ദേശം <?php } else {?>Your Message<?php }?></label>
           <textarea class="form-control loginfont" id="message" name="message" rows="4" placeholder="<?php if(isset($val)){ ?> നിങ്ങളുടെ സന്ദേശം <?php } else {?>Your Message<?php }?>"></textarea>
      </fieldset>
      <fieldset class="form-group">
      <label>Please enter the code<font color="#FF0000">*</font></label>
      <input name="contactcaptcha" type="text" class="validate[required,custom[onlyLetterNumber]]"  id="contactcaptcha" autocomplete="off"  placeholder="Enter Captcha" size="10" maxlength="4" style="text-align:center" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" required="true" title="Please Enter the Captcha !!!!">
          <?php $rr=base64_encode($_SESSION['contactcap_code']);?>
           <img src="<?php echo base_url()?>captcha.php?id=<?php echo $contactcode; ?>" id="capchaimg"/>
             <input name="contactpass" type="hidden" class="tb4" id="contactpass" size="24"  value=<?php echo $rr;?>>
             
          <img src="<?php echo base_url()?>plugins/img/Refresh.png"  style="cursor:pointer" id="captchareload"  >
      </fieldset>
      <button type="button" id="cntct_submit" name="cntct_submit" class="btn btn-dark btn-point contentfont"><?php if(isset($val)){ ?> അയക്കുക <?php } else {?>Submit<?php }?></button>
  <!-- </form> -->
  <?php echo form_close();?>
</div>
<div class="port-content alert col-4 port-bg-lightgray text-maroon" id="success_mail_div" style="display: none;"></div>

<div class="port-content col-4 port-bg-lightgray">
   <p class="bcontentfont text-primary"> <?php if(isset($val)){ ?> തുറമുഖ ഓഫീസുകൾ അറിയാൻ  <?php } else {?>Locate Port Office<?php }?> </p>
      <form action="#contact" method="post" id="contact-form">
                    <fieldset class="form-group ">
                      <label for="budget " class="contentfont"><?php if(isset($val)){ ?> ഓഫീസ് തിരഞ്ഞെടുക്കുക  <?php } else {?>Select Office<?php }?> </label>
                        <!-- <select class="form-control contentfont" id="budget">
                            <option>Head Office</option>
                        </select> -->
<input type="hidden" name="val" id="val" value="<?php if(isset($val)){ echo $val; } else { echo "2";}?>">
                        <select class="form-control contentfont" id="office" name="office">
                          <option value=""> Select Office</option>
                          <?php foreach($ports as $port_res){ 
                            $mal_name = $port_res['portofregistry_mal_name']; 
                            $name     = $port_res['vchr_portoffice_name'];
                            //$map      = $port_res['portoffice_map'];?>
                          <option value="<?php echo $port_res['int_portoffice_id']; ?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?></option>
                        <?php } ?>
                          
                        </select>
                    </fieldset>
                    <ul class="list-group contentfont" id="office_locate">
                    </ul>
      </form>
</div>
<div class="port-content col-4 port-bg-lightgray" style="display: none;" id="map_loca"  >
  <!-- <div id="map-container-google-9" class="z-depth-1-half map-container-5" >
            <iframe src="<?php //echo $map;?>" frameborder="0" height="250px;" style="border:0" allowfullscreen></iframe>

  </div> -->
</div>
<div class="port-content col-4 port-bg-lightgray" id="default_map">
  <div id="map-container-google-9" class="z-depth-1-half map-container-5" >
            <iframe src=" https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.611509550513!2d76.9624495496608!3d8.439755793901169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05a52aa94e35b7%3A0xb2bc2f81bdc7c7c7!2sCDIT%2C+Karinkadamugal%2C+Thiruvananthapuram%2C+Kerala+695027!5e0!3m2!1sen!2sin!4v1549270335292" frameborder="0" height="250px;" style="border:0" allowfullscreen></iframe>
  </div> 
</div>
</div>
<!-- ---------------------------- End of Contact TAB  -------------------------------------------------->

<!------------------------------ start of modal window --------------------->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="track_myModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="track_content">
    </div> <!-- end of modal content -->
  </div> <!-- end of modal dialog -->
</div> <!-- end of modal window -->
<!-- -------------------------- modal window ends here ------------ -->

<!------------------------------ start of modal window --------------------->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="track_ref_myModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="track_ref_content">
    </div> <!-- end of modal content -->
  </div> <!-- end of modal dialog -->
</div> <!-- end of modal window -->
<!-- -------------------------- modal window ends here ------------ -->
