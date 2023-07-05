<?php

$con = mysql_connect("Tsmartcookies.db.7121184.hostedresource.com","Tsmartcookies","Bpsi@1234")
		or die('Cannot connect to the DB');
mysql_select_db("Tsmartcookies",$con); 

$q=mysql_query("Select std_PRN from tbl_student");
$e=0;
$n=0;

$year=date('Y');
$entity="Student";
$college="COEP";
$start_dir="Images";
$path=$start_dir.'/'.$college.'/'.$entity.'/'.$year.'/';
if(!file_exists($path)){
	mkdir($path, 0777, true);
}

while($r=mysql_fetch_array($q)){
	$i=trim($r['std_PRN']);
	$file = $college.'_'.$i.'.png';	
	$filename=$path.$file;
		if (file_exists($filename)) {
			$e+=1;					
		//mysql_query("update tbl_student set std_img_path='$filename' where std_PRN='$i'");
			
		} else {
			$n+=1;
			//echo $i."<br/>";
		}

}
echo 'You have uploaded '.$start_dir.' for '.$e.' '.$entity." <br/>";
echo 'You haven\'t uploaded '.$start_dir.' for '.$n.' '.$entity." <br/>";
?>