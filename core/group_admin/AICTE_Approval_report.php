<?php
include("groupadminheader.php");
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];

//$res2 = mysql_query("select distinct(is_accept_terms) from tbl_school_admin");
    

$cond =" where gs.group_member_id= '$group_member_id' and ";
$order_by="sa.school_name";

if(isset($_POST['submit']) || isset($_GET['page']) ){
  if(isset($_POST['submit'])){
    session_start();
$status=$_POST['status'];
$country=$_POST['country'];
$state=$_POST['state'];
$city=$_POST['city'];
$aicte_id=$_POST['aicte_id'];
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];
$gpp=$_POST['group_name'];
$_SESSION["status"]=$status;
$_SESSION["country"]=$country;
$_SESSION["state"]=$state;
$_SESSION["city"]=$city;
// $_SESSION["aicte_id"]=$aicte_id;
$_SESSION["from_date"]=$from_date;
$_SESSION["to_date"]=$to_date;
$_SESSION["group_name"]=$gpp;
  }else{
$status=$_GET['status'];
$country=$_GET['country'];
$state=$_GET['state'];
$city=$_GET['city'];
$aicte_id=$_GET['aicte_id'];
$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];
$gpp=$_GET['group_name'];
  }

$g = explode(",",$gpp);
$group_member_id =$g[0];
$group_name=$g[1];
  
$arr=[];





if($group_member_id!='')
{
  if($group_member_id=='All')
  {
    $cond = " where ";
  }
  else
  {
    $cond =" where gs.group_member_id= '$group_member_id' and ";

  }
  // $group_member_id='91';
  // $arr['CountryCode']=$country1;
}

if($country!='')
{
    $country1='91';
  // $arr['CountryCode']=$country1;
  $cond .= " sa.CountryCode='$country1'";

}
if($state!='')
{
   $sql1= mysql_query("SELECT * FROM tbl_state where state_id='$state' order by state asc");
   $a1=mysql_fetch_array($sql1);

   $c=$a1['state'];
   $state1= $a1['state_id'];
  // $arr['scadmin_state']=$c;
 
  $cond .= " and sa.scadmin_state='$c'";
}


if($city!='')
{
   //$arr['scadmin_city']=$city;
 $cond .= " and sa.scadmin_city='$city'";
}

if($from_date!='' && $to_date!='')
{


   $cond .= " and sa.accept_terms_date>='$from_date 00:00:00' and sa.accept_terms_date<='$to_date 23:59:59'";
   $order_by = "sa.accept_terms_date";
}

if($status!='' && $status!='2')

{
  $cond .= " and sa.is_accept_terms='$status'";
  //$arr['is_accept_terms']=$status;
}


//print_r($arr);die;
 define('max_res_per_page',10);
 $sqls="SELECT
        * from tbl_state where country_id= '$country'";
        $arrs = mysql_query($sqls);
        $row1 = mysql_fetch_array($arrs);


       $sqln3=mysql_query("SELECT  COUNT(*) as id1 FROM tbl_school_admin sa join tbl_group_school gs on gs.school_id = sa.school_id $cond order by $order_by");
       $my_var=mysql_fetch_array($sqln3);
       $total= $my_var['id1'];

if(isset($_POST['submit'])){
                  $_GET['page']=0;
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
     
      
       $sqln1= "SELECT * FROM tbl_school_admin sa join tbl_group_school gs on gs.school_id = sa.school_id $cond order by $order_by LIMIT $start  , 10  ";
  
    }
?>
<?php if (isset($_POST['submit'])){?>
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

            window.location.assign('AICTE_Approval_report.php?page='+page+'&status=<?php echo $status; ?>&country=<?php echo $country; ?>&state=<?php echo $state1; ?>&city=<?php echo $city; ?>&group_name=<?php echo $group_member_id; ?>' );
        });
    });
</script>
<?php }else{
    ?>
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
            window.location.assign('AICTE_Approval_report.php?page='+page +'&status=<?php echo $status; ?>&country=<?php echo $country; ?>&state=<?php echo $state1; ?>&city=<?php echo $city; ?>&group_name=<?php echo $group_member_id; ?>');
             });
    });
</script>
<?php }?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/select2.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->

<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />
<!-- 


