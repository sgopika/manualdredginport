<?php
$sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
$customer_id = $this->session->userdata('customer_id');

$owner_details= 	$this->Survey_model->get_owner_details($customer_id);
$data['owner_details']	=	$owner_details;
if(!empty($owner_details))
{
  @$user_email           =  $owner_details[0]['user_email'];
  @$user_mobile_number   =  $owner_details[0]['user_mobile_number'];
}
//print_r($owner_details);



?>
<div class="row no-gutters  ui-color profilesection d-flex align-content-middle">
  <div class="col-12 mt-5">
<div class="alert alert-success mt-3" role="alert">
  You've got following notifications!
</div>
  </div>
  <div class="col-12">
	<div id="demo" class="carousel slide" data-ride="carousel">
<!-- Indicators -->
  <ul class="carousel-indicators">

   <!--  <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
    -->
    <li data-target="#demo" data-slide-to="0" class="active"></li>

    <?php 
    
    if($count!=0)
    {


    for($i=1;$i<$count; $i++) { ?>
    <li data-target="#demo" data-slide-to="<?php echo $i; ?>"></li>
    <?php } } ?>
    </ul>  
  <!-- The slideshow -->
 
    <div class="carousel-inner">
    <?php 
 //print_r($vessel_details);

    if(!empty($vessel_details))
    {
      $k=1;
      foreach ($vessel_details as $key) 
      {
       
      $vesselname   = $key['vessel_name'];
      $vessel_id    = $key['vessel_id'];

      $surveyId    = $key['survey_id'];


      $vessel_type_id           = $key['vessel_type_id'];;
      $vessel_subtype_id        = $key['vessel_subtype_id'];;

  $status_details          =   $this->Survey_model->get_status_details($vessel_id,$surveyId);
  $data['status_details']  =   $status_details;

 
  if(!empty($status_details))
  {
    $survey_id          = $status_details[0]['survey_id'];
    $process_id         = $status_details[0]['process_id'];
    $current_status_id  = $status_details[0]['current_status_id'];
  

  $process_details          =   $this->Survey_model->get_form_number_cs($process_id);
  $data['process_details']  =   $process_details;
  if(!empty($process_details))
  {
    $process_name=  $process_details[0]['process_name'];
  }
  
$survey_status_details          =   $this->Survey_model->get_kiv_status($current_status_id);
  $data['survey_status_details']  =   $survey_status_details;
  if(!empty($survey_status_details))
  {
     $status_name=$survey_status_details[0]['status_name'];
  }
  $process_status_name=$process_name.'-'.$status_name;

}
//_________________________________________________________________________________//

if($k==1)
{
$k++;

    ?>

  
  <div class="carousel-item active">
  <?php }  else { ?>
  <div class="carousel-item">
  <?php  } ?> 

<!--  <?php //echo $vesselname.'-'.$vessel_id; ?> <?php //echo $process_id.'---------'.$current_status_id; ?>  -->
  
<!-- ________________________________Form 1 start __________________________________________ -->

<?php 
if(($process_id==1 || $process_id==2 || $process_id==3 || $process_id==4) && ($current_status_id!=5))
{
 
 //---------------------------------Coding for display-------------------------------// 

$vessel_created_timestamp =   $key['vessel_created_timestamp'];
$application_date         =   date("d-m-Y", strtotime($vessel_created_timestamp));
$form_id1=1;


$form1_payment_details=$this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id1);
$data['form1_payment_details']  =   $form1_payment_details;

if(!empty($form1_payment_details))
{
  $form1_payment_amount=$form1_payment_details[0]['dd_amount'];
}
else
{
  $form1_payment_amount=0;
}



$month_id=$key['month_id'];
$vessel_expected_completion=$key['vessel_expected_completion'];
$month_details=$this->Survey_model->get_month_details($month_id);
$data['month_details']  =   $month_details;
if(!empty($month_details))
{
  $month_name1=$month_details[0]['month_name'];
  $month_name = substr($month_name1, 0, 3);
}
else
{
  $month_name="";
}

//----Keel laying-----//
$process_keel_id=2;
$processactivity_date_keel = $this->Survey_model->get_processactivity($vessel_id,$survey_id,$process_keel_id);
$data['processactivity_date_keel']= $processactivity_date_keel;
print_r($processactivity_date_keel);

//-----keel approved date----------//
$process_keel_approved_date = $this->Survey_model->get_processactivity_approved($vessel_id,$survey_id,$process_keel_id);
$data['process_keel_approved_date']= $process_keel_approved_date;
if(!empty($process_keel_approved_date))
{
  $keel_approved_date1=date('d-m-Y',strtotime($process_keel_approved_date[0]['approved_date']));

if($keel_approved_date1)
{
  $keel_approved_date=$keel_approved_date1;
}
else
{
  $keel_approved_date="";
}
}
else
{
  $keel_approved_date="";
}
//--------------------//

$myArray1 = array();
$myArray2 = array();
$myArray3 = array();
if(!empty($processactivity_date_keel))
{
 
  foreach ($processactivity_date_keel as $key1 ) 
  {
    array_push($myArray1, $key1['activity_date']);
  }
}
 @$next_keel_date1 = date("d-m-Y", strtotime($myArray1[0]));
 if($next_keel_date1!="01-01-1970")
 {
  $next_keel_date=$next_keel_date1;
 }
 else
 {
  $next_keel_date="";
 }

 @$previous_keel_date1 = date("d-m-Y", strtotime($myArray1[1]));
 if($previous_keel_date1!="01-01-1970")
 {
  $previous_keel_date=$previous_keel_date1;
 }
 else
 {
  $previous_keel_date="";
 }

//----Hull inspection-----//   
$process_hull_id=3;
$processactivity_date_hull= $this->Survey_model->get_processactivity($vessel_id,$survey_id,$process_hull_id);
$data['processactivity_date_hull']= $processactivity_date_hull;
if(!empty($processactivity_date_hull))
{
  foreach ($processactivity_date_hull as $key2)
  {
    array_push($myArray2, $key2['activity_date']);
  }
}
@$next_hull_date1 = date("d-m-Y", strtotime($myArray2[0]));
 if($next_hull_date1!="01-01-1970")
 {
  $next_hull_date=$next_hull_date1;
 }
 else
 {
  $next_hull_date="";
 }

 @$previous_hull_date1 = date("d-m-Y", strtotime($myArray2[1]));
 if($previous_hull_date1!="01-01-1970")
 {
  $previous_hull_date=$previous_hull_date1;
 }
 else
 {
  $previous_hull_date="";
 }

//-----hull approved date----------//
$process_hull_approved_date = $this->Survey_model->get_processactivity_approved($vessel_id,$survey_id,$process_hull_id);
$data['process_hull_approved_date']= $process_hull_approved_date;
if(!empty($process_hull_approved_date))
{
  $hull_approved_date1=date('d-m-Y',strtotime($process_hull_approved_date[0]['approved_date']));

if($hull_approved_date1)
{
  $hull_approved_date=$hull_approved_date1;
}
else
{
  $hull_approved_date="";
}
}
else
{
  $hull_approved_date="";
}
//--------------------------------//



//----Final inspection-----//   
$process_final_id=4;
$processactivity_date_final= $this->Survey_model->get_processactivity($vessel_id,$survey_id,$process_final_id);
$data['processactivity_date_final']= $processactivity_date_final;
if(!empty($processactivity_date_final))
{
  foreach ($processactivity_date_final as $key3)
  {
    array_push($myArray3, $key3['activity_date']);
  }
}
@$next_final_date1 = date("d-m-Y", strtotime($myArray3[0]));
 if($next_final_date1!="01-01-1970")
 {
  $next_final_date=$next_final_date1;
 }
 else
 {
  $next_final_date="";
 }

 @$previous_final_date1 = date("d-m-Y", strtotime($myArray3[1]));
 if($previous_final_date1!="01-01-1970")
 {
  $previous_final_date=$previous_final_date1;
 }
 else
 {
  $previous_final_date="";
 }

//-----final approved date----------//
$process_final_approved_date = $this->Survey_model->get_processactivity_approved($vessel_id,$survey_id,$process_final_id);
$data['process_final_approved_date']= $process_final_approved_date;
if(!empty($process_final_approved_date))
{
  $final_approved_date1=date('d-m-Y',strtotime($process_final_approved_date[0]['approved_date']));

if($final_approved_date1)
{
  $final_approved_date=$final_approved_date1;
}
else
{
  $final_approved_date="";
}
}
else
{
  $final_approved_date="";
}
//--------------------------------//



//-----------Payment--------------//

$form_id=1;
$activity_id=1;

$tariff_details           =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
$data1['tariff_details']  =   $tariff_details;


$tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
$data1['tonnage_details']  =   $tonnage_details;
@$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];

if(!empty($tariff_details))
{
  foreach ($tariff_details as $key ) 
  {
  $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];

    if($tariff_tonnagetype_id==1)
    {
      $tariff_amount1=$key['tariff_amount'];
    }
    elseif($tariff_tonnagetype_id==2)
    {
      $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;
      @$tariff_amount1                   = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
    }
    elseif($tariff_tonnagetype_id==3)
    {
      $tariff_details_typeid3           =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
      @$tariff_amount1                   = $tariff_details_typeid3[0]['tariff_amount'];
    }
    else
    {
      @$tariff_amount= 0;
    }
  }
}
if($tariff_amount1!=0)
{
  $tariff_amount=$tariff_amount1;
}
else
{
  $tariff_amount=0;
}





                
?>

