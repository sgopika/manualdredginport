<?php
if(!empty($refnumber_details)) 
{
  $vessel_id=$refnumber_details[0]['vessel_id'];
  $ref_number=$refnumber_details[0]['ref_number'];
  $ref_process_id=$refnumber_details[0]['process_id'];
  $ref_number_status=$refnumber_details[0]['ref_number_status'];
}
else
{
  $vessel_id="";
  $ref_number="";
  $ref_process_id="";
  $ref_number_status="";
}
if(!empty($vessel_id))
{
	if($ref_number_status==1)
	{
		$processing_status="Processing";
	}
	else
	{
		$processing_status="Completed";
	}
	$form_number           =   $this->Survey_model->get_form_number($vessel_id); 
	$data['form_number']   =   $form_number;
	if (!empty($form_number)) 
	{
		@$form_no =$form_number[0]['form_no'];
	}
	else
	{
		@$form_no =0;
	}
	$processflow           =   $this->Survey_model->get_processflow_vessel($vessel_id);
	$data['processflow']   =   $processflow;
	//print_r($processflow);
	if(!empty($processflow))
	{
		$process_id 		=	$processflow[0]['process_id'];
		$survey_id 			=	$processflow[0]['survey_id'];
		$current_status_id 	=	$processflow[0]['current_status_id'];
		$current_position 	=	$processflow[0]['current_position'];
		$user_id 			= 	$processflow[0]['user_id'];
	}

	$status_details           =   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
	$data['status_details']   =   $status_details;
	if(!empty($status_details))
	{
		$sending_user_id 	=	$status_details[0]['sending_user_id'];
		$receiving_user_id  =	$status_details[0]['receiving_user_id'];
		@$status_id         =   $status_details[0]['current_status_id'];
		@$process_id_status =   $status_details[0]['process_id'];
	}

	$user_type_details          =   $this->Survey_model->get_user_master($receiving_user_id);
	$data['user_type_details']  =   $user_type_details;
	//print_r($user_type_details);
	@$usertype_name 			= 	$user_type_details[0]['user_type_type_name'];

	$user_type_details1           	=   $this->Survey_model->get_user_master($sending_user_id);
	$data['user_type_details1']    	=   $user_type_details1;
	@$usertype_name_from 			= 	$user_type_details1[0]['user_type_type_name'];

	$survey_master           =   $this->Survey_model->get_survey_name($ref_process_id); 
	$data['survey_master']   =   $survey_master;
	if(!empty($survey_master))
	{
  		$survey_name=$survey_master[0]['survey_name'];
  	}
  	else 
  {
  //$survey_name=""; 
    if($process_id_status==14)
    {
      $survey_name="Registration";
    }
    elseif($process_id_status==16) {
      $survey_name="Registration";
    }
    elseif($process_id_status==38) {
      $survey_name="Name change";
    }
    elseif ($process_id_status==39) {
       $survey_name="Ownership change";
    } 
    elseif ($process_id_status==40) {
       $survey_name="Transfer of vessel";
    }
    elseif ($process_id_status==41) {
       $survey_name="Duplicate certificate";
    }
    elseif ($process_id_status==42) {
       $survey_name="Renewal of registration certificate";
    }
    elseif ($process_id_status==31) {
       $survey_name="Additional payment";
    }
    else { $survey_name="";}
  }
//_____________________Status Display_______________________________________________________//

  if($status_id=='' || $status_id==1)
  {
  	$message='Payment verification';
  }

  if($status_id==2)
  {
 	 $message='Forwarded to '.$usertype_name.'';
  }
  if($status_id==3)
  {
  	$message='Application Rejected';
  }
  if($status_id==4)
  {
  	$message='Revert from '.$usertype_name_from.'';
  }
  if($status_id==5)
  {
  	$message='Approved';
  }
  if($status_id==6)
  {
  	$message='Approved & Forward';
  }
  if($status_id==7)
  {
  	$message='Survey Intimation Send';
  }

  if($process_id_status==1 && $status_id==7)
  {
  	$message='Payment verified';
  }

  if($process_id_status==16 && $status_id==7 && $survey_id==0)
  {
  $message='Registration Intimation';
  }

  if($status_id==2 && $process_id_status==2)
  {
  $message='Started';
  }

  if($status_id==2 && $process_id_status==3)
  {
  $message='Started';
  }
  if(($status_id==2 && $process_id_status==4) || ($status_id==1 && $process_id_status==5) || ($status_id==2 && $process_id_status==6) || ($status_id==1 && $process_id_status==8) || ($status_id==1 && $process_id_status==9)  || ($status_id==1 && $process_id_status==10))
  {
  $message='Started';
  }

  if($process_id_status==21 && $status_id==1)
  {
  $message='Started';
  }

  if($process_id_status==23 && $status_id==1)
  {
  $message='Started';
  }
  if($process_id_status==24 && $status_id==1)
  {
  $message='Started';
  }


  if($status_id==7 && $process_id_status==7)
  {
  $message='PC verified';
  }
  if($status_id==6 && $process_id_status==7)
  {
  $message='Survey intimation';
  }

  if($status_id==1 && $process_id_status==12)
  {
  $message='Started';
  }

  if($status_id==1 && $process_id_status==13)
  {
  $message='Started';
  }

  if($status_id==1 && $process_id_status==14)
  {
  $message='Started';
  }
  if($status_id==1 && $process_id_status==20)
  {
  $message='Started';
  }


  if($status_id==8 && $process_id_status==1)
  {
  $message='Payment pending';
  }

  if($status_id==8 && $process_id_status==5)
  {
  $message='Payment pending';
  }
  if($status_id==7 && $process_id_status==15)
  {
  $message='pc verified';
  }

  if($status_id==7 && $process_id_status==18)
  {
  $message='Defect found';
  } 
  if($status_id==1 && $process_id_status==26)
  {
  $message='Payment verification';
  }
  if($status_id==2 && $process_id_status==16)
  {
  $message='Registration intimation';
  }


  if($status_id==6 && $process_id_status==26)
  {
  $message='Approved & Forward to '.$usertype_name.'';
  //echo "ddgdfg";
  }

  if($status_id==1 && $process_id_status==28)
  {
  $message='Forward to '.$usertype_name.'';
  //echo "ddgdfg";
  }


  if($status_id==1 && $process_id_status==29)
  {
  $message='Started';

  }

  if($status_id==1 && $process_id_status==30)
  {
  $message='Started';

  }if($status_id==1 && $process_id_status==31)
  {
  $message='Started';

  }
//___________________________________________Process Display_______________________________________________---//

  if($process_id_status==0)
  {
  $message1='Initial';
  }

  if($process_id_status==1)
  {
  $message1='Form 1';
  }

  if($process_id_status==1 && $status_id==8)
  {
  $message1='Form 1';
  }
  if($process_id_status==1 && $status_id==7)
  {
  $message1='Form 1';
  }

  if($process_id_status==2)

  {
  $message1='Keel Laying ';
  }

  if($process_id_status==3)
  {
  $message1='Hull Inspection';
  }

  if($process_id_status==4)
  {
  $message1='Final Inspection';
  }

  if($process_id_status==5)
  {
  $message1='Form 3';
  }

  if($status_id==3)
  {
  $message1='-';
  }


  if($process_id_status==1 && $status_id==1)
  {
  $message1='-';  
  }

  if($process_id_status==5 && $status_id==2)
  {
  $message1='Form 3';  
  }

  if($process_id_status==6 && $status_id==2)
  {
  $message1='Form 4';  
  }
  if($process_id_status==6 && $status_id==7)
  {
  $message1='Form 4';  
  }
  if($process_id_status==7 && $status_id==7)
  {
  $message1='Form 4';  
  }

  if($process_id_status==7 && $status_id==1)
  {
  $message1='Form 4';  
  }
  if($process_id_status==7 && $status_id==2)
  {
  $message1='Form 4';  
  }


  if($process_id_status==8)
  {
  $message1='Form 5';  
  }
  if($process_id_status==9)
  {
  $message1='Form 6';  
  }

  if($process_id_status==10 && $status_id==2)
  {
  $message1='Form 7';  
  }
  if($process_id_status==10 && $status_id==5)
  {
  $message1='Form 7';  
  }
  if($process_id_status==10 && $status_id==1)
  {
  $message1='Form 7';  
  }

  if($process_id_status==11 )
  {
  $message1='Form 8';  
  }
  if($process_id_status==12 )
  {
  $message1='Form 9';  
  }
  if($process_id_status==13 )
  {
  $message1='Form 10';  
  }
  if($process_id_status==14 )
  {
  $message1='Registration';  
  }
  if($process_id_status==15 )
  {
  $message1='Form2';  
  }
  if($process_id_status==17 )
  {
  $message1='Form4';  
  }

  if($process_id_status==18 )
  {
  $message1='Form4';  
  }
  if($process_id_status==19)
  {
  $message1='Form5';  
  }
  if($process_id_status==20)
  {
  $message1='Form6';  
  }

  if($process_id_status==21 && $status_id==2)
  {
  $message1='Form 7';  
  }
  if($process_id_status==21 && $status_id==5)
  {
  $message1='Form 7';  
  }
  if($process_id_status==21 && $status_id==1)
  {
  $message1='Form 7';  
  }


  if($process_id_status==22 )
  {
  $message1='Form 8';  
  }

  if($process_id_status==23 )
  {
  $message1='Form 9';  
  }
  if($process_id_status==24 )
  {
  $message1='Form 10';  
  }

  if($process_id_status==24 && $survey_id==0)
  {
  $message1='';  
  }

  if($process_id_status==25)
  {
  $message1='Annual survey';
  }  
  if($process_id_status==26 )
  {
  $message1='Drydock survey';
  }
  if($process_id_status==27 )
  {
  $message1='Drydock survey certificate';
  }


  if($process_id_status==16)
  {
  $message1='Form13';  
  }
  if($process_id_status==28)
  {
  $message1='Special survey ';  
  }

  if($process_id_status==29 && $status_id==1)
  {
  $message1='Annual survey';  
  }


  if($process_id_status==30 && $status_id==1)
  {
  $message1='Drydock survey';  
  }

  if($process_id_status==38)
  {
  $message1='Form 11';  
  }
  if($process_id_status==39)
  {
  $message1='Form --';  
  }
  if($process_id_status==40)
  {
  $message1='Form --';  
  }


  if($process_id_status==41)
  {
  $message1='Duplicate certificate';  
  }
  if($process_id_status==42)
  {
  $message1='Renewal of registration';  
  }
  if($process_id_status==31)
  {
  $message1='Additional payment';  
  }

 ?>

<div class="modal-header bg-tan">
<h5 class="modal-title text-danger" id="exampleModalLongTitle">Reference Number : <?php echo $ref_number; ?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;
</button>
</div> <!-- end of modal header -->

<div class="modal-body bg-tanblur">
	<div class="row no-gutters">
		<div class="col-12 border-white">
              <p class="px-0 text-dark"> Activity Type: <?php echo $survey_name;?> - <?php echo $processing_status; ?> </p>
            </div> <!-- end of col12 -->
             <div class="col-12 border-white">
              <p class="pt-2 text-dark">  <?php if($form_no) { echo  'Form '.$form_no; } else { echo ""; } echo " " .$message .", ". $usertype_name_from." to ".$usertype_name; ?>
              <br><?php  ?>

              <?php
              //echo $usertype_name_from ."->".$message."->".$usertype_name//if($form_no) { echo  'Form '.$form_no; } else { echo ""; }   //echo $message1. "  " .$message; "-"?>  </p>
            </div> <!-- end of col12 -->
		
	</div>

 </div> <!-- INS_001_162019 end of modal body -->

<?php 	
}
else
{
	?>
	<div class="modal-header bg-tan">
<h5 class="modal-title text-danger" id="exampleModalLongTitle"> <?php echo "Invalid Reference number"; ?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;
</button>
</div> <!-- end of modal header -->
<div class="modal-body bg-tanblur">
	<div class="row no-gutters">
		
		
	</div>

 </div> <!-- INS_001_162019 end of modal body -->
<?php
	
}
?>