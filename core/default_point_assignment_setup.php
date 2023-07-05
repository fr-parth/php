<?php
$successreport="";
//include 'scadmin_header.php';
$school_id=$_SESSION['school_id'];

if(isset($_GET['rd'])){
	$rd=$_GET['rd'];
	if($rd==1){
	mysql_query("DELETE FROM `tbl_master` WHERE school_id='$school_id' AND activity_id=0 AND subject_id =0");
		header("Location:".htmlspecialchars($_SERVER['PHP_SELF']));
	}
}

if(isset($_POST['submit'])){
	$total_ranges=$_POST['total_ranges'];	
	$method_id = $_POST['method_id'];
	$sch_id = $_POST['school_id'];

	
for($i=1;$i<=$total_ranges; $i++){
$mid = $_POST['mid'.$i];
$from = $_POST['from'.$i];
$to = $_POST['to'.$i];
$points = $_POST['points'.$i];

//select query added, update & insert query and if condition modified by Pranali for SMC-4210 on 29-11-19  
$query=mysql_query("SELECT id FROM `tbl_master` WHERE from_range='$from' AND to_range='$to' AND points='$points' AND method_id='$method_id' AND school_id='$school_id' AND activity_id='0' AND subject_id='0'");
$cnt=mysql_num_rows($query);

if($school_id!='0' && $cnt>0){
	
$p=mysql_query("update `tbl_master` set from_range='$from',to_range='$to', points='$points' where method_id='$method_id' and school_id='$school_id' and activity_id='0' and subject_id='0' "); 
$add='Updated'; 	
}else{
	
$p=mysql_query("insert into `tbl_master`(school_id,method_id,range_id,from_range,to_range,points,activity_id,subject_id) values('$school_id', '$method_id', 0, '$from', '$to', '$points',0,0 )");
$add='Added'; 	
}
		if($p)
		{
			$successreport="Successfully $add";
		}
		else
		{
			$successreport="Point Range Not Added";
		}
	}
}

?>
<script>
$(function() {
	$("#method1").change(function() {
  var category= document.getElementById('method1').value;
	// document.category.submit();
	    getRanges(category);
    })

});
</script>
<script>
function getRanges(xx)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("range").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","get_range_data.php?method="+xx,true);
xmlhttp.send();
}
</script>
<?php
function isDefaultSet(){
	global $school_id;
	$rem=0;
	
for($method_id=2;$method_id<=4; $method_id++){	

	$val= mysql_query("SELECT m.id FROM tbl_master m JOIN tbl_method t on t.id=m.method_id WHERE t.id ='$method_id' AND m.activity_id='0' AND m.subject_id='0' AND m.school_id='$school_id'");
	$rows = mysql_num_rows($val);
	$methods=array();
	if($rows==0){
		$val1=mysql_query("select method_name from tbl_method where `id`='$method_id'");
		$arr=mysql_fetch_array($val1);
		$method_name=$arr['method_name'];
		$methods[$method_id]=$method_name;	
			
	}
	foreach($methods as $key =>$values){
		echo "<i>Set defaults points for ".$values."</i><br/>";
	}
}

}
?>
<div class="container">
<div class="col-md-12">
<div class="panel panel-info" >
<div class="panel panel-heading">
Default Point Assignment Setup
</div>

<div class="panel-body">
<?php isDefaultSet(); ?>
<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?rd=1" class="btn btn-default btn-sm">Reset</a><br/>
					<form id="method2" action="" name="method2" method="get">
                    <select class="form-control btn-sm" style=""  name="method1" id="method1"> 
					<option ><strong>Select Method</strong></option>
					<?php $tbl_method=mysql_query("SELECT * FROM `tbl_method` WHERE group_member_id='0' AND school_id='0' AND method_flag='Yes'");
						while($method_value=mysql_fetch_array($tbl_method)){
							$method_id=$method_value['id'];
							$method_name=$method_value['method_name'];
					?>
                         <option value="<?php echo $method_id; ?>"><?php echo $method_name; ?></option>
						<?php } ?>    
                    </select>
					</form>
<form name="range" id="range" method="post" >	
<div id="range" name="range" >
</div>
<div style="color:#090;">
<?php echo $successreport;?>
</div>
</form>
</div>
</div>			
</div>
</div>