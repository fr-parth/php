<?php
/**
 * User: Pravin
 * Date: 2017/09/09
 * Time: 8:45 P.M
 */
 defined('BASEPATH') OR exit('No direct script access allowed');
class Sponsors extends CI_Controller {
	
	function __construct()

    {

        parent::__construct();

        
		
        
    }
    function  index() {
		$this->load->model('sponsor');
		$data['sponsorlist']=$this->sponsor->sponsorlist();
		
		/*echo "<pre>";
		die(print_r($data['sponsorlist'],true));*/
		
        $this->load->view('sponsorlist',$data);
    }
	public function  proudsponsor()
	{
		$this->load->model('sp/sponsor');
		
		
			$id=$this->uri->segment(3);
			$data['user']= $this->sponsor->headerData($id);
		
			$data['product_details']=$this->sponsor->product($id);
		/*echo "<pre>";
		die(print_r($data['product_details'],true));*/
		$this->load->view('Sponsor_Gallary/sponsor',$data);
			
		
	}
	
}