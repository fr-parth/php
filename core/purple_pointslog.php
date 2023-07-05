<?php
 include_once('stud_header.php');
 $id=$_SESSION['id'];
          $fields=array("id"=>$id);
		   $table="tbl_student";
	       $smartcookie=new smartcookie();
		   $result=$smartcookie->retrive_individual($table,$fields);
		   $results=mysql_fetch_array($result);
		   $city=$results['std_city'];
		   $country=$results['std_country'];
		   $std_PRN=$results['std_PRN'];
		   $school_id=$results['school_id'];
$report="";
	
	 ?>


       <html><head>
     
       <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  
  
		<script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script> 
          <script>
		
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

    
        <script>
	
        $(document).ready(function() {
            $('#example').dataTable( {
		
				
         });
			
  
        } );
		
		
        </script>
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
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		text-align:left;
		
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
        
        
        
       </head>
   <body style= "background: none repeat scroll 0% 0% transparent;border: 0px none; margin: 0px; outline: 0px none; padding: 0px;">


<div class="container" style="padding-top:10px;">

            <div class="row" style="color:#3c763d;font-weight:bold;padding-top:10px;">
            <h4 align="center">Purple Points Log</h4>
            </div>        
                  
  <div class="row">
	
   

  
  <div class="tab-content" style="padding-top:10px;">
    <div id="home" class="tab-pane fade in active">
     
       <div id="no-more-tables" style="padding-top:20px;">
          
                           
                    <table id="example" class="display"  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Parent Name</th>
                        <th>Points</th>
                        <th>Reason</th>
                        <th>Date</th>
                       
                    </tr>
                </thead>
               
        <tbody>
                  <?php   $sql1="SELECT s.Name, sp.sc_point, sp.sc_studentpointlist_id, sp.point_date
FROM tbl_student_point sp
JOIN tbl_parent s
WHERE sp.sc_teacher_id = s.Id
AND sp.sc_entites_id =  '106'
AND sp.sc_stud_id =  '$std_PRN'
ORDER BY sp.id DESC  ";
                    $i=0;
                        $arr1 = mysql_query($sql1);
                        while($row1 = mysql_fetch_array($arr1))
                        {
							$std_complete_name=ucwords(strtolower($row1['Name']));
							
								
                        $i++;
                        ?>
                        <tr>
                            <td data-title="Sr.No" ><?php echo $i;?></td>
                            <td data-title="student Name" ><?php echo $std_complete_name;?></td>
                            <td data-title="Points" ><?php echo $row1['sc_point'];?></td>
                            <td data-title="reason"><?php 
							$sc_studentpointlist_id=$row1['sc_studentpointlist_id'];
							$sql_query=mysql_query("select sc_list from tbl_studentpointslist where sc_id='$sc_studentpointlist_id' and school_id='$school_id'");
							$result_query=mysql_fetch_array($sql_query);
							echo $result_query['sc_list'];
							
							?></td>
                            <td data-title="Date"><?php echo $row1['point_date'];?></td>
                            
                        </tr>
                        <?php
                        }
                        ?>
        
        
                 
                    
                </tbody>
            </table> 
            </div>
    </div>
   
  
    
  </div>
</div>
                 
               
       
                 


          
          
          
          
          
          </div>
          
          
          
          
          


</div>









</div>


</body>




</html>










