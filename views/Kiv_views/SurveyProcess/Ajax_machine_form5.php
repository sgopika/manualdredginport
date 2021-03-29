<script language="javascript">
$("#go").click(function()
{
  //alert("gghj");
  var numberofBoats=$('#numberofBoats').val();//alert(numberofBoats);
  $('#boatDet').show();
  $('#boadHeading').show();
  
  //if(numberofBoats > 1)
  //{
    for (var i = 1; i <= numberofBoats; i++)
    
      {  
        if(i % 2 == 0){ var tabType="oddtab";}else{var tabType="eventab";}

        $('<div id="boatNum' + i + '" class="row ' + tabType + '"><div class="col-3 border-top border-bottom border-left ves_div1"><p class="mt-3 mb-3">Boat #' + i + ' <br>Measurement details</p></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="lengthbt' + i + '" value="" id="lengthbt' + i + '"  class="form-control"  autocomplete="off" placeholder="നീളം /Length" maxlength="8" data-validation="required" required  onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" /></div></div><div class="col-3 border-top border-bottom border-left ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="breadthbt' + i + '" value="" id="breadthbt' + i + '"  class="form-control" maxlength="8" autocomplete="off" placeholder="വീതി /Breadth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="depthbt' + i + '" value="" id="depthbt' + i + '" maxlength="8" class="form-control"  autocomplete="off" placeholder="ആഴം /Depth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div></div>').appendTo('#boatDet');

        /*$('#bar').append('<div style="color:red">\n\
                Name:' + name + '\n\
            </div>'); */

        //$('#boatDet2').replaceWith('<div id="boatDet" class="row oddtab"><div class="col-3 border-top border-bottom border-left ves_div1"><p class="mt-3 mb-3">Boat #1 <br>Measurement details</p></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="lengthbt" value="" id="lengthbt"  class="form-control"  autocomplete="off" placeholder="നീളം /Length" maxlength="8" data-validation="required" required  onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" /></div></div><div class="col-3 border-top border-bottom border-left ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="breadthbt" value="" id="breadthbt"  class="form-control" maxlength="8" autocomplete="off" placeholder="വീതി /Breadth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="depthbt" value="" id="depthbt" maxlength="8" class="form-control"  autocomplete="off" placeholder="ആഴം /Depth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div></div>');    
      }
       $('<div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addMoreBoat" id="addMoreBoat" onclick="add()" ><i class="far fa-save"></i>&nbsp;Add Boat</button></div></div>').appendTo('#boatDet'); 

      $('#numberofBoats').attr('readonly', true);
      $('#go').attr('disabled', true);
    
  //}
});



/*$('#go').on('click', function( e ) { //alert("hi");
        
        $('#boatDet').show();
        $('#boadHeading').show();
        $('#numberofBoats').attr('readonly', true);
        $('#go').attr('disabled', true);

        e.preventDefault();
        $('<div/>').addClass( 'row oddtab' )
        
        .html( $('<div id="boatDet" class="row oddtab"><div class="col-3 border-top border-bottom border-left ves_div1"><p class="mt-3 mb-3">Boat #1 <br>Measurement details</p></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="lengthbt" value="" id="lengthbt"  class="form-control"  autocomplete="off" placeholder="നീളം /Length" maxlength="8" data-validation="required" required  onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" /></div></div><div class="col-3 border-top border-bottom border-left ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="breadthbt" value="" id="breadthbt"  class="form-control" maxlength="8" autocomplete="off" placeholder="വീതി /Breadth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="depthbt" value="" id="depthbt" maxlength="8" class="form-control"  autocomplete="off" placeholder="ആഴം /Depth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /><button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addMoreBoat" id="addMoreBoat" ><i class="far fa-save"></i>&nbsp;Add Boat</button></div></div></div>').addClass( 'someclass' ) )
        .append( $('<button/>').addClass( 'remove' ).text( 'Remove' ) )
        .insertBefore( this );
    });*/

