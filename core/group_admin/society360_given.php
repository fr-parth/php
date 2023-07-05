<?php
ob_start('ob_gzhandler');
include('groupadminheader.php');
$sc_id= $_GET['sc_id'];
if($_GET['group_name']!=""){
	$group_member_id=explode(',',$_GET['group_name'])[0];
	$group_name=$_GET['group_name'];
	}
	else{
		$group_member_id = $_SESSION['group_admin_id'];
		$group_name="";
	}
  $year=$_GET['year'];
//  $ac_yr=mysql_query("SELECT Academic_Year FROM tbl_academic_Year where Year='$year'");
//			$yt=mysql_fetch_array($ac_yr);
//			$yr=$yt['Academic_Year'];
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
	//  "scrollX": true
    } );
} );
    </script>
	<?php

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };
$start_from = ($page-1) * $webpagelimit;
	if($_GET['year'] and $year !='ALL' and $year!='')
	{
		$cond = " and sf.Academic_Year= '$year'";
	}
	else
	{
		$cond =" ";
	}
	$sql=mysql_query("
	SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
	  FROM tbl_teacher  t join tbl_school_admin sa on t.school_id=sa.school_id where sa.school_id='$sc_id'
	  and t.t_emp_type_pid in (133,134,135,137) and t.t_id  IN
	   (select sf.tID
	  from tbl_360_activities_data sf where sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137)) and sf.schoolID='$sc_id' $cond)
	LIMIT $start_from, $webpagelimit");
	
	$sql1 ="SELECT count(distinct t.t_id) as cnt FROM  tbl_teacher t join tbl_school_admin sa on t.school_id=sa.school_id where sa.school_id='$sc_id'
	and t.t_emp_type_pid in (133,134,135,137) and t.t_id  IN
	 (select sf.tID
	from tbl_360_activities_data sf where sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137)) and sf.schoolID='$sc_id' $cond)";
	
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

$searchq=trim(mysql_real_escape_string($_GET['Search']));
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($searchq != '')
	{

		if($_GET['year'] and $year !='ALL' and $year!='')
		{
			$cond .= " and sf.Academic_Year= '$year'";
		}
		else
		{
			$cond .=" ";
		}

		$query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
		FROM tbl_teacher  t join tbl_school_admin sa on t.school_id=sa.school_id where sa.school_id='$sc_id'
		and t.t_emp_type_pid in (133,134,135,137) and t.t_id  IN
		 (select sf.tID
		from tbl_360_activities_data sf where sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137)) and sf.schoolID='$sc_id' $cond)

 and

 (t.t_complete_name LIKE '%$searchq%' or
 t.t_dept LIKE '%$searchq%'or
 t.t_id LIKE '%$searchq%'or
 t.t_academic_year LIKE '%$searchq%'
  )
  LIMIT $start_from, $webpagelimit") or die("could not Search!");

			$sql1 ="SELECT count(distinct t.t_id) as cnt FROM  tbl_teacher t join tbl_school_admin sa on t.school_id=sa.school_id where sa.school_id='$sc_id'
			and t.t_emp_type_pid in (133,134,135,137) and t.t_id  IN
			 (select sf.tID
			from tbl_360_activities_data sf where sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137)) and sf.schoolID='$sc_id' $cond)

