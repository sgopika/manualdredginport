		 <?php 
        $attributes = array("class" => "form-horizontal", "id" => "instform", "name" => "instform");
        echo form_open("settings/index", $attributes);
		//print_r($data);
		?>
                   <strong> <?php echo $msg=$this->session->flashdata('msg_valid'); ?></strong>
					<label>Username</label>
					<input type="text" name="vchr_uname" id="vchr_uname" />
					<br />

					<label>Password</label>
					<input name="vchr_pass" id="vchr_pass" type="password" autocomplete="off"/>
					<br />

					<div class="action_btns">
					
						<div class="one_half last"><input type="submit" class="btn btn_red"   name="login" id="login" value="Login" ></div>
						
					</div>
				 
					<a href="<?php echo base_url();?>index.php/Accountrecovery/index" class="forgot_password">Forgot password?</a>
                    
                 
                    
                    
                <?php echo form_close(); ?>