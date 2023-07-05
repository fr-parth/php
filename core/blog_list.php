<?php
	include("scadmin_header.php");
	$id=$_SESSION['id'];
	$school_id=$_SESSION['school_id'];
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Display Blog List</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
	
	
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	 "scrollX": true
    } );
} );
    </script>


<?php

$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");
$week=date('Y-m-d 00:00:00', strtotime('-6 days'));
$last_day_this_month = date('Y-m-d 23:59:59'); 
$first_day_this_month = date('Y-m-d 00:00:00', strtotime('-29 days'));// hard-coded '01' for first day

$where1="";
 $std_PRN=$_GET['std_PRN'];
 $activity=$_GET['activity'];
 $blog_title=$_GET['blog_title'];
 $std_name=$_GET['std_name'];

$info = $_GET['info'];
$from=$_GET['from'];
$to=$_GET['to'];
if($from !="" AND $to !="")
{
	$to=$to." ".'23:59:59';
	$where1.=" AND (b.date BETWEEN '".$from."' AND '".$to."') ";
	
}
if($from !="" AND $to =="")
{
	$to=$date1;
	$where1.=" AND (b.date BETWEEN '".$from."' AND '".$to."') ";	
}
if($from =="" AND $to !="")
{	$from=$to." ".'00:00:00';
	$to=$to." ".'23:59:59';
	$where1.=" AND (b.date BETWEEN '".$from."' AND '".$to."') ";	
}
if($std_PRN !="")
{
	$where1.=" AND b.PRN_TID='".$std_PRN."' ";
}
if($activity !="")
{
	$where1.=" AND b.activity='".$activity."' ";
}
if($blog_title !="")
{
	$where1.=" AND b.BlogTitle LIKE '%".$blog_title."%' ";
}
if($std_name !="")
{
	$where1.=" AND b.name LIKE '%".$std_name."%' ";
}
//echo $where1;

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
$sql=mysql_query("SELECT b.featureimage, b.BlogTitle,b.Description,b.MemberID,b.EntityType,b.PRN_TID,b.name,b.date,b.activity,s.school_name FROM blog b join tbl_school_admin s on b.SchoolID=s.school_id where b.SchoolID='$school_id' order by b.BlogID desc LIMIT $start_from, $webpagelimit");	

$sql1 ="SELECT count(b.BlogID) FROM blog b join tbl_school_admin s on b.SchoolID=s.school_id where b.SchoolID='$school_id' order by b.BlogID desc LIMIT $start_from, $webpagelimit"; 
 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
}else
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

 $Search=mysql_real_escape_string($_GET['Search']); 
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($Search != '')
	{ 
		$query1=mysql_query("SELECT b.featureimage, b.BlogTitle,b.Description,b.MemberID,b.EntityType,b.PRN_TID,b.name,b.date,b.activity,s.school_name FROM blog b join tbl_school_admin s on b.SchoolID=s.school_id where b.SchoolID='$school_id' $where1 
		order by b.BlogID desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="SELECT count(b.BlogID) FROM blog b join tbl_school_admin s on b.SchoolID=s.school_id where b.SchoolID='$school_id' $where1 order by b.BlogID desc"; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
	
	
$query1=mysql_query("SELECT b.featureimage, b.BlogTitle,b.Description,b.MemberID,b.EntityType,b.PRN_TID,b.name,b.date,b.activity,s.school_name FROM blog b join tbl_school_admin s on b.SchoolID=s.school_id where b.SchoolID='$school_id'  and  $colname LIKE '%$searchq%' order by b.BlogID desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
					//echo $query1;
		$sql1 ="SELECT b.featureimage, b.BlogTitle,b.Description,b.MemberID,b.EntityType,b.PRN_TID,b.name,b.date,b.activity,s.school_name FROM blog b join tbl_school_admin s on b.SchoolID=s.school_id where b.SchoolID='$school_id'  and  $colname LIKE '%$searchq%' order by b.BlogID desc"; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
			
			
			
		}
			
		//below query use for search count
		 
					

					if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 
}

?>


<?php 

if (!($_GET['Search'])){?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $page; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('blog_list.php?page='+page);
        });
    });
</script>
<?php }else{
	?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $spage; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('blog_list.php?from=<?php echo $from;?>&to=<?php echo $to;?>&std_PRN=<?php echo $std_PRN; ?>&activity=<?php echo $activity; ?>&std_name=<?php echo $std_name; ?>&blog_title=<?php echo $blog_title; ?>&spage='+page);
        });
    });
</script>
<?php }?>





<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

<!--tr:nth-child(even) {
    background-color: #dddddd;
}-->

</style>

 <script>
        $(function () {
            $("#from").datepicker({
               // changeMonth: true,
                //changeYear: true
				dateFormat: 'yy-mm-dd'
            });
        });
        $(function () {
            $("#to").datepicker({
                //changeMonth: true,
                //changeYear: true,
				dateFormat: 'yy-mm-dd'
            });
        });
    </script>
 
