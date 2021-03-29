<?php

defined('BASEPATH') OR exit('No direct script access allowed');    

class Port extends CI_Controller 

{

	 

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

	        $this->load->model('Master_model');

    }

	public function corn_update()

	{

		$this->db->query("insert into paydet values(NULL,'222','1111','11111','1111','2017-10-13','6666')");

	}

	public function emailSendFun($from,$to,$sub,$msg)

	{

  		$config = Array(

			'protocol' => 'smtp',

			'smtp_host' => 'ssl://smtp.googlemail.com',

			'smtp_port' => 465,

			'smtp_user' => 'manualdredging@gmail.com',

			'smtp_pass' => 'Portkerala@123',

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

	public function delmat()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('mat_id')));

			//echo $matid;

			$result=$this->db->query("update material_master set material_master_status=0 where material_master_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delmatrate()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo $matid;

			$result=$this->db->query("update materialrate set materialrate_port_status=0 where materialrate_port_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function deltax()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo $matid;

			$result=$this->db->query("update taxname_master set taxname_master_status=0 where taxname_master_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function deltaxcalc()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo $matid;

			$result=$this->db->query("update tax_calculator set tax_calculator_status=0 where tax_calculator_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delconstr()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo $matid;

			$result=$this->db->query("update construction_master set construction_master_status=0 where construction_master_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delple()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update plintharea_master set plintharea_status=0 where plintharea_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delqty()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update quantity_master set quantity_master_status=0 where quantity_master_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function wqqty()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update worker_quantity set worker_quantity_status=0 where worker_quantity_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delport()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update tbl_portoffice_master set int_dredge_status=0 where int_portoffice_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delpc()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update user_master set user_master_status=0,user_enddate='$d' where user_master_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delzone()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update zone set zone_status=0 where zone_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function del_aszone()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update lsg_zone set lsg_zone_status=0 where lsg_zone_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function del_assec()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update lsg_section set lsg_section_status=0 where lsg_section_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delpcuser()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update user_master set user_master_status=0,user_enddate='$d' where user_master_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delbank()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{
			

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";
				echo "update bank set bank_status=0 where bank_id='$matid'";
			$result=$this->db->query("update bank set bank_status=0 where bank_id='$matid'");
exit;
			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function delqtypc()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update quantity set quantity_status=0 where quantity_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function dellsgd()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update lsgd set lsgd_status=0 where lsgd_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function mailbox()

	{

			$sess_usr_id 			=   $this->session->userdata('int_userid');

			$sess_user_type			=	$this->session->userdata('int_usertype');

			if(!empty($sess_usr_id))

			{	

				$this->load->model('Master_model');	

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$recieved			= 	$this->Master_model->getrecditem($sess_usr_id);

				$data['recieved']	=	$recieved;

				$data 				= 	$data + $this->data;

				$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

				$data['tn']			=	$tn[0]['totnew'];

				$data 				= 	$data + $this->data;

				$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

				$this->load->view('Master/mailbox', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

			}

			else

			{

				redirect('Master/index');        

			}  	

	}

	public function readmail()

	{

			$sess_usr_id 			=  $this->session->userdata('int_userid');

			$sess_user_type			=	$this->session->userdata('int_usertype');

			$msg_id		=	decode_url($this->uri->segment(3));	

			if(!empty($sess_usr_id))

			{	$this->load->model('Master_model');	

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$msg			= 	$this->Master_model->readmsg($msg_id);

				$data['msg']	=	$msg;

				$data 				= 	$data + $this->data;

				$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

				$data['tn']			=	$tn[0]['totnew'];

				$data 				= 	$data + $this->data;

				$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

				$this->load->view('Master/readmail', $data);

				$this->db->query("update tbl_mailbox set tbl_mailflag=1 where tbl_inboxid=$msg_id and tbl_to=$sess_usr_id");

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

			}

			else

			{

				redirect('Master/index');        

			}  	

	}

	public function compose()

	{

			$sess_usr_id 			=  $this->session->userdata('int_userid');

			$sess_user_type			=	$this->session->userdata('int_usertype');

			if(!empty($sess_usr_id))

			{	$this->load->model('Master_model');	

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				/*$data 				= 	$data + $this->data;   */

				$users			= 	$this->Master_model->get_all_user($sess_usr_id);

				$data['users']	=	$users;

				$data 				= 	$data + $this->data;

				$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

				$data['tn']			=	$tn[0]['totnew'];

				$data 				= 	$data + $this->data;

				if($this->input->post())

				{

					$from=$sess_usr_id;

					$user=$this->input->post('mailto');

					$u_s=explode(',',$user);

					$sub=$this->input->post('subject');

					$msg=$this->input->post('message');

					foreach($u_s as $u_name)

					{

							$u_det=$this->Master_model->getuserdetails(trim($u_name));

							if(!empty($u_det))

							{

								$to=$u_det[0]['user_master_id'];

								//$utype=$u_det[0]['user_type_id'];

								$dt=date('Y-m-d H:i:s');

								$mail_data=array(

								'tbl_from'=>$from,

								'tbl_to'=>$to,

								'tbl_subject'=>$sub,

								'tbl_message'=>$msg,

								'tbl_date'=>$dt,

								'tbl_usertypeid'=>$sess_user_type

								);

								$result=$this->Master_model->save_mail($mail_data);

							}

							if($result==1)

							{

									$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Mail sent successfully</div>');

									redirect('Port/mailbox');

							}

							else

							{

									$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Mail sent failed</div>');

									redirect('Port/mailbox');

							}

					}

				}

				$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

				$this->load->view('Master/compose', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

			}

			else

			{

				redirect('Master/index');        

			}  

	}

	public function senditem()

	{

			$sess_usr_id 			=  $this->session->userdata('int_userid');

			$sess_user_type			=	$this->session->userdata('int_usertype');

			if(!empty($sess_usr_id))

			{	$this->load->model('Master_model');	

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$sent				= 	$this->Master_model->getsentitem($sess_usr_id);

				$data['sent']		=	$sent;

				$data 				= 	$data + $this->data;

				$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

				$data['tn']			=	$tn[0]['totnew'];

				$data 				= 	$data + $this->data;

				$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

				$this->load->view('Master/sentitem', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

			}

			else

			{

				redirect('Master/index');        

			}  	

	}

	public function getzone()

	{

			    $port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$zone				= 	$this->Master_model->get_zone_acinP($port_id);

				$data['zone']		=	$zone;

				$data 				= 	$data + $this->data;

				$this->load->view('Master/showzone', $data);

	}

	public function chart_pc()

	{

			$sess_usr_id 			=   $this->session->userdata('int_userid');

			$sess_user_type			=	$this->session->userdata('int_usertype');

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];

			if(!empty($sess_usr_id))

			{	

				$this->load->model('Master_model');	

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$port				= 	$this->Master_model->get_zone_acinP($port_id);

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

				$tpa=$this->Master_model->permit_reqApfor_pc($pnd,$port_id);

				$d[$k]=$tpa[0]["totsreq"];

				$tsp  = 	$this->Master_model->tot_sand_passfor_pc($pnd,$port_id);

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

			$totperreq			= 	$this->Master_model->permit_req_pc($port_id);

			//print_r($totperreq);

			$data['totperreq']	=	$totperreq[0]['totreq'];

			//exit();

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

			//

			//Do END 

			//

			//

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

			$data 				= 	$data + $this->data;

				$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

				$this->load->view('Master/chart_pc', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

			}

			else

			{

				redirect('Master/index');        

			}  	

	}

	public function Piechart()

	{

			$port_id			=	$this->security->xss_clean(html_escape($this->input->post('port_id')));

			$p_name				=	$this->security->xss_clean(html_escape($this->input->post('period')));

			//$z_id				=	$this->input->post('zone_id');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$id=1;

			$total1			= 	$this->Master_model->sum_amt_new_pc($id,$port_id,$p_name);

			$data['total1']	=	$total1[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=2;

			$total2			= 	$this->Master_model->sum_amt_new_pc($id,$port_id,$p_name);

			$data['total2']	=	$total2[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=3;

			$total3			= 	$this->Master_model->sum_amt_new_pc($id,$port_id,$p_name);

			$data['total3']	=	$total3[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=4;

			$total4			= 	$this->Master_model->sum_amt_new_pc($id,$port_id,$p_name);

			$data['total4']	=	$total4[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=5;

			$total5			= 	$this->Master_model->sum_amt_new_pc($id,$port_id,$p_name);

			$data['total5']	=	$total5[0]['totsum'];

			$data 				= 	$data + $this->data;

			$id=6;

			$total6			= 	$this->Master_model->sum_amt_new_pc($id,$port_id,$p_name);

			$data['total6']	=	$total6[0]['totsum'];

			$data 				= 	$data + $this->data;

			$this->load->view('Master/piechart',$data);

	}

	public function dowchart()

	{

			$port_id			=	$this->security->xss_clean(html_escape($this->input->post('port_id')));

			$p_name				=	$this->security->xss_clean(html_escape($this->input->post('period')));

			//$z_id				=	$this->input->post('zone_id');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$totperreq			= 	$this->Master_model->permit_reqcustom_pc($port_id,$p_name);

			//print_r($totperreq);

			$data['totperreq']	=	$totperreq[0]['totreq'];

			//exit();

			$data 				= 	$data + $this->data;

			$totperreqAp			= 	$this->Master_model->permit_reqApcustom_pc($port_id,$p_name);

			$data['totperreqAp']	=	$totperreqAp[0]['totreqa'];

			$data 				= 	$data + $this->data;

			$totsreq			= 	$this->Master_model->san_reqcustom_pc($port_id,$p_name);

			$data['totsreq']	=	$totsreq[0]['totsreq'];

			$data 				= 	$data + $this->data;

			$totsreqa			= 	$this->Master_model->san_reqacustom_pc($port_id,$p_name);

			$data['totsreqa']	=	$totsreqa[0]['totsreqa'];

			$data 				= 	$data + $this->data;

			$totsreqr			= 	$this->Master_model->san_reqrcustom_pc($port_id,$p_name);

			$data['totsreqr']	=	$totsreqr[0]['totsreqr'];

			$data 				= 	$data + $this->data;

			$totspass			= 	$this->Master_model->tot_sand_passcustom_pc($port_id,$p_name);

			$data['totspass']	=	$totspass[0]['totspass'];

			$data 				= 	$data + $this->data;

			$balsand			= 	$this->Master_model->bal_sandcustom_pc($port_id,$p_name);

			$data['balsand']	=	$balsand[0]['balsand'];

			$data 				= 	$data + $this->data;

			$this->load->view('Master/dowchart',$data);

	}

	public function barchart()

	{

			$port_id			=	$this->security->xss_clean(html_escape($this->input->post('port_id')));

			$p_name				=	$this->security->xss_clean(html_escape($this->input->post('period')));

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

				$tpa=$this->Master_model->permit_reqApforcustom_pc($port_id,$pnd);

				$d[$k]=$tpa[0]["totsreq"];

				$tsp  = 	$this->Master_model->tot_sand_passforcustom_pc($port_id,$pnd);

				$c[$k]=$tsp[0]["totspass"];

				$k++;

			}

			$data['totpermitbar']	=	$d;

			//exit();

			$data 				= 	$data + $this->data;

			$data['totsandpassbar']	=	$c;

			//exit();

			$data 				= 	$data + $this->data;

			

			$this->load->view('Master/barchart',$data);

	}

	public function port_con_main()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	$userinfo[0]['user_master_port_id'];

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

			$data['tn']			=	$tn[0]['totnew'];  

			$tn1=$this->Master_model->totcus_reg($port_id);  

			$data['tn1']			=	$tn1[0]['totcreq']; 

			$tn2=$this->Master_model->tot_buk_pen($port_id);

			$data['tn2']			=	$tn2[0]['totbpen']; 

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

			$fin_year		= 	$this->Master_model->get_fin_year();

			$data['fin_year']		=	$fin_year;

			$data 				= 	$data + $this->data; 

			//lmr

			$totpermit_aprvd=$this->Master_model->tot_permit_aprvd($port_id);

			$data['tot_per_aprvd']		=	$totpermit_aprvd[0]['permit_aprvd'];

			$data 				= 	$data + $this->data; 

			

			$totpermit_pend=$this->Master_model->tot_permit_pend($port_id);

			$data['tot_per_pend']		=	$totpermit_pend[0]['permit_pend'];

			$data 				= 	$data + $this->data; 

			

			$curr_date=date("Y-m-d");

			$holy_prd=date('F Y',strtotime($curr_date));

			$data['holy_prd']		=	$holy_prd;

			$tot_workdays=$this->Master_model->tot_working_days($holy_prd);

			//print_r($tot_workdays);break;

			$data['tot_workdays']		=	$tot_workdays[0]['working_days'];

			$tot_holydays=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));

			$tot_holydays=$tot_holydays-$tot_workdays[0]['working_days'];

			$data['tot_holydays']		=$tot_holydays;

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

			//exit();

			$data 				= 	$data + $this->data;

			$data['totsandpassbar']	=	$c;

			//exit();

			$data 				= 	$data + $this->data;

			//

			//Doaunut

			//   

			$totperreq			= 	$this->Master_model->permit_req_pc($port_id);

			//print_r($totperreq);

			$data['totperreq']	=	$totperreq[0]['totreq'];

			//exit();

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

			//

			//Do END 

			//

			//

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

			$data 				= 	$data + $this->data;
			
			$data['portid']	=	$port_id;

			$data 				= 	$data + $this->data;

			$this->load->view('Master/portconservator',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function port_dir_main()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

			$data['tn']			=	$tn[0]['totnew'];  

			$tn1=$this->Master_model->totcus_reg($port_id);  

			$data['tn1']			=	$tn1[0]['totcreq']; 

			$tn2=$this->Master_model->tot_buk_pen($port_id);

			$data['tn2']			=	$tn2[0]['totbpen']; 

			$tn3=$this->Master_model->police_ge($port_id);

			$data['tn3']			=	$tn3[0]['totcase'];

			$totobuk=$this->Master_model->pd_tot_buk();

			$data['tn4']			=	$totobuk[0]['tot_buk'];//san_reqacustom_pc

			$totobuka=$this->Master_model->pd_tot_buk_ap();

			$data['tn5']			=	$totobuka[0]['tot_buk'];

			$totobuks=$this->Master_model->pd_tot_buk_si();

			$data['tn6']			=	$totobuks[0]['tot_buk'];

			$totobuta=$this->Master_model->pd_sam();

			$data['tn7']			=	$totobuta[0]['totsreqa'];

			$totobutn=$this->Master_model->pd_si();

			$data['tn8']			=	$totobutn[0]['totsreqa'];

			$port				= 	$this->Master_model->get_port();

			$data['port_det']	=	$port;

			$data 				= 	$data + $this->data; 

			$permit_name		= 	$this->Master_model->get_monthly_period();

			$data['permit']		=	$permit_name;

			$data 				= 	$data + $this->data; 

			$fin_year		= 	$this->Master_model->get_fin_year();

			$data['fin_year']		=	$fin_year;

			$data 				= 	$data + $this->data; 

			//lmr

			$totpermit_aprvd=$this->Master_model->tot_permit_aprvd($port_id);

			$data['tot_per_aprvd']		=	$totpermit_aprvd[0]['permit_aprvd'];

			$data 				= 	$data + $this->data; 

			

			$totpermit_pend=$this->Master_model->tot_permit_pend($port_id);

			$data['tot_per_pend']		=	$totpermit_pend[0]['permit_pend'];

			$data 				= 	$data + $this->data; 

			

			$curr_date=date("Y-m-d");

			$holy_prd=date('F Y',strtotime($curr_date));

			$data['holy_prd']		=	$holy_prd;

			$tot_workdays=$this->Master_model->tot_working_days($holy_prd);

			//print_r($tot_workdays);break;

			$data['tot_workdays']		=	$tot_workdays[0]['working_days'];

			$tot_holydays=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));

			$tot_holydays=$tot_holydays-$tot_workdays[0]['working_days'];

			$data['tot_holydays']		=$tot_holydays;

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

			$this->load->view('Master/portdirector',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function port_zone_main()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& $sess_user_type==6)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;
			
			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

			$data['tn']			=	$tn[0]['totnew'];  
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];  
			$zone_id			=	$userinfo[0]['user_master_zone_id'];
			$data['portid']				=	$port_id;
			$data['zoneid']				=	$zone_id;
			$data 				= 	$data + $this->data;
			//

			$this->load->view('Master/zoneop',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function port_lsgd_main()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& $sess_user_type==4)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

			$data['tn']			=	$tn[0]['totnew'];  

			//exit();

			$data 				= 	$data + $this->data;

			//

			$this->load->view('Master/lsgdop',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function cus_reg_det_pd()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& ($sess_user_type==2 || $sess_user_type==8))

		{

			$data['port_officer']=	0;

			if($sess_user_type==8){

				$data['port_officer']=	1;

				$po_port			= 	$this->Master_model->get_portofficer_port($sess_usr_id);

				$po_port_id			=	$po_port[0]['port_id'];

				$po_port_arr		= 	explode(',',$po_port_id);

				//print_r($po_port_arr);break;

				$data['po_port_arr']=	$po_port_arr;	

				

			}

			

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$port=$this->Master_model->get_port();

			$data['port']=	$port;

			$data 				= 	$data + $this->data;

			foreach($port as $p)

			{

				$i=0;

				$pid=$p['int_portoffice_id'];

				$tt_bk=$this->Master_model->pd_tot_buk_bp($pid);

				//echo $tt_bk

				$a[$pid][$i]=$tt_bk[0]['tot_buk'];

				$i++;

				$tt_bk_wp=$this->Master_model->pd_tot_buk_ap_bp($pid);

				$a[$pid][$i]=$tt_bk_wp[0]['tot_buk'];

				$i++;

				$tt_buk_ap=$this->Master_model->pd_tot_buk_si_bp($pid);

				$a[$pid][$i]=$tt_buk_ap[0]['tot_buk'];

				$i++;

			}

			$data['bukk_data']=$a;

			//

			$this->load->view('Master/cus_buk_pd',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function cu_reg_pd()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& ($sess_user_type==2 || $sess_user_type==8))

		{

			$data['port_officer']=	0;

			if($sess_user_type==8){

				$data['port_officer']=	1;

				$po_port			= 	$this->Master_model->get_portofficer_port($sess_usr_id);

				$po_port_id			=	$po_port[0]['port_id'];

				$po_port_arr		= 	explode(',',$po_port_id);

				//print_r($po_port_arr);break;

				$data['po_port_arr']=	$po_port_arr;	

				

			}

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$port=$this->Master_model->get_port();

			$data['port']=	$port;

			$data 				= 	$data + $this->data;

			

			foreach($port as $p)

			{

				$i=0;

				$pid=$p['int_portoffice_id'];

				$tt_bk=$this->Master_model->get_total_cus_regVp($pid);

				//echo $tt_bk

				$a[$pid][$i]=$tt_bk[0]['tot_buk'];

				$i++;

				$tt_bk_wp=$this->Master_model->get_total_cus_reg_wp_Vp($pid);

				$a[$pid][$i]=$tt_bk_wp[0]['tot_buk'];

				$i++;

				$tt_buk_ap=$this->Master_model->get_total_cus_reg_gp_Vp($pid);

				$a[$pid][$i]=$tt_buk_ap[0]['tot_buk'];

				$i++;

			}

			$data['bukk_data']=$a;

			//$mn_pr=$this->Master_model->get_monthly_period();

			//$data['mn_pr']=	$mn_pr;

			//

			$this->load->view('Master/cut_reg_pd',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function mon_pt_ap_pd()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& ($sess_user_type==2 || $sess_user_type==8))

		{

			$data['port_officer']=	0;

			if($sess_user_type==8){

				$data['port_officer']=	1;

				$po_port			= 	$this->Master_model->get_portofficer_port($sess_usr_id);

				$po_port_id			=	$po_port[0]['port_id'];

				$po_port_arr		= 	explode(',',$po_port_id);

				//print_r($po_port_arr);break;

				$data['po_port_arr']=	$po_port_arr;	

				

			}

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$port=$this->Master_model->get_port();

			$data['port']=	$port;

			$data 				= 	$data + $this->data;

			foreach($port as $p)

			{

				$i=0;

				$pid=$p['int_portoffice_id'];

				$tt_bk=$this->Master_model->permit_req_pd_new($pid);

				//echo $tt_bk

				$a[$pid][$i]=$tt_bk[0]['tot_buk'];

				$i++;

				$tt_bk_wp=$this->Master_model->permit_reqAp_pd_new($pid);

				$a[$pid][$i]=$tt_bk_wp[0]['tot_buk'];

				$i++;

				$tt_buk_ap=$this->Master_model->permit_reqRp_pd_new($pid);

				$a[$pid][$i]=$tt_buk_ap[0]['tot_buk'];

				$i++;

			}

			$data['bukk_data']=$a;

			$mn_pr=$this->Master_model->get_monthly_period();

			$data['mn_pr']=	$mn_pr;

			$data 				= 	$data + $this->data;

			$this->load->view('Master/mon_pt_pd',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else if(!empty($sess_usr_id)&& $sess_user_type==8)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$port=$this->Master_model->get_port();

			$data['port']=	$port;

			$data 				= 	$data + $this->data;

			

			foreach($port as $p)

			{

				$i=0;

				$pid=$p['int_portoffice_id'];

				$tt_bk=$this->Master_model->get_total_cus_regVp($pid);

				//echo $tt_bk

				$a[$pid][$i]=$tt_bk[0]['tot_buk'];

				$i++;

				$tt_bk_wp=$this->Master_model->get_total_cus_reg_wp_Vp($pid);

				$a[$pid][$i]=$tt_bk_wp[0]['tot_buk'];

				$i++;

				$tt_buk_ap=$this->Master_model->get_total_cus_reg_gp_Vp($pid);

				$a[$pid][$i]=$tt_buk_ap[0]['tot_buk'];

				$i++;

			}

			$data['bukk_data']=$a;

			//$mn_pr=$this->Master_model->get_monthly_period();

			//$data['mn_pr']=	$mn_pr;

			//

			$this->load->view('Master/cut_reg_pd',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	/*public function mon_pt_ap_pd()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$port=$this->Master_model->get_port();

			$data['port']=	$port;

			$data 				= 	$data + $this->data;

			foreach($port as $p)

			{

				$i=0;

				$pid=$p['int_portoffice_id'];

				$tt_bk=$this->Master_model->permit_req_pd_new($pid);

				//echo $tt_bk

				$a[$pid][$i]=$tt_bk[0]['tot_buk'];

				$i++;

				$tt_bk_wp=$this->Master_model->permit_reqAp_pd_new($pid);

				$a[$pid][$i]=$tt_bk_wp[0]['tot_buk'];

				$i++;

				$tt_buk_ap=$this->Master_model->permit_reqRp_pd_new($pid);

				$a[$pid][$i]=$tt_buk_ap[0]['tot_buk'];

				$i++;

			}

			$data['bukk_data']=$a;

			$mn_pr=$this->Master_model->get_monthly_period();

			$data['mn_pr']=	$mn_pr;

			$data 				= 	$data + $this->data;

			$this->load->view('Master/mon_pt_pd',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}*/

	public function get_pd_buk()

	{

			    $port_id		    =	decode_url($this->uri->segment(3));

				//$zone_id			=	$this->input->post('zone_id');

				//$f_date				=	date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('f_date')))));

				//$t_date				=	date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('t_date')))));

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$buk_det				= 	$this->Master_model->get_pd_buk_det_fr($port_id);

				$data['buk_det']		=	$buk_det;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header');

				$this->load->view('Master/show_pd_buk', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

	}

	public function get_mon_pd()

	{

			    $port_id		    =	decode_url($this->uri->segment(3));

				//$zone_id			=	$this->input->post('zone_id');

				//$m_p				=	$this->input->post('m_p');

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$mp_det				= 	$this->Master_model->get_pd_mon_det_fr($port_id);

				$data['mp_det']		=	$mp_det;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header');

				$this->load->view('Master/show_pd_mon', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

	}

	public function get_cus_pd()

	{

			    $port_id		    =	decode_url($this->uri->segment(3));

				//$zone_id			=	$this->input->post('zone_id');

				//$m_p				=	$this->input->post('m_p');

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$mp_det				= 	$this->Master_model->get_pd_cus_det($port_id);

				$data['cu_det']		=	$mp_det;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header');

				$this->load->view('Master/show_pd_cus', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

	}

	public function customerregistration_view()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		

		if(!empty($sess_usr_id))

		{	

			$id			=		$this->uri->segment(3);

			$id			=		decode_url($id);

			

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;    

			

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			//$user_id			=	$userinfo[0]['user_master_port_id']; 

			$customerreg_details= $this->Master_model->getcustomerregdetails($id,10);

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

			$this->load->view('template/header',$data);

			

			$this->load->view('Master/customerregistration_view_pd', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  



    }

	public function user_logs_pd()

	{

			    //$port_id		    =	decode_url($this->uri->segment(3));

				//$zone_id			=	$this->input->post('zone_id');

				//$m_p				=	$this->input->post('m_p');

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$mp_det				= 	$this->Master_model->get_user_logs_pd();

				$data['log_det']		=	$mp_det;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header');

				$this->load->view('Master/userlogs', $data);

				$this->load->view('template/footer');

				$this->load->view('template/js-footer');

				$this->load->view('template/script-footer');

				$this->load->view('template/html-footer');

	}

	public function getzones()

	{

			    $port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$zone				= 	$this->Master_model->get_zone_acinP($port_id);

				$data['zone']		=	$zone;

				$data 				= 	$data + $this->data;

				$this->load->view('Master/showzones', $data);

	}

	public function getqty()

	{

			    $port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));

				$zone_id		    =	$this->security->xss_clean(html_escape($this->input->post('zone_id')));

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data; 

				$data['zone_id']	=	$zone_id;

				$data 				= 	$data + $this->data;

				$get_quantity_details= $this->Master_model->get_quantity_detailswk($port_id);

			    $data['get_quantity_details']=$get_quantity_details; 

				$data 				= 	$data + $this->data;

				$qty=$this->Master_model->get_quantity_masterPD();

				 $data['qty']=$qty;

				$data 				= 	$data + $this->data;

				$this->load->view('Master/showqty', $data);

	}

	public function portofficer_master()

{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$portc				= 	$this->Master_model->get_port_officer();

			$data['portc']		=	$portc;

			$data 				= 	$data + $this->data;		

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/portofficer', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  	

}

	public function po_user_add()

{

	//echo bin2hex(openssl_random_pseudo_bytes(4));

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$port				= 	$this->Master_model->get_po_port();

			//print_r($portc);

			$data['port']		=	$port;

			$data 				= 	$data + $this->data;	

			$portc			= 	$this->Master_model->get_po_ex();

			$data['portc']		=	$portc[0]['port'];

			$data 				= 	$data + $this->data;	

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/addportofficer', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

			if($this->input->post())

			{

				$p_id=$this->security->xss_clean(html_escape($this->input->post('int_port')));

				$portt_id=implode(',',$p_id);

				$un=$this->security->xss_clean(html_escape($this->input->post('vch_un')));

				$psw=bin2hex(openssl_random_pseudo_bytes(4));

				$ph=$this->security->xss_clean(html_escape($this->input->post('vch_ph')));

				$uemail=$this->input->post('vch_email');

				$phno=$this->security->xss_clean(html_escape($this->input->post('vch_ph')));

				$sub="User Login Information | Port";

				$msg="Username :- $un  and Password:- $psw";

				$data_array=array(

				'user_master_name'=>$this->security->xss_clean(html_escape($this->input->post('vch_un'))),

				'user_master_password'=>$this->phpass->hash($psw),

				'user_master_id_user_type'=>8,

				'user_master_status'=>1,

				'user_master_fullname'=>'Port Officer',

				'user_master_ph'=>$phno,

				'user_master_email'=>$this->input->post('vch_email'),

				'user_master_user_id'=>$sess_usr_id

				);

				$result	= $this->Master_model->add_user_login($data_array);

				if(isset($result))

				{

					$this->emailSendFun('manualdredging@gmail.com',$uemail,$sub,$msg);

					$po_id=$result;

					$d_array=array('po_user_id'=>$po_id,

									'port_id'=>$portt_id

					);

					$this->Master_model->add_po_det($d_array);

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Port Conservator added successfully</div>');

													redirect('Master/portconserv_master');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Port Conservator add failed!!!</div>');

													redirect('Master/portconserv_master');

				}

				

			}

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  	

}

public function all_customer_booking_pc()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&&$sess_user_type==3)

		{	$this->load->model('Master_model');	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$customerreg_booking= '';//$this->Master_model->get_all_buk_his($port_id);

			$data['cust_book_his']=$customerreg_booking;

			$zone				= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']		=	$zone;

			$data = $data + $this->data;    

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

		 	

			$this->load->view('Master/all_customer_booking', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		} 

		 

		//$this->load->view('Master/undermain');



    }

	public function sand_booking_history_ajax()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));

			$mont=$this->security->xss_clean(html_escape($this->input->post('mont')));

			$yer=$this->security->xss_clean(html_escape($this->input->post('yer')));

			$stdate=$yer."-".$mont."-01";

			$endday=date('t',strtotime($stdate));

			$enddate=$yer."-".$mont."-".$endday;

			$this->load->model('Master_model');	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			//if($zone_id=='' || $zone_id==0){

				//$customerreg_booking= $this->Master_model->get_all_buk_his($port_id);

			//}else{

				$customerreg_booking= $this->Master_model->get_all_buk_his_by_sandbuk($port_id,$zone_id,$stdate,$enddate);

			//}

			$data['cust_book_his']=$customerreg_booking;

			$zone				= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']		=	$zone;

			$data = $data + $this->data;    

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('Master/all_customer_booking_Ajax', $data);

			//$this->load->view('template/footer');

			//$this->load->view('template/js-footer');

			//$this->load->view('template/script-footer');

			//$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function port_officer_main()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	'';

		if(!empty($sess_usr_id)&& $sess_user_type==8)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

			$data['tn']			=	$tn[0]['totnew'];  

			$tn1=$this->Master_model->totcus_reg($port_id);  

			$data['tn1']			=	$tn1[0]['totcreq']; 

			$tn2=$this->Master_model->tot_buk_pen($port_id);

			$data['tn2']			=	$tn2[0]['totbpen']; 

			$tn3=$this->Master_model->police_ge($port_id);

			$data['tn3']			=	$tn3[0]['totcase'];

			$totobuk=$this->Master_model->pd_tot_buk();

			$data['tn4']			=	$totobuk[0]['tot_buk'];//san_reqacustom_pc

			$totobuka=$this->Master_model->pd_tot_buk_ap();

			$data['tn5']			=	$totobuka[0]['tot_buk'];

			$totobuks=$this->Master_model->pd_tot_buk_si();

			$data['tn6']			=	$totobuks[0]['tot_buk'];

			$totobuta=$this->Master_model->pd_sam();

			$data['tn7']			=	$totobuta[0]['totsreqa'];

			$totobutn=$this->Master_model->pd_si();

			$data['tn8']			=	$totobutn[0]['totsreqa'];

			$port				= 	$this->Master_model->get_port();

			$data['port_det']	=	$port;

			$po_port				= 	$this->Master_model->get_portofficer_port($sess_usr_id);

			

			$po_port_id			=	$po_port[0]['port_id'];

			$po_port_arr		= 	explode(',',$po_port_id);

			//print_r($po_port_arr);break;

			$data['po_port_arr']=	$po_port_arr;

			$data 				= 	$data + $this->data; 

			$permit_name		= 	$this->Master_model->get_monthly_period();

			$data['permit']		=	$permit_name;

			$data 				= 	$data + $this->data; 

			$fin_year		= 	$this->Master_model->get_fin_year();

			$data['fin_year']		=	$fin_year;

			$data 				= 	$data + $this->data; 

			//lmr

			$totpermit_aprvd=$this->Master_model->tot_permit_aprvd($port_id);

			$data['tot_per_aprvd']		=	$totpermit_aprvd[0]['permit_aprvd'];

			$data 				= 	$data + $this->data; 

			

			$totpermit_pend=$this->Master_model->tot_permit_pend($port_id);

			$data['tot_per_pend']		=	$totpermit_pend[0]['permit_pend'];

			$data 				= 	$data + $this->data; 

			

			$curr_date=date("Y-m-d");

			$holy_prd=date('F Y',strtotime($curr_date));

			$data['holy_prd']		=	$holy_prd;

			$tot_workdays=$this->Master_model->tot_working_days($holy_prd);

			//print_r($tot_workdays);break;

			$data['tot_workdays']		=	$tot_workdays[0]['working_days'];

			$tot_holydays=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));

			$tot_holydays=$tot_holydays-$tot_workdays[0]['working_days'];

			$data['tot_holydays']		=$tot_holydays;

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

			$this->load->view('Master/portofficer',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function customer_booking_pc_paid()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	$this->load->model('Master_model');	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$zone				= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']		=	$zone;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->view('Master/paid_customer_pc', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

    }

	public function customer_booking_pc_ajax()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{	

			$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));

			$this->load->model('Master_model');	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			//$customerreg_booking= $this->Master_model->get_all_buk_pay_suc($zone_id);

			$customerreg_booking= $this->Master_model->get_all_buk_pay_suc_new($zone_id);

			

			$data['cust_book_his']=$customerreg_booking;

			$data = $data + $this->data; 

			$res_day= $this->Master_model->get_reserv_day($port_id,$zone_id);

			$balance_sand=0;

			foreach($res_day as $rday)

			{

				$r_d=$rday['holiday_date'];

				$bal_s=$this->Master_model->get_daily_balforday($port_id,$zone_id,$r_d);

				if(!empty($bal_s))

				{

				$balance_sand=$balance_sand+$bal_s;

				}

			}

			//echo $balance_sand;

			$data['bal_sand']= $balance_sand;

			$data = $data + $this->data;    

			//$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			//	$data['user_header']=	$u_h_dat;

			//	$data 				= 	$data + $this->data;

			//	$this->load->view('template/header',$data);

			$this->load->view('Master/paid_customer_ajax_pc', $data);

			//$this->load->view('template/footer');

			//$this->load->view('template/js-footer');

			//$this->load->view('template/script-footer');

			//$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

    }

	public function movetoresrve()

	{

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$bukk_id=$this->security->xss_clean(html_escape($this->input->post('chk')));

			foreach($bukk_id as $buk_id)

			{

				//echo $buk_id;

				$b_det=$this->Master_model->get_buk_for_bukid($buk_id);

				$cus_phone=$b_det[0]['customer_phone_number'];

				$port_id=$b_det[0]['customer_booking_port_id'];

				$zone_id=$b_det[0]['customer_booking_zone_id'];

				$altd_date=$b_det[0]['customer_booking_allotted_date'];

				$r_ton=$b_det[0]['customer_booking_request_ton'];

				$res_day= $this->Master_model->get_reserv_day($port_id,$zone_id);

				//print_r($res_day);

				//exit;

				$balance_sand=0;

				foreach($res_day as $rday)

				{

					$r_d=$rday['holiday_date'];

					$bal_s=$this->Master_model->get_daily_balforday($port_id,$zone_id,$r_d);

					$balance_sand=$bal_s;

					if($balance_sand >= $r_ton)

					{

						//echo $r_d;

						$rmdate=date("d/m/Y",strtotime(str_replace('-', '/',$r_d)));

						$zdet=$this->db->query("select * from zone where zone_id='$zone_id'");

						$zone_namedet=$zdet->result_array();

						$zone_name=$zone_namedet[0]["zone_name"];
						if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip = $_SERVER["REMOTE_ADDR"];
}

						$msg="Dear Customer Your sand issue date for your booking has been successfully changed to ".$rmdate." and Kadavu - ".$zone_name;

						//$msg="Dear Customer Your sand issue date for your booking has been successfully changed to ".$rmdate;

						$this->sendSms($msg,$cus_phone);

						$n_bal=$balance_sand-$r_ton;

						$this->db->query("update customer_booking set customer_booking_allotted_date='$r_d',customer_booking_request_status=2

 where customer_booking_id='$buk_id'");

						$this->db->query("update daily_log set daily_log_used=daily_log_used+$r_ton,daily_log_unused=daily_log_unused-$r_ton,daily_log_balance=daily_log_balance- $r_ton,dailylog_reserve=dailylog_reserve+$r_ton where daily_log_date='$r_d' and daily_log_zone_id='$zone_id' and daily_log_port_id='$port_id'");

						$data_re=array(

						'buk_id'=>$buk_id,

						'prev_buk_date'=>$altd_date,

						'rebuk_ap_user'=>$sess_usr_id,

						'user_ip'=>$ip

						);

						$this->db->insert('tbl_rebuking',$data_re);

						break;

					}

					else

					{

						  continue;

					}

				}

			}	

			redirect('Port/customer_booking_pc_paid');

		}

	}

	public function getzones_for_p()

	{

				$getp=date('F Y');

			    $port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));

				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$data 				= 	$data + $this->data;     

				$zone				= 	$this->Master_model->get_zone_detailsnew($port_id,$getp);

				$data['zone']		=	$zone;

				$data 				= 	$data + $this->data;

				$this->load->view('Master/showzones', $data);

	}

	public function zoneStatus()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$zone				= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']		=	$zone;

			$data 				= 	$data + $this->data;

			$permit_name		= 	$this->Master_model->get_monthly_period();

			$data['permit']		=	$permit_name;

			$data 				= 	$data + $this->data; 

			$this->load->view('template/header',$data);

			$this->load->view('Master/zone_status_pc', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

		{

			redirect('Master/index');

		}

	}

	public function get_zone_bal()

	{

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));

			$period_id=$this->security->xss_clean(html_escape($this->input->post('period')));

			$permit_id=$this->Master_model->get_permit_id($zone_id,$period_id);

			$pr_id=$permit_id[0]['monthly_permit_id'];

			$t_sand=$this->Master_model->get_permit_totsand($port_id,$zone_id,$pr_id);

			$sum_tot=$t_sand[0]['sumtot'];

			$data['tot_sand']=$sum_tot;

			$data = $data + $this->data;

			$get_daily_log=$this->Master_model->daily_log_dates($port_id,$zone_id,$pr_id);

			$data['daily_det']=$get_daily_log;

			$data = $data + $this->data;

			$this->load->view('Master/show_zone_stat_ajax', $data);	

		}

		else

		{

			redirect('Master/index');

		}

		

	}

	public function user_change_pw()

	{

		echo $sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$un					=	$u_h_dat[0]['user_master_name'];

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->view('Master/ch_pw_new', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

			if($this->input->post())

			{

				$paswd=html_escape($this->input->post('c_p'));

				$npaswd=html_escape($this->input->post('n_p'));

				$res=$this->Master_model->login($un);

				//print_r($res);

				//exit();

				foreach($res as $re)

				{

				$hashed=$re['user_master_password'];

				//exit;

				}

				if($this->phpass->check($paswd,$hashed))

				{

						$newp=$this->phpass->hash($npaswd);

						$data_u=array('user_master_password'=>$newp);

						$res=$this->Master_model->up_pw($data_u,$sess_usr_id);

						session_destroy();

						redirect('Master/index');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your Password!!!</div>');

					redirect('Master/ch_pw'); 

				}

			}

		}

		else

		{

			redirect('Master/index'); 

		}

		

	}

	public function get_zone_pass_stat()

	{

		$sess_usr_id 			= 	$this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id']; 

			$zone_id			=	$userinfo[0]['user_master_zone_id'];

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$t_sand=$this->Master_model->get_today_pass($port_id,$zone_id);

			$data['t_sandpass']=$t_sand;

			$data = $data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->view('Master/today_sand_pass', $data);	

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

		{

			redirect('Master/index');

		}

		

	}

	public function sendSms($message,$number)

	{

		

		$link = curl_init();

		curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");

		curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($link , CURLOPT_HEADER, 0);

		$output = curl_exec($link);

		curl_close($link );

}

	public function forget_pw()

	{

		    $this->load->view('template/header');

			$this->load->view('Master/forgetme');	

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

			if($this->input->post())

			{

				$uname=html_escape($this->input->post('c_p'));

				$phone=html_escape($this->input->post('n_p'));

				$rres=$this->db->query("select user_master_id_user_type as ut from user_master where user_master_name='$uname'");

				$ru=$rres->result_array();

				$utype=$ru[0]['ut'];

				if($utype==5)

				{

				$resr=$this->db->query("select * from user_master join customer_registration on user_master.user_master_id=customer_registration.customer_public_user_id where user_master.user_master_name='$uname' and customer_registration.customer_phone_number='$phone'");

				//echo $this->db->last_query();

				//exit;

				}

				else

				{

					$resr=$this->db->query("select * from user_master where user_master_name='$uname' and user_master_ph='$phone'");

				}

				$no=$this->db->affected_rows();

				if($no==1)

				{

					$pw=bin2hex(openssl_random_pseudo_bytes(4));

					$newp=$this->phpass->hash($pw);

					$msg="Your Password changed successfully,Please note your new password $pw";

					//exit;

					$this->db->query("update user_master set user_master_password='$newp' where user_master_name='$uname'");

					$this->sendSms($msg,$phone);

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your Phone number / Username!!!</div>');

					redirect('Master/ch_pw'); 

				}

			}

	}

	///***************** NEW MECH DREDGE *************///////////////////////

	public function delmatrate_mech()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$matid=$this->security->xss_clean(html_escape($this->input->post('id')));

			//echo $matid;

			$result=$this->db->query("update tbl_mdrate set mdrate_status=2 where mdrate_id='$matid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	public function edit_mechmaterialrate_pc()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$int_userpost_sl		=	decode_url($this->uri->segment(3));	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(2);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_det			= 	$this->Master_model->get_materialrate_mech_byid($int_userpost_sl);

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

						/*if($this->input->post('vch_material_amt_dzone')!="true")

						{

							$domain=2;

							$rate=NULL;

						}

						else

						{

							$domain=3;

							$rate=$mat=implode(',',$this->input->post('vch_material_amt_zone'));

						}

						*/

						$matrate_data=array(

						//'materialrate_port_material_master_id'=>html_escape($this->input->post('int_material')),

						'mat_amount'=>html_escape($this->input->post('vch_material_amt')),

						'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

						'end_date'=>$end_date,

						'mat_domain'=>2,

						'mdrate_status'=>html_escape($this->input->post('int_material_status')),

						//'materialrate_port_user_id'=>$sess_usr_id,

						//'port_id'=>$port_id,

						//'materialrate_zone'=>$rate

						);

						$matrate_data=$this->security->xss_clean($matrate_data);

						$result=$this->Master_model->update_mech_material_rate_master($mr_id,$matrate_data);

						if($result==1)

						{

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate Updated successfully</div>');

															redirect('Port/mech_rate_pc');

						}

						else

						{

							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Update failed!!!</div>');

															redirect('Port/mech_rate_pc');

						}

					}

				}

				

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/addmaterialrate_mech_pc', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function add_mech_matrate_pc()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(2);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_ex			= 	$this->Master_model->get_mech_materialrate_act_pc($port_id);

			$data['material_ex']	=	$material_ex[0]['mat_id'];

			//exit;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$zone			= 	$this->Master_model->get_zoneByPID($sess_usr_id);

			$data['zone']	=	$zone;

			$data 			= 	$data + $this->data;

			$gm             =   $this->Master_model->get_mech_matforp($port_id);

			$data['matid']	=	$gm[0]['matid'];

			$data 			= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->view('Master/addmaterialrate_mech_pc', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

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

						/*if($this->input->post('vch_material_amt_dzone')!="true")

						{

							$domain=2;

							$rate=NULL;

						}

						else

						{

							$domain=3;

							$rate=$mat=implode(',',$this->input->post('vch_material_amt_zone'));

						}*/

						$matrate_data=array(

						'material_id'=>html_escape($this->input->post('int_material')),

						'mat_amount'=>html_escape($this->input->post('vch_material_amt')),

						'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

						'end_date'=>$end_date,

						'mat_domain'=>2,

						'mdrate_status'=>html_escape($this->input->post('int_material_status')),

						'port_user'=>$sess_usr_id,

						'port_id'=>$port_id

						//'materialrate_zone'=>$rate

						);

						$matrate_data=$this->security->xss_clean($matrate_data);

						$result=$this->Master_model->add_material_rate_mech($matrate_data);

						if($result==1)

						{

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate added successfully</div>');

															redirect('Port/mech_rate_pc');

						}

						else

						{

							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Add failed!!!</div>');

															redirect('Port/mech_rate_pc');

						}

					}

			}

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function mech_rate_pc()

	{	

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$material			= 	$this->Master_model->get_material_master();

			$data['material']	=	$material;   

			$material_rate			= 	$this->Master_model->get_materialratefu_mech($port_id);

			$data['material_rate']	=	$material_rate;

			$data 				= 	$data + $this->data;

			$zone			= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']	=	$zone;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/material_rate_mech_pc',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function mech_rate()

	{	

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Master_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;  

			$material			= 	$this->Master_model->get_material_master();

			$data['material']	=	$material;   

			$material_rate			= 	$this->Master_model->get_materialratefu_pd();

			$data['material_rate']	=	$material_rate;

			$data 				= 	$data + $this->data;

			$zone			= 	$this->Master_model->get_zone_acinP($port_id);

			$data['zone']	=	$zone;

			$data 				= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/material_rate_mech',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function add_mech_matrate()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(1);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_ex			= 	$this->Master_model->get_mech_materialrate_act();

			$data['material_ex']	=	$material_ex[0]['mat_id'];

			//exit;

			$data 				= 	$data + $this->data;

			$status			= 	$this->Master_model->get_status();

			$data['status']	=	$status;

			$data 				= 	$data + $this->data;

			$zone			= 	$this->Master_model->get_zoneByPID($sess_usr_id);

			$data['zone']	=	$zone;

			$data 			= 	$data + $this->data;

			$gm             =   $this->Master_model->get_mech_matforp($port_id);

			$data['matid']	=	$gm[0]['matid'];

			$data 			= 	$data + $this->data;

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->view('Master/addmaterialrate_mech', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

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

						/*if($this->input->post('vch_material_amt_dzone')!="true")

						{

							$domain=2;

							$rate=NULL;

						}

						else

						{

							$domain=3;

							$rate=$mat=implode(',',$this->input->post('vch_material_amt_zone'));

						}*/

						$matrate_data=array(

						'material_id'=>html_escape($this->input->post('int_material')),

						'mat_amount'=>html_escape($this->input->post('vch_material_amt')),

						'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

						'end_date'=>$end_date,

						'mat_domain'=>1,

						'mdrate_status'=>html_escape($this->input->post('int_material_status')),

						'port_user'=>$sess_usr_id,

						'port_id'=>NULL

						//'materialrate_zone'=>$rate

						);

						$matrate_data=$this->security->xss_clean($matrate_data);

						$result=$this->Master_model->add_material_rate_mech($matrate_data);

						if($result==1)

						{

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate added successfully</div>');

															redirect('Port/mech_rate');

						}

						else

						{

							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Add failed!!!</div>');

															redirect('Port/mech_rate');

						}

					}

			}

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

	}

	public function edit_mechmaterialrate()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$i=0;

		if(!empty($sess_usr_id)&& $sess_user_type==2)

		{

			$int_userpost_sl		=	decode_url($this->uri->segment(3));	

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[$i]['user_master_port_id'];

			$this->load->model('Master_model');	

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     

			$material			= 	$this->Master_model->get_material_masterby_auth(1);

			$data['material']	=	$material;

			$data 				= 	$data + $this->data;

			$material_det			= 	$this->Master_model->get_materialrate_mech_byid($int_userpost_sl);

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

						/*if($this->input->post('vch_material_amt_dzone')!="true")

						{

							$domain=2;

							$rate=NULL;

						}

						else

						{

							$domain=3;

							$rate=$mat=implode(',',$this->input->post('vch_material_amt_zone'));

						}

						*/

						$matrate_data=array(

						//'materialrate_port_material_master_id'=>html_escape($this->input->post('int_material')),

						'mat_amount'=>html_escape($this->input->post('vch_material_amt')),

						'start_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('vch_material_sd'))))),

						'end_date'=>$end_date,

						'mat_domain'=>1,

						'mdrate_status'=>html_escape($this->input->post('int_material_status')),

						//'materialrate_port_user_id'=>$sess_usr_id,

						//'port_id'=>$port_id,

						//'materialrate_zone'=>$rate

						);

						$matrate_data=$this->security->xss_clean($matrate_data);

						$result=$this->Master_model->update_mech_material_rate_master($mr_id,$matrate_data);

						if($result==1)

						{

							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate Updated successfully</div>');

															redirect('Port/mech_rate');

						}

						else

						{

							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Update failed!!!</div>');

															redirect('Port/mech_rate');

						}

					}

				}

				

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

				$data['user_header']=	$u_h_dat;

				$data 				= 	$data + $this->data;

				$this->load->view('template/header',$data);

			$this->load->view('Master/addmaterialrate_mech', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

	   	}

	   	else

	   	{

			redirect('Master/index');        

  		}  

	}

		

	//-------------------------------------PC CLERK LOGIN------------------------------------------------------

	

	public function port_clerk_main()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$port_id			=	$userinfo[0]['user_master_port_id'];

		if(!empty($sess_usr_id)&& $sess_user_type==9)

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->model('Master_model');	

			

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 

			$menu_assign=$this->Master_model->get_module_assign($sess_usr_id);

			$data['module_assign']=	$menu_assign;

			$data 				= 	$data + $this->data;

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];

			$tn=$this->Master_model->tot_msg_unread($sess_usr_id);

			$data['tn']			=	$tn[0]['totnew'];  

			$tn1=$this->Master_model->totcus_reg($port_id);  

			$data['tn1']			=	$tn1[0]['totcreq']; 

			$tn2=$this->Master_model->tot_buk_pen($port_id);

			$data['tn2']			=	$tn2[0]['totbpen']; 

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

			$fin_year		= 	$this->Master_model->get_fin_year();

			$data['fin_year']		=	$fin_year;

			$data 				= 	$data + $this->data; 

			//lmr

			$totpermit_aprvd=$this->Master_model->tot_permit_aprvd($port_id);

			$data['tot_per_aprvd']		=	$totpermit_aprvd[0]['permit_aprvd'];

			$data 				= 	$data + $this->data; 

			

			$totpermit_pend=$this->Master_model->tot_permit_pend($port_id);

			$data['tot_per_pend']		=	$totpermit_pend[0]['permit_pend'];

			$data 				= 	$data + $this->data; 

			

			$curr_date=date("Y-m-d");

			$holy_prd=date('F Y',strtotime($curr_date));

			$data['holy_prd']		=	$holy_prd;

			$tot_workdays=$this->Master_model->tot_working_days($holy_prd);

			//print_r($tot_workdays);break;

			$data['tot_workdays']		=	$tot_workdays[0]['working_days'];

			$tot_holydays=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));

			$tot_holydays=$tot_holydays-$tot_workdays[0]['working_days'];

			$data['tot_holydays']		=$tot_holydays;

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

			//exit();

			$data 				= 	$data + $this->data;

			$data['totsandpassbar']	=	$c;

			//exit();

			$data 				= 	$data + $this->data;

			//

			//Doaunut

			//   

			$totperreq			= 	$this->Master_model->permit_req_pc($port_id);

			//print_r($totperreq);

			$data['totperreq']	=	$totperreq[0]['totreq'];

			//exit();

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

			//

			//Do END 

			//

			//

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

			$data 				= 	$data + $this->data;

			$this->load->view('Master/portclerk_view',$data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

		}

		else

	   	{

			redirect('Master/index');        

  		}  

	}

	//////////////*****************************************************************************/////////////////////

	public function addmodule_clerk()

	{

		 $sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$un					=	$u_h_dat[0]['user_master_name'];

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];

			$this->load->model('Reports_model');

			$assignmod_view=$this->Reports_model->assign_mod_view($port_id);

			$data['assign_modview']=	$assignmod_view;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->view('Master/addmodule', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

			

		}

		else

		{

			redirect('Master/index'); 

		}

	}

	//------------------------------------------------------------------

	public function add_module_new()

	{

		 $sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$this->load->model('Reports_model');	

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$un					=	$u_h_dat[0]['user_master_name'];

			$data['user_header']=	$u_h_dat;

			$data 				= 	$data + $this->data;

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

			$port_id			=	$userinfo[0]['user_master_port_id'];

			$username_get		=	$this->Reports_model->getuser_nameclerk($port_id);

			

			//print_r($username_get);

			$data['get_clerk']=	$username_get;

			$data 				= 	$data + $this->data;

			$getmodule			=$this->Reports_model->get_moduledetails();

			$data['get_module']=	$getmodule;

			$data 				= 	$data + $this->data;

			$this->load->view('template/header',$data);

			$this->load->view('Master/add_module_new', $data);

			$this->load->view('template/footer');

			$this->load->view('template/js-footer');

			$this->load->view('template/script-footer');

			$this->load->view('template/html-footer');

			if($this->input->post())

			{

				$useriddropdown=html_escape($this->input->post('int_user'));

				$moduleid=html_escape($this->input->post('int_mod'));

				

				$querycheck=$this->db->query("select * from assign_module where user_master_id='$useriddropdown' and module_id='$moduleid' and assign_module_status=0");

				$no=$this->db->affected_rows();

				if($no==1)

				{

					$mod_array=$querycheck->result_array();

					$modid=$mod_array[0]['assign_mod_id'];

					$result=$this->db->query("update assign_module set assign_module_status=1,user_enddate='0000-00-00' where assign_mod_id='$modid'");

				}

				else{

						

						$data_u=array('user_master_id'=>$useriddropdown,

									 'user_type_id'=>9,

									 'module_id'=>$moduleid);

				$result=$this->db->insert('assign_module',$data_u);

					

					}

				if($result)

				{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Assign Successfully......</div>');

						redirect('Port/addmodule_clerk');

			   }

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Already assigned no possible....!!!</div>');

					redirect('Port/add_module_new'); 

				}

		  }

		}

		else

		{

			redirect('Master/index'); 

		}

	}

	//***************************************************************************************************************

	public function delmoduleuser()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{

			$modid=$this->security->xss_clean(html_escape($this->input->post('id')));

			$d=date('Y-m-d');

			//echo "update plintharea_master set plintharea_status=0 where plintharea_id='$matid'";

			$result=$this->db->query("update assign_module set assign_module_status=0,user_enddate='$d' where assign_mod_id='$modid'");

			if($result==1)

			{

				echo $result;

			}

		}

	}

	//---------------------------------------------------------------------------------------------------------------

}