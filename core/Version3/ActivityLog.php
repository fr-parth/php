<?php
include('scadmin_header.php');
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
/*echo date("Y-m-d h:i:s"); */
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

              			 <div class="col-md-10 " align="center"  >

                         	<div style="font-size:34px;">Login Status </div>

               			 </div>



                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >

   <table id="example" class="display" width="100%" cellspacing="0">
        <thead>
            <th>Name</th>
            <th>Entity Type</th>
            <!--<th>FirstLoginTime</th>
            <th>FirstMethod</th>
            <th>FirstDeviceDetails</th>
            <th>FirstPlatformOS</th>
            <th>FirstIPAddress</th>
            <th>FirstLatitude</th>
            <th>FirstLongitude</th>
            <th>FirstBrowser</th>-->
            <th>Activity</th>
            <th>Time</th>


            <!--<th>CountryCode</th> -->
        </thead>

        <tbody>
         <?php
         $table = "";
         $ent_type ="";
         $name = "";
         function checkEntity($entity)
         {
           $data = array();
            switch($entity)
            {
              case 105:
                    $data['table'] = "tbl_student";
                    $data['ent_type'] = "STUDENT";
                    $data['name'] ="std_complete_name";
                    break;
              case 103:
                    $data['table'] = "tbl_teacher";
                    $data['ent_type'] = "TEACHER";
                    $data['name'] ="t_complete_name";
                    break;
            }
           return $data;
         }


          $sql = "SELECT `EntityID`,`Entity_type`,`Timestamp`,`Activity`,`CountryCode` FROM `tbl_ActivityLog` WHERE 1" ;
 /*school_id='".$school_id."'"        */
          $query = mysql_query($sql);
          while ($row = mysql_fetch_assoc($query))
          {
             $data =  checkEntity($row['Entity_type']);
             $entity_type = $data['ent_type'];
             $sql1 = "SELECT ".$data['name']." as name from ".$data['table']." WHERE id='".$row['EntityID']."'";
             $q = mysql_query($sql1);
             $row1 = mysql_fetch_array($q);
           ?>
           <tr>
              <td><?php echo strtoupper($row1['name']); ?></td>
              <td><?php echo $entity_type; ?></td>
              <td><?php echo $row['Activity']; ?></td>
             <!-- <td><?php if($row['LogoutTime']!="") {echo $row['LogoutTime'];}else{echo "<div style='color:#428BCA'>Running</div>";} ?></td>   -->
              <!--<td><?php echo $row['LatestMethod']; ?></td>  -->
              <td><?php echo $row['Timestamp']; ?></td>
              <!--<td><?php echo $row['LatestPlatformOS']; ?></td>
              <td><?php echo $row['LatestIPAddress']; ?></td>
              <td><?php echo $row['LatestBrowser']; ?></td>-->


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