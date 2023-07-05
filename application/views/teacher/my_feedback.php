<html>
<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Parisienne&family=Satisfy&display=swap" rel="stylesheet">
<style>
  #rotate-text {
   transform: rotate(-5deg);
}
</style>
  </head>
  <body>
    <form method="post" action="<?php echo base_url().'Teachers/my_feedback'; ?>">              <div class="row">
               <!--  <div class="col-md-4" style="width:25%;"> </div> -->
                 <div class="col-md-2" style="color:#808080; font-size:18px; margin:0px;margin-left: 150px;">Select Year</div>
                <div class="col-md-3">
                  <?php $acad=$this->session->userdata('current_acadmic_year1'); ?>
                  <select name="year3" id="year" class="form-control" style="width: 160px;margin-left: -60px;">
                      <!-- <option value="All">All</option> -->
                        <?php 
                        foreach($Acdemicyear2 as $row)
                        { 
                        ?>
                      <option value = "<?php echo $row['Academic_Year']; ?>" 
                        <?php if(isset($_POST['year3'])) { if($row['Academic_Year']==$_POST['year3']) { echo "selected"; } } else { if($row['Academic_Year']==$acad) { 
                        echo "selected"; } }  ?> > 
                        <?php echo $row['Academic_Year']; ?>                      
                        </option>

                           <?php }  ?>
                    </select>
                    </br></br></br>
                </div>
                 <div class="col-md-2" style="margin-left: -190px;">
                            <input type="submit" name="acadmic_yr1" value="Submit" class="btn btn-success" />
                        </div>                
            </div>    
                </form>

    <div class="col-md-2" style="margin-left: 84%; margin-top: -90px;" >
      <?php 
      $empType = $teacher_info[0]->t_emp_type_pid; 
$school_type = $teacher_info[0]->sctype;
switch ($empType) {
    case 133:
  if($school_type=='organization')
  {
            $teacherType='Manager';
  }else{
     $teacherType='Teacher';
  }     
        break;
    case 134:
           if($school_type=='organization')
    {
            $teacherType='Manager';
    }else{
         $teacherType='Teacher';
    }
        break;
    case 135:
           if($school_type=='organization')
  {
            $teacherType='Reviewing Officer';
  }else{
     $teacherType='HOD';
  }     
        break;
    case 137:
           if($school_type=='organization')
  {
            $teacherType='Appointing Authority';
  }else{
     $teacherType='Principal';
  }     
        break;
    case 139:
           if($school_type=='organization')
    {
            $teacherType='Member Secretary';
    }else{
         $teacherType='';
    }           
        break; 
    case 141:
           if($school_type=='organization')
    {
            $teacherType='Vice Chairman';
    }else{
         $teacherType='';
    }           
        break;
    case 143:
           if($school_type=='organization')
    {
            $teacherType='Chairman';
    }else{
         $teacherType='';
    }           
        break;     
    default:
           if($school_type=='organization')
  {
            $teacherType='Manager';
  }else{
     $teacherType='Teacher';
  }     
        break;
}

$count=count($teaching_process_det['posts']);
               foreach($teaching_process_det['posts'] as $rows)
               {
                $rows['feed360_semester_ID'];
$student_feed=round((($rows['feed360_actual_classes']/$rows['feed360_classes_scheduled'])*25),2);
                        $temp=$temp+$student_feed;
                        $tc_feedback = round(($temp/$count),2);
               }
               $count1=count($student_feed_det['posts']);
                          foreach($student_feed_det['posts'] as $rows)
                          {
                            $avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5*$rows['count']))),2);
                                        $temp1=$temp1+$avg_stud_feed;
                                     $st_feed = round(($temp1/$count1),2);
                           $feedback_score1 = $feedback_score1 + $st_feed;   
                             }
                             $dept_total=0;
                            $dept_cnt=0;
                            foreach($dept_activity_det['posts'] as $rows)
                             { $dept_cnt++;
                              $dept_total+= $rows['credit_point'];
                              $dept_feed = round(($dept_total/$dept_cnt),2);
                              if($dept_total >20)
                            {
                               $dept_total=20;
                              
                            }
                            }
                            $institute_total = 0;
                $institute_cnt = 0;
                foreach($institute_activity_det['posts'] as $rows) 
                  { $institute_cnt++;
                                $institute_total+=$rows['credit_point'];
                              
                              //($r > 10) ? echo "10" : echo $r;     
                            if($institute_total >10)
                            {
                               $institute_total=10;
                              
                            }
                          
                           
                    }
                     $ACR_count=count($acr_det['posts']);
                            $ACR_total = 0;
                            foreach($acr_det['posts'] as $rows) { 
                              $ACR_total+= $rows['credit_point'];
                                        $acr_feed = round(($ACR_total/$ACR_count),2);
                            }
                            $contribution_total = 0;
                            $contribution_cnt = 0;
                            foreach($society_contri_det['posts'] as $rows) { $contribution_cnt++;
                              $contribution_total+= $rows['credit_point'];
                                        $society_feed = round(($contribution_total/$contribution_cnt),2);
                              if($contribution_total >10)
                            {
                               $contribution_total=10;
                              
                            }
                            }
                        $feedback_score= $tc_feedback+$st_feed+$dept_total+$institute_total+$acr_feed+ $contribution_total;
           $aaaa=(array)$sc_det;

          ?>
       <form action="<?php echo base_url('Pdf_generate/view_file'); ?>" method="post"> 
        <input type="hidden" name="xyz" value="<?php echo $this->session->userdata('teacher_name1').','.$_POST['year3'].','.'/core/'.$aaaa['img_path'].','.$aaaa['school_name'].','.'/Assets/images/avatar/avatar_2x.png'.','.'/core/scadmin_image/aicte_logo.jpg'.','.$teacherType.','.$feedback_score; ?>" >
                        <button class="btn btn-primary" type="submit" id="clickbind" name="submit">Print this page</button>
        </form>
                    </div>    
   <div id="content1">
