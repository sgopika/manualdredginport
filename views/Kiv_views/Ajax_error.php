
  <?php 
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id  =   $this->session->userdata('int_usertype');

$message = "Dynamic page is not set";
echo "<script type='text/javascript'>alert('$message');</script>";




if($user_type_id==12)
{
	redirect('Kiv_Ctrl/Survey/csHome/');
}
if($user_type_id==13)
{
	redirect('Kiv_Ctrl/Survey/SurveyorHome/');
}

  
  ?>


