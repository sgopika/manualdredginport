<?php

defined('BASEPATH') OR exit('No direct script access allowed');    

class Master extends CI_Controller {

	 

	public function __construct()

    {

			parent::__construct();

			$this->load->library('session');

			$this->load->library('phpass',array(8, FALSE));

			$this->load->helper('form');

			$this->load->helper('url');
		

			$this->load->database();

			$this->load->library('form_validation');

			$this->load->helper('date');

			$this->load->library('encrypt');
			$this->load->helper('encdec');
			$this->load->library('upload');

			date_default_timezone_set("Asia/Kolkata");

			$this->data 		= 	array(

				'controller' 		=> 	$this->router->fetch_class(),

				'method' 			=> 	$this->router->fetch_method(),

				'session_userdata' 	=> 	isset($this->session->userdata) ? $this->session->userdata : '',

				'base_url' 			=> 	base_url(),

				'site_url'  		=> 	site_url(),

				'int_userid' 		=> 	isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,

				'int_district_id' 	=> 	isset($this->session->userdata['int_district_id']) ? $this->session->userdata['int_district_id'] : 0

			);

	        $this->load->model('Manual_dredging/Master_model');
			$this->load->model('Kiv_models/Survey_model');
    }

//--------------------------------------------------Upload file view retrict function -----done on 19/03/2018-------------------------------

	public function down_my_file($fname)

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& ($sess_user_type==3 ||$sess_user_type==9))

		{	

   		$song_name = $fname;

     $song_file = "{$_SERVER['DOCUMENT_ROOT']}/upload/{$fname}"; 

    if( file_exists( $song_file ) )

    {

     /* header( 'Cache-Control: public' );

     // header( 'Content-Description: File Transfer' );

      header( "Content-Disposition: attachment; filename={$song_file}" );

      header( 'Content-Type:application/force-download' );

    //  header( 'Content-Transfer-Encoding: binary' );

	

	*/

	$get_ftype=explode('.',$fname);

	$fty=strtolower($get_ftype[1]);

	if($fty=='pdf')

	{

	    header('Content-Description: File Transfer');

		//header('Content-Type: application/octet-stream');

		header("Content-type: application/pdf"); 

		header('Content-Disposition:  inline; filename='.basename($song_file));

		header('Content-Transfer-Encoding: binary');

		header('Expires: 0');

		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

		header('Pragma: public');

		header('Content-Length: ' . filesize($song_file));

		ob_clean();

		flush();

		//echo $song_file;

		//fopen($song_file, "r");

		//echo "<iframe src='".readfile($song_file)."' />";

			  readfile( $song_file );

	}

	else

	{

		

		header('Content-Description: File Transfer');

		//header('Content-Type: application/octet-stream');

		header("Content-type: image/jpg"); 

		header('Content-Disposition:  inline; filename='.basename($song_file));

		header('Content-Transfer-Encoding: binary');

		header('Expires: 0');

		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

		header('Pragma: public');

		header('Content-Length: ' . filesize($song_file));

		ob_clean();

		flush();

		readfile( $song_file );

	}

     // exit;

    }

  }

	else

	{

die( "ERROR: Sorry you don't have permissions to download it." );

	}

}
//-------------------------------------------------------------------------------------
	public function pcdredginghome()
{
		/*----------------------------------------------------------------------------------------------------
		$this->load->view('Kiv_views/template/dash-header.php');
        $this->load->view('Kiv_views/template/nav-header.php');
        $this->load->view('Manual_dredging/Master/pc.php',$data);
        $this->load->view('Kiv_views/template/dash-footer.php');
		-----------------------------------------------------------------------------------------------------*/
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$this->load->model('Manual_dredging/Master_model');	
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$port_id			=	$userinfo[0]['user_master_port_id'];

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{ 
			$this->load->model('Manual_dredging/Master_model');	
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id); //print_r($u_h_dat);exit;
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data; 
			$tn1=$this->Master_model->totcus_reg($port_id);  
			$data['tn1']			=	$tn1[0]['totcreq']; 
			$tn2=$this->Master_model->tot_buk_pen($port_id);
			$data['tn2']			=	$tn2[0]['totbpen'];
			$totpermit_pend		=	$this->Master_model->tot_permit_pend($port_id);
			$data['tot_per_pend']		=	$totpermit_pend[0]['permit_pend'];
			$data 				= 	$data + $this->data; 
			$curr_date=date("Y-m-d");
			$holy_prd=date('F Y',strtotime($curr_date));
			$data['holy_prd']		=	$holy_prd;
			$tot_workdays=$this->Master_model->tot_working_days($holy_prd);

			

			$data['tot_workdays']		=	$tot_workdays[0]['working_days'];
			$tot_holydays=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			
			$tot_holydays=$tot_holydays-$tot_workdays[0]['working_days'];
			$data['tot_holydays']		=$tot_holydays;
			$data 				= 	$data + $this->data; 

			/*$tn=$this->Master_model->tot_msg_unread($sess_usr_id);
			$data['tn']			=	$tn[0]['totnew'];  

			

			 

			$tn3=$this->Master_model->police_ge($port_id);
			$data['tn3']			=	$tn3[0]['totcase'];

			$totobuk=$this->Master_model->san_req_pc($port_id);
			$data['tn4']			=	$totobuk[0]['totsreq'];//san_reqacustom_pc

			$totobuka=$this->Master_model->san_reqacustom_pch($port_id);
			$data['tn5']			=	$totobuka[0]['totsreqa'];

			$totobuks=$this->Master_model->san_reqacustom_pcs($port_id);
			$data['tn6']			=	$totobuks[0]['totsreqa'];

			$totobuta=$this->Master_model->san_reqacustom_totand($port_id);
			$data['tn7']			=	$totobuta[0]['totsreqa'];

			$totobutn=$this->Master_model->san_reqacustom_totspen($port_id);
			$data['tn8']			=	$totobutn[0]['totsreqa'];

			$port				= 	$this->Master_model->get_zone_acinP($port_id);
			$data['port_det']	=	$port;
			$data 				= 	$data + $this->data; 

			$permit_name		= 	$this->Master_model->get_monthly_period();
			$data['permit']		=	$permit_name;
			$data 				= 	$data + $this->data; 

			$fin_year			= 	$this->Master_model->get_fin_year();
			$data['fin_year']	=	$fin_year;
			$data 				= 	$data + $this->data; 

			$totpermit_aprvd	=	$this->Master_model->tot_permit_aprvd($port_id);
			$data['tot_per_aprvd']		=	$totpermit_aprvd[0]['permit_aprvd'];
			$data 				= 	$data + $this->data; 

			

			$totpermit_pend		=	$this->Master_model->tot_permit_pend($port_id);
			$data['tot_per_pend']		=	$totpermit_pend[0]['permit_pend'];
			$data 				= 	$data + $this->data; 

			

			

			$k=0; 

			foreach($permit_name as $pn)
			{
				$pnd=$pn["monthly_permit_period_name"];
				$tpa=$this->Master_model->permit_reqApfor_pc($pnd,$port_id);
				$d[$k]=$tpa[0]["totsreq"];

				$tsp  = 	$this->Master_model->tot_sand_passfor_pc($pnd,$port_id);
				$c[$k]=$tsp[0]["totspass"];
				$k++;
			}

			$data['totpermitbar']	=	$d;
			$data 				= 	$data + $this->data;

			$data['totsandpassbar']	=	$c;
			$data 				= 	$data + $this->data;
  

			$totperreq			= 	$this->Master_model->permit_req_pc($port_id);
			$data['totperreq']	=	$totperreq[0]['totreq'];
			$data 				= 	$data + $this->data;

			$totperreqAp			= 	$this->Master_model->permit_reqAp_pc($port_id);
			$data['totperreqAp']	=	$totperreqAp[0]['totreqa'];
			$data 				= 	$data + $this->data;

			$totsreq			= 	$this->Master_model->san_req_pc($port_id);
			$data['totsreq']	=	$totsreq[0]['totsreq'];
			$data 				= 	$data + $this->data;

			$totsreqa			= 	$this->Master_model->san_reqa_pc($port_id);
			$data['totsreqa']	=	$totsreqa[0]['totsreqa'];
			$data 				= 	$data + $this->data;

			$totsreqr			= 	$this->Master_model->san_reqr_pc($port_id);
			$data['totsreqr']	=	$totsreqr[0]['totsreqr'];
			$data 				= 	$data + $this->data;

			$totspass			= 	$this->Master_model->tot_sand_pass_pc($port_id);
			$data['totspass']	=	$totspass[0]['totspass'];
			$data 				= 	$data + $this->data;

			$balsand			= 	$this->Master_model->bal_sand_pc($port_id);
			$data['balsand']	=	$balsand[0]['balsand'];
			$data 				= 	$data + $this->data;

			

			//pie Start

			//

			$id=1;

			$total1			= 	$this->Master_model->sum_amt_pc($id,$port_id);
			$data['total1']	=	$total1[0]['totsum'];
			$data 				= 	$data + $this->data;

			$id=2;
			$total2			= 	$this->Master_model->sum_amt_pc($id,$port_id);
			$data['total2']	=	$total2[0]['totsum'];
			$data 				= 	$data + $this->data;

			$id=3;
			$total3			= 	$this->Master_model->sum_amt_pc($id,$port_id);
			$data['total3']	=	$total3[0]['totsum'];
			$data 				= 	$data + $this->data;

			$id=4;
			$total4			= 	$this->Master_model->sum_amt_pc($id,$port_id);
			$data['total4']	=	$total4[0]['totsum'];
			$data 				= 	$data + $this->data;

			$id=5;
			$total5			= 	$this->Master_model->sum_amt_pc($id,$port_id);
			$data['total5']	=	$total5[0]['totsum'];
			$data 				= 	$data + $this->data;

			$id=6;
			$total6			= 	$this->Master_model->sum_amt_pc($id,$port_id);
			$data['total6']	=	$total6[0]['totsum'];
			$data 				= 	$data + $this->data;*/
			
			$data['portid']	=	$port_id;
			$data 				= 	$data + $this->data;
			$this->load->view('Manual_dredging/Master/pc.php',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

		else

	   	{

			redirect('Main_login/index');        

  		}  

		
		
		
		
        }
    
//==============================================================================================================

	public function getcustomerdetails_ajax_new()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

	$this->load->model('Manual_dredging/Master_model');	

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$port_id			=	$userinfo[0]['user_master_port_id'];  

	$custaadhar=$this->security->xss_clean(html_escape($this->input->post('custaadhar')));

	$get_customerapproval=$this->Master_model->customerapprovalnew($custaadhar,$port_id);

	

	$data['get_customerapproval']=$get_customerapproval;

	$data = $data + $this->data;

	$this->load->view('Manual_dredging/Master/customerreg_ajax_new', $data);

	}

	////   Function For Login Start  /////

public function test_mrate()

{

 $tax=$this->Master_model->get_materials_with_tax();

 $mat_id=$tax['tax_calculator_materials'];

 $ma=explode(',',$mat_id);

 // print_r($ma);

 $t_rate=$tax['tax_calculator_rate'];

 $amt_wt=0;

 $amt_wt1=0;

 $amt_wt2=0;

 $amt_wt3=0;

 $amt_wt4=0;

 $amt_wt5=0;

 $material=$this->Master_model->get_material_master_act();

 foreach($material as $mat)

 {

	 $mid=$mat['material_master_id'];

	

		 if($mat['material_master_authority']==1)

		 {

			 if(in_array($mid,$ma))

			 {

				 //echo $mid;

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 $amt_wt=$amt_wt+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

			 }

			 else

			 {

				 $amt_wt1= $amt_wt1+$m_r[0]['materialrate_port_amount'];

			 }

			 //echo $amt_wt."/".$amt_wt1;

		 //exit;

		 }

		 else

		 {

			  if(in_array($mid,$ma))

			 {

				 //echo $mid;

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 //print_r($m_r);

				 if($m_r[0]['materialrate_domain']==2)

				 {

					 

				 	$amt_wt2=$amt_wt2+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

				 }

				 else

				 {

					 //echo "ff".$port_id."ff".$mid."ff".$zone_id;

					 $m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

					// print_r($m_rn);

					 $amt_wt3=$amt_wt3+($m_rn[0]['materialrate_port_amount']+$m_rn[0]['materialrate_port_amount']*($t_rate/100));

				 }

			 }

			 else

			 {

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 if($m_r[0]['materialrate_domain']==2)

				 {

					// echo "ff";

				 	$amt_wt4=$amt_wt4+$m_r[0]['materialrate_port_amount'];

				 }

				 else

				 {

					 ///echo "ff";

					 $m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

					// print_r($m_rn);

					 $amt_wt5=$amt_wt5+$m_rn[0]['materialrate_port_amount'];

				 }

			 }

		 }

 }

// echo $amt_wt."_".$amt_wt1."_".$amt_wt2."_".$amt_wt3."_".$amt_wt4."_".$amt_wt5;

 //echo "<br>";

 

// echo "/".$amt_wt."/".$amt_wt1."/".$amt_wt2."/".$amt_wt3."/".$amt_wt4."/".$amt_wt5;

 

 echo $sand_rate=$amt_wt+$amt_wt1+$amt_wt2+$amt_wt3+$amt_wt4+$amt_wt5;

	}

	public function emailSendFun($from,$to,$sub,$msg)

	{

  		$config = Array(

			'protocol' => 'smtp',

			'smtp_host' => 'ssl://smtp.googlemail.com',

			'smtp_port' => 465,

			'smtp_user' => 'manualdredging@gmail.com',

			'smtp_pass' => 'Portinfokerala@123',

			'mailtype'  => 'html', 

			'charset'   => 'iso-8859-1'

		);

		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");

		

		$this->email->from($from);

        $this->email->to($to); 

        $this->email->subject($sub);

        $this->email->message($msg); 

		

		// Set to, from, message, etc.

		$result = $this->email->send();

		$res=$this->email->print_debugger();

        //$this->load->view('email_view'); 

		//print_r($result);exit;

		return $result;

	}



	public function index()

	{

		$this->load->model('Manual_dredging/Master_model');

		//$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				//$data['user_header']=	$u_h_dat;

				//$data 				= 	$data + $this->data;

		//$this->load->view('template/header');

		$this->load->view('Manual_dredging/Master/login');

		//$this->load->view('template/footer');

		//$this->load->view('template/js-footer');

		//$this->load->view('template/script-footer');

		//$this->load->view('template/html-footer');

		if($this->input->post())

		{	

			$uname=html_escape($this->input->post('vch_un'));

			//$uname=$this->security->xss_clean('$uname');

			//$paswd=html_escape($this->input->post('vch_pw'));

			//$paswd=$this->security->xss_clean('$paswd');

			$paswd=html_escape($this->input->post('vch_pw'));

			$res=$this->Master_model->login($uname);

			foreach($res as $re)

			{

			$hashed=$re['user_master_password'];

			}

			if($this->phpass->check($paswd,$hashed))

			{

				$userdet=$this->Master_model->getuserdetails($uname);

				$user_id=$userdet[0]['user_master_id'];

				$res=$this->Master_model->getuserlog($user_id);

				//echo $userdet;break;

				if($res==0)

				{

					$this->session->set_userdata('u_id',$user_id);

					$this->session->set_userdata('int_userid_pw',$uname);

					redirect("Manual_dredging/Master/ch_pw");

				}

				else

				{

					foreach($userdet as $userde)

					{

						//date_default_timezone_set("Asia/Kolkata");

						$this->session->set_userdata('int_userid',$userde['user_master_id']);

						$this->session->set_userdata('int_usertype',$userde['user_master_id_user_type']);

						//$u_ip=$_SERVER['REMOTE_ADDR'];
						if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $u_ip = $_SERVER["REMOTE_ADDR"];
}

						$timestamp = time();

						$date_time = date("Y-m-d  H:i:s", $timestamp);

						$login_time = $date_time;

						$maxlifetime=ini_get("session.gc_maxlifetime");

						$add_time=$timestamp+$maxlifetime;

						$logout_time= date("Y-m-d H:i:s",$add_time);

						$this->session->set_userdata('login_time',$login_time);

						$data=array(

						'user_id'=>$userde['user_master_id'],

						'login'=> $login_time,

						'logout'=>$logout_time,

						'log_ip'=>$this->input->ip_address()

						);

						$this->Master_model->save_userlog($data);

					}

					redirect("Manual_dredging/Master/pc");

				}

			}

			else

			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center" style="width:100%">Invalid username/password</div>');

				redirect('Main_login/index'); 

			}

		}

	}

	public function chart()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;

			$port				= 	$this->Master_model->get_port();

			$data['port_det']	=	$port;

			$data 				= 	$data + $this->data; 

			$permit_name		= 	$this->Master_model->get_monthly_period();

			$data['permit']		=	$permit_name;

			$data 				= 	$data + $this->data; 

			$fin_year		= 	$this->Master_model->get_fin_year();

			$data['fin_year']		=	$fin_year;

			$data 				= 	$data + $this->data; 

			$k=0; 

			foreach($permit_name as $pn)

			{

				$pnd=$pn["monthly_permit_period_name"];

				$tpa=$this->Master_model->permit_reqApfor($pnd);

				$d[$k]=$tpa[0]["totsreq"];

				$tsp  = 	$this->Master_model->tot_sand_passfor($pnd);

				$c[$k]=$tsp[0]["totspass"];

				$k++;

			}

			$data['totpermitbar']	=	$d;

			//exit();

			$data 				= 	$data + $this->data;

			$data['totsandpassbar']	=	$c;

			//exit();

			$data 				= 	$data + $this->data;

			//

			//Doaunut

			//   

			$totperreq			= 	$this->Master_model->permit_req();

			//print_r($totperreq);

			$data['totperreq']	=	$totperreq[0]['totreq'];

			//exit();

			$data 				= 	$data + $this->data;

			$totperreqAp			= 	$this->Master_model->permit_reqAp();

			$data['totperreqAp']	=	$totperreqAp[0]['totreqa'];

			$data 				= 	$data + $this->data;

			$totsreq			= 	$this->Master_model->san_req();

			$data['totsreq']	=	$totsreq[0]['totsreq'];

			$data 				= 	$data + $this->data;

			$totsreqa			= 	$this->Master_model->san_reqa();

			$data['totsreqa']	=	$totsreqa[0]['totsreqa'];

			$data 				= 	$data + $this->data;

			$totsreqr			= 	$this->Master_model->san_reqr();

			$data['totsreqr']	=	$totsreqr[0]['totsreqr'];

			$data 				= 	$data + $this->data;

			$totspass			= 	$this->Master_model->tot_sand_pass();

			$data['totspass']	=	$totspass[0]['totspass'];

			$data 				= 	$data + $this->data;

			$balsand			= 	$this->Master_model->bal_sand();

			$data['balsand']	=	$balsand[0]['balsand'];

			$data 				= 	$data + $this->data;

			//

			//Do END 

			//

			//

			//pie Start

			//

			$id=1;

			$total1			= 	$this->Master_model->sum_amt($id);

			$data['total1']	=	$total1[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=2;

			$total2			= 	$this->Master_model->sum_amt($id);

			$data['total2']	=	$total2[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=3;

			$total3			= 	$this->Master_model->sum_amt($id);

			$data['total3']	=	$total3[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=4;

			$total4			= 	$this->Master_model->sum_amt($id);

			$data['total4']	=	$total4[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=5;

			$total5			= 	$this->Master_model->sum_amt($id);

			$data['total5']	=	$total5[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=6;

			$total6			= 	$this->Master_model->sum_amt($id);

			$data['total6']	=	$total6[0]['totsum'];

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');						
$this->load->view('Kiv_views/template/nav-header');
$this->load->view('Manual_dredging/Master/chart', $data);
$this->load->view('Kiv_views/template/dash-footer');

			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function Piechart()

{

			$port_id			=	$this->security->xss_clean(html_escape($this->input->post('port_id')));

			$p_name				=	$this->security->xss_clean(html_escape($this->input->post('period')));

			$z_id				=	$this->security->xss_clean(html_escape($this->input->post('zone_id')));

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$id=1;

			$total1			= 	$this->Master_model->sum_amt_new($id,$port_id,$p_name,$z_id);

			$data['total1']	=	$total1[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=2;

			$total2			= 	$this->Master_model->sum_amt_new($id,$port_id,$p_name,$z_id);

			$data['total2']	=	$total2[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=3;

			$total3			= 	$this->Master_model->sum_amt_new($id,$port_id,$p_name,$z_id);

			$data['total3']	=	$total3[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=4;

			$total4			= 	$this->Master_model->sum_amt_new($id,$port_id,$p_name,$z_id);

			$data['total4']	=	$total4[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=5;

			$total5			= 	$this->Master_model->sum_amt_new($id,$port_id,$p_name,$z_id);

			$data['total5']	=	$total5[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=6;

			$total6			= 	$this->Master_model->sum_amt_new($id,$port_id,$p_name,$z_id);

			$data['total6']	=	$total6[0]['totsum'];

			$data 				= 	$data + $this->data;

			$this->load->view('Manual_dredging/Master/piechart',$data);

}

public function dowchart()

{

			$port_id			=	$this->security->xss_clean(html_escape($this->input->post('port_id')));

			$p_name				=	$this->security->xss_clean(html_escape($this->input->post('period')));

			$z_id				=	$this->security->xss_clean(html_escape($this->input->post('zone_id')));

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$totperreq			= 	$this->Master_model->permit_reqcustom($port_id,$p_name,$z_id);

			//print_r($totperreq);

			$data['totperreq']	=	$totperreq[0]['totreq'];

			//exit();

			$data 				= 	$data + $this->data;

			$totperreqAp			= 	$this->Master_model->permit_reqApcustom($port_id,$p_name,$z_id);

			$data['totperreqAp']	=	$totperreqAp[0]['totreqa'];

			$data 				= 	$data + $this->data;

			$totsreq			= 	$this->Master_model->san_reqcustom($port_id,$p_name,$z_id);

			$data['totsreq']	=	$totsreq[0]['totsreq'];

			$data 				= 	$data + $this->data;

			$totsreqa			= 	$this->Master_model->san_reqacustom($port_id,$p_name,$z_id);

			$data['totsreqa']	=	$totsreqa[0]['totsreqa'];

			$data 				= 	$data + $this->data;

			$totsreqr			= 	$this->Master_model->san_reqrcustom($port_id,$p_name,$z_id);

			$data['totsreqr']	=	$totsreqr[0]['totsreqr'];

			$data 				= 	$data + $this->data;

			$totspass			= 	$this->Master_model->tot_sand_passcustom($port_id,$p_name,$z_id);

			$data['totspass']	=	$totspass[0]['totspass'];

			$data 				= 	$data + $this->data;

			$balsand			= 	$this->Master_model->bal_sandcustom($port_id,$p_name,$z_id);

			$data['balsand']	=	$balsand[0]['balsand'];

			$data 				= 	$data + $this->data;

			$this->load->view('Manual_dredging/Master/dowchart',$data);

}

public function barchart()

{

			$port_id			=	$this->security->xss_clean(html_escape($this->input->post('port_id')));

			$p_name				=	$this->security->xss_clean(html_escape($this->input->post('period')));

			$z_id				=	$this->security->xss_clean(html_escape($this->input->post('zone_id')));

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$fin_year		= 	$this->Master_model->get_fin_yearbyid($p_name);

			//$data['fin_year']		=	$fin_year;

			//$data 				= 	$data + $this->data; 

			$permit_name		= 	$this->Master_model->get_monthly_period();

			$s_y				=	$fin_year[0]['dtStartingDate'];

			$e_y				=	$fin_year[0]['dtEndingDate'];

			$j=0;

			$ac=array();

			$d=array();

			$c=array();

			foreach($permit_name as $pn)

			{

				$pnd=$pn["monthly_permit_period_name"];

				$cd=date('Y-m-d', strtotime($pnd));

				//$cd=date('Y-m-d',date(strtotime("+1 day", strtotime($cnd))));

				if(($cd >= $s_y)&&($cd <= $e_y))

				{

					//echo $pnd;

					$ac[$j]=$pnd;

				}

				$j++;

			}

			$data['permit']		=	$ac;

			$data 				= 	$data + $this->data;

			$k=0; 

			foreach($ac as $pn)

			{

				$pnd=$pn;

				$tpa=$this->Master_model->permit_reqApforcustom($port_id,$pnd,$z_id);

				$d[$k]=$tpa[0]["totsreq"];

				$tsp  = 	$this->Master_model->tot_sand_passforcustom($port_id,$pnd,$z_id);

				$c[$k]=$tsp[0]["totspass"];

				$k++;

			}

			$data['totpermitbar']	=	$d;

			//exit();

			$data 				= 	$data + $this->data;

			$data['totsandpassbar']	=	$c;

			//exit();

			$data 				= 	$data + $this->data;

			

			$this->load->view('Manual_dredging/Master/barchart',$data);

}

	public function ch_pw()

	{

		$sess_usr_id 			= $this->session->userdata('int_userid_pw');

	    $u_id			=	$this->session->userdata('u_id');

		//echo $u_id;break;

		//$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		//$i=0;

		//$port_id			=	$userinfo[$i]['user_master_port_id'];

		if(!empty($sess_usr_id))

		{

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($u_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/ch_pw', $data);
			$this->load->view('Kiv_views/template/dash-footer');

			

			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$paswd=$this->security->xss_clean(html_escape($this->input->post('c_p')));

				$npaswd=$this->security->xss_clean(html_escape($this->input->post('n_p')));

				$res=$this->Master_model->login($sess_usr_id);

				//print_r($res);

				//exit();

				foreach($res as $re)

				{

				$hashed=$re['user_master_password'];

				}

				if($this->phpass->check($paswd,$hashed))

				{

						//$u_ip=$_SERVER['REMOTE_ADDR'];
					if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $u_ip = $_SERVER["REMOTE_ADDR"];
}

						$timestamp = time();

						$date_time = date("Y-m-d  H:i:s", $timestamp);

						$login_time = $date_time;

						//$maxlifetime=ini_get("session.gc_maxlifetime");

						//$add_time=$timestamp+$maxlifetime;

						//$logout_time= date("Y-m-d H:i:s",$add_time);

						$newp=$this->phpass->hash($npaswd);

						$data_u=array('user_master_password'=>$newp);

						$res=$this->Master_model->up_pw($data_u,$u_id);

						if($res==1)

						{

							$this->session->set_userdata('login_time',$login_time);

							$data=array(

							'user_id'=>$u_id,

							'login'=> $login_time,

							'logout'=>$login_time,

							'log_ip'=>$this->input->ip_address()

							);

							$this->Master_model->save_userlog($data);

							session_destroy();

							redirect('Main_login/index');

						}

						else

						{

							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Update failed!!!</div>');

							redirect('Manual_dredging/Master/ch_pw');

						}

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your Password!!!</div>');

					redirect('Manual_dredging/Master/ch_pw'); 

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

	}

	public function dashboard()

	{

		$user_id=$this->session->userdata('int_userid');

		$sess_usr_id=$user_id;

		if(!empty($user_id))

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);

			$ut=$this->session->userdata('int_usertype');

			if($ut==1)

			{

				$this->load->view('Manual_dredging/Master/dashboard_admin');

			}

			else if($ut==2)

			{

				redirect('Manual_dredging/Port/port_dir_main');

			}

			else if($ut==8)

			{

				redirect('Manual_dredging/Port/port_officer_main');

			}

			else if($ut==3)

			{

				redirect('Manual_dredging/Port/port_con_main');

			}

			else if($ut==4)

			{

				redirect('Manual_dredging/Port/port_lsgd_main');

			}

			else if($ut==5)

			{

				$this->session->unset_userdata('int_userid');

				$login_time=$this->session->userdata('login_time');

				

				$temp_userid=$this->session->set_userdata('tempuser_id',$user_id);

				$this->load->model('Manual_dredging/Master_model');

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$rres=$this->db->query("select customer_registration_id as crid,customer_phone_number as phoneno from customer_registration where customer_public_user_id='$user_id'");

				$ud=$rres->result_array();

				$cus_id=$ud[0]['crid'];

				$cus_phoneno=$ud[0]['phoneno']; 

				$currentdate  =	date('Y-m-d H:i:s');

				$otpno=rand(100000,999999);

				$smsmsg="Portinfo 2 - Dear Customer OTP generated for login is $otpno.";

				$this->sendSms($smsmsg,$cus_phoneno);

				//-----------------------insert otp in userlog----------------------------

			//	echo "update tbl_userlog set otpnumber='$otpno' where user_id='$user_id' and login='$login_time' and logout='$login_time'";exit();

				

				$qry=$this->db->query("update tbl_userlog set otpnumber='$otpno' where user_id='$user_id' and login='$login_time'");

				//-------------------------------------------------------------------------

				if($qry)

				{

					

				$sess_otpno=$this->session->set_userdata('sess_otpno',$otpno);

					redirect('Manual_dredging/Master/customer_otpcheck');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your OTP!!!</div>');

				}

				

				

				//-------------------------------------------------------------------------------

				/*$this->load->model('Manual_dredging/Master_model');

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$rres=$this->db->query("select customer_registration_id as crid,customer_purpose as purpose,int_req as req_stat from customer_registration where customer_public_user_id='$user_id'");

				$ud=$rres->result_array();

				$cr_id=$ud[0]['crid'];  

				$data['purpose']=$ud[0]['purpose'];  

				$data 				= 	$data + $this->data;

				$data['req_stat']=$ud[0]['req_stat']; 

				$data 				= 	$data + $this->data;

				$buk_info			=	$this->Master_model->getbukinfo($cr_id);

				//$buk_info			=	$this->Master_model->getbukinfo($user_id);

				$buk_infout			=	$this->Master_model->getbukinfount($user_id);

				$last_booked_date	=	$buk_info[0]['bookeddate'];

				//print_r($buk_infout);

				//exit();

				$bal_sand=$buk_infout[0]['customer_unused_ton'];

				//exit();

				$last_bookeddate	=	strtotime($last_booked_date);

				$bookingtime_data= $this->Master_model->customerbooking_timecheck();

				$starttime=$bookingtime_data[0]['booking_master_start'];

				//exit;

				$endtime=$bookingtime_data[0]['booking_master_end'];

				$data['b_start']=$starttime;

				$data 				= 	$data + $this->data;

				$data['b_end']=$endtime;

				$data 				= 	$data + $this->data;

				$start_time=strtotime($starttime);

				$end_time=strtotime($endtime);

				$current_time=strtotime("now");

				$currentdate  =	date('Y-m-d H:i:s');

				$date1 = date_create($currentdate);

				$date2 = date_create($last_booked_date);

				//difference between two dates

				$diff = date_diff($date1,$date2);

				$dateInterval=$diff->format("%a");

				//$nex_d=7-$dateInterval;

				$ld=explode(" ",$last_booked_date);

				$l_d=$ld[0];

				$n_b_d=date('Y-m-d H:i:s', strtotime($l_d. ' +7 days'));

				$data['nbd']=$n_b_d;

				if($last_booked_date=='')

				{

					$data['status']="buk_allow";

				}

				else

				{

					if($bal_sand>=3)

					{

						if($current_time >= $start_time && $current_time <= $end_time)

						{

							if($dateInterval>=7)

							{

							$reqtt=$this->db->query("select * from customer_booking where customer_booking_pass_issue_user=0 and customer_booking_customer_booking='$user_id' and customer_booking_decission_status NOT IN(4,5,3)");

							$no=$this->db->affected_rows();

							if($no==0)

							{

								$data['status']="buk_allow";

							}

							else

							{

								$data['status']="buk_blockw";

							}

							}

							else

							{

								$data['status']="buk_block";

							}	

						}

					}

					else

					{

						$data['status']="limit";

					}

				}

				$secreqtt=$this->db->query("select * from customer_sec_reg where cus_reg_id='$cr_id' and customer_request_status=1");

							$secno=$this->db->affected_rows();

							if($secno==0){$data['upload']="no";}else{$data['upload']="yes";}

				$this->load->view('Master/customer_home',$data);*/

				

				//------------------------------------------------------------------------------

			}

			else if($ut==6)

			{

				redirect('Manual_dredging/Port/port_zone_main');

			}

			else if($ut==9)

			{

				redirect('Manual_dredging/Port/port_clerk_main');

			}

			else

			{

				

			}
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/dashboard_PCL');
			$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

		else

		{

			redirect('Main_login/index');

		}

	}

	////   Function For Login END  /////

	public function dashboard_master()

	{

		redirect('Manual_dredging/Master/dashboard');

	}

	public function innerPage()

	{



		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);

		$this->load->view('template/inner-list');

		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');*/

	}

	

	

//////     PORT                          ////



/// List/ADD/Edit Zone  By Port Conservator/ Port clerk



//////        Start         ////////////////



public function zone()

{

	 $sess_usr_id 			=  $this->session->userdata('int_userid');
	 $sess_user_type			=	$this->session->userdata('int_usertype');

	$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	
			$this->load->model('Manual_dredging/Master_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			//$allegation			= 	$this->Master_model->get_allegation();
			//$data['allegation']	=	$allegation;
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$this->load->view('Kiv_views/template/dash-header');
        	$this->load->view('Kiv_views/template/nav-header');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
			$zone=$this->Master_model->get_zone_bypID($port_id);
			$data['zone']=$zone;
			$data 				= 	$data + $this->data;
		//	print_r($data);

	//$this->load->view('template/header',$data);
			
		
		$this->load->view('Manual_dredging/Master/zone',$data);
        $this->load->view('Kiv_views/template/dash-footer');

			//$this->load->view('Master/zone', $data);

			//$this->load->view('template/footer');

			//$this->load->view('template/js-footer');

			//$this->load->view('template/script-footer');

			//$this->load->view('template/html-footer');

		 //---------------------------------------------------
		 
       
		 
		 
		 
		 
	   	}

	   	else

	   	{

			redirect('Manual_dredging/Main_login/index');        

  		}  	

}

public function zone_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
		 	$this->load->view('Kiv_views/template/dash-header');
        	$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addzone', $data);
		 	$this->load->view('Kiv_views/template/dash-footer');
			

			$this->load->model('Manual_dredging/Master_model');

			if($this->input->post())

			{

				$this->form_validation->set_rules('vch_zone_name', 'Zone Name', 'required');

				$this->form_validation->set_rules('vch_zone_code', 'Zone Code', 'required');

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					$zone_name=$this->input->post('vch_zone_name');

					$zone_name=$this->security->xss_clean($zone_name);

					$zone_name=html_escape($zone_name);

					$zone_code=$this->input->post('vch_zone_code');

					$zone_code=$this->security->xss_clean($zone_code);

					$zone_code=html_escape($zone_code);

					$zone_type=$this->input->post('dredge_type');

					$zone_type=$this->security->xss_clean($zone_type);

					$zone_type=html_escape($zone_type);

					$zone_data=array(

					'zone_name'=>$zone_name,

					'zone_code'=>$zone_code,

					'zone_user_id'=>$sess_usr_id,

					'zone_port_id'=>$port_id,

					'zone_type'=>$zone_type,

					);

					$result=$this->Master_model->add_zone($zone_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Zone added successfully</div>');

														redirect('Manual_dredging/Master/zone');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Zone Add failed!!!</div>');

														redirect('Manual_dredging/Master/zone');

					}

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function zone_edit()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');	

	$this->load->model('Manual_dredging/Master_model');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	

			//$int_userpost_sl	=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
		//	echo "asdasdadadsads----".$int_userpost_sl;exit;

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$zonedet			= 	$this->Master_model->get_zoneByID($int_userpost_sl);

			$data['zonedata']	=	$zonedet;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addzone', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			$this->load->model('Manual_dredging/Master_model');

			if($this->input->post())

			{

				$zone_name=$this->input->post('vch_zone_name');

					$zone_name=$this->security->xss_clean($zone_name);

					$zone_name=html_escape($zone_name);

					$zone_code=$this->input->post('vch_zone_code');

					$zone_code=$this->security->xss_clean($zone_code);

					$zone_code=html_escape($zone_code);

				$zone_id	=	decode_url($this->input->post('hid'));

				$zone_data=array(

				'zone_name'=>$zone_name,

				'zone_code'=>$zone_code

				);

				//print_r($zone_data);

				$result=$this->Master_model->update_zone($zone_id,$zone_data);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Zone Updated successfully</div>');

													redirect('Manual_dredging/Master/zone');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Zone Update failed!!!</div>');

													redirect('Manual_dredging/Master/zone');

				}

				

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit Zone  By Port Conservator/ Port clerk



//////        EnD         ////////////////



//////     PORT                          ////



/// List/ADD/Edit LSGD  By Port Conservator/ Port clerk



//////       Start         ////////////////

public function genReport()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))

	{
		$this->load->model('Manual_dredging/Master_model');
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;
		
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/genreport',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		
	}

	else

	{

		redirect('Main_login/index');        

  	} 

}

public function report_genAjax()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	$fromt=$this->input->post('fromd');

	$tot=$this->input->post('tod');

	$from=date("Y-m-d",strtotime(str_replace('/', '-',$fromt)));

	$to=date("Y-m-d",strtotime(str_replace('/', '-',$tot)));

	if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))

	{
		$this->load->model('Manual_dredging/Master_model');
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

	$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name,'from'=>$fromt,'to'=>$tot);

		$data 				= 	$data + $this->data;     

		//$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

//				$data['user_header']=	$u_h_dat;

	//			$data 				= 	$data + $this->data;

		//		$this->load->view('template/header',$data);

		$a1	=	$this->Master_model->get_lsgd_byID($port_id);

		$data['a1']=$a1;

		$data 	= 	$data + $this->data;

		$zone=$this->Master_model->get_zone_by_portIDforrep($port_id);//change for spot

		$data['zone']=$zone;

		$data 	= 	$data + $this->data;

		$j=0;

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);//change for spot

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					$a2[$lsgd_id][$z['zone_id']]=$z['zone_name'];

				}

			}		

		}	

		$data['a2']=$a2;

		$data 	= 	$data + $this->data;

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);//change for spot

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					$totton=$this->Master_model->get_lsgd_totqty($lsgd_id,$z['zone_id'],$from,$to);//change for spot

					$a3[$lsgd_id][$z['zone_id']]=$totton[0]['totton'];

				}

			}		

		}	

		$data['a3']=$a3;

		$data 	= 	$data + $this->data;

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);//change for spot

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					$totVP=$this->Master_model->get_lsgd_totVP($lsgd_id,$z['zone_id'],$from,$to);//change for spot

					$a4[$lsgd_id][$z['zone_id']]=$totVP[0]['nos'];

				}

			}		

		}	

		$data['a4']=$a4;

		$data 	= 	$data + $this->data;

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);//change for spot

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					$totAmt=$this->Master_model->get_lsgd_totAmt($lsgd_id,$z['zone_id'],$from,$to);//change for spot

					$a5[$lsgd_id][$z['zone_id']]=$totAmt[0]['amt'];

				}

			}		

		}	

		$data['a5']=$a5;

		$data 	= 	$data + $this->data;

		$material	=	$this->Master_model->get_material_master_act();

		$matw_tax	=	$this->Master_model->get_taxrate();

		foreach($matw_tax as $mattax)

		{

			if($mattax['tax_calculator_status']==1)

			{

				$taxedmat=$mattax['tax_calculator_materials'];

				$tax_rate=$mattax['tax_calculator_rate'];

			}

		}

		$tam=explode(',',$taxedmat);

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);//change for spot

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					foreach($material as $m)

					{

						if($m['material_master_id']==3)

						{

							if($m['material_master_authority']==1)

							{

								$material_r	=	$this->Master_model->get_materialrateByMatID($m['material_master_id']);

								//$mamt

								if(empty($material_r))

								{

									$matamt=0;

								}

								else

								{

								$matamt=$material_r[0]['materialrate_port_amount'];

								}

								$a6[$lsgd_id][$z['zone_id']]=$matamt;

							}

							else

							{

								$material_r	=	$this->Master_model->get_materialrateByMatIDp($m['material_master_id'],$port_id);

								if($material_r[0]['materialrate_domain']==2)

								{

									$matamt=$material_r[0]['materialrate_port_amount'];

									$a6[$lsgd_id][$z['zone_id']]=$matamt;

								}

								else

								{

									$material_nr	=	$this->Master_model->get_materialrateByMatIDs($port_id,$m['material_master_id'],$z['zone_id']);

									if(empty($material_nr))

									{

										$matamt=0;

									}

									else

									{

									$matamt=$material_nr[0]['materialrate_port_amount'];

									$a6[$lsgd_id][$z['zone_id']]=$matamt;

									}

								}	

							}

						}

					}

				}

			}

		}

		$data['a6']=$a6;

		$data 	= 	$data + $this->data;

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					foreach($material as $m)

					{

						if($m['material_master_id']==2)

						{

							if($m['material_master_authority']==1)

							{

								$material_r	=	$this->Master_model->get_materialrateByMatID($m['material_master_id']);

								//$mamt

								$matamt=$material_r[0]['materialrate_port_amount'];

								$a7[$lsgd_id][$z['zone_id']]=$matamt;

							}

							else

							{

								$material_r	=	$this->Master_model->get_materialrateByMatIDp($m['material_master_id'],$port_id);

								if($material_r[0]['materialrate_domain']==2)

								{

									$matamt=$material_r[0]['materialrate_port_amount'];

									$a7[$lsgd_id][$z['zone_id']]=$matamt;

								}

								else

								{

									$material_nr	=	$this->Master_model->get_materialrateByMatIDs($port_id,$m['material_master_id'],$z['zone_id']);

									$matamt=$material_nr[0]['materialrate_port_amount'];

									$a7[$lsgd_id][$z['zone_id']]=$matamt;

								}	

							}

						}

					}

				}

			}

		}

		$data['a7']=$a7;

		$data 	= 	$data + $this->data;

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					foreach($material as $m)

					{

						if($m['material_master_id']==5)

						{

							if($m['material_master_authority']==1)

							{

								$material_r	=	$this->Master_model->get_materialrateByMatID($m['material_master_id']);

								//$mamt

								$matamt=$material_r[0]['materialrate_port_amount'];

								$a8[$lsgd_id][$z['zone_id']]=$matamt;

							}

							else

							{

								$material_r	=	$this->Master_model->get_materialrateByMatIDp($m['material_master_id'],$port_id);

								if($material_r[0]['materialrate_domain']==2)

								{

									$matamt=$material_r[0]['materialrate_port_amount'];

									$a8[$lsgd_id][$z['zone_id']]=$matamt;

								}

								else

								{

									$material_nr	=	$this->Master_model->get_materialrateByMatIDs($port_id,$m['material_master_id'],$z['zone_id']);

									$matamt=$material_nr[0]['materialrate_port_amount'];

									$a8[$lsgd_id][$z['zone_id']]=$matamt;

								}	

							}

						}

					}

				}

			}

		}

		$data['a8']=$a8;

		$data 	= 	$data + $this->data;

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					foreach($material as $m)

					{

						if($m['material_master_id']==6)

						{

							if($m['material_master_authority']==1)

							{

								$material_r	=	$this->Master_model->get_materialrateByMatID($m['material_master_id']);

								//$mamt

								$matamt=$material_r[0]['materialrate_port_amount'];

								$a9[$lsgd_id][$z['zone_id']]=$matamt;

							}

							else

							{

								$material_r	=	$this->Master_model->get_materialrateByMatIDp($m['material_master_id'],$port_id);

								if($material_r[0]['materialrate_domain']==2)

								{

									$matamt=$material_r[0]['materialrate_port_amount'];

									$a9[$lsgd_id][$z['zone_id']]=$matamt;

								}

								else

								{

									$material_nr	=	$this->Master_model->get_materialrateByMatIDs($port_id,$m['material_master_id'],$z['zone_id']);

									$matamt=$material_nr[0]['materialrate_port_amount'];

									$a9[$lsgd_id][$z['zone_id']]=$matamt;

								}	

							}

						}

					}

				}

			}

		}

		$data['a9']=$a9;

		$data 	= 	$data + $this->data;

		$nmatamt1=0;

		$matamt2=0;

		$matamt1=0;

		$a10[$lsgd_id][$z['zone_id']]=0;

		$taxedmat=explode(',',$taxedmat);

		foreach($a1 as $a)

		{

			$lsgd_id=$a['lsgd_id'];

			$zne	=	$this->Master_model->get_zone_bylsgdID($lsgd_id);

			$ze=explode(',',$zne[0]['Zone']);

			foreach($zone as $z)

			{

				if(in_array($z['zone_id'],$ze))

				{

					foreach($material as $m)

					{

							if($m['material_master_authority']==1)

							{

								if(in_array($m['material_master_id'],$taxedmat))

								{

								$material_r	=	$this->Master_model->get_materialrateByMatID($m['material_master_id']);

								//$mamt

								$matamt1=$material_r[0]['materialrate_port_amount']*($tax_rate/100);

								}

								//$a9[$lsgd_id][$z['zone_id']]=$matamt;

							}

							else

							{

								$material_r	=	$this->Master_model->get_materialrateByMatIDp($m['material_master_id'],$port_id);

								if(in_array($m['material_master_id'],$taxedmat))

								{

									if($material_r[0]['materialrate_domain']==2)

									{

										$matamt1=$material_r[0]['materialrate_port_amount']*($tax_rate/100);

										//$a9[$lsgd_id][$z['zone_id']]=$matamt;

									}

									else

									{

										$material_nr	=	$this->Master_model->get_materialrateByMatIDs($port_id,$m['material_master_id'],$z['zone_id']);

										if(empty($material_nr))

										{

											$matamt1=0;

										}

										else

										{

										$matamt1=$material_nr[0]['materialrate_port_amount']*($tax_rate/100);

										//$a9[$lsgd_id][$z['zone_id']]=$matamt;

										}

									}

								}

							}

							$nmatamt1=$nmatamt1+$matamt1;
						

					}

					$a10[$lsgd_id][$z['zone_id']]=$nmatamt1;
$nmatamt1=0;
				}

			}

		}

		$data['a10']=$a10;

		$data 	= 	$data + $this->data;

		$this->load->view('Manual_dredging/Master/rep_gen',$data);

		//$this->load->view('template/footer');

		//$this->load->view('template/js-footer');

		//$this->load->view('template/script-footer');

		//$this->load->view('template/html-footer');

	}

	else

	{

		redirect('Main_login/index');        

  	} 

}

public function lsgd()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$lsgd=$this->Master_model->get_lsgd_byPort($port_id);

			$data['lsgd']=$lsgd;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

$this->load->view('Manual_dredging/Master/lsgd', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

}

public function lsgd_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$port=$this->Master_model->get_port_By_PC($port_id);

			//print_r($port);

			$dist_id=$port[$i]['int_district_id'];

			$data['port']=$port;

			$data 				= 	$data + $this->data;

			$district=$this->Master_model->get_district_byID($dist_id);

			$data['di']=$district;

			$data 				= 	$data + $this->data;

			$panch=$this->Master_model->get_panchayath($dist_id);

			$data['lsg']=$panch;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				$this->load->view('Manual_dredging/Master/addlsgd', $data);
				$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				//$this->form_validation->set_rules('int_lsgd_port', 'Port', 'required');

				//$this->form_validation->set_rules('int_lsgd_dist', 'District', 'required');

				$this->form_validation->set_rules('int_lsgd_name', 'LSGD', 'required');

				$this->form_validation->set_rules('int_lsgd_name_mal', 'LSGD NAME', 'required');

				$this->form_validation->set_rules('vch_lsgd_adrs', 'Address', 'required');

				$this->form_validation->set_rules('vch_lsgd_phone', 'Phone', 'required|exact_length[10]');

				if($this->form_validation->run() == FALSE)

				{

					echo validation_errors();

					exit();

				}

				else

				{

					//print_r($this->input->post());

					//exit;

					$lsgd_name=html_escape($this->input->post('int_lsgd_name'));

					$lsgd_name_unicode=html_escape($this->input->post('int_lsgd_name_mal'));

					$lsgd_address=html_escape($this->input->post('vch_lsgd_adrs'));

					$lsgd_phone_number=html_escape($this->input->post('vch_lsgd_phone'));

					$lsgd_district_id=html_escape($this->input->post('int_lsgd_dist'));

					$lsgd_port_id=html_escape($this->input->post('int_lsgd_port'));

					$lsgd_master=html_escape($this->input->post('tb_lsg_id'));

					$lsgd_data=array(

					'lsgd_name'=>$lsgd_name,

					'lsgd_name_unicode'=>$lsgd_name_unicode,

					'lsgd_address'=>$lsgd_address,

					'lsgd_phone_number'=>$lsgd_phone_number,

					'lsgd_district_id'=>$lsgd_district_id,

					'lsgd_port_id'=>$lsgd_port_id,

					'lsgd_user_id'=>$sess_usr_id,

					'panchayath_sl'=>$lsgd_master

					);

					$lsgd_data=$this->security->xss_clean($lsgd_data);

					$result=$this->Master_model->add_lsgd($lsgd_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">LSGD added successfully</div>');

														redirect('Manual_dredging/Master/lsgd');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error LSGD Add failed!!!</div>');

														redirect('Manual_dredging/Master/lsgd');

					}

			   }

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function lsgd_edit()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			//$int_userpost_sl	=		decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$lsgd				= 	$this->Master_model->get_lsg_byid($int_userpost_sl);

			//print_r($lsgd);

			foreach($lsgd as $l)

			{

				$dist_id			=	$l['lsgd_district_id'];

			}

			$data['lsgd']		=	$lsgd;

			$data 				= 	$data + $this->data;

			$lsgd				= 	$this->Master_model->get_district();

			$data['dist']		=	$lsgd;

			$data 				= 	$data + $this->data;

			$port				= 	$this->Master_model->get_port();

			$data['port']		=	$port;

			$data 				= 	$data + $this->data;

			$lsg				= 	$this->Master_model->get_panchayath($dist_id);

			$data['lsg']		=	$lsg;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

$this->load->view('Manual_dredging/Master/addlsgd', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$lsgd_id=decode_url($this->input->post('hid'));

				$lsgd_data=array(

				//'lsgd_name'=>$this->input->post('int_lsgd_name'),

				//'lsgd_name_unicode'=>$this->input->post('int_lsgd_name_mal'),

				'lsgd_address'=>html_escape($this->input->post('vch_lsgd_adrs')),

				'lsgd_phone_number'=>html_escape($this->input->post('vch_lsgd_phone')),

				//'lsgd_district_id'=>$this->input->post('int_lsgd_dist'),

				//'lsgd_port_id'=>$this->input->post('int_lsgd_port'),

				//'lsgd_user_id'=>$sess_usr_id

				);

				$lsgd_data=$this->security->xss_clean($lsgd_data);

				$result=$this->Master_model->update_lsgd($lsgd_id,$lsgd_data);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">LSGD added successfully</div>');

													redirect('Manual_dredging/Master/lsgd');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error LSGD Add failed!!!</div>');

													redirect('Manual_dredging/Master/lsgd');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

//////     PORT                          ////



/// List/ADD/Edit LSGD  By Port Conservator/ Port clerk



//////       End        ////////////////



///     Ajax Functions       //////

///     Start               //////

public function getDistAjax()

{

	$this->load->model('Manual_dredging/Master_model');	

	$port_id=$this->security->xss_clean(html_escape($this->input->post('dist_id')));

	$dist_id=$this->Master_model->get_port_district($port_id);

	foreach($dist_id as $diid)

	{

	$dist_id=$diid['int_district_id'];

	}

	$district=$this->Master_model->get_district_byID($dist_id);

	$data['district']=$district;

	$this->load->view('Manual_dredging/Master/getDist', $data);

}

public function getPanchayathAjax()

{

	$this->load->model('Manual_dredging/Master_model');	

	$dis_id=$this->security->xss_clean(html_escape($this->input->post('dist_id')));

	$panchayath=$this->Master_model->get_panchayath($dis_id);

	$data['panchayath']=$panchayath;

	$this->load->view('Manual_dredging/Master/getpanchayath', $data);

}

public function getPanchayathmalAjax()

{
	

	$this->load->model('Manual_dredging/Master_model');	

	 $panch_id=$this->security->xss_clean(html_escape($this->input->post('panch_id')));

	$panchayath_mal=$this->Master_model->get_panchayath_mal($panch_id);

	$data['panchayath_mal']=$panchayath_mal;

	$this->load->view('Manual_dredging/Master/getpanchayath_mal', $data);

}

public function getLsgforZoneAjax()

{

	$this->load->model('Manual_dredging/Master_model');	

	$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));

	$lsg=$this->Master_model->get_zone_lsg($zone_id);

	$port_id=$lsg[0]['lsgd_port_id'];

	//$lsg_id=$lsg[0]['lsgd_id'];

	$mat=$this->Master_model->get_matforport($port_id);

	$l=count($mat);

	$cnt=0;

	if($l>0)

	{

		foreach($mat as $m)

		{

			$mid=$m['materialrate_port_material_master_id'];

			$lsgd=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

			if(!empty($lsgd))

			{

				$cnt++;

			}

		}

	}

	if($cnt==$l)

	{

		$data['lsgd']=$lsg;

		$this->load->view('Manual_dredging/Master/getlsgforzone', $data);

	}

	else

	{

		echo "0";

	}

}

public function ch_usrAjax()

{

	$this->load->model('Manual_dredging/Master_model');	

	$un=$this->security->xss_clean(html_escape($this->input->post('un')));

	$no=$this->Master_model->chk_usr($un);

	if($no==1)

	{

		echo "1";

	}

	else

	{

		echo "0";

	}

	

}

public function get_usrAjax()

{

	$i=0;

	$this->load->model('Manual_dredging/Master_model');	

	$pid=$this->security->xss_clean(html_escape($this->input->post('pid')));

	$port=$this->Master_model->get_portcode($pid);

	$port_code=$port[$i]['vchr_officecode'];

	$cnt=$this->Master_model->get_count_login();

	//print_r($cnt);

	$count=$cnt[$i]['cnt'];

	$un=$port_code."_".$count;

	echo $un;

}

public function get_zusrAjax()

{

	$i=0;

	$this->load->model('Manual_dredging/Master_model');	

	$zid=$this->security->xss_clean(html_escape($this->input->post('zid')));

	$zone=$this->Master_model->get_zoneByID($zid);

	$zone_code=$zone[$i]['zone_code'];

	$cnt=$this->Master_model->get_count_login();

	//print_r($cnt);

	$count=$cnt[0]['cnt'];

	$un=$zone_code."_".$count;

	echo $un;

}

public function getzoneAjax()

{

	$i=0;

	$this->load->model('Manual_dredging/Master_model');	

	$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL);

	$data 				= 	$data + $this->data; 

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$port_id			=	$userinfo[$i]['user_master_port_id'];

	$mat_id=$this->security->xss_clean(html_escape($this->input->post('mat_id')));

	$zones=$this->Master_model->get_zoneBymID($port_id,$mat_id);

	$data['zones']		=	$zones;

	$data 				= 	$data + $this->data;

	//$zone_code=$zone[$i]['zone_code'];

	$zone			= 	$this->Master_model->get_zone_by_portID($port_id);

	$data['zone']	=	$zone;

	$data 				= 	$data + $this->data;

	$this->load->view('Manual_dredging/Master/getzones', $data);

	//echo "hiiiiiii";

}

/// Ajax Function ////////////////

///  ENd //////////////////////////

//////     PORT                          ////



/// List/ADD/Edit Material Master  By Port Director



//////       Start         ////////////////

public function material()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model-> get_material_master();

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			
				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');

				$this->load->view('Manual_dredging/Master/material', $data);
				$this->load->view('Kiv_views/template/dash-footer');
			

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}



public function material_master_edit()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	$this->load->model('Manual_dredging/Master_model');	

			//$int_userpost_sl		=	decode_url($this->uri->segment(3));	//------comment on 6/11/2019---------port intergration------------
		 	$int_userpost_sl		=	decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model-> get_material_master_det($int_userpost_sl);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$amount_type			= 	$this->Master_model->get_amount_type();

			$data['amount_type']	=	$amount_type;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				$this->load->view('Manual_dredging/Master/addmaterial', $data);
				$this->load->view('Kiv_views/template/dash-footer');
			

			if($this->input->post())

			{

				$mat_id=decode_url($this->input->post('hid'));

				$material_data=array(

				'material_master_name'=>html_escape($this->input->post('vch_material_name')),

				'material_master_amount_type_id'=>html_escape($this->input->post('int_material_amtype')),

				'material_master_authority'=>html_escape($this->input->post('int_authority')),

				//'material_master_user_id'=>$sess_usr_id

				);

				$material_data=$this->security->xss_clean($material_data);

				$result=$this->Master_model->update_material_master($mat_id,$material_data);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Updated successfully</div>');

													redirect('Manual_dredging/Master/material');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material update failed!!!</div>');

													redirect('Manual_dredging/Master/material');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

}

public function material_add()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$amount_type			= 	$this->Master_model->get_amount_type();

			$data['amount_type']	=	$amount_type;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addmaterial', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
			if($this->input->post())

			{

				$this->form_validation->set_rules('vch_material_name', 'Material Name', 'required');

				$this->form_validation->set_rules('int_material_amtype', 'Amount Type', 'required');

				$this->form_validation->set_rules('int_authority', 'Authority Type', 'required');

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					$material_data=array(

					'material_master_name'=>html_escape($this->input->post('vch_material_name')),

					'material_master_amount_type_id'=>html_escape($this->input->post('int_material_amtype')),

					'material_master_authority'=>html_escape($this->input->post('int_authority')),

					'material_master_user_id'=>$sess_usr_id

					);

					$material_data=$this->security->xss_clean($material_data);

					$result=$this->Master_model->add_material($material_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material added successfully</div>');

														redirect('Manual_dredging/Master/material');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Add failed!!!</div>');

														redirect('Manual_dredging/Master/material');

					}

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit Material Master  By Port Director



//////       End       ////////////////





//////     PORT                          ////



/// List/ADD/Edit Material Rate  By Port Director



//////       Start         ////////////////

public function material_rate()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'user'=>$sess_usr_id);

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(1);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_rate			= 	$this->Master_model->get_materialrate();

			$data['material_rate']	=	$material_rate;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/material_rate', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function materiaratel_master_edit()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			//$int_userpost_sl		=	decode_url($this->uri->segment(3));	//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl		=	decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(1);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_rate			= 	$this->Master_model->get_materialrate_masterByID($int_userpost_sl);

			$data['material_rate']	=	$material_rate;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				$this->load->view('Manual_dredging/Master/addmaterialrate', $data);
				$this->load->view('Kiv_views/template/dash-footer');
		

			if($this->input->post())

			{

				

				if($this->input->post('vch_material_ed')=='')

				{

					if($this->input->post('int_material_status')==2)

					{

						$end_date=date('Y-m-d');	

					}

					else

					{

					$end_date='0000-00-00';

					}

				}

				else

				{

					$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

				}

				$m_r_id=decode_url($this->input->post('hid'));

				$matrate_data=array(

				'materialrate_port_material_master_id'=>html_escape($this->input->post('int_material')),

				'materialrate_port_amount'=>html_escape($this->input->post('vch_material_amt')),

				'materialrate_port_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'materialrate_port_end_date'=>$end_date,

				'materialrate_port_status'=>html_escape($this->input->post('int_material_status')),

				//'material_master_user_id'=>$sess_usr_id

				);

				$matrate_data=$this->security->xss_clean($matrate_data);

				$result=$this->Master_model->update_material_rate_master($m_r_id,$matrate_data);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate Updated successfully</div>');

													redirect('Manual_dredging/Master/material_rate');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Update failed!!!</div>');

													redirect('Manual_dredging/Master/material_rate');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function materialrate_add()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(1);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_ex			= 	$this->Master_model->get_materialrate_act_pd();

			$data['material_ex']	=	$material_ex[0]['mat_id'];

			//exit;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addmaterialrate', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$this->form_validation->set_rules('int_material', 'Material', 'required');

				$this->form_validation->set_rules('vch_material_amt', 'Amount', 'required');

				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

				$this->form_validation->set_rules('int_material_status', 'Status', 'required');

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

					$matrate_data=array(

					'materialrate_port_material_master_id'=>html_escape($this->input->post('int_material')),

					'materialrate_port_amount'=>html_escape($this->input->post('vch_material_amt')),

					'materialrate_port_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

					'materialrate_port_end_date'=>$end_date,

					'materialrate_domain'=>1,

					'materialrate_port_status'=>html_escape($this->input->post('int_material_status')),

					'materialrate_port_user_id'=>$sess_usr_id

					);

					$matrate_data=$this->security->xss_clean($matrate_data);

					$result=$this->Master_model->add_material_rate($matrate_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate added successfully</div>');

														redirect('Manual_dredging/Master/material_rate');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Add failed!!!</div>');

														redirect('Manual_dredging/Master/material_rate');

					}

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

//////     PORT                          ////



/// List/ADD/Edit Material Master  By Port Director



//////      EnD        ////////////////



//////     PORT                          ////



/// List/ADD/Edit Material Master  By Port Conservator/Port Clerk



//////       Start         ////////////////

public function material_rate_pc()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$material			= 	$this->Master_model->get_material_master();

			$data['material']	=	$material;   

			$material_rate			= 	$this->Master_model->get_materialratefu($port_id);

			$data['material_rate']	=	$material_rate;

			$data 				= 	$data + $this->data;

			$zone			= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']	=	$zone;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/material_rate_pc',$data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function addmaterialrate_pc()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(2);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_ex			= 	$this->Master_model->get_materialrate_act_pc($port_id);

			$data['material_ex']	=	$material_ex[0]['mat_id'];

			//exit;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$zone			= 	$this->Master_model->get_zoneByPID($sess_usr_id);

			$data['zone']	=	$zone;

			$data 			= 	$data + $this->data;

			$gm             =   $this->Master_model->get_matforp($port_id);

			$data['matid']	=	$gm[0]['matid'];

			$data 			= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addmaterialrate_pc', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
			$this->form_validation->set_rules('int_material', 'Material', 'required');

				$this->form_validation->set_rules('vch_material_amt', 'Amount', 'required');

				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

				$this->form_validation->set_rules('int_material_status', 'Status', 'required');

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post())

					{

						if($this->input->post('vch_material_ed')=='')

						{

							$end_date='0000-00-00';

						}

						else

						{

							$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

						}

						if($this->input->post('vch_material_amt_dzone')!="true")

						{

							$domain=2;

							$rate=NULL;

						}

						else

						{

							$domain=3;

							$rate=$mat=implode(',',$this->input->post('vch_material_amt_zone'));

						}

						$matrate_data=array(

						'materialrate_port_material_master_id'=>html_escape($this->input->post('int_material')),

						'materialrate_port_amount'=>html_escape($this->input->post('vch_material_amt')),

						'materialrate_port_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

						'materialrate_port_end_date'=>$end_date,

						'materialrate_domain'=>$domain,

						'materialrate_port_status'=>html_escape($this->input->post('int_material_status')),

						'materialrate_port_user_id'=>$sess_usr_id,

						'port_id'=>$port_id,

						'materialrate_zone'=>$rate

						);

						$matrate_data=$this->security->xss_clean($matrate_data);

						$result=$this->Master_model->add_material_rate($matrate_data);

						if($result==1)

						{

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate added successfully</div>');

															redirect('Manual_dredging/Master/material_rate_pc');

						}

						else

						{

							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Add failed!!!</div>');

															redirect('Manual_dredging/Master/material_rate_pc');

						}

					}

				}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function editmaterialrate_pc()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			//$int_userpost_sl		=	decode_url($this->uri->segment(3));	//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl		=	decode_url($this->uri->segment(4));
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(2);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_det			= 	$this->Master_model->get_materialrate_byid($int_userpost_sl);

			$data['material_det']	=	$material_det;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$zone			= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']	=	$zone;

				

			if($this->input->post())

			{

				

				//$this->form_validation->set_rules('int_material', 'Material', 'required');

				$this->form_validation->set_rules('vch_material_amt', 'Amount', 'required');

				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

				$this->form_validation->set_rules('int_material_status', 'Status', 'required');

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

					//exit();

				}

				else

				{

						$mr_id=decode_url($this->input->post('hid'));

						if($this->input->post('vch_material_ed')=='')

						{

							if($this->input->post('int_material_status')==2)

					{

						$end_date=date('Y-m-d');	

					}

					else

					{

					$end_date='0000-00-00';

					}

						}

						else

						{

							$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

						}

						if($this->input->post('vch_material_amt_dzone')!="true")

						{

							$domain=2;

							$rate=NULL;

						}

						else

						{

							$domain=3;

							$rate=$mat=implode(',',$this->input->post('vch_material_amt_zone'));

						}

						$matrate_data=array(

						//'materialrate_port_material_master_id'=>html_escape($this->input->post('int_material')),

						'materialrate_port_amount'=>html_escape($this->input->post('vch_material_amt')),

						'materialrate_port_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

						'materialrate_port_end_date'=>$end_date,

						'materialrate_domain'=>$domain,

						'materialrate_port_status'=>html_escape($this->input->post('int_material_status')),

						//'materialrate_port_user_id'=>$sess_usr_id,

						//'port_id'=>$port_id,

						'materialrate_zone'=>$rate

						);

						$matrate_data=$this->security->xss_clean($matrate_data);

						$result=$this->Master_model->update_material_rate_master($mr_id,$matrate_data);

						if($result==1)

						{

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate Updated successfully</div>');

															redirect('Manual_dredging/Master/material_rate_pc');

						}

						else

						{

							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Update failed!!!</div>');

															redirect('Manual_dredging/Master/material_rate_pc');

						}

					}

				}

				

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addmaterialrate_pc', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

//////     PORT                          ////



/// List/ADD/Edit Material Master  By Port Conservator/Port Clerk



//////       End         ////////////////



//////     PORT                          ////



/// List/ADD/Edit Tax Calculator  By Port Director



//////       Start         ////////////////

public function taxcalculator()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$tax_rate			= 	$this->Master_model->get_taxrate();

			$data['tax_rate']	=	$tax_rate;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/taxcalculator', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function taxcalculator_edit()

{

	    $sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			//$int_userpost_sl		=	decode_url($this->uri->segment(3));	//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl		=	decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$tax_rate			= 	$this->Master_model->get_taxrateByID($int_userpost_sl);

			$data['tax_rate']	=	$tax_rate;

			$data 				= 	$data + $this->data;

			$taxname			= 	$this->Master_model->get_tax_name();

			$data['taxname']	=	$taxname;

			$data 				= 	$data + $this->data;

			$material			= 	$this->Master_model->get_material_master();

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addtaxcalculator', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$t_id=decode_url($this->input->post('hid'));

				$mat=implode(',',$this->input->post('vch_material'));

				if($this->input->post('vch_material_ed')=='')

				{

					if($this->input->post('int_material_status')==2)

					{

						$end_date=date('Y-m-d');	

					}

					else

					{

					$end_date='0000-00-00';

					}

				}

				else

				{

					$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

				}

				$data_taxrate=array(

				//'tax_calculator_taxname_id'=>$this->input->post('int_taxname'),

				'tax_calculator_rate'=>$this->security->xss_clean(html_escape($this->input->post('vch_material_amt'))),

				'tax_calculator_materials'=>$mat,

				'tax_calculator_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'tax_calculator_end_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed'))))),

				'tax_calculator_status'=>html_escape($this->input->post('int_material_status')),

				//'tax_calculator_user_id'=>$sess_usr_id

				);

				$data_taxrate=$this->security->xss_clean($data_taxrate);

				$result=$this->Master_model->update_taxrate_calc($t_id,$data_taxrate);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Tax Rate updated successfully</div>');

													redirect('Manual_dredging/Master/taxcalculator');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Tax Rate update failed!!!</div>');

													redirect('Manual_dredging/Master/taxcalculator');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function taxcalculator_add()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$taxname			= 	$this->Master_model->get_taxname_NotAs();

			$data['taxname']	=	$taxname;

			$data 				= 	$data + $this->data;

			$taxnames			= 	$this->Master_model->get_tax_namea();

			$data['taxnames']	=	$taxnames;

			$data 				= 	$data + $this->data;

			$material			= 	$this->Master_model->get_material_master();

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addtaxcalculator', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				//$this->form_validation->set_rules('int_material', 'Material', 'required');

				$this->form_validation->set_rules('int_taxname', 'Tax Name', 'required');

				$this->form_validation->set_rules('vch_material_amt', 'Amount', 'required');

				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

				$this->form_validation->set_rules('int_material_status', 'Status', 'required');

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

					$mat=implode(',',$this->input->post('vch_material'));

					$data_taxrate=array(

					'tax_calculator_taxname_id'=>html_escape($this->input->post('int_taxname')),

					'tax_calculator_rate'=>html_escape($this->input->post('vch_material_amt')),

					'tax_calculator_materials'=>$mat,

					'tax_calculator_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

					'tax_calculator_end_date'=>$end_date,

					'tax_calculator_status'=>html_escape($this->input->post('int_material_status')),

					'tax_calculator_user_id'=>$sess_usr_id

					);

					$data_taxrate=$this->security->xss_clean($data_taxrate);

					$result=$this->Master_model->add_taxrate_calc($data_taxrate);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Tax Rate added successfully</div>');

														redirect('Manual_dredging/Master/taxcalculator');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Tax Rate Add failed!!!</div>');

														redirect('Manual_dredging/Master/taxcalculator');

					}

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit Tax Calculator  By Port Director



//////       End        ////////////////



//////     PORT                          ////



/// List/ADD/Edit Quantity  By Port Conservator/Port Clerk



//////       Start        ////////////////

public function quantity_pc()

{

		$i=0;

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$quantity			= 	$this->Master_model->get_quantity_by_pc($port_id);

			$data['quantity']	=	$quantity;

			$data 				= 	$data + $this->data;

			$quantitym			= 	$this->Master_model->get_quantity_master();

			$data['quantitym']	=	$quantitym;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				
				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				$this->load->view('Manual_dredging/Master/quantity_pc', $data);
				$this->load->view('Kiv_views/template/dash-footer');
			
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

public function quantity_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{				

			$this->load->model('Manual_dredging/Master_model');

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data; 

			$status			= 	$this->Master_model->get_status();
			$data['status']	=	$status;    
			
			$quantity			= 	$this->Master_model->get_quantity_master();
			$data['quantity']	=	$quantity;
			$data 				= 	$data + $this->data;
			
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addquantity_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			

			if($this->input->post())

			{

				//$this->form_validation->set_rules('int_material', 'Material', 'required');

				//$this->form_validation->set_rules('int_taxname', 'Tax Name', 'required');

				$this->form_validation->set_rules('vch_material_amt[]', 'Amount', 'required');

				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

				$this->form_validation->set_rules('int_material_status', 'Status', 'required');

				if($this->form_validation->run() == FALSE)

				{
					echo validation_errors();
					exit();
				}

				else

				{

					$qty=implode(',',$this->input->post('vch_material_amt'));
					if($this->input->post('vch_material_ed')=='')
					{
						$end_date='0000-00-00';
					}
					else
					{
						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escale($this->input->post('vch_material_ed')))));
					}

					$master_dara=array(
					'quantity_master_id'=>$qty,
					'port_id'=>$port_id,
					'quantity_start_date'=>date("Y-m-d", strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),
					'quantity_end_date'=>$end_date,
					'quantity_status'=>html_escape($this->input->post('int_material_status')),
					'user_id'=>$sess_usr_id
					);

					$master_dara=$this->security->xss_clean($master_dara);
					$result=$this->Master_model->add_quantity_pc($master_dara);
					if($result==1)
					{
						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Quantity added successfully</div>');
						redirect('Manual_dredging/Master/quantity_pc');
					}
					else
					{
						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Quantity Add failed!!!</div>');
					redirect('Manual_dredging/Master/quantity_pc');
					}
				}

			}

	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  	
}

public function quantity_pc_edit()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$this->load->model('Manual_dredging/Master_model');

			//$int_userpost_sl	=		decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl		=	decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);
			$data 				= 	$data + $this->data;     
			$quantity			= 	$this->Master_model->get_quantity_byid($int_userpost_sl);
			$data['quantity']	=	$quantity;
			$data 				= 	$data + $this->data;
			
			$quantity_s			= 	$this->Master_model->get_quantity_master();
			$data['quantity_s']	=	$quantity_s;
			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();
			$data['status']	=	$status;
			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addquantity_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
			if($this->input->post())
			{
				$q_id=decode_url($this->input->post('hid'));
				$qty=implode(',',$this->input->post('vch_material_amt'));
				if($this->input->post('vch_material_ed')=='')
				{
					$end_date='0000-00-00';
				}
				else
				{
					$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));
				}

				$master_dara=array(
				'quantity_master_id'=>$qty,
				'quantity_start_date'=>date("Y-m-d", strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),
				'quantity_end_date'=>$end_date,
				'quantity_status'=>html_escape($this->input->post('int_material_status')),

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->update_quantity_pc($q_id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Quantity updated successfully</div>');
					redirect('Manual_dredging/Master/quantity_pc');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Quantity update failed!!!</div>');
					redirect('Manual_dredging/Master/quantity_pc');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  


}

////chellan///////////////////////////////////

function getChellanDetails()

{

	

	//$buk_id=decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
	$buk_id		=	decode_url($this->uri->segment(4));
$tran_det=$this->Master_model->get_tran_det($buk_id);

	$uid=$tran_det[0]['uid_no'];

	$ifsc=$tran_det[0]['ifsc_code'];

	$cus_regid=$tran_det[0]['transaction_customer_registration_id'];

    $buk_det=$this->Master_model->get_cus_buk_ch_modi($buk_id);

	$bb_det=$this->db->query("select customer_name,customer_phone_number from customer_registration where customer_registration_id='$cus_regid'");

	$bbb_det=$bb_det->result_array();

	$tok_no=$buk_det[0]['customer_booking_token_number'];

	$p_id=$buk_det[0]['customer_booking_port_id'];

	$m_p_id=$buk_det[0]['customer_booking_monthly_permit_id'];

	$t_amt=$buk_det[0]['customer_booking_request_ton'];

	$zone_id=$buk_det[0]['customer_booking_zone_id'];

	$amtbuk=$buk_det[0]['customer_booking_chalan_amount'];

	$cus_name=$bbb_det[0]['customer_name'];

	$cus_phne=$bbb_det[0]['customer_phone_number'];

	$pt_det=$this->db->query("select * from tbl_portoffice_master where int_portoffice_id='$p_id'");

	$p_det=$pt_det->result_array();

	$did=$p_det[0]['int_district_id'];

	//exit;

	$port_name=$p_det[0]['vchr_portoffice_name'];

	$zt_det=$this->db->query("select * from zone where zone_id='$zone_id'");

	$z_det=$zt_det->result_array();

	$z_name=$z_det[0]['zone_name'];

 $dd=$this->Master_model->get_district_byID($did);

 $bank=$this->Master_model->get_bank($p_id);

 $m_p=$this->Master_model->get_monthly_permitByID($m_p_id);

 $sand_rate=$m_p[0]['sand_rate'];

 $amount=$amtbuk;

 $amt=explode('.',$amount);

 if(count($amt)>1)

 {

 $am_wo=$amt[0];

 $am_w=$amt[1];

 }

 else

 {

 $am_wo=$amt[0];

 $am_w="00";

 }

 $acno=$bank[0]['bank_account_number'];

 $a=$this->load->library('numbertowords');

 $date = strtotime("+7 day"); 

 $convertno=$this->numbertowords->convert_number($am_wo);

 

// $l=strlen($acno);

//<img height="75" width="100"  src="'.base_url().'assets/images/goktransmall.png"/>

//<img  height="75" width="100" src="'.base_url().'assets/images/icon_bank.jpg"/>

//<img height="75" width="100"  src="'.base_url().'assets/images/goktransmall.png"/>

//<img  height="75" width="100" src="'.base_url().'assets/images/icon_bank.jpg"/>

		$html='';

		

		for($i=0;$i<3;$i++){

		$html.='<div style="border: 1px solid #111;width:400px;height:auto;text-align:center;margin-top:0px;">';

						

					

						//$html.='<p style="text-align:left;color:black;margin-left:3px;"></p>';

						$html.='

						<table border="0" style="text-align: left;margin:0px 0px 3px 0px;postion:absolute">

							<tbody>

							<tr><td colspan="4" height="5px"></td></tr>

							

								<tr><td ><img height="75" width="100"  src="'.getcwd().'/assets/images/goktransmall.png"/></td>

								<td colspan="2" align="center" style="font-size:12px;text-align:justify;margin:2px 3px 2px 3px;" >Vijaya Bank Pay-in-Slip <br>for Port & Shipping Office <br>'.$port_name.','.$dd[0]['district_name'].'.</td>

								<td  style="text-align: right;margin:0px 0px 3px 0px;"><img  height="75" width="100" src="'.getcwd().'/assets/images/icon_bank.jpg"/></td></tr>

								<tr><td  style="font-size:13px;font-weight: bold;"><b>Token No :</b></td><td><input type="text"  name="doi" value="'.$tok_no.'"></td><td>Date:</td><td >...............................</td></tr>

								<tr><td style="font-size:12px;"><b>UID/SID No :</b></td><td>'.$uid.'</td><td></td><td>Name :- <br>'.$cus_name.'</td></tr>

								<tr><td style="font-size:12px;"><b>IFSC Code :</b></td><td>'.$ifsc.'</td><td></td><td >Kadavu :- <br>'.$z_name.'</td></tr>

								<tr><td style="font-size:12px;"><b>Valid Till :</b></td><td>Sand Allotted Date</td><td></td><td></td></tr>

								

								<tr><td colspan="4" style="text-align: center;margin:0px 0px 3px 0px;"></td></tr>

								<tr><td colspan="4"><b>Amount in Words :</b>'.$convertno.' only</td></tr>

								<tr><td colspan="4">

							<table border="1" cellpadding="0" cellspacing="0" width="100%">

							<tr>

							<td rowspan="2" width="40%" style="text-align: center;margin:0px 0px 3px 0px;"> Purpose of Remittance</td>

							

							<td rowspan="1" colspan="2" width="50%" style="text-align:center;margin:0px 0px 3px 0px;" >Amount</td></tr>

							<tr><td width="25%" style="text-align: center;margin:0px 0px 3px 0px;"> Rs.</td><td width="25%" style="text-align: center;margin:0px 0px 3px 0px;">Ps.</td></tr>

							<tr rowspan="2"><td height="150px">Cost of '. $t_amt.' Tons of Sand     </td><td style="text-align: center;">'. $am_wo.'</td><td border="0" style="text-align: center;" >'. $am_w.'</td></tr>

							<tr ><td style="text-align:right;margin:0px 0px 3px 0px;" height="5px">Total</td><td style="text-align: center;" >'. $am_wo.'</td><td  style="text-align: center;">'. $am_w.'</td></tr>

							</table></ td></tr><tr><td colspan="4"></td></tr>

							<tr><td colspan="4"></td></tr>

						<tr><td colspan="4" height="10px" style="font-size:11px;">Signature of Remitter</td></tr>

						<tr><td colspan="4" height="10px" style="font-size:13px;">Contact Number:<b>'. $cus_phne.'</b></td></tr>

						<tr><td colspan="4" align="center" >FOR BRANCH USE</td></tr>

						<tr><td colspan="4" ><hr></td></tr>

						<tr><td colspan="2" height="10px">Branch Name</td><td>_________________________</td></tr>

						<tr><td colspan="2" height="10px">Branch Code</td><td>_________________________</td></tr>

						<tr><td colspan="2" height="10px">Transaction Ref No.</td><td>_________________________</td></tr>

						<tr><td colspan="2" height="10px">Deposit Date</td><td>_________________________</td></tr>

						<tr><td colspan="4" align="right"></td></tr>

						<tr><td colspan="4" align="right">Authorised Signatory</td></tr>

						<tr><td colspan="4" align="right"></td></tr>

						

						<tr><td colspan="4"  style="text-align:left;border: 1px solid black;">

						<b>Instructions to Branch:</b><br>

1.  Use "FEEHIVE" menu in CBS to perform this transaction.<br>

2.  Verify the amount displayed in CBS with challan amount mentioned above.<br>

3.  Make sure that the challan is valid, by referring the ‘Valid till’ date<br>

mentioned above before accepting the challan<br> </td></tr>

								<tr><td colspan="4" height="4px"  >   </td></tr>

								</tbody>

						</table>&nbsp;';

						$html.='</div>';

						

						}

						$this->load->library('M_pdf');

		                $this->m_pdf->pdf->AddPage('L');

		                $this->m_pdf->pdf->SetMargins(0,0,1);

		                $this->m_pdf->pdf->SetColumns(3);

						$this->m_pdf->pdf->WriteHTML($html);

						$permit_number="challan";

		//$this->m_pdf->pdf->Output(base_url().'assets/monthly_permit_pdf/'.$monthly_permit_permit_number.'.pdf','F');

		$sucss = $this->m_pdf->pdf->Output($permit_number.'.pdf','D');//exit;



}





////chellan End?????????????/////////////////

//////     PORT                          ////



/// List/ADD/Edit Quantity  By Port Conservator/Port Clerk



//////       End        ////////////////



//////     PORT                          ////



/// List/ADD/Edit Quantity Master  By Port Director



//////       Start       ////////////////

public function quantity_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$quantity			= 	$this->Master_model->get_quantity_masterPD();

			$data['quantity']	=	$quantity;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/quantity_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function quantity_master_edit()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			//$int_userpost_sl	=		decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$quantity			= 	$this->Master_model->get_quantity_masterByID($int_userpost_sl);

			$data['quantity']	=	$quantity;

			$data 				= 	$data + $this->data;

			//update_quantity_master

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addquantity_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$q_id=decode_url($this->input->post('hid'));

				$master_dara=array(

				'quantity_master_name'=>html_escape($this->input->post('vch_quantity_name')),

				//'quantity_master_status'=>1,

				//'user_id'=>$sess_usr_id

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->update_quantity_master($q_id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Quantity Updated successfully</div>');

					redirect('Manual_dredging/Master/quantity_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Quantity Update failed!!!</div>');

													redirect('Manual_dredging/Master/quantity_master');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function quantitymaster_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			//$allegation			= 	$this->Master_model->get_allegation();

			//$data['allegation']	=	$allegation;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addquantity_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

					$this->form_validation->set_rules('vch_quantity_name', 'Quantity', 'required');

					//$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

					if($this->form_validation->run() == FALSE)

					{

						validation_errors();

					}

					else

					{

					$master_dara=array(

					'quantity_master_name'=>html_escape($this->input->post('vch_quantity_name')),

					'quantity_master_status'=>1,

					'user_id'=>$sess_usr_id

					);

					$master_dara=$this->security->xss_clean($master_dara);

					$result=$this->Master_model->add_qunatity_master($master_dara);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Quantity added successfully</div>');

						redirect('Manual_dredging/Master/quantity_master');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Quantity Add failed!!!</div>');

														redirect('Manual_dredging/Master/quantity_master');

					}

				}

			}

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit Quantity Master  By Port Director



//////       End        ////////////////



//////     PORT                          ////



/// List/ADD/Edit TAX Name Master  By Port Director



//////      Start       ////////////////

public function taxname_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$taxname			= 	$this->Master_model->get_tax_name();

			$data['taxname']	=	$taxname;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/taxname_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function taxname_master_edit()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			//$int_userpost_sl	=		decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$taxname			= 	$this->Master_model->get_tax_name_ByID($int_userpost_sl);

			$data['taxname']	=	$taxname;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addtaxname_master', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			

			if($this->input->post())

			{

				$tax_id=decode_url($this->input->post('hid'));

				if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'taxname_master_name'=>html_escape($this->input->post('vch_tax_name')),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				//'taxname_master_status'=>1,

				//'taxname_master_user_id'=>$sess_usr_id

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->update_tax_master($tax_id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Tax Name Updated successfully</div>');

					redirect('Manual_dredging/Master/taxname_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Tax Name Update failed!!!</div>');

													redirect('Manual_dredging/Master/taxname_master');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function taxnamemaster_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			//$allegation			= 	$this->Master_model->get_allegation();

			//$data['allegation']	=	$allegation;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addtaxname_master', $data);
			
			

			if($this->input->post())

			{

				$this->form_validation->set_rules('vch_tax_name', 'Tax Name', 'required');

				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

					if($this->form_validation->run() == FALSE)

					{

						validation_errors();

					}

					else

					{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'taxname_master_name'=>html_escape($this->input->post('vch_tax_name')),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				'taxname_master_status'=>1,

				'taxname_master_user_id'=>$sess_usr_id

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->add_taxname_master($master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Tax Name added successfully</div>');

					redirect('Manual_dredging/Master/taxname_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Tax Name Add failed!!!</div>');

													redirect('Manual_dredging/Master/taxname_master');

				}

			}

			}
			$this->load->view('Kiv_views/template/dash-footer');

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit Tax Name Master  By Port Director



//////       End        ////////////////



//////     PORT                          ////



/// List/ADD/Edit Construction Master  By Port Director



//////      Start        ////////////////

public function construction_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$cnst				= 	$this->Master_model->get_construction_master();

			$data['cnst']		=	$cnst;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/construction_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function construction_master_edit()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			//$int_userpost_sl	=		decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl' =>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$cnst				= 	$this->Master_model->get_construction_master_ByID($int_userpost_sl);

			$data['cnst']		=	$cnst;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addconstruction_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$c_id=decode_url($this->input->post('hid'));

				if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'construction_master_name'=>html_escape($this->input->post('vch_construction_name')),

				'construction_master_max_ton'=>html_escape($this->input->post('vch_construction_max')),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

			//	'construction_master_status'=>1,

			//	'user_id'=>$sess_usr_id

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->update_construction_master($c_id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Construction Name Updated successfully</div>');

					redirect('Manual_dredging/Master/construction_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Construction Name Update failed!!!</div>');

													redirect('Manual_dredging/Master/construction_master');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function construction_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			//$allegation			= 	$this->Master_model->get_allegation();

			//$data['allegation']	=	$allegation;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addconstruction_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$this->form_validation->set_rules('vch_construction_name', 'Construction Name', 'required');

				$this->form_validation->set_rules('vch_construction_max', 'Max Quantity', 'required');

					//$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

					$master_dara=array(

					'construction_master_name'=>html_escape($this->input->post('vch_construction_name')),

					'construction_master_max_ton'=>html_escape($this->input->post('vch_construction_max')),

					'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

					'end_date'=>$end_date,

					'construction_master_status'=>1,

					'user_id'=>$sess_usr_id

					);

					$master_dara=$this->security->xss_clean($master_dara);

					$result=$this->Master_model->add_construction_master($master_dara);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Construction Name added successfully</div>');

						redirect('Manual_dredging/Master/construction_master');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Construction Name Add failed!!!</div>');

														redirect('Manual_dredging/Master/construction_master');

					}

				}

			}

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit Construction Master  By Port Director



//////      End        ////////////////



//////     PORT                          ////



/// List/ADD/Edit Plinth Area Master  By Port Director



//////      Start        ////////////////

public function plintharea_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$plinth				= 	$this->Master_model->get_plintharea_master();

			$data['plinth']		=	$plinth;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/plintharea_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function plintharea_master_edit()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			//$int_userpost_sl	=		decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$plinth				= 	$this->Master_model->get_plintharea_masterByID($int_userpost_sl);

			$data['plinth']		=	$plinth;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addplintharea_master', $data);

	$this->load->view('Kiv_views/template/dash-footer');	
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$p_id=decode_url($this->input->post('hid'));

				if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'plintharea_area'=>html_escape($this->input->post('vch_plinth_name')),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				//'plintharea_status'=>1,

				//'plintharea_userid'=>$sess_usr_id,

				//'plintharea_permit_cutoff_date'=>$this->input->post('vch_plinth_pc'),

				//'plintharea__permit_cutoff_status'=>$this->input->post('int_material_status'),

				//'plintharea_booking_time_start'=>$this->input->post('vch_plinth_bsd'),

				//'plintharea_booking_time_end'=>$this->input->post('vch_plinth_bed'),

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->update_plinth_master($p_id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Plinth Area Updated successfully</div>');

					redirect('Manual_dredging/Master/plintharea_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Plinth Area Update failed!!!</div>');

													redirect('Manual_dredging/Master/plintharea_master');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}



public function plintharea_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addplintharea_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$this->form_validation->set_rules('vch_plinth_name', 'Plinth Name', 'required');

				//$this->form_validation->set_rules('vch_construction_max', 'Max Quantity', 'required');

					//$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'plintharea_area'=>html_escape($this->input->post('vch_plinth_name')),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				'plintharea_status'=>1,

				'plintharea_userid'=>$sess_usr_id,

				//'plintharea_permit_cutoff_date'=>$this->input->post('vch_plinth_pc'),

				//'plintharea__permit_cutoff_status'=>$this->input->post('int_material_status'),

				//'plintharea_booking_time_start'=>$this->input->post('vch_plinth_bsd'),

				//'plintharea_booking_time_end'=>$this->input->post('vch_plinth_bed'),

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->add_plintharea_master($master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Plinth Area added successfully</div>');

					redirect('Manual_dredging/Master/plintharea_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Plinth Area Add failed!!!</div>');

													redirect('Manual_dredging/Master/plintharea_master');

				}

			}

			}

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit PlinthArea Master  By Port Director



//////      End        ////////////////



public function cutoff_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$plinth				= 	$this->Master_model->get_cutoff();

			$data['plinth']		=	$plinth;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/cutoff_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function cutoff_master_edit()

{

	//$int_userpost_sl   =  decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
	$int_userpost_sl	=		decode_url($this->uri->segment(4));
	$sess_usr_id 			=  $this->session->userdata('int_userid');

    $sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id)&& $sess_user_type==2)

	{

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$plinth			= 	$this->Master_model->get_cutoff();

			$data['plinth']	=	$plinth;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addcutoff_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				//$this->form_validation->set_rules('vch_plinth_name', 'Plinth Name', 'required');

				$this->form_validation->set_rules('vch_plinth_pc', 'Cutoff Date', 'required');

					//$this->form_validation->set_rules('vch_plinth_bsd', 'Booking Start Time', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'cutoff_user'=>$sess_usr_id,

				'cutoff_date'=>$this->input->post('vch_plinth_pc'),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				//'cutoff_status'=>$this->input->post('int_material_status'),

				//'booking_time_start'=>$this->input->post('vch_plinth_bsd'),

				//'booking_time_end'=>$this->input->post('vch_plinth_bed'),

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$id=decode_url($this->input->post('hid'));

				$result=$this->Master_model->update_cutoff($id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Cutoff Updated successfully</div>');

					redirect('Manual_dredging/Master/cutoff_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Cutoff Update failed!!!</div>');

													redirect('Manual_dredging/Master/cutoff_master');

				}

			}

			}

	}

	else

	{

			redirect('Main_login/index');        

  	}

	

}

public function cutoff_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addcutoff_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				//$this->form_validation->set_rules('vch_plinth_name', 'Plinth Name', 'required');

				$this->form_validation->set_rules('vch_plinth_pc', 'Cutoff Date', 'required');

					//$this->form_validation->set_rules('vch_plinth_bsd', 'Booking Start Time', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'cutoff_user'=>$sess_usr_id,

				'cutoff_date'=>$this->input->post('vch_plinth_pc'),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				//'cutoff_status'=>$this->input->post('int_material_status'),

				//'booking_time_start'=>$this->input->post('vch_plinth_bsd'),

				//'booking_time_end'=>$this->input->post('vch_plinth_bed'),

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->add_cutoff_master($master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Cutoff added successfully</div>');

					redirect('Manual_dredging/Master/cutoff_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Cutoff Add failed!!!</div>');

													redirect('Manual_dredging/Master/cutoff_master');

				}

			}

			}

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////

public function customer_booking_Succ()

{

	

	

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==5)

		{

			//$buk_id=decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$buk_id	=		decode_url($this->uri->segment(4));
			if(!empty($buk_id))

			{

				$data 				= 	array('title' => 'Booking Success', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'suc'=>'Sand Booking Successful');
				$this->load->model('Manual_dredging/Master_model');	

				$buk_del=$this->Master_model->get_permitidbooked($buk_id);

				$data['buk_del']	=	$buk_del;

				$data 				= 	$data + $this->data;

				$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$prio_no=$buk_del[0]['customer_booking_priority_number'];

				$zone_no=$buk_del[0]['customer_booking_zone_id'];

				$buk_p_id=$buk_del[0]['customer_booking_port_id'];

				if($buk_p_id==17)

				{

					$data['stat_u']=1;

					$data 				= 	$data + $this->data;

				$get_last_altd=$this->db->query("select customer_booking_priority_number from customer_booking where customer_booking_zone_id='$zone_no' and customer_booking_pass_issue_user!=0 order by customer_booking_priority_number desc limit 0,1");

				$get_la_altd=$get_last_altd->result_array();

				$get_las_prio=$get_la_altd[0]['customer_booking_priority_number'];

				$get_tot_ton=$this->db->query("select sum(customer_booking_request_ton) as total_ton from customer_booking where customer_booking_zone_id='$zone_no' and customer_booking_priority_number > '$get_las_prio' and customer_booking_priority_number < $prio_no and customer_booking_decission_status=0");

				$tot=$get_tot_ton->result_array();

				//print_r($tot);

				$total_ton=$tot[0]['total_ton'];

				//echo "select sum(customer_booking_request_ton) as total_ton from customer_booking where customer_booking_zone_id='$zone_no' and customer_booking_priority_number > '$get_las_prio' and customer_booking_priority_number < $prio_no and customer_booking_decission_status=0";

				$today=date('Y-m-d');

				$d_log=$this->db->query("select daily_log_date,daily_log_balance from daily_log where daily_log_zone_id='$zone_no' and daily_log_date >='$today'");

				$dd_log=$d_log->result_array();

				$sum_tot=0;

				foreach($dd_log as $ddd)

				{

					$sum_tot=$sum_tot+$ddd['daily_log_balance'];

					if($sum_tot>=$total_ton)

					{

						$pos_date=$ddd['daily_log_date'];

						break;

					}

				}

				if(empty($pos_date))

				{

					$data['posdate']="next permit period";

					$data 				= 	$data + $this->data;

				}

				else

				{

					$data['posdate']=$pos_date;

					$data 				= 	$data + $this->data;

				}

				}

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

				$this->load->view('Manual_dredging/Master/buk_suc', $data);
$this->load->view('Kiv_views/template/dash-footer');
				/*$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');*/

			}

			else

			{

				redirect('Manual_dredging/Master/customer_home');

			}

		}

		else

		{

			redirect('Main_login/index');

		}



	/*

	

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==5)

		{

			$buk_id=decode_url($this->uri->segment(3));

			if(!empty($buk_id))

			{

			$data 				= 	array('title' => 'Booking Success', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'suc'=>'Sand Booking Successful');

			$buk_del=$this->Master_model->get_permitidbooked($buk_id);

			$data['buk_del']	=	$buk_del;

			$data 				= 	$data + $this->data;

		    $u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/buk_suc', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

			}

			else

			{

				redirect('Master/dashboard');

			}

		}

		else

		{

			redirect('Master/index');

		}

*/}

public function booking_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$plinth				= 	$this->Master_model->get_buking();

			$data['plinth']		=	$plinth;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/buking_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}



public function booking_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addbuking_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				//$this->form_validation->set_rules('vch_plinth_name', 'Plinth Name', 'required');

				$this->form_validation->set_rules('vch_booking_s', 'Start Time', 'required');

				$this->form_validation->set_rules('vch_booking_e', 'End Time', 'required');

					//$this->form_validation->set_rules('vch_plinth_bsd', 'Booking Start Time', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'booking_master_user'=>$sess_usr_id,

				'booking_master_start'=>$this->input->post('vch_booking_s'),

				'booking_master_end'=>$this->input->post('vch_booking_e'),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				//'booking_time_start'=>$this->input->post('vch_plinth_bsd'),

				//'booking_time_end'=>$this->input->post('vch_plinth_bed'),

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->add_buking_master($master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Booking Time added successfully</div>');

					redirect('Manual_dredging/Master/booking_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Booking Time Add failed!!!</div>');

													redirect('Manual_dredging/Master/booking_master');

				}

			}

			}

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function booking_master_edit()

{

	//$int_userpost_sl   =  decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
	$int_userpost_sl	=		decode_url($this->uri->segment(4));
	$sess_usr_id 			=  $this->session->userdata('int_userid');

    $sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id)&& $sess_user_type==2)

	{

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$plinth			= 	$this->Master_model->get_buking();

			$data['plinth']	=	$plinth;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addbuking_master', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				//$this->form_validation->set_rules('vch_plinth_name', 'Plinth Name', 'required');

				$this->form_validation->set_rules('vch_booking_s', 'Start Time', 'required');

				$this->form_validation->set_rules('vch_booking_e', 'End Time', 'required');

					//$this->form_validation->set_rules('vch_plinth_bsd', 'Booking Start Time', 'required');

					//$this->form_validation->set_rules('int_material_status', 'Status', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_material_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));

					}

				$master_dara=array(

				'booking_master_user'=>$sess_usr_id,

				'booking_master_start'=>$this->input->post('vch_booking_s'),

				'booking_master_end'=>$this->input->post('vch_booking_e'),

				'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

				'end_date'=>$end_date,

				//'cutoff_status'=>$this->input->post('int_material_status'),

				//'booking_time_start'=>$this->input->post('vch_plinth_bsd'),

				//'booking_time_end'=>$this->input->post('vch_plinth_bed'),

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$id=decode_url($this->input->post('hid'));

				$result=$this->Master_model->update_buking($id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Cutoff Updated successfully</div>');

					redirect('Manual_dredging/Master/booking_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Cutoff Update failed!!!</div>');

													redirect('Manual_dredging/Master/booking_master');

				}

			}

			}

	}

	else

	{

			redirect('Main_login/index');        

  	}

	

}

//////     PORT                          ////



/// List/ADD/Edit WOrker Quantity Master  By Port Director



//////      Start        ////////////////

public function workerqty_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& ($sess_user_type==2 || $sess_user_type==8))

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;

			

			$data['port_officer']=	0;

			if($sess_user_type==8){

				$data['port_officer']=	1;

			}

			$wqty				= 	$this->Master_model->get_workerqty_master();

			$data['wqty']		=	$wqty;

			$data 				= 	$data + $this->data;		

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			
				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				$this->load->view('Manual_dredging/Master/workerqty_master', $data);
				$this->load->view('Kiv_views/template/dash-footer');
			
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function workerqty_master_edit()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			//$int_userpost_sl	=		decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$wqty				= 	$this->Master_model->get_workerqty_masterByID($int_userpost_sl);

			$data['wqty']		=	$wqty;

			$data 				= 	$data + $this->data;

			$status				= 	$this->Master_model->get_status();

			$data['status']		=	$status;

			$data 				= 	$data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addworkerqty', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$wq_id=decode_url($this->input->post('hid'));

				if($this->input->post('vch_worker_ed')=='')

				{

					$end_date='0000-00-00';

				}

				else

				{

					$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_worker_ed')))));

				}

				$master_dara=array(

				'worker_quantity'=>$this->security->xss_clean(html_escape($this->input->post('vch_worker_qty'))),

				'worker_quantity_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_worker_sd'))))),

				'worker_quantity_end_date'=>$end_date,

				'worker_quantity_status'=>$this->security->xss_clean(html_escape($this->input->post('int_worker_status'))),

				//'_user_id'=>$sess_usr_id

				);

				$master_dara=$this->security->xss_clean($master_dara);

				$result=$this->Master_model->update_worker_quantity($wq_id,$master_dara);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Worker Quantity updated successfully</div>');

					redirect('Manual_dredging/Master/workerqty_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Worker Quantity Update failed!!!</div>');

													redirect('Manual_dredging/Master/workerqty_master');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function workerqty_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$status				= 	$this->Master_model->get_status();

			$data['status']		=	$status;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addworkerqty', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
			if($this->input->post())

			{

				$this->form_validation->set_rules('vch_worker_qty', 'Worker Quantity', 'required');

				//$this->form_validation->set_rules('vch_construction_max', 'Max Quantity', 'required');

					$this->form_validation->set_rules('vch_worker_sd', 'Start Date', 'required');

					$this->form_validation->set_rules('int_worker_status', 'Status', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					if($this->input->post('vch_worker_ed')=='')

					{

						$end_date='0000-00-00';

					}

					else

					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_worker_ed')))));

					}

					$master_dara=array(

					'worker_quantity'=>$this->input->post('vch_worker_qty'),

					'worker_quantity_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_worker_sd'))))),

					'worker_quantity_end_date'=>$end_date,

					'worker_quantity_status'=>html_escape($this->input->post('int_worker_status')),

					'_user_id'=>$sess_usr_id

					);

					$master_dara=$this->security->xss_clean($master_dara);

					$result=$this->Master_model->add_workqty_master($master_dara);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Worker Quantity added successfully</div>');

						redirect('Manual_dredging/Master/workerqty_master');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Worker Quantity Add failed!!!</div>');

														redirect('Manual_dredging/Master/workerqty_master');

					}

				}

			}

        }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD/Edit WOrker Quantity Master  By Port Director



//////      End        ////////////////



//////     PORT                          ////



/// List/ADD/Edit Bank Details By Port COnservator / Port Clerk



//////      Start        ////////////////

public function bank()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$i=0;

	$this->load->model('Manual_dredging/Master_model');

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$port_id			=	$userinfo[$i]['user_master_port_id'];

	$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$bank			= 	$this->Master_model->get_bank($port_id);
			$data['bank']	=	$bank;
			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/bank_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  	
}
public function bank_pc_edit()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');
	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
	$i=0;
	$port_id			=	$userinfo[$i]['user_master_port_id'];
	$this->load->model('Manual_dredging/Master_model');
	$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
			//$int_userpost_sl		=	decode_url($this->uri->segment(3));	//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);
			$data 				= 	$data + $this->data;     

			$bank			= 	$this->Master_model->get_bank_det($int_userpost_sl);
			$data['bank']	=	$bank;
			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addbank_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
			if($this->input->post())
			{
				$bank_id=decode_url($this->input->post('hid'));
				$bank_data=array(
				'bank_name'=>html_escape($this->input->post('vch_bankname')),
				'bank_branch_name'=>html_escape($this->input->post('vch_branchname')),
				'bank_account_number'=>html_escape($this->input->post('vch_acno')),
				'bank_ifsc_code'=>html_escape($this->input->post('vch_ifsc')),
				'bank_micr_code'=>html_escape($this->input->post('vch_micr')),
				);

				$bank_data=$this->security->xss_clean($bank_data);
				$result=$this->Master_model->update_bank_pc($bank_id,$bank_data);
				if($result==1)
				{
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Bank details updated successfully</div>');
					redirect('Manual_dredging/Master/bank');
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Bank details update failed!!!</div>');
				redirect('Manual_dredging/Master/bank');
				}
			}
	   	}
	   	else
	   	{
			redirect('Main_login/index');        

  		}  
}

public function bank_add()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	$this->load->model('Manual_dredging/Master_model');

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
		 	$this->load->view('Kiv_views/template/dash-header');
		 	$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addbank_pc', $data);
		 $this->load->view('Kiv_views/template/dash-footer');
			
			if($this->input->post())

			{

				$this->form_validation->set_rules('vch_bankname', 'Bank Name', 'required');
				$this->form_validation->set_rules('vch_branchname', 'Branch', 'required');
				$this->form_validation->set_rules('vch_acno', 'account number', 'required');
				$this->form_validation->set_rules('vch_ifsc', 'IFSC', 'required');
				$this->form_validation->set_rules('vch_micr', 'MICR', 'required');
			    if($this->form_validation->run() == FALSE)
				{
					validation_errors();
				}
				else
				{
					$bank_data=array(
					'bank_name'=>html_escape($this->input->post('vch_bankname')),
					'bank_branch_name'=>html_escape($this->input->post('vch_branchname')),
					'bank_account_number'=>html_escape($this->input->post('vch_acno')),
					'bank_ifsc_code'=>html_escape($this->input->post('vch_ifsc')),
					'bank_micr_code'=>html_escape($this->input->post('vch_micr')),
					'bank_port_id'=>$port_id,
					'bank_status'=>1,
					'user_id'=>$sess_usr_id
					);

					$bank_data=$this->security->xss_clean($bank_data);
					$result=$this->Master_model->add_bank($bank_data);
					if($result==1)
					{
						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Bank added successfully</div>');
						redirect('Manual_dredging/Master/bank');
					}
					else
					{
						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Bank Add failed!!!</div>');
						redirect('Manual_dredging/Master/bank');

					}
				}
			}
	   	}
	   	else
	   	{
			redirect('Main_login/index');        

  		}  	
}

//////     PORT                          ////

/// List/ADD/Edit Bank Details By Port COnservator / Port Clerk

//////      ENd        ////////////////


//////     PORT                          ////


/// List/ADD/Edit Assign Zone By Port COnservator / Port Clerk


//////      Start        ////////////////

public function assignzone()

{

	$sess_usr_id 			=   $this->session->userdata('int_userid');
	$sess_user_type			=	$this->session->userdata('int_usertype');
	$userinfo				=	$this->Master_model->getuserinfo($sess_usr_id);

	$i=0;

	$port_id			=	$userinfo[$i]['user_master_port_id'];

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$this->load->model('Manual_dredging/Master_model');		
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     

			$aszone				= 	$this->Master_model->get_assigned_zone_byID($port_id);
			$data['aszone']		=	$aszone;
			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/assignzone_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  	

}

public function assignzone_add()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');
	$sess_user_type			=	$this->session->userdata('int_usertype');
	$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{

			$this->load->model('Manual_dredging/Master_model');	
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$data 			= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 			= 	$data + $this->data;     

			$fee			= 	$this->Master_model->get_fee_master();
			$data['fee']	=	$fee;
			$data 			= 	$data + $this->data;

			$lsgd			= 	$this->Master_model->get_lsgd_byID($port_id);
			$data['lsgd']	=	$lsgd;
			$data 			= 	$data + $this->data;

			$zone			= 	$this->Master_model->get_zone_NotAs($port_id);
			$data['zone']	=	$zone;
			$data 			= 	$data + $this->data;

			$zones=$this->Master_model->get_zone_by_portID($port_id);
			$data['zones']	=	$zones;
			$data 			= 	$data + $this->data;

			$wQ				=	$this->Master_model->get_wQ();
			$data['wq']		=$wQ[$i]['worker_quantity'];
			
			$status			= 	$this->Master_model->get_status();
			$data['status']		=	$status;
			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
	
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addassignzone_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			

			if($this->input->post())

			{

				$this->form_validation->set_rules('int_lsg', 'LSGD', 'required');
				//$this->form_validation->set_rules('vch_construction_max', 'Max Quantity', 'required');
				$this->form_validation->set_rules('int_zone', 'Zone', 'required');
				$this->form_validation->set_rules('vch_reg_fee', 'Registration fee', 'required');
				$this->form_validation->set_rules('vch_jetty_fee', 'Jetty Fee', 'required');
				$this->form_validation->set_rules('vch_worker_qty', 'Worker Quantity', 'required');
				$this->form_validation->set_rules('vch_order_no', 'Order No', 'required');
				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');
				$this->form_validation->set_rules('vch_reg_date', 'Registration Date', 'required');
				//$this->form_validation->set_rules('vch_monthly_qty', 'Monthly Quantity', 'required');
				$this->form_validation->set_rules('vch_remark', 'Remark', 'required');
				$this->form_validation->set_rules('int_status', 'Status', 'required');
			    if($this->form_validation->run() == FALSE)

				{

					echo validation_errors();

				}
				else
				{
					if($this->input->post('vch_material_ed')=='')
					{
						$end_date='0000-00-00';
					}
					else
					{
						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));
					}
					$zone_id=html_escape($this->input->post('int_zone'));

					$bank_data=array(
					'lsg_id'=>html_escape($this->input->post('int_lsg')),
					'zone_id'=>$zone_id,
					'lsg_zone_registration_fee'=>html_escape($this->input->post('vch_reg_fee')),
					'lsg_zone_jetty_fee'=>html_escape($this->input->post('vch_jetty_fee')),
					'lsg_zone_number_of_workers'=>html_escape($this->input->post('vch_worker_qty')),
					'lsg_zone_order_number'=>html_escape($this->input->post('vch_order_no')),
					'lsg_zone_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),
					'lsg_zone_end_date'=>$end_date,
					'lsg_zone_registration_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_reg_date'))))),
					'lsg_zone_monthly_ton'=>html_escape($this->input->post('vch_monthly_qty')),
					'lsg_zone_remarks'=>html_escape($this->input->post('vch_remark')),
					'lsg_zone_status'=>html_escape($this->input->post('int_status')),
					'user_id'=>$sess_usr_id,
					'lsg_zone_port_id'=>$port_id,
					'lsg_zone_loading_place'=>html_escape($this->input->post('load_place'))
					);

//print_r($bank_data);exit();

					$bank_data=$this->security->xss_clean($bank_data);
					$result=$this->Master_model->add_zone_lsg($bank_data);
					if($result==1)
					{

						$priority_data=array('port_id'=>$port_id,
						'zone_id'=>$zone_id,
						'last_priority'=>0,
						);

						$this->db->insert('tbl_priority',$priority_data);
						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Zone Assigned successfully</div>');
														redirect('Manual_dredging/Master/assignzone');

					}
					else
					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Zone Assign failed!!!</div>');
														redirect('Manual_dredging/Master/assignzone');
					}
				}
			}
	   	}
	   	else
	   	{
			redirect('Main_login/index');        

  		}  
		
}

public function assignzone_edit()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$i=0;
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{

			$this->load->model('Manual_dredging/Master_model');	
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];

			//$int_userpost_sl		=	decode_url($this->uri->segment(3));	//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			$data 			= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 			= 	$data + $this->data;     

			$lsg_zone			= 	$this->Master_model->getzonelsged($int_userpost_sl);
			$data['lsg_zone']	=	$lsg_zone;
			$data 			= 	$data + $this->data;

			//$lsgd			= 	$this->Master_model->get_lsgd_byID($sess_usr_id);

//			$data['lsgd']	=	$lsgd;

//			$data 			= 	$data + $this->data;

//			$zone			= 	$this->Master_model->get_zone_NotAs($sess_usr_id);

//			$data['zone']	=	$zone;

//			$data 			= 	$data + $this->data;

			$wQ				=	$this->Master_model->get_wQ();
			$data['wq']		=	$wQ[$i]['worker_quantity'];
			$data 			= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();
			$data['status']		=	$status;
			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addassignzone_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
			if($this->input->post())
			{

				//$this->form_validation->set_rules('int_lsg', 'LSGD', 'required');
				//$this->form_validation->set_rules('vch_construction_max', 'Max Quantity', 'required');
				//$this->form_validation->set_rules('int_zone', 'Zone', 'required');
				$this->form_validation->set_rules('vch_reg_fee', 'Registration fee', 'required');
				$this->form_validation->set_rules('vch_jetty_fee', 'Jetty Fee', 'required');
				$this->form_validation->set_rules('vch_worker_qty', 'Worker Quantity', 'required');
				$this->form_validation->set_rules('vch_order_no', 'Order No', 'required');
				$this->form_validation->set_rules('vch_material_sd', 'Start Date', 'required');
				$this->form_validation->set_rules('vch_reg_date', 'Registration Date', 'required');
				//$this->form_validation->set_rules('vch_monthly_qty', 'Monthly Quantity', 'required');
				$this->form_validation->set_rules('vch_remark', 'Remark', 'required');
				$this->form_validation->set_rules('int_status', 'Status', 'required');
			    if($this->form_validation->run() == FALSE)
				{
					echo validation_errors();exit;

				}
				else
				{
					if($this->input->post('vch_material_ed')=='')
					{
						$end_date='0000-00-00';

					}
					else
					{

						$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_ed')))));
						//exit;
					}

					$bank_data=array(
					//'lsg_id'=>html_escape($this->input->post('int_lsg')),
					//'zone_id'=>html_escape($this->input->post('int_zone')),
					//'lsg_zone_registration_fee'=>html_escape($this->input->post('vch_reg_fee')),
					//'lsg_zone_jetty_fee'=>html_escape($this->input->post('vch_jetty_fee')),
					'lsg_zone_number_of_workers'=>html_escape($this->input->post('vch_worker_qty')),
					'lsg_zone_order_number'=>html_escape($this->input->post('vch_order_no')),
					'lsg_zone_start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),
					'lsg_zone_end_date'=>$end_date,
					'lsg_zone_registration_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_reg_date'))))),
					'lsg_zone_monthly_ton'=>html_escape($this->input->post('vch_monthly_qty')),
					'lsg_zone_remarks'=>html_escape($this->input->post('vch_remark')),
					'lsg_zone_status'=>html_escape($this->input->post('int_status')),
					//'user_id'=>$sess_usr_id,
					//'lsg_zone_port_id'=>$port_id,
					'lsg_zone_loading_place'=>html_escape($this->input->post('load_place'))
					);

					$bank_data=$this->security->xss_clean($bank_data);
					$id=decode_url($this->input->post('hid'));
					$result=$this->Master_model->update_lsgzone($id,$bank_data);
					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Updated successfully</div>');
														redirect('Manual_dredging/Master/assignzone');
					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Update failed!!!</div>');
														redirect('Manual_dredging/Master/assignzone');
					}

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

}

//////     PORT                          ////



/// List/ADD Assign Zone By Port COnservator / Port Clerk



//////      EnD       ////////////////



//////     PORT                          ////



/// List/ADD Assign Section By Port COnservator / Port Clerk



//////     Start       ////////////////

public function assignzone_sec()

{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$i=0;
		$port_id			=	$userinfo[$i]['user_master_port_id'];
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{

			$this->load->model('Manual_dredging/Master_model');	
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     

			$asgn_sec			= 	$this->Master_model->get_assigned_sec($port_id);
			
			$data['asgn_sec']	=	$asgn_sec;
			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/assignzonesec_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');	
	   	}
	   	else
	   	{
			redirect('Main_login/index');        

  		}  
}

public function logout()

{

	$this->load->model('Manual_dredging/Master_model');

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$login_time 			=  $this->session->userdata('login_time');

	//date_default_timezone_set("Asia/Kolkata");

	$timestamp = time();

    $date_time = date("Y-m-d  H:i:s", $timestamp);

	$logout_time = $date_time;

	session_destroy();

	if(isset($sess_usr_id))

	{

	$this->Master_model->update_userlog($sess_usr_id,$login_time,$logout_time);

	}

	redirect('Main_login/index');

}

public function assignzonesec_add()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	

			$this->load->model('Manual_dredging/Master_model');

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$i=0;

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$zone		= 	$this->Master_model->get_zone_NotAsS($port_id);

			$data['zone']	=	$zone;

			$data 				= 	$data + $this->data;

			$zones=$this->Master_model->get_zone_by_portID($port_id);

			$data['zones']	=	$zones;

			$data 			= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addassignzone_sec_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

				$this->form_validation->set_rules('int_zone', 'Zone', 'required');

				//$this->form_validation->set_rules('vch_construction_max', 'Max Quantity', 'required');

					$this->form_validation->set_rules('int_lsg', 'LSGD', 'required');

					$this->form_validation->set_rules('vch_sec_name', 'Section Name', 'required');

					$this->form_validation->set_rules('vch_sec_phone', 'Section Phone', 'required');

					//$this->form_validation->set_rules('vch_micr', 'MICR', 'required');

			    if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					$zone_id=html_escape($this->input->post('int_zone'));

					$lsgd_id=html_escape($this->input->post('int_lsg'));

					$wrkq		= 	$this->Master_model->get_workercount($zone_id,$lsgd_id);

					$w_c=$wrkq[$i]['lsg_zone_number_of_workers'];

					$bank_data=array(

					'lsgd_id'=>$lsgd_id,

					'zone_id'=>$zone_id,

					'port_id'=>$port_id,

					'lsg_section_name'=>html_escape($this->input->post('vch_sec_name')),

					'lsg_section_current_workers'=>0,

					'lsg_section_status'=>1,

					'user_id'=>$sess_usr_id,

					'lsg_section_phone_number'=>html_escape($this->input->post('vch_sec_phone'))

					);

					$bank_data=$this->security->xss_clean($bank_data);

					//print_r($bank_data);break;

					$result=$this->Master_model->add_zone_sec($bank_data);

					if(!empty($result))

					{

						//$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Bank added successfully</div>');

														redirect('Manual_dredging/Master/sec_user/'.encode_url($result));

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Bank Add failed!!!</div>');

														redirect('Manual_dredging/Master/bank');

					}

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	

}

//////     PORT                          ////



/// List/ADD Assign Zone By Port COnservator / Port Clerk



//////      EnD       ////////////////



//////     PORT                          ////



/// List/ADD Create Section User Port COnservator / Port Clerk



//////     Start      ////////////////

public function sec_user()

{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$i=0;

			$port_id			=	$userinfo[$i]['user_master_port_id'];	

			$p_c=$this->Master_model->get_port_By_PC($port_id);

			$p_cd=$p_c[$i]['vchr_officecode'];

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'pc'=>$p_cd);

			$data 				= 	$data + $this->data;     

			//$int_sec_id			=	decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_sec_id	=		decode_url($this->uri->segment(4));
			$sectiondet			= 	$this->Master_model->get_sec_det($int_sec_id);

			//print_r($sectiondet);break;

			$data['sectiondet']		=	$sectiondet;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/sec_user', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{
				$this->load->model('Manual_dredging/Master_model');	

				$un=$this->security->xss_clean(html_escape($this->input->post('vch_un')));

				$email=$this->input->post('vch_email');

			    $pw=$this->input->post('vch_pw');

				$phno=$this->security->xss_clean(html_escape($this->input->post('txt_phone')));

				//exit;

				$sub="User Login Information | Port";

				$msg="Username :- $un  and Password:- $pw";

				$lsg_sec_id=$this->security->xss_clean(html_escape($this->input->post('lsgsecid')));

				$bank_data=array(

				'user_master_name'=>$un,

				'user_master_password'=>$this->phpass->hash($pw),

				'user_master_id_user_type'=>4,

				'user_master_port_id'=>$port_id,

				'user_master_zone_id'=>$this->security->xss_clean(html_escape($this->input->post('zoneid'))),

				'user_master_lsg_id'=>$this->security->xss_clean(html_escape($this->input->post('lsgid'))),

				'user_master_fullname'=>'Lsgd Section Clerk',

				'user_master_lsg_section_id'=>$lsg_sec_id,

				'user_master_status'=>1,

				'user_master_ph'=>$phno,

				'user_master_user_id'=>$sess_usr_id

				);

				$result=$this->Master_model->add_user_login($bank_data);

				if(!empty($result))

				{

					$smsmsg="Portinfo 2 - Dear LSGD user please note your username $un and password $pw";

					$this->sendSms($smsmsg,$phno);

					$this->emailSendFun('manualdredging@gmail.com',$email,$sub,$msg);

					$u_id=$result;

					$data_s =array('lsg_section_user'=>$u_id);

					$result=$this->Master_model->up_lsgsec($data_s,$lsg_sec_id);

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Section added successfully</div>');

													redirect('Manual_dredging/Master/assignzone_sec');

				}

			

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Section Add failed!!!</div>');

													redirect('Manual_dredging/Master/assignzone_sec');

				}

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}



//////     PORT                          ////



/// List/ADD Create Section User Port COnservator / Port Clerk



//////    End      ////////////////







//////     PORT                          ////



/// Common FUnction TO delete Data



// tbl_name => Table NAme

//uni_f =>Primary Field Name

//u_f=Name of the Field to be updated

//id=>primary value



//////     Start      ////////////////

public function deldata()

{

	$id=$this->security->xss_clean(html_escape($this->input->post('id')));

	$table=$this->security->xss_clean(html_escape($this->input->post('tbl_name')));

	$uniq_f=$this->security->xss_clean(html_escape($this->input->post('uni_f')));

	$up_f=$this->security->xss_clean(html_escape($this->input->post('u_f')));

	$data=array($up_f=>0);

	$this->load->model('Manual_dredging/Master_model');

	$result=$this->Master_model->del_det($table,$uniq_f,$data,$id);

	echo $result;

}

public function del_worker()

{

	$id=$this->security->xss_clean(html_escape($this->input->post('id')));

	$table=$this->security->xss_clean(html_escape($this->input->post('tbl_name')));

	$uniq_f=$this->security->xss_clean(html_escape($this->input->post('uni_f')));

	$up_f=$this->security->xss_clean(html_escape($this->input->post('u_f')));

	$data=array($up_f=>0);

	$this->load->model('Manual_dredging/Master_model');

	$worker=$this->Master_model->get_worker_details($id);

	$result=$this->Master_model->del_det($table,$uniq_f,$data,$id);

	//echo $result;exit();

	//print_r($worker);exit();

	$zone_id=$worker['zone_id'];

	$lsgd_id=$worker['lsg_id'];

	if($result==1){

		$result=$this->Master_model->decrement_current_worker($zone_id,$lsgd_id);

	}

	echo $result;

}



//////     PORT                          ////



/// Common FUnction TO delete Data



//////     End     ////////////////



//////     PORT                          ////



/// List/ADD New Dredging Port Port Director



//////    Start      ////////////////

public function dregport_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& ($sess_user_type==2 || $sess_user_type==8))

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;   

			$data['port_officer']=	0;

			if($sess_user_type==8){

				$data['port_officer']=	1;

				$po_port			= 	$this->Master_model->get_portofficer_port($sess_usr_id);

				$po_port_id			=	$po_port[0]['port_id'];

				$po_port_arr		= 	explode(',',$po_port_id);

				//print_r($po_port_arr);break;

				$data['po_port_arr']=	$po_port_arr;		

			}	  

			$port				= 	$this->Master_model->get_port();

			$data['port']		=	$port;

			$data 				= 	$data + $this->data;		

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/assigndredgport', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function dredgeport_add()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$port				= 	$this->Master_model->get_portb();

			$data['port']		=	$port;

			$data 				= 	$data + $this->data;	

			$status				= 	$this->Master_model->get_status();

			$data['status']		=	$status;

			$data 				= 	$data + $this->data;	

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				
				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/adddredgeport', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
			if($this->input->post())

			{

				$port_id=$this->security->xss_clean(html_escape($this->input->post('int_port')));

				$status=$this->security->xss_clean(html_escape($this->input->post('int_material_status')));

				$result	= $this->Master_model->update_port_master($port_id,$status);

				if($result==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Dredging Port added successfully</div>');

													redirect('Manual_dredging/Master/dregport_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Dredging Port add failed!!!</div>');

													redirect('Manual_dredging/Master/dregport_master');

				}

				

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD New Dredging Port Port Director



//////   ENd      ////////////////



//////     PORT                          ////



/// Create New Port Conservator Port Director



//////    Start      ////////////////

public function portconserv_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$portc				= 	$this->Master_model->get_port_conserv();

			$data['portc']		=	$portc;

			$data 				= 	$data + $this->data;		

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/portconserv', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function post_to_url($url, $data) 

{

					$fields = '';

					foreach($data as $key => $value) {

					   $fields .= $key . '=' . $value . '&';

					}

			rtrim($fields, '&');

			$post = curl_init();

			curl_setopt($post, CURLOPT_URL, $url);

			curl_setopt($post, CURLOPT_POST, count($data));

			curl_setopt($post, CURLOPT_POSTFIELDS, $fields);

			curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

			$result = curl_exec($post);

			curl_close($post);

}

public function pc_user_add()

{

	//echo bin2hex(openssl_random_pseudo_bytes(4));

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$portc				= 	$this->Master_model->get_pc_ex();

			//print_r($portc);

			$data['portc']		=	$portc;

			$data 				= 	$data + $this->data;	

			$port				= 	$this->Master_model->get_port_master_details();

			$data['port']		=	$port;

			$data 				= 	$data + $this->data;	

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/addportconserv', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			

			if($this->input->post())

			{

				$un=html_escape($this->input->post('vch_un'));

				$un=$this->security->xss_clean($un);

				$psw=bin2hex(openssl_random_pseudo_bytes(4));

				$ph=html_escape($this->input->post('vch_ph'));

				$ph=$this->security->xss_clean($ph);

				$uemail=html_escape($this->input->post('vch_email'));

				$uemail=$this->security->xss_clean($uemail);

				$desig=html_escape($this->input->post('desig'));

				$desig=$this->security->xss_clean($desig);

				$int_port=html_escape($this->input->post('int_port'));

				$int_port=$this->security->xss_clean($int_port);

				//$phno=$this->input->post('vch_ph');

				$sub="User Login Information | Port";

				$msg="Username :- $un  and Password:- $psw";

				$data_array=array(

				'user_master_port_id'=>$int_port,

				'user_master_name'=>$un,

				'user_master_password'=>$this->phpass->hash($psw),

				'user_master_id_user_type'=>3,

				'user_master_status'=>1,

				'user_master_fullname'=>$desig,

				'user_master_ph'=>$ph,

				'user_master_email'=>$uemail,

				'user_master_user_id'=>$sess_usr_id

				);

				$result	= $this->Master_model->add_user_login($data_array);

				if(isset($result))

				{

					$this->emailSendFun('manualdredging@gmail.com',$uemail,$sub,$msg);

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Port Conservator added successfully</div>');

													redirect('Manual_dredging/Master/portconserv_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Port Conservator add failed!!!</div>');

													redirect('Manual_dredging/Master/portconserv_master');

				}

				

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD New Dredging Port Port Director



//////    End      ////////////////

//////     PORT                          ////



/// List/ADD New Port Conservtor  By Port Conservator



//////    Start      ////////////////

public function cr_pc_user()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$this->load->model('Manual_dredging/Master_model');	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$i=0;

			$port_id			=	$userinfo[$i]['user_master_port_id'];	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$portc				= 	$this->Master_model->get_port_user($port_id);

			$data['portc']		=	$portc;

			$data 				= 	$data + $this->data;		

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;
		
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/pcuser', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

public function pc_user_addN()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$this->load->model('Manual_dredging/Master_model');	
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$usert				= 	$this->Master_model->get_user_type();
			$data['usert']		=	$usert;
			$data 				= 	$data + $this->data;	
			$zones				= 	$this->Master_model->get_zone_bypID_user($port_id);
			$data['zones']		=	$zones[0]['uzone'];
			$data 				= 	$data + $this->data;
			$zone				= 	$this->Master_model->get_zone_bypID($port_id);
			$data['zone']		=	$zone;
			$data 				= 	$data + $this->data;		
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/addpcuser', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
			if($this->input->post())

			{
				$this->load->model('Manual_dredging/Master_model');	
				$psw=bin2hex(openssl_random_pseudo_bytes(4));
				$ut=$this->security->xss_clean(html_escape($this->input->post('int_ut')));
				if($ut==6)
				{
					$fname="Zone Operator";
					$zid=$this->security->xss_clean(html_escape($this->input->post('int_zone')));
				}
				else
				{
					$fname="Port Clerk";
					$zid=NULL;
				}
				$un=$this->input->post('vch_un');
				$email=$this->input->post('vch_email');
			    $pw=$psw;
				$phnoU=$this->input->post('vch_ph');
				//exit;
				$sub="User Login Information | Port";
				$msg="Username :- $un  and Password:- $pw";
				
				$data_array = array(
				'user_master_port_id'=>$port_id,
				'user_master_name'=>$un,
				'user_master_password'=>$this->phpass->hash($psw),
				'user_master_id_user_type'=>$this->input->post('int_ut'),
				'user_master_fullname'=>$fname,
				'user_master_status'=>1,
				'user_master_zone_id'=>$zid,
				'user_master_user_id'=>$sess_usr_id,
				'user_master_ph'=>$this->input->post('vch_ph'),
				);

				$result	= $this->Master_model->add_user_login($data_array);
				if(isset($result))
				{
					$msgg="Dear Port User please note your login information username $un and password $pw";
					$this->sendSms($msgg,$phnoU);
					$this->emailSendFun('manualdredging@gmail.com',$email,$sub,$msg);
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Port User added successfully</div>');
													redirect('Manual_dredging/Master/cr_pc_user');

				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Port User add failed!!!</div>');
													redirect('Manual_dredging/Master/cr_pc_user');

				}
	

			}

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

}

//////     PORT                          ////



/// List/ADD New Port Conservtor  By Port Conservator



//////    End       ////////////////



///////////                  ******               POLICE            ******              /////////////////

	public function police_case()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

		$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$get_policecase_list= $this->Master_model->policecase_list();

			$data['get_policecase_list']=$get_policecase_list;

			$data = $data + $this->data;   

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/police_case', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

    }

	public function police_case_pc()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			$this->load->model('Manual_dredging/Master_model');	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$i=0;

			$port_id			=	$userinfo[$i]['user_master_port_id'];	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$get_policecase_list= $this->Master_model->policecase_list_byPort($port_id);

			$data['get_policecase_list']=$get_policecase_list;

			$data = $data + $this->data;   

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/police_case_pc', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

    }

	function police_case_add()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			$this->load->model('Manual_dredging/Master_model');	

			$data = array('title' => 'Add Police Case', 'page' => 'police_case_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$get_policecase_list= $this->Master_model->policecase_list();

			$data['get_policecase_list']=$get_policecase_list;

			$data = $data + $this->data; 

			$get_cus_buk= $this->Master_model->get_cus_buk();

			$data['get_cus_buk']=$get_cus_buk;

			$data = $data + $this->data;   

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/police_case_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			if($this->input->post())

			{

			$buk_id=$this->security->xss_clean(html_escape($this->input->post('bukid')));

			$buk_data=$this->Master_model->get_cud_police_byID($buk_id);

			$permit_no=$buk_data[0]['customer_booking_permit_number'];

			$permit_portid=$buk_data[0]['customer_booking_port_id'];

			$dataarray=array(

			'police_case_booking_id'=>$buk_id,

			'police_case_token_number'=>$this->security->xss_clean(html_escape($this->input->post('txttokenno'))),

			'police_case_permit_number'=>$permit_no,

			'police_case_office'=>$this->input->post('txtpolicestnname'),

			'police_case_letter_date'=>$this->input->post('txtletterdate'),

			'police_case_letter_number'=>$this->input->post('txtletterno'),

			'police_case_reference_number'=>$this->input->post('txtrefno'),

			'police_case_ofiicer_details'=>$this->input->post('txtofficedetails'),

			'police_case_cdit_received_timestamp'=>date('Y-m-d H:i:s',now()),

			'police_case_port_id'=>$permit_portid,

			'police_case_cdit_user'=>$sess_usr_id,

			);

			$customerregupt_data= $this->Master_model->police_case_add($dataarray);

				if($customerregupt_data==1)

				{

					

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Police Case added successfully</div>');

						redirect('Manual_dredging/Master/police_case');

					

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error failed!!!</div>');

													redirect('Manual_dredging/Master/police_case');

				}

				

			}

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

    }

	function police_view_pc()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			//$int_userpost_sl		=	decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$int_userpost_sl	=		decode_url($this->uri->segment(4));
			if(!empty($int_userpost_sl))

			{	

			$data = array('title' => 'Add Police Case-PC', 'page' => 'police_case_pc_add', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			}

			else

			{

				$data = array('title' => 'Add Police Case-PC', 'page' => 'police_case_pc_add', 'errorCls' => NULL, 'post' => $this->input->post());

			}

			$data = $data + $this->data; 

			$get_cus_buk= $this->Master_model->get_cus_buk();

			$data['get_cus_buk']=$get_cus_buk;

			$data = $data + $this->data;  

			if(!empty($int_userpost_sl))

			{

			$get_policecase_list= $this->Master_model->policecase_listById($int_userpost_sl);

			$pctime=$get_policecase_list[0]['police_case_port_recieved_timestamp'];

			$data['police']=$get_policecase_list;

			$data = $data + $this->data; 

				if($pctime==NULL)

				{

					$uppolice_date=array(

					'police_case_received_user'=>$int_userpost_sl,

					'police_case_port_recieved_timestamp'=>date('Y-m-d H:i:s',now())

					);	

					$this->Master_model->update_police_pc($int_userpost_sl,$uppolice_date);

				}

			}

			if($this->input->post())

			{

				if($this->input->post('hid')!='')

				{

					$id=decode_url($this->input->post('hid'));

					$data_array=array(

					'police_case_replied_reference_number'=>$this->input->post('retxtrefno'),

					'police_case_replied_date'=>$this->input->post('retxtrefdate'),

					'police_case_replied_user'=>$sess_usr_id,

					);

					$result= $this->Master_model->update_police_pc($id,$data_array);

					if($result==1)

					{

						

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Police Case Replied successfully</div>');

							redirect('Manual_dredging/Master/police_case_pc');

						

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error failed!!!</div>');

														redirect('Manual_dredging/Master/police_case_pc');

					}

				}

				else

				{

					$buk_id=$this->input->post('bukid');

					$buk_data=$this->Master_model->get_cud_police_byID($buk_id);

					$permit_no=$buk_data[0]['customer_booking_permit_number'];

					$permit_portid=$buk_data[0]['customer_booking_port_id'];

					$dataarray=array(

					'police_case_booking_id'=>$buk_id,

					'police_case_token_number'=>$this->input->post('txttokenno'),

					'police_case_permit_number'=>$permit_no,

					'police_case_office'=>$this->input->post('txtpolicestnname'),

					'police_case_letter_date'=>$this->input->post('txtletterdate'),

					'police_case_letter_number'=>$this->input->post('txtletterno'),

					'police_case_reference_number'=>$this->input->post('txtrefno'),

					'police_case_ofiicer_details'=>$this->input->post('txtofficedetails'),

					'police_case_port_recieved_timestamp'=>date('Y-m-d H:i:s',now()),

					'police_case_port_id'=>$permit_portid,

					'police_case_replied_reference_number'=>$this->input->post('retxtrefno'),

					'police_case_replied_date'=>$this->input->post('retxtrefdate'),

					'police_case_received_user'=>$sess_usr_id,

					'police_case_replied_user'=>$sess_usr_id,

					);

					$customerregupt_data= $this->Master_model->police_case_add($dataarray);

					if($customerregupt_data==1)

					{

						

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Police Case added successfully</div>');

							redirect('Manual_dredging/Master/police_case_pc');

						

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error failed!!!</div>');

														redirect('Manual_dredging/Master/police_case_pc');

					}

				}

			}

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/police_case_view', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

    }

	//--------------------------------------------------------------------------------------------------------------------

	public function fee_master()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$get_policecase_list= $this->Master_model->get_fee_masterf();

			$data['get_fee']=$get_policecase_list;

			$data = $data + $this->data;   

			

			$data['port_officer']=	0;

			if($sess_user_type==8){

				$data['port_officer']=	1;

			}

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/feemaster', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



    }

	public function fee_master_edit()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
		$id			=		$this->uri->segment(4);
		$id			=		decode_url($id);

		if(!empty($sess_usr_id))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$get_policecase_list= $this->Master_model->get_fee_master_edit($id);

			$data['get_fee']=$get_policecase_list;

			$data = $data + $this->data;   

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/feemaster_edit', $data);
$this->load->view('Kiv_views/template/dash-footer');
			if($this->input->post())

			{

				$hid=$this->input->post('hid');

				$amt=$this->input->post('famt');

				$res=$this->db->query("update fee_master set fee_master_fee='$amt' where fee_master_id=$hid");

				if($res==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processed successfully</div>');

				    redirect('Manual_dredging/Master/fee_master/');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processed successfully</div>');

					redirect('Manual_dredging/Master/fee_master/');

				}

			}

			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



    }

	function police_caseforwards_add()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			$data = array('title' => 'Add Police Case Forwards', 'page' => 'police_caseforwards_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/police_caseforwards_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

    }

	

	//--------------------------------------------------------------------------------------------------------------------

	

	function police_case_pc_add()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			$data = array('title' => 'Add Police Case-PC', 'page' => 'police_case_pc_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data; 

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/police_case_pc_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

    }



///////////                                 POLICE                          /////////////////

////// PORT    /////	

	  ///Function for case stage   

	public function reqdchk($val)

    {

        if ($val=='')

        {

            $this->form_validation->set_message('reqdchk', 'Atleast One Enquiry to be selected');

            return FALSE;

        }

        else

        {

            return TRUE;

        }

    } 

	 public function reqdunitchk($val)

    {

        if ($val=='')

        {

            $this->form_validation->set_message('reqdunitchk', 'Atleast One Unit to be selected');

            return FALSE;

        }

        else

        {

            return TRUE;

        }

    }   

	//custom validation function to accept only alpha and space input

    public function alphanum_only_space($str)

    {

		if( $str!=""){

			if (!preg_match("/^([-a-zA-Z0-9 ])+$/i", $str))

			{

				$this->form_validation->set_message('alphanum_only_space', 'The %s field must contain only alphabets, numbers or spaces');

				return FALSE;

			}

			else

			{

				return TRUE;

			}

		return TRUE;}

	}

	

	//custom validation function to accept only alpha and space input

    public function alphanum($str)

    {

		if( $str!=""){

			if (!preg_match("/^([-a-zA-Z0-9])+$/i", $str))

			{

				$this->form_validation->set_message('alphanum', 'The %s field must contain only alphabets or numbers');

				return FALSE;

			}

			else

			{

				return TRUE;

			}

		return TRUE;}

	}

	

	 public function alphanumspace($str)

    {

		if( $str!=""){

	 if (!preg_match("/^([-a-zA-Z0-9 ])+$/i ", $str))

			{

				$this->form_validation->set_message('alphanumspace', 'The %s field must contain only alphabets, number or spaces');

				return FALSE;

			}

			else

			{

				return TRUE;

			}

			return TRUE;}

	}

	

//custom validation function to accept only alpha and space input

    public function alpha_only($str)

    {

		if( $str!=""){

			if (!preg_match("/^([-a-zA-Z ])+$/i", $str))

			{

				$this->form_validation->set_message('alpha_only', 'The %s field must contain only alphabets or spaces');

				return FALSE;

			}

			else

			{

				return TRUE;

			}

		return TRUE;}

	}

	

	function address_check($str)

    {

        if (!preg_match("/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s\,]+$/i", $str))

        {

            $this->form_validation->set_message('address_check', 'The %s field does not accept special characters');

            return FALSE;

        }

        else

        {

            return TRUE;

        }

    }

	public function check_worker_count($count){

		$sess_usr_id = $this->session->userdata('int_userid');

		$no_of_workers		= $this->Master_model->get_no_of_workers($sess_usr_id);

		//print_r($no_of_workers);break;

		$no_of_workers = $no_of_workers['lsg_section_current_workers']; 

		if ($no_of_workers==$count)

			return true;

		else{

			

			$this->form_validation->set_message('check_worker_count', 'The %s field should be equal to the number of Registered  Workers for this LSGD');

			return false;

		}

		

		

	} 

///////





//////                               Gopika Start    ///////////////////////////////////////////////





////////



//------------------------------------------------------------------------------------------------------------------------

	



//==============================================================================================================================================



	//------------------------------------------------------------------------------------------------------------------------

public function check_CustomerAddharold()

{

		$adhar_no  =$this->input->post('adhar_no');

		$isAdharExists=$this->Master_model->get_customer_registration($adhar_no);

		if (count($isAdharExists))

			echo 0;

		else{

			echo 1 ;

		}

}

public function check_CustomerAddhar()

{
		$this->load->model('Manual_dredging/Master_model');	
		$adhar_no  =$this->security->xss_clean(html_escape($this->input->post('adhar_no')));

		

		$isAdharExists=$this->Master_model->get_customer_registration($adhar_no);

		if (count($isAdharExists)==0)

		{

			

			$isAdharExistOld=$this->Master_model->get_customer_registrationOld($adhar_no); 

			if (count($isAdharExistOld)==0)

			{

			echo 0;

			}

			else

			{

			

			

				$data['isAdharExistOld']=$isAdharExistOld;

				$data = $data + $this->data;

	

				$array_perm_postoff_id=$this->Master_model->get_postoffice_details();

				$data['array_perm_postoff_id']=$array_perm_postoff_id;

				$data = $data + $this->data;

			

				$array_perm_dist_id=$this->Master_model->get_district_details();

				$data['array_perm_dist_id']=$array_perm_dist_id;

				$data = $data + $this->data;

			

				$array_localbody=$this->Master_model->get_localbody_details();

				$data['array_localbody']=$array_localbody;

				$data = $data + $this->data;

			

				$array_customer_pur=$this->Master_model->get_customer_purpose_details();

				$data['array_customer_pur']=$array_customer_pur;

				$data = $data + $this->data;

			

			

			

				$array_portmaster=$this->Master_model->get_port_master_details();

				$data['array_portmaster']=$array_portmaster;

				$data = $data + $this->data;

				$this->load->view('Manual_dredging/Master/customerregistration_addAjax',$data);

			//echo 1;

			}

		}

		else

		{

			echo 1;

		} 

}

public function check_CustomerAddharoldoct20()

{

		$adhar_no  =$this->input->post('adhar_no');

		

		$isAdharExists=$this->Master_model->get_customer_registration($adhar_no);

		if (count($isAdharExists)==0)

		{

			

			$isAdharExistOld=$this->Master_model->get_customer_registrationOld($adhar_no); 

			if (count($isAdharExistOld)==0)

			{

			echo 0;

			}

			else

			{

			

			

				$data['isAdharExistOld']=$isAdharExistOld;

				$data = $data + $this->data;

	

				$array_perm_postoff_id=$this->Master_model->get_postoffice_details();

				$data['array_perm_postoff_id']=$array_perm_postoff_id;

				$data = $data + $this->data;

			

				$array_perm_dist_id=$this->Master_model->get_district_details();

				$data['array_perm_dist_id']=$array_perm_dist_id;

				$data = $data + $this->data;

			

				$array_localbody=$this->Master_model->get_localbody_details();

				$data['array_localbody']=$array_localbody;

				$data = $data + $this->data;

			

				$array_customer_pur=$this->Master_model->get_customer_purpose_details();

				$data['array_customer_pur']=$array_customer_pur;

				$data = $data + $this->data;

			

			

			

				$array_portmaster=$this->Master_model->get_port_master_details();

				$data['array_portmaster']=$array_portmaster;

				$data = $data + $this->data;

				$this->load->view('Manual_dredging/Master/customerregistration_addAjax',$data);

			//echo 1;

			}

		}

		else{echo 1;}

}

//----------------------------------------------------------------------------------------------------------

public function getPanchayathAjaxcustomerperm()

{

	$this->load->model('Manual_dredging/Master_model');	

	$dis_id=$this->security->xss_clean(html_escape($this->input->post('customer_perm_distid')));

	$panchayath=$this->Master_model->get_panchayath($dis_id);

	$data['panchayath']=$panchayath;

	$data = $data + $this->data;

	$postoffice=$this->Master_model->get_postoffice_details_reg($dis_id);

	$data['postoffice']=$postoffice;

	$data = $data + $this->data;

	$this->load->view('Manual_dredging/Master/getpanchayathpostoffice', $data);

}

public function getPanchayathAjaxcustomerwork()

{

	$this->load->model('Manual_dredging/Master_model');	

	$dis_id=$this->security->xss_clean(html_escape($this->input->post('customerwork_distid')));

	$panchayath=$this->Master_model->get_panchayath($dis_id);

	$data['panchayath']=$panchayath;

	$postoffice=$this->Master_model->get_postoffice_details_reg($dis_id);

	$data['postoffice']=$postoffice;

	$data = $data + $this->data;

	$this->load->view('Manual_dredging/Master/getpanchayathwork', $data);

}

//==============================================================================================================================================

 private function set_upload_optionsold($i,$adhar)

{   

    //upload an image options

    $config = array();

		$config['upload_path'] = './upload/'; /* NB! create this dir! */

      $config['allowed_types'] = 'jpg|jpeg|pdf';

      $config['max_size']  = '0';

      $config['max_width']  = '0';

      $config['max_height']  = '0';

      $config['overwrite']     = FALSE;

	if($i==0){$config['file_name'] =$adhar;}else{$config['file_name'] =$adhar."per_".$i;}

    return $config;

}

 private function set_upload_options($i,$adhar)

{   

    //upload an image options

    $config = array();

		$config['upload_path'] = './upload/'; /* NB! create this dir! */

      $config['allowed_types'] = 'jpg|jpeg|pdf';

      $config['max_size']  = '200';

      $config['max_width']  = '0';

      $config['max_height']  = '0';

      $config['overwrite']     = FALSE;

	if($i==0){$config['file_name'] =$adhar;}else{$config['file_name'] =$adhar."per_".$i;}
		echo "--------";print_r($config);
    return $config;

}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function customerregistration_add()

    {

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;    

						

			$this->load->model('Manual_dredging/Master_model');	

			$array_perm_postoff_id=$this->Master_model->get_postoffice_details();

			$data['array_perm_postoff_id']=$array_perm_postoff_id;

			$data = $data + $this->data;

			

			$array_perm_dist_id=$this->Master_model->get_district_details();

			$data['array_perm_dist_id']=$array_perm_dist_id;

			$data = $data + $this->data;

			

			$array_localbody=$this->Master_model->get_localbody_details();

			$data['array_localbody']=$array_localbody;

			$data = $data + $this->data;

			

			$array_customer_pur=$this->Master_model->get_customer_purpose_details();

			$data['array_customer_pur']=$array_customer_pur;

			$data = $data + $this->data;

			

			

			

			$array_portmaster=$this->Master_model->get_port_master_details();

			$data['array_portmaster']=$array_portmaster;

			$data = $data + $this->data;

			

			//$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			//	$data['user_header']=	$u_h_dat;

			//	$data 				= 	$data + $this->data;

				//$this->load->view('template/header');
//$this->load->view('Kiv_views/template/dash-header');
//$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Kiv_views/Registration/header_reg.php');
			$this->load->view('Manual_dredging/Master/customerregistration_add', $data);
			//$this->load->view('Kiv_views/Registration/footer_reg.php'); 
//$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			

			

			if($this->input->post())

			{

				$adr_no=$this->security->xss_clean(html_escape($this->input->post('customer_aadhar_number')));

				$rd=$this->db->query("select customer_registration_id from  customer_registration where customer_aadhar_number='$adr_no' and customer_request_status!=3");

				$r_data=$rd->result_array();

				if(count($r_data)>0)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Adhaar already exist!!!</div>');

					redirect('Manual_dredging/Master/customerregistration_add');

				}

				$phone_no  =$this->security->xss_clean(html_escape($this->input->post('customer_phone_number')));

		

		$isphoneExists=$this->Master_model->get_customer_registration_ph($phone_no);

		if (count($isphoneExists)>0)

		{

			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Phone number exist!!!</div>');

					redirect('Manual_dredging/Master/customerregistration_add');

		}

				

				$this->form_validation->set_rules('customer_aadhar_number', 'Aadhar Number', 'required');

				$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');

				$this->form_validation->set_rules('customer_phone_number', 'Phone Number', 'required');

				$this->form_validation->set_rules('customer_perm_house_number', 'House Number', 'required');

				$this->form_validation->set_rules('customer_perm_house_name', 'House Name', 'required');

				$this->form_validation->set_rules('customer_perm_place', 'Place', 'required');

				$this->form_validation->set_rules('customer_perm_post_office', 'Post Office', 'required');

				$this->form_validation->set_rules('customer_perm_pin_code', 'Pin Code', 'required');

				$this->form_validation->set_rules('customer_perm_district_id', 'District Name', 'required');

				$this->form_validation->set_rules('customer_perm_lsg_id', 'Zone Name', 'required');

				$this->form_validation->set_rules('customer_work_house_name', 'Panchayath', 'required');

				$this->form_validation->set_rules('customer_work_place', 'Work Place', 'required');

				$this->form_validation->set_rules('customer_work_post_office', 'Work Post Office', 'required');

				$this->form_validation->set_rules('customer_work_pin_code', 'Work Pin Code', 'required');

				$this->form_validation->set_rules('customer_work_district_id', 'Work Zone Code', 'required');

				$this->form_validation->set_rules('customer_work_lsg_id', 'Work Panchayath', 'required');

				$this->form_validation->set_rules('customer_purpose', 'Purpose', 'required');

				

				$this->form_validation->set_rules('customer_max_allotted_ton', 'Max.Required Ton', 'required');

				$this->form_validation->set_rules('customer_permit_number', 'Permit Number', 'required');

				$this->form_validation->set_rules('customer_permit_date', 'Permit Date', 'required');

				$this->form_validation->set_rules('customer_permit_authority', 'Permit Authority', 'required');

				$this->form_validation->set_rules('customer_worksite_route', 'Worksite Route', 'required');

				$this->form_validation->set_rules('customer_worksite_distance', 'Worksite Distance', 'required|numeric');

				

				$this->form_validation->set_rules('customer_port_id', 'Select Port', 'required');

				if (empty($_FILES['userfile']['name']))

				{

   					 $this->form_validation->set_rules('userfile', 'Document', 'required');

				}

				if (empty($_FILES['userfile']['name']))

				{

   					 $this->form_validation->set_rules('userfile', 'Document', 'required');

				}

				if($this->security->xss_clean(html_escape($this->input->post('customer_purpose')))==1)

				{

				$this->form_validation->set_rules('customer_plinth_area', 'Plinth Area', 'required');

				}

				if($this->form_validation->run() == FALSE)

				{

					echo validation_errors();

				}

				else

				{

					

			//echo "sdsdsd";break;

//--------------------------------------------------------------------upload files------------------------------
					$this->load->model('Manual_dredging/Master_model');	

	$portid=$this->security->xss_clean(html_escape($this->input->post('customer_port_id')));

			$portcode=$this->Master_model->get_portcode($portid);

			$port_code=$portcode[0]['vchr_officecode'];

			$number = substr(uniqid(md5(time()* rand()), true),0,6);

			//$number=rand(000001,999999);

			$year=date("y");

			

			//-----------------------

			$customerregno=$port_code."_".$number."_".$year;

			

			//-----------------------

      

     		$this->load->library('upload', $config);

 	 	$dataInfo = array();
 	 	//print_r($_FILES);

		$cpt = count($_FILES['userfile']['name']);

    	$files = $_FILES;

   

      for($i = 0; $i <$cpt; $i++) 

	  {

	

         $_FILES['userfile']['name']= $files['userfile']['name'][$i];

		

        $_FILES['userfile']['type']= $files['userfile']['type'][$i];

        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];

        $_FILES['userfile']['error']= $files['userfile']['error'][$i];

        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    

		$config = array();

        $this->upload->initialize($this->set_upload_options($i,$customerregno));

		

		//*************************************************************88888

		//$this->load->library('upload', $config);



        if ( ! $this->upload->do_upload('userfile'))

        {

            $error = array('error' => $this->upload->display_errors());

           // print_r($error);

            $this->load->view('Manual_dredging/Master/customerregistration_add', $error);

        }

        else

        {

           // $data = array('upload_data' => $this->upload->data());

 $dataInfo[] = $this->upload->data();

           // $this->load->view('upload_success', $data);

        }

		//****************************************************************

		

		// $this->load->library('upload',$config);

       // $this->upload->do_upload('userfile');

	 		

      }

	///print_r($dataInfo);

	

	$aadharupload=$dataInfo[0]['file_name'];

	$permitupload=$dataInfo[1]['file_name'];

	

    

		 	//$ip_address=$_SERVER['REMOTE_ADDR'];
					if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}

			$currentdate=date('Y-m-d H:i:s');

			

			$customerreg_data=array('customer_aadhar_number'=>$this->security->xss_clean(html_escape($this->input->post('customer_aadhar_number'))),

			'customer_name'=>$this->security->xss_clean(html_escape($this->input->post('customer_name'))),

			'customer_phone_number'=>$this->security->xss_clean(html_escape($this->input->post('customer_phone_number'))),

			'customer_email_id'=>$this->security->xss_clean(html_escape($this->input->post('customer_email'))),

			'customer_perm_house_number'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_house_number'))),

			'customer_perm_house_name'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_house_name'))),

			'customer_perm_house_place'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_place'))),

			'customer_perm_post_office'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_post_office'))),

			'customer_perm_pin_code'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_pin_code'))),

			'customer_perm_district_id'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_district_id'))),

			'customer_perm_lsg_id'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_lsg_id'))),

			'customer_work_house_name'=>$this->security->xss_clean(html_escape($this->input->post('customer_work_house_name'))),

			'customer_work_house_place'=> $this->security->xss_clean(html_escape($this->input->post('customer_work_place'))),

			'customer_work_post_office'=>$this->security->xss_clean(html_escape($this->input->post('customer_work_post_office'))),

			'customer_work_pin_code'=> $this->security->xss_clean(html_escape($this->input->post('customer_work_pin_code'))),

			'customer_work_district_id'=>$this->security->xss_clean(html_escape($this->input->post('customer_work_district_id'))),

			'customer_work_lsg_id'=>$this->security->xss_clean(html_escape($this->input->post('customer_work_lsg_id'))),

			'customer_purpose'=>$this->security->xss_clean(html_escape($this->input->post('customer_purpose'))),

			'customer_plinth_area'=>$this->security->xss_clean(html_escape($this->input->post('customer_plinth_area'))),

			'customer_requested_ton'=>$this->security->xss_clean(html_escape( $this->input->post('customer_max_allotted_ton'))),

			'customer_max_allotted_ton'=>$this->security->xss_clean(html_escape( $this->input->post('customer_max_allotted_ton'))),

			'customer_permit_number'=>$this->security->xss_clean(html_escape($this->input->post('customer_permit_number'))),

			'customer_permit_date'=> date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('customer_permit_date')))),

			'customer_permit_authority'=>$this->security->xss_clean(html_escape($this->input->post('customer_permit_authority'))),

			'customer_worksite_route'=>$this->security->xss_clean(html_escape($this->input->post('customer_worksite_route'))),

			'customer_worksite_distance'=>$this->security->xss_clean(html_escape($this->input->post('customer_worksite_distance'))),

			'customer_unloading_place'=>$this->security->xss_clean(html_escape($this->input->post('customer_unloading_place'))),

			'customer_public_user_id'=>'',

			'customer_ip_address'=>$ip_address,

			'customer_registration_timestamp'=>$currentdate,

			'customer_decission_user_id'=>'',

			'customer_decission_timestamp'=>'',

			'customer_request_status'=>1,

			'customer_used_ton'=>'',

			'customer_unused_ton'=>'',

			'customer_number_pass'=>'',

			'customer_allotted_ton'=>'',

			'customer_blocked_once'=>'',

			'customer_blocked_status'=>'',

			'port_id'=>$portid,

			'customer_reg_no'=>$customerregno,

			'aadhar_uploadname'=>$aadharupload,

			'permit_uploadname'=>$permitupload);

		
				//print_r($customerreg_data);exit();

				

				 $insert_customer_reg	=	$this->db->insert('customer_registration', $customerreg_data);

					 $customerreg_insert_id 					= 	$this->db->insert_id();

				if($insert_customer_reg==1)

				{

					

					//$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Customer Registration successfully</div>');

				redirect('Manual_dredging/Master/customerregistration_message/'.encode_url($customerreg_insert_id));

				}	

				else

				{

				//$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Customer Registration failed!!!</div>');

			redirect('Manual_dredging/Master/customerregistration_message/'.encode_url($customerreg_insert_id));

				}

			}//validation

		}

	

    }

	//---------------------------------------------------------------------------------------------



public function customerregistration_addold2409()

    {

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;    

						

			$this->load->model('Manual_dredging/Master_model');	

			$array_perm_postoff_id=$this->Master_model->get_postoffice_details();

			$data['array_perm_postoff_id']=$array_perm_postoff_id;

			$data = $data + $this->data;

			

			$array_perm_dist_id=$this->Master_model->get_district_details();

			$data['array_perm_dist_id']=$array_perm_dist_id;

			$data = $data + $this->data;

			

			$array_localbody=$this->Master_model->get_localbody_details();

			$data['array_localbody']=$array_localbody;

			$data = $data + $this->data;

			

			$array_customer_pur=$this->Master_model->get_customer_purpose_details();

			$data['array_customer_pur']=$array_customer_pur;

			$data = $data + $this->data;
		
			$array_portmaster=$this->Master_model->get_port_master_details();

			$data['array_portmaster']=$array_portmaster;

			$data = $data + $this->data;

			

				//$this->load->view('template/header');
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/customerregistration_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			

			

			if($this->input->post())

			{

			

				$this->form_validation->set_rules('customer_aadhar_number', 'Aadhar Number', 'required');

				$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');

				$this->form_validation->set_rules('customer_phone_number', 'Phone Number', 'required');

				$this->form_validation->set_rules('customer_email', 'E-mail ID', 'required');

				$this->form_validation->set_rules('customer_perm_house_number', 'House Number', 'required');

				$this->form_validation->set_rules('customer_perm_house_name', 'House Name', 'required');

				$this->form_validation->set_rules('customer_perm_place', 'Place', 'required');

				$this->form_validation->set_rules('customer_perm_post_office', 'Post Office', 'required');

				$this->form_validation->set_rules('customer_perm_pin_code', 'Pin Code', 'required');

				$this->form_validation->set_rules('customer_perm_district_id', 'District Name', 'required');

				$this->form_validation->set_rules('customer_perm_lsg_id', 'Zone Name', 'required');

				$this->form_validation->set_rules('customer_work_house_name', 'Panchayath', 'required');

				$this->form_validation->set_rules('customer_work_place', 'Work Place', 'required');

				$this->form_validation->set_rules('customer_work_post_office', 'Work Post Office', 'required');

				$this->form_validation->set_rules('customer_work_pin_code', 'Work Pin Code', 'required');

				$this->form_validation->set_rules('customer_work_district_id', 'Work Zone Code', 'required');

				$this->form_validation->set_rules('customer_work_lsg_id', 'Work Panchayath', 'required');

				$this->form_validation->set_rules('customer_purpose', 'Purpose', 'required');

			

				$this->form_validation->set_rules('customer_max_allotted_ton', 'Max.Required Ton', 'required');

				$this->form_validation->set_rules('customer_permit_number', 'Permit Number', 'required');

				$this->form_validation->set_rules('customer_permit_date', 'Permit Date', 'required');

				$this->form_validation->set_rules('customer_permit_authority', 'Permit Authority', 'required');

				$this->form_validation->set_rules('customer_worksite_route', 'Worksite Route', 'required');

				$this->form_validation->set_rules('customer_worksite_distance', 'Worksite Distance', 'required|numeric');

				

				$this->form_validation->set_rules('customer_port_id', 'Select Port', 'required');

				if (empty($_FILES['userfile']['name']))

				{

   					 $this->form_validation->set_rules('userfile', 'Document', 'required');

				}

				if (empty($_FILES['userfile']['name']))

				{

   					 $this->form_validation->set_rules('userfile', 'Document', 'required');

				}

				if($this->input->post('customer_purpose')==1)

				{

				$this->form_validation->set_rules('customer_plinth_area', 'Plinth Area', 'required');

				}

				if($this->form_validation->run() == FALSE)

				{

					echo validation_errors();

				}

				else

				{

					

			//echo "sdsdsd";break;

//--------------------------------------------------------------------upload files------------------------------

	//$adhar=$this->input->post('customer_aadhar_number');

			$portid=$this->input->post('customer_port_id');

			$portcode=$this->Master_model->get_portcode($portid);

			$port_code=$portcode[0]['vchr_officecode'];

			$number=rand(000001,999999);

			$year=date("y");

			

			//-----------------------

			$customerregno=$port_code."_".$number."_".$year;

			

			//-----------------------

      

      $this->load->library('upload');

 	 	$dataInfo = array();

		$cpt = count($_FILES['userfile']['name']);

    	$files = $_FILES;

   

      for($i = 0; $i <$cpt; $i++) 

	  {

	

         $_FILES['userfile']['name']= $files['userfile']['name'][$i];

		

        $_FILES['userfile']['type']= $files['userfile']['type'][$i];

        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];

        $_FILES['userfile']['error']= $files['userfile']['error'][$i];

        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    

		$config = array();

        $this->upload->initialize($this->set_upload_options($i,$customerregno));

		 $this->load->library('upload',$config);

        $this->upload->do_upload('userfile');

	 

        $dataInfo[] = $this->upload->data();

		

      }

	//print_r($dataInfo);

	

	$aadharupload=$dataInfo[0]['file_name'];

	$permitupload=$dataInfo[1]['file_name'];

	

    

		 	//$ip_address=$_SERVER['REMOTE_ADDR'];
					if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}

			$currentdate=date('Y-m-d H:i:s');

			

			$customerreg_data=array('customer_aadhar_number'=>$this->input->post('customer_aadhar_number'),

			'customer_name'=>$this->input->post('customer_name'),

			'customer_phone_number'=>$this->input->post('customer_phone_number'),

			'customer_email_id'=>$this->input->post('customer_email'),

			'customer_perm_house_number'=>$this->input->post('customer_perm_house_number'),

			'customer_perm_house_name'=>$this->input->post('customer_perm_house_name'),

			'customer_perm_house_place'=>$this->input->post('customer_perm_place'),

			'customer_perm_post_office'=>$this->input->post('customer_perm_post_office'),

			'customer_perm_pin_code'=>$this->input->post('customer_perm_pin_code'),

			'customer_perm_district_id'=>$this->input->post('customer_perm_district_id'),

			'customer_perm_lsg_id'=>$this->input->post('customer_perm_lsg_id'),

			'customer_work_house_name'=>$this->input->post('customer_work_house_name'),

			'customer_work_house_place'=> $this->input->post('customer_work_place'),

			'customer_work_post_office'=>$this->input->post('customer_work_post_office'),

			'customer_work_pin_code'=> $this->input->post('customer_work_pin_code'),

			'customer_work_district_id'=>$this->input->post('customer_work_district_id'),

			'customer_work_lsg_id'=>$this->input->post('customer_work_lsg_id'),

			'customer_purpose'=>$this->input->post('customer_purpose'),

			'customer_plinth_area'=>$this->input->post('customer_plinth_area'),

			'customer_max_allotted_ton'=> $this->input->post('customer_max_allotted_ton'),

			'customer_permit_number'=>$this->input->post('customer_permit_number'),

			'customer_permit_date'=> date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('customer_permit_date')))),

			'customer_permit_authority'=>$this->input->post('customer_permit_authority'),

			'customer_worksite_route'=>$this->input->post('customer_worksite_route'),

			'customer_worksite_distance'=>$this->input->post('customer_worksite_distance'),

			'customer_unloading_place'=>$this->input->post('customer_unloading_place'),

			'customer_public_user_id'=>'',

			'customer_ip_address'=>$ip_address,

			'customer_registration_timestamp'=>$currentdate,

			'customer_decission_user_id'=>'',

			'customer_decission_timestamp'=>'',

			'customer_request_status'=>1,

			'customer_used_ton'=>'',

			'customer_unused_ton'=>'',

			'customer_number_pass'=>'',

			'customer_allotted_ton'=>'',

			'customer_blocked_once'=>'',

			'customer_blocked_status'=>'',

			'port_id'=>$portid,

			'customer_reg_no'=>$customerregno,

			'aadhar_uploadname'=>$aadharupload,

			'permit_uploadname'=>$permitupload);

		

				
				 $insert_customer_reg	=	$this->db->insert('customer_registration', $customerreg_data);

					 $customerreg_insert_id 					= 	$this->db->insert_id();

				if($insert_customer_reg==1)

				{

					

					//$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Customer Registration successfully</div>');

													redirect('Manual_dredging/Master/customerregistration_message/'.encode_url($customerreg_insert_id));

				}	

				else

				{

				//$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Customer Registration failed!!!</div>');

													redirect('Manual_dredging/Master/customerregistration_message/'.encode_url($customerreg_insert_id));

				}

			}//validation

		}

	

    }

	

	public function customerregistration_message()

	{

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);		

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

		$getcustomerreg_message=$this->Master_model->customer_registration_msg($id);

		$data['getcustomerreg_message']=$getcustomerreg_message;

			$data = $data + $this->data;

			$this->load->view('Kiv_views/Registration/header_reg.php');

			$this->load->view('Manual_dredging/Master/customerregistration_message',$data);
			$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			

	}

	//------------------------------------------------------------------------------------------------------------------------

public function getPermPincode()

{

	$this->load->model('Manual_dredging/Master_model');	

	

	$postoffice_id=$this->security->xss_clean(html_escape($this->input->post('custmer_perm_postoff')));

	$getpincode_data=$this->Master_model->get_pincode($postoffice_id);

	

	$data['getpincode_data']=$getpincode_data;

	$this->load->view('Manual_dredging/Master/getPermPincode', $data);

}

//-----------------------------------------------------------------------------

public function getWorkPincode()

{

	$this->load->model('Manual_dredging/Master_model');	

	$postoffice_id=$this->security->xss_clean(html_escape($this->input->post('customerwork_post_office')));

	$getpincode_data=$this->Master_model->get_pincode($postoffice_id);

	$data['getpincode_data']=$getpincode_data;

	

	$this->load->view('Manual_dredging/Master/getWorkPincode', $data);

	

}

//-----------------------------------------------------------------------------

public function Checkallotedton()

{

	$this->load->model('Manual_dredging/Master_model');	

	$requested_ton=$this->security->xss_clean(html_escape($this->input->post('requestedton')));

	$master_id=$this->security->xss_clean(html_escape($this->input->post('construct_masterid')));

	$getdata=$this->Master_model->get_construction_master_ByID($master_id);

	$data['getdata']=$getdata;//print_r($getdata);

	$this->load->view('Manual_dredging/Master/checkresult', $data);

}



//--------------------------------------------------------------------------------------------------------------------------------------------

	public function customerregistration_view()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		

		if(!empty($sess_usr_id))

		{	

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);

			

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;    

			

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			//$user_id			=	$userinfo[0]['user_master_port_id']; 

			$customerreg_details= $this->Master_model->getcustomerregdetails($id,$port_id);

			$data['customerreg_details']=$customerreg_details;

			$data = $data + $this->data;

			

			$array_perm_postoff_id=$this->Master_model->get_postoffice_details();

			$data['array_perm_postoff_id']=$array_perm_postoff_id;

			$data = $data + $this->data;

			

			$array_perm_dist_id=$this->Master_model->get_district_details();

			$data['array_perm_dist_id']=$array_perm_dist_id;

			$data = $data + $this->data;

			

			$array_permlocalbody=$this->Master_model->get_localbody_details();

			$data['array_permlocalbody']=$array_permlocalbody;

			$data = $data + $this->data;

			$array_perm_postoff_id=$this->Master_model->get_postoffice_details();

			$data['array_work_postoff_id']=$array_perm_postoff_id;

			$data = $data + $this->data;

			

			$array_perm_dist_id=$this->Master_model->get_district_details();

			$data['array_work_dist_id']=$array_perm_dist_id;

			$data = $data + $this->data;

			

			$array_localbody=$this->Master_model->get_localbody_details();

			$data['array_worklocalbody']=$array_localbody;

			$data = $data + $this->data;

			

			$array_customer_pur=$this->Master_model->get_customer_purpose_details();

			$data['array_customer_pur']=$array_customer_pur;

			$data = $data + $this->data;

			

			/*$array_permit_authority=$this->Master_model->get_permit_authority_details();

			$data['array_permit_authority']=$array_permit_authority;

			$data = $data + $this->data;*/

			

			$array_portmaster=$this->Master_model->get_port_master_details();

			//print_r($array_portmaster);break;

			$data['array_portmaster']=$array_portmaster;

			$data = $data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			if($this->input->post())

			{

//print_r($this->input->post());exit;

			$customername=$this->security->xss_clean(html_escape($this->input->post('customer_name')));

			$customerpurpose=$this->security->xss_clean(html_escape($this->input->post('customer_purpose')));

			$plintharea=$this->security->xss_clean(html_escape($this->input->post('customer_plinth_area')));

			$maxallotton=$this->security->xss_clean(html_escape($this->input->post('customer_max_allotted_ton')));

			$radiorequest_status=$this->security->xss_clean(html_escape($this->input->post('radioRequestStatus')));

			if(!isset($radiorequest_status))

			{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">please select approve or reject option!!</div>');					
						redirect('Manual_dredging/Master/customer_requestprocessing');

			}

			$txtremarks=$this->security->xss_clean(html_escape($this->input->post('txtremarks')));

			$customerreg_id=$this->security->xss_clean(html_escape($this->input->post('hid_custid')));

			$portid=$this->security->xss_clean(html_escape($this->input->post('customer_port_id')));

			$currentdate=date('Y-m-d H:i:s');

		

			if($radiorequest_status==2)

			{

			if($customerpurpose==2){$plintharea=0;}else{$plintharea=$plintharea;}

				

				

				$Ins_usermaster_data=array(

				'user_master_name'			=>	$customerreg_id,

				'user_master_password'		=>	'xxx',

				'user_master_fullname'		=>	$customername,

				'user_master_id_user_type'	=>	5,

				'user_master_port_id'		=>	$portid,

				'user_master_zone_id'		=>	0,

				'user_master_lsg_id'		=>	0,

				'user_master_lsg_section_id'=>	0,

				'user_master_timestamp'		=>	$currentdate,

				'user_master_status'		=>	1,

				'user_master_user_id'		=>	$sess_usr_id);

 $usermaster_insert_id			=	$this->Master_model->insert_usermaster($Ins_usermaster_data);

 $x_data=$this->db->query("select user_master_id from user_master where user_master_name='$customerreg_id'");

 $xd_data=$x_data->result_array();

 $usermaster_insert_id=$xd_data[0]['user_master_id'];

 

 //print_r( $usermaster_insert_id);exit;

				

				// $insert_usermaster			=	$this->db->insert('user_master', $Ins_usermaster_data);

				// $usermaster_insert_id 					= 	$this->db->insert_id();

					$request_data=array(

				'customer_decission_user_id'	=>	$sess_usr_id,

				'customer_decission_timestamp'	=>	$currentdate,

				'customer_plinth_area'			=>	$plintharea,

				'customer_max_allotted_ton'		=>	$maxallotton,

				'customer_request_status'		=>	$radiorequest_status,

				'customer_unused_ton'			=>	$maxallotton,

				'customer_public_user_id'		=>	$usermaster_insert_id,

				'customer_registration_remarks'	=>	$txtremarks);	

			}

			else 

			{

			$request_data=array(

				'customer_decission_user_id'	=>	$sess_usr_id,

				'customer_decission_timestamp'	=>	$currentdate,

				'customer_request_status'		=>	$radiorequest_status,

				'customer_registration_remarks'	=>	$txtremarks);

			}

				

				$result=$this->Master_model->update_customerregistration($request_data,$customerreg_id);

				if($result==1)

				{

					if($radiorequest_status==2)

					{

						//  New Code For Message

						

						$customerregupt_data= $this->Master_model->getcustomerregdetails($customerreg_id,$port_id);

						$p_id=$customerregupt_data[0]['port_id'];

						$pub_user_id=$customerregupt_data[0]['customer_public_user_id'];

						$cus_phone=$customerregupt_data[0]['customer_phone_number'];

						$cus_reg_idfp=$customerregupt_data[0]['customer_registration_id']+1;

						$portcode=$this->Master_model->get_portcode($p_id);

						$port_code=$portcode[0]['vchr_officecode'];

						$year=date('y');

						$user_name=$year.$port_code.$cus_reg_idfp;

						//exit;

						

						$random_pass=substr(number_format(time() * rand() * $cus_reg_idfp,0,'',''),0,5);

						$passwordnew=$year.$port_code.$random_pass;//----------set on 21/05/18

						$password=$this->phpass->hash($passwordnew);

						$Ins_usermaster_data=array(

						'user_master_name'			=>	$user_name,

						'user_master_password'		=>	$password,

						);

						

				$insert_usermaster=$this->db->query("update user_master set user_master_name='$user_name',user_master_password='$password' where user_master_id='$pub_user_id'");

						/* $usermaster_insert_id 					= 	$this->db->insert_id();

						 */
						//$xab='"';
						//$msg="Portinfo 2 - Your Port Registration Approved successfully,Please note the login details and change it on first login.Username ".$xab.$user_name.$xab."Password ".$xab.$passwordnew.$xab;

				 $msg="Your Port Registration Approved successfully,Please note the login details and change it on first login.%0aUsername ".$user_name."%0aPassword  ".$passwordnew;

		

						$this->sendSms($msg,$cus_phone);

						

						//

						

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processed successfully</div>');

													redirect('Manual_dredging/Master/customer_requestprocessing');

													

					}

					else

					{

						$customerregupt_data= $this->Master_model->getcustomerregdetails($customerreg_id,$port_id);

						$cus_remark=$customerregupt_data[0]['customer_registration_remarks'];

						

						//$p_id=$customerregupt_data[0]['port_id'];

						//$pub_user_id=$customerregupt_data[0]['customer_public_user_id'];

						$cus_phone=$customerregupt_data[0]['customer_phone_number'];
						//$xab='"';
						//$msgnew="Portinfo 2 - Your Port Registration has been rejected by Port Conservator due to ".$xab.$cus_remark."'' you can register again with correct data.";

						$msgnew="Your Port Registration has been rejected by Port Conservator due to ".$cus_remark." you can register again with correct data";

						$this->sendSms($msgnew,$cus_phone);

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processing Rejected</div>');				
						redirect('Manual_dredging/Master/customer_requestprocessing');

					}

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');

													redirect('Manual_dredging/Master/customer_requestprocessing');

				}

				

			}

			$this->load->view('Manual_dredging/Master/customerregistration_view', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



    }

	//--------------------------------------------------------------------------------------------------------------------

function customer_requestprocessing_add()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		

		if(!empty($sess_usr_id))

		{	

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);

			$this->load->model('Manual_dredging/Master_model');	

			$data = array('title' => 'Add customer requestprocessing', 'page' => 'Add customer requestprocessing', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];

			$customerreg_data= $this->Master_model->get_customer_reg_details($id,$port_id);

			

			

			//print_r($customerreg_details);

			$data['customerreg_data']=$customerreg_data;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			

			

			if($this->input->post())

			{

			

			

			$radiorequest_status=$this->security->xss_clean(html_escape($this->input->post('radioRequestStatus')));

			$txtremarks=$this->security->xss_clean(html_escape($this->input->post('txtremarks')));

			$customerreg_id=$this->security->xss_clean(html_escape($this->input->post('hid_custid')));

			$currentdate=date('Y-m-d H:i:s');

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];

			$customerregupt_data= $this->Master_model->get_customer_reg_details($customerreg_id,$port_id);

			foreach($customerregupt_data as $rowcustomer)

			{

			 $customerid=$rowcustomer['customer_registration_id']; 

			 $customername=$rowcustomer['customer_name'];

			 $portid=$rowcustomer['port_id'];

			 $maxallotton=$rowcustomer['customer_max_allotted_ton'];

			}

			

			



			if($radiorequest_status==2)

			{



			

				$p_id=$customerregupt_data[0]['port_id'];

				$pub_user_id=$customerregupt_data[0]['customer_public_user_id'];

				$cus_phone=$customerregupt_data[0]['customer_phone_number'];

				$cus_reg_idfp=$customerregupt_data[0]['customer_registration_id']+1;

				$portcode=$this->Master_model->get_portcode($p_id);

				$port_code=$portcode[0]['vchr_officecode'];

				$year=date('y');

				$user_name=$year.$port_code.$cus_reg_idfp;

				$password=$this->phpass->hash($year.$port_code.$cus_reg_idfp);

				$Ins_usermaster_data=array(

				'user_master_name'			=>	$user_name,

				'user_master_password'		=>	$password,

				);

				

			$insert_usermaster=$this->db->query("update user_master set user_master_name='$user_name',user_master_password='$password' where user_master_id='$pub_user_id'");

				/* $usermaster_insert_id 					= 	$this->db->insert_id();

				 */
				//$xab='"';
					//	$msg="Portinfo 2 - Your Port Registration Approved successfully,Please note the login details and change it on first login.Username ".$xab.$user_name.$xab."Password ".$xab.$user_name.$xab;

		 $msg="Your Port Registration Approved successfully,Please note the login details and change it on first login.%0aUsername ".$user_name."%0aPassword  ".$user_name;



				$this->sendSms($msg,$cus_phone);

					$request_data=array(

				'customer_decission_user_id'	=>	$sess_usr_id,

				'customer_decission_timestamp'	=>	$currentdate,

				'customer_request_status'		=>	$radiorequest_status,

				'customer_unused_ton'			=>	$maxallotton,

				//'customer_public_user_id'		=>	 $usermaster_insert_id,

				'customer_registration_remarks'	=>	$txtremarks);	

			}

			else 

			{

			$request_data=array(

				'customer_decission_user_id'	=>	$sess_usr_id,

				'customer_decission_timestamp'	=>	$currentdate,

				'customer_request_status'		=>	$radiorequest_status,

				'customer_registration_remarks'	=>	$txtremarks);

			}

				

				$result=$this->Master_model->update_customerregistration($request_data,$customerreg_id);

				if($result==1)

				{

					if($radiorequest_status==2)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processed successfully</div>');

													redirect('Manual_dredging/Master/customer_login_add/'.encode_url($customerreg_id));

													

					}

					else

					{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processing Rejected</div>');

													redirect('Manual_dredging/Master/customer_requestprocessing');

					}

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');

													redirect('Manual_dredging/Master/customer_requestprocessing');

				}

				

			}

			$this->load->view('Manual_dredging/Master/customer_requestprocessing_add', $data);

			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

    }

	

	

	//--------------------------------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------------------

	public function sand_issue()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$this->load->model('Manual_dredging/Master_model');	

			

			 

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			if($this->input->post())

			{

			

				$this->form_validation->set_rules('txttokenno', 'Token No ', 'required');

				$this->form_validation->set_rules('txtaadharno', 'Aadhaar No', 'required');

				

				

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

			

					$tokennumnber=$this->security->xss_clean(html_escape($this->input->post('txttokenno')));

					$aadharnumber=$this->security->xss_clean(html_escape($this->input->post('txtaadharno')));

					$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

					$port_id			=	$userinfo[0]['user_master_port_id'];  

					$zone_id			=	$userinfo[0]['user_master_zone_id'];

					//$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlist($tokennumnber,$aadharnumber,$port_id,$zone_id);

					$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlistnn($tokennumnber,$aadharnumber,$port_id,$zone_id);



					//print_r($get_bookingapprovedlist);break;

					//

					if($get_bookingapprovedlistdata)

					{

					

						$data['get_bookingapprovedlistdata']=$get_bookingapprovedlist;

						$bookingid=$get_bookingapprovedlistdata[0]['customer_booking_id'];

						$booking_id=encode_url($bookingid);

						redirect('Manual_dredging/Master/sand_issue_addmessage/'.$booking_id);

					

					}

					else

					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');

													redirect('Manual_dredging/Master/sand_issue');

					}

			

				}

			

			

		}

			$this->load->view('Manual_dredging/Master/sand_issue', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			//$bk_id_pass=decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$bk_id_pass	=		decode_url($this->uri->segment(4));
			if($bk_id_pass!=0)

			{

				redirect('Manual_dredging/Master/generatepass/'.encode_url($bk_id_pass));

			}

		}	

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

			



    }

//----------------------------------------------------------------------------	

	public function sand_issue_add()

    {

		

		 $sess_usr_id = $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);

			$data = array('title' => 'Add Sand Issue', 'page' => 'sand_issue_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$this->load->model('Manual_dredging/Master_model');

			$get_bookingapprovedadded= $this->Master_model->get_bookingapprovedaddnn($id);

			$data['get_bookingapprovedadded']=$get_bookingapprovedadded;

			//$data = $data + $this->data;

			

			$monthlypermitid=$get_bookingapprovedadded[0]['customer_booking_monthly_permit_id'];

			$permitamount=$this->Master_model->get_monthly_permit_by_id($monthlypermitid);

			$data['permitamount']=$permitamount;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');
			

if($this->input->post())

			{
  
	

			$txtchallanno=$this->security->xss_clean(html_escape($this->input->post('txtchallanno')));

			$txtchallandate=date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('txtchallandate'))));

			$txtchallanamt=$this->security->xss_clean(html_escape($this->input->post('txtchallanamt')));

			$txtvehiclemake=$this->security->xss_clean(html_escape($this->input->post('txtvehiclemake')));

			$txtvehicleregno=$this->security->xss_clean(html_escape($this->input->post('txtvehicleregno')));

			$txtdrivername=$this->security->xss_clean(html_escape($this->input->post('txtdrivername')));

			$txtdrlicenseno=$this->security->xss_clean(html_escape($this->input->post('txtdrlicenseno')));

			$txtdrmobno=$this->security->xss_clean(html_escape($this->input->post('txtdrmobno')));

			$hid_bookingid=$this->security->xss_clean(html_escape($this->input->post('hid_bookingid')));

			

			$currentdate=date('Y-m-d H:i:s');

			//$ip_address				=	$_SERVER['REMOTE_ADDR'];
if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
			

			$update_data=array('customer_booking_pass_issue_user'			=>	$sess_usr_id,

								'customer_booking_pass_issue_timestamp'		=>	$currentdate,

								'customer_booking_vehicle_make'				 =>	$txtvehiclemake,

								'customer_booking_vehicle_registration_number'=>$txtvehicleregno,

								'customer_booking_driver_name'			=>	$txtdrivername,

								'customer_booking_driver_license'		=>	$txtdrlicenseno,

								'customer_booking_blocked_status'		=>0,

							  	'customer_booking_driver_mobile'		=>$txtdrmobno);

		
				$result=$this->Master_model->update_customerbooking($update_data,$hid_bookingid);

				//$get_bookingapprovedadd= $this->Master_model->get_bookingapprovedadd($hid_bookingid);

			$get_bookingapprovedadd= $this->Master_model->get_bookingapprovedaddnn($hid_bookingid);



				foreach($get_bookingapprovedadd as $rowfetch)

				{

				$customer_reg_id	=	$rowfetch['customer_booking_registration_id'];

				$port_id			=	$rowfetch['customer_booking_port_id'];

				$zone_id			=	$rowfetch['customer_booking_zone_id'];

				$lsg_id				=	$rowfetch['customer_booking_lsg_id'];

				$customernumberpass	=	$rowfetch['customer_number_pass'];

				$alotdton			=	$rowfetch['customer_booking_request_ton'];

				$cusused			=	$rowfetch['customer_used_ton'];

				$cusunused			=	$rowfetch['customer_unused_ton'];

				}

				$incrementnumpass=$customernumberpass+1;

				$updatereg_data=array('customer_used_ton'	  => $cusused+$alotdton,

								'customer_unused_ton'		  => $cusunused-$alotdton,

								'customer_blocked_status'	  => 0,

								'customer_number_pass'=> $incrementnumpass);

				

				$this->db->where('customer_registration_id',$customer_reg_id);

				$this->db->where('customer_unused_ton >', 0);

				$worker_res=$this->db->update('customer_registration', $updatereg_data);

//-------------------------------------  Insert to Payment Table    -----------------------------------------------

				$tax=$this->Master_model->get_materials_with_tax();

 				$mat_id=$tax['tax_calculator_materials'];

 				$ma=explode(',',$mat_id);

				$t_rate=$tax['tax_calculator_rate'];

 				$amt_wt=0;

 				$amt_wt1=0;

 				$amt_wt2=0;

				$amt_wt3=0;

 				$amt_wt4=0;

 				$amt_wt5=0;

				$amounttot=0;

 			$material=$this->Master_model->get_material_master_act();

			foreach($material as $mat)

 		 {

	 		$mid=$mat['material_master_id'];

	

		 	if($mat['material_master_authority']==1)

		 	{

			 	if(in_array($mid,$ma))

				 {

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 $amt_wt=$amt_wt+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

				 $amounttot=$amt_wt;

			 }

			 else

			 {

				 $amt_wt1= $amt_wt1+$m_r[0]['materialrate_port_amount'];

				  $amounttot=$amt_wt1;

			 }

		 }

		 else

		 {

			  if(in_array($mid,$ma))

			 {

				 //echo $mat['material_master_id'];

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 //print_r($m_r);

				 if($m_r[0]['materialrate_domain']==2)

				 {

				 	$amt_wt2=$amt_wt2+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

					 $amounttot=$amt_wt2;

				 }

				 else

				 {

					 //echo "ff".$port_id."ff".$mid."ff".$zone_id;

					 $m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

					// print_r($m_rn);

					 $amt_wt3=$amt_wt3+($m_rn[0]['materialrate_port_amount']+$m_rn[0]['materialrate_port_amount']*($t_rate/100));

					 $amounttot=$amt_wt3;

				 }

			 }

			 else

			 {

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 if($m_r[0]['materialrate_domain']==2)

				 {

					// echo "ff";

				 	$amt_wt4=$amt_wt4+$m_r[0]['materialrate_port_amount'];

					$amounttot=$amt_wt4;

				 }

				 else

				 {

					 ///echo "ff";

					 $m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

					// print_r($m_rn);

					 $amt_wt5=$amt_wt5+$m_rn[0]['materialrate_port_amount'];

					 $amounttot=$amt_wt5;

				 }

			 }

		 }

		 $ins_payment_data=array('payment_booking_id'=>$hid_bookingid,

				'payment_customer_id'=>$customer_reg_id,

				'payment_port_id'=>$port_id,

				'payment_zone_id'=>$zone_id,

				'payment_lsg_id'=>$lsg_id,

				'payment_head'=>$mid,

				'payment_amount'=>$amounttot,

				'payment_timestamp'=>$currentdate,

				'payment_status'=>1,

				'payment_user_id'=> $sess_usr_id);

				

				$payment_add=$this->db->insert('payment', $ins_payment_data);

 }

 //-----------------------------------------------------------------------------------------------------------------------

				//$result=$this->Master_model->update_customerregistration($request_data,$customerreg_id);

				if($payment_add==1)

				{

					$this->db->query("update transaction_details set print_status=1 where transaction_customer_booking_id='$hid_bookingid'");

					//	$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Sand Issued successfully</div>');

													//$this->load->library('user_agent');

				redirect('Manual_dredging/Master/vehicle_pass_success/'.encode_url($hid_bookingid));

													//redirect('Master/generatepass/'.encode_url($hid_bookingid));

					

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Sand Issue failed!!!</div>');

													redirect('Manual_dredging/Master/sand_issue');

				}

				

			

			}

			$this->load->view('Manual_dredging/Master/sand_issue_add',$data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

	}

	

	//--------------------------------------------------------------------------------------------------------------------

	public function sand_issue_addmessage()

	{

		/*

			$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------

			$id			=		decode_url($id);		

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

		$get_bookingapprovedadd=$this->Master_model->get_bookingapprovedadd($id);

		//print_r($getcustomerreg_message);break;

		$data['get_bookingapprovedadd']=$get_bookingapprovedadd;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/sandissue_addmessage',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

			*/

			$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id			=		$this->uri->segment(4);
			 $id			=		decode_url($id);		

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

		$get_bookingapprovedadd=$this->Master_model->get_bookingapprovedaddnn($id);

		//print_r($get_bookingapprovedadd);break;

		$data['get_bookingapprovedadd']=$get_bookingapprovedadd;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/sandissue_addmessage',$data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	}



//--------------------------------------------------------------------------------------------------------------------------------------------

	//gopika new

	public function sand_issue_reprint_old()

    {

	

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id)&& ($sess_user_type==6))

	{

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;

		//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

		$this->load->view('Manual_dredging/Master/sand_issue_reprint',$data);
$this->load->view('Kiv_views/template/dash-footer');
		

		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');
*/
		if($this->input->post())

			{

				$this->form_validation->set_rules('txttokenno', 'Token No ', 'required');

				$this->form_validation->set_rules('txtaadharno', 'Aadhaar No', 'required');

				$this->form_validation->set_rules('txtreason', 'Reason', 'required');

				

				

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					$tokenno=$this->input->post('txttokenno');

					$tokenno=$this->security->xss_clean($tokenno);

					$tokenno=html_escape($tokenno);

					$aadhar_no=$this->input->post('txtaadharno');

					$aadhar_no=$this->security->xss_clean($aadhar_no);

					$aadhar_no=html_escape($aadhar_no);

					$reason=$this->input->post('txtreason');

					$currentdate=date('Y-m-d H:i:s');

					$get_datarrequested=$this->Master_model->get_bookingapprovedRPT($tokenno,$aadhar_no);

					$port_id			=	$get_datarrequested[0]['customer_booking_port_id'];

					$zone_id			=	$get_datarrequested[0]['customer_booking_zone_id'];

					$lsg_id				=	$get_datarrequested[0]['customer_booking_lsg_id'];

					$lsg_section_id		=	$get_datarrequested[0]['customer_booking_lsg_section_id'];

					$customer_regn_id	=	$get_datarrequested[0]['customer_booking_registration_id'];

					$customer_booking_id=	$get_datarrequested[0]['customer_booking_id'];

						

					$reprintrequest_data=array(

					'zone_id'=>$zone_id,

					'port_id'=>$port_id,

					'lsg_id'=>$lsg_id,

					'lsg_section_id'=>$lsg_section_id,

					'customer_registration_id'=>$customer_regn_id,

					'customer_booking_id'=>$customer_booking_id,

					'token_no'=>$tokenno,

					'customer_aadhaar_no'=>$aadhar_no,

					'sandreprint_reason'=>$reason,

					'zone_operator_id'=>$sess_usr_id,

					'approved_user_id'=>0,

					'approve_status'=>'',

					'approveddate_timestamp'=>'',

					'requesteddate_timestamp'=>$currentdate,

					'reprint_status'=>1,

					'remarks'	=>'');

					$result=$this->Master_model->add_sandpass_reprint($reprintrequest_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Send Successfully</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintVw');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Send failed!!!</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintVw');

					}

				}

			}

	}

	else

	{

		redirect('Main_login/index');        

  	}      

    }

	public function sand_issue_reprintApprove_old()

    {

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id))

	{

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;

		

		

		$datareprintview=$this->Master_model->get_pass_reprintAPP($port_id);

		$data['datareprintview']=	$datareprintview;

		$data 				= 	$data + $this->data;

		

		//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

		$this->load->view('Manual_dredging/Master/sand_issue_reprintAppVw',$data);
$this->load->view('Kiv_views/template/dash-footer');
		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');*/

		

	}

	else

	{

		redirect('Main_login/index');        

  	} 

	

    }

	public function sand_issue_reprintVw_old()

    {

	

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id))

	{
		$this->load->model('Manual_dredging/Master_model');	
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		//$pass_id=decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
		$pass_id	=		decode_url($this->uri->segment(4));
		

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;

		

		$datareprintview=$this->Master_model->get_pass_reprintApproved($port_id);
		//print_r($datareprintview);
		//$datareprintview=$this->Master_model->get_pass_reprint($port_id);

		$data['datareprintview']=	$datareprintview;

		$data 				= 	$data + $this->data;

		

		//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

		$this->load->view('Manual_dredging/Master/sand_issue_reprintVw',$data);
$this->load->view('Kiv_views/template/dash-footer');
		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');*/

		if($pass_id!='')

		{

		$getsandpassdata=$this->Master_model->get_sandpassdata($pass_id);

		$booking_id			=	$getsandpassdata[0]['customer_booking_id'];

		$request_data=array('reprint_status'=>2);

					//	print_r($booking_id); break;

					

					$result=$this->Master_model->update_passreprint($pass_id,$request_data);

					if($result==1)

					{

						redirect('Manual_dredging/Master/generatepass/'.encode_url($booking_id));

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Approval failed!!!</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintVw');

					}

		}

	}

	else

	{

		redirect('Main_login/index');        

  	} 

	

	     

    }	

	public function sand_issue_reprintApproval_old()

	{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id))

	{

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;

		

		

		$datareprintview=$this->Master_model->get_pass_reprint($port_id);

		$data['datareprintview']=	$datareprintview;

		$data 				= 	$data + $this->data;

		

		//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

		$this->load->view('Manual_dredging/Master/sand_issue_reprintApproval',$data);
$this->load->view('Kiv_views/template/dash-footer');
		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');*/

		if($this->input->post())

		{

				

				$this->form_validation->set_rules('txtremarks', 'Remarks', 'required');

				

				

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					$bid=$this->input->post('bid');

					$remarks=$this->input->post('txtremarks');

					$remarks=$this->security->xss_clean($remarks);

					$remarks=html_escape($remarks);

					$radio=$this->input->post('radiobookingStatus');

					$hid_passid=$this->input->post('hid_passid');

					$hid_passid=$this->security->xss_clean($hid_passid);

					$hid_passid=html_escape($hid_passid);

					$currentdate=date('Y-m-d H:i:s');

					if($radio==2)

					{

						$this->db->query('update transaction_details set print_status=0 where transaction_customer_booking_id=$bid');

					}

					$request_data=array(

					'approved_user_id'=>$sess_usr_id,

					'approveddate_timestamp'=>$currentdate,

					'approve_status'=>$radio,

					'remarks'=>$remarks);

						//print_r($request_data); 

					

					$result=$this->Master_model->update_passreprint($hid_passid,$request_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Approved Successfully</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintApprove');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Approval failed!!!</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintApprove');

					}

				}

			

		

		}

	}

	else

	{

		redirect('Main_login/index');        

  	}      

}

	//---------------------------------------------24-01-2018--------------------------------------------------

	public function sand_issue_reprint()

    {

	

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id)&& ($sess_user_type==6))

	{

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;

		//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

		$this->load->view('Manual_dredging/Master/sand_issue_reprint',$data);
$this->load->view('Kiv_views/template/dash-footer');
		

		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');*/

		if($this->input->post())

			{

				$this->form_validation->set_rules('txttokenno', 'Token No ', 'required');

				$this->form_validation->set_rules('txtaadharno', 'Aadhaar No', 'required');

				$this->form_validation->set_rules('txtreason', 'Reason', 'required');

				

				

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					$tokenno=$this->input->post('txttokenno');

					$tokenno=$this->security->xss_clean($tokenno);

					$tokenno=html_escape($tokenno);

					$aadhar_no=$this->input->post('txtaadharno');

					$aadhar_no=$this->security->xss_clean($aadhar_no);

					$aadhar_no=html_escape($aadhar_no);

					$reason=$this->input->post('txtreason');

					$currentdate=date('Y-m-d H:i:s');

					

					//$get_datarrequested=$this->Master_model->get_bookingapprovedRPT($tokenno,$aadhar_no,$port_id,$zone_id);

						$get_datarrequested=$this->Master_model->get_transRPT($tokenno,$aadhar_no);

					

					

					$customer_regn_id	=	$get_datarrequested[0]['customer_registration_id'];

					$customer_booking_id=	$get_datarrequested[0]['transaction_customer_booking_id'];

					

					$get_bookdet=$this->Master_model->bookingdet($customer_booking_id);

					

					$lsg_id				=	$get_bookdet[0]['customer_booking_lsg_id'];

					$lsg_section_id		=	$get_bookdet[0]['customer_booking_lsg_section_id'];

					$port_id			=	$get_bookdet[0]['customer_booking_port_id'];

					$zone_id			=	$get_bookdet[0]['customer_booking_zone_id'];

						

					$reprintrequest_data=array(

					'zone_id'=>$zone_id,

					'port_id'=>$port_id,

					'lsg_id'=>$lsg_id,

					'lsg_section_id'=>$lsg_section_id,

					'customer_registration_id'=>$customer_regn_id,

					'customer_booking_id'=>$customer_booking_id,

					'token_no'=>$tokenno,

					'customer_aadhaar_no'=>$aadhar_no,

					'sandreprint_reason'=>$reason,

					'zone_operator_id'=>$sess_usr_id,

					'approved_user_id'=>0,

					'approve_status'=>'',

					'approveddate_timestamp'=>'',

					'requesteddate_timestamp'=>$currentdate,

					'reprint_status'=>1,

					'remarks'	=>'');

					$result=$this->Master_model->add_sandpass_reprint($reprintrequest_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Send Successfully</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintVw');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Send failed!!!</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintVw');

					}

				}

			}

	}

	else

	{

		redirect('Main_login/index');        

  	}      

    }

	public function sand_issue_reprintApprove()

    {

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id))

	{

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;

		$datareprintview=$this->Master_model->get_pass_reprintAPP($port_id);
		$data['datareprintview']=	$datareprintview;

		$data 				= 	$data + $this->data;

            $this->load->view('Kiv_views/template/dash-header');
            $this->load->view('Kiv_views/template/nav-header');
            $this->load->view('Manual_dredging/Master/sand_issue_reprintAppVw',$data);
            $this->load->view('Kiv_views/template/dash-footer');
		
	}
	else
	{
		redirect('Main_login/index');        
  	} 

    }

	public function sand_issue_reprintVw()

    {
    	ini_set('display_errors', 1);
	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id))

	{

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		//$pass_id=decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
		$pass_id	=		decode_url($this->uri->segment(4));
		

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;
		$datareprintview=$this->Master_model->get_pass_reprintApproved($port_id);

		//print_r(WEWEWEWEE);break;

		$customer_regn_id	=	$datareprintview[0]['transaction_customer_registration_id'];
		$datacustreg=$this->Master_model->get_cust_det($customer_regn_id);

		

		$data['customer_name']=$datacustreg[0]['customer_name'];

		$data['customer_aadhar_number']=$datacustreg[0]['customer_aadhar_number'];

		$data['customer_max_allotted_ton']=$datacustreg[0]['customer_max_allotted_ton'];

		//$datareprintview=$this->Master_model->get_pass_reprint($port_id);

		$data['datareprintview']=	$datareprintview;

		$data 				= 	$data + $this->data;

            $this->load->view('Kiv_views/template/dash-header');
            $this->load->view('Kiv_views/template/nav-header');
            $this->load->view('Manual_dredging/Master/sand_issue_reprintVw',$data);
            $this->load->view('Kiv_views/template/dash-footer');
		
		if($pass_id!='')

		{

		$getsandpassdata=$this->Master_model->get_sandpassdata($pass_id);

		$booking_id			=	$getsandpassdata[0]['customer_booking_id'];

		$request_data=array('reprint_status'=>2);

		$result=$this->Master_model->update_passreprint($pass_id,$request_data);

		if($result==1)
		{
		redirect('Manual_dredging/Master/generatepass/'.encode_url($booking_id));
		}
		else
		{
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Approval failed!!!</div>');
		redirect('Manual_dredging/Master/sand_issue_reprintVw');

		}

	}

	}

	else

	{

		redirect('Main_login/index');        

  	} 

    }	

	public function sand_issue_reprintApproval()

	{

	$sess_usr_id 			=  $this->session->userdata('int_userid');

	$sess_user_type			=	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id))

	{

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];

		$p_name=$this->Master_model->get_port_By_PC($port_id);

		$port_name=$p_name[$i]['vchr_portoffice_name'];

		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

		$data 				= 	$data + $this->data;     

		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

		$data['user_header']=	$u_h_dat;

		$data 				= 	$data + $this->data;

		//$id 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
		$id					=	$this->uri->segment(4);
		$sandpassid 		= 	decode_url($id); 

		

		$datareprintview=$this->Master_model->get_pass_reprint($port_id,$sandpassid);

		//print_r($datareprintview);break;

		

		$data['datareprintview']=	$datareprintview;

		$data 				= 	$data + $this->data;

		

		//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

		$this->load->view('Manual_dredging/Master/sand_issue_reprintApproval',$data);
$this->load->view('Kiv_views/template/dash-footer');
		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');*/

		if($this->input->post())

		{

				

				$this->form_validation->set_rules('txtremarks', 'Remarks', 'required');

				

				

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

					$bid=$this->security->xss_clean(html_escape($this->input->post('bid')));

			//	print_r($bid);//break;

					$remarks=$this->security->xss_clean(html_escape($this->input->post('txtremarks')));

					$remarks=$this->security->xss_clean($remarks);

					$remarks=html_escape($remarks);

					$radio=$this->security->xss_clean(html_escape($this->input->post('radiobookingStatus')));

					$hid_passid=$this->security->xss_clean(html_escape($this->input->post('hid_passid')));

					$hid_passid=$this->security->xss_clean($hid_passid);

					$hid_passid=html_escape($hid_passid);

					$currentdate=date('Y-m-d H:i:s');

					if($radio==2)

					{

					//print_r($bid);//break;

						$this->db->query("update transaction_details set print_status=0 where transaction_customer_booking_id='$bid'");

					}

					$request_data=array(

					'approved_user_id'=>$sess_usr_id,

					'approveddate_timestamp'=>$currentdate,

					'approve_status'=>$radio,

					'remarks'=>$remarks);

						//print_r($request_data); 

					

					$result=$this->Master_model->update_passreprint($hid_passid,$request_data);

					if($result==1)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Approved Successfully</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintApprove');

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Approval failed!!!</div>');

														redirect('Manual_dredging/Master/sand_issue_reprintApprove');

					}

				}

			

		

		}

	}

	else

	{

		redirect('Main_login/index');        

  	}      

}

	

	//--------------------------------------------------------------------------------------------------------------------

	public function customer_requestprocessing()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&&($sess_user_type==3||$sess_user_type==9))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;

			    

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];  
			$customerreg_details= $this->Master_model->get_customerreg_details($port_id);

			

			$data['customerreg_details']=$customerreg_details;
			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

				
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/customer_requestprocessing', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  

    }

	public function customer_requestprocessingOct10()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		

		

		if(!empty($sess_usr_id))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;

			    

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];  

			$customerreg_details= $this->Master_model->get_customerreg_details($port_id);

			

			$data['customerreg_details']=$customerreg_details;

			$data = $data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/customer_requestprocessing', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



    }

	public function getbookedzonedetails_ajax()

	{

	$this->load->model('Manual_dredging/Master_model');	

	$zoneid=$this->security->xss_clean(html_escape($this->input->post('zone_id')));

	$get_bookingapproval=$this->Master_model->bookingapprovalzone_new($zoneid);

	$data['get_bookingapproval']=$get_bookingapproval;

	$data = $data + $this->data;

	$this->load->view('Manual_dredging/Master/cus_buk_approve_pc', $data);

	}



public function getcustomerdetails_ajax()

{

	$sess_usr_id = $this->session->userdata('int_userid');
	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
	$port_id			=	$userinfo[0]['user_master_port_id']; 

	$this->load->model('Manual_dredging/Master_model');	

	$custaadhar=$this->security->xss_clean(html_escape($this->input->post('custaadhar')));
	$get_customerapproval=$this->Master_model->customerapproval($custaadhar,$port_id);

	$data['get_customerapproval']=$get_customerapproval;
	$data = $data + $this->data;
	$this->load->view('Manual_dredging/Master/customerreg_ajax', $data);

}

//---------------------------------------------------------------------------------------------------------------------



function convertToHoursMins($time, $format = '%02d:%02d') 

{

    if ($time < 1) {

        return;

    }

    $hours = floor($time / 60);

    $minutes = ($time % 60);

    return sprintf($format, $hours, $minutes);

}



public function generatepass()

	{

			ini_set("memory_limit","128M");



		//$id 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
		$id			=		$this->uri->segment(4);
	$bookingid 			= 	decode_url($id); 	

	$this->db->query("UPDATE transaction_details SET pass_dstatus = 1,print_status=1 WHERE transaction_customer_booking_id = $bookingid");

	$sess_usr_id 			= 	$this->session->userdata('int_userid');

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$desgofsign			=	$userinfo[0]['user_master_fullname'];  

	//exit;

	$data_vehiclepass	= 	$this->Master_model->vehiclepass_details($bookingid);

		//-------------------5/01/2018---------------------------------------------

		$lsgdid=$data_vehiclepass[0]['customer_booking_lsg_id'];

		$zoneid=$data_vehiclepass[0]['customer_booking_zone_id'];

		$customerregistration_id=$data_vehiclepass[0]['customer_booking_registration_id'];
		$bankrefno=$data_vehiclepass[0]['transaction_refno'];
		

		$lsgzonedetails=$this->db->query("select * from lsg_zone where lsg_zone.lsg_id ='$lsgdid' and lsg_zone.zone_id='$zoneid'");

		$lsgzone_details=$lsgzonedetails->result_array();

		$data['lsgzone_details']=$lsgzone_details;

		

		

		$loadingplace	=	$lsgzone_details[0]['lsg_zone_loading_place'];

		

		$lsgdetails=$this->db->query("select * from lsgd where lsgd_id ='$lsgdid' and lsgd_status=1");

		$lsg_details=$lsgdetails->result_array();

		//print_r($lsg_details); break;

		$data['lsg_details']=$lsg_details;

		

		

		$lsgdename		=	$lsg_details[0]['lsgd_name'];

		$lsgdaddress	=	$lsg_details[0]['lsgd_address'];

		$lsgdphoneno	=	$lsg_details[0]['lsgd_phone_number'];

		

		

		

		$customerregdetails=$this->db->query("select customer_name,customer_phone_number,customer_unused_ton,customer_perm_house_number,customer_perm_house_name,customer_perm_house_place,customer_unloading_place,customer_perm_house_place from customer_registration where customer_registration_id ='$customerregistration_id'");

		$customerregdetails=$customerregdetails->result_array();

		$data['customerregdetails']=$customerregdetails;

		

		

	$customername		=	$customerregdetails[0]['customer_name'];

	$customerphone		=	$customerregdetails[0]['customer_phone_number'];

	$customerbalsand	=	$customerregdetails[0]['customer_unused_ton'];

	$houseno			=	$customerregdetails[0]['customer_perm_house_number'];

	$housename			=	$customerregdetails[0]['customer_perm_house_name'];

	$houseplace			=	$customerregdetails[0]['customer_perm_house_place'];

	$unloadplace		=	$customerregdetails[0]['customer_unloading_place'];

	

		

		

		//-------------------------------------------------------------------------

	

	

	

	$tokenno		=	$data_vehiclepass[0]['customer_booking_token_number'];

	$permitno		=	$data_vehiclepass[0]['customer_permit_number'];

	$vehicleno		=	$data_vehiclepass[0]['customer_booking_vehicle_registration_number'];

	$driverlicense	=	$data_vehiclepass[0]['customer_booking_driver_license'];

	$requestton		=	$data_vehiclepass[0]['customer_booking_request_ton'];

	$bookingroute	=	$data_vehiclepass[0]['customer_booking_route'];

	$distance		=   $data_vehiclepass[0]['customer_booking_distance'];

	$drivermobno	=	$data_vehiclepass[0]['customer_booking_driver_mobile'];

	$passissuedate	=	date("d-m-Y H:i:s",strtotime(str_replace('-', '/',$data_vehiclepass[0]['customer_booking_pass_issue_timestamp'])));

	

	

	$timetaken		= ($distance*3);

	//$roundtime=round($timetaken,2);

	//$roundtimenew=explode('.',$roundtime);

	$totamount		=	$data_vehiclepass[0]['transaction_amount'];

	$currentdate=date('d-m-Y H:i:s');
	//$xab='"';

	//$msg="Portinfo 2 - Dear customer your sand pass generated successfully. your balance sand quantity".$xab.$customerbalsand.$xab;

	$msg="Dear customer your sand pass generated successfully. your balance sand quantity - ".$customerbalsand;

	$this->sendSms($msg,$customerphone);

	//require_once('../libraries/tcpdf/tcpdf.php');

$this->load->library('Pdf');

ob_clean();

// create new PDF document

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set document information



// set default header data

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 050', PDF_HEADER_STRING);



// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// set default monospaced font

//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set margins

//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



// set auto page breaks

//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



// set image scale factor

//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// set some language-dependent strings (optional)

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {

    require_once(dirname(__FILE__).'/lang/eng.php');

    $pdf->setLanguageArray($l);

}



// ---------------------------------------------------------



// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.



// set font

//$pdf->SetFont('courier', '', 11);



// add a page

$pdf->AddPage();



// print a message

//$txt = "You can also export 2D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcode directory.\n";

//$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);





$pdf->SetFont('courierB', '', 10);



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	

	

	//$sample_data='Token Number :'.$tokenno.'Permit Number : '.$permitno.'Vehicle Number : '.$vehicleno.'Driver License No. : '.$driverlicense.'Quantity of Dredged Material(in Ton) : '.$requestton.'Loading Place : '.$loadingplace.'Unloading Place : '.$unloadplace.'Vehicle Pass Issued Date & Time : '.$passissuedate.',Date : '.$currentdate.'Duration of Pass : 01 Hours and 00 mins  Cost Of Sand : '. $currentdate;

		

		

	

	//******************************************************************

	$portid=$data_vehiclepass[0]['customer_booking_port_id'];

	$zoneid=$data_vehiclepass[0]['customer_booking_zone_id'];

	

	

	//----------------------------------------------------

		$alloteddate	=   $data_vehiclepass[0]['customer_booking_allotted_date'];

		$period_name=date("F Y", strtotime($alloteddate));

		$data_sandrate	= 	$this->Master_model->get_montly_permit_by_periodnew($period_name,$portid,$zoneid);

	 	$sandrate		=	$data_sandrate['sand_rate'];

		

		//$total_amt_includetax=$sandamt+$cleaningcharge+$royalty;

	 	$tot_exclude_tax=(($sandrate * 100)/105); //break;

		$tot_excludetax=floor($tot_exclude_tax);

		$totaltax=$sandrate - $tot_excludetax;

		$cgst=($totaltax / 2);

		$sgst=($totaltax / 2);

		//----------------------------------------------------

		$sample_data='Token Number :'.$tokenno.',Permit Number : '.$permitno.',Vehicle Number : '.$vehicleno.',Driver License No. : '.$driverlicense.',Quantity of Dredged Material(in Ton) : '.$requestton.',Loading Place : '.$loadingplace.',Unloading Place : '.$unloadplace.',Vehicle Pass Issued Date & Time : '.$passissuedate.',Date : '.$currentdate.',Duration of Pass :'.$this->convertToHoursMins($timetaken, '%02d hours %02d mins').', Cost Of Sand : '. $totamount;

	/*if($portid==10)

	{

 		$pamt= 1538;

	}

	else if($portid==22)

	{

 		$pamt= 1260;

	}

	else

	{ 

 		$pamt= 1995;

	}*/

	//$getpaymentdetails=$this->Master_model->get_paymentdetails($bookingid,$portid,$zoneid);

	$sandamt=0;$cleaningcharge=0;$royalty=0;$vehiclepass=0;

	/*foreach($getpaymentdetails as $rowdata)

	{

	//echo "aaaa--".$i=$rowdata['payment_head'];

	

	/*if($rowdata['payment_head']==1 ||$rowdata['payment_head']==2 ||$rowdata['payment_head']==3)

	{

	

	$sandamt=$sandamt+$rowdata['payment_amount'];

	}

	 if($rowdata['payment_head']==4)

	{

	$cleaningcharge=$rowdata['payment_amount'];

	//$cleaningcharge;

	}

	 if($rowdata['payment_head']==5)

	{

	$royalty=$rowdata['payment_amount'];

	//$royalty;

	}

	 if($rowdata['payment_head']==6)

	{

	$vehiclepass=$rowdata['payment_amount'];

	//$vehiclepass;

	}

	

	

//echo "kkkkk".$sandamt;





}

*/

	

	//$a=$this->load->library('numbertowords');

 

 //$total=$this->numbertowords->convert_number($totamount);

	if($data_vehiclepass[0]['customer_booking_requested_timestamp']>'2018-07-03 00:00:00')

	{

	$totgstvehicle=220*(19/100);//---1%  flood cess increased on 02/08/2019[18 +1]

	$cgstvehicle=($totgstvehicle/2);

	$sgstvehicle=($totgstvehicle/2);

	

 $totamountnew=ceil($totamount);

		$tabledata='<tr>

		<td width="60%" style="text-align:left;font-size:9px;">SGST @ 9 %(on Vehicle Pass)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.ceil($sgstvehicle).'</td>

		</tr>

		<tr>

		<td width="60%" style="text-align:left;font-size:9px;">CGST @ 9 %(on Vehicle Pass)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.ceil($cgstvehicle).'</td>

		</tr>';

	

	}

		else

		{

			$cgstvehicle=0;

			$sgstvehicle=0;

			$totamountnew=$totamount;

			$tabledata='';

		}

	

	$a=$this->load->library('numbertowords');



 	 $totalnew=$this->numbertowords->convert_number($totamountnew);

		

	//$sandamt=$getpaymentdetails[0]['payment_amount']+$getpaymentdetails[1]['payment_amount']+$getpaymentdetails[2]['payment_amount'];

	

	

	

	

	//******************************************************************

	

	//$sample_dataa='Token Number :'.$tokenno.'Permit Number : '.$permitno.'Vehicle Number : '.$vehicleno;

// set style for barcode



$style = array(

    'border' => true,

    'vpadding' => 'auto',

    'hpadding' => 'auto',

    'fgcolor' => array(0,0,0),

    'bgcolor' => false, //array(255,255,255)

    'module_width' => 1, // width of a single module in points

    'module_height' => 1 // height of a single module in points

);

$pdf->setXY(450,272);

$pdf->write2DBarcode($sample_data, 'QRCODE,H', 15, 20, 52, 52, $style, 'N');



$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p><hr/>



		<h4 style="text-align:center">VEHICLE PASS</h4>

		<table border="0" style="text-align:left;" width="100%">

		<thead style="font-weight:50">

		

		<tr>

		<th width="60%">1 Token Number & Transaction</th>

		<th width="40%">: '.$tokenno.'</th>

		</tr>

		<tr>

		<th>2 Customer name</th>

		<th>: '.$customername.'</th>

		</tr>

		<tr>

		<th>3 Customer Phone</th>

		<th>: '.$customerphone.'</th>

		</tr>

		<tr>

		<th>4 House No & Name</th>

		<th>: '.$houseno.'&'.$housename.'</th>

		</tr>

		<tr>

		<th>5 Bank Reference No</th>

		<th>: '.$bankrefno.'</th>

		</tr>

		<tr>

		<th>6 Place</th>

		<th>: '.$houseplace.'</th>

		</tr>

		<tr>

		<th>7  LSGD Name,Address and Phone No</th>

		<th>: '.$lsgdename.','.$lsgdaddress.',

		'.$lsgdphoneno.'</th>

		</tr>

		<tr>

		<th>8 Vehicle Number</th>

		<th>: '.$vehicleno.'</th>

		</tr>

		<tr>

		<th>9 Driver License No</th>

		<th>: '.$driverlicense.'</th>

		</tr>

		<tr>

		<th>10 Quantity of Dredged Material(in Ton)</th>

		<th>: '.$requestton	.'</th>

		</tr>

		<tr>

		<th>11 Loading Place</th>

		<th>: '.$loadingplace.'</th>

		</tr>

		<tr>

		<th>12 Unloading Place</th>

		<th>: '.$unloadplace.'</th>

		</tr>

		<tr>

		<th>13 Vehicle Pass Issued Date & Time</th>

		<th>: '.$passissuedate.'</th>

		</tr>

		<tr>

		<th>14 Route</th>

		<th>: '.$bookingroute.'</th>

		</tr>

		<tr>

		<th>15 Driver Mobile No</th>

		<th>: '.$drivermobno.'</th>

		</tr>

		

		</thead>

		</table>

		<p style="margin-top:10px">Date :'.$currentdate.'</p>

		<p>Duration of Pass : '.$this->convertToHoursMins($timetaken, '%02d hours %02d minutes').'</p>

		<hr/>

		<p style="text-align:center;">BILL</p>

		<table border="0" style="text-align:left;font-size:11px;" width="100%">

		<tbody>

		<tr>

		<td width="60%">Cost of Sand</td>

		<td width="40%">:'.ceil($tot_excludetax*$requestton).'</td>

		</tr>

		<tr>

		<td width="60%" style="text-align:left;font-size:9px;">SGST @ 2.5 % (on Cost of Sand)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.round($sgst*$requestton,2).'</td>

		</tr>

		<tr>

		<td width="60%" style="text-align:left;font-size:9px;">CGST @ 2.5 %(on Cost of Sand)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.round($cgst*$requestton,2).'</td>

		</tr>

		<tr>

		<td width="60%">Vehicle Pass</td>

		

		<td width="40%">:220</td>

		</tr>'.

		$tabledata.'

		</tbody>

		</table>

		<hr/>

		<table class="tab2" border="0" style="text-align:left;width:100%;font-size:12px;">

		<tbody>

		<tr>

		<td width="60%"><b>Total Amount</b></td>

		<td width="40%"><b>: Rs '.$totamountnew.'</b>('.$totalnew.')</td>

		</tr>

		<tr>

		<td width="60%"> </td>

		<td width="40%"> </td>

		</tr>

		</tbody>

		</table>

		<table style="margin-top:70px" width="100%">

		<tbody>

		<tr>

		<td width="60%" style="text-align:left;font-size:10px;font-weight:bold;">Place: </td>

		<td width="40%" style="text-align:left;font-size:10px;font-weight:bold;">Signature of Kadavu Supervisor</td>

		</tr>

		<tr><td width="100%" style="text-align:left;font-size:10px;font-weight:bold;">Customer Name & Signature</td></tr>

		</tbody>

		</table>

		

		<p style="text-align:left;font-size:9px;">Computer generated vehicle pass, www.portinfo.kerala.gov.in </p><br/>';

		

		//==============================================================

		//==============================================================

		//==============================================================

		//print_r($html);

$pdf->writeHTML($html, true, false, true, false, '');

//$pdf->write2DBarcode('hello', 'PDF417',0,154, 35,0, 20, $style, 'N');

$pdf->write2DBarcode($sample_data, 'PDF417', 154, 255,0, 20, $style, 'N');

//$pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');

//Close and output PDF document

$pdf->Image(getcwd().'/assets/temp/vehicle_passnew.png', 64, 35, 100, 35, 'PNG', false , '', false, 100, '', false, false, 0, false, false, false);

$pdf->Image(getcwd().'/assets/images/pass_seal.png', 162, 33, 35, 30, 'PNG', false , '', false, 100, '', false, false, 0, false, false, false);

//$pdf->Image(base_url().'assets/temp/2017-07-131.png');

$pdf->Output('vehicle_pass.pdf', 'D');

//$this->output->enable_profiler(TRUE);

exit;

	

	}

	//--------------------------------------------------------------------------------------------------------------------

	public function customer_login()

    {

		$sess_usr_id 			= $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& ($sess_user_type==3 ||$sess_user_type==9))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];  

		 	$data = $data + $this->data; 

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			
                        $this->load->view('Kiv_views/template/dash-header');
                        $this->load->view('Kiv_views/template/nav-header');
						$this->load->view('Manual_dredging/Master/customer_login', $data);
                        $this->load->view('Kiv_views/template/dash-footer');
			
	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

    }

	

	public function customer_login_add()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);

			$this->load->model('Manual_dredging/Master_model');	

		$data = array('title' => 'Add Customer Login Details', 'page' => 'customer_login_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$customerAppvd_data= $this->Master_model->get_customer_reg_detailsapproved($id);

			$data['customerAppvd_data']=$customerAppvd_data;

			$data = $data + $this->data; 

			$portid=$customerAppvd_data[0]['port_id'];

			$cus_phone_number=$customerAppvd_data[0]['customer_phone_number'];

			$portcode=$this->Master_model->get_portcode($portid);

			$data['portcode']=$portcode;

			$data = $data + $this->data; 

			if($this->input->post())

			{

			

			$txtcustrname=$this->security->xss_clean(html_escape($this->input->post('txtcustrname')));

			$cust_pass=$this->input->post('txtcustrpassword');

			$txtcustrpassword=$this->phpass->hash($this->input->post('txtcustrpassword'));

			$txtcustrconfpassword=$this->phpass->hash($this->input->post('txtcustrconfpassword'));

			

			$hid_usermasterid=$this->input->post('hid_usermasterid');

			$hid_usermasterid=decode_url($hid_usermasterid);

			//exit();

			//$hid_usermasterid=url_decode($hid_usermasterid);

			//print_r($hid_usermasterid);



			$currentdate=date('Y-m-d H:i:s');

			$update_data=array(

				'user_master_name'	=>	$txtcustrname,

				'user_master_password'	=>$txtcustrpassword);

			$customerregupt_data= $this->Master_model->update_usermaster($update_data,$hid_usermasterid);

				if($customerregupt_data==1)

				{

						//$this->emailSendFun('',,'','');

						$message="Your Registration Approved Successfully<br>

						User Name : ".$txtcustrname."<br>

						Password  : ".$cust_pass;

						$sms_succ=$this->sendSms($message,$cus_phone_number);

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Customer Credentials added successfully</div>');

						redirect('Manual_dredging/Master/customer_requestprocessing');

					

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error failed!!!</div>');

													redirect('Manual_dredging/Master/customer_login');

				}

				

			}

			$this->load->view('Manual_dredging/Master/customer_login_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

    }

	//--------------------------------------------------------------------------------------------------------------------

	public function customer_booking()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

		//	$customerreg_booking= $this->Master_model->get_customerreg_booking();

		//	$data['customerreg_booking']=$customerreg_booking;

			$data = $data + $this->data;    

			

			

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/customer_booking', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



    }

//==========================================================================================================================================	

public function customer_booking_history()

    {

		ini_set('display_errors', 1);

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$customerreg_booking= $this->Master_model->get_cus_buk_his($sess_usr_id);

			$data['cust_book_his']=$customerreg_booking;

			$data = $data + $this->data;    

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');

			$cus_bal=$this->db->query("select customer_allotted_ton,customer_used_ton,customer_unused_ton from customer_registration where customer_public_user_id='$sess_usr_id'");

			if($this->db->affected_rows() > 0)
			{
            $cust_bal=$cus_bal->result_array();
        	}
        	else
        	{
            $cust_bal='NULL';
        	}
			//$cust_bal=$cus_bal->result_array();

			$data['cus_bal']=$cust_bal;

			$data 		= 	$data + $this->data;

			//$this->output->enable_profiler(TRUE);

			$this->load->view('Manual_dredging/Master/customer_booking_his', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



    

	}

//==========================================================================================================================================

public function customer_booking_add()

    {

		

        $sess_usr_id = $this->session->userdata('int_userid');

		$rres=$this->db->query("select customer_registration_id as crid from customer_registration where customer_public_user_id='$sess_usr_id'");

		$ud=$rres->result_array();

		$cr_id=$ud[0]['crid'];     

		$buk_info			=	$this->Master_model->getbukinfo($cr_id);

		$last_booked_date	=	$buk_info[0]['bookeddate'];

		

		$buk_id=	$buk_info[0]['customer_bukid'];

		if(!empty($last_booked_date))

		{

		$currentdate  =	date('Y-m-d H:i:s');

		$date1 = date_create($currentdate);

		$date2 = date_create($last_booked_date);

				//difference between two dates

		$diff = date_diff($date1,$date2);

		$dateInterval=$diff->format("%a");

		if($dateInterval<7)

		{

			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Warning Not allowed to book | you might have previous pending request !!!</div>');

			redirect("Master/customer_home");

		}

			else if($dateInterval>7)

			{

				$reqtt=$this->db->query("select * from customer_booking where customer_booking_pass_issue_user=0 and customer_booking_id='$buk_id' and customer_booking_decission_status NOT IN(4,5,3)");

							$no=$this->db->affected_rows();

							if($no!=0)

							{

				//$get_print_stat=$this->db->query("select print_status from transaction_details where transaction_customer_booking_id=$buk_id");

				//$det_print_stat=$get_print_stat->result_array();

				//$printstatus	=	$det_print_stat[0]['print_status'];

				//if($printstatus==0)

				//{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Warning Not allowed to book | you might have previous pending request !!!</div>');

			redirect("Master/customer_home");

				}

			}

		}

		if(!empty($sess_usr_id))

		{	

		

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);

			

			$data = array('title' => 'Add Customer Booking Details', 'page' => 'customer_booking_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			

			

			$this->load->model('Manual_dredging/Master_model');	

			//================================================================================================

			$bookingtime_data= $this->Master_model->customerbooking_timecheck();

			$starttime=$bookingtime_data[0]['booking_master_start'];

			$endtime=$bookingtime_data[0]['booking_master_end'];

			$start_time=strtotime($starttime);

			$end_time=strtotime($endtime);

			//echo date_default_timezone_get();

			//echo date('Y-M-d h:i:s');

			//exit;

			$current_time=strtotime("now");

		if($current_time >= $start_time && $current_time <= $end_time)

		{ 

			$customerreg_data= $this->Master_model->get_customer_regDetails($sess_usr_id);

			$data['customerreg_data']=$customerreg_data;

			$data = $data + $this->data; 

			

			$portid=$customerreg_data[0]['port_id'];

			

			$currentdate	=	date('Y-m-d H:i:s');//ADDED ON 07/09/17

			$period_name=date("F Y", strtotime($currentdate));//ADDED ON 07/09/17

			$get_zone_details= $this->Master_model->get_zone_detailsnew($portid,$period_name);//ADDED PERIOD NAME  ON 07/09/17

			

			//$get_zone_details= $this->Master_model->get_zone_details($portid);

			

			$data['get_zone_details']=$get_zone_details;

			$data = $data + $this->data; 

			$port				= 	$this->Master_model->get_port();

			$data['port_det']	=	$port;

			

			$get_quantity_details= $this->Master_model->get_quantity_details($portid);

			$data['get_quantity_details']=$get_quantity_details;

			$data = $data + $this->data; 

			$currentdate	=	date('Y-m-d H:i:s');

			



			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/customer_booking_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

			

			if($this->input->post())

			{

			

				$this->form_validation->set_rules('zone_id', 'Zone ', 'required');

				$this->form_validation->set_rules('quantity_id', 'Required Ton', 'required');

				$this->form_validation->set_rules('txtrouteunloadplace', 'Route to unload Place', 'required');

				$this->form_validation->set_rules('txtdistanceunloadplace', 'Distance to Unload Place', 'required');

				

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

			

					$this->load->model('Manual_dredging/Master_model');	

					$zone_id				=	$this->security->xss_clean(html_escape($this->input->post('zone_id')));

					$quantity_id			=	$this->security->xss_clean(html_escape($this->input->post('quantity_id')));

					$txtrouteunloadplace	=	$this->security->xss_clean(html_escape($this->input->post('txtrouteunloadplace')));

					$txtdistanceunloadplace	=	$this->security->xss_clean(html_escape($this->input->post('txtdistanceunloadplace')));

					$hid_custid				=	$this->security->xss_clean(html_escape($this->input->post('hid_custid')));

					$currentdate			=	date('Y-m-d H:i:s');

					//$ip_address				=	$_SERVER['REMOTE_ADDR'];
if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
			

			//---------------------------------------------------------------------

			$customerreg_booking		=	 $this->Master_model->get_customer_regDetailsadd($hid_custid);

			//$data['customerreg_booking']=	$customerreg_booking;

			//$data = $data + $this->data;  

			$cutomerregistration_id	=	$customerreg_booking[0]['customer_registration_id'];

			$cutomeruser_id			=	$customerreg_booking[0]['customer_public_user_id'];

			$portid					=	$this->security->xss_clean(html_escape($this->input->post('portdc')));

			$unused_ton				=	$customerreg_booking[0]['customer_unused_ton'];

			$quantity_data	=	$this->Master_model->get_quantitymast($quantity_id);

			$requested_ton	=	$quantity_data[0]['quantity_master_name'];

			if($unused_ton < $requested_ton)

			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Warning Balance Quantity less than Requested Quantity!!!</div>');

			     redirect('Manual_dredging/Master/customer_booking_add/'.encode_url($hid_custid));

			}

			//---------------------------------------------------------------------

			$period_name=date("F Y", strtotime($currentdate));

			$get_monthlypermit_details			= 	$this->Master_model->get_monthly_permitnew($portid,$period_name,$zone_id);

			//print_r($get_monthlypermit_details);

			//exit;

			foreach($get_monthlypermit_details as $get_f_per)

			{

				$monthlypermitid	=	$get_f_per['monthly_permit_id'];

				$lsgseectionid		=	$get_f_per['lsg_section_id'];

				$lsgid				=	$get_f_per['lsg_id'];

				$balance_ton		=	$get_f_per['monthly_permit_balance_ton'];

				$amount_ton			=	$get_f_per['sand_rate'];

			}

			//$period_name		=	$get_monthlypermit_details[0]['monthly_permit_period_name'];

			$p_det=$this->Master_model->get_port_By_PC($portid);

			$p_code=$p_det[0]['intport_code'];

			$alp_nu=bin2hex(openssl_random_pseudo_bytes(4));

			//$tok_no=substr(number_format(time() * rand(),0,'',''),0,8);

			//exit();

			////

			

			              //for UID

			$data = array("OPCODE"=>"GETUID",

            "TOKENNO"=>98565656,

            "PORTCODE"=>$p_code,

            "INSTCODE"=>"DOP");                                                                    

			$data_string = json_encode($data);                                                                                   

																																 

		$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                                                      

			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

				'Content-Type: application/json',                                                                                

				'Content-Length: ' . strlen($data_string))                                                                       

			);                                                                                                                   

																																 

			$result = curl_exec($ch);

			$myArray=json_decode($result, true);

						  //FOR UID 

			//print_r($myArray);UIDSeries

			if(!empty($myArray))

			{

			$uid=$myArray['UID'];

			}

			//if(empty($uid))

			//{

				//$uid=$myArray['UIDSeries'];

			//}

			//$ifsc=$myArray['IFSC'];

			//exit;

			/////

			if(empty($uid))

			{

				//$uid="9856666".$tok_no;

				//$ifsc='VIJ10253';

			}

			$currentbookingtime		=	strtotime("now");

			

			$customerreg_history	= 	$this->Master_model->get_customer_booking($cutomerregistration_id);

			$data['get_monthlypermit_details']	=	$get_monthlypermit_details;

			$data = $data + $this->data; 

			

			$data['customerreg_history']=	$customerreg_history;

			$data = $data + $this->data; 

			

			$last_booked_date	=	$customerreg_history[0]['bookeddate'];

			$last_bookeddate	=	strtotime($last_booked_date);

			

			

			

		

	//-------------------------------------------------------------------------------------------------------------------------------

			//$maxpriorty	=	$this->Master_model->maxpriorty_check($portid,$lsgid,$zone_id);

			//foreach($maxpriorty as $max_pro)

			//{

			//$priority	=	$max_pro['prioritynum'];

			//}

			//echo $priority;

			//exit;

			$prioritynew=0;

	//-------------------------------------------------------------------------------------------------------------------------------

	

$date1 = date_create($currentdate);

$date2 = date_create($last_booked_date);



//difference between two dates

$diff = date_diff($date1,$date2);

	$dateInterval=$diff->format("%a");

	//$date = '08/04/2010 22:15:00';

	if($unused_ton<3)

	{

	$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Maximum required ton must be greater than 3 !!!</div>');

	redirect('Manual_dredging/Master/customer_booking_add');

	}

	else{

			if($dateInterval>=7)

			{

			 

				if($balance_ton>=$requested_ton)

				{

			

						$insert_booking_data=array('customer_booking_registration_id'=>$cutomerregistration_id,

						'customer_booking_customer_booking'=>$cutomeruser_id,

						'customer_booking_port_id'=>$portid,

						'customer_booking_zone_id'=>$zone_id,

						'customer_booking_lsg_id'=>$lsgid,

						'customer_booking_lsg_section_id'=>$lsgseectionid,

						'customer_booking_monthly_permit_id'=>$monthlypermitid,

						'customer_booking_request_ton'=>$requested_ton,

						'customer_booking_token_number'=>$tok_no,

						'customer_booking_priority_number'=>0,

						'customer_booking_allotted_date'=>'',

						'customer_booking_requested_timestamp'=>$currentdate,

						'customer_booking_decission_timestamp'=>'',

						'customer_booking_decission_user'=>'',

						'customer_booking_decission_status'=>'',

						'customer_booking_route'=>$txtrouteunloadplace,

						'customer_booking_distance'=>$txtdistanceunloadplace,

						'customer_booking_requested_ip'=>$ip_address,

						'customer_booking_pass_issue_user'=>'',

						'customer_booking_pass_issue_timestamp'=>'',

						'customer_booking_vehicle_make'=>'',

						'customer_booking_vehicle_registration_number'=>'',

						'customer_booking_driver_name'=>'',

						'customer_booking_driver_license'=>'',

						'customer_booking_permit_number'=>'',

						'customer_booking_chalan_date'=>date('Y-m-d'),

						'customer_booking_chalan_number'=>$alp_nu,

						'customer_booking_chalan_amount'=>ceil($amount_ton*$requested_ton)+220+42,

						'customer_booking_current_status'=>1,

						'customer_booking_decission_ip'=>'',

						'customer_booking_pass_issue_ip'=>'',

						'customer_booking_period_name'=>$period_name,

						'customer_booking_blocked_status'=>'');

						$this->db->trans_start();

						$insert_customer_booking=$this->db->insert('customer_booking', $insert_booking_data);

					

						$buk_id=$this->db->insert_id();

						$tok_no=substr(number_format(time() * rand(00000,99999) * $buk_id,0,'',''),0,8);

						

				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
				$no=$gt_ch->num_rows();

				if($no>0)

				{
					$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
				}

						//space for UID

						$amnt=ceil($amount_ton*$requested_ton)+220+42;

						

								$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>$tok_no,

											"PORTCODE"=>$p_code,

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$amnt",

											);                                                                    

								$data_string = json_encode($data);   

								//echo $data_string;                                                                                                                  

		$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

									'Content-Type: application/json',                                                                                

									'Content-Length: ' . strlen($data_string))                                                                       

								);                                                                                                                     

								$result = curl_exec($ch);

								$myArray=json_decode($result, true);

								$uid=$myArray['UID'];

								$ifsc=$myArray['IFSC'];

								if($uid=="")

								{

									//echo $data_string;

									//print_r($myArray);

									//exit;

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');

									redirect('Manual_dredging/Master/customer_booking_add/');

								}

						/////////////////////

						

						$data_trans=array(

						'transaction_customer_registration_id'=>$cutomerregistration_id,

						'transaction_customer_booking_id'=>$buk_id,

						'token_no'=>$tok_no,

						'challan_no'=>$alp_nu,

						'challan_amount'=>ceil($amount_ton*$requested_ton)+220+42,

						'uid_no'=>$uid,

						'ifsc_code'=>$ifsc,

						'challan_timestamp'=>$currentdate,

						'booking_timestamp'=>$currentdate,

						'zone_id'=>$zone_id,

						'port_id'=>$portid,

						);

						$res_prio=$this->db->query("select last_priority as prioritynum from tbl_priority  where port_id='$portid' and zone_id='$zone_id'");

						$prio_at=$res_prio->result_array();

						$this->db->query("update tbl_priority set last_priority=last_priority+1  where port_id='$portid' and zone_id='$zone_id'");

						$data_prio=array('customer_booking_priority_number'=>$prio_at[0]['prioritynum']+1,

						'customer_booking_token_number'=>$tok_no

						);

						$this->db->where('customer_booking_id',$buk_id);

						$this->db->update('customer_booking',$data_prio);

						//$this->Master_model->add_trans_det($data_trans);

						$this->db->insert('transaction_details',$data_trans);

						$this->db->trans_complete();

				}

				else

				 {

				

					$next_permitperiod= date('F Y', strtotime('+1 months'));

					//$get_nextmonthlypermit_det			= 	$this->Master_model->get_monthly_permit($portid,$next_permitperiod);
					 $get_nextmonthlypermit_det			= 	$this->Master_model->get_monthly_permitnew($portid,$next_permitperiod,$zone_id);

					//$data['get_nextmonthlypermit_det']	=	$get_nextmonthlypermit_det;

					//$data = $data + $this->data; 

					if($get_nextmonthlypermit_det)

					{

						$nextmonthlypermitid	=	$get_nextmonthlypermit_det[0]['monthly_permit_id'];

						$nextlsgseectionid		=	$get_nextmonthlypermit_det[0]['lsg_section_id'];

						$nextlsgid				=	$get_nextmonthlypermit_det[0]['lsg_id'];

						$nextbalance_ton		=	$get_nextmonthlypermit_det[0]['monthly_permit_balance_ton'];

						$new_amount_ton			=	$get_nextmonthlypermit_det[0]['sand_rate'];

						if($nextbalance_ton>=$requested_ton)

					{

						$insertnext_booking_data=array('customer_booking_registration_id'=>$cutomerregistration_id,

						'customer_booking_customer_booking'=>$cutomeruser_id,

						'customer_booking_port_id'=>$portid,

						'customer_booking_zone_id'=>$zone_id,

						'customer_booking_lsg_id'=>$nextlsgid,

						'customer_booking_lsg_section_id'=>$nextlsgseectionid,

						'customer_booking_monthly_permit_id'=>$nextmonthlypermitid,

						'customer_booking_request_ton'=>$requested_ton,

						'customer_booking_token_number'=>$tok_no,

						'customer_booking_priority_number'=>0,

						'customer_booking_allotted_date'=>'',

						'customer_booking_requested_timestamp'=>$currentdate,

						'customer_booking_decission_timestamp'=>'',

						'customer_booking_decission_user'=>'',

						'customer_booking_decission_status'=>'',

						'customer_booking_route'=>$txtrouteunloadplace,

						'customer_booking_distance'=>$txtdistanceunloadplace,

						'customer_booking_requested_ip'=>$ip_address,

						'customer_booking_pass_issue_user'=>'',

						'customer_booking_pass_issue_timestamp'=>'',

						'customer_booking_vehicle_make'=>'',

						'customer_booking_vehicle_registration_number'=>'',

						'customer_booking_driver_name'=>'',

						'customer_booking_driver_license'=>'',

						'customer_booking_permit_number'=>'',

						'customer_booking_chalan_date'=>date('Y-m-d'),

						'customer_booking_chalan_number'=>$alp_nu,

						'customer_booking_chalan_amount'=>ceil($new_amount_ton*$requested_ton)+220+42,

						'customer_booking_current_status'=>1,

						'customer_booking_decission_ip'=>'',

						'customer_booking_pass_issue_ip'=>'',

						'customer_booking_period_name'=>$next_permitperiod,

						'customer_booking_blocked_status'=>'');

						$this->db->trans_start();

						$insert_customer_booking=$this->db->insert('customer_booking', $insert_booking_data);

						

						$buk_id=$this->db->insert_id();

						$tok_no=substr(number_format(time() * rand(00000,99999) * $buk_id,0,'',''),0,8);
						$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
				$no=$gt_ch->num_rows();

				if($no>0)

				{
					$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
				}

						//Space for UID

						$amnt=ceil($new_amount_ton*$requested_ton)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1]  40 changed to 42

							$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>$tok_no,

											"PORTCODE"=>$p_code,

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$amnt",

											);                                                                    

								$data_string = json_encode($data);   

								//echo $data_string;                                                                                                                  

				$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

									'Content-Type: application/json',                                                                                

									'Content-Length: ' . strlen($data_string))                                                                       

								);                                                                                                                     

								$result = curl_exec($ch);

								$myArray=json_decode($result, true);

								$uid=$myArray['UID'];

								$ifsc=$myArray['IFSC'];

								if($uid=="")

								{

									//echo $data_string;

									//print_r($myArray);

									//exit;

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');

									redirect('Manual_dredging/Master/customer_booking_add/');

								}

						///////////

						$data_trans=array(

						'transaction_customer_registration_id'=>$cutomerregistration_id,

						'transaction_customer_booking_id'=>$buk_id,

						'token_no'=>$tok_no,

						'challan_no'=>$alp_nu,

						'challan_amount'=>ceil($new_amount_ton*$requested_ton)+220+42,

						'uid_no'=>$uid,

						'ifsc_code'=>$ifsc,

						'challan_timestamp'=>$currentdate,

						'booking_timestamp'=>$currentdate,

						'zone_id'=>$zone_id,

						'port_id'=>$portid,

						);

						$res_prio=$this->db->query("select last_priority as prioritynum from tbl_priority  where port_id='$portid' and zone_id='$zone_id'");

						$prio_at=$res_prio->result_array();

						$this->db->query("update tbl_priority set last_priority=last_priority+1  where port_id='$portid' and zone_id='$zone_id'");

						$data_prio=array('customer_booking_priority_number'=>$prio_at[0]['prioritynum']+1,

						'customer_booking_token_number'=>$tok_no);

						$this->db->where('customer_booking_id',$buk_id);

						$this->db->update('customer_booking',$data_prio);

						//$this->Master_model->add_trans_det($data_trans);

						$this->db->insert('transaction_details',$data_trans);

						$this->db->trans_complete();

					}

					else

					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Booking  failed333!!!</div>');

													redirect('Manual_dredging/Master/customer_booking_add/'.encode_url($hid_custid));

					}

				}

				}

				

				

				

			}

			else

			 {

			

			 if($last_bookeddate=='')

			 { 

			  

			 if($balance_ton>=$requested_ton)

				{

			

						$insert_booking_data=array('customer_booking_registration_id'=>$cutomerregistration_id,

						'customer_booking_customer_booking'=>$cutomeruser_id,

						'customer_booking_port_id'=>$portid,

						'customer_booking_zone_id'=>$zone_id,

						'customer_booking_lsg_id'=>$lsgid,

						'customer_booking_lsg_section_id'=>$lsgseectionid,

						'customer_booking_monthly_permit_id'=>$monthlypermitid,

						'customer_booking_request_ton'=>$requested_ton,

						'customer_booking_token_number'=>$tok_no,

						'customer_booking_priority_number'=>0,

						'customer_booking_allotted_date'=>'',

						'customer_booking_requested_timestamp'=>$currentdate,

						'customer_booking_decission_timestamp'=>'',

						'customer_booking_decission_user'=>'',

						'customer_booking_decission_status'=>'',

						'customer_booking_route'=>$txtrouteunloadplace,

						'customer_booking_distance'=>$txtdistanceunloadplace,

						'customer_booking_requested_ip'=>$ip_address,

						'customer_booking_pass_issue_user'=>'',

						'customer_booking_pass_issue_timestamp'=>'',

						'customer_booking_vehicle_make'=>'',

						'customer_booking_vehicle_registration_number'=>'',

						'customer_booking_driver_name'=>'',

						'customer_booking_driver_license'=>'',

						'customer_booking_permit_number'=>'',

						'customer_booking_chalan_date'=>date('Y-m-d'),

						'customer_booking_chalan_number'=>$alp_nu,

						'customer_booking_chalan_amount'=>ceil($amount_ton*$requested_ton)+220+42,

						'customer_booking_current_status'=>1,

						'customer_booking_decission_ip'=>'',

						'customer_booking_pass_issue_ip'=>'',

						'customer_booking_period_name'=>$period_name,

						'customer_booking_blocked_status'=>'');

						

						$this->db->trans_start();

						$insert_customer_booking=$this->db->insert('customer_booking', $insert_booking_data);

					

						$buk_id=$this->db->insert_id();

					

						$tok_no=substr(number_format(time() * rand(00000,99999) * $buk_id,0,'',''),0,8);

						$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
				$no=$gt_ch->num_rows();

				if($no>0)

				{
					$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
				}

						//space for  UID

						$amnt=ceil($amount_ton*$requested_ton)+220+42;

							$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>$tok_no,

											"PORTCODE"=>$p_code,

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$amnt",

											);                                                                    

								$data_string = json_encode($data);   

								//echo $data_string;                                                                                                                  

				$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

									'Content-Type: application/json',                                                                                

									'Content-Length: ' . strlen($data_string))                                                                       

								);                                                                                                                     

								$result = curl_exec($ch);

								$myArray=json_decode($result, true);

								$uid=$myArray['UID'];

								$ifsc=$myArray['IFSC'];

								if($uid=="")

								{

									//echo $data_string;

									//print_r($myArray);

									//exit;

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');

									redirect('Manual_dredging/Master/customer_booking_add/');

								}

						//////

						$data_trans=array(

						'transaction_customer_registration_id'=>$cutomerregistration_id,

						'transaction_customer_booking_id'=>$buk_id,

						'token_no'=>$tok_no,

						'challan_no'=>$alp_nu,

						'challan_amount'=>ceil($amount_ton*$requested_ton)+220+42,

						'uid_no'=>$uid,

						'ifsc_code'=>$ifsc,

						'challan_timestamp'=>$currentdate,

						'booking_timestamp'=>$currentdate,

						'zone_id'=>$zone_id,

						'port_id'=>$portid,

						);

						$res_prio=$this->db->query("select last_priority as prioritynum from tbl_priority  where port_id='$portid' and zone_id='$zone_id'");

						$prio_at=$res_prio->result_array();

						$this->db->query("update tbl_priority set last_priority=last_priority+1  where port_id='$portid' and zone_id='$zone_id'");

						$data_prio=array('customer_booking_priority_number'=>$prio_at[0]['prioritynum']+1,

						'customer_booking_token_number'=>$tok_no);

						$this->db->where('customer_booking_id',$buk_id);

						$this->db->update('customer_booking',$data_prio);

						//$this->Master_model->add_trans_det($data_trans);

						$this->db->insert('transaction_details',$data_trans);

						$this->db->trans_complete();

				}

				else

				 {

				

					$next_permitperiod= date('F Y', strtotime('+1 months'));

					//$get_next_monthlypmt = $this->Master_model->get_monthly_permit($portid,$next_permitperiod);
					 $get_next_monthlypmt = $this->Master_model->get_monthly_permitnew($portid,$next_permitperiod,$zone_id);

					//print_r($get_next_monthlypmt);

					//exit;

					//$data['get_nextmonthlypermit_det']	=	$get_nextmonthlypermit_det;

					//$data = $data + $this->data; 

					if(!empty($get_next_monthlypmt))

					{

						foreach($get_next_monthlypmt as $get_mon_details)

						{

							 $nextmonthlypermitid_new=$get_mon_details['monthly_permit_id'];

							 $nextlsgseectionid_new=$get_mon_details['lsg_section_id'];

							 $nextlsgid_new=$get_mon_details['lsg_id'];

							$nextbalance_ton_new=$get_mon_details['monthly_permit_balance_ton'];

							$new_per_ton=$get_mon_details['sand_rate'];

							//echo "//".$requested_ton;

							

						}

						if($nextbalance_ton_new>=$requested_ton)

						{

							//echo "//";

							//exit;

					$insertnext_booking_data=array('customer_booking_registration_id'=>$cutomerregistration_id,

						'customer_booking_customer_booking'=>$cutomeruser_id,

						'customer_booking_port_id'=>$portid,

						'customer_booking_zone_id'=>$zone_id,

						'customer_booking_lsg_id'=>$nextlsgid_new,

						'customer_booking_lsg_section_id'=>$nextlsgseectionid_new,

						'customer_booking_monthly_permit_id'=>$nextmonthlypermitid_new,

						'customer_booking_request_ton'=>$requested_ton,

						'customer_booking_token_number'=>$tok_no,

						'customer_booking_priority_number'=>0,

						'customer_booking_allotted_date'=>'',

						'customer_booking_requested_timestamp'=>$currentdate,

						'customer_booking_decission_timestamp'=>'',

						'customer_booking_decission_user'=>'',

						'customer_booking_decission_status'=>'',

						'customer_booking_route'=>$txtrouteunloadplace,

						'customer_booking_distance'=>$txtdistanceunloadplace,

						'customer_booking_requested_ip'=>$ip_address,



						'customer_booking_pass_issue_user'=>'',

						'customer_booking_pass_issue_timestamp'=>'',

						'customer_booking_vehicle_make'=>'',

						'customer_booking_vehicle_registration_number'=>'',

						'customer_booking_driver_name'=>'',

						'customer_booking_driver_license'=>'',

						'customer_booking_permit_number'=>'',

						'customer_booking_chalan_date'=>'',

						'customer_booking_chalan_number'=>$alp_nu,

						'customer_booking_chalan_amount'=>ceil($new_per_ton*$requested_ton)+220+42,

						'customer_booking_current_status'=>1,

						'customer_booking_decission_ip'=>'',

						'customer_booking_pass_issue_ip'=>'',

						'customer_booking_period_name'=>$next_permitperiod,

						'customer_booking_blocked_status'=>'');

					

						$this->db->trans_start();

						$insert_customer_booking=$this->db->insert('customer_booking', $insertnext_booking_data);

						

						$buk_id=$this->db->insert_id();

						$tok_no=substr(number_format(time() * rand(00000,99999) * $buk_id,0,'',''),0,8);

						$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
				$no=$gt_ch->num_rows();

				if($no>0)

				{
					$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
				}

						///space for UID

						$amnt=ceil($new_per_ton*$requested_ton)+220+42;

							$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>$tok_no,

											"PORTCODE"=>$p_code,

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$amnt",

											);                                                                    

								$data_string = json_encode($data);   

								//echo $data_string;                                                                                                                  

					$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

									'Content-Type: application/json',                                                                                

									'Content-Length: ' . strlen($data_string))                                                                       

								);                                                                                                                     

								$result = curl_exec($ch);

								$myArray=json_decode($result, true);

								$uid=$myArray['UID'];

								$ifsc=$myArray['IFSC'];

							if($uid=="")

								{

									//echo $data_string;

									//print_r($myArray);

									//exit;

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');

									redirect('Manual_dredging/Master/customer_booking_add/');

								}

						/////

						$data_trans=array(

						'transaction_customer_registration_id'=>$cutomerregistration_id,

						'transaction_customer_booking_id'=>$buk_id,

						'token_no'=>$tok_no,

						'challan_no'=>$alp_nu,

						'challan_amount'=>ceil($new_per_ton*$requested_ton)+220+42,

						'uid_no'=>$uid,

						'ifsc_code'=>$ifsc,

						'challan_timestamp'=>$currentdate,

						'booking_timestamp'=>$currentdate,

						'zone_id'=>$zone_id,

						'port_id'=>$portid,

						);

						$res_prio=$this->db->query("select last_priority as prioritynum from tbl_priority  where port_id='$portid' and zone_id='$zone_id'");

						$prio_at=$res_prio->result_array();

						$this->db->query("update tbl_priority set last_priority=last_priority+1  where port_id='$portid' and zone_id='$zone_id'");

						$data_prio=array('customer_booking_priority_number'=>$prio_at[0]['prioritynum']+1,

						'customer_booking_token_number'=>$tok_no);

						$this->db->where('customer_booking_id',$buk_id);

						$this->db->update('customer_booking',$data_prio);

						//$this->Master_model->add_trans_det($data_trans);

						$this->db->insert('transaction_details',$data_trans);

						$this->db->trans_complete();

					}

					else

					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Booking  failed!!!2</div>');

													redirect('Manual_dredging/Master/customer_booking_add/'.encode_url($hid_custid));

					}

				}

				}

				

			 

			 }

			 

			 }

			

			

	//***************************************************************************************************************************

		

	//echo "insert----".$insert_customer_booking;break;

				if($insert_customer_booking==1)

				{

				 $customer_booking_insert_id 					= 	$buk_id;

				 

				 $bookmonthlypermit_det			= 	$this->Master_model->get_permitidbooked($customer_booking_insert_id);

				 

				

				 

				 $permitid_booked=$bookmonthlypermit_det[0]['customer_booking_monthly_permit_id'];

				 $booked_date=$bookmonthlypermit_det[0]['customer_booking_requested_timestamp'];

				$bookkeddate= date("Y-m-d", strtotime($booked_date));

									

						//$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Customer Booking added successfully........<br>Your Priority Number ->'.$prioritynew.'</div>');

							//echo	$this->db->last_query(); break;	

						redirect('Manual_dredging/Master/customer_booking_Succ/'.encode_url($customer_booking_insert_id));

					

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Booking  failed!!!5</div>');

													redirect('Manual_dredging/Master/customer_booking_add/'.encode_url($hid_custid));

				}

			

			}//----unusedton >3 else close	

			}//---------------------validation true case

			

		}

		}//booking time check if close//

		else

		{

	

		

		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Not Possible to Book Now !!!!!!</div>');

		redirect('Manual_dredging/Master/customer_home');

		

		}

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

	}


	///--------------------------------------------------------------------------------------------------------------------

	public function customer_bookingapproval()

    {

		$sess_usr_id 			= $this->session->userdata('int_userid');
		$sess_user_type=$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&&($sess_user_type==3 ||$sess_user_type==9))

		{	

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data; 

			//$zonep_id=decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
			$zonep_id=decode_url($this->uri->segment(4));
			if($zonep_id > 0)

			{

				$data['pass_zoneid']=$zonep_id;
				$data = $data + $this->data;
			}

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$get_bookingapproval= ''; //$this->Master_model->bookingapproval($port_id);
			$data['get_bookingapproval']=$get_bookingapproval;
			$data = $data + $this->data;    

			$get_zone_details= $this->Master_model->get_zone_details($port_id);
			$data['get_zone_details']=$get_zone_details;
			$data = $data + $this->data; 

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/customer_bookingapproval', $data);
			$this->load->view('Kiv_views/template/dash-footer');

	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  

    }//---------------------------------------------------------------------------------------------------------------------	

	public function customer_bookingapproval_add()

    {

        $sess_usr_id = $this->session->userdata('int_userid');
		$this->load->model('Manual_dredging/Master_model');	
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$acport_id			=	$userinfo[0]['user_master_port_id'];

		if(!empty($sess_usr_id))

		{	

			//$bid			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$bid			=		$this->uri->segment(4);
			$id			=		decode_url($bid);

			$data = array('title' => 'Add monthly permit', 'page' => 'customer_bookingapproval_add', 'errorCls' => NULL, 'post' => $this->input->post());
			

			$this->load->model('Manual_dredging/Master_model');	

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$cus_det=$this->Master_model->get_cus_buk_ch($id);
			$user_id			=	$cus_det[0]['customer_booking_customer_booking']; 

			if(!empty($id))
			{ 
				$this->load->model('Manual_dredging/Master_model');	
			$customerregupt_data= $this->Master_model->booking_approval_addVw_new($id,$acport_id);
			//print_r($customerregupt_data);
			$data['booking_approval_addVw']=$customerregupt_data;
			$data = $data + $this->data;

			$data['cus_phone']=$customerregupt_data[0]['customer_phone_number'];
			$data = $data + $this->data;

			foreach($customerregupt_data as $rowcustomer)

			{
			 $customerid	=	$rowcustomer['customer_registration_id']; 
			 $customername	=	$rowcustomer['customer_name'];
			 $portid		=	$rowcustomer['customer_booking_port_id'];
			 $maxallotton	=	$rowcustomer['customer_max_allotted_ton'];
			 $bookedpermitid=	$rowcustomer['customer_booking_monthly_permit_id'];
			 $requestedton	=	$rowcustomer['customer_booking_request_ton'];
			 $bookeddate	=	$rowcustomer['customer_booking_requested_timestamp'];
			 $zoneid		=	$rowcustomer['customer_booking_zone_id'];
			}

				$data = $data + $this->data;
				$a_b=explode(" ",$bookeddate);
				$bukd_date=$a_b[0];
				$today=date('Y-m-d');
				$pos_date=date('Y-m-d',strtotime($bukd_date.'+2 days'));

				$checkdailylog=$this->Master_model->check_dailylogtable($bookedpermitid,$acport_id,$requestedton,$zoneid);
				$resrv_date=$this->Master_model->get_permit_reserve($acport_id,$zoneid);

				$jj=0;

				//$rev_d='';

				foreach($resrv_date as $rd)

				{

					$today_d	=	date('Y-m-d');
					$rese_date	=	$rd['holiday_date'];
					$today_d_e	=	date_create($today_d);
					$rese_date_e=	date_create($rese_date);
					$diff		=	date_diff($today_d_e,$rese_date_e);
					$res_dif	=	$diff->format("%a");

					if($res_dif > 2)

					{
					$rev_d[$jj]=$rd['holiday_date'];
					$jj++;
					}
				}

				foreach($checkdailylog as $rowdailylog)

				{
					if(!in_array($rowdailylog['daily_log_date'],$rev_d))
					{
						$dt=$rowdailylog['daily_log_date'];
						if($dt>$pos_date)
						{
							if($dt>$today)
							{
								$allt_date=$dt;
								break;
							}
						}
					}
				}

				$allt_date;
				if(empty($allt_date))

				{
					$data['empty_stats']="true";
					$data = $data + $this->data;
					//exit;
				}
				else
				{

				}

				$data['allt_date']=$allt_date;
				$data = $data + $this->data;

				//exit();

			}

			$data['zoneid']=$zoneid;
			$data = $data + $this->data;

			if($this->input->post())
			{

				$cus_perno		=	$this->security->xss_clean(html_escape($this->input->post('cus_perno')));
				$requested_ton	=	$this->security->xss_clean(html_escape($this->input->post('alttone')));
				$radiobookingStatus	=	$this->security->xss_clean(html_escape($this->input->post('radiobookingStatus')));
				$txtremarks			=	$this->security->xss_clean(html_escape($this->input->post('txtremarks')));
				$customerbook_id	=	$this->security->xss_clean(html_escape($this->input->post('hid_custbookid')));
				$dailylogdate		=	$this->security->xss_clean(html_escape($this->input->post('altdate')));
				$currentdate		=date('Y-m-d H:i:s');
				$dailylogdate	= date('Y-m-d', strtotime($dailylogdate));
				$this->load->model('Manual_dredging/Master_model');	
			//$ip_address				=	$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"])
					{
						$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
					}
				else 
				{
					$ip_address = $_SERVER["REMOTE_ADDR"];
				}

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];


			if($radiobookingStatus==2)
			{
				//-- Send Valid Till Date Bank----//

					$get_ud		=	$this->db->query("select uid_no from transaction_details where transaction_customer_booking_id='$customerbook_id'");
					$get_uid	=	$get_ud->result_array();
					$uid_buk	=	$get_uid[0]['uid_no'];

					$chvaliddate	= date('Y-m-d', strtotime($dailylogdate. ' + 60 days'));

					$data = array(

									"OPCODE"=>"CHALLANDATE",

            						"UID"=>$uid_buk,

            						"CHALLANDATE"=>$chvaliddate

								); 

			                                                           
					$data_string = json_encode($data);   

					//echo $data_string;   exit();                                                                                                               

				$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

					curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

					'Content-Type: application/json',                                                                                

					'Content-Length: ' . strlen($data_string))                                                                       

					);                                                                                                                     

					$result = curl_exec($ch);

					$myArray=json_decode($result, true);

					$resres=$myArray['RESPONSECODE'];

					//print_r($resres);

					$data_ins=array(

					'buk_id'=>$customerbook_id,

					'response'=>$resres

					);

					$this->db->insert("tbl_chellan_valid",$data_ins);
				//-- Send Valid Till Date Bank----//

				/*$bookeddatenew1=strtotime($bookeddate);

					$dailylogdate=$rowdailylog['daily_log_date'];

					$dailylog_date=strtotime($dailylogdate);

					if($bookeddatenew1==$dailylog_date)

					{

						$dailylogdate=$rowdailylog['daily_log_date'];

						break;

					}

					else{}

			

				}*/

				//$tokennumber=$customerid.$portid.$zoneid.$customerbook_id;

				$updateapprove_data=array(

				'customer_booking_allotted_date'		=>	$dailylogdate,

				//'customer_booking_token_number'			=>	$tokennumber,

				'customer_booking_decission_user'		=>	$sess_usr_id,

				'customer_booking_decission_status'		=>	2,

				'customer_booking_decission_remark' => $txtremarks,

				'customer_booking_decission_timestamp'	=>	$currentdate,

				'customer_booking_decission_ip'			=>	$ip_address);

				//print_r($updateapprove_data);

				//exit();

				$result=$this->Master_model->update_customerbooking($updateapprove_data,$customerbook_id);

				$cus_phone=$this->security->xss_clean(html_escape($this->input->post('cus_phone')));

				$mdadate=date("d/m/Y",strtotime(str_replace('-', '/',$dailylogdate)));

				$getzone_id=$this->db->query("select * from customer_booking where customer_booking_id='$customerbook_id'");

				$get_zone_id=$getzone_id->result_array();

				$bu_zone_id=$get_zone_id[0]["customer_booking_zone_id"];

				$zdet=$this->db->query("select * from zone where zone_id='$bu_zone_id'");

				$zone_namedet=$zdet->result_array();

				$buk_zone_name=$zone_namedet[0]["zone_name"];

				if($port_id==10)

				{

				$msg="Dear Customer your sand booking successfully approved.Sand issue Date".$mdadate." and Kadavu - ".$buk_zone_name.".Kadav working time 7:30 AM - 1:00 PM.Customer/representative should bring self attested copies of Aadhar card.";

				}

				else

				{

				$msg="Dear Customer your sand booking successfully approved.Sand issue Date".$mdadate." and Kadavu - ".$buk_zone_name.".Customer/representative should bring self attested copies of Aadhar card.";

				}

				$this->sendSms($msg,$cus_phone);

			}

			else if($radiobookingStatus==3)

			{	

				$updateapprove_data=array(

				'customer_booking_decission_user'		=>	$sess_usr_id,

				'customer_booking_decission_status'		=>	3,

				'customer_booking_decission_timestamp'	=>	$currentdate,

				'customer_booking_decission_remark' => $txtremarks,

				'customer_booking_decission_ip'			=>	$ip_address);

				

				$result=$this->Master_model->update_customerbooking($updateapprove_data,$customerbook_id);

				 }

			

			else 

			{

			//$request_data=array(

//				'customer_decission_user_id'	=>	$sess_usr_id,

//				'customer_decission_timestamp'	=>	$currentdate,

//				'customer_request_status'		=>	$radiorequest_status,

//				'customer_registration_remarks'	=>	$txtremarks);

//				$result=$this->Master_model->update_customerregistration($request_data,$customerreg_id);

			}

				if($result==1)

				{

					if($radiobookingStatus==2)

					{

						//$dailylogdate

						$cperiod=date('F Y');

						$res_permitquery=$this->db->query("Update monthly_permit set monthly_permit_booked_ton=monthly_permit_booked_ton + $requested_ton,monthly_permit_balance_ton=monthly_permit_balance_ton - $requested_ton where zone_id='$bu_zone_id' and monthly_permit_period_name='$cperiod' and monthly_permit_permit_status=2");

	//echo "Update daily_log set daily_log_booked=(daily_log_booked + $requested_ton),daily_log_balance=(daily_log_balance - $requested_ton) where daily_log_date='$dailylogdate' and daily_log_zone_id='$bu_zone_id'";

		$res_dailyquery=$this->db->query("Update daily_log set daily_log_booked=(daily_log_booked + $requested_ton),daily_log_balance=(daily_log_balance - $requested_ton) where daily_log_date='$dailylogdate' and daily_log_zone_id='$bu_zone_id'");
		//exit();

		//$res_dailyquery=$this->db->query("Update customer_registration set customer_used_ton=customer_used_ton + $requested_ton,customer_unused_ton  =	customer_unused_ton - $requested_ton where daily_log_date='$dailylogdate' and customer_registration_id='$customerid'");

						

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Booking Approved successfully</div>');
						redirect('Manual_dredging/Master/customer_bookingapproval/'.encode_url($bu_zone_id));

					}

					else

					{

						$getzone_id=$this->db->query("select * from customer_booking where customer_booking_id='$customerbook_id'");
						$get_zone_id=$getzone_id->result_array();
						$bu_zone_id=$get_zone_id[0]["customer_booking_zone_id"];
						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Booking Rejected Rejected</div>');
					    redirect('Manual_dredging/Master/customer_bookingapproval/'.encode_url($bu_zone_id));

					}

				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Booking Rejected</div>');
					redirect('Manual_dredging/Master/customer_bookingapproval');

				}
			}
			$this->load->view('Manual_dredging/Master/customer_bookingapproval_add', $data);
			$this->load->view('Kiv_views/template/dash-footer');
		
		}
		else
		{
				redirect('Manual_dredging/settings/index');        
		}

    }

//////





//////////////////////////// Gopika End







/////////////////





////////////////////Liju  Start ////////////////////////////////////// 



public function workerregistration()

	{

		//checking of session set or not
		$this->load->model('Manual_dredging/Master_model');	
		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		//$lsg_id				= $user_details['user_master_lsg_id'];

		$reg_worker_list= $this->Master_model->get_worker_registration($zone_id);

		//print_r($reg_worker_list);break;

		if(!empty($sess_usr_id) && $sess_user_type==4)

		{	

			$data = array('title' => 'module', 'page' => 'worker registration', 'errorCls' => NULL, 'post' => $this->input->post());

			$data['reg_worker_list']=$reg_worker_list; 

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/workerRegistration',$data);
			$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   }

	   else

	   {

			redirect('Main_login/index');        

	   }  

	

	}

	

	// registration of worker

	function workerregistration_add()

    {

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		

		if(!empty($sess_usr_id) && $sess_user_type==4)

		{	

			$btn_add=$this->security->xss_clean(html_escape($this->input->post('btn_add')));

			$user_id=$sess_usr_id;

			$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

			//print_r($user_details);break;

			$port_id			= $user_details['user_master_port_id'];

			$zone_id			= $user_details['user_master_zone_id'];

			$lsg_id				= $user_details['user_master_lsg_id'];

			$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

			if($btn_add)

			{

				$this->form_validation->set_rules('worker_adhar_no', 'Adhar No','required|callback_adharcheck');

				$this->form_validation->set_rules('worker_name', 'Name','required|callback_alphanum_only_space');

				$this->form_validation->set_rules('worker_father_name', 'Father Name','required|callback_alphanum_only_space');

				$this->form_validation->set_rules('worker_address', 'Address ','required');

				$this->form_validation->set_rules('worker_phone_number', 'Phone Number','required|numeric');

				//$this->form_validation->set_rules('zone_id', 'Zone','required');

				$this->form_validation->set_rules('worker_status', 'Status','required');

				

				if ($this->form_validation->run() == FALSE)

				{

					validation_errors();

					$this->session->set_flashdata('msg', "<div id='msgDiv' class='alert alert-info alert-dismissible'>".validation_errors().'

					</div>');

				}

				else

				{   

					$sess_usr_id = $this->session->userdata('int_userid');

					$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

					$port_id			= $user_details['user_master_port_id'];

					$zone_id			= $user_details['user_master_zone_id'];

					$lsg_id				= $user_details['user_master_lsg_id'];

					$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

					//Check whether the Number of  Workers is Exceeds the "lsg_zone_number_of_workers" in Table "lsg_zone"

					$MaxWorkerCount=$this->Master_model->get_max_workercount_lsg_zone($zone_id,$lsg_id);

					$MaxWorkerCount=$MaxWorkerCount['lsg_zone_number_of_workers'];

					$no_of_workers		= $this->Master_model->get_no_of_workers($sess_usr_id);

					$no_of_workers		= $no_of_workers['lsg_section_current_workers'];

					if($MaxWorkerCount!='' && $MaxWorkerCount>0){

						

						if($no_of_workers>=$MaxWorkerCount){

							$this->session->set_flashdata('msg', '<div class="alert alert-info alert-error">Sorry !!! Allowed number of workers registration is Completed, If you want to add more workers please Update the Max no of Workers for this LSGD first !!!</div>');

							redirect('Manual_dredging/Master/workerregistration');

						}

					}else{

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-error">Sorry !!! Please Set the Max no of Workers for this LSGD first !!!</div>');

						redirect('Manual_dredging/Master/workerregistration');

					}

					$worker_adhar_no=$this->security->xss_clean(html_escape($this->input->post('worker_adhar_no')));

					$worker_name=$this->security->xss_clean(html_escape($this->input->post('worker_name')));

					$worker_father_name=$this->security->xss_clean(html_escape($this->input->post('worker_father_name')));

					$worker_address=$this->security->xss_clean(html_escape($this->input->post('worker_address')));

					$worker_phone_number=$this->security->xss_clean(html_escape($this->input->post('worker_phone_number')));

					//$zone_id=$this->input->post('zone_id');

					$worker_status=$this->security->xss_clean(html_escape($this->input->post('worker_status')));

					

					$worker_adhar_no			= 	$this->security->xss_clean(htmlentities($worker_adhar_no));

					$worker_name				= 	$this->security->xss_clean(htmlentities($worker_name));

					$worker_father_name			= 	$this->security->xss_clean(htmlentities($worker_father_name));

					$worker_address				= 	$this->security->xss_clean(htmlentities($worker_address));

					$worker_phone_number		= 	$this->security->xss_clean(htmlentities($worker_phone_number));

					//$zone_id					= 	$this->security->xss_clean(htmlentities($zone_id));

					$worker_status				= 	$this->security->xss_clean(htmlentities($worker_status));

					//Check Whether this Adhar no is already Exists

					$isDuplicateAdhar=$this->Master_model->worker_adhar_check($worker_adhar_no);

					if(count($isDuplicateAdhar)>0){

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-error">Sorry !!! This Adhar Number is Already Exist!!!</div>');

						redirect('Manual_dredging/Master/workerregistration');

					}

					$data = array(

						'worker_registration_aadhar_number' => $worker_adhar_no,  

						'worker_registration_name' => $worker_name,

						'worker_registration_father_name' => $worker_father_name,

						'worker_registration_address' => $worker_address,

						'worker_registration_phone_number'=>$worker_phone_number,

						'worker_registration_status'=>$worker_status,

						'user_id'=>$user_id,

						'port_id'=>$port_id,

						'zone_id' => $zone_id,

						'lsg_id' => $lsg_id

					);

		

					$usr_res=$this->db->insert('worker_registration', $data);

					//INCREMENTING THE "lsg_section_current_workers" IN TABLE "lsg_section"

					//$this->db->where('zone_id', $zone_id);

					//$this->db->set('lsg_section_current_workers', 'lsg_section_current_workers+1', FALSE);

					$upd_no_worker=$this->Master_model->increment_current_worker($zone_id,$lsg_id);

					//$upd_no_worker=$this->db->update('lsg_section');

					if($usr_res && $upd_no_worker){

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-success">Worker added Successfully!!!</div>');

						redirect('Manual_dredging/Master/workerregistration_add');

					} 

					else{ 

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, an error occured !!!</div>'); 		

						redirect('Manual_dredging/Master/workerregistration');

					} 

				}

			}

			

			$data = array('title' => 'Add Worker', 'page' => 'workerregistration_add', 'errorCls' => NULL, 'post' => $this->input->post());

			//$array_zone= $this->Master_model->get_lsg_zones($lsg_id);

			//$data['array_zone']=$array_zone; 

			$array_status = $this->Master_model->get_status();

			$data['array_status']=$array_status; 

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/workerregistration_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

		else

		{

			redirect('Manual_dredging/settings/index');        

		}

    }

	public function workerregistration_view()

	{

		//checking of session set or not

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		if(!empty($sess_usr_id) && $sess_user_type==4)

		{	

			$data = array('title' => 'module', 'page' => 'worker registration', 'errorCls' => NULL, 'post' => $this->input->post());

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$edtidenc			=		$this->uri->segment(4);
			//$data['edtidenc']		=	$edtidenc;

			$edtid 					= 	decode_url($edtidenc); 

			$get_worker_details		= 	$this->Master_model->get_worker_details($edtid);

			$data['get_worker_details']			=	$get_worker_details; 

			

			$data['worker_id'] 					= 	$get_worker_details['worker_registration_id'];

			$data['worker_adhar_no'] 			= 	$get_worker_details['worker_registration_aadhar_number'];

			$data['worker_name'] 				= 	$get_worker_details['worker_registration_name'];

			$data['worker_father_name'] 		= 	$get_worker_details['worker_registration_father_name'];

			$data['worker_address'] 			= 	$get_worker_details['worker_registration_address'];

			$data['worker_phone_number'] 		= 	$get_worker_details['worker_registration_phone_number'];

			$data['worker_status']				= 	$get_worker_details['worker_registration_status'];

			$data['zone_id'] 					= 	$get_worker_details['zone_id'];

			$zone_name							=	$this->Master_model->get_zone_name_by_id($get_worker_details['zone_id']);

			$data['zone_name'] 					= 	$zone_name['zone_name'];

			$data = $data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/workerregistration_view',$data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   }

	   else

	   {

			redirect('Main_login/index');        

	   }  

	

	}

	public function workerregistration_edit()

	{

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		$lsg_id				= $user_details['user_master_lsg_id'];

		if(!empty($sess_usr_id) && $sess_user_type==4)

		{	

			$user_id=$sess_usr_id;

			$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

			$port_id			= $user_details['user_master_port_id'];

			//$zone_id			= $user_details['user_master_zone_id'];

			$data = array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$edtidenc 				= 	$this->uri->segment(4);
			//$data['edtidenc']		=	$edtidenc;

			$edtid 					= 	decode_url($edtidenc); 

			$get_worker_details		= 	$this->Master_model->get_worker_details($edtid);

			$data['get_worker_details']			=	$get_worker_details; 

			

			//DECREMENTING THE "lsg_section_current_workers" IN TABLE "lsg_section"

			//$this->Master_model->decrement_current_worker($get_worker_details['zone_id'],$get_worker_details['lsg_id']);

			

			$data['worker_id'] 					= 	$get_worker_details['worker_registration_id'];

			$data['worker_adhar_no'] 			= 	$get_worker_details['worker_registration_aadhar_number'];

			$data['worker_name'] 				= 	$get_worker_details['worker_registration_name'];

			$data['worker_father_name'] 		= 	$get_worker_details['worker_registration_father_name'];

			$data['worker_address'] 			= 	$get_worker_details['worker_registration_address'];

			$data['worker_phone_number'] 		= 	$get_worker_details['worker_registration_phone_number'];

			$data['worker_status']				= 	$get_worker_details['worker_registration_status'];

			$data['zone_id'] 					= 	$get_worker_details['zone_id'];

			$data['lsg_id'] 					= 	$get_worker_details['lsg_id'];

			

			$array_zone= $this->Master_model->get_lsg_zones($lsg_id);

			$data['array_zone']=$array_zone; 

				

			$array_status = $this->Master_model->get_status();

			$data['array_status']=$array_status; 

			$data 					= 	$data + $this->data;     

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/workerregistration_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			

			

        	if(isset($_REQUEST['btn_add'])){

				

				$sess_usr_id = $this->session->userdata('int_userid');

				$sess_user_type=$this->session->userdata('int_usertype');

				$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

				$port_id			= $user_details['user_master_port_id'];

				$zone_id			= $user_details['user_master_zone_id'];

				$lsg_id				= $user_details['user_master_lsg_id'];

				

				$hid=$this->security->xss_clean(html_escape($this->input->post('hid')));

				$hid = $this->security->xss_clean(htmlentities($hid));

				$enc_hid= encode_url($hid); 

				$this->form_validation->set_rules('worker_adhar_no', 'Adhar No','required|numeric');

				$this->form_validation->set_rules('worker_name', 'Name','required|callback_alphanum_only_space');

				$this->form_validation->set_rules('worker_father_name', 'Father Name','required|callback_alphanum_only_space');

				$this->form_validation->set_rules('worker_address', 'Address ','required');

				$this->form_validation->set_rules('worker_phone_number', 'Phone Number','required|numeric');

				//$this->form_validation->set_rules('zone_id', 'Zone','required');

				$this->form_validation->set_rules('worker_status', 'Status','required');

				

				if ($this->form_validation->run() == FALSE)

				{

					validation_errors();

					$this->session->set_flashdata('msg', "<div id='msgDiv' class='alert alert-info alert-dismissible'>".validation_errors().'

					</div>');

					redirect("Master/workerregistration_edit/$enc_hid");

				}

				else

				{   

					$worker_adhar_no=$this->security->xss_clean(html_escape($this->input->post('worker_adhar_no')));

					$worker_name=$this->security->xss_clean(html_escape($this->input->post('worker_name')));

					$worker_father_name=$this->security->xss_clean(html_escape($this->input->post('worker_father_name')));

					$worker_address=$this->security->xss_clean(html_escape($this->input->post('worker_address')));

					$worker_phone_number=$this->security->xss_clean(html_escape($this->input->post('worker_phone_number')));

					//$zone_id=$this->input->post('zone_id');

					$worker_status=$this->security->xss_clean(html_escape($this->input->post('worker_status')));

					

					$worker_adhar_no			= 	$this->security->xss_clean(htmlentities($worker_adhar_no));

					$worker_name				= 	$this->security->xss_clean(htmlentities($worker_name));

					$worker_father_name			= 	$this->security->xss_clean(htmlentities($worker_father_name));

					$worker_address				= 	$this->security->xss_clean(htmlentities($worker_address));

					$worker_phone_number		= 	$this->security->xss_clean(htmlentities($worker_phone_number));

					//$zone_id					= 	$this->security->xss_clean(htmlentities($zone_id));

					$worker_status				= 	$this->security->xss_clean(htmlentities($worker_status));

					

					//INCREMENTING THE "lsg_section_current_workers" IN TABLE "lsg_section"

					//$this->Master_model->increment_current_worker($zone_id,$get_worker_details['lsg_id']);

					

					$data = array(

						'worker_registration_aadhar_number' => $worker_adhar_no,  

						'worker_registration_name' => $worker_name,

						'worker_registration_father_name' => $worker_father_name,

						'worker_registration_address' => $worker_address,

						'worker_registration_phone_number'=>$worker_phone_number,

						'worker_registration_status'=>$worker_status,

						'user_id'=>$user_id,

						'port_id'=>$port_id,

						'zone_id'=> $zone_id,

					);

		

					$this->db->where('worker_registration_id', $hid);

					$worker_res=$this->db->update('worker_registration', $data);

					

					if($worker_res){

														

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Worker Updated successfully!!!</div>');

						redirect('Manual_dredging/Master/workerregistration');

					} 

					else{ 

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, an error occured !!!</div>'); 		

						redirect("Manual_dredging/Master/workerregistration_edit/$enc_hid");

					} 

				}

				

			}

		}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

			

		/*$this->load->view('template/footer');

		$this->load->view('template/js-footer');

		$this->load->view('template/script-footer');

		$this->load->view('template/html-footer');*/

	}

	

	public function canoeregistration()

	{

		//checking of session set or not

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$reg_canoe_list= $this->Master_model->get_canoe_registration($port_id);

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7 || $sess_user_type==9))

		{	

			$data = array('title' => 'module', 'page' => 'canoe registration', 'errorCls' => NULL, 'post' => $this->input->post());

			$data['reg_canoe_list']=$reg_canoe_list; 

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/canoeregistration', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   }

	   else

	   {

			redirect('Main_login/index');        

	   }  

	

	}

		

	// registration of canoe for zone

	function canoeregistration_add()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7 || $sess_user_type==9))

		{	

			$btn_add=$this->input->post('btn_add');

			$user_id=$sess_usr_id;

			$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

			$port_id			= $user_details['user_master_port_id'];

			//$zone_id			= $user_details['user_master_zone_id'];

			//$lsg_id				= $user_details['user_master_lsg_id'];

			//print_r($reg_fee['fee_master_fee']);break;

			if($btn_add)

			{

				$this->form_validation->set_rules('canoe_registration_number', 'Registration no','required');

				$this->form_validation->set_rules('canoe_name', 'Name','required|callback_alphanum_only_space');

				$this->form_validation->set_rules('canoe_capacity', 'Capacity','required|numeric');

				$this->form_validation->set_rules('number_of_workers', 'No of workers','required|numeric|max_length[2]');

				$this->form_validation->set_rules('canoe_registration_fee', 'Rgistration Fee','required|numeric');

				$this->form_validation->set_rules('zone_id', 'Zone','required');

				$this->form_validation->set_rules('canoe_status', 'Status','required');

				

				if ($this->form_validation->run() == FALSE)

				{

					validation_errors();

					$this->session->set_flashdata('msg', "<div id='msgDiv' class='alert alert-info alert-dismissible'>".validation_errors().'

					</div>');

				}

				else

				{    

					$canoe_registration_number=$this->input->post('canoe_registration_number');

					$canoe_name=$this->input->post('canoe_name');

					$canoe_capacity=$this->input->post('canoe_capacity');

					$number_of_workers=$this->input->post('number_of_workers');

					$canoe_registration_fee=$this->input->post('canoe_registration_fee');

					$zone_id=$this->input->post('zone_id');

					$ls=$this->Master_model->get_zoneBycanID($zone_id);

					$lsg_id=$ls[0]['lsg_id'];

					$canoe_status=$this->input->post('canoe_status');

					

					$canoe_registration_number	= 	$this->security->xss_clean(htmlentities($canoe_registration_number));

					$canoe_name					= 	$this->security->xss_clean(htmlentities($canoe_name));

					$canoe_capacity				= 	$this->security->xss_clean(htmlentities($canoe_capacity));

					$number_of_workers			= 	$this->security->xss_clean(htmlentities($number_of_workers));

					$canoe_registration_fee		= 	$this->security->xss_clean(htmlentities($canoe_registration_fee));

					$zone_id					= 	$this->security->xss_clean(htmlentities($zone_id));

					$canoe_status				= 	$this->security->xss_clean(htmlentities($canoe_status));

					

					$data = array(

						'canoe_registration_number' => $canoe_registration_number,  

						'canoe_name' => $canoe_name,

						'canoe_capacity' => $canoe_capacity,

						'canoe_number_of_workers' => $number_of_workers,

						'canoe_registration_fee'=>$canoe_registration_fee,

						'canoe_registration_status'=>$canoe_status,

						'user_id'=>$user_id,

						'port_id '=>$port_id,

						'zone_id ' => $zone_id,

						'lsg_id ' => $lsg_id

					);

		

					$can_suc=$this->db->insert('canoe_registration', $data);

					if($can_suc){

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-success">Canoe added to Database!!!</div>');

						redirect('Manual_dredging/Master/canoeregistration');

					} 

					else{ 

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, an error occured !!!</div>'); 		

						redirect('Manual_dredging/Master/canoeregistration_add');

					} 

				}

			}

			$data = array('title' => 'Add canoe', 'page' => 'canoeregistration_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$array_zone= $this->Master_model->get_zone_by_portID($port_id);

			$data['array_zone']=$array_zone; 

				

			$array_status = $this->Master_model->get_status();

			$data['array_status']=$array_status; 

			$reg_fee= $this->Master_model->get_canoe_registration_fee();

			$canoe_registration_fee=$reg_fee['fee_master_fee']; 

			if($canoe_registration_fee=='' || $canoe_registration_fee==0){

				$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry,Please Set the Canoe Registration Fee first !!!</div>'); 		

				redirect('Manual_dredging/Master/canoeregistration');

			}

			$data['canoe_registration_fee']=$canoe_registration_fee; 

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/canoeregistration_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

    }

	public function canoeregistration_view()

	{

		//checking of session set or not

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7 || $sess_user_type==9))

		{	

			$data = array('title' => 'module', 'page' => 'canoe registration', 'errorCls' => NULL, 'post' => $this->input->post());

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$edtidenc 				= 	$this->uri->segment(4);
			$data['edtidenc']		=	$edtidenc;

			$edtid 					= 	decode_url($edtidenc); 

			$get_canoe_details		= 	$this->Master_model->get_canoe_details($edtid);

			$data['get_canoe_details']			=	$get_canoe_details; 

			$data['canoe_id'] 					= 	$get_canoe_details['canoe_registration_id'];

			$data['canoe_registration_number'] 	= 	$get_canoe_details['canoe_registration_number'];

			$data['canoe_name'] 				= 	$get_canoe_details['canoe_name'];

			$data['canoe_capacity'] 			= 	$get_canoe_details['canoe_capacity'];

			$data['number_of_workers'] 			= 	$get_canoe_details['canoe_number_of_workers'];

			$data['canoe_registration_fee'] 	= 	$get_canoe_details['canoe_registration_fee'];

			$data['canoe_status']				= 	$get_canoe_details['canoe_registration_status'];

			$data['zone_id'] 					= 	$get_canoe_details['zone_id'];

			$zone_name							=	$this->Master_model->get_zone_name_by_id($get_canoe_details['zone_id']);

			$data['zone_name'] 					= 	$zone_name['zone_name'];

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/canoeregistration_view', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   }

	   else

	   {

			redirect('Main_login/index');        

	   }  

	

	}

	public function canoeregistration_edit()

	{

		$sess_usr_id 		= $this->session->userdata('int_userid');
		$sess_user_type		= $this->session->userdata('int_usertype');
		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);
		$port_id			= $user_details['user_master_port_id'];
		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7 || $sess_user_type==9))
		{	

			$data = array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data = $data + $this->data;

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$edtidenc 				= 	$this->uri->segment(4);
			$data['edtidenc']		=	$edtidenc;
			$edtid 					= 	decode_url($edtidenc); 

			$get_canoe_details		= 	$this->Master_model->get_canoe_details($edtid);
			$data['get_worker_details']			=	$get_canoe_details; 
			$data['canoe_id'] 					= 	$get_canoe_details['canoe_registration_id'];
			$data['canoe_registration_number'] 	= 	$get_canoe_details['canoe_registration_number'];
			$data['canoe_name'] 				= 	$get_canoe_details['canoe_name'];
			$data['canoe_capacity'] 			= 	$get_canoe_details['canoe_capacity'];
			$data['number_of_workers'] 			= 	$get_canoe_details['canoe_number_of_workers'];
			$data['canoe_registration_fee'] 	= 	$get_canoe_details['canoe_registration_fee'];
			$data['canoe_status']				= 	$get_canoe_details['canoe_registration_status'];
			$data['zone_id'] 					= 	$get_canoe_details['zone_id'];

			//$array_zone= $this->Master_model->get_zone();
			$array_zone= $this->Master_model->get_zone_by_portID($port_id);
			$data['array_zone']=$array_zone; 
	
			$array_status = $this->Master_model->get_status();
			$data['array_status']=$array_status; 
			$data 					= 	$data + $this->data;     

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/canoeregistration_add', $data);
			$this->load->view('Kiv_views/template/dash-footer');
				
        	if(isset($_REQUEST['btn_add']))
			{

				$hid=$this->input->post('hid');
				$hid	= 	$this->security->xss_clean(htmlentities($hid));
				$enc_hid= encode_url($hid); 
				$this->form_validation->set_rules('canoe_registration_number', 'Registration no','required');
				$this->form_validation->set_rules('canoe_name', 'Name','required|callback_alphanum_only_space');
				$this->form_validation->set_rules('canoe_capacity', 'Capacity','required|numeric');
				$this->form_validation->set_rules('number_of_workers', 'No of workers','required|numeric|max_length[2]');
				$this->form_validation->set_rules('canoe_registration_fee', 'Rgistration Fee','required|numeric');
				$this->form_validation->set_rules('zone_id', 'Zone','required');
				$this->form_validation->set_rules('canoe_status', 'Status','required');				

				if ($this->form_validation->run() == FALSE)

				{

				echo validation_errors();
				$this->session->set_flashdata('msg', "<div id='msgDiv' class='alert alert-info alert-dismissible'>".validation_errors().'
					</div>');
					redirect("Manual_dredging/Master/canoeregistration_edit/$enc_hid");

				}

				else

				{   

					$canoe_registration_number	=	$this->input->post('canoe_registration_number');
					$canoe_name					=	$this->input->post('canoe_name');
					$canoe_capacity				=	$this->input->post('canoe_capacity');
					$number_of_workers			=	$this->input->post('number_of_workers');
					$canoe_registration_fee		=	$this->input->post('canoe_registration_fee');
					$zone_id					=	$this->input->post('zone_id');
					$canoe_status				=	$this->input->post('canoe_status');

					$canoe_registration_number	= 	$this->security->xss_clean(htmlentities($canoe_registration_number));
					$canoe_name					= 	$this->security->xss_clean(htmlentities($canoe_name));
					$canoe_capacity				= 	$this->security->xss_clean(htmlentities($canoe_capacity));
					$number_of_workers			= 	$this->security->xss_clean(htmlentities($number_of_workers));
					$canoe_registration_fee		= 	$this->security->xss_clean(htmlentities($canoe_registration_fee));
					$zone_id					= 	$this->security->xss_clean(htmlentities($zone_id));
					$canoe_status				= 	$this->security->xss_clean(htmlentities($canoe_status));

					

					$data = array(

						'canoe_registration_number' => $canoe_registration_number,  
						'canoe_name' => $canoe_name,
						'canoe_capacity' => $canoe_capacity,
						'canoe_number_of_workers' => $number_of_workers,
						'canoe_registration_fee'=>$canoe_registration_fee,
						'canoe_registration_status'=>$canoe_status,
						'user_id'=>$user_id,
						'port_id '=>$port_id,
						'zone_id ' => $zone_id,
					);

		

					$this->db->where('canoe_registration_id', $hid);
					$worker_res=$this->db->update('canoe_registration', $data);
					if($worker_res)
					{
													
						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Canoe Updated successfully!!!</div>');
						redirect('Manual_dredging/Master/canoeregistration');
					} 

					else{ 

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, an error occured !!!</div>'); 		

						redirect("Manual_dredging/Master/canoeregistration_edit/$enc_hid");

					} 

				}

				

			}

		}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

		
	}

	

	public function monthlypermitapproval()

	{

		//checking of session set or not

		$sess_usr_id = $this->session->userdata('int_userid');
		$sess_user_type=$this->session->userdata('int_usertype');
		$this->load->model('Manual_dredging/Master_model');	
		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);
		$user_master_port_id= $user_details['user_master_port_id'];
		$monthly_permit_list= $this->Master_model->get_port_monthly_permit_list($user_master_port_id);

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			$data = array('title' => 'module', 'page' => 'monthly permit', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$data['monthly_permit_list'] = $monthly_permit_list;
			$this->load->model('Manual_dredging/Master_model');	
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/monthlypermitapproval', $data);
			$this->load->view('Kiv_views/template/dash-footer');		
	   }

	   else

	   {

			redirect('Main_login/index');        
	   }  
	}

	

	//

	public function monthlypermit()

	{

		//checking of session set or not
		$this->load->model('Manual_dredging/Master_model');
		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		$lsgd_id			= $user_details['user_master_lsg_id'];

		$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

		$monthly_permit_list= $this->Master_model->get_monthly_permit_list($sess_usr_id);

		$zone_name	=	$this->Master_model->get_zone_name_by_id($zone_id);

		$lsgd_name	=	$this->Master_model->get_lsgdname_by_id($lsgd_id);

		if(!empty($sess_usr_id) && $sess_user_type==4)

		{	

			$data = array('title' => 'module', 'page' => 'monthly permit approval', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$data['monthly_permit_list'] = $monthly_permit_list;

			$data['zone_name'] = $zone_name['zone_name'];

			$data['lsgd_name'] = $lsgd_name['lsgd_name'];

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/monthlypermit', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
	   }

	   else

	   {

			redirect('Main_login/index');        

	   }  

	

	}

	function monthlypermit_add()

    {
    	$this->load->model('Manual_dredging/Master_model');
		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		//print_r($user_details);break;

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		$lsgd_id			= $user_details['user_master_lsg_id'];

		$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

		$no_of_workers		= $this->Master_model->get_no_of_workers($sess_usr_id);

		//print_r($no_of_workers);break;

		$worker_quantity 	= $this->Master_model->worker_quantity();

		$no_of_workers	 	= $no_of_workers['lsg_section_current_workers']; 

		$worker_quantity	= $worker_quantity['worker_quantity'];

		$permit_requested_ton=($worker_quantity)*($no_of_workers);

		$plinth_cutoffdate 	= $this->Master_model->plinth_cutoffdate();

		$plinth_cutoffdate 	=$plinth_cutoffdate['cutoff_date'];

		

		if(!empty($sess_usr_id) && $sess_user_type==4)

		{	

			if(isset($_REQUEST['btn_add'])){

				//echo '<pre>';print_r($_POST);break;
				$this->load->model('Manual_dredging/Master_model');
				$sess_usr_id = $this->session->userdata('int_userid');

				$sess_user_type=$this->session->userdata('int_usertype');

				$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

				//print_r($user_details);break;

				$port_id			= $user_details['user_master_port_id'];

				$zone_id			= $user_details['user_master_zone_id'];

				$lsgd_id			= $user_details['user_master_lsg_id'];

				$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

				

				$hid=$this->input->post('hid');

				$hid=$this->security->xss_clean(htmlentities($hid));

				$enc_hid= encode_url($hid); 

				$this->form_validation->set_rules('start_date', 'Start Date','required');

				$this->form_validation->set_rules('end_date', 'End date','required');

				$this->form_validation->set_rules('number_of_workers', 'Number of workers','required|numeric|greater_than[0]|callback_check_worker_count');

				$this->form_validation->set_rules('permit_requested_ton','Required Quantity of sand','required|numeric|less_than_equal_to['.$permit_requested_ton.']|greater_than[0]');

				//$this->form_validation->set_rules('permit_order_number', 'Order No','required');

				$this->form_validation->set_rules('permit_remarks', 'Monthly Permit Remarks','alpha_numeric_spaces');

				if ($this->form_validation->run() == FALSE)

				{

					validation_errors();

					$this->session->set_flashdata('msg', "<div id='msgDiv' class='alert alert-error'>".validation_errors().'

					</div>');

				}

				else

				{    

					$start_date=$this->input->post('start_date');

					$start_date	= $this->security->xss_clean(htmlentities($start_date));

					//$start_date = explode('/', $start_date);

					//$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];

					$end_date=$this->input->post('end_date');

					$end_date = $this->security->xss_clean(htmlentities($end_date));

					//$end_date = explode('/', $end_date);

					//$end_date =$end_date[2]."-".$end_date[1]."-".$end_date[0];

					$permit_requested_ton=$this->input->post('permit_requested_ton');

					$number_of_workers=$this->input->post('number_of_workers');

					$permit_remarks=$this->input->post('permit_remarks');

					$permit_order_number=$this->input->post('permit_order_number');

					$permit_order_number = $this->security->xss_clean(htmlentities($permit_order_number));

					$number_of_workers = $this->security->xss_clean(htmlentities($number_of_workers));

					$permit_order_number = $this->security->xss_clean(htmlentities($permit_order_number));

					$permit_remarks = $this->security->xss_clean(htmlentities($permit_remarks));

					$period_name=date("F Y", strtotime($start_date));

					

					//Checking holidays for the current period is set 

					//$holidayStatus=$this->Master_model->get_port_holiday_status($port_id,$period_name);

					$holidayStatus=$this->Master_model->get_port_holiday_statusnew($port_id,$zone_id,$period_name);

					if($holidayStatus!=''){

						if($holidayStatus['holiday_port_status']==0){

							$this->session->set_flashdata('msg', '<div class="alert alert-error">Sorry, Please set the Holidays for the given Permit Period First !!!</div>'); 

							redirect("Manual_dredging/Master/monthlypermit_add");

						}

					}else{

						$this->session->set_flashdata('msg', '<div class="alert alert-error">Sorry,The holidays for the given Permit Period is not found !!!</div>'); 

						redirect("Manual_dredging/Master/monthlypermit_add");

					}

					$no_of_working_days	= $this->Master_model->get_monthly_working_daysnew($port_id,$zone_id,$period_name);

					if($no_of_working_days['working_days']!=''&& $no_of_working_days['working_days']>0){

						$no_of_working_days=$no_of_working_days['working_days'];

					}else{

						$this->session->set_flashdata('msg', '<div class="alert alert-error">Sorry, No working days for the given Permit Period is found !!!</div>'); 

						redirect("Manual_dredging/Master/monthlypermit_add");

					}

					//CHECKING MONTHLY PERIOD IS ALREADY ADDED FOR THIS PERIOD 

					$isMonthlyPeriodSet=$this->Master_model->get_lsgd_montlyPermit_by_periodname($period_name,$port_id,$lsgd_section_id);

					if(count($isMonthlyPeriodSet)>0){

						$this->session->set_flashdata('msg', '<div class="alert alert-error">Sorry, Monthly Permit for the given period is already exists !!!</div>'); 		

						redirect('Manual_dredging/Master/monthlypermit');

					}

					//print_r($worker_quantity);break;

					

					//Calculating Sand rate

					$get_zone_type=$this->db->query("select zone_type as zt from zone where zone_id='$zone_id'");

					//$this->db->last_query();

					$getzone=$get_zone_type->result_array();

					$zone_type=$getzone[0]['zt'];

					$port_id;

					//exit;

					if($zone_type==2)

					{

						$amt_wt=0;

						$amt_wt1=0;	

						$amt_wt2=0;

						$amt_wt4=0;

						$tax=$this->Master_model->get_materials_with_tax();

					 	$mat_id=$tax['tax_calculator_materials'];

 						$ma=explode(',',$mat_id);

 						//print_r($ma);

						$t_rate=$tax['tax_calculator_rate'];

						$material=$this->Master_model->get_material_master_act();

 						foreach($material as $mat)

 						{

							$mid=$mat['material_master_id'];

		 					if($mat['material_master_authority']==1)

		 					{

								if(in_array($mid,$ma))

			 					{

									//echo $mid;

				 					$m_r=$this->Master_model->get_materialrateByMatID_mech($mid);

				 					$amt_wt=$amt_wt+($m_r[0]['mat_amount']+($m_r[0]['mat_amount']*($t_rate/100)));

			 					}

			 					else

			 					{

									$m_r=$this->Master_model->get_materialrateByMatID_mech($mid);

				 					$amt_wt1= $amt_wt1+$m_r[0]['mat_amount'];

			 					}

							}

							else

							{

								if(in_array($mid,$ma))

			 					{

				 					//echo $mat['material_master_id'];

				 					$m_r=$this->Master_model->get_materialrateByMatID_port_mech($mid,$port_id);

				 					//print_r($m_r);

				 					$amt_wt2=$amt_wt2+($m_r[0]['mat_amount']+($m_r[0]['mat_amount']*($t_rate/100)));

			 					}

			 					else

			 					{

				 					$m_r=$this->Master_model->get_materialrateByMatID_port_mech($mid,$port_id);

							 		$amt_wt4=$amt_wt4+$m_r[0]['mat_amount'];

							 	}

							}

						}

						//echo $amt_wt."/".$amt_wt1."/".$amt_wt2."/".$amt_wt4;

					$sand_rate=ceil($amt_wt+$amt_wt1+$amt_wt2+$amt_wt4)-220;

					//exit;

					}

					else

					{

				//---------------------------------------------------------------------------------------------------------------------------------------

				

 

 $tax=$this->Master_model->get_materials_with_tax();

 $mat_id=$tax['tax_calculator_materials'];

 $ma=explode(',',$mat_id);

 $t_rate=$tax['tax_calculator_rate'];

 $amt_wt=0;

 $amt_wt1=0;

 $amt_wt2=0;

 $amt_wt3=0;

 $amt_wt4=0;

 $amt_wt5=0;

 $material=$this->Master_model->get_material_master_act();

 foreach($material as $mat)

 {

	 $mid=$mat['material_master_id'];

	

		 if($mat['material_master_authority']==1)

		 {

			 if(in_array($mid,$ma))

			 {

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 $amt_wt=$amt_wt+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

			 }

			 else

			 {

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 $amt_wt1= $amt_wt1+$m_r[0]['materialrate_port_amount'];

			 }

		 }

		 else

		 {

			  if(in_array($mid,$ma))

			 {

				 //echo $mat['material_master_id'];

				 $m_r=$this->Master_model->get_materialrateByMatID_p($mid,$port_id);

				 //print_r($m_r);

				 if($m_r[0]['materialrate_domain']==2)

				 {

				 	$amt_wt2=$amt_wt2+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

				 }

				 else

				 {

					 //echo "ff".$port_id."ff".$mid."ff".$zone_id;

					 $m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

					// print_r($m_rn);

					 $amt_wt3=$amt_wt3+($m_rn[0]['materialrate_port_amount']+$m_rn[0]['materialrate_port_amount']*($t_rate/100));

				 }

			 }

			 else

			 {

				 $m_r=$this->Master_model->get_materialrateByMatID_p($mid,$port_id);

				 if($m_r[0]['materialrate_domain']==2)

				 {

					// echo "ff";

				 	$amt_wt4=$amt_wt4+$m_r[0]['materialrate_port_amount'];

				 }

				 else

				 {

					 ///echo "ff";

					 $m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

					// print_r($m_rn);

					 $amt_wt5=$amt_wt5+$m_rn[0]['materialrate_port_amount'];

				 }

			 }

		 }

 }

 //echo $amt_wt."_".$amt_wt1."_".$amt_wt2."_".$amt_wt3."_".$amt_wt4."_".$amt_wt5;

 //echo "<br>";

 $sand_rate=ceil($amt_wt+$amt_wt1+$amt_wt2+$amt_wt3+$amt_wt4+$amt_wt5)-220;

					}

//---------------------------------------------------------------------------------------------------------------------------------------	//				

					$monthly_permit_daily_ton=$worker_quantity*$no_of_workers;	

					//$permit_no = time();lsgd_id

					$permit_no = $lsgd_id.$lsgd_section_id.strtotime($period_name);

					$data = array(

						'port_id' => $port_id,  

						'lsg_id' => $lsgd_id,

						'zone_id' => $zone_id,

						'lsg_section_id' => $lsgd_section_id,

						'monthly_permit_start_date'=>$start_date,

						'monthly_permit_end_date'=>$end_date,

						'monthly_permit_number_of_workers'=>$number_of_workers,

						'monthly_permit_remarks'=>$permit_remarks,

						'monthly_permit_requested_ton '=>$permit_requested_ton,

						'monthly_permit_approved_ton '=>0,

						'monthly_permit_requested_user'=>$sess_usr_id,

						'monthly_permit_daily_ton'=>$monthly_permit_daily_ton,

						'monthly_permit_permit_number' => $permit_no.$sess_usr_id,

						'monthly_permit_period_name'=>$period_name,

						'monthly_permit_order_number'=>$permit_order_number,

						'sand_rate'=>$sand_rate

					);

				//print_r($data);break;

					$can_suc=$this->db->insert('monthly_permit', $data);

					//print_r($can_suc);

					//echo $this->db->last_query();

					//break;

					if($can_suc){

						$this->session->set_flashdata('msg', '<div class="alert alert-success">Permit added Successfully!!!</div>');

						redirect('Manual_dredging/Master/monthlypermit');

					} 

					else{ 

						$this->session->set_flashdata('msg', '<div class="alert alert-error">Sorry, an error occured !!!</div>'); 		

						redirect('Manual_dredging/Master/monthlypermit_add');

					} 

				}

				

			}

			$data = array('title' => 'Add monthly permit', 'page' => 'monthlypermit_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$permit_order_number=$this->Master_model->get_lsgd_order_number($port_id,$lsgd_id,$zone_id);

			$data['permit_order_number']=$permit_order_number['lsg_zone_order_number'];

			$data['number_of_workers']=$no_of_workers;

			$data['worker_quantity']=$worker_quantity;

			$data['plinth_cutoffdate']=$plinth_cutoffdate;

			$data['permit_requested_ton']=$permit_requested_ton;

			$data['worker_quantity']=$worker_quantity;

			date_default_timezone_set("Asia/Kolkata");

			$current_date= date("Y-m-d");

			//$current_date=date('2017-06-17');

			$current_date=explode("-",$current_date);

			$current_day=$current_date[2];

			

			//$current_month='12';

			$current_month=$current_date[1];

			$next_month=$current_date[1]+1;

			if($next_month<10){

				$next_month='0'.$next_month;

			}

			//$next_month=date('m', strtotime($next_month));

			$current_year=$current_date[0];

			if($current_day>=$plinth_cutoffdate){

				if($current_month=='12'){

					$next_month='01';

					$current_year=$current_year+1;

				}

				$period_name=date("F Y", strtotime($current_year.'-'.($next_month)));

				$start_date=$current_year.'-'.($next_month).'-01';

				$end_date=date('Y-m-t', strtotime($start_date));

			}else{

				$period_name=date("F Y", strtotime($current_year.'-'.($current_month)));

				$start_date=$current_year.'-'.($current_month).'-'.($current_day+1);

				$end_date=date('Y-m-t', strtotime($start_date));

			}

			//print_r($next_month);exit;

			$data['period_name_default']=$period_name;

			$data['start_date']=$start_date;

			$data['end_date']=$end_date;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/monthlypermit_add', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

	}

	

	public function monthlypermitapprovalview()

	{

		//checking of session set or not

		$sess_usr_id 	= 	$this->session->userdata('int_userid');
		$sess_user_type	=	$this->session->userdata('int_usertype');
		$this->load->model('Manual_dredging/Master_model');

		$user_details	= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id		= $user_details['user_master_port_id'];

		$zone_id		= $user_details['user_master_zone_id'];

		$lsgd_id		= $user_details['user_master_lsg_id'];

		$lsgd_section_id= $user_details['user_master_lsg_section_id'];

		

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			$data = array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$edtidenc 				= 	$this->uri->segment(4);
			$data['edtidenc']		=	$edtidenc;

			$edtid 					= 	decode_url($edtidenc); 

			$get_permit_details		= 	$this->Master_model->get_monthly_permit_by_id($edtid);

			$zone_name				=	$this->Master_model->get_zone_name_by_id($get_permit_details['zone_id']);

			$lsgd_name				=	$this->Master_model->get_lsgdname_by_id($get_permit_details['lsg_id']);

			$district_name			=	$this->Master_model->get_districtname_by_id($get_permit_details['lsg_id']);

			$vchr_portoffice_name	=	$this->Master_model->get_port_details($get_permit_details['port_id']);

			//print_r($get_permit_details);break;

			$data['get_permit_details']			=	$get_permit_details; 

			$data['permit_id'] 					= 	$edtid;

			$data['zone_name'] 					= 	$zone_name['zone_name'];

			$data['lsgd_name'] 					= 	$lsgd_name['lsgd_name'];

			$data['period'] 					= 	date("d-m-Y",strtotime(str_replace('-', '/',$get_permit_details['monthly_permit_start_date']))).' to '.date("d-m-Y",strtotime(str_replace('-', '/',$get_permit_details['monthly_permit_end_date'])));

			$data['number_of_workers'] 			= 	$get_permit_details['monthly_permit_number_of_workers'];

			$data['permit_status'] 				= 	$get_permit_details['monthly_permit_permit_status'];

			$data['permit_requested_ton'] 		= 	$get_permit_details['monthly_permit_requested_ton'];

			$data['permit_approved_ton'] 		= 	$get_permit_details['monthly_permit_approved_ton'];

			$data['permit_approved_remarks'] 	= 	$get_permit_details['monthly_permit_approved_remarks'];

			$data = $data + $this->data;

			

        	if(isset($_REQUEST['btn_add'])){

				

				$hid=$this->input->post('hId');

				$hid	= 	$this->security->xss_clean(htmlentities($hid));

				

				$get_permit_details		= 	$this->Master_model->get_monthly_permit_by_id($hid);

				$zone_name				=	$this->Master_model->get_zone_name_by_id($get_permit_details['zone_id']);

				$zone_id=$get_permit_details['zone_id'];

				$district_name			=	$this->Master_model->get_districtname_by_id($get_permit_details['lsg_id']);

				$vchr_portoffice_name	=	$this->Master_model->get_port_details($get_permit_details['port_id']);

				

				$enc_hid= encode_url($hid);

				$get_permits	= 	$this->Master_model->get_monthly_permit_by_id($hid);

				$requested_ton=$get_permits['monthly_permit_requested_ton'];

				$period_name=$get_permits['monthly_permit_period_name'];

				$sand_rate=$get_permits['sand_rate'];

				$monthly_permit_permit_number=$get_permits['monthly_permit_permit_number'];

				$this->form_validation->set_rules('permit_approved_ton', 'Approved Permit','required|numeric|less_than_equal_to['.$requested_ton.']');

				$this->form_validation->set_rules('permit_status', 'Status','required');	

				$this->form_validation->set_rules('permit_approved_remarks', 'Remarks','alpha_numeric_spaces');				

				if ($this->form_validation->run() == FALSE)

				{

					validation_errors();

					$this->session->set_flashdata('msg', "<div id='msgDiv' class='alert alert-info alert-dismissible'>".validation_errors().'

					</div>');

					redirect("Master/monthlypermitapprovalview/$enc_hid");

				}

				else

				{   

					$permit_status=$this->input->post('permit_status');

					$permit_approved_ton=$this->input->post('permit_approved_ton');

					$permit_approved_remarks=$this->input->post('permit_approved_remarks');

					$permit_status	= 	$this->security->xss_clean(htmlentities($permit_status));

					$permit_approved_ton	= 	$this->security->xss_clean(htmlentities($permit_approved_ton));

					$permit_approved_remarks	= 	$this->security->xss_clean(htmlentities($permit_approved_remarks));

					//$request_status_arr = $this->Master_model->get_request_status();

					//Checking permit is approved

					if($permit_status == 0)

					{

						//$rejectsuc=$this->Master_model->reject_monthly_permit($port_id,$period_name);

						$rejectsuc=$this->Master_model->reject_monthly_permitnew($port_id,$zone_id,$period_name);

						redirect("Master/monthlypermitapproval");

					}

					//CHECKING WHETHER NO OF WORKING DAYS IS SET

					//--------------------------------------------------------------

					

					///-------------------------------------------------------------

					

					

					//$no_of_working_days	= $this->Master_model->get_monthly_working_days($port_id,$period_name);

					$no_of_working_days	= $this->Master_model->get_monthly_working_daysnew($port_id,$zone_id,$period_name);

					if($no_of_working_days['working_days']!=''){

						$no_of_working_days=$no_of_working_days['working_days'];

					}else{

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, No working days for the given Permit Period is found !!!</div>'); 

						redirect("Master/monthlypermitapproval");

					}

					$current_date = date("Y-m-d");   

					$getholidayuptoapprovaldate=$this->Master_model->get_holiday($port_id,$zone_id,$period_name,$current_date);

					$err=count($getholidayuptoapprovaldate); 

					$start_dat=explode('-',$current_date);

					$day=$start_dat[2];

				    if($day >=25)

					{

						$newnumberofworkingdays=$no_of_working_days;

					}

					else

					{

						$newnumberofworkingdays=$no_of_working_days-($day-$err);

					}

					//print_r($permit_approved_ton);

					//print_r($newnumberofworkingdays);

					$daily_ton=$permit_approved_ton/$newnumberofworkingdays;

					$daily_ton=ceil($daily_ton);

					date_default_timezone_set("Asia/Kolkata");
					$updateArray=array('working_days' => $newnumberofworkingdays);
					$this->db->where('holiday_port_port_id', $port_id);
					$this->db->where('holiday_port_zone_id', $zone_id);
					$this->db->where('holiday_port_period_name',$period_name);
					$this->db->where('holiday_port_holiday_status', 1);

					

					$update_result=$this->db->update('holiday_port', $updateArray);

					$dataArray = array(

						'monthly_permit_approved_ton' => $permit_approved_ton,  
						'monthly_permit_approved_timestamp' => date("Y-m-d H:i:s"),
						'monthly_permit_approved_user' => $sess_usr_id,
						'monthly_permit_daily_ton' => $daily_ton,
						'monthly_permit_balance_ton' => $permit_approved_ton,
						'monthly_permit_permit_status' => $permit_status,
						'monthly_permit_approved_remarks' => $permit_approved_remarks,
					);

	//print_r($dataArray); print_r($hid);

				//	break;

					$this->db->where('monthly_permit_id', $hid);
					
					$rdnew=$this->db->query("select * from  daily_log where daily_log_permit_id='$hid'");

				$r_datanew=$rdnew->result_array();
					if(count($r_datanew)>0)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Monthly permit already approved!!!</div>');

					redirect('Manual_dredging/Master/monthlypermitapproval');

				}
				else
					{
						$update_res=$this->db->update('monthly_permit', $dataArray);
					}
							

				//	echo $this->db->last_query();break;

					/////////INSRTING VALUES TO DAILY-LOG\\\\\\\\\\

					$holidayArr=array();

					$logdayArr=array();

					$logtableArr=array();

					$list_holidays=$this->Master_model->get_holidaylist_by_periodnamenew($port_id,$zone_id,$period_name);

					

					//$list_holidays=$this->Master_model->get_holidaylist_by_periodname($port_id,$period_name);

					//echo '<pre>';print_r($list_holidays);break;

					if(count($list_holidays)>0){

						foreach($list_holidays as $holiday){

							$holiday_date=$holiday['holiday_date'];

							if($holiday_date!='' || $holiday_date!=0){

								if($holiday['holiday_reserve_status']!=1 && $holiday['holiday_status']==1){

									array_push($holidayArr,$holiday_date);

								}

							}

						}

					}

					//echo '<pre>';print_r($holidayArr);break;

					$last_day_of_period = date('t-m-Y', strtotime($period_name));

					$month_year=explode(' ',$period_name);

					$month_no=date('m',strtotime("2017-".$month_year[0]."-01"));

					//$month_no=date('m', strtotime($month_year[0]."-01-2017"));

					$year_no=$month_year[1];

					for($i=1;$i<=$last_day_of_period;$i++){

						if($i<10)

							$log_date=$year_no.'-'.$month_no.'-'.'0'.$i;

						else

							$log_date=$year_no.'-'.$month_no.'-'.$i;

						if(in_array($log_date,$holidayArr)!=1){

							$dataArray = array(

								'daily_log_permit_id' => $hid,  

								'daily_log_port_id' => $port_id,

								'daily_log_zone_id' => $get_permits['zone_id'],

								'daily_log_lsg_id' => $get_permits['lsg_id'],

								'daily_log_lsg_section_id' => $get_permits['lsg_section_id'],

								'daily_log_date' => $log_date,

								'daily_log_total' => $daily_ton,

								'daily_log_unused' => $daily_ton,

								'daily_log_balance' => $daily_ton,

							);

							//array_push($logtableArr,$data);

							//echo '<pre>';print_r($data);break;

							$insert_log=$this->db->insert('daily_log', $dataArray);

						}

					}

					//echo '<pre>';print_r($dataArray);break;

					

					//print_r($zone_name);break;

					//if($update_res){

							//Downloadfunction

							if($update_res)	{							

								$this->session->set_flashdata('msg', '<div class="alert alert-info alert-success">Permit Updated successfully!!!</div>');

								redirect('Manual_dredging/Master/monthlypermitapproval');

							}

						//} 

					else{ 

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, an error occured !!!</div>'); 		

						redirect("Manual_dredging/Master/monthlypermitapprovalview/$enc_hid");

					} 

				}

				

			}

			

			$data 	= 	$data + $this->data;     

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				$this->load->view('Manual_dredging/Master/monthlypermitapproval_action', $data);

		}

	   	else

	   	{

			redirect('Main_login/index');        

  		}

	}

	

	// Approval of Monthly Permit

	function monthlypermitapproval_action()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id))

		{	

			$data = array('title' => 'Add canoe', 'page' => 'canoeregistration_add', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/monthlypermitapproval_action', $data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

			

		else

		{

			redirect('Manual_dredging/settings/index');        

		}

    }

	

	//

	public function holidaysettings()

	{
				//checking of session set or not

		 $sess_usr_id = $this->session->userdata('int_userid');
		

		 $sess_user_type=$this->session->userdata('int_usertype');
		
		$this->load->model('Manual_dredging/Master_model');
		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$period_holidays_list= $this->Master_model->get_period_holidays_listnew($sess_usr_id);
		//print_r($user_details);
		//exit;

		//$period_holidays_list= $this->Master_model->get_period_holidays_port_list($sess_usr_id);

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			$data = array('title' => 'module', 'page' => 'monthly permit approval', 'errorCls' => NULL, 'post' => $this->input->post());

			$data['period_holidays_list']=$period_holidays_list;

			$data['port_id']=$port_id;

			$data = $data + $this->data;
			$this->load->model('Manual_dredging/Master_model');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Master/holidaysettings', $data);
			$this->load->view('Kiv_views/template/dash-footer');



/*
			$this->load->view('Manual_dredging/template/header',$data);

			$this->load->view('Manual_dredging/Master/holidaysettings', $data);

			$this->load->view('Manual_dredging/template/footer');

			$this->load->view('Manual_dredging/template/js-footer');

			$this->load->view('Manual_dredging/template/script-footer');

			$this->load->view('Manual_dredging/template/html-footer');*/

	   }

	   else
	   {
			redirect('Main_login/index');        
	   }  
	
	}

	function holi_period_add(){
		$this->load->model('Manual_dredging/Master_model');

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id= $user_details['user_master_port_id'];

		$period_name='';

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{

			

			$data = array('title' => 'module', 'page' => 'monthly permit approval', 'errorCls' => NULL, 'post' => $this->input->post());

			$data['port_id']=$port_id;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$get_zone_details=$this->Master_model->get_zone_details($port_id);

				$data['get_zone_details']=$get_zone_details;

				$data = $data + $this->data;

				$this->load->view('Manual_dredging/template/header',$data);
			//$this->load->view('Kiv_views/template/dash-header');
			//$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/holidays_period', $data);
			//$this->load->view('Kiv_views/template/dash-footer');
			$this->load->view('Manual_dredging/template/footer');

			$this->load->view('Manual_dredging/template/js-footer');

			$this->load->view('Manual_dredging/template/script-footer');

			$this->load->view('Manual_dredging/template/html-footer');

		}

		else

		{

			redirect('Main_login/index');        

		} 

	}

	function holidays_add()

    {

		

		 //print_r($_POST);break;
    	$this->load->model('Manual_dredging/Master_model');
		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id= $user_details['user_master_port_id'];

		$btn_add=$this->input->post('btn_add');

		$btn_holy_period=$this->input->post('btn_holy_period');

		$period_name='';

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			

			if($btn_holy_period=='Go')

			{

				//print_r($_POST);exit();

				$data = array('title' => 'Add Holydays', 'page' => 'holidays_add', 'errorCls' => NULL, 'post' => $this->input->post());

				$sess_usr_id = $this->session->userdata('int_userid');

				$sess_user_type=$this->session->userdata('int_usertype');

				$user_details= $this->Master_model->user_details_by_id($sess_usr_id);

				$port_id= $user_details['user_master_port_id'];

				$start_date  =$this->input->post('start_date');

				$end_date    =$this->input->post('end_date');

				$zone_id	 =$this->input->post('zoneid');

				$start_date		= 	$this->security->xss_clean(htmlentities($start_date));

				$end_date		= 	$this->security->xss_clean(htmlentities($end_date));

				$zone_id		= 	$this->security->xss_clean(htmlentities($zone_id));

				$period_name=date("F Y", strtotime($start_date));

				//CHECKING PERIOD HOLIDAY IS ALREADY SET

				

				//$isHolidaysSet=$this->Master_model->get_holiday_by_periodname($period_name,$port_id);

				$isHolidaysSet=$this->Master_model->get_holiday_by_periodnamenew($period_name,$port_id,$zone_id);

				//print_r($isHolidaySet);break;

				if(count($isHolidaysSet)>0){

					$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, Holiday for the given period is already added, Please use Edit option !!!</div>'); 		

					redirect('Manual_dredging/Master/holidaysettings');

				}

				//Adding Sundays As Holidays for the given month

				$dayofweek = date('w', strtotime($start_date));

				$last_day=date('t', strtotime($end_date));

				$start_dat=explode('/',$start_date);

				//print_r($start_dat);break;

				$day=$start_dat[2];

				$month=$start_dat[1];

				$year=$start_dat[0];

				if($dayofweek==0){

					$dayofweek=7;

				}

				$diff=7-$dayofweek;

				//Second Saturday

				$second_sat=$year.'-'.$month.'-'.($diff+7);

				if($dayofweek==7){

					$second_sat=$year.'-'.$month.'-'.($diff+14);

				}

				//$second_sat=date_create($second_sat)->format('Y-m-d');
				$second_sat=date("Y-m-d", strtotime($second_sat));
				//$second_sat=date_create($second_sat);
				//$second_sat=$second_sat->format('Y-m-d');

				$sundayArr=array();

				for($i=($day+$diff);$i<=$last_day;$i=$i+7){

					$newSunday=$year.'-'.$month.'-'.$i;

					//$newSunday=date_create($newSunday)->format('Y-m-d');
					$newSunday=date("Y-m-d", strtotime($newSunday));
					//print_r($newSunday);break;

					array_push($sundayArr,$newSunday);

				}

				//Inserting Second Sat

				array_push($sundayArr,$second_sat);

				//print_r($sundayArr);exit;

				//Working Days Calculatons

				$noOfWorkingDays=$last_day-(count($sundayArr));

				for($i=0;$i<count($sundayArr);$i++){

					//$isHolidaySet=$this->Master_model->get_holiday_by_date($period_name,$port_id,$sundayArr[$i]);

					$isHolidaySet=$this->Master_model->get_holiday_by_datenew($period_name,$port_id,$zone_id,$sundayArr[$i]);

					

					if(count($isHolidaySet)>0){

						continue;

					}else{

						if($sundayArr[$i]==$second_sat)

							$reason='Second Saturday';

						else

							$reason='Sunday';

						$dataArr = array(

							'holiday_date' => $sundayArr[$i],  

							'holiday_reason' =>$reason,

							'holiday_port_id' => $port_id,

							'holiday_zone_id' => $zone_id,

							'holiday_period_name' => $period_name,

							'holiday_user_id'=>$sess_usr_id,

							'holiday_status'=>1,

							'holiday_reserve_status'=>0,

						);

						//print_r($dataArr);break;

						$holiday_succ=$this->db->insert('holiday', $dataArr);

					}

				}

				//INSERTING VALUES TO THE HOLIDAY PORT TABLE

				$dataArray = array(

					'holiday_port_port_id' => $port_id,

					'holiday_port_zone_id' => $zone_id,    

					'holiday_port_period_name' => $period_name,

					'holiday_port_user_id' => $sess_usr_id,

					'holiday_port_holiday_status' => 1,

					'working_days'=>$noOfWorkingDays,

				);

				$holiday_port_succ=$this->db->insert('holiday_port', $dataArray);

		//------------------------------------------------------		

				$data = $data + $this->data;

				$data['start_date']=$start_date;

				$data['end_date']=$end_date;	

				$data['period_name']=$period_name;

				$data['port_id']=$port_id;

				$data['zone_id']=$zone_id;//added on 11/10/2017 by gopika

		//----------------------------------------------------------------------------------		

			}

			if($btn_add)

			{

				//print_r($_POST);break;

				$this->form_validation->set_rules('zoneid', 'Zone','required');

				$this->form_validation->set_rules('start_date', 'Start date','required|callback_checkStartDate');

				$this->form_validation->set_rules('end_date', 'End Date|callback_checkEndDate');

				//$this->form_validation->set_rules('date','DOB','callback_checkDateFormat'); 

				

				if ($this->form_validation->run() == FALSE)

				{

					validation_errors();

					$this->session->set_flashdata('msg', "<div id='msgDiv' class='alert alert-info alert-dismissible'>".validation_errors().'

					</div>');

				}

				else

				{   

					//print_r($_POST);break;

					$period_name=$this->input->post('period_name');

					$period_name	= 	$this->security->xss_clean(htmlentities($period_name));

					$zone_id	 =$this->input->post('zoneid');

					$zone_id	= 	$this->security->xss_clean(htmlentities($zone_id));

					//IF UPDATE HOLIDAYS 

					if($period_name!=''){

						//$succ_del_hol=$this->Master_model->delete_holiday_by_periodname($period_name,$port_id);

						$succ_del_hol=$this->Master_model->delete_holiday_by_periodnamenew($period_name,$port_id,$zone_id);

						//$succ_del_hol_port=$this->Master_model->delete_holiday_port_by_periodname($period_name,$port_id);

						$succ_del_hol_port=$this->Master_model->delete_holiday_port_by_periodnamenew($period_name,$port_id,$zone_id);

					}

					$start_date=$this->input->post('start_date');

					$end_date=$this->input->post('end_date');

					$totalDatecount=$this->input->post('totalDatecount');

					$start_date	= 	$this->security->xss_clean(htmlentities($start_date));

					$end_date	= 	$this->security->xss_clean(htmlentities($end_date));

					$totalDatecount	= 	$this->security->xss_clean(htmlentities($totalDatecount));

					$start_date = explode('/', $start_date);

					$end_date = explode('/', $end_date);

					if($start_date[1]!=$end_date[1]){

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, the START DATE and END DATE should be of same month !!!</div>'); 		

						redirect('Manual_dredging/Master/holidays_add');

					}

					$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];

					$end_date =$end_date[2]."-".$end_date[1]."-".$end_date[0];

					

					$holidayArr=array();

					$reserveArr=array();

					$reasonArr=array();

					$CombinedArr=array();

					for($i=0;$i<$totalDatecount;$i++){

						$daytype=$this->input->post('date'.$i);

						$holiday=$this->input->post('dateId'.$i);

						$reason=$this->input->post('reason'.$i);

						$daytype	= 	$this->security->xss_clean(htmlentities($daytype));

						$holiday	= 	$this->security->xss_clean(htmlentities($holiday));

						$reason		= 	$this->security->xss_clean(htmlentities($reason));

						if(isset($daytype)){

							if($daytype==1){

								if($holiday!='' && $reason!=''){

									array_push($holidayArr,$holiday);

									array_push($reasonArr,$reason);

								}else{

									$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, Reason for the Holiday('.$holiday.' is not set) !!!</div>'); 		

									redirect('Manual_dredging/Master/holidays_add');	

								}

							}

							if($daytype==2){

								if($holiday!=''){

									array_push($reserveArr,$holiday);

									//array_push($reasonArr,'');

								}

							}

						}

					}

					$totalNumberOfDays = date_diff(date_create($end_date),date_create($start_date))->days+1;

					$noOfHolidays=count($holidayArr)+count($reserveArr);

					//$noOfHolidays=count($holidayArr);

					//$noOfWorkingDays=$totalNumberOfDays-$noOfHolidays;

					$noOfWorkingDays=$totalNumberOfDays-count($holidayArr);

					if($period_name=='')

						$period_name=date("F Y", strtotime($start_date));

					//CHECKING PERIOD HOLIDAY IS ALREADY SET

					//$isHolidaySet=$this->Master_model->get_holiday_by_periodname($period_name,$port_id);

					$isHolidaySet=$this->Master_model->get_holiday_by_periodnamenew($period_name,$port_id,$zone_id);

					//print_r($isHolidaySet);break;

					if(count($isHolidaySet)>0){

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, Holiday for the given period is already exists !!!</div>'); 		

						redirect('Manual_dredging/Master/holidaysettings');

					}

					$CombinedArr=array_merge($holidayArr,$reserveArr);

					//INSERTING HOLIDAYS TO THE HOLIDAY TABLE

					for($i=0;$i<$noOfHolidays;$i++){





						$holiday_date=$CombinedArr[$i];

						$holiday_reason=$reasonArr[$i];

						$holiday_status=1;

						$reserveFlag=0;

						if(in_array($holiday_date,$reserveArr)==1){

							$reserveFlag=1;

							$holiday_status=0;

						}

						

						if($holiday_date!='' && $holiday_date!=0){

							$data = array(

								'holiday_date' => $holiday_date,  

								'holiday_reason' => $holiday_reason,

								'holiday_port_id' => $port_id,

								'holiday_zone_id' => $zone_id,

								'holiday_period_name' => $period_name,

								'holiday_user_id'=>$sess_usr_id,

								'holiday_status'=>$holiday_status,

								'holiday_reserve_status'=>$reserveFlag

							);

							print_r($data);break;

							$holiday_succ=$this->db->insert('holiday', $data);

						}

					}

					

					//INSERTING VALUES TO THE HOLIDAY PORT TABLE

					$data = array(

						'holiday_port_port_id' => $port_id,

						'holiday_port_zone_id' => $zone_id,    

						'holiday_port_period_name' => $period_name,

						'holiday_port_user_id' => $sess_usr_id,

						'holiday_port_holiday_status' => 1,

						'working_days'=>$noOfWorkingDays,

					);

					$holiday_port_succ=$this->db->insert('holiday_port', $data);

					if($holiday_succ && $holiday_port_succ){

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-success">Holidays for the period '.$period_name.' added to Database!!!</div>');

						redirect('Manual_dredging/Master/holidaysettings');

					} 

					else{ 

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, an error occured !!!</div>'); 		

						redirect('Manual_dredging/Master/holidaysettings');

					} 

				}

			}

			

			/*date_default_timezone_set("Asia/Kolkata");

			$current_date= date("Y-m-d");

			$period_name=date("F Y", strtotime($current_date));

			//echo $period_name;break;

			$data['period_name']=$period_name;*/

			$data['port_id']=$port_id;

			$data['zone_id']=$zone_id;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('Manual_dredging/template/header',$data);
				//$this->load->view('Kiv_views/template/dash-header');
				//$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/holidays_add', $data);
			//$this->load->view('Kiv_views/template/dash-footer');
			$this->load->view('Manual_dredging/template/footer');

			$this->load->view('Manual_dredging/template/js-footer');

			$this->load->view('Manual_dredging/template/script-footer');

			$this->load->view('Manual_dredging/template/html-footer');

		}

			

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

	

	}

	public function holiday_view()

	{

		//checking of session set or not

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');
		$this->load->model('Manual_dredging/Master_model');
		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			$data = array('title' => 'module', 'page' => 'monthly permit approval', 'errorCls' => NULL, 'post' => $this->input->post());

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$edtidenc 				= 	$this->uri->segment(4);
			$data['edtidenc']		=	$edtidenc;

			$edtid 					= 	decode_url($edtidenc); 

			//$edtzone				= 	$this->uri->segment(4);//------comment on 6/11/2019---------port intergration------------
			$edtzone				= 	$this->uri->segment(5);

			//$data['edtzone']		=	$edtzone;

			$edtzoneid 	= 	decode_url($edtzone); 

			
			$this->load->model('Manual_dredging/Master_model');
			//$holiday_list			= 	$this->Master_model->get_period_holidays_list($sess_usr_id);

			$holiday_list			= 	$this->Master_model->get_period_holidays_listnew($sess_usr_id);

			$data['holiday_list']	=	$holiday_list; 

			$data['period_name'] 	= 	$edtid;

			$data['port_id'] 		= 	$port_id;

			$data['zone_id'] 		= 	$edtzoneid;

			//$last_day_of_period 	= 	date('t-m-Y', strtotime($edtid));

			$last_day_of_period 	= 	date('t', strtotime($edtid));

			$month_year=explode(' ',$edtid);

			//print_r($month_year);

			$month_no=date('m',strtotime("2017-".$month_year[0]."-01"));

			$year_no=$month_year[1];

			$data['start_date'] 	= 	'01/'.$month_no.'/'.$year_no;

			$data['end_date'] 		= 	$last_day_of_period.'/'.$month_no.'/'.$year_no;

			$data['port_id']=$port_id;

			$data['zone_id']=$edtzoneid;

			$data = $data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('Manual_dredging/template/header',$data);
//$this->load->view('Kiv_views/template/dash-header');
//$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/holidays_view', $data);
//$this->load->view('Kiv_views/template/dash-footer');
			$this->load->view('Manual_dredging/template/footer');

			$this->load->view('Manual_dredging/template/js-footer');

			$this->load->view('Manual_dredging/template/script-footer');

			$this->load->view('Manual_dredging/template/html-footer');

	   }

	   else

	   {

			redirect('Main_login/index');        

	   }  

	}

	public function holidays_edit()

	{

		$this->load->model('Manual_dredging/Master_model');

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		$lsgd_id			= $user_details['user_master_lsg_id'];

		$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			$data = array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$this->load->model('Manual_dredging/Master_model');

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$edtidenc 				= 	$this->uri->segment(4);
			$data['edtidenc']		=	$edtidenc;

			$edtid 					= 	decode_url($edtidenc); 

		//	$edtzone_enc 			= 	$this->uri->segment(4);//------comment on 6/11/2019---------port intergration------------
			$edtzone_enc 			= 	$this->uri->segment(5);

			$edtzoneid 					= 	decode_url($edtzone_enc); 

			$holiday_list			= 	$this->Master_model->get_period_holidays_list($sess_usr_id);

			//$monthly_permit			= 	$this->Master_model->get_montly_permit_by_period($edtid,$port_id);

			$monthly_permit			= 	$this->Master_model->get_montly_permit_by_periodnew($edtid,$port_id,$edtzoneid);

			//print_r($monthly_permit);break;

			$data['holiday_list']	=	$holiday_list; 

				$data['period_name'] 	= 	$edtid;

				$data['port_id'] 		= 	$port_id;

				$data['zone_id'] 		= 	$edtzoneid;

			if($monthly_permit!=''){

				$monthly_permit_status	=	$monthly_permit['monthly_permit_permit_status']; 

			}else{

				$monthly_permit_status	=	1;	

			}

			//echo '<pre>';

			//print_r($monthly_permit_status);break;

			//$last_day_of_period 	= 	date('t-m-Y', strtotime($edtid));

			$last_day_of_period 	= 	date('t', strtotime($edtid));

			$month_year=explode(' ',$edtid);

			$month_no=date('m', strtotime($month_year[0]."-01-2017"));

			$year_no=$month_year[1];

			$data['start_date'] 	= 	$year_no.'/'.$month_no.'/'.'01';

			$data['end_date'] 		= 	$year_no.'/'.$month_no.'/'.$last_day_of_period;

			$data 					= 	$data + $this->data;     

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');

			if($monthly_permit_status==2)  

				$this->load->view('Manual_dredging/Master/holidays_approved_edit', $data);

			else

				$this->load->view('Manual_dredging/Master/holidays_edit', $data);
				$this->load->view('Kiv_views/template/dash-footer');
		}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

			

		

	

	}

	

	public function holidays_edit_new()

	{
		$this->load->model('Manual_dredging/Master_model');
		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		$lsgd_id			= $user_details['user_master_lsg_id'];

		$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			$data = array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data = $data + $this->data;

			$this->load->model('Manual_dredging/Master_model');

			//$edtidenc 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			 $edtidenc 				= 	$this->uri->segment(4);
			$data['edtidenc']		=	$edtidenc;

			$edtid 					= 	decode_url($edtidenc); 

			$monthly_permit			=	$edtid;

			//print_r($monthly_permit);break;

			$data['period_name'] 	= 	$edtid;

			$data['port_id'] 		= 	$port_id;

			//$edtzone_enc 			= 	$this->uri->segment(4);//------comment on 6/11/2019---------port intergration------------
			 $edtzone_enc 			= 	$this->uri->segment(5);
			$edtzoneid 				= 	decode_url($edtzone_enc);

			$data['zone_id'] 		= 	$edtzoneid; 

			//$monthly_permit			= 	$this->Master_model->get_montly_permit_by_period($edtid,$port_id);

			$monthly_permit			= 	$this->Master_model->get_montly_permit_by_periodnew($edtid,$port_id,$edtzoneid);

			if($monthly_permit!=''){

				$monthly_permit_status	=	$monthly_permit['monthly_permit_permit_status']; 

			}else{

				$monthly_permit_status	=	1;	

			}

			//echo '<pre>';

			//print_r($monthly_permit_status);break;

			//$last_day_of_period 	= 	date('t-m-Y', strtotime($edtid));

			$last_day_of_period 	= 	date('t', strtotime($edtid));

			$month_year=explode(' ',$edtid);

			$month_no=date('m',strtotime("2017-".$month_year[0]."-01"));

			$year_no=$month_year[1];

			$data['start_date'] 	= 	$year_no.'/'.$month_no.'/'.'01';

			$data['end_date'] 		= 	$year_no.'/'.$month_no.'/'.$last_day_of_period;

			$data['monthly_permit_status'] 		= 	$monthly_permit_status;

			$data 					= 	$data + $this->data;     

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('Manual_dredging/template/header',$data);
				//$this->load->view('Kiv_views/template/dash-header');
				//$this->load->view('Kiv_views/template/nav-header');

			/*if($monthly_permit_status==2)  

				$this->load->view('Master/holidays_approved_edit_new', $data);

			else*/

				$this->load->view('Manual_dredging/Master/holidays_edit_new', $data);
				//$this->load->view('Kiv_views/template/dash-footer');
				$this->load->view('Manual_dredging/template/footer');

		$this->load->view('Manual_dredging/template/js-footer');

		$this->load->view('Manual_dredging/template/script-footer');

		$this->load->view('Manual_dredging/template/html-footer');

		}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

			

	}

	function holidays_approved_edit() {

		
		$this->load->model('Manual_dredging/Master_model');
		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details		= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id			= $user_details['user_master_port_id'];

		$zone_id			= $user_details['user_master_zone_id'];

		$lsgd_id			= $user_details['user_master_lsg_id'];

		$lsgd_section_id	= $user_details['user_master_lsg_section_id'];

		$btn_add=$this->input->post('btn_add');

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{
			$this->load->model('Manual_dredging/Master_model');

			if($btn_add)

			{//echo '<pre>';print_r($_POST);break;

				$period_name=$this->input->post('period_name');

				$port_id=$this->input->post('port_id');

				$totalDatecount=$this->input->post('totalDatecount');

				$start_date	= 	$this->security->xss_clean(htmlentities($period_name));

				$end_date	= 	$this->security->xss_clean(htmlentities($port_id));

				$totalDatecount	= 	$this->security->xss_clean(htmlentities($totalDatecount));

				

				$holidayArr=array();

				$reserveArr=array();

				$reasonArr=array();

				$CombinedArr=array();

				for($i=0;$i<$totalDatecount;$i++){

					$daytype=$this->input->post('date'.$i);

					$holiday=$this->input->post('dateId'.$i);

					$reason=$this->input->post('reason'.$i);

					$daytype	= 	$this->security->xss_clean(htmlentities($daytype));

					$holiday	= 	$this->security->xss_clean(htmlentities($holiday));

					$reason		= 	$this->security->xss_clean(htmlentities($reason));

					if(isset($daytype)){

						if($daytype==1){

							if($holiday!='' && $reason!=''){

								array_push($holidayArr,$holiday);

								array_push($reasonArr,$reason);

							}else{

								$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, Reason for the Holiday('.$holiday.' is not set) !!!</div>'); 		

								redirect('Manual_dredging/Master/holidays_add');	

							}

						}

						if($daytype==2){

							if($holiday!=''){

								array_push($reserveArr,$holiday);

								//array_push($reasonArr,'');

							}

						}

					}

				}

				//print_r($reserveArr);break;

				$noOfHolidays=count($holidayArr)+count($reserveArr);

				$CombinedArr=array_merge($holidayArr,$reserveArr);

				for($i=0;$i<$noOfHolidays;$i++){

					$holiday_date=$CombinedArr[$i];

					$holiday_reason=$reasonArr[$i];

					$holiday_status=1;

					$reserveFlag=0;

					if(in_array($holiday_date,$reserveArr)==1){

						$reserveFlag=1;

						$holiday_status=0;

					}

					//Checking Date Already Exist in Holiday Table

					$isHolidaySet=$this->Master_model->get_holiday_by_date($period_name,$port_id,$holiday_date);

					

					if(count($isHolidaySet)>0){

						$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, Holiday for the given date '.$holiday_date.' is already exists !!!</div>'); 		

						redirect('Manual_dredging/Master/holidaysettings');

					}else{

						

						//Checking Customer Booking

						$customerBookingList=$this->Master_model->get_customerBookingList($holiday_date,$port_id);

						if(count($customerBookingList)>0){

							

							$succesTransfer=$this->transferCusBooking($holiday_date);	

							//echo '<pre>';print_r($succesTransfer);exit;

						}

						

						if($holiday_date!='' && $holiday_date!=0){

							$dataArr = array(

								'holiday_date' => $holiday_date,  

								'holiday_reason' => $holiday_reason,

								'holiday_port_id' => $port_id,

								'holiday_period_name' => $period_name,

								'holiday_user_id'=>$sess_usr_id,

								'holiday_status'=>$holiday_status,

								'holiday_reserve_status'=>$reserveFlag

							);

							$success=$holiday_succ=$this->db->insert('holiday', $dataArr);

						}

					}

				}

				if($success){

					if($reserveFlag==1){$holyType= "Reserve Day";}else{$holyType= "Holiday";}

					$this->session->set_flashdata('msg', '<div class="alert alert-info alert-success">'.$holyType.' Days added Successfully !</div>');

					redirect('Manual_dredging/Master/holidaysettings');

				}else{

					$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry, an error occured !!!</div>'); 		

					redirect('Manual_dredging/Manual_dredging/Master/holidaysettings');

				}

			}

		}else

	   	{

			redirect('Main_login/index');        

  		} 

	}

	

	function createDateRangeArr() {

		

		//print_r($_POST);exit;

		$format = 'Y-m-d';

		$start_date  =$this->input->post('start_date');

		$end_date    =$this->input->post('end_date');

		$start_date		= 	$this->security->xss_clean(htmlentities($start_date));

		$end_date		= 	$this->security->xss_clean(htmlentities($end_date));

		/*$start_date = date("Y-m-d", strtotime($start_date));

		$end_date = date("Y-m-d", strtotime($end_date));*/

		$start_date = explode('/', $start_date);

		$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];

		$end_date = explode('/', $end_date);

		$end_date =$end_date[2]."-".$end_date[1]."-".$end_date[0];

		$start  = new DateTime($start_date);

		$end    = new DateTime($end_date);

		$invert = $start > $end;

	

		$dates = array();

		$dates[] = $start->format($format);

		while ($start != $end) {

			$start->modify(($invert ? '-' : '+') . '1 day');

			$dates[] = $start->format($format);

		}

		//print_r($dates);exit;

		$dateArray='<p><input type="hidden" id="totalDatecount" name="totalDatecount" value="'.count($dates).'"></p>';

		for($i=0;$i<count($dates);$i++){

			$dateValue=$dates[$i];

			$idDate=strtotime($dateValue);

			$dateArray.='<p dateid="'.$i.'"><strong>'.$dateValue.'</strong>' .' '.'

				<input type="hidden" id="dateId'.$i.'" name="dateId'.$i.'" value="'.$dateValue.'"></p>

				<p><input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="displayCommentBox('.$i.')" value="1" autocomplete="off" />	Holiday

				<input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="hideCommentBox('.$i.')" value="2" autocomplete="off" />	Reserve day

				<input type="radio" id="radiobx'.$i.'" name="date'.$i.'" onClick="hideCommentBox('.$i.')"  value="0" />	Cancel</p>

				<input class="form-control" style="display:none" type="textbox" id="textbx'.$i.'" name="reason'.$i.'" disabled value="" placeholder="Reason for the holiday in date '.$dateValue.'" ></p>';

		}

		echo $dateArray;

	}

	

	function createDateRangeArrEdit() {

		

		//print_r($_POST);exit;

		$format = 'Y-m-d';

		$start_date  =$this->input->post('start_date');

		$end_date    =$this->input->post('end_date');

		$period_name =$this->input->post('period_name');

		$port_id 	 =$this->input->post('port_id');

		$start_date		= 	$this->security->xss_clean(htmlentities($start_date));

		$end_date		= 	$this->security->xss_clean(htmlentities($end_date));

		$period_name	= 	$this->security->xss_clean(htmlentities($period_name));

		$port_id		= 	$this->security->xss_clean(htmlentities($port_id));

		/*$start_date = date("Y-m-d", strtotime($start_date));

		$end_date = date("Y-m-d", strtotime($end_date));*/

		$start_date = explode('/', $start_date);

		$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];

		$end_date = explode('/', $end_date);

		$end_date =$end_date[2]."-".$end_date[1]."-".$end_date[0];

		$start  = new DateTime($start_date);

		$end    = new DateTime($end_date);

		$invert = $start > $end;

	

		$dates = array();

		$dates[] = $start->format($format);

		while ($start != $end) {

			$start->modify(($invert ? '-' : '+') . '1 day');

			$dates[] = $start->format($format);

		}

		//print_r($dates);exit;

		$holidayArr=array();

		$list_holidays=$this->Master_model->get_holidaylist_by_periodname($port_id,$period_name);

		//echo '<pre>';print_r($list_holidays);exit;

		if(count($list_holidays)>0){

			foreach($list_holidays as $holiday){

				$holiday_date=$holiday['holiday_date'];

				if($holiday_date!='' || $holiday_date!=0){

					array_push($holidayArr,$holiday_date);

				}

			}

		}

		$dateArray='<p><input type="hidden" id="totalDatecount" name="totalDatecount" value="'.count($dates).'"></p>';

		for($i=0;$i<count($dates);$i++){

			$dateValue=$dates[$i];

			$idDate=strtotime($dateValue);

			

			if(in_array($dateValue,$holidayArr)!=1){

			

				$dateArray.='<p dateid="'.$i.'"><strong>'.$dateValue.'</strong>' .' '.'

					<input type="hidden" id="dateId'.$i.'" name="dateId'.$i.'" value="'.$dateValue.'"></p>

					<p><input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="displayCommentBox('.$i.')" value="1" autocomplete="off" />	Holiday

					<input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="hideCommentBox('.$i.')" value="2" autocomplete="off" />	Reserve day				

					<input type="radio" id="radiobx'.$i.'" name="date'.$i.'" onClick="hideCommentBox('.$i.')"  value="0" />	Cancel</p>

					<input class="form-control" style="display:none" type="textbox" id="textbx'.$i.'" name="reason'.$i.'" disabled value="" placeholder="Reason for the holiday in date '.$dateValue.'" ></p>';

			}else{

				$pos = array_search($dateValue,$holidayArr);

				$holiday_det=$list_holidays[$pos];

				//print_r($holiday_det);exit;

				if($holiday_det!='' ){

					if($holiday_det['holiday_reserve_status']==0 ){/*

						$holiday_reason=$holiday_det['holiday_reason'];

						$dateArray.='<p dateid="'.$i.'"><strong>'.$dateValue.'</strong>' .' '.'

							<input type="hidden" id="dateId'.$i.'" name="dateId'.$i.'" value="'.$dateValue.'"></p>

							<p><input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="displayCommentBox('.$i.')" value="1" checked />	Holiday

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="hideCommentBox('.$i.')" value="2" autocomplete="off" />	Reserve day

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'" onClick="hideCommentBox('.$i.')"  value="0" />	Cancel</p></p>

							<input class="form-control" type="textbox" id="textbx'.$i.'" name="reason'.$i.'" value="'.$holiday_reason.'" placeholder="Reason for the holiday in date '.$dateValue.'" ></p>';	

						

					*/}else if($holiday_det['holiday_reserve_status']==1){/*

						

						$dateArray.='<p dateid="'.$i.'"><strong>'.$dateValue.'</strong>' .' '.'

							<input type="hidden" id="dateId'.$i.'" name="dateId'.$i.'" value="'.$dateValue.'"></p>

							<p><input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="displayCommentBox('.$i.')" value="1" />	Holiday

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="hideCommentBox('.$i.')" value="2" checked />	Reserve day

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'" onClick="hideCommentBox('.$i.')"  value="0" />	Cancel</</p>

							<input class="form-control" style="display:none" type="textbox" id="textbx'.$i.'" name="reason'.$i.'" disabled value="" placeholder="Reason for the holiday in date '.$dateValue.'" ></p>';	

					*/}

				}

			}

		}

		echo $dateArray;

	}

	

	function createDateRangeArrApprovedEdit() {

		

		//print_r($_POST);exit;

		$port_id  =$this->input->post('port_id');

		$period_name    =$this->input->post('period_name');

		$port_id		= 	$this->security->xss_clean(htmlentities($port_id));

		$period_name		= 	$this->security->xss_clean(htmlentities($period_name));

		/*$start_date = date("Y-m-d", strtotime($start_date));

		$end_date = date("Y-m-d", strtotime($end_date));*/

		$monthly_permit			= 	$this->Master_model->get_montly_permit_by_period($period_name,$port_id);

		$monthly_permit_id		=	$monthly_permit['monthly_permit_id'];

		$lsgd_section_id		= 	$monthly_permit['lsg_section_id'];

		//$port_id				= 	$monthly_permit['port_id'];



		$monthly_permit['monthly_permit_permit_status'];

		//Getting Dates of the Permit Period Without Any Bookings

		$noBookingdays		=	$this->Master_model->get_booking_free_days($monthly_permit_id,$period_name,$port_id,$lsgd_section_id);

		

		$holidayArr=array();

		$noBookingdaysArr=array();

		$list_holidays=$this->Master_model->get_holidaylist_by_periodname($port_id,$period_name);

		//echo '<pre>';print_r($list_holidays);exit;

		if(count($list_holidays)>0){

			foreach($list_holidays as $holiday){

				$holiday_date=$holiday['holiday_date'];

				if($holiday_date!='' || $holiday_date!=0){

					array_push($holidayArr,$holiday_date);

				}

			}

		}

		if(count($noBookingdays)>0){

			foreach($noBookingdays as $noBook){

				$noBook_date=$noBook['customer_booking_allotted_date'];

				if($noBook_date!='' || $noBook_date!=0){

					array_push($noBookingdaysArr,$noBook_date);

				}

			}

		}

		//$noBookingdaysArr=array_merge($holidayArr,$noBookingdaysArr);

		//echo '<pre>';print_r($holidayArr);exit ;

		$start_date= date('01-m-Y', strtotime($period_name));

		$end_date=date('t-m-Y',strtotime($period_name));

		$format = 'Y-m-d';

		$start  = new DateTime($start_date);

		$end    = new DateTime($end_date);

		$invert = $start > $end;

		

		$dates = array();

		$dates[] = $start->format($format);

		while ($start != $end) {

			$start->modify(($invert ? '-' : '+') . '1 day');

			$dates[] = $start->format($format);

		}

		//echo '<pre>';print_r($dates);exit ;

		

		$i=0;

		

		

		/*foreach($noBookingdaysArr as $bdate){

			

			$pos	=	array_search($bdate,$dates);

			//print_r($pos);exit;

			if($pos >= 0){

				//array_push($freeBookDayArr,$dates[$i]);

				//unset($dates[$pos]);

				$dates[$pos]='';

			}

			//print_r($pos);exit ;

			$i++;

		}*/

				

		//echo '<pre>';print_r($dates);exit;

		//print_r($dates);exit;

		$dateArray='<p><input type="hidden" id="totalDatecount" name="totalDatecount" value="'.count($dates).'"></p>';

		for($i=0;$i<count($dates);$i++){

			$dateValue=$dates[$i];

			$idDate=strtotime($dateValue);

			

			if(in_array($dateValue,$holidayArr)!=1){

			

				$dateArray.='<p dateid="'.$i.'"><strong>'.$dateValue.'</strong>' .' '.'

					<input type="hidden" id="dateId'.$i.'" name="dateId'.$i.'" value="'.$dateValue.'"></p>

					<p><input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="displayCommentBox('.$i.')" value="1" autocomplete="off" />	Holiday

					<input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="hideCommentBox('.$i.')" value="2" autocomplete="off" />	Reserve day				

					<input type="radio" id="radiobx'.$i.'" name="date'.$i.'" onClick="hideCommentBox('.$i.')"  value="0" />	Cancel</p>

					<input class="form-control" style="display:none" type="textbox" id="textbx'.$i.'" name="reason'.$i.'" disabled value="" placeholder="Reason for the holiday in date '.$dateValue.'" ></p>';

			}else{

				$pos = array_search($dateValue,$holidayArr);

				$holiday_det=$list_holidays[$pos];

				//print_r($holiday_det);exit;

				if($holiday_det!='' ){

					if($holiday_det['holiday_reserve_status']==0 ){/*

						$holiday_reason=$holiday_det['holiday_reason'];

						$dateArray.='<p dateid="'.$i.'"><strong>'.$dateValue.'</strong>' .' '.'

							<input type="hidden" id="dateId'.$i.'" name="dateId'.$i.'" value="'.$dateValue.'"></p>

							<p><input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="displayCommentBox('.$i.')" value="1" checked />	Holiday

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="hideCommentBox('.$i.')" value="2" autocomplete="off" />	Reserve day

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'" onClick="hideCommentBox('.$i.')"  value="0" />	Cancel</p></p>

							<input class="form-control" type="textbox" id="textbx'.$i.'" name="reason'.$i.'" value="'.$holiday_reason.'" placeholder="Reason for the holiday in date '.$dateValue.'" ></p>';	

						

					*/}else if($holiday_det['holiday_reserve_status']==1){/*

						

						$dateArray.='<p dateid="'.$i.'"><strong>'.$dateValue.'</strong>' .' '.'

							<input type="hidden" id="dateId'.$i.'" name="dateId'.$i.'" value="'.$dateValue.'"></p>

							<p><input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="displayCommentBox('.$i.')" value="1" />	Holiday

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'"  onClick="hideCommentBox('.$i.')" value="2" checked />	Reserve day

							<input type="radio" id="radiobx'.$i.'" name="date'.$i.'" onClick="hideCommentBox('.$i.')"  value="0" />	Cancel</</p>

							<input class="form-control" style="display:none" type="textbox" id="textbx'.$i.'" name="reason'.$i.'" disabled value="" placeholder="Reason for the holiday in date '.$dateValue.'" ></p>';	

					*/}

				}

			}

		}





		echo $dateArray;

	}

	

	

	public function delete_holidays()

	{

		$period_name=$this->input->post('period_name');

		$port_id=$this->input->post('port_id');

		$period_name	= 	$this->security->xss_clean(htmlentities($period_name));

		$port_id		= 	$this->security->xss_clean(htmlentities($port_id));

		$this->load->model('Manual_dredging/Master_model');

		$result='';

		$res=0;

		$isPermitApproved=$this->Master_model->get_montlyPermit_by_periodname($period_name,$port_id);

		//print_r($isPermitApproved);exit;

		if($isPermitApproved['monthly_permit_permit_status']==2){

			$result='Sorry !! Holidays cant be deleted after the approval of monthly permit!!';

			$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Sorry !! Holidays cant be deleted after the approval of monthly permit!!</div>'); 

		}else{

			$res=$this->Master_model->delete_holiday_by_periodname($period_name,$port_id);

			if($res==1){

				$result='Holidays for the period '.$period_name.' deleted!!!!!!';

				$this->session->set_flashdata('msg', '<div class="alert alert-info alert-dismissible">Holidays for the period '.$period_name.' deleted!!!</div>');

			}

		}

		

		echo $result;

	}

	

	public function checkStartDate($date){

		$start=explode("/",$date);

		//print_r($start);exit;

		if ($start[2]=='01')

			return true;

		else{

			return false;

			$this->form_validation->set_message('checkStartDate', 'The %s field must be the first day of the month');

		}

		

	} 

	public function checkEndDate($date) {

		$last=date('t',strtotime($date));

		$start=explode("/",$date);

		if ($start[2]==$last)

			return true;

		else{

			return false;

			$this->form_validation->set_message('checkEndDate', 'The %s field must be the last day of the month');

		}

		

	}

	public function chech_worker_adhar_exists() {

		$adhar_no  =$this->security->xss_clean(html_escape($this->input->post('adhar_no')));

		$isAdharExists=$this->Master_model->get_worker_by_adhar($adhar_no);

		if (count($isAdharExists))

			echo 0;

		else{

			echo 1 ;

		}

		

	}

	public function adharcheck($str)

    {

		if( $str!=""){

			$isAdharExists=$this->Master_model->get_worker_by_adhar($str);

			if (count($isAdharExists))

			{

				$this->form_validation->set_message('adharcheck', 'The %s is already exists');

				return FALSE;

			}

			else

			{

				return TRUE;

			}

		}

	}

	function holiday_checking_Ajax() 

	{

		$port_id  =$this->input->post('port_id');

		$period_name    =$this->input->post('period_name');

		$zone_id=$this->input->post('zone_id');

		$port_id		= 	$this->security->xss_clean(htmlentities($port_id));

		$period_name		= 	$this->security->xss_clean(htmlentities($period_name));

		$isHolidaySet=$this->Master_model->get_holiday_by_periodnamenew($period_name,$port_id,$zone_id);

		

	//	print_r($isHolidaySet);exit();

		if(count($isHolidaySet)>0){

			echo 1;

		}else

			echo 0;

	

	}

	function monthlypermit_approval_pdf_dwnld($permit_id)

	{

		//print_r(decode_url($this->uri->segment(3)));break;

		//echo '<pre>';print_r($logtableArr);break;

		//echo $insert_log;break;

		//$permit_id 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
		$permit_id 				= 	$this->uri->segment(4);
		$permit_id 				= 	decode_url($permit_id); 

		//$permit_id   			=	$this->input->post('permit_id');

		$permit_id				= 	$this->security->xss_clean(htmlentities($permit_id));

		$get_permit_details		= 	$this->Master_model->get_monthly_permit_by_id($permit_id);

		//print_r($get_permit_details	);break;

		$zone_name				=	$this->Master_model->get_zone_name_by_id($get_permit_details['zone_id']);

		$lsgd_name				=	$this->Master_model->get_lsgdname_by_id($get_permit_details['lsg_id']);

		$district_name			=	$this->Master_model->get_districtname_by_id($get_permit_details['lsg_id']);

		$vchr_portoffice_name	=	$this->Master_model->get_port_details($get_permit_details['port_id']);

		$lsgd_name				=	$this->Master_model->get_lsgdname_by_id($get_permit_details['lsg_id']);

		

		$requested_ton=$get_permit_details['monthly_permit_requested_ton'];

		$approved_ton=$get_permit_details['monthly_permit_approved_ton'];

		$period_name=$get_permit_details['monthly_permit_period_name'];

		$sand_rate=$get_permit_details['sand_rate'];

		$monthly_permit_permit_number=$get_permit_details['monthly_permit_permit_number'];

		$order_number=$get_permit_details['monthly_permit_order_number'];

		$permit_number=$get_permit_details['monthly_permit_permit_number'];

		$approved_on=$get_permit_details['monthly_permit_approved_timestamp'];

		$approved_on=date_create($approved_on)->format('d-m-Y');

		$approved_by_id=$get_permit_details['monthly_permit_approved_user'];

		$approved_by_user_details		= $this->Master_model->user_details_by_id($approved_by_id);

		$approved_designation			= $approved_by_user_details['user_master_fullname'];

		

		$vchr_portoffice_name=$vchr_portoffice_name['vchr_portoffice_name'];

		$district_name=$district_name['district_name'];

		$zone_name=$zone_name['zone_name'];

		$lsgd_name_name=$lsgd_name['lsgd_name'];

		$lsgd_address=$lsgd_name['lsgd_address'];

		$period_name=$get_permit_details['monthly_permit_period_name'];

		$period_month=explode(" ",$period_name);

		$period_month=$period_month[0];

		$lsgd_name_name=$lsgd_name['lsgd_name'];

		$lsgd_address=$lsgd_name['lsgd_address'];

		

		$lsgd_panchayth_id=$lsgd_name['panchayath_sl'];

		

		$lsgd_type	=	$this->Master_model->get_lsgdtype_by_id($lsgd_panchayth_id);

		if($lsgd_type!=''){

			$lsgd_type	=	$lsgd_type['tnyLBTypeID'];

		}else{

			$lsgd_type=5;	

		}

		if($lsgd_type==1){

			$lsgd_type_name='District Panchayath';

		}

		if($lsgd_type==2){

			$lsgd_type_name='Block Panchayath';

		}

		if($lsgd_type==3){

			$lsgd_type_name='Municipality';

		}

		if($lsgd_type==4){

			$lsgd_type_name='Corporation';

		}

		if($lsgd_type==5){

			$lsgd_type_name='Grama Panchayth';

		}

		$period		= 	date_create($get_permit_details['monthly_permit_start_date'])->format('d-m-Y').' to '.date_create($get_permit_details['monthly_permit_end_date'])->format('d-m-Y');

//<img width="100px" src="http://117.239.77.22/~portusr/Seal_of_Kerala.svg.png" style="margin-left:290px" />

		$html='';

		$this->load->library('M_pdf');

		$this->m_pdf->pdf->AddPage('P');

		//$this->m_pdf->pdf->showImageErrors=true;

		$html='<style>p{text-align:left;margin:3px;font-size:14px;}</style>

		<img width="100px" src="'.base_url().'assets/images/Seal_of_Kerala.svg.png" style="margin-left:290px" />

				<h4 style="text-align:center">PERMIT</h4>

				<h3 style="text-align:center">(See appendix A)</h3>

				<div>Order No:'.$order_number.'</div><div style="text-align:right">Dated :'.$approved_on.'</div>

				<p>This permit is issued to the under mentioned '.$lsgd_name_name.' '.$lsgd_type_name.' for the manual dredging and transportation of dredged material(sand) from the '.$zone_name.' ZONE of '.$vchr_portoffice_name.' port in '.$district_name.' district during the period '.$period.'

</p>

				<hr/>

				<table border="0" style="text-align:center;margin:5px;padding;5px;" width="100%">

					<thead>

						<tr>

							<th width="10%">Sl No</th>

							<th width="40%">Name and Address of permit holder</th>

							<th width="20%">Kadavu</th>

							<th width="20%">Month</th>

							<th width="30%">Permited Quantity</th>

						</tr>

					</thead>

					<tdata style="text-align:center;">

						<tr>

							<td width="10%">1</td>

							<td width="40%">'.$lsgd_name_name.'<br>'.$lsgd_address.'</td>

							<td width="20%">'.$zone_name.'</td>

							<td width="20%">'.$period_month.'</td>

							<td width="30%">'.$approved_ton.'</td>

						</tr>

					</thead>

				</table>

				<hr/>

				<p> This permit is subject to the following terms and conditions and is liable to be suspended/terminated in case of violation of terms and conditions/government orders. <br>

				1. The Port department reserves the right to revoke this permit at any time without notice and without any liability to refund any fee paid by the permit holder. <br>

				

				2.No country boat or any other vessel shall be put into use unless it has been registered under the Harbour craft rules 1970. <br>

				

				3.Timing of manual dredging (6 am to 4 pm) and transportation (8 am to 4 pm) shall be strictly adhered.Any changes in timing shall be made only with prior permission. <br>

				

				4.The dredged material (sand) removed from the channel shall not be permanently deposited within 500 meters from the high water mark of sea/river as per CRZ Norms.Material shall be transported only with valid vehicle pass issued from this office. <br>

				

				5.Dredging shall be carried out only/from the designated port area within port limits.<br> 

				

				6.LSGDs shall take necessary precautions against loss/theft of dredged material kept in kadavus. <br>

				

				7.Proper registers and accounts shall be maintained by the LSGDs.<br>

				

				8.Necessary precautions shall be taken against occurrence any accident/loss of lives,loss of property etc. <br>

				

				9.The rate of dredged material is liable to change as and when decided by government/port department.<br>

</p>

<br>

<br>

<p>&nbsp;</p>

				<div style="text-align:right"><span>'.strtoupper($approved_designation).' <br>'.$vchr_portoffice_name.'</span></div>

				<div>

					<p>To</p>

					<p>The Secretary </p>

					<p>'.$lsgd_name_name.'</p>

					<p>'.$lsgd_address.'</p>

					

				</div>';

				//print_r($html);break;

		$this->m_pdf->pdf->WriteHTML($html);

		//$this->m_pdf->pdf->Output(base_url().'assets/monthly_permit_pdf/'.$monthly_permit_permit_number.'.pdf','F');

		$sucss = $this->m_pdf->pdf->Output($permit_number.'.pdf','D');//exit;

		

		

	

	}

	function holy()

    {

        $sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details= $this->Master_model->user_details_by_id($sess_usr_id);

		

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{	

			if($_POST)

			{

				

			}

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/calendar');
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	   }

	   else

	   {

			redirect('Main_login/index');        

	   }  

	}

	public function transferCusBooking($holiday_date){

		//$holiday_date='2017-06-21';

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id	= $user_details['user_master_port_id'];

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{

			

			$lsg_section_arr=$this->Master_model->get_lsg_section_booking_List($holiday_date,$port_id);

			$customerBookingList=$this->Master_model->get_customerBookingList($holiday_date,$port_id);

			/*$reserveDayList=$this->Master_model->get_reserveDayList($holiday_date,$port_id);

			$totalAllottedTon=$this->Master_model->get_totalAllottedTon($holiday_date,$port_id);

			$totalAllottedTon=$totalAllottedTon['SUM(customer_booking_request_ton)'];

			$totalReseveDayBalnceTon=$this->Master_model->get_totalReseveDayBalnceTon($holiday_date,$port_id);

			$totalReseveDayBalnceTon=$totalReseveDayBalnceTon['SUM(daily_log_balance)'];*/

			$customerBooking_Group_List=array();

			foreach ($customerBookingList as $data) {

			  $id = $data['customer_booking_lsg_section_id'];

			  if (isset($customerBooking_Group_List[$id])) {

				 $customerBooking_Group_List[$id][] = $data;

			  } else {

				 $customerBooking_Group_List[$id] = array($data);

			  }

			}



			//return $return;

			//echo '<pre>';print_r($customerBooking_Group_List);exit;

			//ksort($arr, SORT_NUMERIC);

			//print_r($arr);break;

			$result_arr=array();

			if($customerBooking_Group_List!=''){

				$i=0;$j=0;

				foreach($customerBooking_Group_List as $key => $booking_list){

					$lsgd_section=$key;

					//echo '<pre>';print_r($booking_list);exit;

					$totalAllottedTon=$this->Master_model->get_totalAllottedTon($holiday_date,$port_id,$lsgd_section);

					$totalAllottedTon=$totalAllottedTon['SUM(customer_booking_request_ton)'];

					

					$totalReseveDayBalnceTon=$this->Master_model->get_totalReseveDayBalnceTon($holiday_date,$port_id,$lsgd_section);

					$totalReseveDayBalnceTon=$totalReseveDayBalnceTon['SUM(daily_log_balance)'];

					//echo $totalAllottedTon.' && '.$totalReseveDayBalnceTon;exit;

					if($totalReseveDayBalnceTon>=$totalAllottedTon){

						

						//sort booking list

						

						usort($booking_list, array('Master', 'sortByOrder'));

						//usort($booking_list, 'customer_booking_priority_number');

						//echo '<pre>';print_r($reserveDayList);exit;

						$j=0;

						foreach($booking_list as $key => $booking){

							$booking_id = $booking['customer_booking_id'];

							$reserveDayList=$this->Master_model->get_reserveDayList($holiday_date,$port_id,$lsgd_section);

							//echo '<pre>';print_r($booking);exit;

							foreach($reserveDayList as $reserveDay){

								$newHoliday= $reserveDay['holiday_date'];

								$dailylog_id= $reserveDay['daily_log_id'];

								$booking_req_ton=$booking['customer_booking_request_ton'];

								$daily_balance=$reserveDay['daily_log_balance'];

								/*if($booking_req_ton=''){

									$booking_req_ton=0;

								}*/

								$maxPriority = $this->Master_model->max_priority_number($newHoliday,$port_id,$lsgd_section);

								$maxPriority=$maxPriority['MAX(customer_booking_priority_number)'];

								if($maxPriority==''){

									$maxPriority=0;

								}

								//print_r($reserveDay);exit;

								if(($daily_balance >= $booking_req_ton) && $daily_balance>0){

									//Alloting Date for the Booking to this Reserve Day

									$updateSucc=$this->Master_model->transfer_booking_to_reserve($newHoliday,$booking_id,($maxPriority+1));

									if($updateSucc){

										//Update Daily Log ( Decreasing Daily Lod Balance)

										$newBalance=$daily_balance-$booking_req_ton;

										$updateLog=$this->Master_model->update_daily_log_balance_ton($dailylog_id,$newBalance);

										//Removing Booking From Array

										unset($booking_list[$key]);

										//unset($customerBooking_Group_List[$i][$key]);

										$result_arr[$lsgd_section][$j]='success '.$key;

										break;// First Booking is placed to new date so no further search to reserve day for current booking	

									}

								}else{

									//Take the next Reserve day

									//continue;

								}

								

							}

						$j++;	

						}

						

					}else{

						//Reserve day blance is not sufficient for the transfer 

						//return 1;

						$result_arr[$i][$j]='No sufficient daily balance for the avialable Reserve days for lsgd '.$key;

						

					}

					$i++;

				}

				//echo '<pre>';print_r($customerBooking_Group_List);exit;

				return $result_arr;

			}else{

				return 0;

			}

		}

		

	}

	public function sortByOrder($a,$b) {

		return $a['customer_booking_priority_number'] - $b['customer_booking_priority_number'];

	}

	public function holidays_add_Ajax(){

		

	

	//echo '<pre>';print_r($_POST);exit;
$this->load->model('Manual_dredging/Master_model');
		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');
		
		$user_details= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id	= $user_details['user_master_port_id'];

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{

			$type_id  =$this->input->post('type_id');

			$holy_date    =$this->input->post('holy_date');

			$holyreason  =$this->input->post('holyreason');

			$port_id  =$this->input->post('port_id');

			$period_name    =$this->input->post('period_name');

			$zone_id  =$this->input->post('zone_id');

			//$permit_status	=$this->input->post('permit_status');

			$type_id		= 	$this->security->xss_clean(htmlentities($type_id));

			$holy_date		= 	$this->security->xss_clean(htmlentities($holy_date));

			$holyreason		= 	$this->security->xss_clean(htmlentities($holyreason));

			$period_name	= 	$this->security->xss_clean(htmlentities($period_name));

			$port_id		= 	$this->security->xss_clean(htmlentities($port_id));

			$zone_id		= 	$this->security->xss_clean(htmlentities($zone_id));

			//$permit_status	= 	$this->security->xss_clean(htmlentities($permit_status));

			//$permit_status_arr	= 	$this->Master_model->get_monthly_permit_details($port_id,$period_name);

			$permit_status_arr	= 	$this->Master_model->get_monthly_permit_detailsnew($port_id,$zone_id,$period_name);

			

			if(count($permit_status_arr)>0){

				//echo '<pre>';print_r($permit_status);exit;

				//$permit_status	= $permit_status[0]['monthly_permit_permit_status'];

				foreach($permit_status_arr as $value){

					if($value['monthly_permit_permit_status']==2){

						$permit_status=2;break;

					}

				}

			}else{

				$permit_status=1;

			}

			if($permit_status==2){

				echo '0#Sorry holidays/Reserve Days can not be changed after the Approving any of the corresponding Monthly Permit !';

				exit;	

			}

			$holiday_status=0;

			$reserveFlag=0;

			if($type_id==1){

				$holiday_status=1;

				if($holyreason==''){

					echo '0#Please enter the reason for the holiday ';

					exit;	

				}

			}

			else if($type_id==2){

				$reserveFlag=1;

				$holyreason=NULL;

			}

			if($holy_date!='' && $holy_date!=0){

				$isHolidaySet=$this->Master_model->get_holiday_by_datenew($period_name,$port_id,$zone_id,$holy_date);

				if($isHolidaySet['holiday_reserve_status']==1 && $isHolidaySet['holiday_status']==0){

					$delResSuc=$this->Master_model->delete_holiday_by_datenew($period_name,$port_id,$holy_date,$zone_id);

					//echo '<pre>';print_r($delResSuc);exit;

				}

				//echo '<pre>';print_r(count($isHolidaySet));exit;

				if(count($isHolidaySet)>0 && $isHolidaySet['holiday_status']==1){

					echo '0#Sorry, Holiday for the given date '.$holiday_date.' is already exists !!!';

					exit;

				}else{

					

					//Checking Customer Booking

					$customerBookingList=$this->Master_model->get_customerBookingListnew($holy_date,$port_id,$zone_id);

					if(count($customerBookingList)>0){

						

						$succesTransfer=$this->transferCusBooking($holy_date);	

						//echo '<pre>';print_r($succesTransfer);exit;

						//print_r($succesTransfer);exit;

					}

					$data = array(

						'holiday_date' => $holy_date,  

						'holiday_reason' => $holyreason,

						'holiday_port_id' => $port_id,

						'holiday_zone_id' => $zone_id,

						'holiday_period_name' => $period_name,

						'holiday_user_id'=>$sess_usr_id,

						'holiday_status'=>$holiday_status,

						'holiday_reserve_status'=>$reserveFlag

					);

					$holiday_succ=$this->db->insert('holiday', $data);

				}

				//Updating No of working days in Holday Port

				//echo $holiday_succ.'#'.$permit_status.'#'.$holiday_status;exit;

				if($holiday_succ==1 && $permit_status==1 && $holiday_status==1){

					$inc_succ=$this->Master_model->decrement_working_daysnew($period_name,$port_id,$zone_id);

				}

				

			}

			if($holiday_succ){

				if($reserveFlag==1){$holyType= "Reserve Day";}else{$holyType= "Holiday";}

				echo '1#'.$holyType.' added Successfully ';exit;

			}else{

				echo '0#'.'Sorry, an error occured !!!';

			}

		}

	

		}





/////////////////////////





//////



//// Liju End



////

public function printProc()

{

 //$lsg_sec_id=decode_url($this->uri->segment(3));//------comment on 6/11/2019---------port intergration------------
$lsg_sec_id=decode_url($this->uri->segment(4));
 $this->load->model('Manual_dredging/Master_model');

 $ls=$this->Master_model->get_sec_det_pr($lsg_sec_id);

 //$ls[0]['lsgd_address']

 $wqty	= 	$this->Master_model->get_workerqty_master();

 $wc=$wqty[0]['worker_quantity'];

 $nw=$ls[0]['lsg_section_user'];

 $tm_s=$ls[0]['lsg_section_timestamp'];

 $startt=explode(" ",$tm_s);

 $sd=$startt[0];

 $ed=date("Y-m-d", strtotime(date("Y-m-d", strtotime($sd)) . " + 1 year"));

 $did=$ls[0]['int_district_id'];

 $dd=$this->Master_model->get_district_byID($did);

 $tt=$wc*$nw*12;

 //exit();

 //find Amount

 $port_id=$ls[0]['port_id'];

 $zone_id=$ls[0]['zone_id'];

 $tax=$this->Master_model->get_materials_with_tax();

 $mat_id=$tax['tax_calculator_materials'];

 $ma=explode(',',$mat_id);

 $t_rate=$tax['tax_calculator_rate'];

 $amt_wt=0;

 $amt_wt1=0;

 $amt_wt2=0;

 $amt_wt3=0;

 $amt_wt4=0;

 $amt_wt5=0;

 $material=$this->Master_model->get_material_master_act();

 foreach($material as $mat)

 {

	 $mid=$mat['material_master_id'];

	

		 if($mat['material_master_authority']==1)

		 {

			 if(in_array($mid,$ma))

			 {

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 if(!empty($m_r))

				 {

				 $amt_wt=$amt_wt+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

				 }

			 }

			 else

			 {

				 if(!empty($m_r))

				 {

				 	$amt_wt1=$amt_wt1+$m_r[0]['materialrate_port_amount'];

				 }

			 }

		 }

		 else

		 {

			  if(in_array($mid,$ma))

			 {

				 //echo $mat['material_master_id'];

				 if(!empty($m_r))

				 {

					 $m_r=$this->Master_model->get_materialrateByMatID($mid);

					 //print_r($m_r);

					 if($m_r[0]['materialrate_domain']==2)

					 {

						 if(!empty($m_r))

						 {

							$amt_wt2=$amt_wt2+($m_r[0]['materialrate_port_amount']+$m_r[0]['materialrate_port_amount']*($t_rate/100));

						 }

					 }

					 else

					 {

						$m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

						if(!empty($m_rn))

				 		{

						 $amt_wt3=$amt_wt3+($m_rn[0]['materialrate_port_amount']+$m_rn[0]['materialrate_port_amount']*($t_rate/100));

						}

					 }

				 }

			 }

			 else

			 {

				 $m_r=$this->Master_model->get_materialrateByMatID($mid);

				 if(!empty($m_r))

				 {

					 if($m_r[0]['materialrate_domain']==2)

					 {

						// echo "ff";

						$amt_wt4=$amt_wt4+$m_r[0]['materialrate_port_amount'];

					 }

				 }

				 else

				 {

					$m_rn=$this->Master_model->get_materialrateByMatIDs($port_id,$mid,$zone_id);

					if(!empty($m_rn))

				 	{//print_r($m_rn);

					 $amt_wt5=$amt_wt5+$m_rn[0]['materialrate_port_amount'];

					}

				 }

			 }

		 }

 }

 //echo $amt_wt."_".$amt_wt1."_".$amt_wt2."_".$amt_wt3."_".$amt_wt4."_".$amt_wt5;

 //echo "<br>";

 $sand_rate=$amt_wt+$amt_wt1+$amt_wt2+$amt_wt3+$amt_wt4+$amt_wt5;

 //echo $sand_rate;

// exit();

 //

 $sdn=date("d-m-Y",strtotime(str_replace('-', '/',$sd)));

  $edn=date("d-m-Y",strtotime(str_replace('-', '/',$ed)));

 $html="<center><font face='Times New Roman'><table border='0' width='100%'>

  <tr>

    <td colspan='4' align='center'><b>PROCEEDINGS OF THE SENIOR PORT CONSERVATOR, ".$ls[0]['vchr_portoffice_name']."<b><br/><p>&nbsp;</p>(Present : pc in Full Addl. Charge of Senior Port Conservator)<br/><p>&nbsp;</p><p>&nbsp;</p></td>

  </tr>

  <tr>

    <td style='font-size:12px'>ORDER NO :".$ls[0]['lsg_zone_order_number']."</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td align='right' style='font-size:12px'>Dated :$sdn</td>

  </tr>

</table></center>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p align='justify'>&nbsp;&nbsp;&nbsp;&nbsp;A large number of complaints have been received from masters of vessels calling at ".$ls[0]['vchr_portoffice_name']." Port on the

non-availability of sufficient drafts in Port Channel,which is creating difficulties for the smooth port operation.As per

letter read 4 th ,Director of Ports had directed to start manual dredging in the port limits of ".$ls[0]['vchr_portoffice_name']." immediately. In

the reference read as 6 th above,the ".$ls[0]['lsgd_address']."

".$ls[0]['lsgd_address']." requested permission to remove ".$tt." tons of sand deposited in ".$ls[0]['vchr_portoffice_name']." Port channel

using manual dredging method.</p>

<p align='justify'>&nbsp;&nbsp;&nbsp;&nbsp;Accordingly as per the decision of permit application/tender evaluation committee referred 3 th above ,orders

are hereby issued for granting manual dredging permit to the under mentioned Local body for a period from $sdn

to $edn, in accordance with the Government Order read 1 st above and subsequent orders/Circulars.(Permit

Appended).</p>

<table border='0' width='100%'>

<tr><th>Sl No.</th><th>Name of Local Body</th><th align='center'>Zone No.</th><th align='center'>Quantity in Tons</th></tr>

<tr><td align='center'>1</td><td align='center'>".$ls[0]['lsgd_address']."</td><td align='center'>".$ls[0]['zone_code']."</td>

<td align='center'>".$tt."</td>

</tr>

</table>

<p align='justify'>The Committee also fixed the selling price of sand at various Jetty/Kadavu in ".$ls[0]['vchr_portoffice_name']." Port during the 3 rd

stage evaluation process as Rs. $sand_rate/- per ton. This rate shall be applicable to all the permit holders in the port limits.</p>

<p align='justify'>The renewal of the monthly permit shall be subject to the compliance of Government orders and orders issued

by the Port authorities in force.</p>

<center>

<table border='0' width='100%'>

<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>Senior Port Conservator<br>

".$ls[0]['vchr_portoffice_name']."</td></tr>

<tr>

<td colspan='4'>

To<br>

".$ls[0]['lsgd_address']."

</td>

</tr>

<tr>

<td colspan='4'>

Copy To:-<br>

The Geologist,".$dd[0]['district_name']."

</td>

</tr>

</table></font></center>";

				$fname=$ls[0]['lsgd_name']."_proceedings.pdf";

				$this->load->library('M_pdf');

				$this->m_pdf->pdf->AddPage('P');

				$this->m_pdf->pdf->WriteHTML($html);

				$this->m_pdf->pdf->Output($fname,'D');

}

public function etestprint()

{

 

  

 $html="<h1>hello</h1>";

				$fname="proceedings.pdf";

				$this->load->library('M_pdf');

				$this->m_pdf->pdf->AddPage('P');

				$this->m_pdf->pdf->WriteHTML($html);

				$this->m_pdf->pdf->Output($fname,'D');

}

public function RemoveReserveDay_Ajax(){
//echo '<pre>';print_r($_POST);exit();

	 $this->load->model('Manual_dredging/Master_model');

		//echo '<pre>';print_r($_POST);exit();

		$sess_usr_id = $this->session->userdata('int_userid');

		$sess_user_type=$this->session->userdata('int_usertype');

		$user_details= $this->Master_model->user_details_by_id($sess_usr_id);

		$port_id	= $user_details['user_master_port_id'];

		if(!empty($sess_usr_id) && ($sess_user_type==3 || $sess_user_type==7))

		{

			$type_id  =$this->input->post('day_type');

			$holy_date    =$this->input->post('holy_date');

			//$holyreason  =$this->input->post('holyreason');

			$port_id  =$this->input->post('port_id');

			$period_name    =$this->input->post('period_name');

			//$permit_status	=$this->input->post('permit_status');

			$type_id		= 	$this->security->xss_clean(htmlentities($type_id));

			$holy_date		= 	$this->security->xss_clean(htmlentities($holy_date));

			//$holyreason		= 	$this->security->xss_clean(htmlentities($holyreason));

			$period_name	= 	$this->security->xss_clean(htmlentities($period_name));

			$port_id		= 	$this->security->xss_clean(htmlentities($port_id));

			$permit_status_arr	= 	$this->Master_model->get_monthly_permit_details($port_id,$period_name);

			//$date_format	= 	date('d-m-Y',$holy_date);

			$date_format	= 	date_create($holy_date)->format('d-m-Y');

			$permit_status=1;

			if(count($permit_status_arr)>0){

				//echo '<pre>';print_r($permit_status);exit;

				//$permit_status	= $permit_status[0]['monthly_permit_permit_status'];

				foreach($permit_status_arr as $value){

					if($value['monthly_permit_permit_status']==2){

						$permit_status=2;break;

					}

				}

				if($permit_status==2){

					echo '0#Sorry holidays/Reserve Days can not be changed after the Approving any of the corresponding Monthly Permit !';

					exit;	

				}

				if($permit_status==3){

					echo '0#Sorry this Monthly Permit is Rejected';

					exit;	

				}if($permit_status==1){

					//Monthly permut is not approved

					//Deleting Reserveday 

					if($type_id==4){

						$del_succ	=	$this->Master_model->delete_reserve_day_by_date($port_id,$period_name,$holy_date);

					}else if($type_id==5){

						$del_succ	=	$this->Master_model->delete_holi_day_by_date($port_id,$period_name,$holy_date);

						//Decrement no of working days from table holiday_port

						if($del_succ){

							$del_succ	=	$this->Master_model->increment_working_days($period_name,$port_id);

						}

					}

				}

			}else{

					//Monthly permut is not exist

					//Deleting Reserveday 

					if($type_id==4){

						$del_succ	=	$this->Master_model->delete_reserve_day_by_date($port_id,$period_name,$holy_date);

					}else if($type_id==5){

						$del_succ	=	$this->Master_model->delete_holi_day_by_date($port_id,$period_name,$holy_date);

						//Decrement no of working days from table holiday_port

						if($del_succ){

							$del_succ	=	$this->Master_model->increment_working_days($period_name,$port_id);

						}

					}

			}

			

			if($del_succ){

				if($type_id==4){

					echo '1#'.$date_format.' removed from Reserve Day List Successfully ';exit;

				}else{

					echo '1#'.$date_format.' removed from Holiday List Successfully ';exit;

				}

			}else{

				echo '0#'.'Sorry, an error occured !!!';exit;

			}

		}

	

	}

	public function vehicle_pass_success()

	{

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id 				= 	$this->uri->segment(4);
			$id			=		decode_url($id);		

			$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$sess_usr_id 			= 	$this->session->userdata('int_userid');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$desgofsign			=	$userinfo[0]['user_master_fullname'];  

		//exit;

			$data_vehiclepass	= 	$this->Master_model->vehiclepass_details_new($id);

			if(empty($data_vehiclepass))

			{

				redirect('Manual_dredging/Master/dashboard');

			}

			$data['data_vehiclepass']=	$data_vehiclepass;

			$data 				= 	$data + $this->data;

			//$this->load->view('template/header');
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/vehicle_pass_success',$data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

		}

		else

		{

			redirect('Main_login/index');

		}

			

	}

	

	

	

	//SEND SMS

	public function sendSms($message,$number){

		

		$link = curl_init();

		curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");

		curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($link , CURLOPT_HEADER, 0);
		
		return $output = curl_exec($link);

		curl_close($link );

}



// Report Controller



//////////////////////////////////////////////////////////   file update /////////////////////////////////////////////////

public function  check_customerphonenumber()

{

	$phone_no  =$this->security->xss_clean(html_escape($this->input->post('customerphno')));

		

		$isphoneExists=$this->Master_model->get_customer_registration_ph($phone_no);

		if (count($isphoneExists)==0)

		{

		echo 0;

		}

		else

			{

				echo 1;

			}

		

}

	public function scanpass()

	{

		//$id 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
		$id 				= 	$this->uri->segment(4);
		$tokeno 			= 	decode_url($id); 	

	

	$sess_usr_id 			= 	$this->session->userdata('int_userid');

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$desgofsign			=	$userinfo[0]['user_master_fullname'];  

	//exit;

		

		$data_vehiclepass	= 	$this->Master_model->vehiclepass_detailScan($tokeno);

		$rowcount=count($data_vehiclepass);

		if($rowcount>0)

		{

			$data['pass_type']=1;

			$data['data_vehiclepass']=$data_vehiclepass;

			$data 				= 	$data + $this->data;

			

		}else

		{

			$data['pass_type']=2;

			$data_vehiclepass	= 	$this->Reports_model->vehiclepass_details_spot_pass($bookingid);

			$data['data_vehiclepass']=$data_vehiclepass;

			$data 				= 	$data + $this->data;

		}

	

		//-------------------5/01/2018---------------------------------------------

		

				//$this->load->view('template/header');
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

			$this->load->view('Manual_dredging/Master/scanpass',$data);
$this->load->view('Kiv_views/template/dash-footer');
			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');
*/
	}

//-------------------------------------------

	public function scanpassod()

	{

		//$id 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
		$id 				= 	$this->uri->segment(4);
	$bookingid 			= 	decode_url($id); 	

	

	$sess_usr_id 			= 	$this->session->userdata('int_userid');

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$desgofsign			=	$userinfo[0]['user_master_fullname'];  

	//exit;

	$data_vehiclepass	= 	$this->Master_model->vehiclepass_details($bookingid);

		$data['data_vehiclepass']=$data_vehiclepass;

		$data 				= 	$data + $this->data;

		//-------------------5/01/2018---------------------------------------------

		

				//$this->load->view('template/header');

			$this->load->view('Manual_dredging/Master/scanpass',$data);

			/*$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	}

//----------------------------------------------------------------------------------

	public function customer_otpcheck()

{

		$temp_usr_id 			= 	$this->session->userdata('tempuser_id');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($temp_usr_id)&&$sess_user_type==5)

	{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;

			    

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];  

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;
				$this->load->view('Kiv_views/template/dash-header');
				$this->load->view('Kiv_views/template/nav-header');
				$this->load->view('Manual_dredging/Master/otpview', $data);
				$this->load->view('Kiv_views/template/dash-footer');

		 if($this->input->post('btn_add')=='Submit')

		 {

			

			$sess_otpno=$this->session->userdata('sess_otpno');

			 $txt_optnumber=$this->security->xss_clean(html_escape($this->input->post('txtotpnumber'))); 


			if($txt_optnumber==$sess_otpno)

			{

 


				$user_id=$this->session->set_userdata('int_userid',$temp_usr_id);

			 	$this->session->unset_userdata('tempuser_id');

								

				redirect('Manual_dredging/Master/customer_home');

				

			}

			else

			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your Password!!!</div>');

				redirect('Manual_dredging/Master/customer_otpcheck');

			}

			
		 }


				
				
		

	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  

}

//----------------------------------------------------------------------------

	public function customer_home()

	{
		//ini_set('display_errors', 1);
		//$temp_usr_id 			= 	$this->session->userdata('tempuser_id');

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&&$sess_user_type==5)

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;

			    

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];  

			$customerreg_details= $this->Master_model->get_customerreg_details($port_id);

			

			$data['customerreg_details']=$customerreg_details;

			$data = $data + $this->data;

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				

	   	

		//-------------------------------

			//$user_id=$this->session->set_userdata('int_userid',$temp_usr_id);

			 //	$this->session->unset_userdata('tempuser_id');

				//----------------------------------------------------------------------

				$rres=$this->db->query("select customer_registration_id as crid,customer_purpose as purpose,int_req as req_stat from customer_registration where customer_public_user_id='$sess_usr_id'");

				$ud=$rres->result_array();

				$cr_id=$ud[0]['crid'];  

				$data['purpose']=$ud[0]['purpose'];  

				$data 				= 	$data + $this->data;

				$data['req_stat']=$ud[0]['req_stat']; 

				$data 				= 	$data + $this->data;

				$buk_info			=	$this->Master_model->getbukinfo($cr_id);

				//$buk_info			=	$this->Master_model->getbukinfo($user_id);

				$buk_infout			=	$this->Master_model->getbukinfount($sess_usr_id);

				$last_booked_date	=	$buk_info[0]['bookeddate'];

				//print_r($buk_infout);

				//exit();

				$bal_sand=$buk_infout[0]['customer_unused_ton'];

				//exit();

				$last_bookeddate	=	strtotime($last_booked_date);

				$bookingtime_data= $this->Master_model->customerbooking_timecheck();

				$starttime=$bookingtime_data[0]['booking_master_start'];

				//exit;

				$endtime=$bookingtime_data[0]['booking_master_end'];

				$data['b_start']=$starttime;

				$data 				= 	$data + $this->data;

				$data['b_end']=$endtime;

				$data 				= 	$data + $this->data;

				$start_time=strtotime($starttime);

				$end_time=strtotime($endtime);

				$current_time=strtotime("now");

				$currentdate  =	date('Y-m-d H:i:s');

				$date1 = date_create($currentdate);

				$date2 = date_create($last_booked_date);

				//difference between two dates

				$diff = date_diff($date1,$date2);

				$dateInterval=$diff->format("%a");

				//$nex_d=7-$dateInterval;

				$ld=explode(" ",$last_booked_date);

				$l_d=$ld[0];

				$n_b_d=date('Y-m-d H:i:s', strtotime($l_d. ' +7 days'));

				$data['nbd']=$n_b_d;

				if($last_booked_date=='')

				{

					$data['status']="buk_allow";

				}

				else

				{

					if($bal_sand>=3)

					{

						if($current_time >= $start_time && $current_time <= $end_time)

						{

							if($dateInterval>=7)

							{

							$reqtt=$this->db->query("select * from customer_booking where customer_booking_pass_issue_user=0 and customer_booking_customer_booking='$sess_usr_id' and customer_booking_decission_status NOT IN(4,5,3)");

							$no=$this->db->affected_rows();

							if($no==0)

							{

								$data['status']="buk_allow";

							}

							else

							{

								$data['status']="buk_blockw";

							}

							}

							else

							{

								$data['status']="buk_block";

							}	

						}

					}

					else

					{

						$data['status']="limit";

					}

				}

				$secreqtt=$this->db->query("select * from customer_sec_reg where cus_reg_id='$cr_id' and customer_request_status=1");

							$secno=$this->db->affected_rows();

							if($secno==0){$data['upload']="no";}else{$data['upload']="yes";}

						// $this->load->view('template/header',$data);
						$this->load->view('Kiv_views/template/dash-header');
					$this->load->view('Kiv_views/template/nav-header');

					$this->load->view('Manual_dredging/Master/customer_home',$data);
					$this->load->view('Kiv_views/template/dash-footer');
			
		 }

	   	else

	   	{

			redirect('Main_login/index');        

  		}  



	}

	//------------------------------------------------------------------------------------------------

	

	

	public function sand_issueotp()

    {
    	ini_set('display_errors', 1);
		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$this->load->model('Manual_dredging/Master_model');	

				$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				//$this->load->view('template/header',$data);
$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');
			if($this->input->post())

			{

				$this->session->unset_userdata('sess_pass_otp',$otpno);	

			

				$this->form_validation->set_rules('txttokenno', 'Token No ', 'required');

				//$this->form_validation->set_rules('txtaadharno', 'Aadhaar No', 'required');

				

				

				if($this->form_validation->run() == FALSE)

				{

					validation_errors();

				}

				else

				{

			

					$tokennumnber=$this->security->xss_clean(html_escape($this->input->post('txttokenno')));

				//	$aadharnumber=$this->input->post('txtaadharno');

					$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

					$port_id			=	$userinfo[0]['user_master_port_id'];  

					$zone_id			=	$userinfo[0]['user_master_zone_id'];

					//$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlist($tokennumnber,$aadharnumber,$port_id,$zone_id);

				///	$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlistnn($tokennumnber,$aadharnumber,$port_id,$zone_id);

$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlistnnew($tokennumnber,$port_id,$zone_id);

					//print_r($get_bookingapprovedlist);break;

					//

					if($get_bookingapprovedlistdata)

					{

					

						$data['get_bookingapprovedlistdata']=$get_bookingapprovedlist;

						$bookingid=$get_bookingapprovedlistdata[0]['customer_booking_id'];

						$booking_id=encode_url($bookingid);

						redirect('Manual_dredging/Master/sand_issue_addmessage/'.$booking_id);

					

					}

					else

					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');

													redirect('Manual_dredging/Master/sand_issueotp');

					}

			

				}

			

			

		}

			$this->load->view('Manual_dredging/Master/sand_issueotp', $data);

			$this->load->view('Kiv_views/template/dash-footer');

			$bk_id_pass=decode_url($this->uri->segment(4));
			if($bk_id_pass!=0)

			{

				redirect('Manual_dredging/Master/generatepass/'.encode_url($bk_id_pass));

			}

		}	

		else

		{

				redirect('Manual_dredging/settings/index');        

		}

			



    }

	/////////////////////////////////////////////////////////////////////////////////

	public function otp_vehiclepass()

		{

			

			$sess_usr_id 			= 	$this->session->userdata('int_userid');

			$sess_user_type			=	$this->session->userdata('int_usertype');

			$this->load->model('Manual_dredging/Master_model');	

		//$txtaadharno=$this->security->xss_clean(htmlentities($this->input->post('txtaadharno')));

		$txttokenno=$this->security->xss_clean(htmlentities($this->input->post('txttokenno')));

			

				$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

					$port_id			=	$userinfo[0]['user_master_port_id'];  

					$zone_id			=	$userinfo[0]['user_master_zone_id'];

					$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlistnnew($txttokenno,$port_id,$zone_id);

			$rowcount=count($get_bookingapprovedlistdata); 

	//print_r($get_bookingapprovedlistdata);exit();

					if($rowcount==1)

					{

					

						$data['get_bookingapprovedlistdata']=$get_bookingapprovedlist;

						$bookingid=$get_bookingapprovedlistdata[0]['customer_booking_id'];

						$cusphoneno=$get_bookingapprovedlistdata[0]['customer_phone_number'];

						

			$currentdate  =	date('Y-m-d H:i:s');

				$otpno=rand(100000,999999);

				$smsmsg="Portinfo 2 - Dear Customer OTP generated for Vehicle Pass is $otpno.";

		

				$this->session->set_userdata('sess_pass_otp',$otpno);

				$send=$this->sendSms($smsmsg,$cusphoneno);

		//print_r($send);

		$rr=explode(",",$send); 

	//echo "rrrrr---".$rr[0];

		if($rr[0]==402)

	

		{

			

			$this->session->set_userdata('sess_pass_otp',$otpno);

		

			echo 1;

		}

				

		else

		{ 

			//$this->session->unset_userdata('sess_custpass_otp',$otpno);		

					echo 0; 

		}

					

	}

	else

	{

			

		$this->session->unset_userdata('sess_pass_otp',$otpno);		

		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');

			redirect('Manual_dredging/Master/sand_issueotp');

	}

			

}

public function vehiclepass_otpcheck()

	{

		$sess_custpass_otp 			=  $this->session->userdata('sess_pass_otp');

		

		//if($this->input->post())

		//	{

		$cusotpno=$this->security->xss_clean(htmlentities($this->input->post('otpno')));

		//exit();

		if($cusotpno==$sess_custpass_otp)

		{

			echo 1;

			//redirect("Report/add_spot_registrationnew");

		}

		else

		{

			echo 0;

			//redirect("Report/spot_otpcheck");

		}

		//	}

		

		/*$this->load->view('template/header',$data);

			$this->load->view('Report/validatespototp',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');*/

	}

	//----------------------------------------------------------------------
#
	#
	#
	#
	#
	#
	//--------O N L I N E     P A Y M E N T --------------------------------------------------
	
	public function Onlinepayment()
	{
	 $sess_usr_id = $this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	
			//$id			=		$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
			$id 				= 	$this->uri->segment(4);
			$id			=		decode_url($id);
			$data = array('title' => 'Add Sand Issue', 'page' => 'sand_issue_add', 'errorCls' => NULL, 'post' => $this->input->post());
			$data = $data + $this->data;
			$this->load->model('Manual_dredging/Master_model');
			$get_bookingdata= $this->Master_model->onlinepay_details($id);
			$port_id=$get_bookingdata[0]['customer_booking_port_id'];
		
			$data['get_bookingdata']=$get_bookingdata;
			$data = $data + $this->data;
			$get_banktype= $this->Master_model->onlinebank_type();
			$data['get_banktype']=$get_banktype;
			$data = $data + $this->data;
			
			
			
			//$monthlypermitid=$get_bookingapprovedadded[0]['customer_booking_monthly_permit_id'];
			//$permitamount=$this->Master_model->get_monthly_permit_by_id($monthlypermitid);
			//$data['permitamount']=$permitamount;
			$data = $data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
				//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
$this->load->view('Kiv_views/template/nav-header');

		if($this->input->post())
		{
			//echo "asasa".$sess_token = $this->session->userdata('sess_token');
			//$sess_amount = $this->session->userdata('sess_amount');
			//print_r($_POST);
			//exit();
			$data['postdata']=$_POST;
			$data 				= 	$data + $this->data;
				$hid_custid=html_escape($_POST['hid_custid']);
				$hid_bookingid=html_escape($_POST['hid_bookingid']);
				//$tokenno=html_escape($_POST['tokenno']);
				//$custname=html_escape($_POST['custname']);
				//$custphone=html_escape($_POST['custphone']);
				//$requestton=html_escape($_POST['requestton']);
				//$transamount=html_escape($_POST['transamount']);
				$custemail=html_escape($_POST['custemail']);
				$banktype=html_escape($_POST['banktype']);
			
			
		
			
			$get_bookingdata= $this->Master_model->onlinepay_details($hid_bookingid);
			
			$port_id=$get_bookingdata[0]['customer_booking_port_id'];
			$zone_id=$get_bookingdata[0]['customer_booking_zone_id'];
			$tokenno=$get_bookingdata[0]['customer_booking_token_number'];
			$transamount=$get_bookingdata[0]['customer_booking_chalan_amount'];
			
				$custname=$get_bookingdata[0]['customer_name'];
				$custphone=$get_bookingdata[0]['customer_phone_number'];
				$requestton=$get_bookingdata[0]['customer_booking_request_ton'];
				
			$custemail=html_escape($_POST['custemail']);
			$data['getbookingdata']=$get_bookingdata;
			$data 				= 	$data + $this->data;
		//	if($token_no==$tokenno && $trans_amount==$transamount)
		//	{
			$currentdate  =	date('Y-m-d H:i:s');
			
			$rres=$this->db->query("select * from bank_type where bank_status=1 and bank_type_id='$banktype'");

				$banktypedata=$rres->result_array();

			$last_generated_no=$banktypedata[0]['last_generated_no'];
			/*if($last_generated_no=='')
			{
				$last_generated_no=substr(number_format(time() * rand() * $hid_bookingid,0,'',''),0,4);
			}
			$tid=$tokenno.''.$last_generated_no;*/
			//-----------------------------------------------------------
			$tid=substr(number_format(time() * rand(00000,99999) * $tokenno,0,'',''),0,12);
			//-----------------------------------------------------------
			$gt_ch=$this->db->query("select * from bank_transactionnw where transaction_id='$tid'");
				$no=$gt_ch->num_rows();

				if($no==0)

				{
			
			
			$insert_data=array('transaction_id'=>$tid,
							   'token_no'=>$tokenno,
							   'customer_registration_id'=>$hid_custid,
							   'customer_name'=>$custname,
							   'mobile_no'=>$custphone,
							   'email_id'=>$custemail,
							   'requested_ton'=>$requestton, 
							   'transaction_amount'=>$transamount,
							   'bank_type'=>$banktype, 
							   'transaction_status'=>'1',
							   'transaction_timestamp'=>$currentdate, 
							   'port_id'=>$port_id,
							   'zone_id'=>$zone_id,
							    );
		//	print_r($insert_data);
			$insert_transaction_reg	=$this->db->insert('bank_transactionnw',$insert_data);
				
			//	}//Session check if close
			//else   //Session check elsee
			//{
				
				//	$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Online payment  failed!!!</div>');

				//	redirect('Master/customer_booking_history');
			//}
//echo	$this->db->last_query(); exit();
			if($insert_transaction_reg==1)
			{
				
				$trans_id=$this->db->insert_id();
				//echo	$this->db->last_query(); exit();
				$this->db->query("update bank_type set last_generated_no='$trans_id' where bank_type_id='$banktype'");
				$sess_usr_id = $this->session->userdata('int_userid');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				
				$data 				= 	$data + $this->data;
				
				$get_paydata= $this->Master_model->onlinetrans_details($trans_id);
				
				$data['transid']=$get_paydata[0]['transaction_id'];
				$data 				= 	$data + $this->data;
				$this->session->set_userdata('online_portid',$port_id);
				
				$merkey_data=$this->db->query("select * from online_payment_data where port_id='$port_id' and payment_status=1 and bank_type_id='$banktype'");

				$merkeydata=$merkey_data->result_array();

			$data['merkeydata']=	$merkeydata;
			$data 				= 	$data + $this->data;
				//$this->load->view('template/header',$data);
			$this->load->view('ccpay/hdfc_post',$data);
			
			}
			else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Online payment  failed!!!</div>');

					redirect('Manual_dredging/Master/customer_booking_history');

				}
				
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Online payment  failed!!!</div>');

					redirect('Manual_dredging/Master/customer_booking_history');

			}
				
			
		
			
		}
			$this->load->view('Manual_dredging/Master/onlinepayu_view',$data);
		$this->load->view('Kiv_views/template/dash-footer');	
			/*$this->load->view('template/footer');
			$this->load->view('template/js-footer');
			$this->load->view('template/script-footer');
			$this->load->view('template/html-footer');*/
	}
		else
		{
				redirect('Manual_dredgingsettings/index');        
		}
	}
//------------------------------------------------------------------------------------------
	public function customer_bookingsearch()

    {

		$sess_usr_id 			= $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& ($sess_user_type==3 ||$sess_user_type==9))

		{	$this->load->model('Manual_dredging/Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];  

		 

		//	$customerreg_detailsAppvd= $this->Master_model->get_customerreg_detailsapproved($port_id);

			//$data['customerreg_detailsAppvd']=$customerreg_detailsAppvd;

			$data = $data + $this->data; 
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;
                            $this->load->view('Kiv_views/template/dash-header');
                            $this->load->view('Kiv_views/template/nav-header');
                            $this->load->view('Manual_dredging/Master/customer_bookingsearch', $data);
                            $this->load->view('Kiv_views/template/dash-footer');
		   	}

	   	else

	   	{

			redirect('Main_login/index');        

  		}  
    }
	
	
	public function getbookingdetails_ajax_new()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

	$this->load->model('Manual_dredging/Master_model');	

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$port_id			=	$userinfo[0]['user_master_port_id'];  

	//$tokeno=$this->security->xss_clean(html_escape($this->input->post('tokenno')));
	$transactionno=$this->security->xss_clean(html_escape($this->input->post('tokenno')));
	$trans_data=$this->db->query("select * from bank_transactionnw where port_id='$port_id' and transaction_id='$transactionno' and customer_registration_id!=0");
	$transdata=$trans_data->result_array();
	$tokeno=$transdata[0]['token_no'];

	$get_customerapproval=$this->Master_model->customerbookingsearch($tokeno,$port_id);

	

	$data['get_customerapproval']=$get_customerapproval;

	$data = $data + $this->data;

	$this->load->view('Manual_dredging/Master/getbookingdetails_ajax_new', $data);

	}
//------------------------------------------------------------------------------------------
	public function generatepass_duplicate()

	{

			ini_set("memory_limit","128M");
$this->load->model('Manual_dredging/Master_model');	


		//$id 				= 	$this->uri->segment(3);//------comment on 6/11/2019---------port intergration------------
		$id			=		$this->uri->segment(4);
	$bookingid 			= 	decode_url($id); 	

	//$this->db->query("UPDATE transaction_details SET pass_dstatus = 1,print_status=1 WHERE transaction_customer_booking_id = $bookingid");

	$sess_usr_id 			= 	$this->session->userdata('int_userid');

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$desgofsign			=	$userinfo[0]['user_master_fullname'];  

	//exit;

	$data_vehiclepass	= 	$this->Master_model->vehiclepass_details($bookingid);

		//-------------------5/01/2018---------------------------------------------

		$lsgdid=$data_vehiclepass[0]['customer_booking_lsg_id'];

		$zoneid=$data_vehiclepass[0]['customer_booking_zone_id'];

		$customerregistration_id=$data_vehiclepass[0]['customer_booking_registration_id'];
		$bankrefno=$data_vehiclepass[0]['transaction_refno'];
		

		$lsgzonedetails=$this->db->query("select * from lsg_zone where lsg_zone.lsg_id ='$lsgdid' and lsg_zone.zone_id='$zoneid'");

		$lsgzone_details=$lsgzonedetails->result_array();

		$data['lsgzone_details']=$lsgzone_details;

		

		

		$loadingplace	=	$lsgzone_details[0]['lsg_zone_loading_place'];

		

		$lsgdetails=$this->db->query("select * from lsgd where lsgd_id ='$lsgdid' and lsgd_status=1");

		$lsg_details=$lsgdetails->result_array();

		//print_r($lsg_details); break;

		$data['lsg_details']=$lsg_details;

		

		

		$lsgdename		=	$lsg_details[0]['lsgd_name'];

		$lsgdaddress	=	$lsg_details[0]['lsgd_address'];

		$lsgdphoneno	=	$lsg_details[0]['lsgd_phone_number'];

		

		

		

		$customerregdetails=$this->db->query("select customer_name,customer_phone_number,customer_unused_ton,customer_perm_house_number,customer_perm_house_name,customer_perm_house_place,customer_unloading_place,customer_perm_house_place from customer_registration where customer_registration_id ='$customerregistration_id'");

		$customerregdetails=$customerregdetails->result_array();

		$data['customerregdetails']=$customerregdetails;

		//print_r($customerregdetails); exit();

		

	$customername		=	$customerregdetails[0]['customer_name'];

	$customerphone		=	$customerregdetails[0]['customer_phone_number'];

	$customerbalsand	=	$customerregdetails[0]['customer_unused_ton'];

	$houseno			=	$customerregdetails[0]['customer_perm_house_number'];

	$housename			=	$customerregdetails[0]['customer_perm_house_name'];

	$houseplace			=	$customerregdetails[0]['customer_perm_house_place'];

	$unloadplace		=	$customerregdetails[0]['customer_unloading_place'];

	

		

		

		//-------------------------------------------------------------------------

	

	

	

	$tokenno		=	$data_vehiclepass[0]['customer_booking_token_number'];

	$permitno		=	$data_vehiclepass[0]['customer_permit_number'];

	$vehicleno		=	$data_vehiclepass[0]['customer_booking_vehicle_registration_number'];

	$driverlicense	=	$data_vehiclepass[0]['customer_booking_driver_license'];

	$requestton		=	$data_vehiclepass[0]['customer_booking_request_ton'];

	$bookingroute	=	$data_vehiclepass[0]['customer_booking_route'];

	$distance		=   $data_vehiclepass[0]['customer_booking_distance'];

	$drivermobno	=	$data_vehiclepass[0]['customer_booking_driver_mobile'];

	$passissuedate	=	date("d-m-Y H:i:s",strtotime(str_replace('-', '/',$data_vehiclepass[0]['customer_booking_pass_issue_timestamp'])));

	

	

	$timetaken		= ($distance*3);

	//$roundtime=round($timetaken,2);

	//$roundtimenew=explode('.',$roundtime);

	$totamount		=	$data_vehiclepass[0]['transaction_amount'];

	$currentdate=date('d-m-Y H:i:s');

	//$msg="Dear customer your sand pass generated successfully. your balance sand quantity - ".$customerbalsand;

	//$this->sendSms($msg,$customerphone);

	//require_once('../libraries/tcpdf/tcpdf.php');

$this->load->library('Newpdf');
ob_clean();
// create new PDF document
$pdf = new Newpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set document information



// set default header data

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 050', PDF_HEADER_STRING);



// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// set default monospaced font

//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set margins

//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



// set auto page breaks

//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



// set image scale factor

//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// set some language-dependent strings (optional)

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {

    require_once(dirname(__FILE__).'/lang/eng.php');

    $pdf->setLanguageArray($l);

}



// ---------------------------------------------------------



// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.



// set font

//$pdf->SetFont('courier', '', 11);



// add a page

$pdf->AddPage();



// print a message

//$txt = "You can also export 2D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcode directory.\n";

//$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);





$pdf->SetFont('courierB', '', 10);



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	

	

	//$sample_data='Token Number :'.$tokenno.'Permit Number : '.$permitno.'Vehicle Number : '.$vehicleno.'Driver License No. : '.$driverlicense.'Quantity of Dredged Material(in Ton) : '.$requestton.'Loading Place : '.$loadingplace.'Unloading Place : '.$unloadplace.'Vehicle Pass Issued Date & Time : '.$passissuedate.',Date : '.$currentdate.'Duration of Pass : 01 Hours and 00 mins  Cost Of Sand : '. $currentdate;

		

		

	

	//******************************************************************

	$portid=$data_vehiclepass[0]['customer_booking_port_id'];

	$zoneid=$data_vehiclepass[0]['customer_booking_zone_id'];

	

	

	//----------------------------------------------------

		$alloteddate	=   $data_vehiclepass[0]['customer_booking_allotted_date'];

		$period_name=date("F Y", strtotime($alloteddate));

		$data_sandrate	= 	$this->Master_model->get_montly_permit_by_periodnew($period_name,$portid,$zoneid);

	 	$sandrate		=	$data_sandrate['sand_rate'];

		

		//$total_amt_includetax=$sandamt+$cleaningcharge+$royalty;

	 	$tot_exclude_tax=(($sandrate * 100)/105); //break;

		$tot_excludetax=floor($tot_exclude_tax);

		$totaltax=$sandrate - $tot_excludetax;

		$cgst=($totaltax / 2);

		$sgst=($totaltax / 2);

		//----------------------------------------------------

		$sample_data='Token Number :'.$tokenno.',Permit Number : '.$permitno.',Vehicle Number : '.$vehicleno.',Driver License No. : '.$driverlicense.',Quantity of Dredged Material(in Ton) : '.$requestton.',Loading Place : '.$loadingplace.',Unloading Place : '.$unloadplace.',Vehicle Pass Issued Date & Time : '.$passissuedate.',Date : '.$currentdate.',Duration of Pass :'.$this->convertToHoursMins($timetaken, '%02d hours %02d mins').', Cost Of Sand : '. $totamount;

	/*if($portid==10)

	{

 		$pamt= 1538;

	}

	else if($portid==22)

	{

 		$pamt= 1260;

	}

	else

	{ 

 		$pamt= 1995;

	}*/

	//$getpaymentdetails=$this->Master_model->get_paymentdetails($bookingid,$portid,$zoneid);

	$sandamt=0;$cleaningcharge=0;$royalty=0;$vehiclepass=0;

	/*foreach($getpaymentdetails as $rowdata)

	{

	//echo "aaaa--".$i=$rowdata['payment_head'];

	

	/*if($rowdata['payment_head']==1 ||$rowdata['payment_head']==2 ||$rowdata['payment_head']==3)

	{

	

	$sandamt=$sandamt+$rowdata['payment_amount'];

	}

	 if($rowdata['payment_head']==4)

	{

	$cleaningcharge=$rowdata['payment_amount'];

	//$cleaningcharge;

	}

	 if($rowdata['payment_head']==5)

	{

	$royalty=$rowdata['payment_amount'];

	//$royalty;

	}

	 if($rowdata['payment_head']==6)

	{

	$vehiclepass=$rowdata['payment_amount'];

	//$vehiclepass;

	}

	

	

//echo "kkkkk".$sandamt;





}

*/

	

	//$a=$this->load->library('numbertowords');

 

 //$total=$this->numbertowords->convert_number($totamount);

	if($data_vehiclepass[0]['customer_booking_requested_timestamp']>'2018-07-03 00:00:00')

	{

	$totgstvehicle=220*(19/100);//---1%  flood cess increased on 02/08/2019[18 +1]

	$cgstvehicle=($totgstvehicle/2);

	$sgstvehicle=($totgstvehicle/2);

	

 $totamountnew=ceil($totamount);

		$tabledata='<tr>

		<td width="60%" style="text-align:left;font-size:9px;">SGST @ 9 %(on Vehicle Pass)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.ceil($sgstvehicle).'</td>

		</tr>

		<tr>

		<td width="60%" style="text-align:left;font-size:9px;">CGST @ 9 %(on Vehicle Pass)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.ceil($cgstvehicle).'</td>

		</tr>';

	

	}

		else

		{

			$cgstvehicle=0;

			$sgstvehicle=0;

			$totamountnew=$totamount;

			$tabledata='';

		}

	

	$a=$this->load->library('numbertowords');



 	 $totalnew=$this->numbertowords->convert_number($totamountnew);

		

	//$sandamt=$getpaymentdetails[0]['payment_amount']+$getpaymentdetails[1]['payment_amount']+$getpaymentdetails[2]['payment_amount'];

	

	

	

	

	//******************************************************************

	

	//$sample_dataa='Token Number :'.$tokenno.'Permit Number : '.$permitno.'Vehicle Number : '.$vehicleno;

// set style for barcode



$style = array(

    'border' => true,

    'vpadding' => 'auto',

    'hpadding' => 'auto',

    'fgcolor' => array(0,0,0),

    'bgcolor' => false, //array(255,255,255)

    'module_width' => 1, // width of a single module in points

    'module_height' => 1 // height of a single module in points

);

$pdf->setXY(450,272);

$pdf->write2DBarcode($sample_data, 'QRCODE,H', 15, 20, 52, 52, $style, 'N');



$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p><hr/>



		<h4 style="text-align:center">VEHICLE PASS</h4>

		<table border="0" style="text-align:left;" width="100%">

		<thead style="font-weight:50">

		

		<tr>

		<th width="60%">1 Token Number & Transaction</th>

		<th width="40%">: '.$tokenno.'</th>

		</tr>

		<tr>

		<th>2 Customer name</th>

		<th>: '.$customername.'</th>

		</tr>

		<tr>

		<th>3 Customer Phone</th>

		<th>: '.$customerphone.'</th>

		</tr>

		<tr>

		<th>4 House No & Name</th>

		<th>: '.$houseno.'&'.$housename.'</th>

		</tr>

		<tr>

		<th>5 Bank Reference No</th>

		<th>: '.$bankrefno.'</th>

		</tr>

		<tr>

		<th>6 Place</th>

		<th>: '.$houseplace.'</th>

		</tr>

		<tr>

		<th>7  LSGD Name,Address and Phone No</th>

		<th>: '.$lsgdename.','.$lsgdaddress.',

		'.$lsgdphoneno.'</th>

		</tr>

		<tr>

		<th>8 Vehicle Number</th>

		<th>: '.$vehicleno.'</th>

		</tr>

		<tr>

		<th>9 Driver License No</th>

		<th>: '.$driverlicense.'</th>

		</tr>

		<tr>

		<th>10 Quantity of Dredged Material(in Ton)</th>

		<th>: '.$requestton	.'</th>

		</tr>

		<tr>

		<th>11 Loading Place</th>

		<th>: '.$loadingplace.'</th>

		</tr>

		<tr>

		<th>12 Unloading Place</th>

		<th>: '.$unloadplace.'</th>

		</tr>

		<tr>

		<th>13 Vehicle Pass Issued Date & Time</th>

		<th>: '.$passissuedate.'</th>

		</tr>

		<tr>

		<th>14 Route</th>

		<th>: '.$bookingroute.'</th>

		</tr>

		<tr>

		<th>15 Driver Mobile No</th>

		<th>: '.$drivermobno.'</th>

		</tr>

		

		</thead>

		</table>

		<p style="margin-top:10px">Date :'.$currentdate.'</p>

		<p>Duration of Pass : '.$this->convertToHoursMins($timetaken, '%02d hours %02d minutes').'</p>

		<hr/>

		<p style="text-align:center;">BILL</p>

		<table border="0" style="text-align:left;font-size:11px;" width="100%">

		<tbody>

		<tr>

		<td width="60%">Cost of Sand</td>

		<td width="40%">:'.ceil($tot_excludetax*$requestton).'</td>

		</tr>

		<tr>

		<td width="60%" style="text-align:left;font-size:9px;">SGST @ 2.5 % (on Cost of Sand)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.round($sgst*$requestton,2).'</td>

		</tr>

		<tr>

		<td width="60%" style="text-align:left;font-size:9px;">CGST @ 2.5 %(on Cost of Sand)</td>

		<td width="40%" style="text-align:left;font-size:9px;">:'.round($cgst*$requestton,2).'</td>

		</tr>

		<tr>

		<td width="60%">Vehicle Pass</td>

		

		<td width="40%">:220</td>

		</tr>'.

		$tabledata.'

		</tbody>

		</table>

		<hr/>

		<table class="tab2" border="0" style="text-align:left;width:100%;font-size:12px;">

		<tbody>

		<tr>

		<td width="60%"><b>Total Amount</b></td>

		<td width="40%"><b>: Rs '.$totamountnew.'</b>('.$totalnew.')</td>

		</tr>

		<tr>

		<td width="60%"> </td>

		<td width="40%"> </td>

		</tr>

		</tbody>

		</table>

		<table style="margin-top:70px" width="100%">

		<tbody>

		<tr>

		<td width="60%" style="text-align:left;font-size:10px;font-weight:bold;">Place: </td>

		<td width="40%" style="text-align:left;font-size:10px;font-weight:bold;">Signature of Kadavu Supervisor</td>

		</tr>

		<tr><td width="100%" style="text-align:left;font-size:10px;font-weight:bold;">Customer Name & Signature</td></tr>

		</tbody>

		</table>

		

		<p style="text-align:left;font-size:9px;">Computer generated vehicle pass, www.portinfo.kerala.gov.in </p><br/>';

		

		//==============================================================

		//==============================================================

		//==============================================================

		//print_r($html);

$pdf->writeHTML($html, true, false, true, false, '');

//$pdf->write2DBarcode('hello', 'PDF417',0,154, 35,0, 20, $style, 'N');

$pdf->write2DBarcode($sample_data, 'PDF417', 154, 255,0, 20, $style, 'N');

//$pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');

//Close and output PDF document

$pdf->Image(getcwd().'/assets/temp/vehicle_passnew.png', 64, 35, 100, 35, 'PNG', false , '', false, 100, '', false, false, 0, false, false, false);

$pdf->Image(getcwd().'/assets/images/pass_seal.png', 162, 33, 35, 30, 'PNG', false , '', false, 100, '', false, false, 0, false, false, false);

//$pdf->Image(base_url().'assets/temp/2017-07-131.png');

$pdf->Output('vehicle_pass.pdf', 'D');

//$this->output->enable_profiler(TRUE);

exit;

	

	}
//-------------------------------------------------------------------------------------------	

}

?>