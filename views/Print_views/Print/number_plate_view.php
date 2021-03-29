<?php

$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
/*_____________________Decoding Start___________________*/
$vessel_id    = $this->uri->segment(4);


$vessel_id     = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id);
$vessel_id     = $this->encrypt->decode($vessel_id); 




$vessel_details       =   $this->Print_model->get_vessel_details($vessel_id);
  $data['vessel_details']   = $vessel_details;


if(!empty($vessel_details))
{
	foreach($vessel_details as $res_vessel)
  	{
	    $vessel_name                =     $res_vessel['vessel_name'];
	    $vesselmain_reg_number       =     $res_vessel['vesselmain_reg_number'];
	    

    }
}



?>

<div class="ui-innerpage">
<div class="row no-gutter text-primary">
<div align="center"  class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong> </strong>
</div> <!-- end of col12 -->
<div align="center" class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong><?php echo $vesselmain_reg_number;?> </strong>
</div> <!-- end of col12 -->
</div>
<div></div>
<div></div>
<div></div>
<div></div>

</div>