<?php
//Created by Rutuja for SMC-4447 on 23/01/2020
 include_once('cookieadminheader.php');
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
						$date=date('Y/m/d');
						$d=strtotime("+6 Months");
						$validity=date("Y/m/d",$d);
						
						
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
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
       // alert("Activity has been deleted successfully..");
        window.location = "delete_system_activity.php?id="+xxx;
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


<div class="container" style="padding:10px;">

          <div class="row" style="padding:5px;height:50px; background-color:#C1CDCD ;border-color:#C1CDCD">

    <div class="col-md-8 "  align="left">
                
                    <h1 style="padding-left:50%; margin-top:5px;">List of Referral Activity Reasons </h1>
         </div>

        
		 <?php  
		 $sql2="SELECT id,reason_id,reason FROM referral_activity_reasons order by id desc limit 1";
       				       
                        $arr2 = mysql_query($sql2);
                         while($row2 = mysql_fetch_array($arr2))
                        {
                       
                       $reason_id=$row2['reason_id'];
						}
         ?>
                 <div class="col-md-4"  align="right">
              <a href="add_referal_activity_reason.php?reason=<?php echo $reason_id;  ?>" ><input type="button" class="btn btn-primary" name="Add" value="Add Referral Activity Reason" style="background-color:"></a>
                 </div>
          </div>
                 
               
        <div id="no-more-tables" style="padding-top:20px;">
          
        
                    <table id="example" class="display "  width="80%" cellspacing="0" style="padding-top:10px;">
                <thead>
                    <tr>
                        <th width="10%" align="center">Sr. No.</th>
                        <th width="50%" align="left">Referral Activity Reason</th>
                        <th width="20%" align="left">Reason ID</th>
                         <th width="20%" align="left">Edit</th>
                       
                        
                       
                    </tr>
                </thead>
         
               
         
                <tbody>
                     <?php  $sql="SELECT id,reason_id,reason FROM referral_activity_reasons";
       						
                         
                           
                    $i=0;
                        $arr1 = mysql_query($sql);
                        while($row1 = mysql_fetch_array($arr1))
                        {
                        $i++;
                        ?>
                        <tr>
                            <td data-title="Sr.No" width="15%" align="center"><?php echo $i;?></td>
                            <td data-title="Activity" width="45%"><?php echo ucwords($row1['reason']);?></td>
                            <td data-title="points" width="20%" ><?php echo $row1['reason_id'];?></td>
                           <td><a href="add_referal_activity_reason.php?&id=<?php echo $row1['id'];?>"><i class='glyphicon glyphicon-pencil'></i></a></td>
                           
                            
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










