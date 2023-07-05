<?php
error_reporting(0);
//include('conn.php');
include("sponsor_header.php");

$report="";	
$subject_id=$_GET['id'];

$id=$_SESSION['id'];
$query="select * from `tbl_sponsorer` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];
	


				
?> 
<html>
<head>

<style>
.dropdown {

    display: -webkit-flex; /* Safari */
    -webkit-align-items: center; /* Safari 7.0+ */
    display: flex;
    align-items: center;
}
.list-inline
{
display: inline-block; }
.dropdown{padding-left:45px;margin-top:15px;margin-bottom:30px;}
.dropdown1{padding-left:90px;margin-top:15px;}
.panel-heading{margin-top:5px;}



  </style>


</style>
<!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<title>LEADER BOARD::SMART COOKIES</title>
<script>
var school_id="<?php echo $school_id; ?>";
var time="allDuration";
var sub_id;
var activity_id;
var t = 0;
function ajax_subject()
{
      	if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp1=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp1.onreadystatechange=function()
          {
          if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
            {

         document.getElementById("dropdownMenu3").innerHTML  =xmlhttp1.responseText;
            }
          }
        xmlhttp1.open("GET","top10_stud_cookieadmin_ajax_subject.php?sc_id=" +school_id ,true);
        xmlhttp1.send();
}

