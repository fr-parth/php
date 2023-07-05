<?php
include("groupadminheader.php");
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];
$schoolres = mysql_query("select school_id,school_name from tbl_school_admin where group_member_id = '$group_member_id' order by school_name");
if (($_GET['Search']))
{
     if($_GET['startlmt']!="" && $_GET['endlmt']!=""){
            $start=((int)$_GET['startlmt']-1);
            
        }
        else if($_GET['startlmt']!="" && $_GET['endlmt']==""){
            $Limit= "LIMIT ".$_GET['startlmt'];
        }
        else{$Limit= "";}

    if (isset($_GET["spage"])){ $spage  = $_GET["spage"]; } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;
$searchq=$_GET['Search'];
$School_id=$_GET['school_id'];
 if ($School_id == 'all')
    {
        $School_id=$_GET['school_id'];
        
    }
    elseif ($School_id != '' && $School_id!='all')
    {
        $s_query="SELECT id,std_PRN,std_complete_name,std_phone,std_email,school_id FROM tbl_student where group_member_id = '$group_member_id' AND school_id = '$School_id' LIMIT $start_from, $webpagelimit";
        $sql=mysql_query($s_query) or die("could not Search!");
                    
        $sql1 ="SELECT id from tbl_student where group_member_id = '$group_member_id' AND school_id = '$School_id'"; 
                    $rs_result = mysql_query($sql1);  
                    $row1 = mysql_num_rows($rs_result);  
                    $total_records = $row1;  
                    $total_pages = ceil($total_records / $webpagelimit);
    }


                    if($total_pages == $spage){
                    $webpagelimit = $total_records;
                    }else{
                    $webpagelimit = $start_from + $webpagelimit;
                    }
                     
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Smart Cookie:Send SMS/EMAIL</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<script src="../js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />
<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
    "paging":   false,
    "info":false,
    "searching": false,
     "scrollCollapse": true

    } );
} );
    </script>
<?php if (isset($_GET['Search'])){?>
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
            window.location.assign('export_student.php?school_id=<?php echo $School_id;?>&Search=<?php echo $searchq; ?>&spage='+page);
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
        <div style="padding-top:50px;">
            <h2 style="padding-left:20px; margin-top:2px;color:#666">Student's List</h2>
        </div>
        <div class='row'>
        <form style="margin-top:5px;" method="get">
            <div class="col-md-4">
              <div class="form-group">
                <label for="type" class ="control-label col-sm-3">Select School<span style="color:red;">*</span>:</label>
                  <div class="col-sm-9" id="typeedit">
                    <select class="form-control searchselect" id="scl_id" name="school_id" required>
                      <option value="">School Name</option>
                       <option value="all" <?php if($_GET['school_id']=='all'){?>selected="selected" <?php }?>>All</option>
                      <?php while($sc_row= mysql_fetch_array($schoolres)){ ?>
                        <option value="<?php echo $sc_row['school_id']; ?>" <?php if($sc_row['school_id']==$_GET['school_id']){echo 'selected'; } ?>><?php echo $sc_row['school_name']." (".$sc_row['school_id'].")"; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                    <label for="type" class ="control-label col-sm-6">Start From:</label>
                    <div class="col-sm-6" id="typeedit">
                        <input type="number" class="form-control" name="startlmt" id="startlmt" <?php if(isset($_GET['startlmt'])){ echo "value=".$_GET['startlmt']; }?> min="1">    
                    </div>
                </div>
            <div class="col-md-3">
                <label for="type" class ="control-label col-sm-6">Record Limit:</label>
                <div class="col-sm-6" id="typeedit">
                    <input type="number" class="form-control" name="endlmt" id="endlmt" <?php if(isset($_GET['endlmt'])){ echo "value=".$_GET['endlmt']; }?> min="1">    
                </div>
            </div> 
              <div class="col-md-1" >
                <button type="submit" name="Search" value="Search" class="btn btn-primary">Search</button>
              </div>
              <div class="col-md-1" id="sch_id" >
                <!-- <input type="button" class="btn btn-info" value="Reset" onclick="window.open('export_teachers.php','_self')" /> -->
                        <?php if(isset($_GET['Search'])){?><a href="csv_export_student.php?gid=<?= $group_member_id;?>&sid=<?= $_GET['school_id'];?>&slmt=<?= $_GET['startlmt'];?>&elmt=<?= $_GET['endlmt']?>" class="btn btn-success">Export to CSV</a>  <?php } ?>
                
              </div>
              <div class="col-md-1" id="all1">
                
                       <a href="csv_export_student.php?gid=<?= $group_member_id;?>&sid=<?= $_GET['school_id'];?>&slmt=<?= $_GET['startlmt'];?>&elmt=<?= $_GET['endlmt']?>" class="btn btn-success">Export to CSV</a>                
              </div>
          </form>
          </div><br> 
          
                    <div class="row">   
        <?php
        if (isset($_GET['Search']))
        {
            $count=mysql_num_rows($sql);
            if($count == 0){
                echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";
            }
            else
            {
            ?>
            <div id="no-more-tables">
            <?php $i = 0; ?>
            <table id="example" class="col-md-10 table-bordered table-striped table-condensed cf" >
                <thead>
                 <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                    <th> Sr. No.</th>
                    <th> Student Name </th>
                    <th> School Name </th>
                    <th> Email ID </th>
                    <th> Student PRN </th>
                    <th> Mobile </th>
                    
                 </tr>
                </thead>
                <?php
                    $i = ($start_from +1);
                     while ($row = mysql_fetch_array($sql)) {
                        $Sc_id = $row["school_id"];
                        $sc_query="SELECT school_name FROM tbl_school_admin where school_id = '$Sc_id'";
                        // echo $sc_query; exit;
                        $sc_query1=mysql_query($sc_query) or die("could not Search!");
                        $sc_row = mysql_fetch_row($sc_query1);
                    ?>
                    <tr> 
                        <td data-title="Sr.No" ><b><?php echo $i; ?></b></td>
                        <td data-title="Teacher ID" ><b><?php echo $row['std_complete_name']; ?></b></td>
                        <td data-title="Name" ><?php echo $sc_row[0];?></td>
                        <td data-title="Phone" ><?php echo $row['std_email']; ?> </td>
                        <td data-title="Phone" ><?php echo $row['std_PRN']; ?> </td>
                        <td data-title="Phone" ><?php echo $row['std_phone']; ?> </td>
                        
                    </tr>
                            <?php $i++;
                            } ?>
            </table>
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
            <table class="col-md-10 table-bordered table-striped table-condensed cf"  >
                <thead>
                <tr style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                    <th> Sr. No.</th>
                    <th> Student Name </th>
                    <th> School Name </th>
                    <th> Email ID </th>
                    <th> Student PRN </th>
                    <th> Mobile </th>
                    
                </tr>
                </thead>
                   <tr>
                        <td colspan="6" class="text-center">Please select and search by School Name </td>
                     
                    </tr>
                      
            </table>
        </div>
    <?php }?>
    </div>
    </div>
</div>

<script>
    $(document).ready(function(){
      $('.searchselect').select2();
    });

</script>

<script type="text/javascript">
     $(document).ready(function(){
              
        $("#all1").hide();
       $("#sch_id").show();
        $('#scl_id').on('change', function() {
      if ( this.value == 'all')
      {
        $("#all1").show();
        $("#sch_id").hide();
      }
      if ( this.value != 'all')
      {
        $("#all1").hide();
        $("#sch_id").show();
      }
      
      
    });
});
         </script>
</body>
</html>
<style>
.modal fade {
  text-align: center;
}


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
</style>