<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />
 -->
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
            padding-right: 10px;
            white-space: nowrap;
        }
        /*
        Label the data
        */
        #no-more-tables td:before {
            content: attr(data-title);
        }
    }

    /*for loader*/
    .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie:Send SMS/EMAIL</title>
    
    <style type="text/css">
  .popup {
    width:200px;
    height:100px;
    position:absolute;
    top:50%;
    left:50%;
    margin:-50px 0 0 -100px; /* [-(height/2)px 0 0 -(width/2)px] */
    display:none;
  }
</style> 

</head>

 <script>
    $(document).ready(function() {
       $('#example').dataTable({
          "paging":   false,
          "searching": true,
          "info":false,
          "scrollCollapse": true
       });    
    });
      $(function () {
            $("#from_date").datepicker({
               // changeMonth: true,
                //changeYear: true
        dateFormat: 'yy-mm-dd',
      maxDate:0
            });
        });
        $(function () {
            $("#to_date").datepicker({
                //changeMonth: true,
                //changeYear: true,
        dateFormat: 'yy-mm-dd',
        maxDate:0
            });
        });


    function valid(){
  
  var from = document.getElementById("from_date").value;
  var myDate = new Date(from);
  var today = new Date();
                   
 
  if(myDate.getFullYear() > today.getFullYear()) {

        alert('Please select valid from date');
        return false;

  }
  else if(myDate.getFullYear() == today.getFullYear()) {

      if (myDate.getMonth() == today.getMonth()) {
                                
          if (myDate.getDate() > today.getDate()) {

              alert('Please select valid from date');
              return false;
          }                    
          
      }

  else if (myDate.getMonth() > today.getMonth()) {
      alert('Please select valid from date');
      return false;

  }                
          
  }          
          
  var to = document.getElementById("to_date").value;
  var myDate1 = new Date(to);
  var today1 = new Date();
                    
    
 
  if(myDate1.getFullYear() > today1.getFullYear()) {

         alert('Please select valid to date');
          return false;
      
    }
    else if(myDate1.getFullYear() == today1.getFullYear()) {

      if (myDate1.getMonth() == today1.getMonth()) {
                                
          if (myDate1.getDate() > today1.getDate()) {
          
            alert('Please select valid to date');
            return false;
        }
                                
        
    }

    else if(myDate1.getMonth() > today1.getMonth()) {
      alert('Please select valid to date');
      return false;

    }
                            
  }

    if(myDate.getFullYear() > myDate1.getFullYear())
    {
      alert('Start Date should be less than End Date');
      return false;
    }

    else if(myDate.getFullYear() == myDate1.getFullYear())
    {
        if(myDate.getMonth() == myDate1.getMonth()){

          if(myDate.getDate() > myDate1.getDate()) {

          alert('Start Date should be less than End Date');
          return false;
          }
          
        }
        else if (myDate.getMonth() > myDate1.getMonth()) {
          alert('Start Date should be less than End Date');
          return false;

        }
                            
    }
  
}


