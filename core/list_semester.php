<?php

include('scadmin_header.php');

    //     $id=$_SESSION['staff_id'];

           $fields=array("id"=>$id);

		   /*$table="tbl_school_admin";

		   */
 
		$smartcookie=new smartcookie();
		$results=$smartcookie->retrive_individual($table,$fields);
		$result=mysql_fetch_array($results);
		$sc_id=$result['school_id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $dynamic_semester;?></title>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
 
 <script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>


<script>

$(document).ready(function() {

    $('#example').dataTable( {


    } );

} );

function confirmation(xxx) 
{
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "deletesemester.php?id="+xxx;
		
		
    }
    else
	{
       
    }
}

</script>



<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>



  <style>

@media only screen and (max-width: 800px) {

    

    /* Force table to not be like tables anymore */

	#no-more-tables table, 

	#no-more-tables thead, 

	#no-more-tables tbody, 

	#no-more-tables th, 

	#no-more-tables td, 

	#no-more-tables tr { 

		display: block; 

	}

 

	/* Hide table headers (but not display: none;, for accessibility) */

	#no-more-tables thead tr { 

		position: absolute;

		top: -9999px;

		left: -9999px;

	}

 

	#no-more-tables tr { border: 1px solid #ccc; }

 

	#no-more-tables td { 

		/* Behave  like a "row" */

		border: none;

		border-bottom: 1px solid #eee; 

		position: relative;

		padding-left: 50%; 

		white-space: normal;

		text-align:left;

		font:Arial, Helvetica, sans-serif;

	}

 

	#no-more-tables td:before { 

		/* Now like a table header */

		position: absolute;

		/* Top/left values mimic padding */

		top: 6px;

		left: 6px;

		

		padding-right: 10px; 
		
		white-space: nowrap;

		

		

	}

 

	/*

	Label the data

	*/

	#no-more-tables td:before { content: attr(data-title); }
	
	.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}

}

</style>

</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div>

 
</div>