<section class="content" style="margin-top: -10px;">
  <div class="container-fluid">
    <div class="row clearfix">
      <div class="block-header" align="center">
   <h2 id="content1" style="text-align: center;font-size: 18px;">360 Feedback Report For <?php $years= $_POST['year3']; echo $years; ?></h2>
      </div> 
       <form method="post" action="<?php echo base_url().'Teachers/my_feedback'; ?>"> 
      <div class="panel panel-default">
        <div class="panel-body">
     <?php 
         $aaaa=(array)$sc_det;
          ?>
             <table width=100% height=100>
                   
                    <tr>
                    <td style="width:20%;"> 

                        <?php if($aaaa['img_path'] != "") { ?>
                            <img src="<?php echo base_url().'core/'.$aaaa['img_path'] ; ?>" height="70" width="70" class="preview" style="float: left;"/>
                            <?php } else { ?>
                            
                            <img src="<?php echo base_url('Assets/images/avatar/avatar_2x.png');?>" width="70" height="70" class="preview" style="float: left;border-radius: 50%;"/>
                        <?php } ?>
                      </td>
                    <td style="width:60%;">
                        <h3 style="text-align: center;">
                            <?php echo $aaaa['school_name']; ?>
                        </h3>
             </td>
                   
                       <td style="float: right;width:20%;">
                       <img src="<?php echo base_url('core/scadmin_image/aicte_logo.jpg');?>" width="70" height="70" class="preview" style="float: right;"/>
                       </td>
                    </tr>               
                </table>      
                </form>       
          <!-- <form method="POST" action=""> -->
         <div class="col-sm-12"> 
             <table style="text-align: center;" width="100%" cellspacing="0" border="1">                  
                            <thead>
                            <tr>
                                <th style=" text-align: center;width:300px;"> Teacher Name </th>
                                <th style="text-align: center;width:150px;"> Present Position </th>
                                <th style=" text-align: center;width:150px;"> 360 Feedback Score </th>
                                <th style="text-align: center;width:150px;"> Academic year </th>

                            </tr>
                            </thead>
                            