<!-- JQuery script and JavaScript valid() function added  by Pranali for task SMC-2235 on 05-07-2018  -->
<script>
$(document).ready(function(){

		$("#fromDiv").show();
		$("#toDiv").show();
    $('#info').on('change', function() {
		
   /*   if ( this.value == "5")
      {
        
      }
      else
      {
        $("#fromDiv").hide();
		$("#toDiv").hide();
      }
	  */
    });
});
</script>
<script>
function valid()
{
	var info = document.getElementById("info");

	//if(info.value=="5")
	//{
		var from = document.getElementById("from").value;
                    var myDate = new Date(from);
                    var today = new Date();
                   
					if (from == "") {

                     /* document.getElementById('errorfrom').innerHTML='Please select date';
                       return false;
					   */
                    }

	                else if(myDate.getFullYear() > today.getFullYear()) {
					document.getElementById('errorfrom').innerHTML='Please select valid date';
                       return false;
					}

                      else if(myDate.getFullYear() == today.getFullYear()) {

                              if (myDate.getMonth() == today.getMonth()) {
                                
								if (myDate.getDate() > today.getDate()) {

                                    document.getElementById('errorfrom').innerHTML='Please select valid date';
                                    return false;
								}
                                
                                else {
                                   document.getElementById('errorfrom').innerHTML='';
                                    
                                }


                            }

                            else if (myDate.getMonth() > today.getMonth()) {
                               document.getElementById('errorfrom').innerHTML='Please select valid date';
                                return false;

                            }
                            else {
                              document.getElementById('errorfrom').innerHTML='';  
                            }
                        }

                    

                    else {
                     document.getElementById('errorfrom').innerHTML='';
                    }

	var to = document.getElementById("to").value;
                    var myDate1 = new Date(to);
                    var today1 = new Date();
                    
					if (to == "") {

                  /*    document.getElementById('errorto').innerHTML='Please select date';
                       return false;
					   */
                    }
	                 else if(myDate1.getFullYear() > today1.getFullYear()) {
						
						document.getElementById('errorto').innerHTML='Please select valid date';
                        return false;
		 			 }

                       else if(myDate1.getFullYear() == today1.getFullYear()) {

                              if (myDate1.getMonth() == today1.getMonth()) {
                                
									if (myDate1.getDate() > today1.getDate()) {
                                    document.getElementById('errorto').innerHTML='Please select valid date';
                                    return false;
								}
                                
                                else {
                                   document.getElementById('errorto').innerHTML='';
                                    
                                }


                            }

                            else if (myDate1.getMonth() > today1.getMonth()) {
                               document.getElementById('errorto').innerHTML='Please select valid date';
                                return false;

                            }
                            else {
                              document.getElementById('errorto').innerHTML='';  
                            }
                        }

                    

                    else {
                     document.getElementById('errorto').innerHTML='';
                    }



		if(myDate.getFullYear() > myDate1.getFullYear())
		{
			document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
			return false;
		}

		else if(myDate.getFullYear() == myDate1.getFullYear())
		{
			if(myDate.getMonth() == myDate1.getMonth()){

				if(myDate.getDate() > myDate1.getDate()) {

				document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
				return false;
				}
				else
				{
					document.getElementById('errorDate').innerHTML='';
				}

			}
			else if (myDate.getMonth() > myDate1.getMonth()) {
                               document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
                                return false;

                            }
                            else {
                              document.getElementById('errorDate').innerHTML='';  
                            }
		}
		else
		{
			document.getElementById('errorDate').innerHTML=''
			
		}
	//}
}
	
	
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.searchselect').select2();
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
</head>
<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Display Blog List</h2>

        </div>
		
		<div class='row'>
		  
	<form style="margin-top:5px;">
		  
	<div class="row">
	<div class="col-md-11">
	<div class="col-md-2" id="fromDiv">
	<label> From Date:</label>
  <input type="text" class="form-control" id="from" name="from" placeholder="YYYY-MM-DD" autocomplete="off"/>
			  <div id="errorfrom" style="color:#FF0000"></div>
     
  </div>
  <div class="col-md-2" id="toDiv">
  <label> To Date:</label>
  <input type="text" class="form-control" id="to" name="to" placeholder="YYYY-MM-DD" autocomplete="off"/>
			  <div id="errorto" style="color:#FF0000"></div>
     
  </div>
  <div class="col-md-2" >
  <label> Student PRN:</label>
 <input type="text" class="form-control" name="std_PRN" id="std_PRN"  placeholder="Search by PRN" >  
  </div> 
  
 <!-- <div class="col-md-2">
  <label> Activity:</label>
  <input type="text" class="form-control" name="activity" id="activity"  placeholder="Search by Activity" > 
      
  </div> --> 
