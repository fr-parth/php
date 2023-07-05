<?php
/**

 * User: Pravin
 * Date: 17/01/2017
 * Time: 9:41 PM
 */
class Preferredsponsors extends CI_Controller {
    function  index() {
        //$this->load->model('tenant');
        //$data['tenants']= $this->tenant->getTenants(); //Get rid of Echo
        $this->load->view('preferredsponsors');
    }
}