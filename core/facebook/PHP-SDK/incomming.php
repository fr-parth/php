<?php
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	
	mysql_connect("ivrapp.db.7121184.hostedresource.com","ivrapp","Ivrdb@123");
mysql_select_db("ivrapp");
	
	 $arr=mysql_query("select temp,DR_ID,thank_you_message,active,path from tbl_template where ph_number='".$_REQUEST['To']."' and temp_id='111'");
	$row=mysql_fetch_array($arr);
	$arr1=mysql_query("select * from tbl_practice where PRT_ID='".$row['DR_ID']."'");
	$row1=mysql_fetch_array($arr1);
	$practice=$row1['PRT_HOSPITALNAME'];
	$practice1=$row1['PRT_NAME'];
	$practice2=$row1['PRT_CITY'];
	$voice="woman";
	$active=$row['active'];
	$file=$row['thank_you_message'];
	$path=$row['path'];
	$pid=$row1['PRT_ID'].".mp3";
	$arr_away=mysql_query("select * from tbl_option where DR_ID='".$row['DR_ID']."'");
	$row_away=mysql_fetch_array($arr_away);
	$prt_date=$row_away['dateofreturn'];
	$dr_flag=$row_away['dr_flag'];
	$time=$row_away['replay_time'];
	
	 $arr_a=mysql_query("select temp,DR_ID,thank_you_message,active,path from tbl_template where ph_number='".$_REQUEST['To']."' and temp_id='AT'");
	$row_a=mysql_fetch_array($arr_a);
	
	 $arr_RWT=mysql_query("select temp,DR_ID,thank_you_message,active,path from tbl_template where ph_number='".$_REQUEST['To']."' and temp_id='RWT'");
	$row_RWT=mysql_fetch_array($arr_RWT);
	$rwt=$row_RWT['temp'];
?>
<Response>
 <Gather numDigits="1" action="incomming_call_transfer.php" method="POST">

 


<?php
if($active==0){
if($dr_flag=='Yes')
{
 $strs = str_replace('<Dateofreturn>', $prt_date, $row_a['temp']);
$str1 = str_replace('<LOCATION>', $practice2, $strs);
$str2 = str_replace('<DOCTORNAME>', $practice1, $str1);
   $str = str_replace('<PRACTICE>', $practice, $str2);
  
 echo "<Say voice='$voice'>$str</Say>";
 ?>
  <Pause length="<?php echo $time;?>"/>
   <?php
    echo "<Say voice='$voice'>$rwt</Say>";

 }
 else
 {
 
$str1 = str_replace('<LOCATION>', $practice2, $row['temp']);
$str2 = str_replace('<DOCTORNAME>', $practice1, $str1);
   $str = str_replace('<PRACTICE>', $practice, $str2);
  
 echo "<Say voice='$voice'>$str</Say>";
 ?>
  <Pause length="<?php echo $time;?>"/>
   <?php
    echo "<Say voice='$voice'>$rwt</Say>";
   
 }
 }
 if($active==1){
 if($file==''){
  $strs = str_replace('<Dateofreturn>', $prt_date, $row['temp']);
$str1 = str_replace('<LOCATION>', $practice2, $strs);
 $str1 = str_replace('<LOCATION>', $practice2, $row['temp']);
$str2 = str_replace('<DOCTORNAME>', $practice1, $str1);
   $str = str_replace('<PRACTICE>', $practice, $str2);
 echo "<Say voice='$voice'>$str</Say>";
 }else{
 echo "<Play>$file</Play>";
 }
 }
  if($active==2){
 if($path==''){
  $strs = str_replace('<Dateofreturn>', $prt_date, $row['temp']);
$str1 = str_replace('<LOCATION>', $practice2, $strs);
 $str1 = str_replace('<LOCATION>', $practice2, $row['temp']);
$str2 = str_replace('<DOCTORNAME>', $practice1, $str1);
   $str = str_replace('<PRACTICE>', $practice, $str2);
 echo "<Say voice='$voice'>$str</Say>";
 }else{
 echo "<Play>$path/this.mp3</Play>";
 echo "<Play>$path/$pid</Play>";
 echo "<Play>$path/welcome_template.mp3</Play>";
 }
 }
 ?>
  
</Gather>
	
</Response>