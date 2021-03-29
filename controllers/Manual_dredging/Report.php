<?php
defined('BASEPATH') OR exit('No direct script access allowed');    
class Report extends CI_Controller 

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
			$this->load->helper('encdec');
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
	        $this->load->model('Manual_dredging/Reports_model');
			

    }

	public function addbalq()
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
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$daily_bal_id=decode_url($id=$this->uri->segment(3));
			$daily_bal_id=decode_url($id=$this->uri->segment(4));
			$sql=$this->db->query("select * from daily_log join zone on daily_log.daily_log_zone_id=zone.zone_id where daily_log_id='$daily_bal_id'");
			$rd=$sql->result_array();
			$data['rd_det']=$rd;
			if($this->input->post())

			{
				$did=$this->security->xss_clean(html_escape($this->input->post('hid_db')));
				$upqty=$this->security->xss_clean(html_escape($this->input->post('upqty')));
				$this->db->query("update daily_log set daily_log_total=daily_log_total+$upqty,daily_log_balance=daily_log_balance+$upqty where daily_log_id='$did'");

				redirect('Manual_dredging/Report/update_dailylog_qty');


			}
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/addbalq',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

	}

	public function minusbalq()

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
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$daily_bal_id=decode_url($id=$this->uri->segment(3));
			$daily_bal_id=decode_url($id=$this->uri->segment(4));
			$sql=$this->db->query("select * from daily_log join zone on daily_log.daily_log_zone_id=zone.zone_id where daily_log_id='$daily_bal_id'");
			$rd=$sql->result_array();
			$data['rd_det']=$rd;
			if($this->input->post())

			{
				$did=$this->security->xss_clean(html_escape($this->input->post('hid_db')));
				$upqty=$this->security->xss_clean(html_escape($this->input->post('upqty')));
				$this->db->query("update daily_log set daily_log_total=daily_log_total-$upqty,daily_log_balance=daily_log_balance-$upqty where daily_log_id='$did'");
				redirect('Manual_dredging/Report/update_dailylog_qty');

			}
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/minusbalq',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

	}

	public function get_daily_bal()


	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))
		{
			$zone=$this->security->xss_clean(html_escape($this->input->post('zone')));
			$y=date('Y');
			$m=date('m');
                        $sdate=$y."-".$m."-1";
			$today=date('Y-m-d');
			$sql=$this->db->query("select * from daily_log where daily_log_zone_id='$zone' and daily_log_date>='$today'");
			$bal=$sql->result_array();
			$data["bal_qty"]=$bal;
			$data 				= 	$data + $this->data;
			$sql1=$this->db->query("select SUM(daily_log_balance) as WaistedTon from daily_log where daily_log_zone_id='$zone' and daily_log_date<'$today' and daily_log_date>='$sdate'");
			$bal1=$sql1->result_array();
			$data["bal1"]=$bal1;
			$data 				= 	$data + $this->data;
			$this->load->view("Manual_dredging/Report/daily_bal_ajax",$data);

		}


	}

	public function update_dailylog_qty()
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
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$res_data=$this->db->query("select * from zone where zone_port_id='$port_id'");
			$data['zone']=$res_data->result_array();
			$data 				= 	$data + $this->data;
			if($this->input->post())
			{
				$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));
				$data_in=array('zone_id'=>$zone_id,
				'user'=>$sess_usr_id);

				$this->db->insert('spot_kadavu',$data_in);
				redirect('Manual_dredging/Report/add_kadavu_spot');

			}

			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/up_dailylog',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}
		else

		{

			redirect('Main_login/index');        

		}


	}

	public function act_usr()

	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))

		{

			$txt_mob=$this->security->xss_clean(html_escape($this->input->post('txt_mob')));
			$txt_un=$this->security->xss_clean(html_escape($this->input->post('txt_un')));
			$txt_reg=$this->security->xss_clean(html_escape($this->input->post('txt_reg')));
			$this->db->query("update customer_registration set customer_phone_number='$txt_mob' where customer_registration_id=$txt_reg");
			$new_pswd=bin2hex(openssl_random_pseudo_bytes(4));
			$newp=$this->phpass->hash($new_pswd);
			$res=$this->db->query("update user_master set user_master_status=1,user_master_password='$newp' where user_master_name='$txt_un'");
			if($res==1)
			{
				$msg="Dear customer your account has been activated please note your new password-: ".$new_pswd;
				$this->sendSms($msg,$txt_mob);
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Phone Number Updated and Account Activated Successfully</div>');
					redirect('Manual_dredging/Report/update_blocked');

			}

			else

			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Failed !!!</div>');
					redirect('Manual_dredging/Report/update_blocked');

			}	

		}

	}

	public function chk_mob_user()

	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))

		{
			$txt_mob=$this->security->xss_clean(html_escape($this->input->post('txt_mob')));
			$r_data=$this->db->query("select customer_registration_id from  customer_registration where customer_phone_number='$txt_mob' and customer_request_status!=3");
			$rr=$r_data->result_array();
			if(count($rr)==0)
			{

				echo "0";

			}

			else

			{
				echo "1";

			}

		}

	}

	public function get_usr_det()

	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($sess_user_type==3 || $sess_user_type==9))
		{
			$txt_un=$this->security->xss_clean(html_escape($this->input->post('txt_un')));
			$r_data=$this->db->query("select user_master_id,user_master_status from  user_master where user_master_name='$txt_un' and user_master_id_user_type='5'");
			$rr=$r_data->result_array();
			$u_pub_id=$rr[0]['user_master_id'];
			if($u_pub_id!='')
			{
			if($rr[0]['user_master_status']==0)
			{
				$stat="Blocked";

			}

			else

			{


				$stat="Active";

			}

			$cus_det=$this->db->query("select customer_registration_id,customer_name,customer_phone_number from customer_registration where customer_public_user_id='$u_pub_id'");
			$cus_data=$cus_det->result_array();
			echo "<input type='hidden' name='txt_reg' id='txt_reg' value='".$cus_data[0]['customer_registration_id']."'/><table class='table table-bordered table-striped'><tr><td>Name</td><td>".$cus_data[0]['customer_name']."</td></tr><tr><td>Used Mobile No</td><td>".$cus_data[0]['customer_phone_number']."</td></tr><tr><td>Status</td><td>".$stat."</td></tr></table>";	

			}

		}

	}


	public function userman_home()
	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)

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
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			//$this->load->view('template/header',$data);
			$this->load->view('Manual_dredging/Report/userman_home',$data);
			$this->load->view('Kiv_views/template/dash-footer');
			

		}

		else

		{
			redirect('Main_login/index');        

		}

	}

	public function update_blocked()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))
		{       $this->load->model('Manual_dredging/Master_model');
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
			$this->load->view('Manual_dredging/Report/update_blocked',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
		redirect('Main_login/index');        
		}
	}

	public function get_interval_stat_phone()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');

		if(!empty($sess_usr_id))

		{       $this->load->model('Manual_dredging/Master_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			$port_id			=	$userinfo[$i]['user_master_port_id'];

		$txt_phone=$this->security->xss_clean(html_escape($this->input->post('txt_phone')));
		$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_phone='$txt_phone' order by spotreg_id desc limit 0,1");
		$g_int=$get_intrvl->result_array();
		if(count($g_int)==0)
	{
		echo 0;


			}

			else
		{

		$today=date('Y-m-d h:i:s');
		$w_buk_date=$g_int[0]['spot_timestamp'];
			$date1=date_create($today);
			$date2=date_create($w_buk_date);
			$diff = $date2->diff($date1)->format("%a");
			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id='$port_id' and buk_stat=1");
			$tn_no=$get_last_d->result_array();
			$t_n=$tn_no[0]['buk_time'];
			if($diff<$t_n)
			{
				echo 1;

			}
			else
			{
				echo 0;
			}
			}

		}

	}
	public function get_interval_stat()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		if(!empty($sess_usr_id))

		{
                    $this->load->model('Manual_dredging/Master_model');
                    $userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;

		$port_id			=	$userinfo[$i]['user_master_port_id'];
	$txt_adhar=$this->security->xss_clean(html_escape($this->input->post('txt_adhar')));
	$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhar' order by spotreg_id desc limit 0,1");

	$g_int=$get_intrvl->result_array();
			if(count($g_int)==0)
		{

			echo 0;
	}
	else
		{

		$today=date('Y-m-d h:i:s');
		$w_buk_date=$g_int[0]['spot_timestamp'];
			$date1=date_create($today);
		$date2=date_create($w_buk_date);

                $diff = $date2->diff($date1)->format("%a");
		$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id='$port_id' and buk_stat=1");
		$tn_no=$get_last_d->result_array();
		$t_n=$tn_no[0]['buk_time'];

			if($diff<$t_n)
			{
				echo 1;
			}
			else
			{
			echo 0;
			}
			}
		}
	}
public function settings_interval()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))
		{       $this->load->model('Manual_dredging/Master_model');
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
			$res_data=$this->db->query("select * from tbl_buk_interval where port_id='$port_id' order by buk_int_id desc");
			$data['buk_int']=$res_data->result_array();
			$data 				= 	$data + $this->data;
		if($this->input->post())
			{
				$txt_intrvl=$this->security->xss_clean(html_escape($this->input->post('txt_intrvl')));
				$data_in=array('buk_time'=>$txt_intrvl,
				'buk_usr'=>$sess_usr_id,
				'port_id'=>$port_id
				);
				$this->db->insert('tbl_buk_interval',$data_in);
				redirect('Manual_dredging/Report/settings_interval');
			}
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/add_interval',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
		redirect('Main_login/index');        
		}
	}
	public function c_interval()
	{
		//$id=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$this->db->query("update tbl_buk_interval set buk_stat=2 where buk_int_id='$id'");
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Cancelled!!!</div>');
		redirect('Manual_dredging/Report/settings_interval');
	}
	public function reg_lorry_pc()
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
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$res_data=$this->db->query("select * from tbl_lorry join zone on tbl_lorry.zone_id=zone.zone_id where port_id='$port_id'");
			$data['lorry']=$res_data->result_array();
			$data 				= 	$data + $this->data;
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/lorry_details_pc',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');        
		}
	}
	public function a_lorry()
	{
		//$id=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$this->db->query("update tbl_lorry set status=1 where lorry_id='$id'");
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Lorry Activated!!!</div>');
		redirect('Manual_dredging/Report/reg_lorry_pc');
	}
	public function b_lorry()
	{
		//$id=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$this->db->query("update tbl_lorry set status=2 where lorry_id='$id'");
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Lorry Blocked!!!</div>');
		redirect('Manual_dredging/Report/reg_lorry_pc');
	}
	public function c_lorry()
	{
		//$id=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$this->db->query("update tbl_lorry set status=3 where lorry_id='$id'");
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Lorry Registration Cancelled!!!</div>');
		redirect('Manual_dredging/Report/reg_lorry_pc');
	}
	public function lorry()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
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
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/lorryt_home',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');        
		}
	}
	public function get_sand_issue_det()
	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==6))
		{
                        $this->load->model('Manual_dredging/Master_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];
			$zone_id			=	$userinfo[0]['user_master_zone_id'];
			$periodname			=	date('F Y');
			if($sess_user_type==6)
			{
			$zone_det=$this->Master_model->get_zone_detailsnew_nn($port_id,$zone_id,$periodname);
			$data['zone_det']=$zone_det;		
			}
			else
			{
			$zone_det=$this->Master_model->get_zone_detailsnew($port_id,$periodname);
			$data['zone_det']=$zone_det;
			}
			$data 				= 	$data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/get_sand_issue', $data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
	   	{
			redirect('Main_login/index');        
  		} 
	}
	public function get_sand_issue_ajax()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{
                        $this->load->model('Manual_dredging/Master_model');

                        $userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];
			$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone')));
			$today=date('Y-m-d');
			$prevdate=date('Y-m-d',(strtotime ( '-3 day' , strtotime ($today))));
			//$today=date('Y-m-d');
			$t_sand=$this->db->query("select * from customer_registration join customer_booking on customer_registration.customer_registration_id=customer_booking.customer_booking_registration_id where customer_booking.customer_booking_allotted_date > '$prevdate' and  customer_booking.customer_booking_allotted_date <='$today' and customer_booking.customer_booking_zone_id='$zone_id' order by customer_booking.customer_booking_pass_issue_timestamp desc");
			//print_r($t_sand);
			$data['t_sandpass']=$t_sand->result_array();
			$data 				= 	$data + $this->data;
			$this->load->view('Manual_dredging/Report/sand_issue_lorry', $data);
		}
	}
	public function cancel_token()
	{
		//$loken			=		$this->uri->segment(3);
		$loken			=		$this->uri->segment(4);
		$this->db->query("update customer_booking set customer_booking_decission_status=5 where customer_booking_token_number='$loken'");
	}
	public function lorry_today()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))
		{
                        $this->load->model('Manual_dredging/Master_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$zone_id			=	$userinfo[$i]['user_master_zone_id'];
			$p_name=$this->Master_model->get_port_By_PC($port_id);
			$port_name=$p_name[$i]['vchr_portoffice_name'];
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$res_data=$this->db->query("select * from tbl_lorry join assign_lorry on  tbl_lorry.lorry_id=assign_lorry.assign_lorry_lid where tbl_lorry.zone_id='$zone_id'");
			$data['l_det']=$res_data->result_array();
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/today_lorry',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}
		else
		{
			redirect('Main_login/index');        
		}
	}
	//******************************************-----Sand Issue----****************************************
	public function sand_issue()
    {
    	//ini_set('display_errors', 1);
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$this->load->model('Manual_dredging/Master_model');	
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
				//$this->load->view('template/header',$data);
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
					//$port_id			=	$userinfo[0]['user_master_port_id'];  
					//$zone_id			=	$userinfo[0]['user_master_zone_id'];
					$this->load->model('Manual_dredging/Reports_model');
					$get_bookingapprovedlistdata= $this->Reports_model->get_spotbookinglist($tokennumnber,$aadharnumber,$zone_id);
					//print_r($get_bookingapprovedlist);break;
					//
					if($get_bookingapprovedlistdata)
					{

						$data['get_bookingapprovedlistdata']=$get_bookingapprovedlist;
						$bookingid=$get_bookingapprovedlistdata[0]['spotreg_id'];
						$booking_id=encode_url($bookingid);
						redirect('Manual_dredging/Report/sand_issue_addmessage/'.$booking_id);
					}
					else
					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');
													redirect('Manual_dredging/Report/sand_issue');
					}
				}
		}

			$today=date('Y-m-d');
			$t_d=$this->db->query("select * from tbl_spotbooking join transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where tbl_spotbooking.spot_alloted='$today' and transaction_details.zone_id='$zone_id' and transaction_details.print_status=0 and pass_dstatus=2 and  spot_booking_type=1 ");
			if($this->db->affected_rows() > 0){
            $data['to_data']=$t_d->result_array();
        }else{
           $data['to_data']='NULL';
        }
			//$data['to_data']=$t_d->result_array();
			$data 				= 	$data + $this->data;
			$this->load->view('Manual_dredging/Report/sand_issue', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			//$bk_id_pass=decode_url($this->uri->segment(3));//----------after integration changed---
			$bk_id_pass=decode_url($this->uri->segment(4));
			if($bk_id_pass!=0)
			{
				redirect('Manual_dredging/Report/generatepass/'.encode_url($bk_id_pass));
		}
		}	
		else
		{
				redirect('settings/index');        
		}
    }
//----------------------------------------------------------------------------	
	public function sand_issue_add()
    {
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
			//$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
			 $id			=		decode_url($id);
		if(!empty($sess_usr_id))
		{	
			$data = array('title' => 'Add Sand Issue', 'page' => 'sand_issue_add', 'errorCls' => NULL, 'post' => $this->input->post());
			$data = $data + $this->data;
			$this->load->model('Manual_dredging/Reports_model');
			$get_bookingapprovedadded= $this->Reports_model->get_spotbookingadd($id);
			$data['get_bookingapprovedadded']=$get_bookingapprovedadded;
			$data = $data + $this->data;
						$this->load->model('Manual_dredging/Master_model');
			//$monthlypermitid=$get_bookingapprovedadded[0]['customer_booking_monthly_permit_id'];
			//$permitamount=$this->Master_model->get_monthly_permit_by_id($monthlypermitid);
			//$data['permitamount']=$permitamount;
			//$data = $data + $this->data;
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
			$hid_bookingid=$this->security->xss_clean(html_escape($this->input->post('hid_bookingid')));
			$txtdrmobno=$this->security->xss_clean(html_escape($this->input->post('txtdrmobno')));
			$currentdate=date('Y-m-d H:i:s');
			//$ip_address				=	$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
                                    {
                                        $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
                                    }
                                    else 
                                        {
                                            $ip_address = $_SERVER["REMOTE_ADDR"];
                                        }
                                        $update_data=array('pass_isue_user'	=>  $sess_usr_id,
							'pass_issue_timestamp'	=>  $currentdate,
							'spot_VehicleMake'	=>  $txtvehiclemake,
							'spot_vehicleRegno'	=>  $txtvehicleregno,
							 'spot_altd_timestamp'	=>  $currentdate,
							'spot_driver'		=>  $txtdrivername,
							'spot_license'		=>  $txtdrlicenseno,
							'spot_driver_mobile'	=>  $txtdrmobno);

				$result=$this->Reports_model->update_spotbooking($update_data,$hid_bookingid);
			/*	
				$get_bookingapprovedadd= $this->Reports_model->get_spotbookingadd($hid_bookingid);
//-------------------------------------  Insert to Payment Table    ---------------------------------------------

 */


 //-----------------------------------------------------------------------------------------------------------------------
				//$result=$this->Master_model->update_customerregistration($request_data,$customerreg_id);
				if($result)
				{
					$get_token=$this->db->query("select spot_token from tbl_spotbooking where spotreg_id='$hid_bookingid'");
					$g_tok=$get_token->result_array();
					 $token=$g_tok[0]['spot_token'];	
					$this->db->query("update transaction_details set print_status=1 where token_no='$token'");
//exit();
					//	$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Sand Issued successfully</div>');
													//$this->load->library('user_agent');

				redirect('Manual_dredging/Report/vehicle_pass_success/'.encode_url($hid_bookingid));
				//redirect('Master/generatepass/'.encode_url($hid_bookingid));

				}

				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Sand Issue failed!!!</div>');
												redirect('Manual_dredging/Master/sand_issue');
				}


			}

			$this->load->view('Manual_dredging/Report/sand_issue_add',$data);
			$this->load->view('Kiv_views/template/dash-footer');
			$this->load->view('template/html-footer');
		}
		else
		{
				redirect('settings/index');        
		}
	}
	//--------------------------------------------------------------------------------------------------------------------
	public function sand_issue_addmessage()
	{
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
			//$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
			 $id			=		decode_url($id);
		$this->load->model('Manual_dredging/Master_model');	
		$this->load->model('Manual_dredging/Reports_model');	
		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data; 
		$get_bookingapprovedadd=$this->Reports_model->get_spotbookingadd($id);
//print_r($get_bookingapprovedadd);
//		break;
	$data['get_bookingapprovedadd']=$get_bookingapprovedadd;
			$data = $data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
				//$this->load->view('template/header',$data);
				$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/sandissue_addmessage',$data);
			$this->load->view('Kiv_views/template/dash-footer');

	}
	//------------------------------------------------------------------------------
	/*---
	
	spot otp check
	
	
	
	*/
	//------------------------------------------------------------------------------------------------

	public function sand_issueotpspot()

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
				//$this->load->view('template/header',$data);
				$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');

			if($this->input->post())

			{

				$this->session->unset_userdata('sess_spotpass_otp',$otpno);
				$this->form_validation->set_rules('txttokenno', 'Token No ', 'required');

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
					

//$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlistnnew($tokennumnber,$port_id,$zone_id);
				
					
					$this->load->model('Manual_dredging/Reports_model');
					$get_bookingapprovedlistdata= $this->Reports_model->get_spotbookinglistotp($tokennumnber,$port_id,$zone_id);

					//print_r($get_bookingapprovedlist);break;

					//

					if($get_bookingapprovedlistdata)
					{

						$data['get_bookingapprovedlistdata']=$get_bookingapprovedlist;
						$bookingid=$get_bookingapprovedlistdata[0]['spotreg_id'];
						$booking_id=encode_url($bookingid);
						redirect('Manual_dredging/Report/sand_issue_addmessage/'.$booking_id);
					}
					else
					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');
							redirect('Manual_dredging/Report/sand_issueotpspot');
					}
		

				}
			

			

		}

			$this->load->view('Manual_dredging/Report/sand_issuespototp', $data);

			$this->load->view('Kiv_views/template/dash-footer');

			//$bk_id_pass=decode_url($this->uri->segment(3));
			$bk_id_pass=decode_url($this->uri->segment(4));
			if($bk_id_pass!=0)
			{
				redirect('Manual_dredging/Report/generatepass/'.encode_url($bk_id_pass));
		}
		}	
		else
		{
				redirect('settings/index');        
		}


    }

	/////////////////////////////////////////////////////////////////////////////////

	public function spototp_vehiclepass()

		{

			

			$sess_usr_id 			= 	$this->session->userdata('int_userid');

			$sess_user_type			=	$this->session->userdata('int_usertype');

			$this->load->model('Manual_dredging/Master_model');	

		//$txtaadharno=$this->security->xss_clean(htmlentities($this->input->post('txtaadharno')));

		$txttokenno=$this->security->xss_clean(htmlentities($this->input->post('txttokenno')));
	

				$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

					$port_id			=	$userinfo[0]['user_master_port_id'];  

					$zone_id			=	$userinfo[0]['user_master_zone_id'];

				//	$get_bookingapprovedlistdata= $this->Master_model->get_bookingapprovedlistnnew($txttokenno,$port_id,$zone_id);
$get_bookingapprovedlistdata= $this->Reports_model->get_spotbookinglistotp($txttokenno,$port_id,$zone_id);
			$rowcount=count($get_bookingapprovedlistdata); 

	//print_r($get_bookingapprovedlistdata);exit();

					if($rowcount==1)

					{

					

						$data['get_bookingapprovedlistdata']=$get_bookingapprovedlist;

						$bookingid=$get_bookingapprovedlistdata[0]['spotreg_id'];

						$cusphoneno=$get_bookingapprovedlistdata[0]['spot_phone'];

						

			$currentdate  =	date('Y-m-d H:i:s');

				$otpno=rand(100000,999999);

				$smsmsg="Portinfo 2 - Dear Customer SPOT OTP generated for Vehicle Pass  is $otpno.";

		

				$this->session->set_userdata('sess_spotpass_otp',$otpno);

				$send=$this->sendSms($smsmsg,$cusphoneno);

		//print_r($send);

		$rr=explode(",",$send); 

	//echo "rrrrr---".$rr[0];

		if($rr[0]==402)

	

		{

			

			$this->session->set_userdata('sess_spotpass_otp',$otpno);

		

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

			

		$this->session->unset_userdata('sess_spotpass_otp',$otpno);		

		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');

			redirect('Manual_dredging/Report/sand_issueotpspot');

	}

			

}

public function vehiclepass_spototpcheck()

	{

		$sess_custpass_otp 			=  $this->session->userdata('sess_spotpass_otp');

		

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

		
		}

		

	}

	//-------------------------------------------------------------------------------
	
public function vehicle_pass_success()
	{

	$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{
			//$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);		
			$this->load->model('Manual_dredging/Master_model');	
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data; 
			$sess_usr_id 			= 	$this->session->userdata('int_userid');
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$desgofsign			=	$userinfo[0]['user_master_fullname'];  
			$data_vehiclepass	= 	$this->Reports_model->vehiclepass_details_spot($id);
			if(empty($data_vehiclepass))
			{
			//redirect('Master/dashboard');
			}
			$data['data_vehiclepass']=	$data_vehiclepass;
			$data 				= 	$data + $this->data;
			$this->load->view('template/header');
			$this->load->view('Manual_dredging/Report/vehicle_pass_success',$data);
			$this->load->view('Kiv_views/template/dash-footer');
	}
	else
		{
			redirect('Master/index');
		}
	}


function convertToHoursMins($time, $format = '%02d:%02d') 

{

    if ($time < 1) {

        return;

    }

    $hours = floor($time / 60);

    $minutes = ($time % 60);

    return sprintf($format, $hours, $minutes);

}
	public function generatepass_duplicate()

	{

		ini_set("memory_limit","256M");
		//$id 				= 	$this->uri->segment(3);
		$id			=		$this->uri->segment(4);
	    $bookingid 			= 	decode_url($id); 
	//$get_token=$this->db->query("select spot_token from tbl_spotbooking where spotreg_id='$bookingid'");
	//$g_tok=$get_token->result_array();
	//$token=$g_tok[0]['spot_token'];	
	//$this->db->query("UPDATE transaction_details SET pass_dstatus = 1, print_status=1 WHERE token_no= $bookingid");
	$sess_usr_id 			= 	$this->session->userdata('int_userid');
	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
	$desgofsign			=	$userinfo[0]['user_master_fullname'];  
	//exit;
	$data_vehiclepass	= 	$this->Reports_model->vehiclepass_details_spot_pass($bookingid);
	//print_r($data_vehiclepass);
	$customername	=	$data_vehiclepass[0]['spot_cusname'];
	$customerphone	=	$data_vehiclepass[0]['spot_phone'];
	/*$customerbalsand	=	$data_vehiclepass[0]['customer_unused_ton'];
	$houseno		=	$data_vehiclepass[0]['customer_perm_house_number'];
	$housename		=	$data_vehiclepass[0]['customer_perm_house_name'];
	$houseplace		=	$data_vehiclepass[0]['customer_perm_house_place'];
	$lsgdename		=	$data_vehiclepass[0]['lsgd_name'];
	$lsgdaddress	=	$data_vehiclepass[0]['lsgd_address'];
	$lsgdphoneno	=	$data_vehiclepass[0]['lsgd_phone_number'];*/
	$tokenno		=	$data_vehiclepass[0]['spot_token'];
	//$permitno		=	$data_vehiclepass[0]['customer_permit_number'];
	$vehicleno		=	$data_vehiclepass[0]['spot_vehicleRegno'];
	$driverlicense	=	$data_vehiclepass[0]['spot_license'];
	$requestton		=	$data_vehiclepass[0]['spot_ton'];
	$bookingroute	=	$data_vehiclepass[0]['spot_route'];
	$spotdriver_mobile	=	$data_vehiclepass[0]['spot_driver_mobile'];
	$spotbookingtype	=	$data_vehiclepass[0]['spot_booking_type'];
	$distance		=   $data_vehiclepass[0]['spot_distance'];
		$bankrefno=$data_vehiclepass[0]['transaction_refno'];
		$timetaken		= ($distance*3);
		//exit();
		if($spotbookingtype==2)

		{

			$typename='DOOR DELIVERY';

		}

		else

		{

			$typename='SPOT';

		}

	$passissuedate	=	date("d-m-Y H:i:s",strtotime(str_replace('-', '/',$data_vehiclepass[0]['pass_issue_timestamp'])));
	//$loadingplace	=	$data_vehiclepass[0]['lsg_zone_loading_place'];
	$unloadplace	=	$data_vehiclepass[0]['spot_unloading'];
	$printstatus	=   $data_vehiclepass[0]['spot_unloading'];
	$totamount		=	$data_vehiclepass[0]['transaction_amount'];
	$zone_id		=	$data_vehiclepass[0]['zone_id'];
		$zt_det=$this->db->query("select * from zone where zone_id='$zone_id'");
	$z_det=$zt_det->result_array();
	$z_name=$z_det[0]['zone_name'];
	$currentdate=date('d-m-Y H:i:s');
//	$msg="Dear customer your sand pass generated successfully. your balance sand quantity - ".$customerbalsand;
//	$this->sendSms($msg,$customerphone);
	//require_once('../libraries/tcpdf/tcpdf.php');
$this->db->query("UPDATE transaction_details SET pass_dstatus = 1, print_status=1 WHERE token_no= $bookingid");
$this->load->library('Newpdf');
ob_clean();
// create new PDF document
$pdf = new Newpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		
		
//$img_file = K_PATH_IMAGES.'/assets/temp/vehicle_passnew.png';
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

	$sample_data='Token Number :'.$tokenno.'Vehicle Number : '.$vehicleno.'Driver License No. : '.$driverlicense.'Quantity of Dredged Material(in Ton) : '.$requestton.'Loading Place :'.$z_name.'Unloading Place : '.$unloadplace.'Vehicle Pass Issued Date & Time : '.$passissuedate.',Date : '.$currentdate.'Duration of Pass ::'.$this->convertToHoursMins($timetaken, '%02d hours %02d mins').', Cost Of Sand : '. $totamount;

	//******************************************************************

	//$portid=$data_vehiclepass[0]['customer_booking_port_id'];
	//$zoneid=$data_vehiclepass[0]['customer_booking_zone_id'];
//----------------------------------------------------
		/*$alloteddate	=   $data_vehiclepass[0]['customer_booking_allotted_date'];
		$period_name=date("F Y", strtotime($alloteddate));
		$data_sandrate	= 	$this->Master_model->get_montly_permit_by_periodnew($period_name,$portid,$zoneid);
	 	$sandrate		=	$data_sandrate['sand_rate'];
	//$total_amt_includetax=$sandamt+$cleaningcharge+$royalty;
 	$tot_excludetax=(($sandrate * 100)/105); //break;
	$totaltax=$sandrate - $tot_excludetax;
	$cgst=($totaltax / 2);
		$sgst=($totaltax / 2);*/
	//----------------------------------------------------
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
	//$sandamt=0;$cleaningcharge=0;$royalty=0;$vehiclepass=0;
	//foreach($getpaymentdetails as $rowdata)
	//{
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
	}*/
//echo "kkkkk".$sandamt;
//}
	$a=$this->load->library('numbertowords');
 $total=$this->numbertowords->convert_number($totamount);
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
$pdf->write2DBarcode($sample_data, 'QRCODE,H', 15, 20, 50, 50, $style, 'N');

$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p><hr/>
<p>&nbsp;</p>
		<h4 style="text-align:center">VEHICLE PASS-'.$typename.'</h4>
		<table border="0" style="text-align:left;" width="100%">
		<thead style="font-weight:50">
		<tr>
		<th width="60%">1 Token Number</th>
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
		<th>4 Vehicle Number</th>
		<th>: '.$vehicleno.'</th>
		</tr>
	<tr>
		<th>5 Driver License No</th>
		<th>: '.$driverlicense.'</th>
		</tr>
	<tr>
		<th>6 Quantity of Dredged Material(in Ton)</th>
		<th>: '.$requestton	.'</th>
		</tr>
		<tr>
		<th>7 Loading Place</th>
		<th>: '.$z_name.'</th>
		</tr>
		<tr>
		<th>8 Unloading Place</th>
	<th>: '.$unloadplace.'</th>
		</tr>
		<tr>
		<th>9 Vehicle Pass Issued Date & Time</th>
		<th>: '.$passissuedate.'</th>
		</tr>
		<tr>
		<th>10 Driver Mobile No</th>
		<th>: '.$spotdriver_mobile.'</th>
		</tr>
<tr>

		<th>11 Route</th>

		<th>: '.$bookingroute.'</th>
		</tr>
		<tr>

		<th>12 Bank Reference No</th>

		<th>: '.$bankrefno.'</th>
		</tr>
		</thead>
		</table>
		<p style="margin-top:10px">Date :'.$currentdate.'</p>
		<p>Duration of Pass : '.$this->convertToHoursMins($timetaken, '%02d hours %02d minutes').'</p>

		<hr/>
		<p style="text-align:center;">BILL</p>
<table border="0" style="text-align:left;font-size:12px;" width="100%">
		<tbody>
	<tr>
		<td width="60%">Cost of Sand</td>
		<td width="40%">:'.$totamount.'</td>
		</tr>
		</tbody>
		</table>
	<hr/>
	<table class="tab2" border="0" style="text-align:left;width:100%;font-size:12px;">
		<tbody>
		<tr>
		<td width="60%"><b>Total Amount</b></td>
		<td width="40%"><b>: Rs '.$totamount.'</b>('.$total.')</td>
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
		<td width="60%" style="text-align:left;font-size:14px;">Place: </td>
		<td width="40%" style="text-align:left;font-size:14px;">Signature of Kadavu Supervisor</td>
	</tr>
		</tbody>
		</table>
		<p>Computer generated vehicle pass, www.portinfo.kerala.gov.in </p><br/>';
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
exit;
}
//-------------------------------------------------------------------------------------------------
	public function generatepass()

	{

		ini_set("memory_limit","256M");
		//$id 				= 	$this->uri->segment(3);
		$id			=		$this->uri->segment(4);
	    $bookingid 			= 	decode_url($id); 
	//$get_token=$this->db->query("select spot_token from tbl_spotbooking where spotreg_id='$bookingid'");
	//$g_tok=$get_token->result_array();
	//$token=$g_tok[0]['spot_token'];	
	$this->db->query("UPDATE transaction_details SET pass_dstatus = 1, print_status=1 WHERE token_no= $bookingid");
	$sess_usr_id 			= 	$this->session->userdata('int_userid');
	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
	$desgofsign			=	$userinfo[0]['user_master_fullname'];  
	//exit;
	$data_vehiclepass	= 	$this->Reports_model->vehiclepass_details_spot_pass($bookingid);
	//print_r($data_vehiclepass);
	$customername	=	$data_vehiclepass[0]['spot_cusname'];
	$customerphone	=	$data_vehiclepass[0]['spot_phone'];
	/*$customerbalsand	=	$data_vehiclepass[0]['customer_unused_ton'];
	$houseno		=	$data_vehiclepass[0]['customer_perm_house_number'];
	$housename		=	$data_vehiclepass[0]['customer_perm_house_name'];
	$houseplace		=	$data_vehiclepass[0]['customer_perm_house_place'];
	$lsgdename		=	$data_vehiclepass[0]['lsgd_name'];
	$lsgdaddress	=	$data_vehiclepass[0]['lsgd_address'];
	$lsgdphoneno	=	$data_vehiclepass[0]['lsgd_phone_number'];*/
	$tokenno		=	$data_vehiclepass[0]['spot_token'];
	//$permitno		=	$data_vehiclepass[0]['customer_permit_number'];
	$vehicleno		=	$data_vehiclepass[0]['spot_vehicleRegno'];
	$driverlicense	=	$data_vehiclepass[0]['spot_license'];
	$requestton		=	$data_vehiclepass[0]['spot_ton'];
	$bookingroute	=	$data_vehiclepass[0]['spot_route'];
	$spotdriver_mobile	=	$data_vehiclepass[0]['spot_driver_mobile'];
	$spotbookingtype	=	$data_vehiclepass[0]['spot_booking_type'];
	$distance		=   $data_vehiclepass[0]['spot_distance'];
		$bankrefno=$data_vehiclepass[0]['transaction_refno'];
		$timetaken		= ($distance*3);
		//exit();
		if($spotbookingtype==2)

		{

			$typename='DOOR DELIVERY';

		}

		else

		{

			$typename='SPOT';

		}

	$passissuedate	=	date("d-m-Y H:i:s",strtotime(str_replace('-', '/',$data_vehiclepass[0]['pass_issue_timestamp'])));
	//$loadingplace	=	$data_vehiclepass[0]['lsg_zone_loading_place'];
	$unloadplace	=	$data_vehiclepass[0]['spot_unloading'];
	$printstatus	=   $data_vehiclepass[0]['spot_unloading'];
	$totamount		=	$data_vehiclepass[0]['transaction_amount'];
	$zone_id		=	$data_vehiclepass[0]['zone_id'];
		$zt_det=$this->db->query("select * from zone where zone_id='$zone_id'");
	$z_det=$zt_det->result_array();
	$z_name=$z_det[0]['zone_name'];
	$currentdate=date('d-m-Y H:i:s');
//	$msg="Dear customer your sand pass generated successfully. your balance sand quantity - ".$customerbalsand;
//	$this->sendSms($msg,$customerphone);
	//require_once('../libraries/tcpdf/tcpdf.php');
$this->db->query("UPDATE transaction_details SET pass_dstatus = 1, print_status=1 WHERE token_no= $bookingid");
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

	$sample_data='Token Number :'.$tokenno.'Vehicle Number : '.$vehicleno.'Driver License No. : '.$driverlicense.'Quantity of Dredged Material(in Ton) : '.$requestton.'Loading Place :'.$z_name.'Unloading Place : '.$unloadplace.'Vehicle Pass Issued Date & Time : '.$passissuedate.',Date : '.$currentdate.'Duration of Pass ::'.$this->convertToHoursMins($timetaken, '%02d hours %02d mins').', Cost Of Sand : '. $totamount;

	//******************************************************************

	//$portid=$data_vehiclepass[0]['customer_booking_port_id'];
	//$zoneid=$data_vehiclepass[0]['customer_booking_zone_id'];
//----------------------------------------------------
		/*$alloteddate	=   $data_vehiclepass[0]['customer_booking_allotted_date'];
		$period_name=date("F Y", strtotime($alloteddate));
		$data_sandrate	= 	$this->Master_model->get_montly_permit_by_periodnew($period_name,$portid,$zoneid);
	 	$sandrate		=	$data_sandrate['sand_rate'];
	//$total_amt_includetax=$sandamt+$cleaningcharge+$royalty;
 	$tot_excludetax=(($sandrate * 100)/105); //break;
	$totaltax=$sandrate - $tot_excludetax;
	$cgst=($totaltax / 2);
		$sgst=($totaltax / 2);*/
	//----------------------------------------------------
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
	//$sandamt=0;$cleaningcharge=0;$royalty=0;$vehiclepass=0;
	//foreach($getpaymentdetails as $rowdata)
	//{
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
	}*/
