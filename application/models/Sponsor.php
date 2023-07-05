<?php 
class sponsor extends CI_Model
{

public function sponsorinfo()
{
	//Author VaibhavG. Below I'hv added sp_company for the ticket number SMC-3245 22Aug18 5:57PM
	$this->db->select('id,sp_name,sp_company, sp_address,sp_email, sp_city,sp_country,sp_state,lat,lon');
	$this->db->from('tbl_sponsorer');  
	$query = $this->db->get();
	return $res1 = $query->result();	
}





public function sponsorlist()
{
	$this->db->select('id,sp_name, sp_address,sp_company,sp_email,sponaor_img_path,sp_phone,sp_city,sp_country,sp_state,lat,lon');
	$this->db->from('tbl_sponsorer');  
	   $query = $this->db->get();
        return $res1 = $query->result();
	
}

//below functions from "sp/sponsor" model & these functions are used in "Main" controller's "sponsor_map" function 
	public function map_init($id){
		$this->db->select('id, sp_name, sp_company, lat, lon, sp_country, sp_city, sp_state, sp_address');
		$q= $this->db->get_where('tbl_sponsorer', "id=$id");
		return $q->result();
	}
	
	public function nearby_sponsors($id, $dist){
		$map_init=$this->map_init($id);
		$lat1=floatval($map_init[0]->lat);
		$lon1=floatval($map_init[0]->lon);
		$spcountry=$map_init[0]->sp_country;
		$q=$this->db->query("select id, lat ,lon, sp_city, sp_company, sp_address from tbl_sponsorer where sp_country='$spcountry' and id<>'$id' and v_status<>'Inactive'");
		$locations = array();
		$i=0;
		$sp= $q->result();
		foreach($sp as $key =>$value ){
			$lat2=floatval($sp[$key]->lat);
			$lon2=floatval($sp[$key]->lon);
			$sp_id=$sp[$key]->id;
			$miles=$this->calculateDistance($lat1, $lon1, $lat2, $lon2);
			$distance = round($miles * 1.609344,1);
			if($distance <= $dist){
				$locations[$i]=$sp[$key];
				$i++;
			}		
		}
		return $locations;
	}

	public function nearby_schools($id, $dist){
		$map_init=$this->map_init($id);
		$lat1=floatval($map_init[0]->lat);
		$lon1=floatval($map_init[0]->lon);
		$sch=$this->db->query("select id,school_name,school_address,school_latitude,school_longitude from tbl_school");	
		$schools = array();
		$i=0;
		$school= $sch->result();
		foreach($school as $key =>$value ){
			$lat2 = floatval($school[$key]->school_latitude);
			$lon2 = floatval($school[$key]->school_longitude);
			$miles=$this->calculateDistance($lat1, $lon1, $lat2, $lon2);
			$distance = round($miles * 1.609344,1);
			if($distance <= $dist){
				$schools[$i]=$school[$key];
				$i++;
			}	
		}
		return $schools;
	}

public function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
	    $theta = $longitude1 - $longitude2;
	    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	    $miles = acos($miles);
	    $miles = rad2deg($miles);
	    $miles = $miles * 60 * 1.1515;
	    return $miles; 
	}	
}


?>







