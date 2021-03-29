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
  //print_r($meansofPropulsionShaft);
  if (count($fieldstoShow)!=0) 
  {
  $row_count=0;
  $row_color=0;

  foreach ($fieldstoShow as $listFields) 
  {
    $labelId=$listFields['label_id'];
    
    if($labelId!='')
    {
      $value='';
      $label_name=$listFields['label_name'];
    }
?>

<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vesselId; ?>" >

  <?php   
    $value99='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3">'. $label_name. '</p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <select class="form-control select2" name="meansofpropulsion_shaft" id="meansofpropulsion_shaft" placeholder="Select Means of propulsion shaft" data-validation="required" >
            <option value="">Select Means of propulsion shaft</option>';
            foreach ($meansofPropulsionShaft as $proplsn)
            {            
            $value99 .='<option value="'. $proplsn['meansofpropulsion_sl'].'"> '.$proplsn['meansofpropulsion_name'].'</option>';            
            } 
            $value99 .='</select>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';

 
    $value100='<div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3"> '. $label_name. '  </p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <input type="text" name="propeller_shaft_drawn_date" value="" id="propeller_shaft_drawn_date"  class="form-control dob" placeholder="Shaft last drawn date"  data-validation="required" required autocomplete="off" onpaste="return false;" onchange="return prevDate(this.id);" />
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';
   
    $value101='<div class="col-3 border-bottom ves_div2">
      <p class="mt-3 mb-3">'. $label_name. '</p>
    </div> <!-- end of col-2 -->

    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
        <input type="text" name="horsepowerofEngine" value="" id="horsepowerofEngine"  class="form-control" maxlength="7" autocomplete="off" placeholder="Total horse power of main engine" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" />
      </div> <!-- end of form group -->
    </div> <!-- end of col -->';

    $value102 ='<div class="col-3 border-bottom border-left ves_div2">
      <p class="mt-3 mb-3">'. $label_name. ' </p>
    </div>
    
    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
        <select class="form-control select2" name="conditionofMachinery" id="conditionofMachinery" placeholder="Select Condition of Machinery" data-validation="required">
        <option value="">Select Condition of Machinery</option>';
        foreach ($conditionofItem as $condtn)
        {
        $value102 .='<option value="'.$condtn['conditionstatus_sl'].'"> '.$condtn['conditionstatus_name'].'</option>';
        }  
        $value102 .='</select>
      </div> 
    </div>';


    $value108 ='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3">'. $label_name. '</p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <textarea class="form-control" rows="3" name="engine_description" id="engine_description"  title="Description of Engine"  data-validation="required" required onkeypress="return IsAddress(event);" maxlength="200" onpaste="return false;" onchange="return checklength(this.id)" ></textarea>
      </div> <!-- end of form group -->
    </div>';

 /*if(isset($value107)||isset($value108)){ echo $value104='<div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-10 mb-10"> Engine set  </p>
    </div>';}*/


    $value107 ='<div class="col-3 border-bottom border-left ves_div2">
      <p class="mt-3 mb-3">'. $label_name. '</p>
    </div>
    
    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
          <input type="text" name="dateofConstruction" value="" id="dateofConstruction"  class="form-control dob" data-validation="required" required onchange="return prevDate(this.id);" onpaste="return false;" autocomplete="off" placeholder="Date of construction"  />
      </div> <!-- end of form group -->
    </div>';

    $value103 ='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3">'. $label_name. '</p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <textarea class="form-control" rows="3" name="modelNumber" id="modelNumber"  title="Model Number" data-validation="required" required onkeypress="return IsAddress(event);" onpaste="return false;" onchange="return checklength(this.id)" ></textarea>
      </div> <!-- end of form group -->
    </div>';

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
  if($row_color==0)
    $style='oddtab';
  else 
    $style="eventab";
  /*style for the save button*/   
 ?> 
   </div> <!-- end of oddtab --> 



<!--Save button row-->
<div class="row mx-0 mb-3 no-gutters  <?php echo $style; ?>"">
<div class="col-10"></div>
<!--<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab3back" id="tab3back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  
</div> --><!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<!--<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab3next" id="tab3next" ><i class="far fa-save"></i>&nbsp;Save</button>-->
</div>
</div> <!-- End of button row -->
