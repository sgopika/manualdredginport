<script type="text/javascript">
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

<?php
//echo $a=count($fieldstoShow);
//print_r($fieldstoShow);
//print_r($vesselId);
$date=date('m-d-Y');
if (count($fieldstoShow)!=0) 
{
$row_count=0;
$row_color=0;
  foreach ($fieldstoShow as $listFields) 
  {
    //print_r($listFields) ;
    $labelId=$listFields['label_id'];
    
    if($labelId!='')
    {
      $value='';
        $label_name=$listFields['label_name'];
    }
 
?>
  <input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vesselId; ?>" >

    <?php $value152='<div class="col-3 border-bottom ">
    <p class="mt-3 mb-3">'.$label_name.'</p>
    </div><!-- end of col-2 ves_div1 -->

    <div class="col-3 border-bottom  ">
      <div class="form-group mt-2 mb-2">
          <input type="text" name="dateofInspection" value="" id="dateofInspection"  class="form-control dob"  maxlength="10" autocomplete="off" placeholder="Enter Date of inspection" data-validation="required" required  onchange="return prevDate(this.id);" /> 
      </div> <!-- end of form group -->
    </div> <!-- end of col-2 ves_div1 -->';
   
    $value153='<div class="col-3 border-bottom border-left ">
      <p class="mt-3 mb-3 ">'.$label_name .' </p>
    </div>
    <div class="col-3 border-bottom  ">    
      <div class="form-group mt-2 mb-2">
          <input type="text" name="machineryValDate" value="" id="machineryValDate"  class="form-control dob"  maxlength="10" autocomplete="off" placeholder="Enter Validity of the machinery (until)" data-validation="required" required  onchange="return nextDate(this.id);" /> 
      </div> <!-- end of form group -->
    </div>';



    $value154='<div class="col-3 border-bottom">
      <p class="mt-3 mb-3">'.$label_name .'</p>
    </div> <!-- end of col-2 -->

    <div class="col-3 border-bottom">
      <div class="form-group mt-2 mb-2">
        <input type="text" name="hullValDate" value="" id="hullValDate"  class="form-control dob"  maxlength="50" autocomplete="off" placeholder="Enter Validity of the hull (until)" data-validation="required" required  onchange="return nextDate(this.id);" />
      </div> <!-- end of form group -->
    </div> <!-- end of col -->';

    $value155='<div class="col-3 border-bottom border-left ">
      <p class="mt-2 mb-3">'.$label_name .'</p>
    </div>

    <div class="col-3 border-bottom ">
      <div class="form-group mt-2 mb-2">
        <input type="text" name="declarationDate" value="'.$date.'" id="declarationDate"  class="form-control dob"  maxlength="10" autocomplete="off" placeholder="Enter Declaration date" data-validation="required" required onchange="return prevDate(this.id);"  />
      </div> <!-- end of form group -->
    </div><!-- end of col -->';



 
  // Placing Div Elements from here
  if($row_count==0)
  { 
    $row_count=1;
    if($row_color==0)
    {
      $style='oddtab';
      $row_color=1;
    }
    else 
    {
       $style="eventab";
       $row_color=0;
    }
?>

 <!--Place the data div inside the row div-->
  <div class="row no-gutters  <?php echo $style; ?>"><!--placing row .opened-->
  <?php
  $value="value".$labelId;
    echo ${$value};
    }
    else // Already a row has been opened.
  {
    $row_count=0;
  
    $value="value".$labelId;
      echo ${$value};
      ?>
    </div> <!-- end of opened placing row -->

    <?php
  } //End of var_row condition  
  
  }/*End of foreach*/
  }/*End of Main if*/ 

  /*style for the save button*/
  /*if($row_color==0)
    $style='oddtab';
  else 
    $style="eventab";*/
  /*style for the save button*/
  
?>