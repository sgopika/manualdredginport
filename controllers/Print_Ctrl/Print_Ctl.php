<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_Ctl extends CI_Controller {

public function __construct() 
{
    
	parent::__construct();
	$this->load->library('session');
	$this->load->library('Phpass',array(8, FALSE));
	$this->load->helper('form');
	$this->load->helper('url');
	$this->load->database();
	$this->load->library('form_validation');
	$this->load->helper('date');
	//$this->load->helper('Specifictable_helper');
	$this->load->library('encrypt');
	$this->data 		= 	array(
		'controller' 			=> 	$this->router->fetch_class(),
		'method' 				=> 	$this->router->fetch_method(),
		'session_userdata' 		=> 	isset($this->session->userdata) ? $this->session->userdata : '',
		'base_url' 				=> 	base_url(),
		'site_url'  			=> 	site_url(),
		 'int_userid'       =>  isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,
          'int_usertype'    =>  isset($this->session->userdata['int_usertype']) ? $this->session->userdata['int_usertype'] : 0,
		'customer_id' 			=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
		'survey_user_id' 		=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
	);
    $this->load->model('Super_models/Super_model');
	$this->load->model('Kiv_models/Master_model');
	$this->load->model('Kiv_models/Survey_model');
	$this->load->model('Print_models/Print_model');
}

public function PrintHome()
{ 
	$sess_usr_id 	  	= $this->session->userdata('int_userid');
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==17))
	{


		$data 			=	 array('title' => 'PrintHome', 'page' => 'PrintHome', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			=	 $data + $this->data;
		/* ======Added for dynamic menu listing (start) on 26.11.2019========   */ 
		$menu			= 	$this->Super_model->get_supermenu($int_usertype); //print_r($menu);exit;
		$data['menu']	=	$menu;
		$data 			= 	$data + $this->data;

		$vessel_reg		= 	$this->Print_model->get_registered_vessels(); //print_r($menu);exit;
		$data['vessel_reg']	=	$vessel_reg;
		$data 			= 	$data + $this->data;

		$sdate=date('Y-m-d', strtotime('-30 days'));
    	$edate=date('Y-m-d');
		$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_rep($sdate,$edate); //print_r($vessel_reg_rep);exit;
		$data['vessel_reg_rep']	=	$vessel_reg_rep;
		$data 			= 	$data + $this->data;
		      
		$this->load->view('Kiv_views/template/dash-header.php');
   		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Print_views/Print/PrintHome.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
		
}

/*=========================================== Print (Start) ======================================================*/

public function show_print_xl_table()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==17))
	{	
		$data =	array('title' => 'show_print_xl_table', 'page' => 'show_print_xl_table', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$val 				= 	$this->input->post('val');//submodule
		$data['val']		=	$val;
		$id 				= 	$this->input->post('id');//1=All 2=New 3=Reprint
		$data['id']			=	$id;

		if($val==216){

			if($id==1)
			{
				$vessel_det		= 	$this->Print_model->get_registered_vessels_all(); //print_r($menu);exit;
			}
			else if($id==2)
			{
				$vessel_det		= 	$this->Print_model->get_registered_vessels(); //print_r($menu);exit;
			
			} elseif ($id==3) 
			{
				$vessel_det		= 	$this->Print_model->get_registered_vessels_reprint(); //print_r($menu);exit;
			}
			$data['vessel_det']	=	$vessel_det;
			$data 				= 	$data + $this->data;
		} else if($val==217){

			if($id==1){
				$sdate=date('Y-m-d', strtotime('-30 days'));
		    	$edate=date('Y-m-d');
				$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_all_rep($sdate,$edate);

			} else if($id==2){
				$sdate=date('Y-m-d', strtotime('-30 days'));
		    	$edate=date('Y-m-d');
				$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_rep($sdate,$edate); //print_r($menu);exit;
			} else if($id==3){
				$sdate=date('Y-m-d', strtotime('-30 days'));
		    	$edate=date('Y-m-d');
				$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_reprint_rep($sdate,$edate);
			}
			$data['vessel_reg_rep']	=	$vessel_reg_rep;
			$data 				= 	$data + $this->data;
		}	
		//print_r($vessel_det);
		

		$this->load->view('Print_views/Print/show_print_xl_table_Ajax.php', $data);

	}
	else
	{
		redirect('Main_login/index');        
  	}	
}	


