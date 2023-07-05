<?php
/*
Author : Pranali Dalvi
Date Created : 05-01-2019
This file was created for registration of Spectator / Volunteer
*/
ob_start();
ob_end_clean();
defined('BASEPATH') OR exit('No direct script access allowed');
class Spectator extends CI_Controller {
	function __construct()
    {
        parent::__construct();
   
        $this->load->model('MSpectator');
		$this->load->library('form_validation');
	}
	function  index() {
		if($this->input->post('submit'))
		{
			$this->form_validation->set_rules('user_type', 'I am', 'trim|required');
			
			$this->form_validation->set_rules('user_name', 'Name', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
			
			$this->form_validation->set_rules('Contact', 'Mobile No', 'trim|required|numeric|greater_than[0]|exact_length[10]|is_unique[tbl_vol_spect_master.mobile]');
			
		}
		if($this->form_validation->run()==TRUE)
		{
				$user_name = $this->input->post('user_name');
				$user_type = $this->input->post('user_type');
				$contact = $this->input->post('Contact');
								
				$table = "tbl_vol_spect_master";
				$data = array('name'=>$user_name,'category'=>$user_type,'mobile'=>$contact,'registered_on'=>CURRENT_TIMESTAMP);
				$insert = $this->MSpectator->insert_data($table,$data);

				if($insert)
				{
					//$link="https://goo.gl/G6jpu2";
					//$this->messageUser($country_code, $contact, $link, $user_type ,$device_type);
					//redirect($link, 'refresh');
					$this->session->set_flashdata('success','Spectator registered successfully');
				}
		}
        
        $this->load->view('spectator_registration');
    }
}
?>