<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Society Activity Given</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
	 //"scrollX": true
    } );
} );
    </script>
	<?php
if (!($_GET['Search'])){
    define('max_res_per_page',10);
// if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };
// $start_from = ($page-1) * $webpagelimit;

if ((isset($_GET['yr'])) or (isset($_GET['dpt']))){
 $yr=$_GET['yr']; 
 $dpt=$_GET['dpt']; 
if(($yr!='' and $yr!='ALL') and ($dpt!='' and $dpt!='ALL')){


$sql3=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
FROM tbl_teacher  t
 where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_dept='$dpt' and t.t_emp_type_pid
		in (133,134,135,137) and t.t_id IN
 (
select ft.tID
from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
group by t.t_id");

}
elseif(($yr!='ALL' and $yr!='') and ($dpt=='' or $dpt=='ALL')){
  $sql3=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
  FROM tbl_teacher  t
  where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_emp_type_pid
    in (133,134,135,137) and t.t_id  IN
  (
  select ft.tID
  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
        group by t.t_id");
        }
elseif(($yr=='ALL' or $yr=='') and ($dpt!='' and $dpt!='ALL')){
    $sql3=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
    FROM tbl_teacher  t
     where t.school_id='$school_id' and t.t_dept='$dpt' and t.t_emp_type_pid
            in (133,134,135,137) and t.t_id IN
     (
    select ft.tID
    from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
    group by t.t_id");
        }
else{
  $sql3=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
  FROM tbl_teacher  t
   where t.school_id='$school_id' and t.t_emp_type_pid
          in (133,134,135,137) and t.t_id IN
   (
  select ft.tID
  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
  group by t.t_id");
}
}else{
  $sql3=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
  FROM tbl_teacher  t
   where t.school_id='$school_id' and t.t_emp_type_pid
          in (133,134,135,137) and t.t_id IN
   (
  select ft.tID
  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
  group by t.t_id");
}
$total= mysql_num_rows($sql3);
if(!isset($_GET['page'])){
$page=0;
}


$total_page= ceil($total/max_res_per_page);
$page= intval($_GET['page']);
if($page==0 || $page==''){
$page=1;

}

$start= max_res_per_page * ($page-1);
$end =max_res_per_page;
if($total_page == $_GET['page']){
         $end = $total;
         }else{
         $end = $start + $end;
         }

    //   $total_records = mysql_num_rows($sql);
    //   $total_pages = ceil($total_records / $webpagelimit);
    //   if($total_pages == $_GET['page']){
    //   $webpagelimit = $total_records;
    //   }else{
    //   $webpagelimit = $start_from + $webpagelimit;
    //   }
}
else
{
// if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };
// $start_from = ($spage-1) * $webpagelimit;
define('webpagelimit',10);
$searchq=trim(mysql_real_escape_string($_GET['Search']));
//$colname=mysql_real_escape_string($_GET['colname']);
 $yr=$_GET['yr']; 
 $dpt=$_GET['dpt']; 
if ($searchq != '')
{
  if((isset($_GET['yr'])) or (isset($_GET['dpt']))){
      if(($yr!='' and $yr!='ALL') and ($dpt!='' and $dpt!='ALL')){

$query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
FROM tbl_teacher  t
 where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_dept='$dpt' and t.t_emp_type_pid
		in (133,134,135,137) and t.t_id IN
 (
select ft.tID
from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
 and
 (t.t_complete_name LIKE '%$searchq%' or
 t.t_dept LIKE '%$searchq%'or
 t.t_id LIKE '%$searchq%'or
 t.t_academic_year LIKE '%$searchq%'
  )") or die("could not Search!");

 }
elseif (($yr!='' and $yr!='ALL') and ($dpt=='' or $dpt=='ALL')) {
  $query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
  FROM tbl_teacher  t
   where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_emp_type_pid
          in (133,134,135,137) and t.t_id IN
   (
  select ft.tID
  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
   and
   (t.t_complete_name LIKE '%$searchq%' or
   t.t_dept LIKE '%$searchq%'or
   t.t_id LIKE '%$searchq%'or
   t.t_academic_year LIKE '%$searchq%'
    )") or die("could not Search!");
}
elseif (($yr=='' or $yr=='ALL') and ($dpt!='' and $dpt!='ALL')) {
    $query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
    FROM tbl_teacher  t
     where t.school_id='$school_id' and  t.t_dept='$dpt' and t.t_emp_type_pid
            in (133,134,135,137) and t.t_id IN
     (
    select ft.tID
    from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
     and
     (t.t_complete_name LIKE '%$searchq%' or
     t.t_dept LIKE '%$searchq%'or
     t.t_id LIKE '%$searchq%'or
     t.t_academic_year LIKE '%$searchq%'
      )") or die("could not Search!");
  }
else {
  $query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
  FROM tbl_teacher  t
   where t.school_id='$school_id'  and t.t_emp_type_pid
          in (133,134,135,137) and t.t_id IN
   (
  select ft.tID
  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
   and
   (t.t_complete_name LIKE '%$searchq%' or
   t.t_dept LIKE '%$searchq%'or
   t.t_id LIKE '%$searchq%'or
   t.t_academic_year LIKE '%$searchq%'
    )") or die("could not Search!");
 }
}
else {
  $query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
  FROM tbl_teacher  t
   where t.school_id='$school_id'  and t.t_emp_type_pid
          in (133,134,135,137) and t.t_id IN
   (
  select ft.tID
  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
   and
   (t.t_complete_name LIKE '%$searchq%' or
   t.t_dept LIKE '%$searchq%'or
   t.t_id LIKE '%$searchq%'or
   t.t_academic_year LIKE '%$searchq%'
    )") or die("could not Search!");

}

					// $total_records = mysql_num_rows($query1);
					// $total_pages = ceil($total_records / $webpagelimit);

	}else{

	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
FROM tbl_teacher  t
 where t.school_id='$school_id'  and t.t_emp_type_pid
        in (133,134,135,137) and t.t_id IN
 (
select ft.tID
from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
 and  $colname LIKE '%$searchq%'")

		or die("could not Search!");
					//echo $query1;

					// $total_records = mysql_num_rows($query1);
					// $total_pages = ceil($total_records / $webpagelimit);



		}

		//below query use for search count

        $total_records = mysql_num_rows($query1);
        $total_pages = ceil($total_records / $webpagelimit);
        if(!isset($_GET['spage'])){
          $spage=0;
       }
    
      $spage= intval($_GET['spage']);
        if($spage==0 || $spage==''){
          $spage=1;
          }
         
         $start_from= webpagelimit * ($spage-1);
         $ends =webpagelimit;
         if($total_pages == $_GET['spage']){
                     $ends = $total_records;
                     }else{
                     $ends = $start_from + $ends;
                     }

					// if($total_pages == $_GET['spage']){
					// $webpagelimit = $total_records;
					// }else{
					// $webpagelimit = $start_from + $webpagelimit;
					// }

}
?>



<?php if (!($_GET['Search'])){?>
<script type="text/javascript">
    $(function () {
		var total_page = <?php echo $total_page; ?> ;
		var start_page = <?php echo $page; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_page,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)');
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
           console.log(page);
      			window.location.assign('society360_given.php?yr=<?php echo $yr."&dpt=".$dpt; ?>&page='+page);
                  
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
            <?php if($_GET['yr'] or $_GET['dpt']){ ?>
     window.location.assign('society360_given.php?yr=<?php echo $yr."&dpt=".$dpt; ?>&Search=<?php echo $searchq; ?>&spage='+page);
         <?php } else{ ?>
     window.location.assign('society360_given.php?Search=<?php echo $searchq; ?>&spage='+page);
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
       <input type='hidden' name='yr' value='<?php echo $_GET['yr']?>'> </input>
       <input type='hidden' name='dpt' value='<?php echo $_GET['dpt']?>'> </input>

			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required>
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('society360_given.php?yr=<?php echo $yr; ?>&dpt=<?php echo $dpt; ?>','_self')" />
			</div>

		  <div class='col-md-1 '>
                            <a href="360Feedback.php?year=<?php echo $yr; ?>&department=<?php echo $dpt; ?>" style="text-decoration:none;">
                                <input class='btn-lg btn-danger' type='button' value="Back" name="back" style="padding:5px;"/>
                            </a>
                        </div>



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
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" style="padding:0px;" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">

				  <th>Sr.No.</th>
					<th>Teacher Name</th>
						 <th> Member ID </th>
						<th> Department</th>


                     <th> Academic Year</th>




                </tr>
                </thead>

                <?php 
                if ($searchq != '')
                {
                  if((isset($_GET['yr'])) or (isset($_GET['dpt']))){
                      if(($yr!='' and $yr!='ALL') and ($dpt!='' and $dpt!='ALL')){
                
                $query=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                FROM tbl_teacher  t
                 where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_dept='$dpt' and t.t_emp_type_pid
                        in (133,134,135,137) and t.t_id IN
                 (
                select ft.tID
                from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                 and
                 (t.t_complete_name LIKE '%$searchq%' or
                 t.t_dept LIKE '%$searchq%'or
                 t.t_id LIKE '%$searchq%'or
                 t.t_academic_year LIKE '%$searchq%'
                  )
                  LIMIT $start_from, 10") or die("could not Search!");
                
                 }
                elseif (($yr!='' and $yr!='ALL') and ($dpt=='' or $dpt=='ALL')) {
                  $query=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                  FROM tbl_teacher  t
                   where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_emp_type_pid
                          in (133,134,135,137) and t.t_id IN
                   (
                  select ft.tID
                  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                   and
                   (t.t_complete_name LIKE '%$searchq%' or
                   t.t_dept LIKE '%$searchq%'or
                   t.t_id LIKE '%$searchq%'or
                   t.t_academic_year LIKE '%$searchq%'
                    )
                    LIMIT $start_from, 10") or die("could not Search!");
                }
                elseif (($yr=='' or $yr=='ALL') and ($dpt!='' and $dpt!='ALL')) {
                    $query=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                    FROM tbl_teacher  t
                     where t.school_id='$school_id' and  t.t_dept='$dpt' and t.t_emp_type_pid
                            in (133,134,135,137) and t.t_id IN
                     (
                    select ft.tID
                    from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                     and
                     (t.t_complete_name LIKE '%$searchq%' or
                     t.t_dept LIKE '%$searchq%'or
                     t.t_id LIKE '%$searchq%'or
                     t.t_academic_year LIKE '%$searchq%'
                      )
                      LIMIT $start_from, 10") or die("could not Search!");
                  }
                else {
                  $query=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                  FROM tbl_teacher  t
                   where t.school_id='$school_id'  and t.t_emp_type_pid
                          in (133,134,135,137) and t.t_id IN
                   (
                  select ft.tID
                  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                   and
                   (t.t_complete_name LIKE '%$searchq%' or
                   t.t_dept LIKE '%$searchq%'or
                   t.t_id LIKE '%$searchq%'or
                   t.t_academic_year LIKE '%$searchq%'
                    )
                    LIMIT $start_from, 10") or die("could not Search!");
                 }
                }
                else {
                  $query=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                  FROM tbl_teacher  t
                   where t.school_id='$school_id'  and t.t_emp_type_pid
                          in (133,134,135,137) and t.t_id IN
                   (
                  select ft.tID
                  from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                   and
                   (t.t_complete_name LIKE '%$searchq%' or
                   t.t_dept LIKE '%$searchq%'or
                   t.t_id LIKE '%$searchq%'or
                   t.t_academic_year LIKE '%$searchq%'
                    )
                    LIMIT $start_from,10") or die("could not Search!");
                
                }
                
                    }else{
                
                    //$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
                $query=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                FROM tbl_teacher  t
                 where t.school_id='$school_id'  and t.t_emp_type_pid
                        in (133,134,135,137) and t.t_id IN
                 (
                select ft.tID
                from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                 and  $colname LIKE '%$searchq%'
                
                LIMIT $start_from, 10")
                
                        or die("could not Search!");
                     
                        }
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>




						 <td data-title="Teacher  Name"><?php echo $result['t_complete_name']; ?></td>
							<td data-title="Member ID"><?php echo $result['t_id']; ?></td>
						 <td data-title="Department"><?php echo $result['deptName']; ?></td>

						<td data-title="Academic Year"><?php echo $result['t_academic_year']; ?></td>






					</tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align=left>
		 		<?php  
                  if($total_records==0){ $start_from=$start_from-1;}
                   if ($ends >$total_records){ $ends=$total_records;}
                   echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start +1)." to ".($ends)." records out of ".($total_records). " records.</font></style></div>";
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

            <table id="example" style="padding:0px;" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr.No.</th>

					<th>Teacher Name</th>
						 <th> Member ID </th>
						<th> Department</th>


                     <th> Academic Year</th>




                </tr>
                </thead>

                <?php
                if ((isset($_GET['yr'])) or (isset($_GET['dpt']))){
                    
                   if(($yr!='' and $yr!='ALL') and ($dpt!='' and $dpt!='ALL')){
                   
                   
                   $sql=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                   FROM tbl_teacher  t
                    where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_dept='$dpt' and t.t_emp_type_pid
                           in (133,134,135,137) and t.t_id IN
                    (
                   select ft.tID
                   from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                   group by t.t_id LIMIT $start,10");
                   
                   }
                   elseif(($yr!='ALL' and $yr!='') and ($dpt=='' or $dpt=='ALL')){
                     $sql=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                     FROM tbl_teacher  t
                     where t.school_id='$school_id' and t.t_academic_year='$yr' and t.t_emp_type_pid
                       in (133,134,135,137) and t.t_id  IN
                     (
                     select ft.tID
                     from tbl_360_activities_data ft where ft.activity_level_id='3'and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                           group by t.t_id LIMIT $start,10");
                           }
                   elseif(($yr=='ALL' or $yr=='') and ($dpt!='' and $dpt!='ALL')){
                       $sql=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                       FROM tbl_teacher  t
                        where t.school_id='$school_id' and t.t_dept='$dpt' and t.t_emp_type_pid
                               in (133,134,135,137) and t.t_id IN
                        (
                       select ft.tID
                       from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                       group by t.t_id LIMIT $start,10");
                           }
                   else{
                     $sql=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                     FROM tbl_teacher  t
                      where t.school_id='$school_id' and t.t_emp_type_pid
                             in (133,134,135,137) and t.t_id IN
                      (
                     select ft.tID
                     from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                     group by t.t_id LIMIT $start,10");
                   }
                   }else{
                     $sql=mysql_query("SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
                     FROM tbl_teacher  t
                      where t.school_id='$school_id' and t.t_emp_type_pid
                             in (133,134,135,137) and t.t_id IN
                      (
                     select ft.tID
                     from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$school_id' )
                     group by t.t_id LIMIT $start,10");
                   }
                   
					$i = ($start+1);
                while($result = mysql_fetch_array($sql)) {

                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>




						 <td data-title="Teacher  Name"><?php echo $result['t_complete_name']; ?></td>
							<td data-title="Member ID"><?php echo $result['t_id']; ?></td>
						 <td data-title="Department"><?php echo $result['deptName']; ?></td>

						<td data-title="Academic Year"><?php echo $result['t_academic_year']; ?></td>



					</tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align=left>
<?php 
if($total==0){ $start=$start-1;}
if ($end >$total){ $end=$total;}
      echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start +1)." to ".($end)." records out of ".($total). " records.</font></style></div>";
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
