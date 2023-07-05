<?php
//Created by Rutuja to Add/Edit Academic Years in CookieAdmin for SMC-4663 on 10/04/2020
include('cookieadminheader.php');
$report = "";
//$smartcookie = new smartcookie();
//$results = $smartcookie->retrive_individual($table, $fields);
//$result = mysql_fetch_array($results);
$id=$_GET['id'];
$group_member_id=$_SESSION['id']; 
$sc_id =0;
if(isset($id))
{
     $qury1 = "select * from tbl_academic_Year where id='$id'";
     //echo $qury2;
     $query1= mysql_query($qury1);
     $rows = mysql_fetch_array($query1);
     $ExtYearID = $rows['ExtYearID'];
     $Academic_Year = $rows['Academic_Year'];
     $Year = $rows['Year'];
     $Enab = $rows['Enable'];
     if($Enab==1){ 
    $Enable="Yes";
        }
    else{$Enable="No";}
}
if (isset($_POST['submit'])) {

    $ac_year_id = trim($_POST['extId']);
     $ac_year = trim($_POST['a_year']);
     $is_active = $_POST['enabled'];
    $year = trim($_POST['year']);
    $confirm_type = trim($_POST['confirm_type']);
    //$semester_type = trim($_POST['semester_type']);
if(isset($id))
{
if($ac_year_id!='')
{
if($ac_year_id!=$ExtYearID)
{
$qury2 = "select * from tbl_academic_Year where group_member_id='0' AND school_id='0' AND ExtYearID='$ac_year_id'";
     //echo $qury2;
     $query2= mysql_query($qury2);
    // $r=mysql_fetch_array($query);
     $count2=mysql_num_rows($query2);
     
    if($count2>0)
    {
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('External Year ID already present!!!Try another....');
                     window.location.href='Add_academic_year_cookieadmin.php';
                     
                    </script>";
    
    }
    else{
     
    if($is_active=='1' && $confirm_type=='Yes'){
        $qury3 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury3);
       $qury4 = "UPDATE tbl_academic_Year SET Enable='0' where school_id='0' and group_member_id='0' and Enable='1'" ;
         //echo $qury5; 
       mysql_query($qury4);
       
    }
 // echo $ac_year_id;
$qury5 = "UPDATE tbl_academic_Year SET ExtYearID='$ac_year_id',Academic_Year='$ac_year',Year='$year',Enable='$is_active' where id='$id'" ;
         echo $qury5;
       mysql_query($qury5);

   if($qury5){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record updated Successfully');
                    window.location.href='cookie_Admin_academic_year.php';
                    exit;
                    </script>";
}
}

}
else if($ac_year!=$Academic_Year)
{
   $qury6 = "select * from tbl_academic_Year where group_member_id='0' AND school_id='0' AND Academic_Year='$ac_year'";
     //echo $qury2;
     $query6= mysql_query($qury6);
    // $r=mysql_fetch_array($query);
     $count6=mysql_num_rows($query6);
     
  if($count6>0)
    {
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Academic Year already present!!!Try another....');
                    
                    </script>";
    
    }
    else{
     
    if($is_active=='1' && $confirm_type=='Yes'){
        $qury7 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury7);
       $qury8 = "UPDATE tbl_academic_Year SET Enable='0' where school_id='0' and group_member_id='0' and Enable='1'" ;
         //echo $qury5; 
       mysql_query($qury8);
       
    }
  //echo $ac_year_id;
$qury9 = "UPDATE tbl_academic_Year SET ExtYearID='$ac_year_id',Academic_Year='$ac_year',Year='$year',Enable='$is_active' where id='$id'" ;
         //echo $qury5; 
       mysql_query($qury9);

   if($qury9){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record updated Successfully');
                    window.location.href='cookie_Admin_academic_year.php';
                    </script>";
}
}
}
    else{

    if($is_active=='1' && $confirm_type=='Yes'){
   // echo "hi";
        $qury10 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury10);
       $qury11 = "UPDATE tbl_academic_Year SET Enable='0' where school_id='0' and group_member_id='0' and Enable='1'" ;
         //echo $qury5; 
       mysql_query($qury11);
       
    }
   
$qury12 = "UPDATE tbl_academic_Year SET ExtYearID='$ac_year_id',Academic_Year='$ac_year',Year='$year',Enable='$is_active' where id='$id'" ;
         //echo $qury5; 
       mysql_query($qury12);

   if($qury12){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record updated Successfully');
                    window.location.href='cookie_Admin_academic_year.php';
                    </script>";
}
     
}
  
 }
