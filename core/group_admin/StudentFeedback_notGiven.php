<?php
include('groupadminheader.php');
$sc_id= $_GET['sc_id'];
$year=$_GET['year'];
//$results = $smartcookie->retrive_individual($table, $fields);
//$result = mysql_fetch_array($results);
if($_GET['group_name']!=""){
	$group_member_id=explode(',',$_GET['group_name'])[0];
	$group_name=$_GET['group_name'];
	}
	else{
		$group_member_id = $_SESSION['group_admin_id'];
		$group_name="";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $dynamic_school;?> Information</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
   <!--  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"> -->
   <!--  <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	 // "scrollX": true
    } );
} );
    </script>
	<?php

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };
$start_from = ($page-1) * $webpagelimit;

if($year !='ALL' && $year!='')
	{
		$cond .= "and sf.stu_feed_academic_year='$year'";
	}
	else
	{
		$cond=" ";
	}
 $sql=mysql_query("SELECT distinct st.std_complete_name,st.Academic_Year, st.std_PRN, st.std_branch,st.school_id,
st.std_dept,st.std_class,st.std_div FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$sc_id' 
and st.std_PRN not in (SELECT distinct sf.stu_feed_student_ID
FROM tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' $cond) 
LIMIT $start_from, $webpagelimit");

/*removed part from $sql = sf.stu_feed_school_id=st.school_id AND  . after 'on' condition*/

$sql1 ="SELECT count(distinct st.std_PRN) FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$sc_id' 
and st.std_PRN not in (SELECT distinct sf.stu_feed_student_ID
FROM tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' $cond) ";

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

if($_GET['year'] and $year !='ALL' and $year!='')
{
  $cond = " and sf.stu_feed_academic_year='$year'";
}
else
{
  $cond=" ";
}

$searchq=trim(mysql_real_escape_string($_GET['Search']));
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($searchq != '')
	{
		$query1=mysql_query("SELECT distinct st.std_complete_name,st.Academic_Year, st.std_PRN, st.std_branch,st.school_id,
		st.std_dept,st.std_class,st.std_div FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$sc_id' 
		and st.std_PRN not in (SELECT distinct sf.stu_feed_student_ID
		FROM tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' $cond)

 and

 (st.std_complete_name LIKE '%$searchq%' or
 st.std_branch LIKE '%$searchq%'or
 st.std_dept LIKE '%$searchq%'or
 st.std_class LIKE '%$searchq%'or
 st.std_div LIKE '%$searchq%'or
 st.std_PRN LIKE '%$searchq%' or
 st.Academic_Year LIKE '%$searchq%'
  )  
  LIMIT $start_from, $webpagelimit") or die("could not Search!");

			$sql1 ="SELECT count(distinct st.std_PRN) FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$sc_id' 
			and st.std_PRN not in (SELECT distinct sf.stu_feed_student_ID
			FROM tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' $cond) and

 (st.std_complete_name LIKE '%$searchq%' or
 st.std_branch LIKE '%$searchq%'or
 st.std_dept LIKE '%$searchq%'or
 st.std_class LIKE '%$searchq%'or
 st.std_div LIKE '%$searchq%'or
 st.std_PRN LIKE '%$searchq%' or
 st.Academic_Year LIKE '%$searchq%'
  )";

			$rs_result = mysql_query($sql1);
					$row1 = mysql_fetch_row($rs_result);
					$total_records = $row1[0];
					$total_pages = ceil($total_records / $webpagelimit);

	}else{

	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("SELECT distinct st.std_complete_name,st.Academic_Year, st.std_PRN, st.std_branch,st.school_id,
st.std_dept,st.std_class,st.std_div FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$sc_id' 
and st.std_PRN not in (SELECT distinct sf.stu_feed_student_ID
FROM tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' $cond)
 and  $colname LIKE '%$searchq%'
LIMIT $start_from, $webpagelimit")

		or die("could not Search!");
					//echo $query1;
		$sql1 ="SELECT count(distinct st.std_PRN) FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$sc_id' 
		and st.std_PRN not in (SELECT distinct sf.stu_feed_student_ID
		FROM tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' $cond) and
 and  $colname LIKE '%$searchq%'";
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



<?php if (!($_GET['Search'])){?>
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

            <?php if ($_GET['year'] and ($_GET['group_name'])){ ?>
      window.location.assign('StudentFeedback_notGiven.php?sc_id=<?php echo $sc_id;?>&year=<?php echo $year;?>&group_name=<?php echo $group_name;?>&page='+page);
      <?php }else{ ?>
      window.location.assign('StudentFeedback_notGiven.php?sc_id=<?php echo $sc_id;?>&page='+page);
      	<?php } ?>
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
      <?php if ($_GET['year']){ ?>
window.location.assign('StudentFeedback_notGiven.php?sc_id=<?php echo $sc_id;?>&year=<?php echo $year;?>&Search=<?php echo $searchq; ?>&group_name=<?php echo $group_name;?>&spage='+page);
<?php }else{ ?>
window.location.assign('StudentFeedback_notGiven.php?sc_id=<?php echo $sc_id;?>&Search=<?php echo $searchq; ?>&spage='+page);
  <?php } ?>
        });
    });
</script>
<?php }?>
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

            #no-more-tables tr {
                border: 1px solid #ccc;
            }

            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
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
                text-align: left;

            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
</head>


<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> <?php echo $dynamic_student;?>  feedback Not Given</h2>

        </div>

		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:35%;">
			 </div>

			<div class="col-md-2" style="width:17%;">
        <input type="hidden" name="sc_id" value="<?php echo $_GET['sc_id'];?>" />
        <?php if($_GET['year']){ ?>
        <input type="hidden" name="year" value="<?php echo $_GET['year'];?>" />
		<input type="hidden" name="group_name" value="<?php echo $_GET['group_name'];?>" />
      <?php } ?>
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required>
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('StudentFeedback_notGiven.php?sc_id=<?php echo $sc_id; ?>&year=<?php echo $_GET['year'];?>&group_name=<?php echo $group_name;?>','_self')" />
			</div>
				</form>
						 </div>
  					<form method="post" class="pull-left" action="not_given_school.php?year=<?php echo $year?>&group_name=<?php echo $group_name;?>">


      <button class="btn btn-info" type="submit"><i class="glyphicon glyphicon-chevron-left"></i>Back to  School List</button>
    </form>

				</br></br>


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
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">

				  <th>Sr.No.</th>
					<th><?php echo $dynamic_student;?>  Name</th>
					<th> PRN </th>
						<th> Class</th>
						<th> Department</th>
						<th> Branch </th>

                     <th> Academic Year</th>




                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>




						 <td data-title="<?php echo $dynamic_student;?>  Name"><?php echo $result['std_complete_name']; ?></td>
						 <td data-title="PRN"><?php echo $result['std_PRN']; ?></td>
						 <td data-title="Class"><?php echo $result['std_class']; ?></td>
						 <td data-title="Department"><?php echo $result['std_dept']; ?></td>
						 <td data-title="Branch"><?php echo $result['std_branch']; ?></td>

						 <?php

             /* <td> $a=$result['school_id'];


					$query1="SELECT distinct
					a.Academic_Year

					 FROM tbl_student_subject_master sm join tbl_student s on sm.school_id=s.school_id and
					 sm.student_id=s.std_PRN
					 join tbl_academic_Year a on sm.school_id=a.school_id and  a.Year=sm.AcademicYear and
					 s.school_id='$a'";
					 $res=mysql_query($query1);
					 $result1=mysql_fetch_array($res);
					 echo $result1['Academic_Year'];?></td> */ ?>
           <td data-title="AcademicYear"><?php echo $result['Academic_Year']; ?></td>





					</tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
						if($total_records==0){$start_from=-1;}
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
						if($total_records==0){$start_from=-1;}
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
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr.No.</th>
					<th><?php echo $dynamic_student;?>  Name</th>
					<th> PRN </th>
                    <th> Class</th>
						<th> Department</th>
						<th> Branch </th>

                     <th> Academic Year</th>




                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>



                        <td data-title="<?php echo $dynamic_student;?>  Name"><?php echo $result['std_complete_name']; ?></td>
						<td data-title="PRN"><?php echo $result['std_PRN']; ?></td>
						 <td data-title="Class"><?php echo $result['std_class']; ?></td>
						 <td data-title="Department"><?php echo $result['std_dept']; ?></td>
						 <td data-title="Branch"><?php echo $result['std_branch']; ?></td>


						<?php /*<td> $a=$result['school_id'];


					$query1="SELECT distinct
					a.Academic_Year

					 FROM tbl_student_subject_master sm join tbl_student s on sm.school_id=s.school_id and
					 sm.student_id=s.std_PRN
					 join tbl_academic_Year a on sm.school_id=a.school_id and  a.Year=sm.AcademicYear and
					 s.school_id='$a'";
					 $res=mysql_query($query1);
					 $result1=mysql_fetch_array($res);
					 echo $result1['Academic_Year'];?></td> */ ?>

           <td data-title="AcademicYear"><?php echo $result['Academic_Year']; ?></td>




					</tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
						if($total_records==0){$start_from=-1;}
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
						if($total_records==0){$start_from=-1;}
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
