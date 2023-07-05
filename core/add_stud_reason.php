<?php
$report="";
  include_once('cookieadminheader.php');

		   
		  
if(isset($_POST['submit']))
{
	  $i=0;
	  $count=$_POST['count'];
				$counts=0;			// Loop to store each class.
				$activities=Array();
				$activity_add=Array();
			
				 $j=0;
				for($i=0;$i<$count;$i++)
				          {
							  $activity=$_POST[$i];
							  $results=mysql_query("select * from tbl_thanqyoupointslist where school_id='0'  and t_list like '$activity'  ");
							  //check already class exist or not
								 if(mysql_num_rows($results)==0 && $activity!="")
									{
										$query="insert into tbl_student_recognition(student_recognition	,school_id) values('$activity','0') ";
									
										$rs = mysql_query($query );
									 $activity_add[$counts]=$activity;
										 $counts++; 
									}
								 else
								 	{
								  $activities[$j]=$activity;
									   $j++;
										
									}
							
							     
							
							
							}
							if(count($activities)>0 || count($activity_add)>0)
							{
							   $last_index=count($activities);
							   $report1="";$report2="";
							   if( $last_index>0)
							   {
								$report1="Already added  ";
								 $activity_list="";
								for($i=0;$i<$last_index-1;$i++)
								{
								  $activity_list= $activities[$i].",". $activity_list;
								}
								
								$activity_list=$activity_list.$activities[$last_index-1];
								$report1=$report1." ".$activity_list;
								$activity_list="";
								}
							
							  $last_index1=count($activity_add);
							  $report2="";
							 if( $last_index1>0)
							   {
								   $last_index1;
									$report2="You have successfully added ";
									 $activity_list="";
									for($i=0;$i<$last_index1-1;$i++)
									{
									  $activity_list=$activity_add[$i].",". $activity_list;
									}
								   $activity_list=$activity_list.$activity_add[$last_index1-1];
									$report2=$report2." ".$activity_list;
									$activity_list="";
								}
							  
								if($report1!="" && $report2!="")
								{
								 $report=$report1." .".$report2." .";
								}
								else if($report1=="")
								{
								  $report=$report2." .";
								}
								else
								{
								$report=$report1." .";
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
 $("<div class='row formgroup' style='padding:5px;'  ><div class='col-md-3 col-md-offset-4'  ><input type='text'  name="+i+" id="+i+" class='form-control' placeholder='Enter ThanQ reason '></div><div class='col-md-3 ' style='color:#FF0000;' id="+index+i+" ></div></div>").appendTo('#add');
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
			
		if(values==null||values=="")
			{
			
				document.getElementById( index+i).innerHTML='Please enter ThanQ reason';
				
				return false;
			}
			regx=/^[a-zA-Z\s]*$/;
				//validation of activity
				
			if(!regx.test(values))
				{
					document.getElementById(index+i).innerHTML='Please enter valid ThanQ reason';
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
                    
                    <div >
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >

               			 </div>
              			 <div class="col-md-4"  style="color:#663399;" >
                         	
                   				<h2>Add Reason</h2>
               			 </div>
                         
                     </div>
                   <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >
                 
                    </div>
                  
               <div class="col-md-3">
           
             </div>
               
               
               </div>
              
                  </div>  
                  
                   
                  
               <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >
                 
                    </div>
                   
               
               <div class="col-md-3 col-md-offset-2 ">
             <input type="text" name="0" id="0" class="form-control " placeholder="Enter ThanQ Reason">
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
                    <input type="submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>
                    </div>
                     <div class="col-md-3 "  align="left">
                    <a href="student_reason.php" style="text-decoration:none;"><input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>
                    </div>
                   
                   </div>
                   
                     <div class="row" style="padding:15px;">
                     <div class="col-md-4">
                     <input type="hidden" name="count" id="count" value="1">
                     </div>
                      <div class="col-md-6" style="color:#FF0000;" align="left" id="error">
                      
                      <?php echo $report;?>
               			</div>
                 
                    </div>
                       </div>
                </form>
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>
