<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback360 extends CI_Controller
{
	
	
	public function __construct()
		{

        parent::__construct();
//       	$this->load->model('entity');
//        $this->load->model('Student');	   
		
		}
      
	
	        public function index()
			{
				$this->load->view('aicte360_feedback');	 
			}
 			
 			public function Past_Webinar()
			{
				$this->load->view('past_webinar');	 
			}

			public function Upcoming_Events()
			{
				$this->load->view('upcoming_events');	 
			}
 

}