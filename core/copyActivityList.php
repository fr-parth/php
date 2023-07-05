<?php
$report="";
  include_once('scadmin_header.php');
$id=$_SESSION['id'];
$school_id=$_SESSION['school_id'];
$group_member_id=$_SESSION['group_member_id'];
$number=0;
if(isset($_POST['submit']))
{
	 $activity_type_id=$_POST['activity_type'];
	
	 $activity_type_id1=$_POST['activity_type1']; 
	 
	$results=mysql_query("SELECT * FROM tbl_studentpointslist where sc_type='$activity_type_id' and school_id='0' and group_member_id='0'");
//echo	$cnt=mysql_num_rows($results);exit;
	 while ($row = mysql_fetch_array($results))
	 {
		 $sc_list=$row['sc_list'];
		 $results1=mysql_query("SELECT * FROM tbl_studentpointslist where sc_list='$sc_list' and school_id='$school_id'");
		 $cnt=mysql_num_rows($results1);
		
		 if($cnt==0)
		 {
			$query = mysql_query("INSERT INTO tbl_studentpointslist (sc_list,sc_type,school_id,group_member_id) VALUES ('$sc_list','$activity_type_id1','$school_id','$group_member_id')");
			$number++;
		 }
	 } 
	  echo ("<script LANGUAGE='JavaScript'>
					window.alert('$number Activity successfully Inserted');
					window.location.href='activitylist.php';
					</script>");
}


?>


<html>
<head>
<script>
var i=1;
function create_input()

{


 var index='E-';
 $("<div class='row formgroup' style='padding:5px;'  ><div class='col-md-3 col-md-offset-4'  ><input type='text'  name="+i+" id="+i+" class='form-control' placeholder='Enter Activity'></div><div class='col-md-3 ' style='color:#FF0000;' id="+index+i+" ></div></div>").appendTo('#add');
   i=i+1;
   document.getElementById("count").value = i;

}





</script>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;">
        		<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <form method="post">

                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >
                      
               			 </div>
              			 <div class="col-md-3 " align="center" style="color:#663399;" >

                   				<h2>COPY Activity</h2>
               			 </div>

                     </div>
                   <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4> Cookie Activity Type</h4></b>
                    </div>

               <div class="col-md-3">
            <select name="activity_type" id="activity_type" class="form-control">

            <option value="select">Select</option>
			
            <?php $row=mysql_query("select * from tbl_activity_type where school_id='0' and group_member_id='0'");
			while($value=mysql_fetch_array($row)){?>

            <option value="<?php echo $value['id'];?>"><?php echo $value['activity_type'];?></option>
			<?php }?>

			</select>
             </div>
               <div class="col-md-3" id="error_activity_type" style="color:#FF0000;">

               </div>

                  </div>


			       <div class="col-md-4" align="left" >
                    <b><h4 style="margin-left: 175px";>School Activity Type</h4></b>
                    </div>

               <div class="col-md-3">
            <select name="activity_type1" id="activity_type1" class="form-control">

            <option value="select">Select</option>
			

            <?php $row=mysql_query("select * from tbl_activity_type where school_id='$school_id'");
			while($value=mysql_fetch_array($row)){?>

            <option value="<?php echo $value['id'];?>"><?php echo $value['activity_type'];?></option>
			<?php }?>

			</select>
             </div>
               <div class="col-md-3" id="error_activity_type" style="color:#FF0000;">

               </div>

                  </div>

				  

                <div id="add">
                </div>

                   <div class="row" style="padding-top:15px;">
                   <div class="col-md-2">
               </div>
                  <div class="col-md-2 col-md-offset-2 "  >
                    <input type="submit" class="btn btn-primary" name="submit" value="COPY " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>
                    </div>
               
                   </div>

                     <div class="row" style="padding:15px;">
                     <div class="col-md-4">
                     <input type="hidden" name="count" id="count" value="1">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center" id="error">


                      <?php echo $report;?>
               			</div>
						</div>


						  <div class="row" style="padding:15px;">
                      <div class="col-md-7" style="color:green;" align="right" id="success">
                   <?php echo $report2;?>
                 </div>
                    </div>
					</div>
                       </div>
                </form>

               </div>
               </div>
</body>
</html>
