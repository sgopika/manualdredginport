<script type="text/javascript">
	
	$(document).ready(function(){	
		
		$("#vessel_fitto_carry_passenger").change(function()
		{
		var fitCarry = $("#vessel_fitto_carry_passenger").val();//alert(fitCarry);

			if (fitCarry==1) 
			{
				$('#headRow').show();
				$('#hiddenDiv').show();
			}

      		else if (fitCarry==2) 
      		{
		        $('#headRow').hide();
		        $('#hiddenDiv').hide();
      		}
		
		});	


/*For calculating total*/
 /* $("#uprDeckbynight").change(function()
  {
      var uprDeckbynight = parseInt($("#uprDeckbynight").val());//alert(uprDeckbynight);
      $("#tot1").val(uprDeckbynight);

      $('#tot1').val(a+b);
          
  });*/

  $('#tab6next').hide();

  $("#checkTotal").click(function()
  {
      if($("#uprDeckbynight").length){var uprDeckbynight  = parseInt($("#uprDeckbynight").val());}else{var uprDeckbynight=0;}	  
	  if($("#inbwDeckbynight").length){var inbwDeckbynight  = parseInt($("#inbwDeckbynight").val());}else{var inbwDeckbynight=0;}
	  if($("#mainDeckbynight").length){var mainDeckbynight  = parseInt($("#mainDeckbynight").val());}else{var mainDeckbynight=0;}

	  if($("#uprDeckbydaynight").length){var uprDeckbydaynight=parseInt($("#uprDeckbydaynight").val());}else{var uprDeckbydaynight=0;}	  
	  if($("#inbwbydaynight").length){var inbwbydaynight  = parseInt($("#inbwbydaynight").val());}else{var inbwbydaynight=0;}
	  if($("#mainDeckbydaynight").length){var mainDeckbydaynight  = parseInt($("#mainDeckbydaynight").val());}else{var mainDeckbydaynight=0;}

	  if($("#uprDeckbydayvoyages").length){var uprDeckbydayvoyages=parseInt($("#uprDeckbydayvoyages").val());}else{var uprDeckbydayvoyages=0;}	  
	  if($("#inbwbydayvoyages").length){var inbwbydayvoyages  = parseInt($("#inbwbydayvoyages").val());}else{var inbwbydayvoyages=0;}
	  if($("#mainDeckbydayvoyages").length){var mainDeckbydayvoyages  = parseInt($("#mainDeckbydayvoyages").val());}else{var mainDeckbydayvoyages=0;}

	  if($("#secCabinBynight").length){var secCabinBynight=parseInt($("#secCabinBynight").val());}else{var secCabinBynight=0;}	  
	  if($("#saloonBynight").length){var saloonBynight  = parseInt($("#saloonBynight").val());}else{var saloonBynight=0;}

	  if($("#secCabinBydaynight").length){var secCabinBydaynight=parseInt($("#secCabinBydaynight").val());}else{var secCabinBydaynight=0;}  
	  if($("#saloonBydaynight").length){var saloonBydaynight  = parseInt($("#saloonBydaynight").val());}else{var saloonBydaynight=0;}

	  if($("#secCabinBydayVoyages").length){var secCabinBydayVoyages=parseInt($("#secCabinBydayVoyages").val());}else{var secCabinBydayVoyages=0;}	  
	  if($("#saloonBydayVoyages").length){var saloonBydayVoyages  = parseInt($("#saloonBydayVoyages").val());}else{var saloonBydayVoyages=0;}


	  /*var uprDeckbynight      = parseInt($("#uprDeckbynight").val());
	  var inbwDeckbynight     = parseInt($("#inbwDeckbynight").val());
	  var mainDeckbynight     = parseInt($("#mainDeckbynight").val());

	  var uprDeckbydaynight   = parseInt($("#uprDeckbydaynight").val());
	  var inbwbydaynight      = parseInt($("#inbwbydaynight").val());
	  var mainDeckbydaynight  = parseInt($("#mainDeckbydaynight").val());

	  var uprDeckbydayvoyages = parseInt($("#uprDeckbydayvoyages").val());
	  var inbwbydayvoyages    = parseInt($("#inbwbydayvoyages").val());
	  var mainDeckbydayvoyages= parseInt($("#mainDeckbydayvoyages").val());

	  var secCabinBynight     = parseInt($("#secCabinBynight").val());
	  var saloonBynight       = parseInt($("#saloonBynight").val());

	  var secCabinBydaynight  = parseInt($("#secCabinBydaynight").val());
	  var saloonBydaynight    = parseInt($("#saloonBydaynight").val());

	  var secCabinBydayVoyages= parseInt($("#secCabinBydayVoyages").val());
	  var saloonBydayVoyages  = parseInt($("#saloonBydayVoyages").val());*/
      
      //$("#tot1").val(uprDeckbynight);

      if($("#form6").isValid())
      {
  /*var form = $("#form6");
  form.validate();
    if(form.valid())
  {*/


	  	  $('#tot1').val(uprDeckbynight+inbwDeckbynight+mainDeckbynight);
	      $('#tot2').val(uprDeckbydaynight+inbwbydaynight+mainDeckbydaynight);
	      $('#tot3').val(uprDeckbydayvoyages+inbwbydayvoyages+mainDeckbydayvoyages);

	      $('#tot4').val(secCabinBynight+saloonBynight);
	      $('#tot5').val(secCabinBydaynight+saloonBydaynight);      
	      $('#tot6').val(secCabinBydayVoyages+saloonBydayVoyages);

	      /*display save button*/
	      $('#tab6next').show();
	      $('#checkTotal').hide();
	      $('#changeValue').show();

	      $('#uprDeckbynight').attr('readonly', true);
	      $('#inbwDeckbynight').attr('readonly', true);
	      $('#mainDeckbynight').attr('readonly', true);

	      $('#uprDeckbydaynight').attr('readonly', true);
	      $('#inbwbydaynight').attr('readonly', true);
	      $('#mainDeckbydaynight').attr('readonly', true);

	      $('#uprDeckbydayvoyages').attr('readonly', true);
	      $('#inbwbydayvoyages').attr('readonly', true);
	      $('#mainDeckbydayvoyages').attr('readonly', true);

	      $('#secCabinBynight').attr('readonly', true);
	      $('#saloonBynight').attr('readonly', true);

	      $('#secCabinBydaynight').attr('readonly', true);
	      $('#saloonBydaynight').attr('readonly', true);

	      $('#secCabinBydayVoyages').attr('readonly', true);
	      $('#saloonBydayVoyages').attr('readonly', true);
  	  }

          
  });


$("#changeValue").click(function()
	{
		$('#tab6next').hide();
	    $('#checkTotal').show();
	    $('#changeValue').hide();

		$('#uprDeckbynight').attr('readonly', false);
	    $('#inbwDeckbynight').attr('readonly', false);
	    $('#mainDeckbynight').attr('readonly', false);

	    $('#uprDeckbydaynight').attr('readonly', false);
	    $('#inbwbydaynight').attr('readonly', false);
	    $('#mainDeckbydaynight').attr('readonly', false);

	    $('#uprDeckbydayvoyages').attr('readonly', false);
	    $('#inbwbydayvoyages').attr('readonly', false);
	    $('#mainDeckbydayvoyages').attr('readonly', false);

	    $('#secCabinBynight').attr('readonly', false);
	    $('#saloonBynight').attr('readonly', false);

	    $('#secCabinBydaynight').attr('readonly', false);
	    $('#saloonBydaynight').attr('readonly', false);

	    $('#secCabinBydayVoyages').attr('readonly', false);
	    $('#saloonBydayVoyages').attr('readonly', false);    
	});
/*For calculating total*/


	});


