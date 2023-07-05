<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	
	
	public function __construct()
		{

        parent::__construct(); 
       	$this->load->model('entity');
        $this->load->model('Student');	 
		
		}
      
	
	        public function index()
			{
				$row1['img'] = $this->Student->get_scl_image(); 
				$this->load->view('index',$row1);	
				
			}

			public function login($entity)
			{
				$data['entity']=$entity;
				$this->load->view('login',$data);
				
			}
	// 		public function sql_schoolimg()
    //    {  
    //        $row1['img'] = $this->entity->get_scl_image();  
    //        $this->load->view('index' , $row1); 
    //    }
    
 
			
       public function Login_new_user()
       {  
           $row['schoolList'] = $this->Student->studentSchoolListinfo();  
           $this->load->view('newUserLogin' , $row); 
       }
 
        public function login_validation()
		{ 
				$this->load->library('form_validation');
				$this->form_validation->set_rules('entity', 'entity', 'required');
				$this->form_validation->set_rules('username','Username','required|callback_validate_credentials');
				$this->form_validation->set_rules('password','Password','required');

			
			$entity=$this->input->post('entity');
			$data['entity']=$entity;
			if($entity=='select'){
				
				$this->load->view('login',$data);
			}
			
			if($entity=='teacher'){
				$this->load->view('login',$data);
			}
			
			
			if($entity=='student')
			{
				if($this->form_validation->run()!=false)
				{
					$data=array(
						'username'=> $this->input->post('username'),
						'is_loggen_in'=>1,
						'entity'=> $this->input->post('entity'),
										
							);

					$this->session->set_userdata($data);

							
					redirect('main/members');
				}
				else
				{
						$this->load->view('login',$data);
				}
				
			}
			
				if($entity=='sponsor')
				{
					
						if($this->form_validation->run()!=false)
						{
							$data=array(
								'logged_in'=> TRUE,
								'entity'=> $this->input->post('entity'),
												
							);
							$this->session->set_userdata($data);									
							redirect('/Allshops', 'location', 301);
						}
						else
						{
								$this->load->view('login',$data);
						}
					
				}
				
				

		}



 		public function validate_credentials()
		{
			
		$entity=$this->input->post('entity');
		
	
				
		$row['info']=$this->entity->can_log_in();
		
		
		if($row['info']!='')
		{
					
					if($entity=='student')
					{
					$std_PRN=$row['info'][0]->std_PRN;
					$stud_id=$row['info'][0]->id;
					
					

							if($std_PRN!='' && $stud_id!='')
							{
								$newdata = array(
                 			  	'std_PRN'  => $std_PRN,
								'stud_id' =>$stud_id
                  
             					  );

								$this->session->set_userdata($newdata);
								
								
							}
							else
							{
								$this->form_validation->set_message('validate_credentials','Incorrect Username and Password');
								return false;
							}
							
					}
					
					if($entity=='teacher')
					{
						
					}
					
					
					if($entity=='sponsor')
					{
						
						
						
						$id=$row['info'];
									

							if($id!='')
							{
								$newdata = array(
                 			  	'ids'  => $id, 
             					  );
								$this->session->set_userdata($newdata);
								
								
							}
							else
							{
								$this->form_validation->set_message('validate_credentials','Incorrect Username and Password');
								return false;
							}
						
						
						
					}
					
					
					}
					
					else
					{
						$this->form_validation->set_message('validate_credentials','Incorrect Username and Password');
						return false;
					}

			
		}
			

}