<?php
include("scadmin_header.php");
$batch_id=$_GET['id'];
$sql_query=mysql_query("select * from tbl_Batch_Master where id='$batch_id'");
$result_query=mysql_fetch_array($sql_query);
$b_id=$result_query['batch_id'];
$batchid=$result_query['id'];



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Display records</title>

</head>

<body>
<div class="container" style="padding-top:30px;">

<div class="row" style="padding-top:10px;" align="center"><h3>Teacher batch report</h3></div>
<div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="#" style="text-decoration:none;" >
        <div class="panel panel-info ">
          <div class="panel-heading">
            <h3 class="panel-title" align="center"><b>Total uploaded records </b> </h3>
          </div>
          <div class="panel-body" style="font-size:x-large" align="center">
          <?php 	
                                    echo $result_query['num_records_uploaded'];
                        ?>
          </div>
        </div></a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
        <div class="panel panel-info ">
          <div class="panel-heading">
            <h3 class="panel-title" align="center"><b>Error <br />
Records </b> </h3>
          </div>
          <div class="panel-body" style="font-size:x-large" align="center">
          <?php 	
        echo $result_query['num_errors_records'];
                        ?>
          </div>
        </div></a>
        </div>


        <div class="col-md-3"><a href="#" style="text-decoration:none;">
        <div class="panel panel-info ">
          <div class="panel-heading">
            <h3 class="panel-title" align="center"><b>Correct Records</b> </h3>
          </div>
          <div class="panel-body" style="font-size:x-large" align="center">
          <?php 	
                                 
         echo $result_query['num_correct_records'];
                        
                        ?>
          </div>
        </div></a>
        </div>


            <div class="col-md-3"><a href="#" style="text-decoration:none;">
            <div class="panel panel-info ">
              <div class="panel-heading">
                <h3 class="panel-title" align="center"><b>Duplicate Records</b> </h3>
              </div>
              <div class="panel-body" style="font-size:x-large" align="center">
              <?php 	
                                     
             echo $result_query['num_duplicates_record'];
                            
                            ?>
              </div>
            </div></a>
            </div>









</div>





<div class="row" style="padding-top:20px;">
<div class="col-md-1"></div>

<div class="col-md-3"><a href="#" style="text-decoration:none;">
        <div class="panel panel-info ">
          <div class="panel-heading">
            <h3 class="panel-title" align="center"><b>New Records </b> </h3>
          </div>
          <div class="panel-body" style="font-size:x-large" align="center">
          <?php 	
        echo $result_query['num_newrecords_inserted'];
                        ?>
          </div>
        </div></a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;" >
        <div class="panel panel-info ">
          <div class="panel-heading">
            <h3 class="panel-title" align="center"><b>Updated Records </b> </h3>
          </div>
          <div class="panel-body" style="font-size:x-large" align="center">
          <?php 	
                                    echo $result_query['num_records_updated'];
                        ?>
          </div>
        </div></a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
        <div class="panel panel-info ">
          <div class="panel-heading">
            <h3 class="panel-title" align="center"><b>Existing Records </b> </h3>
          </div>
          <div class="panel-body" style="font-size:x-large" align="center">
          <?php 	
        echo $result_query['existing_records'];
                        ?>
          </div>
        </div></a>
        </div>


 
      











</div>













</div>

</body>
</html>