else{
if($ac_year!=$Academic_Year)
{
$qury13 = "select * from tbl_academic_Year where group_member_id='0' AND school_id='0' AND Academic_Year='$ac_year'";
     //echo $qury2;
     $query13= mysql_query($qury13);
    // $r=mysql_fetch_array($query);
     $count13=mysql_num_rows($query13);
    if($count13>0)
    {
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Academic Year already present!!!Try another....');
                    
                    </script>";
    
    }
    else{
     
    if($is_active=='1' && $confirm_type=='Yes'){
        $qury14 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury14);
       $qury15 = "UPDATE tbl_academic_Year SET Enable='0' where school_id='0' and group_member_id='0' and Enable='1'" ;
         //echo $qury5; 
       mysql_query($qury15);
       
    }
  //echo $ac_year_id;
$qury16 = "UPDATE tbl_academic_Year SET ExtYearID='$ac_year_id',Academic_Year='$ac_year',Year='$year',Enable='$is_active' where id='$id'" ;
         //echo $qury5; 
       mysql_query($qury16);

   if($qury16){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record updated Successfully');
                    window.location.href='cookie_Admin_academic_year.php';
                    </script>";
}
}
}
    else{
     
    if($is_active=='1' && $confirm_type=='Yes'){
        $qury17 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury17);
       $qury18 = "UPDATE tbl_academic_Year SET Enable='0' where school_id='0' and group_member_id='0' and Enable='1'" ;
         //echo $qury5; 
       mysql_query($qury18);
       
    }
  //echo $ac_year_id;
$qury19 = "UPDATE tbl_academic_Year SET ExtYearID=NULL,Academic_Year='$ac_year',Year='$year',Enable='$is_active' where id='$id'" ;
         //echo $qury5; 
       mysql_query($qury19);

   if($qury19){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record updated Successfully');
                    window.location.href='cookie_Admin_academic_year.php';
                    </script>";
}
}
}      
}
//insert
else
{
if($ac_year_id!='')
{
$qury20 = "select * from tbl_academic_Year where group_member_id='0' AND school_id='0' AND ExtYearID='$ac_year_id'";
     //echo $qury2;
     $query20= mysql_query($qury20);
    // $r=mysql_fetch_array($query);
     $count20=mysql_num_rows($query20);
     $qury21 = "select * from tbl_academic_Year where group_member_id='0' AND school_id='0' AND Academic_Year='$ac_year'";
     //echo $qury2;
     $query21= mysql_query($qury21);
    // $r=mysql_fetch_array($query);
     $count21=mysql_num_rows($query21);
    if($count20>0)
    {
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('External Year ID already present!!!Try another....');
                     window.location.href='Add_academic_year_cookieadmin.php';
                     
                    </script>";
    
    }



     
  elseif($count21>0)
    {
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Academic Year already present!!!Try another....');
                    
                    </script>";
    
    }
    else{

    if($is_active=='1' && $confirm_type=='Yes'){
    //echo "hi";
        $qury22 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury22);
       $qury25 = "UPDATE tbl_academic_Year SET Enable='0' where school_id='0' and group_member_id='0' and Enable='1'" ;
         //echo $qury5; 
       mysql_query($qury25);
       
    }
   

$qury26 = "INSERT INTO tbl_academic_Year (ExtYearID,Academic_Year,Year,school_id,Enable,group_member_id) VALUES ('$ac_year_id','$ac_year','$year','0','$is_active','0')" ;
         //echo $qury6; exit;
       mysql_query($qury26);
  
    if($qury26){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record inserted Successfully');
                    window.location.href='cookie_Admin_academic_year.php';
                    </script>";
}    
}
  
 }
else{
$qury27 = "select * from tbl_academic_Year where group_member_id='0' AND school_id='0' AND Academic_Year='$ac_year'";
     //echo $qury2;
     $query27= mysql_query($qury27);
    // $r=mysql_fetch_array($query);
     $count27=mysql_num_rows($query27);
    if($count27>0)
    {
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Academic Year already present!!!Try another....');
                    
                    </script>";
    
    }
    else{
     
    if($is_active=='1' && $confirm_type=='Yes'){
        $qury28 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury28);
       $qury29 = "UPDATE tbl_academic_Year SET Enable='0' where school_id='0' and group_member_id='0' and Enable='1'" ;
         //echo $qury5; 
       mysql_query($qury29);
       
    }
   
//if($ac_year_id==""){$ac_year_id=0;}
$qury30 = "INSERT INTO tbl_academic_Year (Academic_Year,Year,school_id,Enable,group_member_id) VALUES ('$ac_year','$year','0','$is_active','0')" ;
        // echo $qury30; 
       mysql_query($qury30);
  
    if($qury30){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record inserted Successfully');
                    window.location.href='cookie_Admin_academic_year.php';
                    </script>";
}
}
}      

}
    
}

  
?>
            <script type="text/javascript">

