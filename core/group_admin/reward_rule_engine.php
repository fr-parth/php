<?php
/*Author: Pranali Dalvi
Date : 09-11-2019
This file was created for Insertion/Updation of Rewards Rule Engine (for assigning points) in Group Admin
*/
include_once ('groupadminheader.php');
$groupMemberID=$_SESSION['id'];

$sql = mysql_query("SELECT * FROM tbl_method WHERE group_member_id='".$groupMemberID."' AND school_id='0'"); //from group admin
$title = 'Group Admin';
$update = 'Updated';

if(mysql_num_rows($sql)==0){
  $sql = mysql_query("SELECT * FROM tbl_method WHERE group_member_id='0' AND school_id='0'"); //from cookie admin
  $title = 'Cookie Admin';
  $update = 'Inserted';
}

$count = mysql_num_rows($sql);
if(isset($_POST['submit'])){

     $title=$_POST['title'];
     $set1=$_POST['set1'];
     $set2=$_POST['set2'];
     $set3=$_POST['set3'];
     $set4=$_POST['set4'];
        
      if($title=='Group Admin') {
     
      $update_query = mysql_query("UPDATE 
      tbl_method SET method_flag = (CASE WHEN method_name = 'Judgement' THEN '".$set1."' 
      WHEN method_name = 'Marks' THEN '".$set2."' 
      WHEN method_name = 'Grade' THEN '".$set3."' 
      WHEN method_name = 'Percentile' THEN '".$set4."' END) 
      WHERE method_name IN ('Judgement', 'Marks', 'Grade','Percentile') 
      AND group_member_id='".$groupMemberID."' AND school_id='0'");

    }else if($title=='Cookie Admin'){

      $insert = mysql_query("INSERT INTO tbl_method(method_name,method_flag,group_member_id,school_id) VALUES ('Judgement','".$set1."','".$groupMemberID."','0'), ('Marks','".$set2."','".$groupMemberID."','0'), ('Grade','".$set3."','".$groupMemberID."','0'), ('Percentile','".$set4."','".$groupMemberID."','0')");
    }

      echo "<script>alert('Rewards Rule Engine ".$update." Successfully');
      window.location.href='reward_rule_engine.php';
      </script>";

}
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie </title>
  <link href="css/style.css" rel="stylesheet">
   <style>
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
        }

        #percentage{
          width: 40px;
        }
    </style>
    
</head>
<body>
<div class="container" style="width:100%">
    <div class="row">

        <div class="col-md-15" style="padding-top:15px;">
            <div style="height:50px; width:100%; background-color:#694489;box-shadow: 0px 1px 3px 1px #666666;"
                 align="center">
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px; font-size:30px;color:white;text-decoration:underline;">Rewards Rule Engine </h2>
            </div>

        </div>
    </div>

    <div class="row" style="padding-top:15px; ">
        <div class="col-md-15" style="width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 2px 1px #666666;">

            <form method="post" action="" style="max-width:1200px; width:100%;">
             <?php
             $i=1;
             
               while($result=mysql_fetch_array($sql))
                {?>
                  <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-5" style="margin-top:6px;">
                          <h4> <?php echo $result['method_name'];?>  </h4>
                          
                      </div>
                      <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                          <input type="radio" name="set<?php echo $i;?>" id="set<?php echo $i;?>"
                                 value="Yes" <?php if ($result['method_flag'] == "Yes") {  echo 'checked="checked"'; } ?> />
                          ON
                      </div>
                      <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                          <input type="radio" name="set<?php echo $i;?>" id="set<?php echo $i;?>"
                                 value="No" <?php if ($result['method_flag'] == 'No') {  echo 'checked="checked"'; } ?> />
                          OFF
                      </div>
                  </div>
                  <hr>
                <?php 
                $i++;
              } ?>
       <input type="hidden" name="title" id="title" value="<?php echo $title; ?>" />
                <div class="row" style="margin-top:8px; margin-bottom:2px;margin-left:120px;">
                    <div class="col-md-5"></div>
                    <div class="col-md-1"><input type="submit" name="submit" value="Save" class="btn btn-success"></div>
                    <div class="col-md-1"><a href="home_groupadmin.php"><input type="button" name="cancel" value="Cancel" class="btn btn-danger"></a></div>

                    <div style="height:60px"></div>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>