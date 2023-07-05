<?php
	
	include("Parent_header.php");
           $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_parent";
		   
		   //$smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$parent=mysql_fetch_array($results);
			$c_id=$parent['std_PRN'];
		//	$c_school_id=$parent['school_id']; 
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

 <link rel="stylesheet" type="text/css" href="../../../wamp/www/smartcookies/css/jquery.dataTables.css">
		<script src="../../../wamp/www/smartcookies/js/jquery-1.11.1.min.js"></script>
        <script src="../../../wamp/www/smartcookies/js/jquery.dataTables.min.js"></script>
        <script src="../../../wamp/www/smartcookies/js/jdataTables.responsive.js"></script> 
  <link rel="stylesheet" type="text/css" href="../../../wamp/www/smartcookies/css/dataTables.responsive.css"> 
  <link rel="stylesheet" type="text/css" href="css//dataTables.bootstrap.css"> 




  <script type="text/javascript">

        function validate()
      {           alert('entered');
            regx1=/^[A-z ]+$/;
			regx2=/^[0-9]+$/;
			regx3 = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
			dateReg = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
			timeReg = /^([1-9]|1[0-2]):([0-5]\d)\s?(AM|PM)?$/i;
			loc = /^[a-zA-Z0-9\s,'-]*$/;
			regUrl = /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/;

            if(!regx2.test(document.myForm.prn.value))
		   {
			        	 alert( "Please provide valid PRN No." );
		    			return false;
		   }
		   else
			{

			}
            if( document.myForm.stdname.value == "" )
            {


                document.myForm.cmpyname.focus() ;
                     return false;
            }else if(!regx1.test(document.myForm.cmpyname.value))
		   {
				 alert( "Please provide Valid Student name" );
					return false;
		   }
		   else
			{

			}
        }
  $(document).ready(function() {

		// Disable search and ordering by default
$.extend( $.fn.dataTable.defaults, {
    searching: true,
    ordering:  false
} );
 
// For this specific table we are going to enable ordering
// (searching is still disabled)
$('#example').DataTable( {
     
		"info":     false,
		 responsive: true
		
} );
 	
  
        } );
		
  </script>
 
 
</head>

<body>
<div class="container" style=" padding:10px;height:20px;" align="center">

      <form method="post" name="myForm" >
	<div  class="row" align="center"  >
    <div  class="col-md-1"> 
          		
          </div>
          <div  class="col-md-2" style=" padding:10px;">
          		<input type="text" name="roll_no"  placeholder="Enter PRN No" id="prn" class="form-control" value="<?php if(isset($_POST['roll_no'])){echo $_POST['roll_no'];} ?>">
          </div>
          <div  class="col-md-2" style=" padding:10px;"> 
          		<input type="text" name="std_name"  placeholder="Student Name" id="stdname" class="form-control" value="<?php if(isset($_POST['std_name'])){echo $_POST['std_name'];} ?>">
          </div>
          
          <div  class="col-md-2" style=" padding:10px;"> 
          		<input type="text" name="class"  placeholder="Enter Class" id="class" class="form-control" value="<?php if(isset($_POST['class'])){echo $_POST['class'];} ?>">
          </div>
          <div class="col-md-2" style=" padding:10px;"> 
          		<input type="text" name="school_id"  placeholder="Enter School Id" id="scid" class="form-control" value="<?php if(isset($_POST['school_id'])){echo $_POST['school_id'];} ?>">
          </div>
          <div   class="col-md-2" style=" padding:10px;">
          		 <input type="submit" name="submit" value="Search" id="search-btn" style="width:70px; height:32px; background-color:#0080FF; color:#FFFFFF; border:1px solid #CCCCCC;" class="form-control"/>
          </div>
      </div>
      </form>
         <div style="font-size:25px;color:#990066;height:30px;padding:20px;font-weight:bold;"> Search Student</div>      
     <div style="margin-top:10px;padding:10px;">
              <?php            					 
		if(isset($_POST['submit']))
		{	 
			  $id=$_SESSION['id'];
			  $roll_no=$_POST['roll_no'];
			    $std_name=$_POST['std_name'];
			  $class=$_POST['class'];
			  $school_id=$_POST['school_id'];
             $a=preg_match('/^[0-9]*$/', $roll_no);
             $b=preg_match("/^[a-zA-Z ]*$/",$std_name);
			
			  ?>
                    <table id="example" class="display table table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Student Name</th>
                        <th>Father Name</th>
                        <th>School Name</th>
                        <th></th>
                       
                    </tr>
                </thead>

               
         
                <tbody>
      <?php
      
		   if($roll_no=='' && $class=='' && $school_id=='' && $std_name=='')
		   {
				echo "<script type=text/javascript>alert('Plz enter data.');</script>";
		   }
      		elseif($roll_no!='' || $class!='' || $school_id!='' || $std_name!='')
      		{


      				 $arr="select * from tbl_student";
					 $arr1 = " where ";
				$f = 0;	 
			if($roll_no!='')
      		{
				$f = 1;
      		$arr1 = $arr1 . " std_PRN like '%$roll_no%'";
      		}

      		if($class!='')
      		{
				if($f==1)
				{
					$arr1 = $arr1 . " and ";
				}
				$arr1 = $arr1 . " std_class like '%$class%'";
				$f = 1;
      		//$arr=mysql_query("select * from tbl_student  where std_class='$class'");
      		}

      		if($school_id!='')
      		{
				if($f==1)
				{
					$arr1 = $arr1 . " and ";
				}
				$arr1 = $arr1 . " school_id like '%$school_id%'";
				$f = 1;
      		//$arr=mysql_query("select * from tbl_student  where school_id='$school_id'");
      		}
			if($std_name!='')
      		{
				if($f==1)
				{
					$arr1 = $arr1 . " and ";
				}
				$arr1 = $arr1 . " std_complete_name like '%$std_name%'";
				$f = 1;
      		//$arr=mysql_query("select * from tbl_student  where school_id='$school_id'");
      		}
					 $arr = $arr . $arr1;
					// echo $arr;
					$sql = mysql_query($arr);
              

      		/*if($roll_no!='')
      		{
      		$arr=mysql_query("select * from tbl_student  where std_PRN='$roll_no'");
      		}

      		else if($class!='')
      		{
      		$arr=mysql_query("select * from tbl_student  where std_class='$class'");
      		}

      		else if($school_id!='')
      		{
      		$arr=mysql_query("select * from tbl_student  where school_id='$school_id'");
      		}

      		else
      		{
      		$arr=mysql_query("select * from tbl_student  where std_name='$std_name'");
      		}
*/


							  while($result=mysql_fetch_array($sql))
					{
					?>


                        <tr>
                            <td align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
							<?php echo  $tbl_id=$result['std_PRN'];?> </td>
                            <td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
							<?php echo $result['std_complete_name'];?></td>
                            <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
							<?php  echo $result['std_Father_name'];?> </td>
                            <td style="padding-left:10px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
							<?php echo $result['std_school_name'];?></td>
                            <td style="padding-left:30px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
                           <a href="assign_parentid_child.php?std_prn=<?php echo $tbl_id; ?>&id=<?php echo $id;?>&sch_id=<?php echo $result['school_id'];?>"><input type="button" name="add" value="Add" id="search-btn" style="width:70px; height:32px; background-color:#0080FF; color:#FFFFFF; border:1px solid #CCCCCC;" /></td></a>
                            
                        </tr>
                        <?php
                        }
           
			}
					      ?>
        
                 
                    
                </tbody>
            </table>
            <?php }?>
   		 </div>
       
   </div>
</body>
</html>
