 <div class="row no-gutters ml-3 mr-3 mb-3 mt-2">
      <div class="col-12">
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
            <option value="">Select</option>
            <?php foreach ($hullmaterial as $res_hullmaterial)
            {
            ?>
            <option value="<?php echo $res_hullmaterial['hullmaterial_sl']; ?>"> <?php echo $res_hullmaterial['hullmaterial_name'];?>  </option>
            <?php
            } 
            ?>
            </select>
      </div> <!-- end of form group -->
    </div> <!-- end of col -->
    <div class="col-3 border-bottom border-left ">
      <p class="mt-3 mb-3">Whether Engine inboard/outboard</p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-2 mb-2">
                  <select class="custom-select select2" name="engine_placement_id" id="engine_placement_id" title="Select Engine inboard/outboard" data-validation="required">
                  <option value="">Select</option>
                    <?php
                    foreach ($inboard_outboard as $res_inboard_outboard)
                   {
                        ?>
                     <option value="<?php echo $res_inboard_outboard['inboard_outboard_sl']; ?>" <?php //if($res_inboard_outboard['inboard_outboard_sl']==$sltid1) { echo "selected"; }?>> <?php echo $res_inboard_outboard['inboard_outboard_name']; ?>  </option>
                    <?php
                   }
                    ?>
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
              <option value="">Select</option>
              <?php foreach ($month as $res_month)
              {
              ?>
              <option value="<?php echo $res_month['month_sl']; ?>"> <?php echo $res_month['month_name'];?>  </option>
              <?php
              } 
              ?>
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
            <option value="">Select</option>
            <?php foreach ($vesselcategory as $res_vesselcategory)
            {
            ?>
            <option value="<?php echo $res_vesselcategory['vesselcategory_sl']; ?>"> <?php echo $res_vesselcategory['vesselcategory_name'];?> </option>
            <?php
            } 
            ?>
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