//echo "kkkkk".$sandamt;
//}
	$a=$this->load->library('numbertowords');
 $total=$this->numbertowords->convert_number($totamount);
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
$pdf->write2DBarcode($sample_data, 'QRCODE,H', 15, 20, 50, 50, $style, 'N');

$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p><hr/>
<p>&nbsp;</p>
		<h4 style="text-align:center">VEHICLE PASS-'.$typename.'</h4>
		<table border="0" style="text-align:left;" width="100%">
		<thead style="font-weight:50">
		<tr>
		<th width="60%">1 Token Number</th>
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
		<th>4 Vehicle Number</th>
		<th>: '.$vehicleno.'</th>
		</tr>
	<tr>
		<th>5 Driver License No</th>
		<th>: '.$driverlicense.'</th>
		</tr>
	<tr>
		<th>6 Quantity of Dredged Material(in Ton)</th>
		<th>: '.$requestton	.'</th>
		</tr>
		<tr>
		<th>7 Loading Place</th>
		<th>: '.$z_name.'</th>
		</tr>
		<tr>
		<th>8 Unloading Place</th>
	<th>: '.$unloadplace.'</th>
		</tr>
		<tr>
		<th>9 Vehicle Pass Issued Date & Time</th>
		<th>: '.$passissuedate.'</th>
		</tr>
		<tr>
		<th>10 Driver Mobile No</th>
		<th>: '.$spotdriver_mobile.'</th>
		</tr>
<tr>

		<th>11 Route</th>

		<th>: '.$bookingroute.'</th>
		</tr>
		<tr>

		<th>12 Bank Reference No</th>

		<th>: '.$bankrefno.'</th>
		</tr>
		</thead>
		</table>
		<p style="margin-top:10px">Date :'.$currentdate.'</p>
		<p>Duration of Pass : '.$this->convertToHoursMins($timetaken, '%02d hours %02d minutes').'</p>

		<hr/>
		<p style="text-align:center;">BILL</p>
<table border="0" style="text-align:left;font-size:12px;" width="100%">
		<tbody>
	<tr>
		<td width="60%">Cost of Sand</td>
		<td width="40%">:'.$totamount.'</td>
		</tr>
		</tbody>
		</table>
	<hr/>
	<table class="tab2" border="0" style="text-align:left;width:100%;font-size:12px;">
		<tbody>
		<tr>
		<td width="60%"><b>Total Amount</b></td>
		<td width="40%"><b>: Rs '.$totamount.'</b>('.$total.')</td>
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
		<td width="60%" style="text-align:left;font-size:14px;">Place: </td>
		<td width="40%" style="text-align:left;font-size:14px;">Signature of Kadavu Supervisor</td>
	</tr>
		</tbody>
		</table>
		<p>Computer generated vehicle pass, www.portinfo.kerala.gov.in </p><br/>';
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
exit;
}
//-------------------------------------------------------------------------------------------------------
	public function add_kadavu_spot()

	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&&$sess_user_type==3)

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
			$res_data=$this->db->query("select * from zone where zone_port_id='$port_id'");
			$data['zone']=$res_data->result_array();
			$data 				= 	$data + $this->data;

			if($this->input->post())
			{
		$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));
		$data_in=array('port_id'=>$port_id,
						'zone_id'=>$zone_id,
						'user'=>$sess_usr_id

				);
				$this->db->insert('spot_kadavu',$data_in);
				redirect('Manual_dredging/Report/add_kadavu_spot');
			}
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/add_kadavu',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}
		else
		{
			redirect('Main_login/index');       
		}
	}
	public function spot_reg_details()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&&($sess_user_type==3 || $sess_user_type==9))
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
			$res_data=$this->db->query("select tbl_spotbooking.spotreg_id,tbl_spotbooking.spot_cusname,tbl_spotbooking.preferred_zone,tbl_spotbooking.spot_timestamp,tbl_spotbooking.spot_alloted,tbl_spotbooking.spot_unloading,tbl_spotbooking.spot_token,tbl_spotbooking.spot_phone,tbl_spotbooking.spot_ton,tbl_spotbooking.pass_isue_user,transaction_details.print_status,transaction_details.payment_status,transaction_details.zone_id,tbl_spotbooking.spot_booking_type,tbl_spotbooking.lorry_type from tbl_spotbooking join  transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where transaction_details.port_id='$port_id'  and transaction_details.transaction_status=1 and transaction_details.print_status=0  AND tbl_spotbooking.spot_alloted IS NULL ORDER BY `tbl_spotbooking`.`spot_timestamp` DESC LIMIT 0,250");
			$data['spot']=$res_data->result_array();
			$data 				= 	$data + $this->data;
			$spot_zone=$this->db->query("select * from zone join spot_kadavu on zone.zone_id=spot_kadavu.zone_id where zone.zone_port_id='$port_id'");
			$data['zone']=$spot_zone->result_array();
			$data 				= 	$data + $this->data;
			if($this->input->post())
			{
				//$ip_address=$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
                                    {
                                         $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
                                    }
                                    else 
                                     {
                                        $ip_address = $_SERVER["REMOTE_ADDR"];
                                      }
				$token_no=$this->security->xss_clean(html_escape($this->input->post('txt_token')));
				$txt_date=date("Y-m-d",strtotime(str_replace('/', '-',$this->input->post('txt_date'))));
				$zone_id=$this->security->xss_clean(html_escape($this->input->post('txt_zone')));
				$dtstamp=date('Y-m-d h:i:s');
				$rse=$this->db->query("select spot_ton,spot_phone from tbl_spotbooking where spot_token='$token_no'");
				$rrr=$rse->result_array();
				$req_ton=$rrr[0]['spot_ton'];
				$cus_phone=$rrr[0]['spot_phone'];

//*******************************************************************************

				$booking_type=$rrr[0]['spot_booking_type'];

				if($booking_type==1 || $booking_type==0 ){$type='Spot booking';}else if($booking_type==2){$type='Door delivery';}

			//--------------------------------------------------------------------------------

				$zdet=$this->db->query("select * from zone where zone_id='$zone_id'");
				$zone_namedet=$zdet->result_array();
				$buk_zone_name=$zone_namedet[0]["zone_name"];
				//----------------------------------------------------------------------------------
				$r_data=$this->db->query("select * from daily_log where daily_log_date='$txt_date' and daily_log_zone_id='$zone_id' and daily_log_balance >='$req_ton'");
			$rr=$r_data->result_array();
				if(count($rr)>0)

				{

					$this->db->trans_begin();
					$this->db->query("update daily_log set daily_log_balance=daily_log_balance-$req_ton,daily_log_used=daily_log_used+$req_ton,dailylog_spot=dailylog_spot+$req_ton where daily_log_date='$txt_date' and daily_log_zone_id='$zone_id'");

				$this->db->query("update tbl_spotbooking set spot_alloted='$txt_date',spot_user='$sess_usr_id',spot_altd_timestamp='$dtstamp',decision_ip_addr='$ip_address' where spot_token='$token_no'");
				$res_data=$this->db->query("update transaction_details set zone_id='$zone_id' where token_no='$token_no'");
					$this->db->query("INSERT INTO `tbl_spotalloted_datelog`(`spottoken`, `alloted_userid`, `alloted_datetimestamp`, `port_id`, `alloteduser_ip`) VALUES ('$token_no','$sess_usr_id','$dtstamp','$port_id','$ip_address')");

				//-------------------------------------------------------------------------------------------------------------------

				$mdadate=date("d/m/Y",strtotime(str_replace('-', '/',$txt_date)));

$msg="Dear Customer your ".$type." has been successfully approved and your Ref Token No is ".$token_no.".Sand issue Date ".$mdadate." & Kadavu - ".$buk_zone_name;
		//$msg="Dear Customer your Spot booking has been successfully approved and your Reference Token No is ".$token_no.".Sand issue Date ".$mdadate." and Kadavu - ".$buk_zone_name;


				$this->sendSms($msg,$cus_phone);
		//------------------------------------------------------------------------------------------
					$get_ud=$this->db->query("select uid_no from transaction_details where token_no='$token_no'");
					$get_uid=$get_ud->result_array();
					$uid_buk=$get_uid[0]['uid_no'];
					$chvaliddate=date('Y-m-d', strtotime($txt_date. ' + 3 day'));

					$data = array(
								"OPCODE"=>"CHALLANDATE",
            						"UID"=>$uid_buk,
            						"CHALLANDATE"=>$chvaliddate
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

					$resres=$myArray['RESPONSECODE'];

					//print_r($resres);

					$data_ins=array(
					'tokenno'=>$token_no,
					'response'=>$resres
					);
					$this->db->insert("tbl_chellan_validspot",$data_ins);

				//-----###################################################################	

				$this->db->trans_commit();

				if($res_data==1)

				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Approved Successfully</div>');

					redirect('Manual_dredging/Report/spot_reg_details');

				}

				else

				{


					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Failed, please try again!!!</div>');
					redirect('Manual_dredging/Report/spot_reg_details');

				}

				}


				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Low balance on selected date</div>');
					redirect('Manual_dredging/Report/spot_reg_details');

				}

			}


			//$zone=$this->Master_model->get_zone_acinP($port_id);


			//$data['zone']=$zone;

			//$this->output->enable_profiler(TRUE);

			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
		$this->load->view('Manual_dredging/Report/spot_reg_details',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');       
		}
		/*
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

			$res_data=$this->db->query("select * from tbl_spotbooking join  transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where transaction_details.port_id='$port_id' ORDER BY `tbl_spotbooking`.`spot_timestamp` DESC");
			$data['spot']=$res_data->result_array();
			$data 				= 	$data + $this->data;
		$spot_zone=$this->db->query("select * from zone join spot_kadavu on zone.zone_id=spot_kadavu.zone_id where zone.zone_port_id='$port_id'");
		$data['zone']=$spot_zone->result_array();
			$data 				= 	$data + $this->data;
			if($this->input->post())
			{
				$token_no=$this->input->post('txt_token');
				$txt_date=date("Y-m-d",strtotime(str_replace('/', '-',$this->input->post('txt_date'))));
			$zone_id=$this->input->post('txt_zone');
				$dtstamp=date('Y-m-d h:i:s');
				$rse=$this->db->query("select spot_ton from tbl_spotbooking where spot_token='$token_no'");
				$rrr=$rse->result_array();
				$req_ton=$rrr[0]['spot_ton'];
				$r_data=$this->db->query("select * from daily_log where daily_log_date='$txt_date' and daily_log_zone_id='$zone_id' and daily_log_balance >='$req_ton'");
				$rr=$r_data->result_array();
				if(count($rr)>0)

			{
					$this->db->trans_begin();
					$this->db->query("update daily_log set daily_log_balance=daily_log_balance-$req_ton,daily_log_used=daily_log_used+$req_ton where daily_log_date='$txt_date' and daily_log_zone_id='$zone_id'");
				$this->db->query("update tbl_spotbooking set spot_alloted='$txt_date',spot_user='$sess_usr_id',spot_altd_timestamp='$dtstamp' where spot_token='$token_no'");
				$res_data=$this->db->query("update transaction_details set zone_id='$zone_id' where token_no='$token_no'");
				$this->db->trans_commit();
				if($res_data==1)
				{
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Approved Successfully</div>');
					redirect('Report/spot_reg_details');
				}
				else
				{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Failed, please try again!!!</div>');
					redirect('Report/spot_reg_details');
				}
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Low balance on selected date</div>');
					redirect('Report/spot_reg_details');

				}
			}
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Report/spot_reg_details',$data);
			$this->load->view('template/footer');
			$this->load->view('template/js-footer');
			$this->load->view('template/script-footer');
			$this->load->view('template/html-footer');
		}
		else

		{


			redirect('Main_login/index');       

		}


		*/

	}

	public function assign_lorry()

	{

	$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
		{
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
		$port_id			=	$userinfo[$i]['user_master_port_id'];
		$zone_id			=	26;
		$p_name=$this->Master_model->get_port_By_PC($port_id);
		$port_name=$p_name[$i]['vchr_portoffice_name'];
		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
	$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$today=date('Y-m-d');
			$sata_buked			=	$this->db->query("select * from customer_booking where customer_booking_zone_id='$zone_id' and customer_booking_decission_status=2 and customer_booking_allotted_date >='$today'  order by customer_booking_priority_number asc");
			$data['sata_buked']=$sata_buked->result_array();
			$data 				= 	$data + $this->data;
			$periodname			=	date('F Y');
			$zone_dets=$this->Master_model->get_zone_detailsnew($port_id,$periodname);
		//print_r($zone_dets);
			$data['zone_dets']=$zone_dets;
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			if($this->input->post("btn"))
			{
			//exit;
				$no_lorry=$this->security->xss_clean(html_escape($this->input->post('no_lorry')));
				$altn_date=date("Y-m-d",strtotime(str_replace('/', '-',$this->input->post('date_alt'))));
				$zoneid=$this->security->xss_clean(html_escape($this->input->post('txt_zone')));
				$lsgiddet			=	$this->Master_model->get_zoneBycanID($zoneid);
				$lsg_id			=	$lsgiddet[0]['lsg_id'];
				$un_ass_buk=$this->db->query("select * from customer_booking where customer_booking_zone_id='$zoneid' and customer_booking_decission_status=2 and customer_booking_allotted_date ='$altn_date' and lorry_status=1  order by customer_booking_priority_number asc LIMIT 0,$no_lorry");	
				$un_lo_buk=$un_ass_buk->result_array();
				$selectedTime = "09:00:00 AM";
				foreach($un_lo_buk as $bu)
				{
					$alt_date=$bu['customer_booking_allotted_date'];
					$buk_id=$bu['customer_booking_id'];


					$cus_reg_id=$bu['customer_booking_registration_id'];

					$cus_det=$this->db->query("select customer_phone_number,customer_name from customer_registration where customer_registration_id='$cus_reg_id'");
					$c_det=$cus_det->result_array();
					$cus_phone=$c_det[0]['customer_phone_number'];
					$cus_name=$c_det[0]['customer_name'];
					$x_l=$this->db->query("select lorry_id from tbl_lorry where last_trip=(select MAX(last_trip) as x from tbl_lorry)-1 and lsg_id='$lsg_id'");
					$xx_ll=$x_l->result_array();
					if(count($xx_ll)>0)
					{

						$l_details=$this->db->query("select * from tbl_lorry where lsg_id='$lsg_id' and last_trip=(select MAX(last_trip) as x from tbl_lorry)-1 order by('lorry_id') asc LIMIT 0,1");
						$lorry=$l_details->result_array();
						$lorry_id=$lorry[0]['lorry_id'];
						$phone_no=$lorry[0]['contact_no'];
						$endTime = strtotime("+6 minutes", strtotime($selectedTime));
					    $al_time = date('h:i:s A', $endTime);
						$data_in=array('assign_lorry_bukid'=>$buk_id,
						'assign_lorry_lid'=>$lorry_id,
						'assign_lorry_date'=>$alt_date,
						'assign_lorry_time'=>$al_time,
						'assign_lorry_usr'=>$sess_usr_id
						);
						$chk_rep=$this->db->query("select * from assign_lorry where assign_lorry_lid=$lorry_id and assign_lorry_date='$alt_date'");
						$ck_ar=$chk_rep->result_array();
						if(count($ck_ar)>0)
						{
							break;

						}
						else
						{

							$this->db->trans_start();
							$this->db->query("update tbl_lorry set last_trip=last_trip+1 where lorry_id='$lorry_id'");
							$this->db->insert('assign_lorry',$data_in);
							$this->db->query("update customer_booking set lorry_status=2 where customer_booking_id='$buk_id'");
							$this->db->trans_complete();
							$selectedTime=$al_time;
							$msg="You have approved sand load in KSMDC ONE Kadavu,Azhikkal Port on $alt_date please contact customer on mobile no: $cus_phone -Portinfo 2.0";
							$this->sendSms($msg,$phone_no);
							$msg2="Your Azhikkal Port sand allotment date is $alt_date from KSMDC ONE Kadavu.please contact your assigned lorry driver on mobile no: $phone_no -Portinfo 2.0";
							$this->sendSms($msg2,$cus_phone);

						}

					}

				else

					{

						$l_details=$this->db->query("select * from tbl_lorry where lsg_id='$lsg_id' order by('lorry_id') asc LIMIT 0,1");
						$lorry=$l_details->result_array();
						$lorry_id=$lorry[0]['lorry_id'];
						$phone_no=$lorry[0]['contact_no'];
						$endTime = strtotime("+6 minutes", strtotime($selectedTime));
				    	$al_time = date('h:i:s A', $endTime);
						$data_in=array('assign_lorry_bukid'=>$buk_id,
						'assign_lorry_lid'=>$lorry_id,
						'assign_lorry_date'=>$alt_date,
						'assign_lorry_time'=>$al_time,
						'assign_lorry_usr'=>$sess_usr_id
						);
						$chk_rep=$this->db->query("select * from assign_lorry where assign_lorry_lid=$lorry_id and assign_lorry_date='$alt_date'");
						$ck_ar=$chk_rep->result_array();
					if(count($ck_ar)>0)

						{
							break;
						}
					else
						{
							$this->db->trans_start();
							$this->db->query("update tbl_lorry set last_trip=last_trip+1 where lorry_id='$lorry_id'");
							$this->db->insert('assign_lorry',$data_in);
						$this->db->query("update customer_booking set lorry_status=2 where customer_booking_id='$buk_id'");
							$this->db->trans_complete();
							$selectedTime=$al_time;
							$msg="You have approved sand load in KSMDC ONE Kadavu,Azhikkal Port on $alt_date please contact customer on mobile no: $cus_phone -Portinfo 2.0";
						$this->sendSms($msg,$phone_no);
							$msg2="Your Azhikkal Port sand allotment date is $alt_date from KSMDC ONE Kadavu.please contact your assigned lorry driver on mobile no: $phone_no -Portinfo 2.0";
							$this->sendSms($msg2,$cus_phone);
						}
					}
				}

	}

			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/assign_lorry',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');       
		}
	}

public function spot()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
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
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/spot_home',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

		else
		{
			redirect('Main_login/index');       
		}
	}

	/*public function add_spot_registration()


	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');

		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{

			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$i=0;
	$port_id			=	$userinfo[$i]['user_master_port_id'];
	$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 				= 	$data + $this->data;  
		 $data['po_id']=$port_id; 
	 $data 				= 	$data + $this->data; 
$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
	$data['user_header']=	$u_h_dat;

	$data 				= 	$data + $this->data;

	//$zone=$this->Master_model->get_zone_acinP($port_id);
	//$data['zone']=$zone;

	if($this->input->post())
		{
		$ip_address=$_SERVER['REMOTE_ADDR'];
		$txt_username=html_escape($this->input->post('txt_username'));
		$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
		$txt_phone=html_escape($this->input->post('txt_phone'));
	$txt_ton=html_escape($this->input->post('txt_ton'));
		$txt_place=html_escape($this->input->post('txt_place'));
	$txt_route=html_escape($this->input->post('txt_route'));
	$txt_distance=html_escape($this->input->post('txt_distance'));
	$period=date('F Y');
		$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
	$et_amount=$getrate_port->result_array();
$sand_amount=$et_amount[0]["s_amount"];
	$challan_amount=ceil($txt_ton*$sand_amount)+220+40;
	$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
	$data_in=array(
	'spot_cusname'=>$txt_username,
	'spot_adhaar'=>$txt_adhaar,
	'spot_phone'=>$txt_phone,
	'spot_ton'=>$txt_ton,
	'spot_unloading'=>$txt_place,
	'spot_route'=>$txt_route,
		'spot_distance'=>$txt_distance,
	'spot_challan'=>$challan_no,
	'spot_amount'=>$challan_amount,
	'spot_user'=>$sess_usr_id,
	'spotbooking_ip_addr'=>$ip_address,
	);
			$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
		//print_r($getpdtaa);
		$p_code=$getpdtaa[$i]['intport_code'];
		//echo $p_code;
		//exit;
		$this->db->trans_begin();
		$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
		$buk_id=$this->db->insert_id();
		$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
		//echo $tok_no;
		//exit;
	$gt_ch=$this->db->query("select * from customer_booking where customer_booking_token_number='$tok_no'");
	$no=$gt_ch->num_rows();
		if($no==0)
		{
		$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
					$data = array("OPCODE"=>"GETUID",
								"TOKENNO"=>"$tok_no",
						"PORTCODE"=>"$p_code",
					"INSTCODE"=>"DOP",
						"CHALLANAMOUNT"=>"$challan_amount",
						);                                                                    
			$data_string = json_encode($data);   
			//echo $data_string;                                                                                  $ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');           					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                     
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
								'Content-Type: application/json',                                                                    
									'Content-Length: ' . strlen($data_string))                                                                       

								);                                                                                                                     

								$result = curl_exec($ch);
								$myArray=json_decode($result, true);
					//print_r($myArray);
					//exit;
					$uid=$myArray['UID'];
					$ifsc=$myArray['IFSC'];
				if($uid=="")
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
				redirect('Report/spot_registration');
			}
				else
			{
					$currentdate			=	date('Y-m-d H:i:s');
				$data_trans=array(
									'transaction_customer_registration_id'=>000,
				'transaction_customer_booking_id'=>000,
							'token_no'=>$tok_no,
							'challan_no'=>$challan_no,
					'challan_amount'=>$challan_amount,
					'uid_no'=>$uid,
			'ifsc_code'=>$ifsc,
'challan_timestamp'=>$currentdate,
							'booking_timestamp'=>$currentdate,
								'zone_id'=>000,
						'port_id'=>$port_id,
				);
$this->db->insert('transaction_details',$data_trans);
					$this->db->trans_commit();
					redirect('Report/spot_registration');
								}

				}

				else

				{


					 $this->db->trans_rollback();
					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete registration!!!</div>');
					 redirect('Report/spot_registration');

				}

			}

			$this->load->view('template/header',$data);

			$this->load->view('Report/spot_registration',$data);

			$this->load->view('template/footer');
			$this->load->view('template/js-footer');
			$this->load->view('template/script-footer');
			$this->load->view('template/html-footer');

		}
	else

		{

			redirect('Main_login/index');       
		}

	}*/

	public function spot_registration()

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
		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
		$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;

			$data_g=$this->db->query("select tbl_spotbooking.spotreg_id,tbl_spotbooking.spot_cusname,tbl_spotbooking.spot_token,spot_alloted,tbl_spotbooking.spot_phone,tbl_spotbooking.spot_ton,tbl_spotbooking.spot_timestamp,tbl_spotbooking.pass_isue_user,transaction_details.transaction_status from tbl_spotbooking join transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where transaction_details.port_id='$port_id' and transaction_details.print_status=0 and transaction_details.pass_dstatus=2 ORDER BY `tbl_spotbooking`.`spot_timestamp` DESC limit 10");

			$buk_spot			=	$data_g->result_array();

			$data['buk_data']	=	$buk_spot;
			$data 				= 	$data + $this->data;
 //print_r($data);//exit;
		//	$this->output->enable_profiler(TRUE);
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/spot',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

		else
		{
			redirect('Main_login/index');       
		}

	/*	$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
		$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$data_g=$this->db->query("select * from tbl_spotbooking join transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where transaction_details.port_id='$port_id' ORDER BY `tbl_spotbooking`.`spot_timestamp` DESC");
			$buk_spot			=	$data_g->result_array();
			$data['buk_data']	=	$buk_spot;
			$data 				= 	$data + $this->data;
			$this->load->view('template/header',$data);
			$this->load->view('Report/spot',$data);
			$this->load->view('template/footer');
			$this->load->view('template/js-footer');
			$this->load->view('template/script-footer');
			$this->load->view('template/html-footer');

		}

		else
		{
			redirect('Main_login/index');       
		}
		*/

	}
	public function reg_lorry()
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
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$res_data=$this->db->query("select * from tbl_lorry where port_id='$port_id' and zone_id='$zone_id'");
			$data['lorry']=$res_data->result_array();
			$data 				= 	$data + $this->data;
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/lorry_details',$data);
			$this->load->view('Kiv_views/template/dash-footer');
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

	public function lorry_reg()
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
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$lsg_id=$u_h_dat[0]['user_master_lsg_id'];
			$data['zone_id']=$zone_id;
			$data 				= 	$data + $this->data;
			if($this->input->post())
			{

				$lorry_reg=$this->security->xss_clean(html_escape($this->input->post('lorry_reg')));
				$lorry_make=$this->security->xss_clean(html_escape($this->input->post('lorry_make')));
				$owner_name=$this->security->xss_clean(html_escape($this->input->post('owner_name')));
				$owner_adno=$this->security->xss_clean(html_escape($this->input->post('owner_adno')));
				$contct_no=$this->security->xss_clean(html_escape($this->input->post('contct_no')));
				$lorry_cap=$this->security->xss_clean(html_escape($this->input->post('lorry_cap')));
				$driver_name=$this->security->xss_clean(html_escape($this->input->post('driver_name')));
				$driver_license=$this->security->xss_clean(html_escape($this->input->post('driver_license')));
				$driver_mobile=$this->security->xss_clean(html_escape($this->input->post('driver_mobile')));
				$lorry_reg = str_replace(' ', '-', $lorry_reg); // Replaces all spaces with hyphens.
    			$lorry_reg=preg_replace('/[^A-Za-z0-9\-]/', '', $lorry_reg);
				$fname=$_FILES["lorry_rc"]["name"];
				$extension =explode(".", $fname);
				$ext=$extension[1];
				if($ext=="jpg"||$ext=="pdf"||$ext=="jpeg"||$ext=="png")
				{

					if($_FILES["lorry_rc"]["tmp_name"]<771568)
					{
					$t_name=uniqid().".".$ext;
						copy($_FILES["lorry_rc"]["tmp_name"],'./upload/'.$t_name);
					}
					else
					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed file size 500Kb</div>');
						redirect('Manual_dredging/Report/lorry_reg');


					}


				}


				$data_in=array(
				'lorry_reg_no'=>$lorry_reg,
				'lorry_make'=>$lorry_make,
				'owner_name'=>$owner_name,
				'owner_adhaar'=>$owner_adno,
				'contact_no'=>$contct_no,
				'driver_name'=>$driver_name,
				'driver_license'=>$driver_license,
				'contact_no'=>$driver_mobile,
				'lorry_cap'=>$lorry_cap,
				'rc_name'=>$t_name,
				'port_id'=>$port_id,
				'zone_id'=>$zone_id,
				'lsg_id'=>$lsg_id
				);
				$res=$this->db->insert('tbl_lorry',$data_in);
				if($res==1)
				{	
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Registration Completed</div>');
					redirect('Manual_dredging/Report/reg_lorry');

				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Registration Failed</div>');
					redirect('Manual_dredging/Report/reg_lorry');
				}
			}
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/lorry_registration',$data);
			$this->load->view('Kiv_views/template/dash-footer');
			
		}
		else
		{
		redirect('Main_login/index');       
		}
	}

	public function report()
	{
		//ini_set('display_errors', 1);
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==2 || $sess_user_type==3 || $sess_user_type==9))

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
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/reports_home',$data);
			$this->load->view('Kiv_views/template/dash-footer');
			

		}
		else
		{
			redirect('Main_login/index');       
		}

	}

	public function sale_report()
	{
		//ini_set('display_errors', 1);
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
			$zone=$this->Master_model->get_zone_acinP($port_id);
			$data 				= 	$data + $this->data;
			$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/gensalereport',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');       
		}
	}
	public function gen_salereport()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))
		{
                    $this->load->model('Manual_dredging/Reports_model');
			$zone_id=$this->security->xss_clean($this->input->post('zone'));
			$from=$this->security->xss_clean($this->input->post('fromd'));
			$from=date("Y-m-d",strtotime(str_replace('/', '-',$from)));
			$to=$this->security->xss_clean($this->input->post('tod'));
			$to=date("Y-m-d",strtotime(str_replace('/', '-',$to)));
			$sale_rep=$this->Reports_model->gensalereport($zone_id,$from,$to);
			$data['sale_report']=$sale_rep;
			$data 				= 	$data + $this->data;
			$data['zone_id']=$zone_id;
			$data 				= 	$data + $this->data;
			$data['from_d']=$from;
			$data 				= 	$data + $this->data;
			$data['to_d']=$to;
			$data 				= 	$data + $this->data;
			$this->load->view('Manual_dredging/Report/gensale_ajax',$data);
		}
	}



//-----------------------------------------------------------------------------------------------------

	public function gen_salereportzone()

	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
		{
            $this->load->model('Manual_dredging/Master_model');
            $this->load->model('Manual_dredging/Reports_model');
			$currentdate			=	date('Y-m-d');
		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
			//$zone_id=$this->security->xss_clean($this->input->post('zone'));
			//$from=$this->security->xss_clean($this->input->post('fromd'));
			//$from=date("Y-m-d",strtotime(str_replace('/', '-',$from)));
	//$to=$this->security->xss_clean($this->input->post('tod'));
			//$to=date("Y-m-d",strtotime(str_replace('/', '-',$to)));
			$sale_rep=$this->Reports_model->gensalereport($zone_id,$currentdate,$currentdate);
			$data['sale_report']=$sale_rep;
			$data 				= 	$data + $this->data;
			$data['zone_id']=$zone_id;
			$data 				= 	$data + $this->data;
			$data['from_d']=$currentdate;
			$data 				= 	$data + $this->data;
			$data['to_d']=$currentdate;
		$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/salereportzone',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
	}

//-------------------------------------------------------------------------------------------------
	public function sale_report_zone()

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
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$zone_id=$userinfo[0]['user_master_zone_id'];

			$zone=$this->db->query("select * from zone where zone_id='$zone_id'");
		$data['zone']=$zone->result_array();
		//$this->load->view('template/header',$data);
		$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
		$this->load->view('Manual_dredging/Report/gensalereport_zone',$data);

			$this->load->view('Kiv_views/template/dash-footer');

		}
		else
		{
			redirect('Main_login/index');       
		}

	}

	public function cancelbooking()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==5)
		{
			//$buk_id=decode_url($this->uri->segment(3));
			$buk_id			=		decode_url($this->uri->segment(4));
			$res=$this->db->query("update customer_booking set customer_booking_decission_status=5 where customer_booking_id='$buk_id'");
			if($res==1)
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Booking Canceled</div>');
													redirect('Master/customer_booking_history');
			}

			else

			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Booking Cancelation Failed</div>');

													redirect('Master/customer_booking_history');

			}

		}

	}


	public function zone_stat()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==5)
		{
                    $this->load->model('Manual_dredging/Master_model');
                    $this->load->model('Manual_dredging/Reports_model');
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
			$zone_stat=$this->Reports_model->get_portzonestatus();
			$data['zone_stat']=$zone_stat;
			$data 				= 	$data + $this->data;
			$za=array('');
			foreach($zone_stat as $zs)
			{
				$myzone_id=$zs['zone_id'];
				$res=$this->db->query("select MAX(customer_booking_priority_number) as maxpro from customer_booking where customer_booking_pass_issue_user!=0 and customer_booking_zone_id='$myzone_id'");
				$zone_last=$res->result_array();
				$zone_lastp=$zone_last[0]['maxpro'];
				$za[$myzone_id]=$zone_lastp;
			}
			$data['zas']=$za;
			//print_r($za);
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/zone_stat',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');       
		}

	}
	public function change_zone()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
			//$zone_id=$this->security->xss_clean($this->input->post('zone'));
			//$from=$this->security->xss_clean($this->input->post('fromd'));
			//$from=date("Y-m-d",strtotime(str_replace('/', '-',$from)));
			//$to=$this->security->xss_clean($this->input->post('tod'));
			//$to=date("Y-m-d",strtotime(str_replace('/', '-',$to)));
			//$sale_rep=$this->Reports_model->gensalereport($zone_id,$from);
			//$data['sale_report']=$sale_rep;
			//$data 				= 	$data + $this->data
                    $this->load->model('Manual_dredging/Master_model');
                    $this->load->model('Manual_dredging/Reports_model');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			if($this->input->post())
			{
				$fromzone=$this->input->post('int_frm');
				$tozone=$this->input->post('int_to');
				$get_to_move_data=$this->Reports_model->get_change_booking($fromzone);
				if(empty($get_to_move_data))
				{

					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">No data to move</div>');
					redirect('Manual_dredging/Report/change_zone');
			}
				else
				{
					foreach($get_to_move_data as $gmd)
					{
					$cus_buk_id=$gmd['customer_booking_id'];
					$old_zone=$gmd['customer_booking_zone_id'];
					$new_zone=$tozone;
					$this->db->trans_start();
					$this->db->query("update customer_booking set customer_booking_zone_id='$new_zone' where customer_booking_id='$cus_buk_id'");
					$this->db->query("update transaction_details set zone_id='$new_zone' where transaction_customer_booking_id='$cus_buk_id'");
						$data_ins=array('change_bookig_bukid'=>$cus_buk_id,
						'change_bookig_oldzone'=>$old_zone,
						'change_bookig_newzone'=>$new_zone,
						'change_booking_user'=>$sess_usr_id
						);
						$this->db->insert('tbl_change_booking',$data_ins);
						$this->db->trans_complete();
				}
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Booking moved Successfully</div>');
					redirect('Manual_dredging/Report/change_zone');
				}
			}
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/change_zone');
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');        
		}
	}

public function user_notice()
	{
		$sess_usr_id 			= $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
                    $this->load->model('Manual_dredging/Master_model');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];
			$curdate=date('Y-m-d');
		//	$curdate='2019-01-01';
			$data_date=$this->db->query("SELECT `daily_log_date` FROM `daily_log` where `daily_log_date` >= '$curdate' limit 5");
			$data['date_det']=$data_date->result_array();
			$data 				= 	$data + $this->data;
			$data_zone=$this->db->query("SELECT * FROM zone where zone_port_id='$port_id'");
			$data['date_zone']=$data_zone->result_array();
			$data 				= 	$data + $this->data;
			if($this->input->post())
			{
			$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_int')));
			$date=$this->input->post('date_int');
			$msg=$this->security->xss_clean(html_escape($this->input->post('msg')));
			$chkd_no=$this->security->xss_clean(html_escape($this->input->post('text_mob'))); 
			if(empty($chkd_no))
			{
				$get_buk_phone=$this->db->query("select customer_registration.customer_phone_number from customer_registration join customer_booking on customer_registration.customer_registration_id=customer_booking.customer_booking_registration_id where customer_booking.customer_booking_allotted_date='$date' and customer_booking.customer_booking_zone_id='$zone_id'");
				$data_user=$get_buk_phone->result_array();
				foreach($data_user as $sd)
				{
					$user_phone=$sd['customer_phone_number'];
					$this->sendSms($msg,$user_phone);
				}
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Message Send Successfully</div>');
				redirect("Manual_dredging/Report/user_notice");
			}
			else
			{
			foreach($chkd_no as $c_no)
				{
					$this->sendSms($msg,$c_no);
				}
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Message Send Successfully</div>');
				redirect("Manual_dredging/Report/user_notice");
			}
			}
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/user_notice',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');        
		}
	}
	public function sendSms($message,$number){

		

		$link = curl_init();

		curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");

		curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($link , CURLOPT_HEADER, 0);
		
		return $output = curl_exec($link);

		curl_close($link );

}