<div class="col-md-2" id="typeedit">
<?php
$sqln2="SELECT sc_list FROM tbl_studentpointslist where school_id='$school_id'";
                                // echo $sqln2; exit;
    $sql1 = mysql_query($sqln2);
 ?>
<label for="type"> Activity:</label>
   <select class="form-control searchselect" name="activity" id="activity">
              <option value="">Select Activity </option>
              <?php while ($row = mysql_fetch_array($sql1)){ ?>
                <option <?php if(isset($_POST['sc_list'])){ if($_POST['sc_list']==$row['sc_list']){ echo "selected"; } }?> value="<?php echo $row['sc_list']; ?>"><?php echo $row['sc_list']; ?> </option>
              <?php } ?>
            </select>
      
  </div>   
  <div class="col-md-2">
  <label> Student name:</label>
  <input type="text" class="form-control" name="std_name" id="std_name"  placeholder="Search by Name" > 
     
  </div>
  <div class="col-md-2">
  <label> Blog Title:</label>
  <input type="text" class="form-control" name="blog_title" id="blog_title"  placeholder="Search by Title" > 
      
  </div>       
  </div>
  
	<div class="col-md-1">
	
      <button type="submit" name="Search" value="Search" onClick="return valid();" class="btn btn-primary" style="margin-top:25px;">Search</button>
	</div>   
  
</div>
</br>
<div class="col-md-4" id="errorDate" style="color:#FF0000"></div>	
	<!--	  <div class='row' style="margin-left:270px;">
			<div class="col-md-2" style="width:17%;margin-left:140px;">
				<input type="text" class="form-control" name="Search" value="<?php //echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" style="margin-left:28px;">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			
					
		
					
					
					
			</div>		
		-->	
		
		</form>
		 </div> 
		 <!-- <div id="show" >
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		 </div> -->
		<?php
		
		 if (isset($_GET['Search']))
		{
			
			$count=mysql_num_rows($query1);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			
                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
                    ?>
                    <tr>
					
					<div class="row">
<div class="col-md-8 col-md-offset-2 border">
 <b><hr></b>
  <div class="row">   
    <div class="col-md-6 text-left">
      <p><h3><b> <?php echo $result['BlogTitle'];?></b></h3><p>
      </div>
  </div>      
   

<div class="row">
       
   <div class="col-md-6 text-left">
     
      <b><?php echo $result['activity'];?></b>
    </div> 
	<div class="col-md-6 text-right">
     
      <?php echo $result['date'];?>
    </div>	
</div>
</br>

<div class="row">
       
    <div class="col-md-12 text-left">
       <p><?php echo $result['Description'];?></p>
      
    </div>       
    
</div>
<hr>

<div class="row">
       
  <div class="col-md-6">
       <label for="name"><img src="<?php echo $GLOBALS['URLNAME']."/".$result['featureimage'];?>" height="400px" width="400px"></label>
  </div>       
  
</div>
<div class="row">
       
  <div class="col-md-6 col-md-offset-6 text-right">
       <?php echo $result['name'];?>
  </div>       
  
</div>
<div class="row">
       
  <div class="col-md-6 col-md-offset-6 text-right">
  <b><?php echo ($result['PRN_TID']);?></b>
       
  </div>       
  
</div>

</div>
</div>
</br></br>
                </tr>	
                    <?php $i++;
                } ?>
           
		<div align="left">
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
			<?php
			}

		}
		else
			{
			?>
			

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
                    ?>
                    <tr>
					
					<div class="row">
<div class="col-md-8 col-md-offset-2 border">
 <b><hr></b>
  <div class="row">   
    <div class="col-md-6 text-left">
      <p><h3><b> <?php echo $result['BlogTitle'];?></b></h3><p>
      </div>
  </div>      
   

<div class="row">
       
   <div class="col-md-6 text-left">
     
      <b><?php echo $result['activity'];?></b>
    </div> 
	<div class="col-md-6 text-right">
     
      <?php echo $result['date'];?>
    </div>	
</div>
</br>

<div class="row">
       
    <div class="col-md-12 text-left">
       <p><?php echo $result['Description'];?></p>
      
    </div>       
    
</div>
<hr>

<div class="row">
       
  <div class="col-md-6">
       <label for="name"><img src="<?php echo $GLOBALS['URLNAME']."/".$result['featureimage'];?>" height="400px" width="400px"></label>
  </div>       
  
</div>
<div class="row">
       
  <div class="col-md-6 col-md-offset-6 text-right">
       <?php echo $result['name'];?>
  </div>       
  
</div>
<div class="row">
       
  <div class="col-md-6 col-md-offset-6 text-right">
  <b><?php echo ($result['PRN_TID']);?></b>
       
  </div>       
  
</div>

</div>
</div>
</br></br>
                </tr>		
                    <?php $i++;
                } ?>
           
<div align="left">
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
		<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>

<?php } ?>

	<div style="padding-top:50px;">

            
        </div>
    </div>
</div>

</div>
</div>
</body>
</html>
