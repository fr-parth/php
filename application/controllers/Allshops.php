<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allshops extends CI_Controller {

	public function __construct(){
	  parent::__construct();
			$this->load->library('session');
			$this->entity=$this->session->entity;
			if($this->entity!='sponsor'){
			   redirect('/welcome', 'location', 301);
			}
	}

	public function index()
	{ 	
		$this->load->library('session');
				
		$this->load->model("sp/sponsor");
		$data['shops']= $this->sponsor->myshops($this->session->ids);
		$myData=$this->sponsor->myData($this->session->ids[0]->id);	
		//get all data of that sponsor
		
		$allids=$this->session->ids;
		$allid=array();
		foreach($allids as $key=>$value){
			$allid[]=$allids[$key]->id;
		}		
		$data['owner_id']=min($allid);			

		$data['myData']=@$myData[0];
		$data['categories']=$this->sponsor->categories('');
		$data['countries']=$this->sponsor->countries();
		$data['disp']=0;
		$data['AlreadyExist']='';
		$data['states']=@$this->sponsor->get_states($data['myData']->sp_country);
		$data['cities']=@$this->sponsor->get_cities($data['myData']->sp_country,$data['myData']->sp_state);	
		
		$data['total_shops']=count($data['shops']);
		$this->load->view('sp/allshops',$data);
	}
	
	public function auth_user($ids, $id){
		$s=false;
		foreach(@$ids as $key=>$value){
			if($ids[$key]->id==$id){
				$s=true;
				break;
			}
		}
		return $s;
	}
	
	public function redir($id){
		$ids=$this->session->ids;
		if($this->auth_user($ids, $id)){
			$newdata = array(
							'id' => $id
			); 
			$this->session->set_userdata($newdata);
			if($this->session->entity=='sponsor'){			
				redirect('/Csponsor', 'location', 301);
			} 
		}else{
			$this->session->sess_destroy();
			echo "<script>alert('Dont Be OverSmart');</script>";
			redirect('/Welcome/login', 'location', 301);
		}
	}
	
	public function del($id){
		$this->load->model("sp/sponsor");
		$i=$this->sponsor->del('tbl_sponsorer', $id);
		if($i==1)
		{
			$this->session->set_flashdata('successdeleteshop', 'Shop Successfully Deleted!');
		}
		else if($i==0)
		{	
			$this->session->set_flashdata('errordeleteshop', 'Shop Not Deleted!');
		}
		$this->load->library('session');
		$ids= $this->session->ids;
		foreach(@$ids as $key=>$value){
			if($ids[$key]->id==$id){
				unset($ids[$key]);	
				break;
			}
		}
		$this->session->ids=$ids;
		//print_r($ids);
		redirect('/Allshops', 'location', 301);
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
	
	public function add_shop(){	
		$this->load->model("sp/sponsor");
		$this->load->helper('form');
		$this->load->library('form_validation');	
		
		//if($this->input->post('sp_password')==''){
		//	redirect('/Allshops', 'location', 301);		
		//}
				
		$config=array(
			array(
			'field' => 'sp_company',
			'label' => 'Company Name',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter Company Name<br/>',			
            ),
			),
			array(
			'field' => 'sp_name',
			'label' => 'sponsor Name',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter Sponsor Name<br/>',			
            ),
			),
			array(
			'field' => 'v_category',
			'label' => 'Product Category',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Select Product Category<br/>',			
            ),
			),
			array(
			'field' => 'sp_website',
			'label' => 'Website',
			'rules' => 'prep_url'
			),
			array(
			'field' => 'sp_phone',
			'label' => 'Contact Number',
			'rules' => 'required|is_natural_no_zero|min_length[10]|max_length[10]|regex_match[/^[6789]\d{9}$/]',
			'errors' => array(
                        'required' => 'Please Enter Contact Number<br/>',			
                        'is_natural_no_zero' => 'Please Enter Valid Contact Number<br/>',
                        'min_length[10]' => 'Please Enter Valid Contact Number<br/>',
                        'max_length[10]' => 'Contact Number Length Exceeded<br/>',
                        'regex_match[/^[789]\d{9}$/]'	=> 'Contact Number start with only 6,7,8 & 9 only.<br/>',	
            ),
			),
			array(
			'field' => 'country_code',
			'label' => 'country_code',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter country_code<br/>',			
                       		
            ),
			),
		
			array(
			'field' => 'sp_address',
			'label' => 'Address',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter Address<br/>',			
            ),
			),
			
			array(
			'field' => 'sp_country',
			'label' => 'Country',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Select Country<br/>',			
            ),
			),
			
			array(
			'field' => 'sp_state',
			'label' => 'State',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Select State<br/>',			
            ),
			),
			
			array(
			'field' => 'sp_city',
			'label' => 'City',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Select City<br/>',			
            ),
			),
			
			array(
			'field' => 'pin',
			'label' => 'ZIP/PIN Code',
			'rules' => 'required|is_natural_no_zero|max_length[15]',
			'errors' => array(
                        'required' => 'Enter ZIP/PIN Code<br/>',			
                        'is_natural_no_zero' => 'Enter Valid ZIP/PIN Code<br/>',			
            ),
			),
		);
		
			$this->form_validation->set_rules($config);	
				$myData=(object)[];				
				
				$myData->sp_name=$this->input->post('sp_name');
				$myData->sp_company=$this->input->post('sp_company');
				$myData->v_category=$this->input->post('v_category');
				$myData->sp_website=$this->input->post('sp_website');
				$myData->sp_email=$this->input->post('sp_email');
				$myData->CountryCode=$this->input->post('country_code');
				$myData->sp_phone=$this->input->post('sp_phone');
				$myData->sp_img_path=$this->input->post('sp_img_path');
				$myData->sp_password=$this->input->post('sp_password');
				//$myData->sp_date=$this->input->post('sp_date');
				
				if($myData->CountryCode==91)
				{
					date_default_timezone_set("Asia/Calcutta");
					// VaibhavG added new date format for ticket number SMC-3486 26Sept18 3:59PM
					//$dates = date("Y-m-d h:i:s A");
					$dates = CURRENT_TIMESTAMP;
					$myData->sp_date=$dates;
				}
				elseif($myData->CountryCode==1)
				{
					date_default_timezone_set("America/Boa_Vista");
					// VaibhavG added new date format for ticket number SMC-3486 26Sept18 3:59PM
					//$dates = date("Y-m-d h:i:s A");
					$dates = CURRENT_TIMESTAMP;
					$myData->sp_date=$dates;
				}

				$myData->sp_address=$this->input->post('sp_address');
				$myData->sp_country=$this->input->post('sp_country');
				$myData->sp_state=$this->input->post('sp_state');
				$myData->sp_city=$this->input->post('sp_city');
				$myData->pin=$this->input->post('pin');		
				
							
				
				$myData->owner_id=$this->input->post('owner_id');
				$myData->payment_method="free";
				$myData->entity_id=108;
				$myData->platform_source= "web(Sponsor Add Shop)";
				$myData->v_responce_status= "Interested";
				
				$latlon=$this->calLatLongByAddress($this->input->post('sp_country'), 
										$this->input->post('sp_state'), 
										$this->input->post('sp_city'), 
										$this->input->post('sp_address'));
				
				$myData->lat=@$latlon[0];
				$myData->lon=@$latlon[1];
				$myData->calculated_lat=@$latlon[0];
				$myData->calculated_lon=@$latlon[1];
				$data['myData']=$myData;
				$error=false;
				$data['AlreadyExist']='';
				/*Author VaibhavG
				* initialize success variable to the shop insertion code for the ticket number SMC-3357 27Aug18 3:29PM 
				*/
				$data['success']='';
		        if ($this->form_validation->run()){
					$last_id=$this->sponsor->add_shop($data['myData']);					
					if($last_id!=0){
						$ids=$this->session->ids;
						$idi=(object)[];	
						$idi->id=$last_id;
						array_push($ids,$idi);
						$this->session->ids=$ids;
						/*Author VaibhavG
						* Added success message to the shop insertion for the ticket number SMC-3357 27Aug18 3:29PM
						*/
						$data['success']='New Shop Added Successfully!';
						$error=true;
						//commented by VaibhavG for the ticket number SMC-3357 27Aug18 3:29PM
						//redirect('/Allshops/index', 'location', 301);						
					}else{				
						$error=true;
						$data['AlreadyExist']='Shop Already Exist';
					}			
                }else{					
					$error=true;
                }
				
				if($error){
					$data['disp']=1;
					$data['shops']= $this->sponsor->myshops($this->session->ids);
					$myData=$this->sponsor->myData($this->session->ids[0]->id);	
					
					$data['categories']=@$this->sponsor->categories('');
					$data['countries']=@$this->sponsor->countries();
					$data['states']=@$this->sponsor->get_states($data['myData']->sp_country);
					$data['cities']=@$this->sponsor->get_cities($data['myData']->sp_country,$data['myData']->sp_state);
					
					$data['total_shops']=count($data['shops']);
					$this->load->view('sp/allshops',$data);
					//$this->load->view('sp/footer');
				}
		
	}
}