function ajax_activity()
{
      	if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {

         document.getElementById("dropdownMenu4").innerHTML  =xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","top10_stud_cookieadmin_ajax_activity.php?sc_id=" +school_id ,true);
        xmlhttp2.send();
}

function display_top10_students()
{
		 // document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;
         t=0;
	     school_id =document.getElementById("dropdownMenu1").value;
		 /*$('#dropdownMenu2').get(0).selectedIndex = 0;*/
 		//alert(school_id);
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

         document.getElementById("top10_students").innerHTML  =xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","top10_stud_school_name_scadmin.php?school_id=" +school_id+"&time="+time ,true);
        xmlhttp.send();

}
function display_top10_students_wmy_wise()
{
		 // document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;

	   time =document.getElementById("dropdownMenu2").value;
       if(t==0)
       {
          display_top10_students() ;
       }
       if(t==1)
       {
          display_top10_students_subject_wise();
       }
       if(t==2)
       {
          display_top10_students_activity_wise() ;
       }

 		//alert(id);
	   /*	if (window.XMLHttpRequest)
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

         document.getElementById("top10_students").innerHTML  =xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","top10_stud_week_name_scadmin.php?check_id=" +time+","+school_id,true);
        xmlhttp.send();*/

}
function display_top10_students_subject_wise()
{
		 // document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;

        t=1;
	    sub_id =document.getElementById("dropdownMenu3").value;
	  // var sch_id =document.getElementById("school_id").value;

 		//alert(sub_id);
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

         document.getElementById("top10_students").innerHTML  =xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","top10_stud_subject_name_scadmin.php?subject_id=" +sub_id+","+school_id+"&time="+time,true);
        xmlhttp.send();

}
function display_top10_students_activity_wise()
{
		 // document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;

        t=2;
	    activity_id =document.getElementById("dropdownMenu4").value;
 		//alert(activity_id);
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

         document.getElementById("top10_students").innerHTML  =xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","top10_stud_activity_name_scadmin.php?sc_id=" +activity_id+","+school_id+"&time="+time ,true);
        xmlhttp.send();

}
function subjectChange()
{
    $('#dropdownMenu4').get(0).selectedIndex = 0;
    display_top10_students_subject_wise() ;
}

function ActivityChange()
{
    $('#dropdownMenu3').get(0).selectedIndex = 0;
    display_top10_students_activity_wise();
}

function onSchoolChange()
{
   display_top10_students();
   ajax_subject();
   ajax_activity();
}
</script>
</head>
<body onload="onSchoolChange();" bgcolor=#FFDD88>
<!--<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
     <!--<img src="image/newlogo1.png">--><!--<h1><font color="red" size=10>Smart</font> <font color="black" size=10>Cookie</font></h1></font>
      </div>
      <div class="panel-body" style="background-color:#FFDD88;color:#4D4B4A;text-align:center;padding:3px;">
      <small><b><font size=4>LEADER BOARD (TOP 10 STUDENTS OF THE YEAR)</font></b></small>
      </div>
     </div>
  </div>
</div>  -->

<!-- School name drop down list -->

<div class="row">
    <div class="col-md-1 "></div>
  <div class="col-md-10 center centered">
<div class="panel panel-danger " style="margin-top:22px;">


  <div class="panel-heading text-center">
    <h3 class="panel-title"><font color="#580000"><b>List of Top 10 Students</b></font></h3>
  </div>
  <div class="panel-body" style="margin-top:10px;">
 <div class="center-block">
 <div class="row">
  <div class="col-md-3">
<select name="limit1" class="dropdownMenu1" id="dropdownMenu1" style="width:85%; height:30px; border-radius:2px;margin-left:50px;margin-top:20px;margin-bottom:20px;" onChange="onSchoolChange()">


   <?php $sql1=mysql_query("Select id,school_name,school_mnemonic from tbl_school  where `school_mnemonic`!='' group by school_name order by `school_name` ASC");?>

    <option value="<?php echo $school_id; ?>" disabled selected>School/College Name</option>
	<option value="all">All School</option>
	<?php while($row=mysql_fetch_array($sql1)){ ?>
	<option <?php if($row['school_mnemonic']==$school_id) echo "selected" ?> value="<?php echo $row['school_mnemonic']; ?>"><?php echo $row['school_name']; ?></option>
    <?php }?>
  </select>


</div>

<!-- Duration drop down list -->

 <div class="row">
  <div class="col-md-3">
<select name="limit2" class="dropdownMenu2" id="dropdownMenu2" style=" height:30px; border-radius:2px;margin-left:20px;margin-top:20px;margin-bottom:20px;" onChange="display_top10_students_wmy_wise()">




    <option id="time" value="" disabled selected>Duration</option>
	<option value="allDuration">All</option>
	<option value="1">Top 10 Students of the Week</option>
	<option value="2">Top 10 Students of the Month</option>
	<option value="3">Top 10 Students of the Year</option>

  </select>


</div>

   <!-- Subject/Activity drop down list -->
    <div class="row">
  <div class="col-md-3">

<select name="limit3" class="dropdownMenu3" id="dropdownMenu3" style="width:80%; height:30px; border-radius:2px;margin-left:0px;margin-top:20px;margin-bottom:20px;" onChange="subjectChange()">


   <!--<?php $sql1=mysql_query("Select id,school_name from tbl_school order by `school_name` ASC" );?>  -->

    <option  value="" disabled selected>Subjects Name</option>


   <!--	<?php $sql2=mysql_query("Select id,subject from tbl_school_subject where school_id='$school_id'" );?>
	<?php while($row=mysql_fetch_array($sql2)){ ?>
	<option value="<?php echo $row['id'];?>,<script>document.write(school_id);</script><?php /*echo $school_id;*/ ?>"><?php echo $row['subject'];?></option>
    <?php }?>-->
	</select>
	</div>

	 <div class="row">
  <div class="col-md-3">

<select name="limit4" class="dropdownMenu4" id="dropdownMenu4" style="width:80%; height:30px; border-radius:2px;margin-left:0px;margin-top:20px;margin-bottom:20px;" onChange="ActivityChange()">
	 <!--<option value="" disabled selected>-------------------------</option>-->

	 <option  value="" disabled selected>Activities Name</option>
	 <!-- <option  value="allActivity">All Activities</option>-->
	 <!--<option value="" disabled selected>------------------------</option>-->


  </select>


</div>

  </div>
</div>

 </div>
</div>



<div class="container" id="top10_students" style="padding:5px;">
    </div>









</div>

  </div>


 </div>
</div>

</div>

</body>
</html>