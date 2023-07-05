<?php
	include("corporate_cookieadminheader.php");
	$report="";
	$school_id=$_GET['school_id'];
	
            
            if(isset($_POST['submit']))
				{
				$point=$_POST['point'];
			
				
				
	 				
					$arrs=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id' ");
      				$arr=mysql_fetch_array($arrs);
      				$school_balance_point=$arr['school_balance_point']+$point;

		  			mysql_query("update tbl_school set school_balance_point='$school_balance_point' where id='$school_id'");
				
				mysql_query("update tbl_school_admin set school_balance_point='$school_balance_point' where school_id='$school_id'");
				 // header("location:school_list.php");	
					
	  				$report="$point points are assigned successfully";
					
	   
	   
				
	            
	  
	}
	
 ?>
	

<html>
<head>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <script>

function valid()
{

var points=document.getElementById("point").value;
if(points==''||points==null)
{
 document.getElementById('errorpoints').innerHTML='Please enter Points';
return false;
}

var numbers = /^[0-9]+$/;  
 if(!points.match(numbers))
 {
document.getElementById('errorpoints').innerHTML='Please enter Valid Points';
 return false;
 
 }  



}
</script>
</head>




<body>

    <div class="container">
    <div >
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        	<h2 style="padding-left:20px; margin-top:2px;color:#003399">Assign Points to Company</h2>
        </div>
              
         </div>
         
         
       </div>
    <div class="row" style="padding:20px;">
     <div class="col-md-2"> 
     </div>

         <?php 
            

            $sql=mysql_query("SELECT school_id, name,school_name, address, name, reg_date, school_balance_point
FROM tbl_school_admin
WHERE school_id =  '$school_id'");
			
			$sql1=mysql_fetch_array($sql);
			$school_id=$sql1['school_id'];
		
			$school_name=$sql1['school_name'];
			$school_address=$sql1['address'];
			$school_head_name=$sql1['name'];
			$school_balance_points=$sql1['school_balance_point'];
			$date=$sql1['reg_date'];
			
            ?>
            <div class="col-md-8"> 
    	<div  style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
       
        <div class="row">
        <div class="col-md-4">
       		<div align="left" style="padding:10px;font-size:16px"> <b>Company ID</b></div></div>
			<div class="col-md-4">
			<?php echo $school_id;?>
            </div>
            </div>
           
           <div class="row">
           <div class="col-md-4">
        	<div align="left" style="padding:10px;font-size:16px"><b> Name</b></div>
			</div>
            <div class="col-md-4">
			<?php echo $school_name;?>
            </div>
            </div>
            
            <div class="row">
            <div class="col-md-4">
          <div align="left" style="padding:10px;font-size:16px"> <b>Address</b></div>
          </div>
          <div class="col-md-3">
          <?php echo $school_address;?></div>
          </div>
      
          
          <div class="row">
          <div class="col-md-4">
              <div align="left" style="padding:10px;font-size:16px"><b>Company Head</b></div>
			  </div>
			      <div class="col-md-3">
			  <?php echo $school_head_name;?></div>
              </div>
              
              <div class="row">
              <div class="col-md-4">
              <div align="left" style="padding:10px;font-size:16px"><b> Date</b></div>
			  </div>
                  <div class="col-md-3">
			  <?php echo $date;?></div>
              </div>
          
          
          
            <div class="row">
              <div class="col-md-4">
              <div align="left" style="padding:10px;font-size:16px"><b> Balance Points</b></div>
			  </div>
                  <div class="col-md-3">
			  <?php $query=mysql_query("SELECT  school_balance_point
FROM tbl_school_admin
WHERE school_id =  '$school_id'");
$result=mysql_fetch_array($query);
echo $result['school_balance_point'];
 ?></div>
              </div>
          
               <form method="post">
               <div class="row">
                   <div class="col-md-4">
               <div align="left" style="padding:10px;font-size:16px"> <b>Assign Points</b></div>
               </div>
                 
                   <div class="col-md-3">
                   
               <input type="text" name="point" id="point" class="form-control"/>
            
               </div>
                
                  
                
               </div>
               <div style="color:#FF0000;" id="errorpoints" align="center"><?php echo $report;?></div>
                <div style="padding-top:20px; " > 
                  <div class="row">
                  <div class="col-md-3"></div>
                <div class="col-md-2">
                 <input type="submit" name="submit" class="btn btn-primary" value="Assign" onClick="return valid();">
            
            
                 </div>
                
                <a href="school_list.php"><input type="button" name="cancel" class="btn btn-danger" value="Back"></a></div>
               
                 <div style="height:10px;"></div></div>
           
            
            
	</form>
            </div>
            
        </div>
        </div>
        
        
          
         
       
       
       
       
       
</body>
</html>