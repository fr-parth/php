<?php
include('groupadminheader.php');
$group_member_id=$_SESSION['group_admin_id'];;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
 <link rel="stylesheet" href="../css/bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">



<script>

$(document).ready(function() {

    $('#example').dataTable( {



    } );

} );

</script>



<script src="../js/jquery-1.11.1.min.js"></script>

<script src="../js/jquery.dataTables.min.js"></script>



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

                         	<h2 style="color:#0000FF">Blue Points Coupon Issued Log</h2>

               			 </div>



                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >

   <table id="example" class="display" width="100%" cellspacing="0">
        <thead>
		<th>Sr. No.</th>
            <th>Coupon Id</th>
            <th>Points</th>
            <th>Issue Date</th>
            <th>Issued To</th>
			<th>School ID</th>
            <th>Entity</th>
           
            

           
        </thead>

        <tbody>
         <?php
           $i=1;

          $sql = "SELECT gp.*,sa.school_name,sa.school_id,sa.group_member_id FROM tbl_giftof_bluepoint gp join tbl_school_admin sa on gp.user_id=sa.school_id or gp.user_id=sa.id INNER JOIN tbl_group_school gs ON sa.school_id=gs.school_id where  gs.group_member_id='$group_member_id' and gp.entities_id='102' and gp.points!=0 group by coupon_id order by id desc";
          $query = mysql_query($sql);
          while ($row = mysql_fetch_assoc($query))
          {
             ?>
           <tr>
				<td><?php echo $i++; ?></td>
              <td><?php echo $row['coupon_id']; ?></td>
              <td><?php echo $row['points']; ?></td>
              <td><?php echo $row['issue_date']; ?></td>
			  <td><?php echo $row['school_name']; ?></td>
			  <td><?php echo $row['school_id']; ?></td>
			   <td><?php echo 'SCHOOL ADMIN'; ?></td>
			    
             


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