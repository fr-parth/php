<?php
//Created by Rutuja to display Academic Years of CookieAdmin for SMC-4663 on 10/04/2020
include('cookieadminheader.php');

    //     $id=$_SESSION['staff_id'];

           $fields=array("id"=>$id);

        /*   $table="tbl_school_admin";
*/


           $smartcookie=new smartcookie();



$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);

$sc_id=$result['id'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Academic Year List</title>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script>

$(document).ready(function() {

    $('#example').dataTable( {



    } );

} );

   function confirmation(xxx) 
{
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_school_academic_year.php?id="+xxx;
    
    
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

}

</style>



</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">



<div class="container" style="padding:30px;" >

          <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">





                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

                       <a href="Add_academic_year_cookieadmin.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Academic Year" style="font-weight:bold;font-size:14px;"/></a>

                     </div>

                     <div class="col-md-6 " align="center"  >

                          <h2>Academic Year List </h2>

                     </div>



                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >





    <table id="example" align="center" class="display" style="text-align: center;" width="100%" cellspacing="0">

        <thead style="text-align: center;">

            <tr><!-- Camel casing done for Sr. No. by Pranali -->
                <th style="width:100px; text-align: center;">Sr. No.</th>
        <th style="text-align: center;">External Year Id</th>

                <th style="text-align: center;">Academic Year</th>

                <!--<th>Teacher ID</th>   -->

                <th style="text-align: center;">Year</th>
                 <th style="text-align: center;">Enable</th>
          <th style="text-align: center;">Edit</th>
                 
            </tr>

        </thead>
        <tbody>
            <?php $sql = "SELECT DISTINCT * FROM  tbl_academic_Year  WHERE `school_id`='0' and group_member_id='0' order by id desc";
                  $query = mysql_query($sql);
//$i variable used instead of $rows['id'] for displaying Sr.No. for SMC-3655 by Pranali 
          $i=1;
                  while($rows=mysql_fetch_assoc($query))
                  {  
          
        ?>
                  <tr>
                      <td>
                          <?php echo $i; ?>
                      </td>
            <td>
                          <?php echo $rows['ExtYearID']; ?>
                      </td>
                      <td>
                          <?php echo $rows['Academic_Year']; ?>
             
                      </td>
                      <td>
                          <?php echo $rows['Year']; ?>
                      </td>
 <td>
                          <?php echo $rows['Enable']; ?>
                      </td>

            
                      <!--<td>
                          <?php echo $rows['department']; ?>
                      </td>
                      <td>
                          <?php echo $rows['batch_id']; ?>
              
                      </td>-->
            
          <th style="width:30px;" ><b><center>

                 <?php $id= $row['id'];?>  <a href="Add_academic_year_cookieadmin.php?id=<?php echo $rows['id']; ?>" <span class="glyphicon glyphicon-pencil"></span></a></center></b></th>
         <!-- 
          <th style="width:100px;" ><!--<a href="list_school_academic_year.php?id=<?php// echo $row['id'];?>"> <span class="glyphicon glyphicon-trash"></span></a></center></b></th>
          -->
              
                    
                  
            
                                       
                  </tr>

                 <?php $i++;    //changes end for SMC-3655
         } ?>


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



