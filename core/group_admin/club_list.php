<?php
ob_start('ob_gzhandler');
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/21/2017
 * Time: 3:31 PM
 */
include_once("./groupadminheader.php");
//print_r($_SESSION);
//include("../conn.php");
/*Entity and if conditions added by Rutuja for differentiating between Group Admin & Group Admin Staff for fetching the group_member_id to
 solve the issue of other schools other than those under group getting displayed for SMC-4566 on 24/03/2020 by Rutuja*/
$entity=$_SESSION['entity'];
if($entity==12)
{
$group_member_id = $_SESSION['group_admin_id'];
}
if($entity==13)
{
$group_member_id = $_SESSION['group_member_id'];
}
if($_GET['group_name']!=''){ 
    $grp_arr=explode(',',$_GET['group_name']);
    $grp_id=$grp_arr[0];
    $group_member_id= trim($grp_id); 
}
?>
<?php
//if(isset($_POST['search1'])){
  //  $from_date = $_POST['from_date'];  $to_date = $_POST['to_date'];
//    $sql1="SELECT school_id,school_name,name,reg_date,school_balance_point ,school_assigned_point FROM tbl_school_admin where school_id!='' and group_member_id = '$group_member_id'  and reg_date between '$from_date' and '$to_date' order by school_id desc";$sql=mysql_query($sql1);
//}
//else
//{
     //$sql="SELECT school_id,school_name,reg_date,name,school_balance_point,school_assigned_point FROM tbl_school_admin where group_member_id = '$group_member_id'  order by school_id";
    //$row=mysql_query($sql); 

/*START-Change in pagignation problem line by sachin*/
//$webpagelimit = 10;  
/*
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
$s="SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point, (select count(id)  from tbl_student where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_students,(select count(id) from tbl_teacher where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_teacher FROM tbl_school_admin sa where sa.group_member_id='$group_member_id' order by school_id LIMIT $start_from, $webpagelimit";

$sql=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point, (select count(id)  from tbl_student where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_students,(select count(id) from tbl_teacher where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_teacher FROM tbl_school_admin sa where sa.group_member_id='$group_member_id' order by school_id LIMIT $start_from, $webpagelimit");
*/

//}

