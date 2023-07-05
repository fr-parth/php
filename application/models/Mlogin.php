<?php 
 ob_start();
class Mlogin extends CI_Model
{
	public function searchUser($LoginOption,$table,$FieldPassword,$Password,$FieldEmail,$EmailID,$FieldEmployeeID,$EmployeeID,$FieldOrg,$OrganizationID,$FieldPhoneNumber,$PhoneNumber,$FieldCountryCode,$CountryCode,$FieldMemberId,$MemberID){		
		//print_r($MemberID);exit;
		if($table=='tbl_sponsorer'){
			$sel='id';			
		}else{
			$sel='*';
		}
		$q="select ".$sel." from ".$table." where ";
		//print_r($q);exit; 			
			if($EmailID!="" && $LoginOption=='EmailID'){
				if($table=='tbl_student'){
					$q.=$FieldEmail."='".$EmailID."' and binary ".$FieldPassword."='".$Password."'and ".$FieldOrg."='".$OrganizationID."'";
				}
				else if($table=='tbl_teacher'){
					$q.=$FieldEmail."='".$EmailID."' and binary ".$FieldPassword."='".$Password."'and ".$FieldOrg."='".$OrganizationID."'";
				}
				else{
				$q.=$FieldEmail."='".$EmailID."' and binary ".$FieldPassword."='".$Password."'";
				}
			}
			if($MemberID!="" && $LoginOption=='memberId'){
				$q.=$FieldMemberId."='".$MemberID."' and binary ".$FieldPassword."='".$Password."'";
			}
			
			if($EmployeeID!="" && $LoginOption=='EmployeeID'){
				$q.=$FieldEmployeeID."='".$EmployeeID."' and ".$FieldOrg."='".$OrganizationID."' and binary ".$FieldPassword."='".$Password."'";
			}
			
			if($PhoneNumber!="" && $LoginOption=='PhoneNumber' ){
				
				if($table=='tbl_sponsorer'){
					if($FieldCountryCode!=""){					
						$q.="(".$FieldPhoneNumber."='".$PhoneNumber."' or sp_landline='".$PhoneNumber."' ) and ".$FieldCountryCode."='".$CountryCode."' and binary ".$FieldPassword."='".$Password."'";	
					}else{
						$q.="(".$FieldPhoneNumber."='".$PhoneNumber."' or sp_landline='".$PhoneNumber."' ) and binary ".$FieldPassword."='".$Password."'";
					}
				}
				//below code is added by chaitali for SMC-5161 sales person on 15-03-2021  
				elseif($table=='tbl_salesperson'){
					if($FieldCountryCode!=""){					
						$q.=$FieldPhoneNumber."='".$PhoneNumber."' and ".$FieldCountryCode."='".$CountryCode."' and binary ".$FieldPassword."='".$Password."' ";	
					}else{
						$q.=$FieldPhoneNumber."='".$PhoneNumber."' and binary ".$FieldPassword."='".$Password."' ";		
					}
				}
				else{
		/*added FieldOrg in if and else condition*/

					if($FieldCountryCode!=""){	

						$q.=$FieldPhoneNumber."='".$PhoneNumber."' and ".$FieldCountryCode."='".$CountryCode."' and binary ".$FieldPassword."='".$Password."' and ".$FieldOrg."='".$OrganizationID."'";	


					}else{
						$q.=$FieldPhoneNumber."='".$PhoneNumber."' and binary ".$FieldPassword."='".$Password."'and ".$FieldOrg."='".$OrganizationID."' ";
		/*End*/			
					}
				}
			}
			if($table=='tbl_sponsorer'){
				$q.=' order by sp_company ASC, sp_name ASC';
			}	
		
			$query=$this->db->query($q);	
			$data['Result']=$query->result();
			$data['TotalUser']=$query->num_rows();
			return $data;			
	}
    
//    public function checkPRNisExist($email,$schoolID)
//    { 
//         $this->db->where('std_email' , $email);
//         $this->db->where('school_id' , $schoolID); 
//         //$this->db->where("(std_email='$email' OR std_PRN='$prn' OR std_phone='$phone')", NULL, FALSE);
//          
//         $query =  $this->db->get('tbl_student');
//         
//         if($query->num_rows() > 0)
//         {
//             return TRUE;
//         
//         }else{
//             
//             return FALSE;
//         }
//    }
    
//    public function checkPRNisExist($email,$schoolID)
//    {
//        $qury = $this->db->query("SELECT * FROM tbl_student WHERE std_email='$email' and school_id='$schoolID'");
//        return $qury->result();
//    }
    
    
    //Insert User Registration Data
    public function insertStudentInfo($update_data)
    { 
        $this->db->insert('tbl_student', $update_data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id; 
        
    }
    
    
    public function checkSchooIDpassExt($OrganizationID)
    {    
         $this->db->where('school_id' , $OrganizationID);
          
         $query =  $this->db->get('tbl_stud_first_login');
         
         if($query->num_rows() > 0)
         {
             return TRUE;
         
         }else{
             
             return FALSE;
         }
   
        
    }
    
    
    public function fetchAllScID()
    {
        $res = $this->db->query("SELECT school_id FROM tbl_stud_first_login group by school_id");
        return $res->result();
    } 
    
    
    public function updateLoginUser($update_data,$email,$prn,$phone)
    {
        $this->db->where('school_id',$schoolID); 
        $this->db->where("(std_email='$email' OR std_PRN='$prn' OR std_phone='$phone')", NULL, FALSE);
        //$this->db->where('std_password','temp123');
        
        $this->db->update('tbl_student' , $update_data);
        
        $result = $this->db->affected_rows();
        
        return $result;
      
    }
 
    public function fetchPRNfrStudent($EmailID,$OrganizationID) 
    { 
		$this->db->select('std_PRN,std_phone');
		$this->db->from('tbl_student');
		$this->db->where('std_email',$EmailID);
		$this->db->where('school_id',$OrganizationID);
       
		$query = $this->db->get();
        return $query->result();
      
    }

	public function errorMultipleUsers($entity,$record=''){
		//condition for entity added by Sayali for SMC-4944 on 10/11/2020
		if($entity=='student')
		{
			$ent="105(Student)";
		}
		else if($entity=='employee')
		{
			$ent="205(Employee)";
		}
		else if($entity=='teacher')
		{
			$ent="103(Teacher)";
		}
		else if($entity=='manager')
		{
			$ent="203(Manager)";
		}
		else
		{
			$ent=$entity;
		}
		$query=$this->db->query("insert into `tbl_error_log` (`id`, `error_type`, `error_description`, `datetime`, `user_type`, `last_programmer_name`) values(NULL, 'More Than 1 User', 'Login.php', CURRENT_TIMESTAMP, '$ent', 'Sudhir')");
		
		$insert_id = $this->db->insert_id();
		return  $insert_id;
		
	}

	//function added by sayali to insert login error logs on 12/10/2020 for SMC-4897	
	//Below query updated by Rutuja for SMC-4915 for adding last_programmer_name on 21-10-2020	
//condition for entity added by Sayali for SMC-4944 on 10/11/2020	
	public function errorUserLogin($dataDesc,$LoginOption,$entity,$Password,$EmailID,$OrganizationID,$EmployeeID,$CountryCode,$PhoneNumber,$MemberID,$device_name,$os,$ip_server){
		if($entity=='student')
		{
			$ent="105(Student)";
		}
		else if($entity=='employee')
		{
			$ent="205(Employee)";
		}
		else if($entity=='teacher')
		{
			$ent="103(Teacher)";
		}
		else if($entity=='manager')
		{
			$ent="203(Manager)";
		}
		else
		{
			$ent=$entity;
		}
		$query=$this->db->query("insert into `tbl_error_log` (error_type, error_description,datetime, user_type, email,school_id,member_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Login Fail', '$dataDesc', CURRENT_TIMESTAMP, '$ent', '$EmailID','$OrganizationID','$MemberID','$PhoneNumber','$device_name','$os','$ip_server','Web','Sayali Balkawade')");
		
		$insert_id = $this->db->insert_id();
		return  $insert_id;
		
	}
	
	public function setLoginLogoutStatus($TblEntityID, $UserID,$lat,$lon,$CountryCode,$ip,$os,$browser,$school_id){
		$date=date('Y-m-d h:i:s');
		//$q=$this->db->get_where("tbl_LoginStatus","EntityID = '$UserID' AND Entity_type= '$TblEntityID'");
		 $this->db->select('*');
		 $this->db->from('tbl_LoginStatus');
		 $this->db->where('EntityID', $UserID);
		 $this->db->where('Entity_type', $TblEntityID);
		 $this->db->order_by("RowID", "DESC");
		 $this->db->limit('1');
		 $q = $this->db->get();
		 $q_result = $q->result_array();
		
		 $this->session->set_userdata('TblEntityID_loginstatus', $q_result[0]['Entity_type']);
		 $this->session->set_userdata('UserID_loginstatus', $q_result[0]['EntityID']);
		$rows=$q->num_rows();
		if( $rows > 0 ){
			$insdata=array(
					'EntityID'=>$q_result[0]['EntityID'],
					'Entity_type'=>$q_result[0]['Entity_type'],
					'FirstLoginTime'=>$q_result[0]['FirstLoginTime'],
					'FirstMethod'=>$q_result[0]['FirstMethod'],
					'FirstDevicetype'=>$q_result[0]['FirstDevicetype'],
					'FirstDeviceDetails'=>$q_result[0]['FirstDeviceDetails'],
					'FirstPlatformOS'=>$q_result[0]['FirstPlatformOS'],
					'FirstIPAddress'=>$q_result[0]['FirstIPAddress'],
					'FirstLatitude'=>$q_result[0]['FirstLatitude'],
					'FirstLongitude'=>$q_result[0]['FirstLongitude'],
					'FirstBrowser'=>$q_result[0]['FirstBrowser'],	
					
					'LatestLoginTime'=>$date,
					'LatestMethod'=>'web',
					'LatestDevicetype'=>'',
					'LatestDeviceDetails'=>$os,
					'LatestPlatformOS'=>$os,
					'LatestIPAddress'=>$ip,
					'LogoutTime'=>$date,
					'LatestLatitude'=>$lat,
					'LatestLongitude'=>$lon,
					'LatestBrowser'=>$browser,			
					'CountryCode'=>$CountryCode,			
					'school_id'=>$school_id			
			);
		
			$update1=array(
					
					'first_login_date'=>$q_result[0]['FirstLoginTime'],
					'last_login_date'=>$date					
			);
			
			
			$q=$this->db->insert("tbl_LoginStatus",$insdata);
			
			$ids=$q_result[0]['EntityID'];
			$entityTypes=$q_result[0]['Entity_type'];
			if($entityTypes=='105' or $entityTypes=='205')
			{
			$this->db->update('tbl_student', $update1,"id = '$ids'");	
			}	
			if($entityTypes=='103' or $entityTypes=='203')
			{	
			$this->db->update('tbl_teacher', $update1,"id = '$ids'");	
			}
			if($q_result[0]['RowID']!='')
			{
			$RowID = $q_result[0]['RowID'];
			$updata=array(
				'LogoutTime'=>$date,
			);			
			//$this->db->limit(1);
			$q=$this->db->update("tbl_LoginStatus",$updata,"EntityID = '$UserID' AND Entity_type= '$TblEntityID' AND RowID= '$RowID'");		
			}
		
		}else{
			$insdata=array(
					'EntityID'=>$UserID,
					'Entity_type'=>$TblEntityID,
					'FirstLoginTime'=>$date,
					'FirstMethod'=>'web',
					'FirstDevicetype'=>'',
					'FirstDeviceDetails'=>$os,
					'FirstPlatformOS'=>$os,
					'FirstIPAddress'=>$ip,
					'FirstLatitude'=>$lat,
					'FirstLongitude'=>$lon,
					'FirstBrowser'=>$browser,			
					'LatestLoginTime'=>$date,
					'LatestMethod'=>'web',
					'LatestDevicetype'=>'',
					'LatestDeviceDetails'=>$os,
					'LatestPlatformOS'=>$os,
					'LatestIPAddress'=>$ip,
					'LatestLatitude'=>$lat,
					'LatestLongitude'=>$lon,
					'LatestBrowser'=>$browser,
					'LogoutTime'=>$date,			
					'CountryCode'=>$CountryCode,			
					'school_id'=>$school_id			
			);
			$update1=array(
					
					'first_login_date'=>$date,
					'last_login_date'=>$date					
			);
		
		$q=$this->db->insert("tbl_LoginStatus",$insdata);
		$ids=$UserID;
			$entityTypes=$TblEntityID;
			if($entityTypes=='105' or $entityTypes=='205')
			{
			$this->db->update('tbl_student', $update1,"id = '$ids'");	
			}	
			if($entityTypes=='103' or $entityTypes=='203')
			{	
			$this->db->update('tbl_teacher', $update1,"id = '$ids'");	
			}
				
				}
		
		if($q){
			return true;
		}else{
			return false;
		}
	}
	public function sessionLogout()	{	
//echo "<script>alert('updated')</script>";die;	
	$TblEntityID_loginstatus = $this->session->userdata('TblEntityID_loginstatus');
	$UserID_loginstatus = $this->session->userdata('UserID_loginstatus');
 $this->db->select('RowID');
				 $this->db->from('tbl_LoginStatus');
				 $this->db->where('EntityID', $UserID_loginstatus);
				 $this->db->where('Entity_type', $TblEntityID_loginstatus);
				 $this->db->order_by("RowID", "DESC");
				 $this->db->limit('1');
				 $q_rowid = $this->db->get();
				 $q_rowid_result = $q_rowid->result_array();
				
	$RowID_loginstatus = $q_rowid_result[0]['RowID'];

	
	$updata=array(
				'LogoutTime'=>date("Y-m-d h:i:s"),
			);	
		
		$q=$this->db->update("tbl_LoginStatus",$updata,"EntityID = '$UserID_loginstatus' AND Entity_type= '$TblEntityID_loginstatus' AND RowID= '$RowID_loginstatus'");			
	
		
	}
}	
				

?>