public function sendSmsotp($message,$number)
	{
	$link = curl_init();
	curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsmsotp&password=Port@123&message=".$message."&numbers=".$number."&senderid=PORTDR");
		curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($link , CURLOPT_HEADER, 0);
		return $output = curl_exec($link);
		curl_close($link );
	}
	public function send_flash()
	{
	$sess_usr_id 			=  $this->session->userdata('int_userid');
	$sess_user_type			=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&& $sess_user_type==3)
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
			if($this->input->post())
			{
				$txt_flash=html_escape($this->input->post('txt_flash'));
				$txt_from=html_escape($this->input->post('txt_from'));
				$txt_to=html_escape($this->input->post('txt_to'));
				$data_in=array('news'=>$txt_flash,
							  'news_from'=>date("Y-m-d",strtotime(str_replace('/', '-',$txt_from))),
							   'news_to'=>date("Y-m-d",strtotime(str_replace('/', '-',$txt_to))),
							   'user_id'=>$sess_usr_id
							  );
				$res=$this->db->insert('tbl_flash',$data_in);
				if($res==1)
				{
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Flash Message Added Successfully</div>');
					redirect('Manual_dredging/Report/send_flash');

				}
				else
				{

				}
			}
			//$this->load->view('template/header',$data
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/send_flash',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');        
		}
	}
	public function change_phone_no()
	{
		$sess_usr_id 			= $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))
		{
                    $this->load->model('Manual_dredging/Master_model');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];
			if($this->input->post())
			{
				$user_name=html_escape($this->input->post('txt_userid'));
				$adhar=html_escape($this->input->post('txt_adhaar'));
				$new_phone=html_escape($this->input->post('txt_phone'));
				$get_user_det=$this->db->query("select customer_registration.customer_registration_id,customer_registration.customer_phone_number from customer_registration join user_master on customer_registration.customer_public_user_id=user_master.user_master_id where customer_registration.customer_request_status!=3 and customer_registration.customer_aadhar_number='$adhar' and user_master.user_master_name='$user_name'");
				$res_data=$get_user_det->result_array();
				if(!empty($res_data))
				{
					$cus_reg_id=$res_data[0]['customer_registration_id'];
					$cus_old_phone=$res_data[0]['customer_phone_number'];
					//$u_ip=$_SERVER['REMOTE_ADDR'];
					if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $u_ip = $_SERVER["REMOTE_ADDR"];
}
					//$msg="Dear Portinfo 2 user your mobile number has been updated to $new_phone, please contact port office if change was not made on your request";
					$msg="Dear Portinfo 2 user your mobile number has been updated to $new_phone, please contact port office if change was not made on your request";
					$get_res=$this->db->query("update customer_registration set customer_phone_number='$new_phone' where customer_registration_id='$cus_reg_id'");
					$data_in=array(
					'cus_reg_id'=>$cus_reg_id,
					'cus_old_phone'=>$cus_old_phone,
					'user_id'=>$sess_usr_id,
					'user_ip'=>$u_ip
					);
					$this->db->insert('tbl_phone_change',$data_in);
					$this->sendSms($msg,$new_phone);
					$this->sendSms($msg,$cus_old_phone);
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Phone Number Changed Successfully</div>');
					redirect("Manual_dredging/Report/change_phone_no");
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Entered details not correct</div>');
					redirect("Manual_dredging/Report/change_phone_no");
			}
			}
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/change_phone',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');        
		}
	}
	function gen_report()
	{
	//	echo $this->load->view('Master/undermain');
	//$zid 				= 	$this->uri->segment(3);
	$zid			=		$this->uri->segment(4);
	$zoneid 			= 	decode_url($zid);
	$fd					=	$this->uri->segment(5); 
	$from			= 	decode_url($fd);
	$tod					=	$this->uri->segment(6); 
	$to			= 	decode_url($tod);
	$this->db->select('*');
    $this->db->from('customer_booking');
	$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');
	$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');
	$this->db->where('customer_booking.customer_booking_allotted_date >=',$from);
	$this->db->where('customer_booking.customer_booking_allotted_date <=',$to);
	$this->db->where('transaction_details.print_status',1);
	$this->db->where('customer_booking.customer_booking_zone_id',$zoneid);
	$query = $this->db->get();
    $sale_report = $query->result_array();	
		$zdet=$this->db->query("select * from zone where zone_id='$zoneid'");
				$zone_namedet=$zdet->result_array();
				$buk_zone_name=$zone_namedet[0]["zone_name"];
//	print_r($sale_report);
//require_once('../libraries/tcpdf/tcpdf.php');
$this->load->library('Pdf');
ob_clean();
// create new PDF document
//ini_set('memory_limit', '-1');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.
// set font
$pdf->SetFont('helvetica', '', 11);
// add a page
$pdf->AddPage();
// print a message
//$txt = "You can also export 2D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcode directory.\n";
//$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
$pdf->SetFont('helvetica', '', 10);
$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p>
<table align="center"><tr><td><img height="75" width="75"  src="'.getcwd().'/assets/images/port-logo-wheel.png"/></td></tr>
<tr><td><h3>APPENDIX -F</h3></td></tr>
<tr><td><h4>Daily Dredged Sale Register With Abstract from '.date("d/m/Y",strtotime(str_replace('-', '/',$from))).' to '.date("d/m/Y",strtotime(str_replace('-', '/',$to))).'</h4></td></tr>
</table>
<center>
<h4>Zone :- '.$buk_zone_name.'</h4>
</center>
<table cellspacing="1" cellpadding="2" border="1" >
         <tr>
        <th>Total Quantity</th>
      <th>Total Sale Price</th>
        <th>Total GST Vehicle</th>
                </tr>';
				 $id=1; 
				 $totton=0;
				 $totamount=0;
				$totgst=0;
				 foreach($sale_report as $sp)
				 {
					 $totton=$totton+$sp['customer_booking_request_ton'];
					 $totamount=$totamount+$sp['transaction_amount'];
		 if($sp['customer_booking_requested_timestamp']>='2018-07-01 00:00:00'){$totgst+=40;}else{$totgst+=0;}  
			 					 //$id = $rowmodule['police_case_id'];
					$id++; 

				}
		 $html=$html.'<tr>
    <td>'.$totton.'</td>
    <td>'.$totamount.'</td>
    <td>'.$totgst.'</td>
					</tr></table>';

	

		//==============================================================

		//print_r($html);
		//echo $html;
		//$htmla='<table><tr><td>hari</td></tr></table>';
$pdf->writeHTML($html, true, false, false, false, '');
//ob_end_clean();
$pdf->Output('salerport.pdf', 'D');
exit;
}
	function testapass()
	{
	
$this->load->library('Pdf');

ob_clean();
// create new PDF document

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
$pdf->SetFont('courier', '', 10);
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	$sample_data='abcd';
	//******************************************************************

/*	$portid=$data_vehiclepass[0]['customer_booking_port_id'];
	$zoneid=$data_vehiclepass[0]['customer_booking_zone_id'];
	if($portid==10)
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
	}
	$getpaymentdetails=$this->Master_model->get_paymentdetails($bookingid,$portid,$zoneid);
	$sandamt=0;$cleaningcharge=0;$royalty=0;$vehiclepass=0;
	foreach($getpaymentdetails as $rowdata)
	{
	//echo "aaaa--".$i=$rowdata['payment_head'];
	if($rowdata['payment_head']==1 ||$rowdata['payment_head']==2 ||$rowdata['payment_head']==3)
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
	$a=$this->load->library('numbertowords');
 $total=$this->numbertowords->convert_number(12000);
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
$pdf->write2DBarcode($sample_data, 'QRCODE,H', 15, 20, 50, 50, $style, 'N');
//$img = file_get_contents('http://portinfo.kerala.gov.in/assets/images/ship.png');
//$img = getcwd().'/assets/images/ship.png';
//$pdf->Image('@' . $img);
//$pdf->Image($img,55, 20, 50, 50);
$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p><hr/>
<p>&nbsp;</p>
		<h4 style="text-align:center">VEHICLE PASS</h4>
		<table border="0" style="text-align:left;" width="100%">
		<thead style="font-weight:50">
		<tr>
		<th width="60%">1 Token Number</th>
		<th width="40%">:8959 </th>
		</tr>
		<tr>
		<th>2 Customer name</th>
		<th>: 6233</th>
		</tr>
		<tr>
		<th>3 Customer Phone</th>
		<th>: 95966</th>
		</tr>
		<tr>
		<th>4 House No</th>
		<th>: 2323232</th>
		</tr>
		<tr>
	<th>5 House Name</th>
		<th>: 959559</th>
		</tr>
	<tr>
	<th>6 Place</th>
	<th>: 8989</th>
	</tr>
		<tr>

		<th>7  LSGD Name,Address and Phone No</th>
		<th>: 87878,54545,
		798989</th>
		</tr>
		<tr>
		<th>8 Vehicle Number</th>
		<th>:7998898</th>
		</tr>
		<tr>
		<th>9 Driver License No</th>
		<th>: 454545</th>
		</tr>
		<tr>
		<th>10 Quantity of Dredged Material(in Ton)</th>
	<th>: 5454</th>
		</tr>
		<tr>
	<th>11 Loading Place</th>
		<th>: 1212</th>
	</tr>
		<tr>
		<th>12 Unloading Place</th>
		<th>:1212</th>

		</tr>
		<tr>
		<th>13 Vehicle Pass Issued Date & Time</th>

	<th>: 1212</th>

		</tr>
		</thead>
		</table>
		<p style="margin-top:10px">Date :1212</p>
		<p>Duration of Pass : 01 Hours and 00 mins</p>
		<hr/>
		<p style="text-align:center;">BILL</p>
		<table border="0" style="text-align:left;font-size:12px;" width="100%">
		<tbody>
		<tr>
		<td width="60%">Royalty / ton</td>
		<td width="40%">:40</td>
		</tr>
		<tr>
		<td width="60%">Sand Amount / Ton</td>
		<td width="40%">:1000</td>
		</tr>
		<tr>
		<td width="60%">Vehicle Pass</td>
		<td width="40%">:220</td>
		</tr>
	</tbody>
		</table>
		<hr/>
		<table class="tab2" border="0" style="text-align:left;width:100%;font-size:12px;">
		<tbody>
		<tr>
		<td width="60%"><b>Total Amount</b></td>
		<td width="40%"><b>: Rs 1000</b>(10000)</td>
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
		<td width="60%" style="text-align:left;font-size:14px;">Place: </td>
		<td width="40%" style="text-align:left;font-size:14px;">Signature of Kadavu Supervisor</td>
		</tr>
		</tbody>
		</table>
		<p>Computer generated vehicle pass, downloaded from www.portinfo.kerala.gov.in </p><br/>';
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
exit;
	}
	public function view_customer_info()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))
		{
$this->load->model('Manual_dredging/Master_model');
			//$usr_id=decode_url($this->uri->segment(3));
			$usr_id			=		decode_url($this->uri->segment(4));
			$i=0;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			$customerreg_booking= $this->Master_model->get_cus_buk_his($usr_id);
			$data['cust_book_his']=$customerreg_booking;
			$data = $data + $this->data;
			$cus_bal=$this->db->query("select * from customer_registration where customer_public_user_id='$usr_id'");
			$cust_bal=$cus_bal->result_array();
			$data['cus_bal']=$cust_bal;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/customer_booking_his',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
			redirect('Main_login/index');        
		}
	}
	public function get_alt_cus()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
$this->load->model('Manual_dredging/Master_model');
			$zone_id=$this->security->xss_clean($this->input->post('zone'));
			$from=$this->security->xss_clean($this->input->post('fromd'));
			$get_buk_phone=$this->db->query("select customer_registration.customer_phone_number,customer_registration.customer_name from customer_registration join customer_booking on customer_registration.customer_registration_id=customer_booking.customer_booking_registration_id where customer_booking.customer_booking_allotted_date='$from' and customer_booking.customer_booking_zone_id='$zone_id'");
			$data_user=$get_buk_phone->result_array();
			$data['buk_data']=$data_user;
			$this->load->view('Manual_dredging/Report/cus_det',$data);
		}
		else

		{

			redirect('Main_login/index');        
		}
	}
	public function get_zone_allot()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))
		{
                    $this->load->model('Manual_dredging/Master_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];
			$periodname			=	date('F Y');
			$zone_det=$this->Master_model->get_zone_detailsnew($port_id,$periodname);
			$data['zone_det']=$zone_det;
			$data 				= 	$data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/get_zone_allotment', $data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
	   	{
			redirect('Main_login/index');        
  		} 
	}
	public function get_zone_allot_ajax()
	{

		$sess_usr_id 			=  $this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{
                    $this->load->model('Manual_dredging/Master_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];
			$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone')));
			$t_sand=$this->Master_model->get_today_pass_pc($port_id,$zone_id);
			//print_r($t_sand);
			$data['t_sandpass']=$t_sand;
			$data 				= 	$data + $this->data;
			$this->load->view('Manual_dredging/Report/today_sand_pass', $data);
		}
	}
	public function customerregistration_dtview()
    {
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	
			//$id			=		$this->uri->segment(3);
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
			$this->load->view('Manual_dredging/Report/customerregistration_details', $data);
			$this->load->view('Kiv_views/template/dash-footer');

	   	}
	   	else
	   	{

			redirect('Main_login/index');        

  		}  

    }

	public function customerregistration_view()
	{

		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	

			$cus_d=$this->db->query("select customer_registration_id,customer_reg_no from customer_registration where customer_public_user_id='$sess_usr_id'");
			$c_d=$cus_d->result_array();
			//$purpose_id			=		decode_url($this->uri->segment(3));
			$purpose_id			=		decode_url($this->uri->segment(4));
			$id					=		$c_d[0]['customer_registration_id'];
			$c_reg_no			=		$c_d[0]['customer_reg_no'];
			$this->load->model('Manual_dredging/Master_model');	
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;    
			$data['purpose_id']	=		$purpose_id;
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
				//$copname=$_FILES["file"]["userfile"];
			//$t_name=$c_reg_no."_New_per.jpg";
			$fname=$c_reg_no."permit";
				$up_name=$fname.".pdf";
				if($this->input->post('customer_purpose')==1)
				{
					$customer_plinth_area=$this->input->post('customer_plinth_area');
					//exit;
				}
				else
				{
					$customer_plinth_area=0;
				}
				$data_in=array(
				'customer_name'=>$this->security->xss_clean(html_escape($this->input->post('txt_cusname'))),
				'customer_work_house_name'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_house_name'))),
				'work_house_number'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_house_number'))),
			   'customer_work_house_place'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_place'))),
			   'customer_work_post_office'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_post_office'))),
				'customer_work_pin_code'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_pin_code'))),
				'customer_work_district_id'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_district_id'))),
				'customer_work_lsg_id'=>$this->security->xss_clean(html_escape($this->input->post('customer_perm_lsg_id'))),
				'customer_purpose'=>$this->security->xss_clean(html_escape($this->input->post('customer_purpose'))),
				'customer_plinth_area'=>$customer_plinth_area,
				'customer_requested_ton'=>$this->security->xss_clean(html_escape($this->input->post('customer_max_allotted_ton'))),
			    'customer_max_allotted_ton'=>$this->security->xss_clean(html_escape($this->input->post('customer_max_allotted_ton'))),
				'customer_permit_number'=>$this->security->xss_clean(html_escape($this->input->post('customer_permit_number'))),
				'customer_permit_date'=>date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('customer_permit_date')))),
				'customer_permit_authority'=>$this->security->xss_clean(html_escape($this->input->post('customer_permit_authority'))),
				'customer_worksite_route'=>$this->security->xss_clean(html_escape($this->input->post('customer_worksite_route'))),
				'customer_worksite_distance'=>$this->security->xss_clean(html_escape($this->input->post('customer_worksite_distance'))),
				'customer_unloading_place'=>$this->security->xss_clean(html_escape($this->input->post('customer_unloading_place'))),
				'customer_decission_user_id'=>0,
				'customer_decission_timestamp'=>'0000-00-00',
				'customer_request_status'=>1,
				'customer_used_ton'=>0,
				'customer_unused_ton'=>$this->security->xss_clean(html_escape($this->input->post('customer_max_allotted_ton'))),
				'customer_registration_remarks'=>0,
				'permit_uploadname'=>$up_name,
				'cus_reg_id'=>$id,
				'update_stat'=>1,
				);
				//$type=$_FILES["userfile"]["type"];
			 copy($_FILES["userfile"]["tmp_name"],'./upload/'.$up_name);
//print_r($data_in); 
			$res=$this->db->insert('customer_sec_reg',$data_in);
//echo $this->db->last_query();exit();
				if($res==1)
				{

					$this->db->query("update customer_registration set int_req=int_req+1 where customer_registration_id='$id'");
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Registration Completed</div>');
					redirect("Manual_dredging/Master/customer_home");

				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Registration Failed</div>');
					redirect("Manual_dredging/Master/customer_home");
				}

			}

			$this->load->view('Manual_dredging/Report/customerregistration_viewCUS', $data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}

	   	else
	   	{
			redirect('Main_login/index');        
  		}  
	}
	public function Checkregistration()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$lsg_id=$u_h_dat[0]['user_master_lsg_id'];
			$lorry_reg=$this->security->xss_clean($this->input->post('lorry_reg'));
   			$lorry_reg = str_replace(' ', '-', $lorry_reg); // Replaces all spaces with hyphens.
    		$lorry_reg=preg_replace('/[^A-Za-z0-9\-]/', '', $lorry_reg); // Removes special chars.
		$lorry_reg1=strtoupper($lorry_reg);
if($zone_id==26){$sql='and zone_id=26';}else{$sql='';}
			//$get_buk_phone=$this->db->query("select lorry_id from tbl_lorry where replace(replace(replace(lorry_reg_no, '-', ''),'.',''),' ','')='$lorry_reg1' and status!=3 $sql");
			$get_buk_phone=$this->db->query("select lorry_id from tbl_lorry where lorry_reg_no='$lorry_reg1' and status!=3 $sql");
//echo $this->db->last_query(); exit();
		$no=$get_buk_phone->num_rows();
			if($no==0)
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
	}
	function getchallan()
	{
	ini_set("memory_limit","128M");
	//$buk_id=decode_url($this->uri->segment(3));
	$buk_id=decode_url($this->uri->segment(4));
	$tdet=$this->db->query("select * from transaction_details join tbl_spotbooking on tbl_spotbooking.spot_token=transaction_details.token_no where tbl_spotbooking.spotreg_id='$buk_id'");
	$tran_det=$tdet->result_array();
	//print_r($tran_det);
	//exit;
	$uid=$tran_det[0]['uid_no'];
	$ifsc=$tran_det[0]['ifsc_code'];
	$p_id=$tran_det[0]['port_id'];
	$t_amt=$tran_det[0]['spot_ton'];
$buktype=$tran_det[0]['spot_booking_type'];
		if($buktype==1){$z_name="Spot Booking";}else{$z_name="Door Delivery";}
	$cus_name=$tran_det[0]['spot_cusname'];
	$cus_phne=$tran_det[0]['spot_phone'];
   //$buk_det=$this->Master_model->get_cus_buk_ch($buk_id);
	$bdet=$this->db->query("select * from tbl_portoffice_master where int_portoffice_id='$p_id'");
	$buk_det=$bdet->result_array();
	$did=$buk_det[0]['int_district_id'];
	 //$p_id=$buk_det[0]['customer_booking_port_id'];
	// $m_p_id=$buk_det[0]['customer_booking_monthly_permit_id'];
 $dd=$this->Master_model->get_district_byID($did);
 $bank=$this->Master_model->get_bank($p_id);
 $amount=$tran_det[0]['spot_amount'];
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
 //echo $dd[0]['district_name'];
 //exit;
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
								<td colspan="2" align="center" style="font-size:12px;text-align:justify;margin:2px 3px 2px 3px;" >Vijaya Bank Pay-in-Slip <br>for Port & Shipping Office <br>'.$buk_det[0]['vchr_portoffice_name'].','.$dd[0]['district_name'].'.</td>
								<td  style="text-align: right;margin:0px 0px 3px 0px;"><img  height="75" width="100" src="'.getcwd().'/assets/images/icon_bank.jpg"/></td></tr>
								<tr><td  style="font-size:13px;font-weight: bold;"><b>Token No :</b></td><td><input type="text"  name="doi" value="'.$tran_det[0]['spot_token'].'"></td><td>Date:</td><td >...............................</td></tr>
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
				<tr><td colspan="4" height="10px" style="font-size:12px;">Signature of Remitter</td></tr>
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
						$permit_number=$cus_name."_challan";
		//$this->m_pdf->pdf->Output(base_url().'assets/monthly_permit_pdf/'.$monthly_permit_permit_number.'.pdf','F');
		$sucss = $this->m_pdf->pdf->Output($permit_number.'.pdf','D');//exit;
	}
	//--------------------------------------------------------------
	public function get_balance_ton()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9))
		{
			$zone_id=$this->security->xss_clean($this->input->post('zone'));
			$from=$this->security->xss_clean($this->input->post('fromd'));
			$fromdate=date("Y-m-d", strtotime(str_replace('/', '-',$from)));
			$get_buk_phone=$this->db->query("select daily_log_balance from daily_log where daily_log_date='$fromdate' and daily_log_zone_id='$zone_id'");
			$data_user=$get_buk_phone->result_array();
		//echo "select daily_log_balance from daily_log where daily_log_date='$fromdate' and daily_log_zone_id='$zone_id'";
		//exit;
			$data['buk_data']=$data_user;
			$this->load->view('Manual_dredging/Report/get_balance_ton',$data);
		}
		else
		{
			redirect('Main_login/index');        
		}
	}

//--------------------------------------------------------------
	public function Seccustomer_requestprocessingold()
    {
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	$this->load->model('Manual_dredging/Master_model');	
			$this->load->model('Manual_dredging/Reports_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
		 	$data['portid']=$port_id;
			$customerreg_details= $this->Reports_model->getSec_customerreg_details($port_id);
			$data = $data + $this->data;
			$data['customerreg_details']=$customerreg_details;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/sec_customer_requestprocessing', $data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}
	   	else
	   	{
			redirect('Main_login/index');        

  		}  

    }

	public function getcustomerdetails_ajax()
{
	//print_r($_POST);
	$sess_usr_id = $this->session->userdata('int_userid');
        $this->load->model('Manual_dredging/Master_model');
	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
	$port_id			=	$userinfo[0]['user_master_port_id']; 
	$this->load->model('Manual_dredging/Reports_model');	
	$custaadhar=$this->security->xss_clean(html_escape($this->input->post('custaadhar')));
	$get_customerapproval=$this->Reports_model->customerapproval_second($custaadhar,$port_id);
	$data['get_customerapproval'] = $get_customerapproval;
	$data = $data + $this->data;
	$this->load->view('Manual_dredging/Report/testingajax', $data);

}

//--------------------------------------------------------------28/2/2018----------------------------------

	public function Seccustomer_requestprocessing()
    {
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	$this->load->model('Manual_dredging/Master_model');	
			$this->load->model('Manual_dredging/Reports_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
		 	$data['portid']=$port_id;
			$customerreg_details= $this->Reports_model->getSec_customerreg_details($port_id);
			$data['customerreg_details']=$customerreg_details;
			$data = $data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/sec_customer_requestprocessing', $data);
		$this->load->view('Kiv_views/template/dash-footer');

	   	}
	   	else
	   	{
			redirect('Main_login/index');        

  		}  
    }

	public function Seccustomer_requestrejectedlist()

    {
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	$this->load->model('Manual_dredging/Master_model');	
			$this->load->model('Manual_dredging/Reports_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
	 	$data['portid']=$port_id;
			$customerreg_details= $this->Reports_model->getSec_customerreg_rejected($port_id);
			$data['customerreg_details']=$customerreg_details;
			$data = $data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/sec_customer_requestrejected', $data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}
	   	else
	   	{
			redirect('Main_login/index');        
 		}  
    }

//------------------------------------------------------------------------------------------------------------------------------
	
	public function seccustomerregistration_view()
    {
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))

		{	
			//$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);
			$this->load->model('Manual_dredging/Master_model');	
			$this->load->model('Manual_dredging/Reports_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;    
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
			//$user_id			=	$userinfo[0]['user_master_port_id']; 
			$customerreg_details= $this->Reports_model->getSeccustomerregdetails($id,$port_id);
			//$customerreg_details= $this->Master_model->getcustomerregdetails($id,$port_id);
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
						redirect('Manual_dredging/Report/Seccustomer_requestprocessing');
			}
			$txtremarks=$this->security->xss_clean(html_escape($this->input->post('txtremarks')));
			$customerreg_id=$this->security->xss_clean(html_escape($this->input->post('hid_custid')));
			$portid=$this->security->xss_clean(html_escape($this->input->post('customer_port_id')));
			$currentdate=date('Y-m-d H:i:s');
			if($radiorequest_status==2)

			{

				if($customerpurpose==2){$plintharea=0;}else{$plintharea=$plintharea;}
				//-------------------------------------------------------------------------------
		$rres=$this->db->query("select * from customer_sec_reg where customer_registration_id='$customerreg_id'");
				$ud=$rres->result_array();
				$customer_work_house_name=$ud[0]['customer_work_house_name'];
				//$work_house_number=$ud[0]['work_house_number']; 
				$customer_work_house_place=$ud[0]['customer_work_house_place'];
				$customer_work_post_office=$ud[0]['customer_work_post_office']; 
				$customer_work_pin_code=$ud[0]['customer_work_pin_code'];
				$customer_work_district_id=$ud[0]['customer_work_district_id'];
				$customer_work_lsg_id=$ud[0]['customer_work_lsg_id'];
				$customer_purpose=$ud[0]['customer_purpose'];
				$customer_plinth_area=$ud[0]['customer_plinth_area'];
				$customer_requested_ton=$ud[0]['customer_requested_ton'];
				$customer_max_allotted_ton=$ud[0]['customer_max_allotted_ton'];
				$customer_permit_number=$ud[0]['customer_permit_number'];
				$customer_permit_date=$ud[0]['customer_permit_date'];
				$customer_permit_authority=$ud[0]['customer_permit_authority'];
				$customer_worksite_route=$ud[0]['customer_worksite_route'];
				$customer_worksite_distance=$ud[0]['customer_worksite_distance'];
				$customer_unloading_place=$ud[0]['customer_unloading_place'];
				$customer_registration_timestamp=$ud[0]['customer_registration_timestamp'];
				$customer_decission_user_id=$ud[0]['customer_decission_user_id'];
				$customer_decission_timestamp=$ud[0]['customer_decission_timestamp'];
				$customer_request_status=$ud[0]['customer_request_status']; 
				$customer_used_ton=$ud[0]['customer_used_ton'];
				$customer_unused_ton=$ud[0]['customer_unused_ton']; 
				$permit_uploadname=$ud[0]['permit_uploadname'];
				$customer_registration_remarks=$ud[0]['customer_registration_remarks'];
				$cus_reg_id=$ud[0]['cus_reg_id'];
				//-------------------------------------------------------------------------------
					$request_data=array(
						'customer_work_house_name'		=>	$customer_work_house_name,
						'customer_work_house_place'		=>	$customer_work_house_place,
						'customer_work_post_office'		=>	$customer_work_post_office,
						'customer_work_pin_code'		=>	$customer_work_pin_code,
						'customer_work_district_id'		=>	$customer_work_district_id,
						'customer_work_lsg_id'			=>	$customer_work_lsg_id,
						'customer_purpose'				=>	$customer_purpose,
						'customer_plinth_area'			=>	$plintharea,
						'customer_requested_ton'		=>	$customer_requested_ton,
						'customer_max_allotted_ton'		=>	$maxallotton,
						'customer_permit_number'		=>	$customer_permit_number,
						'customer_permit_date'			=>	$customer_permit_date,
						'customer_permit_authority'		=>	$customer_permit_authority,
						'customer_worksite_route'		=>	$customer_worksite_route,
						'customer_worksite_distance'	=>	$customer_worksite_distance,
						'customer_unloading_place'		=>	$customer_unloading_place,
						'customer_registration_timestamp'=>	$customer_registration_timestamp,
						'customer_decission_user_id'	=>	$sess_usr_id,
						'customer_decission_timestamp'	=>	$currentdate,
						'customer_request_status'		=>	$radiorequest_status,
						'customer_used_ton'				=>	$customer_used_ton,
						'customer_unused_ton'			=>	$customer_unused_ton,
						'permit_uploadname'				=>	$permit_uploadname,
						'customer_registration_remarks'	=>	$txtremarks);	
				$result=$this->Master_model->update_customerregistration($request_data,$cus_reg_id);
				$request_datasec=array(
				'customer_decission_user_id'	=>	$sess_usr_id,
				'customer_decission_timestamp'	=>	$currentdate,
				'customer_request_status'		=>	$radiorequest_status,
				'customer_registration_remarks'	=>	$txtremarks);
				$resultsec=$this->Reports_model->update_secondreg($request_datasec,$customerreg_id);

			}
			else 
			{
				$rres=$this->db->query("select * from customer_sec_reg where customer_registration_id='$customerreg_id'");
				$ud=$rres->result_array();
				$cus_reg_idone=$ud[0]['cus_reg_id'];
			$request_datasec=array(
				'customer_permit_number'		=>	$customerreg_id,
				'customer_decission_user_id'	=>	$sess_usr_id,
				'customer_decission_timestamp'	=>	$currentdate,
				'customer_request_status'		=>	$radiorequest_status,
				'customer_registration_remarks'	=>	$txtremarks);
				$resultsec=$this->Reports_model->update_secondreg($request_datasec,$customerreg_id);
				$request_dataone=array('int_req'		=>	1);	
		$this->Master_model->update_customerregistration($request_dataone,$cus_reg_idone);
				//$this->db->query("update customer_registration set int_req=1 where customer_registration_id='$cus_reg_id'");

			}

				if($resultsec==1)
				{
					if($radiorequest_status==2)

					{

						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processed successfully</div>');
						redirect('Manual_dredging/Report/Seccustomer_requestprocessing');

					}

					else

					{

								$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Request Processing Rejected</div>');			
								redirect('Manual_dredging/Report/Seccustomer_requestprocessing');

					}

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');
					redirect('Manual_dredging/Report/Seccustomer_requestprocessing');
												//	redirect('Master/customer_requestprocessing');

				}
			}
			$this->load->view('Manual_dredging/Report/customerregistration_view', $data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}
	   	else

	   	{

			redirect('Main_login/index');        

  		}  

    }
	//--------------------------------------------------------------------------------------------------------------------
	public function spotsale_report()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& ($sess_user_type==3 || $sess_user_type==9 ||$sess_user_type==4))

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
			
			
			$zone_id=$userinfo[0]['user_master_zone_id'];
			
			
			$data 				= 	$data + $this->data;
			$zone=$this->Master_model->get_zone_acinP($port_id);
			if($sess_user_type==4)
			{
				$zone=$this->db->query("select * from zone where zone_id='$zone_id'");
				$data['zone']=$zone->result_array();
				
			}
			else
			{
				$data['zone']=$zone;
			}
			
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/spotgensalereport',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

	else
		{

			redirect('Main_login/index');        

		}

	}
	public function spotgen_salereport()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))

		{
              $this->load->model('Manual_dredging/Reports_model');      
			$zone_id=$this->security->xss_clean($this->input->post('zone'));
			$from=$this->security->xss_clean($this->input->post('fromd'));
			$from=date("Y-m-d",strtotime(str_replace('/', '-',$from)));
			$to=$this->security->xss_clean($this->input->post('tod'));
			$to=date("Y-m-d",strtotime(str_replace('/', '-',$to)));
			$sale_rep=$this->Reports_model->spot_gensalereport($zone_id,$from,$to);
			$data['sale_report']=$sale_rep;
			$data 				= 	$data + $this->data;
			$data['zone_id']=$zone_id;
			$data 				= 	$data + $this->data;
			$data['from_d']=$from;
			$data 				= 	$data + $this->data;
			$data['to_d']=$to;
			$data 				= 	$data + $this->data;
			$this->load->view('Manual_dredging/Report/spotgensale_ajax',$data);
		}

	}

public function spotgen_salereport_zone()

	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))
		{
                    $this->load->model('Manual_dredging/Master_model');
                    $this->load->model('Manual_dredging/Reports_model');
			
                    $currentdate			=	date('Y-m-d');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$sale_rep=$this->Reports_model->spot_gensalereport($zone_id,$currentdate,$currentdate);
			$data['sale_report']=$sale_rep;
			$data 				= 	$data + $this->data;
			$data['zone_id']=$zone_id;
			$data 				= 	$data + $this->data;
		$data['from_d']=$currentdate;
			$data 				= 	$data + $this->data;
			$data['to_d']=$currentdate;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/spotgensale_zone',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

	}

//--------------------------------------------------------------------------------------------------	
public function update_myfile()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');

		if(!empty($sess_usr_id)&& $sess_user_type==5)
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
			$get_reg_id=$this->db->query("select customer_registration_id from customer_registration where customer_public_user_id='$sess_usr_id'");
			$det_re_id=$get_reg_id->result_array();
			$cus_regid=$det_re_id[0]['customer_registration_id'];
			$get_sec_det=$this->db->query("select * from customer_sec_reg where cus_reg_id='$cus_regid'");
			$det_sec_det=$get_sec_det->result_array();
			$data['sec_reg']=	$det_sec_det;
			//print_r($za);

			if($this->input->post())

			{

				$cus_regid=$this->security->xss_clean(html_escape($this->input->post('hid')));
				$fname=$cus_regid."permit";
				$up_name=$fname.".pdf";
			    copy($_FILES["txt_permit"]["tmp_name"],"upload/".$up_name);

				$this->db->query("update customer_sec_reg set permit_uploadname='$up_name' , update_stat=1 where cus_reg_id='$cus_regid'");

				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">File Update Successfully, Thank You!!!!!!</div>');

				redirect('Manual_dredging/Report/update_myfile');
			}

			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/update_file',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}

		else

		{

			redirect('Main_login/index');        

		}

	}


/////////////////////////////////////  end here /////////////////////////////////////////////////////////////////

	public function spot_online()

	{

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'port_name'=>$port_name);

			$data 				= 	$data + $this->data;     
			/*$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;*/
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			$this->load->view('Kiv_views/Registration/header_reg.php');
			$this->load->view('Manual_dredging/Report/spot_home_online',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		//}
		//else
		//{
		//redirect('Main_login/index');       

		//}

	}	
	//==================================SPOT ONLINE REGISTRATION==============================================
	public function add_spot_registrationnew29072019()

	{
		 /*?>$sess_usr_id 			=  $this->session->userdata('int_userid');
	$sess_user_type			=	$this->session->userdata('int_usertype');
	//if(!empty($sess_usr_id)&& $sess_user_type==3)
	//{
		//	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

		$i=0;
		//$port_id			=	$userinfo[$i]['user_master_port_id'];

	$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 				= 	$data + $this->data;     
		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);

			$data['user_header']=	$u_h_dat;<?php */?>
			<?php 
			$bookingtime_data= $this->Master_model->customerspotbooking_timecheck();
			$starttime=$bookingtime_data[0]['spotbooking_master_start'];
			$endtime=$bookingtime_data[0]['spotbooking_master_end'];
			$start_time=strtotime($starttime);
			$end_time=strtotime($endtime);
		//echo date_default_timezone_get();
	//echo date('Y-M-d h:i:s');
		//exit;
			$current_time=strtotime("now");
	if($current_time >= $start_time && $current_time <= $end_time)

		{ 

		$port				= 	$this->Master_model->get_portspot();

		$data['port_det']	=	$port;
		$data 				= 	$data + $this->data; 

			if($this->input->post())

			{

				$this->form_validation->set_rules('portdc', 'Port ', 'required');
				$this->form_validation->set_rules('txt_username', 'Name', 'required');
				$this->form_validation->set_rules('txt_adhaar', 'Aadhar', 'required');
				$this->form_validation->set_rules('txt_phone', 'Phone No ', 'required');
				$this->form_validation->set_rules('txt_ton', 'Ton', 'required');
				$this->form_validation->set_rules('txt_place', 'Place', 'required');
				$this->form_validation->set_rules('txt_route', 'Route ', 'required');
				$this->form_validation->set_rules('txt_distance', 'Distance', 'required');
			///-----------------------------------------------------------------------------------------
			$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
			$txt_phone=html_escape($this->input->post('txt_phone'));
			$port_id=html_escape($this->input->post('portdc'));
				$today=date('Y-m-d');

		//	$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhaar' and `spot_timestamp` LIKE '%$today%' order by spotreg_id desc limit 0,1");

$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhaar' order by spotreg_id desc limit 0,1");
			//echo $this->db->last_query();

	$g_int=$get_intrvl->result_array();
	if(count($g_int)==0)


			{

		if($this->form_validation->run() == FALSE)

				{

				validation_errors();

				}

		else
		{
		//$ip_address=$_SERVER['REMOTE_ADDR'];
			if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
		$port_id=html_escape($this->input->post('portdc'));
		$txt_username=html_escape($this->input->post('txt_username'));
		$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
		$txt_phone=html_escape($this->input->post('txt_phone'));
		$txt_ton=html_escape($this->input->post('txt_ton'));
		$txt_place=html_escape($this->input->post('txt_place'));
		$txt_route=html_escape($this->input->post('txt_route'));
		$txt_distance=html_escape($this->input->post('txt_distance'));
		$zone_id=html_escape($this->input->post('zone_id'));
		$hid_otp=html_escape($this->input->post('hid_otp'));
		$booking_type=html_escape($this->input->post('booking_type'));
			$vehicle_type=html_escape($this->input->post('vehicle_type'));
	//-------------------------------------------------------------------------------------	

					//if($booking_type!="true")

					//	{

							$bookingtype=1;
	//	}
						//else

					//	{
							//$bookingtype=2;

					//		}	

				 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
				if($hid_otp!='')

				{

						if($hid_otp!=$sess_otp)

						{

							redirect('Manual_dredging/Report/add_spot_registrationnew');	
						}

					}
					else
					{

						redirect('Manual_dredging/Report/add_spot_registrationnew');	

					}

//-----------------------limit check----------------------------------------------------------------

						$today=date('Y-m-d');


						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
				$ud=$queryspot->result_array();
				//	foreach($ud as $rowfetch)
				//	{
					$limit_id=$ud[0]['spot_limit_id'];
					$limitqty=$ud[0]['spot_limit_quantity'];
					$limitbalance=$ud[0]['spot_limit_balance'];


				//	}

					if($limitbalance<$txt_ton)
					{	


					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
					// redirect('Report/spot_registration_online');
					redirect('Manual_dredging/Report/add_spot_registrationnew');

					}

			else
			{
						//-------------------------------------------------------------------------------------------------
				$period=date('F Y');
			$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");

		$et_amount=$getrate_port->result_array();

		$sand_amount=$et_amount[0]["s_amount"];		
		$challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
		$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
	$data_in=array(
		'spot_cusname'=>$txt_username,
		'spot_adhaar'=>$txt_adhaar,
		'spot_phone'=>$txt_phone,
		'spot_ton'=>$txt_ton,
		'spot_unloading'=>$txt_place,
		'spot_route'=>$txt_route,
		'spot_distance'=>$txt_distance,
		'spot_token'=>uniqid(),
		'spot_challan'=>$challan_no,
		'spot_amount'=>$challan_amount,
		'spot_user'=>$sess_usr_id,
		'spotbooking_ip_addr'=>$ip_address,
		'port_id'=>$port_id,
		'preferred_zone'=>$zone_id,
		'spotbooking_status'=>2,
		'spotbooking_dte'=>date('Y-m-d'),
		'spotbuk_dteph'=>date('Y-m-d'),
		'spot_booking_type'=>$bookingtype,
		);


				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);

				//print_r($getpdtaa);

				$p_code=$getpdtaa[0]['intport_code'];

				$this->db->trans_begin();
				
				//-----------------------------------------------------------------------------------
			

				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
				$getton=$get_ton->result_array();

			$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
				
				
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {
					if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;


						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");

//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}
				
					 
					 
					 }
				else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}
				$buk_id=$this->db->insert_id();

				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//exit();
				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
				$no=$gt_ch->num_rows();

				if($no==0)

				{

					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
						$data = array("OPCODE"=>"GETUID",
								"TOKENNO"=>"$tok_no",
								"PORTCODE"=>"$p_code",
								"INSTCODE"=>"DOP",
								"CHALLANAMOUNT"=>"$challan_amount",
									 );                                                                 

							$data_string = json_encode($data);  

								//exit; 
							//echo $data_string;                                                                           
			$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                   
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
									'Content-Type: application/json',                                    
									'Content-Length: ' . strlen($data_string))                                 
								);                                                                               
								$result = curl_exec($ch);
								$myArray=json_decode($result, true);
								$uid=$myArray['UID'];
							$ifsc=$myArray['IFSC'];
								if($uid=="")
								{

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');

								}
								else
								{
								$currentdate			=	date('Y-m-d H:i:s');
						$data_trans=array('transaction_customer_registration_id'=>000,
													'transaction_customer_booking_id'=>000,
													'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>$uid,
													'ifsc_code'=>$ifsc,
													'challan_timestamp'=>$currentdate,
													'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,

												);

						$this->db->insert('transaction_details',$data_trans);

							$this->session->unset_userdata('sess_spot_otp');				
						$this->db->trans_commit();
						//echo encode_url($buk_id);
						redirect('Manual_dredging/Report/customerspot_message/'.encode_url($buk_id));

						//redirect('Report/getchallan/'.encode_url($buk_id));

						//redirect('Report/spot_registration');

								}

				}

				else

				{

					 $this->db->trans_rollback();

					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');

					// redirect('Report/spot_registration_online');



					redirect('Manual_dredging/Report/add_spot_registrationnew');

			}

		}//else limit
	}//echo 0;

}
else
			{
			 $today=date('Y-m-d h:i:s');
			 $w_buk_date=$g_int[0]['spot_timestamp'];
			$date1=date_create($today);
			$date2=date_create($w_buk_date);
		$diff = $date2->diff($date1)->format("%a");
			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id='$port_id' and buk_stat=1");
			$tn_no=$get_last_d->result_array();
			$t_n=$tn_no[0]['buk_time'];
			if($diff<$t_n)
			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Adhaar already exist!!!</div>');
				redirect('Manual_dredging/Report/add_spot_registrationnew');

			}
			else

			{

			//----------------------------------------------------------------------------------------------------

		
				if($this->form_validation->run() == FALSE)
			{
				validation_errors();


				}

			else



			{


				//$ip_address=$_SERVER['REMOTE_ADDR'];
if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
			$port_id=html_escape($this->input->post('portdc'));
				$txt_username=html_escape($this->input->post('txt_username'));
				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
				$txt_phone=html_escape($this->input->post('txt_phone'));
				$txt_ton=html_escape($this->input->post('txt_ton'));
				$txt_place=html_escape($this->input->post('txt_place'));
				$txt_route=html_escape($this->input->post('txt_route'));
				$txt_distance=html_escape($this->input->post('txt_distance'));
				$zone_id=html_escape($this->input->post('zone_id'));
				$hid_otp=html_escape($this->input->post('hid_otp'));
			$booking_type=html_escape($this->input->post('booking_type'));

				//-------------------------------------------------------------------------------------	

				//	if($booking_type!="true")
//
//						{

							$bookingtype=1;

							
//
//						}
//
//						else
//
//						{
//
//							$bookingtype=2;
//
//							
//
//						}



					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');



					if($hid_otp!='')

					{

						if($hid_otp!=$sess_otp)

						{

							redirect('Manual_dredging/Report/add_spot_registrationnew');	


						}



					}

					else

					{

						redirect('Manual_dredging/Report/add_spot_registrationnew');	

					}


				//-----------------------limit check-------------------------------------------------------------


						$today=date('Y-m-d');

						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");

				$ud=$queryspot->result_array();

					//foreach($ud as $rowfetch)

					//{


					$limit_id=$ud[0]['spot_limit_id'];

				$limitqty=$ud[0]['spot_limit_quantity'];

				$limitbalance=$ud[0]['spot_limit_balance'];

				//	}


					if($limitbalance<$txt_ton)

					{	

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');


					 //redirect('Report/spot_registration_online');

					redirect('Manual_dredging/Report/add_spot_registrationnew');

					}

				else
					{


						/*$data_udt=array(

					'spot_limit_balance'=>$limitbalance-$txt_ton,

						);
					$this->db->where('spot_limit_id',$limit_id);
					$this->db->where('spot_limit_date',$today);
					$this->db->where('spot_limit_port_id',$port_id);
					$this->db->where('spot_limit_balance >', 0);
				//print_r($data_udt);break;

			$resultins=$this->db->update('spot_booking_limit', $data_udt);*/
						//-------------------------------------------------------------------------------------------------


				$period=date('F Y');

				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");

				$et_amount=$getrate_port->result_array();

				$sand_amount=$et_amount[0]["s_amount"];

			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));

				$data_in=array(
				'spot_cusname'=>$txt_username,
				'spot_adhaar'=>$txt_adhaar,
				'spot_phone'=>$txt_phone,
				'spot_ton'=>$txt_ton,
				'spot_unloading'=>$txt_place,
				'spot_route'=>$txt_route,
				'spot_distance'=>$txt_distance,
				'spot_token'=>uniqid(),
				'spot_challan'=>$challan_no,
				'spot_amount'=>$challan_amount,
				'spot_user'=>$sess_usr_id,
				'spotbooking_ip_addr'=>$ip_address,
					'port_id'=>$port_id,
				'preferred_zone'=>$zone_id,
				'spotbooking_status'=>2,
				'spotbooking_dte'=>date('Y-m-d'),
					'spotbuk_dteph'=>date('Y-m-d'),
					'spot_booking_type'=>$bookingtype,

				);


				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);

				//print_r($data_in);

				$p_code=$getpdtaa[0]['intport_code'];

		//--------------------------------------------------------------------------
						
		$this->db->trans_begin();
						
		//--------------------------------------------------------------------------
		$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
				$getton=$get_ton->result_array();

			$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
				
				
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {				
						
						
				if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;


						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");

$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}

}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}