if (!(isset($_GET['Search']))){

    
// echo $webpagelimit;
if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
// echo $start_from;
//echo "SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon, (select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(sselect count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' order by sa.id LIMIT $start_from, $webpagelimit" ;
$sql=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon, (select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137') ) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' order by no_students desc LIMIT $start_from, $webpagelimit");  
$sql1 ="select COUNT(sa.id) from tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id  where gs.group_member_id = '$group_member_id' order by sa.school_id";  
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

$searchq=mysql_real_escape_string($_GET['Search']);
$colname=mysql_real_escape_string($_GET['colname']);

    if ($colname != ''and $colname != 'select'  )
    {   
    //     if ($colname=="no_students" || $colname=="no_teacher" )
    //         {
    //         $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,(select count(id)  from tbl_student s where s.school_id=sa.school_id ) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' having `$colname` = '$searchq' order by no_students desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
                    
    //     $sql1 ="select  sa.school_id FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' having `$colname` = '$searchq'";
    //         //echo $sql1;
    //     }
    //     elseif ($colname=="coordinator_id" )
    //         {
    //             if(strtolower($searchq)=='yes'){$cond .= " and coordinator_id!='' and coordinator_id IS NOT NULL";}
    //             if(strtolower($searchq)=='no'){$cond .= " and (coordinator_id='' or coordinator_id IS NULL)";}
    //             if(strtolower($searchq)=='all'){$cond .= "";}
               
    //         $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' $cond order by no_students desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
    //         $sql1 ="select  sa.school_id FROM tbl_school_admin sa where sa.group_member_id='$group_member_id' $cond ";
    //         //echo $sql1;exit;
    //     }
    //     elseif($colname=='reg_date'){
    //     $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id'  AND gs.createdon LIKE '%$searchq%' order by no_students desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
    //     $sql1 ="select sa.id from tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id  where gs.group_member_id = '$group_member_id'  AND ( gs.createdon LIKE '%$searchq%' )";
        
    // }
    // elseif($colname=='school_assigned_point'){
    //     if($searchq=='0'){$cond = " (sa.balance_blue_points = '0' or sa.balance_blue_points = '' or sa.balance_blue_points is null) ";}
    //             else{$cond = "sa.balance_blue_points ='$searchq'";}
    //     $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' and $cond order by no_students desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
    //     $sql1 ="select sa.id from tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id  where gs.group_member_id = '$group_member_id'  AND $cond ";
    //     //      
    // }
    // elseif($colname=='school_balance_point'){
    //     if($searchq=='0'){$cond = "  (sa.school_balance_point = '0' or sa.school_balance_point = '' or sa.school_balance_point is null) ";}
    //             else{$cond = "sa.school_balance_point ='$searchq'";}
    //     $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' and $cond  order by no_students desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
    //     $sql1 ="select sa.id from tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id  where gs.group_member_id = '$group_member_id' and $cond ";  
    // }
    //    else{
            $col= 'sa.'. $colname;
        //echo "SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id'  AND $col LIKE '%$searchq%' AND $col is not null order by no_students desc LIMIT $start_from, $webpagelimit";

        $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id'  AND $col LIKE '%$searchq%' AND $col is not null order by no_students desc LIMIT $start_from, $webpagelimit");
        $sql1 ="select sa.id from tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id  where gs.group_member_id = '$group_member_id'  AND ( $col LIKE '%$searchq%' )";
            // echo $sql1;echo 1;
    //        }
         
                    $rs_result = mysql_query($sql1);  
                    $row1 = mysql_num_rows($rs_result);  
                    //echo '<br> row'.$row1.'<br>';
                    $total_records = $row1;  
                    $total_pages = ceil($total_records / $webpagelimit);
                    //echo 'trecord'.$total_records;
        
    }else{ 
            //echo "SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' AND (sa.school_id LIKE '$searchq%' or school_name LIKE '%$searchq%' or reg_date LIKE '%$searchq%' or name LIKE '$searchq%' or school_balance_point LIKE '$searchq%' or balance_blue_points LIKE '$searchq%') order by no_students desc LIMIT $start_from, $webpagelimit";
            $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.balance_blue_points,sa.email,sa.coordinator_id,gs.createdon,(select count(id)  from tbl_student s where s.school_id=sa.school_id) as no_students,(select count(id) from tbl_teacher t where t.school_id=sa.school_id AND t.t_emp_type_pid IN ('133','134','135','137')) as no_teacher FROM tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id='$group_member_id' AND (sa.school_id LIKE '$searchq%' or school_name LIKE '%$searchq%' or reg_date LIKE '%$searchq%' or name LIKE '$searchq%' or school_balance_point LIKE '$searchq%' or balance_blue_points LIKE '$searchq%') order by no_students desc LIMIT $start_from, $webpagelimit");
            
            $sql1= "select COUNT(sa.id) from tbl_school_admin sa inner join tbl_group_school gs on sa.school_id=gs.school_id  where gs.group_member_id = '$group_member_id' order by sa.school_id";


            $rs_result = mysql_query($sql1);  
                    $row1 = mysql_fetch_row($rs_result);  
                    $total_records = $row1[0];  
            // echo $total_records;

                    $total_pages = ceil($total_records / $webpagelimit);
        }
            // echo $total_pages;
           // echo 4;
        //below query use for search count
                    if($total_pages == $_GET['spage']){
                    $webpagelimit = $total_records;
                    }else{
                    $webpagelimit = $start_from + $webpagelimit;
                    } 

}
?>

<!DOCTYPE html >
<html>
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

   <!--  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> -->
  <!-- <script>
        $(function() {
            $( "#from_date" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
        $(function() {
            $( "#to_date" ).datepicker({
                changeMonth: true,
                changeYear: true,
  
            });
        });
    </script> -->
    
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
    "paging":   false,
    "searching": false,
    "info":false,
     "scrollCollapse": true
         } );
         $("#Search_btn").on('click',function(){
        var searchBox= $('#Search11').val();
        var grpname=$('#group_name1').val();
        var search_by=$('#search_by').val();
        console.log(search_by)
        if(searchBox!='' && search_by!='select' || grpname!=''){
            if(searchBox!='' && grpname!='' || searchBox!='' && search_by='' || grpname!=''){
            return true;
            }else{ 
            return false; 
            }
        }else{ 
            alert("Select Search By!!");
            $('#search_by').prop("required", true);
            return false; 
            }
        
    });
         
    } );
   
    </script>
    <?php if (!isset($_GET['Search'])){?>
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
            window.location.assign('club_list.php?page='+page);
        });
    });
