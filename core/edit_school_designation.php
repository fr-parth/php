<?php
         if(isset($_GET['divi']))
		 {
			 $report="";
			include_once("school_staff_header.php");
		$division_id= $_GET["divi"];
		 $sql1="select * from tbl_school_division where id=".$division_id;
		$row=mysql_query($sql1);
	    $arr=mysql_fetch_array($row);
		$division=$arr['division'];
	    $class_id=$arr['class_id'];
	
		$rows=mysql_query("select * from tbl_school_class where id='$class_id'");
	    $value=mysql_fetch_array($rows);
		$class=$value['class'];
		

?>
<?php
 if(isset($_POST['submit']))
 {
   $division_new=$_POST['division'];

	$rows=mysql_query("select * from tbl_school_division where class_id='$class_id' and division='$division_new' ");
	    if(mysql_num_rows($rows)<=0)
		{
		
	
			mysql_query("update tbl_school_division set division='$division_new' where id=$division_id");
			 if(mysql_affected_rows()>0)
				{
		 			$report="Division is Successfully updated !!!";
		 			header("Location:list_school_division.php?name=".$staff_id."&report=".$report);
	
				}
			  }
       else
	   {
	    $report= $division_new." division is already present.";
	   
	   }

	
}?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script>
	function valid()
	{
	  var division=document.getElementById("division").value;
	
	  if(division=="")
	  {
	   document.getElementById('error').innerHTML='Please Enter Division';
	    return false;
	  }
	  	regx=/^[0-9]*$/;
				//validation of division
				
			if(regx.test(division))
				{
			
					document.getElementById('error').innerHTML='Please Enter valid Division';
					return false;
				}
	
	}
</script>
</head>
<body  align="center">
<div class="container" style="padding:10px;" align="center">
<div class="row"  >
<div class="col-md-3">
</div>
<div class="col-md-6">
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                   
                    
               
	
         <form method="post"  >
          <div class="row" style="color: #666;height:80px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                <h2>Edit Division</h2>
          </div>
           <div class="row " >
                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                 <b>Class</b>
                  </div>
                  <div class="col-md-5 form-group" align="left">
                  <?php 
		$rows=mysql_query("select * from tbl_school_class where id='$class_id'");
	    $arrs=mysql_fetch_array($rows); echo $arrs['class'];?>
                            
                            
                  </div>
          </div>
          <div class="row " >
                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                 <b> Division</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                                <input type="text" name="division" id="division" class="form-control" style="width:100%; padding:5px;" placeholder=":Enter Division" value='<?php echo $division; ?>'/>
                  </div>
          </div>
		  
		  <div class="row " >
                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                 <b> Division</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                                <input type="text" name="division" id="division" class="form-control" style="width:100%; padding:5px;" placeholder=":Enter Division" value='<?php echo $division; ?>'/>
                  </div>
          </div>
		  
		  <div class="row " >
                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                 <b> Division ID</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                                <input type="text" name="division_id" id="division_id" class="form-control" style="width:100%; padding:5px;" placeholder=":Enter Division" value='<?php echo $division; ?>'/>
                  </div>
          </div>
		  
          <div class="row " >
                  
                  <div class="col-md-8 form-group col-md-offset-2" id="error" style="color:red;">
                            
                               <?php echo $report;?>
                  </div>
          </div>
          
          <div class="row" >
          	<div class="col-md-3 col-md-offset-2" style="padding:10px;">
          			   <input type="submit" name="submit" class="form-control" style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="Submit" onClick="return valid()"/>
             </div>
             <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                <a href="list_school_division.php?name=<?=$name?>" style="text-decoration:none;"><input type="button" class="form-control" name="cancel" value="Cancel" style="width:100%;background-color:#0080C0; color:#FFFFFF;" ></a>
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

<?php  
		 }
		 else
		 {
			 $report="";
include("scadmin_header.php");

 $division_id= $_GET["id"];	
 $division_name= $_GET["designation"];	

?>
<?php
 if(isset($_POST['submit']))
 {
   $division_new=$_POST['division'];

	
		
	
			mysql_query("update tbl_teacher_designation set designation='$division_new' where id=$division_id");
			 if(mysql_affected_rows()>0)
				{
		 			/*$report="Successfully updated !!!";
		 			header("Location:list_school_division.php?report=".$report);*/
	echo ("<script LANGUAGE='JavaScript'>
					alert('Record Updated Successfully..!!');
					window.location.href='list_school_designation.php';
					</script>");
				
			
		}
       else
	   {
	    $report= $division_new." Designation is already present.";
	   
	   }

	
}?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script>
	function valid()
	{
	  var division=document.getElementById("division").value;
	
	  if(division=="")
	  {
	   document.getElementById('error').innerHTML='Please Enter Designation';
	    return false;
	  }
	  	
	
	}
</script>
</head>
<body  align="center">
<div class="container" style="padding:10px;" align="center">
<div class="row"  >
<div class="col-md-3">
</div>
<div class="col-md-6">
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                   
                    
               
	
         <form method="post"  >
          <div class="row" style="color: #666;height:80px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                <h2>Edit Designation</h2>
          </div>
		  
		  
          
						
          <div class="row " >
                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                 <b> Designation</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                                <input type="text" value="<?php echo $division_name;?>" name="division" id="division" class="form-control" style="width:100%; padding:5px;" placeholder=":Enter Designation" value='<?php echo $division_new; ?>'/>
                  </div>
          </div>
          <div class="row " >
                  
                  <div class="col-md-8 form-group col-md-offset-2" id="error" style="color:red;">
                            
                               <?php echo $report;?>
                  </div>
          </div>
          
          <div class="row" >
          	<div class="col-md-3 col-md-offset-2" style="padding:10px;">
          			   <input type="submit" name="submit" class="form-control" style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="Submit" onClick="return valid()"/>
             </div>
             <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                <a href="list_school_designation.php" style="text-decoration:none;"><input type="button" class="form-control" name="cancel" value="Cancel" style="width:100%;background-color:#0080C0; color:#FFFFFF;" ></a>
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

<?php 
}
?>
		  

