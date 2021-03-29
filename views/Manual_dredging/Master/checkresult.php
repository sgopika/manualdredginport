<?php 
$requested_ton=$this->input->post('requestedton');
$master_id=$this->input->post('construct_masterid');
foreach($getdata as $row){
$max_ton=$row['construction_master_max_ton'];}
if($max_ton>=$requested_ton){$result=1;}else{$result=0;}
echo $result;
?>