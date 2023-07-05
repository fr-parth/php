<?php
include('scadmin_header.php');
$report="";
/*$id=$_SESSION['id'];
$fields=array("id"=>$id);
$table="tbl_school_admin";*/

$smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$_SESSION['school_id'];
$academic_sesn_yr=$_SESSION['AcademicYear'];
define('max_res_per_page',10);

if($academic_sesn_yr == 'All'){
  $sqln3=mysql_query("SELECT  COUNT(*) as id1 FROM `tbl_class_subject_master` WHERE `school_id` ='$sc_id'");
  }
  else{
    $sqln3=mysql_query("SELECT  COUNT(*) as id1 FROM `tbl_class_subject_master` WHERE `school_id` ='$sc_id' and academic_year='$academic_sesn_yr'"); 
  }
      
      $my_var=mysql_fetch_array($sqln3);
      $total= $my_var['id1'];

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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"> 
<link rel="stylesheet" href="css/bootstrap.min.css"> 
<script src="jquery.js"></script> 
<script src="jquery.dataTables.js"></script> 
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script> 
    
  <style> 
@media only screen and (max-width: 800px) {  
    #no-more-tables table, 
    #no-more-tables thead, 
    #no-more-tables tbody, 
    #no-more-tables th, 
    #no-more-tables td, 
    #no-more-tables tr { 
        display: block; 
    } 
    #no-more-tables thead tr { 
        position: absolute; 
        top: -9999px; 
        left: -9999px; 
    } 
    #no-more-tables tr { border: 1px solid #ccc; } 
    #no-more-tables td { 
        border: none; 
        border-bottom: 1px solid #eee; 
        position: relative; 
        padding-left: 50%; 
        white-space: normal; 
        text-align:left; 
        font:Arial, Helvetica, sans-serif; 
    } 
    #no-more-tables td:before { 
        position: absolute; 
        top: 6px; 
        left: 6px; 
        padding-right: 10px; 
        white-space: nowrap; 
    } 
    #no-more-tables td:before { content: attr(data-title); } 
}

</style> 
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
           window.location.assign('list_class_subject.php?page='+page+'&school_id=<?php echo $school_id; ?>' );
       });
   });
</script>
<script>

function confirmation(id)
{
  if(window.confirm("Are you sure you want to delete?"))
  {
    $.ajax({
    url: "deleteclass_sub.php",
    type:'post',
    data:({id:id}),
    success: function(result){
      if(result == true)
      {
        alert('Record Deleted Successfully');
        
      }
      else {
        alert('Error In Deletion');
      }
  }
})
  }
  
}

</script>

<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Untitled Document</title> 
</head>
 
        <script> 
              $(document).ready(function() {

                $('#example').dataTable( {
                  "paging":   false,
                  "searching": true,
                  "info":false,
                  "scrollCollapse": true
                } );
  //commented below code by Pranali for SMC-5084
            
//             $(".btn_edit").click(function(){
//                var id = $(this).attr("user_id") 
              
//                         $.ajax({
//                                  url:"update_class_subject.php",
//                                  type:"POST",
//                                  data:{id:id}, //this is formData 
//                                  async: false,
//                                  dataType:"json",     
//                                    success:function(data)
//                                    {  
//                                         $("#u_id").val(id);
// //                                        $("#subject_code").val(data.subject_code);  
// //                                        $("#subject_name").val(data.subject_name);
// //                                        $("#subject_type").val(data.subject_type);
// //                                        $("#subject_short_name").val(data.subject_short_name);
// //                                        $("#semester_id").val(data.semester_id);
// //                                        $("#semester").val(data.semester);                                      
//                                         $("#branch_id").val(data.branch_id);
//                                         $("#branch").val(data.branch);
//                                         $("#dept_id").val(data.dept_id);
//                                         $("#department").val(data.department);
//                                         $("#school_id").val(data.school_id);
// //                                        $("#course_level").val(data.course_level);
// //                                        $("#academic_year").val(data.academic_year);
// //                                        $("#academic_yearID").val(data.academic_yearID);
//                                         $("#uploaded_by").val(data.uploaded_by);
                                        
//                                    }
//                          }); 
//             });
                  
                  
                                         // $('#update_form').submit(function(e){ 
                                         //       e.preventDefault(); 
                                             
                                         //            $.ajax({
                                         //                 url:'insertUpdatedDate_Class_Subject.php',
                                         //                 type:"POST",
                                         //                 data:new FormData(this), //this is formData
                                         //                 processData:false,
                                         //                 contentType:false,
                                         //                 cache:false,
                                         //                 async:false,
                                         //                  success: function(data){
                                         //                      alert(data);
                                         //                      //$('form').unbind("submit").submit();   
                                         //                       window.location.href = 'list_class_subject.php'; 
                                         //                       $('#update_form')[0].reset();
                                         //                      //$("#updateModal").hide();
                                         //                      //show_data();
                                         //               }
                                         //         });
                                             
                                         //      }); 
  
                } );
