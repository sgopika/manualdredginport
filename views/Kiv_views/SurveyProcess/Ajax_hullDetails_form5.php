
<?php 
/*if($this->session->flashdata('msg'))
{
  echo $this->session->flashdata('msg');
}*/
?>

<?php 
  //print_r($fieldstoShow);
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

  <!--<div class="row oddtab">-->
    <?php 
    $value97='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3">'. $label_name. '</p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <input type="text" name="lengthIdentification" value="" id="lengthIdentification" maxlength="8" class="form-control"  autocomplete="off" placeholder="Enter Length for identification" data-validation="required" required onpaste="return false;" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" />
      </div>  <!--end of form group--> 
    </div>';

     $value98='<div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3">'. $label_name. '</p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <select class="form-control select2" name="conditionofHull" id="conditionofHull" placeholder="Select Condition of Hull" data-validation="required">
           <option value="">Select Condition of Hull</option>';
            foreach ($conditionofItem as $condtn)
            {
            $value98 .='<option value="'.$condtn['conditionstatus_sl'].'">'.$condtn['conditionstatus_name']. '</option>';            
            } 
            $value98 .='</select>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>
  
  
  <!-- </div>  end of oddtab -->';  
  
 // }/*End of foreach*/
  //}/*End of Main if*/ 
  

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
<!--<div class="row mx-0 mb-3 no-gutters eventab">
  <div class="row no-gutters d-flex justify-content-end <?php echo $style; ?>">-->
<div class="row mx-0 mb-3 no-gutters <?php echo $style; ?>">
<div class="col-10"></div>
<!--<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab2back" id="tab2back"><i class="fas fa-step-backward"></i>&nbsp;Back</button> 
</div> --> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab2next" id="tab2next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div> <!-- End of button row -->
   