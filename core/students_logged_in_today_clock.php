<?php

	require 'conn.php';
	
function get_url_contents($url) {
    $crl = curl_init();

    curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}



$site = $_SERVER['HTTP_HOST'];

$date = date("Y-m-d");

$sql = mysql_query("select count(1) as student_count from tbl_LoginStatus where LatestLoginTime like '%$date%'");

$res = mysql_fetch_assoc($sql);

$student_count = $res['student_count'];

$url = "http:125.99.68.2:8081/$student_count";

$res = get_url_contents($url);


?>