<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i>
       Application date : <?php echo $application_date; ?> </li>
      <li class="list-group-item text-primary"> <i class="fas fa-eraser"></i> 
      <?php 
      if($next_keel_date==false && $next_hull_date==false && $next_final_date==false) {  echo "Next keel date :"; }
      else {
        if($next_keel_date==true && $next_hull_date==false && $next_final_date==false) { echo "Next keel date :"; }
        else if($next_hull_date==true  && $keel_approved_date==true) { echo "Keel approved date :".$keel_approved_date; }
        else { echo ""; }
      }
  
      ?>
      </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> 
       <?php if($form1_payment_amount!=0) {  ?> Amount Remitted : <?php echo $form1_payment_amount; } else { ?>Amount to be remitted: <?php  echo  $tariff_amount; } ?>    </li>
      <li class="list-group-item text-primary"> <i class="fas fa-fire-extinguisher"></i> 

      <?php 
      if($next_hull_date==false && $next_final_date==false) {  echo "Next hull date :"; }
      else {
        if($next_hull_date==true && $next_final_date==false) { echo "Next hull date :".$next_hull_date; }
        else if($next_hull_date==true  && $hull_approved_date==true) { echo "Hull approved date : ".$hull_approved_date; }
        else { echo ""; }
      }
      ?>


       <?php /*if($next_final_date) { echo "Hull approved date :".$hull_approved_date; } else {  ?>
        Next hull date: <?php echo $next_hull_date; }*/ ?>
        </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i> 
        Year of completion  : <?php echo $month_name.', '.$vessel_expected_completion; ?></li>
      <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i> 
        Next final date  : <?php echo $next_final_date; ?> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i> 
       <?php 
       if($next_hull_date) { echo ""; }  
       else if($next_final_date) { echo ""; } 
       else { echo "Previous keel date  : ".$previous_keel_date; }
      ?>
        </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i> 
       <?php 
       if($next_final_date) { echo ""; } 
       else { echo " Previous hull date  : ".$previous_hull_date; }
      ?>
        </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i>  
        Previous final date : <?php echo $previous_final_date; ?></li>
      </ul>
      </div> 