public function show_rpt_dt_xl_table()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==17))
	{	
		$data =	array('title' => 'show_rpt_dt_xl_table', 'page' => 'show_rpt_dt_xl_table', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$from_date       = $this->security->xss_clean($this->input->post('start'));
      	$to_date         = $this->security->xss_clean($this->input->post('end'));
      	$id              = $this->security->xss_clean($this->input->post('id'));
      	$val              = $this->security->xss_clean($this->input->post('val'));
      	$data['id']	=	$id;
      	$data['val']	=	$val;
		    if($id==1){
				
				$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_all_rep($from_date,$to_date);

			} else if($id==2){
				
				$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_rep($from_date,$to_date); //print_r($menu);exit;
			} else if($id==3){
				
				$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_reprint_rep($from_date,$to_date);
			}
			$data['vessel_reg_rep']	=	$vessel_reg_rep;
			$data 				= 	$data + $this->data;
			
		//print_r($vessel_det);
		

		$this->load->view('Print_views/Print/show_rpt_dt_xl_table_Ajax.php', $data);

	}
	else
	{
		redirect('Main_login/index');        
  	}	
}


public function print_number()
{
  
  $this->load->model('Print_models/Print_model');
  $vessel_id    = $this->uri->segment(4);
  $act_id    = $this->uri->segment(5);

  $vessel_id     = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id);
  $vessel_id     = $this->encrypt->decode($vessel_id); 
  $act_id     = str_replace(array('-', '_', '~'), array('+', '/', '='), $act_id);
  $act_id     = $this->encrypt->decode($act_id); 
  $date  = date('Y-m-d H:i:s');
  
  //$this->load->view('Kiv_views/dash/form11_certificate_view',$data);
  $this->load->library('Pdf.php');
  $pdf =  $this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;

  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');

  $pdfFilePath = "Number_plate_".$vessel_id.".pdf";
	//table name  
	$get_cnt_val =  $this->Print_model->get_vessel_details_id($vessel_id);
	
	foreach($get_cnt_val as $res_cnt){
		$print_cnt_val = $res_cnt['print_count'];
	}
	$count_value = $print_cnt_val+1;


	if($act_id==3){
		$data_print = 	array(
	    'print_count ' => $count_value,
		'reprint_request_status'=>0,
		'reprint_approve_status'=>0);
	} 
	else if($act_id==1){
		if($print_cnt_val==0){
			$data_print = 	array(
    		'print_count ' => $count_value);
		} else{
			$data_print = 	array(
		    'print_count ' => $count_value,
			'reprint_request_status'=>0,
			'reprint_approve_status'=>0);
		}
	}
	else {
		$data_print = 	array(
    	'print_count ' => $count_value);
	}
	
    $updvessel_res		=	$this->Print_model->update_vessel_print_cnt($data_print,$vessel_id);
	if($updvessel_res){
		$get_rows =  $this->Print_model->get_regn_plate_id($vessel_id);
		$count_rows = count($get_rows);
		
    	if($count_rows==0){
    		$data_plate = 	array(
	    	'vessel_id ' => $vessel_id,
	    	'print_timestamp' => $date
	    	);
	    	$vessel_regn_det 	=	$this->db->insert('tbl_registrationplate', $data_plate);
    	} else{
    		$data_regn_plate= 	array(
	    	'reprint_status' => 1
	    	);
    		$updrep_res		=	$this->Print_model->update_regn_plate($data_regn_plate,$vessel_id);
    	}
    	

		  $html = $this->load->view('Print_views/Print/number_plate_view',$vessel_id,true);
		  $output=$pdf->WriteHTML($html);
		  $pdf->Output($output.$pdfFilePath, 'I');
		  exit(); 
	}
}