//echo $this->db->last_query();



				 $buk_id=$this->db->insert_id();

				 $tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
	//	echo "WWWWWW". $tok_no;
//exit();

			$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");

				$no=$gt_ch->num_rows();

				if($no==0)

				{
//echo "update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'";exit();
					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");

								$data = array("OPCODE"=>"GETUID",
										"TOKENNO"=>"$tok_no",
											"PORTCODE"=>"$p_code",
											"INSTCODE"=>"DOP",
											"CHALLANAMOUNT"=>"$challan_amount",
											);                                                                   

						$data_string = json_encode($data);  
								//exit; 
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

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');

								redirect('Manual_dredging/Report/add_spot_registrationnew');

								}

							else

								{

								$currentdate			=	date('Y-m-d H:i:s');
							$data_trans=array('transaction_customer_registration_id'=>000,
												'transaction_customer_booking_id'=>000,
												'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>$uid,
													'ifsc_code'=>$ifsc,
													'challan_timestamp'=>$currentdate,
													'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,

												);

						$this->db->insert('transaction_details',$data_trans);
					$this->session->unset_userdata('sess_spot_otp');			

						$this->db->trans_commit();


                          //echo encode_url($buk_id);



						redirect('Manual_dredging/Report/customerspot_message/'.encode_url($buk_id));

			//redirect('Report/getchallan/'.encode_url($buk_id));

						//redirect('Report/spot_registration');

								}

				}


				else


				{


					 $this->db->trans_rollback();

					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');

					 redirect('Manual_dredging/Report/spot_registration_online');

				}


			}//else limit


		}//else validation


		}//aadhar check else part else(diff<t_n)

		}//aadhar check else part

		//###############################################################################################

		
				$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_phone='$txt_phone' order by spotreg_id desc limit 0,1");

				//echo $this->db->last_query();

		$g_int=$get_intrvl->result_array();

			if(count($g_int)==0)

			{



				if($this->form_validation->run() == FALSE)

				{

					validation_errors();
		}

				else
		{

				//$ip_address=$_SERVER['REMOTE_ADDR'];
			if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
				$port_id=html_escape($this->input->post('portdc'));
				$txt_username=html_escape($this->input->post('txt_username'));
				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
				$txt_phone=html_escape($this->input->post('txt_phone'));
				$txt_ton=html_escape($this->input->post('txt_ton'));
				$txt_place=html_escape($this->input->post('txt_place'));
				$txt_route=html_escape($this->input->post('txt_route'));
				$txt_distance=html_escape($this->input->post('txt_distance'));
				$zone_id=html_escape($this->input->post('zone_id'));
					$hid_otp=html_escape($this->input->post('hid_otp'));
			$booking_type=html_escape($this->input->post('booking_type'));
				

				//-------------------------------------------------------------------------------------	

					//if($booking_type!="true")
//
//						{

							$bookingtype=1;

							
//
//						}
//
//						else
//
//						{
//
//							$bookingtype=2;
//
//							
//
//						}



					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
					if($hid_otp!='')

					{

						if($hid_otp!=$sess_otp)

						{

						redirect('Manual_dredging/Report/add_spot_registrationnew');	
						}

					}
					else

					{
						redirect('Manual_dredging/Report/add_spot_registrationnew');	
					}


				//-----------------------limit check----------------------------------------------------------------

						$today=date('Y-m-d');

						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");


				$ud=$queryspot->result_array();


				//	foreach($ud as $rowfetch)

				//	{


					$limit_id=$ud[0]['spot_limit_id'];

					$limitqty=$ud[0]['spot_limit_quantity'];
					$limitbalance=$ud[0]['spot_limit_balance'];

				//	}

					if($limitbalance<$txt_ton)

					{	


					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');

		// redirect('Report/spot_registration_online');


					redirect('Manual_dredging/Report/add_spot_registrationnew');


					}


					else

					{

						//-------------------------------------------------------------------------------------------------
				$period=date('F Y');
				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");

			$et_amount=$getrate_port->result_array();
			$sand_amount=$et_amount[0]["s_amount"];
			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
				$data_in=array(
			'spot_cusname'=>$txt_username,
				'spot_adhaar'=>$txt_adhaar,
				'spot_phone'=>$txt_phone,
				'spot_ton'=>$txt_ton,
				'spot_unloading'=>$txt_place,
				'spot_route'=>$txt_route,
				'spot_distance'=>$txt_distance,
					'spot_token'=>uniqid(),
				'spot_challan'=>$challan_no,
				'spot_amount'=>$challan_amount,
				'spot_user'=>$sess_usr_id,
				'spotbooking_ip_addr'=>$ip_address,
					'port_id'=>$port_id,
			'preferred_zone'=>$zone_id,
				'spotbooking_status'=>2,
				'spotbooking_dte'=>date('Y-m-d'),
					'spotbuk_dteph'=>date('Y-m-d'),
					'spot_booking_type'=>$bookingtype,

				);

				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);

				$p_code=$getpdtaa[0]['intport_code'];


				$this->db->trans_begin();

//-----------------------------------------------------------------------------------
			

				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
				$getton=$get_ton->result_array();

			$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
				
				
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {
						if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;


						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");

$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}
					 
					  }
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}
				$buk_id=$this->db->insert_id();
					 
				 $tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//exit();

				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");



				$no=$gt_ch->num_rows();

				if($no==0)

				{
					//echo "update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'";exit();


					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
					$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>"$tok_no",

											"PORTCODE"=>"$p_code",

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$challan_amount",
					);                                                                    


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
								$uid=$myArray['UID'];

								$ifsc=$myArray['IFSC'];

								if($uid=="")


								{
									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');


									redirect('Manual_dredging/Report/add_spot_registrationnew');


								}

								else


								{

								$currentdate			=	date('Y-m-d H:i:s');

	$data_trans=array(
													'transaction_customer_registration_id'=>000,
													'transaction_customer_booking_id'=>000,
													'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>$uid,
													'ifsc_code'=>$ifsc,
													'challan_timestamp'=>$currentdate,
													'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,
												);

						$this->db->insert('transaction_details',$data_trans);
						$this->session->unset_userdata('sess_spot_otp');					
						$this->db->trans_commit();
						//echo encode_url($buk_id);
						redirect('Manual_dredging/Report/customerspot_message/'.encode_url($buk_id));
						//redirect('Report/getchallan/'.encode_url($buk_id));
						//redirect('Report/spot_registration');
								}

				}

				else
				{

				 $this->db->trans_rollback();
					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
					redirect('Manual_dredging/Report/add_spot_registrationnew');

				}

			}//else limit


				}//echo 0;
			}
			else
			{
			 $today=date('Y-m-d h:i:s');
			 $w_buk_date=$g_int[0]['spot_timestamp'];
				//exit();
			$date1=date_create($today);
			$date2=date_create($w_buk_date);
			$diff = $date2->diff($date1)->format("%a");
			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id=0 and buk_stat=1");
			$tn_no=$get_last_d->result_array();
			$t_n=$tn_no[0]['buk_time'];
			if($diff<$t_n)

			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Phone already exist!!!</div>');



				redirect('Manual_dredging/Report/add_spot_registrationnew');







			}



			else


			{




			//----------------------------------------------------------------------------------------------------

				if($this->form_validation->run() == FALSE)







				{

		validation_errors();


				}


				else

			{

				//$ip_address=$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
	$port_id=html_escape($this->input->post('portdc'));

	$txt_username=html_escape($this->input->post('txt_username'));

				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));

				$txt_phone=html_escape($this->input->post('txt_phone'));

				$txt_ton=html_escape($this->input->post('txt_ton'));

				$txt_place=html_escape($this->input->post('txt_place'));

				$txt_route=html_escape($this->input->post('txt_route'));

				$txt_distance=html_escape($this->input->post('txt_distance'));

				$zone_id=html_escape($this->input->post('zone_id'));

				$hid_otp=html_escape($this->input->post('hid_otp'));

$booking_type=html_escape($this->input->post('booking_type'));

				//-------------------------------------------------------------------------------------	

				/*	if($booking_type!="true")

						{*/

							$bookingtype=1;

							

					/*	}

						else

						{

							$bookingtype=2;

							

						}*/

					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');



					if($hid_otp!='')



					{



						if($hid_otp!=$sess_otp)

						{

							redirect('Manual_dredging/Report/add_spot_registrationnew');	

						}

					}

					else

					{

						redirect('Manual_dredging/Report/add_spot_registrationnew');	
					}


				//-----------------------limit check----------------------------------------------------------------

						$today=date('Y-m-d');


						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");

				$ud=$queryspot->result_array();

					//foreach($ud as $rowfetch)


					//{


					$limit_id=$ud[0]['spot_limit_id'];

					$limitqty=$ud[0]['spot_limit_quantity'];

					$limitbalance=$ud[0]['spot_limit_balance'];

					//}

					if($limitbalance<$txt_ton)

					{	



					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');


					redirect('Manual_dredging/Report/add_spot_registrationnew');

					}

					else



					{
						/*$data_udt=array(
					'spot_limit_balance'=>$limitbalance-$txt_ton,
						);
					$this->db->where('spot_limit_id',$limit_id);
					$this->db->where('spot_limit_date',$today);
					$this->db->where('spot_limit_port_id',$port_id);
					$this->db->where('spot_limit_balance >', 0);
				//print_r($data_udt);break;
				$resultins=$this->db->update('spot_booking_limit', $data_udt);*/

						//-------------------------------------------------------------------------------------------------


				$period=date('F Y');

				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");


				$et_amount=$getrate_port->result_array();


				$sand_amount=$et_amount[0]["s_amount"];

			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42



				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));

				$data_in=array(

				'spot_cusname'=>$txt_username,

				'spot_adhaar'=>$txt_adhaar,

				'spot_phone'=>$txt_phone,

				'spot_ton'=>$txt_ton,

				'spot_unloading'=>$txt_place,

				'spot_route'=>$txt_route,

				'spot_distance'=>$txt_distance,

				'spot_token'=>uniqid(),

				'spot_challan'=>$challan_no,

				'spot_amount'=>$challan_amount,

				'spot_user'=>$sess_usr_id,

				'spotbooking_ip_addr'=>$ip_address,
					'port_id'=>$port_id,

				'preferred_zone'=>$zone_id,

				'spotbooking_status'=>2,

				'spotbooking_dte'=>date('Y-m-d'),

				'spotbuk_dteph'=>date('Y-m-d'),

					'spot_booking_type'=>$bookingtype,

				);

				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);



				//print_r($data_in);

				$p_code=$getpdtaa[0]['intport_code'];




					//--------------------------------------------------------------------------	



				$this->db->trans_begin();
						
			//-----------------------------------------------------------------------------------
			

				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
				$getton=$get_ton->result_array();

			$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
				
				
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {
							
						

if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;


						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");

$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}
 }
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
				}


//echo $this->db->last_query();



				$buk_id=$this->db->insert_id();


				 $tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);

//exit();

			//	echo "WWWWWW". $tok_no;



//



			//	exit;


				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");


				$no=$gt_ch->num_rows();



				if($no==0)



				{

//echo "update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'";exit();


					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
				$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>"$tok_no",

											"PORTCODE"=>"$p_code",

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$challan_amount",

											);                                                                    

							$data_string = json_encode($data);  


								//exit; 


								//echo $data_string;                                                                                 

					$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');


								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                         curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                         
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
									'Content-Type: application/json',                                    'Content-Length: ' . strlen($data_string))                                   
								);                                                                               
								$result = curl_exec($ch);
								$myArray=json_decode($result, true);
								$uid=$myArray['UID'];
								$ifsc=$myArray['IFSC'];
								if($uid=="")


								{

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationnew');
								}

								else
							{

								$currentdate			=	date('Y-m-d H:i:s');
							$data_trans=array('transaction_customer_registration_id'=>000,
													'transaction_customer_booking_id'=>000,
													'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>$uid,
													'ifsc_code'=>$ifsc,
													'challan_timestamp'=>$currentdate,
												'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,

												);

						$this->db->insert('transaction_details',$data_trans);

	
								$this->session->unset_userdata('sess_spot_otp');

						$this->db->trans_commit();


                          //echo encode_url($buk_id);



						redirect('Manual_dredging/Report/customerspot_message/'.encode_url($buk_id));
						//redirect('Report/getchallan/'.encode_url($buk_id));
						//redirect('Report/spot_registration');

								}

				}

			else

				{

					 $this->db->trans_rollback();
					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
					 redirect('Manual_dredging/Report/spot_registration_online');

				}

			}//else limit

		}//else validation

		}//phone check else part else(diff<t_n)

		}//phone check else part

	//-#################################################################################################		
		} //post check

		} //time check if close

		else
		{ 

			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');

		// redirect('Report/spot_registration_online');

			redirect('Manual_dredging/Report/add_spot_registrationnew');
					 }
			$this->load->view('template/header');
			$this->load->view('Manual_dredging/Report/spot_registration_online',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		//}

		//else


	//	{

		//	redirect('Main_login/index');       


	//	}


	}


//------------------------------------------------------------------------------------------
	//public function add_door_registrationnew()
