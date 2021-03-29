<?php if(isset($search_det)){ if(!empty($search_det)){//print_r($search_det);

  if(($search_id==1)||($search_id==2)){
    
    foreach ($search_det as $search_res) {
      $userid             = $search_res['user_master_id'];
      $username           = $search_res['user_master_fullname'];
      $user_address       = $search_res['user_address'];
      $user_master_ph     = $search_res['user_master_ph'];
      $user_master_email  = $search_res['user_master_email'];
    }

  } else {

    foreach ($search_det as $search_res) {
      $userid             = $search_res['user_master_id'];
      $username           = $search_res['user_master_fullname'];
      $user_address       = $search_res['user_address'];
      $user_master_ph     = $search_res['user_master_ph'];
      $user_master_email  = $search_res['user_master_email'];
    }

  }

?>
  
  <div class="col-12">
    <table id="example1" class="table table-bordered table-striped table-hover text-blue">
      <thead>
        <tr>
          <th >User Name</th>
          <th id="col_name">User Address</th>
          <th id="col_name">Mobile Number</th>
          <th id="col_name">Email ID</th>
          <th id="col_name"></th>
          
        </tr>
      </thead>
      <tbody>
        <tr >
          <td ><?php  echo $username;  ?> 
          <input type="hidden" name="hid_id" id="hid_id" value="<?php echo $userid;?>">
          </td>

          <td >
            <div id="address"><?php echo $user_address;?></div>
            <div id="hide_address"  style="display:none">
              <input type="text" name="edit_address"  id="edit_address" value="<?php echo $user_address;?>" onkeypress="return IsAddress(event);"    autocomplete="off"/>
            </div> 
          </td>
          <td >
            <div id="phone"><?php echo $user_master_ph;?></div>
            <div id="hide_ph"  style="display:none">
              <input maxlength="20" class="div300" type="text" name="edit_ph"  id="edit_ph" value="<?php echo $user_master_ph;?>" onkeypress="return IsNumeric(event);"    autocomplete="off"/>
            </div>
          </td>
          <td >
            <div id="email"><?php echo $user_master_email;?></div>
            <div id="hide_email" style="display:none">
              <input  class="div300" type="text" name="edit_email"  id="edit_email" onchange="return validateEmail(this.value);" value="<?php echo $user_master_email;?>" autocomplete="off"/>
            </div> 
          </td>
          <td>
            <div id="edit_div">
              <button name="edit_registration_btn" id="edit_registration_btn" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_registration();" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
            </div>
            <div id="save_div" style="display:none" class="div150">
              <button class="btn btn-sm btn-success btn-flat" type="button" name="save_registration" id="save_registration" onclick="save_registration();" >    &nbsp; Save  </button> &nbsp;&nbsp;
              <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_registration" id="cancel_registration" onclick="cancel_registration();" >   &nbsp; Cancel  </button> 
            </div>
          </td>
        </tr>
      </tbody>  
    </table>
  </div>

<?php } else {?>

<div class="col-12">
  No Rows Found
</div>

<?php }} ?>

