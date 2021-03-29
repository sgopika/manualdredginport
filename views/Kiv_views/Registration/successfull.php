<?php 	 $id=$this->uri->segment(4);

 $user_name=$owner_details[0]['user_name'];
 $user_password=$owner_details[0]['user_password'];
 ?>
 Successfully Registered....<br><br>

 Your Username  : <?php echo $user_name; ?><br>

 Your Password  : <?php echo $user_password; ?><br>

 <br><br>
 <a class="btn btn-secondary" href="<?php echo base_url()."index.php/Main_login/index"?>"><i class="fas fa-home"></i>&nbsp;Home</a>
