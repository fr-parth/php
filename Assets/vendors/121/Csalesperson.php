<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Csalesperson extends CI_Controller {	
	public $id;
	public $entity;
	
	public function __construct(){
      parent::__construct();
  	   $this->load->library('session'); 
	   $this->id=$this->session->id;
	   $this->entity=$this->session->entity;
	   
	   if($this->entity!='salesperson'){
		   redirect('/welcome', 'location', 301);
	   } 

	 // $this->id=19;
	 //  $this->entity='salesperson';
	 
	   
		$this->load->library('form_validation');
		$this->load->library('TwilioRestClient');
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('slp/Msalesperson');
		$this->load->model('sp/sponsor');
    }

	public function index()
	{ 			
		$this->page('RegisteredSponsorsList');	
	}	
	
	public function page($page){			
		$id=$this->id;
		$data= $this->headerData($id);
			switch($page){
				case 'RegisteredSponsorsList':					
					$data['RegisteredSponsorsList']= $this->Msalesperson->RegisteredSponsorsList($id);
					$data['count_RegisteredSponsorsList'] = count($data['RegisteredSponsorsList']); 
				break;
				case 'SMSPanel':					
					$data['error']='';
					$data['Output']='';
				break;
				case 'sponsor_map':
					//$data['map_init']= $this->sponsor->map_init($id);					
					$this->load->library('googlemaps');		
					$config = array();
					$config['center'] = 'auto';
					$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|F4F6F7|000000';
					$config['zoom'] = '13';
					$config['onboundschanged'] = 'if (!centreGot) {
						var mapCentre = map.getCenter();
						marker_0.setOptions({
							position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 
						});
					}
					centreGot = true;';
					
					$this->googlemaps->initialize($config);
				
					$marker = array();
					$location=$this->Msalesperson->nearby_sponsors();
					foreach($location as $key =>$value){					
						$marker['position'] = ''.$location[$key]->lat.','.$location[$key]->lon.'';						
			
						if($location[$key]->sales_person_id==$id){
								$marker['draggable'] = false;								
								$marker['infowindow_content'] = "SP".$location[$key]->id."<br/>".$location[$key]->sp_company;
								//$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
								$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|A569BD|000000';
						}elseif($location[$key]->v_status=='Inactive'){
							$marker['draggable'] = false;
							$marker['infowindow_content'] = "SUG".$location[$key]->id."<br/>".$location[$key]->sp_company;							
							$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|F5B041|000000';
						}else{
							$marker['draggable'] = false;
							$marker['infowindow_content'] = "SP".$location[$key]->id."<br/>".$location[$key]->sp_company;
							$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|EC7063|000000';
						}
						$this->googlemaps->add_marker($marker).'';
					}		

					$schools=$this->Msalesperson->nearby_schools();
					foreach($schools as $key =>$value){
						//$marker = array();						
						$marker['position'] = ''.$schools[$key]->school_latitude.','.$schools[$key]->school_longitude.'';
						$marker['infowindow_content'] = "SCH ".$schools[$key]->school_mnemonic."<br/>".$schools[$key]->school_name;
						$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=I|009900|000000';
						$this->googlemaps->add_marker($marker).'';				
					}
					
					$data['map'] = $this->googlemaps->create_map();		
					$data['location']=$location;
					break;
				case 'RegisterSponsor':						
					$data['error']='';
					$data['categories']=$this->sponsor->categories('');
					$data['countries']=$this->sponsor->countries();
					break;
			}

		$this->load->view('slp/'.$page,$data);
		$this->load->view('slp/footer');
	}
	

	public function headerData($id){
		$data['img_path']="./Assets/images/slp/profile/";		
		$data['user']= $this->Msalesperson->headerData($id);
		return $data;   
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/welcome', 'location', 301);
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
	
	public function calLatLongByAddress($country, $state, $city, $address){	
		$addr=$address.", ".$city.", ".$state.", ".$country;
		$add= urlencode($addr);
		$geocode_selected=@file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$add.'&sensor=false');
		$output_selected= @json_decode($geocode_selected);
		$latlong=array();
		$latlong[0] = @$output_selected->results[0]->geometry->location->lat;
		$latlong[1] = @$output_selected->results[0]->geometry->location->lng;
		return $latlong;	
	}
	
	public function SMSPanel(){
		$data= $this->headerData($this->id);
		
		$this->form_validation->set_rules('CountryCode', 'CountryCode', 'trim');	
		$this->form_validation->set_rules('sp_phone', 'Mobile', 'trim|is_numeric|max_length[15]');
		$this->form_validation->set_rules('sp_email', 'Email', 'trim|valid_email|max_length[60]');			
		$this->form_validation->set_rules('sp_message', 'Message', 'required|trim');

		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');	

		$data['error']='';
		$data['Output']='';
	
		if ($this->form_validation->run() == FALSE or $data['error']!='') // validation hasn't been passed
		{			
            $this->load->view('slp/SMSPanel', $data); 			
		}
		else 
		{	
			if($this->input->post('sp_email')!=""){				
						//mail
								$this->load->library('email');
								$config['protocol'] = "mail";
								$this->email->initialize($config);		
								
								$this->email
									->from('rakesh@blueplanetsolutions.com', 'SmartCookie Admin')				
									->to($this->input->post('sp_email'))								
									->subject('SmartCookie')
									->message($this->input->post('sp_message'))
									->set_mailtype('html');										
								if (!$this->email->send()){
									echo "error";die;
								}else{									
									$data['Output'].="<br/>"."Mail Sent to ".$this->input->post('sp_email');
								}					
			}
					
			if($this->input->post('sp_phone')!='' and $this->input->post('CountryCode')!=''){
					$phone=$this->input->post('sp_phone');	
					$CountryCode=$this->input->post('CountryCode');	
					
					if($CountryCode==91){		
						/*Below getdynamic function added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$dynamic=$this->Msalesperson->getdynamic();		
						$dynamic_user=$dynamic[0]->mobileno; 
						$dynamic_pass=$dynamic[0]->email; 
						$dynamic_sender=$dynamic[0]->otp; 
						$Text=urlencode($this->input->post('sp_message'));			
						$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";						
		
						$data['Output'].="<br/>".file_get_contents($url);
						
					}else{
						$ApiVersion = "2010-04-01";
						// set our AccountSid and AuthToken
						$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
						$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
						// instantiate a new Twilio Rest Client
						$client = new TwilioRestClient();
						$number='+'.$CountryCode.$phone;
						$message=$this->input->post('sp_message');	

						$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
						"POST", array(
						"To" => $number,
						"From" => "732-798-7878",
						"Body" => $message
						));
						
						$data['Output'].="<br/>"."Message Sent to : ".$number;
					}
				$this->load->view('slp/SMSPanel', $data); 						
			}			
			
		}
	}
	
	public function editSponsor($id){
		$data= $this->headerData($this->id);
		$this->load->model('sp/sponsor');
		$data['categories']=$this->sponsor->categories('');
		$data['countries']=$this->sponsor->countries();	
		
		$data1=$this->Msalesperson->getSponsorByID($id);
		$data=$data1[0];
		
		print_r($data);
		
		//$data['states']=$this->sponsor->get_states($this->input->post('sp_country'));
		//$data['cities']=$this->sponsor->get_cities($this->input->post('sp_country'),$this->input->post('sp_state'));
		
		$data['states']=$this->sponsor->get_states($data['sp_country']);
		$data['cities']=$this->sponsor->get_cities($data['sp_country'],$data['sp_state']);
		
		
		$this->load->view('slp/RegisterSponsor', $data); 
	}
		
	public function RegisterSponsor()
	{		
		$data= $this->headerData($this->id);
		$this->load->model('sp/sponsor');
		$data['categories']=$this->sponsor->categories('');
		$data['countries']=$this->sponsor->countries();			
		$data['states']=$this->sponsor->get_states($this->input->post('sp_country'));
		$data['cities']=$this->sponsor->get_cities($this->input->post('sp_country'),$this->input->post('sp_state'));
		
		$this->form_validation->set_rules('sp_company', 'Company', 'required|trim|max_length[50]');			
		$this->form_validation->set_rules('sp_phone', 'Mobile', 'required|trim|is_numeric|max_length[15]|is_unique[tbl_sponsorer.sp_phone]');			
				
		$this->form_validation->set_rules('sp_landline', 'Landline', 'trim|is_numeric|max_length[20]');			
		$this->form_validation->set_rules('sp_email', 'Email', 'trim|valid_email|max_length[60]|is_unique[tbl_sponsorer.sp_email]');			
		$this->form_validation->set_rules('v_category', 'Product Category', 'required|trim|max_length[30]');			
		$this->form_validation->set_rules('sp_website', 'Website', 'trim|max_length[60]');			
		$this->form_validation->set_rules('sp_address', 'Address', 'required|trim|max_length[255]');			
		$this->form_validation->set_rules('sp_country', 'Country', 'required|trim|max_length[50]');			
		$this->form_validation->set_rules('sp_state', 'State', 'required|trim|max_length[50]');			
		$this->form_validation->set_rules('sp_city', 'City', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('sp_password', 'Password', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('sp_password1', 'Confirm Password', 'required|trim|max_length[50]|matches[sp_password]');
		$this->form_validation->set_rules('amount', 'Registration Cost', 'is_natural|trim|max_length[10]');
		$this->form_validation->set_rules('source', 'Source', 'trim|max_length[60]');		
		$this->form_validation->set_rules('v_status', 'Status', 'required|trim|max_length[20]');
		
		$this->form_validation->set_rules('discount', 'Discount', 'is_natural|trim|max_length[3]');
		$this->form_validation->set_rules('points', 'Points', 'is_natural|trim');
		
		
		$this->form_validation->set_rules('editID', 'Status', 'trim|max_length[10]');		
		
		
		$configi['upload_path']          = './Assets/images/sp/profile/';
		$configi['allowed_types']        = 'gif|jpg|jpeg|png';
		$configi['max_size']             = 100;
		$configi['max_width']            = 1024;
		$configi['max_height']           = 900;	
		$this->load->library('upload', $configi);			

		$data['error']='';
		
		date_default_timezone_set("Asia/Kolkata"); 
		
		$mob="/^[789][0-9]{9}$/";	
		if(!preg_match($mob, $this->input->post('sp_phone'))){ 
			$data['error']='Invalid Phone Number';
		}
		
		if(!$this->upload->do_upload('image',FALSE)){	
			if($this->upload->data('file_name')){				
				$data['error'] .= "<br/>".$this->upload->display_errors(); 
			} 
		}

		if ($this->input->post('amount') != 0 and $this->input->post('amount') != ''){
			$amount1=$this->input->post('amount')/100;
		}else{
			$amount1=0;
		}		
		
		if ($amount1!=0) {					
						$add_days = 365 * $amount1;
						$date     = date('m/d/Y');
						$date1    = date('m/d/Y', strtotime($date) + (24 * 3600 * $add_days));
						$amount=$this->input->post('amount');
		}elseif($amount1<=0){	
						$add_days = 15;
						$date     = date('m/d/Y');
						$date1    = date('m/d/Y', strtotime($date) + (24 * 3600 * $add_days));
						$amount   = "Free Registration";
		}
		
		if($this->input->post('sp_country')=="India"){
			$CountryCode=91;
		}elseif($this->input->post('sp_country')=="USA"){
			$CountryCode=1;
		}
		
		
			
		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
		
		if ($this->form_validation->run() == FALSE or $data['error']!='') // validation hasn't been passed
		{	
			$this->load->view('slp/RegisterSponsor', $data); 			
		}
		else 
		{	 	
			$latlon=$this->calLatLongByAddress($this->input->post('sp_country'), 
										$this->input->post('sp_state'), 
										$this->input->post('sp_city'), 
										$this->input->post('sp_address'));
			$form_data = array(
					       	'sp_company' => set_value('sp_company'),
					       	'CountryCode' => $CountryCode,
					       	'sp_phone' => set_value('sp_phone'),
					       	'sp_landline' => set_value('sp_landline'),
					       	'sp_email' => set_value('sp_email'),
					       	'v_category' => set_value('v_category'),
					       	'sp_website' => set_value('sp_website'),
					       	'sp_address' => set_value('sp_address'),
					       	'sp_country' => set_value('sp_country'),
					       	'sp_state' => set_value('sp_state'),
					       	'sp_city' => set_value('sp_city'),
					       	'sp_password' => set_value('sp_password'),
							'sp_img_path' => $this->upload->data('file_name'),
							'sales_person_id' => $this->id,
							'sp_date' => date('m/d/Y'),
							'amount' => $amount,	
							'expiry_date' => $date1,	
							'lat' => @$latlon[0],	
							'lon' => @$latlon[1],
							'v_status' => set_value('v_status'),
							'source' => set_value('source')							
						);
			//if($form_data['lat']!= NULL && $form_data['lon']!= NULL){
			// run insert model to write data to db
			if($this->input->post('editID')!='' and $this->input->post('editID')!=0){
				$ins=$this->Msalesperson->UpdateSponsor($form_data,$this->input->post('editID'));
			}else{
				$ins=$this->Msalesperson->RegisterSponsor($form_data);
				
				if($this->input->post('discount')==''){
					$idiscount=0;
				}else{
					$idiscount=$this->input->post('discount');
				}
				
				if($this->input->post('points')==''){
					$pointsd=0;
				}else{
					$pointsd=$this->input->post('discount');
				}
				
				if($ins!= FALSE && $idiscount!=0){
					$this->sponsor->add_product($ins, 'discount', $idiscount, $idiscount, $pointsd, '');
				}
				
			}
          //  }else{
          //      echo 'Location is not found......!';
         //   }

			
			if ($ins != FALSE) // the information has therefore been successfully saved in the db
			{ 
				if($this->input->post('v_status')!="Invalid"){
								$pdfdata=array(
									'id'=>$ins,
									'dates'=>date('mdY'),
									'amount'=>$amount,
									'sponsor_name'=>set_value('sp_company'),
									'email'=> set_value('sp_email'),
									'sp_phone'=> set_value('sp_phone'),
									'date1'=> $date1);
								
								$r=$this->Msalesperson->receiptinfo($pdfdata);						
						if($this->input->post('sp_email')!=""){				
						//mail
								$this->load->library('email');
								$config['protocol'] = "mail";
								$this->email->initialize($config);
								$this->email
									->from('rakesh@blueplanetsolutions.com', 'SmartCookie Admin')				
									->to($this->input->post('sp_email'))
									->cc('acc@blueplnetsolutions.com','avi@blueplanetsolutions.com')
									->subject('SmartCookie Sponsor Registration')
									->message("Dear Sponsorer,<br/>".			 
									  "Your Username is: ".$this->input->post('sp_email')."<br/>".
									  "Password is: ".$this->input->post('sp_password')."<br/>Download Sponsor Android Application from <a href='https://goo.gl/XssIUG'>https://goo.gl/XssIUG</a><br/>Visit Our Website <a href='http://www.smartcookie.in'>www.smartcookie.in</a><br/>".$this->load->view('slp/web_pdfforsales', $pdfdata, true))
									->set_mailtype('html');
								if (!$this->email->send() or !$r){
									echo "Email error";die;
								}					
						}
					
						if($this->input->post('sp_phone')!=""){
								$phone=$this->input->post('sp_phone');
								//https://goo.gl/XssIUG
								if($CountryCode==91){	
								/*Below getdynamic function added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
								$dynamic=$this->Msalesperson->getdynamic();		
								$dynamic_user=$dynamic[0]->mobileno; 
								$dynamic_pass=$dynamic[0]->email; 
								$dynamic_sender=$dynamic[0]->otp; 	
									if($this->input->post('sp_email')!=''){
										$Text="Your%20Username%20for%20SmartCookie%20Sponsor%20is%3A%20".trim($this->input->post('sp_email'))."%20"."Password%20is%3A%20".trim($this->input->post('sp_password'))."%20Please%20Download%20App%20https%3A%2F%2Fgoo.gl%2FXssIUG%20Visit%20http%3A%2F%2Fwww.smartcookie.in";			
										$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
									}else{
										$Text="Your%20Username%20for%20SmartCookie%20Sponsor%20is%3A%20".trim($phone)."%20"."Password%20is%3A%20".trim($this->input->post('sp_password'))."%20Please%20Download%20App%20https%3A%2F%2Fgoo.gl%2FXssIUG%20Visit%20Visit%20http%3A%2F%2Fwww.smartcookie.in";			
										$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
									}
									file_get_contents($url);
								}else{
									$ApiVersion = "2010-04-01";
									// set our AccountSid and AuthToken
									$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
									$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";

									// instantiate a new Twilio Rest Client
									$client = new TwilioRestClient($AccountSid, $AuthToken);
									$number='+'.$CountryCode.$phone;
									$message="Your Username for SmartCookie Sponsor is: ".$this->input->post('sp_email')." "."Password is: ".$this->input->post('sp_password')." Download Sponsor Android Application https://goo.gl/XssIUG";	

									$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
									"POST", array(
									"To" => $number,
									"From" => "732-798-7878",
									"Body" => $message
									));
								}		
						}
				}
				
				redirect('Csalesperson/page/RegisteredSponsorsList');   // or whatever logic needs to occur
			}
			else
			{
				echo 'An error occurred while saving information. Please try again later';

			}
		}
	}
	
	
	public function activateSponsor(int $a){
		$ins=$this->Msalesperson->activateSponsor($a);
		if($ins){
			redirect('Csalesperson/page/RegisteredSponsorsList'); 
		}else{
			echo 'An error occurred while activating sponsor. Please try again later';
		}
	}
	
		public function add_discount(){
		$id=$this->id;
		$data= $this->headerData($id);	
		$this->load->model('sp/sponsor');
		$data['product']=$this->sponsor->product($id);
		$data['discount']=$this->sponsor->discount($id);
		$this->load->helper('form');
		$this->load->library('form_validation');		
		$edit_did=$this->input->post('edit_did');
		
		$config=array(
			array(
			'field' => 'idiscount',
			'label' => 'Product Name',
			'rules' => 'required|callback_product_check[' . $edit_did . ']',
			'errors' => array(
                        'required' => 'Please Enter Flat Discount<br/>',			
            ),
			),			
			array(
			'field' => 'pointsd',
			'label' => 'Product Points',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter Points For Discount<br/>',			
            ),
			)
		);
		
		
		$data['up']['disimg']=$this->uploadProductImage('disimg');
		$data['up']['proimg']['upload_error']='';
		
		
		
		$this->form_validation->set_rules($config);		 
		if($this->form_validation->run()==TRUE && ($fileuploaded['upload_error']==NULL || $fileuploaded['upload_data']['file_name']==NULL) ){
			
			$this->form_validation->set_message('idiscount', 'The {field} already exist<br/>');
			
			$idiscount=$this->input->post('idiscount');			
			$pointsd=$this->input->post('pointsd');		
			$disimguploaded=$data['up']['disimg']['upload_data']['file_name'];		
 			if($edit_did!=""){
				//update discount
				$this->sponsor->update_product($id, $idiscount, $idiscount, $pointsd, $edit_did, $disimguploaded);
			}else{
				//add discount
				$this->sponsor->add_product($id, 'discount', $idiscount, $idiscount, $pointsd, $disimguploaded );
			} 		
			redirect('/Csponsor/page/product_setup', 'location', 301); 
				
		}				
		$this->load->view('sp/product_setup',$data);
		$this->load->view('sp/footer'); 
	}
}