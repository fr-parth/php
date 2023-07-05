<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Msalesperson extends CI_Model{
	public function __construct(){
         $this->load->database();
    }
	
    //below code is added by chaitali for SMC-5161 sales person on 16-03-2021  
	public function checkForLoginValidations($value,$field,$table)
	{
		$this->db->where($field, $value);
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
		{
			return TRUE;
		
		}else{ 
			
			return FALSE;
		}
	}
    
	public function headerData($id){	
		$q = $this->db->query("select * from tbl_salesperson s where s.person_id='$id'");
		return $q->result();		
	}	
	
	public function RegisteredSponsorsList($id){	
//$this->db->order_by('id', 'DESC'); done by Pranali for bug SMC-3683 on 17-12-2018
		$this->db->order_by('id', 'DESC');	
		$q = $this->db->get_where("tbl_sponsorer",array("sales_person_id"=>$id));		
		return $q->result();			
	}
	
	public function activateSponsor($a){
		$data = array(
               'v_status' => 'Active'
        );			
		$q=$this->db->update('tbl_sponsorer', $data, array('id' => $a));
		return $q;
	}
	
	public function getSponsorByID($id){
		//$q = $this->db->get_where("tbl_sponsorer",array("id"=>$id));	

	$q = $this->db->select('s.*, spd.discount, spd.points_per_product, spd.revenue_percent, spd.revenue_per_visit')
     ->from('tbl_sponsorer as s')
     ->where('s.id', $id)
     ->join('tbl_sponsored as spd', 's.id = spd.sponsor_id', 'inner')
     ->get();		
		return $q->result();	
	}
	//getSponsorDetails() added by Pranali for SMC-3697
	public function getSponsorDetails($id){
		$q = $this->db->select('s.*')
		 ->from('tbl_sponsorer as s')
		 ->where('s.id', $id)
		->get();
		return $q->result();
	}
	function RegisterSponsor($form_data)
	{
		$this->db->insert('tbl_sponsorer', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return $this->db->insert_id();
		}else{
			return FALSE;
		}	
		
	}
	public function EditSponsorProfile($form_data,$id){
		$this->db->where('id',$id);
		$this->db->update('tbl_sponsorer',$form_data);
		return $id;
	}
		public function nearby_sponsors(){
 		//$map_init=$this->map_init($id);
		//$lat1=$map_init[0]->lat;
		//$lon1=$map_init[0]->lon;
		//$spcountry=$map_init[0]->sp_country;
		$q=$this->db->query("select id, lat ,lon, sp_city, sp_company, sp_address, v_status, sales_person_id from tbl_sponsorer where `lat`!=0");
		$locations = array();
		$i=0;
		$sp= $q->result(); 
		foreach($sp as $key =>$value ){
			//$lat2=$sp[$key]->lat;
			//$lon2=$sp[$key]->lon;
			//$sp_id=$sp[$key]->id;
			//$miles=$this->calculateDistance($lat1, $lon1, $lat2, $lon2);
			//$distance = round($miles * 1.609344,1);
			//if($distance <= $dist){
			if(true){
				$locations[$i]=$sp[$key];
				$i++;
			}		
		}
		return $locations;
	}

	public function nearby_schools(){
		//$map_init=$this->map_init($id);
		//$lat1=$map_init[0]->lat;
		//$lon1=$map_init[0]->lon;
		$sch=$this->db->query("select id,school_name,school_address,school_latitude,school_longitude,school_mnemonic from tbl_school where school_latitude!='0'");	
		$schools = array();
		$i=0;
		$school= $sch->result();
		foreach($school as $key =>$value ){
			//$lat2=$school[$key]->school_latitude;
			//$lon2=$school[$key]->school_longitude;
			//$miles=$this->calculateDistance($lat1, $lon1, $lat2, $lon2);
			//$distance = round($miles * 1.609344,1);
			//if($distance <= $dist){
			if(true){
				$schools[$i]=$school[$key];
				$i++;
			}	
		}
		return $schools;
	}
	
	public function receiptinfo($pdfdata)
	{
			$pdfdata1=array(
				'sp_id'=>$pdfdata['id'],
				'ReceiptNo'=>"SPR".$pdfdata['id'].$pdfdata['dates'],
				'Name'=>$pdfdata['sponsor_name'],
				'Email'=>$pdfdata['email'],
				'sp_phone'=>$pdfdata['sp_phone'],
				'Amount'=>$pdfdata['amount'],
				'Validity'=>$pdfdata['date1']);
									
		$res=$this->db->insert('tbl_insert_receipt', $pdfdata1);
		return $res;
		
	}
	/*Below getdynamic function added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
	public function getdynamic(){
		$q = $this->db->select('*')
		 ->from('tbl_otp')
		 ->where('id', 1)
		->get();
		return $q->result();
	}
}	