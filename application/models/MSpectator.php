<?php
/*
Author : Pranali Dalvi
Date Created : 05-01-2019
This file was created for registration of Spectator / Volunteer
*/
ob_start();
class MSpectator extends CI_Model
{
	public function insert_data($table,$data)
	{
		$this->db->insert($table,$data);
		return TRUE;
	}
}
?>