</div> 
</div>
<?php } ?>



<!-- ________________________________Form 1 end __________________________________________ -->

<!-- ________________________________Form 3 start __________________________________________ -->
<?php 
if(($process_id==5) && ($current_status_id!=5))
{

  $current_status_id1=1;
  
   $form3_date= $this->Survey_model->get_form3_date($vessel_id,$process_id,$survey_id,$current_status_id1,$user_type_id,$sess_usr_id);
$data['form3_date']= $form3_date;
if(!empty($form3_date))
{
  @$status_change_date = date("d-m-Y", strtotime($form3_date[0]['status_change_date']));
}
$current_status_id2=2;
  
   $form3_appdate= $this->Survey_model->get_form3_appdate($vessel_id,$process_id,$survey_id,$current_status_id2);
$data['form3_appdate']= $form3_appdate;
//print_r($form3_appdate);
if(!empty($form3_appdate))
{
  @$application_date_form31 = date("d-m-Y", strtotime($form3_appdate[0]['status_change_date']));
  if($application_date_form31!="01-01-1970")
  {
    $application_date_form3=$application_date_form31;
  }
  else
  {
    $application_date_form3="";
  }
}
else
{
  $application_date_form3 ="";
}


//___________________Payment________________//
$vessel =   $this->Survey_model->get_vessel_details_individual($vessel_id);
$data['vessel'] = $vessel;
if(!empty($vessel))
{
  $vessel_type_id         = $vessel[0]['vessel_type_id'];
  $vessel_subtype_id      = $vessel[0]['vessel_subtype_id'];
  $vessel_total_tonnage   = $vessel[0]['vessel_total_tonnage'];
}


  $status_change_date1   = $form3_date[0]['status_change_date'];
$form3_initiated_date    = date("d-m-Y", strtotime($status_change_date1));

  $status_change_date    = date("Y-m-d", strtotime($status_change_date1));

  $now                  = date("Y-m-d");
  $form_id=3;

    $date1_ts    = strtotime($status_change_date);
    $date2_ts    = strtotime($now);
    $diff        = $date2_ts - $date1_ts;
    $numberofdays= round($diff / 86400);
        

    $tariff_dtls =   $this->Survey_model->get_tariff_dtls($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_dtls'] = $tariff_dtls;


if(!empty($tariff_dtls))
{
  $tariff_tonnagetype_id=$tariff_dtls[0]['tariff_tonnagetype_id'];
  if($tariff_tonnagetype_id==3)
  {
    if($numberofdays<365)
    {
      
      $tariff_form3 =   $this->Survey_model->get_tariff_form3($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage,$numberofdays);
      $data['tariff_form3'] = $tariff_form3;
      
   
    }
    else
    {
      
      $tariff_form3 =   $this->Survey_model->get_tariff_form3_366($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data['tariff_form3'] = $tariff_form3;
     
    }
    
  }
}
if(!empty($tariff_form3))
{

    @$tariff_amount=$tariff_form3[0]['tariff_amount'];
}
else
{
  @$tariff_amount=0;
}

//_____________________________Payment end____________________________//









$form_id3=3;

$form3_payment_details=$this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id3);
$data['form3_payment_details']  =   $form3_payment_details;
//print_r( $form3_payment_details);

if(!empty($form3_payment_details))
{
  $form3_payment_amount=$form3_payment_details[0]['dd_amount'];
  $form3_payment_date=date('d-m-Y',strtotime($form3_payment_details[0]['dd_date']));
}
else
{
  $form3_payment_amount=0;
  $form3_payment_date="";
}

//______________________hull details_____________________//

   $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
   $data['hull_details']    = $hull_details;
   if(!empty($hull_details))
   {
    $hull_year_of_built=$hull_details[0]['hull_year_of_built'];
   }
   else
   {
    $hull_year_of_built="";
   }
   
  //______________________engine details_____________________//
   
   $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
   $data['engine_details']  = $engine_details;
   if(!empty($engine_details))
   {
    foreach ($engine_details as $key) 
    {
    
    $make_year1[] =$key['make_year'];
    $make_year    = implode(", ",$make_year1);
    }
     

   }
   else
   {
    $make_year="";
   }
  
                  
?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> 
      Form 3 initiated date : <?php echo $form3_initiated_date; ?> </li>
      <li class="list-group-item text-primary"> <i class="fas fa-eraser"></i> 
      Application date: <?php echo $application_date_form3; ?> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i><!--  Current payment due  :  <?php //echo $tariff_amount; ?> -->  <?php if($form3_payment_amount!=0) {  ?> Amount Remitted : <?php echo $form3_payment_amount; } else { ?>Amount to be remitted: <?php  echo  @$tariff_amount; } ?> </li>
      <li class="list-group-item text-primary"> <i class="fas fa-fire-extinguisher"></i> Payment date : <?php echo $form3_payment_date; ?> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i>  Year of built of hull : <?php echo $hull_year_of_built; ?></li>
      <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i> Year of built of engine  : <?php  if($make_year) { echo $make_year; } else { echo ""; } ?> </li>
      </ul>
      </div> 

  </div> 
</div>
<?php 
}
 ?>
<!-- ________________________________Form 3 end __________________________________________ -->

<!-- ________________________________Form 4 start __________________________________________ -->

<?php 
if(($process_id==6 && $current_status_id!=5))
{
    //-----------Get survey intimation :  tbl_kiv_survey_intimation --------------//

$survey_intimation          = $this->Survey_model->get_survey_intimation_details_owner($vessel_id,$survey_id);
$data['survey_intimation']  = $survey_intimation;
//print_r($survey_intimation);

if(!empty($survey_intimation))
{
  foreach ($survey_intimation as $key ) 
  {
    $defect_status=$key['defect_status'];
    $survey_defects_id=$key['survey_defects_id'];
    
    
    if($defect_status==0)
    {
      $date_of_survey      = date('d-m-Y', strtotime($survey_intimation[0]['date_of_survey']));
    }
    else
    {
      $survey_intimation_defects      =   $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
      $data['survey_intimation_defects']  =   $survey_intimation_defects;

       $date_of_survey      = date('d-m-Y', strtotime($survey_intimation_defects[0]['date_of_survey']));
    }
  }

}
$process_id3=5;
$current_status_id3=5;

$forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id3,$survey_id,$current_status_id3);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $form3_approved_date5=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
      else
      {
        $form3_approved_date5="";
      }
$process_id3=5;
$current_status_id3=6;

$forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id3,$survey_id,$current_status_id3);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $form3_approved_date6=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
      else
      {
        $form3_approved_date6="";
      }
