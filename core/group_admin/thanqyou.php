<?php
 include_once('groupadminheader.php');
 $id=$_SESSION['id'];
 $group_member_id=$id;
		?>

       <html>
       <head>
       <link rel="stylesheet" type="text/css" href="../css/student_dashboard_test.css">
       <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
		<script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/sum().js"></script>
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
        
        window.location = "delete_thanqyou.php?id="+xxx;
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
   <div class="container" style="padding-top:50px;">
  
 <div class="row" style="padding:5px;height:50px; background-color:#C1CDCD ;border-color:#C1CDCD">

    <div class="col-md-8 "  align="left">
                
                    <h1 style="padding-left:5px; margin-top:5px;">ThanQ List </h1>
         </div>
             <!--    <div class="col-md-4"  align="right">
            <a href="addthanq.php"><input type="button" class="btn btn-primary" name="Add" value="Add ThanQ - Reason" ></a>
                 </div> -->
				   <div class="col-md-4"  align="left">
               <a href="addthanq.php"><input type="button" class="btn btn-primary" name="Add" value="Add ThanQ - Reason" style="background-color:"></a>
                 </div>
				   <div class="col-md-4"  align="right">
               <a href="copyCookieToGroup.php"><input type="submit" class="btn btn-primary" name="copy" value="Copy from Cookieadmin" style="background-color:;margin-top:-50px"></a>
                 </div>
          </div>
    
         
   
 
   <div class="row" style="padding-top:30px;">
     <div class="container" style="padding:20px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:10px;font-color:#000000;"  >
   
     <div id="no-more-tables" style="padding-top:20px;">
          
        
                    <table id="example" class="display "  width="80%" cellspacing="0" style="padding-top:10px;">
                <thead>
                    <tr>
                        <th width="10%" >Sr. No.</th>
                        <th width="30%">Reason</th>
                     
                        <th width="10%" >Edit</th>
                        <th width="10%">Delete</th>
                        
                       
                    </tr>
                </thead>
         
               
         
                <tbody>
                     <?php 
					 $sql="select * from tbl_thanqyoupointslist where school_id='0' AND group_member_id='$group_member_id'";
       						
                         
                           
                    $i=0;
                        $arr1 = mysql_query($sql);
                        while($row1 = mysql_fetch_array($arr1))
                        {
                        $i++;
                        ?>
                        <tr>
                            <td data-title="Sr.No" width="10%" ><?php echo $i;?></td>
                            <td data-title="Activity" width="30%"  ><?php echo ucwords($row1['t_list']);?></td>
                            
                            <td data-title="Edit" width="10%"  ><a style="text-decoration:none"> <a href="edit_thanqyou.php?id=<?php echo $row1['id'];  ?>">  <span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td data-title="Delete" width="10%" ><a style="text-decoration:none" onClick="confirmation(<?php echo $row1['id']; ?> )"><span class="glyphicon glyphicon-trash"></span></a></td>
                           
                            
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
   

</body>
</html>