<div class="container" style="padding:45px;" width="70%"  >

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;  width:1250px; margin-left: -80px; " >

                    <div style="width:100%">

                    <div class="row" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-6"  align="center">
					  <div class="col-md-6 " align="center">
                        <h2><?php echo $dynamic_semester;?> List </h2>
                    </div>
                    <!--      <h2 style="margin-top:2px;color:#666;background-color:#694489;color:white;padding-top:15px;padding-bottom:10px;"> Semester List</h2>
                      <div style="color:#090;">  -->

                      <?php if(isset($_GET['report'])){echo $_GET['report'];}?>
                      </div>
                       <div style="color:#090;">

                      <?php if(isset($_GET['successreport'])){echo $_GET['successreport'];}?>
                      </div>
                      

               			</div>

               
                    </div>

                    <div class="row">

                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;margin-right: 2cm;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						 
                       <a href="addsemester.php" ><input type="button" class="btn btn-primary"  value="Add <?php echo $dynamic_semester;?>" style="width:160px;font-weight:bold;font-size:14px; margin-left:33px;"/></a>

               		</div>


              	<div class="col-md-5 " align="center" style="color:black;padding:5px;" >
              
               </div>
                         
                     </div>
   
               <div class="row">

               <br>
			   
				<div class="col-md-12 " >
			      <div class="row" align="center" style="margin-top:3%;">

				  <form action="list_semester.php" method="post">
				    <div class="col-md-12">
						<div class="col-md-3">
							<label class="col-sm-4 control-label text-right"  for="info">Select <?php echo $dynamic_semester;?></label>
							
							<select name="info" class="form-control" style="width:150px;">			  
							<option value="">Choose</option>
							<?php $select1 = $_POST['info'] ?>
							<option value="1"  <?php if($select1 == "1") echo "selected"; ?> >Current </option>
							<option value="2"  <?php if($select1 == "2") echo "selected"; ?> >All </option>
							</select>
						</div>
						
						<div class="col-md-3">
							<label class="col-sm-4 control-label text-right" for="info"><?php echo $dynamic_semester;?> Name </label>
							<select name="Semester_Name" id="Semester_Name"	class="form-control" style="width:150px;">		
								<?php $sems=mysql_query("SELECT DISTINCT Semester_Name FROM  tbl_semester_master where school_id='$sc_id'"); ?>	
								<option value="" >Choose</option>
								<?php $k = 1;
								 	$select2 = $_POST['Semester_Name'];
                    				while ($opt = mysql_fetch_array($sems)) { ?>
                        				<option value="<?php echo $opt['Semester_Name'] ?>" <?php if($select2 == $opt['Semester_Name']) echo "selected"; ?> > <?php echo $opt['Semester_Name'];  ?> </option>
  								  <?php $k++; } ?>

							<!-- <option value="" >Choose</option>
							<option value="" >Semester I</option>
							<option value="" >Semester II</option>
							<option value="" >Semester III</option>
							<option value="" >Semester IV</option>
							<option value="" >Semester V</option>
							<option value="" >Semester VI</option>
							<option value="" >Semester VII</option>
							<option value="" >Semester VIII</option> -->
							</select>`
						</div>
						
					
						
						
						
						
						<div class="col-md-3">
							<label class="col-sm-4 control-label text-right" for="info">Enabled <?php echo $dynamic_semester;?></label>
							<select name="Enabled" class="form-control" style="width:150px;">			  
							<option value="">Choose</option>
							<?php $select3 = $_POST['Enabled'] ?>
							<option value="1" <?php if($select3 == "1") echo "selected"; ?> >Yes </option>
							<option value="0" <?php if($select3 == "0") echo "selected"; ?> >No </option>
							</select>
						</div>
					</div>
					

						<div class="col-md-2" style="float:right; margin-left:-40px;">
							<input type="submit" name="submit" value="Submit" class="btn btn-success">
						</div>  
				  </form>

				  </div>
			   </div>
			   <br>

               <div class="col-md-12 " >
               

               <?php $i=0;?>

					<table id="example" class="display" width="40%" cellspacing="0">

						<thead>

                    	<tr><!--<th  ><b><center>Sr.No</center></b></th>-->
                           <!-- <th  ><b><center>Class</center></b></th>-->

						   <!-- Camel casing done for Semester Credit,ExtSemesterID and Course Level  by Pranali -->
						   	<th> <center> Sr.No </center> </th>
                            <th><center><?php echo $dynamic_semester;?> Name </center></th>

                            <th  ><b><center><?php echo $dynamic_branch;?> Name</center></b></th>
                            <th ><b><center>Department Name</center></b></th>

							<th ><b><center><?php echo $dynamic_class;?>  </center></b></th>

                            <th  ><b><center><?php echo $dynamic_semester;?> Credit</center></b></th>
                            <th ><b><center>Is Regular <?php echo $dynamic_semester;?></center></b></th>

                            <th ><b><center> Is Enable</center></b></th>
                            <th ><b><center> Ext <?php echo $dynamic_semester;?> ID</center></b></th>
                            <th ><b><center><?php echo $dynamic_level;?></center></b></th>

    						<th ><b><center>Edit</center></b></th>
                            <th ><b><center> Delete</center></b></th>
							
                        </tr>
						</thead>
					 
                  <tbody>
                 <?php
				
				$i=1;
				
				$arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id'");

					/* For GET Request */
					if($_SERVER['REQUEST_METHOD'] === 'GET'){
						if(isset($_GET['Branch_name'])){
							$branch=$_GET['Branch_name'];
							$arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Branch_name='$branch'");
						} 
						if(isset($_GET['Department_Name'])){
							$DepartmentName=$_GET['Department_Name'];
							$arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Department_Name='$DepartmentName'");
						}
						if(isset($_GET['Semester_Name'])){
							$SemesterName=$_GET['Semester_Name'];
							$arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Semester_Name='$SemesterName'");
						}
						if(isset($_GET['Is_enable'])){
							$Isenable=$_GET['Is_enable'];
							$arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='$Isenable'");
						}
					}
					
					if($_SERVER['REQUEST_METHOD'] === 'POST'){
								$info=$_POST['info'];
								$Semester = $_POST['Semester_Name'];
								$Enabled=$_POST['Enabled'];
								
						
								/*search    only currect and all semester */
									if($info!='' && $Semester == '' && $Enabled == '' ){ 
										if($info =='1'){
										
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='1'");
										}
										if($info =='2'){
									
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel,ExtSemesterId,CourseLevel  from tbl_semester_master where school_id='$sc_id'");
										}	
								  }
								  
								/*search      only Semester name only */  
								  if($info =='' && $Semester != '' && $Enabled == ''){
									$arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Semester_Name='$Semester' ");
								}
								
								/* search AND checks only IsEnable */  
								  if($info =='' && $Semester == '' && $Enabled!=''){
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='$Enabled'");
								  }
								  
								  /*search current and semester name */
								  	if($info!='' && $Semester != '' && $Enabled == '' ){ 
										if($info =='1'){
										
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='1' and Semester_Name='$Semester'");
										}
										if($info =='2'){
									
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel,ExtSemesterId,CourseLevel  from tbl_semester_master where school_id='$sc_id' and Semester_Name='$Semester' ");
										}	
								  }
								  
								    /*search current and semester name */
								  	if($info!='' && $Semester == '' && $Enabled != '' ){ 
										if($info =='1'){
										
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='1' ");
										}
										if($info =='2'){
									
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel,ExtSemesterId,CourseLevel  from tbl_semester_master where school_id='$sc_id' ");
										}	
								  }
								  
								     /*search semester name and IsEnabled  */
								  	if($info=='' && $Semester != '' && $Enabled != '' ){ 
										if($Enabled =='1'){
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='1' and Semester_Name='$Semester' ");
										}
										if($Enabled =='2'){
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel,ExtSemesterId,CourseLevel  from tbl_semester_master where school_id='$sc_id' and Semester_Name='$Semester' ");
										}	
								  }
								  
								     /*search semester name and IsEnabled  */
								  	if($info!='' && $Semester != '' && $Enabled != '' ){ 
										if($info =='1'){
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='1' and Semester_Name='$Semester' ");
										}
										if($info =='2'){
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel,ExtSemesterId,CourseLevel  from tbl_semester_master where school_id='$sc_id' and Semester_Name='$Semester' ");
										}	
								  }
								
					}
				?>
				
                  <?php 
				  while($value=mysql_fetch_array($arr)){?>

                <tr >
				<th  ><b><center><?php echo $i;?></center></b></th>
                <th  ><center><a href="list_semester.php?Semester_Name=<?php echo $value['Semester_Name']; ?>"><?php echo $value['Semester_Name'];?></center></th>
                <th  ><b><center><a href="list_semester.php?Branch_name=<?php echo $value['Branch_name']; ?>"><?php echo $value['Branch_name'];?></center></b></th>
				
                <th  ><b><center><a href="list_semester.php?Department_Name=<?php echo $value['Department_Name']; ?>"><?php echo $value['Department_Name'];?></center></b></th>
				
			   <th  ><b><center><a href="list_semester.php?class=<?php echo $value['class']; ?>"><?php echo $value['class'];?></center></b></th>
                <th  ><b><center><?php echo $value['Semester_credit'];?></center></b></th>
                <th  ><b><center><?php if($value['Is_regular_semester']==1){ echo "Yes";}else{ echo "No";}?></center></b></th>
                 <th  ><b><center><a href="list_semester.php?Is_enable=<?php echo $value['Is_enable']; ?>"><?php if($value['Is_enable']==1){ echo "Yes";}elseif($value['Is_enable']==0){ echo "No";}?></center></b></th>
				 <th  ><b><center><?php echo $value['ExtSemesterId'];?></center></b></th>
				 <th  ><b><center><?php echo $value['CourseLevel'];?></center></b></th>
				<!--<th><?php echo $value['batch_id']; ?></th>-->
				
				<th ><b><center><a href="addsemester.php?id=<?php echo $value['Semester_Id']; ?>
				&extID=<?php echo $value['ExtSemesterId'];?>"><span class="glyphicon glyphicon-pencil"></a></center></b></th>
				
 


				<th style="width:100px;" ><b><center> <a onClick="confirmation(<?php echo $value['Semester_Id']; ?> )"><span class="glyphicon glyphicon-trash"></span></a></b></center></th>
				
				</tr>
				
				
                <?php $i++;?>

				  <?php }?>

                  </tbody>

                  </table>

                  </div>

                  </div>

                   <div class="row" style="padding:5px;">

                   <div class="col-md-4">

               </div>

                  <div class="col-md-3 "  align="center">

                   </form>

                   </div>

                    </div>
 
               </div>

               </div>

</body>

</html>

