
<div>
  <?php $attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1" , "novalidate"); 
              echo form_open("Kiv_Ctrl/Master/testpassword", $attributes);  
  ?>
  <div class="row " >
      <div class="port-content-noborder  col-lg-8 col-md-8 port-bg-lightgray ">
          
      </div> <!-- end of col 8 ----- -->
      <div class="port-content-noborder  col-lg-4 col-md-4 port-bg-blue ">
              <p class="home_title"> Hash Password</p>
                  <div class="col-md-12 col-lg-12">
                    
                    <fieldset class="form-group">
                        <label for="email" class="home_linkhead">Password</label>
                        <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Password">
                    </fieldset>
                    <button type="submit" class="btn btn-danger opaqueclass btn-flat btn-point btn-block home_linkhead_w" name="login"  id="login" ><i class="fas fa-sign-in-alt"></i>&nbsp; Encrypt </button>
                </div>   <!-- end of inner col12 --->
      </div> <!-- end of col 4 ------->
  </div> <!-- end of row ------------ >
 <?php echo form_close(); ?>
</div>