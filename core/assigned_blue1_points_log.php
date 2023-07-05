<?php
//Added by Rutuja for SMC-4472 to solve the issue of 404 on 31/01/2020
include('corporate_cookieadminheader.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

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
<body>

   <div style="bgcolor:#CCCCCC">



<div class="" style="padding:30px;" >

        	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

                      <!-- <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Degree" style="font-weight:bold;font-size:14px;"/></a>      -->

               			 </div>

              			 <div class="col-md-10 " align="center" style="padding-left:300px;" >

                         	<h2 style="color:#0000FF">Blue Points Assigned Log</h2>

               			 </div>



                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >

   <table id="example" class="display" width="100%" cellspacing="0">
        <thead>
		<th>Sr. No.</th>
            <th>Assigned By</th>
            <th>Reciever</th>
            <th>Reciever ID</th>
            <th>Blue Point</th>
            <th>Date</th>
            <th>Time</th>
            

           
        </thead>

        <tbody>
         <?php
            $i=1;

          $sql = "SELECT * FROM `tbl_distribute_points_by_cookieadmin` WHERE `point_color`='BLUE' and `assigned_by`='cookieadmin' ORDER BY STR_TO_DATE( `date` , '%Y/%m/%d'  )  DESC" ;
          $query = mysql_query($sql);
          while ($row = mysql_fetch_assoc($query))
          {
             ?>
           <tr>
		   	<td><?php echo $i++; ?></td>
              <td><?php echo strtoupper($row['assigned_by']); ?></td>
              <td><?php echo ucwords($row['entity_name']); ?></td>
              <td><?php echo $row['entity_id']; ?></td>
			  <td><?php echo $row['points']; ?></td>
			   <td><?php echo $row['date']; ?></td>
			     <td><?php echo $row['time']; ?></td>
             


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