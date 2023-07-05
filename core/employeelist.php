
<?php
include('hr_header.php');
$report="";
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];


?>

<?php
if(isset($_GET['id'])){
	
	$sp=$_GET['id'];
	//$id=$_GET['id']
	mysql_query(" DELETE FROM `tbl_student` WHERE `id`= $sp ");
	//mysql_query(" DELETE FROM `tbl_sponsored` WHERE `sponsor_id`= $sp ");
	header("Location:employeelist.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">





<script src="jquery.js"></script>

<script src="jquery.dataTables.js"></script>



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

        







<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>

</head>



<script>

/*$(document).ready(function() {

	$('#example').dataTable( {

	"aProcessing": true,

	"b.ServerSide": true,

	"ajax": "server-response_student.php?sc_id="+<?php echo $sc_id; ?>,

	} );

	} );
*/

  $(document).ready(function() {

    $('#example').dataTable( {





    } );

} );



</script>
<script>
    function confirmation(xxx)
  {
    var s = "Are you sure you want to delete?";
    var answer = confirm(s);
    if (answer){

        window.location = "employeelist.php?id="+xxx;
    }
    else{

    }
  }
</script>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">



<div class="container" style="padding:30px;" >

        	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   

                   

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

 <a href="employee_setup.php">

                          <input type="submit" class="btn btn-primary" name="submit" value="Add employee" style="width:150;font-weight:bold;font-size:14px;"/></a>

					
					
					
                                      			 </div>

              			 <div class="col-md-6 " align="center"  >

                         	<h2>List of Employee</h2>

               			 </div>

                         

                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >



            

    <table id="example" class="display" width="100%" cellspacing="0">

        <thead>

            <tr>

               
				
				<th style="width:100px;" ><center> PRN</center></th>
				<th style="width:100px;" ><center>Employee Name</center></th>
				
				<th style="width:100px;" ><center>Email ID</center></th>
			    <th style="width:100px;" ><center>Mobile No</center></th>
		        <th>Edit</th>
                <th>Delete</th>


               

            </tr>

        </thead>
        <tbody>
            <?php
               $sql= "select id,std_PRN,std_complete_name,std_email,Course_level,std_phone,batch_id from tbl_student where school_id='$sc_id'";
               $query = mysql_query($sql);
                while($rows=mysql_fetch_assoc($query))
                  {
             ?>
            <tr class="active" 
				  onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"
				  onmouseout="this.style.textDecoration='none';this.style.color='black';" 
				  onclick="window.location='studentinformation.php?prn=<?php echo $rows['std_PRN'];?>'"
				  style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-color: rgb(239, 243, 251);height:30px;color:#808080;"
				>
                 <td style="width:100px;">
                     <?php echo $rows['std_PRN']; ?>
                 </td>
                 <td style="width:100px;">
                    <center> <?php echo $rows['std_complete_name']; ?></center>
                 </td>
				 
                 <td style="width:100px;">
                   <center>  <?php echo $rows['std_email']; ?> </center>
                 </td>
                 <td style="width:100px;">
                    <center> <?php echo $rows['std_phone']; ?></center>
                 </td>
                 
                 <td>
                     <a style="cursor: pointer;" href="edit_employee_details.php?std_prn=<?php echo $rows['std_PRN']; ?>">Edit</a>
                 </td>
                <td><center><a onClick="confirmation(<?php echo $rows['id']; ?>)">Delete</a></center>
				 </td>
             </tr>

              <?php } ?>
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

                      <div class="col-md-3" style="color:#FF0000;" align="center">

                      

                      <?php echo $report;?>

               			</div>

                 

                    </div>

                 

               </div>

               </div>

</body>

</html>






































			