function valid() {
    //alert('hi');
        var extId = document.getElementById("extId").value;
        var pattern = /^[0-9 ]+$/;
        if(extId.trim()=="" || extId.trim()==null)
        {
           
        }
        else{
        if (pattern.test(extId)) {
            //alert("Your your Academic Year is : " + ExtCourseLevelID);
           // return true;
        }
        else{
        alert("It is not valid External year Id !");
        return false;
        }  
        }   
        var a_year = document.getElementById("a_year").value;
        var pattern =/^[0-9 -]+$/;
        if (pattern.test(a_year)) {
            //alert("Your your Academic Year is : " + a_year);
           // return true;
        }
        else{
        alert("It is not valid Academic Year!");
        return false;
        }
        var year = document.getElementById("year").value;
       
       var pattern = /^[0-9]+$/;
        if (pattern.test(year)) {
            //alert("Your your Academic Year is : " + year);
           // return true;
        }
        else{
        alert("It is not valid  Year!");
        return false;
        }
        //validations for enabled year added by Pranali for bug SMC-3554
        var enabled = document.getElementById("enabled");
        if(enabled.value == '-1'){
            alert("Please Select if year is Enabled or not!");
            return false;   
        }
        
        
        
}
</script>
<html>
    <head>

    </head>
    <body>
        <div class="container" style="padding:25px;" >

                <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

                   <form method="post">

                   <div class="row">

                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" ></div>

                         <div class="col-md-3 " align="center" style="color:#663399;" >

                                <h2><?php if(isset($id)){?>Update<?php } else {?>Add<?php }?> Academic Year</h2>

                               <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                                 <br><br>
                         </div>

                     </div>


          <!--     <div class="row formgroup" style="padding:5px;" >

                   <div class="col-md-3 col-md-offset-4">
-->                     
                        <div class="row">
                        <div class="col-md-4"><input type="hidden" name="yid" value="<?php echo $_GET['ExtYearID']?>" /></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">External Year ID:<span style="color:red;font-size: 25px;"></span></div>
                    <div class="col-md-3">
                        <input type="text" name="extId" class="form-control " id="extId" placeholder="Enter ID" value="<?php if(isset($id)){ echo $ExtYearID;}else{}?>">

                   </div>
                    <br><br/>  
                        
                    <div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year:<span style="color:red;font-size: 25px;">*</span></div>
                    <div class="col-md-3">
                        <input type="text" name="a_year" class="form-control " id="a_year" placeholder="eg. 2020-2021" value="<?php if(isset($id)){ echo $Academic_Year;}else{}?>" maxlength="10" required>

                   </div>

                   <br/><br/>

              <!--      <div class="col-md-3 col-md-offset-4">  -->
                        
                    <div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;"> Current Year:<span style="color:red;font-size: 25px;">*</span></div>
                    <div class="col-md-3">
                        <input type="text" name="year" class="form-control " id="year" placeholder="eg. 2020" value="<?php if(isset($id)){ echo $Year;}else{}?>" maxlength="4" required>

                   </div>
                   <br><br/> 
                   <!--Enabled Year added by Pranali for bug SMC-3554 -->
                  
                   <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:382px;"> Enabled :<span style="color:red;font-size: 25px;">*</span></div>
                        <div class="col-md-5">
                        
                            <select name="enabled" id="enabled" class="form-control" style="width:255px;">            
                            <option value="<?php $n=-1; if(isset($id)){ echo $Enab;}else{echo $n;}?>"><?php if(isset($id)){ echo $Enable;}else{ echo "Choose";}?></option>
                            <?php if(isset($id)){?>
                            <?php if($Enable=="Yes"){?>
                            <option value="0" >No </option>
                        <?php }else{?>
                            <option value="1" >Yes</option>
                        <?php }?>
                    <?php }else{?>
                        <option value="1" >Yes</option>
                        <option value="0" >No </option>
                    <?php } ?>
                            </select>
                        </div>
                    <br/>

                    <div class="row" id="isconfirm" style="padding-top:30px; display: none;">
                
                <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:390px;"> Are you sure you want to disable the previously enabled years?<span style="color:red;font-size: 25px;">*</span></div>
                       <div class="col-md-3" id="isconfirm_type" style="margin-right: :2%;width: 24.5%">
            </div> 
        </div>
             <!--changes end for bug SMC-3554  -->
                   <div class="col-md-3 col-md-offset-4">

                   </div>

                    <!--<br/><br/>
-->


                 


                  <div id="error" style="color:#F00;text-align: center;" align="center"></div>
                    </br></br>
                   <div class="row" style="padding-top:15px;">

                  <div class="col-md-2 col-md-offset-4 " >

                    <input type="submit" class="btn btn-primary" name="submit" value="<?php if(isset($id)){ echo 'Update';}else{echo 'Add';}?>" style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                    </div>

                     <div class="col-md-3 "  align="left">

                   <a href="cookie_Admin_academic_year.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                   </div>

                     <div class="row" style="padding-top:15px;">

                     <div class="col-md-4">

                     <input type="hidden" name="count" id="count" value="1">

                     </div>

                      <div class="col-md-11" style="color:#FF0000;" align="center" id="error">



                      <?php echo $errorreport;?>

                        </div>
                         <div class="col-md-11" style="color:#063;" align="center" id="error">



                      <?php echo $successreport;?>

                        </div>



                    </div>




                  </form>

          </div>
          </div>

         

<script type="text/javascript">
    $(document).ready(function(){
    //     $("#ac_year").datepicker();

        $("#enabled").change(function(){
            var isAct = $(this).val();
            if(isAct=="1"){
                $("#isconfirm").css("display","block");
                $("#isconfirm_type").html("<select name='confirm_type' id='confirm_type' class='form-control' required><option value='No'>No</option><option value='Yes'>Yes </option></select>");
            }else{
                $("#isconfirm").css("display","none");
                $("#isconfirm_type").html("");
            }
        });
    });
</script>
    </body>
</html>