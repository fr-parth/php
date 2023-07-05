	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccoupon extends CI_Controller {
		
		public $id;
		public $entity;
		
		public function __construct(){
		  parent::__construct();
 			$this->load->library('session'); 
			
			if($this->session->entity=='student'){
				$this->entity=$this->session->entity; 
				$this->id=$this->session->stud_id;
				$this->std_PRN=$this->session->std_PRN;
				$this->school_id=$this->session->school_id;
			}elseif($this->session->entity=='teacher'){
				$this->entity=$this->session->entity; 
				
			}elseif($this->session->entity=='sponsor'){
				$this->entity='student'; 
				$this->id=1;
						
			}else{
				//redirect('Welcome/login', 'location');								echo "<div class='row'><div class=\"alert alert-info\" role=\"alert\" align=\"center\">					<span class=\"glyphicon glyphicon-thumbs-down\" aria-hidden=\"true\"> &nbsp;&nbsp;&nbsp;&nbsp;					</span><strong>Your Session Has Been Expired. Please Login Again.. <br /> <a href=".base_url('Welcome/login').">Click Here.</a></strong></div></div>";				
			}
			
			
			
			
			$this->load->helper('imageurl');

		}
	
		public function header(){			
			
					switch($this->session->entity){
						case 'teacher':
							$this->teacherHeader();
								break;
						case 'student':
							$this->studHeader();
							break;	
						case 'sponsor':
							$this->spheader();
							break;		
					}
		
		}
		public function footer(){
			$this->spfooter();
		}
		
		public function teacherHeader(){
			
		}	
		
		public function studHeader(){	
			$this->load->model("student");
			$row['studentinfo']=$this->student->studentinfo($this->std_PRN,$this->school_id);		
			$this->load->view('stud_header',$row);
		}	
		
		public function spheader(){	
			
			$data['img_path']="assets/images/sp/";
			$this->load->model("sp/sponsor");
			$data['user']= $this->sponsor->headerData($this->session->id);
			$this->load->view('sp/header',$data);			
		}	
		
		public function spfooter(){
			$this->load->view('sp/footer');
		}
		
		public function select_coupon(){
			$this->header();					
			$this->load->model("sp/sponsor");	
			$this->load->model('coupons/coupons');
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['cart_items']=$this->coupons->cart_items($this->entity,$this->id);
			$data['cart_items']['usedpts'][0]->usedpts;
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
			$data['categories']=$this->sponsor->categories('');	
			
			$data['states']=$this->sponsor->get_states($data['userinfo'][0]->country);
			$data['cities']=$this->sponsor->get_cities($data['userinfo'][0]->country,$data['userinfo'][0]->state);
			
			$this->load->view('coupons/coupons',$data);			
			$this->footer();
		}
		
		public function getStatusRow(){
			$this->load->model('coupons/coupons');
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['cart_items']=$this->coupons->cart_items($this->entity,$this->id);
			$data['cart_items']['usedpts'][0]->usedpts;
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
			$this->load->view('coupons/my_points',$data);

		}
		
		public function calLatLongByAddress($country, $state, $city){	
			$addr=$city.", ".$state.", ".$country;
			$add= urlencode($addr);
			$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$add.'&sensor=false');
			$output_selected= json_decode($geocode_selected);
			$latlong=array();
			$latlong[0] = $output_selected->results[0]->geometry->location->lat;
			$latlong[1] = $output_selected->results[0]->geometry->location->lng;
			return $latlong;	
		}
		
		public function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
			$latitude1=(double)$latitude1;
			$longitude1=(double)$longitude1;
			$latitude2=(double)$latitude2;
			$longitude2=(double)$longitude2;
			
			$theta = $longitude1 - $longitude2;
			$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
			$miles = acos($miles);
			$miles = rad2deg($miles);
			$miles = $miles * 60 * 1.1515;
			return $miles; 
		}
		
		public function datediffr($date1,$date2){

			$date1 = DateTime::createFromFormat('m/d/Y', trim($date1));
			$date_1 = $date1->format('Y-m-d');

			$date2 = DateTime::createFromFormat('m/d/Y', trim($date2));
			$date_2 = $date2->format('Y-m-d');

			$datetime1 = date_create($date_1);
			$datetime2 = date_create($date_2);

			$interval = date_diff($datetime1, $datetime2);

			return $interval->format("%R%a");		
		}
		
		public function coupon_list(){
			
			$this->load->model('coupons/coupons');	
			$this->coupons->total_coupon_check();	//check with number of coupons can be selected
			
		 	$lat=trim($this->input->post('lat'));
		 	$lon=trim($this->input->post('lon'));			
		 	$distance=trim($this->input->post('dist'));
		 	$catid=trim($this->input->post('cat'));
			$addr=trim($this->input->post('addr'));
		 	$country=trim($this->input->post('country'));
		 	$state=trim($this->input->post('state'));
		 	$city=trim($this->input->post('city'));
		 	$curr=trim($this->input->post('curr'));
			
			 
			if(!$curr){ //if the current location is selected then use lat lon else 
				$latlon=$this->calLatLongByAddress($country, $state, $city);
				$lat=$latlon[0];
				$lon=$latlon[1];
			}
			
				$items=$this->coupons->coupon_list($catid);
			
			
			
			$sr=0;
		$td=date("m/d/Y",time());
			
					
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);						
			$data['cart_items']=$this->coupons->cart_items($this->entity,$this->id);			
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;		
			
			$pts=$data['rem_pts'];
			foreach($items as $key=>$value){
				$valid=true;	
				$items[$key]->lat;
				$items[$key]->lon;
				
				$miles=$this->calculateDistance($items[$key]->lat, $items[$key]->lon, $lat, $lon);
					
				$kilometers = $miles * 1.609344;				
				if($kilometers > $distance){						
					$valid=false;
					continue;
				}	
					
				$start_check=$this->datediffr($td,$items[$key]->sponsered_date);
				$start_check=intval($start_check);
				if($start_check > 0){ 
					//$start_check=0;
					$valid=false;
					continue;
				}
				
				$di=$this->datediffr($td,$items[$key]->valid_until);
				$di=intval($di);
				if($di < 0){
					$this->coupons->up_valid_until($items[$key]->id);//set invalid
					$valid=false;
					continue;
				} 
				
				
				$daily_limit=$items[$key]->daily_limit;	
				$reset_date=$items[$key]->reset_date;						
				$daily=$this->datediffr($td,$reset_date);				
				if($daily < 0){
					$this->coupons->up_daily_counter($items[$key]->id,$td,$daily_limit);
					//update counter for today
					$items[$key]->daily_counter=$daily_limit;
					$items[$key]->reset_date=$td;
				}
				
				//daily limit
				if($items[$key]->daily_counter!='unlimited' and $items[$key]->daily_counter==0){
					$valid=false;
					continue;
				} 
				
				if($kilometers <= 0){
					$meters = $miles * 1609.34;
					$calculated_distance=round($meters,2)." Mtr";
					
				}else{
					$calculated_distance=round($kilometers,2)." Kms";
				}
				
				//if($valid){
					$this->coupon($items[$key], $calculated_distance, $pts);
					$sr++;					
				//}
			}
			if($sr==0){
				echo "<div class=\"alert alert-info\" role=\"alert\" align=\"center\">
					<span class=\"glyphicon glyphicon-thumbs-up\" aria-hidden=\"true\"> &nbsp;&nbsp;&nbsp;&nbsp;
					</span><strong>Sorry! coupons not available	for this location / category .</strong></div>";
			}	 

		}
		public function coupon($item, $distance, $pts){

	$content='';
	if($item->valid_until!=''){ 
		$content.="Valid Until: <strong>".$item->valid_until."</strong><br/>"; 
	}
	$content.="Distance: <strong>".$distance."</strong><br/>"; 
	if($item->total_coupons!="unlimited"){ 
		$content.="Total Coupons Left <strong>".$item->total_coupons."</strong><br/>"; 
	}
	if($item->daily_counter!="unlimited"){ 
		$content.="Todays Limit <strong>".$item->daily_counter."</strong><br/>"; 
	}
	if($item->offer_description!=""){ 
		$content.="Description: ".$item->offer_description."<br/>"; 
	}
	if($item->sp_address!=""){ 
		$content.="Address: ".$item->sp_address."<br/>";
	}
	if($item->sp_city!=""){ 
		$content.="City: ".$item->sp_city."<br/>"; 
	}
	if($item->sp_state!=""){ 
		$content.="State: ".$item->sp_state."<br/>"; 
	}
	if($item->sp_country!=""){ 
		$content.="Country: ".$item->sp_country."<br/>"; 
	}
	if($item->sp_email!=""){ 
		$content.="Email: ".$item->sp_email."<br/>"; 
	}
	$content.=$item->id."<br/>";


$logoexist=imageurl($item->sp_img_path,'sclogo','sp_profile');
$prodexist=imageurl($item->product_image,'','product');

	
	echo "<div class='col-xs-12 col-sm-4 col-md-3'>
                      <div class='coup_box'>";
				//echo "<form method='post' >";
					
				echo "<a href='";
				if($item->sp_website!=''){ 
					echo "http://".htmlspecialchars(urlencode($item->sp_website));
				} 
				echo "' target='_blank' ><img src='$logoexist' class='sp_logo img-responsive' style='height:83px;'/></a>";
				
				echo "<img src='$prodexist' class='sp_prod img-responsive'  style='height:140px;'/>";
				 
				echo "<div class='coup_txtbox' >
						<p class='couptxt1'>";
				if($item->sp_company!=''){  
					echo  '<font color=\'black\'>'.strtoupper($item->sp_company).'</font>'; 
				}elseif($item->sp_name!=''){
					echo  '<font color=\'black\'>'.strtoupper($item->sp_name).'</font>'; 
				}else{ 
					echo "<p class='couptxt1' style='visibility:hidden;' >NA</p>";
				} 
				echo "</p>";
				
				if($item->Sponser_product!=''){
					echo "<p class='couptxt1'>".strtoupper($item->Sponser_product)."</p>";
				} else { 
					echo "<p class='couptxt1' style='visibility:hidden;' >NA</p>";
				} 
				
				echo "<p><span class='couptxt2'>";
				if($item->discount!=0 or $item->discount!=0){ 
						echo $item->discount.'% Off'; 
				} 
				if($item->buy!=0 and $item->get!=0){ 
					if($item->discount!=0){ 
						echo ' Or ';
					} 
					echo 'Buy '.$item->buy.' Get '.$item->get.' Free'; 
				} 
				echo "</span> <br />";
				if($item->product_price!=0){ 
					echo "<span class='couptxt3'>MRP: ".$item->currency." ".$item->product_price."/-</span><br />";
				}else{
					echo "<span class='couptxt3'  style='visibility:hidden;'>MRP: ".$item->currency." ".$item->product_price." /-</span><br/>";
				} 
				echo "<span class='couptxt3'>(on $item->points_per_product points)</span></p>";
                if($item->saving!=0){
					echo "<p class='couptxt4'>SAVE ".$item->currency." ".$item->saving." /-</p>";
				}else{
					echo "<p class='couptxt4' style='visibility:hidden;'>SAVE ".$item->currency." ".$item->saving." /-</p>";
				} 

				echo "<p>
	<button type=\"button\" class=\"catbtn\"  data-container=\"body\" data-toggle=\"popover\" data-trigger=\"hover\" data-placement=\"top\" 
	data-viewport=\"\"
	data-html=\"true\" data-content=\"$content\">Description</button>						  				 
	<input type='hidden' name='id' value='$item->id'>
		<input type='hidden' name='points_per_product' value='$item->points_per_product'>
		<input type='button' name='select' value='Select' onClick=\"getThisCoupon('$item->id','$item->points_per_product')\" class='getcoubtn'";
						if(!($item->points_per_product <= $pts) ){ 
							echo 'disabled'; 
						} echo "/></p>";
						 //  </form>
					echo "<div class='clearfix' ></div>
                        </div>
                      </div>
                    </div>"; 
		}
		
		public function add_to_cart(){
			$proid=$this->input->post('id');
			$ppp=$this->input->post('ppp');
			
 			$this->load->model('coupons/coupons');
			
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);						
			$data['cart_items']=$this->coupons->cart_items($this->entity,$this->id);			
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
		
			if($data['rem_pts']>=$ppp)
			{
				$counter=$this->coupons->getCounters($proid);
				$total_coupons=$counter[0]->total_coupons;
				
					if($total_coupons!='unlimited' and $total_coupons!='NULL' and !$total_coupons<1 ){
						$total_coupons -=1;
						$this->coupons->updateTotalCoupons($proid, $total_coupons);
					}
					
				
				$daily_counter=$counter[0]->daily_counter;	
				
				if($daily_counter!='unlimited' and $daily_counter!='NULL' and !$daily_counter<1 ){
						$daily_counter -=1;
						$this->coupons->updateDailyCounterValue($proid, $daily_counter);
				}
				$i=$this->coupons->addCoupon($this->entity,$this->id,$proid,$ppp);
				echo 'Coupon added to cart';				
			}else{
				echo 'You Don\'t have enough balance points';
			} 
		}
		
		public function del_cart($id,$proid){
			$this->load->model("sp/sponsor");			
			$i=$this->sponsor->del('cart', $id);
			$this->load->model('coupons/coupons');	
				$counter=$this->coupons->getCounters($proid);
				$total_coupons=$counter[0]->total_coupons;
				
				if($total_coupons!='unlimited' and $total_coupons!='NULL' and !$total_coupons<1 ){
					$total_coupons +=1;
					$this->coupons->updateTotalCoupons($proid, $total_coupons);
				}				
				
				$daily_counter=$counter[0]->daily_counter;	
				
				if($daily_counter!='unlimited' and $daily_counter!='NULL' and !$daily_counter<1 ){
						$daily_counter +=1;
						$this->coupons->updateDailyCounterValue($proid, $daily_counter);
				}		
			
			redirect('Ccoupon/cart', 'location');		
		}
		
		public function cart(){
			$this->header();
			$this->load->model('coupons/coupons');			
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);						
			$data['cart_items']=$this->coupons->cart_itemsinfo($this->entity,$this->id);			
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
			
			$this->load->view('coupons/cart',$data);
			$this->footer();
		}	
		
		public function confirm_cart(){
			$this->load->model('coupons/coupons');			
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['cart_items']=$this->coupons->cart_itemsinfo($this->entity,$this->id);			
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
			if($data['rem_pts']>=0){		
				$school_id=$data['userinfo'][0]->school_id;
				
				if($this->entity=='student' or $this->entity=='Student'){
					$pts_green=$data['userinfo'][0]->green;
					$pts_yellow=$data['userinfo'][0]->yellow;
					$pts_purple=$data['userinfo'][0]->purple;
					$pts_water=$data['userinfo'][0]->water;					
					
					$deduct=$data['cart_items']['usedpts'][0]->usedpts;
					
					if($deduct > $pts_green){
						$deduct=$deduct-$pts_green;
						$pts_green=0;
						if($deduct > $pts_yellow){
							$deduct=$deduct-$pts_yellow;
							$pts_yellow=0;
							if($deduct > $pts_purple){
								$deduct=$deduct-$pts_purple;
								$pts_purple=0;
								if($deduct > $pts_water){
									$deduct=$deduct-$pts_water;
									$pts_water=0;
								}else{
									$pts_water=$pts_water-$deduct;
									$deduct=0;
								}
							}else{
								$pts_purple=$pts_purple-$deduct;
								$deduct=0;
							}
						}else{
							$pts_yellow=$pts_yellow-$deduct;
							$deduct=0;						
						}					
					}else{
						$pts_green=$pts_green-$deduct;
						$deduct=0;
					}
					$this->coupons->updateStudentPoints($this->id,$pts_green,$pts_yellow,$pts_purple,$pts_water);
					$entity=3;
				}elseif($this->entity=='teacher' or $this->entity=='Teacher'){					
					$pts_blue=$data['rem_pts'];
					$this->coupons->updateTeacherPoints($this->id,$pts_blue);
					$entity=2;
				}
				$sr=1;
				foreach($data['cart_items']['items'] as $key =>$value){					
					$cid=$value->coupon_id;					
					$ppp=$value->for_points;
					$time=$value->timestamp;
					$ts=explode(' ',$time);
					$date=$ts[0];
					$tm=$ts[1];
					
					$sp_id=$value->sponsor_id;
					$product=$value->Sponser_product;
					$valid_until=$value->valid_until;
					$coupon_code_ifunique=$value->coupon_code_ifunique;
					$company=$value->sp_company;
					$user_id=$this->id;
						if($coupon_code_ifunique=="" or $coupon_code_ifunique==NULL or $coupon_code_ifunique==0){
							$code1 = $company.$product.$user_id.$entity;							
							$a=rand(0,26);				
							$cpue=substr(md5($code1),$a,5);			
							$m1=time().$sr;
							$m=md5($m1);
							$b=rand(0,26);	
							$tsr=substr($m,$b,5);							
							$code2='SC'.$cpue.$tsr;
							$code=strtoupper($code2);
						}else{ 
							if($coupon_code_ifunique!=null){
							$code=$coupon_code_ifunique;
							}
						}
						$this->coupons->insertSelectedVendorCoupon($entity,$this->id,$cid,$ppp,$code,$sp_id,$valid_until,$school_id);
						$this->load->model("sp/sponsor");
						$this->sponsor->del('cart', $value->id);

					 $sr++;	
				}
				$this->unused_coupons();
				redirect('Ccoupon/unused_coupons');
			}else{
				echo '<script language="javascript">';
				echo 'alert("You Don\'t Have Enough Balance Points")';
				echo '</script>';
				redirect('Ccoupon/cart');
			}

		}
		
		public function unused_coupons(){		
			$this->header();
			$this->load->model('coupons/coupons');					
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);						
			$data['my_coupons']=$this->coupons->my_coupons($this->entity,$this->id);
			foreach($data['my_coupons'] as $key=>$value){
					$this->load->library('ciqrcode');
					$path='Assets/images/sp/coupon_qr/';
					$params['level'] = 'H';
					$params['size'] = 3;
					$params['data'] = $value->code;
					$params['savename'] = FCPATH.$path.$value->code.'.png';
					$this->ciqrcode->generate($params);	
			}
			
			$this->load->view('coupons/unused_coupons',$data);			
			$this->footer();
		}	
		
		public function used_coupons(){
			$this->header();
			$this->load->model('coupons/coupons');		
			$data['my_coupons']=$this->coupons->used_coupons($this->entity,$this->id);
/* 	foreach($data['my_coupons'] as $key=>$value){					
					$path='Assets/images/sp/coupon_qr/';					
					$params['savename'] = FCPATH.$path.$value->code.'.png';					
			}	 */		
			$this->load->view('coupons/used_coupons',$data);			
			$this->footer();
					
					
		}
		function set_qrcode($code)
		{
				$this->load->library('ciqrcode');
				$path='Assets/images/sp/coupon_qr/';					
				$params['data'] = $code;
				$params['level'] = 'H';
				$params['size'] = 3;
				$params['savename'] = FCPATH.$path.$code.'.png';
				$this->ciqrcode->generate($params);					
		}
		
		function email_coupons(){
			$this->load->model('coupons/coupons');					
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);						
			$data['my_coupons']=$this->coupons->my_coupons($this->entity,$this->id);
			$name=$data['userinfo'][0]->name;			
			
			$this->load->library('email');
			
			$config['protocol'] = "mail";
			$this->email->initialize($config);
			
			//->to('sudhirp@roseland.com')
			$this->email
				->from('rakesh@blueplanetsolutions.com', 'SmartCookie Admin')				
				->to($data['userinfo'][0]->email)
				->subject('SmartCookie Coupons')
				->message("Hello $name ,".$this->load->view('coupons/unused_coupons_template', $data, true))
				->set_mailtype('html');

				if (!$this->email->send()){
					//echo $this->email->print_debugger(); 				
					echo '<script language="javascript">';
					echo "alert('Email cant be send to ".$data['userinfo'][0]->email."'); ";
					echo "window.location='".base_url()."Ccoupon/unused_coupons';";
					echo '</script>';
					//redirect('Ccoupon/unused_coupons');
				}else{
					echo '<script language="javascript">';
					echo "alert('Coupons emailed to ".$data['userinfo'][0]->email."'); ";
					echo "window.location='".base_url()."Ccoupon/unused_coupons';";
					echo '</script>';
					
					//redirect('Ccoupon/unused_coupons');
				} 
		}
		
		public function use_now($sel_id,$school_id){
			$this->load->model('coupons/coupons');	
			$q=$this->coupons->use_now($sel_id,$school_id);
			if($q){
				redirect('Ccoupon/unused_coupons');
			}else{
				echo '<script language="javascript">';
				echo "alert('Error Occured ".$sel_id." ".$school_id."'); ";
				echo "window.location='".base_url()."Ccoupon/unused_coupons';";
				echo '</script>';
			}
			
		}
		
		public function suggested_sponsors(){
			$this->header();					
			$this->load->model("sp/sponsor");	
			$this->load->model('coupons/coupons');
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['categories']=$this->sponsor->categories('');				
			$data['states']=$this->sponsor->get_states($data['userinfo'][0]->country);
			$data['cities']=$this->sponsor->get_cities($data['userinfo'][0]->country,$data['userinfo'][0]->state);
			
			$this->load->view('coupons/suggested_sponsors',$data);			
			$this->footer();
			
		}
		
		public function suggested_list(){
			
			$this->load->model('coupons/coupons');	
					
		 	$lat=trim($this->input->post('lat'));
		 	$lon=trim($this->input->post('lon'));			
		 	$distance=trim($this->input->post('dist'));
		 	$catid=trim($this->input->post('cat'));
			$addr=trim($this->input->post('addr'));
		 	$country=trim($this->input->post('country'));
		 	$state=trim($this->input->post('state'));
		 	$city=trim($this->input->post('city'));
		 	$curr=trim($this->input->post('curr'));
			
			
 			if(!$curr){ //if the current location is selected then use lat lon else 
				$latlon=$this->calLatLongByAddress($country, $state, $city);
				$lat=$latlon[0];
				$lon=$latlon[1];
			}			
			
			$items=$this->coupons->suggested_sponsors($catid);
			
			
			$sr=0;
			$td=date("m/d/Y",time());			
					
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			

			foreach($items as $key=>$value){
				$valid=true;	
				$items[$key]->lat;
				$items[$key]->lon;
				
				$miles=$this->calculateDistance($items[$key]->lat, $items[$key]->lon, $lat, $lon);
					
				$kilometers = $miles * 1.609344;				
				if($kilometers > $distance){						
					$valid=false;
					continue;
				}	
				
				if($kilometers <= 0){
					$meters = $miles * 1609.34;
					$calculated_distance=round($meters,2)." Mtr";
					
				}else{
					$calculated_distance=round($kilometers,2)." Kms";
				}
				
				$is_liked=$this->coupons->is_suggested_liked($this->entity,$this->id, $value->id);		
				
				
				
				$this->suggested_sponsor($value, $calculated_distance, $is_liked);
				$sr++;				
				
			} 
			if($sr==0){
				echo "<div class='row'><div class=\"alert alert-info\" role=\"alert\" align=\"center\">
					<span class=\"glyphicon glyphicon-thumbs-down\" aria-hidden=\"true\"> &nbsp;&nbsp;&nbsp;&nbsp;
					</span><strong>There are no suggested sponsors for this location / category .</strong></div></div>";
			}	 

		}
		public function suggested_sponsor($item, $distance, $is_liked){

		
 	$content='';
	if($item->sp_address!=""){ 
		$content.="Address: ".$item->sp_address."<br/>";
	}
	if($item->sp_city!=""){ 
		$content.="City: ".$item->sp_city."<br/>"; 
	}
	if($item->sp_state!=""){ 
		$content.="State: ".$item->sp_state."<br/>"; 
	}
	if($item->sp_country!=""){ 
		$content.="Country: ".$item->sp_country."<br/>"; 
	}
	if($item->sp_email!=""){ 
		$content.="Email: ".$item->sp_email."<br/>"; 
	}
	$content.=$item->id."<br/>"; 

	//id,sp_name,sp_company,v_category,sp_phone,sp_email,sp_address,sp_state,sp_city,sp_country,v_status,v_likes,lat,lon

if($is_liked){ 
	$dis='disabled'; 
	$lk='Liked';
}else{
	$dis='';
	$lk='Like';
}					
					
					echo "<div class='col-xs-12 col-sm-4 col-md-3'>
							<div class='panel panel-violet'>
								<div class='panel-heading'>
									<span class='panel-title'>".$item->sp_company."</span>
									<p><small style='font-size:xx-small;'>(".$item->category.")</small></p>
									<button type=\"button\" class=\"btn btn-info btn-xs\"  data-container=\"body\" data-toggle=\"popover\" data-trigger=\"hover\" data-placement=\"top\" 
	data-viewport=\"\"
	data-html=\"true\" data-content=\"$content\"><span class='glyphicon glyphicon-info-sign'></span></button>
	<button class='btn btn-success btn-xs' onClick=\"likeThisSponsor('$item->id')\" ".$dis.">
	<span class='glyphicon glyphicon-thumbs-up'></span> ".$lk."
	<span class=''> ".$item->v_likes."</span>
	</button>
								</div>
							</div>
						</div>";
	
		}
		
		public function likeThisSponsor(){
			$sp_id=$this->input->post('id');
		
			if($sp_id==''){
				echo 0;
			}else{
				$this->load->model('coupons/coupons');
				$liked=$this->coupons->likeThisSponsor($this->entity,$this->id, $sp_id);	
				echo 1;
			}
		}

		public function suggest_sponsor(){
			$this->header();					
			$this->load->model("sp/sponsor");	
			$this->load->model('coupons/coupons');
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['categories']=$this->sponsor->categories('');				
			$data['states']=$this->sponsor->get_states($data['userinfo'][0]->country);
			$data['cities']=$this->sponsor->get_cities($data['userinfo'][0]->country,$data['userinfo'][0]->state);

			
			$data['catsel']='';
			$data['statesel']=$data['userinfo'][0]->state;
			$data['citysel']=$data['userinfo'][0]->city;
			
			$this->load->view('coupons/suggest_sponsor',$data);			
			$this->footer();		
		}
		
		public function suggest_new_sponsor(){
	
		$this->load->model('coupons/coupons');
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$config=array(
			array(
			'field' => 'name',
			'label' => 'Sponsor Name',
			'rules' => 'required|trim',
			'errors' => array(
                    'required' => 'Please Enter Sponsor Name<br/>',
			),
			),
			array(
			'field' => 'cat',
			'label' => 'Product Category',
			'rules' => 'required|trim',
			'errors' => array(
                    'required' => 'Please Select Product Category<br/>',
			
            ),
			),
			array(
			'field' => 'vendor_address',
			'label' => 'Sponsor Address',
			'rules' => 'required|trim',
			'errors' => array(
                    'required' => 'Please Enter Sponsor Address<br/>',
			
            ),
			),
						array(
			'field' => 'city',
			'label' => 'City',
			'rules' => 'required|trim',
			'errors' => array(
                    'required' => 'Please Select City<br/>',
			
            ),
			),
						array(
			'field' => 'state',
			'label' => 'State',
			'rules' => 'required|trim',
			'errors' => array(
                    'required' => 'Please Select State<br/>',
			
            ),
			),
						array(
			'field' => 'country',
			'label' => 'Country',
			'rules' => 'required|trim',
			'errors' => array(
                    'required' => 'Please Update Your Profile<br/>',
			
            ),
			),
						array(
			'field' => 'email',
			'label' => 'Product Discount',
			'rules' => 'trim|valid_email',
			'errors' => array(
                    'required' => 'Please Enter Valid Email<br/>',
			
            ),
			),
			array(
			'field' => 'phone_number',
			'label' => 'Phone Number',
		    'rules' => 'required|trim|regex_match[/^[0-9]$/]',
			'errors' => array(
                    'required' => 'Please Enter Phone Number<br/>',
			
            ),
			)
		);
		
		

		$this->form_validation->set_rules($config);		 
		if($this->form_validation->run()){	
			
			if($this->input->post('iscurrent')=='current'){
				$lon=$this->input->post('lon');
				$lat=$this->input->post('lat');
			}else{
				$latlon=$this->calLatLongByAddress($this->input->post('country'), $this->input->post('state'), $this->input->post('city'));	
				$lat=$latlon[0];
				$lon=$latlon[1];
			}				
		
			$this->coupons->suggest_new_sponsor($this->entity, $this->id, $lat, $lon);
			redirect('/Ccoupon/suggested_sponsors', 'location', 301);			
		}else{
			$data['catsel']=$this->input->post('cat');
			$data['statesel']=$this->input->post('state');
			$data['citysel']=$this->input->post('city');
						
			$this->header();
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['categories']=$this->sponsor->categories('');				
			$data['states']=$this->sponsor->get_states($data['userinfo'][0]->country);
			$data['cities']=$this->sponsor->get_cities($data['userinfo'][0]->country,$data['statesel']);			
			$this->load->view('coupons/suggest_sponsor',$data);			
			$this->footer();
			
		}


		
			
		}
		
		public function country_state(){
			$country=$this->input->post('country');
			$this->load->model('sp/sponsor');
			$get_states=$this->sponsor->get_states($country);
			$this->output->set_content_type('application/json')
						 ->set_output(json_encode($get_states));	 
		}
		
		public function country_state_city(){
			$country=$this->input->post('country');
			$state=$this->input->post('state');
			$this->load->model('sp/sponsor');
			$get_cities=$this->sponsor->get_cities($country,$state);
			$this->output->set_content_type('application/json')
						 ->set_output(json_encode($get_cities));
		}
		

	
	
}