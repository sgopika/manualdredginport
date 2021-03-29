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
            
          </td>
          <td >
            <div id="phone"><?php echo $user_master_ph;?></div>
            
          </td>
          <td >
            <div id="email"><?php echo $user_master_email;?></div>
            
          </td>
          <td>
            <div id="reset_div">
              <button name="edit_registration_btn" id="edit_registration_btn" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="reset_password();" >   <i class="fas fa-key"></i> &nbsp; Reset Password </button>          
            </div>
            <div id="reseting_div" style="display: none;">
               <button name="edit_registration_btn" id="edit_registration_btn" class="btn btn-sm btn-flat btn-point btn-success" type="button" ><i class="fas fa-spinner fa-spin"></i> &nbsp; Reseting Password   </button>       
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

