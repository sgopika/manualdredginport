
 <div class="row oddtab">

    <div class="col-3 border-bottom ves_div1">
      <p class="mt-3 mb-3"> Type of vessel </p>
    </div><!-- end of col-2 ves_div1 -->

    <div class="col-3 border-bottom  ves_div1">
      <div class="form-group mt-2 mb-2">
          <select class="custom-select select2" name="vessel_type_id" id="vessel_type_id" title="Select Vessel Type" data-validation="required">
        
    <option value="">Select</option>
    <?php foreach ($vesseltype as $res_vesseltype)
    {
    ?>
    <option value="<?php echo $res_vesseltype['vesseltype_sl']; ?>"> <?php echo $res_vesseltype['vesseltype_name'];?>  </option>
    <?php
    } 
    ?>
          </select> 
      </div> <!-- end of form group -->
    </div> <!-- end of col-2 ves_div1 -->
    <div class="col-3 border-bottom border-left ves_div1">
      <p class="mt-3 mb-3 "> Subtype of vessel </p>
    </div>
    <div class="col-3 border-bottom ves_div1 ">
       <div class="form-group mt-2 mb-2">
              <select class="custom-select select2" name="vessel_subtype_id" id="vessel_subtype_id" title="Select Vessel Sub Type" > </select>
   </div> <!-- end of form group -->
    </div>
   </div> <!-- end of oddtab row in tab-pane -->

