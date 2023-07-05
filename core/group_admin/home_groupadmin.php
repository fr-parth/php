<?php

include("groupadminheader.php");
//include('../conn.php');

//called group_admin_get_all_count_API webservice by default and update_dashboard_summary webservice onclick  recalculate button and displayed records accordingly by Pranali for SMC-4960 on 25/11/20
$group_member_id = $_SESSION['group_admin_id'];

if(isset($_POST['recal']))
{ 

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
 $url = $protocol.'://'.$_SERVER['HTTP_HOST'].'/core/Version3/update_dashboard_summary.php';
 $data = array('group_id'=>$group_member_id);
$ch = curl_init($url);             
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $upload_status = json_decode(curl_exec($ch),true); 
        
          if($upload_status['responseStatus']==200)
          {            
              echo "<script type='text/javascript'>alert('Counts Recalculated Successfully');</script>";
          }
        
}


$sql = "SELECT group_type FROM tbl_cookieadmin WHERE id='$group_member_id'";
 $query = mysql_query($sql);
$rows = mysql_fetch_assoc($query);
$group_type= $rows['group_type']; 

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
 $url = $protocol.'://'.$_SERVER['HTTP_HOST'].'/core/Version3/group_admin_get_all_count_API.php';
 $data = array('group_id'=>$group_member_id);
$ch = curl_init($url);             
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $upload_status = json_decode(curl_exec($ch),true); 
        // print_r($upload_status['posts']);exit;
$ar=array();
  foreach ($upload_status['posts'] as $posts) {
  
      if($posts['description']=='School')
      { 
          $school_desc = $posts['description'];
          $school_cnt = $posts['value'];
      }
      else if($posts['description']=='Teacher')
      { 
          $teacher_desc = $posts['description'];
          $teacher_cnt = $posts['value'];
      }
      else if($posts['description']=='Student')
      { 
          $student_desc = $posts['description'];
          $student_cnt = $posts['value'];
      }
      else if($posts['description']=='Sponsor')
      { 
          $Sponsor_desc = $posts['description'];
          $Sponsor_cnt = $posts['value'];
      }
      else if($posts['description']=='Parent')
      { 
          $parent_desc = $posts['description'];
          $parent_cnt = $posts['value'];
      }
      else if($posts['description']=='Non_teacher')
      { 
          $Non_teacher_desc = $posts['description'];
          $Non_teacher_cnt = $posts['value'];
      }
      else if($posts['description']=='Subject')
      { 
          $Subject_desc = $posts['description'];
          $Subject_cnt = $posts['value'];
      }
      else if($posts['description']=='Student_subject')
      { 
          $Student_subject_desc = $posts['description'];
          $Student_subject_cnt = $posts['value'];
      }
      
  }

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie </title>
    <!--<script src='js/bootstrap.min.js' type='text/javascript'></script>-->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/lib/w3.css">
    <style>
        .shadow {
            box-shadow: 1px 1px 1px 2px rgba(150, 150, 150, 0.4);
        }
        .shadow:hover {
            box-shadow: 1px 1px 1px 3px rgba(150, 150, 150, 0.5);
        }
        .radius {
            border-radius: 5px;
        }
        .hColor {
            padding: 3px;
            border-radius: 5px 5px 0px 0px;
            color: #fff;
            background-color: rgba(105, 68, 137, 0.8);
        }
        
        .panel-info>.panel-heading
        {
        background-color:#dac1f1;
        color:#dc2351;
        
        }
        .panel-body
        {
        font-size:x-large;
        color:Green;
        }

    </style>
</head>
<body>
    
<div class="container" style="width:100%">
    <div class="row">
        <div class="col-md-15" style="padding-top:15px;">
            <div class="radius " style="height:50px; width:100%; background-color:#dac1f1;color:#080808;" align="center">
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">Dashboard</h2>
            </div>
        </div>
    </div>
    <br>
<form method="post" action="">
<div class="row">
    
    <button type="submit" name="recal" id="recal" class="btn-lg btn-success"  >Recalculate Count</button>
</div>
    <div class="row" style="padding-top:20px;">
        
        <div class="col-md-3">
            <a href="club_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_school;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php
                                          
                            echo $school_cnt;
 
                      ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="volunteer_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_teacher;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php

                        
                            echo $teacher_cnt;

                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="beneficiary_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_student;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php
                        
                        echo $student_cnt;

                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="sponsor_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of Sponsors</b></h3>
                    </div>
                    <div class="panel-body"  align="center">
                        <?php
                    
                        echo $Sponsor_cnt;
                        ?>
                    </div>
                </div>
            </a>
        </div>

    </div>
 <br>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="parent_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of Parents</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php
                       

                            echo $parent_cnt;
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="NonTeachingStaff.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of NonTeachingStaff</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php   
                        echo $Non_teacher_cnt;
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="games_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_subject;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">

                         <?php

                         echo $Subject_cnt;
                        ?>
                        
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="list_student_maping.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> <?php echo $dynamic_subject;?> Mapping</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php

                       
                            echo $Student_subject_cnt;
                        ?>
                    </div>
                </div>
            </a>
        </div>

    </div>

<br>
<br>
    </div>


</div>
</form>
</body>
</html>