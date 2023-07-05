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

<title>Semester</title>

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

<div class="container" style="padding:25px;" width="100%"  >

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; width:1300px;" >

                    <div style="width:100%">

                    <div class="row" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-3"  align="center">

                      <div style="color:#090;">

                      <?php if(isset($_GET['report'])){echo $_GET['report'];}?>
                      </div>
                       <div style="color:#090;">

                      <?php if(isset($_GET['successreport'])){echo $_GET['successreport'];}?>
                      </div>
                      

               			</div>

               
                    </div>

                    <div class="row">

                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                       <a href="addsemester.php">   <input type="button" class="btn btn-primary"  value="Add Semester" style="width:140px;font-weight:bold;font-size:14px;"/></a>

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
						<label class="col-sm-4 control-label text-right" for="info">Select Semester</label>
							<select name="info" class="form-control" style="width:150px;">			  
							<option value="" >Choose</option>
							<option value="1" >Current </option>
							<option value="2" >All </option>
							</select>
						</div>
						
						<div class="col-md-3">
						<label class="col-sm-4 control-label text-right" for="info">Semester Name </label>
							<select name="Semester" class="form-control" style="width:150px;">			  
							<option value="" >Choose</option>
							<option value="Semester I" >Semester I</option>
							<option value="Semester II" >Semester II</option>
							<option value="Semester III" >Semester III</option>
							<option value="Semester IV" >Semester IV</option>
							<option value="Semester V" >Semester V</option>
							<option value="Semester VI" >Semester VI</option>
							<option value="Semester VII" >Semester VII</option>
							<option value="Semester VIII" >Semester VIII</option>
							</select>`
						</div>
						
						<div class="col-md-3">
						<label class="col-sm-4 control-label text-right" for="info">Enabled Semester</label>
							<select name="Enabled" class="form-control" style="width:150px;">			  
							<option value="" >Choose</option>
							<option value="1" >Yes </option>
							<option value="2" >No </option>
							</select>
						</div>
					</div>

						<div class="col-md-2" style="float:right;">
							<input type="submit" name="submit" value="Submit" class="btn btn-success">
						</div>  
				  </form>
				  </div>
			   </div>
			   <br>
               <div class="col-md-12 " >
               

               <?php $i=0;?>

                  <table id="example" class="display" width="100%" cellspacing="0">

                     <thead>

                    	<tr ><!--<th  ><b><center>Sr.No</center></b></th>-->
                           <!-- <th  ><b><center>Class</center></b></th>-->
                            <th  ><center>Semester Name </center></th>
                            <th  ><b><center>Branch Name</center></b></th>
                            <th ><b><center>Department Name</center></b></th>
                            <th  ><b><center>Semester credit</center></b></th>
                            <th ><b><center>Is Regular semester</center></b></th>
                            <th ><b><center> Is Enable</center></b></th>
                            <th ><b><center> ExtSemesterId</center></b></th>
                            <th ><b><center> CourseLevel</center></b></th>
    						<!--<th>Batch ID</th>-->
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
								$Semester=$_POST['Semester'];
								$Enabled=$_POST['Enabled'];
								echo $info;
								echo '<br>';
								echo $Semester;
								echo '<br>';
								echo $Enabled;
								echo '<br>';
								
						
								/*search only currect and all semester */
									if($info!='' && $Semester == '' && $Enabled == '' ){ 
										if($info =='1'){
										
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='1'");
										}
										if($info =='2'){
									
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel,ExtSemesterId,CourseLevel  from tbl_semester_master where school_id='$sc_id'");
										}	
								  }
								  
								/*search only Semester name only */  
								  if($info =='' && $Semester != '' && $Enabled == ''){
									$arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Semester_Name='$Semester' ");
								}
								
								/* search AND checks only IsEnable */  
								  if($info =='' && $Semester == '' && $Enabled!=''){
									  if($Enabled =='1'){
										
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel from  tbl_semester_master where school_id='$sc_id' and Is_enable='1'");
										}
										if($Enabled =='2'){
									
										  $arr=mysql_query("select DISTINCT Semester_Id,Department_Name,Semester_Name,Branch_name,Is_enable,Is_regular_semester,Semester_credit,class,batch_id,ExtSemesterId,CourseLevel,ExtSemesterId,CourseLevel  from tbl_semester_master where school_id='$sc_id'");
										}	
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

                <tr ><!--<th  ><b><center><?php echo $i;?></center></b></th><th  ><b><center> <?php //echo $value['class'];?></center></b></th>--> 
                <th  ><center><a href="list_semester.php?Semester_Name=<?php echo $value['Semester_Name']; ?>"><?php echo $value['Semester_Name'];?></center></th>
                <th  ><b><center><a href="list_semester.php?Branch_name=<?php echo $value['Branch_name']; ?>"><?php echo $value['Branch_name'];?></center></b></th>
                <th  ><b><center><a href="list_semester.php?Department_Name=<?php echo $value['Department_Name']; ?>"><?php echo $value['Department_Name'];?></center></b></th>
                <th  ><b><center><?php echo $value['Semester_credit'];?></center></b></th>
                <th  ><b><center><?php if($value['Is_regular_semester']==1){ echo "yes";}else{ echo "No";}?></center></b></th>
                 <th  ><b><center><a href="list_semester.php?Is_enable=<?php echo $value['Is_enable']; ?>"><?php if($value['Is_enable']==1){ echo "yes";}else{ echo "No";}?></center></b></th>
				 <th  ><b><center><?php echo $value['ExtSemesterId'];?></center></b></th>
				 <th  ><b><center><?php echo $value['CourseLevel'];?></center></b></th>
				<!--<th><?php echo $value['batch_id']; ?></th>-->
				<th ><b><center> <a href="editsemester.php?id=<?php echo $value['Semester_Id']; ?>">Edit</a></center></b></th>
				<th  ><b><center> <a href="deletesemester.php?id=<?php echo $value['Semester_Id']; ?>">Delete</a></center></b></th></tr>

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