function print_all()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==17))
	{	
		$data =	array('title' => 'print_all', 'page' => 'print_all', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$items 				= 	$this->input->post('selectedItems'); //print_r($items);
		
		$selctd_ids			=	rtrim($items,'/');
		$selctd_idsexp 		= 	explode('/',$selctd_ids);
		$data['ids'] 		=	$selctd_idsexp;
		$data 				= 	$data + $this->data;
		$cnt_rw   			= count($selctd_idsexp);


		/*====TCPDF (start)===*/
		$this->load->library('pdf_tcpdf');

		$pdf = new TCPDF('P', 'mm', array(85.6,54));
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
			
		//Basic setup
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);


		for($i=0;$i<$cnt_rw;$i++){
			$vessel = $selctd_idsexp[$i];
			$vessel_details       =   $this->Print_model->get_vessel_details($vessel); //print_r($vessel_details);
		    $data['vessel_details']   = $vessel_details;

		    if(!empty($vessel_details))
			{
				foreach($vessel_details as $res_vessel)
			  	{
				    $vessel_name                =     $res_vessel['vesselmain_vessel_name'];
				    $vesselmain_reg_number       =     $res_vessel['vesselmain_reg_number'];
				    $print_cnt 					=		$res_vessel['print_count'];
				    $count_value = $print_cnt_val+1;
					$data_print = 	array(
				    'print_count ' => $count_value);
				    $updvessel_res		=	$this->Print_model->update_vessel_print_cnt($data_print,$vessel);
					if($updvessel_res){
					$pdf->AddPage();
					$pdf->SetAutoPageBreak(false, 0);

					/* name and profession and country */
					$pdf->SetFont('helveticaB', 'B', 12);	
				 	$pdf->SetFillColor(215, 235, 255);
					$pdf->SetY(58);
					$pdf->SetX(1);
					$pdf->MultiCell(52, 8, $vesselmain_reg_number."\n", 0, 'C', 0, 0, '' ,'', true, 0, false, true, 6, 'B');

					$pdf->SetFont('times', '', 9);	
					}
				}
			}
		}	
		$time=time();
		$pdfname='numberplate_'.$vessel.'_'.$time.'.pdf';


		// $this->db->set('md_print_status', 1); //value that used to update column  
		// $this->db->where('md_id', $id); //which row want to upgrade  
		// $this->db->update('tb_media');  //table name		

		$pdf->Output($pdfname, 'D');


		/*---mpdf(start)---$html = $this->load->view('Print_views/Print/multiple_number_plate_view',$data,true);
		
		include_once APPPATH.'/third_party/mpdf/mpdf.php';
		$pdfFilePath = "Number_plate.pdf";

		$pdf=new mPDF('utf-8', 'A4');
		$pdf->setFooter("Page {PAGENO} of {nb}");
		$output=$pdf->WriteHTML($html);
  // write the HTML into the PDF
		for($i=0;$i<$cnt_rw;$i++){
		$pdf->AddPage();
		}	
		$pdf->AddPage('P','','','','',0,0,0,0,0,0);
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment'); 
		//$pdf->WriteHTML($html2); // write the HTML into the PDF
		$pdf->Output($output.$pdfFilePath, 'I'); 
		exit();---mpdf(end)*/
			

	}	
}

function Vw_print_report(){

	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==17))
	{	
		$data =	array('title' => 'Vw_print_report', 'page' => 'Vw_print_report', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;

		$sdate=date('Y-m-d', strtotime('-30 days'));
    	$edate=date('Y-m-d');

	   
	    $day="";
	    $data['day']=$day;
	    $from_date       = $this->security->xss_clean($this->input->post('from_date'));
	    $to_date         = $this->security->xss_clean($this->input->post('to_date'));

	    
	      $initial_survey_done=$this->Survey_model->get_survey_done($process_id,$initial_survey_id,$from_date,$to_date);
	      $data['initial_survey_done']  = $initial_survey_done;
	    
	}	
	else
	{
		redirect('Main_login/index');        
  	}	

}


