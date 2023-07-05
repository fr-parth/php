<?php
$class="";
include("cookieadminheader.php");
$report="";
if(isset($_GET["activity"]))
	{
		$record_id= $_GET["activity"];
		 $sql1="select sc_list,activity_type,sc_type from tbl_studentpointslist stp join tbl_activity_type ac_type on stp.sc_type=ac_type.id where sc_id='$record_id'";
		$row=mysql_query($sql1);
	    $arr=mysql_fetch_array($row);
		$activity=$arr['sc_list'];
		$activity_type=$arr['activity_type'];
		$activity_id=$arr['sc_type'];
	
?>
<?php
 if(isset($_POST['submit']))
 {
 $activity=$_POST['activity'];
 $activity_type_id=$_POST['activity_type'];
	//$row=mysql_query("select * from tbl_class  where class='$class'");
  
	$row=mysql_query("select * from tbl_studentpointslist  where sc_list like '$activity' and school_id='0'  and  sc_id!='$record_id' ");
	if(mysql_num_rows($row)<=0 )
	{
      // $id=$values['Id'];
	  
	 
	$rows=  mysql_query("update tbl_studentpointslist set sc_list='$activity',sc_type='$activity_type_id' where sc_id=$record_id");
	 
	  if(mysql_affected_rows()>0)
		{
		 $report="Activity is Successfully updated !!!";
		
	
		}
	  
	}
	else
	{
	
	 $report=$activity." is already present.";
	}
	
	
}?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

</head>
<script>
	function valid()
{
   
	
	

		var values=document.getElementById("activity").value;
		
			regx=/^[a-zA-Z\s]*$/;
				//validation of class
	if(values==null||values=="")
			{
			
				document.getElementById("erroractivity").innerHTML='Please enter activity';
				
				return false;
			}
	else if(!regx.test(values))
				{
					document.getElementById("erroractivity").innerHTML='Please enter valid activity';
					return false;
				}
				else
	{
	document.getElementById("erroractivity").innerHTML='';
					return true;
	
	}

}
</script>
<body  align="center">
<div class="container" style="padding:10px;" align="center">
<div class="row"  >
<div class="col-md-3">
</div>
<div class="col-md-6">
<div class="container" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                   
                    
               
	
         <form method="post"  >
          <div class="row" style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                <h2>Edit Activity</h2>
          </div>
          
          <div class="row " >
                  <div class="col-md-4 col-md-offset-1" align="left" style="color:#003399;font-size:16px">
                 <b>Activity</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                                <input type="text" name="activity" id="activity" class="form-control" style="width:100%; padding:5px;" placeholder=":Enter activity" value='<?php echo $activity; ?>' />
                  </div>
                   
          </div>
          <div class="row">
                   <div class="col-md-7 col-md-offset-2" align="left" style="color:#FF0000;font-size:16px" id="erroractivity">
               
                  </div>
 
          </div>
          <div class="row " >
                  <div class="col-md-4 col-md-offset-1" align="left" style="color:#003399;font-size:16px;padding-top:5px;">
                 <b>Activity Type</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                         <select name="activity_type" class="form-control">
                           
                                <?php if(isset($_POST['activity_type'])){
							     $activity_id= $_POST['activity_type'];
						
							    $rowt=mysql_query("SELECT * FROM tbl_activity_type where id='$activity_id'");
								$vals=mysql_fetch_array($rowt);
								$act_type=$vals['activity_type'];
								?>
						 <option value='<?php echo  $_POST['activity_type']; ?>'  SELECTED ><?php echo $act_type;?></option> 
							<?php } else{?>
                               <option value='<?php echo  $activity_id; ?>'  SELECTED ><?php echo $activity_type;?></option>
                            <?php  }  ?>
                               <?php
							  
							  
							      $row1=mysql_query("SELECT * FROM tbl_activity_type where id!='$activity_id'");
							    while($values=mysql_fetch_array($row1))
                               {?>
                             <option value='<?php echo  $values['id']; ?>'><?php echo $values['activity_type'];?></option>
                               
                              <?php }?>
                             
                             </select>
                  </div>
          </div>
          <div class="row " style="padding:10px;" >
                  
                  <div class="col-md-8 form-group col-md-offset-4" id="error" style="color:red;">
                            <?php echo $report;?>
                               
                  </div>
          </div>
          
          <div class="row" >
          	<div class="col-md-3 col-md-offset-2" style="padding:15px;">
          			   <input type="submit" name="submit" class="form-control" style="width:65%;background-color:#0080C0; color:#FFFFFF;" value="Submit" onClick="return valid()"/>
             </div>
             <div class="col-md-3 col-md-offset-1" style="padding:15px;">
               <!-- <a href="System_level_activity.php" style="text-decoration:none;"><input type="button" class="form-control" name="cancel" value="Cancel"    style="width:100%;background-color:#8B4513" ></a> -->
				<div class="col-md-1"><a href="System_level_activity.php"><input type="button" value="Back" class="btn btn-danger" name="cancel" value="Cancel"></a></div>
             </div>
          
          </div>
         </form>
          </div>
      </div>
    </div>
</div>

</div>
</div>

	
      
</body>
</html>
<?php }?>
