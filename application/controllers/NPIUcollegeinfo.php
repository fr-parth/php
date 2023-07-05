<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NPIUcollegeinfo extends CI_Controller
{
	public function __construct()
	{
        parent::__construct(); 
       	$this->load->model('entity');
        $this->load->model('School_admin');	 	
	}    
	
	public function index($id=NULL)
	{
		if($id!=NULL){
			if($this->uri->segment(2)=="pid"){
				$data["college_detail"]=$this->School_admin->get_record("tbl_school_admin","aicte_permanent_id='".$id."'");
			}else{
				$data["college_detail"]=$this->School_admin->get_record("tbl_school_admin","aicte_application_id='".$id."'");
			}
		}			
			// print_r($data["college_detail"]); exit;
			$data["special_project_detail"]=$this->School_admin->get_records("tbl_special_project","project_enabled='1'");
			$this->load->view('npiu_college_data_form',$data);	
	}

	public function Search_college_Ajax()
	{
		$state=$_POST['st'];
		$city=$_POST['ct'];
		$where="";
		if($state!="" && $city!="")
		{
			$where = array('scadmin_state'=>$state,'scadmin_city'=>$city);
			// $where .="scadmin_state=$state AND scadmin_city=$city";
		}
		else if(isset($state) && $state!=""){
			$where = array('scadmin_state'=>$state);
		}
		else if(isset($city) && $city!="")
		{
			$where = array('scadmin_city'=>$city);
		}

		$b=$this->School_admin->get_records_byLike('tbl_school_admin',$where);
		//print_r(expression)
		echo '<option value="">Select College</option>';
		foreach ($b as $list) {
			print_r($b_option[]="<option value='".$list->school_id."|".$list->aicte_application_id."|".$list->aicte_permanent_id."'>".$list->school_name."</option>");
		}
		// echo '<option value="open">Other</option>';
	}
	public function Search_college_info()
	{
		$application_id=$_POST['application_id'];
		//$city=$_POST['ct'];
		$where="";
		if($application_id!="")
		{
			$where = array('aicte_application_id'=>$application_id);	
			$where2 = array('apply_id' =>$application_id);
		}

		$list=$this->School_admin->get_record('tbl_school_admin',$where);
		$list2=$this->School_admin->get_record('aicte_college_info',$where2);
		$b_option[0]=$list->scadmin_city;
		$b_option[1]=$list->scadmin_state;
		$b_option[2]=$list->aicte_permanent_id;
		$b_option[3]="<option value='".$list->school_id."'>".$list->school_name."</option>";
		$b_option[4]=$list2;
		$b_option[5]=$list->school_name;
		echo json_encode($b_option);
	/*	foreach ($b as $list) {
			print_r($b_option[]="<option value='".$list->school_id."'>".$list->school_name."</option>");
		}
		// echo '<option value="open">Other</option>';
		*/
	}
	
	public function Search_permanent_id()
	{
		$permanent_id=$_POST['permanent_id'];
		//echo $permanent_id; exit;
		$where="";
		if($permanent_id!="")
		{
			$where = array('aicte_permanent_id'=>$permanent_id);
			$where2 = array('aicte_id' =>$permanent_id);
		}
	
		$list=$this->School_admin->get_record('tbl_school_admin',$where);
		$list2=$this->School_admin->get_record('aicte_college_info',$where2);

		$b_option[0]=$list->scadmin_city;
		$b_option[1]=$list->scadmin_state;
		$b_option[2]=$list->aicte_application_id;
		$b_option[3]="<option value='".$list->school_id."'>".$list->school_name."</option>";
		$b_option[4]=$list2;
		$b_option[5]=$list->school_name;
		//echo json_encode($b_option);
		echo json_encode($b_option);
	}

	public function InsertCollege_data()
	{
		$ccarray=array();
		$incharge_names="";
		$clg_id1 = $_POST['colleges'];
		$exp=explode('|',$clg_id1);
		$clg_id=$exp['0'];
		$clg_name = $_POST['clg_name'];
		$apply_id = $_POST['apply_id'];
		$aicte_id = $_POST['aicte_id'];
		$impliment_date = date("Y-m-d",strtotime($_POST['implement_dt']));
		$informer_name = $_POST['informer_name'];
		$designation = $_POST['designation'];
		$email_id = $_POST['email_id'];
		// check if e-mail address is well-formed
	    if (filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$email_id);
	    }
		$phone_no = $_POST['phone_no'];
		$erp_incharge_nm = $_POST['erp_incharge_nm'];
		$erp_incharge_mob = $_POST['erp_incharge_mob'];
		$erp_incharge_email = $_POST['erp_incharge_email'];
		if (filter_var($erp_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$erp_incharge_email);
	    }
	    if($erp_incharge_nm!=""){
	    	$incharge_names.=$erp_incharge_nm." (ERP Incharge) <br>";
	    }

		$it_incharge_nm = $_POST['it_incharge_nm'];
		$it_incharge_mob = $_POST['it_incharge_mob'];
		$it_incharge_email = $_POST['it_incharge_email'];
		if (filter_var($it_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$it_incharge_email);
	    }
	    if($it_incharge_nm!=""){
	    	$incharge_names.=$it_incharge_nm." (IT Incharge) <br>";
	    }

		$aicte_incharge_nm = $_POST['aicte_incharge_nm'];
		$aicte_incharge_mob = $_POST['aicte_incharge_mob'];
		$aicte_incharge_email = $_POST['aicte_incharge_email'];
		if (filter_var($aicte_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$aicte_incharge_email);
	    }
	    if($aicte_incharge_nm!=""){
	    	$incharge_names.=$aicte_incharge_nm." (AICTE Coordinator) <br>";
	    }

		$tpo_incharge_nm = $_POST['tpo_incharge_nm'];
		$tpo_incharge_mob = $_POST['tpo_incharge_mob'];
		$tpo_incharge_email = $_POST['tpo_incharge_email'];
		if (filter_var($tpo_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$tpo_incharge_email);
	    }
	    if($tpo_incharge_nm!=""){
	    	$incharge_names.=$tpo_incharge_nm." (TPO) <br>";
	    }

		$art_incharge_nm = $_POST['art_incharge_nm'];
		$art_incharge_mob = $_POST['art_incharge_mob'];
		$art_incharge_email = $_POST['art_incharge_email'];
		if (filter_var($art_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$art_incharge_email);
	    }
	    if($art_incharge_nm!=""){
	    	$incharge_names.=$art_incharge_nm." (Art circle Incharge) <br>";
	    }

		$student_incharge_nm = $_POST['student_incharge_nm'];
		$student_incharge_mob = $_POST['student_incharge_mob'];
		$student_incharge_email = $_POST['student_incharge_email'];
		if (filter_var($student_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$student_incharge_email);
	    }
	    if($student_incharge_nm!=""){
	    	$incharge_names.=$student_incharge_nm." (Student Affair Incharge) <br>";
	    }

		$admin_incharge_nm = $_POST['admin_incharge_nm'];
		$admin_incharge_mob = $_POST['admin_incharge_mob'];
		$admin_incharge_email = $_POST['admin_incharge_email'];
		if (filter_var($admin_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$admin_incharge_email);
	    }
	    if($admin_incharge_nm!=""){
	    	$incharge_names.=$admin_incharge_nm." (Admin Dept. Incharge) <br>";
	    }

		$exam_incharge_nm = $_POST['exam_incharge_nm'];
		$exam_incharge_mob = $_POST['exam_incharge_mob'];
		$exam_incharge_email = $_POST['exam_incharge_email'];
		if (filter_var($exam_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$exam_incharge_email);
	    }
	    if($exam_incharge_nm!=""){
	    	$incharge_names.=$exam_incharge_nm." (Exam Dept. Incharge) <br>";
	    }

		$placement_incharge_nm = $_POST['place_incharge_nm'];
		$placement_incharge_mob = $_POST['place_incharge_mob'];
		$placement_incharge_email = $_POST['place_incharge_email'];
		if (filter_var($placement_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$placement_incharge_email);
	    }
	    if($placement_incharge_nm!=""){
	    	$incharge_names.=$placement_incharge_nm." (Other contact person) <br>";
	    }

	    $nss_incharge_nm = $_POST['nss_incharge_nm'];
		$nss_incharge_mob = $_POST['nss_incharge_mob'];
		$nss_incharge_email = $_POST['nss_incharge_email'];
		if (filter_var($nss_incharge_email, FILTER_VALIDATE_EMAIL)) {
	      array_push($ccarray,$nss_incharge_email);
	    }
	    if($nss_incharge_nm!=""){
	    	$incharge_names.=$nss_incharge_nm." (NSS club Incharge) <br>";
	    }

		$placement_help = $_POST['place_help'];
		$ncc_incharge_nm = $_POST['ncc_incharge_nm'];
		$ncc_incharge_mob = $_POST['ncc_incharge_mob'];
		$ncc_incharge_email = $_POST['ncc_incharge_email'];
		$abvp_incharge_nm = $_POST['abvp_incharge_nm'];
		$abvp_incharge_mob = $_POST['abvp_incharge_mob'];
		$abvp_incharge_email = $_POST['abvp_incharge_email'];
		$nsui_incharge_nm = $_POST['nsui_incharge_nm'];
		$nsui_incharge_mob = $_POST['nsui_incharge_mob'];
		$nsui_incharge_email = $_POST['nsui_incharge_email'];
		if($_POST['erp_meet_date']!=""){$erp_meet_date=date('Y-m-d H:i:s',strtotime($_POST['erp_meet_date']));}else{ $erp_meet_date="NULL";}
        if($_POST['it_meet_date']){ $it_meet_date =date('Y-m-d H:i:s',strtotime($_POST['it_meet_date']));}else{ $it_meet_date="NULL";}
        if($_POST['aicte_meet_date']){ $aicte_meet_date =date('Y-m-d H:i:s',strtotime($_POST['aicte_meet_date']));}else{ $aicte_meet_date="NULL";}
        if($_POST['tpo_meet_date']){ $tpo_meet_date =date('Y-m-d H:i:s',strtotime($_POST['tpo_meet_date']));}else{ $tpo_meet_date="NULL";}
        if($_POST['art_meet_date']){ $art_meet_date =date('Y-m-d H:i:s',strtotime($_POST['art_meet_date']));}else{ $art_meet_date="NULL";}
        if($_POST['student_meet_date']){ $student_meet_date =date('Y-m-d H:i:s',strtotime($_POST['student_meet_date']));}else{ $student_meet_date="NULL";}
        if($_POST['admin_meet_date']){ $admin_meet_date =date('Y-m-d H:i:s',strtotime($_POST['admin_meet_date']));}else{ $admin_meet_date="NULL";}
        if($_POST['exam_meet_date']){ $exam_meet_date =date('Y-m-d H:i:s',strtotime($_POST['exam_meet_date']));}else{ $exam_meet_date="NULL";}
        if($_POST['erp_meet_date']){ $placement_meet_date =date('Y-m-d H:i:s',strtotime($_POST['erp_meet_date']));}else{ $placement_meet_date="NULL";}
        if($_POST['nss_meet_date']){ $nss_meet_date =date('Y-m-d H:i:s',strtotime($_POST['nss_meet_date']));}else{ $nss_meet_date="NULL";}

		$cid = $_POST['c_id'];
		$data = array('college_id'=>$clg_id,'college_name'=>$clg_name,'apply_id'=>$apply_id,'aicte_id'=>$aicte_id,'impliment_date'=>$impliment_date,'informer_name'=>$informer_name,'designation'=>$designation,'erp_incharge_nm'=>$erp_incharge_nm,'email_id'=>$email_id,'phone_no'=>$phone_no,'erp_incharge_mob'=>$erp_incharge_mob,'erp_incharge_email'=>$erp_incharge_email,'it_incharge_nm'=>$it_incharge_nm,'it_incharge_mob'=>$it_incharge_mob,'it_incharge_email'=>$it_incharge_email,'aicte_incharge_nm'=>$aicte_incharge_nm,'aicte_incharge_mob'=>$aicte_incharge_mob,'aicte_incharge_email'=>$aicte_incharge_email,'tpo_incharge_nm'=>$tpo_incharge_nm,'tpo_incharge_mob'=>$tpo_incharge_mob,'tpo_incharge_email'=>$tpo_incharge_email,'art_incharge_nm'=>$art_incharge_nm,'art_incharge_mob'=>$art_incharge_mob,'art_incharge_email'=>$art_incharge_email,'student_incharge_nm'=>$student_incharge_nm,'student_incharge_mob'=>$student_incharge_mob,'student_incharge_email'=>$student_incharge_email,'admin_incharge_nm'=>$admin_incharge_nm,'admin_incharge_mob'=>$admin_incharge_mob,'admin_incharge_email'=>$admin_incharge_email,'exam_incharge_nm'=>$exam_incharge_nm,'exam_incharge_mob'=>$exam_incharge_mob,'exam_incharge_email'=>$exam_incharge_email,'placement_help'=>$placement_help,'placement_incharge_nm'=>$placement_incharge_nm,'placement_incharge_mob'=>$placement_incharge_mob,'placement_incharge_email'=>$placement_incharge_email,'nss_incharge_nm'=>$nss_incharge_nm,'nss_incharge_mob'=>$nss_incharge_mob,'nss_incharge_email'=>$nss_incharge_email,'ncc_incharge_nm'=>$ncc_incharge_nm,'ncc_incharge_mob'=>$ncc_incharge_mob,'ncc_incharge_email'=>$ncc_incharge_email,'abvp_incharge_nm'=>$abvp_incharge_nm,'abvp_incharge_mob'=>$abvp_incharge_mob,'abvp_incharge_email'=>$abvp_incharge_email,'nsui_incharge_nm'=>$nsui_incharge_nm,'nsui_incharge_mob'=>$nsui_incharge_mob,'nsui_incharge_email'=>$nsui_incharge_email,'erp_meet_date' => $erp_meet_date,
        'it_meet_date' => $it_meet_date,'aicte_meet_date' => $aicte_meet_date,'tpo_meet_date' => $tpo_meet_date,
        'art_meet_date' => $art_meet_date,'student_meet_date' => $student_meet_date,'admin_meet_date' => $admin_meet_date,
        'exam_meet_date' => $exam_meet_date,'placement_meet_date' => $placement_meet_date,'nss_meet_date' => $nss_meet_date);


		$project_cnt = count($_POST['project_id']);
		for($k=0;$k<$project_cnt;$k++){
			$project_id = $_POST['project_id'][$k];
			$project_name = $_POST['project_name'][$k];
			$project_incharge_nm = $_POST['project_incharge_nm'][$k];
			$project_incharge_mob = $_POST['project_incharge_mob'][$k];
			$project_incharge_email = $_POST['project_incharge_email'][$k];
			$data2 = array('college_id' => $clg_id,'college_name' => $clg_name,'special_project_name' => $project_name,'special_project_id' => $project_id,'special_project_coordinator_name' => $project_incharge_nm,'special_project_coordinator_phone' => $project_incharge_mob,'special_project_coordinator_email' => $project_incharge_email);
			// print_r($data2);
		 	$rec_id2 = $this->School_admin->InsertData('tbl_special_project_coordinators',$data2);
		}
		// echo $cid; exit;
		// print_r($ccarray); exit;
		if($cid!=""){
			$condition = array('id' =>$cid);
		 	$rec_id = $this->School_admin->UpdateData('aicte_college_info',$data,$condition);			
		}else{
		 	$rec_id = $this->School_admin->InsertData('aicte_college_info',$data);
		}
		if($rec_id){

			$emailpar= $this->School_admin->get_records_3joins('aicte_email_setup.id,aicte_email_setup.is_active,tbl_email_parameters.host,tbl_email_parameters.email_id,tbl_email_parameters.email_password,tbl_email_parameters.port,tbl_email_sms_templates.subject,tbl_email_sms_templates.email_body','aicte_email_setup','tbl_email_parameters','tbl_email_sms_templates','aicte_email_setup.email_id=tbl_email_parameters.e_id','aicte_email_setup.email_template_id=tbl_email_sms_templates.id','1','single');
			// $emailformat= $this->School_admin->get_record(,'type="AICTE College Readiness"');
// 			print_r($emailpar);
// 			echo "<br>";
// 			print_r($emailformat);
// exit;
			if($emailpar->is_active==1){
				$email_body=$emailpar->email_body;
				$email_body=str_replace("{implementation_date}", $_POST['implement_dt'], $email_body);
				$email_body=str_replace("{informer_name}", $_POST['informer_name'], $email_body);
				$email_body=str_replace("{incharge_name}", $incharge_names, $email_body);
				$email_body=str_replace("[college_name]", $clg_name, $email_body);
				$email_body=str_replace("[college_id]", $clg_id, $email_body);

				$email_body=str_replace("[implementation_date]", date('d M Y',strtotime($_POST['implement_dt'])), $email_body);
				$email_body=str_replace("[informer_name]", $_POST['informer_name'], $email_body);
				$email_body=str_replace("[informer_designation]", $_POST['designation'], $email_body);
				$email_body=str_replace("[incharge_aicte]", $_POST['aicte_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_erp]", $_POST['erp_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_it]", $_POST['it_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_student]", $_POST['student_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_tpo]", $_POST['tpo_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_art]", $_POST['art_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_nss]", $_POST['nss_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_placement]", $_POST['tpo_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_exam]", $_POST['exam_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_admin]", $_POST['admin_incharge_nm'], $email_body);
				$email_body=str_replace("[incharge_sports]", $_POST['sports_incharge_nm'], $email_body);
				
			$this->load->library('email');

			$this->email->initialize(array(
			  'protocol' => 'mail',
			  'smtp_host' => $emailpar->host, // 'smtp.sendgrid.net',
			  'smtp_user' => $emailpar->email_id, // 'sendgridusername',
			  'smtp_pass' => $emailpar->email_password, // 'sendgridpassword',
			  'smtp_port' => $emailpar->port, //587,
			  'priority' => 1, // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
			  'newline' => "\r\n",
			  'wordwrap' => TRUE,
			  'charset' =>"utf-8",
			  'mailtype' => "html"
			));
			$this->email->set_newline("\r\n");

			$this->email->from($emailpar->email_id, 'Smart Cookie');
			$this->email->to($email_id);
			$this->email->cc($ccarray);
			// $this->email->bcc('kunalwaghmare20@gmail.com');
			$this->email->subject($emailpar->subject);
			$this->email->message($email_body);
			// $this->email->send();
			// echo $email_body;
			// echo $this->email->print_debugger();
			// exit;
			}
			// echo ("<script LANGUAGE='JavaScript'> alert('Thanks for updating your college information. We will contact you soon for further process.'); window.location.href='../index.php';</script>");
			$this->session->set_flashdata("success_msg","Thanks for updating your college information. We will contact you soon for further process.");
		$data2['success_msg']= "Thanks for updating your college information. We will contact you soon for further process.";
		}else{
			// echo "<script>alert('Something went wrong, Please try again!'); window.location.href='../index.php';</script>";
			$this->session->set_flashdata("error_msg","Data not added, Please try again!");
		$data2['error_msg']= "Data not added, Please try again!";
		}
		$data3 = array_merge($data,$data2);
		// print_r($data3); exit;
		$this->load->view('download_mou.php',$data3);
	}

	public function Search_college_data()
	{
		$sc_id=$_POST['sc_id'];
		//$city=$_POST['ct'];
		$where="";
		if($sc_id!="")
		{
			$where = array('college_id'=>$sc_id);	
		}

		$list=$this->School_admin->get_record('aicte_college_info',$where);
		$b_option[]=$list;
		// if(!empty($list->apply_id)){
			echo json_encode($b_option);
		// }else{
		// 	echo json_encode(array('0'=>0));
		// }
	/*	foreach ($b as $list) {
			print_r($b_option[]="<option value='".$list->school_id."'>".$list->school_name."</option>");
		}
		// echo '<option value="open">Other</option>';
		*/
	}

	public function SendMailToIncharge()
	{
		$cid=$_POST['cid'];
		$email_id=$_POST['incharge_email'];
		$sender_id=$_POST['email_id'];
		$temp_id=$_POST['email_template_id'];
		$incharge=$_POST['incharge'];
		$incharge_name = $_POST['incharge_name'];
		$incharge_mobile = $_POST['incharge_mobile'];
		$where="";
		if($cid!="")
		{
			$where = array('college_id'=>$cid);	
		}
		if($temp_id!="")
		{
			$where2 = array('id'=>$temp_id);	
		}
		if($sender_id!="")
		{
			$where3 = array('e_id'=>$sender_id);	
		}
		// print_r($_POST); exit;
		$list=$this->School_admin->get_record('aicte_college_info',$where);
		$email_temp=$this->School_admin->get_record('tbl_email_sms_templates',$where2);
		$email_par=$this->School_admin->get_record('tbl_email_parameters',$where3);

			$email_body=$email_temp->email_body;
				$email_body=str_replace("{implementation_date}", $list->implement_dt, $email_body);
				$email_body=str_replace("{informer_name}", $list->informer_name, $email_body);

				$email_body=str_replace("[incharge_name]", $incharge_name, $email_body);
				$email_body=str_replace("[incharge_mobile]", $incharge_mobile, $email_body);
				$email_body=str_replace("[incharge_email]", $email_id, $email_body);
				$email_body=str_replace("[college_name]", $list->college_name, $email_body);
				$email_body=str_replace("[college_id]", $cid, $email_body);
				$email_body=str_replace("[implementation_date]", date('d M Y',strtotime($list->implement_dt)), $email_body);
				$email_body=str_replace("[fillup_date]", date('d M Y',strtotime($list->reg_date)), $email_body);
				$email_body=str_replace("[informer_name]", $list->informer_name, $email_body);
				$email_body=str_replace("[informer_designation]", $list->designation, $email_body);
				
			$this->load->library('email');

			$this->email->initialize(array(
			  'protocol' => 'mail',
			  'smtp_host' => $email_par->host, // 'smtp.sendgrid.net',
			  'smtp_user' => $email_par->email_id, // 'sendgridusername',
			  'smtp_pass' => $email_par->email_password, // 'sendgridpassword',
			  'smtp_port' => $email_par->port, //587,
			  'priority' => 1, // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
			  'newline' => "\r\n",
			  'wordwrap' => TRUE,
			  'charset' =>"utf-8",
			  'mailtype' => "html"
			));
			$this->email->set_newline("\r\n");

			$this->email->from($email_par->email_id, 'Smart Cookie');
			$this->email->to($email_id);
			// $this->email->cc($ccarray);
			// $this->email->bcc('kunalwaghmare20@gmail.com');
			$this->email->subject($email_temp->subject);
			$this->email->message($email_body);
			$this->email->send();
			// echo $email_body;
			// echo $this->email->print_debugger();
			// exit;
			echo ("<script LANGUAGE='JavaScript'>
					alert('Email has been sent successfully to ".$incharge_name.".');
					</script>");
			$_SESSION['success_msg']="Email has been sent successfully to ".$incharge_name;

		redirect(base_url('core/group_admin/aicte_send_email.php?cid='.$cid.'&in='.$incharge),'refresh');
	}		
			
	public function CollegeReadinessMeeting($id,$incharge)
	{
		if($id!=NULL){
			$data["college_detail"]=$this->School_admin->get_record("aicte_college_info","college_id='".$id."'");
			// print_r($data["college_detail"]); exit;
			$incharge_name="";
			$incharge_mob="";
			$incharge_email="";
			if($incharge){
			switch ($incharge) {
		    case 'informer':
		       $incharge_name=$data["college_detail"]->informer_name;
		       $incharge_mob=$data["college_detail"]->phone_no;
		       $incharge_email=$data["college_detail"]->email_id;
		       $incharge_type=$data["college_detail"]->designation;
		        break;
		    case 'erp':
		       $incharge_name=$data["college_detail"]->erp_incharge_nm;
		       $incharge_mob=$data["college_detail"]->erp_incharge_mob;
		       $incharge_email=$data["college_detail"]->erp_incharge_email;
		       $incharge_type="ERP In-charge";
		        break;
		    case 'it':
		       $incharge_name=$data["college_detail"]->it_incharge_nm;
		       $incharge_mob=$data["college_detail"]->it_incharge_mob;
		       $incharge_email=$data["college_detail"]->it_incharge_email;
		       $incharge_type="IT In-charge";
		        break;
		    case 'aicte':
		       $incharge_name=$data["college_detail"]->aicte_incharge_nm;
		       $incharge_mob=$data["college_detail"]->aicte_incharge_mob;
		       $incharge_email=$data["college_detail"]->aicte_incharge_email;
		       $incharge_type="AICTE Co-ordinator";
		        break;
		    case 'tpo':
		       $incharge_name=$data["college_detail"]->tpo_incharge_nm;
		       $incharge_mob=$data["college_detail"]->tpo_incharge_mob;
		       $incharge_email=$data["college_detail"]->tpo_incharge_email;
		       $incharge_type="TPO In-charge";
		        break;
		    case 'art':
		       $incharge_name=$data["college_detail"]->art_incharge_nm;
		       $incharge_mob=$data["college_detail"]->art_incharge_mob;
		       $incharge_email=$data["college_detail"]->art_incharge_email;
		       $incharge_type="Arts / Clubs In-charge";
		        break;
		    case 'student':
		       $incharge_name=$data["college_detail"]->student_incharge_nm;
		       $incharge_mob=$data["college_detail"]->student_incharge_mob;
		       $incharge_email=$data["college_detail"]->student_incharge_email;
		       $incharge_type="Student In-charge";
		        break;
		    case 'admin':
		       $incharge_name=$data["college_detail"]->admin_incharge_nm;
		       $incharge_mob=$data["college_detail"]->admin_incharge_mob;
		       $incharge_email=$data["college_detail"]->admin_incharge_email;
		       $incharge_type="Admin In-charge";
		        break;
		    case 'exam':
		       $incharge_name=$data["college_detail"]->exam_incharge_nm;
		       $incharge_mob=$data["college_detail"]->exam_incharge_mob;
		       $incharge_email=$data["college_detail"]->exam_incharge_email;
		       $incharge_type="Exam In-charge";
		        break;
		    case 'nss':
		       $incharge_name=$data["college_detail"]->nss_incharge_nm;
		       $incharge_mob=$data["college_detail"]->nss_incharge_mob;
		       $incharge_email=$data["college_detail"]->nss_incharge_email;
		       $incharge_type="NSS In-charge";
		        break;
		    case 'sports':
		       $incharge_name=$data["college_detail"]->sports_incharge_nm;
		       $incharge_mob=$data["college_detail"]->sports_incharge_mob;
		       $incharge_email=$data["college_detail"]->sports_incharge_email;
		       $incharge_type="Sports In-charge";
		        break;
		    case 'other':
		       $incharge_name=$data["college_detail"]->placement_incharge_nm;
		       $incharge_mob=$data["college_detail"]->placement_incharge_mob;
		       $incharge_email=$data["college_detail"]->placement_incharge_email;
		       $incharge_type="Other Person";
		        break;
		    
		    default:
        		break;
			}
				$data["incharge_detail"]=array('incharge_name'=>$incharge_name,'incharge_mobile'=>$incharge_mob,'incharge_email'=>$incharge_email,'incharge_type'=>$incharge_type);
		}
			$this->load->view('incharge_data_form',$data);	
		}else{
			redirect(base_url());	
		}
	}

	public function Update_Incharge_data()
	{
		// print_r($_POST); exit;
		$clg_name=$_POST['clg_name'];
		$id=$_POST['c_id'];
		$incharge=$_POST['incharge_type'];
		$incharge_label=$_POST['type'];
		if($incharge!=""){
			$incharge_name=$_POST['incharge_nm'];
			$incharge_email=$_POST['incharge_email'];
			$incharge_mobile=$_POST['incharge_mob'];
			$incharge_meeting_date=$_POST['meeting_date'];
			$incharge_meeting_time=$_POST['meeting_time'];
			$date_time=$incharge_meeting_date." ".$incharge_meeting_time;
			if($incharge){
			switch ($incharge) {
		    case 'informer':
		       $field_name="informer_meet_date";
		        break;
		    case 'erp':
		       $field_name="erp_meet_date";
		        break;
		    case 'it':
		       $field_name="it_meet_date";
		        break;
		    case 'aicte':
		       $field_name="aicte_meet_date";
		        break;
		    case 'tpo':
		       $field_name="tpo_meet_date";
		        break;
		    case 'art':
		       $field_name="art_meet_date";
		        break;
		    case 'student':
		       $field_name="student_meet_date";
		        break;
		    case 'admin':
		       $field_name="erp_meet_date";
		        break;
		    case 'exam':
		       $field_name="exam_meet_date";
		        break;
		    case 'nss':
		       $field_name="nss_meet_date";
		        break;
		    case 'sports':
		       $field_name="sports_meet_date";
		        break;
		    case 'other':
		       $field_name="placement_meet_date";
		        break;
		    
		    default:
        		break;
			}
			$data=array($field_name=>$date_time);
			$cond=array('college_id'=>$id);
		}
			$record=$this->School_admin->UpdateData('aicte_college_info',$data,$cond);
			
			$cond2=array('use_default'=>'1');
			$emailpar=$this->School_admin->get_record('tbl_email_parameters',$cond2);
			
			if($emailpar->use_default==1){
			$this->load->library('email');
			$this->email->initialize(array(
			  'protocol' => 'mail',
			  'smtp_host' => $emailpar->host, // 'smtp.sendgrid.net',
			  'smtp_user' => $emailpar->email_id, // 'sendgridusername',
			  'smtp_pass' => $emailpar->email_password, // 'sendgridpassword',
			  'smtp_port' => $emailpar->port, //587,
			  'priority' => 1, // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
			  'newline' => "\r\n",
			  'wordwrap' => TRUE,
			  'charset' =>"utf-8",
			  'mailtype' => "html"
			));
			$cond3=array('type'=>'Reply_Email_For_AICTE_Data');
			$emaildetail=$this->School_admin->get_record('tbl_email_sms_templates',$cond3);
			$subject=$emaildetail->subject;
 			$subject=str_replace("[incharge_type]", $incharge_label, $subject);
			
			$email_body=$emaildetail->email_body;
			
				$email_body=str_replace("[incharge_name]", $incharge_name, $email_body);
 				$email_body=str_replace("[incharge_mobile]", $incharge_mobile, $email_body);
 				$email_body=str_replace("[incharge_email]", $email_id, $email_body);
 				$email_body=str_replace("[college_name]", $clg_name, $email_body);
 				$email_body=str_replace("[college_id]", $id, $email_body);
 				$email_body=str_replace("[meeting_date]", date('d M Y',strtotime($incharge_meeting_date)), $email_body);
 				$email_body=str_replace("[meeting_time]", date('H:i a',strtotime($incharge_meeting_time)), $email_body);
 				$email_body=str_replace("[incharge_type]", $incharge_label, $email_body);
 				
			$this->email->set_newline("\r\n");

			$this->email->from($incharge_email,$incharge_name);
			$this->email->to('spoc360@smartcookie.in');
			$this->email->reply_to($incharge_email,$incharge_name);
			// $this->email->cc($ccarray);
			// $this->email->bcc('kunalwaghmare20@gmail.com');
			$this->email->subject($subject);
			$this->email->message($email_body);
			$this->email->send();
			// echo $email_body;
			// echo $this->email->print_debugger();
			// exit;
			// redirect(base_url());	
			}
			echo "<script>alert('Thank you for giving us meeting date and time.');

					window.location.href='../index.php';</script>";
			}else{
			redirect(base_url());	
		}
	}

	public function College_MOU($id=NULL)
	{
		if($id!=NULL){
				$data["college"]=$this->School_admin->get_record("tbl_school_admin","school_id='".$id."'");
			$this->load->view('college_mou',$data);	
		}else{
			echo "<script>alert('Data not found');

					window.location.href='../index.php';</script>";
		}			
			// print_r($data["college_detail"]); exit;
	}
}