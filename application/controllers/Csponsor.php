<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csponsor extends CI_Controller {	
	
	public $id;
	public $entity;
	public $email;
	public $name;
	
	public function __construct(){
      parent::__construct();
	   $this->load->library('session'); 
	   $this->id=$this->session->id;
	   $this->entity=$this->session->entity;
	   if($this->entity!='sponsor'){
		   redirect('/welcome', 'location', 301);
	   }elseif($this->id=='' or $this->id==0){
           $this->load->model("sp/sponsor");
           $this->sponsor->logoutStatus();
		   redirect('/welcome', 'location', 301);   
	   }
    }

	
    public  function sp_my_qr_code($id){
         $this->load->model('sp/sponsor');
         $data['user']= $this->sponsor->headerData($id);
        /* echo '<pre>';
         die(print_r($data,true));*/
         $this->load->view('qr_img0.50j/php/sp_my_qr_code',$data);
     }
	 
/*start sponsor website create functions*/ 
	public function sp_search_domain($id)
	{
		$this->load->model('sp/sponsor');
		$domain= $this->input->post('domain');
		$data['domain']=$domain;
		$data['user']=$this->sponsor->headerData($id);
		$data['mod_search_domain']=$this->sponsor->mod_search_domain($id);
		$data['message'] = $this->sponsor->mod_search_domain($domain);
		$this->load->view('sp/sponsor_create_website',$data);
	}

	public function sp_create_website($id){
		$this->load->model('sp/sponsor');
		$data['user']=$this->sponsor->headerData($id);
		$this->load->view('sp/sponsor_create_website',$data);		
	}

	public function sp_price_website($id){
		$this->load->model('sp/sponsor');	
		$data['user']=$this->sponsor->headerData($id);
		$this->load->view('sp/sponsor_price_website',$data);
	}
	
	/*public function sp_200_website($id){
		$this->load->model('sp/sponsor');
		$data['user']=$this->sponsor->headerData($id);
		$data['myData']=$this->sponsor->myData($id);
		$data['product_details']=$this->sponsor->product($id);
		$this->load->view('sp/sponsor_200_website',$data);
	}
	
	public function sp_500_website($id){
		$this->load->model('sp/sponsor');
		$data['user']=$this->sponsor->headerData($id);
		$data['myData']=$this->sponsor->myData($id);
		$data['product_details']=$this->sponsor->product($id);
		$this->load->view('sp/sponsor_500_website',$data);
	}*/
	
	
	public function sp_1000_website($id){
		if(is_numeric($id))
		{
			$this->load->model('sp/sponsor');
			$data['user']=$this->sponsor->headerData($id);
			$data['myData']=$this->sponsor->myData($id);
			$data['product_details']=$this->sponsor->product($id);
			$this->load->view('sp/sponsor_1000_website',$data);
		}
		else
		{
			$this->load->model('sp/sponsor');
			$data['sp_name']=$this->sponsor->sponsor_name($id);
			$data['user']=$this->sponsor->headerData($data['sp_name'][0]->id);
			$data['myData']=$this->sponsor->myData($data['sp_name'][0]->id);
			$data['product_details']=$this->sponsor->product($data['sp_name'][0]->id);
			$this->load->view('sp/sponsor_1000_website',$data);
		}
	}
	
	public function sp_500_website($id){
		if(is_numeric($id))
		{
			$this->load->model('sp/sponsor');
			$data['user']=$this->sponsor->headerData($id);
			$data['myData']=$this->sponsor->myData($id);
			$data['product_details']=$this->sponsor->product($id);
			$this->load->view('sp/sponsor_500_website',$data);
		}
		else
		{
			$this->load->model('sp/sponsor');
			$data['sp_name']=$this->sponsor->sponsor_name($id);
			$data['user']=$this->sponsor->headerData($data['sp_name'][0]->id);
			$data['myData']=$this->sponsor->myData($data['sp_name'][0]->id);
			$data['product_details']=$this->sponsor->product($data['sp_name'][0]->id);
			$this->load->view('sp/sponsor_500_website',$data);
		}
	}
	
	public function sp_200_website($id){
		if(is_numeric($id))
		{
			$this->load->model('sp/sponsor');
			$data['user']=$this->sponsor->headerData($id);
			$data['myData']=$this->sponsor->myData($id);
			$data['product_details']=$this->sponsor->product($id);
			$this->load->view('sp/sponsor_200_website',$data);
		}
		else
		{
			$this->load->model('sp/sponsor');
			$data['sp_name']=$this->sponsor->sponsor_name($id);
			$data['user']=$this->sponsor->headerData($data['sp_name'][0]->id);
			$data['myData']=$this->sponsor->myData($data['sp_name'][0]->id);
			$data['product_details']=$this->sponsor->product($data['sp_name'][0]->id);
			$this->load->view('sp/sponsor_200_website',$data);
		}
	}

	/*public function sp_1000_website($id){
		$this->load->model('sp/sponsor');
		$data['user']=$this->sponsor->headerData($id);
		$data['myData']=$this->sponsor->myData($id);
		$data['product_details']=$this->sponsor->product($id);
		$this->load->view('sp/sponsor_1000_website',$data);
	}*/
/*End sponsor website create functions*/
	
	public function index()
	{ 			
		$this->page('accept_coupon');			
	}
	public function page($page){	
		$this->load->model("sp/sponsor");
		$id=$this->id;
		$data= $this->headerData($id);
			switch($page){
				case 'log_generated_coupons':					
					$data['log_generated_coupons']= $this->sponsor->log_generated_coupons($id);
					$data['count_generated_coupons'] = count($data['log_generated_coupons']);
				break;	
				case 'log_accepted_sc_coupons':
					$data['log_accepted_sc_coupons']= $this->sponsor->log_accepted_sc_coupons($id);
					$data['count_accepted_sc_coupons'] = count($data['log_accepted_sc_coupons']); 
				break;	
				case 'log_accepted_sp_coupons':
					$data['log_accepted_sp_coupons']= $this->sponsor->log_accepted_sp_coupons($id);
					$data['count_accepted_sp_coupons'] = count($data['log_accepted_sp_coupons']); 
				break;
				//log_membership_discount added by Rutuja Jori & Sayali Balkawade(PHP Interns) for Bug SMC-3773 on 19/04/2019
				
				case 'log_membership_discount':
					$data['log_membership_discount']= $this->sponsor->log_membership_discount($id);
					$data['count_membership_discount'] = count($data['log_membership_discount']); 
				break;	//end	
				case 'log_collegewise_sp_coupon_usage':
					@$data['log_collegewise_sp_coupon_usage']= @$this->sponsor->collegewise_usage($id);
					$data['count_collegewise_sp_coupon_usage'] = count(@$data['log_collegewise_sp_coupon_usage']);
					break;
				case 'sponsor_map':
					$data['map_init']= $this->sponsor->map_init($id);					
					$this->load->library('googlemaps');
					$config['center'] = ''.$data['map_init'][0]->lat.','.$data['map_init'][0]->lon.'';				
					$config['zoom'] = '9';
					$this->googlemaps->initialize($config);			
				
					$marker = array();
					$marker['position'] = ''.$data['map_init'][0]->lat.','.$data['map_init'][0]->lon.'';
					if($data['map_init'][0]->sp_company!=""){
						$marker['infowindow_content'] = $data['map_init'][0]->sp_company;					
					}else{
						$marker['infowindow_content'] = $data['map_init'][0]->sp_name;
					}					
					$marker['draggable'] = true;
					$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';				
					$marker['icon'] = 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|9999FF|000000';
					$this->googlemaps->add_marker($marker);
				
					$location=$this->sponsor->nearby_sponsors($id,10);
					foreach($location as $key =>$value){
						$marker = array();						
						$marker['position'] = ''.$location[$key]->lat.','.$location[$key]->lon.'';
						$marker['infowindow_content'] = $location[$key]->sp_company;
						$this->googlemaps->add_marker($marker).'';
					}		

					$schools=$this->sponsor->nearby_schools($id,10);
					foreach($schools as $key =>$value){
						$marker = array();						
						$marker['position'] = ''.$schools[$key]->school_latitude.','.$schools[$key]->school_longitude.'';
						$marker['infowindow_content'] = $schools[$key]->school_name;
						$marker['icon'] = 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=I|009900|000000';
						$this->googlemaps->add_marker($marker).'';				
					}
					
					$data['map'] = $this->googlemaps->create_map();		
					$data['location']=$location;
					break;
				case 'product_setup':
					$data['up']['proimg']['upload_error']='';
					$data['up']['disimg']['upload_error']='';
					$data['product']=$this->sponsor->product($id);
					$data['discount']=$this->sponsor->discount($id);
					$data['categories']=$this->sponsor->categories('');
					$data['currencies']=$this->sponsor->currencies('');
					$data['reset']=true;
					break;	
				case 'accept_coupon':					
					$data['coupons']['rows']=0;
					$data['product']=$this->sponsor->product($id);
					$data['discount']=$this->sponsor->discount($id);
					break;
				case 'sp_coupon':
					$data['myData']=$this->sponsor->myData($id);
					$data['categories']=$this->sponsor->categories('');
					$data['currencies']=$this->sponsor->currencies('');
					$data['cdata']=$this->init_coupon_setup();
					break;
				case 'profile':
					$data['myData']=$this->sponsor->myData($id);	
					if($data['myData'][0]->v_category!="" and $data['myData'][0]->v_category!=NULL){
						@$cat=$this->sponsor->categories($data['myData'][0]->v_category);
						$data['myData'][0]->v_category=@$cat[0]->category;
					}else{
						$data['myData'][0]->v_category='Please Select Product Category';
					}			
					
					$data['myData'][0]->fileerror='';
					$data['calling_code']=$this->sponsor->calling_code($data['myData'][0]->sp_country);
					break;
				case 'edit_profile':
					$d=$this->sponsor->myData($id);	
					
					$data['myData']=$d[0];
					$data['categories']=$this->sponsor->categories('');
					$data['countries']=$this->sponsor->countries();
					$data['states']=$this->sponsor->get_states($data['myData']->sp_country);
					$data['cities']=$this->sponsor->get_cities($data['myData']->sp_country,$data['myData']->sp_state);
					break;
					
					
					
			}

		$this->load->view('sp/'.$page,$data);
		$this->load->view('sp/footer');
	}
	public function headerData($id){
		//$data['img_path']="./Assets/images/sp/profile/";
		$data['img_path']="./core/image_sponsor/";
		$this->load->model("sp/sponsor");
		$data['user']= $this->sponsor->headerData($id);
		$this->email=$data['user'][0]->sp_email;
		return $data;   
	}
	public function logout(){
        $this->load->model("sp/sponsor");
        $this->sponsor->logoutStatus();
		$this->session->sess_destroy();

        redirect(base_url());
	}
	public function update_coords(){
		$newLat=$this->input->post('newLat');
		$newLng=$this->input->post('newLng');
		$var1=$this->input->post('var1');
		$this->load->model("sp/sponsor");
		$i=$this->sponsor->update_coords($newLat, $newLng, $this->id);
		if($i){
			echo 'Location Updated';
		}else{
			echo 'Error Occured';
		}		
	}
	public function del($page, $table, $id, $type){
		$this->load->model("sp/sponsor");
		$i=$this->sponsor->del($table, $id);
		//echo $i;exit;
		if($i==1 AND $type=='product')
		{
			$this->session->set_flashdata('successdeleteproduct', 'Product Successfully Deleted!');
		}
		else if($i==0 AND $type=='product')
		{	
			$this->session->set_flashdata('errordeleteproduct', 'Product Not Deleted!');
		}

		if($i==1 AND $type=='discount')
		{
			$this->session->set_flashdata('successdeletediscount', 'Discount Successfully Deleted!');
		}
		else if($i==0 AND $type=='discount')
		{	
			$this->session->set_flashdata('errordeletediscount', 'Discount Not Deleted!');
		}

		if($i==1 AND $type=='productlog')
		{
			$this->session->set_flashdata('successdeletegeneratedcoupons', 'Product Log Successfully Deleted!');
		}
		else if($i==0 AND $type=='productlog')
		{	
			$this->session->set_flashdata('errordeletegeneratedcoupons', 'Product Log Not Deleted!');
		}
		redirect('csponsor/page/'.$page, 'location');		
	}
 	public function search_spcoupon_form(){	
		$id=$this->id;
		$data= $this->headerData($id);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$config=array(
			array(
			'field' => 'code',
			'label' => 'Coupon Code',
			'rules' => 'required|callback_code_check',
			'errors' => array(
                        'required' => 'Please Enter Coupon Code Above',
			
            ),
			)
		);

		$this->form_validation->set_rules($config);		 
		$this->form_validation->run();
		$this->load->model('sp/sponsor');		
		$data['coupons']=$this->sponsor->code_user($id, $this->input->post('code'));
		$data['product']=$this->sponsor->product($id);
		$data['discount']=$this->sponsor->discount($id);

//		echo "<pre>";
//		die(print_r($data['coupons'],true));
		$this->load->view('sp/accept_coupon',$data);
		$this->load->view('sp/footer');
		
	}
	public function code_check($str){
		$id=$this->id;
		$this->load->model('sp/sponsor');
		$rows=$this->sponsor->is_valid_code($id, $str);
		if($rows>0){
			return true;
		}else{
			$this->form_validation->set_message('code_check', 'The {field} is Invalid');
			return false;
		}
	}
	public function accept_sp_coupon(){
		$cpid=$this->input->post('cpid');
		$scid=$this->input->post('scid');
		
		$this->load->model("sp/sponsor");
		$i=$this->sponsor->accept_sp_coupon($cpid, $this->id, $scid);
		
		if($i!=0 or $i!=""){
			echo 'Coupon Successfully Accepted';
		}else{
			echo 'Sorry Error Occured';
		}
	}
	public function accept_sc_coupon_display(){
		$cpid=$this->input->post('cpid');
		
		$this->load->model("sp/sponsor");
		$table=$this->sponsor->is_sccoupon_exist($cpid);		
		
		if($cpid==""){
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
		}elseif($table!=""){
				$userinfo=$this->sponsor->sccoupon_display($cpid,$table,$this->id);
				$schoolName=$this->sponsor->getSchoolName($userinfo['data'][0]->school_id);
				$userinfo['schoolName']=$schoolName[0]->school_name;
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$userinfo;
		}else{
			  	$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
		}
		$this->output->set_content_type('application/json')
             ->set_output(json_encode($postvalue));	
	}
	public function getProduct(){
		$cid=$this->input->post('cid');
		
		$this->load->model("sp/sponsor");
		$val['product']=$this->sponsor->getProduct($cid);
		
		$this->output->set_content_type('application/json')
             ->set_output(json_encode($val));	
	}
	public function accept_sc_coupon(){
		$sccode=$this->input->post('sccode');
		$id=$this->id;
		//check is exist
		$this->load->model("sp/sponsor");
		$table=$this->sponsor->is_sccoupon_exist($sccode);		
		$ok=true; //input errors
		$t=false; //successfully accepted
		$nep=false; //not enough points
		
		if(!$table){
			$ok=false;	
		}else{
			if($table=="tbl_coupons"){
				$type='student';
			}elseif($table=="tbl_teacher_coupon"){
				$type='teacher';
			}			
			
			$otype=$this->input->post('otype');
			$product_id=$this->input->post('product_id');
			$discount_id=$this->input->post('discount_id');
			$misc=$this->input->post('misc');		
			
			$prodisc=$this->input->post('prodisc');	
			
			$propoints=$this->input->post('propoints');	
			$discpoints=$this->input->post('discpoints');
			$miscpoints=$this->input->post('miscpoints');

			$proname=$this->input->post('proname');
			$discamt=$this->input->post('discamt');			
			
			/*$config=array(			
			array(
			'field' => 'miscpoints',
			'label' => 'Product Points',
			'rules' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[9999]|integer',
			'errors' => array(
                        'required' => 'Please Enter Product Points<br/>',
						'numeric' => 'Please Enter Number only.<br/>',
			
            ),
			)
		);
			$this->form_validation->set_rules($config);		 
			if($this->form_validation->run()==false)
			{
				$ok=false;
			}*/
			
			if($product_id=="" && $discount_id=="" && $misc==""){
					$ok=false;
			}elseif($otype=="Product" && $product_id=="select"){
					$ok=false;				
			}else if($otype=="Discount" && $discount_id=="select"){
					$ok=false;				
			}else if($otype=="Miscellaneous" && ($misc=="" || $miscpoints=="")){
					$ok=false;				
			}
			
			$userinfo=$this->sponsor->sccoupon_display($sccode,$table,$id);
			//print_r($userinfo);
			$amount=$userinfo['data'][0]->amount;
			$user_id=$userinfo['data'][0]->user_id;
			$school_id=$userinfo['data'][0]->school_id;

			if($ok){
				if($otype=="Product"){
					if($amount < $propoints){
						$nep=true;
					}else{
						$amt=$amount-$propoints;
						
						$t=$this->sponsor->accept_sccoupon($id,$user_id,$sccode,$propoints,$proname,$type,$school_id, $amt);	
						
			
					}
				}elseif($otype=="Discount"){
					
					if($amount < $discpoints){
						$nep=true;
					}else{
						$amt=$amount-$discpoints;
	
			$t=$this->sponsor->accept_sccoupon($id,$user_id,$sccode,$discpoints,$discamt,$type,$school_id, $amt);	

					}
				}elseif($otype=="Miscellaneous"){
					
					if($amount < $miscpoints){
						$nep=true;
					}else{
						$amt=$amount-$miscpoints;
						
						$t=$this->sponsor->accept_sccoupon($id,$user_id,$sccode,$miscpoints,$misc,$type,$school_id, $amt);

					}
				}
			}			
		}
	/* sccode: sccode, otype: otype, product_id: product_name, prodisc: prodisc, propoints: propoints, discount_id: discount_name, discpoints: discpoints, misc: note, miscpoints: miscpoints */
			
				if(!$ok){
						$postvalue['responseStatus']=1000;
						$postvalue['responseMessage']="Invalid Input";
						$postvalue['posts']=null;
				}elseif($nep || !$t){
						$postvalue['responseStatus']=204;
						$postvalue['responseMessage']="No Response";
						$postvalue['posts']=null;
				}elseif($t){
						$userinfo=$this->sponsor->sccoupon_display($sccode,$table,$id);
						$postvalue['responseStatus']=200;
						$postvalue['responseMessage']="OK";
						$postvalue['posts']=$userinfo;
				}				
				$this->output->set_content_type('application/json')
					 ->set_output(json_encode($postvalue));	 
	}
	public function sponsor()
	{
		$id=$this->id;
		$this->load->model('sp/sponsor');
		$data['user']= $this->sponsor->headerData($id);
		//$data['product_details']=$this->sponsor->product($id);
		$data['product_details']=$this->sponsor->product_with_currency($id);
		$data['rolling_messages']=$this->sponsor->rolling_messages($id);
	/*echo "<pre>";
 die(print_r($messages,true));*/
		$this->load->view('sp/product_sponsor_smartcookie',$data);
		$this->load->view('sp/footer');
		
	}
	public function product_gallery_zoom()
	{
		$id=$this->id;
		$this->load->model('sp/sponsor');
		$data['user']= $this->sponsor->headerData($id);
		//$data['product_details']=$this->sponsor->product($id);		
		$data['product_details']=$this->sponsor->product_with_currency($id);
		$this->load->view('sp/product_gallery_zoom',$data);
		$this->load->view('sp/footer');
		
	}
	public function product_gallery()
	{
		$id=$this->id;
		$this->load->model('sp/sponsor');
		//$data['product_details']=$this->sponsor->product($id);
		$data['product_details']=$this->sponsor->product_with_currency($id);
		$data['user']= $this->sponsor->headerData($id);
		$this->load->view('sp/product_gallery',$data);
		$this->load->view('sp/footer'); 
	}
	public function add_product(){
//Validations modified for Product Discount, Product Price, Product Points and ltrim() removed for prodis and pointsp for bug SMC-3717 by Pranali on 21-12-18
		$id=$this->id;
		$data= $this->headerData($id);	
		$iproduct=ltrim($this->input->post('iproduct'),0);
		$iproductOriginal=ltrim($this->input->post('iproductOriginal'),0);
		$prodis=$this->input->post('prodis');
		$pointsp=$this->input->post('pointsp');
		$curr=$this->input->post('currency');
		$price=trim($this->input->post('price'));
		$data['currencies']=$this->sponsor->currencies('');
		$this->load->model('sp/sponsor');
		$data['product']=$this->sponsor->product($id);
		$data['discount']=$this->sponsor->discount($id);
		$this->load->helper('form');
		$this->load->library('form_validation');		
		$edit_pid=$this->input->post('edit_pid');
		
		if(empty($edit_pid))
		{
		$config=array(
			array(
			'field' => 'iproduct',
			'label' => 'Product Name',
			'rules' => 'required|callback_product_check[' . $edit_pid . ']',
			'errors' => array(
                        'required' => 'Please Enter Product Name<br/>',
			
            ),
			),
			array(
			'field' => 'prodis',
			'label' => 'Product Discount',

			'rules' => 'required|is_natural|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',

			'errors' => array(
                        'required' => 'Please Enter Product Discount<br/>',
						'numeric' => 'Please Enter Number only.<br/>',	
            ),
			),
			array(
			'field' => 'price',
			'label' => 'Product Price',

			'rules' => 'required|trim|is_natural|numeric|greater_than_equal_to[0]',

			'errors' => array(
                        'required' => 'Please Enter Product Price<br/>',
						'numeric' => 'Please Enter Number only.<br/>',	
            ),
			),
			array(
			'field' => 'pointsp',
			'label' => 'Product Points',

			'rules' => 'required|is_natural|numeric|greater_than_equal_to[0]|less_than_equal_to[9999]',

			'errors' => array(
                        'required' => 'Please Enter Product Points<br/>',
						'numeric' => 'Please Enter Number only.<br/>',
			
            ),
			)
			
		);
		}
		else if((!empty($edit_pid)) && ($iproduct!=$iproductOriginal))
		{
			$config=array(
			array(
			'field' => 'iproduct',
			'label' => 'Product Name',
			'rules' => 'required|callback_product_check[' . $edit_pid . ']',
			'errors' => array(
                        'required' => 'Please Enter Product Name<br/>',
			
            ),
			),
			array(
			'field' => 'prodis',
			'label' => 'Product Discount',

			'rules' => 'required|is_natural|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',

			'errors' => array(
                        'required' => 'Please Enter Product Discount<br/>',
						'numeric' => 'Please Enter Number only.<br/>',	
            ),
			),
			array(
			'field' => 'pointsp',
			'label' => 'Product Points',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[9999]',

			'errors' => array(
                        'required' => 'Please Enter Product Points<br/>',
						'numeric' => 'Please Enter Number only.<br/>',
			
            ),
			)
		);
		}
		else
		{
			$config=array(
			array(
			'field' => 'iproduct',
			'label' => 'Product Name',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter Product Name<br/>',
			
            ),
			),
			array(
			'field' => 'prodis',
			'label' => 'Product Discount',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[100]',

			'errors' => array(
                        'required' => 'Please Enter Product Discount<br/>',
						'numeric' => 'Please Enter Number only.<br/>',	
            ),
			),
			array(
			'field' => 'pointsp',
			'label' => 'Product Points',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[9999]',

			'errors' => array(
                        'required' => 'Please Enter Product Points<br/>',
						'numeric' => 'Please Enter Number only.<br/>',
			
            ),
			)
		);
		}
		$fileuploaded=$this->uploadProductImage('proimg');
		$data['up']['proimg']=$fileuploaded;
		
		$data['up']['disimg']['upload_error']='';
		
		$this->form_validation->set_rules($config);		 
		if($this->form_validation->run() && ($fileuploaded['upload_error']==NULL || $fileuploaded['upload_data']['file_name']==NULL)){
			//$iproduct=ltrim($this->input->post('iproduct'),0);
			//$prodis=ltrim($this->input->post('prodis'),0);
			//$pointsp=ltrim($this->input->post('pointsp'),0);
			
			$proimguploaded=$data['up']['proimg']['upload_data']['file_name'];
			
			
			if($edit_pid!=""){
				//update product
				
				$result=$this->sponsor->update_product($id, $iproduct, $pointsp, $prodis,$edit_pid, $proimguploaded, $price,$curr);
				if($result)
				{
					$this->session->set_flashdata('successupdateproduct', 'Product Successfully Updated!');
				}
				else
				{	
					$this->session->set_flashdata('errorupdateproduct', 'Product Not Updated!');
				}
			}else{
				//add product
				//$revenue_percent and $revenue_per_visit added by Pranali for SMC-3717
				$revenue_percent=0;
				$revenue_per_visit=0;
				$result=$this->sponsor->add_product($id, 'product', $iproduct, $prodis, $pointsp,$price,$curr, $proimguploaded,$revenue_percent,$revenue_per_visit);
				if(!$result){
					echo "<script>alert('Please Update Product Category In Sponsor Profile');</script>";			
				}	
				if($result)
				{
					$this->session->set_flashdata('successproduct', 'Product Successfully Added!');
				}
				else
				{	
					$this->session->set_flashdata('errorproduct', 'Product Not Added!');
				}
			}	
		
			redirect('/Csponsor/page/product_setup', 'location', 301);
		}
		$data['currencies']=$this->sponsor->currencies('');
		$data['reset']=false;
		//redirect('/Csponsor/page/product_setup', 'location', 301);
		$this->load->view('sp/product_setup',$data);
		$this->load->view('sp/footer'); 
	}
	
	
	public function product_check($str, $update){
		//if($update==""){
		$id=$this->id;
		$this->load->model('sp/sponsor');
		$rows=$this->sponsor->is_valid_product($id, $str);
		if(!$rows){
			return true;
		}else{
			$this->form_validation->set_message('product_check', 'The {field} already exist<br/>');
			return false;
		}
		//}else{
		//	return true;
		//}
	}
	public function uploadProductImage($uploadField){
		
		$configi['upload_path']          = './Assets/images/sp/productimage/';
		$configi['allowed_types']        = 'gif|jpg|jpeg|png';
		$configi['max_size']             = 1024;
		$configi['max_width']            = 1200;
		$configi['max_height']           = 500;				

		$this->load->library('upload', $configi);			
		$this->upload->do_upload($uploadField);	

		$data = array('upload_error'=> $this->upload->display_errors(), 'upload_data' => $this->upload->data());			
		
		return $data;	
	}
	public function add_discount(){
//Validations modified for Discount, Product Points and ltrim() removed for idiscount and pointsd for bug SMC-3717 by Pranali on 21-12-18
		$id=$this->id;
		$data= $this->headerData($id);
		$idiscount=$this->input->post('idiscount');			
		$idiscountOriginal=ltrim($this->input->post('idiscountOriginal'),0);			
		$pointsd=$this->input->post('pointsd');	
		$this->load->model('sp/sponsor');
		$data['product']=$this->sponsor->product($id);
		$data['discount']=$this->sponsor->discount($id);
		$this->load->helper('form');
		$this->load->library('form_validation');		
		$edit_did=$this->input->post('edit_did');
		if(empty($edit_did))
		{
		$config=array(
			array(
			'field' => 'idiscount',
			'label' => 'Discount',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[100]|callback_discount_check[' . $edit_did . ']',

			'errors' => array(
                        'required' => 'Please Enter Discount<br/>',
						'numeric' => 'Please Enter Numbers Only<br/>',
			
            ),
			),			
			array(
			'field' => 'pointsd',
			'label' => 'Product Points',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[9999]',

			'errors' => array(
                        'required' => 'Please Enter Points For Discount<br/>',	
						'numeric' => 'Please Enter Numbers Only<br/>',
            ),
			)
		);
		}
		else if((!empty($edit_did)) && ($idiscount!=$idiscountOriginal))
		{
		$config=array(
			array(
			'field' => 'idiscount',
			'label' => 'Discount',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[100]|callback_discount_check[' . $edit_did . ']',

			'errors' => array(
                        'required' => 'Please Enter Discount<br/>',
						'numeric' => 'Please Enter Numbers Only<br/>',
			
            ),
			),			
			array(
			'field' => 'pointsd',
			'label' => 'Product Points',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[9999]',

			'errors' => array(
                        'required' => 'Please Enter Points For Discount<br/>',	
						'numeric' => 'Please Enter Numbers Only<br/>',
            ),
			)
		);
		}
		else{
			$config=array(
			array(
			'field' => 'idiscount',
			'label' => 'Discount',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[100]',

			'errors' => array(
                        'required' => 'Please Enter Discount<br/>',
						'numeric' => 'Please Enter Numbers Only<br/>',
			
            ),
			),			
			array(
			'field' => 'pointsd',
			'label' => 'Product Points',

			'rules' => 'required|numeric|is_natural|greater_than_equal_to[0]|less_than_equal_to[9999]',

			'errors' => array(
                        'required' => 'Please Enter Points For Discount<br/>',	
						'numeric' => 'Please Enter Numbers Only<br/>',
            ),
			)
		);
		}
		
		$fileuploaded=$this->uploadProductImage('disimg');
		$data['up']['disimg']=$fileuploaded;
		
		$data['up']['proimg']['upload_error']='';
		
		
		
		$this->form_validation->set_rules($config);		 
		if($this->form_validation->run()==TRUE && ($fileuploaded['upload_error']==NULL || $fileuploaded['upload_data']['file_name']==NULL) ){
			
			$this->form_validation->set_message('idiscount', 'The {field} already exist<br/>');
			
			$idiscount=$this->input->post('idiscount');			
			$pointsd=$this->input->post('pointsd');		
			$disimguploaded=$data['up']['disimg']['upload_data']['file_name'];		
 			if(!empty($edit_did)){
				//update discount
				$result=$this->sponsor->update_product($id, $idiscount,$pointsd, $idiscount, $edit_did, $disimguploaded);
				if($result)
				{
					$this->session->set_flashdata('successupdatediscount', 'Discount Successfully Updated!');
				}
				else
				{	
					$this->session->set_flashdata('errorupdatediscount', 'Discount Not Updated!');
				}
			}else{
				//add discount
				//$curr and $price added in $this->sponsor->add_product() as parameters by Pranali for SMC-3717
				$curr='';
				$price=0;
				$revenue_percent=0;
				$revenue_per_visit=0;
				$result=$this->sponsor->add_product($id, 'discount', $idiscount, $idiscount, $pointsd, $price ,$curr, $disimguploaded, $revenue_percent, $revenue_per_visit);
				if(!$result){
					echo "<script>alert('Please Update Product Category In Sponsor Profile');</script>";			
				}
				if($result)
				{
					$this->session->set_flashdata('successdiscount', 'Discount Successfully Added!');
				}
				else
				{	
					$this->session->set_flashdata('errordiscount', 'Discount Not Added!');
				}
			} 	

			redirect('/Csponsor/page/product_setup', 'location', 301); 
				
		}	
		$data['currencies']=$this->sponsor->currencies('');
		$data['reset']=true;
		$this->load->view('sp/product_setup',$data);
		$this->load->view('sp/footer'); 
	}
	
	public function discount_check($str, $update){
		//if($update==""){
		$id=$this->id;
		$this->load->model('sp/sponsor');
		$rows=$this->sponsor->is_valid_discount($id, $str);
		if(!$rows){
			return true;
		}else{
			$this->form_validation->set_message('discount_check', 'The {field} already exist<br/>');
			return false;
		}
		//}else{
		//	return true;
		//}
	}
	public function init_coupon_setup(){			
			//$upload_data = new ArrayObject();			
			//$upload_data=new \stdClass;
			$upload_data=(object)[];
			$upload_data->product_type=1;
			$upload_data->name='';
			// VaibhavG added new date format to startdate & enddate for ticket number SMC-3486 26Sept18 6:36PM
			$upload_data->startdate=CURRENT_TIMESTAMP;
			$upload_data->enddate=date("Y-m-d H:i:s", strtotime('+6 months', time()));
			$upload_data->currency=1;
			$upload_data->price=0;
			$upload_data->points=0;
			$upload_data->discount=100;
			$upload_data->buy=0;
			$upload_data->buy_get=0;
			$upload_data->offer_description='';
			$upload_data->daily_limit=1000;
			$upload_data->total_coupons=1000;
			$upload_data->uniquecode=0;
			$upload_data->file_name='new-product.jpg';
			$upload_data->fileerror='';
			$upload_data->up=0;
			$upload_data->currency_value='INR';
			$upload_data->category_value='Food';
			$upload_data->formerror='';
			return $upload_data;
	}
	public function datediffr($date1,$date2){
	
	$datetime1=trim(@$date1);//todays date
	$datetime2=trim(@$date2);//last date
	$DateDiff = floor( strtotime(@$datetime2 ) - strtotime( @$datetime1 ) ) / 86400 ;
	$d=@$DateDiff;
	return $d;

	}
	public function add_coupon(){
		$this->load->model('sp/sponsor');
		$id=$this->id;
		$data=$this->headerData($id);	

		$data['categories']=$this->sponsor->categories('');
		$data['currencies']=$this->sponsor->currencies('');
	
		$this->load->helper('form');
		$this->load->library('form_validation');		
		$up=$this->input->post('up');
//added validation for Product Category by Pranali for bug SMC-3621
		$prodCategory = $this->input->post('product_type');
		$this->form_validation->set_rules('product_type', 'Product Category', 'required|callback_selectValid',array('required' => 'Please Choose Product Category.'));
		
		
		$config1=array(
			/*array(
			'field' => 'product_type',
			'label' => 'Product Category',
			'rules' => 'required|callback_selectValid',
			'errors' => array(
                        'required' => 'Please Choose Product Category<br/>',			
            ),
			),*/
//is_unique added by Pranali for SMC-3677 on 17-01-2019			
			array(
			'field' => 'name',
			'label' => 'Product Name',
			'rules' => 'required|trim',
			'errors' => array(
                        'required' => 'Please Enter %s.<br/>'			
            ),
			),
			array(
			'field' => 'startdate',
			'label' => 'Start Date',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter Start Date<br/>',			
            ),
			),
			array(
			'field' => 'enddate',
			'label' => 'End Date',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter End Date<br/>',			
            ),
			),
			array(
			'field' => 'points',
			'label' => 'Points',
			'rules' => 'required',
			'errors' => array(
                        'required' => 'Please Enter Points For Offer<br/>',			
            ),
			),
			array(
			'field' => 'price',
			'label' => 'Product Price',
			'rules' => 'numeric|greater_than[0]|required',
			'errors' => array(
                        'required' => 'Please Enter Product Price<br/>',	
						'numeric' => 'Please Enter Valid Product Price<br/>',
						'greater_than[0]' => 'Please Enter Valid Product Price<br/>',							
            ),
			),
			
			array(
			'field' => 'discount',
			'label' => 'Discount',
			'rules' => 'greater_than_equal_to[0]|less_than_equal_to[100]',
			'errors' => array(
                        'greater_than_equal_to[0]' => 'Please Enter Valid Discount<br/>',
						'less_than_equal_to[100]' => 'Please Enter Valid Discount<br/>',	
            ),
			),
			
			array(
			'field' => 'buy',
			'label' => 'Buy Value',
			'rules' => 'is_natural',
			'errors' => array(
                        'is_natural' => 'Please Enter Valid Buy Value<br/>',			
            ),
			),
			
			array(
			'field' => 'buy_get',
			'label' => 'Buy-Get Value',
			'rules' => 'is_natural',
			'errors' => array(
                        'is_natural' => 'Please Enter Valid Buy-Get Value<br/>',			
            ),
			),
			
			array(
			'field' => 'offer_description',
			'label' => 'Description',
			'rules' => 'alpha_numeric_spaces',
			'errors' => array(
                        'alpha_numeric_spaces' => 'CheckOut For Invalid Symbols<br/>',			
            ),
			),
			
			array(
			'field' => 'daily_limit',
			'label' => 'Description',
			'rules' => 'is_natural',
			'errors' => array(
                        'is_natural' => 'CheckOut For Invalid Symbols<br/>',			
            ),
			),
			
			array(
			'field' => 'total_coupons',
			'label' => 'Description',
			'rules' => 'is_natural',
			'errors' => array(
                        'is_natural' => 'CheckOut For Invalid Symbols<br/>',			
            ),
			),
			
			array(
			'field' => 'uniquecode',
			'label' => 'Description',
			'rules' => 'alpha_numeric',
			'errors' => array(
                        'alpha_numeric' => 'CheckOut For Invalid Symbols<br/>',			
            ),
			),		
			
		);
		

			$this->form_validation->set_rules($config1);
			
			$upload_data=(object)[];
				$upload_data->product_type=$this->input->post('product_type');
				$upload_data->name=$this->input->post('name');
				$upload_data->startdate=$this->input->post('startdate');
				//added below code for SMC-3622 by Pranali
				$startdate = $this->input->post('startdate');
				
				if (strlen($startdate) <  13 ) {
					$startdate = $startdate . "00:00:00";
				}
				
				$startdate=date("Y-m-d H:i:s",strtotime($startdate));	
			
				$upload_data->startdate = $startdate;
				
				
				$upload_data->enddate=$this->input->post('enddate');
				$enddate = $this->input->post('enddate');
				
				if (strlen($enddate) <  13 ) {
					$enddate = $enddate . "00:00:00";
				}
				
				$enddate=date("Y-m-d H:i:s",strtotime($enddate));	
			
				$upload_data->enddate = $enddate;
				//changes end for SMC-3622
				$upload_data->currency=$this->input->post('currency');
				$upload_data->price=$this->input->post('price');
				$upload_data->points=$this->input->post('points');
				$upload_data->discount=$this->input->post('discount');
				$upload_data->buy=$this->input->post('buy');
				$upload_data->buy_get=$this->input->post('buy_get');
				$upload_data->offer_description=$this->input->post('offer_description');
				$upload_data->daily_limit=$this->input->post('daily_limit');
				$upload_data->total_coupons=$this->input->post('total_coupons');
				$upload_data->uniquecode=$this->input->post('uniquecode');
				
				$upload_data->currency_value=$this->sponsor->currencies($upload_data->currency);
				$upload_data->category_value=$this->sponsor->categories($upload_data->product_type);
				
				
				$fileuploaded=$this->uploadProductImage('file');
				
				if($fileuploaded['upload_error']==NULL || $fileuploaded['upload_data']['file_name']==NULL  ){
					if($fileuploaded['upload_data']['file_name']==NULL){
						$upload_data->file_name=$this->input->post('proimg');
					}else{
						$upload_data->file_name=$fileuploaded['upload_data']['file_name'];
					}										
					$upload_data->fileerror='';
				}else{
					
					$upload_data->fileerror=$fileuploaded['upload_error'];
					$upload_data->file_name=$this->input->post('proimg');
				}		
				
				$upload_data->up=$this->input->post('up');	
				
				$upload_data->formerror='';				
				$data['cdata']=$upload_data;
				
				
				if($upload_data->discount<=0 and ($upload_data->buy==0 or $upload_data->buy_get==0)){
					$upload_data->formerror='Please Give A Valid Offer';
				}
				
				$datediff=@$this->datediffr($upload_data->startdate,$upload_data->enddate);
				if($datediff<0){
					$upload_data->formerror.="<br/>".'Check Start And End Date';
				}

				// VaibhavG added new date format to datediffr for ticket number SMC-3486 26Sept18 6:34PM
				$datediff1=@$this->datediffr(date("Y-m-d H:i:s",time()),$upload_data->enddate);

				if($datediff1<0){
					$upload_data->formerror.="<br/>".'End Date Should Be Greater Than or equal to Today\'s Date';
				}
				//Added below if condition code by Pranali for SMC-4819
				if($up==''){
					$coupon_details=$this->sponsor->get_coupon($id, $up);
					if(trim($coupon_details[0]->Sponser_product) == trim($upload_data->name) )
					{
						$upload_data->formerror.="<br/>".'This product name already exists';
					}
				}

                if ($this->form_validation->run()==TRUE and $upload_data->formerror=='' and $upload_data->fileerror==''){
					
						$this->sponsor->add_coupon($id, $data);	
						$this->load->view('sp/coupon_preview',$data);
						$this->load->view('sp/footer');						
                }else{
					
						$this->load->view('sp/sp_coupon',$data);
						$this->load->view('sp/footer');   
                }

	}
	public function selectValid($index){
		// '' is the first option that is default "-------Choose ------"

			if($index=="")
			{
				$this->form_validation->set_message('product_type', 'Please Choose category.');
				return false;
			}
			else
			{
				// User picked something.
				return true;
			}
	}
	//End code for SMC-3621
	public function edit_coupon($cid){
		$this->load->model('sp/sponsor');		
		$r=@$this->sponsor->get_coupon($this->id, $cid);		
		$data=$this->headerData($this->id);	
		if(!empty($r)){
			$upload_data=(object)[];
			$upload_data->product_type=@$r[0]->category;
			$upload_data->name=@$r[0]->Sponser_product;
			$upload_data->startdate=@$r[0]->sponsered_date;
			$upload_data->enddate=@$r[0]->valid_until;
			$upload_data->currency=@$r[0]->currency;
			$upload_data->price=@$r[0]->product_price;
			$upload_data->points=@$r[0]->points_per_product;
			$upload_data->discount=@$r[0]->discount;
			$upload_data->buy=@$r[0]->buy;
			$upload_data->buy_get=@$r[0]->get;
			$upload_data->offer_description=@$r[0]->offer_description;
			$upload_data->daily_limit=@$r[0]->daily_limit;
			$upload_data->total_coupons=@$r[0]->total_coupons;
			$upload_data->uniquecode=@$r[0]->coupon_code_ifunique;
			$upload_data->file_name=@$r[0]->product_image;
			$upload_data->fileerror='';
			$upload_data->up=$cid;
			$upload_data->formerror='';
			$upload_data->currency_value=$this->sponsor->currencies(@$r[0]->currency);
			$upload_data->category_value=$this->sponsor->categories(@$r[0]->category);		
					$data['categories']=$this->sponsor->categories('');
					$data['currencies']=$this->sponsor->currencies('');
					$data['cdata']=$upload_data;
			$this->load->view('sp/sp_coupon',$data);
		}else{
			$this->load->view('sp/wrong',$data);
		}
			$this->load->view('sp/footer'); 		
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
	public function edit_prof(){
		$this->load->model('sp/sponsor');
		$id=$this->id;
		$data=$this->headerData($id);	

		$data['categories']=$this->sponsor->categories('');
		$data['currencies']=$this->sponsor->currencies('');
	
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');	
				
		$config=array(	
			array(
			'field' => 'sp_name',
			'label' => 'Owner Name',
			'rules' => 'required|max_length[50]',
			'errors' => array(
                        'required' => 'Please Enter Sponsor Name<br/>',			
            ),
			),
			array(
			'field' => 'sp_company',
			'label' => 'Company Name',
			'rules' => 'required|max_length[50]',
			'errors' => array(
                        'required' => 'Please Enter Company Name<br/>',			
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
			'rules' => 'valid_url',
			'errors' => array(
						'valid_url' => 'Please Enter valid website with http:// OR https://<br/>',	
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
			'label' => 'PIN/ZIP',
			'rules' => 'trim|is_numeric|max_length[15]',
			),		
			array(
			'field' => 'sp_landline',
			'label' => 'Landline',
			'rules' => 'trim|is_numeric|max_length[15]',
			),				

		);
		
				$this->form_validation->set_rules($config);	

				$myData=(object)[];				
				$myData->sp_name=$this->input->post('sp_name');
				$myData->sp_company=$this->input->post('sp_company');
				$myData->sp_landline=$this->input->post('sp_landline');
				$myData->v_category=$this->input->post('v_category');
				$myData->sp_website=$this->input->post('sp_website');
				$myData->sp_address=$this->input->post('sp_address');
				$myData->sp_country=$this->input->post('sp_country');
				$myData->sp_state=$this->input->post('sp_state');
				$myData->sp_city=$this->input->post('sp_city');
				$myData->pin=$this->input->post('pin');		
				
				$revenue_percent = $this->input->post('Revenue_percent');
				$revenue_per_visit = $this->input->post('Revenue_visit');
				
				$revenue_array = array('revenue_percent'=>$revenue_percent,'revenue_per_visit'=>$revenue_per_visit);
				$data['myData']=$myData;
				
			    $this->sponsor->update_profile_revenue($this->id, $revenue_array);
                if ($this->form_validation->run()){
					$d=$this->sponsor->update_profile($this->id, $data['myData']);
					if($d)
					{
						$this->session->set_flashdata('successupdateprofile', 'Profile Successfully Updated!');
					}
					else
					{	
						$this->session->set_flashdata('errorupdateprofile', 'Profile Not Updated!');
					}
					redirect('/Csponsor/page/profile', 'location', 301);
                }else{
					$data['categories']=$this->sponsor->categories('');
					$data['countries']=$this->sponsor->countries();
					$data['states']=$this->sponsor->get_states($data['myData']->sp_country);
					$data['cities']=$this->sponsor->get_cities($data['myData']->sp_country,$data['myData']->sp_state);
				
					$this->load->view('sp/edit_profile',$data);
					$this->load->view('sp/footer');
                }
	}
	public function send_otp_phone(){
 		$cc=$this->input->post('cc');		
		$phone=$this->input->post('phone');
		$mob="/^[789][0-9]{9}$/";
		$this->load->model('sp/sponsor');
			
		if(!preg_match($mob, $phone)){ 
			echo "<span style='color:red;'>Check your Mobile number</span>";
		}else{
			$this->sponsor->send_otp_phone($this->id, $cc, $phone);
			echo "<span style='color:green;'>OTP Sent</span>";
		} 
	}
	public function send_otp_email(){			
		$email=$this->input->post('email');
		$mob='/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
		$this->load->model('sp/sponsor');		
		if(!preg_match($mob, $email)){ 
			echo $msg="<span style='color:red;'>Check your Email ID</span>";
		}else{
			$otp=$this->sponsor->send_otp_email($this->id, $email);
		
				$subject = 'Smart-Cookie Email Verification';
				$message = "Dear Sponsorer,\r\n\r\n".						
						  "Your OTP for Email Verification is: ".$otp."\n\n".						 
						  "Regards,\r\n".
						  "Smart Cookie Admin \n"."www.smartcookie.in";
				$headers = 'From: Smart-Cookie Admin <smartcookiesprogramme@gmail.com>' . "\r\n" .
					'Reply-To: smartcookiesprogramme@gmail.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				if (!mail($email, $subject, $message, $headers)){
				//echo $this->email->print_debugger(); 
						echo "<span style='color:red;'>Error Occured</span>";
				}else{
						echo "<span style='color:green;'>OTP Sent</span>";
				}
		}
	}
	public function verify_phone(){
		$otp=$this->input->post('sent_phone_otp');
		$this->load->model('sp/sponsor');
		$p=$this->sponsor->verify_phone($this->id,$otp);		
			if($p){
				echo "<span style='color:green;'>Verified! Thank You!</span>";
			}else{
				echo "<span style='color:red;'>Error Occured</span>";
			}				
	}
	public function verify_email(){
		$otp=$this->input->post('sent_email_otp');
		$this->load->model('sp/sponsor');
		$p=$this->sponsor->verify_email($this->id,$otp);		
			if($p){
				echo "<span style='color:green;'>Verified! Thank You!</span>";
			}else{
				echo "<span style='color:red;'>Error Occured</span>";
			}
	}
	public function change_password(){
		 $oldpass=$this->input->post('oldpass');
		 $newpass=$this->input->post('newpass');
		 $confpass=$this->input->post('confpass');		//echo $this->id;		//var_dump($_SESSION);		//echo $id = $_SESSION['id'];		//$this->load->model("sp/sponsor");		$data['user']= $this->sponsor->headerData($this->id);		echo "578654";		$this->email=$data['user'][0]->sp_email;				echo $this->email;		echo "ruigt";
		if($newpass!='' and $confpass!='' and $oldpass!=''){
			if(!($newpass===$confpass)){
				echo "<span style='color:red;'>Password Didn't Match</span>";
			}else{
				$this->load->model('sp/sponsor');
				$p=$this->sponsor->change_password($this->id, $this->email, $oldpass,$confpass);
				if($p){
					echo "<span style='color:green;'>Password Changed! Thank You!</span>";
				}else{
					echo "<span style='color:red;'>Incorrect Password</span>";
				}
			}
		}else{
			echo "<span style='color:red;'>Please Enter Passwords</span>";
		}
	}
	public function update_profile_image(){	
		$this->load->model('sp/sponsor');
		$id=$this->id;
		
		$this->load->helper('form');
		$this->load->library('form_validation');	
				
		//$config['upload_path']          = './Assets/images/sp/profile/';
		$config['upload_path']          = './core/image_sponsor/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 900;				

                $this->load->library('upload', $config);
				$this->form_validation->set_rules($config);	
				
				if($this->upload->do_upload('file')){
					$image_loaded=true;
				}else{
					$image_loaded=false;					
				}
							
				if($image_loaded){
					$data['myData'][0]->sp_img_path=$this->upload->data('file_name');         
					$i=$this->sponsor->update_profile_image($id, $data['myData'][0]->sp_img_path);
                    if($i==1)
                    {
                        $this->session->set_flashdata('success_profile_img_update', 'Profile Image Updated Successfully!');
                    }
                    else 
                    {   
                        $this->session->set_flashdata('error_profile_img_update', 'Profile Image Not Updated Successfully!');
                    }
					redirect('/Csponsor/page/profile', 'location', 301);
				}else{							
					$data=$this->headerData($id);
					$data['myData']=$this->sponsor->myData($id);					
					$cat=$this->sponsor->categories($data['myData'][0]->v_category);
					$data['myData'][0]->v_category=$cat[0]->category;		
					$data['calling_code']=$this->sponsor->calling_code($data['myData'][0]->sp_country);
							
					$data['myData'][0]->fileerror=$this->upload->display_errors();
					$this->load->view('sp/profile',$data);				
					$this->load->view('sp/footer');	
				}						

	}
	
	/*
	* Author : Vaibhav G
	* funstion used for remove profile image of sponsor
	*/
	public  function remove_profile_image()
 
    {
        $this->load->library('upload');
        $this->load->model('sp/sponsor');
        $id=$this->id;
        
        $i=$this->sponsor->remove_profile_image($id);
        if($i==1)
        {
            $this->session->set_flashdata('success_profile_img_remove', 'Profile Image Removed Successfully!');
        }
        else 
        {   
            $this->session->set_flashdata('error_profile_img_remove', 'Profile Image Not Removed Successfully!');
        }
 
        $data=$this->headerData($id);
        $data['myData']=$this->sponsor->myData($id);                  
        $cat=$this->sponsor->categories($data['myData'][0]->v_category);
        $data['myData'][0]->v_category=$cat[0]->category;     
        $data['calling_code']=$this->sponsor->calling_code($data['myData'][0]->sp_country);
                
        $data['myData'][0]->fileerror=$this->upload->display_errors();
        $this->load->view('sp/profile',$data);        
 
 
    }
}


