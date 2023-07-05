<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sponsor extends CI_Model{
	public function __construct(){
         $this->load->database();
    }
	public function myshops($allid){
			
		$allids=array();
		foreach($allid as $key=>$value){
			$allids[]=$allid[$key]->id;
		}		
		$owner_id=min($allids);	
		
		
		
		$data = array(
               'v_status' => 'Active',
               'owner_id' => $owner_id
			   );	
		
		$sr=0;
		foreach($allid as $key=>$value){
			//echo $allid[$key]->id;
			$this->db->update('tbl_sponsorer', $data, array('id' => $allid[$key]->id));
			
			$this->db->select('id, sp_company, sp_img_path, sp_address, sp_city, sp_name, sp_phone, sp_email');
			$q = $this->db->get_where("tbl_sponsorer",array("id"=>$allid[$key]->id));
			$p[$sr]=$q->result();
			$sr++;
		}
		return $p;
	}
	
	
	
	public function headerData($id){
	
		$q = $this->db->query("select s.id, s.sp_name, s.sp_company, s.sp_img_path, s.sp_address, s.sp_city, s.sp_state, s.sp_country, s.sp_email, s.lat, s.lon, s.v_category, s.sp_website, (select sum(ts.product_price) from tbl_selected_vendor_coupons svc join tbl_sponsored ts on svc.coupon_id=ts.id and svc.sponsor_id=ts.sponsor_id  where svc.sponsor_id='$id' and svc.used_flag='used') as income, (select count(svc.id) from tbl_selected_vendor_coupons svc where sponsor_id='$id' ) as selected_coupons, (select count(svc.id) from tbl_selected_vendor_coupons svc where sponsor_id='$id' and used_flag='used') as redeemed_coupons,(select count(distinct(svc.user_id)) from tbl_selected_vendor_coupons svc where sponsor_id='$id' and used_flag='used') as visitors from tbl_sponsorer s where s.id='$id'");
		return $q->result();		
	}
	
	public function update_coords($newLat, $newLng, $id){
		$data = array(	'lat' => $newLat,
						'lon' => $newLng,					
					); 	
		$this->db->where(array("id"=>$id));
		$q=$this->db->update('tbl_sponsorer', $data); 
		return $q;	
	}

	public function categories($id){
		if($id==""){
			$q = $this->db->get("categories");
			return $q->result(); 
		}else{
			$q = $this->db->get_where("categories",array("id"=>$id));
			return $q->result();
		}
	}

	public function currencies($id){
		if($id==""){
			$q = $this->db->get("currencies");
			return $q->result(); 
		}else{
			$q = $this->db->get_where("currencies",array("id"=>$id));
			return $q->result();
		}	
	}

	public function log_generated_coupons($id){
		$this->db->select('ts.id, ts.Sponser_product, ts.points_per_product, ts.sponsered_date, ts.valid_until, cat.category, cur.currency, ts.product_price, ts.discount, ts.buy, ts.get, ts.validity');
		$this->db->from('tbl_sponsored ts');
		$this->db->join('currencies cur', 'cur.id = ts.currency', 'left');
		$this->db->join('categories cat', 'cat.id = ts.category', 'left');
		$this->db->where(array("ts.sponsor_id"=>$id));
		$this->db->order_by('ts.id DESC, ts.Sponser_product ASC');
		$q = $this->db->get();
		return $q->result();
	}

	public function log_accepted_sc_coupons($id){
		$this->db->select("( case user_type when 'student' then concat(s.std_lastname,' ',s.std_name,' ',s.std_Father_name)
			when 'teacher' then concat(t.t_lastname,' ',t.t_name,' ',t.t_middlename) end ) as name,
		( case user_type when 'student' then s.std_img_path
		when 'teacher' then t.t_pc end ) as photo, 
		`coupon_id`,`product_name`,`points`,`issue_date`, `user_type`");

		$this->db->from('tbl_accept_coupon c');
		$this->db->join('tbl_student s', 's.std_PRN=c.stud_id and s.school_id=c.school_id', 'left');
		$this->db->join('tbl_teacher t', 't.school_id=c.school_id and t.id=c.stud_id', 'left');
		$this->db->where(array("c.sponsored_id"=>$id));
		$this->db->order_by('c.id DESC');
		$q = $this->db->get();
		return $q->result();
	}


	public function log_accepted_sp_coupons($id){
		$this->db->select("( case entity_id when '3' then concat(s.std_lastname,' ',s.std_name,' ',s.std_Father_name)
			when '2' then concat(t.t_lastname,' ',t.t_name,' ',t.t_middlename) end ) as name,
			
		( case entity_id when '3' then s.std_img_path
		when '2' then t.t_pc end ) as photo,

		( case entity_id when '3' then 'Student'
			when '2' then 'Teacher' end ) as user_type,
			
		`code`, sp.Sponser_product, sp.Sponser_product as discount, `for_points`,`timestamp`");

		$this->db->from('tbl_selected_vendor_coupons c');
		$this->db->join('tbl_student s', 's.id=c.user_id', 'left');
		$this->db->join('tbl_teacher t', 't.id=c.user_id', 'left');
		$this->db->join('tbl_sponsored sp', 'c.coupon_id=sp.id', 'left');
		$this->db->where(array("c.sponsor_id"=>$id, "c.used_flag"=>'used'));
		$this->db->order_by('c.timestamp desc');
		$q = $this->db->get();
		return $q->result();
	}

	public function getSchoolNameAndCoupons($id){
		$q = $this->db->query("select  sa.school_name, svc.school_id, count(*) as cnt FROM tbl_selected_vendor_coupons svc
		join tbl_school_admin sa on sa.school_id=svc.school_id
		where sponsor_id='$id' group by school_id");
		return $q->result();
	}

	public function collegewise_sp_coupon_stat($id, $school_id, $school_name, $school_count){
		$q = $this->db->query("select '$school_name' as school, '$school_count' as school_count, 
		(select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id'  and entity_id='3' and school_id='$school_id') as studs,
		(select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and entity_id='3' and used_flag='used' and school_id='$school_id') as used_studs,
		(select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and entity_id='3' and used_flag='unused' and school_id='$school_id') as unused_studs,
		(select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id'  and entity_id='2' and school_id='$school_id') as teachers,
		(select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and entity_id='2' and used_flag='used' and school_id='$school_id') as used_teachers,
		(select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and entity_id='2' and used_flag='unused' and school_id='$school_id') as unused_teachers");
		return $q->result();

	}

	public function collegewise_usage($id){
		$schools = $this->getSchoolNameAndCoupons($id);
		$data=array();
		foreach($schools as $key => $value){
			$data[]=$this->collegewise_sp_coupon_stat($id, $schools[$key]->school_id, $schools[$key]->school_name, $schools[$key]->cnt );			
		}
		return $data;
	}

	public function map_init($id){
		$this->db->select('id, sp_name, sp_company, lat, lon, sp_country, sp_city, sp_state, sp_address');
		$q= $this->db->get_where('tbl_sponsorer', "id=$id");
		return $q->result();
	}

	public function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
	    $theta = $longitude1 - $longitude2;
	    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	    $miles = acos($miles);
	    $miles = rad2deg($miles);
	    $miles = $miles * 60 * 1.1515;
	    return $miles; 
	}
	
	public function spLatLonId(){
		//$this->db->select('id, lat ,lon');
		//$q=$this->db->from("tbl_sponsorer");
		$q = $this->db->query("select id, lat ,lon FROM tbl_sponsorer"); 
		return $q->result();
	}
	
	public function nearby_sponsors($id, $dist){
		$map_init=$this->map_init($id);
		$lat1=$map_init[0]->lat;
		$lon1=$map_init[0]->lon;
		$spcountry=$map_init[0]->sp_country;
		$q=$this->db->query("select id, lat ,lon, sp_city, sp_company, sp_address from tbl_sponsorer where sp_country='$spcountry' and id<>'$id' and v_status<>'Inactive'");
		$locations = array();
		$i=0;
		$sp= $q->result();
		foreach($sp as $key =>$value ){
			$lat2=$sp[$key]->lat;
			$lon2=$sp[$key]->lon;
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
		$lat1=$map_init[0]->lat;
		$lon1=$map_init[0]->lon;
		$sch=$this->db->query("select id,school_name,school_address,school_latitude,school_longitude from tbl_school");	
		$schools = array();
		$i=0;
		$school= $sch->result();
		foreach($school as $key =>$value ){
			$lat2=$school[$key]->school_latitude;
			$lon2=$school[$key]->school_longitude;
			$miles=$this->calculateDistance($lat1, $lon1, $lat2, $lon2);
			$distance = round($miles * 1.609344,1);
			if($distance <= $dist){
				$schools[$i]=$school[$key];
				$i++;
			}	
		}
		return $schools;
	}
	
	public function product($id){
		$this->db->select("id, Sponser_type, Sponser_product, points_per_product, discount ");
		$q=$this->db->get_where("tbl_sponsored", "Sponser_type = 'product' and sponsor_id='$id' and validity='valid'");
		return $q->result();
	}
	public function discount($id){
		$this->db->select("id, Sponser_type, Sponser_product, points_per_product, discount ");
		$q=$this->db->get_where("tbl_sponsored", "Sponser_type = 'discount' and sponsor_id='$id' and validity='valid'");
		return $q->result();
	}
	
	public function del($table, $id){
		$this->db->where('id', $id);
		$s=$this->db->delete($table);
		return $s;
	}
	
	public function is_valid_code($id, $str){
		$this->db->select("id, used_flag");
		$q=$this->db->get_where("tbl_selected_vendor_coupons", "`code`='$str' and sponsor_id='$id'");
		//$q->result();
		return $q->num_rows();
	}
	
	public function code_user($id, $str){
		$this->db->select("( case entity_id when '3' then concat(s.std_lastname,' ',s.std_name,' ',s.std_Father_name)
			when '2' then concat(t.t_lastname,' ',t.t_name,' ',t.t_middlename) end ) as name,
			
		( case entity_id when '3' then s.std_school_name
		when '2' then t.t_current_school_name end ) as school,
		
		( case entity_id when '3' then s.std_img_path
		when '2' then t.t_pc end ) as photo,

		( case entity_id when '3' then 'Student'
			when '2' then 'Teacher' end ) as user_type,
			
		c.`id`,c.`coupon_id`,`code`, sp.Sponser_product,sp.discount,`for_points`,`timestamp`, c.school_id, `used_flag`, sp.valid_until");
		
		$this->db->from('tbl_selected_vendor_coupons c');
		$this->db->join('tbl_student s', 's.id=c.user_id', 'left');
		$this->db->join('tbl_teacher t', 't.id=c.user_id', 'left');
		$this->db->join('tbl_sponsored sp', 'c.coupon_id=sp.id', 'left');
		$this->db->where(array("c.sponsor_id"=>$id, "c.code"=>$str));
		$this->db->order_by('c.used_flag asc, c.timestamp desc');
		$q = $this->db->get();
		$user['data']=$q->result();
		$user['rows']=$q->num_rows();
		return $user;
		
	}
	
	public function accept_sp_coupon($cpid, $id, $scid){		
		$q = $this->db->query("update tbl_selected_vendor_coupons set used_flag='used',
		`school_id`='$scid', timestamp=CURRENT_TIMESTAMP where sponsor_id ='$id' AND id='$cpid'");
		return  $this->db->affected_rows();
	}
	
	public function is_sccoupon_exist($cpid){
/* 		 	$arr = mysql_query("select cp_stud_id,s.std_complete_name,s.std_name,s.std_lastname,s.school_id,s.std_Father_name,s.std_school_name,s.std_img_path,amount,status,cp_gen_date,validity from tbl_coupons c join tbl_student s on c.cp_stud_id=s.std_PRN where cp_code=\"$cp_id\"");
			
$arr2 = mysql_query("SELECT user_id, t_complete_name,t_lastname,t_name, t_current_school_name, t_pc, t.school_id, amount, status, issue_date, validity_date FROM `tbl_teacher_coupon` c JOIN `tbl_teacher` t ON c.user_id=t.id WHERE coupon_id=\"$cp_id\"");  */
			
		
		$this->db->select("id");
		$q=$this->db->get_where("tbl_coupons", "`cp_code`='$cpid'");
		
		$this->db->select("id");
		$r=$this->db->get_where("tbl_teacher_coupon", "`coupon_id`='$cpid'");
		
		//$q->result();
		if($q->num_rows()){
			return 'tbl_coupons';
		}elseif($r->num_rows()){
			return 'tbl_teacher_coupon';
		}else{
			return false;
		}
	}
	
	public function sccoupon_display($cpid,$table,$spid){
		if($table=='tbl_coupons'){	
		
			$this->db->select("c.cp_stud_id as user_id,c.Stud_Member_Id,s.std_complete_name,
			concat(s.std_name,' ',s.std_Father_name,' ',s.std_lastname) as name, 
			s.school_id , s.std_school_name as school_name, s.std_img_path as photo, amount,
			c.status, cp_gen_date as generation_date,c.validity as validity_date");
			$this->db->from('tbl_coupons c');
			$this->db->join('tbl_student s', 'c.Stud_Member_Id=s.id');
			//$this->db->join('tbl_student s', 'c.cp_stud_id=s.std_PRN');
			
			//here i have to look again as school_id field is not present in tbl_coupons as std_PRN may be ambiguous		
			$this->db->where(array("c.cp_code"=>$cpid));
			$q = $this->db->get();
			
			$user['data']=$q->result();
			$user['rows']=$q->num_rows();
			
			
		
		}elseif($table=='tbl_teacher_coupon'){
			
			$this->db->select("user_id, concat(t.t_lastname,' ',t.t_name,' ',t.t_middlename) as name,  t_current_school_name as school_name, t_pc as photo, t.school_id, amount, c.status, issue_date as generation_date, c.validity_date"); 	 	
			$this->db->from('tbl_teacher_coupon c');
			$this->db->join('tbl_teacher t', 'c.user_id=t.id');	
			$this->db->where(array("c.coupon_id"=>$cpid));
			$q = $this->db->get();
			
			$user['data']=$q->result();
			$user['rows']=$q->num_rows();
		}
			//$user['product']=$this->product($spid);
			//$user['discount']=$this->discount($spid);
		return $user;
	}
	
	public function getProduct($cid){
		$this->db->select("id, Sponser_type, Sponser_product, points_per_product, discount ");
		$q=$this->db->get_where("tbl_sponsored", "id='$cid'");
		return $q->result();
	}

public function accept_sccoupon($id,$user_id,$sccode,$propoints,$proname,$type,$school_id, $amt){
		
					$data = array(
							'sponsored_id' => $id,
							'stud_id' => $user_id,
							'quantity' => '1',
							'coupon_id' => $sccode,
							'points' => $propoints,
							'product_name' => $proname,
							'issue_date' => date('m/d/Y'),
							'user_type' => $type,
							'school_id' => $school_id,
					); 	 	 	 	 	 	 	 	
			$q=$this->db->insert('tbl_accept_coupon', $data);
			$p=$this->update_accepted_coupon_points($user_id, $type, $sccode, $amt, $school_id );			
		if($q && $p){
			return true;
		}else{
			return false;
		}
			
	}	
	
	public function update_accepted_coupon_points($user_id, $type, $sccode, $amt, $school_id){	
		if($amt==0){
			$status='no';
		}else{
			$status='p';
		}
		
		if($type=='student'){			
					$data = array(
							'amount' => $amt,
							'status' => $status
					);
					$this->db->where(array("cp_stud_id"=>$user_id, "cp_code"=>$sccode));
					$q=$this->db->update('tbl_coupons', $data);
					
		}elseif($type=='teacher'){			
					$data = array(
							'amount' => $amt,
							'status' => $status,
					);

					$this->db->where(array("user_id"=>$user_id, "coupon_id"=>$sccode));
					$q=$this->db->update('tbl_teacher_coupon', $data);			
		}
		
		if($q){
			return true;
		}else{
			return false;
		}

	}	
	
	public function is_valid_product($id, $str){
		$this->db->select("id");
		$q=$this->db->get_where("tbl_sponsored", "sponsor_id='$id' and Sponser_product='$str'");
		if($q->num_rows()){
			return true;
		}else{
			return false;
		}
	}
	
	public function add_product($id, $type, $product, $discount, $pts, $disimguploaded){
		
		$this->db->select("v_category, DefaultCategoryImage");		
		$this->db->from('tbl_sponsorer s');		
		$this->db->join('categories c', 's.v_category=c.id', 'left');		
		$this->db->where(array("s.id"=>$id));		
		$q = $this->db->get();	
		
		$c=$q->result();
		$category=$c[0]->v_category;	
		$DefaultCategoryImage=$c[0]->DefaultCategoryImage;		
		
		if($category=="" or $category==NULL){
				return false;
		}else{
		
			if($disimguploaded!=''){
				$product_image=$disimguploaded;
			}else{
				$product_image=$DefaultCategoryImage;
			}
			
			$data = array(
								'Sponser_type' => $type,
								'Sponser_product' => $product,
								'Points_per_product' => $pts,
								'sponsor_id' => $id,
								'total_coupons' => 'unlimited',
								'valid_until' => date("m/d/Y", strtotime('+6 months', time())),
								'sponsered_date' => date('m/d/Y'),
								'daily_limit' => 'unlimited',
								'daily_counter' => 'unlimited',
								'reset_date' => date('m/d/Y'),
								'discount' => $discount,
								'category' => $category,
								'product_image' => $product_image,	
						); 	 	 	 	 	 	 	 	
			 $q=$this->db->insert('tbl_sponsored', $data);
							
			return $q;
		}
	}
	
	public function update_product($id, $product, $discount, $pts, $upid, $disimguploaded){			
	
		$this->db->select("product_image, v_category, DefaultCategoryImage");		
		$this->db->from('tbl_sponsored spd');
		$this->db->join('tbl_sponsorer s', 's.id=spd.sponsor_id', 'left');		
		$this->db->join('categories c', 's.v_category=c.id', 'left');		
		$this->db->where(array("s.id"=>$id,"spd.id"=>$upid));		
		$q = $this->db->get();
		
		$c=$q->result();
		$category=$c[0]->v_category;	
		$DefaultCategoryImage=$c[0]->DefaultCategoryImage;		
		$product_image=$c[0]->product_image;		
		
		if($disimguploaded!=''){
			$product_image=$disimguploaded;
		}elseif($product_image!=''){
			
		}else{
			$product_image=$DefaultCategoryImage;
		}		
	
		$data = array(		'Sponser_product' => $product,
							'Points_per_product' => $pts,
							'discount' => $discount,
							'category' => $category,
							'product_image' => $product_image,							
					); 	
		$this->db->where(array("id"=>$upid, "sponsor_id"=>$id));
		$q=$this->db->update('tbl_sponsored', $data); 
		return $q;		
	}
	
	public function add_coupon($id, $data){
		$saving=0;
		if($data['cdata']->price!=0 && $data['cdata']->discount!=0){ 
			$saving=$data['cdata']->price*($data['cdata']->discount/100); 
		} 
		if($data['cdata']->buy!=0 && $data['cdata']->buy_get!=0){ 
			$saving=$data['cdata']->buy_get*$data['cdata']->price; 
		} 
		$limit_value=$data['cdata']->daily_limit;
		$total_coupons=$data['cdata']->total_coupons;
		
		if($limit_value==0){ 
			$limit_value='unlimited'; 
		}
		
		if($total_coupons==0){ $total_coupons='unlimited'; }
		

		if(is_numeric($data['cdata']->name)){ 						 
			$sponsor_type='discount';
		}elseif(strpos($data['cdata']->name, '%') !== false){
			$sponsor_type='discount';
		}else{
			$sponsor_type='product';
		} 
				
		$sponsor_type='product';
		
		$offerdes = htmlentities($data['cdata']->offer_description);
		
		if($saving==0){ $saving='NULL'; }

		
		if($data['cdata']->up){
					$datau = array(
						'Sponser_type'=>$sponsor_type, 
						'Sponser_product'=>$data['cdata']->name, 
						'points_per_product'=>$data['cdata']->points, 
						'sponsered_date'=>$data['cdata']->startdate, 						
						'validity'=>'valid', 
						'sponsor_id'=>$id, 
						'product_image'=>$data['cdata']->file_name, 
						'valid_until'=>$data['cdata']->enddate, 
						'category'=>$data['cdata']->product_type, 
						'product_price'=>$data['cdata']->price, 
						'discount'=>$data['cdata']->discount, 
						'buy'=>$data['cdata']->buy, 
						'get'=>$data['cdata']->buy_get, 
						'saving'=>$saving, 
						'offer_description'=>$offerdes, 
						'daily_limit'=>$limit_value, 
						'total_coupons'=>$total_coupons, 
						'priority'=>'0', 
						'coupon_code_ifunique'=>$data['cdata']->uniquecode, 
						'currency'=>$data['cdata']->currency, 
						'daily_counter'=>$limit_value, 
						'reset_date'=>$data['cdata']->startdate 
					); 	
					$this->db->where(array("id"=>$data['cdata']->up, "sponsor_id"=>$id));
					$q=$this->db->update('tbl_sponsored', $datau); 
					return $q;		
		}else{
					$datai = array(
						'Sponser_type'=>$sponsor_type, 
						'Sponser_product'=>$data['cdata']->name, 
						'points_per_product'=>$data['cdata']->points, 
						'sponsered_date'=>$data['cdata']->startdate, 						
						'validity'=>'valid', 
						'sponsor_id'=>$id, 
						'product_image'=>$data['cdata']->file_name, 
						'valid_until'=>$data['cdata']->enddate, 
						'category'=>$data['cdata']->product_type, 
						'product_price'=>$data['cdata']->price, 
						'discount'=>$data['cdata']->discount, 
						'buy'=>$data['cdata']->buy, 
						'get'=>$data['cdata']->buy_get, 
						'saving'=>$saving, 
						'offer_description'=>$offerdes, 
						'daily_limit'=>$limit_value, 
						'total_coupons'=>$total_coupons, 
						'priority'=>'0', 
						'coupon_code_ifunique'=>$data['cdata']->uniquecode, 
						'currency'=>$data['cdata']->currency, 
						'daily_counter'=>$limit_value, 
						'reset_date'=>$data['cdata']->startdate 
					); 	 	 	 	 	 	 	 	
				$q=$this->db->insert('tbl_sponsored', $datai); 
				return $q;
		}
	}
	
	public function get_coupon($id, $cid){
		//$this->db->select("id, Sponser_type, Sponser_product, points_per_product, discount ");
		$q=$this->db->get_where("tbl_sponsored", "id='$cid' and sponsor_id='$id'");
		return $q->result();
	}
	
	public function myData($id){
		$q=$this->db->get_where("tbl_sponsorer", "id='$id'");
		return $q->result();
	}
	
	public function countries($id=0){
		if($id){
			$q=$this->db->get_where("tbl_country", "is_enabled='1' AND id='$id'");	
			return $q->result();
		}else{
			$q=$this->db->get_where("tbl_country", "is_enabled='1' order by country");
			//$q=$this->db->order_by("country","ASC");
			return $q->result();
		}
	}
	
	public function get_states($country){
			$this->db->select("s.state"); 	 	
			$this->db->from('tbl_state s');
			$this->db->join('tbl_country c', 'c.country_id=s.country_id');	
			$this->db->where(array("c.country"=>$country));
			$this->db->order_by("state","ASC");
			$q = $this->db->get();			
			return $q->result();		
	}
	
	public function get_cities($country,$state){
			$this->db->distinct();
			$this->db->select("ci.sub_district"); 	 	
			$this->db->from('tbl_city ci');
			$this->db->join('tbl_state s', 'ci.state_id=s.state_id');
			$this->db->join('tbl_country c', 's.country_id=c.country_id');	
			$this->db->where(array("c.country"=>$country,"s.state"=>$state));
			$this->db->order_by("sub_district","ASC");
			$q = $this->db->get();			
			return $q->result();		
	}
	public function update_profile($id, $data){
			$this->db->where(array("id"=>$id));
			$q=$this->db->update('tbl_sponsorer', $data); 
			return $q;			
	}
	
	public function calling_code($sp_country){
				$this->db->select("calling_code");
				$q=$this->db->get_where("tbl_country","country='$sp_country' or is_enabled='1'");
				$r=$q->result();
				$sr=0;
				foreach($r as $key=>$value){
					$i=explode(',',$r[$key]->calling_code);
					foreach($i as $j=>$k){
						$p[$sr]=trim($i[$j]);
						$sr++;
					} 
				}
				return $p;
	}
	
	public function send_otp_phone($id, $cc, $phone){
		$otp=rand(1000,9999);
			
		$data=array("temp_phone"=>$phone,"otp_phone"=>$otp,);
		$this->db->where(array("id"=>$id));
		$q=$this->db->update('tbl_sponsorer', $data); 
		
		
			
			$q = $this->db->query("select s.id, s.sp_name,s.sp_email  from tbl_sponsorer s  where sponsor_id='$id' and  where s.id='$id'");
				
			while($row=mysql_fetch_assoc($q))
			{
				$sp_name=$row['sp_name'];
				$sp_email=$row['sp_email'];
				
			}
			
		if($cc=='+91'){
			
			
			/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= $this->db->query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
						
			$Text="Hello+".$sp_name."+Your+Mobile+Number+is+changed+and+your+OTP+for+".$phone."+is+".$otp."+Thank+You"; 
			$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
			echo $url;exit;
			file_get_contents($url);
		}else{
			$ApiVersion = "2010-04-01";
			// set our AccountSid and AuthToken
			$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
			$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
			
			// instantiate a new Twilio Rest Client
			$client = new TwilioRestClient($AccountSid, $AuthToken);
			$number=$cc.$phone;
			$message="OTP for ".$phone." is ".$otp." Thank You."; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
					"POST", array(
					"To" => $number,
					"From" => "732-798-7878",
					"Body" => $message
				));
		}
		return true;
	}
	
	public function send_otp_email($id, $email){
		$otp=rand(1000,9999);
		
 		$data=array("temp_email"=>$email,"otp_email"=>$otp,);
		$this->db->where(array("id"=>$id));
		$q=$this->db->update('tbl_sponsorer', $data); 
		return $otp;		
	}
	
	public function verify_email($id,$otp){
		$this->db->select("sp_email, temp_email, otp_email");
		$q=$this->db->get_where("tbl_sponsorer", "id='$id'");
		$t=$q->result();
		$te=$t[0]->temp_email;
		$oe=$t[0]->otp_email;
		$oemail=$t[0]->sp_email;
		if($otp==$oe){
			$data=array("sp_email"=>$te,"temp_email"=>'',"otp_email"=>'1');
			$this->db->where(array("sp_email"=>$oemail));
			$q=$this->db->update('tbl_sponsorer', $data);
			return true;
		}else{
			return false;
		}
	}
	
	public function verify_phone($id,$otp){
		$this->db->select("sp_email, temp_phone, otp_phone");
		$q=$this->db->get_where("tbl_sponsorer", "id='$id'");
		$t=$q->result();
		$tp=$t[0]->temp_phone;
		$op=$t[0]->otp_phone;
		$osp_email=$t[0]->sp_email;
		if($otp==$op){
			$data=array("sp_phone"=>$tp,"temp_phone"=>'',"otp_phone"=>'1');
			$this->db->where(array("sp_email"=>$osp_email));
			$q=$this->db->update('tbl_sponsorer', $data);
			return true;
		}else{
			return false;
		}
	}
	
	public function change_password($id, $email,$oldpass,$confpass){				
		$this->db->select("sp_password,sp_email");
		$q=$this->db->get_where("tbl_sponsorer", "id='$id'");
		$t=$q->result();
		$tp=$t[0]->sp_password;				$email = $t[0]->sp_email;
		if($oldpass===$tp)		{			$data=array("sp_password"=>$confpass);			$this->db->where("sp_email",$email);			$q=$this->db->update('tbl_sponsorer', $data);						return true;
			
		}else{
			return false;
		}
	}
	
	public function update_profile_image($id, $img){		
 		$datau = array(						
			'sp_img_path'=>$img						
		); 	
		$this->db->where(array("id"=>$id));
		$q=$this->db->update('tbl_sponsorer', $datau); 
		return $q;
	}
	

	
	public function add_shop($data){
	
		$q=$this->db->get_where("tbl_sponsorer", array('sp_company'=>$data->sp_company, 'sp_address'=>$data->sp_address));
		
		$rows=$q->num_rows();
		
		if($rows<=0){
			$q=$this->db->insert('tbl_sponsorer', $data);
			$last_id = $this->db->insert_id();		
			return $last_id;
		}else{
			return 0;	
		}	
		
	}
}


?>