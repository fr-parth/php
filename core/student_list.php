<?php
include("cookieadminheader.php");
$limit = 50;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
/* START-Change in query to display "school Name" by Dhanashri*/
$sql="SELECT s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name,tsa.school_name,s.std_email,s.std_phone,s.std_address from tbl_student s JOIN tbl_school_admin tsa ON s.school_id = tsa.school_id where s.school_id!='' order by tsa.school_name LIMIT $start_from, $limit";
/*End*/
//$sql = "SELECT std_name,std_Father_name,std_lastname,std_complete_name,std_school_name,std_email,std_phone,std_address from tbl_student where school_id!='' order by id desc LIMIT $start_from, $limit";
$row = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $dynamic_student; ?> Information</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"searching": false
    } );
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
            <h2 style="padding-left:20px; margin-top:2px;color:white;background-color:#694489;padding-top:10px;padding-bottom:10px"> List of Students</h2>
        </div>
<?php  
$sql = "SELECT COUNT(id) FROM tbl_student";  
$rs_result = mysql_query($sql);  
$row1 = mysql_fetch_row($rs_result);  
$total_records = $row1[0];  
$total_pages = ceil($total_records / $limit);  
if($total_pages == $_GET['page']){
$limit = $total_records;
}else{
$limit = $start_from + $limit;
}
$pagLink = "<div class='pagination'>"; 
for ($i=1; $i<=$total_pages; $i++) { 
	$mypage = !empty($_GET['page'])?$_GET['page']:1;
	if($i == $mypage){
		$class = 'active';
		$selected = "selected";
		$pagLink .= "<option value='student_list.php?page=".$i."'".$selected." >  ".$i.''." </option> ";
	}else{
		$class = '';
           // $pagLink .= " <option value='index.php?page=".$i."'".$selected." ><a class='$class' href='index.php?page=".$i."'>".$i.''." </a></option> "; 
		   //$pagLink .="
		   $pagLink .= "<option value='student_list.php?page=".$i."'>  ".$i.''." </option> "; 
	}		   
};
echo "<div class='pagination'>";
echo "<p style='margin-right: 805px;
    margin-bottom: 21px;'><font color='blue'><b>Go to page number</font></p>";
echo "<form><select onchange='location = this.value;' style='margin-right: 600px;
    margin-top: -41px;'>";
echo $pagLink . "</div>";
echo "</select></form></div>"; 
echo "<div id='record' style='margin-top: -62px;
    margin-left: 523px;color:blue'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</div></b>";
?>
<form>
<div style="margin-left: 700px;margin-top: 10px;">
	<input type="text" name="Search" placeholder="Search..">
	<input type="submit" value="Search">
</div>
</form>
	<?php
		if (isset($_GET['Search']))
		{
			$searchq=$_GET['Search'];
		
			$query1=mysql_query("SELECT s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name,tsa.school_name,s.std_email,s.std_phone,s.std_address from tbl_student s JOIN tbl_school_admin tsa ON s.school_id = tsa.school_id 
			WHERE s.std_name LIKE '%$searchq%' or
			s.std_Father_name LIKE '%$searchq%' or
			s.std_lastname LIKE '%$searchq%' or
			s.std_complete_name LIKE '%$searchq%' or 
			s.std_email LIKE '%$searchq%' or 
			s.std_phone LIKE  '%$searchq%' or 
			s.std_address LIKE '%$searchq%' or
			tsa.school_name LIKE '%$searchq%'") or die("could not Search!");
			$count=mysql_num_rows($query1);
			if($count == 0){
				echo "There Was No Search Result";
			}
			else
			{
				?>
				     <div id="no-more-tables" style="padding-top:20px;">
					<table id="example" class="col-md-12 table-bordered " align="center">
						<thead>
						<tr style="background-color:#694489;; color:#FFFFFF; height:30px;">
							<th>Sr. No.</th>
							<th> Student Name</th>
							<th>School Name</th>
							<th>Email ID</th>
							<th> Phone No</th>
							<th> Address</th>
						</tr>
						</thead>
						<?php $J = 1;
						while ($result = mysql_fetch_array($query1)) {
							?>
							<tr>
								<td data-title="Sr.No."><?php echo $J; ?></td>
								<td data-title="Student Name"><?php
									$std_complete_name = ucwords(strtolower($result['std_complete_name']));
									if ($std_complete_name == '') {
										echo ucwords(strtolower($result['std_name'])) . " " . ucwords(strtolower($result['std_Father_name'])) . " " . ucwords(strtolower($result['std_lastname']));
									} else {
										echo $std_complete_name;
									}
									?></td>
								<td data-title="School Name"><?php echo $result['school_name']; ?></td>
								<td data-title="Email ID"><?php echo $result['std_email']; ?></td>
								<td data-title="Phone No."><?php echo $result['std_phone']; ?></td>
								<td data-title="Address"><?php echo $result['std_address']; ?></td>
							</tr>
							<?php $J++;
						} ?>
					</table>	
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
                <tr style="background-color:#694489;; color:#FFFFFF; height:30px;">
                    <th>Sr. No.</th>
                    <th> Student Name</th>
                    <th>School Name</th>
                    <th>Email ID</th>
                    <th> Phone No</th>
                    <th> Address</th>
                </tr>
                </thead>
                <?php $J = ($start_from +1);;
                while ($result = mysql_fetch_array($row)) {
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $J; ?></td>
                        <td data-title="Student Name"><?php
                            $std_complete_name = ucwords(strtolower($result['std_complete_name']));
                            if ($std_complete_name == '') {
                                echo ucwords(strtolower($result['std_name'])) . " " . ucwords(strtolower($result['std_Father_name'])) . " " . ucwords(strtolower($result['std_lastname']));
                            } else {
                                echo $std_complete_name;
                            }
                            ?></td>
                        <td data-title="School Name"><?php echo $result['school_name']; ?></td>
                        <td data-title="Email ID"><?php echo $result['std_email']; ?></td>
                        <td data-title="Phone No."><?php echo $result['std_phone']; ?></td>
                        <td data-title="Address"><?php echo $result['std_address']; ?></td>
                    </tr>
                    <?php $J++;
                } ?>
            </table>	
        </div>
		<?php
		}
		?>
    </div>
</div>
</body>
</html>
<script>
$(document).ready(function() {
$('#example_info').hide();
$('#example_paginate').hide();
//$("select[name='example_length']").hide();
});
</script>