function add()
{
  var numberofBoats=$('#numberofBoats').val();
  var cnt=parseInt(numberofBoats)+1;

  //alert("numberofBoats"+numberofBoats);alert("cnt"+cnt);
   $('<div id="boatNum' + cnt + '" class="row oddtab"><div class="col-3 border-top border-bottom border-left ves_div1"><p class="mt-3 mb-3">Boat #' + cnt + ' <br>Measurement details</p></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="lengthbt' + cnt + '" value="" id="lengthbt' + cnt + '"  class="form-control"  autocomplete="off" placeholder="നീളം /Length" maxlength="8" data-validation="required" required  onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" /></div></div><div class="col-3 border-top border-bottom border-left ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="breadthbt' + cnt + '" value="" id="breadthbt' + cnt + '"  class="form-control" maxlength="8" autocomplete="off" placeholder="വീതി /Breadth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="depthbt' + cnt + '" value="" id="depthbt' + cnt + '" maxlength="8" class="form-control"  autocomplete="off" placeholder="ആഴം /Depth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div></div>').appendTo('#boatNum' + numberofBoats + ''); 
   
   /*$('<div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addMoreBoat" id="addMoreBoat" onclick="cl()" ><i class="far fa-save"></i>&nbsp;Add Boat</button></div></div>').appendTo('#boatDet'); */
   
   $('#addMoreBoat').hide(); 
   if ($('#remove').length === 0) 
   {
    
    $('<div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addMoreBoat" id="addMoreBoat" onclick="add()" ><i class="far fa-save"></i>&nbsp;Add Boat</button>&nbsp;&nbsp;<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="remove" id="remove" onclick="rem()"  ><i class="far fa-save"></i>&nbsp;Remove</button></div></div>').appendTo('#boatDet');
   }    

   /*Set the final number to number of boats*/
   $('#numberofBoats').val(cnt);
           
}


function rem()
{  
  var cnt=$('#numberofBoats').val();
  $("#boatNum"+cnt).remove();
  var boats=parseInt(cnt)-1;
  $('#numberofBoats').val(boats);
}
 


$('#addMore1').on('click', function( e ) { alert("add");
        
        

        e.preventDefault();
        $('<div/>').addClass( 'new-text-div' )
        
        .html( $('<div id="boatDet" class="row oddtab"><div class="col-3 border-top border-bottom border-left ves_div1"><p class="mt-3 mb-3">Boat #1 <br>Measurement details</p></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="lengthbt" value="" id="lengthbt"  class="form-control"  autocomplete="off" placeholder="നീളം /Length" maxlength="8" data-validation="required" required  onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" /></div></div><div class="col-3 border-top border-bottom border-left ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="breadthbt" value="" id="breadthbt"  class="form-control" maxlength="8" autocomplete="off" placeholder="വീതി /Breadth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /></div></div><div class="col border-top border-bottom ves_div1"><div class="form-group mt-2 mb-2"><input type="text" name="depthbt" value="" id="depthbt" maxlength="8" class="form-control"  autocomplete="off" placeholder="ആഴം /Depth" data-validation="required" required onpaste="return false;"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /><button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addMoreBoat" id="addMoreBoat" ><i class="far fa-save"></i>&nbsp;Add Boat</button></div></div></div>').addClass( 'someclass' ) )
        .append( $('<button/>').addClass( 'remove' ).text( 'Remove' ) )
        .insertBefore( this );
    });
    
    $(document).on('click', 'button.remove', function( e ) {
        e.preventDefault();
        $(this).closest( 'div.new-text-div' ).remove();
    });
</script>