and

 (t.t_complete_name LIKE '%$searchq%' or
 t.t_dept LIKE '%$searchq%'or
 t.t_id LIKE '%$searchq%'or
 t.t_academic_year  LIKE '%$searchq%'
  ) ";

			$rs_result = mysql_query($sql1);
					$row1 = mysql_fetch_row($rs_result);
					$total_records = $row1[0];
					$total_pages = ceil($total_records / $webpagelimit);

	}else{


		$query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
		FROM tbl_teacher  t join tbl_school_admin sa on t.school_id=sa.school_id where sa.school_id='$sc_id'
		and t.t_emp_type_pid in (133,134,135,137) and t.t_id  IN
		 (select sf.tID
		from tbl_360_activities_data sf where sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137)) and sf.schoolID='$sc_id' $cond)
		
		 and  $colname LIKE '%$searchq%'
		group by t.t_id
		
		LIMIT $start_from, $webpagelimit")
		
				or die("could not Search!");
							//echo $query1;
				$sql1 ="SELECT count(distinct t.t_id) as cnt FROM  tbl_teacher t join tbl_school_admin sa on t.school_id=sa.school_id where sa.school_id='$sc_id'
				and t.t_emp_type_pid in (133,134,135,137) and t.t_id  IN
				 (select sf.tID
				from tbl_360_activities_data sf where sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137)) and sf.schoolID='$sc_id' $cond)
		
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
      <?php if($_GET['year']){ ?>
				 window.location.assign('society360_given.php?sc_id=<?php echo $sc_id;?>&year=<?php echo $year;?>&group_name=<?php echo $group_name;?>&page='+page);
			<?php } else {?>
				window.location.assign('society360_given.php?sc_id=<?php echo $sc_id;?>&page='+page);
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
      <?php if($_GET['year']){ ?>
				 window.location.assign('society360_given.php?sc_id=<?php echo $sc_id;?>&year=<?php echo $year;?>&group_name=<?php echo $group_name;?>&Search=<?php echo $searchq; ?>&spage='+page);
			<?php } else {?>
				window.location.assign('society360_given.php?sc_id=<?php echo $sc_id;?>&Search=<?php echo $searchq; ?>&spage='+page);
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

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Society Activity- Given</h2>

        </div>

		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:35%;">
			 </div>
       <input type="hidden" name="sc_id" value="<?php echo $_GET['sc_id'];?>" />
       <?php if($_GET['year']){ ?>
       <input type="hidden" name="year" value="<?php echo $_GET['year'];?>" />
	  <input type="hidden" name="group_name" value="<?= $group_name;?>" />
     <?php } ?>

			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required>
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('society360_given.php?sc_id=<?php echo $_GET['sc_id']; ?>&year=<?php echo $_GET['year'];?>&group_name=<?php echo $group_name;?>','_self')" />
</div>
				</form>
						 </div>
  					<form method="post" class="pull-left" action="society_given_school.php?year=<?php echo $year?>&group_name=<?php echo $group_name;?>">
      <input type="hidden" name="year" value="<?= $year;?>" />
	  <input type="hidden" name="group_name" value="<?= $group_name;?>" />

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
					<th>Teacher Name</th>
						 <th>Member ID </th>
						<th> Department</th>


                     <th> Academic Year</th>




                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>




						 <td data-title="Teacher  Name"><?php echo $result['t_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['t_id']; ?></td>
						 <td data-title="Department"><?php echo $result['t_dept']; ?></td>

						<?php /* <td> $a=$result['school_id'];


					$query1="
SELECT distinct
a.Academic_Year

 FROM tbl_teacher_subject_master sm join tbl_teacher t on sm.school_id=t.school_id and
 sm.teacher_id=t.t_id
 join tbl_academic_Year a on sm.school_id=a.school_id and  a.Year=sm.AcademicYear and
 t.school_id='$a'";
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

					<th>Teacher Name</th>
						 <th>Member ID </th>
						<th> Department</th>


                     <th> Academic Year</th>




                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>




						 <td data-title="Teacher  Name"><?php echo $result['t_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['t_id']; ?></td>
						 <td data-title="Department"><?php echo $result['t_dept']; ?></td>


						<?php /* <td> $a=$result['school_id'];


					$query1="
SELECT distinct
a.Academic_Year

 FROM tbl_teacher_subject_master sm join tbl_teacher t on sm.school_id=t.school_id and
 sm.teacher_id=t.t_id
 join tbl_academic_Year a on sm.school_id=a.school_id and  a.Year=sm.AcademicYear and
 t.school_id='$a'";
					 $res=mysql_query($query1);
					 $result1=mysql_fetch_array($res);
					 echo $result1['Academic_Year'];?></td>  */ ?>
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
