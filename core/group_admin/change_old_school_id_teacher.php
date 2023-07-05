<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>

<?php
include("../conn.php");

$group_member_id = $_SESSION['group_admin_id'];
$sql=mysql_query("SELECT old_school_id,school_id,school_name,email,mobile
FROM tbl_school_admin where group_member_id='$group_member_id' and old_school_id IS NOT NULL and old_school_id!='' and old_school_id!=school_id");
// echo"SELECT old_school_id,school_id 
// FROM tbl_school_admin where group_member_id='$group_member_id' and old_school_id IS NOT NULL and old_school_id!='' and old_school_id!=school_id";

$sql1=mysql_num_rows($sql);
//echo "total school count - ".$sql1;?><?php
while($row1=mysql_fetch_array($sql))
{ 
  $old_school_id=$row1['old_school_id'];
  $current_school_id=$row1['school_id'];
  $school_name=$row1['school_name'];
  echo "current_school_id - ".$current_school_id." "." school_name - ".$school_name." "." old_school_id - ".$old_school_id."<br>";
  
    $que1=mysql_query("SELECT school_id,t_id,t_email,t_phone,t_complete_name
    FROM tbl_teacher
    WHERE school_id='$old_school_id' and group_member_id='$group_member_id'");
    
    $que2=mysql_num_rows($que1);
   
    //echo "old school teacher records - ".$que2."<br>";

    ?><br><?php
   
    if($que2>0)
    {

       $que3=mysql_query("SELECT t_id,t_email,t_phone
       FROM tbl_teacher
       WHERE school_id='$current_school_id' and group_member_id='$group_member_id'");
       $que4=mysql_num_rows($que3);
       //echo "current school teacher records - ".$que4."<br><br>";
       if($que4>0)
       {?>
        <table class="table-bordered  table-condensed cf" id="example" width="100%;">
          <tr><td style="font-size: larger;font-weight: 600;background-color: #dc9ed9;" colspan="4"><?php echo "Total School Count - ".$sql1 ?>,
              <?php echo "Old school Id - ".$old_school_id ?>, 
              <?php echo "Current school Id - ".$current_school_id ?>, 
              <?php echo "Old school teacher records - ".$que2?>, 
              <?php echo "Current school teacher records - ".$que4 ?></td>
            </tr>
                 <tr>
                  <th>Old T_ID</th>
                  <th>Current T_ID</th>
                  <th>Current T_Name</th>
                  <th>Status</th>
                 </tr><?php
         while($row=mysql_fetch_array($que1))
         {
            $old_teacher_id=$row['t_id'];
            //echo "Old teacher Id - ".$old_teacher_id."<br>";
            //print_r($row);exit;
            $que3=mysql_query("SELECT t_id,t_complete_name,t_email,t_phone
            FROM tbl_teacher
            WHERE school_id='$current_school_id' and t_id='$old_teacher_id'");

           $que5=mysql_num_rows($que3);
           $que_1=mysql_fetch_array($que3);

            if($que5>0)
            {
             ?>
             <tr>
                  <td><?php echo $old_teacher_id;?></td>
                  <td><?php echo $que_1['t_id'];?></td>
                  <td><?php echo $que_1['t_complete_name'];?></td>
                   <td><?php echo "Duplicate teacher id Found Here";?></td>
                 </tr><?php
              //echo "current_teacher_id - / -"."old_teacher_id - ".$old_teacher_id." Duplicate Teacher id Found Here"."<br>";
                 
              $que3=mysql_query("insert into `tbl_error_log` (error_type, error_description,datetime, user_type,email,school_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Duplicate teacher id found', '$old_teacher_id', CURRENT_TIMESTAMP, '', '','$old_school_id','','device_name','os','ip_server','Web','Tai Shriram')");
              //echo "DELETE FROM tbl_teacher WHERE school_id='$old_school_id' and t_id='$old_teacher_id'";
              $que3_delete=mysql_query("DELETE FROM tbl_teacher WHERE school_id='$old_school_id' and t_id='$old_teacher_id'");

            }
            else
            {
              $old_teacher_email=$row['t_email'];
              //echo "email".$old_teacher_email."<br>";
              // if($old_teacher_email!='')
              // {
              $que_email=mysql_query("SELECT t_email,t_id,t_complete_name
              FROM tbl_teacher
              WHERE school_id='$current_school_id' and t_email='$old_teacher_email'");
              
              $que_email1=mysql_num_rows($que_email);
              $que_email1_t_id=mysql_fetch_array($que_email);
              if($que_email1>0)
             {
              ?><tr>
                  <td><?php echo $old_teacher_id;?></td>
                  <td><?php echo $que_email1_t_id['t_id'];?></td>
                  <td><?php echo $que_email1_t_id['t_complete_name'];?></td>
                   <td><?php echo "Duplicate Email. Found Here";?></td>
                 </tr><?php
              //echo"current t_id for Email found: ".$que_email1_t_id['t_id']."<br>";
             // echo "current_teacher_email - / -"."old_teacher_id - ".$old_teacher_email." Duplicate Email Found Here"."<br>";
                 $que3=mysql_query("insert into `tbl_error_log` (error_type, error_description,datetime, user_type,email,school_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Duplicate email id found', '$old_teacher_email', CURRENT_TIMESTAMP, '', '','$old_school_id','','device_name','os','ip_server','Web','Tai Shriram')");
                  $que3_delete=mysql_query("DELETE FROM tbl_teacher WHERE school_id='$old_school_id' and t_email='$old_teacher_email'");
             }
             else
             {
              //echo "NO record found."."<br><br>";

              $old_teacher_phone=$row['t_phone'];
             // echo "phone".$old_teacher_phone."<br>";
               if($old_teacher_phone!='')
              {
                $que_email=mysql_query("SELECT t_id,t_email,t_phone,t_complete_name
              FROM tbl_teacher
              WHERE school_id='$current_school_id' and t_phone='$old_teacher_phone'");
               
              $que_email1=mysql_num_rows($que_email);
              $que_email1_ph=mysql_fetch_array($que_email);
              if($que_email1>0)
              {
                 ?><tr>
                  <td><?php echo $old_teacher_id;?></td>
                  <td><?php echo $que_email1_ph['t_id'];?></td>
                  <td><?php echo $que_email1_ph['t_complete_name'];?></td>
                   <td><?php echo "Duplicate phone no. Found Here";?></td>
                 </tr><?php
                //echo"current t_id for Phone found: ".$que_email1_ph['t_phone']."<br>";
               // echo "current_teacher_phone - / -"."old_teacher_id - ".$old_teacher_phone." Duplicate Phone No. Found Here"."<br>";
              $que3=mysql_query("insert into `tbl_error_log` (error_type, error_description,datetime, user_type,email,school_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Duplicate phone No. found', '$old_teacher_phone', CURRENT_TIMESTAMP, '', '','$old_school_id','','device_name','os','ip_server','Web','Tai Shriram')");
              $que3_delete=mysql_query("DELETE FROM tbl_teacher WHERE school_id='$old_school_id' and t_phone='$old_teacher_phone'");
              }
              else
              {
                echo "update tbl_teacher set school_id='$current_school_id' WHERE group_member_id='$group_member_id' and school_id='$old_school_id'";
                 $update_teacher_id=mysql_query("update tbl_teacher set school_id='$current_school_id' WHERE group_member_id='$group_member_id' and school_id='$old_school_id'");
              }

              }
              else
              {
                echo "update tbl_teacher set school_id='$current_school_id' WHERE group_member_id='$group_member_id' and school_id='$old_school_id'";
                $update_teacher_id=mysql_query("update tbl_teacher set school_id='$current_school_id' WHERE group_member_id='$group_member_id' and school_id='$old_school_id'");
              }

             }
              
            //}
          }
          
         }
         ?></table><?php
       }


       
    }
    


}

?>