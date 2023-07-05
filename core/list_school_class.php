<?php

              if(isset($_GET['name']))

			  {

			$report="";

             include_once("school_staff_header.php");   

	//     $id=$_SESSION['staff_id'];

          

		   

$results=mysql_query("select * from tbl_school_adminstaff where id=".$staff_id."");

$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>

 

<script>

$(document).ready(function()

 {

    $('#example').dataTable(

	 {

      //  "pagingType": "full_numbers"

     });

   });

function confirmation(xxx)

  {

    var answer = confirm("Are you sure you want to delete?")

    if (answer){

        

        window.location = "delete_school_class.php?id="+xxx;

    }

    else{

       

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

                   

                    

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                       <a href="add_school_class.php?id=<?=$staff_id?>">   <input type="submit" class="btn btn-primary" name="submit" value="Add Class" style="width:100px;font-weight:bold;font-size:14px;"/></a>

               			 </div>

              			 <div class="col-md-5 " align="center" style="color:black;padding:5px;" >

                         	<h2> Classes</h2>

               			 </div>

                         

                     </div>

                  <div class="row">

             

               <div class="col-md-0">

               </div>

               <div class="col-md-12 ">

               <?php $i=0;?>

                  <table id="example" class="display" width="100%" cellspacing="0">

                     <thead>
					<!-- Camel casing done for Sr. No. by Pranali -->
                    	<tr ><th style="width:30%;" ><b><center>Sr. No.</center></b></th><th style="width:30%;" ><center>Class </center></th><th style="width:20%;" ><b><center>Edit</center></b></th><th style="width:40%;" ><center>Delete</center></th></tr></thead><tbody>

                 <?php

				 

				   $i=1;

				  $arr=mysql_query("select class from Class where school_id='$sc_id' ORDER BY class ASC");?>

                  <?php while($row=mysql_fetch_array($arr)){?>

                 <tr style="height:30px;color:#808080;"><th style="width:100px;" ><b><center><?php echo $i;?></center></b></th><th style="width:150px;" ><center><?php echo $row['class'];?></center> </th><th style="width:100px;" ><b><center> 

                 <?php $class_id= $row['id'];?>  <a href="edit_school_class.php?cl=<?php echo $class_id; ?>">co</a></center></b></th><th style="width:150px;" ><center><a onClick="confirmation(<?php echo $class_id; ?> )"> Delete</a></center> </th></tr>

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

                     <div class="row" >

                     <div class="col-md-4">

                     </div>



                      <div class="col-md-4" style="color:#FF0000;" align="center">

                      

                      <?php if(isset($_GET['report'])){echo $_GET['report'];}?>

               			</div>

                 

                    </div>

                </div>

               </div>

</body>

</html>

<?php  

			  }else

			  {

include('scadmin_header.php');

    //     $id=$_SESSION['staff_id'];

           $fields=array("id"=>$id);

		/*   $table="tbl_school_admin";
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

<title><?php echo $dynamic_class;?></title>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

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

}

</style>



</head>



<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div>



</div>

<div class="container" style="padding:25px;" >

        	

            

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   

                    

                    <div style="background-color:#F8F8F8 ;">

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

                       <a href="add_school_class.php">   <input type="button" class="btn btn-primary" name="submit" value="Add <?php echo $dynamic_class;?>" style="width:100px;font-weight:bold;font-size:14px;"/></a>
               			 </div>

              			 <div class="col-md-5 " align="center" style="color:black;padding:5px;" >



                   				<h2> <?php echo $dynamic_classes;?></h2>

               			 </div>

                         

                     </div>

                  

                 

                   

                  

               <div class="row">

             
<div class="col-md-2 ">
</div>
              

              <div class="col-md-12 ">

               <?php $i=0;?>

                  <table id="example" class="display" width="100%" cellspacing="0">

                     <thead>

                    	<tr><th style="width:30%;" ><b><center><?php echo $dynamic_class;?> ID</center></b></th>
						<th style="width:30%;" ><center><?php echo $dynamic_class;?> </center></th>
						<!-- Camel casing done for Course Level by Pranali -->
                        <th style="width:30%;" ><center><?php echo $dynamic_level;?></center></th>
                        <th style="width:20%;" ><b><center>Edit</center></b></th>
						<th style="width:20%;"<b><center>Delete</center></b></th></tr>
						</thead><tbody>

                 <?php

				 

				   $i=1;
                          //  echo ExtClassID;
				  $arr=mysql_query("select ExtClassID,id,class,course_level from Class where school_id='$sc_id' ORDER BY id");?>
				  
				  

                  <?php while($row=mysql_fetch_array($arr)){
					  //echo $row['ExtClassID'];die;
					  ?>
					
                 <tr style="height:30px;color:#808080;"><th style="width:100px;" ><b><center><?php echo $row['ExtClassID'];?></center></b></th>

                 <th style="width:150px;" ><center><?php echo $row['class'];?></center> </th>
                 <th style="width:150px;" ><center><?php echo $row['course_level'];?></center> </th>

					<th style="width:100px;" ><b><center>

                 <?php $class_id= $row['id'];?>  <a href="add_school_class.php?class=<?php echo $class_id; ?>"  ><span class="glyphicon glyphicon-pencil"></span></a></center></b></th>
				  
				  <th style="width:100px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete class.php?id=<?php echo $row['id'];?>"><span class="glyphicon glyphicon-trash"></span></a></center></b></th>
				  
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

                   

                  

                   </div>

                    </div>

                     

                      

                

                  

                 

                    

                    

                  

               </div>

               </div>

</body>

</html>

<?php

	}

?>