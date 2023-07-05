<?php include('Parent_header.php');
if(!isset($_SESSION['id']))
	{
		header('location:index.php');
	}
	$id=$_SESSION['id'];
	$i=0;
    $row=mysql_query("select distinct school_id from tbl_parent where Id='$id'");
	while($values=mysql_fetch_array($row))
	{
	 $school_id[$i]=$values['school_id'];
	 $i++;
	
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
<link rel="stylesheet" href="css/bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-2.2.3/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-2.2.3/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>

<script>

$(document).ready(function() {

    $('#example').dataTable( {
       "order": [[ 8, "desc" ]]


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
<body>

   <div style="bgcolor:#CCCCCC">



<div class="" style="padding:30px;" >

        	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">





                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

                      <!-- <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Degree" style="font-weight:bold;font-size:14px;"/></a>      -->

               			 </div>

              			 <div class="col-md-10 " align="center"  >

                         	<div style="padding-left:200px; margin-top:4px;color:#0000FF;font-size:38px;">Assign Blue Points</div>

               			 </div>



                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >

   <table id="example" class="display" width="100%" cellspacing="0">
        <thead>
            <th>Sr. No.</th>
            <th>Teacher Name</th>
            <th>Teacher ID</th>
            <th>School Name</th>
            <th>Balance Blue Points</th>
			<th>Used Blue Points</th>
            
            <th>Assign</th>
        </thead>

        <tbody>
          <?php
		  $i=1;
					$students=array();
					$school_ids=array();
			// for($j=0;$j<count($school_id);$j++)
			 //{
				 $a=0;$b=0;
				 $t=0;
			 	$sql=mysql_query("SELECT `std_PRN`,`id`,`school_id` FROM `tbl_student` WHERE `parent_id`='$id'");
                while($result=mysql_fetch_array($sql))
				{
					$students[$a]=$result['std_PRN'];
					$school_ids[$b]=$result['school_id'];
					$a++;$b++;
				}
				 $ids = join("','",$students); 
				$sids= join("','",$school_ids); 
				//print_r($ids);				 
				 //$sql = "SELECT * FROM galleries WHERE id IN ('$ids')";
					$sql1=mysql_query("SELECT `teacher_ID` FROM `tbl_student_subject_master` where `student_id` IN ('$ids') and `school_id` IN ('$sids') ");
					while($result1=mysql_fetch_array($sql1))
					{
						$teachers[$t]=$result1['teacher_ID'];
						$t++;
						
					}
					 $id1s = join("','",$teachers); 
                      if(!empty($id1s))
					  {						  
				     //print_r($id1s);
             			$sql2=mysql_query("SELECT t_id,`t_complete_name`,t_name,t_middlename,t_lastname,t_current_school_name,balance_blue_points,used_blue_points FROM `tbl_teacher` where `t_id` IN ('$id1s')");
					
					 while($result2=mysql_fetch_array($sql2)){ 
					?>
           <tr>
              <td><?php echo $i;   ?></td>
              <td><?php echo  $result2['t_name'] ." ".$result2['t_middlename'] ." ".$result2['t_lastname'];?></td>
               <td><?php echo $result2['t_id'];?></td>
              <td><?php echo $result2['t_current_school_name'];?></td>
               <td><?php echo $result2['balance_blue_points'];?></td>
			   <td><?php echo $result2['used_blue_points'];?></td>
                
                 <td><a href="parent_assignbluepoint_teacher.php?id=<?php echo $result2['t_id'];?>"> <input type="button" value="Assign" name="assign" class="btn "/></a></td>
                 


           </tr>

					 <?php $i++;}}?>
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

                      <?php    echo $report;          ?>

               			</div>
                    </div>
               </div>
               </div>
</body>
</html>