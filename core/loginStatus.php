<?php
include('scadmin_header.php');
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];

/*START-Change in pagignation(performance) problem line by sachin*/
$limit = 100;  
/*if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
//$s="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' LIMIT $start_from, $limit";

$query=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,
tc.t_complete_name,st.std_complete_name
 from  tbl_LoginStatus ls
left join tbl_teacher tc on ls.EntityID=tc.id  
left join  tbl_student st on ls.EntityID =st.id
 WHERE ls.school_id='$school_id' LIMIT $start_from, $limit");
*/

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $limit;

//MySQL queries updated by Rutuja Jori(PHP Intern) for the Bug SMC-3567 on 08/04/2019
	
$sql=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,
tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname
 from  tbl_LoginStatus ls
left join tbl_teacher tc on ls.EntityID=tc.id  
left join  tbl_student st on ls.EntityID =st.id
 WHERE ls.school_id='$school_id' order by RowID desc LIMIT $start_from, $limit");	

 
 
$sql1 ="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,
tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname
 from  tbl_LoginStatus ls
left join tbl_teacher tc on ls.EntityID=tc.id  
left join  tbl_student st on ls.EntityID =st.id
 WHERE ls.school_id='$school_id' order by RowID desc";  
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					$total_records = $row1;  
					$total_pages = ceil($total_records / $limit);
					if($total_pages == $_GET['page']){
					$limit = $total_records;
					}else{
					$limit = $start_from + $limit;
					}
			//echo $sql1;
}else
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $limit;

$searchq=mysql_real_escape_string($_GET['Search']);
$colname=mysql_real_escape_string($_GET['colname']);
	if ($colname != ''and $colname != 'Select')
	{
				if ($colname =='name')
					{ 
						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND (t_complete_name LIKE '%$searchq%'or std_complete_name LIKE '%$searchq%')order by RowID desc LIMIT $start_from, $limit") or die("could not Search!");
					
						$sql1 ="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND (t_complete_name LIKE '%$searchq%'or std_complete_name LIKE '%$searchq%') order by RowID desc";
					}else if($colname =='LogoutTime'and ($searchq=='Running' || $searchq=='running') )
					{ $searchq=Null;
						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '$searchq' order by RowID desc LIMIT $start_from, $limit") or die("could not Search!");
					
						$sql1 ="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '$searchq' order by RowID";
						$searchq='Running';
						//echo $sql1;
					}else if($searchq =='TEACHER' || $searchq =='Teacher' || $searchq =='teacher')
					{ $searchq='103';
						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '%$searchq%' order by RowID desc LIMIT $start_from, $limit") or die("could not Search!");
					
						$sql1 ="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '%$searchq%' order by RowID desc";
						//echo $sql1;
					}else if($searchq =='STUDENT' || $searchq =='Student' || $searchq =='student')
					{ $searchq='105';
						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '%$searchq%' order by RowID desc LIMIT $start_from, $limit") or die("could not Search!");
					
						$sql1 ="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '%$searchq%' order by RowID desc";
					}else
					{
						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '%$searchq%' order by RowID desc LIMIT $start_from, $limit") or die("could not Search!");
					
					$sql1 ="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND `$colname` LIKE '%$searchq%' order by RowID desc"; 
				}
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					$total_records = $row1;  
					$total_pages = ceil($total_records / $limit);

	}else{
			
			$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND (Entity_type LIKE '$searchq%' or LatestLoginTime LIKE '%$searchq%' or LogoutTime LIKE '%$searchq%' or LatestMethod LIKE '%$searchq%' or LatestDeviceDetails LIKE '$searchq%' or LatestPlatformOS LIKE '$searchq%'or LatestIPAddress LIKE '$searchq%'or LatestBrowser LIKE '$searchq%'or t_complete_name LIKE '%$searchq%'or std_complete_name LIKE '%$searchq%') order by RowID desc LIMIT $start_from, $limit") or die("could not Search!");
			
			$sql1 ="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name, tc.t_name, tc.t_middlename, tc.t_lastname,st.std_name, st.std_Father_name, st.std_lastname from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND (Entity_type LIKE '$searchq%' or LatestLoginTime LIKE '%$searchq%' or LogoutTime LIKE '%$searchq%' or LatestMethod LIKE '%$searchq%' or LatestDeviceDetails LIKE '$searchq%' or LatestPlatformOS LIKE '$searchq%'or LatestIPAddress LIKE '$searchq%'or LatestBrowser LIKE '$searchq%'or t_complete_name LIKE '%$searchq%'or std_complete_name LIKE '%$searchq%') order by RowID desc"; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $limit);
		}
			
		//below query use for search count
		 
					

					if($total_pages == $_GET['spage']){
					$limit = $total_records;
					}else{
					$limit = $start_from + $limit;
					}
					 
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
 <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">


