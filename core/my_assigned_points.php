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
$report="";
	
	 ?>


       <html>
       <head>
     
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
            <h4 align="center"> Assigned Points</h4>
            </div>        
                  
  <div class="row">
	
   

  
  <div class="tab-content" style="padding-top:10px;">
    <div id="home" class="tab-pane fade in active">
     
       <div id="no-more-tables" style="padding-top:20px;">
          
                      <table id="example" class="display"  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Activity/Subject</th>
                        <th>Points</th>
                        <th>Student Name</th>
                        <th>On Behalf of Teacher </th>
                        <th>Date</th>
                       
                    </tr>
                </thead>
         
               
         
                <tbody>
                 <?php 
							$row=mysql_query("SELECT t_complete_name,t_id
FROM tbl_coordinator
LEFT OUTER JOIN tbl_teacher t ON teacher_id = t.id
WHERE stud_id = '$id'");

							$value=mysql_fetch_array($row);
							$t_id=$value['t_id'];
 ?>
                    <?php
					
					
					
					  $sql1="SELECT sc_point as total_point, sc_studentpointlist_id, t.std_name ,t.std_complete_name, t.std_Father_name,t.std_lastname,point_date ,sc_teacher_id, IF( activity_type =  'subject', (SELECT distinct(subjectName)
FROM tbl_student_subject_master
WHERE subjcet_code=sc_studentpointlist_id limit 1), (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sc_studentpointlist_id ) ) AS sc_list FROM tbl_student_point sp JOIN tbl_student t ON sc_stud_id = t.std_PRN  WHERE sp.sc_entites_id =111 AND sp.sc_teacher_id ='$t_id' ORDER BY sp.id DESC  ";
                    $i=0;
                        $arr1 = mysql_query($sql1);
                        while($row1 = mysql_fetch_array($arr1))
                        {
                        $i++;
                        ?>
                        <tr>
                            <td data-title="Sr.No"><?php echo $i;?></td>
                            <td data-title="Activity"><?php echo $row1['sc_list'];?></td>
                            <td data-title="points"><?php echo $row1['total_point'];?></td>
                            <td data-title="Student Name"><?php 
							if($row1['std_complete_name']=="")
							{
							
							echo ucwords(strtolower($row1['std_name']))." ".ucwords(strtolower($row1['std_Father_name']))." ".ucwords(strtolower($row1['std_lastname']));
							}
							
							else
							{
							echo ucwords(strtolower($row1['std_complete_name']));
							}
							?></td>
                           
                            <td><?php echo ucwords(strtolower($value['t_complete_name']));?></td>
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










