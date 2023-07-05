<?php
 include_once('corporate_cookieadminheader.php');
 $id=$_SESSION['id'];
		$rows=mysql_query("select std_city,std_country,latitude,longitude from tbl_student where id='$id'");
        $results=mysql_fetch_array($rows);
        $city=$results['std_city'];
        $country=$results['std_country'];
$report="";
	
	 if(isset($_POST['submit']) && isset($_POST['coupon']))
	 {
	 	
	   	$cp_stud_id= $_SESSION['id'];
	   	$cp_point=$_POST['coupon'];
	  	 
		 
		 	$arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id =$cp_stud_id");
			$row=mysql_fetch_array($arra); 
			$sc_total_point=$row['sc_total_point'];
					//check total points of student is enough for genrate coupon
					if($sc_total_point>=$cp_point)
					{
						$sql="SELECT id FROM tbl_coupons ORDER BY id DESC LIMIT 1";
						$arr=mysql_query($sql);
						$row=mysql_fetch_array($arr);
						$id= $row['id']+1;
						$chars = "0123456789";
	 					$res = "";

   			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    					}

        				$id= $id."".$res ;
						//todays date
						$date=date('d/m/Y');
						$d=strtotime("+6 Months");
						$validity=date("d/m/Y",$d);
						
						
						mysql_query("insert into tbl_coupons(cp_stud_id,cp_code,amount,cp_gen_date,validity) values('$cp_stud_id','$id','$cp_point','$date','$validity')");
					  //reduce student point after generate coupon
						$sc_total_point = $sc_total_point - $cp_point;
						
						
						 $report="successfully generated coupon";
						 mysql_query("update tbl_student_reward set sc_total_point='$sc_total_point' where sc_stud_id='$cp_stud_id'");
						header("Location:student_dashboard.php?report=".$report);
						 
						//echo "<script type='javascript'>openRequestedPopup();</script>";
					  
						}
						
					
					
	}


?>


       <html>
       <head>
       <link rel="stylesheet" type="text/css" href="css/student_dashboard_test.css">
       <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/sum().js"></script>
        <script>
		
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

        $(document).ready(function() {
            $('#example').dataTable( {
			
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(2 ).footer() ).html(
                'Total points:'+pageTotal  
				
            );
        }
    } );
			
			
  
        } );
		function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete ?")
    if (answer){
        
        window.location = "delete_systemactivity_type.php?id="+xxx;
    }
    else{
       
    }
}
		
		
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


<div class="container" style="padding:25px;">
<div class="row" style="padding:5px;height:50px; background-color:#C1CDCD ;border-color:#C1CDCD">

    <div class="col-md-8 "  align="left">
                
                    <h1 style="padding-left:5px; margin-top:5px;">List of Activity Type</h1>
         </div>
                 <div class="col-md-4"  align="right">
                 <a href="addsystemlevel_activity_type.php"><input type="button" class="btn btn-primary" name="Add" value="Add Activity Type "></a>
                 </div>
                 </div>
                
       
          <div class="row"><div class="col-md-2" style="padding:10px;">
                </div>
          
          </div>
          <div class="row" style="padding:50px;">
          
          <div class="container" style="padding:20px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:10px;font-color:#000000;"  >
               
        <div id="no-more-tables " style="padding:10px;" >
          
        
                    <table id="example" class="display "   width="100%" cellspacing="0" style="padding-top:10px;">
                <thead>
                    <tr>
                        <th width="20%" align="left">Sr. No. </th>
                        <th width="50%" align="left">Activity Type</th>
                        <th width="10%" align="center">Edit</th>
                        <th width="10%" align="center">Delete</th>
                        
                       
                    </tr>
                </thead>
         
               
         
                <tbody>
                     <?php  $sql="select id,activity_type from  tbl_activity_type where school_id='0' ORDER BY  id DESC";
       						
                         
                           
                    $i=0;
                        $arr1 = mysql_query($sql);
                        while($row1 = mysql_fetch_array($arr1))
                        {
                        $i++;
                        ?>
                        <tr>
                            <td data-title="Sr.No" width="20%" align="center"><?php echo $i;?></td>
                          <td data-title="Activity Type" width="50%" ><?php echo $row1['activity_type'];?></td>
                            <td data-title="Edit" width="10%" align="center"> <a href="edit_system_activity_type.php?activity=<?php echo $row1['id'];  ?>"   style="text-decoration:none">Edit</a></td>
                            <td data-title="Delete" width="10%" align="center"><a style="text-decoration:none" onClick="confirmation(<?php echo $row1['id']; ?> )">Delete</a></td>
                           
                            
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














<!-- body-->
</div>
</body>

</html>