//
//	{
//		 $sess_usr_id 			=  $this->session->userdata('int_userid');
//	$sess_user_type			=	$this->session->userdata('int_usertype');
//	//if(!empty($sess_usr_id)&& $sess_user_type==3)
//	//{
//		//	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
//
//		$i=0;
//		//$port_id			=	$userinfo[$i]['user_master_port_id'];
//
//	$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
//	$data 				= 	$data + $this->data;     
//		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
//
//			$data['user_header']=	$u_h_dat;
//			
//			$bookingtime_data= $this->Master_model->customerspotbooking_timecheck();
//			$starttime=$bookingtime_data[0]['spotbooking_master_start'];
//			$endtime=$bookingtime_data[0]['spotbooking_master_end'];
//			$start_time=strtotime($starttime);
//			$end_time=strtotime($endtime);
//		//echo date_default_timezone_get();
//	//echo date('Y-M-d h:i:s');
//		//exit;
//			$current_time=strtotime("now");
//	if($current_time >= $start_time && $current_time <= $end_time)
//
//		{ 
//
//		$port				= 	$this->Master_model->get_portspot();
//
//		$data['port_det']	=	$port;
//		$data 				= 	$data + $this->data; 
//
//			if($this->input->post())
//
//			{
//
//				$this->form_validation->set_rules('portdc', 'Port ', 'required');
//				$this->form_validation->set_rules('txt_username', 'Name', 'required');
//				$this->form_validation->set_rules('txt_adhaar', 'Aadhar', 'required');
//				$this->form_validation->set_rules('txt_phone', 'Phone No ', 'required');
//				$this->form_validation->set_rules('txt_ton', 'Ton', 'required');
//				$this->form_validation->set_rules('txt_place', 'Place', 'required');
//				$this->form_validation->set_rules('txt_route', 'Route ', 'required');
//				$this->form_validation->set_rules('txt_distance', 'Distance', 'required');
//			///-----------------------------------------------------------------------------------------
//			$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//			$txt_phone=html_escape($this->input->post('txt_phone'));
//			$port_id=html_escape($this->input->post('portdc'));
//				$today=date('Y-m-d');
//
//		//	$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhaar' and `spot_timestamp` LIKE '%$today%' order by spotreg_id desc limit 0,1");
//
//$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhaar' order by spotreg_id desc limit 0,1");
//			//echo $this->db->last_query();
//
//			$g_int=$get_intrvl->result_array();
//	if(count($g_int)==0)
//
//
//			{
//
//		if($this->form_validation->run() == FALSE)
//
//				{
//
//				validation_errors();
//
//				}
//
//		else
//		{
//		//$ip_address=$_SERVER['REMOTE_ADDR'];
//			if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
//    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//}
//else {
//    $ip_address = $_SERVER["REMOTE_ADDR"];
//}
//		$port_id=html_escape($this->input->post('portdc'));
//		$txt_username=html_escape($this->input->post('txt_username'));
//		$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//		$txt_phone=html_escape($this->input->post('txt_phone'));
//		$txt_ton=html_escape($this->input->post('txt_ton'));
//		$txt_place=html_escape($this->input->post('txt_place'));
//		$txt_route=html_escape($this->input->post('txt_route'));
//		$txt_distance=html_escape($this->input->post('txt_distance'));
//		$zone_id=html_escape($this->input->post('zone_id'));
//		$hid_otp=html_escape($this->input->post('hid_otp'));
//		$booking_type=html_escape($this->input->post('booking_type'));
//	//-------------------------------------------------------------------------------------	
//
//					/*if($booking_type!="true")
//
//						{
//
//							$bookingtype=1;
//		}
//						else
//
//						{*/
//							$bookingtype=2;
//
//							//}	
//
//				 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
//				if($hid_otp!='')
//
//				{
//
//						if($hid_otp!=$sess_otp)
//
//						{
//
//							redirect('Report/add_door_registrationnew');	
//						}
//
//					}
//					else
//					{
//
//						redirect('Report/add_door_registrationnew');	
//
//					}
//
////-----------------------limit check----------------------------------------------------------------
//
//						$today=date('Y-m-d');
//
//
//						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
//				$ud=$queryspot->result_array();
//				//	foreach($ud as $rowfetch)
//				//	{
//					$limit_id=$ud[0]['spot_limit_id'];
//					$limitqty=$ud[0]['spot_limit_quantity'];
//					$limitbalance=$ud[0]['spot_limit_balance'];
//
//
//				//	}
//
//					if($limitbalance<$txt_ton)
//					{	
//
//
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//					// redirect('Report/spot_registration_online');
//					redirect('Report/add_door_registrationnew');
//
//					}
//
//			else
//			{
//						//-------------------------------------------------------------------------------------------------
//				$period=date('F Y');
//			$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//
//		$et_amount=$getrate_port->result_array();
//
//		$sand_amount=$et_amount[0]["s_amount"];		
//		$challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//		$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//	$data_in=array(
//		'spot_cusname'=>$txt_username,
//		'spot_adhaar'=>$txt_adhaar,
//		'spot_phone'=>$txt_phone,
//		'spot_ton'=>$txt_ton,
//		'spot_unloading'=>$txt_place,
//		'spot_route'=>$txt_route,
//		'spot_distance'=>$txt_distance,
//		'spot_token'=>uniqid(),
//		'spot_challan'=>$challan_no,
//		'spot_amount'=>$challan_amount,
//		'spot_user'=>$sess_usr_id,
//		'spotbooking_ip_addr'=>$ip_address,
//		'port_id'=>$port_id,
//		'preferred_zone'=>$zone_id,
//		'spotbooking_status'=>2,
//		'spotbooking_dte'=>date('Y-m-d'),
//		'spotbuk_dteph'=>date('Y-m-d'),
//		'spot_booking_type'=>$bookingtype,
//		);
//
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//
//				//print_r($getpdtaa);
//
//				$p_code=$getpdtaa[0]['intport_code'];
//
//				$this->db->trans_begin();
//				
//				//-----------------------------------------------------------------------------------
//			
//
//				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//				$getton=$get_ton->result_array();
//
//			$tonbooked=$getton[0]["spotton"];
//				
//				$tonspot=$limitqty-$tonbooked;
//				
//				
//				//-----------------------------------------------------------------------------------
//				 if($tonspot > 3)
//				 {
//						
//				if($tonspot>=$txt_ton)
//					{
//						$totbal=$tonspot-$txt_ton;
//
//
//						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//
//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//	
//				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
//					}
//						else
//				{
//					
//				
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
//					 
//					 }
//				else
//				{
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
//				$buk_id=$this->db->insert_id();
//
//				 $tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//
//				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//				$no=$gt_ch->num_rows();
//
//				if($no==0)
//
//				{
//				//	echo "update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'";exit();
//
//
//					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
//						$data = array("OPCODE"=>"GETUID",
//								"TOKENNO"=>"$tok_no",
//								"PORTCODE"=>"$p_code",
//								"INSTCODE"=>"DOP",
//								"CHALLANAMOUNT"=>"$challan_amount",
//									 );                                                                 
//
//							$data_string = json_encode($data);  
//
//								//exit; 
//							//echo $data_string;                                                                           
//			$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');
//			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                   
//								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
//									'Content-Type: application/json',                                    
//									'Content-Length: ' . strlen($data_string))                                 
//								);                                                                               
//								$result = curl_exec($ch);
//								$myArray=json_decode($result, true);
//								$uid=$myArray['UID'];
//							$ifsc=$myArray['IFSC'];
//								if($uid=="")
//								{
//
//									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
//									redirect('Report/add_door_registrationnew');
//
//								}
//								else
//								{
//								$currentdate			=	date('Y-m-d H:i:s');
//						$data_trans=array('transaction_customer_registration_id'=>000,
//													'transaction_customer_booking_id'=>000,
//													'token_no'=>$tok_no,
//													'challan_no'=>$challan_no,
//													'challan_amount'=>$challan_amount,
//													'uid_no'=>$uid,
//													'ifsc_code'=>$ifsc,
//													'challan_timestamp'=>$currentdate,
//													'booking_timestamp'=>$currentdate,
//													'zone_id'=>000,
//													'port_id'=>$port_id,
//
//												);
//
//						$this->db->insert('transaction_details',$data_trans);
//
//							$this->session->unset_userdata('sess_spot_otp');				
//						$this->db->trans_commit();
//						//echo encode_url($buk_id);
//						redirect('Report/customerspot_message/'.encode_url($buk_id));
//
//						//redirect('Report/getchallan/'.encode_url($buk_id));
//
//						//redirect('Report/spot_registration');
//
//								}
//
//				}
//
//				else
//
//				{
//
//					 $this->db->trans_rollback();
//
//					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//
//					// redirect('Report/spot_registration_online');
//
//
//
//					redirect('Report/add_door_registrationnew');
//
//			}
//
//		}//else limit
//	}//echo 0;
//
//}
//else
//			{
//			 $today=date('Y-m-d h:i:s');
//			 $w_buk_date=$g_int[0]['spot_timestamp'];
//			$date1=date_create($today);
//			$date2=date_create($w_buk_date);
//		$diff = $date2->diff($date1)->format("%a");
//			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id='$port_id' and buk_stat=1");
//			$tn_no=$get_last_d->result_array();
//			$t_n=$tn_no[0]['buk_time'];
//			if($diff<$t_n)
//			{
//
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Adhaar already exist!!!</div>');
//				redirect('Report/add_door_registrationnew');
//
//			}
//			else
//
//			{
//
//			//----------------------------------------------------------------------------------------------------
//
//		
//				if($this->form_validation->run() == FALSE)
//			{
//				validation_errors();
//
//
//				}
//
//			else
//
//			{
//
//
//				//$ip_address=$_SERVER['REMOTE_ADDR'];
//if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
//    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//}
//else {
//    $ip_address = $_SERVER["REMOTE_ADDR"];
//}
//			$port_id=html_escape($this->input->post('portdc'));
//				$txt_username=html_escape($this->input->post('txt_username'));
//				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//				$txt_phone=html_escape($this->input->post('txt_phone'));
//				$txt_ton=html_escape($this->input->post('txt_ton'));
//				$txt_place=html_escape($this->input->post('txt_place'));
//				$txt_route=html_escape($this->input->post('txt_route'));
//				$txt_distance=html_escape($this->input->post('txt_distance'));
//				$zone_id=html_escape($this->input->post('zone_id'));
//				$hid_otp=html_escape($this->input->post('hid_otp'));
//			$booking_type=html_escape($this->input->post('booking_type'));
//
//				//-------------------------------------------------------------------------------------	
//
//				/*	if($booking_type!="true")
//
//						{
//
//							$bookingtype=1;
//		
//
//						}
//
//						else
//
//						{*/
//
//							$bookingtype=2;
//
//							
//
//					//	}
//
//
//
//					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
//
//
//
//					if($hid_otp!='')
//
//					{
//
//						if($hid_otp!=$sess_otp)
//
//						{
//
//							redirect('Report/add_door_registrationnew');	
//
//
//						}
//
//
//
//					}
//
//
//
//					else
//
//
//
//					{
//
//						redirect('Report/add_door_registrationnew');	
//
//
//
//					}
//
//
//				//-----------------------limit check-------------------------------------------------------------
//
//
//						$today=date('Y-m-d');
//
//						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");
//
//				$ud=$queryspot->result_array();
//
//					//foreach($ud as $rowfetch)
//
//					//{
//
//
//					$limit_id=$ud[0]['spot_limit_id'];
//
//				$limitqty=$ud[0]['spot_limit_quantity'];
//
//				$limitbalance=$ud[0]['spot_limit_balance'];
//
//				//	}
//
//
//					if($limitbalance<$txt_ton)
//
//					{	
//
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//
//
//					 //redirect('Report/spot_registration_online');
//
//					redirect('Report/add_door_registrationnew');
//
//					}
//
//				else
//					{
//
//
//						/*$data_udt=array(
//
//					'spot_limit_balance'=>$limitbalance-$txt_ton,
//
//						);
//					$this->db->where('spot_limit_id',$limit_id);
//					$this->db->where('spot_limit_date',$today);
//					$this->db->where('spot_limit_port_id',$port_id);
//					$this->db->where('spot_limit_balance >', 0);
//				//print_r($data_udt);break;
//
//			$resultins=$this->db->update('spot_booking_limit', $data_udt);*/
//						//-------------------------------------------------------------------------------------------------
//
//
//				$period=date('F Y');
//
//				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//
//				$et_amount=$getrate_port->result_array();
//
//				$sand_amount=$et_amount[0]["s_amount"];
//
//			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//
//				$data_in=array(
//				'spot_cusname'=>$txt_username,
//				'spot_adhaar'=>$txt_adhaar,
//				'spot_phone'=>$txt_phone,
//				'spot_ton'=>$txt_ton,
//				'spot_unloading'=>$txt_place,
//				'spot_route'=>$txt_route,
//				'spot_distance'=>$txt_distance,
//				'spot_token'=>uniqid(),
//				'spot_challan'=>$challan_no,
//				'spot_amount'=>$challan_amount,
//				'spot_user'=>$sess_usr_id,
//				'spotbooking_ip_addr'=>$ip_address,
//					'port_id'=>$port_id,
//				'preferred_zone'=>$zone_id,
//				'spotbooking_status'=>2,
//				'spotbooking_dte'=>date('Y-m-d'),
//					'spotbuk_dteph'=>date('Y-m-d'),
//					'spot_booking_type'=>$bookingtype,
//
//				);
//
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//
//				//print_r($data_in);
//
//				$p_code=$getpdtaa[0]['intport_code'];
//
//		//--------------------------------------------------------------------------
//						
//		$this->db->trans_begin();
//						
//		//--------------------------------------------------------------------------
//		$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//				$getton=$get_ton->result_array();
//
//			$tonbooked=$getton[0]["spotton"];
//				
//				$tonspot=$limitqty-$tonbooked;
//				
//				
//				//-----------------------------------------------------------------------------------
//				 if($tonspot > 3)
//				 {				
//						
//						
//				if($tonspot>=$txt_ton)
//					{
//						$totbal=$tonspot-$txt_ton;
//
//
//						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//
//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//	
//				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
//					}
//						else
//				{
//					
//				
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
//
//}
//				else
//				{
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
//
////echo $this->db->last_query();
//
//
//
//				$buk_id=$this->db->insert_id();
//
//				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//	//	echo "WWWWWW". $tok_no;
//
//
//			$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//
//				$no=$gt_ch->num_rows();
//
//				if($no==0)
//
//				{
//
//					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
//
//								$data = array("OPCODE"=>"GETUID",
//										"TOKENNO"=>"$tok_no",
//											"PORTCODE"=>"$p_code",
//											"INSTCODE"=>"DOP",
//											"CHALLANAMOUNT"=>"$challan_amount",
//											);                                                                   
//
//						$data_string = json_encode($data);  
//								//exit; 
//							//echo $data_string;                                                                                 
//					$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');
//
//							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                   
//								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                               
//								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                    
//								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
//								'Content-Type: application/json',                                           
//								'Content-Length: ' . strlen($data_string))                                   
//
//								);                                                                               
//
//								$result = curl_exec($ch);
//
//							$myArray=json_decode($result, true);
//								$uid=$myArray['UID'];
//								$ifsc=$myArray['IFSC'];
//							if($uid=="")
//
//							{
//
//									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
//
//								redirect('Report/add_door_registrationnew');
//
//								}
//
//							else
//
//								{
//
//								$currentdate			=	date('Y-m-d H:i:s');
//							$data_trans=array('transaction_customer_registration_id'=>000,
//												'transaction_customer_booking_id'=>000,
//												'token_no'=>$tok_no,
//													'challan_no'=>$challan_no,
//													'challan_amount'=>$challan_amount,
//													'uid_no'=>$uid,
//													'ifsc_code'=>$ifsc,
//													'challan_timestamp'=>$currentdate,
//													'booking_timestamp'=>$currentdate,
//													'zone_id'=>000,
//													'port_id'=>$port_id,
//
//												);
//
//						$this->db->insert('transaction_details',$data_trans);
//					$this->session->unset_userdata('sess_spot_otp');			
//
//						$this->db->trans_commit();
//
//
//                          //echo encode_url($buk_id);
//
//
//
//						redirect('Report/customerspot_message/'.encode_url($buk_id));
//
//			//redirect('Report/getchallan/'.encode_url($buk_id));
//
//						//redirect('Report/spot_registration');
//
//								}
//
//				}
//
//
//				else
//
//
//				{
//
//
//					 $this->db->trans_rollback();
//
//					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//
//					 redirect('Report/spot_registration_online');
//
//				}
//
//
//			}//else limit
//
//
//		}//else validation
//
//
//		}//aadhar check else part else(diff<t_n)
//
//		}//aadhar check else part
//
//		//###############################################################################################
//
//		
//				$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_phone='$txt_phone' order by spotreg_id desc limit 0,1");
//
//				//echo $this->db->last_query();
//
//		$g_int=$get_intrvl->result_array();
//
//			if(count($g_int)==0)
//
//			{
//
//
//
//				if($this->form_validation->run() == FALSE)
//
//				{
//
//					validation_errors();
//		}
//
//				else
//		{
//
//				//$ip_address=$_SERVER['REMOTE_ADDR'];
//			if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
//    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//}
//else {
//    $ip_address = $_SERVER["REMOTE_ADDR"];
//}
//				$port_id=html_escape($this->input->post('portdc'));
//				$txt_username=html_escape($this->input->post('txt_username'));
//				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//				$txt_phone=html_escape($this->input->post('txt_phone'));
//				$txt_ton=html_escape($this->input->post('txt_ton'));
//				$txt_place=html_escape($this->input->post('txt_place'));
//				$txt_route=html_escape($this->input->post('txt_route'));
//				$txt_distance=html_escape($this->input->post('txt_distance'));
//				$zone_id=html_escape($this->input->post('zone_id'));
//					$hid_otp=html_escape($this->input->post('hid_otp'));
//			$booking_type=html_escape($this->input->post('booking_type'));
//				
//
//				//-------------------------------------------------------------------------------------	
//
//				/*	if($booking_type!="true")
//
//						{
//
//							$bookingtype=1;
//
//							
//
//						}
//
//						else
//
//						{*/
//
//							$bookingtype=2;
//					//	}
//
//					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
//					if($hid_otp!='')
//					{
//						if($hid_otp!=$sess_otp)
//						{
//							redirect('Report/add_door_registrationnew');	
//
//						}
//
//					}
//					else
//					{
//						redirect('Report/add_door_registrationnew');	
//
//					}
//
//				//-----------------------limit check----------------------------------------------------------------
//
//						$today=date('Y-m-d');
//
//						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
//
//
//				$ud=$queryspot->result_array();
//
//
//				//	foreach($ud as $rowfetch)
//
//				//	{
//
//
//					$limit_id=$ud[0]['spot_limit_id'];
//
//					$limitqty=$ud[0]['spot_limit_quantity'];
//					$limitbalance=$ud[0]['spot_limit_balance'];
//
//				//	}
//
//					if($limitbalance<$txt_ton)
//
//					{	
//
//
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//
//		// redirect('Report/spot_registration_online');
//
//
//					redirect('Report/add_door_registrationnew');
//
//
//					}
//
//
//					else
//
//					{
//
//						//-------------------------------------------------------------------------------------------------
//				$period=date('F Y');
//				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//
//			$et_amount=$getrate_port->result_array();
//			$sand_amount=$et_amount[0]["s_amount"];
//			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//				$data_in=array(
//			'spot_cusname'=>$txt_username,
//				'spot_adhaar'=>$txt_adhaar,
//				'spot_phone'=>$txt_phone,
//				'spot_ton'=>$txt_ton,
//				'spot_unloading'=>$txt_place,
//				'spot_route'=>$txt_route,
//				'spot_distance'=>$txt_distance,
//					'spot_token'=>uniqid(),
//				'spot_challan'=>$challan_no,
//				'spot_amount'=>$challan_amount,
//				'spot_user'=>$sess_usr_id,
//				'spotbooking_ip_addr'=>$ip_address,
//					'port_id'=>$port_id,
//			'preferred_zone'=>$zone_id,
//				'spotbooking_status'=>2,
//				'spotbooking_dte'=>date('Y-m-d'),
//					'spotbuk_dteph'=>date('Y-m-d'),
//					'spot_booking_type'=>$bookingtype,
//
//				);
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//
//				$p_code=$getpdtaa[0]['intport_code'];
//
//
//				$this->db->trans_begin();
//
////-----------------------------------------------------------------------------------
//			
//
//				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//				$getton=$get_ton->result_array();
//
//			$tonbooked=$getton[0]["spotton"];
//				
//				$tonspot=$limitqty-$tonbooked;
//				
//				
//				//-----------------------------------------------------------------------------------
//				 if($tonspot > 3)
//				 {
//						if($tonspot>=$txt_ton)
//					{
//						$totbal=$tonspot-$txt_ton;
//
//
//						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//
//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//	
//				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
//					}
//						else
//				{
//					
//				
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
//					 
//					  }
//				else
//				{
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
//				$buk_id=$this->db->insert_id();
//					 
//				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//
//
//				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//
//
//
//				$no=$gt_ch->num_rows();
//
//				if($no==0)
//
//				{
//
//					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
//					$data = array("OPCODE"=>"GETUID",
//
//											"TOKENNO"=>"$tok_no",
//
//											"PORTCODE"=>"$p_code",
//
//											"INSTCODE"=>"DOP",
//
//											"CHALLANAMOUNT"=>"$challan_amount",
//					);                                                                    
//
//
//							$data_string = json_encode($data);  
//
//
//
//					$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');
//
//								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                   
//
//								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                
//
//								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//
//								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                    
//
//								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
//									'Content-Type: application/json',                                           
//
//									'Content-Length: ' . strlen($data_string))                                   
//
//
//								);                                                                               
//
//								$result = curl_exec($ch);
//								$myArray=json_decode($result, true);
//								$uid=$myArray['UID'];
//
//								$ifsc=$myArray['IFSC'];
//
//								if($uid=="")
//
//
//								{
//
//									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
//
//
//									redirect('Report/add_door_registrationnew');
//
//
//								}
//
//								else
//
//
//								{
//
//								$currentdate			=	date('Y-m-d H:i:s');
//
//	$data_trans=array('transaction_customer_registration_id'=>000,
//						'transaction_customer_booking_id'=>000,
//						'token_no'=>$tok_no,
//					  	'challan_no'=>$challan_no,
//					  'challan_amount'=>$challan_amount,
//					  'uid_no'=>$uid,
//					  'ifsc_code'=>$ifsc,
//					  'challan_timestamp'=>$currentdate,
//					'booking_timestamp'=>$currentdate,
//					'zone_id'=>000,
//					'port_id'=>$port_id,
//					);
//
//
//						$this->db->insert('transaction_details',$data_trans);
//						$this->session->unset_userdata('sess_spot_otp');					
//
//						$this->db->trans_commit();
//
//						//echo encode_url($buk_id);
//
//						redirect('Report/customerspot_message/'.encode_url($buk_id));
//
//						
//
//								}
//
//				}
//
//
//				else
//
//				{
//
//					 $this->db->trans_rollback();
//
//					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//
//
//					// redirect('Report/spot_registration_online');
//
//					redirect('Report/add_door_registrationnew');
//
//				}
//
//
//			}//else limit
//
//
//
//				}//echo 0;
//
//
//
//			}
//
//
//			else
//
//			{
//
//			 $today=date('Y-m-d h:i:s');
//	 $w_buk_date=$g_int[0]['spot_timestamp'];
//
//			$date1=date_create($today);
//			$date2=date_create($w_buk_date);
//			$diff = $date2->diff($date1)->format("%a");
//
//			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id=0 and buk_stat=1");
//
//			$tn_no=$get_last_d->result_array();
//
//
//			$t_n=$tn_no[0]['buk_time'];
//
//
//			if($diff<$t_n)
//
//
//			{
//
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Phone already exist!!!</div>');
//				redirect('Report/add_door_registrationnew');
//
//			}
//
//			else
//
//
//			{
//
//	//---------------------------------------------------------------------------------------------------
//
//				if($this->form_validation->run() == FALSE)
//
//				{
//
//		validation_errors();
//
//
//				}
//
//
//				else
//
//			{
//
//				//$ip_address=$_SERVER['REMOTE_ADDR'];
//				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
//    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//}
//else {
//    $ip_address = $_SERVER["REMOTE_ADDR"];
//}
//				$port_id=html_escape($this->input->post('portdc'));
//
//				$txt_username=html_escape($this->input->post('txt_username'));
//
//				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//
//				$txt_phone=html_escape($this->input->post('txt_phone'));
//
//				$txt_ton=html_escape($this->input->post('txt_ton'));
//
//				$txt_place=html_escape($this->input->post('txt_place'));
//
//				$txt_route=html_escape($this->input->post('txt_route'));
//
//				$txt_distance=html_escape($this->input->post('txt_distance'));
//
//				$zone_id=html_escape($this->input->post('zone_id'));
//
//				$hid_otp=html_escape($this->input->post('hid_otp'));
//
//$booking_type=html_escape($this->input->post('booking_type'));
//
//				//-------------------------------------------------------------------------------------	
//
//					/*if($booking_type!="true")
//
//						{
//
//							$bookingtype=1;
//
//							
//
//						}
//
//						else
//
//						{*/
//
//						$bookingtype=2;
//						
//
//				//		}
//
//					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
//					if($hid_otp!='')
//					{
//						if($hid_otp!=$sess_otp)
//
//						{
//
//							redirect('Report/add_door_registrationnew');	
//
//						}
//
//					}
//
//					else
//					{
//						redirect('Report/add_door_registrationnew');	
//
//					}
//		//-----------------------limit check----------------------------------------------------------------
//
//						$today=date('Y-m-d');
//
//
//						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");
//
//				$ud=$queryspot->result_array();
//
//					//foreach($ud as $rowfetch)
//
//
//					//{
//
//
//					$limit_id=$ud[0]['spot_limit_id'];
//
//					$limitqty=$ud[0]['spot_limit_quantity'];
//
//					$limitbalance=$ud[0]['spot_limit_balance'];
//
//
//					//}
//
//
//					if($limitbalance<$txt_ton)
//
//					{	
//
//
//
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//
//
//					redirect('Report/add_door_registrationnew');
//
//					}
//
//					else
//
//
//
//					{
//
//
//						//-------------------------------------------------------------------------------------------------
//
//
//				$period=date('F Y');
//
//				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//
//
//				$et_amount=$getrate_port->result_array();
//
//
//				$sand_amount=$et_amount[0]["s_amount"];
//
//			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//
//
//
//				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//
//				$data_in=array(
//
//				'spot_cusname'=>$txt_username,
//
//				'spot_adhaar'=>$txt_adhaar,
//
//				'spot_phone'=>$txt_phone,
//
//				'spot_ton'=>$txt_ton,
//
//				'spot_unloading'=>$txt_place,
//
//				'spot_route'=>$txt_route,
//
//				'spot_distance'=>$txt_distance,
//
//				'spot_token'=>uniqid(),
//
//				'spot_challan'=>$challan_no,
//
//				'spot_amount'=>$challan_amount,
//
//				'spot_user'=>$sess_usr_id,
//
//				'spotbooking_ip_addr'=>$ip_address,
//					'port_id'=>$port_id,
//
//				'preferred_zone'=>$zone_id,
//
//				'spotbooking_status'=>2,
//
//				'spotbooking_dte'=>date('Y-m-d'),
//
//				'spotbuk_dteph'=>date('Y-m-d'),
//
//					'spot_booking_type'=>$bookingtype,
//
//				);
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//
//
//
//				//print_r($data_in);
//
//				$p_code=$getpdtaa[0]['intport_code'];
//
//
//
//
//			//--------------------------------------------------------------------------	
//
//				$this->db->trans_begin();
//						
//			//-----------------------------------------------------------------------------------
//			
//
//				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//				$getton=$get_ton->result_array();
//
//			$tonbooked=$getton[0]["spotton"];
//				
//				$tonspot=$limitqty-$tonbooked;
//				
//				
//				//-----------------------------------------------------------------------------------
//				 if($tonspot > 3)
//				 {
//							
//						
//if($tonspot>=$txt_ton)
//					{
//						$totbal=$tonspot-$txt_ton;
//
//
//						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//
//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//	
//				$insert_customer_booking=$this->db->insert('tbl_spotbooking', $data_in);
//					}
//						else
//				{
//					
//				
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
// }
//				else
//				{
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_door_registrationnew');
//				}
//
//
////echo $this->db->last_query();
//
//
//
//				$buk_id=$this->db->insert_id();
//
//
//				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//
//
//
//			//	echo "WWWWWW". $tok_no;
//
//
//
////
//
//
//
//			//	exit;
//
//
//				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//
//
//				$no=$gt_ch->num_rows();
//
//
//
//				if($no==0)
//
//
//
//				{
//
//
//
//					$this->db->query("update tbl_spotbooking set spot_token='$tok_no' where spotreg_id='$buk_id'");
//				$data = array("OPCODE"=>"GETUID",
//
//											"TOKENNO"=>"$tok_no",
//
//											"PORTCODE"=>"$p_code",
//
//											"INSTCODE"=>"DOP",
//
//											"CHALLANAMOUNT"=>"$challan_amount",
//
//											);                                                                    
//
//							$data_string = json_encode($data);  
//
//
//								//exit; 
//
//
//								//echo $data_string;                                                                                 
//
//					$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');
//
//
//								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                         curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                
//								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                         
//								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
//									'Content-Type: application/json',                                    'Content-Length: ' . strlen($data_string))                                   
//								);                                                                               
//								$result = curl_exec($ch);
//								$myArray=json_decode($result, true);
//								$uid=$myArray['UID'];
//								$ifsc=$myArray['IFSC'];
//								if($uid=="")
//
//
//								{
//
//									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
//									redirect('Report/add_door_registrationnew');
//								}
//
//								else
//							{
//
//								$currentdate			=	date('Y-m-d H:i:s');
//							$data_trans=array('transaction_customer_registration_id'=>000,
//													'transaction_customer_booking_id'=>000,
//													'token_no'=>$tok_no,
//													'challan_no'=>$challan_no,
//													'challan_amount'=>$challan_amount,
//													'uid_no'=>$uid,
//													'ifsc_code'=>$ifsc,
//													'challan_timestamp'=>$currentdate,
//												'booking_timestamp'=>$currentdate,
//													'zone_id'=>000,
//													'port_id'=>$port_id,
//
//												);
//
//						$this->db->insert('transaction_details',$data_trans);
//
//	
//								$this->session->unset_userdata('sess_spot_otp');
//
//						$this->db->trans_commit();
//
//
//                          //echo encode_url($buk_id);
//
//
//
//						redirect('Report/customerspot_message/'.encode_url($buk_id));
//						//redirect('Report/getchallan/'.encode_url($buk_id));
//						//redirect('Report/spot_registration');
//
//								}
//
//				}
//
//			else
//
//				{
//
//					 $this->db->trans_rollback();
//					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//					redirect('Report/add_door_registrationnew');
//
//				}
//
//			}//else limit
//
//		}//else validation
//
//		}//phone check else part else(diff<t_n)
//
//		}//phone check else part
//
//	//-#################################################################################################		
//		} //post check
//
//		} //time check if close
//
//		else{ 
//
//		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//
//					// redirect('Report/spot_registration_online');
//
//									redirect('Report/add_door_registrationnew');
//					 }
//			$this->load->view('template/header');
//			$this->load->view('Report/door_registration_online',$data);
//			$this->load->view('template/footer');
//			$this->load->view('template/js-footer');
//			$this->load->view('template/script-footer');
//			$this->load->view('template/html-footer');
//
//		//}
//
//		//else
//
//
//	//	{
//
//		//	redirect('Main_login/index');       
//
//
//	//	}
//
//
//	}
//	
//------------------------------------------------------------------------------------------
	public function getqtyspot()
	{
		$port_id		    =$this->security->xss_clean(html_escape($this->input->post('port_id')));
		$zone_id		    =$this->security->xss_clean(html_escape($this->input->post('zone_id')));

		$this->load->model('Manual_dredging/Master_model');	
		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 
		$zonespot=$this->Master_model->get_zone_spot($port_id);
			//$data['zone_id']	=	$zonespot['zone_id'];

		$data['port_id']	=	$port_id;
		$data 				= 	$data + $this->data;
		$get_quantity_details= $this->Master_model->get_quantity_detailswk($port_id);
				//print_r($get_quantity_details);
		$data['get_quantity_details']=$get_quantity_details; 
		$data 				= 	$data + $this->data;
		$qty=$this->Master_model->get_quantity_masterPD();
				//print_r($qty);
		$data['qty']=$qty;
		$data 				= 	$data + $this->data;
		$data['zone_id']	=	$zone_id;
		$qrybalance=$this->Master_model->get_limit_balance($port_id,$zone_id);
		$data['balanceton']=$qrybalance[0]['spot_limit_balance'];	

				$this->load->view('Manual_dredging/Report/showqtyspot', $data);
	}

public function customerspot_message()

	{
			//$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
			$id			=		decode_url($id);		
			$this->load->model('Manual_dredging/Master_model');	
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data; 
		$getcustomerreg_message=$this->Master_model->customer_spot_msg($id);
		$data['getcustomerreg_message']=$getcustomerreg_message;
			$data = $data + $this->data;
			//$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			//	$data['user_header']=	$u_h_dat;
			//	$data 				= 	$data + $this->data;
				$this->load->view('template/header');
			$this->load->view('Manual_dredging/Report/customerspot_message',$data);
			$this->load->view('Kiv_views/template/dash-footer');
	}
	public function spotlimit_view()
	{
	$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
			$this->load->model('Manual_dredging/Master_model');	
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
				$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];
			$cnst				= 	$this->Master_model->get_limit_port($port_id);
		$data['cnst']		=	$cnst;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/spotlimit_view', $data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}
	   	else

	   	{

			redirect('Main_login/index');        

  		}  	

	}
public function add_spot_limit()
	{

		$sess_usr_id 			= $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];

//----------------------------------------------------------------------------

			$spot_zone=$this->db->query("select * from zone join spot_kadavu on zone.zone_id=spot_kadavu.zone_id where zone.zone_port_id='$port_id'");
			$data['zone']=$spot_zone->result_array();
			$data 				= 	$data + $this->data;
//----------------------------------------------------------------------------------------------------
			$data_zone=$this->db->query("SELECT * FROM zone where zone_port_id='$port_id'");
			$data['date_zone']=$data_zone->result_array();
			$data 				= 	$data + $this->data;
			  $bookingtime_data= $this->Master_model->customerspotbooking_timecheck();
			$starttime=$bookingtime_data[0]['spotbooking_master_start'];
			$endtime=$bookingtime_data[0]['spotbooking_master_end'];
			$start_time=strtotime($starttime);
			$end_time=strtotime($endtime);
			//echo date_default_timezone_get();
			//echo date('Y-M-d h:i:s');
		//exit;
			$current_time=strtotime("now");
		if($current_time <= $start_time)
		{
			if($this->input->post())
			{
			$zone_id=$this->security->xss_clean(html_escape($this->input->post('txt_zone')));
			$dateassign=date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('date_int'))));
			//$dateassign=$this->input->post('date_int');
			$quantity=$this->security->xss_clean(html_escape($this->input->post('txtquantity')));
			$bookingcount=$this->security->xss_clean(html_escape($this->input->post('txtbookingcount')));
			//$checkdata=$this->Master_model->get_limit_balancedate($port_id,$dateassign);
		$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$dateassign'");
		//echo $this->db->last_query();exit();
			$checkdata=$this->db->affected_rows();
			//print_r($checkdata);break;
			if($checkdata==0)
			{
				if($port_id==10)
				{
				$data_in=array('spot_limit_port_id'=>$port_id,
				'spot_limit_zone_id'=>$zone_id,
				'spot_limit_date'=>$dateassign,
				'spot_limit_quantity'=>$quantity,
				'spot_limit_balance'=>$quantity,
				'generalbooking_count'=>$bookingcount,
				'updated_userid'=>$sess_usr_id
				);
				}
				else
				{
				$data_in=array('spot_limit_port_id'=>$port_id,
				'spot_limit_zone_id'=>$zone_id,
				'spot_limit_date'=>$dateassign,
				'spot_limit_quantity'=>$quantity,
				'spot_limit_balance'=>$quantity,
				'updated_userid'=>$sess_usr_id
				);
				}
				//print_r($data_in);break;
				$resultins=$this->db->insert('spot_booking_limit',$data_in);
			}
				else
				{
				$this->session->set_flashdata('msg', '<div class="alert alert-info alert-danger">Error,Spot Limit Failed...... !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
				/*$ud=$queryspot->result_array();
					foreach($ud as $rowfetch)
					{
					$limit_id=$rowfetch['spot_limit_id'];
					$limitqty=$rowfetch['spot_limit_quantity'];
					$limitbalance=$rowfetch['spot_limit_balance'];
				}
					$data_udt=array(
				'spot_limit_quantity'=>$limitqty+$quantity,
				'spot_limit_balance'=>$limitbalance+$quantity
				);
				$this->db->where('spot_limit_id',$limit_id);
				$this->db->where('spot_limit_date',$dateassign);
				$this->db->where('spot_limit_port_id',$port_id);
				$this->db->where('spot_limit_balance >', 0);kk
				//print_r($data_udt);break;
				$resultins=$this->db->update('spot_booking_limit', $data_udt);*/
				}
				if($resultins)
				{

				$this->session->set_flashdata('msg', '<div class="alert alert-info alert-success"> Spot Limit added Successfully !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
				}
				else
				{
				$this->session->set_flashdata('msg', '<div class="alert  alert-danger">Error,Spot Limit Failed...... !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
				}
			}
		}
			else
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-info alert-danger">Not allow to add Spot Limit ...... !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
		}
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			if($port_id==10)
			{
				$this->load->view('Manual_dredging/Report/add_spot_limitazk',$data);
			}
			else
			{
					$this->load->view('Manual_dredging/Report/add_spot_limit',$data);
			}
			
			$this->load->view('Kiv_views/template/dash-footer');
	}
	else
		{
			redirect('Main_login/index');        

		}
	}
	public function add_spot_limitold()
	{

		$sess_usr_id 			= $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id'];

//----------------------------------------------------------------------------

			$spot_zone=$this->db->query("select * from zone join spot_kadavu on zone.zone_id=spot_kadavu.zone_id where zone.zone_port_id='$port_id'");
			$data['zone']=$spot_zone->result_array();
			$data 				= 	$data + $this->data;
//----------------------------------------------------------------------------------------------------
			$data_zone=$this->db->query("SELECT * FROM zone where zone_port_id='$port_id'");
			$data['date_zone']=$data_zone->result_array();
			$data 				= 	$data + $this->data;
			  $bookingtime_data= $this->Master_model->customerspotbooking_timecheck();
			$starttime=$bookingtime_data[0]['spotbooking_master_start'];
			$endtime=$bookingtime_data[0]['spotbooking_master_end'];
			$start_time=strtotime($starttime);
			$end_time=strtotime($endtime);
			//echo date_default_timezone_get();
			//echo date('Y-M-d h:i:s');
		//exit;
			$current_time=strtotime("now");
		if($current_time <= $start_time)
		{
			if($this->input->post())
			{
			$zone_id=$this->security->xss_clean(html_escape($this->input->post('txt_zone')));
			$dateassign=date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('date_int'))));
			//$dateassign=$this->input->post('date_int');
			$quantity=$this->security->xss_clean(html_escape($this->input->post('txtquantity')));
			//$checkdata=$this->Master_model->get_limit_balancedate($port_id,$dateassign);
		$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$dateassign'");
		//echo $this->db->last_query();exit();
			$checkdata=$this->db->affected_rows();
			//print_r($checkdata);break;
			if($checkdata==0)
			{
				$data_in=array('spot_limit_port_id'=>$port_id,
				'spot_limit_zone_id'=>$zone_id,
				'spot_limit_date'=>$dateassign,
				'spot_limit_quantity'=>$quantity,
				'spot_limit_balance'=>$quantity,
				'updated_userid'=>$sess_usr_id
				);
				//print_r($data_in);break;
				$resultins=$this->db->insert('spot_booking_limit',$data_in);
			}
				else
				{
				$this->session->set_flashdata('msg', '<div class="alert alert-info alert-danger">Error,Spot Limit Failed...... !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
				/*$ud=$queryspot->result_array();
					foreach($ud as $rowfetch)
					{
					$limit_id=$rowfetch['spot_limit_id'];
					$limitqty=$rowfetch['spot_limit_quantity'];
					$limitbalance=$rowfetch['spot_limit_balance'];
				}
					$data_udt=array(
				'spot_limit_quantity'=>$limitqty+$quantity,
				'spot_limit_balance'=>$limitbalance+$quantity
				);
				$this->db->where('spot_limit_id',$limit_id);
				$this->db->where('spot_limit_date',$dateassign);
				$this->db->where('spot_limit_port_id',$port_id);
				$this->db->where('spot_limit_balance >', 0);kk
				//print_r($data_udt);break;
				$resultins=$this->db->update('spot_booking_limit', $data_udt);*/
				}
				if($resultins)
				{

				$this->session->set_flashdata('msg', '<div class="alert alert-info alert-success"> Spot Limit added Successfully !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
				}
				else
				{
				$this->session->set_flashdata('msg', '<div class="alert  alert-danger">Error,Spot Limit Failed...... !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
				}
			}
		}
			else
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-info alert-danger">Not allow to add Spot Limit ...... !</div>');
				redirect('Manual_dredging/Report/spotlimit_view');
		}
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/add_spot_limit',$data);
			$this->load->view('Kiv_views/template/dash-footer');
	}
	else
		{
			redirect('Main_login/index');        

		}
	}
	/*public function getspotton()
	{
				$port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));
				$zone_id		    =	$this->security->xss_clean(html_escape($this->input->post('zone_id')));
				$req_ton		    =	$this->security->xss_clean(html_escape($this->input->post('ton')));
				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
				$data 				= 	$data + $this->data; 
				$today=date('Y-m-d');
				$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today' and spot_limit_balance>='$req_ton'");
				$checkdata=$this->db->affected_rows();
				//print($checkdata);//break;
				if($checkdata==0){echo 1;}else{echo 2;}
				//$this->load->view('Report/showqtyspot', $data);
	}*/
	
	public function getspottonold()
	{
				$port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));
				$zone_id		    =	$this->security->xss_clean(html_escape($this->input->post('zone_id')));
				$req_ton		    =	$this->security->xss_clean(html_escape($this->input->post('ton')));
				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
				$data 				= 	$data + $this->data; 
				$today=date('Y-m-d');
				$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today' ");
				//$checkdata=$this->db->affected_rows();
				//print($checkdata);//break;
			$ud=$queryspot->result_array();
			$limitbalance=$ud[0]['spot_limit_balance'];
			$bookingcount=$ud[0]['spot_limit_count'];
		$balton=$limitbalance-$req_ton;
				//if($checkdata==0)
		if($limitbalance<=$req_ton)
		{
					echo 1;
				}
				else
				{
		$this->db->query("update spot_booking_limit set spot_limit_balance=$balton where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id'");
				echo 2;
				}
				//$this->load->view('Report/showqtyspot', $data);
	}
	//----------------------------------------------------------------------------------
	public function getspotton()
	{
		
			$port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));
			$zone_id		    =	$this->security->xss_clean(html_escape($this->input->post('zone_id')));
			$req_ton		    =	$this->security->xss_clean(html_escape($this->input->post('ton')));
			
			$today=date('Y-m-d');
			$tabletot=0;
		
		$getintrvl=$this->db->query("select * from tbl_spotbooking_temp where spotbooking_dte='$today' and port_id='$port_id' and preferred_zone='$zone_id'and lorry_type=2");
		//echo "select * from tbl_spotbooking  where spotbooking_dte='$today' and port_id='$port_id' and preferred_zone='$zone_id'and lorry_type=2";//
			$g_int=$getintrvl->result_array();
		//print_r($g_int);
		//exit;
		$tabletot=count($g_int); 
		
				$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");
				//$checkdata=$this->db->affected_rows();
				//print($checkdata);//break;
			$ud=$queryspot->result_array();
			$limitbalance=$ud[0]['spot_limit_balance'];
			$bookingcount=$ud[0]['generalbooking_count'];
			$balton=$limitbalance-$req_ton;
				//if($checkdata==0)
		if($limitbalance<=$req_ton)
		{
			echo 1;
		}
		else
		{
					
				$this->db->query("update spot_booking_limit set spot_limit_balance=$balton where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id'");
					
					
					if($bookingcount!=0 && ($bookingcount > $tabletot))
					{
						$vehicledet=2;
		               $data['portid']=$port_id;
						$data['zoneid']=$zone_id;
						$data['lorrydet']=$vehicledet;
						$data=$data+$this->data;
						
						$this->load->view('Manual_dredging/Report/vehicledet_spot', $data);
					}
					else if($bookingcount <= $tabletot)
					{
						$data['portid']=$port_id;
						$data['zoneid']=$zone_id;
						$vehicledet=1;
						$data['lorrydet']=$vehicledet;
						$data=$data+$this->data;
						
						$this->load->view('Manual_dredging/Report/vehicledet_spot', $data);
					}
					
				}
				//$this->load->view('Report/showqtyspot', $data);
	}
	//----------------------------------------------------------------------------------
	public function spot_status()

	{
		$this->load->model('Manual_dredging/Reports_model');
		
		/*$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==5)
		{
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
		$port_id			=	$userinfo[$i]['user_master_port_id'];
			$p_name=$this->Master_model->get_port_By_PC($port_id);
			$port_name=$p_name[$i]['vchr_portoffice_name'];*/
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			/*$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;*/
			$zone_stat=$this->Reports_model->get_portspot_status();
			$data['spot_stat']=$zone_stat;
			$data 				= 	$data + $this->data;
		$zone_stat=$this->Reports_model->get_portspot_statusnew();
			$data['spot_statnew']=$zone_stat;
			$data 				= 	$data + $this->data;

			$this->load->view('Kiv_views/Registration/header_reg.php');
			$this->load->view('Manual_dredging/Report/spot_stat',$data);
			$this->load->view('Kiv_views/template/dash-footer');
			
			/*$this->load->view('template/header');
			$this->load->view('Manual_dredging/Report/spot_stat',$data);
			$this->load->view('Kiv_views/template/dash-footer');*/

		/*}
		else
		{
			redirect('Main_login/index');        
		}*/
	}
	public function getzones_for_spot()
	{
			    $port_id		    =	$this->security->xss_clean(html_escape($this->input->post('port_id')));
				$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
				$data 				= 	$data + $this->data;     
				$zone				= 	$this->Master_model->get_zone_spot($port_id);
				$data['zone']		=	$zone;
				$data 				= 	$data + $this->data;
				$this->load->view('Manual_dredging/Report/showspotzone', $data);
	}
	//-------------------------------------------------------------------------------------------------------------------	
	public function get_interval_statspot()
	{
	//$sess_usr_id 			=  $this->session->userdata('int_userid');
		//if(!empty($sess_usr_id))
		//{
		//	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			//$port_id			=	$userinfo[$i]['user_master_port_id'];
			$txt_adhar=$this->security->xss_clean(html_escape($this->input->post('txt_adhar')));
			$port_id=$this->security->xss_clean(html_escape($this->input->post('port_id')));
			$todayn=date('Y-m-d');
		//	$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhar' and `spot_timestamp` LIKE '%$todayn%' order by spotreg_id desc limit 0,1");
			$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhar' order by spotreg_id desc limit 0,1");
			$g_int=$get_intrvl->result_array();
			if(count($g_int)==0)
			{
				echo 0;
			}
			else
			{
			$today=date('Y-m-d h:i:s');
			$w_buk_date=$g_int[0]['spot_timestamp'];
			$date1=date_create($today);
			$date2=date_create($w_buk_date);
			$diff = $date2->diff($date1)->format("%a");
			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id='$port_id' and buk_stat=1");
			$tn_no=$get_last_d->result_array();
			$t_n=$tn_no[0]['buk_time'];
			if($diff<$t_n)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
			}
		//}
	}
	//-------------------------------------------------------------------------------
	public function resend_view()
    {
        $sess_usr_id = $this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	
			//$id			=		$this->uri->segment(3);
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
		//	print_r($customerAppvd_data);
		$cus_phone_number=$customerAppvd_data[0]['customer_phone_number'];
			//$cus_phone_number='9747412220';
		$portcode=$this->Master_model->get_portcode($portid);
			$data['portcode']=$portcode;
		$data = $data + $this->data; 
			if($this->input->post())
			{
			$txtcustrname=$this->security->xss_clean(html_escape($this->input->post('txtcustrname')));
			$cust_pass=$this->input->post('txtcustrpassword');
			$cus_phone_number=$this->input->post('txtmobnumber');
			$txtcustrhashpassword=$this->phpass->hash($this->input->post('txtcustrpassword'));
			//$txtcustrconfpassword=$this->phpass->hash($this->input->post('txtcustrconfpassword'));
			$hid_usermasterid=$this->input->post('hid_usermasterid');
			$hid_usermasterid=decode_url($hid_usermasterid);
			//exit();
			//$hid_usermasterid=url_decode($hid_usermasterid);
			//print_r($hid_usermasterid);
			$currentdate=date('Y-m-d H:i:s');
			$update_data=array(
				'user_master_name'	=>	$txtcustrname,
			'user_master_password'	=>$txtcustrhashpassword);
			$customerregupt_data= $this->Master_model->update_usermaster($update_data,$hid_usermasterid);
			//print_r($customerregupt_data);break;
				if($customerregupt_data==1)
				{
				//$this->emailSendFun('',,'','');
						/*$message2="Your Registration Approved Successfully<br>
						User Name : ".$txtcustrname."<br>
						Password  : ".$cust_pass;*/
	 $message="Your Port Registration Approved successfully Please note the login details and change it on first login.%0aUsername ".$txtcustrname."%0aPassword  ".$cust_pass;
//echo $cus_phone_number;
//exit;
						$this->sendSms($message,$cus_phone_number);
						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Customer Credentials send successfully</div>');
						redirect('Manual_dredging/Master/customer_login');
				}
				else
				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error failed!!!</div>');

					redirect('Manual_dredging/Master/customer_login');

				}

			}
			$this->load->view('Manual_dredging/Report/resend_view', $data);
			$this->load->view('Kiv_views/template/dash-footer');

		}
		else
		{

				redirect('Manual_dredging/settings/index');        
		}
    }
	//-------------------------------------------------------------------------------
	public function pc_user_changephno()
{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
			$this->load->model('Manual_dredging/Master_model');	
			$this->load->model('Manual_dredging/Reports_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$usert				= 	$this->Reports_model->get_user_typeph();
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
				//$this->load->view('template/header',$data);
				$this->load->view('Kiv_views/template/dash-header');
                $this->load->view('Kiv_views/template/nav-header');
                $this->load->view('Manual_dredging/Report/pcphone_change', $data);
                $this->load->view('Kiv_views/template/dash-footer');
			if($this->input->post())

			{
				$usertype=$this->security->xss_clean(html_escape($this->input->post('int_ut')));
				$txtuserid=$this->security->xss_clean(html_escape(('int_userid')));
				$phnoold=$this->security->xss_clean(html_escape($this->input->post('vch_oldph')));
				$phnonew=$this->security->xss_clean(html_escape($this->input->post('vch_newph')));
			   //$ip_address=$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
				//$msg="Username :- $un  and Password:- $pw";
				$data_array=array(
					'user_master_ph'=>$phnonew
				);
				$result	= $this->Master_model->up_pw($data_array,$txtuserid);
				if(isset($result))
				{
				$data_in=array(
					'ofc_new_phno'=>$phnonew,
					'ofc_old_phone'=>$phnoold,
					'user_id'=>$txtuserid,
					'user_ip'=>$ip_address,
					);

					$this->db->insert('tbl_offcialphone_change',$data_in);
				$msg="Dear Portinfo 2 user your mobile number has been updated to $phnonew, please contact port office if change was not made on your request";
					//$msgg="Dear Port User please note your login information";
			$this->sendSms($msg,$phnonew);
					//$this->emailSendFun('manualdredging@gmail.com',$email,$sub,$msg);
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Port User added successfully</div>');
					redirect('Manual_dredging/Report/pc_user_changephno');

				}
				else

				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Port User add failed!!!</div>');
					redirect('Manual_dredging/Report/pc_user_changephno');
				}

			}

	   	}
	   	else

	   	{

			redirect('Main_login/index');        
  		}  	

}

	//-------------------------------------------------------------------------------

	public function get_userdataAjax()

	{
				$this->load->model('Manual_dredging/Master_model');
				$this->load->model('Manual_dredging/Reports_model');
				$sess_usr_id 			= 	$this->session->userdata('int_userid');
	 			$usertype		    =	$this->security->xss_clean(html_escape($this->input->post('usertype')));
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

				$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
			$getdata_userttype=$this->Reports_model->get_userdet($port_id,$usertype);
			$data['getdata_userttype']		=	$getdata_userttype;
				$data 				= 	$data + $this->data;
				$this->load->view('Manual_dredging/Report/showsuserdetails', $data);
	}
	//-------------------------------------------------------------
	public function get_zusrphAjax()
{
	$i=0;
	$this->load->model('Manual_dredging/Master_model');	
	$user_id=$this->security->xss_clean(html_escape($this->input->post('userid')));
	$userinfo			=	$this->Master_model->getuserinfo($user_id);
	//print_r($cnt);
	$oldphoneno=$userinfo[0]['user_master_ph'];
	//$un=$zone_code."_".$count;
	echo $oldphoneno;
}

