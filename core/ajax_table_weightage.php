<?php
// add file for SMC-4203 By Kunal
include 'conn.php';
error_reporting(0);
$tbl = $_POST['tbls'];
$query_dtweight = "SELECT weightage FROM tbl_datafile_weightage where tbl_name='$tbl'";
				$sql_dtweight = mysql_query($query_dtweight);
$res_dtwieght = mysql_fetch_row($sql_dtweight);

echo json_decode($res_dtwieght[0]);