</script>





  <div class="row oddtab">

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3"> Is the vessel fit to carry passengers  </p>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <select class="form-control select2" name="vessel_fitto_carry_passenger" id="vessel_fitto_carry_passenger" placeholder="Select" data-validation="required">
           <option value="">Select</option>
           <?php foreach ($choice as $chs)
            {?>
            
            <option value="<?php echo $chs['choice_sl'];?>"><?php echo $chs['choice_name'];?></option>
            
            <?php } ?>
            
            </select>
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3">  </p>
              
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3">  </p> 
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>
  
   </div> <!-- end of oddtab -->  

<div id="hiddenDiv" style="display: none;">
    <div class="row eventab" id="headRow" style="display: none;">
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3"> When plying by night <br>(smooth & partially smooth water)  </p> 
          </div> <!-- end of input-group -->
               
      </div> <!-- end of form group -->
    </div>

   <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3">When plying by day or in canals<br> by night and day <br>(smooth & partially smooth water)</p> 
          </div> <!-- end of input-group -->
               
      </div> <!-- end of form group -->
    </div>


     <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <p class="mt-3 mb-3">When plying by day on voyages <br>which do not last more than 6 hours <br>(smooth water only)</p> 
          </div> <!-- end of input-group -->
               
      </div> <!-- end of form group -->
    </div>
  
   </div> <!-- end of eventab -->  
