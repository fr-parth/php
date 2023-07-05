<?php
/**
 * Created by PhpStorm.
 * User: Rohit
 * Date: 7/29/2017
 * Time: 9:03 PM
 */
class Acceptedhere extends CI_Controller {
    function  index() {
        //$this->load->model('tenant');
        //$data['tenants']= $this->tenant->getTenants(); //Get rid of Echo
        $this->load->view('acceptedhere');
    }
}