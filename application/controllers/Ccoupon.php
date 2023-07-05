<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccoupon extends CI_Controller {
		
		public $id;
		public $entity;
		
		public function __construct(){
		  parent::__construct();
 			$this->load->library('session'); 
			//print_r($this->session->userdata());exit;
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
				echo "<script>alert('Your Session Has Been Expired. Please Login Again..');</script>";
				// VaibhavG I've Commented previous redirect code & added new redirection method to redirect home page while destroy the session for the ticket number SMC-3455 on 2Oct2018
				//redirect('Clogin/login', 'location');								
				redirect('Welcome','refresh');							
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
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
			//var_dump($data['userinfo']);exit;
			$data['cart_items']=$this->coupons->cart_items($this->entity,$this->id);
			$data['cart_items']['usedpts'][0]->usedpts;
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
			$data['categories']=$this->sponsor->categories('');	
			
			$data['states']=$this->sponsor->get_states($data['userinfo'][0]->country);
			$data['cities']=$this->sponsor->get_cities($data['userinfo'][0]->country,$data['userinfo'][0]->state);
			
			$this->load->view('coupons/coupons',$data);			
			$this->footer();
		}
		 public function get_curl_result($url,$data)
    {
           
        $ch = curl_init($url);          
        $data_string = json_encode($data); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $result = json_decode(curl_exec($ch),true);
      
        return $result;
    }
		public function getStatusRow(){
			$this->load->model('coupons/coupons');
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
			$data['cart_items']=$this->coupons->cart_items($this->entity,$this->id);
			$data['cart_items']['usedpts'][0]->usedpts;
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
			$this->load->view('coupons/my_points',$data);

		}
		
		public function calLatLongByAddress($country, $state, $city){	
			// Author VaibhavG for Ticket Number SMC-2576
			$addr=$city.", ".$state.", ".$country;
			//$addr=$country."".$state."".$city;
			//End SMC-2576
			$add= urlencode($addr);
			$geocode_selected=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$add.'&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY');
			$output_selected= json_decode($geocode_selected);
			$latlong=array();
			/*var_dump($output_selected);
			echo $output_selected->results[0]->geometry->location->lat;
			die;*/
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
			//new date format for ticket SMC-3473 On 26Sept18
			$date1 = DateTime::createFromFormat('Y-m-d H:i:s', trim($date1));
			$date_1 = $date1->format('Y-m-d H:i:s');

			$date2 = DateTime::createFromFormat('Y-m-d H:i:s', trim($date2));
			$date_2 = $date2->format('Y-m-d H:i:s');

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
			
			 
			if($this->input->post('curr')=='0')
			{ 
				$latlon=$this->calLatLongByAddress($country, $state, $city);
				$lat=$latlon[0];
				$lon=$latlon[1];
			}
			/* //new code but not used yet for ticket SMC-2576
			if($this->input->post('curr')=='0')
			{
				$latlon=$this->calLatLongByAddress($country, $state, $city);
				if(isset($latlon[0]) && isset($latlon[1]))
				{
					$lat=$latlon[0];
					$lon=$latlon[1];
				}
				else
				{
					$lat="";
					$lon="";
				}
			}*/
			
				$items=$this->coupons->coupon_list($catid);
			
			
			$sr=0;
			//previous date format
			//$td=date("Y-m-d",time());
			//new date format used for display coupon list for ticket SMC-2576
			//$td=date("m/d/Y");
			//new date format for ticket SMC-3473 On 25Sept18		
			$td = CURRENT_TIMESTAMP;
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);						
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
					if($valid){
					$this->coupon($items[$key], $calculated_distance, $pts);
					$sr++;					
					}
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
			
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);						
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
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
			
			$data['cart_items']=$this->coupons->cart_itemsinfo($this->entity,$this->id);
