

 
<?php
if (count($fieldstoShow)!=0) 
{
$row_count=0;
$row_color=0;

$var_row=0;
$var_color=0;// 0-odd, 1-even
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
 <?php
 $value97=' <input type="text" name="lengthIdentification" value="" id="lengthIdentification" maxlength="8" class="form-control"  autocomplete="off" placeholder="Enter Length for identification" data-validation="required" required onpaste="return false;" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" />';

     $value98=' <select class="form-control select2" name="conditionofHull" id="conditionofHull" placeholder="Select Condition of Hull" data-validation="required">
           <option value="">Select Condition of Hull</option>';
            foreach ($conditionofItem as $condtn)
            {
            $value98 .='<option value="'.$condtn['conditionstatus_sl'].'">'.$condtn['conditionstatus_name']. '</option>';            
            } 
            $value98 .='</select>';



     $value225=' <select class="form-control select2" name="cargo_nature" id="cargo_nature" data-validation="required" required >
           <option value="">Select</option>';
         foreach ($cargo_nature as $condtn)
            {
            $value225 .='<option value="'.$condtn['natureofoperation_sl'].'">'.$condtn['natureofoperation_name'].'</option>';
            
            } 
             
            $value225 .='</select>';

    
  // Placing Div Elements from here
  if($var_row==0)
  { 
    $var_row=1;
    if($var_color==0){
      $style='oddtab';
      $var_color=1;
    }
    else {
       $style="eventab";
       $var_color=0;
    }
     $value="value".$labelId;
  ?>
  <!-- Creating New Row -->
  <div class="row no-gutters  <?php echo $style; ?>">
    <div class="col-3 border-top border-bottom ">
      <p class="mt-3 mb-3"> <?php echo $label_name; ?> </p>
      </div>

      <div class="col-3 border-top border-bottom ">
      <?php   echo ${$value}; ?>
      </div>

  <?php
  }
  else
  {
    $var_row=0;
     $value="value".$labelId;
    ?>
    <div class="col-3 border-top border-bottom border-left pl-2">
      <p class="mt-3 mb-3"> <?php echo $label_name; ?> </p>
      </div> <!-- end of col-3 -->

      <div class="col-3 border-top border-bottom">
      <?php   echo ${$value}; ?>
      </div> <!-- end of col-3 -->
      </div> <!-- end of row -->
    <?php
  } //End of var_row condition
} //End of Foreach

if($var_row==1)
{
  ?>
  <div class="col-6"></div>
  </div> <!-- end of unclosed row -->
  <?php
}


} // end of main IF
?>




</div> <!-- end of row -->
</div>  <!-- end of col-12 -->

</form>
</div><!-- end of tab-pane 1 -->



