<tbody>                    
            <tr>
                 <td>
                   <?php echo $this->session->userdata('teacher_name1'); ?>
                   </td>
                  <td>
                   <?php
                  echo $teacherType; ?>
                  </td>
                   <td>
                         <?php             
                        echo $feedback_score;
                                      ?>
                                     </td> 
                                    
                                     <td>
                                      <?php 
                      
                                      if(isset($_POST['year3'])) 
                                      {  
                                        
                                         $years= $_POST['year3'];
                                         echo $years;
                                       }
                                       else 
                                       {
                                        echo $acad;
                                       }
                                                     ?>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
           <h3> <span class="tech-pro">A) Teaching Process (Max Point 25) </span></h3>
           <table style="text-align: center;" width="100%" cellspacing="0" border="1">
            <thead>
            <tr>
                <th style="text-align: center;width:150px;">Semester</th>
                <th style="text-align: center;width:150px;">Subject Code/Name </th>
                <th style="text-align: center;width:150px;">No. Of Scheduled Classes</th>
                <th style="text-align: center;width:150px;">No. Of Actually Held Classes </th>
                <th style="text-align: center;width:75px;">Point Earned</th>
                <th style="text-align: center;width:75px;">Enclosure No. </th>
            </tr>
            </thead>
            <tbody>
              <?php 
               $count=count($teaching_process_det['posts']);
               foreach($teaching_process_det['posts'] as $rows)
               { 
               ?>
                <tr>
                    <td style="text-align: center; padding: 0px 0px 0px 10px;">
                        <?php echo $rows['feed360_semester_ID']; ?>
                    </td>
                    <td style="text-align: center; padding: 0px 0px 0px 10px;">
                        <?php echo $rows['feed360_subject_code']; ?>
                    </td>
                     <td>
                        <?php echo $rows['feed360_classes_scheduled']; ?>
                    </td>
                    <td>
                       <?php echo $rows['feed360_actual_classes']; ?>
                    </td>
                    <td>
<?php echo round((($rows['feed360_actual_classes']/$rows['feed360_classes_scheduled'])*25),2);
                         ?>
                    </td>
                    <td>
                   </td>
                </tr>
            <?php } ?>
            <tr>
            <td></td><td></td><td></td>
            <td><b>Total</b></td>
            <td><b> <?php echo round(($temp/$count),2); ?></b></td>
            <td></td>
            </tr>
            </tbody>
        </table>
          <h3> <span class="tech-pro">B) Student Feedback (Max Point 25) </span></h3>
           <table style="text-align: center;" width="100%" cellspacing="0" border="1">
            <thead>
            <tr>
                <th style="text-align: center;width:150px;">Semester</th>
                <th style="text-align: center;width:150px;">Subject Code </th>
                <th style="text-align: center;width:150px;">Average Student Feedback</th>
                <th style="text-align: center;width:150px;">Details </th>
                <th style="text-align: center;width:150px;">Enclosure No. </th>
            </tr>
            </thead>
            <tbody>
              <?php 
                          $count1=count($student_feed_det['posts']);
                          foreach($student_feed_det['posts'] as $rows) { ?>
                <tr>
                    <td style="text-align: center;padding: 0px 0px 0px 10px;">
                         <?php echo $rows['stu_feed_semester_ID']; ?>
                    </td>
                    <td style="text-align: center;padding: 0px 0px 0px 10px;">
                         <?php echo $rows['stud_subjcet_code']; ?>
                    </td>
                     <td>
                       <?php
                       echo $avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5*$rows['count']))),2);
                                        //$temp1=$temp1+$avg_stud_feed;

                                        ?>
                    </td>
                    <td>
                      <form method="post" action="<?php echo base_url().'Teachers/feedback_question_summary'; ?>">
           <input type="hidden" name="feedback_id" value="<?php echo $rows['stud_subjcet_code'].','.$rows['stu_feed_academic_year'].','.$rows['stu_feed_semester_ID'].','.$rows['stu_feed_points']; ?>">
           <input type="hidden" id="avgId" name="avgId" value="<?php echo $avg_stud_feed; ?>">
            <input type="hidden" name="feedback" value="<?php echo $rows['stu_feed_points'].','.$rows['count']; ?>">
 <input type="submit" name="submit_edit" value="Show" style="border: 0px;"> 
                                            
                                            </form>                                            
                    </td>
                    <td>
                       <?php //echo $rows['']; ?>
                    </td>  
                </tr>

            <?php } ?>
            <tr>
            <td></td>
            <td><b>Total</b></td>
            <td><b> <?php echo round(($temp1/$count1),2); ?></b></td>
            <td></td>
            <td></td>
            </tr>
            </tbody>
        </table>
                         <h3> <span class="tech-pro1">C) Departmental Activity (Max Credit 20) </span> </h3>
                        <?php 
                        foreach($sc_det1 as $value)
                        { 
                   $array[] = $value->total_points;
                         }
                      ?>
                            <table class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">

                            <thead>

                            <tr>
                                <th style="width:20%; text-align: center;">Semester</th>
                                <th style="width:20%;text-align: center;">Activity Code/Name </th>
                                <th style="width:20%;text-align: center;">Credit Point</th>
                                <th style="width:20%;text-align: center;">Criteria</th>
                                <th style="width:20%;text-align: center;">Enclosure NO. </th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php

                            $dept_total=0;
                            $dept_cnt=0;
                            foreach($dept_activity_det['posts'] as $rows) { $dept_cnt++; ?>
                                <tr>

                                    <td style="width:20%;text-align: center; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['semester_name']; ?>
                                    </td>
                                    <td style="width:20%;text-align: center; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['activity_name']; ?>
                                    </td>
                                     <td style="width:20%;">
                                        <?php 
                                        foreach($sc_det1 as $value)
                                        { 

                                      $array[] = $value->total_points;
                                        }
                                         $dept=$array[0];
                                        echo ($rows['credit_point']>$dept) ? $rows['credit_point']=$dept : $rows['credit_point']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php echo $rows['criteria']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php //echo $rows['']; ?>
                                    </td>


                                </tr>

                            <?php $dept_total+= $rows['credit_point'];
                             } ?>
                            <tr>
                                <td style="width:20%;"></td>

                                <td style="width:20%;"><b>Total</b></td>
                                <td style="width:20%;"><b> <?php
                                foreach($sc_det1 as $value)
                                          { 
                                       $array[] = $value->total_points;
                                           }
                                          $dept1=$array[0];
                              if($dept_total >= $dept1)
                                  echo $dept1;
                              else 
                                echo $dept_total;
                                ?></b></td>
                                        <td style="width:20%;"></td>
                                        <td style="width:20%;"></td>
                                    </tr>

                            </tbody>
                        </table>
      <h3> <span class="tech-pro1">D) Institute Activity (Max Credit 10) </span></h3>
         <table class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">
                <thead>
                <tr>
                    <th style="width:20%; text-align: center;">Semester</th>
                    <th style="width:20%; text-align: center;">Activity </th>
                    <th style="width:20%; text-align: center;">Credit Point</th>
                    <th style="width:20%; text-align: center;">Criteria</th>
                    <th style="width:20%; text-align: center;">Enclosure NO. </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $institute_total = 0;
                $institute_cnt = 0;
                foreach($institute_activity_det['posts'] as $rows) { $institute_cnt++; ?>
                    <tr>
                        <td style="width:20%; text-align: center; padding: 0px 0px 0px 10px;">
                            <?php echo $rows['semester_name']; ?>
                        </td>
                        <td style="width:20%; text-align: center; padding: 0px 0px 0px 10px;">
                            <?php echo $rows['activity_name']; ?>
                        </td>
                         <td style="width:20%;">
                            <?php
                            foreach($sc_det1 as $value)
                                          { 
                                       $array[] = $value->total_points;
                                           }
                                          $inst=$array[1];
                             echo ($rows['credit_point']>$inst) ? $rows['credit_point']=$inst : $rows['credit_point']; ?>
                        </td>
                        <td style="width:20%;">
                            <?php echo $rows['criteria']; ?>
                        </td>
                        <td style="width:20%;">
                            <?php  ?>
                        </td>
                    </tr>
                <?php $institute_total+=$rows['credit_point']; 
              } ?>
                    <tr>
                            <td style="width:20%;"></td>

                            <td style="width:20%;"><b>Total</b></td>
                            <td style="width:20%;"><b> 
                                <?php
                                foreach($sc_det1 as $value)
                                          { 
                                       $array[] = $value->total_points;
                                           }
                                          $instt=$array[1];
                              if($institute_total >= $instt)
                                  echo $instt;
                              else 
                                echo $institute_total;
                                 
                            ?>  
                                </b></td>
                            <td style="width:20%;"></td>
                            <td style="width:20%;"></td>
                        </tr>
                     

                </tbody>
            </table>

            <h3><span class="tech-pro1">E) ACR (Max Credit 10)</span> </h3>
              <table class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">
                            <thead>
                            <tr>
                                <th style="width:20%; text-align: center;">Year</th>
                                <th style="width:20%; text-align: center;">Activity </th>
                                <th style="width:20%; text-align: center;">Credit Point</th>
                                <th style="width:20%; text-align: center;">Criteria</th>
                                <th style="width:20%; text-align: center;">Enclosure NO. </th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $ACR_count=count($acr_det['posts']);
                            $ACR_total = 0;
                            foreach($acr_det['posts'] as $rows) { 
                             ?>
                                <tr>

                                    <td style="width: 20%; text-align: center; padding: 0px 0px 0px 10px;">
                                        <?php $years= $_POST['year3'];
                                         echo $years; ?>
                                    </td>
                                    <td style="width: 20%;text-align: center; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['activity_name']; ?>
                                    </td style="width:20%; text-align: center; padding: 0px 0px 0px 10px;">
                                     <td>
                                        <?php 
                                        
echo ($rows['credit_point']>10) ? $rows['credit_point']=10 : $rows['credit_point']; ?>
                                    </td>
                                    <td style="width: 20%;text-align: center; padding: 0px 0px 0px 10px;">
                                        <?php
                                            if($rows['credit_point'] == 10)
                                                echo "Extraordinary";
                                          else if($rows['credit_point'] == 9)
                                                echo "Excellent";
                                          else if($rows['credit_point'] == 8)
                                                echo "Very Good";
                                         else if($rows['credit_point'] == 7)
                                                echo "Good";
                                            else
                                                echo "Satisfactory";
                                            ?>
                                    </td>
                                    <td style="width: 20%;">
                                        <?php //echo $rows['']; ?>
                                    </td>
                               </tr>

                            <?php $ACR_total+= $rows['credit_point']; 
                          } ?>
                                <tr>
                                        <td style="width: 20%;"></td>

                                        <td style="width: 20%;"><b>Total</b></td>
                                        <td style="width: 20%;"><b>
                                         <?php 
                              $acr_feed = round(($ACR_total/$ACR_count),2);
                                         // $feedback_score += $acr_feed;
                              echo $acr_feed;
                              ?></b></td>
                                        <td style="width: 20%;"></td>
                                        <td style="width: 20%;"></td>
                                    </tr>
                            </tbody>
                        </table>
                  <h3><span class="tech-pro1">F) Contribution To Society (Max Credit 10) </span> </h3>
                  <table class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">
                            <thead>
                            <tr>
                                <th style="width: 20%; text-align: center;">Semester</th>
                                <th style="width: 20%; text-align: center;">Activity </th>
                                <th style="width: 20%; text-align: center;">Credit Point</th>
                                <th style="width: 20%; text-align: center;">Criteria</th>
                                <th style="width: 20%; text-align: center;">Enclosure NO. </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = mysql_query($sql);
                            $contribution_total = 0;
                            $contribution_cnt = 0;
                            foreach($society_contri_det['posts'] as $rows) { $contribution_cnt++; ?>
                                <tr>

                                    <td style="width: 20%; text-align: center; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['semester_name']; ?>
                                    </td>
                                    <td style="width: 20%; text-align: center; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['activity_name']; ?>
                                    </td>
                                     <td style="width: 20%;">
                                        <?php echo $rows['credit_point']; ?>
                                    </td>
                                    <td style="width: 20%;">
                                        <?php echo $rows['criteria']; ?>
                                    </td>
                                    <td style="width: 20%;">
                                        <?php //echo $rows['']; ?>
                                    </td>
                                </tr>
                          <?php $contribution_total+= $rows['credit_point']; 
                          } ?>
                                <tr>
                                        <td style="width: 20%;"></td>

                                        <td style="width: 20%;"><b>Total</b></td>
                                        <td style="width: 20%;"><b> 
                                          <?php
                                        foreach($sc_det1 as $value)
                                          { 
                                       $array[] = $value->total_points;
                                           }
                                          $society=$array[2];
                              if($contribution_total >= $society)
                                  echo $society;
                              else 
                                echo $contribution_total;
                                 ?>
                                 </b></td>
                                        <td style="width: 20%;"></td>
                                        <td style="width: 20%;"></td>
                                    </tr>

                            </tbody>
                        </table> 
            </div>
         
        <div id="abc">