<div class="row eventab">
    <div class="col-3 border-bottom">
      <p class="mt-3 mb-3">Material of hull</p>
    </div> <!-- end of col-2 -->
    <div class="col border-bottom">
      <div class="form-group mt-2 mb-2">
      <select class="custom-select select2" name="hullmaterial_id" id="hullmaterial_id" title="Enter Material of hull" data-validation="required">
          
            </select>
      </div> <!-- end of form group -->
    </div> <!-- end of col -->
    <div class="col-3 border-bottom border-left ">
      <p class="mt-3 mb-3">Whether Engine inboard/outboard</p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-2 mb-2">
                  <select class="custom-select select2" name="engine_placement_id" id="engine_placement_id" title="Select Engine inboard/outboard" data-validation="required">
                

                  </select>
   </div> <!-- end of form group -->
    </div>
   </div> <!-- end of eventab -->
   <div class="row oddtab">
    <div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Vessel name  </p>
    </div>
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Vessel Name" data-validation="required"/>
      </div> <!-- end of form group -->
    </div>
    <div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3"> Proposed month and year of completion </p>
    </div>
    <div class="col-2 border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
          <select class="form-control select2" name="month_id" id="month_id" title="Select Month" data-validation="required">
            
              </select>
      </div> <!-- end of form group -->
    </div>
    <div class="col-1 border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
          <input type="text" name="vessel_expected_completion" value="2018" id="vessel_expected_completion"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Proposed Year of Completion"  data-validation="number"/>
      </div> <!-- end of form group -->
    </div>
   </div> <!-- end of oddtab -->
    <div class="row eventab">
    <div class="col-3 border-bottom ves_div2">
      <p class="mt-3 mb-3">Category of vessel</p>
    </div> <!-- end of col-2 -->
    <div class="col border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
      <select class="form-control select2" name="vessel_category_id" id="vessel_category_id" title="Select Vessel Category" data-validation="required">
            
            </select>
      </div> <!-- end of form group -->
    </div> <!-- end of col -->
    <div class="col-3 border-bottom border-left ves_div2">
      <p class="mt-3 mb-3">Sub category of vessel</p>
    </div>
    <div class="col border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
                  <select class="form-control select2" name="vessel_subcategory_id" id="vessel_subcategory_id" title="Select Vessel SubCategory">
        </select>
   </div> <!-- end of form group -->
    </div>
   </div> <!-- end of eventab -->
   <div class="row oddtab">
    <div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Length overall </p>
    </div>
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <input type="text" name="vessel_length_overall" value="" id="vessel_length_overall"  class="form-control"  maxlength="2" autocomplete="off" title="Length Over All" data-validation="number"/>
              <div class="input-group-append">
                <div class="input-group-text">m</div> 
              </div> <!-- end of input-group-append -->
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>
    <div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3">  Number of deck </p>
    </div>
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
          <input type="text" name="vessel_no_of_deck" value="" id="vessel_no_of_deck"  class="form-control"  maxlength="1" autocomplete="off" title="Enter Number of Deck"  data-validation="required" onkeypress="return IsNumeric(event);"/>
      </div> <!-- end of form group -->
    </div>
   </div> <!-- end of oddtab -->
   <div class="row eventab divheight">
    <div class="col-3 d-flex justify-content-center align align-items-center"> Length over the deck
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Breadth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Depth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Tonnage
    </div> <!-- end of col-3 flex -->
   </div> <!-- end of eventab -->
   <div class="row oddtab">
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" class="form-control" name="vessel_length" value="" id="vessel_length" maxlength="5" autocomplete="off" title="Enter Vessel Length" data-validation="required" onkeypress="return IsDecimal(event);">
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" name="vessel_breadth" value="" id="vessel_breadth"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Vessel Breadth" data-validation="required" onkeypress="return IsDecimal(event);"/>
          <div class="input-group-append ">
            <div class="input-group-text ">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" name="vessel_depth" value="" id="vessel_depth"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Vessel Depth" data-validation="required" onkeypress="return IsDecimal(event);"/>
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-2 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
        <button type="button" class="btn bg-secondary text-white btn-flat" id="check_tonnage"> Check </button>
      </div>
    </div>
    <div class="col d-flex justify-content-center" id="Ton"> 
      <font color="#00f" id="show_tonnage">  </font>  
    </div> <!-- end of col-3 d-flex -->
   </div> <!-- end of oddtab -->
   <div class="row eventab divheight">
    <div class="col-3 d-flex justify-content-center align align-items-center"> Length upper the deck
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Breadth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Depth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Tonnage
    </div> <!-- end of col-3 flex -->
   </div> <!-- end of eventab -->
   <div class="row oddtab">
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" class="form-control" name="vessel_upperdeck_length" value="" id="vessel_upperdeck_length" maxlength="4" autocomplete="off" title="Enter Vessel Length Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);" />
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" name="vessel_upperdeck_breadth" value="" id="vessel_upperdeck_breadth"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Vessel Breadth Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);"/>
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" name="vessel_upperdeck_depth" value="" id="vessel_upperdeck_depth"  class="form-control"  maxlength="4" autocomplete="off"  title="Enter Vessel Depth Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);"/>
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-2 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
        <button type="button" class="btn bg-secondary text-white btn-flat" id="check_tonnage_upperdeck"> Check </button>
      </div>
    </div>
    <div class="col d-flex justify-content-center" id="Ton_upperdeck"> 
      <font color="#00f" id="show_upperdeck_tonnage">  </font>  
    </div> <!-- end of col-3 d-flex -->
   </div> <!-- end of oddtab -->
   <div class="row eventab d-flex justify-content-end">
    <div class="col-1"> 
     <button type="button" class="btn btn-primary btn-flat" name="tab1next" id="tab1next" >Save</button>
    </div> <!-- end of col-2 save col -->
   </div> <!-- end of eventab -->
    </div> <!-- end of col-12 inside row in the tab pane -->
    </div> <!-- end of main inside row in the tab pane -->
    <!-- end of content in tab pane -->
  </div><!-- end of tab-pane 1 -->
</form>
</div>

               
<!-- ______________________ Particulars of Hull _________________________ -->

<div class="tab-pane" id="tab_2">
<form name="form2" id="form2" method="post" >

<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" > 
<div id="hulldetails"> </div>



<table id="show_headplacement" class="table table-bordered table-striped">
<tr>
<td colspan="2">
  <td><span id="num_bulk" >Number of Bulk Head</span>  </td>
    <td> <div class="div100"> <div class="form-group" id="bulk_heads_show" >
    <input type="text" name="bulk_heads" value="" id="bulk_heads"  class="form-control"  maxlength="3" autocomplete="off" onkeypress="return IsNumeric(event);" title="Enter Number of Bulk Head" data-validation="number"/>
    </div> </div>
    </td>
  </tr>
  <tr>
    <td colspan="4">
    <table id="show_headplacement" class="table table-bordered table-striped"></table>
    </td>
  </tr>
  

</table>

<button type="button" class="btn btn-info pull-right btn-space " name="tab2next" id="tab2next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab2back" id="tab2back">Back</button>  

