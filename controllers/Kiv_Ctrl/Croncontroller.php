<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Croncontroller extends CI_Controller {

public function __construct() {
	parent::__construct();
	$this->load->model('Kiv_models/Cron_model');
}

public function index() {
}
////------------------------------------------Owner Change------------------------------------------------------------////
public function croncheck()
{ 
	/*if($this->input->is_cli_request())
 	{*/
        $user_id                            = 7;
		$transferownerchg_pending           = $this->Cron_model->get_transferownerchange_pending($user_id); 
        
        if(!empty($transferownerchg_pending)) {
            foreach($transferownerchg_pending as $result){
                $transfer_sl                = $result['transfer_sl'];
                $mobile                     = $result['transfer_buyer_mobile'];
                $email                      = $result['transfer_buyer_email_id'];

                $user_check                 = $this->Cron_model->get_owner_check($mobile,$email);
                $cnt_rws                    = count($user_check); 
                if($cnt_rws>0){
                    foreach($user_check as $user_res){
                        $user_name          = $user_res['user_name'];
                        $user_sl            = $user_res['user_sl'];
                    }
                    $data_tranown = array(
                        'transfer_buyer_id' =>$user_sl
                    );
                    $ownchg_update_status   = $this->Cron_model->update_transownerchg_status('tbl_transfer_ownershipchange',$data_tranown, $transfer_sl);
                    /*if($ownchg_update_status){
                        $message='<strong>The Buyer '.$user_name.' has registered in the port website!!!</strong>';
                    }*/
                }

            }
        }
	/*}
  	else
  	{
  		echo "greet my only be accessed from the command line now";
     	return;
  	}*/

}
///-------------------------------Transfer Vessel---------------------------------------------------------------------///
public function crontranscheck()
{ //echo "hii"; exit;
    /*if($this->input->is_cli_request())
    {*/
        $user_id                            = 7;
        $transfervessel_pending             =  $this->Cron_model->get_transfervessel_pending($user_id); 
        //print_r($transfervessel_pending);exit;
        if(!empty($transfervessel_pending)) {
            foreach($transfervessel_pending as $result1){
                $transfer_sl1               = $result1['transfer_sl'];
                $mobile1                    = $result1['transfer_buyer_mobile'];
                $email1                     = $result1['transfer_buyer_email_id'];

                $user_check1                = $this->Cron_model->get_owner_check($mobile1,$email1);
                $cnt_rws1                   = count($user_check1);
                if($cnt_rws1>0){
                    foreach($user_check1 as $user_res1){
                        $user_name1         = $user_res1['user_name'];
                        $user_sl1           = $user_res1['user_sl'];
                    }
                    $data_tranown1 = array(
                        'transfer_buyer_id' =>$user_sl1
                    );//print_r($data_tranown1);exit;
                    $ownchg_update_status1  = $this->Cron_model->update_transownerchg_status('tbl_transfer_ownershipchange',$data_tranown1, $transfer_sl1);
                    /*if($ownchg_update_status){
                        $message='<strong>The Buyer '.$user_name.' has registered in the port website!!!</strong>';
                    }*/
                }

            }
        }
    /*}
    else
    {
        echo "greet my only be accessed from the command line now";
        return;
    }*/

}

	 /* public function message($to = 'World')
        {
        	if(!$this->input->is_cli_request())
     		{
       			    echo "greet my only be accessed from the command line";
         			return;
    		 }
             echo "Hello {$to}!".PHP_EOL;
        }

     public  function emailsend(){
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->CharSet = "utf-8";
        $mail->Encoding = 'base64';
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // authentication enabled
        $mail->IsHTML(true); 
        $mail->SMTPSecure = 'ssl';//turn on to send html email
        $mail->Host = "ssl://smtp.gmail.com";//use gmail 
        $mail->Port = 465;
        $mail->Username = "vacbsuite2@gmail.com";
        $mail->Password = "vig#701#pmg";
        $mail->SetFrom("vacbsuite2@gmail.com", "VACB Suite");


        $mail->isHTML(true);
        $mail->Subject = "Mail Subject";
        $template = "Some content";
        $mail->Body = $template;

        $to = "ajayvijayan123@gmail.com";
        $to1 = "test-qozxx@mail-tester.com";

        $mail->AddAddress($to);
        if(!$mail->send()){
        	echo "Send email";
        }else{ 
        	echo $mail->ErrorInfo;
        }
    }  */ 
} 	