//echo "<pre>";
 //die(print_r($data['cart_items'],true));			
			$data['rem_pts']=$data['userinfo'][0]->totat_pts-$data['cart_items']['usedpts'][0]->usedpts;
			
			$this->load->view('coupons/cart',$data);
			$this->footer();
		}	
		
		public function confirm_cart(){
			$this->load->model('coupons/coupons');			
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
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
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);						
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
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);						
			$data['my_coupons']=$this->coupons->my_coupons($this->entity,$this->id);
			$name=$data['userinfo'][0]->name;			
			
			$this->load->library('email');
			
			$config['protocol'] = "mail";
			$this->email->initialize($config);
			//modified email address as admin@smartcookie.in as per dsicussed with Rakesh Sir, for SMC-4387 by Pranali on 18-1-20
			//->to('sudhirp@roseland.com')
			$this->email
				->from('admin@smartcookie.in', 'SmartCookie Admin')				
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
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
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
			//new date format for ticket SMC-3473 On 25Sept18
			//$td=date("Y-m-d",time());			
			$td = CURRENT_TIMESTAMP;		
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
			

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
				//Message changed by Pranali for bug SMC-3375
				echo "<div class='row'><div class=\"alert alert-info\" role=\"alert\" align=\"center\">
					<span class=\"glyphicon glyphicon-thumbs-down\" aria-hidden=\"true\"> &nbsp;&nbsp;&nbsp;&nbsp;
					</span><strong>There are no suggested sponsors. Please, select any other location / category .</strong></div></div>";
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

		public function suggest_sponsor()
		{
			$baseurl=base_url();
			$this->load->library('form_validation');
			$this->header();					
			$this->load->model("sp/sponsor");	
			$this->load->model('coupons/coupons');
			/**
			author : vaibhavg
			added 2 more parameter as student PRN & student school id for getting actual student information 
			*/
			//$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id);
			$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
			$data['categories']=$this->sponsor->categories('');	
			/*
			author : vaibhavg
			called countryCode function here for Ticket Number SMC-3262 10Sept2018 6:30PM
			*/
			$data['countrycode']=$this->coupons->countryCode();
			$data['states']=$this->sponsor->get_states($data['userinfo'][0]->country);
			$data['cities']=$this->sponsor->get_cities($data['userinfo'][0]->country,$data['userinfo'][0]->state);

			
			$data['catsel']='';
			$data['statesel']=$data['userinfo'][0]->state;
			$data['citysel']=$data['userinfo'][0]->city;
			
		     $this->form_validation->set_rules('name', 'Sponsor Name', 'required|alpha_numeric_spaces|min_length[3]');
				$this->form_validation->set_rules('company', 'Company Name', 'required|alpha_numeric_spaces|min_length[3]');
				$this->form_validation->set_rules('cat', 'Sponsor Category / Type', 'required|callback_select_val['.$this->input->post('cat').']');
				$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|numeric|exact_length[10]');
				/*
				author : vaibhavg
				apply countryCode validation for Ticket Number SMC-3262 10Sept2018 6:30PM
				*/
				$this->form_validation->set_rules('countryCode', 'Country Code', 'required');
				 $this->form_validation->set_rules('email', 'Email ID', 'ltrim|rtrim|valid_email');
				 $this->form_validation->set_rules('state', 'Select State', 'required|callback_select_val['.$this->input->post('cat').']');
				 $this->form_validation->set_rules('city', 'Select City', 'required|callback_select_val['.$this->input->post('cat').']');
				$this->form_validation->set_rules('vendor_address', 'Address', 'required');
	 
	
			if($this->form_validation->run()!=false)
				{	
					if($this->input->post('iscurrent')=='current')
					{
						
						 $lon=$this->input->post('lon');
						 $lat=$this->input->post('lat');
						
					}
					else
					{
						$latlon=$this->calLatLongByAddress($this->input->post('country'), $this->input->post('state'), $this->input->post('city'));	
						 $lat=$latlon[0];
						 $lon=$latlon[1];
					}				
						$school_id=$this->session->school_id;
						/* Author VaibhavG
						* here I've checked input parameters with trim for Ticket Number SMC-3262 7Sept2018 6:03PM
						*/
							$sp_name =trim($this->input->post('name'));
						   $sp_company= trim($this->input->post('company'));
						   $v_category =  trim($this->input->post('cat'));
						   $country_code =  trim($this->input->post('countryCode'));
						   $sp_phone =  trim($this->input->post('phone_number'));
						   $sp_email =  trim($this->input->post('email'));
						   $sp_address =  trim($this->input->post('vendor_address'));
						   $v_status =  'Inactive';
						   $sp_city =  trim($this->input->post('city'));
						   $sp_state =  trim($this->input->post('state'));
						   $sp_country =  trim($this->input->post('country'));
		   					
		   					 $newspaper=$this->input->post('newspaper');
                  $justdial=$this->input->post('justdial');
                  $inserts=$this->input->post('inserts');
                  $monthly_budgets=$this->input->post('monthly_budgets');
                  
                  $curent_marketing = array($newspaper,$justdial,$inserts,$monthly_budgets);
                                    
                  $curr_market=implode(",",$curent_marketing);
                   $curr_market="[".$curr_market."]";
                  
                  $curr_marketing = array("Newspaper","Just Dial","Inserts","Monthly Budgets");
                  
                  $curr_marketing = implode(",",$curr_marketing);
                   $curr_marketing="[".$curr_marketing."]";
                  
                 $website=$this->input->post('website');
                 $facebook=$this->input->post('facebook');
                  $twitter=$this->input->post('twitter');
                  $zomato=$this->input->post('zomato');
                  $food_panda=$this->input->post('food_panda');
                  $swiggy=$this->input->post('swiggy');
                  $own_app=$this->input->post('own_app');
                  
                  $digital_marketing = array($website,$facebook,$twitter,$zomato,$food_panda,$swiggy,$own_app);
                   //print_r($digital_marketing);
                  $digital_market=implode(",",$digital_marketing);
                  $digital_market="[".$digital_market."]";
                  
                  $dig_marketing = array("Website","Facebook","Twitter","Zomato","Food Panda","Swiggy","Own App");
                  $dig_marketing=implode(",",$dig_marketing);
                  $dig_marketing="[".$dig_marketing."]";
                  
                  $own_coupons=$this->input->post('own_coupons');
                  $coupon_dunia=$this->input->post('coupon_dunia');
                  $freecharge=$this->input->post('freecharge');
                  
                  $discount_coupons=array($own_coupons,$coupon_dunia,$freecharge);
                  
                  $dis_coupons=implode(",",$discount_coupons);
                  $dis_coupons="[".$dis_coupons."]";
                  
                  $discount_coupons1=array("Own Coupons","Coupon Dunia","Freecharge");
                  
                  $discount_coupons1=implode(",",$discount_coupons1);
                  $discount_coupons1="[".$discount_coupons1."]";  
        if($this->input->post('discount')==''){
          $idiscount=0;
        }else{
          $idiscount=$this->input->post('discount');
        }
        
        if($this->input->post('points')==''){
          $pointsd=0;
        }else{
          $pointsd=$this->input->post('points');
        }
        if($lat=='' || $lon=='')
        {
        	$lat="17.82576746";
        	$lon="75.45724065";
        }
        else
        {
        	$lat=$lat;
        	$lon=$lon;
        }
       // echo $lat.''.$lon;exit;
  $url=$baseurl."core/Version5/salesperson_sponsor_registration_webservice1_v7.php";
            $data = array(
            "current_marketing"=> $curr_market,
            "discount"=> $dis_coupons,
            "digital_marketing"=> $digital_market,
            "User_Name"=> $sp_name,
            "Company_Name"=> $sp_company,
            "sp_phone"=> $sp_phone,
            "User_email"=> $sp_email,
            "User_pass"=> $sp_email,
            "Lattitude"=> $lat,
            "Longitude"=> $lon,
            "sp_address"=> $sp_address,
            "city"=> $sp_city,
            "state"=> $sp_state,
            "country"=> $sp_country,
            "sp_product_category"=> $v_category,
            "sales_p_lat"=> $lat,
            "sales_p_lon"=> $lon,
            "school_id"=> $school_id,
            "v_responce_status"=> "Suggested",
            "sales_person_id"=> "",
            "country_code"=> $country_code,
            "pin"=> "",
            "User_Image"=> "user.jpg",
            "User_imagebase64"=> "iVBORw0KGgoAAAANSUhEUgAAAOAAAADgCAMAAAAt85rTAAAAYFBMVEX////e3t6vr697e3t+fn7Q0NCsrKx3d3e8vLy3t7fOzs7AwMC2traxsbHS0tLFxcXo6Ojv7+/09PTz8/Pd3d2enp7q6upxcXGUlJSDg4OLi4uPj4+np6eNjY2goKBra2uLzSdZAAAM6ElEQVR4nO2dibKiOhCGwUSCoCFsEXC57/+WtzsbAdTRqfGIp/JXTQ2iePqzO93ZxCgKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCvoG1RJUV582422qGg5qmjgWovyNmJJP1DSA+as4Yz7XdgucMUTt7wBdAvqcQsryu9unboJ3ITVmo9rnd3LWj/icLxHTtM9PG/yqSmX+s8pQ/KvykHyFT0l9IhmXn7b8STlAztE7L3B+iQ+FtVdCVZBxw3UYOtIJcvZ9gFWjeTJrb1XVJXJy0+Du6lsAubG3mdpblVII8Qi0+ZDFL6q25sc3n0Z3SikazheA4oct/UvV2UNAKwUqYp/zS7Jo/ZJDIHCbLwMsixcjTljA8q12/TOJVx0Sm0+E12+165+p0fYW2ycdUjUW8DuqRMQLUFYUz9pbqgtAX1IlKnDeS/YK8/ricdZdjeriRXtje8GXlMHyVcDGXvAlSVS+6hDbBLMvyTHxqw5xgG8169/J2ftsVcu+DNDa+3SVcBe8165/pap4wV4JH4KwF3xJGbQ5Jn+io8YRKn7hgs+qkphWRG40sfdGuNa8yHMoJdxe8ENm/p2qUsRxjIUhtvZ6SbTk28UFDeDlxXcA1lIgXtwgYGPtHZOoyPJ81sDEFvlyrJWZeX3xs0Y/KweH/zAqrUMKG5UqFFUwOkmNt3rASiq2URK72sZe2y+JLYtrk6ULyhw6A5V5Pl9E8adVzehAJfZEjb26SpRbB2OIS17k/jmXlFZXJcoFX6yqmjY3VT1RkY0wqUKG59PxVOO12dWNJWRzC9Am0VSqWEw9wLSpxeRMnsY3k9JKtABUSTROtaAMVpk9tv8X9sgKruDmBfnqxhKLEFVJtLEwpTt8IKkBUcXqAOt47kIs7c7eOsruYU0A7atWOBpcZNE6GsMSBkvFH/nAa7V91QrHEvIGYOnsrSLV4HYP+HZQ+qRtliuccVo0Qggyme6UsACYwwfCKmEvWF2VgHCc8Qksg7vR3j/y7Wtss/p4lYOlZUctEnsHWP0ZsII2aw6L1ZXBaN4IG0yisQGEfoncox4SKsC9BlxfEl00QlUl9lo4pRbDmCHdIeT+lnb7FAAL82iVM06z7jZWCWuvjjhctI4bnhnQucBrZW6OV1glojFGGwdo7c387UuVGjPyLWIeDgcHuMWenTle3VhCqZ4n0dI6Ki2yjMfTzKgX5yFwNecBvcbNBbsVlsFoVihUlVAeOhy0nyDX5EWRNfF0jruWolFxix01/eJDutJ1CT+PqgkZQzcRkqZFwWfb7ipspoV5zVpnnPw8ivG4XeKNnDsYL6ltd3LkzFcO6DdCDLJi84DQ+TMv1H5RCS5MzdkVzjgpVW5GTQPmD9lG4ecADs0KG9GrLIMorxFildht/uxCB4myD9ZZJaJJI8SxhLb6dR1WOJbQGgsFVon48LwDjRdNxK6xJ6rlemvoA/6XDtwcPo1xXzZG1YxTtvnLGN1/GuO+Ki/HREXyGley0Rck6acx7msCmCfOZouQPMGcJKutEtFYKDBNFAkKIa3Go4dabZWIRhcioNifUc9BedqstkqgxiQa4dAPx/H7w5OeM1pxlYhcoZgOcNU4frd/knO/asBy7GtPpRZ/myzfbZLHcXtea1dbyzZCcec7czCQL0VcpPskOd9uouc1J9HZ1JMQQt75NllVCojbHOPW54T/z+uccXJarFEoTHnn22SQhvg2g0S0GR266iQ6m3qacgLmHc5axk0DDXS/OScrXDmbaL5GMZN8ZL7aQLRyvlvbLTwnft/3O5e6sd/CROgaV1T+Qrdi9G4y/UotXfeL4FCTRvgrWt1M9RiYvw9OSfyahHlP9ZffvCEoKCgoKCgoKCgoKCgoKCgoKCgoKOgXqcgy98UinhXedyEEzzIuFjPaePNGs62gnNySUeJbjdfX/Mb9GiuB98njjVm2r73bPL5rJf8/xo47c9yxo9vT0my6nrD+dJ1vAilbxlp9yBnoYp/YHeGtxv31DYEn28kaaVVcT/CmjAyd/pNxz6zIu3bmHymlvfn0OsIsTtoTgqYQQtvpBWVLyFUfcriWEuu0gcCDce/rjuCzvl/ijhIjdtZnBupOvWu7EAJag0fAhFEybLJsA1azdhKmC0CzG7RRDxxg3RIK7+eZzSmBN+02h8O5GzILSFrzVZp3bUk80r4nA58CZkf4w+r7RgLsJJMtyR5gTuhlIMbDO9KfvJcKQroc/rnr1AdwMF9iMlvDAJC9e6PXkZ7OQKPaigUsT4ScTHCJE6GD/+l6gDtCkpYM6pV1xzp47OI5ZySJGWV2k1vVkSVMPJD3A5JTDE5SYBYwh1hzfxceMD8BeIApmLchVL206UnC2egxfK+qp65Rb4FvsTn9RwAprfeM0ioaAc+jA8GF0E6uXjL0AM9gXkHJGa+F9+AeYAlBXuIb2RNw1bCoBD8TokzW4LEkcoCyI9poLYitwSuPHuAVAONefRhwDa2zERAiFHJTAZ+cjlGIdJIsaip4kKRVDSrftucGAaMdUwndAMaXSV5JyCTbTwAhkiHPQoqKoR1HAHgxba4lDLKr6KkO4KhBFHVUC6XaAp6uSskbAUUkLuAzB8h7SryvOhwIvuQGYNWSfotxukePQaxljBpA2StsfK2ueFlvg5FfTqBLoQFtHWSntwJCwieQKg1gMwXc3wMsO9JzdBsEIzizgkRiPZhR0mFYp+AhOQOE3gMlOm95hf7NgCU2O4wrBBRQzzbjK65Q7W62wVoBVgxbMUNPQSYddKFLILvgnW8T6Capuzk1g+0RNG3b9tQCjn2n9wLCR077eDcmmdZt0q4gPXT+XdQcoFSA6HfIn3glAqqSKTp0EvYwqSkOmGRcLobYHgF/IIuq+AMz94n5PCGt9K62Q4tk/pePRsD4Qi6xSpiHDemlB4itGPmOQGg+q9Z7T3D9zwM2RzqYEI0K6sUoJlF/17UHeFIVQkBxGJR7XIhC07vEJajGq80p6ro5HwFUbrMdD/i4be8F+pt+UfQBIfUjIASc6flgZOL/ukXr17gOOORVdtZB6gH+SKHXgBKHOwYQqjc9boQsBdQIcpn0QEbATNd4TLMqVh2g6/sBPVS6Tn0+vMfBRAGOlfw0epDsdV0U77ohiwNEX7muIwda0kO6Q6OmXwsYAbe9zj4QmeSKENIA5gz7aVpneAf9B7IBTjPatl1P6Vgm+kGpP79pN9yRHg0gJk+XtJuW6QLMrrMeJALqxoTFDmMOM6SyFzyoDjqvrHGoImbEKA6MmbJupg5iNUjWp9o3ddZY74bkRd/TsSo1h64frss72pVXSrUHYZyhrcrbs3qZhAIHCbcmPR2/EwnjTUdbFYd26Ntzam6gG596K3oN+xmDgoKCgoKCgv6s2v7AAMhbDmvwl2y8nhv+MIM9djfrr3I4rNxZfWvfuuHqVxz4Sn6CUJzcohazI4ly38LYjfSnjbWxOjPW20uOjOl5v/I/6FAX7uxRDXY59DVxqaofulV8JRuHdXayywDiwM3Ijp4qGAg5QGanAEpGzYSaOquHYhmeNO9Iu893qnHU05kbg+pJMhjx0f5a8OIKQz8z4rgPSMnOnmXq+i0cFFIKjqtxN2bwf1qicyZq4RREr+Muw4GwsvAu4ODmAHxA7dQGxlrkXUPbp4UenNzEB8f6doFpx8x66T1A0p3tAq4PaEfVOLv26TsHgAcnE4UVxOVgH9Q4CEcX3AE8ki4+GrAbgDjFfWMV5mc192DD3Dp1pF2Ik9X3ACnFVbNen3WAdl4EF0In88ifEAL6bTAFQ8c1XsRF/Ltt8BjF0NDy6LYHcRaq/3CawTLRmXvwG5OOY1AJiDFsYg8Aq4SQU3kHcLaW8wm5lQUQPoaHR+/ZQU8bPgBUc6DpugGt8PEckC4ByRQw2qhF8JuAh+l66ieEbfBqfpPdmMTGtIDT1phyKptKUH6SQUD4FFga9bcAW7tk+DnNs2gO9o0/2VIwswXjMA1RnZaMBzHXDnVLloC4ReXTU6BzQMHGhSG1MKPn5YG7N66Qbg+MBYTayYpbgIXJsJ/UHBD38PT2PstYJfRWCg6NyTi2AGj9AguIHeyhI5rL78lAN/D06c7ooqvGqbOqxPyjWXAtQ48bJCRWs7TgAFUTXfRF1c6wj9/qcAFY7YHwkgkpsotnoFrTbKTknRtijIC4lYF6gLyUoknVIuGn+9pLQKjcEJjk1J5wQOfuA1e2ao2tw7GePTkCQqnwAEmHy2Y4KEw+f5sd0RE2uyVolROm170Gb0heXo9mNcxFHXS2LWAMfXQ9os+Odpso69bwc8PiOgyLdlIVh9Ol3c1GOmJ/vZzO3q9JlP3gakc6DLrX2Zzb4TJcrptv+SXXoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoF+k/wHhBgFzuFSBLgAAAABJRU5ErkJggg==",
            "sponsor_shop_Image"=> "shop.jpg",
            "sponsor_shop_imagebase64"=> "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"

                      );

      // print_r($data3);//exit;

            $sponser= $this->get_curl_result($url,$data);
            //print_r($sponser);exit;
        
						// 	$where = "sp_name='$sp_name' AND sp_company='$sp_company' AND v_category='$v_category' AND  CountryCode='$country_code' AND sp_phone='$sp_phone' AND sp_email='$sp_email' AND sp_address='$sp_address' AND v_status='$v_status' AND sp_city='$sp_city' AND sp_state='$sp_state' AND sp_country='$sp_country'";
							
						// $i=$this->coupons->suggest_new_sponsor($this->entity, $this->id, $lat, $lon,$school_id,$where,$sp_name,$sp_company,$v_category,$country_code,$sp_phone,$sp_email,$sp_address,$v_status,$sp_city,$sp_state,$sp_country);
						
						if($sponser)
						{
							//message changed by Pranali for bug SMC-3376
							$this->session->set_flashdata('success_suggest_new_sponsor', 'Suggested New Sponsor Added Successfully!');
						}
						else 
						{	
							$this->session->set_flashdata('error_suggest_new_sponsor', 'Sponsor Already Suggested!');
						}
					
					redirect('/Ccoupon/suggested_sponsors', 'location', 301);			
				}

			$this->load->view('coupons/suggest_sponsor',$data);			
			$this->footer();		
		}
		
		public function select_val($abcd)
	{
		// '-1' is the first option that is default "-------Choose ------"

					if($abcd=="0")
					{
						$this->form_validation->set_message('select_val', 'Please select some value');
						return false;
					}
					else
					{
						// User picked something.
						return true;
					}

		
	}

		/**
			author : vaibhavg
			no need function suggest_new_sponsor() rather this function we used function suggest_sponsor()
		/*
		public function suggest_new_sponsor()
		{
			
			$this->load->model('coupons/coupons');
			$this->load->model("sp/sponsor");	
			$this->load->helper('form');
			$this->load->library('form_validation');
		
		
			if($this->input->post('submit'))
			{
				$this->form_validation->set_rules('name', 'Sponsor Name', 'required|alpha_numeric_spaces|min_length[3]');
				$this->form_validation->set_rules('company', 'Company Name', 'required|alpha_numeric_spaces|min_length[3]');
				$this->form_validation->set_rules('cat', 'Sponsor Category / Type', 'required|callback_select_val['.$this->input->post('cat').']');
				$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|numeric|exact_length[10]');
				 $this->form_validation->set_rules('email', 'Email ID', 'ltrim|rtrim|valid_email');
				 $this->form_validation->set_rules('state', 'Sponsor Address', 'required|callback_select_val['.$this->input->post('cat').']');
				 $this->form_validation->set_rules('city', 'Sponsor Address', 'required|callback_select_val['.$this->input->post('cat').']');
				$this->form_validation->set_rules('vendor_address', 'Address', 'required');
	 
				if($this->form_validation->run()!=false)
				{	
					if($this->input->post('iscurrent')=='current')
					{
						
						 $lon=$this->input->post('lon');
						 $lat=$this->input->post('lat');
						
					}
					else
					{
						$latlon=$this->calLatLongByAddress($this->input->post('country'), $this->input->post('state'), $this->input->post('city'));	
						$lat=$latlon[0];
						$lon=$latlon[1];
					}				
						$school_id=$this->session->school_id;
						$i=$this->coupons->suggest_new_sponsor($this->entity, $this->id, $lat, $lon,$school_id);
						if($i)
						{
							$this->session->set_flashdata('success_suggest_new_sponsor', 'Suggest New Sponsor Added Successfully!');
						}
						else 
						{	
							$this->session->set_flashdata('error_suggest_new_sponsor', 'Suggest New Sponsor Not Added Successfully!');
						}
					
					redirect('/Ccoupon/suggested_sponsors', 'location', 301);			
				}
				else
				{
					$data['catsel']=$this->input->post('cat');
					$data['statesel']=$this->input->post('state');
					$data['citysel']=$this->input->post('city');
								
					$this->header();
					
					$data['userinfo']=$this->coupons->getuserinfo($this->entity,$this->id,$this->std_PRN,$this->school_id);
					$data['categories']=$this->sponsor->categories('');				
					$data['states']=$this->sponsor->get_states($data['userinfo'][0]->country);
					$data['cities']=$this->sponsor->get_cities($data['userinfo'][0]->country,$data['statesel']);			
					$this->load->view('coupons/suggest_sponsor',$data);			
					$this->footer();	
				}
			}
		}*/
		
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
