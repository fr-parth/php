<?php
include("groupadminheader.php");
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];
$res2 = mysql_query("select distinct(is_accept_terms) from tbl_school_admin");

if(isset($_POST['submit'])=='Search'){
 
$country=$_POST['country'];
$state=$_POST['state'];
$city=$_POST['city'];
$school_id=$_POST['school_id'];


if($country!='')
{
   if($country=='105')
    {
      $country1='91';
    }
    else
    {
        $country1=$country;
    }
        
    $cond .= "and sa.CountryCode='$country1'";
}

if($state!='')
{
   $sql1= mysql_query("SELECT * FROM tbl_state where state_id='$state' order by state asc");
   $a1=mysql_fetch_array($sql1);

   $c=$a1['state'];
   $state1=$c;
   $cond .= "and sa.scadmin_state='$c'";
}

if($city!='')
{
   $cond .= "and sa.scadmin_city='$city'";
}

if($school_id!='')
{
  $cond .="and sa.school_id='$school_id'";
  
}
if($country!='' || $school_id!='')
{
 
$qr="SELECT sa.school_id,sa.school_name,sa.scadmin_country,sa.scadmin_city,sa.scadmin_state FROM tbl_school_admin sa
WHERE sa.school_id NOT IN      
(SELECT sg.school_id 
 FROM tbl_group_school sg WHERE group_member_id='$group_member_id') $cond";
}
else
{
  ?><script type="text/javascript">
    alert("Please search college by country or school id")
  </script><?php
}
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
    <title></title>
    
   </head>
 <script>
     $(document).ready(function() {
        $('#example').dataTable({});  

 });
</script>
<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">
    <div class="container-fluid" style="padding:30px;width:1152px">
       

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div style="color:#700000 ;padding:5px;" >
                       <div class="col-md-12">
                         <div class="col-md-1">
                           <a  href="coll_group_school_list.php" value="" name="" class="btn btn-primary">Back</a>
                        </div>
                        <div class="col-md-11 " align="center">
                            <h2>List of School Not in <?php echo $group_name1; ?></h2>
                        </div>
                      
                    </div>
                    </div>
                         
                </div>
               
                <div class="clearfix"></div>
                <br>
                
                <form method="post" id="myform">
                    
                   
                   <div class="row">
                     <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Country:</label>
                                <div class="col-sm-8" id="typeedit">
              
                                    <select class="form-control" name="country" id="country" >
                                      <option value=''>Select</option>
                                    <?php
                                     $sql2 = mysql_query("select * from tbl_country where is_enabled='1'");
      
                  while($result2 = mysql_fetch_array($sql2)){ ?>
                  
                                    <option value="<?php echo $result2['country_id']; ?>"  <?php if($result2['country_id']==$country){?> selected="selected" <?php }?>><?php echo $result2['country']; ?></option>
                  
                 <?php  echo $result2; }?>
                                  </select> 
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">State:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select name='state' id='state' class='form-control'>
                 <?php if($state !=''){?>
                   <option value='<?php echo $state;?>'><?php echo $c; ?></option>
                 <?php } else {?>
                 <option value=''>Select</option>
                 <?php }?>                 
                   
                </select>
                 
                                </div>
                            </div> 
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">City:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select class="form-control" name="city" id="city" >
                                   
                                    <?php if($city !=''){?>
                   <option value='<?php echo $city;?>'><?php echo $city; ?></option>
                 <?php } else {?>
                  <option value="">All</option>
                 <?php }?>    
                                   
                                  </select>
                                </div>
                            </div> 
                        </div>
                      
                             <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">School ID</label>
                                <div class="col-sm-8" id="typeedit">
                                  <input type="text" id="school_id1" name="school_id" value="<?php echo $school_id;?>" class="form-control">
                                </div>
                            </div> 
                             </div>


                           
           </div>
          

            <div class="col-md-1" >
            <button type="submit"  value="Search" name="submit" class="btn btn-primary">Search</button>
            </div>
      
               
                   
                         </form>
                      
                     </div>
                    <div class="row" style="display:<?php if($_POST['submit']=='Search'){echo 'block'; }else{echo 'none';}?>" >
                        <div class="col-md-12  " id="no-more-tables">
                      
                        <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                <thead>
                                <tr style="background-color:#428BCA">
                                 <th> Sr. No.</th>
                                 <th>School ID </th>
                                 <th>School Name </th>
                                 <th> City </th>
                                 <th> State </th>
                                 <th> Country</th>
                                 <th> Add to Group</th>
          
          
                                </tr>
                                </thead>
                              
                                     <tbody id="ajaxRecords">
                                <?php
                  $i=1;                 
                                    $arr = mysql_query($qr);

                                    // $as=mysql_fetch_array($arr);
                                    // print_r($as);die;
                                   
                                   while ($row = mysql_fetch_array($arr)) {

                                                   ?>
                                 <tr>
                <td data-title="Sr.No" ><b><?php echo $i;  ?></b></td>
                <td data-title="Teacher ID" ><b><?php echo $row['school_id']; ?></b></td>               
                <td data-title="Teacher ID" ><b><?php echo $row['school_name']; ?></b></td>
                <td data-title="Teacher ID" ><b><?php echo $row['scadmin_city']; ?></b></td>
                <td data-title="Sr.No" ><b><?php echo $row['scadmin_state'];  ?></b></td>
                <td data-title="Sr.No" ><b><?php echo $row['scadmin_country'];  ?></b></td>
              <!--   <td data-title="Sr.No" href="group_school_list.php?id="<?php echo $row['school_id'];?> ><button  class="btn btn-primary danger">Add to Group</button></td>
               -->    
               <?php 
                 echo "<td><a class='btn btn-primary' href='coll_group_school_list.php?id=".$row['school_id']."'>Add To Group</a></td>"; 
               ?>   
                  </tr>
                            <?php $i++;?>
                            <?php }
                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </div>
</body>
   
</html>
<script type="text/javascript">
  function validateForm() {
  var x = document.forms["myform"]["country"].value;
  var y = document.forms["myform"]["school_id1"].value;

  if (x == "" && y == "") {
    alert("Search by Country or School Id");
    return false;
  }
}
</script>

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
  
</script>