if($form3_approved_date5)
{
  $form3_approved_date=$form3_approved_date5;
}
else
{
  $form3_approved_date=$form3_approved_date6;
}

?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> Last Date of survey : <?php if($date_of_survey) { echo $date_of_survey; } else { echo ""; } ?> </li>
     </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> Last Defect memo date  :  <?php //echo $datttttttttt; ?> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i> Form3 approved date: <?php echo $form3_approved_date; ?></li>
      </ul>
      </div> 

  </div> 
</div>
<?php 
}
 ?>

<!-- ________________________________Form 4 end __________________________________________ -->


<!-- ________________________________Form 4 defect start __________________________________________ -->

<?php 
if(($process_id==7) && ($current_status_id==7))
{

$survey_intimation1          = $this->Survey_model->get_survey_intimation_details_owner($vessel_id);
$data['survey_intimation1']  = $survey_intimation1;
//print_r($survey_intimation1);

if(!empty($survey_intimation1))
{
  foreach ($survey_intimation1 as $key1 ) 
  {
    $defect_status=$key1['defect_status'];
    $survey_defects_id=$key1['survey_defects_id'];
    
    
    if($defect_status==0)
    {
      $date_of_survey      = date('d-m-Y', strtotime($survey_intimation1[0]['date_of_survey']));
    }
    else
    {
      $survey_intimation_defects      =   $this->Survey_model->get_survey_intimation_defects_owner($survey_defects_id);
      $data['survey_intimation_defects']  =   $survey_intimation_defects;
      

      $date_of_survey      = date('d-m-Y', strtotime($survey_intimation_defects[0]['date_of_survey']));
      $defect_memo_date      = date('d-m-Y', strtotime($survey_intimation_defects[0]['defect_created_timestamp']));
    }
  }
}


                
?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> Last date of survey : <?php if($date_of_survey) { echo $date_of_survey; } else {echo ""; } ?> </li>
     </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> Last defect memo  date  :  <?php if($defect_memo_date) { echo $defect_memo_date; } else {echo ""; } ?> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i>  Approved date: <?php //echo $datttttttttt; ?></li>
      </ul>
      </div> 

  </div> 
</div>
<?php 
}
 ?>

