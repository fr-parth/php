<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservices_V5 extends CI_Controller {
 
   public function __construct()
   {
      parent::__construct();
	  //$this->load->model('Media_model');
	  //$this->load->model('Webservice_model');
   }
    
    
	//webservices for android
    public function send_request_to_join_smartcookie()
    {  
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);
         
	 
		$senderID      = $obj['sender_member_id'];
		$senderEntID   = $obj['sender_entity_id'];
		$recEntID      = $obj['receiver_entity_id'];
		$recConCode    = $obj['receiver_country_code'];
		$recMobNum     = $obj['receiver_mobile_number'];
		$recEmailID    = $obj['receiver_email_id'];
		$firstName     = $obj['firstname'];
		$middleName    = $obj['middlename'];
		$lastName      = $obj['lastname'];
		$platformSor   = $obj['platform_source'];
		$reqStatus     = $obj['request_status'];
		
		$data  =  array(
	
		$senderID      = $obj['sender_member_id'],
		$senderEntID   = $obj['sender_entity_id'],
		$recEntID      = $obj['receiver_entity_id'],
		$recConCode    = $obj['receiver_country_code'],
		$recMobNum     = $obj['receiver_mobile_number'],
		$recEmailID    = $obj['receiver_email_id'],
		$firstName     = $obj['firstname'],
		$middleName    = $obj['middlename'],
		$lastName      = $obj['lastname'],
		$platformSor   = $obj['platform_source'],
		$reqStatus     = $obj['request_status'],
		$issue_date = CURRENT_TIMESTAMP
		);
		          
    } 
	
	
	
	
	  
	
	
}