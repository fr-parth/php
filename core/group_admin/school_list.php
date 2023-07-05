<?php
include('groupadminheader.php');

//$results = $smartcookie->retrive_individual($table, $fields);
//$result = mysql_fetch_array($results);
//comment
if(isset($_GET['group_name'])){
	$group_member_id=explode(',',$_GET['group_name'])[0];
	$group_name=$_GET['group_name'];
	}
	else{
		$group_member_id = $_SESSION['group_admin_id'];
		$group_name="";
	}
$year=$_GET['year'];
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
     "scrollCollapse": false,
	//  "scrollX": true
	//  "scrollY": true
    } );
} );
    </script>
	<?php

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };
$start_from = ($page-1) * $webpagelimit;

if(($year == 'ALL' && $group_member_id =='ALL') or ($year=='ALL' && $group_member_id=='') or ($year=='' && $group_member_id=='ALL'))
{
$query1=mysql_query("SELECT distinct(sa.school_id),sa.school_name FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
and sa.school_id=gs.school_id where sa.school_id  in 
(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  )
LIMIT $start_from, $webpagelimit");


$sql1="SELECT count(distinct sa.school_id,sa.school_name )   FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
and sa.school_id=gs.school_id where sa.school_id  in 
(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID )";

}
else{
	if(($year!='' and $year!='ALL') and ($group_member_id!='' and $group_member_id!='ALL')){
		$query1=mysql_query("SELECT distinct(sa.school_id),sa.school_name FROM tbl_school_admin sa 
		join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
		where sa.group_member_id='$group_member_id' and  sa.school_id  in 
		(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  where sf.stu_feed_school_id is not null  and sf.stu_feed_academic_year='$year') 
		 LIMIT $start_from, $webpagelimit");
		
		
		$sql1="SELECT count(distinct sa.school_id,sa.school_name )  FROM tbl_school_admin sa 
		join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
		where sa.group_member_id='$group_member_id' and  sa.school_id  in 
		(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  where sf.stu_feed_school_id is not null  and sf.stu_feed_academic_year='$year') ";

	}
	elseif (($year!='' and $year!='ALL') and ($group_member_id=='' or $group_member_id=='ALL')){
		$query1=mysql_query("SELECT distinct(sa.school_id),sa.school_name FROM tbl_school_admin sa 
		join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
		where sa.school_id  in 
		(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID where sf.stu_feed_school_id is not null  and sf.stu_feed_academic_year='$year') 
		 LIMIT $start_from, $webpagelimit");

		 $sql1="SELECT count(distinct sa.school_id,sa.school_name )  FROM tbl_school_admin sa 
		 join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
		 where sa.school_id  in 
		 (Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID where sf.stu_feed_school_id is not null  and sf.stu_feed_academic_year='$year')";
		   }
		   else{
			   $query1 = mysql_query("SELECT distinct(sa.school_id),sa.school_name FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			   and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
			   (Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  where sf.stu_feed_school_id is not null  )");

			   $sql1="SELECT count(distinct sa.school_id,sa.school_name )  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			   and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
			   (Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  where sf.stu_feed_school_id is not null  ) ";
}
}
					$rs_result = mysql_query($sql1);

					$row1 = mysql_fetch_row($rs_result);
					// echo $row1;
					// exit;
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

$searchq=trim(mysql_real_escape_string($_GET['Search']));
//$colname=mysql_real_escape_string($_GET['colname']);
	// if ($searchq != '')
	// {
		// $query1=mysql_query("SELECT distinct school_name,school_id FROM techindi_Dev.tbl_school_admin where group_member_id='$group_member_id'

 // and

 // (school_name LIKE '%$searchq%' or
 // school_id LIKE '%$searchq%'
  // )group by school_name
  // LIMIT $start_from, $webpagelimit") or die("could not Search!");

			// $sql1 ="SELECT count(distinct sf.stu_feed_school_id) as cnt FROM tbl_school_admin sc  join tbl_student_feedback sf on sc.school_id=sf.stu_feed_school_id  where sc.group_member_id='$group_member_id'
// group by sc.school_id";

			// $rs_result = mysql_query($sql1);
					// $row1 = mysql_fetch_row($rs_result);
					// $total_records = $row1[0];
					// $total_pages = ceil($total_records / $webpagelimit);

	// }else{


$query1=mysql_query("SELECT distinct sc.school_id
FROM tbl_school_admin sc
inner join (SELECT count(distinct sf.stu_feed_student_ID) as cnt, st.school_id as scid, st.group_member_id as grpid FROM tbl_student_feedback sf join tbl_student st on sf.stu_feed_student_ID=st.std_PRN and sf.stu_feed_school_id=st.school_id

 where st.group_member_id='$group_member_id' and sf.stu_feed_academic_year='$year') temptbl on sc.school_id=scid
where cnt!='0' and
sc.group_member_id=grpid


LIMIT $start_from, $webpagelimit")

		or die("could not Search!");
					//echo $query1;
		$sql1 ="SELECT count(distinct sf.stu_feed_school_id) as cnt FROM tbl_school_admin sc  join tbl_student_feedback sf on sc.school_id=sf.stu_feed_school_id  where $cond ";
					$rs_result = mysql_query($sql1);
					$row1 = mysql_fetch_row($rs_result);
					$total_records = $row1[0];
					$total_pages = ceil($total_records / $webpagelimit);



		// }

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
            <?php if ($_GET['year']){ ?>
			window.location.assign('school_list.php?year<?php echo $_GET['year']; ?>&group_name=<?php echo $group_name;?>&page='+page);
      <?php }else{ ?>
      window.location.assign('school_list.php?page='+page);
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
			window.location.assign('school_list.php?Search=<?php echo $searchq; ?>&spage='+page);
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

            <h2 style="padding-left:20px; margin-top:2px;color:#666">School List</h2>

        </div>

		<div class='row'>
		<form method="post" class="pull-left" action="feedback_stat.php">
      <input type="hidden" name="year" value="<?= $year;?>" />
      <input type="hidden" name="group_name" value="<?= $group_name;?>" />
      <button class="btn btn-info" type="submit"><i class="glyphicon glyphicon-chevron-left"></i>Back to  360 Feedback Statistics</button>
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
			echo $count;
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

				  <th>Sr.No</th>
					<th>School Name</th>
						<th> School ID</th>
						<th> Student Count</th>



                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
          if($_GET['year'] and $year!='ALL' and $year!='')
          {
            $cond1=" and sf.stu_feed_academic_year='$year'";
            }
            else{
              $cond1="";
            }
                while($result = mysql_fetch_array($query1)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>




						 <td data-title="School Name"><?php echo $result['school_name']; ?></td>
						 <td data-title="School ID"><?php echo $result['school_id']; ?></td>
						 <?php $a=$result['school_id']; ?>
						 <td data-title="Student Count"> <a href="studentFeedback.php?sc_id=<?php echo $a;?> &year=<?php echo $year;?>&group_name=<?php echo $group_name;?>" > <?php
						  $query2="SELECT count(distinct st.std_PRN) as cnt FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$a' 
						  and st.std_PRN in (SELECT distinct sf.stu_feed_student_ID
						  FROM tbl_student_feedback sf where sf.stu_feed_school_id='$a' $cond1)";

							$sql=mysql_query($query);
							$result=mysql_fetch_array($sql);
						    echo $result['cnt'];?></td>




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
                     <th>Sr.No</th>
					<th>School Name</th>
						<th> School ID</th>
						<th> Student Count</th>




                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
					 if($_GET['year'] and $year!='ALL' and $year!='')
							{
								$cond1 = "and sf.stu_feed_academic_year='$year'";
							}
							else
							{
								$cond1 ="";
							}
                while($result = mysql_fetch_array($query1)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>



                        <td data-title="School Name"><?php echo $result['school_name']; ?></td>
						 <td data-title="School ID"><?php echo $result['school_id']; ?></td>
						 <?php $a=$result['school_id']; ?>
						 <td data-title="Student Count"><a href="studentFeedback.php?sc_id=<?php echo $a;?>&year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"><?php
						    // $query="  SELECT count(distinct stu_feed_student_ID) as cnt  FROM tbl_student_feedback  sf  join tbl_student st on
// sf.stu_feed_student_ID=st.std_PRN

 // where st.school_id='$a' and st.group_member_id='$group_member_id' and sf.stu_feed_academic_year='2018'";
/*$query=" SELECT count(distinct sf.stu_feed_student_ID,sf.stu_feed_academic_year,sf.stu_feed_dept_ID) as cnt  FROM tbl_student_feedback  sf  join tbl_school_admin sa on
sf.stu_feed_school_id=sa.school_id

where sf.stu_feed_school_id='$a' and sa.group_member_id='$group_member_id' $cond1";*/

$query="SELECT count(distinct st.std_PRN) as cnt FROM  tbl_student st join tbl_school_admin sa on st.school_id=sa.school_id where sa.school_id='$a' 
and st.std_PRN in (SELECT distinct sf.stu_feed_student_ID
FROM tbl_student_feedback sf where sf.stu_feed_school_id='$a' $cond1)";
 //echo $query;




							$sql=mysql_query($query);
							$result=mysql_fetch_array($sql);
						    echo $result['cnt'];?></td>
                        </tr>
                    <?php $i++;
                } ?>
            </table>
			<?php //echo $cond1; ?>
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
