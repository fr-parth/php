<?php
ob_start();
ob_end_clean();
defined('BASEPATH') OR exit('No direct script access allowed');
class Download extends CI_Controller {
	function __construct()
    {
        parent::__construct();
   
        $this->load->model('Teacher');
        $this->load->model('slp/Msalesperson');
		$this->load->library('form_validation');
	}
    function  index() {
		//data insertion done by Shivkumar on 20190102
		if($this->input->post('submit'))
		{
			$this->form_validation->set_rules('user_type', 'I am', 'trim|required');
			
			$this->form_validation->set_rules('user_name', 'Name', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
			//Below code is updated by Rutuja Jori & Sayali Balkawade(PHP Interns) for Bug SMC-3578 on 26/04/2019
			
			$this->form_validation->set_rules('device_type', 'Mobile', 'trim|required');
			$this->form_validation->set_rules('Country_Code', 'Country', 'trim|required');
			$this->form_validation->set_rules('Contact', 'Contact Number', 'trim|required|numeric|greater_than[0]|min_length[10]|max_length[12]');
			$this->form_validation->set_rules('email', 'Email Id', 'trim|valid_email');

			if($this->form_validation->run()!=false)
			{
				$user_name = $this->input->post('user_name');
				$user_type = $this->input->post('user_type');
				$device_type = $this->input->post('device_type');
				$country_code = $this->input->post('Country_Code');
				$contact = $this->input->post('Contact');
				$email = $this->input->post('email');
				$link = $this->input->post('link');
				
				$table = "tbl_app_downloads";
				$data = array('user_name'=>$user_name,'user_type'=>$user_type,'device_type'=>$device_type,'country_code'=>$country_code,'contact_number'=>$contact,'email'=>$email,'datetime'=>CURRENT_TIMESTAMP);
				$insert = $this->Teacher->insert_query($table,$data);

				if($insert)
				{
					$this->messageUser($country_code, $contact, $link, $user_type ,$device_type);
					redirect($link, 'refresh');
				}
			}
		}
		
        //$this->load->model('tenant');
        //$data['tenants']= $this->tenant->getTenants(); //Get rid of Echo
        $this->load->view('acceptedhere');
    }

	function messageUser($cc, $phone, $link, $user_type , $device_type)
	{
		switch ($cc) {
			case 91:
				$Text = "Thank+you+for+choosing+smartcookie.+Following+is+link+for+$device_type+app+for+$user_type+Now:+$link";
				/*Below getdynamic function added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$dynamic=$this->Msalesperson->getdynamic();		
						$dynamic_user=$dynamic[0]->mobileno; 
						$dynamic_pass=$dynamic[0]->email; 
						$dynamic_sender=$dynamic[0]->otp;

				$url = "http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
				file_get_contents($url);
				break;
			case 1:
				$ApiVersion = "2010-04-01";
				// set our AccountSid and AuthToken
				$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
				$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
				// instantiate a new Twilio Rest Client
				$client = new TwilioRestClient($AccountSid, $AuthToken);
				$number = "+1" . $phone;
				$message = "Thank you for choosing smartcookie. Following is link for .$device_type. app for .$user_type. Now: . $link .";
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
					"POST", array(
						"To" => $number,
						"From" => "732-798-7878",
						"Body" => $message
					));
				break;
		}
	}
}