</script>
<?php }else{
    ?>
<script type="text/javascript">
console.log("hello")
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
            window.location.assign('club_list.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&group_name=<?php echo $group_member_id; ?>&spage='+page);
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

<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:20px;">
            <h2 style="padding-left:20px; margin-top:2px;color:#666"><?php echo $dynamic_school;?> Information</h2>
        </div>

        <!-- <div  style=" height:30px; padding:5px;"></div> -->
        <!-- <form method="post" action="">
            <label for="from">From</label>
            <input type="text" id="from_date" name="from_date" placeholder="MM/DD/YYYY">
            <label for="to">to</label>
            <input type="text" id="to_date" name="to_date" placeholder="MM/DD/YYYY">&nbsp;&nbsp;
            <input type="submit" value="Search" name="search1" id="search1" />
        </form> -->
        
        <!-- <form style="margin-top:5px;">
                    <div style="margin-left: 800px;">
                        <input type="text" name="Search" placeholder="Search..">
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
                <select name="colname" id="search_by" class="form-control">
                    <option value='select' selected="selected">Select</option>
                    <option value="school_id"
                    <?php if (($_GET['colname']) == "school_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school;?> ID </option>
                     <option value="school_name"
                    <?php if (($_GET['colname']) == "school_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school;?> Name </option>
                            <option value="scadmin_state"
                    <?php if (($_GET['colname']) == "scadmin_state") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> State </option>
                    <!-- <option value="name"
                    <?php if (($_GET['colname']) == "name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school;?> Head</option>
                    <option value="no_students"
                    <?php if (($_GET['colname']) == "no_students") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>No. of <?php echo $dynamic_student;?></option>
                    <option value="no_teacher"
                    <?php if (($_GET['colname']) == "no_teacher") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>No. of <?php echo $dynamic_teacher;?></option>
                    <option value="reg_date"
                    <?php if (($_GET['colname']) == "reg_date") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Date</option>
                    <option value="school_assigned_point"
                    <?php if (($_GET['colname']) == "balance_blue_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Balance Blue Points</option>
                    <option value="school_balance_point"
                    <?php if (($_GET['colname']) == "school_balance_point") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Balance Green Points</option>
                             <option value="coordinator_id"
                    <?php if (($_GET['colname']) == "coordinator_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Coordinator</option> -->
              
                </select>
            </div>
            <div class="col-md-2" style="width:17%;">
                <input type="text" class="form-control" id='Search11' name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." > 
            </div>
            <div class="col-md-4" style="margin-top: 20px;margin-left: 290px;">
                              <div class="">
                                  <label for="type" class ="control-label col-sm-4">Group Name</label>
              
                                <div class="col-sm-8">
                                  <select name="group_name" id="group_name1" class="form-control searchselect"  >
                                  <option value="" >Choose your group</option>
                                  <option value="All" >All</option>
                                  <?php
                                  $gp = mysql_query("SELECT distinct(group_member_id),group_mnemonic_name FROM tbl_group_school where group_mnemonic_name!=''");
                                  while($rr = mysql_fetch_array($gp)){?>
                                  <option <?php if($group_member_id==$rr['group_member_id']){ echo 'selected'; } ?> value="<?php echo $rr['group_member_id'].','.$rr['group_mnemonic_name'] ?>"><?php echo $rr['group_mnemonic_name'].'-'.$rr['group_member_id'] ?></option>
                                    <?php } ?>
                                  </select>
                              </div>

                            </div> 
                          </div>
            <div class="col-md-1" style="margin-top: 20px;" >
            <button type="submit" id='Search_btn' value="Search" class="btn btn-primary">Search</button>
            </div>
            <div class="col-md-1" style="margin-top: 20px;" >
            <input type="button" class="btn btn-info" value="Reset" onclick="window.open('club_list.php','_self')" />
            </div>
                    <!-- <div style="margin-left: 800px;">
                        <input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
                        <input type="submit" value="Search">
                        <input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
                    </div> -->
                   
                           
        </form>
         </div><br> 
        <!--  <div id="show" >
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
            
        <?php /* 
                    $sql12 ="select COUNT(id) from tbl_school_admin where group_member_id = '$group_member_id' order by school_id";  
                    $rs_result = mysql_query($sql12);  
                    $row1 = mysql_fetch_row($rs_result);  
                    $total_records = $row1[0];  
                    $total_pages = ceil($total_records / $webpagelimit);  
                    if($total_pages == $_GET['page']){
                    $webpagelimit = $total_records;
                    }else{
                    $webpagelimit = $start_from + $webpagelimit;
                    }
                    $pagLink =""; 
                    for ($i=1; $i<=$total_pages; $i++) { 
                        $mypage = !empty($_GET['page'])?$_GET['page']:1;
                        if($i == $mypage){
                            $class = 'active';
                            $selected = "selected";
                            $pagLink .= "<option value='club_list.php?page=".$i."'".$selected." >  ".$i.''." </option> ";
                        }else{
                            $class = '';
                               // $pagLink .= " <option value='index.php?page=".$i."'".$selected." ><a class='$class' href='index.php?page=".$i."'>".$i.''." </a></option> "; 
                               //$pagLink .="
                               $pagLink .= "<option value='club_list.php?page=".$i."'>  ".$i.''." </option> "; 
                        }          
                    };
                    echo "<div class='pagination'  style='margin-top:5px;'>";
                    
                    echo "<form><select onchange='location = this.value;' style='margin-left:100px;' >";
                    echo $pagLink ."</select>";
                    echo "<font color='blue'><b style='margin-left:10px;'>Go to page number</b>"; 
                    echo "<b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></form></div>";
                */?>

            <?php
      if (isset($_GET['Search']))
        {
            /* $searchq=$_GET['Search'];
            $q1="SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point, (select count(id) from tbl_student where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_students,(select count(id) from tbl_teacher where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_teacher FROM tbl_school_admin sa where sa.group_member_id='13' AND (school_id LIKE '$searchq%' or school_name LIKE '%$searchq%' or reg_date LIKE '%$searchq%' or name LIKE '$searchq%' or school_balance_point LIKE '$searchq%' or school_assigned_point LIKE '$searchq%') order by school_id";

            $query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point, (select count(id) from tbl_student where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_students,(select count(id) from tbl_teacher where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_teacher FROM tbl_school_admin sa where sa.group_member_id='13' AND (school_id LIKE '$searchq%' or school_name LIKE '%$searchq%' or reg_date LIKE '%$searchq%' or name LIKE '$searchq%' or school_balance_point LIKE '$searchq%' or school_assigned_point LIKE '$searchq%') order by school_id") or die("could not Search!"); */

            $count=mysql_num_rows($query1);
            if($count == 0){
                echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";
            }
            else
            {
            ?>
            <div id="no-more-tables">
            <table id="example" class="col-md-12 table-bordered table-striped "  >
                <thead>
                <!--  <tr>  <?php echo $q1;?></tr> -->
                <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                    <th> Sr. No. </th>
                    <th> <?php echo $dynamic_school;?> ID/<br><?php echo $dynamic_school;?> Name </th>
                   <!--  <th> <?php echo $dynamic_school;?> Name </th> -->
                    <th> <?php echo $dynamic_school;?> Head /Email</th>
                     <th> School Coordinator /<br>Email</th>
                    <th> No. of <?php echo $dynamic_student;?> /<br>No. of <?php echo $dynamic_teacher;?></th>
               <!--      <th> No. of <?php echo $dynamic_teacher;?> </th> -->
                    <th> Date </th>
                    <th> Balance Green Points/Balance Blue Points </th>
                  <!--   <th> Balance Green Points </th> -->
                    <th> Assign </th>
                    <th> Login To School</th>
                </tr>
                </thead>
                <?php $i=1;
                $i = ($start_from +1);
                while($result=mysql_fetch_array($query1)){
                    $school_id=$result['school_id'];?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        <td data-title="School ID"><?php echo $school_id; ?><br><?php echo $result['school_name'];?></td>
                      <td  data-title="School Head"><?php echo $result['name'];?><br><?php echo $result['email'];?></td>
                          <td  data-title="">
                            <?php $a=$result['coordinator_id'];
                                  
                             if($a!='')
                            {
                               
                            $sql1= mysql_query("SELECT t_email,t_complete_name FROM tbl_teacher where t_id='$a' and school_id='$school_id'");
                            $query =mysql_fetch_array($sql1);
                            $email=$query['t_email'];
                            $coordinator_name=$query['t_complete_name'];
                            echo $coordinator_name;?><br>
                            <?php echo $email;?><?php
                            }
                            else{echo "";
                            }
                            ?>
                            </td>
                      <!--   <td  data-title="School Name"><?php echo $result['school_name'];?></td> -->
                        
                        <?php
                       //  $sql1="select count(id) as no_teacher from tbl_teacher t where t.school_id='$school_id' AND t.t_emp_type_pid IN ('133','134','135','137')";
                       //  $row_teacher=mysql_query($sql1);
                       //  $results=mysql_fetch_array($row_teacher);
                       //  $sql2="SELECT COUNT(id) as no_students FROM tbl_student  where school_id='$school_id' ";
                       //  $row_student=mysql_query($sql2);
                       // $results_student=mysql_fetch_array($row_student);
                        ?><td data-title="No.of Students"><?php
                        // if($result['no_students']==0)
                        // {
                        //     echo $results_student['no_students'];
                            
                        // }
                        // else 
                        // {
                            if($result['no_students']=="")
                            {
                                echo "0";
                            }else 
                            {
                                echo $result['no_students'];
                            }
                        // }
                        ?>/<br>
                         <?php
                        //  if($result['no_teacher']==0)
                        // {
                        //     echo $results['no_teacher'];
                        // }
                        // else 
                        // {
                            if($result['no_teacher']=="")
                            {
                                echo "0";
                            }else 
                            {
                                echo $result['no_teacher'];
                            }
                             ?>
                            </td>
                            <?php 
                        //} 
                        ?>
                        <?php
                        //$sql1="SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where school_id='$school_id'";
                        
                       ?>
                        <!-- <td data-title="No.of Teachers"><?php 
                        if($result['no_teacher']=="")
                        {
                           echo "0";
                        }else 
                        {
                           echo $result['no_teacher'];
                        }?></a></td> -->
                        <td  data-title="Reg.Date"><?php
                         $date_arr=explode(' ',$result['createdon']); 
                        echo $date_arr[0];
                         
                         ?></td>
                        
                         <td  data-title="Balance Blue Points"><?php if(!empty($result['school_balance_point'])){ echo $result['school_balance_point'];} else {echo "0";}?>/<br><?php if(!empty($result['balance_blue_points'])){ echo $result['balance_blue_points'];} else {echo "0";}?></td>
                         
                        <!-- <td  data-title="Balance Points"><?php if(!empty($result['school_balance_point'])){ echo $result['school_balance_point'];} else {echo "0";}?></td> -->
                        <td > <a href="school_assignpoint.php?school_id=<?php echo $school_id;?>" style="text-decoration:none;"> <input type="button" value="Assign" name="assign"/></a></td>
                        <td ><a href="<?php echo "logingrouptoschool.php?school_id=$school_id&group_member_id=$group_member_id"?>" style="text-decoration:none;"> <input type="button" value="Login To School" name="assign"/></a></td>
                    </tr>
                    <?php  $i++;} ?>
            </table>
                </div>
                <!--Below pagination added by Rutuja for SMC-4464 on 30/01/2020-->
        <div align='left'>
                <?php if ($_GET['Search'])
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
        <div id="no-more-tables">
            <table id="example" class="col-md-12 table-bordered table-striped "  >
                <thead>
             <!-- <tr>  <?php echo $s;?></tr>  -->
                <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                    <th> Sr. No. </th>
                    <th> <?php echo $dynamic_school;?> ID /</br><?php echo $dynamic_school;?> Name</th>
                    <th> <?php echo $dynamic_school;?> Head /<br>Email </th>
                    <th> School Coordinator /<br>Email</th>
                    <th> No. of <?php echo $dynamic_student;?>/<br>No. of <?php echo $dynamic_teacher;?> </th>
                   <!--  <th> No. of <?php echo $dynamic_teacher;?> </th> -->
                    <th> Date </th>
                    <th> Balance Green Points/<br>Balance Blue Points </th>
                   <!--  <th> Balance Green Points </th> -->
                    <th> Assign </th>
                    <th> Login To School</th>
                </tr>
                </thead>
                <?php $i=1;
                $i = ($start_from +1);
                while($result=mysql_fetch_array($sql)){
                    $school_id=$result['school_id'];?>
                    
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        <td data-title="School ID"><?php echo $school_id; ?>/<br><?php echo $result['school_name'];?></td>
                        <td  data-title="School Head"><?php echo $result['name'];?>/<br><?php echo $result['email'];?></td>
                        <td  data-title="School Head">
                            <?php $a=$result['coordinator_id'];
                                
                             if($a!='')
                            {
                            $sql1= mysql_query("SELECT t_email,t_complete_name FROM tbl_teacher where t_id='$a' and school_id='$school_id'");
                            $query =mysql_fetch_array($sql1);
                            $email=$query['t_email'];
                            $coordinator_name=$query['t_complete_name'];
                            echo $coordinator_name;?> <br>
                            <?php echo $email;
                            }
                            else{echo "";}
                            ?>
                            </td>
                        <?php
                        // $std_sql="SELECT COUNT(id) as no_students FROM tbl_student  where school_id='$school_id' ";
                        // $row_student=mysql_query($std_sql);
                        // $results_student=mysql_fetch_array($row_student);
                        // $tea_sql= "SELECT COUNT(id) as no_teacher FROM tbl_teacher where school_id='$school_id' AND t_emp_type_pid IN ('133','134','135','137')";
                        // $row_teacher=mysql_query($tea_sql);
                        //     $query =mysql_fetch_array($row_teacher);
                        // echo $results_student['no_students'];
                       ?> 
                       <td data-title="No.of Students"><?php
                            if($result['no_students']==0 || $result['no_students']=="")
                                { echo "0"; }
                            else {
                             echo $result['no_students']; }
                          ?>
                         /<br><?php
                        if($result['no_teacher']=="" || $result['no_teacher']==0)
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['no_teacher'];
                        }?>
                        </td>
                        <?php
                        //$sql1="SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where group_member_id = '$group_member_id' AND school_id='$school_id'";
                        //$row_teacher=mysql_query($sql1);
                        //$results=mysql_fetch_array($row_teacher);
                       ?>
                        <!-- <td data-title="No.of Teachers"><?php 
                        if($result['no_teacher']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['no_teacher'];
                        }?></a></td> -->
                        <td  data-title="Reg.Date"><?php
                         $date_arr=explode(' ',$result['createdon']); 
                        echo $date_arr[0];
                         
                         ?></td>
                        
                        <td  data-title="Balance Points">   <?php if(!empty($result['school_balance_point'])){ echo $result['school_balance_point'];} else {echo "0";}?>/<br><?php if(!empty($result['balance_blue_points'])){ echo $result['balance_blue_points'];} else {echo "0";}?></td>
                       <!--  <td  data-title="Balance Points">  <?php if(!empty($result['school_balance_point'])){ echo $result['school_balance_point'];} else {echo "0";}?></td> -->
                        <td     > <a href="school_assignpoint.php?school_id=<?php echo $school_id;?>" style="text-decoration:none;"> <input type="button" value="Assign" name="assign"/></a></td>
                                                  
  <td >  <!-- <a href="logingrouptoschool.php?school_id=<?php echo $school_id; ?>&&group_member_id=<?php echo $group_member_id; ?>"> -->
     <a href="<?php echo "logingrouptoschool.php?school_id=$school_id&group_member_id=$group_member_id"?>" style="text-decoration:none;"> <input type="button" value="Login To School" onclick="school_login_confirm()" name="assign"/></a>
    <!-- <button type="button" value="Login To School">Login To School</button> </a> --></td> 

                    </tr>
                    <?php  $i++;} ?>
            </table>
        </div>
        <!--Below pagination added by Rutuja for SMC-4464 on 30/01/2020-->
        <div align='left'>
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
    </div>
</div>
<!-- </div>
</div> -->
</body>
</html>
<script type="text/javascript">
      function school_login_confirm(school_id,group_member_id) {
         //alert(group_member_id) ;      
          
            var answer = confirm("Are you sure,do you want to login to School");
            if (answer) {
 
                 window.location="./logingrouptoschool.php?school_id="+school_id+"&group_member_id="+group_member_id;
               }
           
        }
    </script>