<!-- ________________________________Form 4 defect end __________________________________________ -->


<!-- ________________________________Form 5 start ________________________________________ -->

<?php 
if(($process_id==8) && ($current_status_id!=5))
{
$survey_intimation          = $this->Survey_model->get_survey_intimation_details($vessel_id,$survey_id);
$data['survey_intimation']  = $survey_intimation;
//print_r($survey_intimation);

if(!empty($survey_intimation))
{
  foreach ($survey_intimation as $key ) 
  {
    $defect_status=$key['defect_status'];
    $survey_defects_id=$key['survey_defects_id'];
    
    
    if($defect_status==0)
    {
      $date_of_survey      = date('d-m-Y', strtotime($survey_intimation[0]['date_of_survey']));
    }
    else
    {
      $survey_intimation_defects      =   $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
      $data['survey_intimation_defects']  =   $survey_intimation_defects;

        $date_of_survey      = date('d-m-Y', strtotime($survey_intimation_defects[0]['date_of_survey']));
    }
  }

}

                  
?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i>
       Survey date : <?php echo $date_of_survey; ?> </li>
     </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> Declaration issue date  :  <?php //echo $datttttttttt; ?> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i>  </li>
      </ul>
      </div> 

  </div> 
</div>
<?php 
}
 ?>
