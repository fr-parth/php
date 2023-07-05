<?php
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

              			 <div class="col-md-10 " align="center"  >

                         	<h2>Login Status </h2>

               			 </div>



                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >

   <table id="example" class="display" width="100%" cellspacing="0">
        <thead>
             <th>Sr. No.</th>
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
            <th>Login Time</th>
            <th>Logout Time</th>
            <!--<th>LatestMethod</th>-->
            <th>Device Details</th>
            <th>Platform OS</th>
            <th>IP Address</th>
            <!--<th>LatestLatitude</th>
            <th>LatestLongitude</th>-->
            <th>Browser</th>

            <!--<th>CountryCode</th> -->
        </thead>

        <tbody>
         <?php
          $i = 1;
         $table = "";
         $ent_type ="";
         $name = "";
         function checkEntity($entity)
         {
           $data = array();
            switch($entity)
            {
              case 205:
                    $data['table'] = "tbl_student";
                    $data['ent_type'] = "EMPLOYEE";
                    $data['name'] ="std_complete_name";
                    $data['fname'] = "std_name";
                    $data['mname'] = "std_Father_name";
                    $data['lname'] = "std_lastname";
                    break;
              case 203:
                    $data['table'] = "tbl_teacher";
                    $data['ent_type'] = "MANAGER";
                    $data['name'] ="t_complete_name";
                    break;
            }
           return $data;
         }
         define('MAX_REC_PER_PAGE', 100);
                                //getting total count
                                $rs = mysql_query("SELECT COUNT(*) FROM tbl_LoginStatus")
                                or die("Count query error!");
                                list($total) = mysql_fetch_row($rs);
                                    // echo " MAX " . MAX_REC_PER_PAGE;
                                //diving total by 100
                                $total_pages = ceil($total / MAX_REC_PER_PAGE);
                                // echo " Total page " . $total_pages;
                                $page = intval(@$_GET["page"]);
                                if ($page == 0){
                                    $page = 1;
                                }
                                // echo " page " . $page;
                                $start = MAX_REC_PER_PAGE * ($page - 1);
                                // echo " start " . $start;
                                $i = $start + 1; //for serial number
                                $max = MAX_REC_PER_PAGE;
                                //retriving 100 rows each time

          $sql = "SELECT `EntityID`,`Entity_type`,`LatestLoginTime`,`LogoutTime`,`LatestMethod`,`LatestDeviceDetails`,`LatestPlatformOS`,`LatestIPAddress`,`LatestBrowser`,`school_id` FROM `tbl_LoginStatus` WHERE Entity_type='203' or Entity_type='205' ORDER BY RowID DESC LIMIT $start, $max";
          $query = mysql_query($sql);
          while ($row = mysql_fetch_assoc($query))
          {
             $data =  checkEntity($row['Entity_type']);
             $entity_type = $data['ent_type'];
             $sql1 = "SELECT " . $data['name'] . " as name from " . $data['table'] . " WHERE id='".$row['EntityID']."'";
             $q = mysql_query($sql1);
             $row1 = mysql_fetch_array($q);
           ?>
           <tr>
            <td><?php echo $i++; ?></td>
              <td><?php echo strtoupper($row1['name']); ?></td>
              <!-- <td><?php //echo $row['Entity_type']; ?></td> -->
              <td><?php echo ucwords($entity_type);echo "<br>"; if($row['school_id']!=''){echo '('.$row['school_id'].')';}else{}?></td>
              <td><?php echo $row['LatestLoginTime']; ?></td>
              <td><?php if($row['LogoutTime']!="") {echo $row['LogoutTime'];}else{echo "<div style='color:#694489'>Running</div>";} ?></td>
              <!--<td><?php echo $row['LatestMethod']; ?></td>  -->
              <td><?php echo $row['LatestDeviceDetails']; ?></td>
              <td><?php echo $row['LatestPlatformOS']; ?></td>
              <td><?php echo $row['LatestIPAddress']; ?></td>
              <td><?php echo $row['LatestBrowser']; ?></td>


           </tr>

          <?php } ?>
        </tbody>
   </table>

                  </div>
<div border="1">
                            <center>
                            <?php
                            // for previous
                                if($page > 1)
                                    {
                                    $previous = $page - 1;
                                    // echo $previous;
                            ?>
                            <a href="?page=<?php echo $previous; ?>&max=<?php echo $max; ?>"> << PREV </a>
                            <?php
                            // for next
                                    }
                                if($page < $total_pages)
                                    {
                                    $next = $page + 1;
                            ?>
                            &nbsp &nbsp <a href="?page=<?php echo $next; ?>&max=<?php echo $max; ?>">NEXT >></a>
                            <?php
                                    }
                            ?>
                            </center>
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