<!-- <script>
$(document).ready(function() {

    $('#example').dataTable( {
         "order": [[ 2, "desc" ]]    
    } );
} );
</script>
 -->
 <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	"scrollY": "500px"

    } );
} );
    </script>
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
			window.location.assign('loginStatus.php?page='+page);
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
			window.location.assign('loginStatus.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.min.js"></script>
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



        padding-right: 10px;

        white-space: nowrap;
    }
    /*
    Label the data
    */

    #no-more-tables td:before { content: attr(data-title); }
}

</style>
</head>
<body>

<div style="bgcolor:#CCCCCC">
  <div class="" style="padding:30px;" >
     <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
         <div style="background-color:#F8F8F8 ;">
			<div class="row">
					<div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
						 <!-- <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Degree" style="font-weight:bold;font-size:14px;"/></a>      -->
               		</div>
              		<div class="col-md-10 " align="center"  >
                         <div style="font-size:34px;">Login Status </div>
               		<!-- <form style="margin-top:5px;">
               								<div style="margin-left: 800px;">
               									<input type="text" name="Search" value="<?php echo $_POST['Search'];?>" placeholder="Search..">
               									<input type="submit" value="Search">		
               								</div>
               							</form> -->
					<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			<div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
               <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
                    <option value="name"
					<?php if (($_GET['colname']) == "name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Name</option>
					<option value="Entity_type"
					<?php if (($_GET['colname']) == "Entity_type") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Entity Type</option>
                     <option value="LatestLoginTime"
					<?php if (($_GET['colname']) == "LatestLoginTime") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Login Time</option>
					<option value="LogoutTime"
					<?php if (($_GET['colname']) == "LogoutTime") {
					                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Logout Time</option>
					<option value="LatestDeviceDetails"
					<?php if (($_GET['colname']) == "LatestDeviceDetails") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Device Details</option>
					<option value="LatestPlatformOS"
					<?php if (($_GET['colname']) == "LatestPlatformOS") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Platform OS</option>
					<option value="LatestIPAddress"
					<?php if (($_GET['colname']) == "LatestIPAddress") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>IP Address</option>
							<option value="LatestBrowser"
					<?php if (($_GET['colname']) == "LatestBrowser") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Browser</option>
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php 
				if($searchq =='103'){ echo $searchq='TEACHER';}
				else if($searchq =='105'){echo $searchq='STUDENT';}
				else if(($searchq=='Null'|| $searchq=='Running'|| $searchq=='running')){echo $searchq='Running';}
				else{echo $searchq;}?>"placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('loginStatus.php','_self')" />
			</div>
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
		</form>
		 </div> 

		<?php  
		/*if (isset($_GET['Search'])){}else{
					$sql12 ="select COUNT(RowID) from tbl_LoginStatus WHERE school_id='$school_id'";  
					$rs_result = mysql_query($sql12);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $limit);  
					if($total_pages == $_GET['page']){
					$limit = $total_records;
					}else{
					$limit = $start_from + $limit;
					}
					$pagLink =""; 
					for ($i=1; $i<=$total_pages; $i++) { 
						$mypage = !empty($_GET['page'])?$_GET['page']:1;
						if($i == $mypage){
							$class = 'active';
							$selected = "selected";
							$pagLink .= "<option value='loginStatus.php?page=".$i."'".$selected." >  ".$i.''." </option> ";
						}else{
							$class = '';
							   // $pagLink .= " <option value='index.php?page=".$i."'".$selected." ><a class='$class' href='index.php?page=".$i."'>".$i.''." </a></option> "; 
							   //$pagLink .="
							   $pagLink .= "<option value='loginStatus.php?page=".$i."'>  ".$i.''." </option> "; 
						}		   
					};
					echo "<div class='pagination'  style='margin-top:5px;'>";
					
					echo "<form><select onchange='location = this.value;' style='margin-left:100px;' >";
					echo $pagLink ."</select>";
					echo "<font color='blue'><b style='margin-left:10px;'>Go to page number</b>"; 
					echo "<b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</b></font></form></div>";
					//}
					
					*/?>
					</div>
            </div>

		<?php
		if (isset($_GET['Search']))
		{
			/*$searchq=$_GET['Search'];
				if ($searchq =='STUDENT' || $searchq =='Student')
					{ $searchq='105';
						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND ls.Entity_type ='$searchq'") or die("could not Search!");
					}else if($searchq =='TEACHER' || $searchq =='Teacher')
					{ $searchq='103';
						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND ls.Entity_type ='$searchq'") or die("could not Search!");
					}else{
						$q1="SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND (Entity_type LIKE '$searchq%' or LatestLoginTime LIKE '%$searchq%' or LogoutTime LIKE '%$searchq%' or LatestMethod LIKE '%$searchq%' or LatestDeviceDetails LIKE '$searchq%' or LatestPlatformOS LIKE '$searchq%'or LatestIPAddress LIKE '$searchq%'or LatestBrowser LIKE '$searchq%'or t_complete_name LIKE '$searchq%'or std_complete_name LIKE '$searchq%')";

						$query1=mysql_query("SELECT ls.EntityID,ls.Entity_type,ls.LatestLoginTime,ls.LogoutTime,ls.LatestMethod,ls.LatestDeviceDetails,ls.LatestPlatformOS,ls.LatestIPAddress,ls.LatestBrowser,tc.t_complete_name,st.std_complete_name from  tbl_LoginStatus ls left join tbl_teacher tc on ls.EntityID=tc.id left join  tbl_student st on ls.EntityID =st.id WHERE ls.school_id='$school_id' AND (Entity_type LIKE '$searchq%' or LatestLoginTime LIKE '%$searchq%' or LogoutTime LIKE '%$searchq%' or LatestMethod LIKE '%$searchq%' or LatestDeviceDetails LIKE '$searchq%' or LatestPlatformOS LIKE '$searchq%'or LatestIPAddress LIKE '$searchq%'or LatestBrowser LIKE '$searchq%'or t_complete_name LIKE '%$searchq%'or std_complete_name LIKE '%$searchq%')") or die("could not Search!");					}

						*/
			$count=mysql_num_rows($query1);
			if($count == 0)
				{echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;margin-left:600px'><font color='Red'><b>There Was No Search Result</b></font></div>";
			}
				else
				{
				?>
				<div class="row" style="padding:10px;">
	             <div class="col-md-12  " id="no-more-tables" >
				   <table id="example" class="display" width="100%" cellspacing="0">
				   <!-- <tr><?php echo $q1;?></tr> -->
						<thead>
							<th>Sr.No.</th>
							<th>Name</th>
							<th>Entity Type</th>
							<!--
							<th>FirstLoginTime</th>
							<th>FirstMethod</th>
							<th>FirstDeviceDetails</th>
							<th>FirstPlatformOS</th>
							<th>FirstIPAddress</th>
							<th>FirstLatitude</th>
							<th>FirstLongitude</th>
							<th>FirstBrowser</th>-->
							<th>Login Time</th>
							<th>Logout Time</th>
							<!--<th>LatestMethod</th>-->
							<th>Device Details</th>
							<th>Platform OS</th>
							<th>IP Address</th>
							<!--<th>LatestLatitude</th>
							<th>LatestLongitude</th>-->
							<th>Browser</th>

							<!--<th>CountryCode</th> -->
						</thead>





						
						<tbody>
							 <?php
							  $i=1;
							$i = ($start_from +1);
							  while ($row=mysql_fetch_array($query1))
							  {
							   ?>
							   <tr>
							   	 <td><?php echo $i; ?></td>
								  <?php 
								   $entity_type = $row['Entity_type'];
								  if($entity_type =='105' || $entity_type =='205'){
								   ?>
									<td><?php 
									if($row['std_complete_name']=='')
									{
										echo strtoupper($row['std_name'].' '.$row['std_Father_name'].' '.$row['std_lastname']);
									}
									else{
										echo strtoupper($row['std_complete_name']);
									} ?></td>
									<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
									<td>STUDENT</td>
									<?php } else { ?>
									<td>EMPLOYEE</td>
									<?php }?>
									<?php
									}else{

									 ?>
									<td><?php 
									if($row['t_complete_name']=='')
									{	
										echo strtoupper($row['t_name'].' '.$row['t_middlename'].' '.$row['t_lastname']);
									}
									else
									{
										echo strtoupper($row['t_complete_name']); 
									} ?></td>
									<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
									<td>TEACHER</td>
									<?php } else { ?>
									<td>MANAGER</td>
									<?php }?>
									<?php
								   }
									?>
								  <!-- <td><?php echo strtoupper($row['name']); ?></td>
								  <td><?php echo $entity_type; ?></td> -->
								  <td><?php echo $row['LatestLoginTime']; ?></td>
								  <td><?php if($row['LogoutTime']!=""){echo $row['LogoutTime'];}else{echo "<div style='color:#428BCA'>Running</div>";} ?></td>
								  <!-- <td><?php echo $row['LatestMethod']; ?></td> -->
								  <td><?php echo $row['LatestDeviceDetails']; ?></td>
								  <td><?php echo $row['LatestPlatformOS']; ?></td>
								  <td><?php echo $row['LatestIPAddress']; ?></td>
								  <td><?php echo $row['LatestBrowser']; ?></td>
							   </tr>
							  <?php 
								$i++;
								  } ?>
						</tbody>
				   </table>
				</div>
            </div>
			
			<div id="show" >
		<?php if (!($_GET['Search']))
			{
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
			{
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font></div>";
			}
			?>

		 </div>
			<div class="container" align='center'>
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
			<div class="row" style="padding:10px;" >
	             <div class="col-md-12  " id="no-more-tables" >
				   <table id="example" class="display" width="100%" cellspacing="0">
				  <!--  <tr><?php echo $s;?></tr> -->
						<thead>
							<th>Sr.No.</th>
							<th>Name</th>
							<th>Entity Type</th>
							<!--<th>FirstLoginTime</th>
							<th>FirstMethod</th>
							<th>FirstDeviceDetails</th>
							<th>FirstPlatformOS</th>
							<th>FirstIPAddress</th>
							<th>FirstLatitude</th>
							<th>FirstLongitude</th>
							<th>FirstBrowser</th>-->
							<th>Login Time</th>
							<th>Logout Time</th>
							<!--<th>LatestMethod</th>-->
							<th>Device Details</th>
							<th>Platform OS</th>
							<th>IP Address</th>
							<!--<th>LatestLatitude</th>
							<th>LatestLongitude</th>-->
							<th>Browser</th>

							<!--<th>CountryCode</th> -->
						</thead>
						<tbody>
							 <?php
							/* $table = "";
							 $ent_type ="";
							 $name = "";
							 function checkEntity($entity)
							 {
							   $data = array();
								switch($entity)
								{
								  case 105:
										$data['table'] = "tbl_student";
										$data['ent_type'] = "STUDENT";
										$data['name'] ="std_complete_name";
										break;
								  case 103:
										$data['table'] = "tbl_teacher";
										$data['ent_type'] = "TEACHER";
										$data['name'] ="t_complete_name";
										break;
								}
							   return $data;
							 }
							  $sql = "SELECT `EntityID`,`Entity_type`,`LatestLoginTime`,`LogoutTime`,`LatestMethod`,`LatestDeviceDetails`,`LatestPlatformOS`,`LatestIPAddress`,`LatestBrowser` FROM `tbl_LoginStatus` WHERE school_id='".$school_id."'" ;
							  $query = mysql_query($sql);*/
							  $i=1;
							  $i = ($start_from +1);
							  while ($row=mysql_fetch_array($sql))
							  {
								// $data =  checkEntity($row['Entity_type']);
								 //$entity_type = $data['ent_type'];
								// $sql1 = "SELECT ".$data['name']." as name from ".$data['table']." WHERE id='".$row['EntityID']."'";
								// $q = mysql_query($sql1);
								// $row1 = mysql_fetch_array($q);
							   ?>
								  
							   <tr>

							   	  <td><?php echo $i; ?></td>
								  <?php 
								   $entity_type = $row['Entity_type'];
								  if($entity_type =='105'  || $entity_type =='205'){
								   ?>
									<td><?php
									if($row['std_complete_name']=='')
									{
										echo strtoupper($row['std_name'].' '.$row['std_Father_name'].' '.$row['std_lastname']);
									}
									else{
										echo strtoupper($row['std_complete_name']);
									} ?></td>
									<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
									<td>STUDENT</td>
									<?php } else { ?>
									<td>EMPLOYEE</td>
									<?php }?>
									<?php
									}else{
									   ?>
									<td><?php 
									if($row['t_complete_name']=='')
									{	
										echo strtoupper($row['t_name'].' '.$row['t_middlename'].' '.$row['t_lastname']);
									}
									else
									{
										echo strtoupper($row['t_complete_name']); 
									}
									 ?></td>
									<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
									<td>TEACHER </td>
									<?php } else { ?>
									<td>MANAGER</td>
									<?php }?>
									<?php
								   }
									?>
								  <!-- <td><?php echo strtoupper($row['name']); ?></td>
								  <td><?php echo $entity_type; ?></td> -->
								  <td><?php echo $row['LatestLoginTime']; ?></td>
								   <td>

								  <?php
								  
								  /*	$datetime = $row['LogoutTime'];
								  	//$datetime = '2021-04-14 07:05:45';
								  	echo $datetime;
								  	$newtime = date('H:i:s', strtotime($datetime));
								  	echo $newtime;
								   	$time =  date("H:i:s", strtotime($newtime));
								   	echo $time;

								   	$arr_datetime = explode(" ",$datetime);
								   	$date = $arr_datetime[0];
								   	echo $date." ".$time;*/
								  if($row['LogoutTime']!=""){echo $row['LogoutTime'];}else{echo "<div style='color:#428BCA'>Running</div>";} ?></td>
								  <!--<td><?php echo $row['LatestMethod']; ?></td>  -->
								  <td><?php echo $row['LatestDeviceDetails']; ?></td>
								  <td><?php echo $row['LatestPlatformOS']; ?></td>
								  <td><?php echo $row['LatestIPAddress']; ?></td>
								  <td><?php echo $row['LatestBrowser']; ?></td>
							   </tr>
							  <?php 
								$i++;
								  } ?>
						</tbody>
				   </table>
				</div>
            </div>
<div id="show"  align='left'>
		<?php if (!($_GET['Search']))
			{
				if ($limit >$total_records){ $limit=$total_records;}

				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
			{
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font></div>";
			}
			?>

		 </div>
			<div class="container" align='center'>
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
			<?php } ?>

                 <!-- <div class="row" style="padding:5px;">
	                   <div class="col-md-4">               
						</div>
                        <div class="col-md-3 "  align="center">        
						</form> </div>
                    </div>
                     <div class="row" >
                     <div class="col-md-4">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center">
                      <?php echo $report;?> -->
	</div>
   </div>
 </div>
</div>

</body>
</html>