<?php 
  //print_r($choice);
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
 $value136=""; $value137=""; $value138=""; $value139="";

 $value140='<!--<div class="row oddtab" id="upperHead">-->
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
          <p class="mt-3 mb-3">Upper Deck</p>             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="uprDeckbynight" value="" id="uprDeckbynight"  class="form-control"  autocomplete="off" placeholder="Upper deck - plying  by night"  maxlength="5" data-validation="required" required onpaste="return false;"  onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>

  <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="uprDeckbydaynight" value="" id="uprDeckbydaynight"   maxlength="5" class="form-control"  autocomplete="off" placeholder="Upper deck - plying by day or in canals by night and day" data-validation="required" required  onkeypress="return IsNumeric(event);" onpaste="return false;" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>


      <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="uprDeckbydayvoyages" value="" id="uprDeckbydayvoyages"   maxlength="5" class="form-control"  autocomplete="off" placeholder="Upper deck - plying by day on voyages" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>
  
   <!--</div>  end of eventab -->';


  $value141='<!--<div class="row eventab" id="betweenHead">-->
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
          <p class="mt-3 mb-3">In between Deck</p>             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="inbwDeckbynight" value="" id="inbwDeckbynight"   maxlength="5" class="form-control"  autocomplete="off" placeholder="In between Deck - plying  by night" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>

  <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="inbwbydaynight" value="" id="inbwbydaynight"  maxlength="5"  class="form-control"  autocomplete="off" placeholder="In between Deck - plying by day or in canals by night and day" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>


      <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="inbwbydayvoyages" value="" id="inbwbydayvoyages"  maxlength="5"  class="form-control"  autocomplete="off" placeholder="In between Deck - plying by day on voyages" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>
  
   <!--</div>  end of eventab -->  ';


    $value142='<!--<div class="row oddtab" id="maindeckHead">-->
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
          <p class="mt-3 mb-3">Main Deck</p>             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="mainDeckbynight" value="" id="mainDeckbynight"  maxlength="5"  class="form-control"  autocomplete="off" placeholder="Main Deck - plying  by night" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>

  <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="mainDeckbydaynight" value="" id="mainDeckbydaynight"  maxlength="5"  class="form-control"  autocomplete="off" placeholder="Main Deck - plying by day or in canals by night and day" data-validation="required" required  onkeypress="return IsNumeric(event);" onpaste="return false;" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>


      <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="mainDeckbydayvoyages" value="" id="mainDeckbydayvoyages"  maxlength="5"  class="form-control"  autocomplete="off" placeholder="Main Deck  - plying by day on voyages" data-validation="required" required  onkeypress="return IsNumeric(event);" onpaste="return false;" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>
  
   <!-- </div> end of eventab -->  ';


    $value143='<!--<div class="row eventab" id="totalHead">-->
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
          <p class="mt-3 mb-3">Total Deck Passengers</p>             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
               <p class="mt-3 mb-3">Total-<input type="text" name="tot1" value="" id="tot1"  readonly  class="form-control" /></p> 
        </div>
      </div> <!-- end of form group -->
    </div>

  <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
               <p class="mt-3 mb-3">Total-<input type="text" name="tot2" value="" id="tot2"  readonly  class="form-control" /></p> 
        </div>
      </div> <!-- end of form group -->
    </div>


      <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
               <p class="mt-3 mb-3">Total-<input type="text" name="tot3" value="" id="tot3"  readonly  class="form-control" /></p> 
        </div>
      </div> <!-- end of form group -->
    </div>
  
  <!--  </div> end of eventab -->'; 


  $value144='<!--<div class="row oddtab" id="secondCabinHead">-->
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
          <p class="mt-3 mb-3">Second Cabin Passengers</p>             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="secCabinBynight" value="" id="secCabinBynight"   maxlength="5" class="form-control"  autocomplete="off" placeholder="Second Cabin Passengers" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>

  <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="secCabinBydaynight" value="" id="secCabinBydaynight"  maxlength="5"  class="form-control"  autocomplete="off" placeholder="Second Cabin Passengers" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>


      <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="secCabinBydayVoyages" value="" id="secCabinBydayVoyages"  maxlength="5"  class="form-control"  autocomplete="off" placeholder="Second Cabin Passengers" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>
    <!--</div>  end of eventab -->';

   $value145='<!--<div class="row eventab" id="saloonHead">-->
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
          <p class="mt-3 mb-3">Saloon Passengers</p>             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="saloonBynight" value="" id="saloonBynight"  class="form-control"  maxlength="5"  autocomplete="off" placeholder="Saloon Passengers" data-validation="required" required  onkeypress="return IsNumeric(event);" onpaste="return false;" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>

  <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="saloonBydaynight" value="" id="saloonBydaynight"   maxlength="5" class="form-control"  autocomplete="off" placeholder="Saloon Passengers" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>


      <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
                <input type="text" name="saloonBydayVoyages" value="" id="saloonBydayVoyages"   maxlength="5" class="form-control"  autocomplete="off" placeholder="Saloon Passengers" data-validation="required" required onpaste="return false;" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" />
        </div>
      </div> <!-- end of form group -->
    </div>

  
   <!--</div>  end of eventab -->';

    $value146='<!--<div class="row eventab" id="totalHead">-->
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
          <p class="mt-3 mb-3"></p>             
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>

    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
               <p class="mt-3 mb-3">Total-<input type="text" name="tot4" value="" id="tot4"  readonly  class="form-control" /></p> 
        </div>
      </div> <!-- end of form group -->
    </div>

  <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
               <p class="mt-3 mb-3">Total-<input type="text" name="tot5" value="" id="tot5"  readonly  class="form-control" /></p> 
        </div>
      </div> <!-- end of form group -->
    </div>


      <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
               <p class="mt-3 mb-3">Total-<input type="text" name="tot6" value="" id="tot6"  readonly  class="form-control" /></p> 
        </div>
      </div> <!-- end of form group -->
    </div>
  
  <!--  </div> end of eventab -->'; 
   // Placing Div Elements from here
  /*if($row_count==0)
  { 
    $row_count=1;*/
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
    /*}
    else // Already a row has been opened.
  {
    $row_count=0;
  
    $value="value".$labelId;
      echo ${$value};*/
      ?>
    </div> <!-- end of opened placing row -->

    <?php
  //} //End of var_row condition  
  
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
 <button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="checkTotal" id="checkTotal" ><i class="far fa-save"></i>&nbsp;Check Total & Proceed</button> 
 <button type="button" style="display: none;" class="btn btn-success btn-flat  btn-point btn-sm" name="changeValue" id="changeValue" ><i class="far fa-save"></i>&nbsp;Change Passenger Details</button> 
</div>







   