//**********************************************************
	public function customer_booking_request()

    {
    	ini_set('display_errors', 1);
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{
			$this->load->model('Manual_dredging/Master_model');	
			$this->load->model('Manual_dredging/Reports_model');

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;  
			$customerreg_booking= $this->Reports_model->get_request_booked($sess_usr_id);
			$data['cust_book_his']=$customerreg_booking;
			$data = $data + $this->data;    
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$cus_bal=$this->db->query("select customer_allotted_ton,customer_used_ton,customer_unused_ton from customer_registration where customer_public_user_id='$sess_usr_id'");
			//echo $this->db->last_query();exit();
			$cust_bal=$cus_bal->result_array();
			$data['cus_bal']=$cust_bal;
			$data 	= 	$data + $this->data;
			//$this->output->enable_profiler(TRUE);
			$this->load->view('Manual_dredging/Report/customer_booking_request', $data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  
	}
	//-----------------------------------------------------------------
	public function customerbooked_request()
	{

	$sess_usr_id 			= 	$this->session->userdata('int_userid');
		 	//$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
			 $bookingid			=		decode_url($id);		
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');	
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data; 
		$getcustomerreq_booked=$this->Reports_model->requestbooking_again($bookingid);
		//print_r($getcustomerreq_booked);break;
		$data['$getcustomerreq_booked']=$getcustomerreq_booked;
		$portid=$getcustomerreq_booked[0]['customer_booking_port_id'];
		$zoneid=$getcustomerreq_booked[0]['customer_booking_zone_id'];
		$booking_id=$getcustomerreq_booked[0]['customer_booking_id'];
		//$ip_address=$_SERVER['REMOTE_ADDR'];
		if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
		$this->db->query("update customer_booking set customer_booking_request_status=1 where customer_booking_id='$booking_id'");
		$data_ins=array( 'customer_bookingid'=>$booking_id,
						'port_id'=>$portid,
						'zone_id'=>$zoneid,
						'requested_user_id'=>$sess_usr_id,
						 'request_ip_address'=>$ip_address);
	//	print_r($data_ins);break;
		$insert_tbl=$this->db->insert('customer_book_request',$data_ins);
		//print_r($insert_tbl);
		if($insert_tbl==1)
		{
			$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Booking request successfully</div>');
		redirect('Manual_dredging/Report/customer_booking_request');
		}

		else{
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error failed!!!</div>');
			redirect('Manual_dredging/Report/customer_booking_request');
		}
			//$data = $data + $this->data;
			//$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			//	$data['user_header']=	$u_h_dat;
			//	$data 				= 	$data + $this->data;
				$this->load->view('template/header');
			$this->load->view('Manual_dredging/Report/customer_booking_request',$data);
			$this->load->view('Kiv_views/template/dash-footer');
	}
	//***************************************************************************************
	public function checkvehicleblocked()
	{
		$vehicle_regno=$this->security->xss_clean(html_escape($this->input->post('vehicleregno')));
		$blockedarray=$this->db->query("select * from tbl_lorry where status='2'");
			$blocked_array=$blockedarray->result_array();
		echo $blocked_array;

	}
	//***************************************************************************************
	public function secondrequest_booking_pc_paid()
    {
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	$this->load->model('Manual_dredging/Master_model');	
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;  
		// $zonep_id=decode_url($this->uri->segment(3));
		 $zonep_id=decode_url($this->uri->segment(4));
			if($zonep_id > 0)
			{
			$data['pass_zoneid']=$zonep_id;
				$data = $data + $this->data;
			}
			$zone				= 	$this->Master_model->get_zone_acinP($port_id);
			$data['zone']		=	$zone;
			$data 				= 	$data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/sec_customer_pc', $data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}

	   	else
	   	{

			redirect('Main_login/index');        

  		}  

    }

	public function sec_customer_booking_pc_ajax()

		    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	
			$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));
			$this->load->model('Manual_dredging/Master_model');	
			$this->load->model('Manual_dredging/Reports_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;  
			//$customerreg_booking= $this->Master_model->get_all_buk_pay_suc($zone_id);
			$customerreg_booking= $this->Reports_model->get_all_buk_pay_second($zone_id);
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
			$this->load->view('Manual_dredging/Report/sec_customer_ajax_pc', $data);
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
	//-----------------------------------------------------------------------------------
	public function pc_approve_secbooked_request()

	{
	$sess_usr_id 			= 	$this->session->userdata('int_userid');
		 //	$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
		 $bookingid			=		decode_url($id);		
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');	
		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());

			$data 				= 	$data + $this->data; 
		$getcustomerreq_booked=$this->Reports_model->Sec_requestbooking_again($bookingid);
		//print_r($getcustomerreq_booked);break;
		$data['$getcustomerreq_booked']=$getcustomerreq_booked;
		$portid=$getcustomerreq_booked[0]['customer_booking_port_id'];
		$zoneid=$getcustomerreq_booked[0]['customer_booking_zone_id'];
		$booking_id=$getcustomerreq_booked[0]['customer_booking_id'];
		//$ip_address=$_SERVER['REMOTE_ADDR'];
		if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
		$insert_tbl=$this->db->query("update customer_book_request set int_request_count=2 where customer_bookingid='$booking_id' and int_request_count < 2");
		$enc_zoneid=encode_url($zoneid);
		//print_r($insert_tbl);
		if($insert_tbl)
		{
			$this->db->query("update customer_booking set customer_booking_request_status=1 where customer_booking_id='$booking_id'");
			$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Approved request successfully</div>');
				redirect('Manual_dredging/Report/secondrequest_booking_pc_paid/'.$enc_zoneid);
		}
		else
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error failed!!!</div>');
	redirect('Manual_dredging/Report/secondrequest_booking_pc_paid/'.$enc_zoneid);
		}

				$this->load->view('template/header');
			//$this->load->view('Report/customer_booking_request',$data);
			$this->load->view('Kiv_views/template/dash-footer');
	}
	///---------------------------------------------------------------------------------------------
	public function worker_report_zone()
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
			$zone=$this->db->query("select * from zone where zone_port_id='$port_id' and zone_status=1");
			$data['zone']=$zone->result_array();
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/worker_report_zone',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else

		{
			redirect('Main_login/index');        
		}
	}
public function workerdetails_ajax()
	{
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		if(!empty($sess_usr_id))
		{	
			$zone_id=html_escape($this->input->post('zone_id'));
			$this->load->model('Manual_dredging/Reports_model');	
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[0]['user_master_port_id']; 
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;  
			$reg_worker_list= $this->Reports_model->get_worker_registrationpc($zone_id);
			$data['reg_worker_list']=$reg_worker_list; 
			$data = $data + $this->data;
			$data['zoneid']=$zone_id;
			$this->load->view('Manual_dredging/Report/worker_ajax_pc', $data);
	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  
    }
	//------------------------------------pdf worker details REPORT------------------------
	function worker_report()
	{
		//echo $this->load->view('Master/undermain');
	//$zid 				= 	$this->uri->segment(3);
	$zid 				= 	$this->uri->segment(4);
	$zoneid 			= 	decode_url($zid);
	$this->load->model('Manual_dredging/Master_model');
	$this->load->model('Manual_dredging/Reports_model');
	$reg_worker_list	= $this->Reports_model->get_worker_registrationpc($zoneid);
	$zonedet			= $this->Master_model->get_zoneByID($zoneid);
	$zonename			=	$zonedet[0]['zone_name']; 
//	print_r($sale_report);
//require_once('../libraries/tcpdf/tcpdf.php');
$this->load->library('Pdf');
ob_clean();
// create new PDF document
//ini_set('memory_limit', '-1');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.
// set font
$pdf->SetFont('helvetica', '', 11);
// add a page
$pdf->AddPage();
// print a message
//$txt = "You can also export 2D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcode directory.\n";
//$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
$pdf->SetFont('helvetica', '', 10);
$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p>
<center>
<h3>Worker Details-'.$zonename.'</h3>
</center>
<table cellspacing="1" cellpadding="2" >
         <tr>
        <th >Sl No</th>
        <th>Worker Name</th>
        <th>Mobile No</th>
                </tr>';
				 $id=1; 
				 foreach($reg_worker_list as $sp)
				 {
	 $html=$html.'<tr><td>'.$id.'</td>
    <td>'.$sp['worker_registration_name'].'</td>
    <td>'.$sp['worker_registration_phone_number'].'</td>

				</tr>';
					 					 //$id = $rowmodule['police_case_id'];
					$id++; 
				}
				$html=$html.'</table>';

		//==============================================================
		//print_r($html);
		//echo $html;
		//$htmla='<table><tr><td>hari</td></tr></table>';
$pdf->writeHTML($html, true, false, false, false, '');
//ob_end_clean();
$pdf->Output('workerreport.pdf', 'D');
exit;
}
	//-------------------------------------------------------------------------------------
	public function chech_spot_token_aloted() 
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$i=0;
		$this->load->model('Manual_dredging/Master_model');
	$this->load->model('Manual_dredging/Reports_model');	
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$port_id			=	$userinfo[$i]['user_master_port_id'];
		$txt_token  =$this->security->xss_clean(html_escape($this->input->post('tokenno')));
		
		$countspot	=	$this->Reports_model->gettoken($port_id,$txt_token);
		$printstatus=$countspot[0]['print_status'];
		$bookingtype=$countspot[0]['spot_booking_type'];
		$data['zoneid']=$countspot[0]['preferred_zone'];
		if ($printstatus==0)
		{
			$zoneid=$countspot[0]['preferred_zone'];
			echo $zoneid."&".$bookingtype;
		}
		else{
			echo 0 ;
		}
	}
//----------------------------------------------------------------
	public function workdone_approval()

	{	$sess_usr_id 			= 	$this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$this->load->model('Manual_dredging/Master_model');	
		$i=0;
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$port_id			=	$userinfo[$i]['user_master_port_id'];
		if($sess_user_type==3)
		{
			$currentdate=date('Y-m-d');
			$this->load->model('Manual_dredging/Reports_model');
			$cust_bal			=	$this->Reports_model->workcheck($port_id,$currentdate);
			$data['cus_bal']=$cust_bal;
			$data 				= 	$data + $this->data;
			$cust_baltwo			=	$this->Reports_model->workchecktwo($port_id,$currentdate);
			$data['cus_baltwo']=$cust_baltwo;
			$data 				= 	$data + $this->data;
//SELECT count(customer_registration_id) as cntreg FROM `customer_registration` WHERE `customer_registration_timestamp` like '%2018-10-23%' and port_id=10
			//SELECT count(customer_registration_id) as cntreg FROM `customer_registration`  WHERE `customer_decission_timestamp` like '%2018-10-22%' and port_id=10 GROUP by customer_decission_user_id asc
		//$cust_bal=$cus_bal->result_array();
			//$data['cus_bal']=$cust_bal;
			$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/work_doneapproval',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
	}
//----------------------------------------------------------------
	public function spototpmob()
	{
	//if($this->input->post())
		//	{
		$spotphoneno=$this->security->xss_clean(htmlentities($this->input->post('phoneno')));
		$currentdate  =	date('Y-m-d H:i:s');
		$otpno=rand(100000,999999);
		$smsmsg="Portinfo 2 - Dear Customer OTP generated for Spot Booking is $otpno.";
		
		//SELECT `spot_phone`FROM `tbl_spotbooking_temp` WHERE `spotbooking_dte`=''
				//echo $smsmsg; 
		//$sub="porttest";
		//$email="s.gopika84@gmail.com";
		//$this->emailSendFun('manualdredging@gmail.com',$email,$sub,$smsmsg);
		$send=$this->sendSms($smsmsg,$spotphoneno);
		//print_r($send);
		$rr=explode(",",$send); //echo "rrrrr---".$rr[0];
	//exit();
		if($rr[0]==402)
		//if($otpno)
		{
			$this->session->set_userdata('sess_spot_mob',$spotphoneno);
			$this->session->set_userdata('sess_spot_otp',$otpno);
		//	redirect("Manual_dredging/Report/spot_otpcheck/".$enc_mobileno);
		//	echo '<td colspan="2"><table><tr><td>Enter OTP</td><td><input type="text" name="txt_phone" id="txt_phone" class="form-control" maxlength="6" required="required" placeholder="Enter OTP"/></td></tr><tr><td></td><td><input id="btn_otp" name="btn_otp" type="submit" class="btn btn-primary" value="Validate"/></td></tr></table></td>';
			echo 1;
		}
				else

				{ 
					echo 0; 

				}
	}
	//--------------------------------------------------------------------------------------
	public function spototpmobnew()
	{
	//if($this->input->post())
		//	{
		$spotphoneno=$this->security->xss_clean(htmlentities($this->input->post('phoneno')));
		$port_id=$this->security->xss_clean(htmlentities($this->input->post('portdc1')));
		$zone_id=$this->security->xss_clean(htmlentities($this->input->post('zone_id1')));
		$ton=$this->security->xss_clean(htmlentities($this->input->post('txt_ton1')));
		$update=date('Y-m-d');
	
		//$res=$this->db->query("SELECT sum(spot_ton)  as spotton FROM `tbl_spotbooking_temp` WHERE spot_booking_validity=1 and `spotbooking_dte`='$update' and port_id='$port_id' and preferred_zone='$zone_id'");
		
		//$getton=$res->result_array();
		//$tonbooked=$getton[0]["spotton"];
	
		$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$update'");
				$ud=$queryspot->result_array();
				$limit_id=$ud[0]['spot_limit_id'];
				$limitqty=$ud[0]['spot_limit_quantity']; 
				$limitbalance=$ud[0]['spot_limit_balance']; 
			//	$spotton=$limitbalance-$tonbooked;
				if($limitbalance > 3)
				{
					
					$currentdate  =	date('Y-m-d H:i:s');
					$otpno=rand(100000,999999);
					$smsmsg="Portinfo 2 - Dear Customer OTP generated for Spot Booking is $otpno.";
					$send=$this->sendSmsotp($smsmsg,$spotphoneno);
					//print_r($send);
					$rr=explode(",",$send); //echo "rrrrr---".$rr[0];
	
					
						if($rr[0]==402)
					//if($otpno)
						{
						$this->session->set_userdata('sess_spot_mob',$spotphoneno);
						$this->session->set_userdata('sess_spot_otp',$otpno);
		
						echo 1;
					    }
						else

						{ 
							echo 0; 

						}
			}
			else

			{ 
				echo 0; 

			}
			
		
		
	}
	/////-----------------------------------------------------------------------------------

	public function spot_otpcheck()
	{
		$sess_otp 			=  $this->session->userdata('sess_spot_otp');
		//if($this->input->post())
		//	{
		$spototpno=$this->security->xss_clean(htmlentities($this->input->post('otpno')));
		//exit();
		if($spototpno==$sess_otp)
		{
			echo 1;
			//redirect("Report/add_spot_registrationnew");
		}
		else
		{
			echo 0;
			//redirect("Report/spot_otpcheck");

		}

		}

//-----------------------------------------------------------------------	

public function get_interval_spotmob()

	{
		//$sess_usr_id 			=  $this->session->userdata('int_userid');
		//if(!empty($sess_usr_id))
		//{
		//	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			//$port_id			=	$userinfo[$i]['user_master_port_id'];

		$txt_mob=$this->security->xss_clean(html_escape($this->input->post('txtphone')));
			$port_id=$this->security->xss_clean(html_escape($this->input->post('port_id')));
			$todayn=date('Y-m-d');
		//	$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhar' and `spot_timestamp` LIKE '%$todayn%' order by spotreg_id desc limit 0,1");

			$get_intrvl=$this->db->query("select * from tbl_spotbooking_temp where spot_phone='$txt_mob' order by spotreg_id desc limit 0,1");

			$g_int=$get_intrvl->result_array();
			if(count($g_int)==0)
			{
				echo 0;
			}
			else
			{
			$today=date('Y-m-d');
			$w_buk_date=$g_int[0]['spotbooking_dte'];
			$date1=date_create($today);
			$date2=date_create($w_buk_date);
			$diff = $date2->diff($date1)->format("%a");
			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id=0 and buk_stat=1");
			$tn_no=$get_last_d->result_array();
			$t_n=$tn_no[0]['buk_time'];
			if($diff<$t_n)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}

			}
		//}
	}	
	//-----------------------------------------------------------------------------------------------------
	public function spot_challandet()
	{
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');
			/*$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;*/
			$zone_stat=$this->Reports_model->get_portspot_status();
			$data['spot_stat']=$zone_stat;
			$data 				= 	$data + $this->data;
			$this->load->view('template/header');
			$this->load->view('Manual_dredging/Report/challanrequest_spot',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		/*}
		else
		{
			redirect('Main_login/index');       
		}*/
	}
	public function challan_requestspot()
	{
		//if($this->input->post())
		//	{
		$spottokenno=$this->security->xss_clean(htmlentities($this->input->post('tokenno')));
		$get_last_d=$this->db->query("select spot_phone from tbl_spotbooking join transaction_details on transaction_details.token_no=tbl_spotbooking.spot_token where spot_token='$spottokenno' and print_status=0 and payment_type=1");

		$ph_no=$get_last_d->result_array();
		//echo $this->db->last_query();exit();
		$spotphoneno=$ph_no[0]['spot_phone'];
		$currentdate  =	date('Y-m-d H:i:s');
				$otpno=rand(100000,999999);
				$smsmsg="Portinfo 2 - Dear Customer OTP generated for Spot Booking is $otpno.";
		$this->session->set_userdata('sess_spot_token',$spottokenno);
			$this->session->set_userdata('sess_spot_otp',$otpno);
				//echo $smsmsg; 
		//$sub="porttest";
		//$email="s.gopika84@gmail.com";
		//$this->emailSendFun('manualdredging@gmail.com',$email,$sub,$smsmsg);
				$send=$this->sendSms($smsmsg,$spotphoneno);
		//print_r($send);
		$rr=explode(",",$send); //echo "rrrrr---".$rr[0];
	//exit();
		if($rr[0]==402)
		//if($otpno)
		{

			$this->session->set_userdata('sess_spot_token',$spottokenno);
			$this->session->set_userdata('sess_spot_otp',$otpno);
		//	redirect("Report/spot_otpcheck/".$enc_mobileno);
		//	echo '<td colspan="2"><table><tr><td>Enter OTP</td><td><input type="text" name="txt_phone" id="txt_phone" class="form-control" maxlength="6" required="required" placeholder="Enter OTP"/></td></tr><tr><td></td><td><input id="btn_otp" name="btn_otp" type="submit" class="btn btn-primary" value="Validate"/></td></tr></table></td>';
			echo 1;
		}
				else
				{ 
					echo 0; 
				}

	}
	//---------------------------------------------
	function gen_spotreport()
	{
	//	echo $this->load->view('Master/undermain');
	//$zid 				= 	$this->uri->segment(3);
	$zid 				= 	$this->uri->segment(4);
	$zoneid 			= 	decode_url($zid);
	$fd					=	$this->uri->segment(5); 
	$from			= 	decode_url($fd);
	$tod					=	$this->uri->segment(6); 
	$to			= 	decode_url($tod);
	$this->db->select('*');
    $this->db->from('tbl_spotbooking');
	$this->db->join('transaction_details', 'tbl_spotbooking.spot_token = transaction_details.token_no');
	$this->db->where('tbl_spotbooking.spot_alloted >=',$from);
	$this->db->where('tbl_spotbooking.spot_alloted <=',$to);
	$this->db->where('transaction_details.print_status',1);
	$this->db->where('transaction_details.zone_id',$zoneid);
	$query = $this->db->get();
    $sale_report = $query->result_array();	
		$zdet=$this->db->query("select * from zone where zone_id='$zoneid'");
				$zone_namedet=$zdet->result_array();
				$buk_zone_name=$zone_namedet[0]["zone_name"];
//	print_r($sale_report);
//require_once('../libraries/tcpdf/tcpdf.php');
$this->load->library('Pdf');
ob_clean();
// create new PDF document
//ini_set('memory_limit', '-1');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.
// set font
$pdf->SetFont('helvetica', '', 11);
// add a page
$pdf->AddPage();
// print a message
//$txt = "You can also export 2D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcode directory.\n";
//$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
$pdf->SetFont('helvetica', '', 10);
$html = '<style>p{text-align:left;font-size:10;margin:3px;}th{text-align:left;font-size:12;padding-top:10px;}.spec{width:50%;text-align:left;font-size:12;}</style><p>&nbsp;</p>
<table align="center"><tr><td><img height="75" width="75"  src="'.getcwd().'/assets/images/port-logo-wheel.png"/></td></tr>
<tr><td><h3>APPENDIX -F</h3></td></tr>
<tr><td><h4>Daily Dredged Sale Register With Abstract from '.date("d/m/Y",strtotime(str_replace('-', '/',$from))).' to '.date("d/m/Y",strtotime(str_replace('-', '/',$to))).'</h4></td></tr>
</table>
<center>
<h4>Zone :- '.$buk_zone_name.'</h4>
</center>
<table cellspacing="1" cellpadding="2" border="1" >
         <tr>
        <th>Total Quantity</th>
        <th>Total Sale Price</th>
        <th>Total GST Vehicle</th>
                </tr>';
				 $id=1; 
				 $totton=0;
				 $totamount=0;
				 $totgst=0;
				 foreach($sale_report as $sp)
				 {
					 $totton=$totton+$sp['spot_ton'];
					 $totamount=$totamount+$sp['transaction_amount'];
 if($sp['spot_timestamp']>='2018-07-01 00:00:00'){$totgst+=40;}else{$totgst+=0;}  
  
					$id++; 

				}

		 $html=$html.'<tr>
    <td>'.$totton.'</td>
    <td>'.$totamount.'</td>
    <td>'.$totgst.'</td>
	</tr></table>';
		//==============================================================
		//==============================================================
		//print_r($html);
		//echo $html;
		//$htmla='<table><tr><td>hari</td></tr></table>';

$pdf->writeHTML($html, true, false, false, false, '');
//ob_end_clean();
$pdf->Output('salerport.pdf', 'D');
exit;
}
//#######################################################################################################	
/*

	D O O R                   D E L I V E R Y                    B O O K I N G 

	*/

//########################################################################################################

	public function Checkregistrationdoor()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$lsg_id=$u_h_dat[0]['user_master_lsg_id'];
			$lorry_reg=$this->security->xss_clean($this->input->post('lorry_reg'));
   			$lorry_reg = str_replace(' ', '-', $lorry_reg); // Replaces all spaces with hyphens.
    		$lorry_reg=preg_replace('/[^A-Za-z0-9\-]/', '', $lorry_reg); // Removes special chars.
		$lorry_reg1=strtoupper($lorry_reg);
//if($zone_id==26){$sql='and zone_id=26';}else{$sql='';}
		//	$get_buk_phone=$this->db->query("select door_lorry_id from tbl_lorrydoor where replace(replace(replace(door_lorry_regno, '-', ''),'.',''),' ','')='$lorry_reg1' and status!=3 $sql");
		$get_buk_phone=$this->db->query("SELECT *  FROM `tbl_lorrydoor` WHERE `door_lorry_regno` LIKE '%$lorry_reg1%'");
//echo $this->db->last_query();
			$no=$get_buk_phone->num_rows();
			if($no==0)
			{
				echo "1";
			}
			else
			{
			echo "0";
			}
	}

	public function door_a_lorry()
	{
	//$id=$this->uri->segment(3);
	$id=$this->uri->segment(4);
		$this->db->query("update tbl_lorrydoor set status=1 where door_lorry_id='$id'");
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Lorry Activated!!!</div>');
		redirect('Manual_dredging/Report/doorreg_lorry');
	}
	public function door_b_lorry()
	{
		//$id=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$this->db->query("update tbl_lorrydoor set status=2 where door_lorry_id='$id'");
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Lorry Blocked!!!</div>');

		redirect('Manual_dredging/Report/doorreg_lorry');
	}
	public function door_c_lorry()
	{
		//$id=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$this->db->query("update tbl_lorrydoor set status=3 where door_lorry_id='$id'");
		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Lorry Registration Cancelled!!!</div>');
		redirect('Manual_dredging/Report/doorreg_lorry');
	}
	public function doorreg_lorry()
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
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$res_data=$this->db->query("select * from tbl_lorrydoor join zone on zone.zone_port_id=tbl_lorrydoor.door_port_id and zone.zone_id=tbl_lorrydoor.door_zone_id where door_port_id='$port_id'");
			$data['lorry']=$res_data->result_array();
			$data 				= 	$data + $this->data;
			//$zone=$this->Master_model->get_zone_acinP($port_id);
			//$data['zone']=$zone;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/doorlorry_details',$data);
			$this->load->view('Kiv_views/template/dash-footer');
		}
		else
		{
		redirect('Main_login/index');        
		}
	}

	public function material_rate_door()
{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$i=0;
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{	
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;  
			$material			= 	$this->Master_model->get_material_master();
			$data['material']	=	$material;   
			$material_rate			= 	$this->Reports_model->get_doorratefu($port_id);
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
			$this->load->view('Manual_dredging/Report/material_rate_door',$data);
			$this->load->view('Kiv_views/template/dash-footer');
	   	}

   	else
	   	{
			redirect('Main_login/index');        
  		}  

}
public function addmaterialrate_door()
{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$i=0;
		if(!empty($sess_usr_id)&& $sess_user_type==3)
		{
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$port_id			=	$userinfo[$i]['user_master_port_id'];
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$material			= 	$this->Master_model->get_material_masterby_auth(2);
			$data['material']	=	$material;
			$data 				= 	$data + $this->data;
			$material_ex			= 	$this->Reports_model->get_doorrate_pc($port_id);
			$data['material_ex']	=	$material_ex[0]['mat_id'];
			//exit;
			$data 				= 	$data + $this->data;
			$status			= 	$this->Master_model->get_status();
			$data['status']	=	$status;
			$data 				= 	$data + $this->data;
			$zone			= 	$this->Master_model->get_zone_bypID($port_id);
			$data['zone']	=	$zone;
			$data 			= 	$data + $this->data;
			//$gm             =   $this->Master_model->get_matforp($port_id);
			///$data['matid']	=	$gm[0]['matid'];
			//$data 			= 	$data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/addmaterialrate_door', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			
			$this->form_validation->set_rules('zoneid', 'Zone', 'required');
			$this->form_validation->set_rules('minimum_dist', 'Minimum distance', 'required');
			$this->form_validation->set_rules('minimum_amt', 'Minimum Amount', 'required');
			$this->form_validation->set_rules('per_km_amt', 'Per Km Amount', 'required');
			$this->form_validation->set_rules('startdate', 'Start Date', 'required');
			$this->form_validation->set_rules('door_delvy_status', 'Status', 'required');
				if($this->form_validation->run() == FALSE)
				{
					echo validation_errors();
				}
				else
				{
					//print_r($this->input->post());break;
					if($this->input->post())
					{
						$this->load->model('Manual_dredging/Master_model');
						$this->load->model('Manual_dredging/Reports_model');
						if($this->input->post('enddate')=='')
						{
						$end_date='0000-00-00';
						}
						else
						{
							$end_date=date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('enddate')))));

						}
						$currentdate  =	date('Y-m-d H:i:s');					
						$matrate_data=array(
						'door_delivery_port_id'		=>$port_id,
						'door_delivery_zone_id'		=>html_escape($this->input->post('zoneid')),
						'door_delivery_quantity'	=>html_escape($this->input->post('quantityid')),
						'minimum_distance'			=>html_escape($this->input->post('minimum_dist')),
						'minimum_amount'			=>html_escape($this->input->post('minimum_amt')),
						'per_kiometer_amount'		=>html_escape($this->input->post('per_km_amt')),
						'start_date'				=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('startdate'))))),
						'end_date'=>$end_date,
						'door_delivery_status'=>html_escape($this->input->post('door_delvy_status')),
						'updated_timestamp'=>$currentdate,
						'updated_userid'=>$sess_usr_id
						);
						//echo $matrate_data;//break;
						$matrate_data=$this->security->xss_clean($matrate_data);
						$result=$this->Reports_model->add_door_deliveryrate($matrate_data);
						if($result==1)
						{
							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Door Delivery Rate added successfully</div>');
						redirect('Manual_dredging/Report/material_rate_door');
						}
						else
						{
							$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Door Delivery Rate Add failed!!!</div>');
							redirect('Manual_dredging/Report/material_rate_door');
						}
					}
				}
	   	}
	   	else
	   	{
			redirect('Main_login/index');        
  		}  
}
//-------------------------------------------------------	
public function doordevl_zonecheck_ajax()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$i=0;
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$port_id			=	$userinfo[$i]['user_master_port_id'];
		$zoneid 			=  html_escape($this->input->post('zoneid'));
		$quantityid 			=  html_escape($this->input->post('quantityid'));
		$get_last_d=$this->db->query("select * from door_delivery_rate where door_delivery_port_id='$port_id' and  door_delivery_zone_id='$zoneid' and  door_delivery_quantity='$quantityid' and door_delivery_status=1");
			$count_no=$get_last_d->num_rows();
		//echo "sdsd-". $count_no;
		//echo $this->db->last_query();exit();
		//$spotphoneno=$ph_no[0]['spot_phone'];
		if($count_no==1)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}

	}	

	//---------------------------------------
	public function doorlorry_reg()
	{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		if(!empty($sess_usr_id))
		{
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$i=0;
			$port_id			=	$userinfo[$i]['user_master_port_id'];
			$p_name=$this->Master_model->get_port_By_PC($port_id);
			$port_name=$p_name[$i]['vchr_portoffice_name'];

			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
			$data['user_header']=	$u_h_dat;
			$data 				= 	$data + $this->data;
			
			$zone				= 	$this->Reports_model->get_zone_door($port_id);
				$data['zone']		=	$zone;
				$data 				= 	$data + $this->data;
			/*$zone_id=$u_h_dat[0]['user_master_zone_id'];
			$lsg_id=$u_h_dat[0]['user_master_lsg_id'];
			$data['zone_id']=$zone_id;
			$data 				= 	$data + $this->data;*/
			if($this->input->post())

			{
				$this->form_validation->set_rules('zoneid', 'Aadhar Number', 'required');
				$this->form_validation->set_rules('lorry_reg', 'Customer Name', 'required');
				$this->form_validation->set_rules('lorry_make', 'Phone Number', 'required');
				$this->form_validation->set_rules('owner_name', 'House Number', 'required');
				$this->form_validation->set_rules('owner_adno', 'House Name', 'required');
				$this->form_validation->set_rules('contct_no', 'Place', 'required');
				$this->form_validation->set_rules('driver_name', 'Post Office', 'required');
				$this->form_validation->set_rules('driver_license', 'Pin Code', 'required');
				$this->form_validation->set_rules('driver_mobile', 'District Name', 'required');
				$this->form_validation->set_rules('lorry_cap', 'Zone Name', 'required');

				if (empty($_FILES['lorry_rc']['name']))

				{

   					 $this->form_validation->set_rules('lorry_rc', 'Document', 'required');
				}

				if($this->form_validation->run() == FALSE)

				{

					echo validation_errors();exit();

				}

				else
				{
				$zone_id=$this->security->xss_clean(html_escape($this->input->post('zoneid')));
				$lorry_reg=$this->security->xss_clean(html_escape($this->input->post('lorry_reg')));
				$lorry_make=$this->security->xss_clean(html_escape($this->input->post('lorry_make')));
				$owner_name=$this->security->xss_clean(html_escape($this->input->post('owner_name')));
				$owner_adno=$this->security->xss_clean(html_escape($this->input->post('owner_adno')));
				$contct_no=$this->security->xss_clean(html_escape($this->input->post('contct_no')));
				$lorry_cap=$this->security->xss_clean(html_escape($this->input->post('lorry_cap')));
				$driver_name=$this->security->xss_clean(html_escape($this->input->post('driver_name')));
				$driver_license=$this->security->xss_clean(html_escape($this->input->post('driver_license')));
				$driver_mobile=$this->security->xss_clean(html_escape($this->input->post('driver_mobile')));
				$lorry_reg = str_replace(' ', '-', $lorry_reg); // Replaces all spaces with hyphens.
    			$lorry_reg=preg_replace('/[^A-Za-z0-9\-]/', '', $lorry_reg);
				$fname=$_FILES["lorry_rc"]["name"];
				$extension =explode(".", $fname);
				$ext=$extension[1];

				if($ext=="jpg"||$ext=="pdf"||$ext=="jpeg"||$ext=="png")

				{

					if($_FILES["lorry_rc"]["tmp_name"]<771568)

					{

						$t_name=uniqid().".".$ext;
						copy($_FILES["lorry_rc"]["tmp_name"],'./upload/'.$t_name);

					}

					else

					{

						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed file size 500Kb</div>');
						redirect('Manual_dredging/Report/lorry_reg');

					}

				}
				$data_in=array(

				'door_lorry_regno'=>$lorry_reg,
				'door_lorry_make'=>$lorry_make,
				'owner_name'=>$owner_name,
				'owner_adhaar'=>$owner_adno,
				'contact_no'=>$contct_no,
				'driver_name'=>$driver_name,
				'driver_license'=>$driver_license,
				'contact_no'=>$driver_mobile,
				'lorry_cap'=>$lorry_cap,
				'rc_name'=>$t_name,
				'door_port_id'=>$port_id,
				'door_zone_id'=>$zone_id,
				'door_lsg_id'=>0);

				$res=$this->db->insert('tbl_lorrydoor',$data_in);
//echo	$this->db->last_query(); 
//exit();

				if($res==1)

			{	
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Registration Completed</div>');
					redirect('Manual_dredging/Report/doorreg_lorry');

				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Registration Failed</div>');
					redirect('Manual_dredging/Report/doorreg_lorry');

				}

				}

			}

			//$this->load->view('template/header',$data);
			$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/doorlorry_registration',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}

		else

		{

			redirect('Main_login/index');        

		}

	}

	public function editmaterialrate_door()
{
		$sess_usr_id 			=  $this->session->userdata('int_userid');
		$sess_user_type			=	$this->session->userdata('int_usertype');
		$i=0;
		if(!empty($sess_usr_id)&& $sess_user_type==3)

		{
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');
			//$int_userpost_sl		=	decode_url($this->uri->segment(3));
			$int_userpost_sl		=	decode_url($this->uri->segment(4));			
			$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
			$port_id			=	$userinfo[$i]['user_master_port_id'];
				
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post(),'int_userpost_sl'=>$int_userpost_sl);

			$data 				= 	$data + $this->data;     
			$material_det			= 	$this->Reports_model->get_doorrate_byid($int_userpost_sl);
			$data['material_det']	=	$material_det;
			$data 				= 	$data + $this->data;
			$status			= 	$this->Master_model->get_status();
			$data['status']	=	$status;
			$zone			= 	$this->Master_model->get_zone_acinP($port_id);
			$data['zone']	=	$zone;
			if($this->input->post())

			{
				//$this->form_validation->set_rules('int_material', 'Material', 'required');
			//$this->form_validation->set_rules('zoneid', 'Zone', 'required');
			$this->form_validation->set_rules('minimum_dist', 'Minimum distance', 'required');

				$this->form_validation->set_rules('minimum_amt', 'Minimum Amount', 'required');

				$this->form_validation->set_rules('per_km_amt', 'Per Km Amount', 'required');
				//$this->form_validation->set_rules('statedate', 'Start Date', 'required');
				$this->form_validation->set_rules('door_delvy_status', 'Status', 'required');

				if($this->form_validation->run() == FALSE)

				{

					echo validation_errors();

					exit();

				}
				else
				{

						$mr_id=decode_url($this->input->post('hid'));
							$currentdate  =	date('Y-m-d H:i:s');	
						$matrate_data=array(
						'door_delivery_quantity'	=>html_escape($this->input->post('quantityid')),
						'minimum_distance'		=>html_escape($this->input->post('minimum_dist')),
						'minimum_amount'		=>html_escape($this->input->post('minimum_amt')),
						'per_kiometer_amount'	=>html_escape($this->input->post('per_km_amt')),
						'start_date'			=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('startdate'))))),
						'end_date'=>date("Y-m-d",strtotime(str_replace('/', '-',html_escape($this->input->post('enddate'))))),
						'door_delivery_status'=>html_escape($this->input->post('door_delvy_status')),
						'updated_timestamp'=>$currentdate,
						'updated_userid'=>$sess_usr_id);
						$matrate_data=$this->security->xss_clean($matrate_data);
						$result=$this->Reports_model->update_door_rate($mr_id,$matrate_data);
					//echo $this->db->last_query();exit();
						if($result==1)

						{


							$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Material Rate Updated successfully</div>');

															redirect('Manual_dredging/Report/material_rate_door');
						}

						else

						{

$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Material Rate Update failed!!!</div>');

															redirect('Manual_dredging/Report/material_rate_door');

						}

					}
				}

			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
				//$this->load->view('template/header',$data);
				$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
			$this->load->view('Manual_dredging/Report/addmaterialrate_door', $data);
			$this->load->view('Kiv_views/template/dash-footer');

	   	}

	   	else

	   	{

			redirect('Main_login/index');        
  		}  

}	