<table class="display" style="text-align: center;" width="100%" cellspacing="0" border="0">
            <tr>
              <td>
          <div id="rotate-text">
          <h4 style="text-align: left;margin-left: 100px;margin-top: -5px;"><span style="font-family: 'Dancing Script', cursive;color:blue;"><?php
         echo $this->session->userdata('teacher_name1');
         ?></span></h4></div>
       </td>
     </tr>
     <tr>
       <td>
          <h4 style="text-align: left;margin-left: 100px;margin-top: 50px;"><?php
         echo $aaaa['school_name'];
         ?></h4>
       </td>
     </tr>
   </table>
         <table class="display" style="text-align: center;" width="100%" cellspacing="0" border="0">
          <tr>
            <th> <h5 style="float:left;margin-left: 40px;"> <b style="color:purple;">Powered By : Protsahan Mudra &copy;</b></h5></th>
            <th>
          <h4 style="margin-left: -20px;">Date:</h4>
        </th>        
      </tr>
      <tr>
        <td>
        </td>
        <td>
  <p style="margin-top: -30px;margin-left: 0px;"><?php echo date("d-m-Y"); ?></p>
         </td>
       </tr>
     </table>
        </div>
        </div>
        </div>
      </div>
    <!-- </form> -->
  </div>
</div>
</section>
</div>
</body>
</html>
   