<!-- ________________________________Form 5 end __________________________________________ -->

<!-- ________________________________Form 6 start ________________________________________ -->

<?php 
if(($process_id==9) && ($current_status_id!=5))
{

$survey_intimation          = $this->Survey_model->get_survey_intimation_details($vessel_id,$survey_id);
$data['survey_intimation']  = $survey_intimation;
//print_r($survey_intimation);

if(!empty($survey_intimation))
{
  foreach ($survey_intimation as $key ) 
  {
    $defect_status=$key['defect_status'];
    $survey_defects_id=$key['survey_defects_id'];
    
    
    if($defect_status==0)
    {
      $date_of_survey      = date('d-m-Y', strtotime($survey_intimation[0]['date_of_survey']));
    }
    else
    {
      $survey_intimation_defects      =   $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
      $data['survey_intimation_defects']  =   $survey_intimation_defects;

        $date_of_survey      = date('d-m-Y', strtotime($survey_intimation_defects[0]['date_of_survey']));
    }
  }

}

                  
?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i>
       Survey date : <?php echo $date_of_survey; ?> </li>
     </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> Declaration issue date  :  <?php //echo $datttttttttt; ?> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i>  </li>
      </ul>
      </div> 

  </div> 
</div>
<?php 
}
 ?>
<!-- ________________________________Form 6 end __________________________________________ -->

<!-- ________________________________Form 7 start ________________________________________ -->

<?php 
if(($process_id==10) && ($current_status_id==5)) //form 7 approved
{
    $forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id,$survey_id,$current_status_id);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $form7_approved_date=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
      

?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> Approved date : 
      <?php if($form7_approved_date) { echo $form7_approved_date; } else { echo ""; } ?> </li>
     </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i>  </li>
      </ul>
      </div> 

  </div> 
</div>
<?php 
}
 ?>

<!-- ________________________________Form 7 end __________________________________________ -->


<!-- ________________________________Form 7 start ________________________________________ -->

<?php 
if(($process_id==10) && ($current_status_id!=5))
{
   $forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id,$survey_id,$current_status_id);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $form7_issue_date=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }

?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> Issue date : 
      <?php if($form7_issue_date) { echo $form7_issue_date; } else { echo ""; } ?> </li>
     </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i>  </li>
      </ul>
      </div> 

  </div> 
</div>
<?php 
}
 ?>

<!-- ________________________________Form 7 end __________________________________________ -->

<!-- ________________________________Form 8 start ________________________________________ -->

<?php 
if(($process_id==11) && ($current_status_id!=5))
{
$current_status_id1=2;
    $forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id,$survey_id,$current_status_id1);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $form8_application_date=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
                  
?>
<div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> Initiated date : <?php if($form8_application_date) { echo $form8_application_date; } else { echo ""; } ?> </li>
     </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-square"></i>  </li>
      </ul>
      </div> 

      <div class="col-4">
      <ul class="list-group">
      <li class="list-group-item text-primary"> <i class="fas fa-square"></i>  </li>
      </ul>
      </div> 


  </div> 
</div>
<?php 
}
 ?>

<!-- ________________________________Form 8 end __________________________________________ -->

<!-- ________________________________Form 9 start ________________________________________ -->

