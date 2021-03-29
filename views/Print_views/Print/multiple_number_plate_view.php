<?php 
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
/*_____________________Decoding Start___________________*/
$count_id = count($ids);
for($i=0;$i<$count_id;$i++){
	 $vessel = $ids[$i];
	$vessel_details       =   $this->Print_model->get_vessel_details($vessel); //print_r($vessel_details);
    $data['vessel_details']   = $vessel_details;

    if(!empty($vessel_details))
	{
		foreach($vessel_details as $res_vessel)
	  	{
		    $vessel_name                =     $res_vessel['vesselmain_vessel_name'];
		     $vesselmain_reg_number       =     $res_vessel['vesselmain_reg_number'];
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


			</div>
<?php
	    }
	}

}





?>

