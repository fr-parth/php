<?php
$report="";
  include_once('groupadminheader.php');

  $group_member_id=$_SESSION['id'];


if(isset($_POST['submit']))
{
	  $i=0;
	  $count=$_POST['count'];
				$counts=0;			// Loop to store each activity_type.
				//store activity type added successfully.
				$activity_add=Array();
				//store activity type that already present.
				$activity_present=Array(); 
				 $j=0;
				for($i=0;$i<$count;$i++)
				          {
							  $activity_type=$_POST[$i];

							  $results=mysql_query("select * from tbl_activity_type where school_id='0' and group_member_id='$group_member_id'  and activity_type like '$activity_type'");
							//   echo "select * from tbl_activity_type where school_id='0' and group_member_id='$group_member_id'  and activity_type like '$activity_type'";

							  //check already activity_type exist or not
								 if(mysql_num_rows($results)=='0' && $activity_type!="")
									{
										

										$query="insert into tbl_activity_type(activity_type,school_id,group_member_id) values('$activity_type','0','$group_member_id') ";
										// echo "insert into tbl_activity_type(activity_type,school_id,group_member_id) values('$activity_type','0','$group_member_id') ";


										$rs = mysql_query($query);
									 $activity_add[$counts]=$activity_type;
										 $counts++;
									}
								 else
								 	{
									   $activity_present[$j]=$activity_type; //if activity is already present in tbl_activity_type
									   $j++;

									}




							}
						if(count($activity_add)>0 || count($activity_present)>0)
							{
							   $last_index=count($activity_present);
							   $report1="";$report2="";
							   if( $last_index>0)
							   {
								$report1="Already added  ";
								 $activitytype_list="";
								for($i=0;$i<$last_index-1;$i++)
								{
								 $activitytype_list= $activity_present[$i]." , ".$activitytype_list;
								}

								$activitytype_list=$activitytype_list.$activity_present[$last_index-1];
								$report1=$report1." ".$activitytype_list;
								$activitytype_list="";
								}

							  $last_index1=count($activity_add);
							  $report2="";
							 if( $last_index1>0)
							   {
								   $last_index1;
									$report2="You have successfully added ";
									 $activitytype_list="";
									for($i=0;$i<$last_index1-1;$i++)
									{
									  $activitytype_list=$activity_add[$i].",".$activitytype_list;
									}
								 $activitytype_list=$activitytype_list.$activity_add[$last_index1-1];
									$report2=$report2." ".$activitytype_list;
									$activitytype_list="";
								}

								
								
							//Changes done by Pranali on 20-06-2018 for bug SMC-2834,SMC-2832
							
								if($report1!="")
								{
								  $report=$report1;
								}
								else if($report2!="")
								{
								$report_success=$report2;
								}
								else
								{
									$report="";	
									$report_success="";
								}	
								
								
								
								 
							}




}

?>


<html>
<head>
<script>
var i=1;
function create_input()

{


 var index='E-';
 $("<div class='row formgroup' style='padding:5px;'  ><div class='col-md-3 col-md-offset-4'  ><input type='text'  name="+i+" id="+i+" class='form-control' placeholder='Enter Activity Type '></div><div class='col-md-3 ' style='color:#FF0000;' id="+index+i+" ></div></div>").appendTo('#add');
   i=i+1;
   document.getElementById("count").value = i;

}


function valid()
{

	var count=document.getElementById("count").value;



for(var i=0;i<count;i++)
	{
	var index='E-';
		var values=document.getElementById(i).value;

		if(values.trim()==null || values.trim()=="") 
		{

				document.getElementById( index+i).innerHTML='Please enter activity type';

				return false;
			}
			regx=/^[a-zA-Z\s]*$/;
				//validation of activity

			if(!regx.test(values))
				{
					document.getElementById(index+i).innerHTML='Please enter valid activity type';
					return false;
				}


	}

}

</script>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        		<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <form method="post">

                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >
                       <input type="button" class="btn btn-primary" name="add" value="Add more" style="width:100px;font-weight:bold;font-size:14px;" onClick="create_input()"/>
               			 </div>
              			 <div class="col-md-4 " align="center" style="color:#663399;" >

                   				<h2>Add Activity Type</h2>
               			 </div>

                     </div>
                   <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Activity Type</h4></b>
                    </div>



               <div class="col-md-3 ">
             <input type="text" name="0" id="0" class="form-control " placeholder="Enter Activity Type">
             </div>
               <div class="col-md-3" id="E-0" style="color:#FF0000;">

               </div>

                  </div>
                <div id="add">
                </div>

                   <div class="row" style="padding-top:15px;">
                   <div class="col-md-2">
               </div>
                  <div class="col-md-2 col-md-offset-2 "  >
                    <a href="System_level_activity_type.php" style="text-decoration:none;"> <input type="Submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/></a>
                    </div>
                     <div class="col-md-3 "  align="left">
                    <a href="System_level_activity_type.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>
                    </div>

                   </div>

                     <div class="row" style="padding:15px;">
                     <div class="col-md-4">
                     <input type="hidden" name="count" id="count" value="1">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center" id="error">

                      <?php echo $report;?>
               			</div>
                    <div class="col-md-11" style="color:green;" align="center" id="success">

                    <?php echo $report_success;?>
                    </div>
                    </div>
                       </div>
                </form>
               </div>
               </div>
</body>
</html>