<?php 
if(($process_id==12) && ($current_status_id!=5))
{
$survey_intimation          = $this->Survey_model->get_survey_intimation_details($vessel_id,$survey_id);
$data['survey_intimation']  = $survey_intimation;

if(!empty($survey_intimation))   
{
  $survey_number=$survey_intimation[0]['survey_number'];
  $placeofsurvey_id=$survey_intimation[0]['placeofsurvey_id'];
  if($placeofsurvey_id !=0)
      {
        $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_id);
        $data['placeofsurvey']  =   $placeofsurvey;
        $placeofsurvey_name     =   $placeofsurvey[0]['placeofsurvey_name'];
      }

}  
$declaration_issue_date1=date('d-m-Y',strtotime($key['declaration_issue_date']));  
if($declaration_issue_date1!='01-01-1970')  
{
  $declaration_issue_date=$declaration_issue_date1;
}
else
{
  $declaration_issue_date="";
}
//--------certificate notice date------------//
$process_id10=10;
$current_status_id5=5;
    $forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id10,$survey_id,$current_status_id5);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $certificate_notice_date=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
      else
      {
        $certificate_notice_date="";
      }


$process_id11=11;
$current_status_id5=5;
    $forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id11,$survey_id,$current_status_id5);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $certificate_application_date=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
      else
      {
        $certificate_application_date="";
      }
?>
 <div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><!-- Please check for expiry of validity of certificates, next survey date and submission of applications. --><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> 
              Survey number : <?php echo $survey_number; ?> </li>
              <li class="list-group-item text-primary"> <i class="fas fa-eraser"></i> 
              Place of survey: <?php echo $placeofsurvey_name; ?> </li>
            </ul>
          </div> 

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> 
              Declaration issue date :  <?php echo @$declaration_issue_date; ?> </li>
              <li class="list-group-item text-primary"> <i class="fas fa-fire-extinguisher"></i>
               Certificate notice date : <?php echo @$certificate_notice_date; ?> </li>
            </ul>
          </div> 

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i> 
             Application date of certificate : <?php echo $certificate_application_date; ?></li>
              <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i> 
              Validity of hull : <?php //echo $hullValDate; ?> </li>
            </ul>
          </div> 

        </div> 
</div>
<?php 
}
 ?>

<!-- ________________________________Form 9 end __________________________________________ -->

<!-- ________________________________Form 10 start ________________________________________ -->
 <?php 
if(($process_id==13) && ($current_status_id!=5))
{
   $survey_intimation          = $this->Survey_model->get_survey_intimation_details($vessel_id,$survey_id);
$data['survey_intimation']  = $survey_intimation;

if(!empty($survey_intimation))   
{
  $survey_number=$survey_intimation[0]['survey_number'];
  $placeofsurvey_id=$survey_intimation[0]['placeofsurvey_id'];
  if($placeofsurvey_id !=0)
      {
        $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_id);
        $data['placeofsurvey']  =   $placeofsurvey;
        $placeofsurvey_name     =   $placeofsurvey[0]['placeofsurvey_name'];
      }

}  
$declaration_issue_date=date('d-m-Y',strtotime($key['declaration_issue_date']));    
//--------certificate notice date------------//
$process_id10=10;
$current_status_id5=5;
    $forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id10,$survey_id,$current_status_id5);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $certificate_notice_date=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
      else
      {
        $certificate_notice_date="";
      }


$process_id11=11;
$current_status_id5=5;
    $forms_data      =   $this->Survey_model->get_forms_data($vessel_id,$process_id11,$survey_id,$current_status_id5);
      $data['forms_data']  =   $forms_data;
      if(!empty($forms_data))
      {
        $certificate_application_date=date('d-m-Y', strtotime($forms_data[0]['status_change_date']));
      }
      else
      {
        $certificate_application_date="";
      }
?>
 <div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary"><!-- Please check for expiry of validity of certificates, next survey date and submission of applications. --><?php echo $process_status_name; ?></h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> 
              Survey number : <?php echo $survey_number; ?> </li>
              <li class="list-group-item text-primary"> <i class="fas fa-eraser"></i> 
              Place of survey: <?php echo $placeofsurvey_name; ?> </li>
            </ul>
          </div> 

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> 
              Declaration issue date :  <?php echo @$declaration_issue_date; ?> </li>
              <li class="list-group-item text-primary"> <i class="fas fa-fire-extinguisher"></i>
               Certificate notice date : <?php echo @$certificate_notice_date; ?> </li>
            </ul>
          </div> 

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i> 
             Application date of certificate : <?php echo $certificate_application_date; ?></li>
              <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i> 
              Validity of hull : <?php //echo $hullValDate; ?> </li>
            </ul>
          </div> 

        </div> 