//----------------------//////--- D O O R    D E L I V E R Y -----/////////////////////////////////////

public function sand_issue_nw()

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
			$zone_id=$u_h_dat[0]['user_master_zone_id'];
				//$this->load->view('template/header',$data);
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
					$this->load->model('Manual_dredging/Master_model');
					$this->load->model('Manual_dredging/Reports_model');
					$tokennumnber=$this->security->xss_clean(html_escape($this->input->post('txttokenno')));
					$aadharnumber=$this->security->xss_clean(html_escape($this->input->post('txtaadharno')));
					$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
					//$port_id			=	$userinfo[0]['user_master_port_id'];  
					//$zone_id			=	$userinfo[0]['user_master_zone_id']

					
					$get_bookingapprovedlistdata= $this->Reports_model->get_spotbookinglist_nw($tokennumnber,$aadharnumber,$zone_id);
					//print_r($get_bookingapprovedlist);//break;
					//
					if($get_bookingapprovedlistdata)
					{
						$data['get_bookingapprovedlistdata']=$get_bookingapprovedlist;
						$bookingid=$get_bookingapprovedlistdata[0]['spotreg_id'];
						$booking_id=encode_url($bookingid);
						redirect('Manual_dredging/Report/sand_issue_addmessage/'.$booking_id);
					}

					else

					{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Request Processing failed!!!</div>');

													redirect('Manual_dredging/Report/sand_issue_nw');
					}

				}
		}

			$today=date('Y-m-d');

			$t_d=$this->db->query("select * from tbl_spotbooking join transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where tbl_spotbooking.spot_alloted='$today' and transaction_details.zone_id='$zone_id' and spot_booking_type=2 and  transaction_details.print_status=0 and pass_dstatus=2 ");

			$data['to_data']=$t_d->result_array();
			$data 				= 	$data + $this->data;
			$this->load->view('Manual_dredging/Report/sand_issue_nw', $data);
			$this->load->view('Kiv_views/template/dash-footer');
			//$bk_id_pass=decode_url($this->uri->segment(3));
			$bk_id_pass=decode_url($this->uri->segment(4));
			if($bk_id_pass!=0)
			{

				redirect('Manual_dredging/Report/generatepass/'.encode_url($bk_id_pass));

			}
		}	

		else

		{


				redirect('Manual_dredging/settings/index');        
		}

    }

	public function sand_issue_adddoor_nw()

    {

		$sess_usr_id 			= 	$this->session->userdata('int_userid');
			//$id			=		$this->uri->segment(3);
			$id			=		$this->uri->segment(4);
			 $id			=		decode_url($id);

		$this->load->model('Manual_dredging/Master_model');

		if(!empty($sess_usr_id))

		{	

			$data = array('title' => 'Add Sand Issue', 'page' => 'sand_issue_add', 'errorCls' => NULL, 'post' => $this->input->post());
			$data = $data + $this->data;
			$this->load->model('Manual_dredging/Master_model');
			$this->load->model('Manual_dredging/Reports_model');
			$get_bookingapprovedadded= $this->Reports_model->get_spotbookingadd($id);

			$data['get_bookingapprovedadded']=$get_bookingapprovedadded;
			$data = $data + $this->data;
			$this->load->model('Manual_dredging/Master_model');

			//$monthlypermitid=$get_bookingapprovedadded[0]['customer_booking_monthly_permit_id'];
			//$permitamount=$this->Master_model->get_monthly_permit_by_id($monthlypermitid);
			//$data['permitamount']=$permitamount
			//$data = $data + $this->data;
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$port_id			=	$u_h_dat[0]['user_master_port_id'];
			$zone_id			=	$u_h_dat[0]['user_master_zone_id'];
		$t_d=$this->db->query("select * from tbl_lorrydoor where door_port_id='$port_id' and door_zone_id='$zone_id' and status=1");//echo $this->db->last_query();

//exit();
			$data['vehicleregno']=$t_d->result_array();
			$data 				= 	$data + $this->data;
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
			$hid_bookingid=$this->security->xss_clean(html_escape($this->input->post('hid_bookingid')));
			$txtdrmobno=$this->security->xss_clean(html_escape($this->input->post('txtdrmobno')));

			$currentdate=date('Y-m-d H:i:s');
			//$ip_address				=	$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
			$update_data=array('pass_isue_user'			=>	$sess_usr_id,
								'pass_issue_timestamp'	=>	$currentdate,
								'spot_VehicleMake'		=>	$txtvehiclemake,
								'spot_vehicleRegno'		=>	$txtvehicleregno,
							   'spot_altd_timestamp'	=>  $currentdate,
								'spot_driver'			=>	$txtdrivername,
								'spot_license'			=>	$txtdrlicenseno,
							  	'spot_driver_mobile'	=>	$txtdrmobno);


				$result=$this->Reports_model->update_spotbooking($update_data,$hid_bookingid);

			/*	



				$get_bookingapprovedadd= $this->Reports_model->get_spotbookingadd($hid_bookingid);
			
//-------------------------------------  Insert to Payment Table    ---------------------------------------------


 */

 //-----------------------------------------------------------------------------------------------------------------------

				//$result=$this->Master_model->update_customerregistration($request_data,$customerreg_id);

				if($result)
				{
					$get_token=$this->db->query("select spot_token from tbl_spotbooking where spotreg_id='$hid_bookingid'");
					$g_tok=$get_token->result_array();
					 $token=$g_tok[0]['spot_token'];	
					$this->db->query("update transaction_details set print_status=1 where token_no='$token'");

//exit();

					//	$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Sand Issued successfully</div>');
													//$this->load->library('user_agent');
				redirect('Manual_dredging/Report/vehicle_pass_success/'.encode_url($hid_bookingid));
													//redirect('Master/generatepass/'.encode_url($hid_bookingid));
				}
				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Sand Issue failed!!!</div>');


													redirect('Manual_dredging/Report/sand_issue_nw');
				}

			}

			$this->load->view('Manual_dredging/Report/sand_issuedoor_nw',$data);
			$this->load->view('Kiv_views/template/dash-footer');

		}
		else

		{

				redirect('Manual_dredging/settings/index');        

		}

	}
//----------------------------------------------------------------------------------------------------
		function get_spotdet()
	{
		$sess_usr_id 			= 	$this->session->userdata('int_userid');
		$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
		$checkstat=$this->security->xss_clean(html_escape($this->input->post('checkstat')));
		if($checkstat==1){
			$sql='AND tbl_spotbooking.spot_alloted IS NOT NULL ORDER BY `tbl_spotbooking`.`spot_timestamp` DESC LIMIT 0,250';
		}
		else
		{
			$sql=' AND tbl_spotbooking.spot_alloted IS NULL ORDER BY `tbl_spotbooking`.`spot_timestamp` DESC LIMIT 0,250';
		}
		
			$i=0;
			$port_id			=	$userinfo[$i]['user_master_port_id'];
		$res_data=$this->db->query("select tbl_spotbooking.spotreg_id,tbl_spotbooking.spot_cusname,tbl_spotbooking.preferred_zone,tbl_spotbooking.spot_timestamp,tbl_spotbooking.spot_alloted,tbl_spotbooking.spot_unloading,tbl_spotbooking.spot_token,tbl_spotbooking.spot_phone,tbl_spotbooking.spot_ton,tbl_spotbooking.pass_isue_user,transaction_details.print_status,transaction_details.payment_status,transaction_details.zone_id,tbl_spotbooking.spot_booking_type,tbl_spotbooking.lorry_type from tbl_spotbooking join  transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where transaction_details.port_id='$port_id' and transaction_details.transaction_status=1 and transaction_details.print_status=0 and  transaction_details.pass_dstatus=2  $sql ");
		//echo "select tbl_spotbooking.spotreg_id,tbl_spotbooking.spot_cusname,tbl_spotbooking.preferred_zone,tbl_spotbooking.spot_timestamp,tbl_spotbooking.spot_alloted,tbl_spotbooking.spot_unloading,tbl_spotbooking.spot_token,tbl_spotbooking.spot_phone,tbl_spotbooking.spot_ton,tbl_spotbooking.pass_isue_user,transaction_details.print_status,transaction_details.payment_status,transaction_details.zone_id,tbl_spotbooking.spot_booking_type from tbl_spotbooking join  transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where transaction_details.port_id='$port_id' and transaction_details.print_status=0  $sql ";
			$data['spot']=$res_data->result_array();
			$data 				= 	$data + $this->data;
		$spot_zone=$this->db->query("select * from zone join spot_kadavu on zone.zone_id=spot_kadavu.zone_id where zone.zone_port_id='$port_id'");
			$data['zone']=$spot_zone->result_array();
			$data 				= 	$data + $this->data;
		$this->load->view("Manual_dredging/Report/get_spotdet_ajax",$data);
	}
	//--------------------------------------------------------------------------------------
	/*
	###
	###
	###
	###
	*/
	//------------ S P O T   O N L I N E     P A Y M E N T ---------------------------------
	
	public function Onlinepayment_spot()
	{
		
 		$sess_spot_bookid = $this->session->userdata('sess_spot_bookid');
		if(!empty($sess_spot_bookid))
		{	
		//$ids			=		$this->uri->segment(3);
		$ids			=		$this->uri->segment(4);
		$id			=		decode_url($ids);
			$data = array('title' => 'Add Sand Issue', 'page' => 'sand_issue_add', 'errorCls' => NULL, 'post' => $this->input->post());
			$data = $data + $this->data;
			$this->load->model('Manual_dredging/Master_model');
	$this->load->model('Manual_dredging/Reports_model');
			$get_bookingdata= $this->Reports_model->onlinepay_detailsspot($id);
			$port_id=$get_bookingdata[0]['port_id'];
		//print_r($get_bookingdata);exit();
			$data['get_bookingdata']=$get_bookingdata;
			$data = $data + $this->data;
			$get_banktype= $this->Master_model->onlinebank_type();
			$data['get_banktype']=$get_banktype;
			$data = $data + $this->data;
			
			
			
			//$monthlypermitid=$get_bookingapprovedadded[0]['customer_booking_monthly_permit_id'];
			//$permitamount=$this->Master_model->get_monthly_permit_by_id($monthlypermitid);
			//$data['permitamount']=$permitamount;
		//	$data = $data + $this->data;
			/*$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				$data 				= 	$data + $this->data;
				$this->load->view('template/header',$data);*/
			//$this->load->view('template/header');
			$this->load->view('Kiv_views/Registration/header_reg.php');
			$this->load->view('Manual_dredging/Report/spotonlinepayu_view',$data);
		if($this->input->post())
		{
			$this->load->model('Manual_dredging/Master_model');
	$this->load->model('Manual_dredging/Reports_model');
			//echo "asasa".$sess_token = $this->session->userdata('sess_token');
			//$sess_amount = $this->session->userdata('sess_amount');
			//print_r($_POST);
			//exit();
			$data['postdata']=$_POST;
			$data 				= 	$data + $this->data;
				$hid_custid=0;
				$hid_bookingid=html_escape($_POST['hid_bookingid']);
				//$tokenno=html_escape($_POST['tokenno']);
				//$custname=html_escape($_POST['custname']);
				//$custphone=html_escape($_POST['custphone']);
				//$requestton=html_escape($_POST['requestton']);
				//$transamount=html_escape($_POST['transamount']);
				$custemail=html_escape($_POST['custemail']);
				$banktype=html_escape($_POST['banktype']);
			
			
		
			
			$get_bookingdata= $this->Reports_model->onlinepay_detailsspot($hid_bookingid);
			
			$port_id=$get_bookingdata[0]['port_id'];
			$zone_id=$get_bookingdata[0]['preferred_zone'];
			$tokenno=$get_bookingdata[0]['spot_token'];
			$transamount=$get_bookingdata[0]['spot_amount'];
			
				$custname=$get_bookingdata[0]['spot_cusname'];
				$custphone=$get_bookingdata[0]['spot_phone'];
				$requestton=$get_bookingdata[0]['spot_ton'];
				
				$custemail=html_escape($_POST['custemail']);
			$data['getbookingdata']=$get_bookingdata;
			$data 				= 	$data + $this->data;
		
			$currentdate  =	date('Y-m-d H:i:s');
			
			$rres=$this->db->query("select * from bank_type where bank_type_id='$banktype'");

				$banktypedata=$rres->result_array();

			$last_generated_no=$banktypedata[0]['last_generated_no'];
			
			
			//$tid=$tokenno.$last_generated_no; changed on 30/07/19
			//-----------------------------------------------------------
			$tid=substr(number_format(time() * rand() * $tokenno,0,'',''),0,12);
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
				
		
			if($insert_transaction_reg==1)

			{
				
				$trans_id=$this->db->insert_id();
				//echo	$this->db->last_query(); exit();
				$this->db->query("update bank_type set last_generated_no=last_generated_no+1 where bank_type_id='$banktype'");
				/*$sess_usr_id = $this->session->userdata('int_userid');
			$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
				$data['user_header']=	$u_h_dat;
				
				$data 				= 	$data + $this->data;*/
				
				$get_paydata= $this->Reports_model->onlinetrans_detailsspot($trans_id);
				
				$data['transid']=$get_paydata[0]['transaction_id'];
				$data 				= 	$data + $this->data;
				$this->session->set_userdata('spotonline_portid',$port_id);
				
				$merkey_data=$this->db->query("select * from online_payment_data where port_id='$port_id' and payment_status=1 and bank_type_id='$banktype'");

				$merkeydata=$merkey_data->result_array();

			$data['merkeydata']=	$merkeydata;
			$data 				= 	$data + $this->data;
				//$this->load->view('template/header',$data);
			$this->load->view('ccpay/hdfc_postspot',$data);
				
			}
			else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Online payment  failed!!!</div>');

					redirect('Manual_dredging/Report/Onlinepayment_spot/'.encode_url($hid_bookingid));

				}
				
				}else{$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Online payment  failed!!!</div>');

					redirect('Manual_dredging/Report/Onlinepayment_spot/'.encode_url($hid_bookingid));}
			
		
			
		}
			
		
			$this->load->view('Kiv_views/template/dash-footer');
	}
		else
		{
				redirect('Manual_dredging/settings/index');        
		}
	}
		//-------------------------------------------------------------------------------------
	
	

	public function add_spot_registrationpayment()

	{
		 
			 
			$bookingtime_data= $this->Master_model->customerspotbooking_timecheck();
			$starttime=$bookingtime_data[0]['spotbooking_master_start'];
			$endtime=$bookingtime_data[0]['spotbooking_master_end'];
			$start_time=strtotime($starttime);
			$end_time=strtotime($endtime);
		//echo date_default_timezone_get();
	//echo date('Y-M-d h:i:s');
		//exit;
			$current_time=strtotime("now");
	if($current_time >= $start_time && $current_time <= $end_time)

		{ 

		$port				= 	$this->Master_model->get_portspot();

		$data['port_det']	=	$port;
		$data 				= 	$data + $this->data; 
			$spot_zone=$this->db->query("select * from zone join spot_kadavu on zone.zone_id=spot_kadavu.zone_id ");
			$data['zone']=$spot_zone->result_array();
			$data 				= 	$data + $this->data;

			if($this->input->post())

			{


				$this->form_validation->set_rules('portdc', 'Port ', 'required');
				$this->form_validation->set_rules('txt_username', 'Name', 'required');
				$this->form_validation->set_rules('txt_adhaar', 'Aadhar', 'required');
				$this->form_validation->set_rules('txt_phone', 'Phone No ', 'required');
				$this->form_validation->set_rules('txt_ton', 'Ton', 'required');
				$this->form_validation->set_rules('txt_place', 'Place', 'required');
				$this->form_validation->set_rules('txt_route', 'Route ', 'required');
				$this->form_validation->set_rules('txt_distance', 'Distance', 'required');
				$this->form_validation->set_rules('vehicle_type', 'Vehicle Type', 'required');
			///-----------------------------------------------------------------------------------------
			$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
			$txt_phone=html_escape($this->input->post('txt_phone'));
			$port_id=html_escape($this->input->post('portdc'));
				$today=date('Y-m-d');
			//-------------added on 23/09/2019--------------------------------------------------
				
				//$ins_check=$this->db->query("INSERT INTO `spotbooking_check`(`spot_aadharno`, `spot_mobileno`, `spotbooking_date`) VALUES ('$txt_adhaar','$txt_phone','$today')");
				//if($ins_check==1)

				//{
				
					

		//	$get_intrvl=$this->db->query("select * from tbl_spotbooking where spot_adhaar='$txt_adhaar' and `spot_timestamp` LIKE '%$today%' order by spotreg_id desc limit 0,1");

$get_intrvl=$this->db->query("select * from tbl_spotbooking_temp where spot_booking_validity =1 and  spot_adhaar='$txt_adhaar' order by spotreg_id desc limit 0,1");
			//echo $this->db->last_query();

	$g_int=$get_intrvl->result_array();
	if(count($g_int)==0)


			{

		if($this->form_validation->run() == FALSE)

				{

				validation_errors();

				}

		else
		{
		//$ip_address=$_SERVER['REMOTE_ADDR'];
			if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
		$port_id=html_escape($this->input->post('portdc'));
		$txt_username=html_escape($this->input->post('txt_username'));
		$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
		$txt_phone=html_escape($this->input->post('txt_phone'));
		$txt_ton=html_escape($this->input->post('txt_ton'));
		$txt_place=html_escape($this->input->post('txt_place'));
		$txt_route=html_escape($this->input->post('txt_route'));
		$txt_distance=html_escape($this->input->post('txt_distance'));
		$zone_id=html_escape($this->input->post('zone_id'));
		$hid_otp=html_escape($this->input->post('hid_otp'));
		$booking_type=html_escape($this->input->post('booking_type'));
		$vehicle_type=html_escape($this->input->post('vehicle_type'));
	//-------------------------------------------------------------------------------------	

							$bookingtype=1;

				 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
				if($hid_otp!='')

				{

						if($hid_otp!=$sess_otp)

						{

							redirect('Manual_dredging/Report/add_spot_registrationpayment');	
						}

					}
					else
					{

						redirect('Manual_dredging/Report/add_spot_registrationpayment');	

					}

//-----------------------limit check----------------------------------------------------------------

						$today=date('Y-m-d');


						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
				$ud=$queryspot->result_array();
				//	foreach($ud as $rowfetch)
				//	{
					$limit_id=$ud[0]['spot_limit_id'];
					$limitqty=$ud[0]['spot_limit_quantity'];
					$limitbalance=$ud[0]['spot_limit_balance'];


				//	}

					if($limitbalance<$txt_ton)
					{	


					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
					// redirect('Report/spot_registration_online');
					redirect('Manual_dredging/Report/add_spot_registrationpayment');

					}

			else
			{
						
				//-------------------------------------------------------------------------------------------------
				$period=date('F Y');
			$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");

		$et_amount=$getrate_port->result_array();

		$sand_amount=$et_amount[0]["s_amount"];		
		$challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
		$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
	$data_in=array(
		'spot_cusname'=>$txt_username,
		'spot_adhaar'=>$txt_adhaar,
		'spot_phone'=>$txt_phone,
		'spot_ton'=>$txt_ton,
		'spot_unloading'=>$txt_place,
		'spot_route'=>$txt_route,
		'spot_distance'=>$txt_distance,
		'spot_token'=>uniqid(),
		'spot_challan'=>$challan_no,
		'spot_amount'=>$challan_amount,
		'spot_user'=>$sess_usr_id,
		'spotbooking_ip_addr'=>$ip_address,
		'port_id'=>$port_id,
		'preferred_zone'=>$zone_id,
		'spotbooking_status'=>2,
		'spotbooking_dte'=>date('Y-m-d'),
		'spotbuk_dteph'=>date('Y-m-d'),
		'spot_booking_type'=>$bookingtype,
		'lorry_type'=>$vehicle_type,
		);


				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);

				//print_r($getpdtaa);

				$p_code=$getpdtaa[0]['intport_code'];

				$this->db->trans_begin();
				
				//-----------------------------------------------------------------------------------
			

				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today'");//and spot_booking_validity =1 
				$getton=$get_ton->result_array();

					$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
				
				
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {
					if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;


						//$this->db->query("update spot_booking_limit set spot_limit_balance=GREATEST(0,spot_limit_balance-$txt_ton) where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");

//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}
				
					 
					 
					 }
				else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}
				$buk_id=$this->db->insert_id();

				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);

				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
				$no=$gt_ch->num_rows();

				if($no==0)

				{

					$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");
						/*$data = array("OPCODE"=>"GETUID",
								"TOKENNO"=>"$tok_no",
								"PORTCODE"=>"$p_code",
								"INSTCODE"=>"DOP",
								"CHALLANAMOUNT"=>"$challan_amount",
									 );                                                                 

							$data_string = json_encode($data); */ 

								//exit; 
							//echo $data_string;                                                                           
			/*$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                   
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
									'Content-Type: application/json',                                    
									'Content-Length: ' . strlen($data_string))                                 
								);                                                                               
								$result = curl_exec($ch);
								$myArray=json_decode($result, true);
								$uid=$myArray['UID'];
							$ifsc=$myArray['IFSC'];
								if($uid=="")
								{

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
									redirect('Report/add_spot_registrationnew');

								}*/
								//else
								//{
								$currentdate			=	date('Y-m-d H:i:s');
						$data_trans=array('transaction_customer_registration_id'=>000,
													'transaction_customer_booking_id'=>000,
													'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>0,
													'ifsc_code'=>0,
													'challan_timestamp'=>$currentdate,
													'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,

												);

						$this->db->insert('transaction_details',$data_trans);

							$this->session->unset_userdata('sess_spot_otp');
					$this->session->set_userdata('sess_spot_bookid',$buk_id);
						$this->db->trans_commit();
						//echo encode_url($buk_id);
						redirect('Manual_dredging/Report/Onlinepayment_spot/'.encode_url($buk_id));

						//redirect('Report/getchallan/'.encode_url($buk_id));

						//redirect('Report/spot_registration');

								//}

				}

				else

				{

					 $this->db->trans_rollback();

					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');

					// redirect('Report/spot_registration_online');



					redirect('Manual_dredging/Report/add_spot_registrationpayment');

			}

		}//else limit
	}//echo 0;

}
		else
			{
			 $today=date('Y-m-d h:i:s');
			 $w_buk_date=$g_int[0]['spot_timestamp'];
			$date1=date_create($today);
			$date2=date_create($w_buk_date);
		$diff = $date2->diff($date1)->format("%a");
			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id='$port_id' and buk_stat=1");
			$tn_no=$get_last_d->result_array();
			$t_n=$tn_no[0]['buk_time'];
			if($diff<$t_n)
			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Adhaar already exist!!!</div>');
				redirect('Manual_dredging/Report/add_spot_registrationpayment');

			}
			else

			{

			//----------------------------------------------------------------------------------------------------

				if($this->form_validation->run() == FALSE)
			{
				validation_errors();


				}

			else
			{
				//$ip_address=$_SERVER['REMOTE_ADDR'];
if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip_address = $_SERVER["REMOTE_ADDR"];
}
			$port_id=html_escape($this->input->post('portdc'));
				$txt_username=html_escape($this->input->post('txt_username'));
				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
				$txt_phone=html_escape($this->input->post('txt_phone'));
				$txt_ton=html_escape($this->input->post('txt_ton'));
				$txt_place=html_escape($this->input->post('txt_place'));
				$txt_route=html_escape($this->input->post('txt_route'));
				$txt_distance=html_escape($this->input->post('txt_distance'));
				$zone_id=html_escape($this->input->post('zone_id'));
				$hid_otp=html_escape($this->input->post('hid_otp'));
				$booking_type=html_escape($this->input->post('booking_type'));
				$vehicle_type=html_escape($this->input->post('vehicle_type'));
				//-------------------------------------------------------------------------------------	

				
							$bookingtype=1;

					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');

					if($hid_otp!='')

					{

						if($hid_otp!=$sess_otp)

						{

							redirect('Manual_dredging/Report/add_spot_registrationpayment');	

						}

					}

					else

					{

						redirect('Manual_dredging/Report/add_spot_registrationpayment');	

					}


				//-----------------------limit check-------------------------------------------------------------


						$today=date('Y-m-d');

						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");

				$ud=$queryspot->result_array();

					//foreach($ud as $rowfetch)

					//{


					$limit_id=$ud[0]['spot_limit_id'];

				$limitqty=$ud[0]['spot_limit_quantity'];

				$limitbalance=$ud[0]['spot_limit_balance'];

				//	}


					if($limitbalance<$txt_ton)

					{	

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');


					 //redirect('Report/spot_registration_online');

					redirect('Manual_dredging/Report/add_spot_registrationpayment');

					}

				else
					{


				$period=date('F Y');

				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");

				$et_amount=$getrate_port->result_array();

				$sand_amount=$et_amount[0]["s_amount"];

			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));

				$data_in=array(
				'spot_cusname'=>$txt_username,
				'spot_adhaar'=>$txt_adhaar,
				'spot_phone'=>$txt_phone,
				'spot_ton'=>$txt_ton,
				'spot_unloading'=>$txt_place,
				'spot_route'=>$txt_route,
				'spot_distance'=>$txt_distance,
				'spot_token'=>uniqid(),
				'spot_challan'=>$challan_no,
				'spot_amount'=>$challan_amount,
				'spot_user'=>$sess_usr_id,
				'spotbooking_ip_addr'=>$ip_address,
					'port_id'=>$port_id,
				'preferred_zone'=>$zone_id,
				'spotbooking_status'=>2,
				'spotbooking_dte'=>date('Y-m-d'),
				'spotbuk_dteph'=>date('Y-m-d'),
				'spot_booking_type'=>$bookingtype,
					'lorry_type'=>$vehicle_type,

				);


				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);

				//print_r($data_in);

				$p_code=$getpdtaa[0]['intport_code'];

		//--------------------------------------------------------------------------
						
		$this->db->trans_begin();
						
		//--------------------------------------------------------------------------
		$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today' ");//and spot_booking_validity =1
				$getton=$get_ton->result_array();

			$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
				
				
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {				
						
						
				if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;
						

//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}

}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}