function generate_excel($from_dateenc,$to_dateenc,$idenc,$valenc){

	$this->load->model('Print_models/Print_model');

	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==17))
	{

		$data =	array('title' => 'generate_excel', 'page' => 'generate_excel', 'errorCls' => NULL, 'post' => $this->input->post());
		/*$data 				= 	$data + $this->data;
		$from_date          =   $this->security->xss_clean($this->input->post('from_dt'));
      	$to_date            =   $this->security->xss_clean($this->input->post('to_dt'));
      	$id                 =   $this->security->xss_clean($this->input->post('id'));
      	$val                =   $this->security->xss_clean($this->input->post('val'));*/
      	$from_dateen     = str_replace(array('-', '_', '~'), array('+', '/', '='), $from_dateenc);
        $from_date       = $this->encrypt->decode($from_dateen);
        $to_dateen       = str_replace(array('-', '_', '~'), array('+', '/', '='), $to_dateenc);
        $to_date         = $this->encrypt->decode($to_dateen);
        $iden            = str_replace(array('-', '_', '~'), array('+', '/', '='), $idenc);
        $id              = $this->encrypt->decode($iden);
        $valen           = str_replace(array('-', '_', '~'), array('+', '/', '='), $valenc);
        $val             = $this->encrypt->decode($valen); 

      	if($id==1){

      		$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_all_rep($from_date,$to_date);

      	} elseif ($id==2) {

      		$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_rep($from_date,$to_date);
      		
      	} elseif ($id==3) {

      		$vessel_reg_rep		= 	$this->Print_model->get_registered_vessels_reprint_rep($from_date,$to_date);
      		
      	} 

      	$data['vessel_reg_rep'] =   $vessel_reg_rep;
      	$data 				    = 	$data + $this->data;
      	///===================excel report generation==========(start)

      	$this->load->library("Excel");
		$object = new PHPExcel();

		$object->setActiveSheetIndex(0);

  		$table_columns = array("SLNO", "KIV NUMBER","REQUEST TIME", "PORT", "VESSEL" ,"OWNER");

  		$column = 0;

		foreach($table_columns as $field)
		{
		  $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
		  $column++;
		}
		$excel_row = 2;
		$no = 1; //print_r($vessel_reg_rep);
  		foreach($vessel_reg_rep as $row)
  		{ //echo $row['vesselmain_reg_number'];exit;
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
		   	$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['vesselmain_reg_number']);
		   	if ($id==3) {
		   	$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['reprint_reqtimestamp']);	
		   	} else {
		   	$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, '');
		    }
		   	$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['vchr_portoffice_name']);
		   	$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['vesselmain_vessel_name']);
		   	$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['user_master_fullname']);
		   	$excel_row++;
		 	$no++;
		}
        $fname = 'REPORT'.date('dmYHis').'.xls';
  		
  		header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$fname.'"'); 
        header('Cache-Control: max-age=0'); 
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
  		$object_writer->save('php://output');

      	///===================excel report generation==========(end)
	}
}		
/*============================================= Print (End) ==================================================*/	

/*============================================ VALIDATION(START) ===================================================*/

function alphanum_check($str)
{
	if($str!='')
	{
        
	if (!preg_match("/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-_]+$/i", $str))
        {
        $this->form_validation->set_message('alphanum_check', 'The %s field must contain only alphabets, numbers and characters like .-_');
            return FALSE;
        }

        else
        {
            return TRUE;
        }

	}
	else
	{
		 return TRUE;
	}
}	

/*============================================ VALIDATION(END) ===================================================*/

}
?>