</div>
<?php 
}
 ?> 

<!-- ________________________________Form 10 end __________________________________________ -->



<!-- ________________________________Registration start ________________________________________ -->
<?php 
if(($process_id==14) && ($current_status_id==1))
{

      $survey_id=1;
      $subprocess_id1=2; //annual
      $subprocess_id=3; //drydock

     @$validity_fire_extinguisher1=$key['validity_fire_extinguisher'];
      if(@$validity_fire_extinguisher1)
      {
        @$validity_fire_extinguisher = date("d-m-Y", strtotime($validity_fire_extinguisher1));
      }
      else
      {
        @$validity_fire_extinguisher ="";
      }
      @$validity_of_insurance1=$key['validity_of_insurance'];
      if($validity_of_insurance1)
      {
        @$validity_of_insurance = date("d-m-Y", strtotime($validity_of_insurance1));
      }
      else
      {
        @$validity_of_insurance ="";
      }


      @$hullValDate1=$key['hullValDate'];
      if($hullValDate1)
      {
        @$hullValDate = date("d-m-Y", strtotime($hullValDate1));
      }
      else
      {
        @$hullValDate ="";
      }

      @$machineryValDate1=$key['machineryValDate'];
      if($machineryValDate1)
      {
        @$machineryValDate = date("d-m-Y", strtotime($machineryValDate1));
      }
      else
      {
        @$machineryValDate ="";
      }

      //hullValDate
      //machineryValDate

      //Next drydock survey date
       $timeline_nextdrydock      =   $this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$survey_id,$subprocess_id);
      $data['timeline_nextdrydock'] = $timeline_nextdrydock;
      if(!empty($timeline_nextdrydock))
      {
        @$nextdrydock_date1=$timeline_nextdrydock[0]['scheduled_date'];
         @$nextdrydock_date = date("d-m-Y", strtotime($nextdrydock_date1));
      }
      else
      {
        @$nextdrydock_date="";
      }
      //Next Annual survey date
      
      $timeline_nextannual      =   $this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$survey_id,$subprocess_id1);
      $data['timeline_nextannual'] = $timeline_nextannual;
      if(!empty($timeline_nextannual))
      {
        $nextannaul_date1=$timeline_nextannual[0]['scheduled_date'];
         $nextannaul_date = date("d-m-Y", strtotime($nextannaul_date1));
      }
      else
      {
        $nextannaul_date="";
      }
      
                  
?>
 <div class="jumbotron">
  <h4 class="text-success"><?php echo $vesselname.'-'.$vessel_id; ?></h4>
  <h6 class="text-secondary">Please check for expiry of validity of certificates, next survey date and submission of applications.</h6>
  <hr class="my-4">
  <div class="row no-gutters layoutcolor">

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-anchor"></i> Next dry dock date : <?php echo $nextdrydock_date; ?> </li>
              <li class="list-group-item text-primary"> <i class="fas fa-eraser"></i> Next annual survey date: <?php echo $nextannaul_date; ?> </li>
            </ul>
          </div> 

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-certificate"></i> Expiry of Insurance :  <?php echo $validity_of_insurance; ?> </li>
              <li class="list-group-item text-primary"> <i class="fas fa-fire-extinguisher"></i> Fire Extinguisher : <?php echo @$validity_fire_extinguisher; ?> </li>
            </ul>
          </div> 

          <div class="col-4">
            <ul class="list-group">
              <li class="list-group-item text-primary"> <i class="fas fa-toolbox"></i> Validity of machinery : <?php echo $machineryValDate; ?></li>
              <li class="list-group-item text-primary"> <i class="fas fa-vector-square"></i> Validity of hull : <?php echo $hullValDate; ?> </li>
            </ul>
          </div> 

        </div> 
</div>
<?php 
}
 ?>

<!-- ________________________________Registration end __________________________________________ -->



</div>
 <?php
 } 
 }

 ?>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
   <!-- end of carousel -->
 </div> <!-- end of col-12 -->
</div> <!-- end of row profile section --> 