//echo $this->db->last_query();



				$buk_id=$this->db->insert_id();

				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
	//	echo "WWWWWW". $tok_no;


			$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");

				$no=$gt_ch->num_rows();

				if($no==0)

				{

					$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");

								/*$data = array("OPCODE"=>"GETUID",
										"TOKENNO"=>"$tok_no",
											"PORTCODE"=>"$p_code",
											"INSTCODE"=>"DOP",
											"CHALLANAMOUNT"=>"$challan_amount",
											);                                                                   

						$data_string = json_encode($data); */ 
								//exit; 
							//echo $data_string;                                                                                 
					/*$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');

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
								$ifsc=$myArray['IFSC'];*/
							/*if($uid=="")

							{

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');

								redirect('Report/add_spot_registrationnew');

								}

							else

								{*/

								$currentdate			=	date('Y-m-d H:i:s');
							$data_trans=array('transaction_customer_registration_id'=>000,
												'transaction_customer_booking_id'=>000,
												'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>$uid,
													'ifsc_code'=>$ifsc,
													'challan_timestamp'=>$currentdate,
													'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,

												);

						$this->db->insert('transaction_details',$data_trans);
					$this->session->set_userdata('sess_spot_bookid',$buk_id);
					$this->session->unset_userdata('sess_spot_otp');			

						$this->db->trans_commit();


                          //echo encode_url($buk_id);



						redirect('Manual_dredging/Report/Onlinepayment_spot/'.encode_url($buk_id));

			//redirect('Report/getchallan/'.encode_url($buk_id));

						//redirect('Report/spot_registration');

							//	}

				}


				else


				{


					 $this->db->trans_rollback();

					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');

					 //redirect('Report/spot_registration_online');
					redirect('Manual_dredging/Report/add_spot_registrationpayment');

				}


			}//else limit


		}//else validation


		}//aadhar check else part else(diff<t_n)

		}//aadhar check else part

		//###############################################################################################

		
				$get_intrvl=$this->db->query("select * from tbl_spotbooking_temp where spot_phone='$txt_phone' order by spotreg_id desc limit 0,1");

				//echo $this->db->last_query();

		$g_int=$get_intrvl->result_array();

			if(count($g_int)==0)

			{



				if($this->form_validation->run() == FALSE)

				{

					validation_errors();
		}

				else
		{

				//$ip_address=$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
				{
    				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}
			else {
					$ip_address = $_SERVER["REMOTE_ADDR"];
				}
			
				$port_id=html_escape($this->input->post('portdc'));
				$txt_username=html_escape($this->input->post('txt_username'));
				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
				$txt_phone=html_escape($this->input->post('txt_phone'));
				$txt_ton=html_escape($this->input->post('txt_ton'));
				$txt_place=html_escape($this->input->post('txt_place'));
				$txt_route=html_escape($this->input->post('txt_route'));
				$txt_distance=html_escape($this->input->post('txt_distance'));
				$zone_id=html_escape($this->input->post('zone_id'));
				$hid_otp=html_escape($this->input->post('hid_otp'));
				$booking_type=html_escape($this->input->post('booking_type'));
				$vehicle_type=html_escape($this->input->post('vehicle_type'));
				//-------------------------------------------------------------------------------------	
					
							$bookingtype=1;

					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
					if($hid_otp!='')

					{

						if($hid_otp!=$sess_otp)

						{

						redirect('Manual_dredging/Report/add_spot_registrationpayment');	
						}

					}
					else

					{
						redirect('Manual_dredging/Report/add_spot_registrationpayment');	
					}


		//-----------------------limit check----------------------------------------------------------------

						$today=date('Y-m-d');

						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");


				$ud=$queryspot->result_array();


				//	foreach($ud as $rowfetch)

				//	{


					$limit_id=$ud[0]['spot_limit_id'];

					$limitqty=$ud[0]['spot_limit_quantity'];
					$limitbalance=$ud[0]['spot_limit_balance'];

				//	}

					if($limitbalance<$txt_ton)

					{	


					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');

					redirect('Manual_dredging/Report/add_spot_registrationpayment');


					}


					else

					{

		//-------------------------------------------------------------------------------------------------
				$period=date('F Y');
				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");

			$et_amount=$getrate_port->result_array();
			$sand_amount=$et_amount[0]["s_amount"];
			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
				$data_in=array(
			'spot_cusname'=>$txt_username,
				'spot_adhaar'=>$txt_adhaar,
				'spot_phone'=>$txt_phone,
				'spot_ton'=>$txt_ton,
				'spot_unloading'=>$txt_place,
				'spot_route'=>$txt_route,
				'spot_distance'=>$txt_distance,
				'spot_token'=>uniqid(),
				'spot_challan'=>$challan_no,
				'spot_amount'=>$challan_amount,
				'spot_user'=>$sess_usr_id,
				'spotbooking_ip_addr'=>$ip_address,
					'port_id'=>$port_id,
				'preferred_zone'=>$zone_id,
				'spotbooking_status'=>2,
				'spotbooking_dte'=>date('Y-m-d'),
				'spotbuk_dteph'=>date('Y-m-d'),
				'spot_booking_type'=>$bookingtype,
					'lorry_type'=>$vehicle_type,
				);

				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
				$p_code=$getpdtaa[0]['intport_code'];


//------------------------------------------------------------------------------------
				$this->db->trans_begin();

//-----------------------------------------------------------------------------------
				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today'");// and spot_booking_validity =1
				$getton=$get_ton->result_array();

			$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
			
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {
						if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;


//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}
					 
					  }
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}
				$buk_id=$this->db->insert_id();
					 
				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);


				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");



				$no=$gt_ch->num_rows();

				if($no==0)

				{

					$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");
					/*$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>"$tok_no",

											"PORTCODE"=>"$p_code",

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$challan_amount",
					);                                                                    


							$data_string = json_encode($data); */ 



				/*	$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');

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
									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');


									redirect('Report/add_spot_registrationnew');


								}

								else


								{*/

								$currentdate			=	date('Y-m-d H:i:s');

	$data_trans=array(
													'transaction_customer_registration_id'=>000,
													'transaction_customer_booking_id'=>000,
													'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>$uid,
													'ifsc_code'=>$ifsc,
													'challan_timestamp'=>$currentdate,
													'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,
												);

						$this->db->insert('transaction_details',$data_trans);
					$this->session->set_userdata('sess_spot_bookid',$buk_id);
						$this->session->unset_userdata('sess_spot_otp');					
						$this->db->trans_commit();
						//echo encode_url($buk_id);
						redirect('Manual_dredging/Report/Onlinepayment_spot/'.encode_url($buk_id));
						//redirect('Report/getchallan/'.encode_url($buk_id));
						//redirect('Report/spot_registration');
							//	}

				}

				else
				{

				 $this->db->trans_rollback();
					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
					redirect('Manual_dredging/Report/add_spot_registrationpayment');

				}

			}//else limit


				}//echo 0;
			}
			else
			{
			 $today=date('Y-m-d h:i:s');
			 $w_buk_date=$g_int[0]['spot_timestamp'];
				//exit();
			$date1=date_create($today);
			$date2=date_create($w_buk_date);
			$diff = $date2->diff($date1)->format("%a");
			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id=0 and buk_stat=1");
			$tn_no=$get_last_d->result_array();
			$t_n=$tn_no[0]['buk_time'];
			if($diff<$t_n)

			{

				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Phone already exist!!!</div>');

				redirect('Manual_dredging/Report/add_spot_registrationpayment');
			}

			else
			{

			//----------------------------------------------------------------------------------------------------

				if($this->form_validation->run() == FALSE)

				{

		validation_errors();


				}

				else

			{

				//$ip_address=$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"])
				{
    				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}
				else 
				{
    				$ip_address = $_SERVER["REMOTE_ADDR"];
				}
				$port_id=html_escape($this->input->post('portdc'));
				$txt_username=html_escape($this->input->post('txt_username'));
				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
				$txt_phone=html_escape($this->input->post('txt_phone'));
				$txt_ton=html_escape($this->input->post('txt_ton'));
				$txt_place=html_escape($this->input->post('txt_place'));
				$txt_route=html_escape($this->input->post('txt_route'));
				$txt_distance=html_escape($this->input->post('txt_distance'));
				$zone_id=html_escape($this->input->post('zone_id'));
				$hid_otp=html_escape($this->input->post('hid_otp'));
				$booking_type=html_escape($this->input->post('booking_type'));
				$vehicle_type=html_escape($this->input->post('vehicle_type'));
				//-------------------------------------------------------------------------------------	

					$bookingtype=1;
					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
					if($hid_otp!='')
					{
						if($hid_otp!=$sess_otp)

						{

							redirect('Manual_dredging/Report/add_spot_registrationpayment');	

						}

					}

					else

					{

						redirect('Manual_dredging/Report/add_spot_registrationpayment');	
					}

	//-----------------------limit check----------------------------------------------------------------

						$today=date('Y-m-d');

						$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");

				$ud=$queryspot->result_array();

					//foreach($ud as $rowfetch)


					//{


					$limit_id=$ud[0]['spot_limit_id'];

					$limitqty=$ud[0]['spot_limit_quantity'];

					$limitbalance=$ud[0]['spot_limit_balance'];

					//}

					if($limitbalance<$txt_ton)

					{	

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
					redirect('Manual_dredging/Report/add_spot_registrationpayment');

					}

					else
					{
						
		//-------------------------------------------------------------------------------------------------

				$period=date('F Y');

				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");

				$et_amount=$getrate_port->result_array();


				$sand_amount=$et_amount[0]["s_amount"];

			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42



				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));

				$data_in=array(

				'spot_cusname'=>$txt_username,

				'spot_adhaar'=>$txt_adhaar,

				'spot_phone'=>$txt_phone,

				'spot_ton'=>$txt_ton,

				'spot_unloading'=>$txt_place,

				'spot_route'=>$txt_route,

				'spot_distance'=>$txt_distance,

				'spot_token'=>uniqid(),

				'spot_challan'=>$challan_no,

				'spot_amount'=>$challan_amount,

				'spot_user'=>$sess_usr_id,

				'spotbooking_ip_addr'=>$ip_address,
					'port_id'=>$port_id,

				'preferred_zone'=>$zone_id,

				'spotbooking_status'=>2,

				'spotbooking_dte'=>date('Y-m-d'),

				'spotbuk_dteph'=>date('Y-m-d'),

					'spot_booking_type'=>$bookingtype,
					'lorry_type'=>$vehicle_type,
				);

				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);


				//print_r($data_in);

				$p_code=$getpdtaa[0]['intport_code'];


			//--------------------------------------------------------------------------


				$this->db->trans_begin();
						
			//--------------------------------------------------------------------------

				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today'");// and spot_booking_validity =1 
				$getton=$get_ton->result_array();

			$tonbooked=$getton[0]["spotton"];
				
				$tonspot=$limitqty-$tonbooked;
				
				//-----------------------------------------------------------------------------------
				 if($tonspot > 3)
				 {		
						

					 if($tonspot>=$txt_ton)
					{
						$totbal=$tonspot-$txt_ton;



//$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
	
				$insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
					}
						else
				{
					
				
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}
 }
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
									redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}

				$buk_id=$this->db->insert_id();
				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
				$no=$gt_ch->num_rows();
				if($no==0)

				{

					$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");
				/*$data = array("OPCODE"=>"GETUID",

											"TOKENNO"=>"$tok_no",

											"PORTCODE"=>"$p_code",

											"INSTCODE"=>"DOP",

											"CHALLANAMOUNT"=>"$challan_amount",

											);                                                                    

							$data_string = json_encode($data);  */


								//exit; 


								//echo $data_string;                                                                                 

				/*	$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');


								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                         curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                         
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                       
							'Content-Type: application/json','Content-Length: ' . strlen($data_string))                                   
								);                                                                               
								$result = curl_exec($ch);
								$myArray=json_decode($result, true);
								$uid=$myArray['UID'];
								$ifsc=$myArray['IFSC'];
								if($uid=="")


								{

									$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to communicate with bank!!!</div>');
									redirect('Report/add_spot_registrationnew');
								}

								else
							{*/

								$currentdate			=	date('Y-m-d H:i:s');
							$data_trans=array('transaction_customer_registration_id'=>000,
													'transaction_customer_booking_id'=>000,
													'token_no'=>$tok_no,
													'challan_no'=>$challan_no,
													'challan_amount'=>$challan_amount,
													'uid_no'=>$uid,
													'ifsc_code'=>$ifsc,
													'challan_timestamp'=>$currentdate,
												'booking_timestamp'=>$currentdate,
													'zone_id'=>000,
													'port_id'=>$port_id,

												);

						$this->db->insert('transaction_details',$data_trans);

	$this->session->set_userdata('sess_spot_bookid',$buk_id);
								$this->session->unset_userdata('sess_spot_otp');

						$this->db->trans_commit();


                          //echo encode_url($buk_id);



						redirect('Manual_dredging/Report/Onlinepayment_spot/'.encode_url($buk_id));
						//redirect('Report/getchallan/'.encode_url($buk_id));
						//redirect('Report/spot_registration');

							//	}

				}

			else

				{

					 $this->db->trans_rollback();
					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
					// redirect('Report/spot_registration_online');
						redirect('Manual_dredging/Report/add_spot_registrationpayment');
				}

			}//else limit

		}//else validation

		}//phone check else part else(diff<t_n)

		} //phone check else part

	//-#################################################################################################		
		
			//}//spotbooking insert check if close added on [23/09/2019]
		//else
		//{
		//	$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
		//	redirect('Report/add_spot_registrationpayment');
		//}
//-------------------------------------------------------------------------------------------		
	} //post check

		} //time check if close

		else{ 

		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');

					// redirect('Report/spot_registration_online');

			redirect('Manual_dredging/Report/add_spot_registrationpayment');
					 }
			$this->load->view('Kiv_views/Registration/header_reg.php');
			$this->load->view('Manual_dredging/Report/spot_registration_payment',$data);
			$this->load->view('Kiv_views/template/dash-footer');


	}

//------------------------------------------------------------------------------------------
	public function spot_bookingsearch()

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

				//$this->load->view('template/header',$data);
				$this->load->view('Kiv_views/template/dash-header');
			$this->load->view('Kiv_views/template/nav-header');
		

			$this->load->view('Manual_dredging/Report/spot_bookingsearch', $data);
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
	$this->load->model('Manual_dredging/Reports_model');

	$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);

	$port_id			=	$userinfo[0]['user_master_port_id'];  

	$tokeno=$this->security->xss_clean(html_escape($this->input->post('tokenno')));

	$get_customerapproval=$this->Reports_model->customerbookingsearch($tokeno,$port_id);

	

	$data['get_customerapproval']=$get_customerapproval;

	$data = $data + $this->data;

	$this->load->view('Manual_dredging/Report/getbookingdetails_ajax_new', $data);

	}
	
	//---------------------------------------------------------------------------------------
	//public function add_spot_registrationpaymentnew()
//
//	{
//		 
//			 
//			$bookingtime_data= $this->Master_model->customerspotbooking_timecheck();
//			$starttime=$bookingtime_data[0]['spotbooking_master_start'];
//			$endtime=$bookingtime_data[0]['spotbooking_master_end'];
//			$start_time=strtotime($starttime);
//			$end_time=strtotime($endtime);
//			$current_time=strtotime("now");
//if($current_time >= $start_time && $current_time <= $end_time)
//
//{ 
//			$port				= 	$this->Master_model->get_portspot();
//			$data['port_det']	=	$port;
//			$data 				= 	$data + $this->data; 
//
//			if($this->input->post())
//
//			{
//
//				$this->form_validation->set_rules('portdc', 'Port ', 'required');
//				$this->form_validation->set_rules('txt_username', 'Name', 'required');
//				$this->form_validation->set_rules('txt_adhaar', 'Aadhar', 'required');
//				$this->form_validation->set_rules('txt_phone', 'Phone No ', 'required');
//				$this->form_validation->set_rules('txt_ton', 'Ton', 'required');
//				$this->form_validation->set_rules('txt_place', 'Place', 'required');
//				$this->form_validation->set_rules('txt_route', 'Route ', 'required');
//				$this->form_validation->set_rules('txt_distance', 'Distance', 'required');
//			///-----------------------------------------------------------------------------------------
//			$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//			$txt_phone=html_escape($this->input->post('txt_phone'));
//			$port_id=html_escape($this->input->post('portdc'));
//				$today=date('Y-m-d');
//				
//$get_intrvl=$this->db->query("select * from tbl_spotbooking_temp where spot_booking_validity =1 and  spot_adhaar='$txt_adhaar' order by spotreg_id desc limit 0,1");
//			//echo $this->db->last_query();
//	$g_int=$get_intrvl->result_array();
//	if(count($g_int)==0)
//	{
//		if($this->form_validation->run() == FALSE)
//		{
//		echo validation_errors();
//			exit();
//		}
//		else
//		{
//			if ($_SERVER["HTTP_X_FORWARDED_FOR"])
//			{
//   				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//			}
//			else 
//			{
//    			$ip_address = $_SERVER["REMOTE_ADDR"];
//			}
//		$port_id	 =	html_escape($this->input->post('portdc'));
//		$txt_username=	html_escape($this->input->post('txt_username'));
//		$txt_adhaar	 =	html_escape($this->input->post('txt_adhaar'));
//		$txt_phone	 =	html_escape($this->input->post('txt_phone'));
//		$txt_ton	 =  html_escape($this->input->post('txt_ton'));
//		$txt_place	 =  html_escape($this->input->post('txt_place'));
//		$txt_route	 =  html_escape($this->input->post('txt_route'));
//		$txt_distance=  html_escape($this->input->post('txt_distance'));
//		$zone_id	 = html_escape($this->input->post('zone_id'));
//		$hid_otp	 = html_escape($this->input->post('hid_otp'));
//		$booking_type= html_escape($this->input->post('booking_type'));
//	//-------------------------------------------------------------------------------------	
//		$bookingtype=1;
//		 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
//		if($hid_otp!='')
//		{
//		if($hid_otp!=$sess_otp)
//			{
//			redirect('Report/add_spot_registrationpaymentnew');	
//			}
//		}
//		else
//		{
//		 redirect('Report/add_spot_registrationpaymentnew');	
//		}
////-----------------------limit check----------------------------------------------------------------
//		$today=date('Y-m-d');
//		$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
//		$ud=$queryspot->result_array();
//			
//		$limit_id=$ud[0]['spot_limit_id'];
//		$limitqty=$ud[0]['spot_limit_quantity'];
//		$limitbalance=$ud[0]['spot_limit_balance'];
//	if($limitbalance<$txt_ton)
//	{	
//	  $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');				
//	  redirect('Report/add_spot_registrationpaymentnew');
//
//	}
//	else
//	{
//	//-------------------------------------------------------------------------------------------------
//		$period=date('F Y');
//		$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//		$et_amount=$getrate_port->result_array();
//		$sand_amount=$et_amount[0]["s_amount"];		
//		$challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//		$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//	$data_in=array(
//		'spot_cusname'=>$txt_username,
//		'spot_adhaar'=>$txt_adhaar,
//		'spot_phone'=>$txt_phone,
//		'spot_ton'=>$txt_ton,
//		'spot_unloading'=>$txt_place,
//		'spot_route'=>$txt_route,
//		'spot_distance'=>$txt_distance,
//		'spot_token'=>uniqid(),
//		'spot_challan'=>$challan_no,
//		'spot_amount'=>$challan_amount,
//		'spot_user'=>$sess_usr_id,
//		'spotbooking_ip_addr'=>$ip_address,
//		'port_id'=>$port_id,
//		'preferred_zone'=>$zone_id,
//		'spotbooking_status'=>2,
//		'spotbooking_dte'=>date('Y-m-d'),
//		'spotbuk_dteph'=>date('Y-m-d'),
//		'spot_booking_type'=>$bookingtype,
//		);
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//				//print_r($getpdtaa);
//				$p_code=$getpdtaa[0]['intport_code'];
//				$this->db->trans_begin();
//				//-----------------------------------------------------------------------------------
//				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//				$getton=$get_ton->result_array();
//				$tonbooked=$getton[0]["spotton"];
//				$tonspot=$limitqty-$tonbooked;
//	//-----------------------------------------------------------------------------------
//	 if($tonspot > 3)
//		{
//			if($tonspot>=$txt_ton)
//			{
//					
////$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//			$insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
//			}
//			else
//			{
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//				redirect('Report/add_spot_registrationpaymentnew');
//			}
//			  
//		}
//		else
//		{
//						
//			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//			redirect('Report/add_spot_registrationpaymentnew');
//		}
//			$buk_id=$this->db->insert_id();
//			$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//			$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//			$no=$gt_ch->num_rows();
//			if($no==0)
//			{
//			$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");
//				
//			$currentdate			=	date('Y-m-d H:i:s');
//			$data_trans= array('transaction_customer_registration_id'=>000,
//							 'transaction_customer_booking_id'=>000,
//							'token_no'=>$tok_no,
//							'challan_no'=>$challan_no,
//							'challan_amount'=>$challan_amount,
//							'uid_no'=>0,
//							'ifsc_code'=>0,
//							'challan_timestamp'=>$currentdate,
//							'booking_timestamp'=>$currentdate,
//							'zone_id'=>000,
//							'port_id'=>$port_id,
//							);
//
//						$this->db->insert('transaction_details',$data_trans);
//
//							$this->session->unset_userdata('sess_spot_otp');
//					$this->session->set_userdata('sess_spot_bookid',$buk_id);
//						$this->db->trans_commit();
//						//echo encode_url($buk_id);
//						redirect('Report/Onlinepayment_spot/'.encode_url($buk_id));
//
//				}
//				else
//				{
//					 $this->db->trans_rollback();
//					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//					redirect('Report/add_spot_registrationpaymentnew');
//				}
//
//		}//else limit
//	}//echo 0;
//
//}
//else
//	{
//		$today=date('Y-m-d h:i:s');
//		$w_buk_date=$g_int[0]['spot_timestamp'];
//		$date1=date_create($today);
//		$date2=date_create($w_buk_date);
//		$diff = $date2->diff($date1)->format("%a");
//		$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id='$port_id' and buk_stat=1");
//		$tn_no=$get_last_d->result_array();
//		$t_n=$tn_no[0]['buk_time'];
//		if($diff<$t_n)
//		{
//		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Adhaar already exist!!!</div>');
//		redirect('Report/add_spot_registrationpayment');
//		}
//		else
//		{
//	//----------------------------------------------------------------------------------------------------
//			if($this->form_validation->run() == FALSE)
//			{
//				echo validation_errors();
//				exit();
//			}
//			else
//			{
//				//$ip_address=$_SERVER['REMOTE_ADDR'];
//				if ($_SERVER["HTTP_X_FORWARDED_FOR"])
//				{
//    				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//				}
//				else 
//				{
//    				$ip_address = $_SERVER["REMOTE_ADDR"];
//				}
//				$port_id=html_escape($this->input->post('portdc'));
//				$txt_username=html_escape($this->input->post('txt_username'));
//				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//				$txt_phone=html_escape($this->input->post('txt_phone'));
//				$txt_ton=html_escape($this->input->post('txt_ton'));
//				$txt_place=html_escape($this->input->post('txt_place'));
//				$txt_route=html_escape($this->input->post('txt_route'));
//				$txt_distance=html_escape($this->input->post('txt_distance'));
//				$zone_id=html_escape($this->input->post('zone_id'));
//				$hid_otp=html_escape($this->input->post('hid_otp'));
//				$booking_type=html_escape($this->input->post('booking_type'));
//
//				//-------------------------------------------------------------------------------------	
//				
//				$bookingtype=1;
//				$sess_otp 			=  $this->session->userdata('sess_spot_otp');
//			if($hid_otp!='')
//			{
//				if($hid_otp!=$sess_otp)
//				{
//					redirect('Report/add_spot_registrationpayment');	
//
//				}
//
//			}
//			else
//			{
//				redirect('Report/add_spot_registrationpayment');	
//			}
//	//-----------------------limit check-------------------------------------------------------------
//			$today=date('Y-m-d');
//			$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");
//			$ud=$queryspot->result_array();
//
//				$limit_id=$ud[0]['spot_limit_id'];
//				$limitqty=$ud[0]['spot_limit_quantity'];
//				$limitbalance=$ud[0]['spot_limit_balance'];
//
//			if($limitbalance<$txt_ton)
//			{	
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//				redirect('Report/add_spot_registrationpaymentnew');
//			}
//			else
//			{
//				$period=date('F Y');
//				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//				$et_amount=$getrate_port->result_array();
//				$sand_amount=$et_amount[0]["s_amount"];
//			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//
//				$data_in=array(
//				'spot_cusname'=>$txt_username,
//				'spot_adhaar'=>$txt_adhaar,
//				'spot_phone'=>$txt_phone,
//				'spot_ton'=>$txt_ton,
//				'spot_unloading'=>$txt_place,
//				'spot_route'=>$txt_route,
//				'spot_distance'=>$txt_distance,
//				'spot_token'=>uniqid(),
//				'spot_challan'=>$challan_no,
//				'spot_amount'=>$challan_amount,
//				'spot_user'=>$sess_usr_id,
//				'spotbooking_ip_addr'=>$ip_address,
//				'port_id'=>$port_id,
//				'preferred_zone'=>$zone_id,
//				'spotbooking_status'=>2,
//				'spotbooking_dte'=>date('Y-m-d'),
//				'spotbuk_dteph'=>date('Y-m-d'),
//				'spot_booking_type'=>$bookingtype,
//
//				);
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//				//print_r($data_in);
//				$p_code=$getpdtaa[0]['intport_code'];
//		//--------------------------------------------------------------------------
//						
//		$this->db->trans_begin();
//						
//		//--------------------------------------------------------------------------
//		$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//		$getton=$get_ton->result_array();
//		$tonbooked=$getton[0]["spotton"];	
//		$tonspot=$limitqty-$tonbooked;	
//	//-----------------------------------------------------------------------------------
//	if($tonspot > 3)
//	{							
//	if($tonspot>=$txt_ton)
//		{
//		//$totbal=$tonspot-$txt_ton;
//						
////$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//			$insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
//		}
//		else
//		{	
//		  $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//		  redirect('Report/add_spot_registrationpaymentnew');
//		}
//
//	}			
//	else
//	{
//		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//		redirect('Report/add_spot_registrationpaymentnew');
//	}
//			$buk_id=$this->db->insert_id();
//			$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//			$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//			$no=$gt_ch->num_rows();
//			if($no==0)
//			{
//			$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");
//
//			$currentdate			=	date('Y-m-d H:i:s');
//			$data_trans=array('transaction_customer_registration_id'=>000,
//							'transaction_customer_booking_id'=>000,
//							'token_no'=>$tok_no,
//							'challan_no'=>$challan_no,
//							'challan_amount'=>$challan_amount,
//							'uid_no'=>$uid,
//							'ifsc_code'=>$ifsc,
//							'challan_timestamp'=>$currentdate,
//							'booking_timestamp'=>$currentdate,
//							'zone_id'=>000,
//							'port_id'=>$port_id,
//							);
//
//					$this->db->insert('transaction_details',$data_trans);
//					$this->session->set_userdata('sess_spot_bookid',$buk_id);
//					$this->session->unset_userdata('sess_spot_otp');			
//					$this->db->trans_commit();
//
//                          //echo encode_url($buk_id);
//
//						redirect('Report/Onlinepayment_spot/'.encode_url($buk_id));
//
//
//				}
//				else
//				{
//
//				 $this->db->trans_rollback();
//				 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//					 //redirect('Report/spot_registration_online');
//				redirect('Report/add_spot_registrationpaymentnew');
//
//				}
//
//			}//else limit
//	    }//else validation
//    }//aadhar check else part else(diff<t_n)
//
//}//aadhar check else part
////###############################################################################################
//		$get_intrvl=$this->db->query("select * from tbl_spotbooking_temp where spot_phone='$txt_phone' order by spotreg_id desc limit 0,1");
//				//echo $this->db->last_query();
//		$g_int=$get_intrvl->result_array();
//			if(count($g_int)==0)
//			{
//				if($this->form_validation->run() == FALSE)
//				{
//					echo validation_errors();
//					exit();
//				}
//		   else
//		   {
//				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
//				{
//    				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//				}
//				else 
//				{
//					$ip_address = $_SERVER["REMOTE_ADDR"];
//				}
//			
//				$port_id=html_escape($this->input->post('portdc'));
//				$txt_username=html_escape($this->input->post('txt_username'));
//				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//				$txt_phone=html_escape($this->input->post('txt_phone'));
//				$txt_ton=html_escape($this->input->post('txt_ton'));
//				$txt_place=html_escape($this->input->post('txt_place'));
//				$txt_route=html_escape($this->input->post('txt_route'));
//				$txt_distance=html_escape($this->input->post('txt_distance'));
//				$zone_id=html_escape($this->input->post('zone_id'));
//				$hid_otp=html_escape($this->input->post('hid_otp'));
//				$booking_type=html_escape($this->input->post('booking_type'));
//				
//				//-------------------------------------------------------------------------------------	
//					
//				$bookingtype=1;
//				$sess_otp 			=  $this->session->userdata('sess_spot_otp');
//				if($hid_otp!='')
//				{
//					if($hid_otp!=$sess_otp)
//					{
//						redirect('Report/add_spot_registrationpaymentnew');	
//					}
//				}
//				else
//				{
//				 redirect('Report/add_spot_registrationpaymentnew');	
//				}
//
//		//-----------------------limit check----------------------------------------------------------------
//
//			$today=date('Y-m-d');
//			$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
//
//			$ud=$queryspot->result_array();
//
//			$limit_id=$ud[0]['spot_limit_id'];
//			$limitqty=$ud[0]['spot_limit_quantity'];
//			$limitbalance=$ud[0]['spot_limit_balance'];
//			if($limitbalance<$txt_ton)
//			{	
//
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//				redirect('Report/add_spot_registrationpaymentnew');
//			}
//			else
//			{
//
//		//-------------------------------------------------------------------------------------------------
//				$period=date('F Y');
//				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//
//			$et_amount=$getrate_port->result_array();
//			$sand_amount=$et_amount[0]["s_amount"];
//			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//				$data_in=array(
//				'spot_cusname'=>$txt_username,
//				'spot_adhaar'=>$txt_adhaar,
//				'spot_phone'=>$txt_phone,
//				'spot_ton'=>$txt_ton,
//				'spot_unloading'=>$txt_place,
//				'spot_route'=>$txt_route,
//				'spot_distance'=>$txt_distance,
//				'spot_token'=>uniqid(),
//				'spot_challan'=>$challan_no,
//				'spot_amount'=>$challan_amount,
//				'spot_user'=>$sess_usr_id,
//				'spotbooking_ip_addr'=>$ip_address,
//				'port_id'=>$port_id,
//				'preferred_zone'=>$zone_id,
//				'spotbooking_status'=>2,
//				'spotbooking_dte'=>date('Y-m-d'),
//				'spotbuk_dteph'=>date('Y-m-d'),
//				'spot_booking_type'=>$bookingtype,
//				);
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//				$p_code=$getpdtaa[0]['intport_code'];
//				$this->db->trans_begin();
//
////-----------------------------------------------------------------------------------
//				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//				$getton=$get_ton->result_array();
//				$tonbooked=$getton[0]["spotton"];
//				$tonspot=$limitqty-$tonbooked;
//			
//				//-----------------------------------------------------------------------------------
//				 if($tonspot > 3)
//				 {
//					if($tonspot>=$txt_ton)
//					{
//						//$totbal=$tonspot-$txt_ton;
//            //$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//				      $insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
//					}
//					else
//					{	
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//					redirect('Report/add_spot_registrationpaymentnew');
//				}		 
//			 }
//			else
//			{
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//				redirect('Report/add_spot_registrationpaymentnew');
//			}
//				$buk_id=$this->db->insert_id();			 
//				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//
//				$no=$gt_ch->num_rows();
//				if($no==0)
//				{
//
//					$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");
//				
//				$currentdate			=	date('Y-m-d H:i:s');
//
//	$data_trans=array('transaction_customer_registration_id'=>000,
//					  'transaction_customer_booking_id'=>000,
//					 'token_no'=>$tok_no,
//					 'challan_no'=>$challan_no,
//					 'challan_amount'=>$challan_amount,
//					 'uid_no'=>$uid,
//					 'ifsc_code'=>$ifsc,
//					 'challan_timestamp'=>$currentdate,
//					 'booking_timestamp'=>$currentdate,
//					 'zone_id'=>000,
//					 'port_id'=>$port_id,
//					);
//
//					$this->db->insert('transaction_details',$data_trans);
//					$this->session->set_userdata('sess_spot_bookid',$buk_id);
//					$this->session->unset_userdata('sess_spot_otp');					
//					$this->db->trans_commit();
//					//echo encode_url($buk_id);
//					redirect('Report/Onlinepayment_spot/'.encode_url($buk_id));		
//				}
//				else
//				{
//
//				$this->db->trans_rollback();
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//				redirect('Report/add_spot_registrationpaymentnew');
//
//				}
//
//			}//else limit
//
//		}//echo 0;
//	}
//	else
//	{
//			 $today=date('Y-m-d h:i:s');
//			 $w_buk_date=$g_int[0]['spot_timestamp'];
//				//exit();
//			$date1=date_create($today);
//			$date2=date_create($w_buk_date);
//			$diff = $date2->diff($date1)->format("%a");
//			$get_last_d=$this->db->query("select buk_time from tbl_buk_interval where port_id=0 and buk_stat=1");
//			$tn_no=$get_last_d->result_array();
//			$t_n=$tn_no[0]['buk_time'];
//			if($diff<$t_n)
//			{
//				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Phone already exist!!!</div>');
//				redirect('Report/add_spot_registrationpaymentnew');
//			}
//			else
//			{
//		//-----------------------------------------------------------------------------------------------
//
//			if($this->form_validation->run() == FALSE)
//		{
//		   echo validation_errors();
//			exit();
//		}
//		else
//		{
//				//$ip_address=$_SERVER['REMOTE_ADDR'];
//				if ($_SERVER["HTTP_X_FORWARDED_FOR"])
//				{
//    				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
//				}
//				else 
//				{
//    				$ip_address = $_SERVER["REMOTE_ADDR"];
//				}
//				$port_id=html_escape($this->input->post('portdc'));
//				$txt_username=html_escape($this->input->post('txt_username'));
//				$txt_adhaar=html_escape($this->input->post('txt_adhaar'));
//				$txt_phone=html_escape($this->input->post('txt_phone'));
//				$txt_ton=html_escape($this->input->post('txt_ton'));
//				$txt_place=html_escape($this->input->post('txt_place'));
//				$txt_route=html_escape($this->input->post('txt_route'));
//				$txt_distance=html_escape($this->input->post('txt_distance'));
//				$zone_id=html_escape($this->input->post('zone_id'));
//				$hid_otp=html_escape($this->input->post('hid_otp'));
//				$booking_type=html_escape($this->input->post('booking_type'));
//		//-------------------------------------------------------------------------------------	
//					$bookingtype=1;
//					 $sess_otp 			=  $this->session->userdata('sess_spot_otp');
//					if($hid_otp!='')
//					{
//						if($hid_otp!=$sess_otp)
//
//						{
//
//							redirect('Report/add_spot_registrationpaymentnew');	
//
//						}
//
//					}
//
//					else
//
//					{
//
//						redirect('Report/add_spot_registrationpayment');	
//					}
//
//	//-----------------------limit check----------------------------------------------------------------
//
//				$today=date('Y-m-d');
//				$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and spot_limit_date='$today'");
//
//				$ud=$queryspot->result_array();
//
//					$limit_id=$ud[0]['spot_limit_id'];
//					$limitqty=$ud[0]['spot_limit_quantity'];
//					$limitbalance=$ud[0]['spot_limit_balance'];
//
//					if($limitbalance<$txt_ton)
//					{	
//
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//					redirect('Report/add_spot_registrationpaymentnew');
//
//					}
//
//					else
//					{
//						
//		//-------------------------------------------------------------------------------------------------
//
//				$period=date('F Y');
//
//				$getrate_port=$this->db->query("select MAX(sand_rate) as s_amount from monthly_permit where monthly_permit_period_name='$period' and port_id='$port_id'");
//
//				$et_amount=$getrate_port->result_array();
//				$sand_amount=$et_amount[0]["s_amount"];
//			    $challan_amount=ceil($txt_ton*$sand_amount)+220+42;//---1%  flood cess increased on 02/08/2019[18 +1] 40 changed to 42
//				$challan_no=bin2hex(openssl_random_pseudo_bytes(4));
//				$data_in=array(
//				'spot_cusname'=>$txt_username,
//				'spot_adhaar'=>$txt_adhaar,
//				'spot_phone'=>$txt_phone,
//				'spot_ton'=>$txt_ton,
//				'spot_unloading'=>$txt_place,
//				'spot_route'=>$txt_route,
//				'spot_distance'=>$txt_distance,
//				'spot_token'=>uniqid(),
//				'spot_challan'=>$challan_no,
//				'spot_amount'=>$challan_amount,
//				'spot_user'=>$sess_usr_id,
//				'spotbooking_ip_addr'=>$ip_address,
//				'port_id'=>$port_id,
//				'preferred_zone'=>$zone_id,
//				'spotbooking_status'=>2,
//				'spotbooking_dte'=>date('Y-m-d'),
//				'spotbuk_dteph'=>date('Y-m-d'),
//				'spot_booking_type'=>$bookingtype,
//				);
//
//				$getpdtaa=$this->Master_model->get_port_By_PC($port_id);
//				//print_r($data_in);
//				$p_code=$getpdtaa[0]['intport_code'];
//			//--------------------------------------------------------------------------
//				$this->db->trans_begin();
//						
//			//--------------------------------------------------------------------------
//
//				$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking_temp where preferred_zone='$zone_id' and spotbooking_dte='$today'");
//				$getton=$get_ton->result_array();
//				$tonbooked=$getton[0]["spotton"];
//				$tonspot=$limitqty-$tonbooked;
//				
//				//-----------------------------------------------------------------------------------
//				 if($tonspot > 3)
//				 {		
//						
//
//					 if($tonspot>=$txt_ton)
//					{
//						//$totbal=$tonspot-$txt_ton;
//
////$this->db->query("update spot_booking_limit set spot_limit_balance=$totbal where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");
//	
//				$insert_customer_booking=$this->db->insert('tbl_spotbooking_temp', $data_in);
//					}
//				else
//				{
//					
//				
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_spot_registrationpaymentnew');
//				}
// }
//				else
//				{
//					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to book limit over !!!</div>');
//									redirect('Report/add_spot_registrationpaymentnew');
//				}
//
//				$buk_id=$this->db->insert_id();
//				$tok_no=substr(number_format(time() * rand() * $buk_id,0,'',''),0,8);
//				$gt_ch=$this->db->query("select * from transaction_details where token_no='$tok_no'");
//				$no=$gt_ch->num_rows();
//				if($no==0)
//
//				{
//
//					$this->db->query("update tbl_spotbooking_temp set spot_token='$tok_no' where spotreg_id='$buk_id'");
//				
//
//								$currentdate			=	date('Y-m-d H:i:s');
//							$data_trans=array('transaction_customer_registration_id'=>000,
//													'transaction_customer_booking_id'=>000,
//													'token_no'=>$tok_no,
//													'challan_no'=>$challan_no,
//													'challan_amount'=>$challan_amount,
//													'uid_no'=>$uid,
//													'ifsc_code'=>$ifsc,
//													'challan_timestamp'=>$currentdate,
//												'booking_timestamp'=>$currentdate,
//													'zone_id'=>000,
//													'port_id'=>$port_id,
//
//												);
//
//			$this->db->insert('transaction_details',$data_trans);
//			$this->session->set_userdata('sess_spot_bookid',$buk_id);
//			$this->session->unset_userdata('sess_spot_otp');
//			$this->db->trans_commit();
//                          //echo encode_url($buk_id);
//			redirect('Report/Onlinepayment_spot/'.encode_url($buk_id));
//						
//				}
//			else
//				{
//					 $this->db->trans_rollback();
//					 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error unable to complete Spot booking!!!</div>');
//					// redirect('Report/spot_registration_online');
//						redirect('Report/add_spot_registrationpaymentnew');
//				}
//
//			}//else limit
//
//		}//else validation
//
//		}//phone check else part else(diff<t_n)
//
//		}//phone check else part
//
//	//-#################################################################################################		
//		//}//spotbooking insert check if close added on [23/09/2019]
//		//else
//		//{
//		//	$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//		//	redirect('Report/add_spot_registrationpayment');
//		//}
////-------------------------------------------------------------------------------------------				
//						
//		} //post check
//
//		} //time check if close
//
//		else{ 
//
//		$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Not Possible Spot booking!!!</div>');
//
//					// redirect('Report/spot_registration_online');
//
//			redirect('Report/add_spot_registrationpaymentnew');
//					 }
//			$this->load->view('template/header');
//			$this->load->view('Report/spot_registration_paymentnew',$data);
//			$this->load->view('template/footer');
//			$this->load->view('template/js-footer');
//			$this->load->view('template/script-footer');
//			$this->load->view('template/html-footer');
//
//
//	}
//------------------------------------------------------------------------------------------
	
	
	public function checkavaliability_ton()
	{
		//print_r($_POST);exit;
		$port_id=$this->security->xss_clean(html_escape($this->input->post('port_id')));
		$zone_id=$this->security->xss_clean(html_escape($this->input->post('zone_id')));
		$spotton=$this->security->xss_clean(html_escape($this->input->post('spotton')));
		$update=date('Y-m-d');
	
		$res=$this->db->query("SELECT sum(spot_ton)  as spotton FROM `tbl_spotbooking_temp` WHERE spot_booking_validity=1 and `spotbooking_dte`='$update' and port_id='$port_id' and preferred_zone='$zone_id'");
		
		$getton=$res->result_array();
		$tonbooked=$getton[0]["spotton"];
	
		$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$update'");
				$ud=$queryspot->result_array();
				$limit_id=$ud[0]['spot_limit_id'];
				$limitqty=$ud[0]['spot_limit_quantity']; 
				$limitbalance=$ud[0]['spot_limit_balance']; 

				if($limitbalance > $spotton)
				{
					echo '<td colspan="2" ><div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left" >

		

		<input id="btn_change" name="btn_add" type="submit" class="btn btn-primary" value="Register"/>

        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />

       

        </div></td>';

				}
			else
			{
				echo 0;
			}
				
				
				
	}
//------------------------------------------------------------------------------------------
	
	
	
	
	
	
}
?>