<?php
//Below code updated by Rutuja Jori for merging Add & Edit pages into one on 25/11/2019 for SMC-4196
$report="";
$report1="";
 include('scadmin_header.php');
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id1=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id1'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];

if(isset($_POST['id'])=='')
{
if(isset($_POST['submit']))
{		
	//Added trim() by Pranali for SMC-5153
	$ExtBranchId=trim($_POST['ExtBranchId']);
	$course=$_POST['course'];
	$degree=$_POST['degree'];
	$dept_name=$_POST['department'];
	$branch_name=trim($_POST['branch_name']);
	$branch_code=trim($_POST['branch_code']);
	$specialization=trim($_POST['specializaion']);
	$duration=trim($_POST['duration']);
	$isenable=$_POST['isenable'];
	
	if($_POST['branch_code']!='')
	{
		
	
	
	$sql= mysql_query("select id from tbl_branch_master where school_id='$sc_id'  AND  ExtBranchId='$ExtBranchId'");
	

	
 $result=mysql_num_rows($sql);
if($result==0)
{

//Below

$query=mysql_query("insert into tbl_branch_master (branch_Name,Branch_code,Course_Name,ExtBranchId,Duration,Specialization,DepartmentName,school_id,IsEnabled) values('$branch_name','$branch_code','$course','$ExtBranchId','$duration','$specialization','$dept_name','$sc_id','$isenable')");



//$succesreport="$branch_name is successfully inserted";
echo ("<script LANGUAGE='JavaScript'>
	alert('$branch_name is successfully inserted');
	window.location.href='list_school_branch.php';
				</script>");

}

else{
	echo "<script>alert('Record already present, Please enter another $dynamic_branch ID') </script>";
	
}


	
	}
	
	
	
						
}



?>


<html>
<head>
<script>

function MyAlert(course)
{
 
 
 
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
			
			
			var points=xmlhttp.responseText;
			
	
			document.getElementById('degree').innerHTML=points;
      
			
            }
          }
	
		 
        xmlhttp.open("GET","get_schoolscourse.php?course="+course,true);
        xmlhttp.send();


}

 function valid()
{
	
	var course=document.getElementById("course").value;
		
		
		
		regx1=/^[A-z ]+$/;
		
		
		if(course=="select" )
			{
			   
				document.getElementById('errorcourse').innerHTML='Please select <?php echo $dynamic_level;?>';
				
				return false;
			}
			else{
				document.getElementById('errorcourse').innerHTML='';
			}
			
			
			var ExtBranchId=document.getElementById("ExtBranchId").value;
	regx1=/^[0-9 ]+$/;
		if(ExtBranchId==null||ExtBranchId=="" )
			{
			   
				document.getElementById('errorExtBranchId').innerHTML='Please enter <?php echo $dynamic_branch;?> ID';
				
				return false;
			}
			else if(!regx1.test(ExtBranchId))
			{
				document.getElementById('errorExtBranchId').innerHTML='Please enter valid  <?php echo $dynamic_branch;?> ID';
				
				return false;
				}else{
				document.getElementById('errorExtBranchId').innerHTML='';
			}

		
		var department=document.getElementById("department").value;
			
			if(department=='select' )
			{
				document.getElementById('errordepartment').innerHTML='Please select department';
				return false;	
			}
			else{
				document.getElementById('errordepartment').innerHTML='';
			}

			
			
			var branch_name=document.getElementById("branch_name").value;
			
			
			regx1=/^[A-z ]+$/;
		
		
		if(branch_name.trim()==""|| branch_name.trim()==null)
			{
			   
				document.getElementById('errorbranch').innerHTML='Please enter <?php echo $dynamic_branch;?>';
				
				return false;
			}
			else if(!regx1.test(branch_name))
			{
				document.getElementById('errorbranch').innerHTML='Please enter valid  <?php echo $dynamic_branch;?>';
				
				return false;
				}else
				{
				document.getElementById('errorbranch').innerHTML='';
				}
	//			
				var branch_code=document.getElementById("branch_code").value;

		regx1=/^[A-z0-9 ]+$/;

		if(branch_code.trim()==""||branch_code.trim()==null )
			{

				document.getElementById('errorbranchcode').innerHTML='Please enter <?php echo $dynamic_branch;?> code';
				
				return false;
			}
			else if(!regx1.test(branch_code))
			{
				document.getElementById('errorbranchcode').innerHTML='Please enter valid  <?php echo $dynamic_branch;?> code';
				
				return false;
				}else{
				document.getElementById('errorbranchcode').innerHTML='';
			}
				
				
			var specializaion=document.getElementById("specializaion").value;
			
						
			regx_spec=/^[A-z ]+$/;
		
		 <?php if ($user=='School Admin'){?>
//Removed mandatory validation for specializaion and duration by Pranali for SMC-5153
		// if(specializaion.trim()==""||specializaion.trim()==null)
		// 	{
			   
		// 		document.getElementById('errorspecializaion').innerHTML='Please enter specializaion';
				
		// 		return false;
		// 	}
		 
	//Modified validation for specialization and duration by Pranali for SMC-5153
			 if( specializaion.trim()!="" && specializaion.trim()!=null)

			{
				if( regx_spec.test(specializaion) == false) {
				document.getElementById('errorspecializaion').innerHTML='Please enter only alphabets in specialization';
				
				return false;
				}
				else
				{
					document.getElementById('errorspecializaion').innerHTML='';
				}
			}
			else
			{
				document.getElementById('errorspecializaion').innerHTML='';
			}
				
				
				
			var duration=document.getElementById("duration").value;
			
			
			regx_duration=/^[0-9 ]+$/;
				
		// if(duration.trim()==""||duration.trim()==null )
		// 	{
			   
		// 		document.getElementById('errorduration').innerHTML='Please enter duration';
				
		// 		return false;
		// 	}
			 if(duration.trim()!="" && duration.trim()!=null )
			{ 
				if(regx_duration.test(duration) == false)
				{
					document.getElementById('errorduration').innerHTML='Please enter only numbers in duration';
				
					return false;
				}
				else
				{
					document.getElementById('errorduration').innerHTML='';
				}
			}
			else
			{
				document.getElementById('errorduration').innerHTML='';
			}
				<?php }?>
/*				
		
*/
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
                   
               			 </div>
              			 <div class="col-md-4 " align="center" style="color:#663399;" >
                         	
                   				<h2>Add <?php echo $dynamic_branch;?> </h2>
               			 </div>
                         
                     </div>
                  
                  
                    <div class="row " style="padding-top:60px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_level;?><span style="color:red;font-size: 25px;">*</span> </div>
               
               <div class="col-md-3">
               <?php
			   
           //  echo "gtruyfg";
			 // echo "select distinct  CourseLevel from tbl_CourseLevel where school_id='$sc_id'";
			   $query1=mysql_query("select distinct  CourseLevel from tbl_CourseLevel where school_id='$sc_id'");
			 ?>
             <select name="course" id="course" class="form-control" onChange="MyAlert(this.value)">
             <option value="select">Select <?php echo $dynamic_level;?></option>
             
			 
                <?php
				
			 while($result1=mysql_fetch_array($query1))
			 {?>
			 
			 
               <option value=<?php echo $result1['CourseLevel'];?>><?php echo $result1['CourseLevel'];?></option>
			 
			 <?php }?>
             
             </select>
             </div>
                
				<div class="row"><div class="col-md-4 col-md-offset-5" id="errorcourse" style="color:#F00"></div></div>
                  </div>
                  
                  <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_branch;?> ID<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <input type="text" name="ExtBranchId"  id="ExtBranchId" placeholder="Enter <?php echo $dynamic_branch;?> ID" value="<?php if(isset($_POST['ExtBranchId'])){ echo $_POST['ExtBranchId'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errorExtBranchId" style="color:#FF0000"></div></div>
                   
                     
                  
				  
				  
				  
               <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">  Department<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <select name="department" id="department" class="form-control" >
			 
             <option value="select">Select Department</option>
             <?php
			 //ordered dept dropdown by alphabetically by Pranali for SMC-5153
			 $query=mysql_query("SELECT trim(Dept_Name) as Dept_Name from tbl_department_master where school_id='$sc_id' AND trim(Dept_Name)!='' ORDER BY trim(Dept_Name) ASC");
			 while($result=mysql_fetch_array($query))
			 {?>
			 
			 
               <option value="<?php echo $result['Dept_Name'];?>"><?php echo $result['Dept_Name'];?></option>
			 
			 <?php }?>
             
             </select>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errordepartment" style="color:#F00"></div></div>
            
                    <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_branch;?> Name<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3"> 
             <input type="text" name="branch_name"  id="branch_name" placeholder="Enter <?php echo $dynamic_branch;?> Name" value="<?php if(isset($_POST['branch_name'])){ echo $_POST['branch_name'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errorbranch" style="color:#FF0000"></div></div>
                  
				  <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_branch;?> Code<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <input type="text" name="branch_code" id="branch_code" placeholder="Enter <?php echo $dynamic_branch;?> Code" value="<?php if(isset($_POST['branch_code'])){ echo $_POST['branch_code'];}?>" class="form-control"/>
             </div>
             </div>
             <div class="row">
             
              <div class="col-md-3 col-md-offset-5" style="color:#FF0000" id="errorbranchcode">
             <?php echo $report1;?>
             </div>
                
              
                  </div>
                  
                  
                  
                    <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Specialization<span style="color:red;font-size: 25px;"> <?php if ($user=='School Admin'){?> <?php } ?></span></div>
               
               <div class="col-md-3">
             <input type="text" name="specializaion" id="specializaion" placeholder="Enter Specialization" value="<?php if(isset($_POST['specializaion'])){ echo $_POST['specializaion'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
				   <?php if ($user=='School Admin'){?>
                  <div class="row"><div class="col-md-4 col-md-offset-5" id="errorspecializaion" style="color:#F00"></div></div>
				   <?php } ?>
				
                      <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Duration<span style="color:red;font-size: 25px;"> <?php if ($user=='School Admin'){?> <?php } ?></span></div>
               
               <div class="col-md-3">
             <input type="text" name="duration" id="duration" placeholder="Enter Duration" value="<?php if(isset($_POST['duration'])){ echo $_POST['duration'];}?>" class="form-control"/>
             </div>
                 <?php if ($user=='School Admin'){?>
					 <div class="row"><div class="col-md-4 col-md-offset-5" id="errorduration" style="color:#F00"></div></div>
					  <?php } ?>
                  </div>
                  
                  
                   <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Is Enable</div>
               
               <div class="col-md-1">
               <input type="radio" name="isenable" value="1" checked> Yes</div>
                 <div class="col-md-1">
               <input type="radio" name="isenable" value="0" > No</div>
               
               
           
            
                
              
                  </div>
                  
                  
                  
               
                  
                   <div class="row" style="padding-top:40px;">
                   <div class="col-md-2">
               </div>
                  <div class="col-md-1 col-md-offset-3 "  >
                    <input type="submit" class="btn btn-primary" name="submit" value="Add "  onClick="return valid()" style="width:100%;"/>
                    </div>
                     <div class="col-md-3 "  align="left">
        <a href="list_school_branch.php" style="text-decoration:none;">
		<input type="button" class="btn btn-danger" name="Back" value="Back" style="width:30%;"  /></a>
                    </div>
                   
                   </div>
                   
                     <div class="row" style="padding-top:30px;">
                  
                      <div class="col-md-4 col-md-offset-4 "  align="center" id="error">
                       <div style="color:#FF0000;">
                      <?php echo $report;?>
                      </div>
                       <div style="color:#093"><?php echo $succesreport;?></div>
               			</div>
                       
                 
                    </div>
                       </div>
                </form>
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>
<?php } else{
	$id=$_SESSION['id']; 
 

$id=$_POST['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
 $sc_id=$_SESSION['school_id'];

 $id=$_POST['id'];
	$sql=mysql_query("select * from tbl_branch_master where id='$id'");
	$result2=mysql_fetch_array($sql);
	 $BranchCode=$result2['Branch_code']; 
	 $ExBranchId=$result2['ExtBranchId'];  
$courseName=$result2['Course_Name']; 
     
if(isset($_POST['submit']))
{		
 	//$id=$_GET['id'];
	 $branch_name=trim($_POST['branch_name']);
	 $branch_code=trim($_POST['branch_code']);
	 $dept_name=$_POST['department']; 
	  $course=$_POST['course']; 
	 //$degree=$_POST['degree']; 
	  $Special=trim($_POST['Special']); 
	 
	 $Duration=trim($_POST['Duration']);
  $ExtBranchId=trim($_POST['ExtBranchId']); 
	 $IsEnabled=$_POST['isenable'];
	 
	 if($BranchCode == $branch_code &&  $ExBranchId == $ExtBranchId)
{
	

	$r = "update tbl_branch_master set branch_Name='$branch_name',Branch_code='$branch_code',DepartmentName='$dept_name',Course_Name='$course' ,Specialization='$Special',Duration='$Duration',ExtBranchId='$ExtBranchId',IsEnabled='$IsEnabled' where id='$id'";
	

}

else
{
	$qury="select * from `tbl_branch_master` where school_id='$sc_id' AND  id!='$id' AND (Branch_code='$branch_code' or  ExtBranchId='$ExtBranchId')";
	// echo $qury; exit;
$sql1 = mysql_query($qury);

$count=mysql_num_rows($sql1);


if ($count > 0) 
{
	
	
    echo "<script>alert('Record already present') </script>";
}

else
{
    $r = "update tbl_branch_master set branch_Name='$branch_name',Branch_code='$branch_code',DepartmentName='$dept_name',Course_Name='$course' ,Specialization='$Special',Duration='$Duration',ExtBranchId='$ExtBranchId',IsEnabled='$IsEnabled' where id='$id'"; 
}
}
    
	if($r!='')
	{
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_school_branch.php';
                        </script>");
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
	}
	
}

$r = mysql_query("select * from `tbl_branch_master` where (school_id='$sc_id') and (Branch_code='$branch_code' or  ExtBranchId='$ExtBranchId)");

if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
}

		
		

        
?>


<html>
<head>
<script>


 function valid()
 {


//validation for branch name
     var branch_name=document.getElementById("branch_name1").value;
				
			regx1=/^[a-zA-Z ]+$/;
		
		
		if(branch_name==null || branch_name=="" )
			{
			   
				document.getElementById('errorbranch').innerHTML='Please enter branch name';
				
				return false;
			}
			else if(!regx1.test(branch_name))
			{
				document.getElementById('errorbranch').innerHTML='Please enter valid  branch name';
				
				return false;
				}else{
				document.getElementById('errorbranch').innerHTML='';
			          }
//validation for branch code
			var branch_code=document.getElementById("branch_code").value;
			var specialization=document.getElementById("Special").value;
			var duration=document.getElementById("Duration").value;
			var ExtBranchId=document.getElementById("ExtBranchId").value;
		
	          	regx1=/^[A-z0-9 ]+$/;
		
		
		if(branch_code==null||branch_code=="" )
			{
			   
				document.getElementById('errorbranchcode').innerHTML='Please enter branch code';
				
				return false;
			}
			else if(!regx1.test(branch_code))
			{
				document.getElementById('errorbranchcode').innerHTML='Please enter valid  branch code';
				
				return false;
				}else{
				document.getElementById('errorbranchcode').innerHTML='';
			}
			
	          	regx1=/^[A-z0-9 ]+$/;
		
		
		if(ExtBranchId==null||ExtBranchId=="" )
			{
			   
				document.getElementById('errorExtBranchId').innerHTML='Please enter branch ID';
				
				return false;
			}
			else if(!regx1.test(ExtBranchId))
			{
				document.getElementById('errorExtBranchId').innerHTML='Please enter valid  branch ID';
				
				return false;
				}else{
				document.getElementById('errorExtBranchId').innerHTML='';
			}

//Modified validations for specialization and duration by Pranali for SMC-5153
			regx_spec=/^[A-z ]+$/;

			if(specialization.trim()!=null || specialization.trim()!="" )
			{
			   
			// 	document.getElementById('errorSpecial').innerHTML='Please enter Special';
				
			// 	return false;
			// }
				if(regx_spec.test(specialization) == false)
				{
					document.getElementById('errorSpecial').innerHTML='Please enter only alphabets in Specialization';
					
					return false;
				}
				else{
					document.getElementById('errorSpecial').innerHTML='';
				}
			}
			else{
					document.getElementById('errorSpecial').innerHTML='';
				}

			regx_duration = /^[0-9 ]+$/;
			if(duration.trim()!= null || duration.trim()!="" )
			{
			   
			// 	document.getElementById('errorDuration').innerHTML='Please enter Duration';
				
			// 	return false;
			// }
				if(regx_duration.test(duration) == false)
				{
					document.getElementById('errorDuration').innerHTML='Please enter only numbers in Duration';
					
					return false;
				}
				else{
					document.getElementById('errorDuration').innerHTML='';
				}
			}
			else{
					document.getElementById('errorDuration').innerHTML='';
				}
			
//validation for department
		  var department=document.getElementById("department");
			
			if(department.value==null)
			{
				document.getElementById('errordepartment').innerHTML='Please select department';
				return false;	
			}
			else{
				document.getElementById('errordepartment').innerHTML='';
			}
			


//validation for course
	     var course=document.getElementById("course");
		
		
		if(course.value==null )
			{
			   
				document.getElementById('errorcourse').innerHTML='Please select course';
				
				return false;
			}
			else{
				document.getElementById('errorcourse').innerHTML='';
			}
			
			

//validation for degree
			
		var degree=document.getElementById("degree1");
		
		
		if(degree.value==null)
			{
			   
				document.getElementById('errordegree').innerHTML='Please select degree';
				
				return false;
			}else{
				document.getElementById('errordegree').innerHTML='';
			}
		
		}	
		
function validate_form(){
	var br_name = $("#branch_name").val();
	var br_code = $("#branch_code").val();
	var br_id = $("#ExtBranchId").val();
	if(br_name.trim()==""){
		$('#errorbranch').html('Please enter Branch Name');
		return false;
	}
	if(br_code.trim()==""){
		$('#errorbranchcode').html('Please enter Branch Code');
		return false;
	}
	if(br_id.trim()==""){
		$('#errorExtBranchId').html('Please enter Branch Id');
		return false;
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
                   <form method="post" onsubmit="return validate_form();">
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >
                   
               			 </div>
              			 <div class="col-md-4 " align="center" style="color:#663399;" >
                         	
                   		  <h2>Edit <?php echo $organization;?> <?php echo $dynamic_branch;?> </h2>
							<input type="hidden" name="id" value="<?= $_POST['id']; ?>" >
               			 </div>
                         
                     </div>
					 <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_branch;?> Name <span style="color:red;font-size: 25px;">*</span> </div>
             
               <div class="col-md-3">
             <input type="text" name="branch_name"  id="branch_name" value="<?php echo  $result2['branch_Name']; ?>" class="form-control"/>
			  <div class="col-md-10 col-md-offset-5" style="color:#FF0000" id="errorbranch"></div>
             </div>
 
 
				 
               
                  
			  <div class="row "  style="padding-top:60px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_branch;?> Code <span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <input type="text" name="branch_code" id="branch_code" value="<?php echo  $result2['Branch_code']; ?>" class="form-control"/>
             </div>
			  <div class="col-md-15 col-md-offset-5" style="color:#FF0000" id="errorbranchcode">
             </div>
             <div class="row">
             
             
             <?php echo $report1;?>
             </div>
                
              
                  </div>
                
                   </div>
              
                  
				  
				<div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_branch;?> ID<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <input type="text" name="ExtBranchId" id="ExtBranchId" value="<?php echo  $result2['ExtBranchId']; ?>" class="form-control"/>
             </div>
			  <div class="col-md-15 col-md-offset-5" style="color:#FF0000" id="errorExtBranchId">
             </div>
             <div class="row">
             
             
             <?php echo $report1;?>
             </div>
                
              
                  </div>
				 
				 
                 
                  

				  <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">  Department <span style="color:red;font-size: 25px;">*</span>
               </div>
               <div class="col-md-3">
             <select name="department" id="department" class="form-control"  onChange="MyAlert(this.value)">
			 
             <option value="<?php echo $result2['DepartmentName'];?>"><?php echo $result2['DepartmentName'];?></option>
             <?php
			 
			 $query=mysql_query("select Dept_Name from tbl_department_master where school_id='$sc_id'");
			 while($result=mysql_fetch_array($query))
			 {?>
			 
			 
               <option value="<?php echo $result['Dept_Name'];?>"><?php echo $result['Dept_Name'];?></option>
			 
			 <?php }?>
             
             </select>
			 <div class="col-md-10 col-md-offset-5" id="errordepartment" style="color:#F00"></div>
              
             </div>
                  
                  </div>
				   <div class="row">
				 
                  </div>
                  
		
               <div class="row" style="padding-top:30px;">
                   <div class="col-md-2">
               </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errorbranch" style="color:#FF0000"></div></div>
                  
                  
                    <div class="row " style="padding-top:5px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> <?php echo $dynamic_level;?>  <span style="color:red;font-size: 25px;">*</span>
               </div>
               <div class="col-md-3">
               <?php
          
			   $query1=mysql_query("select distinct CourseLevel from tbl_CourseLevel where school_id='$sc_id' and CourseLevel!='$courseName'");
			 ?>
			 
             <select name="course" id="course" class="form-control" onChange="MyAlert(this.value)">
             <option value="<?php echo $result2['Course_Name'];?>"><?php echo $result2['Course_Name'];?></option>
             
			 
			 
                <?php
			 while($result1=mysql_fetch_array($query1))
			 { ?>
			 
			
               <option value=<?php echo $result1['CourseLevel'];?>><?php echo $result1['CourseLevel'];?></option>
			 
			 <?php }?>
             
             </select>
			 <div class="row"><div class="col-md-10 col-md-offset-5" id="errorcourse" style="color:#F00"></div>
             </div>
                </div>
              
                  </div>
                  
                  
                   
             
				       
			  <div class="row "  style="padding-top:60px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> Specialization</div>
               
               <div class="col-md-3">
             <input type="text" name="Special" id="Special" value="<?php echo  $result2['Specialization']; ?>" class="form-control"/>
             </div>
			  <div class="col-md-15 col-md-offset-5" style="color:#FF0000" id="errorSpecial">
             </div>
             <div class="row">
             
             
             <?php echo $report1;?>
             </div>
				  
				  </div> 
				  
				   <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> Duration</div>
               
               <div class="col-md-3">
             <input type="text" name="Duration" id="Duration" value="<?php echo  $result2['Duration']; ?>" class="form-control"/>
             </div>
			  <div class="col-md-15 col-md-offset-5" style="color:#FF0000" id="errorDuration">
             </div>
             <div class="row">
             
             
             <?php echo $report1;?>
             </div>
                
              
                  </div>
				  <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Is Enable</div>
               
               <div class="col-md-1">
               <input type="radio" name="isenable" value="1" checked> Yes</div>
                 <div class="col-md-1">
               <input type="radio" name="isenable" value="0" > No</div>
               
               
           
            
                
              
                  </div>
                  
				  
				  
				    <div class="row" style="padding-top:30px;">
               
                  <div class="col-md-4 col-md-offset-3 " style="padding-left:300px;" >
                    <input type="submit" class="btn btn-primary" name="submit" value="Update "  onClick="return valid();" style="width:100%;"/>
                    </div>
					
                     <div class="col-md-3 " style="padding-top:2px;">
						<a href="list_school_branch.php" style="text-decoration:none;">
						<input type="button" class="btn btn-danger" name="Back" value="Back" style="width:30%;"  /></a>
                    </div>
                   
                   </div>
                   
                     <div class="row" style="padding-top:10px;">
                  
                      <div class="col-md-4 col-md-offset-4" id="error" >
                       <div style="color:#FF0000;">
                      <?php echo $report;?>
                      </div>
                       <div style="color:#093"><?php echo $succesreport;?></div>
               			</div>
                       
                 
                    </div>
                       </div>
					  
                </form>
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>


	<?php } ?>