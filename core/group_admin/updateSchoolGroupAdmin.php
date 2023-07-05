<?php  
  include("../conn.php");

  if(isset($_POST['user-id']))
  {
      $adminName = $_POST['admin_name'];
      $clubName  = $_POST['Club_Name'];
      $clubEmail = $_POST['club_email'];
      $clubAdd   = $_POST['Club_address'];
      
      $uID       = $_POST['user-id'];
      
      
      $updateSchool =  "UPDATE tbl_school_admin
                        SET name='$adminName',school_name='$clubName',email='$clubEmail',address='$clubAdd' WHERE id='$uID'";
              
      $up = mysql_query($updateSchool); 
      
      if($up)
      {
          echo "<script>
                    alert('Successfully Updated');
                    window.location.assign('club.php');
         </script>";
          
      }else{
          
           echo "<script>
                    alert('Updation Failed');
                    window.location.assign('club.php');
         </script>";
      }
      
  }

?>