</script>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC" align="center">
    <div class="container-fluid" style="padding:30px;width:1152px">
       

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div style="color:#700000 ;padding:5px;" >
                        
                      
                        <div  align="center">

                            <h2 align="center">Activation Report on College Status by State/City</h2>

                        </div>
                         </div>
                         
                     </div>
               
                <div class="clearfix"></div>
                <br>
                <form method="post" id="myform">
                    </div>
                    <br>
                    <div class="row">
           <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Country:</label>
                                <div class="col-sm-8" id="typeedit">
              
              <?php $sql2 = mysql_query("select * from tbl_country where is_enabled='1'");
              
            ?>
                                  <select class="form-control" name="country" id="country" >
                                     
                             <option value=''>Select Country</option>
                             <?php 
                              while($result2 = mysql_fetch_array($sql2)){ ?>
                  
                                    <option value="<?php echo $result2['country_id']; ?>"  <?php if($result2['country_id']==$country){?> selected="selected" <?php }?>><?php echo $result2['country']; ?></option>
                  
                 <?php  }?>
                                  </select> 
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">State:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select name='state' id='state' class='form-control searchselect'>
                 <?php if($state !=''){?>
                   <option value='<?php echo $state1;?>'><?php echo $c; ?></option>
             
                        <?php 
                        $query=mysql_query("SELECT st.state as state_name, st.state_id as state_id
                            FROM tbl_state st  where st.country_id ='$country' and st.state!='$c'
                            group by st.state ORDER BY st.state ");
                         while ($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['state_id'] ?>"><?php echo $row['state_name'] ?></option><?php }?>

                 <?php } else {?>
                 <option value=''>All</option>
                 <?php }?>                 
                   
                </select>
                 
                                </div>
                            </div> 
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">City:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select class="form-control searchselect" name="city" id="city" >
                                   
                                    <?php if($city !=''){?>
                             <option value='<?php echo $city;?>'><?php echo $city; ?></option>
                             <?php 
                        $query=mysql_query("SELECT cc.state_id as city_state_id,cc.sub_district as city_sub_district FROM tbl_city cc  where cc.state_id='$state1'
                            and cc.sub_district!='$city' group by cc.sub_district ORDER BY cc.sub_district ");
                         while ($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['city_sub_district'] ?>"><?php echo $row['city_sub_district'] ?></option><?php }?>
                           <?php } else {?>
                            <option value="">All</option>
                           <?php }?>    
                                   
                                  </select>
                                </div>
                            </div> 
                        </div>
                      </div>
<br>
<div class="row">
                         <div class="col-md-4">

                          
                            <div class="form-group">
                           <label for="type" class ="control-label col-sm-4"> From Date </label>
                           <div class="col-sm-8">
                           <input type="text" id="from_date" name="from_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php echo $from_date; ?>" autocomplete="off">
                       </div>
                    </div>
                          
               </div>

        <div class="col-md-4">
                    <div class="form-group">
                        <label for="type" class ="control-label col-sm-4">To Date</label>
          
                        <div class="col-sm-8">
                      <input type="text" id="to_date" name="to_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php echo $to_date; ?>" autocomplete="off">
                  </div>

                    </div> 
                </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Activated</label>
                                <div class="col-sm-8" id="typeedit">
                                <select name="status" id="colname" class="form-control">
                                  
                            
                                
                              <option value="1" <?php if($status == '1' ){?> selected="selected" <?php }?> > Yes </option> 
                              <option value="0" <?php if($status == '0' ){?> selected="selected" <?php }?> > No </option>
                              <option value="2" <?php if($status == '2' ){?> selected="selected" <?php }?> > All </option>
                         
                        </select>
                                </div>
                            </div> 
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="type" class ="control-label col-sm-4">Group Name</label>
              
                                <div class="col-sm-8">
                                  <select name="group_name" id="group_name" class="form-control searchselect"  >
                                  <option value="" disabled selected>All</option>
                                  <option value="All" >All</option>
                                  <?php 
                                    if(isset($_POST['submit']))
                                    {?>
                                      <option value="<?php echo $group_member_id.','.$group_name ?>"selected><?php if($group_name!=''){ echo $group_name.'-'.$group_member_id ;} else{ echo "All" ;} ?></option>
                                   <?php  } ?>
                                  <?php
                                  $gp = mysql_query("SELECT distinct(group_member_id),group_mnemonic_name FROM tbl_group_school where group_mnemonic_name!=''");
                                  while($rr = mysql_fetch_array($gp)){?>
                                  <option value="<?php echo $rr['group_member_id'].','.$rr['group_mnemonic_name'] ?>"><?php echo $rr['group_mnemonic_name'].'-'.$rr['group_member_id'] ?></option>
                                    <?php } ?>
                                  </select>
                              </div>

                            </div> 
                          </div>
                        </div>

        <br>
                <br>
            <div align="center">

              <button type="submit" value="Reset" id="reset1" style="" name="reset" class="btn btn-danger" onclick="window.open('AICTE_Approval_report.php','_self')" >Cancel</button>&nbsp&nbsp&nbsp&nbsp
              <button type="submit" value="Search" name="submit" class="btn btn-primary" onclick="return valid()">Search</button>&nbsp&nbsp&nbsp&nbsp
             <a href="csv_AICTE_approvals.php">
                                        <button type="button" class="btn btn-info" name="export">Export to CSV</button>
                                   </a>
                                
            </div>
            <br>
           
      </form>
     </div>
           
</div>


</div>
<div class="container-fluid" style="padding:30px;width:1152px">
<?php if(isset($_POST['submit']) || isset($_GET['page']) ){ ?>
<h3>Group : <?php if($group_name!=''){ echo $group_name ;} else{ echo "All" ;}  ?></h3>
                            <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                                <thead>
                               <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:19px">
                                 <th> Sr. No.</th>
                  <th>School ID /Name / <br>City, State </th>
                  <th> Is Activated / <br>Activation Date </th>


                  <th> No. of Files Uploaded </th>
                  <th> Percentage Completed</th>
                  <th> ORG Structure</th>
                  <th> Data Uploaded </th>
                  <th> Subject</th>
                  <th> Teacher / <br>Teacher-Sub</th>
                  <th> Student /<br> Student-Sub /<br> Student-Sem</th>

          <th>Co-Ordinater Email</th>
           <th>Admin Email</th>
                                </tr>
                                </thead>
                              
                                     <tbody id="ajaxRecords">
                                <?php
                  $i= $start+1;                 
                                    $arr = mysql_query($sqln1);

                                    while ($row = mysql_fetch_array($arr)) {
                                    $teacher_id = $row['id'];
                                    $no_of_file=0;
                                    $org_str =0;
                ?>
                                <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
              <td data-title="Sr.No" ><b><?php echo $i;  ?></b></td>
                <td data-title="Teacher ID" ><b><?php echo $row['school_id'].'<br>'.$row['school_name']; ?></b>

                  <hr><?php echo $row['scadmin_city'] .", ". $row['scadmin_state'];?>
                </td>
                             <td data-title="Name" ><?php if($row['is_accept_terms']=='1'){echo "Yes";}else{echo "No";};?>

                              <hr>
                                    
                                    <?php if($row['is_accept_terms']=='1'){echo date("Y-m-d", strtotime($row['accept_terms_date']));}else{echo "";};?>

                            </td>
                           

                                <?php  //1
                                $s1="SELECT count(CourseLevel) FROM tbl_CourseLevel
                                WHERE school_id='".$row[school_id]."'";
                                 $r1 = mysql_query($s1);
                                 $r2=mysql_fetch_array($r1);
                                 if ($r2[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 }              
                 ?>               

              
                         <?php  //2
                         $sqlDeg = "SELECT count(id) FROM tbl_degree_master
                                 WHERE school_id='".$row[school_id]."'"; 
                                 $rowD = mysql_query($sqlDeg);
                                 $resultD = mysql_fetch_array($rowD);
                                 
                                 if ($resultD[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 }  

                 ?>
             

                                 <?php //8
                                 $sqlyear = "SELECT count(Academic_Year) 
                                 FROM tbl_academic_Year
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowyear = mysql_query($sqlyear);
                                 $resultyear = mysql_fetch_array($rowyear);

                                 
                                 if ($resultyear[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 } 
                         ?>

                  <?php  //3
                                 $sqlDept = "SELECT count(Dept_Name) 
                                 FROM tbl_department_master
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowDept = mysql_query($sqlDept);
                                 $resultDept = mysql_fetch_array($rowDept);
                                 
                                 if ($resultDept[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 } 
                                 
                 
                 ?>

               <?php  //4
                                 $sqlbranch = "SELECT count(branch_Name) 
                                 FROM tbl_branch_master
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowbranch = mysql_query($sqlbranch);
                                 $resultbranch = mysql_fetch_array($rowbranch);
                                 if ($resultbranch[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 } 
                
                                 ?>

                 <?php  //5
                                 $sqlclass = "SELECT count(class) 
                                 FROM Class
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowclass = mysql_query($sqlclass);
                                 $resultclass = mysql_fetch_array($rowclass);


                                 if ($resultclass[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 } 
                       
                                 ?>
              


                        <?php  //13
                        $sqlcsub = "SELECT count(subject_code) 
                        FROM tbl_class_subject_master
                        WHERE school_id='".$row[school_id]."'";
                        $rowcsub = mysql_query($sqlcsub);
                        $resultcsub = mysql_fetch_array($rowcsub);


                        if ($resultcsub[0] !=0){
                          $no_of_file++;
                            
                      } 
                        
                        ?>
               

                 <?php //6
                                 $sqldivision = "SELECT count(DivisionName) 
                                 FROM Division
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowdivision = mysql_query($sqldivision);
                                 $resultdivision = mysql_fetch_array($rowdivision);

                                 if ($resultdivision[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 } 
                         
                         ?>
                  
                 <?php  //12

                        $sqlbsub = "SELECT count(SubjectCode) 
                        FROM Branch_Subject_Division_Year
                        WHERE school_id='".$row[school_id]."'";
                        $rowbsub = mysql_query($sqlbsub);
                        $resultbsub = mysql_fetch_array($rowbsub);


                        
                        if ($resultbsub[0] !=0){
                                  $no_of_file++;
                                    
                                 } 
                        ?>


                      <?php   //9
                                 $sqlsem = "SELECT count(Semester_Name) 
                                 FROM tbl_semester_master
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowsem = mysql_query($sqlsem);
                                 $resultsem = mysql_fetch_array($rowsem);

                         
                            if ($resultsem[0] !=0){
                                  $no_of_file++;
                                    
                                 } 
                       ?>     
                
                        <?php //7
                                 $sqlsubject = "SELECT count(subject) 
                                 FROM tbl_school_subject
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowsubject = mysql_query($sqlsubject);
                                 $resultsubject = mysql_fetch_array($rowsubject);


                                 
                            
                            if ($resultsubject[0] !=0){
                                  $no_of_file++;
                                    $org_str++;
                                 } 
                         ?>
                     
                    
                    <?php //10

                                 $sqltea = "SELECT count(t_id) 
                                 FROM tbl_teacher
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowtea = mysql_query($sqltea);
                                 $resulttea = mysql_fetch_array($rowtea);                             
                       
                             if ($resulttea[0] !=0){
                                  $no_of_file++;
                                    
                                 }  
                                 ?>
                                 
                 
            

                          <?php //11
                                 $sqlteasub = "SELECT count(tch_sub_id) FROM tbl_teacher_subject_master
                                 WHERE school_id='".$row[school_id]."'";
                                 $rowteasub = mysql_query($sqlteasub);
                                 $resultteasub = mysql_fetch_array($rowteasub);
                                

                                 if ($resultteasub[0] !=0){
                                  $no_of_file++;
                                    
                                 }  
                        
                        ?>
                    
                        <?php   //14
                        $sqlstud = "SELECT count(std_PRN) 
                        FROM tbl_student
                        WHERE school_id='".$row[school_id]."'";
                        $rowstud = mysql_query($sqlstud);
                        $resultstud = mysql_fetch_array($rowstud);
                        
                        if ($resultstud[0] !=0){
                          $no_of_file++;
                            
                         } 
                        ?>
               
              
                        <?php   //16
                        $sqlstudsub = "SELECT count(subjcet_code) 
                        FROM tbl_student_subject_master
                        WHERE school_id='".$row[school_id]."'";
                        $rowstudsub = mysql_query($sqlstudsub);
                        $resultstudsub = mysql_fetch_array($rowstudsub);
                        
                        if ($resultstudsub[0] !=0){
                          $no_of_file++;
                            
                         } 
                        ?>
                
               
           
                        <?php   //15
                        $sqlstudsem = "SELECT count(student_id) 
                        FROM StudentSemesterRecord  
                        WHERE school_id='".$row[school_id]."'";
                        $rowstudsem = mysql_query($sqlstudsem);
                        $resultstudsem = mysql_fetch_array($rowstudsem);
                        

                        if ($resultstudsem[0] !=0){
                          $no_of_file++;
                            
                         } 
                        ?>
             
                
             
                        <?php   //17
                        $sqlparent = "SELECT count(id) 
                        FROM tbl_parent
                        WHERE school_id='".$row[school_id]."'";
                        $rowparent = mysql_query($sqlparent);
                        $resultparent = mysql_fetch_array($rowparent);
                        
                        if ($resultparent[0] !=0){
                          $no_of_file++;
                            
                         }
                        ?>

                         <?php 
          $sqlparent = "SELECT t_email 
                        FROM tbl_teacher r
                        INNER JOIN tbl_school_admin t on r.t_id=t.coordinator_id
                        WHERE r.school_id='".$row[school_id]."'";
                        //echo $sqlparent ; exit;
                        $rowparent = mysql_query($sqlparent);
                        $resultparent1 = mysql_fetch_array($rowparent);
                       
                        if ($resultparent1[0] !=0){
                          $no_of_file++;
                            
                         }

                        ?> 
                
 
        <td> <?php  echo $no_of_file; ?></td>
        <td> <?php
            if ($no_of_file >=15)
            {
              echo "100%";
            } 
            else
            {
              $percent = round(($no_of_file / 15) * 100, 2);
              echo $percent ."%";
            }

            ?>
        </td>
        <td>
          <?php 

             if ($org_str == 8)
             {
              echo "Complete";
             }
             elseif ($org_str == 0)
             {
              echo "No Data";
             }
             else
             {
              echo "Partial";
             }
            ?>
        </td>
        <td> <?php 
          if ($no_of_file >= 15)
             {
              echo "Complete ";
             }
             elseif ($no_of_file == 0)
             {
              echo "No Data";
             }
             else
             {
              echo "Partial ";
             }
         ?> </td>
        <td> <?php echo $resultsubject[0]; ?> </td>
        <td> <?php echo $resulttea[0]; ?> 
        <hr> <?php echo $resultteasub[0]; ?> </td>
        <td> <?php echo $resultstud[0]; ?> 
        <hr> <?php echo $resultstudsub[0]; ?> 
        <hr> <?php echo $resultstudsem[0]; ?> </td>

         <td> <?php echo $resultparent1[0]; ?> </td>
        <td> <?php echo $row['email']; ?> </td>
        
                      </tr>

                            <?php $i++;?>
                            <?php } ?>
                            
                                </tbody>
                            </table>
  <div align='left'>
  <?php 
  if ($_GET['Search'])
  {
      if ($end >$total){ $end=$total;}
      echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start +1)." to ".($end)." records out of ".$total. " records.</font></style></div>";
  }else
  {
      if ($end >$total){ $end=$total;}
      echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start +1)." to ".($end)." records out of ".($total). " records.</font></style></div>";
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

</body>
   
</html>


<style>
th, td {

  text-align: center;
}
</style>

<!--
<style> 

@media screen and (min-width: 768px) { 
  .modal fade:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
   
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  margin-left: -35%;
  width: 70%;
}
</style>-->
<!-- <script>
  $(".aicte_pagination").on('click',function(){
    
    var page_no = $(this).val();
    var status='<?php echo $_POST['status']; ?>';
    var country='<?php echo $_POST['country']; ?>';
    var state='<?php echo $_POST['state']; ?>';
    var city='<?php echo $_POST['city']; ?>';
    var aicte_id='<?php echo $_POST['aicte_id']; ?>';
    var from_date='<?php echo $_POST['from_date']; ?>';
    var to_date='<?php echo $_POST['to_date']; ?>';
    var group_name='<?php echo $_POST['group_name']; ?>';
    $.ajax({
      url : "AICTE_Approval_report_pagination.php",
      data : { page : page_no,status:status,country:country,state:state,city:city,aicte_id:aicte_id,from_date:from_date,to_date:to_date,group_name:group_name },
      type : "POST",
      success : function(data){
        alert("hi");
        $("#example").html(data);
      }

    });
  });
</script> -->
<script type="text/javascript">
  $("#country").change(function(){
    
    var c_id = $(this).val();
    $.ajax({
      url : "country_state_city.php",
      data : { c_id : c_id },
      type : "POST",
      success : function(data){
        $("#state").html(data);
      }

    });
  });

  // $("#country").change(function(){
    
  //   var c_id = $(this).val();
  //   $.ajax({
  //     url : "aicte_data.php",
  //     data : { c_id : c_id },
  //     type : "POST",
  //     success : function(data){
  //       $("#college").html(data);
  //     }

  //   });
  // });

 
  
</script>
<script type="text/javascript">
  $("#state").change(function(){
    
    var s_id = $(this).val();
    // work_categoy=work_category.split('#');
    // var cat_id = work_category[0];
    
    $.ajax({
      url : "country_state_city.php",
      data : { s_id : s_id },
      type : "POST",
      success : function(data){
        $("#city").html(data);
      }

    });
  });

 
   $("#college").change(function(){
    
    var college_id = $(this).val();
    // work_categoy=work_category.split('#');
    // var cat_id = work_category[0];
    
    $.ajax({
      url : "aicte_data.php",
      data : { college_id : college_id },
      type : "POST",
      success : function(data){
        $("#college_data").html(data);
      }

    });
  });

  $(document).ready(function() {
    $('.searchselect').select2();

});
</script>