//Added below javascript function update_class_subject() for SMC-5084
function update_class_subject(k) {

var form = $("#update_form"+k)[0]; // You need to use standard javascript object here
var formData = new FormData(form);

                                           $.ajax({
                                                         url:'insertUpdatedDate_Class_Subject.php',
                                                         type:"POST",
                                                         data: formData, //this is formData
                                                         processData:false,
                                                         contentType:false,
                                                         cache:false,
                                                         async:false,
                                                          success: function(data){
                                                              alert(data);
                                                              //$('form').unbind("submit").submit();   
                                                              // window.location.href = 'list_class_subject.php'; 
                                                               $("#update_form"+k)[0].reset();
                                                              //$("#updateModal").hide();
                                                              //show_data();
                                                       }
                                    });
}
        </script>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC"> 

<div class="container" style="padding:30px;" >

          <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
 
                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

                       <a href="Add_class_subject.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Class Subject" style="font-weight:bold;font-size:14px;"/></a>

                     </div>

                     <div class="col-md-6 " align="center"  >

                          <h2>Class Subject List </h2>

                     </div> 
                     </div>

               <div class="row" style="padding:10px;" > 
             <div class="col-md-12  " id="no-more-tables" > 
   

    <table id="example" class="display" width="100%" cellspacing="0">

        <thead> 
            <tr> 

              <!--Added  Sr. No by Pranali for SMC-5084-->
              <th> Sr. No </th>
                <th>Class</th>

                <!--<th>Teacher ID</th>   -->

                <th>Subject Code</th>

                <th>Subject Name</th>

                <th>Semester</th>

                <th>Branch/Department</th>

                <th>Edit</th> 
                <th>Delete</th> 
            </tr>

        </thead>
        <tbody>
        	
            <?php
            $i= $start+1;
            
                  if($academic_sesn_yr == 'All')
                         {
                         $sql_sp = "SELECT * FROM `tbl_class_subject_master` WHERE `school_id` ='$sc_id' LIMIT $start,10";
                        }
                         else
                         {
                         $sql_sp = "SELECT * FROM `tbl_class_subject_master` WHERE `school_id` ='$sc_id' and academic_year='$academic_sesn_yr' LIMIT $start,10";
                        }
                  $query = mysql_query($sql_sp);
                  $k=1;
                  while($row=mysql_fetch_assoc($query))
                  {
                      
                       
            ?> 
                  <tr>
                    <td> <?php echo $i; ?></td>
                      <td>
                        <!--SMC-5006 by Pranali : solved issue of class not displaying -->
                          <?= $row['class']; ?>
                      </td>
                      <td>
                          <?php echo $row['subject_code']; ?>
                      </td>
                      <td>
                          <?php echo $row['subject_name']; ?>
                      </td>
                      <td>
                          <?php echo $row['semester']; ?>
                      </td>
                      <td>
                          <?php echo $row['branch'] .'<br>'. $row['department']; ?>
                      </td>
                        <td>
                          <!-- <a href="" user_id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-id3="<?php echo $row['id']; ?>" class="btn btn-primary btn_edit" name="btn_edit" id="btn_edit<?= $k;?>" data-toggle="modal" data-target="#updateModal<?= $k;?>">Edit</a>-->
                          <a href="" user_id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-id3="<?php echo $row['id']; ?>" id="btn_edit<?= $k;?>" data-toggle="modal" data-target="#updateModal<?= $k;?>"><span class="glyphicon glyphicon-pencil"></span></a>
                          
<!--Displayed modal inside table and displayed all dropdowns hierarchy wise by Pranali for SMC-5084-->
<div id="updateModal<?= $k;?>" class="modal fade">
    <div class="modal-dialog"> 
        <form id="update_form<?= $k;?>" onsubmit="update_class_subject(<?php echo $k; ?>)" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="btn btn-primary btn-lg">Update Class Subject</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                </div>
				
                <div class="modal-body"> 
                    <label>Course Level</label>
 
                     <select class="form-control" id="course_level<?= $k;?>" name="course_level" >
                        
                <?php  
                      $sql3 = "select CourseLevel from tbl_CourseLevel where school_id='$sc_id'";
                      $query3 = mysql_query($sql3);
                      while($rows2=mysql_fetch_assoc($query3))
                      { 
                ?>
                     
                        <option <?php if($row['course_level']==$rows2['CourseLevel']){ echo "selected"; } ?> value="<?php echo $rows2['CourseLevel'];?> "><?php echo $rows2['CourseLevel'];?></option>
                        
               <?php } ?> 
                        
                    </select> 
                    
                    <br/>

                    <label>Department</label>
                    <input type="text" class="form-control" id="department<?= $k;?>" name="department" value="<?=  $row['department'] ?>" disabled>
                    <br/> 
                    
                    <label>Branch</label>
                    <input type="text" class="form-control" id="branch<?= $k;?>" name="branch" value="<?= $row['branch'] ?>" disabled>
                    <br/>

                    <label>Academic Year</label>
 
                <select class="form-control" id="academic_year<?= $k;?>" name="academic_year" >
                        
                <?php  
                      $sql4 = "select Academic_Year,Year from tbl_academic_Year where school_id='$sc_id' and Enable=1";
                      $query4 = mysql_query($sql4);
                      while($rows3=mysql_fetch_assoc($query4))
                      { 
                ?>
                     
                        <option <?php if($row['academic_year']==$rows3['Academic_Year']){ echo "selected"; } ?> value="<?php echo $rows3['Academic_Year'];?>,<?php echo $rows3['Year'];?> "><?php echo $rows3['Academic_Year'];?></option>
                        
               <?php } ?> 
                        
                    </select> 
                    
                    <br/>

                    <label>Semester</label>
 
                      <select class="form-control" id="semester<?= $k;?>" name="semester" >
                              
                      <?php  
                      //Modified semester query by Pranali for SMC-5084
                             $sql2 = "select Semester_Name,Semester_Id from tbl_semester_master where school_id='".$sc_id."' and Branch_name='".$row['branch']."' and Department_Name='".$row['department']."' and CourseLevel='".$row['course_level']."'";
                            $query2 = mysql_query($sql2);
                            while($rows1=mysql_fetch_assoc($query2))
                            { 
                      ?> 
                              <option <?php if($row['semester']==$rows1['Semester_Name']){ echo "selected"; } ?> value="<?php echo $rows1['Semester_Name'];?>,<?php echo $rows1['Semester_Id'];?>"><?php echo $rows1['Semester_Name'];?></option>
                              
                     <?php } ?> 
                              
                      </select>  
                    <br/> 
                    

                    <label>Subject Name</label>
                    <select class="form-control" id="subject_name<?= $k;?>" name="subject_name" >
                        
                <?php  
                      $sql1 = "select subject,Subject_Code,Subject_type,Subject_short_name,Uploaded_by,batch_id from tbl_school_subject where school_id='$sc_id'";
                      $query1 = mysql_query($sql1);
                      while($rows=mysql_fetch_assoc($query1))
                      { 
                ?>
                     
                        <option <?php if($row['subject_name']==$rows['subject']){ echo "selected"; } ?> value="<?php echo $rows['subject'];?>,<?php echo $rows['Subject_Code'];?>,<?php echo $rows['Subject_type'];?>,<?php echo $rows['Subject_short_name'];?>,<?php echo $rows['Uploaded_by'];?>,<?php echo $rows['batch_id'];?>"><?php echo $rows['subject'];?></option>
                        
               <?php } ?> 
                        
                    </select> 
                    
                    <br/> 
                     
                      
                </div>
                <div class="modal-footer">
                  <!--Displayed value for user_id field by Pranali for SMC-5084-->
                    <input type="hidden" id="u_id<?= $k;?>" value="<?php echo $row['id']; ?>" name="user_id">
                    <input type="submit" name="updateClassSubject" id="action1<?= $k;?>" value="Update" class="btn btn-success" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div> 
            
        </form>
         
    </div>
</div>
                            
           </td>
           <td>            
<!-- created by intern Priyanka Rakshe on 23-04-2021 for  delete option button-->
					 <a href="" onClick="confirmation(<?php echo $row['id']; ?>)"><span class="glyphicon glyphicon-trash"></span> </a>
                        </td>
                  </tr>
                  <?php $i++;?>
                 <?php $k++; } ?> 

        </tbody> 
    </table>
    <div align='center'>
  <?php 
      if ($end >$total){ $end=$total;}
      if($total==0){ $start=$start-1;}
      echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start +1)." to ".($end)." records out of ".($total). " records.</font></style></div>";
  ?>
<div class="container">
  <nav aria-label="Page navigation">
  <ul class="pagination" id="pagination"></ul>
  </nav>
</div>
</div>

                  </div> 
                  </div> 
                        
                   <div class="row" style="padding:5px;">

                   <div class="col-md-4">

               </div>

                  <div class="col-md-3 "  align="center"> 

                   

                   </div>

                    </div>

                     <div class="row" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-3" style="color:#FF0000;" align="center">

                      <?php echo $report;?>

                    </div>
                    </div>
               </div>
               </div>
    </div></div>
</body>

</html>
    