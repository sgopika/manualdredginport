<?php
function add_payment_details()
{
$sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   =	$this->session->userdata('customer_id');
  $survey_user_id	   =	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form8', 'page' => 'form8', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;

    $this->load->model('Kiv_models/Survey_model');

    $vessel_sl    = $this->session->userdata('vessel_id');
   if($vessel_sl=="")
   {
     $vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));
   }
   else
   {
    $vessel_id     =$vessel_sl;
   }
    //$vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));
    $form_stage_sl		    = 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
  //$stage_sl               = 	$form_stage_sl[0]['stage_sl'];
  if(!empty($form_stage_sl))
   {
        $stage_sl               = 	$form_stage_sl[0]['stage_sl'];
   }
     
	$survey_id=1;


/*
$paymenttype_id       =4;
$dd_amount1           =$this->security->xss_clean($this->input->post('dd_amount'));
$portofregistry_sl 	  =$this->security->xss_clean($this->input->post('portofregistry_sl'));
  if($dd_amount1==false)
  {
    $dd_amount=0;
  }
  else
  {
    $dd_amount=$dd_amount1;
  }

  date_default_timezone_set("Asia/Kolkata");
  $ip	      	=	$_SERVER['REMOTE_ADDR'];
  $date 	   	= 	date('Y-m-d h:i:s', time());
  $newDate    = 	date("Y-m-d");

  $data_portofregistry = 	array(
  'vessel_registry_port_id' => $portofregistry_sl
  );
  $update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);



  $port_registry_user_id           =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
  $data['port_registry_user_id']  =   $port_registry_user_id;
  if(!empty($port_registry_user_id))
  {
    $pc_user_id=$port_registry_user_id[0]['user_sl'];
    $pc_usertype_id=$port_registry_user_id[0]['user_type_id'];
  }

  $data_payment=array(
  'vessel_id'=>$vessel_id,
  'survey_id'=>$survey_id,
  'form_number'=>1,
  'paymenttype_id'=>$paymenttype_id,
  'dd_amount'=>$dd_amount,
  'dd_date'=>$newDate,
  'portofregistry_id'=>$portofregistry_sl,
  'payment_created_user_id'=>$sess_usr_id,
  'payment_created_timestamp'=>$date,
  'payment_created_ipaddress'=>$ip
  );

  $data_stage = 	array(
  'stage' => 8,
  'stage_count'=>8
  );

  $data_process=array(
  'vessel_id' => $vessel_id, 
  'process_id'=>1,
  'survey_id'=>1,
  'current_status_id'=>1,
  'current_position'=>$pc_usertype_id,
  'user_id'=>$pc_user_id,
  'status'=>1,
  'status_change_date'=>$date
  );

  $data_status = array('vessel_id' => $vessel_id,
  'process_id' => 1,
  'survey_id' => 1,
  'current_status_id' => 1,
  'sending_user_id' => $sess_usr_id,
  'receiving_user_id' => $pc_user_id,
  );

  $data_vessel_main= array('vesselmain_portofregistry_id' => $portofregistry_sl);
  if($dd_amount>0 && $portofregistry_sl!=false)
  {

  $result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
  $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
  $update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
  $insert_process   		=	$this->Survey_model->insert_process_flow($data_process);
  $insert_data_status   	=	$this->Survey_model->insert_status_details('tbl_kiv_status_details',$data_status);
  if($result_insert && $updstatus_res && $insert_process && $insert_data_status && $update_portofregistry)  
  {
    echo "1";
  } 
  else
  {
    echo "0";
  }      

  }
    else
    {
    	$this->SurveyHome();
    }
    */


//____________________________________________________START ONLINE TRANSACTION__________________________________//

/*_____________________Start Get vessel condition_______________ */   

   $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition'] = $vessel_condition;
   
    if(!empty($vessel_condition))
    {
      $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1=$vessel_condition[0]['vessel_length'];
      $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    }  
/*_____________________End Get vessel condition___________________*/



/*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
$form_id=1;
$activity_id=1;

$tariff_details  =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
$data1['tariff_details'] =   $tariff_details;

$tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
$data1['tonnage_details']  =   $tonnage_details;

if(!empty($tonnage_details))
   {
       @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
   }

if(!empty($tariff_details))
{
  foreach ($tariff_details as $key ) 
  {
  $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];

    if($tariff_tonnagetype_id==1)
    {
      $tariff_amount=$key['tariff_amount'];
    }
    elseif($tariff_tonnagetype_id==2)
    {
      $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;

        if(!empty($tariff_details_typeid2))
        {
          @$tariff_amount                   = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);

        }
    }
    elseif($tariff_tonnagetype_id==3)
    {
      $tariff_details_typeid3           =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
      if(!empty($tariff_details_typeid2))
        {
          @$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];

        }
    }
    else
    {
      @$tariff_amount= 0;
    }
  }
}
/*_______________________________________________END Tariff____________________________ */   






