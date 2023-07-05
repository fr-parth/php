<?php
/*
Author : Pranali Dalvi
Date : 15-11-19
This file was created for tracking uploaded data of Schools under Group Admin
*/
/*Updated by Rutuja for design changes for SMC-4926 on 28-10-2020*/
include("cookieadminheader.php");

if (isset($_POST['search']))
{
	$sql = "SELECT bm.school_id,bm.tbl_display_name,bm.tbl_name,bm.inserted_date,ay.Academic_Year,ay.group_member_id,s.school_id,s.school_type
		FROM tbl_school_datacount bm 
		LEFT JOIN tbl_academic_Year ay ON bm.school_id=ay.school_id
		LEFT JOIN tbl_school_admin s ON bm.school_id=s.school_id  where  s.school_type='school' ";
		

	$qry="";
    $academic_year = $_POST['academic_year'];
    $group_name = $_POST['group_name'];
   
    if ($academic_year != '' && $group_name !='') {
   
		$qry=" and ay.Academic_Year='".$academic_year."' AND ay.group_member_id='".$group_name."'";
    }
	if ($academic_year == '' && $group_name !='') {
   
		$qry=" and ay.group_member_id='".$group_name."'";
    }
	
    if ($academic_year != '' && $group_name =='') {
					
		$qry=" and ay.Academic_Year='".$academic_year."'";
    }
	if ($academic_year == '' && $group_name =='') {
			
		$qry="";
    }
	
 $sql = $sql . $qry . " group by bm.school_id";

}
else{
    $sql = "SELECT bm.school_id,bm.tbl_display_name,bm.tbl_name,bm.inserted_date,ay.Academic_Year,ay.group_member_id,s.school_id,s.school_type
        FROM tbl_school_datacount bm 
        LEFT JOIN tbl_academic_Year ay ON bm.school_id=ay.school_id 
		LEFT JOIN tbl_school_admin s ON bm.school_id=s.school_id  where bm.school_id!='' and s.school_type='school' group by bm.school_id ";
}
//echo $sql;
$row = mysql_query($sql);
$count1 = mysql_num_rows($row);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>School List</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	
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
                border: 1px solid #000000;
                font-weight: bold;
            }
            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #000000;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
                font-weight:bold;
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
                font-weight:bold;
            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
                font-weight:bold;
            }
        }
		.sortable{
				cursor: pointer;
		}
    </style>
    
    <script>
        $(document).ready(function () {
            $('#example').dataTable({});
        });
    </script>
    
</head>
<body>
<div align="center">
     <div class="row" style="padding-top:30px;">
        <form method="POST">
            <div>
            <h2 style="padding-left:20px; margin-top:2px;color:#333;font-family:Times New Roman, Times, serif;font-size:30px;"> Data Upload Status</h2>
        </div>
        <br>
            <div class="col-md-2" style="font-weight:bold;font-size:120%;padding-top:5px;margin-right:-52px;margin-left:220px"> Academic Year</div>
            <div class="col-md-2" style="width:17%;">

                <select name="academic_year" class="form-control">
                    <?php $query = mysql_query("SELECT sd.academic_year,sd.school_id,a.Academic_Year,a.school_id,a.Enable  FROM tbl_school_datacount sd INNER 
JOIN tbl_academic_Year a ON sd.school_id=a.school_id where a.Enable='1' and sd.Academic_Year!='' group by sd.academic_year "); ?>
                    <option value="" style="font-weight:bold">Select</option>
                    <?php $j = 1;
                   	while($test = mysql_fetch_array($query)){  ?>
												 <option value="<?php echo $test['academic_year']?>"
											<?php if (($_POST['academic_year']) == $test['academic_year']) 
											{
												echo $_POST['academic_year']; ?> selected="selected" <?php } ?>> <?php echo ucwords($test['academic_year'])?></option>
										<?php	}
										?>
				
                </select></div>
            <div class="col-md-2" style="font-weight:bold;font-size:120%;padding-top:5px;margin-right:-52px;"> Group Name</div>
            <div class="col-md-2" style="width:17%;">

                <select name="group_name" class="form-control">
                    <?php $query1 = mysql_query("SELECT id,group_name FROM tbl_cookieadmin WHERE group_type!='admin'"); ?>
                    <option value="" style="font-weight:bold">Select</option>
					
                    <?php $k = 1;
                   	while($test1 = mysql_fetch_array($query1)){  ?>
												 <option value="<?php echo $test1['id']?>"
											<?php if (($_POST['group_name']) == $test1['id']) 
											{
												echo $_POST['group_name']; ?> selected="selected" <?php } ?>> <?php echo ucwords($test1['group_name'])?></option>
										<?php	}
										?>
                </select></div>
               
				
            <div class="col-md-1"><input type="submit" name="search" value="Search" class="btn btn-success" style="font-weight:bold"></div>
            <!-- <div class="col-md-1" >
            <input type="button" class="btn btn-info" value="Reset" onclick="window.open('data_upload_track.php','_self')" />
            </div> -->
           </form>
    </div>

    <div>
        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="col-md-12 table-bordered">
              <thead>
              <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:17px">
                    <th>Sr.No.</th>
                    <th>School ID</th>
					<th>School Name</th>
					<th>Preview Uploaded Details</th>
                </tr>
                </thead>
                <?php $i = 1;					
				 
                while ($result = mysql_fetch_array($row)){

                	$sql1 = mysql_query("SELECT school_name,school_id,school_type FROM tbl_school_admin
                		WHERE school_id='".$result['school_id']."'");
                	$res=mysql_fetch_assoc($sql1);
					$school_id=$res['school_id'];
                ?>
				
                <tr style="font-family:Times New Roman, Times, serif;font-size:17px; color:#333;">
                    <td data-title="Sr.No."><?php echo $i; ?></td>
                    <td data-title="School ID"><?php echo $result['school_id'];?></td>
					<td data-title="School Name"><?php echo $res['school_name'];?></td>
					<td data-title="Upload Preview">
						<input type="submit" value="Upload Preview" name="upload_preview" onClick="window.location.href='data_upload_track_sa.php?school_id=<?php echo $res['school_id'] ?>&school_type=<?php echo $res['school_type'] ?>&group_id=<?php echo $result['group_member_id'] ?>&Academic_Year=<?php echo $result['Academic_Year'] ?>&school_name=<?php echo $res['school_name'] ?>'" class="btn btn-primary" />
					</td>
				</tr>	
                    <?php $i++;
                    }
                    ?>
            </table>
            
        </div>
    </div>   <!--end of center content -->
</div>
</body>
</html>