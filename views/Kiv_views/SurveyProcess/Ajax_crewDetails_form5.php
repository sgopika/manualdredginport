
<script type="text/javascript">
$(document).ready(function(){

//$('#addMore1').on('click', function( e ) {
 $("#addMore").click(function()
{
  alert("more");
  var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>'; 
$.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Surveyprocess/saveTab4ss/')?>",
        data:{'csrf_test_name': csrf_token},
        success: function(data)
        {     alert(data);   
        //$(".select2").select2();
        $("#add_crew").html(data);
        $(".select2").select2();
        
        }
      });
  }); 


});
</script>

<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vesselId; ?>" >


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

 <!--<div class="row oddtab">-->

    <?php /*$value132='<div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3"> Crew Type  </p>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';

    $value133='<div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3"> Crew Name  </p>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';

    $value134='<div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3"> Crew Class  </p>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';

    $value135='<div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3"> Crew License Number  </p> 
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';*/?>
  
   <!--</div>--> <!-- end of oddtab -->  

   <!-- <div class="row eventab">-->
<?php 

    /*$value131='<div class="col border-top border-bottom ">
      <p class="mt-2 mb-2">'.$label_name .'</p>
    </div>';*/

    $value132='<div class="col-3 border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2"><p>'.$label_name.'</p>
        <div class="input-group">
             <select class="form-control select2" name="crew_type" id="crew_type" placeholder="Select Crew Type" data-validation="required">
           <option value="">Select Crew Type</option>';
            foreach ($crewType as $crewtp)
            {
            
            $value132 .='<option value="'.$crewtp['crew_type_sl'].'">'.$crewtp['crew_type_name']. '</option>';
            
            }  
            $value132 .='</select>
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';

    $value133='<div class="col-3 border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2"><p>'.$label_name.'</p>
                <input type="text" name="crewName" value="" id="crewName"  class="form-control" maxlength="50"  autocomplete="off" placeholder="Enter Crew Name" data-validation="required" required  onpaste="return false;" onkeypress="return alpbabetspace(event);" onchange="return IsZero(this.id);" />
      </div> <!-- end of form group -->
    </div>';

    $value134='<div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2"><p>'.$label_name.'</p>
        <div class="input-group">
            <select class="form-control select2" name="crew_class" id="crew_class" placeholder="Select Crew Class" data-validation="required">
            <option value="">Select Crew Class</option>';
            foreach ($crewClass as $crewcl)
            {
            
            $value134 .='<option value="'.$crewcl['crew_class_sl'].'"> '.$crewcl['crew_class_name'].'</option>';
            
            }
            $value134 .='</select>
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';


    $value135='<div class="col-3 border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2"><p>'.$label_name.'</p>
                <input type="text" name="crewLicenseNumber" value="" id="crewLicenseNumber" maxlength="30"  class="form-control"  autocomplete="off" placeholder="Enter Crew License Number" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" />
      </div> <!-- end of form group -->
    </div>';

    
 ?> 
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
?><?php //echo $cnt; ?>

 <!--Place the data div inside the row div-->
  <div class="row no-gutters  <?php echo $style; ?>" id="crew"><!--<div class="col-12" id="crewdetails">placing row .opened-->
  <?php
  $value="value".$labelId;
    echo ${$value};
  }
  else // Already a row has been opened.
  { 
          if(($row_count != 0)&&($row_count <= 4))/*to incude 4 labels in a row*/
          {
              //$row_count=0; 
              $row_count=$row_count+1;
              if($row_count == 5) 
              {
                $row_count=0;//echo "hi".$row_count;             

                $value="value".$labelId;
                echo ${$value};

                ?>
                </div> <!-- end of opened placing row -->

                <?php  
              }
               
              else 
              {      
                $value="value".$labelId;
                echo ${$value};                
              }

          }
  } //End of var_row condition  
  
  }/*End of foreach*/
  }/*End of Main if*/ 
  ?>
<div id="add_crew"></div>
  <button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addMore" id="addMore" ><i class="far fa-save"></i>&nbsp;Add Crew</button>

  <script type="text/javascript">
 /* $(function() {

    var uform = $('#crew');
    if(uform[0]) {
    var inputs = uform[0].getElementsByTagName('input');alert(inputs);
}

    $('#addMore').on('click', function( e ) {
        e.preventDefault();
        $('<div/>').addClass( 'new-text-div' )
        
        .html( $('<div class="col-3 border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="crewName" value="" id="crewName"  class="form-control" maxlength="50"  autocomplete="off" placeholder="Enter Crew Name" data-validation="required" required  onpaste="return false;" onkeypress="return alpbabetspace(event);" onchange="return IsZero(this.id);" /></div></div><div class="col-3 border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><p></p><input type="text" name="crewLicenseNumber" value="" id="crewLicenseNumber" maxlength="30"  class="form-control"  autocomplete="off" placeholder="Enter Crew License Number" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div>').addClass( 'someclass' ) )
        .append( $('<button/>').addClass( 'remove' ).text( 'Remove' ) )
        .insertBefore( this );
    });
    $(document).on('click', 'button.remove', function( e ) {
        e.preventDefault();
        $(this).closest( 'div.new-text-div' ).remove();
    });
});*/
</script>

