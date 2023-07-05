<?php 
class Clogin extends CI_Controller
{
	function __construct()

    {
    	ini_set('memory_limit', '512M');
        parent::__construct();
   
        $this->load->model('student');

        $this->load->model('teacher');
		$this->load->model('Mlogin');
						
    }

	public function index(){
		$this->load->view('index');		
	}	
	public function login($entity){
		$a = array('sponsor','student','salesperson','employee','teacher','manager');
		if (!in_array($entity, $a)) {			
			redirect('/Clogin', 'location', 301);
		}	
		$data['report']="";
		$data['LoginOption']="EmailID";
		$data['EmailID']="";
		$data['OrganizationID']="";
		$data['EmployeeID']="";
		$data['CountryCode']="";
		$data['PhoneNumber']="";
		$data['Password']="";
		$data['entity']=$entity;	
		$data['index_url']=base_url();
		
		$this->load->view('login',$data);
	}
	public function duplicate_email()
	{
		//print_r($all_value);exit;
		$this->load->view('duplicate_email');
	}
	public function duplicate_phone()
	{
		//print_r($all_value);exit;
		$this->load->view('duplicate_email');
	}
	public function login_duplicate($entity,$record)
	{
		switch($entity){
			case 'teacher':
				$user='Teacher';
					//print_r($record);exit;
					$this->db->where('id',$record);
					$record=$this->db->get('tbl_teacher')->result_array();
					//print_r($this->db->last_query());exit;die;
			
					$data = array(
                 			  	't_id'  =>  $record[0]['t_id'],
								'school_id' => $record[0]['school_id'],
								'id' => $record[0]['id'],
								'is_loggen_in'=>1,
								'entity'=> 'teacher',
								'entity_id'=> '2',
								'usertype'=> 'teacher',
								'entity_typeid'=>$record[0]['t_emp_type_pid'],
								't_department'=>$record[0]['t_dept'],
								//t_class added by Sayali Balkawade for SMC-4277 on 27/12/2019
								't_class'=>$record[0]['t_class']
					);
					//print_r($data);exit;
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(103,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);
					// redirect('teacher');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;
			case 'manager':
				$user='manager';
				//print_r($record);exit;
					$this->db->where('id',$record);
					$record=$this->db->get('tbl_teacher')->result_array();					
					$data = array(
                 			  	't_id'  =>  $record[0]['t_id'],
								'school_id' => $record[0]['school_id'],
								'id' => $record[0]['id'],
								'is_loggen_in'=>1,
								'entity'=> 'teacher',
								'entity_id'=> '2',
								'usertype'=> 'manager',
								'entity_typeid'=>$record[0]['t_emp_type_pid'],
								't_department'=>$record[0]['t_dept'],
								//t_class added by Sayali Balkawade for SMC-4277 on 27/12/2019
								't_class'=>$record[0]['t_class']
					);
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(103,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);
					// redirect('teacher');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;		
			
			case 'student':	
				$user='student';
				$this->db->where('id',$record);
				$record=$this->db->get('tbl_student')->result_array();
				//print_r($record[0]['std_PRN']);exit;
					$data = array(
                 			  	'std_PRN'  =>  @$record[0]['std_PRN'],
								'school_id' => @$record[0]['school_id'],
								'stud_id' => @$record[0]['id'],
								'username'=> @$record[0]['std_email'],
								'is_loggen_in'=>1,
								'entity'=> 'student',
								'usertype'=> 'student',
					);
					//print_r($data);exit;
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(105,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);

					// redirect('main/members');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;
				case 'employee':	
					$user='employee';
					$this->db->where('id',$record);
					$record=$this->db->get('tbl_student')->result_array();
					
					$data = array(
                 			  	'std_PRN'  =>  $record[0]['std_PRN'],
								'school_id' => $record[0]['school_id'],
								'stud_id' => $record[0]['id'],
								'username'=> $record[0]['std_email'],
								'is_loggen_in'=>1,
								'entity'=> 'student',
								'usertype'=> 'employee',
					);
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(205,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);
					
					// redirect('main/members');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;		
			
			default:
				$user='';
				break;
		}
		//echo $record;exit;
		
		// $data = array(
                 			  	// 't_id'  =>  $record[0]->t_id,
								// 'school_id' => $record[0]->school_id,
								// 'id' => $record[0]->id,
								// 'is_loggen_in'=>1,
								// 'entity'=> 'teacher',
								// 'entity_id'=> '2',
								// 'usertype'=> 'teacher',
								// 'entity_typeid'=>$record[0]->t_emp_type_pid,
								// 't_department'=>$record[0]->t_dept,
								//t_class added by Sayali Balkawade for SMC-4277 on 27/12/2019
								// 't_class'=>$record[0]->t_class
					// );
					//echo "<pre>";print_r($data);exit;
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(103,$record->id,$lat,$lon,$CountryCode,$record->school_id);
					// redirect('teacher');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
		
		/*$entity=$this->uri->segment('3');
		$id=$this->input->post('id');
		$this->db->where('entity_type_id',$entity);
		$this->db->where('id',$id);
		$login=$this->db->get('tbl_teacher')->result_array();
		if(count($login)>0)
		{
			$this->load->view('teacher/dashboard');
		}*/
		//print_r($login);exit;
		
	}
	public function logout()
    {
		$this->load->model("Mlogin");
		$this->Mlogin->sessionLogout();
        $this->session->sess_destroy();
        redirect(base_url());
    }
	public function setLoginLogoutStatus($EntityID, $UserID,$lat,$lon,$CountryCode,$school_id=''){
		$browse=$this->getBrowser();
		$browser=$browse['name'].' '.$browse['version']; 
		$ip=$this->getIP();
		$os=$this->getOS();
		
		$this->load->model("Mlogin");
		$this->Mlogin->setLoginLogoutStatus($EntityID, $UserID,$lat,$lon,$CountryCode,$ip,$os,$browser,$school_id);
	}

public function setSessionAndForward($entity,$record,$CountryCode,$lat,$lon){		

		
		switch($entity){
			case 1:
				$user='School Admin';
						$_SESSION['id'] = $record[0]['id'];					
						$_SESSION['school_id'] = $record[0]['school_id'];
						$this->setLoginLogoutStatus(102,$record[0]['id'],$lat,$lon,$CountryCode,$record[0]['school_id']);
						$_SESSION['entity'] = 1;					
						$_SESSION['username'] = $record[0]['email'];
						// added by Sayali 
						$_SESSION['is_accept_terms'] = $record[0]['is_accept_terms'];
						//header("Location:scadmin_dashboard.php");					
				break;
			case 'teacher':
				$user='Teacher';
										
					$data = array(
                 			  	't_id'  =>  $record[0]->t_id,
								'school_id' => $record[0]->school_id,
								'id' => $record[0]->id,
								'is_loggen_in'=>1,
								'entity'=> 'teacher',
								'entity_id'=> '2',
								'usertype'=> 'teacher',
								'entity_typeid'=>$record[0]->t_emp_type_pid,
								't_department'=>$record[0]->t_dept,
								//t_class added by Sayali Balkawade for SMC-4277 on 27/12/2019
								't_class'=>$record[0]->t_class
					);
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(103,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);
					// redirect('teacher');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;
			case 'manager':
				$user='manager';
										
					$data = array(
                 			  	't_id'  =>  $record[0]->t_id,
								'school_id' => $record[0]->school_id,
								'id' => $record[0]->id,
								'is_loggen_in'=>1,
								'entity'=> 'teacher',
								'entity_id'=> '2',
								'usertype'=> 'manager',
								'entity_typeid'=>$record[0]->t_emp_type_pid,
								't_department'=>$record[0]->t_dept,
								//t_class added by Sayali Balkawade for SMC-4277 on 27/12/2019
								't_class'=>$record[0]->t_class
					);
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(203,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);
					// redirect('teacher');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;		
			case 5:
				$user='Parent';
						$_SESSION['id'] = $record[0]['id'];
						$_SESSION['entity'] = 5;	
						$this->setLoginLogoutStatus(106,$record[0]['id'],$lat,$lon,$CountryCode);
						if($record[0]['email_id']!=''){
							$_SESSION['username'] = $record[0]['email_id'];	
						}else{
							$_SESSION['username'] = $record[0]['Phone'];	
						}
						//header("Location:child.php");
				break;
			case 6:
				$user='Cookie Admin';
						$_SESSION['id'] = $record[0]['id'];
						$_POST['username']=$record[0]['admin_email']; 					
						$_SESSION['entity'] = 6;
						$this->setLoginLogoutStatus(113,$record[0]['id'],$lat,$lon,$CountryCode);
						//header("Location:home_cookieadmin.php");
				break;		
			case 8:
				$user='Cookie Admin Staff';
					$_SESSION['cookieStaff'] = $record[0]['id'];
					$_SESSION['username']=$record[0]['email']; 				
					$_SESSION['entity'] = 8;
					$this->setLoginLogoutStatus(114,$record[0]['id'],$lat,$lon,$CountryCode);
					//header("Location:home_cookieadmin_staff.php");
				break;	
			case 7:
				$user='School Admin Staff';
					$_SESSION['staff_id'] = $record[0]['id'];				
					$_SESSION['username']=$record[0]['email']; 		
					 		
					$_SESSION['entity'] = 7;
					$this->setLoginLogoutStatus(115,$record[0]['id'],$lat,$lon,$CountryCode,$record[0]['school_id']);
					$_SESSION['is_accept_terms'] = $record[0]['is_accept_terms'];
					//header("Location:school_staff_dashboard.php");
				break;	
			case 'salesperson':	
				$user='Sales Person';
					$data = array(
                 		'id'  =>  $record[0]->person_id,			
						'entity'=> 'salesperson',
					);
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(116,$record[0]->person_id,$lat,$lon,$CountryCode);
					if(!empty($_POST["remember_me"])) {
							setcookie ("saleLoginOption",$_POST["LoginOption"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("saleEmailLoginE",$_POST["EmailID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("saleOrgLoginE",$_POST["OrganizationID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("salePassLoginE",$_POST["Password"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("salePRNLoginE",$_POST["EmployeeID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("saleMemberLoginE",$_POST["MemberID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("saleCCLoginE",$_POST["CountryCode"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("salePhoneLoginE",$_POST["PhoneNumber"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("saleRememberLoginE",$_POST["remember_me"],time()+ (10 * 365 * 24 * 60 * 60));
						}
						else {
							if(isset($_COOKIE["saleEmailLoginE"])) {
								setcookie ("saleEmailLoginE","");
							}
							if(isset($_COOKIE["saleOrgLoginE"])) {
								setcookie ("saleOrgLoginE","");
							}
							if(isset($_COOKIE["salePassLoginE"])) {
								setcookie ("salePassLoginE","");
							}
							if(isset($_COOKIE["salePRNLoginE"])) {
								setcookie ("salePRNLoginE","");
							}
							if(isset($_COOKIE["saleMemberLoginE"])) {
								setcookie ("saleMemberLoginE","");
							}
							if(isset($_COOKIE["saleCCLoginE"])) {
								setcookie ("saleCCLoginE","");
							}
							if(isset($_COOKIE["salePhoneLoginE"])) {
								setcookie ("salePhoneLoginE","");
							}
							if(isset($_COOKIE["saleRememberLoginE"])) {
								setcookie ("saleRememberLoginE","");
							}
						}
					redirect('/Csalesperson', 'location', 301);
					break;
			case 'student':	
				$user='Student';
					$data = array(
                 			  	'std_PRN'  =>  $record[0]->std_PRN,
								'school_id' => $record[0]->school_id,
								'stud_id' => $record[0]->id,
								'username'=> $record[0]->std_email,
								'is_loggen_in'=>1,
								'entity'=> 'student',
								'usertype'=> 'student',
					);
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(105,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);
						if(!empty($_POST["remember_me"])) {
							setcookie ("studLoginOption",$_POST["LoginOption"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studEmailLoginE",$_POST["EmailID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studOrgLoginE",$_POST["OrganizationID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studPassLoginE",$_POST["Password"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studPRNLoginE",$_POST["EmployeeID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studMemberLoginE",$_POST["MemberID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studCCLoginE",$_POST["CountryCode"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studPhoneLoginE",$_POST["PhoneNumber"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("studRememberLoginE",$_POST["remember_me"],time()+ (10 * 365 * 24 * 60 * 60));
						}
						else {
							if(isset($_COOKIE["studEmailLoginE"])) {
								setcookie ("studEmailLoginE","");
							}
							if(isset($_COOKIE["studOrgLoginE"])) {
								setcookie ("studOrgLoginE","");
							}
							if(isset($_COOKIE["studPassLoginE"])) {
								setcookie ("studPassLoginE","");
							}
							if(isset($_COOKIE["studPRNLoginE"])) {
								setcookie ("studPRNLoginE","");
							}
							if(isset($_COOKIE["studMemberLoginE"])) {
								setcookie ("studMemberLoginE","");
							}
							if(isset($_COOKIE["studCCLoginE"])) {
								setcookie ("studCCLoginE","");
							}
							if(isset($_COOKIE["studPhoneLoginE"])) {
								setcookie ("studPhoneLoginE","");
							}
							if(isset($_COOKIE["studRememberLoginE"])) {
								setcookie ("studRememberLoginE","");
							}
						}
					// redirect('main/members');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;
				case 'employee':	
					$user='employee';
					
					$data = array(
                 			  	'std_PRN'  =>  $record[0]->std_PRN,
								'school_id' => $record[0]->school_id,
								'stud_id' => $record[0]->id,
								'username'=> $record[0]->std_email,
								'is_loggen_in'=>1,
								'entity'=> 'student',
								'usertype'=> 'employee',
					);
					$this->session->set_userdata($data);
					$this->setLoginLogoutStatus(205,$record[0]->id,$lat,$lon,$CountryCode,$record[0]->school_id);
					if(!empty($_POST["remember_me"])) {
							setcookie ("empLoginOption",$_POST["LoginOption"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empEmailLoginE",$_POST["EmailID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empOrgLoginE",$_POST["OrganizationID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empPassLoginE",$_POST["Password"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empPRNLoginE",$_POST["EmployeeID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empMemberLoginE",$_POST["MemberID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empCCLoginE",$_POST["CountryCode"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empPhoneLoginE",$_POST["PhoneNumber"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("empRememberLoginE",$_POST["remember_me"],time()+ (10 * 365 * 24 * 60 * 60));
						}
						else {
							if(isset($_COOKIE["empEmailLoginE"])) {
								setcookie ("empEmailLoginE","");
							}
							if(isset($_COOKIE["empOrgLoginE"])) {
								setcookie ("empOrgLoginE","");
							}
							if(isset($_COOKIE["empPassLoginE"])) {
								setcookie ("empPassLoginE","");
							}
							if(isset($_COOKIE["empPRNLoginE"])) {
								setcookie ("empPRNLoginE","");
							}
							if(isset($_COOKIE["empMemberLoginE"])) {
								setcookie ("empMemberLoginE","");
							}
							if(isset($_COOKIE["empCCLoginE"])) {
								setcookie ("empCCLoginE","");
							}
							if(isset($_COOKIE["empPhoneLoginE"])) {
								setcookie ("empPhoneLoginE","");
							}
							if(isset($_COOKIE["empRememberLoginE"])) {
								setcookie ("empRememberLoginE","");
							}
						}
					// redirect('main/members');
					// changes done By Kunal
					redirect('Clogin/members_terms/'.$entity);
					// End Changes
					break;		
			case 'sponsor':	
				$user='Sponsor';
					$data = array(
                 		'ids'  =>  $record,
						'logged_in'=> TRUE,
						'entity'=> 'sponsor',
					);
					$this->session->set_userdata($data);
					$myid=array();
					foreach(@$record as $key=>$value){						
						$myid[]=$value->id;
					}	
					$id=min($myid);					
					$this->setLoginLogoutStatus(108,$id,$lat,$lon,$CountryCode);
					if(!empty($_POST["remember_me"])) {
							setcookie ("spLoginOption",$_POST["LoginOption"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("spEmailLoginE",$_POST["EmailID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("spPassLoginE",$_POST["Password"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("spCCLoginE",$_POST["CountryCode"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("spPhoneLoginE",$_POST["PhoneNumber"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("spMemberLoginE",$_POST["MemberID"],time()+ (10 * 365 * 24 * 60 * 60));
							setcookie ("spRememberLoginE",$_POST["remember_me"],time()+ (10 * 365 * 24 * 60 * 60));
						}
						else {
							if(isset($_COOKIE["spEmailLoginE"])) {
								setcookie ("spEmailLoginE","");
							}
							if(isset($_COOKIE["spPassLoginE"])) {
								setcookie ("spPassLoginE","");
							}
							if(isset($_COOKIE["spMemberLoginE"])) {
								setcookie ("spMemberLoginE","");
							}
							if(isset($_COOKIE["spCCLoginE"])) {
								setcookie ("spCCLoginE","");
							}
							if(isset($_COOKIE["spPhoneLoginE"])) {
								setcookie ("spPhoneLoginE","");
							}
							if(isset($_COOKIE["spRememberLoginE"])) {
								setcookie ("spRememberLoginE","");
							}
						}
					redirect('/Allshops', 'location', 301);
					break;
			default:
				$user='';
				break;
		}

	}

	public function searchUser($LoginOption,$entity,$Password,$EmailID="",$OrganizationID="",$EmployeeID="",$CountryCode="",$PhoneNumber="",$MemberID){
		$table='';		
		$FieldPassword='';
		$FieldEmail='';
		$FieldOrg='';
		$FieldEmployeeID='';
		$FieldCountryCode='';
		$FieldPhoneNumber='';
		$FieldMemberId='';
		
		switch($entity){
			case 'teacher':
				$table='tbl_teacher';		
				$FieldPassword='t_password';
				$FieldEmail='t_email';
				$FieldOrg='school_id';
				$FieldEmployeeID='t_id';
				$FieldCountryCode='CountryCode';
				$FieldPhoneNumber='t_phone';
				$FieldMemberId='id';
				break;
			case 'manager':
				$table='tbl_teacher';		
				$FieldPassword='t_password';
				$FieldEmail='t_email';
				$FieldOrg='school_id';
				$FieldEmployeeID='t_id';
				$FieldCountryCode='CountryCode';
				$FieldPhoneNumber='t_phone';
				$FieldMemberId='id';
				break;
			case 1:
				$table='tbl_school_admin';
				$FieldPassword='password';
				$FieldEmail='email';
				$FieldOrg='school_id';
				//$FieldEmployeeID='t_id';
				//$FieldCountryCode='t_id';
				$FieldPhoneNumber='mobile';
				break;
			case 5:
				$table='tbl_parent';
				$FieldPassword='Password';
				$FieldEmail='email_id';
				//$FieldOrg='school_id';
				//$FieldEmployeeID='t_id';
				//$FieldCountryCode='t_id';
				$FieldPhoneNumber='Phone';
				break;
			case 6:
				$table='tbl_cookieadmin';
				$FieldPassword='admin_password';
				$FieldEmail='admin_email';
				//$FieldOrg='school_id';
				//$FieldEmployeeID='t_id';
				//$FieldCountryCode='t_id';
				//$FieldPhoneNumber='Phone';
				break;
			case 8:
				$table='tbl_cookie_adminstaff';
				$FieldPassword='pass';
				$FieldEmail='email';
				//$FieldOrg='school_id';
				//$FieldEmployeeID='t_id';
				//$FieldCountryCode='t_id';
				$FieldPhoneNumber='phone';
				break;
			case 7:
				$table='tbl_school_adminstaff';
				$FieldPassword='pass';
				$FieldEmail='email';
				$FieldOrg='school_id';
				//$FieldEmployeeID='t_id';
				//$FieldCountryCode='t_id';
				$FieldPhoneNumber='phone';
				break;	
			case 'salesperson':
				$table='tbl_salesperson';
				$FieldPassword='p_password';
				$FieldEmail='p_email';
				//$FieldOrg='school_id';
				//$FieldEmployeeID='t_id';
				//$FieldCountryCode='t_id';
				$FieldMemberId='person_id';
				$FieldPhoneNumber='p_phone';
				break;	
			case 'student':
				$table='tbl_student';
				$FieldPassword='std_password';
				$FieldEmail='std_email';
				$FieldOrg='school_id';
				$FieldEmployeeID='std_PRN';
				$FieldCountryCode='country_code';
				$FieldPhoneNumber='std_phone';
				$FieldMemberId='id';
				break;		
			case 'employee':
				$table='tbl_student';
				$FieldPassword='std_password';
				$FieldEmail='std_email';
				$FieldOrg='school_id';
				$FieldEmployeeID='std_PRN';
				$FieldCountryCode='country_code';
				$FieldPhoneNumber='std_phone';
				$FieldMemberId='id';
				break;					
			case 'sponsor':
				$table='tbl_sponsorer';
				$FieldPassword='sp_password';
				$FieldEmail='sp_email';
				//$FieldOrg='school_id';
				//$FieldEmployeeID='std_PRN';
				$FieldCountryCode='CountryCode';
				$FieldPhoneNumber='sp_phone';
				$FieldMemberId='id';
				break;		
		}
		
		$this->load->model("Mlogin");
		
		$res=$this->Mlogin->searchUser($LoginOption,$table,$FieldPassword,$Password,$FieldEmail,$EmailID,$FieldEmployeeID,$EmployeeID,$FieldOrg,$OrganizationID,$FieldPhoneNumber,$PhoneNumber,$FieldCountryCode,$CountryCode,$FieldMemberId,$MemberID);
		//print_r($res);exit;
		return $res;	
	}
	public function chk_input($value){
		return addslashes(htmlentities(trim($value)));
	}
	/* Author VaibhavG
	I've been create new function chk_input_password() to prevent sql injection for ticket Number SMC-3383 8Sept2018 2:57PM
	*/
	public function chk_input_password($value){
		return addslashes($value);
	}
	//code end for SMC-3383

	// Code start Kunal SMC-4923
	public function get_operating_system() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $operating_system = 'Unknown Operating System';

	//Get the operating_system
    if (preg_match('/linux/i', $u_agent)) {
        $operating_system = 'Linux';
    } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
        $operating_system = 'Mac';
    } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
        $operating_system = 'Windows';
    } elseif (preg_match('/ubuntu/i', $u_agent)) {
        $operating_system = 'Ubuntu';
    } elseif (preg_match('/iphone/i', $u_agent)) {
        $operating_system = 'IPhone';
    } elseif (preg_match('/ipod/i', $u_agent)) {
        $operating_system = 'IPod';
    } elseif (preg_match('/ipad/i', $u_agent)) {
        $operating_system = 'IPad';
    } elseif (preg_match('/android/i', $u_agent)) {
        $operating_system = 'Android';
    } elseif (preg_match('/blackberry/i', $u_agent)) {
        $operating_system = 'Blackberry';
    } elseif (preg_match('/webos/i', $u_agent)) {
        $operating_system = 'Mobile';
    }
    
    return $operating_system;
}
// End code Kunal SMC-4923
	public function login_validation(){
		//print_r($_POST);exit;
		//Array ( [LoginOption] => PhoneNumber [EmailID] => [EmployeeID] => [MemberID] => [CountryCode] => 91 [PhoneNumber] => 7020337288 [OrganizationID] => COTP [Password] => 123 [entity] => employee [submit] => Login [lat] => [lon] => )
		$report="";
		$LoginOption=$this->chk_input($this->input->post('LoginOption'));
		
		$EmailID=$this->chk_input($this->input->post('EmailID'));
		
	    $OrganizationID=$this->chk_input($this->input->post('OrganizationID'));
		
		$EmployeeID=$this->chk_input($this->input->post('EmployeeID'));
		
		$CountryCode=$this->chk_input($this->input->post('CountryCode'));
		
		$PhoneNumber=$this->chk_input($this->input->post('PhoneNumber'));
		
		$MemberID=$this->chk_input($this->input->post('MemberID'));
		
		//remove chk_input function changed by VaibhavG -> SMC-2309 ->Login: User is able to login with password including space(" ") 
		// VaibhavG added chk_input_password() function to password for SMC-3383
	   $Password=$this->chk_input_password($this->input->post('Password'));
		   
		$entity=$this->chk_input($this->input->post('entity'));	

		$lat=$this->chk_input($this->input->post('lat'));
		
		$lon=$this->chk_input($this->input->post('lon'));
		
		//Author VaibhavG. Below I'hv maintain session lat & lon to for the ticket number SMC-3245 22Aug18 5:57PM
		$_SESSION['lat'] = $this->chk_input($this->input->post('lat'));
		$_SESSION['lon'] = $this->chk_input($this->input->post('lon'));
		//code end by vaibhavG

		/*$ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		$url = "http://freegeoip.net/json/$ip";
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data_ip = curl_exec($ch);
		curl_close($ch);

		if ($data_ip) {
			$location = json_decode($data_ip);


				$lat = $location->latitude;
				$lon = $location->longitude;

		}*/
		
		if($entity!="" AND $Password!="" and ( $EmailID!="" or ($CountryCode!="" and $PhoneNumber!="") or ($OrganizationID!="" and $EmployeeID!="") OR $MemberID!="") ){
				// if($EmailID!="" && $LoginOption=='EmailID'){			
					// $emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';		
					// if(!preg_match($emailval, $EmailID)){						
						// $report="<span id='error' class='red'>Check your Email ID.</span>";
					// }
				// }
				// if($PhoneNumber!="" && $LoginOption=='PhoneNumber'){
					// $mob="/^[789][0-9]{9}$/";
					// if(!preg_match($mob, $PhoneNumber)){ 
						// $report="<span id='error' class='red'>Check your Mobile Number.</span>";
					// }
				// }
				/* Author VaibhavG
				I've been create new condition for password format checking to prevent sql injection for ticket Number SMC-3383 8Sept2018 3:52PM
				*/
				if($Password!="" && $LoginOption=='Password'){
					$pass="/^([a-zA-Z0-9!@#$%^&*()\-_+{},.])+$/";
					if(!preg_match($pass, $Password)){ 
						$report="<span id='error' class='red'>Wrong Password.</span>";
					}
				}
             
                $this->load->model("Mlogin");
            
                $fetchStuFtLn = $this->Mlogin->checkSchooIDpassExt($OrganizationID);
              
               
                if(($fetchStuFtLn > 0) && $Password === 'temp123'){
        
                        $prn1 = $this->Mlogin->fetchPRNfrStudent($EmailID,$OrganizationID);
                        $prn   = $prn1[0]->std_PRN;
                        $phone = $prn1[0]->std_phone;
                      
                        $data = array(
                        
                            'email'      => $EmailID,
                            'std_PRN'    => $prn,
                            'std_phone'  => $phone
                        
                        );
 
                        $this->session->set_userdata($data);  
						redirect('Welcome/Login_new_user');
				 
                }else{
                     
				if($report==""){
					$res=$this->searchUser($LoginOption,$entity,$Password,$EmailID,$OrganizationID,$EmployeeID,$CountryCode,$PhoneNumber,$MemberID);
					//print_r($res);
					//exit;
					//below code is added by Sayali for SMC-4866 on 28/92020 for login validation
					
					if($entity=='employee' || $entity=='student')
					{
					
						if($LoginOption=='EmailID')
						{	
							$row['stdmail']=$this->student->CheckUserIsExist($EmailID);
							$row['stSchool']=$this->student->checkForLoginValidation($OrganizationID,'school_id','tbl_school_admin');
							 if($row['stdmail']==1 && $row['stSchool']==0)
							{	
								if($entity=='employee')
								{
								$emailchk="Organization ID";
								}else {
								$emailchk="School ID";
								}
							}
							else if($row['stdmail']==0 && $row['stSchool']==1)
							{
								$emailchk="Email ID";
							}
							else if($row['stdmail']==1 && $row['stSchool']==1)
							{
								$emailchk="Password";
							
							}
							else if($row['stdmail']==0 && $row['stSchool']==0)
							{
								$emailchk="Email ID and Organization ID";
							
							}
							
						}
						else if($LoginOption=='PhoneNumber')
						{	


					//print_r($OrganizationID);exit;


							$row['stPhonev']=$this->student->checkForLoginValidation($PhoneNumber,'std_phone','tbl_student');
							$row['stSchool']=$this->student->checkForLoginValidation($OrganizationID,'school_id','tbl_school_admin');
							//print_r($row['stPhonev']);exit;
							 if($row['stPhonev']==1 && $row['stSchool']==0)
							{	
								if($entity=='employee')
								{
								$emailchk="Organization ID";
								}else {
								$emailchk="School ID";
								}
								
							}
							else if($row['stPhonev']==0 && $row['stSchool']==1)
							{
								$emailchk="Phone Number";
							}
							else if($row['stPhonev']==1 && $row['stSchool']==1)
							{
								$emailchk="Password";
								//print_r($emailchk);exit;
							}
							else if($row['stPhonev']==0 && $row['stSchool']==0)
							{
								$emailchk="Phone Number and Organization ID";
							}
						}
						else if($LoginOption=='memberId')
						{	
							$row['midv']=$this->student->checkForLoginValidation($MemberID,'id','tbl_student');
						
							 if($row['midv']==1)
							{	
								$emailchk="Password";
							}
							
							else 
							{
								$emailchk="Member ID";
							}
						} 
						
						else if($LoginOption=='EmployeeID')
						{ 
							$row['empidv']=$this->student->checkForLoginValidation($EmployeeID,'std_PRN','tbl_student');

							$row['stSchool']=$this->student->checkForLoginValidation($OrganizationID,'school_id','tbl_school_admin');
							 if($row['empidv']==1 && $row['stSchool']==0)
							{	
								if($entity=='employee')
								{
								$emailchk="Organization ID";
								}else {
								$emailchk="School ID";
								}
							}
							else if($row['empidv']==0 && $row['stSchool']==1)
							{
								$emailchk="PRN/Employee ID";
							}
							else if($row['empidv']==1 && $row['stSchool']==1)
							{
								$emailchk="Password";
							}
							else if($row['empidv']==0 && $row['stSchool']==0)
							{
								$emailchk="PRN/Employee ID and Organization ID";
							}
						}
					} //code started for Manager/Teacher validation messages
					
					else if($entity=='manager' || $entity =='teacher')
					{
							
						if($LoginOption=='EmailID')
						{	
							$row['tmEmail']=$this->teacher->checkForLoginValidations($EmailID,'t_email','tbl_teacher');
							$row['stSchool1']=$this->teacher->checkForLoginValidations($OrganizationID,'school_id','tbl_school_admin');
							 if($row['tmEmail']==1 && $row['stSchool1']==0)
							{	
								if($entity=='manager')
								{
								$emailchk="Organization ID";
								}else {
								$emailchk="School ID";
								}
							}
							else if($row['tmEmail']==0 && $row['stSchool1']==1)
							{
								$emailchk="Email ID";
							}
							else if($row['tmEmail']==1 && $row['stSchool1']==1)
							{
								$emailchk="Password";
							
							}
							else if($row['tmEmail']==0 && $row['stSchool1']==0)
							{
								$emailchk="Email ID and Organization ID";
							
							}
						}
						else if($LoginOption=='PhoneNumber')
						{	
							$row['tmPhone']=$this->teacher->checkForLoginValidations($PhoneNumber,'t_phone','tbl_teacher');
							$row['stSchool1']=$this->teacher->checkForLoginValidations($OrganizationID,'school_id','tbl_school_admin');
							 if($row['tmPhone']==1 && $row['stSchool1']==0)
							{	
								if($entity=='manager')
								{
								$emailchk="Organization ID";
								}else {
								$emailchk="School ID";
								}
								
							}
							else if($row['tmPhone']==0 && $row['stSchool1']==1)
							{
								$emailchk="Phone Number";
							}
							else if($row['tmPhone']==1 && $row['stSchool1']==1)
							{
								$emailchk="Password";
								
							}
							else if($row['tmPhone']==0 && $row['stSchool1']==0)
							{
								$emailchk="Email ID and Organization ID ";
							}
						}
						else if($LoginOption=='memberId')
						{	
						
							$row['tmID']=$this->teacher->checkForLoginValidations($MemberID,'id','tbl_teacher');
							 if($row['tmID']==1)
							{	
								$emailchk="Password";
							}
							
							else 
							{
								$emailchk="Member ID";
							}
						} 
						
						else if($LoginOption=='EmployeeID')
						{ 
							$row['tmEmpID']=$this->teacher->checkForLoginValidations($EmployeeID,'t_id','tbl_teacher');
							$row['stSchool1']=$this->teacher->checkForLoginValidations($OrganizationID,'school_id','tbl_school_admin');
							 if($row['tmEmpID']==1 && $row['stSchool1']==0)
							{	
								if($entity=='employee')
								{
								$emailchk="Organization ID";
								}else {
								$emailchk="School ID";
								}
							}
							else if($row['tmEmpID']==0 && $row['stSchool1']==1)
							{
								$emailchk="PRN/Employee ID";
							}
							else if($row['tmEmpID']==1 && $row['stSchool1']==1)
							{
								$emailchk="Password";
							}
							else if($row['tmEmpID']==0 && $row['stSchool1']==0)
							{
								$emailchk="PRN/Employee ID and Organization ID";
							}
						}
					}
					
					//below code is added by chaitali for SMC-5161 sponsor on 16-03-2021  
					elseif($entity == 'sponsor')
					{
						$this->load->model("sp/sponsor");
						$table = 'tbl_sponsorer';

						if($LoginOption == 'EmailID')
						{
							$login = 'Email ID';
							$value = $EmailID;
							$field = 'sp_email';
						}

						if($LoginOption == 'PhoneNumber')
						{
							$login = 'Phone Number';
							$value = $PhoneNumber;
							$field = 'sp_phone';
						}

						if($LoginOption == 'memberId')
						{
							$login = 'Member Id';
							$value = $MemberID;
							$field = 'id';
						}

						$value1 = $Password;
						$field1 = 'sp_password';

						$chk=$this->sponsor->checkForLoginValidations($value,$field,$table);
//print_r($chk);exit;
						if($chk == 1)
						{
							$emailchk='Password';
						}
						else
						{
							$value = $Password;
							$field = $field1;

							$chk=$this->sponsor->checkForLoginValidations($value,$field,$table);

							if($chk == 1)
							{
								$emailchk = $login;
							}

						}
								
					}
					
					//below code is added by chaitali for SMC-5161 sales person on 16-03-2021 
					elseif($entity == 'salesperson')
					{
						$this->load->model('slp/Msalesperson');
						$table = 'tbl_salesperson';

						if($LoginOption == 'EmailID')
						{
							$login = 'Email ID';
							$value = $EmailID;
							$field = 'p_email';
						}

						if($LoginOption == 'PhoneNumber')
						{
							$login = 'Phone Number';
							$value = $PhoneNumber;
							$field = 'p_phone';
						}

						if($LoginOption == 'memberId')
						{
							$login = 'Member Id';
							$value = $MemberID;
							$field = 'person_id';
						}

						$value1 = $Password;
						$field1 = 'p_password';

						$chk=$this->Msalesperson->checkForLoginValidations($value,$field,$table);

						if($chk == 1)
						{
							$emailchk='Password';
						}
						else
						{
							$value = $Password;
							$field = $field1;

							$chk=$this->Msalesperson->checkForLoginValidations($value,$field,$table);

							if($chk == 1)
							{
								$emailchk = $login;
							}

						}
								
					}
//print_r($res['TotalUser']);exit;
					if($res['TotalUser']<1){
					//below code is added by sayali to insert login error logs on 12/10/2020 for SMC-4897
						 $ip_server = $_SERVER['SERVER_ADDR']; 

		 	$os=$this->get_operating_system();
		 	// $device_name= gethostname(); 
		 	$device_name="";  
			$dataDesc=array(
                        "Login Option"=>$LoginOption,
                        "entity"=>$entity,
                        "EmailID"=>$EmailID,
                        "PhoneNumber"=>$PhoneNumber,
                        "Password "=>$Password,
                        "OrganizationID "=>$OrganizationID,
                        "EmployeeID "=>$EmployeeID,
                        "memberId "=>$memberId
                       
                         ); 
						 $dataDesc=json_encode($dataDesc);
						$insert_id=$this->Mlogin->errorUserLogin($dataDesc,$LoginOption,$entity,$Password,$EmailID,$OrganizationID,$EmployeeID,$CountryCode,$PhoneNumber,$MemberID,$device_name,$os,$ip_server);


						if($emailchk=='Password')
											{
												$report="<span id='error' class='red'>Invalid Password!</span>";
											}else if($emailchk==''){
													$report="<span id='error' class='red'>Invalid Credentials!</span>";
											} else{
												$report="<span id='error' class='red'>This $emailchk is not registered in system !</span>";
												}


					}else{
						
						if($entity!='sponsor' and $res['TotalUser']>1){		
								$insert_id=$this->Mlogin->errorMultipleUsers($entity);
								
								if($LoginOption=='EmailID')
								{
									if($entity=="student" || $entity=="employee"){
									$this->db->where('std_email',$EmailID);
									$this->db->where('school_id',$OrganizationID);
									$this->db->where('std_password',$Password);
									$all_value=$this->db->get('tbl_student')->result_array();
									}
									else if($entity=="teacher" || $entity=="manager"){
									$this->db->where('t_email',$EmailID);
									$this->db->where('school_id',$OrganizationID);
									$this->db->where('t_password',$Password);
									$all_value=$this->db->get('tbl_teacher')->result_array();	
									}
								}
								if($LoginOption=='PhoneNumber')
								{
									if($entity=="student" || $entity=="employee"){
									$this->db->where('std_phone',$PhoneNumber);
									$this->db->where('school_id',$OrganizationID);
									$this->db->where('std_password',$Password);
									$all_value=$this->db->get('tbl_student')->result_array();
									}
									else if($entity=="teacher" || $entity=="manager"){
									$this->db->where('t_phone',$PhoneNumber);
									$this->db->where('school_id',$OrganizationID);
									$this->db->where('t_password',$Password);
									$all_value=$this->db->get('tbl_teacher')->result_array();	
									//print_r($all_value);exit;
									}
								}
								
								//$report="<span id='error' class='red'>Something went wrong. There may be multiple users with same credentials.</span>";
								
								
								//$all_value=$this->db->get('tbl_teacher')->result_array();
								//print_r($all_value1);exit;
								
								$this->load->view('duplicate_email',array('entity'=>$entity,'all_value'=>$all_value));
						}else{
							$this->setSessionAndForward($entity,$res['Result'],$CountryCode, $lat, $lon);
						}									
						
					}					
				}	
              }
			}
			else{
				$report="<span id='error' class='red'>All Fields Are Mandatory...</span>";
			}	
            

            
        
        if($report!=''){
					$data['report']=$report;
					$data['LoginOption']=$LoginOption;
					$data['EmailID']=$EmailID;
					$data['OrganizationID']=$OrganizationID;
					$data['EmployeeID']=$EmployeeID;
					$data['CountryCode']=$CountryCode;
					$data['PhoneNumber']=$PhoneNumber;
					$data['Password']=$Password;
					$data['entity']=$entity;
					$data['MemberID']=$MemberID;					
					$data['index_url']=base_url();
					
					$this->load->view('login',$data);
		}
      
      	
	}


	public function getOS(){ 

		$user_agent=$_SERVER['HTTP_USER_AGENT'];

		$os_platform    =   "Unknown OS Platform";

		$os_array       =   array(
								'/windows nt 10/i'     =>  'Windows 10',
								'/windows nt 6.3/i'     =>  'Windows 8.1',
								'/windows nt 6.2/i'     =>  'Windows 8',
								'/windows nt 6.1/i'     =>  'Windows 7',
								'/windows nt 6.0/i'     =>  'Windows Vista',
								'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
								'/windows nt 5.1/i'     =>  'Windows XP',
								'/windows xp/i'         =>  'Windows XP',
								'/windows nt 5.0/i'     =>  'Windows 2000',
								'/windows me/i'         =>  'Windows ME',
								'/win98/i'              =>  'Windows 98',
								'/win95/i'              =>  'Windows 95',
								'/win16/i'              =>  'Windows 3.11',
								'/macintosh|mac os x/i' =>  'Mac OS X',
								'/mac_powerpc/i'        =>  'Mac OS 9',
								'/linux/i'              =>  'Linux',
								'/ubuntu/i'             =>  'Ubuntu',
								'/iphone/i'             =>  'iPhone',
								'/ipod/i'               =>  'iPod',
								'/ipad/i'               =>  'iPad',
								'/android/i'            =>  'Android',
								'/blackberry/i'         =>  'BlackBerry',
								'/webos/i'              =>  'Mobile'
							);

		foreach ($os_array as $regex => $value) { 

			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
			}

		}   

		return $os_platform;

	}


	public function getBrowser() 
	{ 
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";

		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}

		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Internet Explorer'; 
			$ub = "MSIE"; 
		} 
		elseif(preg_match('/Firefox/i',$u_agent)) 
		{ 
			$bname = 'Mozilla Firefox'; 
			$ub = "Firefox"; 
		} 
		elseif(preg_match('/Chrome/i',$u_agent)) 
		{ 
			$bname = 'Google Chrome'; 
			$ub = "Chrome"; 
		} 
		elseif(preg_match('/Safari/i',$u_agent)) 
		{ 
			$bname = 'Apple Safari'; 
			$ub = "Safari"; 
		} 
		elseif(preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Opera'; 
			$ub = "Opera"; 
		} 
		elseif(preg_match('/Netscape/i',$u_agent)) 
		{ 
			$bname = 'Netscape'; 
			$ub = "Netscape"; 
		} 

		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}

		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}

		// check if we have a number
		if ($version==null || $version=="") {$version="?";}

		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
	} 



	public function getIP()
	{
		$ip = "";

		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
		//check for ip from share internet
		$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
		// Check for the Proxy User
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else
		{
		$ip = $_SERVER["REMOTE_ADDR"];
		}
		return $ip;
	}

    // SMC-4584 changes done By Kunal
    public function members_terms($entity)
    {
        // print_r($_SESSION); exit;
        $baseurl=base_url();
        if($this->session->userdata('is_loggen_in'))
        {
        	$login_with_otp=$this->session->userdata('login_type');

            if($entity=='student' || $entity=='employee')
            {
                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->check_tncData($std_PRN,$school_id);
            }else if($entity=='teacher' || $entity=='manager')
            {
                $t_id = $this->session->userdata('t_id');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->teacher->check_tncData($t_id,$school_id);
            }
            if($row['studentinfo']->is_accept_terms!='1')
            {
                $data['entity']=$entity;
                //Below session set by Rutuja for SMC-5169 on 22-02-2021
                $_SESSION['update_pass_stud_teacher']="Yes";
                $this->load->view('tnc_link',$data);
            }else{
            	if($entity=='student' || $entity=='employee')
            	{	//Below condition added by Rutuja for SMC-4945 on 10-11-2020
            		/*if(isset($login_with_otp) && !empty($login_with_otp)){ 
            		echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Login successfull...Please update your password...');
           			window.location.href='$baseurl/main/update_profile';
                </script>"); 
            		//redirect('main/members');
            		 

            	}*/
            		redirect('main/members');
            	
            	}else if($entity=='teacher' || $entity=='manager')
            	{ 
                	/*if(isset($login_with_otp) && !empty($login_with_otp)){ 
            		echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Login successfull...Please update your password...');
           			window.location.href='$baseurl/teachers/teacher_profile1';
                </script>"); 
            		
            	}*/
            		redirect('teachers');
            	
            	}
            }
        }else{
            redirect(base_url());
        }
    }
    // End SMC-4584 Changes
}
?>