/*___________________________________________________________________________ */   

//$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
$portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
$bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
$status=1;

$payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
$data['payment_user']     =   $payment_user;
//print_r($payment_user);exit;
if(!empty($payment_user))
{
  $owner_name=$payment_user[0]['user_name'];
  $user_mobile_number=$payment_user[0]['user_mobile_number'];
  $user_email=$payment_user[0]['user_email'];
}
$formnumber=1;
$survey_id=1;

   date_default_timezone_set("Asia/Kolkata");
    $ip         = $_SERVER['REMOTE_ADDR'];
    $date       =   date('Y-m-d h:i:s', time());
    $newDate    =   date("Y-m-d");
    $status_change_date=$date;


$milliseconds = round(microtime(true) * 1000); //Generate unique bank number

$bank_gen_number         =   $this->Survey_model->get_bank_generated_last_number($bank_sl);
$data['bank_gen_number']   = $bank_gen_number;

if(!empty($bank_gen_number))
{
  $bank_generated_number =  $bank_gen_number[0]['last_generated_no']+1;

  $transaction_id        =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
  $tocken_number         =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds;

  $bank_data             =  array('last_generated_no'=>$bank_generated_number);

$data_payment_request = array('transaction_id' => $transaction_id,
'bank_ref_no'   =>0 ,
'token_no'      => $tocken_number,
'vessel_id'     =>$vessel_id,
'survey_id'     => $survey_id,
'form_number'   => $formnumber,
'customer_registration_id' => $sess_usr_id,
'customer_name'         => $owner_name,
'mobile_no'             => $user_mobile_number,
'email_id'              => $user_email,
'transaction_amount'    => $tariff_amount,
'remitted_amount'       => 0,
'bank_id'               => $bank_sl,
'transaction_status'    => 0,
'payment_status'        => 0,
'transaction_timestamp' => $date,
'transaction_ipaddress' => $ip,
'port_id'               => $portofregistry_sl);


$result_insert=$this->db->insert('kiv_bank_transaction_request', $data_payment_request); 
if($result_insert)
{
  //echo "hii"; exit;
  $bank_transaction_id     =    $this->db->insert_id();
  $update_bank             =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);


  $online_payment_data         =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
  $data['online_payment_data']= $online_payment_data;

  $payment_user1              =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
  $data['payment_user1']     =  $payment_user1;

  $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
  $data['requested_transaction_details']  =   $requested_transaction_details;
  $data['amount_tobe_pay']=$tariff_amount;

       $data      =  $data+ $this->data;
       //print_r($data);
       //exit;

          if(!empty($online_payment_data))
          { //print_r($online_payment_data);exit;
            $this->load->view('Hdfc/hdfc_onlinepayment_request',$data);
            //echo "1";
          }
          else
          {
            
            /*echo '<script language="javascript">';
            echo 'alert(Please try after some time)';  
            echo '</script>';*/
            redirect('Kiv_Ctrl/Survey/SurveyHome');
        
          }
      
    }
    else
    {
      /* echo '<script language="javascript">';
          echo 'alert(Please try after some time!)'; 
          echo '</script>';*/
          redirect('Kiv_Ctrl/Survey/SurveyHome');
    }

    }
    else
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }
//____________________________________________________END ONLINE TRANSACTION__________________________________//

	}
}


//---------------------------------------------------------------------------------------------------//

 $vessel_sl   = $this->session->userdata('vessel_id');
   if($vessel_sl=="")
   {
     $vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));
   }
   else
   {
    $vessel_id     =$vessel_sl;
   }
  
  
 /* $vessel_type_id           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vessel_subtype_id        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));*/

  $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition'] = $vessel_condition;
   //print_r($vessel_condition);
    if(!empty($vessel_condition))
    {
      $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1=$vessel_condition[0]['vessel_length'];
      $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    }

$form_id=1;
$activity_id=1;

$tariff_details           =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
$data1['tariff_details']  =   $tariff_details;
//print_r($tariff_details);


$tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
$data1['tonnage_details']  =   $tonnage_details;

if(!empty($tonnage_details))
   {
       @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
   }





if(!empty($tariff_details))
{
  foreach ($tariff_details as $key ) 
  {
  $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];

    if($tariff_tonnagetype_id==1)
    {
      $tariff_amount=$key['tariff_amount'];
    }
    elseif($tariff_tonnagetype_id==2)
    {
      $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;

        if(!empty($tariff_details_typeid2))
        {
          @$tariff_amount                   = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);

        }

      
    }
    elseif($tariff_tonnagetype_id==3)
    {
      $tariff_details_typeid3           =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
      if(!empty($tariff_details_typeid2))
        {
          @$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];

        }

      //@$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];
    }
    else
    {
      @$tariff_amount= 0;
    }
  }
}
if($tariff_amount!=0)
{
  $data1['tariff_amount']=$tariff_amount;
}
else
{
  $data1['tariff_amount']=0;
}
 
















?>