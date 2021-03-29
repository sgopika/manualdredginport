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
 //print_r($fieldstoShow_condn);
 //exit;
  if (count($fieldstoShow_condn)!=0) 
  {
  $row_count=0;
  $row_color=0;

  foreach ($fieldstoShow_condn as $listFields) 
  {
     $labelId=$listFields['label_id'];
    
    if($labelId!='')
    {
      $value='';
       $label_name=$listFields['label_name'];
    }

?>

  <!--<div class="row oddtab">-->
    <?php $value147='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3">'.$label_name.'  </p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <select class="form-control select2" name="natureofCargo" id="natureofCargo" placeholder="Select Nature of cargo" data-validation="required">
           <option value="">Select Nature of cargo</option>';
            foreach ($narutrofCargo as $ntrOfCargo)
            {
            
            $value147 .='<option value="'.$ntrOfCargo['conditionstatus_sl'].'">'.$ntrOfCargo['conditionstatus_name'].'</option>';
            
            } 
            
            $value147 .='</select>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';

    $value148='<div class="col-3 border-bottom ves_div2">
      <p class="mt-3 mb-3">'.$label_name.'</p>
    </div> <!-- end of col-2 -->

    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
        <input type="text" name="qntmofCargo" value="" id="qntmofCargo"  class="form-control"  autocomplete="off" placeholder="Quantum of cargo" data-validation="required" required  onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" />
      </div> <!-- end of form group -->
    </div> <!-- end of col -->';

   

    $value149='<div class="col-3 border-bottom border-left ves_div2">
      <p class="mt-3 mb-3">'.$label_name.'</p>
    </div>
    
    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
          <select class="form-control select2" name="plying_state" id="plying_state" placeholder="Select Towing state" data-validation="required">
           <option value="">Select Plying state</option>';
            foreach ($plyingState as $plystate)
            {
            
            $value149 .='<option value="'.$plystate['plyingstate_sl'].'">'.$plystate['plyingstate_name'].'</option>';
            
            } 
             
            $value149 .='</select>
      </div> <!-- end of form group -->
    </div>

    <!--</div> end of eventab -->

   <!--<div class="row oddtab">-->';
    $value150 ='<div class="col-3 border-bottom border-left ves_div2">
      <p class="mt-3 mb-3">'.$label_name.'</p>
    </div>
    
    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
          <select class="form-control select2" name="towing_state" id="towing_state" placeholder="Select Towing state" data-validation="required">
           <option value="">Select Towing state</option>';
            foreach ($towing as $towstate)
            {
            
            $value150 .='<option value="'.$towstate['towing_sl'].'">'.$towstate['towing_name'].'</option>';
            
            } 
             
            $value150 .='</select>
      </div> <!-- end of form group -->
    </div>

    <!--</div> end of eventab -->

   <!--<div class="row oddtab">-->';

     $value151='<div class="col-3 border-bottom ves_div2">
      <p class="mt-3 mb-3">'.$label_name.'</p>
    </div> <!-- end of col-2 -->

    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
        <input type="text" name="sufficientTimeofService" value="" id="sufficientTimeofService"  class="form-control dob"  autocomplete="off" placeholder="Sufficient Time of Service" data-validation="required" required onpaste="return false;" onchange="return nextDate(this.id)"; />
      </div> <!-- end of form group -->
    </div> <!-- end of col -->';

    ?>

    <!--<div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3">   </p>
    </div>

    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
        
      </div>  end of form group -->
     <!--</div> end of col -->
  
    <!--</div> end of oddtab -->    

   <?php 
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
  ?>