</form>
</div>

<!-- /. end of tab-pane 2 -->



<!-- __________________________ Particulars of Engine __________________________-->


<div class="tab-pane" id="tab_3">
<form name="form3" id="form3" method="post">
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<span id="show_field"></span>
<table id="vacbtable" class="table table-bordered table-striped">
  <tr> 
    <td colspan="3">  Number of engine sets  </td>
    <td colspan="2">  <div class="div100" >
    <div class="input-group input-group-sm" id="engine1">
    <span class="input-group-btn"> 
    <button type="button" class="btn btn-primary btn-flat" id="chg_engine" name="chg_engine"> Go </button>
    </span> 

    </div>
    <!-- /input-group -->
    </div> 
    </td>
  </tr>
  <tr>
    <td colspan="5" align="center" >
    <div id="show_engine_set">
    </div>
    </td>
  </tr>
  <tr> 
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab3next" id="tab3next">Save</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab3back" id="tab3back">Back</button>  
    </td> 
  </tr>

</table>
</form>
</div>
<!-- /. end of tab-pane 3 -->

<!-- _________________________ Particulars of Equipment _______________________________ -->

<div class="tab-pane" id="tab_4">

<table id="vacbtable" class="table table-bordered table-striped">
</table>
<form name="form4" id="form4" method="post">    
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >                

<table  class="table table-bordered table-striped">

<tr> <td id="equipment1" colspan="5"></td></tr>
<tr> <td colspan="5"> 
<button type="button" class="btn btn-info pull-right btn-space" name="tab4next" id="tab4next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab4back" id="tab4back">Back</button>  

</td> </tr>
</table>
</form>     
</div>
 <!-- /. end of tab-pane 4-->

              
<!--__________________________ Particulars of Fire Appliance _____________________________-->
             
<div class="tab-pane" id="tab_5">
<form name="form5" id="form5" method="post">  
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<table id="vacbtable" class="table table-bordered table-striped">


<tr><td id="fireappliance1" colspan="5"></td> </tr>
<tr> <td colspan="5"> 
<button type="button" class="btn btn-info pull-right btn-space" name="tab5next" id="tab5next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab5back" id="tab5back">Back</button>  

</td> </tr>
</table>
</form>
</div>
 <!-- /. end of tab-pane 5-->

              
<!--________________________ Other Equipment _____________________________ -->

<div class="tab-pane" id="tab_6">
<form name="form6" id="form6" method="post">  
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<table id="vacbtable" class="table table-bordered table-striped">

<tr><td id="otherequipment1" colspan="5"></td> </tr>
<tr> <td colspan="5"> 
<button type="button" class="btn btn-info pull-right btn-space" name="tab6next" id="tab6next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab6back" id="tab6back">Back</button>  

</td> </tr>
</table>
</form>
</div>
<!-- /. end of tab-pane 6-->
              
    <!-- ______________________ Documents ________________________________-->

<div class="tab-pane" id="tab_7">


<form name="form7" id="form7" method="post" action="" enctype="multipart/form-data">  
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" > 
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >

<table id="vacbtable" class="table table-bordered table-striped">


<tr><td id="documents1" colspan="5"></td> </tr>


  <tr>
    <td> Preferred Inspection Date</td>
    <td colspan="4" > 
                 
    <div class="div250">
    <div class="form-group">
    <div class="input-group date">
    <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
    </div>
     <input type="text" class="form-control" id="datepicker3" name="vessel_pref_inspection_date" title="Enter Preferred Inspection Date" data-validation="required">
    </div>

    </div>

    </div>
    </td>
  </tr>       
  <tr> 
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab7next" id="tab7next">Save</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab7back" id="tab7back">Back</button>  
    </td>
  </tr>

</table>
</form>
</div> 
<!-- /. end of tab-pane 7-->
              
<!--_______________Payment Details __________________________ --> 

<div class="tab-pane" id="tab_8">
<form name="form8" id="form8" method="post"> 
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<table id="vacbtable" class="table table-bordered table-striped">

<tr colspan="5" id="payment"></tr>
 
 
<tr> <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab8next" id="tab8next">Submit</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab8back" id="tab8back">Back</button>  
    </td>
  </tr>

</table>
</form>
</div>
              
<!-- /. end of tab-pane 8--> 