<?php 
/*
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
*/
?>
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vesselId; ?>" >

  <div class="row oddtab">
    <?php echo $value109='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Number of boats  </p>
    </div>

    <div class="col border-top border-bottom ves_div1" id="addboat">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <input type="text" name="numberofBoats" value="" id="numberofBoats"  class="form-control" data-validation="required" required maxlength="4" autocomplete="off" placeholder="Number of boats" onkeypress="return IsNumeric(event);" onpaste="return false;" onchange="return IsZero(this.id);"/>
              <div class="input-group-append">
                <div class="input-group-text"><button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="go" id="go">GO<i class="fas fa-step-forward"></i></button></div> 
              </div> <!-- end of input-group-append -->
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3">  </p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>';?>
  
  
   </div> <!-- end of oddtab -->  
   

    <?php echo '<div id="boatDet"></div> ';?>

    


   <div class="row oddtab">

    <?php echo $value117='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Life buoys : <br>Description  </p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">                
                <textarea class="form-control" rows="3" name="lifeBuoys_desc" id="lifeBuoys_desc" maxlength="200" placeholder="Description"  onkeypress="return IsAddress(event);" data-validation="required" onpaste="return false;" required onchange="return checklength(this.id)" ></textarea>
      </div> <!-- end of form group -->
    </div>';?>

    <?php echo $value118='<div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3"> Buoyancy apparatus : <br>Description </p>
    </div>

   <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <textarea class="form-control" rows="3" name="buoyancyApparatus_desc" id="buoyancyApparatus_desc" maxlength="200" placeholder="Description" data-validation="required" required onpaste="return false;" onkeypress="return IsAddress(event);" onchange="return checklength(this.id)" ></textarea>
      </div> <!-- end of form group -->
    </div>';?>

    </div> <!-- end of oddtab --> 

    <div class="row eventab">
      <?php echo $value119='<div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3"> Navigation light : <br>Description </p>
    </div>

   <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <textarea class="form-control" rows="3" name="navigationLight_desc" id="navigationLight_desc" maxlength="200" placeholder="Description"  onkeypress="return IsAddress(event);" onpaste="return false;" data-validation="required" required onchange="return checklength(this.id)" ></textarea>
      </div> <!-- end of form group -->
    </div>';?>
  
  
   
    <?php echo $value120='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Total Number of Anchor  </p>
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <input type="text" name="anchor_total_num" value="" id="anchor_total_num"  class="form-control" maxlength="4" autocomplete="off" placeholder="Total Number of Anchor" data-validation="required" required onpaste="return false;"  onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
      </div> <!-- end of form group -->
    </div>';?>

    </div>

 
    <div class="row oddtab">
    <?php echo $value129='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Number of Fire Buckets </p>
    </div>
   
   <div class="col-3 border-top border-bottom border-left ves_div1">
          <div class="form-group mt-2 mb-2">
       <input type="text" name="fireBucketsNumber" value="" id="fireBucketsNumber"  class="form-control" maxlength="4" autocomplete="off" placeholder="Number of Fire Buckets" data-validation="required" required  onkeypress="return IsNumeric(event);" onpaste="return false;" onchange="return IsZero(this.id);" />   
      </div> <!-- end of form group -->
    </div>';?>
  

   
   <?php 
    echo $value157=' <div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Generator Location </p>
    </div>
   
   <div class="col-3 border-top border-bottom border-left ves_div1">
          <div class="form-group mt-2 mb-2">
          <div class="input-group">
       <select class="form-control select2" name="location" id="location" placeholder="Select Location" data-validation="required">
            <option value="">Select Location</option>
            <option value="1">Location</option>
           </select> 
            </div> <!-- end of input-group --> 
      </div> <!-- end of form group -->
    </div>';
            /*foreach ($locationDet as $locn)
            {
            
            $value157 .='<option value="'.$locn['location_sl'].'"> '.$locn['location_name'].'</option>';
            
            }
            $value157 .='';*/?>
    </div>

 
    <div class="row eventab">
    <?php 
    echo $value168='<div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Condition of equipment </p>
    </div>


   
   <div class="col-3 border-top border-bottom border-left ves_div1">
          <div class="form-group mt-2 mb-2">     

       <select class="form-control select2" name="conditionofEquipment" id="conditionofEquipment" placeholder="Select Condition of equipment" data-validation="required">
           <option value="">Select Condition of equipment</option>
           <option value="1">Material</option></select>  
      </div> <!-- end of form group -->
    </div>';
           /* foreach ($conditionofItem as $cndn)
            {
            
            echo $value168 .='<option value="'.$cndn['conditionstatus_sl'].'">'.$cndn['conditionstatus_name'].'</option>';
            
            }  
      echo $value168 .=' ';*/?>
  
   </div> <!-- end of oddtab -->


   
 <?php 
 // Placing Div Elements from here
 /* if($row_count==0)
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
  //}/*End of Main if*/ 
  ?>
