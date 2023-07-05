<?php
//error_open.php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=students_with_incosistent_data".date("Ymd").".xls");
include 'conn.php';

$sel_sub1 = mysql_query("SELECT DISTINCT student_id FROM `tbl_student_subject_master` WHERE `school_id`=\"55\" ");

?><table>
<tr><td>Student PRN</td></tr> 
<?php
while($sel_sub = mysql_fetch_array($sel_sub1)){

$stud=$sel_sub['student_id'];

$query = "SELECT std_PRN, std_name from tbl_student where std_PRN=$stud";
$result = mysql_query($query);
?>


<?php
if(!(mysql_num_rows($result) > 0)){ 

?>
   <tr><td><?php echo $stud; ?></td><td>NOT FOUND</td></tr> 

<?php	}elseif(mysql_num_rows($result) > 0){ ?>
	  <tr><td><?php echo $stud; ?></td><td>FOUND</td></tr> 
<?php	
}else{ ?>
<tr><td><?php echo $stud; ?></td><td>ERROR OCCURED</td></tr> 
<?php
}
?>
</table>
