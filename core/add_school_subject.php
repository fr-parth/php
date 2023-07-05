<?php
//Merging of two files add and edit done by Sayali Balkawade for id SMC-4196 
$report="";
$report1="";
 include('scadmin_header.php');
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
       $table="tbl_school_admin";
       
       $smartcookie=new smartcookie();
       
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];


if($_GET["subject"]=='')
{
  //add
if(isset($_POST['submit']))
{   
  $subcode = $_POST['subcode'];
  $subject= mysql_real_escape_string($_POST['subject']);
  $subtype = $_POST['subtype'];
  $subshortname =  mysql_real_escape_string($_POST['subshortname']);
  $ExtSchoolSubjectId = $_POST['ExtSchoolSubjectId'];
  $subCredit = $_POST['subCredit'];
  
  if($_POST['ExtSchoolSubjectId']!='')
  {
    
  
  
  $sql= mysql_query("select Subject_Code,ExtSchoolSubjectId from tbl_school_subject where school_id='$school_id' and (Subject_Code ='$subcode' or ExtSchoolSubjectId ='$ExtSchoolSubjectId')");
  

  
 $result=mysql_num_rows($sql);
if($result==0)
{

//Below

$query=mysql_query("insert into tbl_school_subject (subject,school_id,Subject_Code,Subject_type,Subject_short_name,ExtSchoolSubjectId,subject_credit) values('$subject','$school_id','$subcode','$subtype','$subshortname','$ExtSchoolSubjectId','$subCredit')");

// echo "insert into tbl_school_subject (subject,school_id,Subject_Code,Subject_type,Subject_short_name,ExtSchoolSubjectId,subject_credit) values('$subject','$sc_id','$subcode','$subtype','$subshortname','$ExtSchoolSubjectId','$subCredit')" ;exit;

//$succesreport="$branch_name is successfully inserted";
echo ("<script LANGUAGE='JavaScript'>
  alert('$dynamic_subject is successfully inserted');
  window.location.href='list_school_subject.php';
        </script>");

}

else{
  echo "<script>alert('Record already present') </script>";
  
}


  
  }
  
  
  
            
}



?>


<html>
<head>
<script>



 function valid()
{
          var subname = document.getElementById("subject").value;
      var subcode = document.getElementById("subcode").value;
            var subtype = document.getElementById("subtype").value;
            var subsn = document.getElementById("subshortname").value;
            var ExtSchoolSubjectId = document.getElementById("ExtSchoolSubjectId").value;
          
         
    
    
    regx1=/^[A-z ]+$/;
    
    
    if(subname.trim()==""||subname.trim()==null )
      {
         
        document.getElementById('errsubname').innerHTML='Please Enter <?php echo $dynamic_subject;?>';
        
        return false;
      }
      else{
        document.getElementById('errsubname').innerHTML='';
      }
      
        

    regx1=/^[A-z0-9- ]+$/;

    if(subcode.trim()==""||subcode.trim()==null )
      {

        document.getElementById('errsubcode').innerHTML='Please enter <?php echo $dynamic_subject;?> code';
        
        return false;
      }
      else if(!regx1.test(subcode))
      {
        document.getElementById('errsubcode').innerHTML='Please enter valid  <?php echo $dynamic_subject;?> code';
        
        return false;
        }else{
        document.getElementById('errsubcode').innerHTML='';
      }
        
        
          
          
      
      
      regx1=/^[a-zA-Z0-9!@#$&()-`.+,]+$/;
    
    if(ExtSchoolSubjectId.trim()==""||ExtSchoolSubjectId.trim()==null )
      {
         
        document.getElementById('errorSubID').innerHTML='Please enter <?php echo $dynamic_subject;?> ID';
        
        return false;
      }
      else if(!regx1.test(ExtSchoolSubjectId))
      {
        document.getElementById('errorSubID').innerHTML='Please enter valid  <?php echo $dynamic_subject;?> ID';
        
        return false;
        }else
        {
        document.getElementById('errorSubID').innerHTML='';
        }
/*        
    
*/
}
 
 
 


</script>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
            <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <form method="post">
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >
                   
                     </div>
                     <div class="col-md-4 " align="center" style="color:#663399;" >
                          
                          <h2>Add <?php echo $dynamic_subject;?> </h2>
                     </div>
                         
                     </div>
            
                  
                    <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject; ?> Name:<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <input type="text" name="subject"  id="subject" placeholder="Enter <?php echo $dynamic_subject; ?> Name" value="<?php if(isset($_POST['subject'])){ echo $_POST['subject'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errsubname" style="color:#FF0000"></div></div>
                  
          
          
           <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject; ?> Code:<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <input type="text" name="subcode"  id="subcode" placeholder="Enter <?php echo $dynamic_subject; ?> Code" value="<?php if(isset($_POST['Subject_Code'])){ echo $_POST['Subject_Code'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errsubcode" style="color:#FF0000"></div></div>
                  
          
           <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject; ?> ID:<span style="color:red;font-size: 25px;">*</span></div>
               
               <div class="col-md-3">
             <input type="text" name="ExtSchoolSubjectId"  id="ExtSchoolSubjectId" placeholder="Enter <?php echo $dynamic_subject;  ?> ID" value="<?php if(isset($_POST['ExtSchoolSubjectId'])){ echo $_POST['ExtSchoolSubjectId'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errorSubID" style="color:#FF0000"></div></div>
                  
               
                  
          <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject; ?> Credits:</div>
               
               <div class="col-md-3">
             <input type="text" name="subCredit"  id="subCredit" placeholder="Enter <?php echo $dynamic_subject; ?> Credits" value="<?php if(isset($_POST['subject_credit'])){ echo $_POST['subject_credit'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errorSubCredit" style="color:#FF0000"></div></div>
           
           
           
           
           <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject; ?> Type:</div>
               
               <div class="col-md-3">
             <input type="text" name="subtype"  id="subtype" placeholder="Enter <?php echo $dynamic_subject; ?> Type" value="<?php if(isset($_POST['Subject_type'])){ echo $_POST['Subject_type'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errsubtype" style="color:#FF0000"></div></div>
           
           
            <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject; ?> Short Name:</div>
               
               <div class="col-md-3">
             <input type="text" name="subshortname"  id="subshortname" placeholder="Enter <?php echo $dynamic_subject; ?> Short Name" value="<?php if(isset($_POST['Subject_short_name'])){ echo $_POST['Subject_short_name'];}?>" class="form-control"/>
             </div>
                
              
                  </div>
                   <div class="row"><div class="col-md-4 col-md-offset-5" id="errsubsn" style="color:#FF0000"></div></div>
           
          
          
          
                   <div class="row" style="padding-top:40px;">
                   <div class="col-md-2">
               </div>
                  <div class="col-md-1 col-md-offset-3 "  >
                    <input type="submit" class="btn btn-primary" name="submit" value="Add "  onClick="return valid()" style="width:100%;"/>
                    </div>
                     <div class="col-md-3 "  align="left">
        <a href="list_school_subject.php" style="text-decoration:none;">
    <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:30%;"  /></a>
                    </div>
                   
                   </div>
                   
                     <div class="row" style="padding-top:30px;">
                  
                      <div class="col-md-4 col-md-offset-4 "  align="center" id="error">
                       <div style="color:#FF0000;">
                      <?php echo $report;?>
                      </div>
                       <div style="color:#093"><?php echo $succesreport;?></div>
                    </div>
                       
                 
                    </div>
                       </div>
                </form>
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>
<?php } else { ?>

<?php
$report = "";
//Edit
// include("scadmin_header.php");
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
  {
    $sc_id1=$_SESSION['school_id']; 
    $query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id1'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
    
    
  }
  else
  {
    $id = $_SESSION['id'];
  }
  
//$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
if (isset($_GET["subject"])) {
    $subject_id = $_GET['subject'];
    //echo "select * from tbl_school_subject where id='$subject_id' and school_id='$sc_id'";
    $sql1 = "select * from tbl_school_subject where id='$subject_id' and school_id='$school_id'";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
    $id = $arr['id'];
    $subject = $arr['subject'];
    $branchName = $arr['Branch_ID'];
    $Subject_Code = $arr['Subject_Code'];
    $course_level = $arr['Course_Level_PID'];
    $semester = $arr['Semester_id'];
    $Subject_type = $arr['Subject_type'];
  $Subject_short_name = $arr['Subject_short_name'];
  $ExtSchoolSubjectId = $arr['ExtSchoolSubjectId'];
  $subject_credit = $arr['subject_credit']; 
  $Year = $arr['Year'];


    if (isset($_POST['submit'])) {
        $SubjectCode = $_POST['Subject_Code']; 
        $subjectName = $_POST['subject'];
        $BranchName = $_POST['BranchName'];
        $course_level = $_POST['course_level'];
        $Year = $_POST['Year'];
    $subtype = $_POST['Subject_type'];
    $subshortname = $_POST['Subject_short_name']; 
      $ExtSchoolSubjectId1 = $_POST['ExtSchoolSubjectId']; 
    $subCredit = $_POST['subject_credit'];
    
    
if($subject == $subjectName)
{
  

  $r = "update tbl_school_subject set Subject_Code='$SubjectCode', subject='$subjectName',Subject_type='$subtype',Subject_short_name='$subshortname',ExtSchoolSubjectId='$ExtSchoolSubjectId1',subject_credit='$subCredit' where id='$id' and school_id='$school_id'";
  //echo "<script>alert('123') </script>";

}
else
{
$sql1 = mysql_query("select * from tbl_school_subject where subject='$subjectName' and (school_id='$school_id')");
$count=mysql_num_rows($sql1);


if ($count > 0) 
{
  
  
    echo "<script>alert('Record already present') </script>";
}

else
{
    $r = "update tbl_school_subject set Subject_Code='$SubjectCode', subject='$subjectName', Subject_type='$subtype',Subject_short_name='$subshortname',ExtSchoolSubjectId='$ExtSchoolSubjectId1',subject_credit='$subCredit' where id='$id' and school_id='$school_id'"; 
}
}
    
  if($r!='')
  {
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_school_subject.php';
                        </script>");
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
  }
  
}

$r = mysql_query("select * from tbl_school_subject where id='$subject_id' and school_id='$school_id'");

if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
}

    
    

      /*  $sql3 = "update tbl_school_subject set Subject_Code='$Subject_Code', subject='$subject', Course_Level_PID='$course_level',Branch_ID='$BranchName', Year_ID='$Year' where id='$id' and school_id='$sc_id'";
        if (mysql_query($sql3)) {
      echo ("<script LANGUAGE='JavaScript'>
          alert('Record Updated Successfully..!!');
          window.location.href='list_school_subject.php';
          </script>");
          //  echo "Records  updated successfully.";
        } else {
      echo '<script type="text/javascript"> alert("ERROR: Could not able to execute") </script>';
           // echo "ERROR: Could not able to execute ";
        }
    }*/ ?>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
        <script>
            function valid() {
                var subject = document.getElementById("subject").value;
        if(subject.trim()==""||subject.trim()==null )
                 {
                    document.getElementById('error').innerHTML = 'Please Enter <?php echo $dynamic_subject;?>';
                    return false;
                }
                regx = /^[0-9]*$/;
                //validation of subject
                if (regx.test(subject)) {
                    document.getElementById('error').innerHTML = 'Please Enter valid <?php echo $dynamic_subject;?>';
                    return false;
                }
            }
        </script>
    </head>
    <body align="center">
    <div class="container" style="padding:10px;" align="center">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="container" style="padding:25px;">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div class="row"
                                 style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                                <h2>Edit <?php echo $dynamic_subject; ?></h2>
                            </div>
                            <div class="row ">

                                 <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?><span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="subject" id="subject" class="form-control" style="width:120%; padding:5px;" placeholder="Enter <?php echo $dynamic_subject; ?>" value="<?php echo $subject; ?>"/>
                                </div>
                <br/><br/>
                <br/><br/>
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> code</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Subject_Code" id="Subject_Code" class="form-control" style="width:120%; padding:5px;" placeholder="Enter <?php echo $dynamic_subject; ?>Code" value="<?php echo $Subject_Code; ?>" /readonly>
                                </div>
                <br/><br/>
                <br/><br/>
                   <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="ExtSchoolSubjectId" id="ExtSchoolSubjectId" class="form-control" style="width:120%; padding:5px;" placeholder="Enter <?php echo $dynamic_subject; ?>" value="<?php echo $ExtSchoolSubjectId; ?>"/readonly>
                                </div>
                <br/><br/>
                <br/><br/>
                
                
                   <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> Credits</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="subject_credit" id="subject_credit" class="form-control" style="width:120%; padding:5px;" placeholder="Enter <?php echo $dynamic_subject; ?>" value="<?php echo $subject_credit; ?>"/>
                                </div>
                
                <br/><br/>
                <br/><br/>
                   <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> Type</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Subject_type" id="Subject_type" class="form-control" style="width:120%; padding:5px;" placeholder="Enter <?php echo $dynamic_subject; ?>" value="<?php echo $Subject_type; ?>"/>
                                </div>
                
                <br/><br/>
                <br/><br/>
                   <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> Short Name</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Subject_short_name" id="Subject_short_name" class="form-control" style="width:120%; padding:5px;" placeholder="Enter <?php echo $dynamic_subject; ?>" value="<?php echo $Subject_short_name; ?>"/>
                                </div>
                
                <br/><br/>
                <br/><br/>

                               
                            </div>

              
              
              
                            

              

                            <div class="row ">
                                <div class="col-md-8 form-group col-md-offset-3" id="error" style="color:red;"><?php echo $report; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-2" style="padding:10px;">
                                    <input type="submit" name="submit" class='btn-lg btn-primary' style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="Submit" onClick="return valid()"/>
                                </div>
                                <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                                    <a href="list_school_subject.php"><input type="button" class='btn-lg btn-danger' name="Back" value="Back" style="width:100%;background-color:##FF0000; color:#FFFFFF;"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php } ?>

<?php } ?>
